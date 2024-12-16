<?php
require '../../lib/db/connection.php';
date_default_timezone_set("Asia/Kuala_Lumpur");

// Function to sanitize values received from the form. Prevents SQL injection
function clean($str) {
    $conn=db();
    $str = @trim($str);
    if(get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }
    return mysqli_real_escape_string($conn,$str);
}

function getSys($sys_id) {
    $conn=db();
    $sql = "SELECT s.*,c.short_name FROM sys_setting s LEFT JOIN company c ON c.sys_id=s.sys_id WHERE s.sys_id='$sys_id'";
    return $conn->query($sql);
}

function getStaffInfo($staff_id){
    $conn=db();
    $sql="SELECT no_staff, name, noic, role_id, department_id, department_sub FROM staff WHERE id = '$staff_id'";
    return $conn->query($sql);
}

function getDropdownCompany($selected){
    $conn=db();
    $sql="SELECT code_department, description FROM department WHERE code_department <> ''";
    $result = $conn->query($sql);

    $txt_result = "";
    while ($row = $result->fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
    }

    return $txt_result;
}

function getHRSeaCompany($selected){
    $conn=db();
    $sql="SELECT code_department, description FROM department WHERE code_department IN ('AGSHIMSB','MOCSB')";
    $result = $conn->query($sql);

    $txt_result = "";
    while ($row = $result->fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
    }

    return $txt_result;

}

function v02getDropDownMonth($selected) {
    $conn=db();
    $sql = "SELECT month_num, month_description FROM aims_month ORDER BY month_num";
    $result = $conn->query($sql);

    $txt_result="<option ".(0 == $selected ? 'selected':'')." value='0'>All</option>";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
    }
    return $txt_result;
}

function v02getDropDownYear($selected) {
    $year_option="";
    $yearNow = date("Y");
    for ($i=-1; $i<4; $i++){
        $year = $yearNow - $i;
        $opt_selected = ($year == $selected) ? 'selected' : '';
        $year_option.= "<option value='".$year."' ".$opt_selected.">".$year."</option>";
    }
    return $year_option;
}

function addMedical($staff_id, $receipt_date, $description, $total_claim, $document_name, $document_size){
    $conn=db();
    $sql="INSERT INTO v02_aims_medical (staff_id, receipt_date, description, total_claim, document_name, document_size, created_at) 
            VALUES ('$staff_id', '$receipt_date', '$description', '$total_claim', '$document_name', '$document_size', CURRENT_TIMESTAMP)";
    return $conn->query($sql);
}

function getMedicalList($staff_id, $year){
    $where_year = ($year == '0') ? "" : "AND YEAR(receipt_date) = '$year'";
    $conn=db();
    $sql = "SELECT * FROM v02_aims_medical WHERE staff_id = '$staff_id' $where_year
                ORDER BY created_at DESC, hr_verify_at DESC";
    return $conn->query($sql);
}

function viewMedicalAttachment($id){
    $conn=db();
    $sql="SELECT document_name, document_size FROM v02_aims_medical WHERE id = '$id'";
    return $conn->query($sql);
}

function getMedicalById($id){
    $conn=db();
    $sql="SELECT l.*, s.id as staff_id, s.name, s.noic, s.no_staff, s.department_id, s.department_sub FROM v02_aims_medical l LEFT JOIN staff s ON s.id = l.staff_id WHERE l.id='$id'";
    return $conn->query($sql);
}

function updateMedical($id, $receipt_date, $description, $total_claim, $document_name, $document_size){
    $conn=db();
    $document_field = ($document_name != '') ? ",document_name='$document_name', document_size='$document_size'" : "";
    $sql="UPDATE v02_aims_medical SET receipt_date='$receipt_date', description='$description', total_claim='$total_claim'
            $document_field WHERE id='$id'";
    return $conn->query($sql);
}

function deleteMedical($id){
    $conn=db();
    $sql="DELETE FROM v02_aims_medical WHERE id='$id'";
    return $conn->query($sql);
}

function getMedicalQuotaByStaffId($staff_id, $year = '0', $current_only = false){
    $conn = db();

    if (substr_count($year, '-') == 2){
        $where_year = "AND start_date <= '$year' AND end_date >= '$year'";
    }else{
        $where_year = ($year != '0') ? "AND (YEAR(start_date) = '$year' OR YEAR(end_date) = '$year')" : "";
    }

    $where_date = ($current_only) ? "AND start_date <= CURRENT_DATE AND end_date >= CURRENT_DATE" : "";
    $limit_one = ($current_only) ? "LIMIT 1" : "";

    $sql = "SELECT * FROM v02_aims_medical_quota WHERE staff_id = '$staff_id' $where_year $where_date ORDER BY end_date $limit_one";
    return $conn->query($sql);
}

function getCountPending($staff_id, $quota_start, $quota_end){
    $conn=db();
    $sql = "SELECT IFNULL(SUM(total_claim),0) as used FROM v02_aims_medical
            WHERE staff_id = '$staff_id'
            AND hr_verify_status IS NULL
            AND receipt_date BETWEEN '$quota_start' 
            AND '$quota_end'";

    return $conn->query($sql)->fetch_object()->used;
}

function getStaffName($id){
    $conn=db();
    $sql="SELECT name FROM staff WHERE id='$id'";
    return $conn->query($sql)->fetch_object()->name;
}

function getMedicalHRList($department_code, $month , $year, $verification){
    $where_month = ($month == 0) ? "" : "AND MONTH(m.receipt_date) = '$month'";

    if ($verification == 'NULL'){
        $where_verify_status = "AND m.hr_verify_status IS NULL AND m.payment_closed_at IS NULL"; //pending
    }else if ($verification == 'YES'){
        $where_verify_status = "AND m.hr_verify_status = 1 AND m.payment_closed_at IS NULL"; //supported
    }else if ($verification == 'NO'){
        $where_verify_status = "AND m.hr_verify_status <> 1 AND m.payment_closed_at IS NULL"; //rejected
    }else{
        $where_verify_status = "AND m.hr_verify_status = 1 AND m.payment_closed_at IS NOT NULL"; //closed
    }

    $conn=db();
    $sql = "SELECT m.*, s.name, s.no_staff, s.department_id, s.department_sub FROM v02_aims_medical m LEFT JOIN staff s ON s.id = m.staff_id
                WHERE s.department_id = '$department_code' $where_verify_status $where_month
                AND YEAR(m.receipt_date) = '$year'";
    return $conn->query($sql);
}

function getMedicalCFOList($department_code, $month , $year, $cfo_approval){
    $where_department = ($department_code == 0) ? "" : "AND s.department_id = '$department_code'";
    $where_month = ($month == 0) ? "" : "AND MONTH(m.receipt_date) = '$month'";
    $where_year = ($year == 0) ? "" : "AND YEAR(m.receipt_date) = '$year'";

    if ($cfo_approval == 'NULL'){
        $where_approval_status = "AND m.cfo_approval_status IS NULL"; //pending
    }else if ($cfo_approval == 'YES'){
        $where_approval_status = "AND m.cfo_approval_status = 1"; //supported
    }else if ($cfo_approval == 'NO'){
        $where_approval_status = "AND m.cfo_approval_status <> 1"; //rejected
    }else{
        $where_approval_status = "AND m.payment_closed_at IS NOT NULL"; //closed
    }

    $conn=db();
    $sql = "SELECT m.*, s.name, s.no_staff, s.department_id, s.department_sub FROM v02_aims_medical m LEFT JOIN staff s ON s.id = m.staff_id
                WHERE m.hr_verify_status = '1' $where_department
                $where_approval_status $where_month $where_year ORDER BY m.receipt_date DESC";
    return $conn->query($sql);
}

function getMedicalCEOList($staff_id, $department_code, $month , $year, $ceo_approval){
    $where_department = ($department_code == 0) ? "" : "AND s.department_id = '$department_code'";
    $where_month = ($month == 0) ? "" : "AND MONTH(m.receipt_date) = '$month'";
    $where_year = ($year == 0) ? "" : "AND YEAR(m.receipt_date) = '$year'";

    if ($ceo_approval == 'NULL'){
        $where_approval_status = "AND m.ceo_approval_status IS NULL"; //pending
    }else if ($ceo_approval == 'YES'){
        $where_approval_status = "AND m.ceo_approval_status = 1"; //supported
    }else if ($ceo_approval == 'NO'){
        $where_approval_status = "AND m.ceo_approval_status <> 1"; //rejected
    }else{
        $where_approval_status = "AND m.payment_closed_at IS NOT NULL"; //closed
    }

    $conn=db();
    if ($staff_id == '12'){ //Chairman
        $custom_condition = "AND s.role_id = 'FOUNDER'";
    }elseif($staff_id == '13'){ //CEO
        $custom_condition = "";
    }else{
        return null;
    }

    $sql="SELECT m.*, s.name, s.no_staff, s.department_id, s.department_sub FROM v02_aims_medical m LEFT JOIN staff s ON s.id = m.staff_id
                WHERE m.hr_verify_status = '1' AND m.cfo_approval_status = '1' AND m.staff_id <> '$staff_id' $where_department
                $where_approval_status $where_month $where_year $custom_condition ORDER BY m.receipt_date DESC";
    return $conn->query($sql);
}

function getCurrentBalanceFromMedicalId($id){
    $conn=db();
    $medical_info = $conn->query("SELECT staff_id, receipt_date FROM v02_aims_medical WHERE id = '$id'")->fetch_assoc();
    $current_balance_sql = "SELECT current_balance FROM v02_aims_medical_quota WHERE staff_id = '".$medical_info['staff_id']."'
                            AND (start_date <= '".$medical_info['receipt_date']."'  AND end_date >= '".$medical_info['receipt_date']."') LIMIT 1";
    return $conn->query($current_balance_sql)->fetch_object()->current_balance;
}

function hrVerifyMedicalClaim($id, $receipt_date, $total_claim, $remark, $hr_verify_by, $hr_verify_status, $current_balance){
    $conn=db();
    $sql = "UPDATE v02_aims_medical SET receipt_date='$receipt_date', total_claim='$total_claim', balance_after_approval='$current_balance', remark='$remark',
            hr_verify_at= CURRENT_TIMESTAMP, hr_verify_by='$hr_verify_by', hr_verify_status='$hr_verify_status' WHERE id='$id'";
    return $conn->query($sql);
}

function medicalQuotaAdjustment($staff_id, $receipt_date, $current_balance){
    $conn=db();
    $sql = "UPDATE v02_aims_medical_quota SET current_balance = '$current_balance' WHERE staff_id = '$staff_id'
                AND (start_date <= '$receipt_date'  AND end_date >= '$receipt_date')";
    return $conn->query($sql);
}

function hrResetMedicalClaimVerification($id){
    $conn=db();
    $sql="UPDATE v02_aims_medical SET balance_after_approval = NULL,
            hr_verify_at = NULL, hr_verify_by = NULL, hr_verify_status = NULL,
            cfo_approval_at = NULL, cfo_approval_by = NULL, cfo_approval_status = NULL,
            ceo_approval_at = NULL, ceo_approval_by = NULL, ceo_approval_status = NULL,
            payment_closed_at = NULL, payment_closed_by = NULL WHERE id = '$id'";
    return $conn->query($sql);
}

function insertMedicalQuota($staff_id, $entitled_balance, $current_balance, $start_date, $end_date, $created_by){
    $conn=db();
    $sql="INSERT INTO v02_aims_medical_quota (staff_id, entitled_balance, current_balance, start_date, end_date, created_at, created_by)
            VALUES ('$staff_id', '$entitled_balance', '$current_balance', '$start_date', '$end_date', CURRENT_TIMESTAMP, '$created_by')";
    return $conn->query($sql);
}

function updateMedicalQuota($quota_id,$entitled_balance,$current_balance,$start_date,$end_date,$updated_by){
    $conn=db();
    $sql="UPDATE v02_aims_medical_quota SET entitled_balance = '$entitled_balance', current_balance = '$current_balance',
            start_date = '$start_date', end_date = '$end_date', updated_at = CURRENT_TIMESTAMP, updated_by = '$updated_by' WHERE id = '$quota_id'";
    return $conn->query($sql);
}

function deleteMedicalQuota($id){
    $conn=db();
    $sql="DELETE FROM v02_aims_medical_quota WHERE id = '$id'";
    return $conn->query($sql);
}

function getMedicalQuotaById($id){
    $conn=db();
    $sql="SELECT * FROM v02_aims_medical_quota WHERE id = '$id'";
    return $conn->query($sql);
}

function approveMedical($id, $action, $approve_by, $level){
    $conn=db();
    $sql = "";
    if ($level == '2'){
        $sql="UPDATE v02_aims_medical SET cfo_approval_at = CURRENT_TIMESTAMP, cfo_approval_by = '$approve_by', cfo_approval_status = '$action' WHERE id = '$id'";
    }elseif ($level == '3'){
        $sql="UPDATE v02_aims_medical SET ceo_approval_at = CURRENT_TIMESTAMP, ceo_approval_by = '$approve_by', ceo_approval_status = '$action' WHERE id = '$id'";
    }
    return $conn->query($sql);
}

/*function rewriteMedicalClaimBalance($id, $new_current_balance){
    $conn=db();
    $sql="UPDATE v02_aims_medical SET balance_after_approval = '$new_current_balance' WHERE id = '$id'";
    return $conn->query($sql);
}*/

function multipleApproveMedical($medical_id_string, $action, $approved_by, $level){
    $conn=db();
    $sql = "";
    if ($level == '2'){
        $sql = "UPDATE v02_aims_medical SET cfo_approval_at = CURRENT_TIMESTAMP, cfo_approval_by = '$approved_by', cfo_approval_status = '$action' WHERE id IN $medical_id_string";
    }elseif ($level == '3'){
        $sql = "UPDATE v02_aims_medical SET ceo_approval_at = CURRENT_TIMESTAMP, ceo_approval_by = '$approved_by', ceo_approval_status = '$action' WHERE id IN $medical_id_string";
    }
    return $conn->query($sql);
}

function updatePaymentStatusMedical($id, $action, $closed_by){
    $conn=db();
    if ($action == 'close'){
        $sql = "UPDATE v02_aims_medical SET payment_closed_at = CURRENT_TIMESTAMP, payment_closed_by = '$closed_by' WHERE id = '$id'";
    }else{
        $sql = "UPDATE v02_aims_medical SET payment_closed_at = NULL, payment_closed_by = NULL WHERE id = '$id'";
    }
    return $conn->query($sql);
}

function multipleCloseMedical($medical_id_string, $action, $closed_by){
    $conn=db();
    if ($action == 'CLOSE'){
        $sql = "UPDATE v02_aims_medical SET payment_closed_at = CURRENT_TIMESTAMP, payment_closed_by = '$closed_by' WHERE id IN $medical_id_string";
    }else{
        $sql = "UPDATE v02_aims_medical SET payment_closed_at = NULL, payment_closed_by = NULL WHERE id IN $medical_id_string";
    }
    return $conn->query($sql);
}