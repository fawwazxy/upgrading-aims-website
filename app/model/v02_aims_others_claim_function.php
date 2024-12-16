<?php
require '../../lib/db/connection.php';

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

function getStaffForm($staff_id){
    $conn=db();
    $sql = " SELECT ot.*,s.name,s.department_sub,s.department_id ,s.noic,sr.id AS st_record_id FROM staff s
			LEFT JOIN staff_record sr ON sr.no_staff= s.noic	
			LEFT JOIN aims_others_claim ot ON sr.id = ot.staff_record_id
			WHERE s.id= '$staff_id'";
    return $conn->query($sql);
}

function v02getStaffDetails($staff_id){
    $conn=db();
    $sql="SELECT name, no_staff, noic, department_sub, department_id, role_id FROM staff WHERE id = '$staff_id'";
    return $conn->query($sql);
}

/*Function used in v02_aims_others_claim_report*/
function v02getClaimDetailsByID($id){
    $conn=db();
    $sql="SELECT a.*, s.name, s.no_staff, s.noic, s.department_sub, s.department_id, s.role_id
            FROM v02_aims_others_claim a
            LEFT JOIN v02_aims_claim_cost_centre b ON b.claim_id = a.id
            LEFT JOIN v02_aims_cost_centre c ON c.id = b.company_cc_id
            LEFT JOIN aims_company d ON d.company_id = c.company_id
            LEFT JOIN staff s ON s.id= a.staff_id
            WHERE a.id = '$id'";
    return $conn->query($sql);
}

function getClaimListMobile($staff_id){
    $conn=db();
    $sql="SELECT * FROM v02_aims_others_claim WHERE staff_id = '$staff_id'";
    return $conn->query($sql);
}

function getRcaByClaimId($id){
    $conn=dbPms();
    $sql="SELECT rca_no FROM rca_form WHERE claim_id = '$id'";
    return $conn->query($sql);
}

function v02getDropDownMonthClaim($suggested_month_claim) {
    $month_array = array();

    for($i=0;$i<3;$i++){
        $generate_month = $suggested_month_claim.' '.$i.' months';
        array_push($month_array, date("Y-m", strtotime($generate_month)));
    }

    $txt_result="";
    foreach ($month_array as $month){
        $value = strtoupper(date("F Y", strtotime($month)));
        $txt_result .= "<option ".($suggested_month_claim == $month ? 'selected' : '')." value='".$value."'>".$value."</option>";
    }
    return $txt_result;
}

function v02getDropDownMonthClaimSelectedNew($month_claim){
    $month_array = array();
    $options = "";
    $base_month = date('Y').'-02';

    for($m=-3; $m<12; $m++) {
        $generate_month = date('F Y', strtotime($base_month.' +'.$m.' months'));
        array_push($month_array,$generate_month);
    }

    foreach ($month_array as $month) {
        $value = strtoupper($month);
        $result = ($month_claim == $value) ? 'selected' : '';
        $options .= '<option '.$result.' value="'.$value.'">'.$value.'</option>';
    }
    return $options;
}

function getCompanyDropdown($id, $mobile = false){
    $conn=db();
    $sql="SELECT id, code_department, description FROM department WHERE code_department NOT IN ('KTPSB')";
    $result = $conn->query($sql);
    if($mobile){
        return $result;
    }
    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $id ? 'selected':'')." value=\"".$row[0]."\">".$row[2]."</option>";
    }
    return $txt_result;
}

function getAllCompanyList($id, $mobile = false){
    $conn=db();
    $sql="SELECT id, code_department, description FROM department";
    $result = $conn->query($sql);
    if($mobile){
        return $result;
    }
    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $id ? 'selected':'')." value=\"".$row[0]."\">".$row[2]."</option>";
    }
    return $txt_result;
}

function v02addOthersClaim($staff_id, $datetime_departure, $datetime_arrival, $description, $job_no, $month_claim, $total_claim, $document_name, $document_size){
    $conn=db();
    if (in_array($staff_id, ['13','12'])){
        $sql_ceo = "INSERT INTO v02_aims_others_claim (staff_id, datetime_departure, datetime_arrival, description, job_no, month_claim, total_claim, document_name, document_size, created_at, updated_at,claim_status, payment_status, verify_by, verify_at, verify_status)
            VALUES ('$staff_id', '$datetime_departure', '$datetime_arrival', '$description', '$job_no', '$month_claim', '$total_claim', '$document_name', '$document_size', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 'OPEN', 'OPEN','AUTO VERIFIED',CURRENT_TIMESTAMP,'1')";
        $conn->query($sql_ceo);
    } else {
        $sql = "INSERT INTO v02_aims_others_claim (staff_id, datetime_departure, datetime_arrival, description, job_no, month_claim, total_claim, document_name, document_size, created_at, updated_at, claim_status ,payment_status)
            VALUES ('$staff_id', '$datetime_departure', '$datetime_arrival', '$description', '$job_no', '$month_claim', '$total_claim', '$document_name', '$document_size', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, 'OPEN','OPEN')";
        $conn->query($sql);
    }

    $claim_id = $conn->insert_id;

    $finance_use = $conn->query("INSERT INTO v02_aims_claim_finance_use(claim_id) value ('$claim_id')");

    if ($finance_use != '' && $finance_use > 0){
        return $claim_id;
    }
}

/*insert_id = multiple-row INSERT statement, it returns first automatically generated value that was successfully inserted*/
function v02addClaimCostCentre($cost_centre_id, $total, $claim_id){
    $conn=db();
    $sql="INSERT INTO v02_aims_claim_cost_centre (claim_id, company_cc_id, total,retrieve_claim_id, retrieve_total) VALUES ('$claim_id', '$cost_centre_id', '$total','$cost_centre_id','$total')";
    return $conn->query($sql);
}

//multiple retrieve - To Display within table
function v02OthersClaim($staff_id, $month, $year){
    $month_name = ($month == 0) ? "" : convertDigitToMonthName($month);
    $conn=db();
    $sql = "SELECT * FROM v02_aims_others_claim WHERE staff_id= '$staff_id' AND month_claim LIKE '%$month_name $year%'  ORDER BY id DESC ";
    return $conn->query($sql);
}

//single retrieve - to display single data (e.g. in modal)
function v02OthersClaimById($id){
    $conn=db();
    $sql = "SELECT * FROM v02_aims_others_claim WHERE id = '$id'";
    return $conn->query($sql);
}

function v02getTypeClaimByClaimId($id){
    $conn=db();
    $sql="SELECT cc.*, ac.cost_centre, ac.description as cc_description FROM v02_aims_claim_cost_centre cc
            LEFT JOIN v02_aims_cost_centre ac ON ac.id = cc.company_cc_id WHERE cc.claim_id = '$id'";
    return $conn->query($sql);
}

function v02getTypeClaimByRetrieveClaimId($id){
    $conn=db();
    $sql="SELECT cc.*, ac.cost_centre, ac.description as cc_description FROM v02_aims_claim_cost_centre cc
            LEFT JOIN v02_aims_cost_centre ac ON ac.id = cc.retrieve_claim_id WHERE cc.claim_id = '$id'";
    return $conn->query($sql);
}

function v02getTypeClaimById($id){
    $conn=db();
    $sql="SELECT cc.*, ac.id, ac.cost_centre, ac.description as cc_description FROM v02_aims_claim_cost_centre cc
            LEFT JOIN v02_aims_cost_centre ac ON ac.id = cc.company_cc_id WHERE cc.id = '$id'";
    return $conn->query($sql);
}

function v02getCostCentreInfoById($id){
    $conn=db();
    $sql="SELECT * FROM v02_aims_cost_centre WHERE id = '$id'";
    return $conn->query($sql);
}

function v02getDropdownCostCentreByCompany($id,$staff_id){
    $conn=db();
    $where_cost_centre = (in_array($staff_id, ['12','13'])) ? "" : "AND cost_centre NOT IN ('9010/170','9010/120','9010/078','9010/185','9010/237')";

    $sql="SELECT id, cost_centre, description, remarks FROM v02_aims_cost_centre 
            WHERE company_id = '$id' $where_cost_centre ORDER BY remarks, description";

    return $conn->query($sql);
}

function v02getDropdownCostCentreOpenByCompany($id){
    $conn=db();
    $sql="SELECT id, cost_centre, description, remarks FROM v02_aims_cost_centre 
            WHERE company_id = '$id'";
    return $conn->query($sql);
}

function getTypeClaimDescription($id){
    $conn=db();
    $sql="SELECT cost_centre, description FROM v02_aims_cost_centre WHERE id = '$id'";
    return $conn->query($sql);
}

function v02getAttachment($id){
    $conn=db();
    $sql="SELECT document_name FROM v02_aims_others_claim WHERE id='$id'";
    return $conn->query($sql)->fetch_object()->document_name;
}

function v02CompanyNameFromClaimId($id, $returnAsId = false){
    $conn=db();
    $sql = "SELECT d.id AS company_id, d.description
            FROM v02_aims_claim_cost_centre a
            LEFT JOIN v02_aims_cost_centre b ON b.id = a.company_cc_id
            LEFT JOIN department d ON d.id = b.company_id
            WHERE a.claim_id = '$id'";
    $result = $conn->query($sql)->fetch_object();
    return $returnAsId ? $result->company_id : $result->description;
}

function v02DeleteClaim($id){
    $conn=db();
    $sql = "DELETE FROM v02_aims_others_claim WHERE id = '$id'";
    return $conn->query($sql);
}

function v02deleteTypeClaimByClaimId($id){
    $conn=db();
    $sql="DELETE FROM v02_aims_claim_cost_centre WHERE claim_id = '$id'";
    return $conn->query($sql);
}

function v02getDocumentName($id){
    $conn=db();
    $sql="SELECT document_name FROM v02_aims_others_claim WHERE id = '$id'";
    return $conn->query($sql);
}

function v02DeleteListCostCentre($id){
    $conn=db();
    $sql="DELETE FROM v02_aims_claim_cost_centre WHERE id = '$id'";
    return $conn->query($sql);
}

function convertDigitToMonthName($number){
    $month = array(
        "1" => "January", "2" => "February","3" => "March", "4" => "April","5" => "May", "6" => "June",
        "7" => "July", "8" => "August","9" => "September", "10" => "October","11" => "November", "12" => "December",
    );
    return $month[$number];
}

/* Function update claim */
function v02getDetailClaim($id){
    $conn=db();
    $sql = "SELECT a.*, SUM(b.retrieve_total) AS retrieve, SUM(b.total) AS total, b.company_cc_id, b.retrieve_claim_id
            FROM v02_aims_others_claim a
            LEFT JOIN v02_aims_claim_cost_centre b ON b.claim_id = a.id
            LEFT JOIN v02_aims_cost_centre c ON c.id = b.company_cc_id
            LEFT JOIN aims_company d ON d.company_id = c.company_id
            WHERE a.id = '$id'";
    return $conn->query($sql);
}

//Claim List For HOD REVIEWED
function v02getMonthClaimListHOD($staff_id_verify, $verification, $month, $year){
    $month_name = ($month == 0) ? "" : convertDigitToMonthName($month);
    $conn=db();

    $ic_number_verify = $conn->query("SELECT noic FROM staff WHERE id = '$staff_id_verify'")->fetch_object()->noic;

    if ($staff_id_verify == '13'){ // CEO
        $custom_condition = "OR s.id = '224'"; // 224: Alias Zakaria
    } else if($staff_id_verify == '12'){ // EC
        $custom_condition = "AND s.id <> '224'";
    }else{
        $custom_condition = "";
    }

    if ($verification == 'PENDING'){
        $where_verify_status = "AND (oc.verify_by IS NULL AND oc.verify_status IS NULL)"; //pending
    } else if ($verification == 'VERIFIED'){
        $where_verify_status = "AND (oc.verify_by IS NOT NULL AND oc.verify_status = 1)"; //verified
    } else{
        $where_verify_status = "AND (oc.verify_by IS NOT NULL AND oc.verify_status <> 1)"; //rejected
    }

    $sql="SELECT s.name, s.noic, s.role_id, s.department_sub, s.department_id, oc.staff_id, oc.month_claim, oc.id FROM v02_aims_others_claim oc
            LEFT JOIN staff s ON s.id= oc.staff_id
            WHERE oc.staff_id<> '$staff_id_verify' AND (s.leave_approval = '$ic_number_verify' $custom_condition)
            $where_verify_status
            AND oc.month_claim LIKE '%$month_name $year%'
            GROUP BY staff_id, month_claim";
    return $conn->query($sql);
}

// Total Claim of staff_id--> HOD
function v02getCountTotalByStaff($staff_id, $month_claim){
    $conn=db();
    $sql="SELECT COUNT(id) AS total_count FROM v02_aims_others_claim
            WHERE staff_id= '$staff_id' AND month_claim = '$month_claim'";
    return $conn->query($sql)->fetch_object()->total_count;
}

// Claim HR Table List
function v02getMonthClaimListHR($department_code, $verification,$claim_status, $month, $year){
    //set where month if parameter contain month number
    $month_name = ($month == 0) ? "" : convertDigitToMonthName($month);
    if ($verification == 'PENDING'){
        $where_review_status = "AND (oc.review_by IS NULL AND oc.review_status IS NULL)"; //pending
    }else if ($verification == 'REVIEWED'){
        $where_review_status = "AND (oc.review_by IS NOT NULL AND oc.review_status = 1)"; //verified
    }else {
        $where_review_status = "AND (oc.review_by IS NOT NULL AND oc.review_status <> 1)"; //rejected
    }
    $conn=db();
    $sql="SELECT s.name, s.noic, s.role_id, s.department_sub, s.department_id, oc.staff_id, oc.month_claim, oc.id, d.code_department, oc.payment_status, oc.tracking_no, oc.finance_remarks, oc.review_status
            FROM v02_aims_others_claim oc
            LEFT JOIN v02_aims_claim_cost_centre cc ON cc.claim_id = oc.id
            LEFT JOIN v02_aims_cost_centre ac ON ac.id = cc.company_cc_id
            LEFT JOIN department d ON d.id = ac.company_id
            LEFT JOIN staff s ON s.id = oc.staff_id
            LEFT JOIN v02_aims_claim_finance_use v02acfu ON v02acfu.claim_id = oc.id
            WHERE d.code_department LIKE '%$department_code%'
            AND (oc.verify_by IS NOT NULL AND oc.verify_status = 1)
            $where_review_status
            AND oc.month_claim LIKE '%$month_name $year%'
            AND oc.claim_status = '$claim_status'
            GROUP BY staff_id,code_department, month_claim";
    return $conn->query($sql);
}

// Claim Finance Table List
function v02getMonthClaimListFinance($department_code, $verification, $payment_status, $month, $year){
    //set where month if parameter contain month number
    $month_name = ($month == 0) ? "" : convertDigitToMonthName($month);
    if ($verification == 'UNCHECKED'){
        $where_check_status = "AND (oc.finance_by IS NULL AND oc.finance_status IS NULL OR oc.finance_status = 0)"; //unchecked
    }else if ($verification == 'CHECKED'){
        $where_check_status = "AND (oc.finance_by IS NOT NULL AND oc.finance_status = 1)"; //checked
    }else {
        $where_check_status = "AND (oc.finance_by IS NOT NULL AND oc.finance_status = 1 AND oc.payment_at IS NOT NULL AND oc.payment_status = 'CLOSED')"; //closed
    }
    $conn=db();
    $sql="SELECT s.name, s.noic, s.role_id, s.department_sub, s.department_id, oc.staff_id, oc.month_claim, oc.id, d.code_department
            FROM v02_aims_others_claim oc
            LEFT JOIN v02_aims_claim_cost_centre cc ON cc.claim_id = oc.id
            LEFT JOIN v02_aims_cost_centre ac ON ac.id = cc.company_cc_id
            LEFT JOIN department d ON d.id = ac.company_id
            LEFT JOIN staff s ON s.id= oc.staff_id
            WHERE d.code_department LIKE '%$department_code%'
            AND oc.verify_status = 1 AND oc.review_status = 1
            $where_check_status 
            AND oc.payment_status = '$payment_status'
            AND oc.month_claim LIKE '%$month_name $year%'
            GROUP BY staff_id, month_claim";
    return $conn->query($sql);
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
    for ($i=-1; $i<3; $i++){
        $year = $yearNow - $i;
        $opt_selected = ($year == $selected) ? 'selected' : '';
        $year_option.= "<option value='".$year."' ".$opt_selected.">".$year."</option>";
    }
    return $year_option;
}

//Claim CEO Table List
function v02getMonthClaimListCEO($department_code, $staff_id_verify, $verification, $month, $year){
    //set where month if parameter contain month number
    $month_name = ($month == 0) ? "" : convertDigitToMonthName($month);
    if ($verification == 'PENDING'){
        $where_approve_status = "AND (oc.approve_by IS NULL AND oc.approve_status IS NULL)"; //pending
    }else if ($verification == 'APPROVED'){
        $where_approve_status = "AND (oc.approve_by IS NOT NULL AND oc.approve_status = 1)"; //verified
    }else{
        $where_approve_status = "AND (oc.approve_by IS NOT NULL AND oc.approve_status <> 1)"; //rejected
    }

    //set custom condition for logged in user
    if ($staff_id_verify == '13'){ // CEO account
        $custom_condition = "AND (s.role_id NOT IN ('HOD','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR','MANAGER') AND s.id NOT IN ('812','224'))"; // Yumni & Alias Zakaria
    }else if($staff_id_verify == '12'){ // Chairman account
        $custom_condition = "AND (s.role_id IN ('FOUNDER','HOD','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO') OR s.id IN ('812','224'))"; // Yumni & Alias Zakaria
    }else{
        $custom_condition = "";
    }
    $conn=db();
    $sql="SELECT s.name, s.noic, s.role_id, s.department_sub, s.department_id, oc.staff_id, oc.month_claim, oc.id, SUM(oc.total_claim) as total
            FROM v02_aims_others_claim oc
            LEFT JOIN staff s ON s.id= oc.staff_id
            WHERE (SELECT count(id) as claim_count FROM v02_aims_others_claim WHERE
                    oc.verify_by IS NOT NULL AND oc.verify_status = '1'
                    AND oc.review_by IS NOT NULL AND oc.review_status = '1'
                    AND oc.finance_by IS NOT NULL AND oc.finance_status = '1'
                    $where_approve_status ) > 0
            AND s.department_id LIKE '%$department_code%'
            AND oc.staff_id <> '$staff_id_verify'
            $custom_condition
            AND oc.month_claim LIKE '%$month_name $year%'
            GROUP BY staff_id, month_claim";
    return $conn->query($sql);
}

function v02getClaimListByStaff($staff_id, $month_claim, $verification){
    if ($verification == 'PENDING'){
        $where_verify_status = "AND (verify_by IS NULL AND verify_status IS NULL)"; //pending
    }else if ($verification == 'VERIFIED'){
        $where_verify_status = "AND (verify_by IS NOT NULL AND verify_status = 1)"; //verified
    }else{
        $where_verify_status = "AND (verify_by IS NOT NULL AND verify_status <> 1)"; //rejected
    }
    $conn=db();
    $sql = "SELECT COUNT(id) as count_status FROM v02_aims_others_claim 
            WHERE staff_id= '$staff_id' AND month_claim = '$month_claim'
            $where_verify_status
            ORDER BY created_at DESC LIMIT 1";
    return $conn->query($sql)->fetch_object()->count_status;
}

/*Used in HOD Approval page*/
function v02getDetailStaff($staff_id,$month_claim,$verification){
    if ($verification == 'PENDING'){
        $where_verify_status = "AND (verify_by IS NULL AND verify_status IS NULL)"; //pending
    }else if ($verification == 'VERIFIED'){
        $where_verify_status = "AND (verify_by IS NOT NULL AND verify_status = 1)"; //verified
    }else{
        $where_verify_status = "AND (verify_by IS NOT NULL AND verify_status <> 1)"; //unverified
    }
    $conn=db();
    $sql = "SELECT a.*, e.no_staff, e.noic, e.name, e.department_sub, e.department_id
            FROM v02_aims_others_claim a
            LEFT JOIN staff e ON e.id= a.staff_id
            WHERE a.staff_id= '$staff_id' AND a.month_claim = '$month_claim'
            $where_verify_status
            ORDER BY a.id";
    return $conn->query($sql);
}

/*Used in HR Approval page*/
function v02getDetailStaffHR($department_code,$staff_id,$month_claim,$verification,$claim_status){
    if ($verification == 'PENDING'){
        $where_review_status = "AND (a.review_by IS NULL AND a.review_status IS NULL)"; //pending
    }else if ($verification == 'REVIEWED'){
        $where_review_status = "AND (a.review_by IS NOT NULL AND a.review_status = 1)"; //reviewed
    }else{
        $where_review_status = "AND (a.review_by IS NOT NULL AND a.review_status <> 1)"; //disapproved
    }
    $conn=db();
    $sql = "SELECT DISTINCT a.*, s.no_staff, s.noic, s.name, s.department_sub, s.department_id, a.review_status, a.finance_remarks
            FROM v02_aims_others_claim a
            LEFT JOIN v02_aims_claim_cost_centre cc ON cc.claim_id = a.id
            LEFT JOIN v02_aims_cost_centre ac ON ac.id = cc.company_cc_id
            LEFT JOIN department d ON d.id = ac.company_id
            LEFT JOIN staff s ON s.id= a.staff_id
            WHERE d.code_department LIKE '%$department_code%'
            AND a.staff_id= '$staff_id' AND a.month_claim = '$month_claim' AND a.claim_status = '$claim_status' 
            AND a.verify_at IS NOT NULL AND a.verify_status = '1'
            $where_review_status
            ORDER BY a.id";
    return $conn->query($sql);
}

/*Used in CEO Approval page*/
function v02getClaimDetailByStaffCeo($staff_id, $month_claim, $verification){
    if ($verification == 'PENDING'){
        $where_approve_status = "AND (a.approve_by IS NULL AND a.approve_status IS NULL)"; //pending
    }else if ($verification == 'APPROVED'){
        $where_approve_status = "AND (a.approve_by IS NOT NULL AND a.approve_status = 1)"; //verified
    }else{
        $where_approve_status = "AND (a.approve_by IS NOT NULL AND a.approve_status <> 1)"; //rejected
    }
    $conn=db();
    $sql = "SELECT a.*, e.no_staff, e.noic, e.name, e.department_sub, e.department_id
            FROM v02_aims_others_claim a
            LEFT JOIN staff e ON e.id= a.staff_id
            WHERE a.staff_id= '$staff_id' AND a.month_claim = '$month_claim'
            AND a.verify_at IS NOT NULL AND a.verify_status = '1'
            AND a.review_by IS NOT NULL AND a.review_status = '1'
            AND a.finance_by IS NOT NULL AND a.finance_status = '1'
            $where_approve_status
            ORDER BY a.id";
    return $conn->query($sql);
}

/*Used in Finance Approval page*/
function v02getDetailStaffFinance($staff_id,$month_claim,$verification,$payment_status,$department_code){
    if ($verification == 'UNCHECKED'){
        $where_check_status = "AND (a.finance_by IS NULL AND a.finance_status IS NULL OR a.finance_status = 0)"; //unchecked
    }else if ($verification == 'CHECKED'){
        $where_check_status = "AND (a.finance_by IS NOT NULL AND a.finance_status = 1)"; //checked
    }else {
        $where_check_status = "AND (a.finance_by IS NOT NULL AND a.finance_status = 1 AND a.payment_at IS NOT NULL AND a.payment_status = 'CLOSED')"; //closed
    }
    $conn=db();
    $sql = "SELECT DISTINCT a.*, e.no_staff, e.noic, e.name, e.department_sub, e.department_id, a.tracking_no
            FROM v02_aims_others_claim a
            LEFT JOIN staff e ON e.id= a.staff_id
            LEFT JOIN v02_aims_claim_cost_centre cc ON cc.claim_id = a.id
            LEFT JOIN v02_aims_cost_centre cost ON cost.id = cc.company_cc_id
            LEFT JOIN department d ON d.id = cost.company_id
            LEFT JOIN v02_aims_claim_finance_use fu ON fu.claim_id = a.id 
            WHERE a.staff_id= '$staff_id' AND a.month_claim = '$month_claim' AND a.payment_status = '$payment_status' AND d.code_department LIKE '%$department_code%'
            AND a.verify_at IS NOT NULL AND a.verify_status = '1'
            AND a.review_at IS NOT NULL AND a.review_status = '1'
            $where_check_status
            ORDER BY a.id";
    return $conn->query($sql);
}

/* Function Verify HOD */
function v02OthersClaimVerify($id, $verification_by,$verification_status){
    $conn = db();
    $sql = "UPDATE v02_aims_others_claim SET verify_by = '$verification_by', verify_at = CURRENT_TIMESTAMP,
                verify_status = '$verification_status' WHERE id IN $id";
    return $conn->query($sql);
}

//Function Review HR
function v02OthersClaimReview($id, $verification_by,$verification_status){
    $conn = db();
    $sql = "UPDATE v02_aims_others_claim
    SET review_by = '$verification_by',
    review_at = CURRENT_TIMESTAMP,
    review_status = '$verification_status'
    WHERE id IN $id";
    return $conn->query($sql);
}

//Function Approved / Disapproved CEO
function v02OthersClaimApproved($id, $verification_by,$verification_status){
    $conn = db();
    $sql = "UPDATE v02_aims_others_claim
    SET approve_by = '$verification_by',
    approve_at = CURRENT_TIMESTAMP,
    approve_status = '$verification_status'
    WHERE id IN $id";
    return $conn->query($sql);
}

/*Created at 08012023*/
function v02getOthersClaimID($staff_id, $month){
    $conn = db();
    $sql = "SELECT id FROM v02_aims_others_claim 
            WHERE staff_id= '$staff_id' AND month_claim LIKE '%$month%'
              AND finance_status = '1' AND verify_status = '1' AND review_status = '1'";
    $result = $conn->query($sql);

    $id_array = array();
    while ($row = $result->fetch_array()){
        array_push($id_array, $row[0]);
    }

    return "'".implode("','", $id_array)."'";
}

function v02getOthersClaimIDVerify($staff_id, $month){
    $conn = db();
    $sql = "SELECT id FROM v02_aims_others_claim 
            WHERE staff_id= '$staff_id' AND month_claim LIKE '%$month%'";
    $result = $conn->query($sql);
    $id_array = array();
    while ($row = $result->fetch_array()){
        array_push($id_array, $row[0]);
    }
    return "'".implode("','", $id_array)."'";
}

/*Used in Checked / Unchecked Status Finance*/
function v02OthersClaimCheck($id, $verification_by,$verification_status){
    $conn = db();
    $sql = "UPDATE v02_aims_others_claim
    SET finance_by = '$verification_by',
    finance_at = CURRENT_TIMESTAMP,
    finance_status = '$verification_status'
    WHERE id IN $id";
    return $conn->query($sql);
}
function v02OthersClaimCheckUpdate($id, $verification_by,$verification_status){
    $conn = db();
    $sql = "UPDATE v02_aims_others_claim
    SET finance_by = '$verification_by',
    finance_at = CURRENT_TIMESTAMP,
    finance_status = '$verification_status'
    WHERE id = '$id'";
    return $conn->query($sql);
}

/*HR LIST TABLE --> HR STATUS*/
function v02getClaimListHR($department_code, $staff_id, $month_claim, $verification, $closedOnly = false){
    $where_closed = $closedOnly ? "AND a.claim_status = 'CLOSED'" : "";

    if ($verification == 'PENDING'){
        $where_review_status = "AND (review_by IS NULL AND review_status IS NULL)"; //pending
    }else if ($verification == 'REVIEWED'){
        $where_review_status = "AND (review_by IS NOT NULL AND review_status = 1)"; //verified
    }else{
        $where_review_status = "AND (review_by IS NOT NULL AND review_status <> 1)"; //unverified
    }
    $conn=db();
    $sql = "SELECT claim_status, COUNT(DISTINCT(a.id)) AS count
            FROM v02_aims_others_claim a
            LEFT JOIN v02_aims_claim_cost_centre cc ON cc.claim_id = a.id
            LEFT JOIN v02_aims_cost_centre ac ON ac.id = cc.company_cc_id
            LEFT JOIN department d ON d.id = ac.company_id
            WHERE d.code_department LIKE '%$department_code%'
            AND a.staff_id= '$staff_id' AND a.month_claim = '$month_claim' $where_closed
            AND a.verify_at IS NOT NULL AND a.verify_status = '1'
            $where_review_status GROUP BY claim_status";
    $result = $conn->query($sql);
    $claim_count = [
        'OPEN' => 0,
        'CLOSED' => 0
    ];

    while ($row = $result->fetch_assoc()){
        $claim_count[$row['claim_status']] = $row['count'];
    }
    return $claim_count;
}

/*HR LIST TABLE --> CEO STATUS*/
function v02getClaimListCEO($staff_id, $month_claim){
    $conn=db();
    $sql = "SELECT approve_status, count(id) as ceo_count FROM v02_aims_others_claim 
            WHERE staff_id= '$staff_id' AND month_claim = '$month_claim'
						GROUP BY approve_status";
    $result = $conn->query($sql);

    $ceo_count = [
        'pending' => 0,
        'approved' => 0,
        'rejected' => 0,
    ];
    while ($row = $result->fetch_assoc()){
        if($row['approve_status'] == ''){
            $ceo_count['pending'] = $row['ceo_count'];
        }else if($row['approve_status'] == '1'){
            $ceo_count['approved'] = $row['ceo_count'];
        }else if($row['approve_status'] == '0'){
            $ceo_count['rejected'] = $row['ceo_count'];
        }
    }
    return $ceo_count;
}

/*HR LIST TABLE --> CEO STATUS*/
function v02claimListCeoVerification($staff_id, $month_claim, $verification){
    if ($verification == 'PENDING'){
        $where_approve_status = "AND (approve_by IS NULL AND approve_status IS NULL)"; //pending
    }else if ($verification == 'APPROVED'){
        $where_approve_status = "AND (approve_by IS NOT NULL AND approve_status = 1)"; //approved
    }else{
        $where_approve_status = "AND (approve_by IS NOT NULL AND approve_status <> 1)"; //disapproved
    }

    $conn=db();
    $sql = "SELECT count(id) as ceo_count FROM v02_aims_others_claim 
            WHERE staff_id= '$staff_id' AND month_claim = '$month_claim'
            AND verify_by IS NOT NULL AND verify_status = '1' 
            AND review_by IS NOT NULL AND review_status = '1'
            AND finance_by IS NOT NULL AND finance_status = '1'
            $where_approve_status";
    return $conn->query($sql)->fetch_object()->ceo_count;
}

/*Used in CEO -> HR Verification*/
function v02HrGetClaimListCEOHOD($staff_id, $month_claim, $verification){
    if ($verification == 'PENDING'){
        $where_approve_status = "AND (verify_by IS NULL AND verify_status IS NULL)"; //pending
    }else if ($verification == 'VERIFIED'){
        $where_approve_status = "AND (verify_by IS NOT NULL AND verify_status = 1)"; //approved
    }else{
        $where_approve_status = "AND (verify_by IS NOT NULL AND verify_status <> 1)"; //disapproved
    }

    $conn=db();
    $sql = "SELECT count(id) as ceo_hod_count FROM v02_aims_others_claim 
            WHERE staff_id= '$staff_id' AND month_claim = '$month_claim'
            $where_approve_status";
    return $conn->query($sql)->fetch_object()->ceo_hod_count;
}

/*Used in HR Table List -> Count by status*/
function v02getClaimListHrFinance($staff_id, $month_claim){

    $conn=db();
    $sql = "SELECT finance_status, payment_status, count(id) as finance_count FROM v02_aims_others_claim 
            WHERE staff_id= '$staff_id' AND month_claim = '$month_claim'
            AND verify_by IS NOT NULL AND verify_status = '1' 
            AND review_by IS NOT NULL AND review_status = '1'
						GROUP BY finance_status, payment_status";
    $result = $conn->query($sql);

    $finance_count = [
        'pending' => 0,
        'checked' => 0,
        'closed' => 0
    ];

    while ($row = $result->fetch_assoc()){
        if(in_array($row['finance_status'], ['','0'])){
            $finance_count['pending'] += $row['finance_count'];
        }else if($row['finance_status'] == '1'){
            if($row['payment_status'] == 'OPEN'){
                $finance_count['checked'] = $row['finance_count'];
            }else{
                $finance_count['closed'] = $row['finance_count'];
            }
        }
    }

    return $finance_count;
}
/*Used in Finance Table List -> Count by status*/
function v02getClaimListFinance($staff_id, $month_claim, $verification, $payment_status, $department_code){
    if ($verification == 'UNCHECKED'){
        $where_check_status = "AND (oc.finance_by IS NULL AND oc.finance_status IS NULL OR oc.finance_status = 0)"; //pending
    }else if ($verification == 'CHECKED'){
        $where_check_status = "AND (oc.finance_by IS NOT NULL AND oc.finance_status = 1)"; //checked
    }else{
        $where_check_status = "AND (oc.finance_status = 1 AND oc.payment_status = 'CLOSED')"; //unchecked
    }
    $conn=db();
    /*$sql = "SELECT count(id) as finance_count FROM v02_aims_others_claim
            WHERE staff_id= '$staff_id' AND month_claim = '$month_claim'
            AND verify_by IS NOT NULL AND verify_status = '1' 
            AND review_by IS NOT NULL AND review_status = '1'
            $where_check_status
            AND payment_status = '$payment_status'";
    return $conn->query($sql)->fetch_object()->finance_count;*/
    $sql = "SELECT DISTINCT oc.* FROM v02_aims_others_claim oc
            LEFT JOIN v02_aims_claim_cost_centre cc ON cc.claim_id = oc.id
            LEFT JOIN v02_aims_cost_centre cost ON cost.id = cc.company_cc_id
            LEFT JOIN department d ON d.id = cost.company_id
            WHERE oc.staff_id= '$staff_id' AND oc.month_claim = '$month_claim' AND d.code_department LIKE '%$department_code%'
            AND oc.verify_by IS NOT NULL AND oc.verify_status = '1' 
            AND oc.review_by IS NOT NULL AND oc.review_status = '1'
            $where_check_status AND oc.payment_status = '$payment_status'";
    $result = $conn->query($sql);
    return mysqli_num_rows($result);
}

/*Used in Finance Table List -> Count by status*/
function v02getClaimListPayment($staff_id, $month_claim, $verification, $payment_status){
    if ($verification == 'UNCHECKED'){
        $where_check_status = "AND (finance_by IS NULL AND finance_status IS NULL)"; //unchecked
    }else if ($verification == 'CHECKED'){
        $where_check_status = "AND (finance_by IS NOT NULL AND finance_status = 1)"; //checked
    }else{
        $where_check_status = "AND (finance_by IS NOT NULL AND finance_status = 1 AND payment_status = 'CLOSED')"; //closed
    }
    $conn=db();
    $sql = "SELECT count(id) as payment_count FROM v02_aims_others_claim 
            WHERE staff_id= '$staff_id' AND month_claim = '$month_claim'
            AND verify_by IS NOT NULL AND verify_status = '1' 
            AND review_by IS NOT NULL AND review_status = '1'
            $where_check_status
            AND payment_status = '$payment_status'";
    return $conn->query($sql)->fetch_object()->payment_count;
}

/*Used in HR page -> Button Closed Claim Status*/
function v02closeOrOpenClaim($id, $closed_by, $action){
    $conn=db();
    $sql = "UPDATE v02_aims_others_claim SET claim_status = '$action', claim_at = CURRENT_TIMESTAMP,
                claim_by = '$closed_by' WHERE id = '$id'";
    return $conn->query($sql) or die($conn->error);
}

/*Used in HR page -> Button Open Claim Status*/
function v02closeOtherOpenClaim($id){
    $conn=db();
    $sql = "UPDATE v02_aims_others_claim
            SET
                claim_status = 'OPEN',
                claim_at = NULL
            WHERE id = '$id'
            AND verify_by IS NOT NULL AND verify_status = '1'
            AND review_by IS NOT NULL AND review_status = '1'";
    return $conn->query($sql) or die($conn->error);
}

/*Used in Finance page -> Button Closed Payment Status*/
/*Fixed : 11012023 -> Add tracking no */
function v02closeOtherClosedPayment($claim_id,$auth_id){
    $conn=db();
    $sql = "UPDATE v02_aims_others_claim
            SET
                payment_status = 'CLOSED',
                payment_at = CURRENT_TIMESTAMP,
                payment_by = '$auth_id'
            WHERE id = '$claim_id'
            AND verify_by IS NOT NULL AND verify_status = '1'
            AND review_by IS NOT NULL AND review_status = '1'
            AND finance_by IS NOT NULL AND finance_status = '1'";
    return $conn->query($sql) or die($conn->error);
}

function v02trackingNo($claim_id,$tracking_no){
    $conn=db();
    $sql = "UPDATE v02_aims_claim_finance_use SET tracking_no = '$tracking_no' WHERE claim_id = '$claim_id'";
    return $conn->query($sql) or die($conn->error);
}

function v02TrackingNoByClaimId($id){
    $conn=db();
    $sql = "SELECT tracking_no FROM v02_aims_claim_finance_use WHERE claim_id = '$id'";
    return $conn->query($sql)->fetch_object()->tracking_no;
}

/*Used in Finance page -> Button Open Payment Status*/
function v02closeOtherOpenPayment($id){
    $conn=db();
    $sql = "UPDATE v02_aims_others_claim
            SET
                payment_status = 'OPEN',
                payment_at = NULL
            WHERE id = '$id'
            AND verify_by IS NOT NULL AND verify_status = '1'
            AND review_by IS NOT NULL AND review_status = '1'
            AND finance_by IS NOT NULL AND finance_status = '1'";
    return $conn->query($sql) or die($conn->error);
}

/*User Cost Centre Modal Update*/
function v02updateOthersClaimCostCentre($claim_id, $detail_claim, $rm_input){
    $conn=db();
    $sql = "UPDATE v02_aims_claim_cost_centre SET company_cc_id = '$detail_claim', total = '$rm_input',
                retrieve_claim_id = '$detail_claim', retrieve_total = '$rm_input' WHERE id = '$claim_id'";
    return $conn->query($sql);
}

function v02updateOthersHRClaimModal($claim_id, $detail_claim, $rm_input){
    $conn=db();
    $sql = "UPDATE v02_aims_claim_cost_centre 
            SET 
                company_cc_id = '$detail_claim',
                total = '$rm_input'
            WHERE id = '$claim_id'";
    return $conn->query($sql) or die($conn->error);
}

/*User Update*/
function v02updateOthersClaim($id,$job_no,$datetime_departure,$datetime_arrival,$month_claim,$description, $hr_auth_id = null){
    $custom_condition = $hr_auth_id ? ", hr_updated_at = CURRENT_TIMESTAMP, hr_updated_by = '$hr_auth_id'" : ", updated_at = CURRENT_TIMESTAMP";
    $conn = db();
    $sql = "UPDATE v02_aims_others_claim
            SET 
                job_no = '$job_no',
                datetime_departure = '$datetime_departure',
                datetime_arrival = '$datetime_arrival',
                month_claim = '$month_claim',
                description = '$description'
                $custom_condition
            WHERE id = '$id'";
    return $conn->query($sql) or die($conn->error);
}

/*Finance Update*/
function v02FinanceUpdateOthersClaim($id,$updated_by,$job_no){
    $conn = db();
    $sql = "UPDATE v02_aims_others_claim SET job_no = '$job_no', finance_updated_at = CURRENT_TIMESTAMP,
                finance_updated_by = '$updated_by' WHERE id = '$id'";
    return $conn->query($sql);
}

/*Get Sum new total after cost centre update*/
function v02getNewTotal($claim_id){
    $conn=db();
    $sql="SELECT SUM(total) as total_claim FROM v02_aims_claim_cost_centre WHERE claim_id = '$claim_id'";
    return $conn->query($sql)->fetch_object()->total_claim;
}

/*Update new sum cost centre*/
function v02updateNewTotal($claim_id, $new_total_claim){
    $conn=db();
    $sql="UPDATE v02_aims_others_claim SET total_claim = '$new_total_claim' WHERE id = '$claim_id'";
    return $conn->query($sql);
}

/*Get Staff Name by no_staff*/
function v02getStaffName($staff_id){
    $conn=db();
    $sql = "SELECT name FROM staff WHERE id = '$staff_id'";
    return $conn->query($sql)->fetch_object()->name;
}

/*HR page -> Add Remarks*/
function v02addOthersClaimRemarks($id, $remarks){
    $conn=db();
    $sql = "UPDATE v02_aims_others_claim SET remarks = '$remarks' WHERE id = '$id'";
    return $conn->query($sql);
}

/*Used to update/delete remarks -> HR page*/
function v02DeleteOthersClaimRemarks($id){
    $conn=db();
    $sql = "UPDATE v02_aims_others_claim SET remarks = NULL WHERE id = '$id'";
    return $conn->query($sql);
}

/*Used in CEO / CHAIRMAN page - Find job position by id*/
function v02getIC($id){
    $conn=db();
    $sql = "SELECT noic FROM staff WHERE id = '$id'";
    return $conn->query($sql);
}

function v02FinanceUse($id,$advance,$refund,$outstanding){
    $conn=db();
    $sql = "UPDATE v02_aims_claim_finance_use SET advance =  '$advance', refund = '$refund', outstanding = '$outstanding',
            created_at = CURRENT_TIMESTAMP WHERE claim_id = '$id'";
    return $conn->query($sql);
}

function v02getFinanceUse($id){
    $conn=db();
    $sql="SELECT * FROM v02_aims_claim_finance_use WHERE claim_id = '$id'";
    return $conn->query($sql);
}

function v02addFinanceClaimId($insert_claim){
    $conn=db();
    $sql="INSERT INTO v02_aims_claim_finance_use(claim_id) value ('$insert_claim')";
    return $conn->query($sql);
}

function v02financeUseByClaimId($id){
    $conn=db();
    $sql="DELETE FROM v02_aims_claim_finance_use WHERE claim_id = '$id'";
    return $conn->query($sql);
}

/*new update 14112022*/
function v02updateAttachment($id,$document_name,$document_size){
    $conn=db();
    $sql="UPDATE v02_aims_others_claim SET document_name='$document_name', document_size='$document_size' WHERE id='$id'";
    return $conn->query($sql);
}

function v02updateOthersFinanceClaimModal($claim_id, $detail_claim){
    $conn=db();
    $sql = "UPDATE v02_aims_claim_cost_centre 
            SET 
                company_cc_id = '$detail_claim'
            WHERE id = '$claim_id'";
    return $conn->query($sql) or die($conn->error);
}

/* Function -> Listing Cost Centre */
function v02getCostCentreList($department_code){
    $conn=db();
    $sql = "SELECT c.*, d.description AS company_name FROM v02_aims_cost_centre c
            LEFT JOIN department d ON d.id = c.company_id
            WHERE d.code_department LIKE '%$department_code%'
            ORDER BY c.id DESC";
    return $conn->query($sql);
}

/* Function -> Add Cost Centre */
function v02addCostCentre($cost_centre, $company_name, $type_claim, $description){
    $conn=db();
    $sql = "INSERT INTO v02_aims_cost_centre(cost_centre, description, company_id, remarks) VALUES ('$cost_centre', '$type_claim', '$company_name', '$description')";
    return $conn->query($sql);
}

/*Function -> Listing Cost Centre by ID*/
function v02getCostCentreById($id){
    $conn=db();
    $sql = "SELECT c.*, d.description AS company_name FROM v02_aims_cost_centre c
            LEFT JOIN department d ON d.id = c.company_id
            WHERE c.id = '$id'";
    return $conn->query($sql);
}

/*Function -> Update Cost Centre*/
function v02updateCostCentre($id, $cost_centre, $company_name, $type_claim, $description){
    $conn=db();
    $sql = "UPDATE v02_aims_cost_centre SET cost_centre = '$cost_centre', description = '$type_claim', company_id = '$company_name', remarks = '$description' WHERE id = '$id'";
    return $conn->query($sql);
}

/*Function -> Delete Cost Centre (Finance)*/
function v02DeleteCostCentre($id){
    $conn=db();
    $sql = "DELETE FROM v02_aims_cost_centre WHERE id = '$id'";
    return $conn->query($sql);
}

/*Created at : 28/12/2023*/
function v02addOthersHRClaimModal($claim_id, $cost_centre_id, $rm_input, $isHumanResources = true){
    $retrieve_cost_centre_id = $isHumanResources ? NULL : $cost_centre_id;
    $retrieve_rm_input = $isHumanResources ? NULL : $rm_input;

    $conn=db();
    $sql="INSERT INTO v02_aims_claim_cost_centre (claim_id, company_cc_id, total,retrieve_claim_id, retrieve_total)
            VALUES ('$claim_id', '$cost_centre_id', '$rm_input', '$retrieve_cost_centre_id', '$retrieve_rm_input')";
    return $conn->query($sql);
}

function v02getCompanyId($desc){
    $conn=db();
    $sql = "SELECT id FROM department WHERE description='$desc' ";
    return $conn->query($sql)->fetch_object()->id;
}

/*function v02getTrackingNoByClaimId($staff_id,$month_claim){
    $conn=db();
    $sql = "SELECT id, month_claim, description, total_claim, tracking_no FROM v02_aims_others_claim
            WHERE staff_id= '$staff_id' AND month_claim LIKE '%$month_claim%' 
            AND payment_status = 'CLOSED'";
    return $conn->query($sql);
}*/

function financeReturnRemarks($claim_id,$reason){
    $conn=db();
    $sql = "UPDATE v02_aims_others_claim SET finance_remarks = '$reason', review_status = NULL, review_at = NULL, review_by = NULL WHERE id = '$claim_id'";
    return $conn->query($sql);
}

// ANALYSIS
function getTotalClaim($year,$type,$status){

    if ($type == 'ceo'){
        $attr = "AND approve_status = '$status'";
    } elseif ($type == 'hod'){
        $attr = "AND verify_status = '$status'";
    } elseif ($type == 'hr'){
        $attr = "AND review_status = '$status'";
    } elseif ($type == 'finance'){
        $attr = "AND finance_status = '$status'";
    } else {
        $attr = "";
    }

    $conn=db();
    $sql = "SELECT COUNT(id) AS total_claim FROM v02_aims_others_claim WHERE month_claim LIKE '%$year' $attr";
    return $conn->query($sql)->fetch_object()->total_claim;
}

function getTotalAmount($year,$type){
    $attr = ($type == "paid")? "AND payment_status = 'CLOSED'":"";
    $conn=db();
    $sql = "SELECT SUM(total_claim) AS sum_claim FROM v02_aims_others_claim WHERE month_claim LIKE '%$year' $attr";
    return $conn->query($sql)->fetch_object()->sum_claim;
}

function getCountByMonth($year, $month, $type){
    if ($type == "request"){
        $attr = 'id';
        $command = 'COUNT';
    } else {
        $attr = 'total_claim';
        $command = 'SUM';
    }
    $conn=db();
    $sql = "SELECT $command($attr) AS monthly_claim FROM v02_aims_others_claim WHERE month_claim LIKE '%$month $year%'";
    return $conn->query($sql)->fetch_object()->monthly_claim;
}

function getCompany(){
    $conn = db();
    $sql = "SELECT id, code_department FROM department";
    return $conn->query($sql);
}

function getTotalCompanyClaim($company_id, $year){
    $conn = db();
    $sql = "SELECT DISTINCT(v02aoc.id) FROM v02_aims_others_claim v02aoc
            LEFT JOIN v02_aims_claim_cost_centre v02accc on v02aoc.id = v02accc.claim_id
            LEFT JOIN v02_aims_cost_centre v02acc on v02accc.company_cc_id = v02acc.id
            WHERE v02acc.company_id = '$company_id' AND v02aoc.month_claim LIKE '%$year%'";
    return $conn->query($sql)->num_rows;
}

function getAmountCompanyClaim($company_id, $year){
    $conn = db();
    $temp_array = array();

    $get_claim = "SELECT DISTINCT v02aoc.* FROM v02_aims_others_claim v02aoc
                LEFT JOIN v02_aims_claim_cost_centre v02accc on v02aoc.id = v02accc.claim_id
                LEFT JOIN v02_aims_cost_centre v02acc on v02accc.company_cc_id = v02acc.id
                WHERE v02acc.company_id = '$company_id' AND v02aoc.month_claim LIKE '%$year%'";

    $claim_id = $conn->query($get_claim);

    if($claim_id->num_rows >  0) {
        while ($row = $claim_id->fetch_assoc()){ array_push($temp_array, $row['id']); }
        $claim_ids = "('" . implode("','", $temp_array) . "')"; //store all date id in (...)
    } else {
        $claim_ids = "(0)";
    }

    $sql = "SELECT SUM(total_claim) AS amount_company FROM v02_aims_others_claim WHERE id IN $claim_ids";
    return $conn->query($sql)->fetch_object()->amount_company;
}

function getDropDownYear($selected) {
    $year_option="";
    $yearNow = date("Y");
    for ($i=0; $i<3; $i++){
        $year = $yearNow - $i;
        $opt_selected = ($year == $selected) ? 'selected' : '';
        $year_option.= "<option value='".$year."' ".$opt_selected.">".$year."</option>";
    }
    return $year_option;
}

function getClaim($year, $month, $company){
    $company_claim = ($company == "0")? "":"AND v02acc.company_id = '$company'";
   /*
    $conn = db();
    $sql = "SELECT * FROM v02_aims_others_claim WHERE month_claim LIKE '%$month $year%'";
    return $conn->query($sql);*/

    $conn = db();
    $temp_array = array();

    $get_claim = "SELECT DISTINCT v02aoc.* FROM v02_aims_others_claim v02aoc
                LEFT JOIN v02_aims_claim_cost_centre v02accc on v02aoc.id = v02accc.claim_id
                LEFT JOIN v02_aims_cost_centre v02acc on v02accc.company_cc_id = v02acc.id
                WHERE v02aoc.month_claim LIKE '%$month $year%' $company_claim";

    $claim_id = $conn->query($get_claim);

    if($claim_id->num_rows >  0) {
        while ($row = $claim_id->fetch_assoc()){ array_push($temp_array, $row['id']); }
        $claim_ids = "('" . implode("','", $temp_array) . "')"; //store all date id in (...)
    } else {
        $claim_ids = "(0)";
    }

    $sql = "SELECT oc.*, s.name, s.department_sub, s.department_id FROM v02_aims_others_claim oc 
            LEFT JOIN staff s ON s.id= oc.staff_id WHERE oc.id IN $claim_ids ORDER BY oc.created_at DESC";
    return $conn->query($sql);

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

function updateTrackingNo($claim_id, $tracking_no){
    $conn=db();
    $sql="UPDATE v02_aims_others_claim SET tracking_no = '$tracking_no' WHERE id = $claim_id";
    return $conn->query($sql);
}

function getTrackingNoById($claim_id){
    $conn=db();
    $sql="SELECT tracking_no FROM v02_aims_others_claim WHERE id = $claim_id";
    return $conn->query($sql)->fetch_object()->tracking_no;

}