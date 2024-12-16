<?php
require '../../lib/db/connection.php';
date_default_timezone_set("Asia/Kuala_lumpur");

/* ================= Start Version 2 function list ================= */

function getSys($sys_id) {
    $conn=db();
    $sql = "SELECT s.*,c.short_name FROM sys_setting s LEFT JOIN company c ON c.sys_id=s.sys_id WHERE s.sys_id='$sys_id'";
    return $conn->query($sql);
}

// Function to sanitize values received from the form. Prevents SQL injection
function clean($str) {
    $conn=db();
    $str = @trim($str);
    if(get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }
    return mysqli_real_escape_string($conn,$str);
}

//list of contractor
function v02getContractorList(){
    $conn = db();
    $sql = "SELECT s.id, c.ic_number FROM v02_aims_ot_contractor c LEFT JOIN staff s ON s.noic = c.ic_number";
    $result = $conn->query($sql);
    $array = [];
    while ($row = $result->fetch_assoc()){
        $array[$row['id']] = $row['ic_number'];
    }
    return $array;
}

function getRateMode($rate = null){
    $list = [
        '1.5' => 'Working Day',
        '2.0' => 'Off-day/Weekend',
        '3.0' => 'Public Holiday',
        '0.0' => '- Invalid rate mode -'
    ];

    if ($rate == null){
        return array_diff_assoc($list, ['0.0' => '- Invalid rate mode -']);
    }

    return $list[$rate];
}

function v02getDropDownMonth($selected){
    $months = [
        '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June',
        '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December',
    ];

    $txt_result="<option ".('0' == $selected ? 'selected':'')." value='0'>All</option>";
    foreach ($months as $index => $month){
        $txt_result .= "<option ".($index == $selected ? 'selected':'')." value=\"".$index."\">".$month."</option>";
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

function getStaffName($staff_id){
    $conn=db();
    $sql="SELECT name FROM staff WHERE id = '$staff_id'";
    return $conn->query($sql)->fetch_object()->name;
}

function convertStaffNotoIcNumber($no_staff){
    $conn=db();
    $sql = "SELECT noic FROM staff WHERE no_staff = '$no_staff'";
    return $conn->query($sql)->fetch_object()->noic;
}

function getMonthSessionName($session_id){
    $conn=db();
    $sql="SELECT month_session FROM v02_aims_ot_month_session WHERE id = '$session_id'";
    return $conn->query($sql)->fetch_object()->month_session;
}

function getOtStaffInfo($staff_id){
    $conn=db();
    $sql = "SELECT name, no_staff, noic, department_id, department_sub FROM staff s WHERE id = '$staff_id'";
    return $conn->query($sql);
}

function v02getOtPermissionList($staff_id,$year,$month){
    $conn=db();
    $where_month = ($month == 0) ? "" : "AND MONTH(created_at) = '$month'";
    $sql="SELECT * FROM v02_aims_ot_permission 
            WHERE applicant_id = '$staff_id'
			AND YEAR(created_at) = '$year'
			$where_month
			ORDER BY created_at DESC";
    return $conn->query($sql);
}

function getDropDownApproval($selected, $mobile = false) {
    $conn=db();
    $sql = "SELECT id, name, role_id, department_id, department_sub FROM staff 
     WHERE role_id IN ('HOD','MANAGER','FOUNDER','HOC','OPERATIONMANAGER','EXECUTIVEAVSB','SUPERVISORAVSB','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR')
     AND status = 'BEKERJA'
     ORDER BY CASE when role_id = 'FOUNDER' then 1
              when role_id = 'CFO' then 2
              when role_id = 'MANAGER' then 3
              when role_id = 'HOD' then 4
              when role_id = 'MANAGING-DIRECTOR' then 5
              when role_id = 'EXECUTIVE-DIRECTOR' then 6
              when role_id = 'OPERATIONMANAGER' then 7
              when role_id = 'SUPERVISORAVSB' then 8
              else 9 END";
    $result = $conn->query($sql);
    if($mobile){
        return  $result;
    }
    $txt_result="";
    while ($row  = $result -> fetch_array()){
        if($row[2] == "FOUNDER"){
            $row[2] = ($row[0] == "751206035485") ? "CEO" : "EC";
        }
        $txt_result .= "<optgroup label='".$row[2]." - ".$row[4]."'>
        <option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>
        </optgroup>";
    }
    return $txt_result;
}

//OT PERMISSION SECTION
function v02addOtPermission($rate_mode, $applicant_id, $description, $approval_id) {
    $conn=db();
    $timeNow = date("Y-m-d H:i:s");
    $sql = "INSERT INTO v02_aims_ot_permission(rate_mode, applicant_id, description, approval_id, claim_status, created_at) VALUES 
		('$rate_mode','$applicant_id','$description','$approval_id','0','$timeNow')";
    $conn->query($sql);
    return $conn->insert_id;
}

function v02getOtPermissionById($id){
    $conn=db();
    $sql = "SELECT otp.*, s.name as applicant_name, s.no_staff as applicant_no, s.noic as applicant_ic,
            a.name as approval_name, a.no_staff as approval_no, a.noic as approval_ic
            FROM v02_aims_ot_permission otp
            LEFT JOIN staff s ON s.id = otp.applicant_id
            LEFT JOIN staff a ON a.id = otp.approval_id
			WHERE otp.id = '$id'";
    return $conn->query($sql);
}

function v02deleteOtPermission($id){
    $conn=db();
    $sql = "DELETE FROM v02_aims_ot_permission WHERE id = '$id'";

    return $conn->query($sql);
}

function v02updateOtPermission($id,$rate_mode,$approval_id,$description){
    $conn=db();
    $sql = "UPDATE v02_aims_ot_permission SET rate_mode='$rate_mode', approval_id='$approval_id', description='$description' WHERE id='$id'";
    return $conn->query($sql);
}

function v02getOtPermissionApproval($approval_id, $approval, $month, $year){  //approve hod
    $where_month = ($month == 0) ? "" : "AND MONTH(created_at) = '$month'";
    if ($approval == "NULL"){
        $approval_at = "AND otp.approval_at IS NULL";
        $approval_status = "";
    }else{
        $approval_at = "AND otp.approval_at IS NOT NULL";
        if ($approval == "NO"){
            $approval_status = "AND otp.approval_status = '0'";
        }else{
            $approval_status = "AND otp.approval_status = '1'";
        }
    }

    $conn=db();
    $sql="SELECT otp.*, s.name as applicant_name, s.no_staff as applicant_no, s.noic as applicant_ic, s.department_sub as applicant_department,
            a.name as approval_name, a.no_staff as approval_no, a.noic as approval_ic
            FROM v02_aims_ot_permission otp
            LEFT JOIN staff s ON s.id = otp.applicant_id
            LEFT JOIN staff a ON a.id = otp.approval_id
            WHERE otp.approval_id = '$approval_id'
            $where_month AND YEAR (otp.created_at) = '$year' 
            $approval_at $approval_status
            ORDER BY created_at DESC";
    return $conn->query($sql);
}

function v02remarkOtPermission($id,$remark){
    $conn=db();
    $sql = "UPDATE v02_aims_ot_permission SET remark='$remark' WHERE id='$id'";
    return $conn->query($sql);
}

function v02approveOtPermission($id,$approval_status){
    $conn=db();
    $approval_at = ", approval_at = CURRENT_TIMESTAMP";
    if ($approval_status == 'null'){
        $approval_at = ", approval_at = NULL";
        $approval_status = '0';
    }
    $sql = "UPDATE v02_aims_ot_permission SET approval_status='$approval_status'".$approval_at." 
	WHERE id='$id'";
    return $conn->query($sql);
}

function v02autoApprovePermission($id){
    $conn=db();
    $sql="UPDATE v02_aims_ot_permission SET approval_status='1', approval_at = CURRENT_TIMESTAMP WHERE id='$id'";
    return $conn->query($sql);
}

function v02getCheckboxApproveOtp($id,$approval_status){
    $conn=db();
    $sql="UPDATE v02_aims_ot_permission SET approval_status = '$approval_status',approval_at=CURRENT_TIMESTAMP WHERE id IN $id" ;
    return $conn->query($sql);
}

function otPermissionIsClaimed($ot_permission_id){
    $conn=db();
    $sql = "SELECT COUNT(id) as ot_count FROM v02_aims_ot WHERE ot_permission_id = '$ot_permission_id'";
    $result = $conn->query($sql)->fetch_object()->ot_count;

    return $result > 0;
}

function v02addOt($staff_id,$ot_permission_id,$month_claim,$date_ot,$start_ot,$end_ot,$total_hours,$document_name,$document_size) { //isi form
    $conn=db();

    //Find month session row and insert if not exist
    $sql_check_month_claim = "SELECT * FROM v02_aims_ot_month_session WHERE month_session = '$month_claim' AND staff_id = '$staff_id' LIMIT 1";
    $check_month_claim = $conn->query($sql_check_month_claim);
    $month_claim_count = mysqli_num_rows($check_month_claim); // count row to check it existence
    $month_session_result = $check_month_claim->fetch_assoc(); //retrieve data from array

    if ($month_claim_count == 0){
        $sql_insert_month_session = "INSERT INTO v02_aims_ot_month_session (month_session, staff_id) VALUES ('$month_claim', '$staff_id')";
        $conn->query($sql_insert_month_session);

        $month_session_id = $conn->insert_id;
    }else{
        $month_session_id = $month_session_result['id'];
    }

    //Find date row and insert if not exist
    $sql_check_date_ot = "SELECT * FROM v02_aims_ot_date WHERE month_session_id = '$month_session_id' AND date = '$date_ot' LIMIT 1";
    $check_date_ot = $conn->query($sql_check_date_ot);
    $date_ot_count = mysqli_num_rows($check_date_ot); // count row to check it existence
    $date_ot_result = $check_date_ot->fetch_assoc(); //retrieve data from array

    if ($date_ot_count == 0){
        $today_overused = $total_hours - 4;
        $today_overused = max($today_overused, 0);
        $sql_insert_date_ot = "INSERT INTO v02_aims_ot_date (month_session_id, date, previous_overused, total_overtime, today_overused)
                                VALUES ('$month_session_id', '$date_ot', '0', '$total_hours', '$today_overused')";
        $conn->query($sql_insert_date_ot);

        $ot_date_id = $conn->insert_id;
    }else{
        $ot_date_id = $date_ot_result['id'];
        $prev_overused = $date_ot_result['previous_overused'];
        $total_overtime = $date_ot_result['total_overtime']+$total_hours;
        $today_overused = ($prev_overused + $total_overtime) - 4;
        $today_overused = max($today_overused, 0);
        $sql_update_date_ot = "UPDATE v02_aims_ot_date SET previous_overused='$prev_overused', total_overtime='$total_overtime', today_overused='$today_overused', updated_at = CURRENT_TIMESTAMP
                                WHERE id='$ot_date_id'";
        $conn->query($sql_update_date_ot);
    }

    if(in_array($staff_id, ['751206035485','660512115105','000701110342'])){ //change to staff_id 15/07/2023
        $doc_field = '';
        $doc_val = '';
        if($document_name!=""){
            $doc_field=" ,document_name,document_size";
            $doc_val=",'$document_name','$document_size'";
        }
        $sql_insert_ot_claim_autoVerified = "INSERT INTO v02_aims_ot(ot_date_id, ot_permission_id, start_ot, end_ot,total_hours, created_at, verify_by, verify_at,payment_status $doc_field)
		VALUES ('$ot_date_id', '$ot_permission_id', '$start_ot', '$end_ot', '$total_hours', CURRENT_TIMESTAMP, 'AUTO VERIFIED', CURRENT_TIMESTAMP, 'OPEN' $doc_val)";
        $conn->query($sql_insert_ot_claim_autoVerified);

        $sql_set_claim_status_autoVerified = "UPDATE v02_aims_ot_permission SET claim_status = '1' WHERE id = '$ot_permission_id'";
        $conn->query($sql_set_claim_status_autoVerified);
    }else {
        $doc_field = '';
        $doc_val = '';
        if($document_name!=""){
            $doc_field=" ,document_name,document_size";
            $doc_val=",'$document_name','$document_size'";
        }
        $sql_insert_ot_claim = "INSERT INTO v02_aims_ot(ot_date_id, ot_permission_id, start_ot, end_ot,total_hours, created_at, payment_status $doc_field)
		VALUES ('$ot_date_id', '$ot_permission_id', '$start_ot', '$end_ot', '$total_hours', CURRENT_TIMESTAMP, 'OPEN' $doc_val)";
        $conn->query($sql_insert_ot_claim);

        $sql_set_claim_status = "UPDATE v02_aims_ot_permission SET claim_status = '1' WHERE id = '$ot_permission_id'";
        $conn->query($sql_set_claim_status);
    }

    return true or die($conn->error);
}

function v02getMonthSession($staff_id, $selected, $mobile=false){ //only used in mobile
    $conn=db();
    $sql="SELECT id, month_session FROM v02_aims_ot_month_session WHERE staff_id = '$staff_id' ORDER BY id DESC";
    $result=$conn->query($sql);
    if($mobile){
        return $result;
    }
    $text_result="<option value='0' ".(0 == $selected ? 'selected':'').">All</option>";
    while ($row = $result->fetch_array()){
        $text_result .= "<option value='".$row[0]."' ".($row[0] == $selected ? 'selected':'').">".$row[1]."</option>";
    }
    return $text_result;
}

function v02getDateOt($staff_id, $sort, $month_session_id){
    $conn=db();
    $where_month_session_id = ($month_session_id == 0) ? "" : "AND otd.month_session_id = '$month_session_id'";
    $sql="SELECT otd.*, otm.month_session FROM v02_aims_ot_date otd 
            LEFT JOIN v02_aims_ot_month_session otm ON otm.id = otd.month_session_id
            WHERE otm.staff_id = '$staff_id' $where_month_session_id
            ORDER BY otd.date $sort";
    return $conn->query($sql);
}

function v02getDateWithOverused($id){
    $conn=db();
    $sql="SELECT * FROM v02_aims_ot_date WHERE month_session_id = '$id' AND today_overused > 0 ORDER BY date";
    return $conn->query($sql);
}

function v02getOverusedDetails($date_id){
    $conn=db();
    $sql="SELECT ot.start_ot, ot.end_ot, ot.total_hours, otp.rate_mode, otp.description FROM v02_aims_ot ot
                LEFT JOIN v02_aims_ot_permission otp ON otp.id = ot.ot_permission_id
                WHERE ot.ot_date_id = '$date_id'";
    return $conn->query($sql);
}

function v02getOtList($date_id){
    $conn=db();

    $sql = "SELECT otp.rate_mode, otp.description, ot.*, otd.date, otm.month_session  FROM v02_aims_ot ot
				LEFT JOIN v02_aims_ot_permission otp ON otp.id = ot.ot_permission_id
				LEFT JOIN v02_aims_ot_date otd ON otd.id = ot.ot_date_id				
				LEFT JOIN v02_aims_ot_month_session otm ON otm.id = otd.month_session_id
				WHERE ot.ot_date_id = '$date_id' ORDER BY otd.date DESC, ot.created_at DESC";
    return $conn->query($sql);
}

function v02getUnclaimedOtp($staff_id){
    $conn=db();
    $sql = "SELECT * FROM v02_aims_ot_permission WHERE applicant_id = '$staff_id'
                AND claim_status = '0' AND approval_at IS NOT NULL
                ORDER BY created_at";
    return $conn->query($sql);
}

function v02getOtInfo($id){
    $conn=db();
    $sql = "SELECT * FROM v02_aims_ot WHERE id='$id'";
    return $conn->query($sql);
}

function v02updateDateSummary($id, $total_hours){
    $conn=db();
    $sql_sum_ot = "SELECT SUM(total_hours) as sum_ot FROM v02_aims_ot WHERE ot_date_id = '$id'";
    $sum_ot = $conn->query($sql_sum_ot)->fetch_object()->sum_ot;
    $total_overtime = $sum_ot - $total_hours;

    $sql_prev_overused = "SELECT previous_overused FROM v02_aims_ot_date WHERE id='$id'";
    $prev_overused = $conn->query($sql_prev_overused)->fetch_object()->previous_overused;

    $today_overused = ($prev_overused + $total_overtime) - 4;
    $today_overused = max($today_overused, 0);
    $sql = "UPDATE v02_aims_ot_date SET total_overtime='$total_overtime', today_overused='$today_overused' WHERE id='$id'";
    return $conn->query($sql);
}

function v02deleteOt($id){
    $conn=db();
    //pick ot permission id from aims_ot table
    $ot_permission_id = $conn->query("SELECT ot_permission_id FROM v02_aims_ot WHERE id='$id'")->fetch_object()->ot_permission_id;

    //revert claim status if claim is deleted
    $sql_revert_claim_status = "UPDATE v02_aims_ot_permission SET claim_status = '0' WHERE id = '$ot_permission_id'";
    $conn->query($sql_revert_claim_status);

    $sql = "DELETE FROM v02_aims_ot WHERE id = '$id'";
    return $conn->query($sql);
}

function v02getOtById($id){
    $conn=db();
    $sql = "SELECT otp.rate_mode, otp.description, ot.*, otd.date, otm.month_session, otm.staff_id FROM v02_aims_ot ot 
            LEFT JOIN v02_aims_ot_permission otp ON otp.id = ot.ot_permission_id
            LEFT JOIN v02_aims_ot_date otd ON otd.id = ot.ot_date_id				
            LEFT JOIN v02_aims_ot_month_session otm ON otm.id = otd.month_session_id
            WHERE ot.id = '$id'";
    return $conn->query($sql);
}

function hourAdjust($id, $previous_hour, $total_hours){
    $conn=db();
    $adjustment_value = $total_hours-$previous_hour;

    //Take previous value (ot_date) eg. 5.0
    $sql_ot_date="SELECT previous_overused, total_overtime, today_overused FROM v02_aims_ot_date WHERE id='$id'";
    $ot_date = $conn->query($sql_ot_date)->fetch_assoc();
    $previous_overused = $ot_date['previous_overused'];
    $previous_total_overtime = $ot_date['total_overtime'];

    //previous total_overtime 5.0 + (-0.5) = 4.5 --> match with new hours
    $new_total_overtime = $previous_total_overtime + $adjustment_value;
    //calculate new today overused
    $new_today_overused = ($previous_overused + $new_total_overtime) - 4;
    $new_today_overused = max($new_today_overused, 0);

    $sql="UPDATE v02_aims_ot_date SET total_overtime = '$new_total_overtime', today_overused='$new_today_overused' WHERE id='$id'";
    return $conn->query($sql);

//  return 'total: '.$previous_total_overtime.' + '.$adjustment_value.' = '.$new_total_overtime.';<br>
//  overused: '.$previous_today_overused.' + '.$adjustment_value.' = '.$new_today_overused;
}

function v02updateOt($id,$start_ot,$end_ot,$total_hours){
    $conn=db();
    $sql = "UPDATE v02_aims_ot SET start_ot='$start_ot', end_ot='$end_ot', total_hours='$total_hours' WHERE id='$id'";
    return $conn->query($sql);
}

function v02viewAttachment($id){
    $conn=db();
    $sql=" SELECT document_name, document_size, verify_at FROM v02_aims_ot
                WHERE id='$id'";
    return $conn->query($sql);
}

function v02updateAttachment($id,$document_name,$document_size){
    $conn=db();
    $sql="UPDATE v02_aims_ot SET document_name='$document_name', document_size='$document_size' WHERE id='$id'";
    return $conn->query($sql);
}

function v02getDropDownMonthClaim($suggested_month_claim, $disabled,$allowed_range = 0, $mobile = false) {
    $month_array = array();

    for($i=$allowed_range;$i<3;$i++){
        $generate_month = $suggested_month_claim.' '.$i.' months';
        array_push($month_array, date("Y-m", strtotime($generate_month)));
    }

    $txt_result="";

    if($mobile){
        $i=0;
        $array = array();
        foreach ($month_array as $month){
            $array[$i] = date('F Y', strtotime($month));
            $i++;
        }
        return  $array;
    }

    foreach ($month_array as $month){
        $value = ($suggested_month_claim == $month && $disabled == 1) ? '' : date("F Y", strtotime($month));
        $txt_result .= "<option ".($suggested_month_claim == $month ? 'selected' : '')." value='".$value."'>".date('F Y', strtotime($month))."</option>";
    }
    return $txt_result;
}

function v02getDropDownMonthClaimContractor($suggested_month_claim, $disabled, $allowed_range = 0, $mobile = false) {
    $month_array = array();
    $txt_result="";

    for($i=$allowed_range;$i<3;$i++){
        $generate_month = $suggested_month_claim.' '.$i.' months';
        array_push($month_array, date("Y-m", strtotime($generate_month)));
    }

    if($mobile){
        $array = array();
        foreach ($month_array as $month){
            if($month == date('Y-m')){
                $session = (date('d') <= 15) ? '1' : '2';
                array_push($array, date('F Y', strtotime($month))." (Session ".$session.")");
            }
        }
        return $array;
    }

    foreach ($month_array as $month){
        $value = ($suggested_month_claim == $month && $disabled == 1) ? '' : date("F Y", strtotime($month));
        $txt_result .= "
            <option ".(($suggested_month_claim == $month && date('d') <= 15) ? 'selected' : '')." value='".$value." (Session 1)'>".date('F Y', strtotime($month))." (Session 1)</option>
            <option ".(($suggested_month_claim == $month && date('d') > 15) ? 'selected' : '')." value='".$value." (Session 2)'>".date('F Y', strtotime($month))." (Session 2)</option>
            ";
    }
    return $txt_result;
}

function v02getOtMonthSession($staff_id, $year = '0'){
    $where_year = ($year != '0') ? "AND month_session LIKE '%$year%'" : "";
    $conn=db();
    $sql="SELECT * FROM v02_aims_ot_month_session WHERE staff_id = '$staff_id'
            $where_year ORDER BY id DESC";
    return $conn->query($sql);
}

function v02getCountOtMonthSession($id){
    $conn=db();
    $sql = "SELECT count(ot.id) as ot_count FROM v02_aims_ot_date otd
            LEFT JOIN v02_aims_ot ot ON ot.ot_date_id = otd.id
            WHERE otd.month_session_id = '$id'";
    return $conn->query($sql)->fetch_object()->ot_count;
}

function v02getOtApproval($month_session_id){
    $conn=db();
    $sql="SELECT ot.verify_by, ot.verify_at, ot.verify_status, ot.review_by, ot.review_at, ot.review_status, ot.approved_by, ot.approved_at, ot.approved_status
            FROM v02_aims_ot ot
            LEFT JOIN v02_aims_ot_date otd ON otd.id = ot.ot_date_id
            WHERE otd.month_session_id = '$month_session_id'";
    return $conn->query($sql);
//    LEFT JOIN v02_aims_ot_month_session otm ON otm.id = otd.month_session_id
}

function v02getMonthClaimStaff($id){
    $conn=db();
    $sql="SELECT otm.*, s.name, s.noic, s.no_staff, s.role_id, s.department_id, s.department_sub
            FROM v02_aims_ot_month_session otm
            LEFT JOIN staff s ON s.id = otm.staff_id
            WHERE otm.id = '$id'";
    return $conn->query($sql);
}

function v02getOtClaimReport($id){
    $conn=db();
    $sql="SELECT ot.*, otp.rate_mode,otp.description, otd.date FROM v02_aims_ot ot
            LEFT JOIN v02_aims_ot_permission otp ON otp.id = ot.ot_permission_id
            LEFT JOIN v02_aims_ot_date otd ON otd.id = ot.ot_date_id
            WHERE otd.month_session_id = '$id'
            ORDER BY otd.date";
    return $conn->query($sql);
}

function convertDigitToMonthName($number){
    $month = array(
        "01" => "January", "02" => "February", "03" => "March", "04" => "April", "05" => "May", "06" => "June",
        "07" => "July", "08" => "August","09" => "September", "10" => "October","11" => "November", "12" => "December",
    );
    return $month[$number];
}

//Verification (HOD), Review (HR), and Approval (CEO) Page

function v02getMonthSessionHOD($department_sub, $staff_id_verify, $verification_status, $month, $year){
    //set where month if parameter contain month number
    $month_name = ($month == 0) ? "" : convertDigitToMonthName($month);
    if ($verification_status == 'NULL'){
//        $where_verify_status = "(verify_by IS NULL AND verify_status IS NULL)"; //pending
        $where_verify_status = "AND ot.verify_status IS NULL";
    }else if ($verification_status == 'YES'){
//        $where_verify_status = "(verify_by IS NOT NULL AND verify_status = 1)"; //verified
        $where_verify_status = "AND ot.verify_status = 1";
    }else{
//        $where_verify_status = "(verify_by IS NOT NULL AND verify_status <> 1)"; //rejected
        $where_verify_status = "AND ot.verify_status <> 1";
    }

    $conn=db();
    //get role id for current logged in user
    $role_id=$conn->query("SELECT role_id FROM staff WHERE id='$staff_id_verify'")->fetch_object()->role_id;

    //set custom condition for ceo, cfo, various role_id (and department_sub if applicable)
    // if ($staff_id_verify == '751206035485'){ //CEO account
    //     $custom_condition = "AND s.role_id IN ('HOD','MANAGER','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR')";
    // }
    // else if($staff_id_verify == '810415035497'){ //En. Alias Account
    //     $custom_condition = "AND s.department_sub = 'MARKETING&BUSINESS-DEV'";
    // }
    // else if($role_id == 'CFO'){ //CFO account
    //     $custom_condition = "AND s.department_sub = 'FINACC' AND s.no_staff <> 'INDEEP0311'";
    // }
    // else if($role_id == 'MANAGING-DIRECTOR'){ //kak lana approve [siha, ..., ..., akmal]
    //     $custom_condition = "AND otm.no_staff IN ('860620295410','850126115526','930128016820','690615115252')";
    // }
    // else if($role_id == 'OPERATIONMANAGER'){
    //     $custom_condition = "AND (s.department_sub IN ('OPERATION-AVSB','PROCUREMENT-AVSB','CORPADMIN-AVSB', 'QR&D',
    //                             'COMMERCIAL-AVSB','OPERATIONFAC-AVSB','OPERATIONFOOD-AVSB','CATERING','LOGISTIC')
    //                                 OR otm.no_staff IN ('INDEEP0311','911011115100'))";
    // }
    // else if($role_id == 'HOD'){
    //     if ($department_sub == 'OPERATION-AGMHESB'){
    //         $custom_condition = "AND s.department_sub IN ('OPERATION-AGMHESB','ELECTRICAL')";
    //     }else if ($department_sub == 'HR'){
    //         $custom_condition = "AND s.department_sub IN ('HR', 'HR-SEA', 'ECOFFICE')";
    //     }else if($department_sub == 'OPERATION-AGMSB'){
    //         $custom_condition = "AND s.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')";
    //     }else if($department_sub == 'TECHOPERATION'){
    //         $custom_condition = "AND s.department_sub IN ('TECHOPERATION','PILOT-BOAT','MOORING-GANG') AND department_id <> 'AVSB'"; //AVSB - custom condition for shahrul hakim [TECHOPERATION] (PA Syafiq Sahamuddin)
    //     }else{
    //         $custom_condition = "AND s.department_sub = '$department_sub' AND s.department_sub NOT IN 
    //                                 ('MARKETING&BUSINESS-DEV', 'FINACC', 'OPERATION-AGMHESB', 'ELECTRICAL', 'HR','HR-SEA', 'ECOFFICE',
    //                                 'OPERATION-AGMSB', 'HR-AGMA', 'OPERATION-BUNKER', 'TECHOPERATION', 'PILOT-BOAT', 'MOORING-GANG')";
    //     }
    // }
    // else{
    //     $custom_condition = "AND s.leave_approval = '$staff_id_verify'";
    // }

    if($role_id == 'CFO'){ //CFO account
        $custom_condition = "AND s.department_sub = 'FINACC' AND s.department_id <> 'AVSB' AND s.no_staff <> 'INDEEP0311'";
    }else if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB'){
        $custom_condition = "AND (s.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER') OR otp.approval_id = '$staff_id_verify')";
    }else{
        $custom_condition = "AND otp.approval_id = '$staff_id_verify' AND (s.department_sub NOT IN ('FINACC','OPERATION-AGMSB', 'HR-AGMA', 'OPERATION-BUNKER') OR
                                (s.department_sub ='FINACC' AND s.department_id = 'AVSB') )";
    }

    //Final Query Monthly Listing
    $sql = "SELECT s.name, s.noic, s.role_id, s.department_sub, s.department_id, otm.id, otm.month_session, otm.staff_id
            FROM v02_aims_ot ot LEFT JOIN v02_aims_ot_date otd ON otd.id = ot.ot_date_id
            LEFT JOIN v02_aims_ot_month_session otm ON otm.id = otd.month_session_id
            LEFT JOIN v02_aims_ot_permission otp ON otp.id = ot.ot_permission_id
            LEFT JOIN staff s ON s.id = otm.staff_id
            WHERE otm.staff_id <> '$staff_id_verify' $where_verify_status  
            $custom_condition
            AND otm.month_session LIKE '%$month_name $year%'
            GROUP BY otm.id
			ORDER BY otm.id DESC";
    return $conn->query($sql);
}

function v02getLatestVerifyInfo($id, $verification_status, $staff_id_verify){
    if ($verification_status == 'NULL'){
        $where_verify_status = "(verify_by IS NULL AND verify_status IS NULL)"; //pending
    }else if ($verification_status == 'YES'){
        $where_verify_status = "(verify_by IS NOT NULL AND verify_status = 1)"; //verified
    }else{
        $where_verify_status = "(verify_by IS NOT NULL AND verify_status <> 1)"; //rejected
    }

    $conn=db();
    $staff=$conn->query("SELECT role_id, department_sub FROM staff WHERE id='$staff_id_verify'")->fetch_assoc();
    $role_id = $staff['role_id'];
    $department_sub = $staff['department_sub'];

    if($role_id == 'CFO'){ //CFO account
        $where_approval_id = "";
    }else if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB'){
        $where_approval_id = "AND (otp.approval_id = 'auto' OR otp.approval_id = '134')";
    }else{
        $where_approval_id = "AND otp.approval_id = '$staff_id_verify'";
    }
    $sql="SELECT ot.verify_by, ot.verify_at,

		(SELECT count(ot.id) FROM v02_aims_ot ot
		    LEFT JOIN v02_aims_ot_date otd ON otd.id = ot.ot_date_id
		    LEFT JOIN v02_aims_ot_permission otp ON otp.id = ot.ot_permission_id
            WHERE otd.month_session_id = '$id' AND $where_verify_status $where_approval_id)
        as selected_row,
            
		(SELECT count(ot.id) FROM v02_aims_ot ot 
		    LEFT JOIN v02_aims_ot_date otd ON otd.id = ot.ot_date_id
		    LEFT JOIN v02_aims_ot_permission otp ON otp.id = ot.ot_permission_id
            WHERE otd.month_session_id = '$id' $where_approval_id)
        as total_row FROM v02_aims_ot ot 
            
            LEFT JOIN v02_aims_ot_date otd ON otd.id = ot.ot_date_id
            WHERE otd.month_session_id = '$id'
            ORDER BY ot.created_at DESC LIMIT 1";
    return $conn->query($sql);
}

function v02getLatestApprovalInfo($id, $approved_status){
    if ($approved_status == 'NULL'){
        $where_approved_status = "(approved_by IS NULL AND approved_status IS NULL)"; //pending
    }else if ($approved_status == 'YES'){
        $where_approved_status = "(approved_by IS NOT NULL AND approved_status = 1)"; //verified
    }else{
        $where_approved_status = "(approved_by IS NOT NULL AND approved_status <> 1)"; //rejected
    }
    $conn=db();
    $sql="SELECT ot.approved_by, ot.approved_at,

		(SELECT count(ot.id) FROM v02_aims_ot ot LEFT JOIN v02_aims_ot_date otd ON otd.id = ot.ot_date_id
            WHERE otd.month_session_id = '$id' AND verify_by IS NOT NULL AND verify_status = '1'
            AND review_by IS NOT NULL AND review_status = '1' AND $where_approved_status) as selected_row,
            
		(SELECT count(ot.id) FROM v02_aims_ot ot LEFT JOIN v02_aims_ot_date otd ON otd.id = ot.ot_date_id
            WHERE otd.month_session_id = '$id') as total_row FROM v02_aims_ot ot 
            
            LEFT JOIN v02_aims_ot_date otd ON otd.id = ot.ot_date_id
            WHERE otd.month_session_id = '$id'
            ORDER BY ot.created_at DESC LIMIT 1";
    return $conn->query($sql);
}

function v02getOtByMonthSession($month_session_id, $verification_status, $verify_id){
    if ($verification_status == 'NULL'){
        $where_verify_status = "AND (ot.verify_by IS NULL AND ot.verify_status IS NULL)"; //pending
    }else if ($verification_status == 'YES'){
        $where_verify_status = "AND (ot.verify_by IS NOT NULL AND ot.verify_status = 1)"; //verified
    }else{
        $where_verify_status = "AND (ot.verify_by IS NOT NULL AND ot.verify_status <> 1)"; //rejected
    }
    $conn=db();
    $staff=$conn->query("SELECT role_id, department_sub FROM staff WHERE id='$verify_id'")->fetch_assoc();
    $role_id = $staff['role_id'];
    $department_sub = $staff['department_sub'];

    if($role_id == 'CFO'){ //CFO account
        $otp_approval = "AND s.department_sub = 'FINACC' AND s.no_staff <> 'INDEEP0311'";
    }else if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB'){
        $otp_approval = "AND (otp.approval_id = 'auto' OR otp.approval_id = '134')";
    }else{
        $otp_approval = "AND otp.approval_id = '$verify_id'";
    }

    $sql="SELECT ot.*, otd.date, otp.description FROM v02_aims_ot ot
            LEFT JOIN v02_aims_ot_date otd ON otd.id = ot.ot_date_id
            LEFT JOIN v02_aims_ot_month_session otm ON otm.id = otd.month_session_id
            LEFT JOIN v02_aims_ot_permission otp ON otp.id = ot.ot_permission_id
            LEFT JOIN staff s ON s.id = otm.staff_id
            WHERE otd.month_session_id = '$month_session_id'
            $otp_approval
            $where_verify_status";
    return $conn->query($sql);
}

function v02CheckboxVerifyMonthClaim($id, $verification_by, $verification_status, $prev_verification){
    if ($prev_verification == 'NULL'){
        $where_verify_status = "AND (verify_by IS NULL AND verify_status IS NULL)"; // to update ot with pending status
    }else if ($prev_verification == 'YES'){
        $where_verify_status = "AND (verify_by IS NOT NULL AND verify_status = 1)"; // to update ot with verified status
    }else{
        $where_verify_status = "AND (verify_by IS NOT NULL AND verify_status <> 1)"; // to update ot with rejected status
    }
    $conn=db();
    $temp_array = array();
    $getOtDateId = $conn->query("SELECT id FROM v02_aims_ot_date WHERE month_session_id IN $id");
    while ($row = $getOtDateId->fetch_assoc()){ array_push($temp_array, $row['id']); }
    $date_id = "('" . implode("','", $temp_array) . "')"; //store all date id in (...)

    $sql="UPDATE v02_aims_ot SET verify_by = '$verification_by' , verify_at=CURRENT_TIMESTAMP, verify_status = '$verification_status'
            WHERE ot_date_id IN $date_id $where_verify_status" ;
    return $conn->query($sql);
}

function v02CheckboxVerifyOtClaim($id, $verification_by, $verification_status){
    $conn=db();
    $sql="UPDATE v02_aims_ot SET verify_by = '$verification_by' , verify_at=CURRENT_TIMESTAMP, verify_status = '$verification_status'
            WHERE id IN $id" ;
    return $conn->query($sql);
}

function v02verificationRemark($id, $verification_remark){
    $conn=db();
    $sql="UPDATE v02_aims_ot SET verification_remark = '$verification_remark' WHERE id = '$id'";
    return $conn->query($sql);
}

function v02updateClaimHod($id, $total_hours){
    $conn=db();
    $sql="UPDATE v02_aims_ot SET total_hours = '$total_hours' WHERE id = '$id'";
    return $conn->query($sql) or die($conn->error);
}

function v02getOtHRReview($company, $month, $year){
    //set where month if parameter contain month number
    $month_name = ($month == 0) ? "" : convertDigitToMonthName($month);
    $conn=db();
    $sql="SELECT otm.*, s.name,s.noic,s.no_staff,s.department_sub,s.department_id,s.role_id FROM v02_aims_ot_month_session otm
            LEFT JOIN staff s ON s.id = otm.staff_id
            WHERE s.department_id LIKE '%$company%'
            AND otm.month_session LIKE '%$month_name $year%'
            ORDER BY otm.id DESC, otm.month_session DESC";
    return $conn->query($sql);
}

function v02countOtStatusFromMonthSessionID($month_session_id, $review_status, $payment_status){
    if ($review_status == 'NULL'){
        $where_review_status = "AND (ot.review_by IS NULL AND ot.review_status IS NULL)"; // to update ot with pending status
    }else if ($review_status == 'YES'){
        $where_review_status = "AND (ot.review_by IS NOT NULL AND ot.review_status = 1)"; // to update ot with verified status
    }else{
        $where_review_status = "AND (ot.review_by IS NOT NULL AND ot.review_status <> 1)"; // to update ot with rejected status
    }
    $conn=db();
    $sql="SELECT COUNT(ot.id) as hr_count FROM v02_aims_ot ot
            LEFT JOIN v02_aims_ot_date otd ON otd.id = ot.ot_date_id
            WHERE otd.month_session_id = '$month_session_id'
            AND ot.verify_by IS NOT NULL AND ot.verify_status = 1
            $where_review_status
            AND ot.payment_status = '$payment_status'";
    return $conn->query($sql)->fetch_object()->hr_count;
}

function v02countTotalOTFromMonthSessionID($month_session_id){
    $conn=db();
    $sql="SELECT COUNT(ot.id) as total_count FROM v02_aims_ot ot
            LEFT JOIN v02_aims_ot_date otd ON otd.id = ot.ot_date_id
            WHERE otd.month_session_id = '$month_session_id'";
    //AND ot.verify_by IS NOT NULL AND ot.verify_status = 1
    return $conn->query($sql)->fetch_object()->total_count;
}

function v02getMonthSessionDetails($month_session_id){
    $conn=db();
    $sql="SELECT otm.*, s.id AS staff_id, s.name, s.noic, s.no_staff, s.department_sub, s.department_id, s.role_id
            FROM v02_aims_ot_month_session otm
            LEFT JOIN staff s ON s.id = otm.staff_id
            WHERE otm.id = '$month_session_id' LIMIT 1";
    return $conn->query($sql);
}

function v02allOtByMonthSession($month_session_id){
    $conn=db();
    $sql="SELECT otp.description, otp.rate_mode, ot.*, otd.date, otd.today_overused, otm.month_session FROM v02_aims_ot ot
            LEFT JOIN v02_aims_ot_permission otp ON otp.id = ot.ot_permission_id
            LEFT JOIN v02_aims_ot_date otd ON otd.id = ot.ot_date_id
            LEFT JOIN v02_aims_ot_month_session otm ON otm.id = otd.month_session_id
            WHERE otm.id = '$month_session_id'
            AND ot.verify_by IS NOT NULL 
            AND ot.verify_status = '1'
            ORDER BY ot.created_at";
    return $conn->query($sql);
}

function getTotalHourByRate($month_session_id, $rate_mode = null, $hr = true){
    $where_hr = $hr ? "AND ot.verify_by IS NOT NULL AND ot.verify_status = '1' AND ot.review_by IS NULL AND ot.review_status IS NULL" : "";
    $where_rate = ($rate_mode) ? "AND otp.rate_mode = '$rate_mode'" : "";
    $conn=db();
    $sql="SELECT SUM(ot.total_hours) as sum_hours FROM v02_aims_ot ot
           LEFT JOIN v02_aims_ot_date otd ON otd.id = ot.ot_date_id
           LEFT JOIN v02_aims_ot_permission otp ON otp.id = ot.ot_permission_id
           WHERE otd.month_session_id = '$month_session_id'
           $where_rate $where_hr";
    return $conn->query($sql)->fetch_object()->sum_hours;
}

function v02updateDescription($id, $rate_mode, $description){
    $conn=db();
    $otp_id = $conn->query("SELECT ot_permission_id FROM v02_aims_ot WHERE id = '$id'")->fetch_object()->ot_permission_id;
    $sql="UPDATE v02_aims_ot_permission SET rate_mode = '$rate_mode', description = '$description' WHERE id = '$otp_id'";
    return $conn->query($sql) or die($conn->error);
}

function v02updateOtByHR($id, $total_hours, $verification_remark){
    $conn=db();
    $sql="UPDATE v02_aims_ot SET total_hours = '$total_hours', verification_remark = '$verification_remark' WHERE id = '$id'";
    return $conn->query($sql) or die($conn->error);
}

function v02reviewOtClaim($id,$normal_hour,$normal_wageperhour,$normal_totalwages,$weekend_hour,$weekend_wageperhour,$weekend_totalwages,$holiday_hour,
                          $holiday_wageperhour,$holiday_totalwages,$special_hour,$special_wageperhour,$special_totalwages,$total_claim,$hr_status, $hr_staff_no){
    $conn=db();
    $sql="UPDATE v02_aims_ot_month_session SET normal_hour = '$normal_hour', normal_wageperhour = '$normal_wageperhour', normal_totalwages = '$normal_totalwages', weekend_hour = '$weekend_hour',
                    weekend_wageperhour = '$weekend_wageperhour', weekend_totalwages = '$weekend_totalwages', holiday_hour = '$holiday_hour', holiday_wageperhour = '$holiday_wageperhour',
                     holiday_totalwages = '$holiday_totalwages', special_hour = '$special_hour', special_wageperhour = '$special_wageperhour', special_totalwages = '$special_totalwages',
                      total_claim = '$total_claim' WHERE id = '$id'";
    $result = $conn->query($sql);
    $temp_array = array();
    if ($result!="" && $result > 0){
        $getOtDateId = $conn->query("SELECT id FROM v02_aims_ot_date WHERE month_session_id = '$id'");
        while ($list = $getOtDateId->fetch_assoc()){ array_push($temp_array, $list['id']); }
        $date_id = "('" . implode("','", $temp_array) . "')"; //store all date id in (...)

        $review_sql = "UPDATE v02_aims_ot SET review_by = '$hr_staff_no', review_at = CURRENT_TIMESTAMP, review_status = '$hr_status'
                            WHERE ot_date_id IN $date_id";
        return $conn->query($review_sql) or die($conn->error);
    }
    return die('Error on review: '.$conn->error);
}

function v02resetSummaryTable($id){
    $conn=db();
    $sql="UPDATE v02_aims_ot_month_session SET total_claim = NULL,
            normal_hour = NULL, normal_wageperhour = NULL, normal_totalwages = NULL,
            weekend_hour = NULL, weekend_wageperhour = NULL, weekend_totalwages = NULL,
            holiday_hour = NULL, holiday_wageperhour = NULL, holiday_totalwages = NULL,
            special_hour = NULL, special_wageperhour = NULL, special_totalwages = NULL,
            total_overused = NULL, conversion_offday = NULL, conversion_claim = NULL
            WHERE id = '$id'";
    $result = $conn->query($sql);
    $temp_array = array();
    if ($result!="" && $result > 0){
        $getOtDateId = $conn->query("SELECT id FROM v02_aims_ot_date WHERE month_session_id = '$id'");
        while ($list = $getOtDateId->fetch_assoc()){ array_push($temp_array, $list['id']); }
        $date_id = "('" . implode("','", $temp_array) . "')"; //store all date id in (...)

        $review_sql = "UPDATE v02_aims_ot SET review_by = NULL, review_at = NULL, review_status = NULL,
                        approved_by = NULL, approved_at = NULL, approved_status = NULL
                            WHERE ot_date_id IN $date_id";
        return $conn->query($review_sql) or die($conn->error);
    }
    return die('Error on review: '.$conn->error);
}

function v02HrChangeMonthClaim($id, $month_claim, $staff_id){
    $conn=db();//Find month session row and insert if not exist
    $sql_check_month_claim = "SELECT * FROM v02_aims_ot_month_session WHERE month_session = '$month_claim' AND staff_id = '$staff_id' LIMIT 1";
    $check_month_claim = $conn->query($sql_check_month_claim);
    $month_claim_count = mysqli_num_rows($check_month_claim); // count row to check it existence
    $month_session_result = $check_month_claim->fetch_assoc(); //retrieve data from array

    if ($month_claim_count == 0){
        $sql_insert_month_session = "INSERT INTO v02_aims_ot_month_session (month_session, staff_id) VALUES ('$month_claim', '$staff_id')";
        $conn->query($sql_insert_month_session);

        $month_session_id = $conn->insert_id;
    }else{
        $month_session_id = $month_session_result['id'];
    }

    $date_id = $conn->query("SELECT ot_date_id FROM v02_aims_ot WHERE id='$id'")->fetch_object()->ot_date_id;
    //$date_id = $conn->query("UPDATE v02_aims_ot SET verify_by = NULL, verify_at = NULL, verify_status = NULL WHERE ot_date_id='$date_id'");

    $sql="UPDATE v02_aims_ot_date SET month_session_id = '$month_session_id' WHERE id='$date_id'";
    return $conn->query($sql) or die($conn->error);
}

function v02getOtOverused($id, $date){
    $conn=db();
    $sql="SELECT today_overused FROM v02_aims_ot_date WHERE month_session_id = '$id' AND date='$date'";
    return $conn->query($sql)->fetch_object()->today_overused;
}

function v02overusedConversion($id, $total_overused, $convert_to_off_day, $convert_to_claim){
    $conn=db();
    $sql="UPDATE v02_aims_ot_month_session SET total_overused = '$total_overused', conversion_offday = '$convert_to_off_day',
                conversion_claim = '$convert_to_claim' WHERE id='$id'";
    return $conn->query($sql);
}

function v02getMonthSessionCEO($department_code, $approval_id, $approved_status, $month, $year){
    $conn=db();
    $month_name = ($month == 0) ? "" : convertDigitToMonthName($month);
    $where_company = ($department_code != '0') ? "AND s.department_id LIKE '%$department_code%'" : "";

    //Approval status
    if ($approved_status == 'NULL'){
        $where_approved_status = "AND (ot.approved_by IS NULL AND ot.approved_status IS NULL)"; // to update ot with pending status
    }else if ($approved_status == 'YES'){
        $where_approved_status = "AND (ot.approved_by IS NOT NULL AND ot.approved_status = 1)"; // to update ot with approved status
    }else{
        $where_approved_status = "AND (ot.approved_by IS NOT NULL AND ot.approved_status <> 1)"; // to update ot with disapproved status
    }

    //set custom condition for logged in user
    if ($approval_id == '13'){ //if CEO account
        $custom_condition = "AND s.role_id NOT IN ('HOD','MANAGER','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR')";
    }else if($approval_id == '12'){ // if chairman account
        $custom_condition = "AND (s.role_id IN ('HOD','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR','MANAGER') OR s.no_staff = '980401115412')"; //PA baru haji, nazifah
    }else{
        $custom_condition = "";
    }

    //Final Query Monthly Listing
    $sql = "SELECT s.name, s.noic, s.no_staff, s.role_id, s.department_sub, s.department_id, s.leave_approval, otm.id, otm.month_session, otm.staff_id, otm.total_claim
            FROM v02_aims_ot ot LEFT JOIN v02_aims_ot_date otd ON otd.id = ot.ot_date_id
            LEFT JOIN v02_aims_ot_month_session otm ON otm.id = otd.month_session_id
            LEFT JOIN staff s ON s.id = otm.staff_id
            WHERE otm.staff_id <> '$approval_id' AND otm.month_session LIKE '%$month_name $year%'
			AND verify_by IS NOT NULL AND verify_status = '1'
            AND review_by IS NOT NULL AND review_status = '1'
			$where_company $where_approved_status $custom_condition
			GROUP BY otm.id";
    return $conn->query($sql);
}

function v02getDocumentListMonthSession($id){
    $conn=db();
    $sql = "SELECT ot.document_name, otd.date, otp.description FROM v02_aims_ot ot
        LEFT JOIN v02_aims_ot_permission otp ON otp.id = ot.ot_permission_id
        LEFT JOIN v02_aims_ot_date otd ON otd.id = ot.ot_date_id
        WHERE otd.month_session_id = '$id' AND ot.document_name != ''";
    return $conn->query($sql);
}

function v02approveOtClaim($id, $approved_by, $approved_status){
    $temp_array = array();
    $conn=db();
    $getOtDateId = $conn->query("SELECT id FROM v02_aims_ot_date WHERE month_session_id = '$id'");
    while ($list = $getOtDateId->fetch_assoc()){ array_push($temp_array, $list['id']); }
    $date_id = "('" . implode("','", $temp_array) . "')"; //store all date id in (...)
    $sql="UPDATE v02_aims_ot SET approved_by = '$approved_by', approved_at = CURRENT_TIMESTAMP, approved_status = '$approved_status'
            WHERE ot_date_id IN $date_id";
    return $conn->query($sql) or die($conn->error);
}

function v02CheckboxApproveMonthClaim($id, $approval_by, $approval_status, $prev_approval){
    if ($prev_approval == 'NULL'){
        $where_approved_status = "AND (approved_by IS NULL AND approved_status IS NULL)"; // to update ot with pending status
    }else if ($prev_approval == 'YES'){
        $where_approved_status = "AND (approved_by IS NOT NULL AND approved_status = 1)"; // to update ot with verified status
    }else{
        $where_approved_status = "AND (approved_by IS NOT NULL AND approved_status <> 1)"; // to update ot with rejected status
    }
    $conn=db();
    $temp_array = array();
    $getOtDateId = $conn->query("SELECT id FROM v02_aims_ot_date WHERE month_session_id IN $id");
    while ($row = $getOtDateId->fetch_assoc()){ array_push($temp_array, $row['id']); }
    $date_id = "('" . implode("','", $temp_array) . "')"; //store all date id in (...)

    $sql="UPDATE v02_aims_ot SET approved_by = '$approval_by' , approved_at=CURRENT_TIMESTAMP, approved_status = '$approval_status'
            WHERE ot_date_id IN $date_id $where_approved_status" ;
    return $conn->query($sql);
}

function v02getOtPermissionHr($department_code,$month,$year){
    $where_year = ($year != '0') ? "AND YEAR(otp.created_at) = '$year'" : "";
    $where_month = ($month != '0') ? "AND MONTH(otp.created_at) = '$month'" : "";
    $conn=db();
    $sql = "SELECT otp.*, s.name as applicant_name, s.no_staff as applicant_no, s.noic as applicant_ic,
            a.name as approval_name, a.no_staff as approval_no, a.noic as approval_ic FROM v02_aims_ot_permission otp
                LEFT JOIN staff s ON s.id = otp.applicant_id
                LEFT JOIN staff a ON a.id = otp.approval_id
                WHERE s.department_id = '$department_code'
                $where_year $where_month
                ORDER BY otp.created_at DESC";
    return $conn->query($sql);
}

function v02closeOtClaim($id){
    $conn=db();
    $temp_array = array();
    $getOtDateId = $conn->query("SELECT id FROM v02_aims_ot_date WHERE month_session_id = '$id'");
    while ($row = $getOtDateId->fetch_assoc()){ array_push($temp_array, $row['id']); }
    $date_id = "('" . implode("','", $temp_array) . "')"; //store all date id in (...)

    $sql = "UPDATE v02_aims_ot SET payment_status='CLOSED'
            WHERE ot_date_id IN $date_id";
    return $conn->query($sql);
}

function v02getYesterdayOt($yesterday){
    $conn=db();
    $sql = "SELECT * FROM v02_aims_ot_date WHERE today_overused > 0 
                AND (created_at LIKE '%$yesterday%' OR updated_at LIKE '%$yesterday%') ORDER BY date";
    return $conn->query($sql);
}

function v02getOverusedById($id){
    $conn=db();
    $sql = "SELECT today_overused FROM v02_aims_ot_date WHERE id = '$id'";
    return $conn->query($sql)->fetch_object()->today_overused;
}

function v02createDateQuotaCutback($month_session_id, $new_date, $new_previous_overused){
    $today_overused = $new_previous_overused - 4;
    $today_overused = max($today_overused, 0);
    $conn=db();

    $sql_check_exist = "SELECT * FROM v02_aims_ot_date WHERE date = '$new_date' AND month_session_id = '$month_session_id' LIMIT 1";
    $check_exist = $conn->query($sql_check_exist);

    if(mysqli_num_rows($check_exist) < 1){
        $sql_insert = "INSERT INTO v02_aims_ot_date (month_session_id, date, previous_overused, total_overtime, today_overused) VALUES
                    ('$month_session_id', '$new_date', '$new_previous_overused', 0, '$today_overused')";
        return $conn->query($sql_insert);
    }else if (mysqli_num_rows($check_exist) > 0){
        while($row = $check_exist->fetch_assoc()){
            $date_id = $row['id'];
            $total_overtime = $row['total_overtime'];

            $new_today_overused = ($new_previous_overused+$total_overtime)-4;
            $new_today_overused = max($new_today_overused, 0);

            $sql_update = "UPDATE v02_aims_ot_date SET previous_overused = '$new_previous_overused',
                                total_overtime = '$total_overtime', today_overused = '$new_today_overused', updated_at = CURRENT_TIMESTAMP
                                WHERE id = '$date_id'";
            $conn->query($sql_update);
        }
        return true;
    }
    return false;
}


function v02getReviewBy($id){
    $conn=db();
    $sql="SELECT ot.review_by FROM v02_aims_ot ot
            LEFT JOIN v02_aims_ot_date otd ON otd.id = ot.ot_date_id
            WHERE otd.month_session_id = '$id' ORDER BY ot.id DESC LIMIT 1";
    $staff_id = $conn->query($sql)->fetch_object()->review_by;

    $sqlGetStaffName = "SELECT name FROM staff WHERE id = '$staff_id'";
    return $conn->query($sqlGetStaffName)->fetch_object()->name;
}

function getOtpApprovalFCMToken($staff_id){
    $conn=db();
    $sql="SELECT p.token FROM push_notification_token p WHERE p.staff_id = '$staff_id'";
    return $conn->query($sql)->fetch_object()->token;
}

function getOtApprovalFCMToken($otp_id){
    $conn=db();
    $sql="SELECT p.token FROM v02_aims_ot_permission otp
          JOIN push_notification_token p ON p.staff_id=otp.approval_id
          WHERE otp.id = '$otp_id'";
    return $conn->query($sql)->fetch_object()->token;
}

function getOtApplicantFCMToken($ot_id){
    $conn=db();
    $sql="SELECT p.token FROM v02_aims_ot ot
          LEFT JOIN v02_aims_ot_date otd ON ot.ot_date_id=otd.id
          LEFT JOIN v02_aims_ot_month_session otm
          ON otm.id=otd.month_session_id LEFT JOIN push_notification_token p
          ON p.staff_id=otm.staff_id WHERE ot.id='$ot_id'";
    return $conn->query($sql)->fetch_object()->token;
}

function getOtpApplicantFCMToken($otp_id){
    $conn=db();
    $sql="SELECT p.token FROM v02_aims_ot_permission otp
            LEFT JOIN push_notification_token p ON p.staff_id=otp.applicant_id
            WHERE otp.id='$otp_id'";
    return $conn->query($sql)->fetch_object()->token;
}

function getAGMAHODFCMToken(){
    $conn=db();
    $sql="SELECT p.token FROM staff s
          LEFT JOIN push_notification_token p ON s.id=p.staff_id 
          WHERE s.role_id='HOD' AND s.department_sub='OPERATION-AGMSB'";
    return $conn->query($sql)->fetch_object()->token;
}

/* ================= End Version 2 function list ================= */

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
