<?php

require '../../lib/db/connection.php';

$action = $_POST['action'];

// Function to sanitize values received from the form. Prevents SQL injection
function clean($str) {
    $conn=db();
    $str=@trim($str);
    if(get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }
    return mysqli_real_escape_string($conn,$str);
}

function getSys($sys_id) {
    $conn=db();
    $sql="SELECT s.*,c.short_name FROM sys_setting s LEFT JOIN company c ON c.sys_id=s.sys_id WHERE s.sys_id='$sys_id'";
    return $conn->query($sql);
}

function getDropDownYear($selected) {
    $year_option="";
    $yearNow = date("Y");
    for ($i=0; $i<4; $i++){
        $year = $yearNow - $i;
        $opt_selected = ($year == $selected) ? 'selected' : '';
        $year_option.= "<option value='".$year."' ".$opt_selected.">".$year."</option>";
    }
    return $year_option;
}

function getDropDownMonth($selected)
{
    $months = [
        '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June',
        '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December',
    ];

    $txt_result = "<option " . (0 == $selected ? 'selected' : '') . " value='0'>All Month</option>";
    foreach ($months as $index => $month) {
        $txt_result .= "<option " . ($index == $selected ? 'selected' : '') . " value=\"" . $index . "\">" . $month . "</option>";
    }
    return $txt_result;
}

function totalPermission($year){
    $conn=db();
    $sql="SELECT COUNT(approval_status) AS total_permission FROM v02_aims_ot_permission WHERE created_at LIKE '%$year-%'";
    return $conn->query($sql)->fetch_object()->total_permission;
}

function claimAnalysis($year, $column = '', $status = 'approved'){
    if($status == 'approved'){
        $where_status = "= '1'";
    } else{
        $where_status = "= '0'";
    }

    $where_column = ($column == '') ? "" : "AND $column $where_status";
    $conn=db();
    $sql="SELECT COUNT(claim_status) AS total_claim FROM v02_aims_ot_permission WHERE created_at LIKE '%$year-%' $where_column";
    return $conn->query($sql)->fetch_object()->total_claim;
}

function totalClosed($year){
    $conn=db();
    $sql="SELECT COUNT(payment_status) AS total_closed FROM v02_aims_ot WHERE payment_status = 'closed' AND created_at LIKE '%$year-%'";
    return $conn->query($sql)->fetch_object()->total_closed;
}

function totalClaim($year){
    $conn=db();
    $sql="SELECT SUM(total_claim) AS total_claim FROM v02_aims_ot_month_session WHERE month_session LIKE '%$year%'";
    return $conn->query($sql)->fetch_object()->total_claim;
}

function getCountByMonth($year, $month){
    $conn = db();
    $sql = "SELECT COUNT(total_claim) as claim_month FROM v02_aims_ot_month_session
	       WHERE month_session LIKE '%$month $year%'";
    return $conn->query($sql)->fetch_object()->claim_month;
}

function getAmountByMonth($year, $month){
    $conn = db();
    $sql = "SELECT SUM(total_claim) as amount_by_month FROM v02_aims_ot_month_session
	       WHERE month_session LIKE '%$month $year%'";
    return $conn->query($sql)->fetch_object()->amount_by_month;
}

function getCompanyCode(){
    $conn = db();
    $sql = "SELECT * FROM department";
    return $conn->query($sql);
}

function getCountByCompany($year, $company_name){
    $conn=db();
    $sql = "SELECT COUNT(m.total_claim) as total_claim_year FROM v02_aims_ot_month_session m
		LEFT JOIN staff s ON s.id = m.staff_id 
		WHERE m.month_session LIKE '%$year%'
		AND s.department_id LIKE '%$company_name%'";
    return $conn->query($sql)->fetch_object()->total_claim_year;
}

function getAmountByCompany($year, $company_name){
    $conn = db();
    $sql = "SELECT SUM(m.total_claim) as total_amount_year FROM v02_aims_ot_month_session m
		LEFT JOIN staff s ON s.id = m.staff_id 
		WHERE m.month_session LIKE '%$year%'
		AND s.department_id LIKE '%$company_name%'";
    return $conn->query($sql)->fetch_object()->total_amount_year;
}

function convertDigitToMonthName($number){
    $month = array(
        "01" => "JANUARY", "02" => "FEBRUARY", "03" => "MARCH", "04" => "APRIL", "05" => "MAY", "06" => "JUNE",
        "07" => "JULY", "08" => "AUGUST","09" => "SEPTEMBER", "10" => "OCTOBER","11" => "NOVEMBER", "12" => "DECEMBER",
    );
    return $month[$number];
}

function getAnalysisReport($year, $month, $company){
    //set where month if parameter contain month number
    $month_name = ($month == 0) ? "" : convertDigitToMonthName($month);
    $conn=db();
    $sql="SELECT otm.*, s.name,s.noic,s.no_staff,s.department_sub,s.department_id,s.role_id FROM v02_aims_ot_month_session otm
            LEFT JOIN staff s ON s.id = otm.staff_id
            WHERE s.department_id LIKE '%$company%'
            AND otm.month_session LIKE '%$month_name $year%'
            ORDER BY otm.id ASC, otm.month_session ASC";
    return $conn->query($sql);
}

function v02countTotalOTFromMonthSessionID($staff_id, $year, $month){
    $month_name = ($month == 0) ? "" : convertDigitToMonthName($month);
    $conn=db();
    $sql="SELECT ao.*, op.description, op.created_at AS permission_created, op.claim_status, op.rate_mode, oms.total_claim as total_claim, 
            oms.month_session, COUNT(ao.id) as total_count FROM v02_aims_ot_month_session oms 
			LEFT JOIN v02_aims_ot_date od ON od.month_session_id = oms.id
			LEFT JOIN v02_aims_ot ao ON ao.ot_date_id = od.id
            LEFT JOIN v02_aims_ot_permission op ON op.id = ao.ot_permission_id
            WHERE oms.month_session LIKE '%$month_name $year%' AND op.applicant_id LIKE '$staff_id'";
    return $conn->query($sql);
}

function getStaffInfo($id){
    $conn=db();
    $sql="SELECT name,noic, department_sub, department_id  FROM staff WHERE id = '$id'";
    return $conn->query($sql);
}

function getAnalysisReportIndividual($id, $year,$month){
    $month_name = ($month == 0) ? "" : convertDigitToMonthName($month);
    $conn=db();
    $sql="SELECT ao.*, op.description, op.created_at AS permission_created, op.claim_status, op.rate_mode, oms.total_claim, oms.month_session FROM v02_aims_ot ao
            LEFT JOIN v02_aims_ot_permission op ON op.id = ao.ot_permission_id
            LEFT JOIN v02_aims_ot_month_session oms on oms.staff_id = op.applicant_id
            WHERE oms.month_session = '$month_name $year' AND op.applicant_id = '$id'";
    return $conn->query($sql);
}
?>