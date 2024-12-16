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
    for ($i=0; $i<3; $i++){
        $year = $yearNow - $i;
        $opt_selected = ($year == $selected) ? 'selected' : '';
        $year_option.= "<option value='".$year."' ".$opt_selected.">".$year."</option>";
    }
    return $year_option;
}

function getDropDownMonth($selected){
    $months = [
        '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April', '05' => 'May', '06' => 'June',
        '07' => 'July', '08' => 'August', '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December',
    ];

    $txt_result="<option ".(0 == $selected ? 'selected':'')." value='0'>All Month</option>";
    foreach ($months as $index => $month){
        $txt_result .= "<option ".($index == $selected ? 'selected':'')." value=\"".$index."\">".$month."</option>";
    }
    return $txt_result;
}

function medicalAnalysis($year, $column = '', $status = 'pending'){
    if($status == 'pending'){
        $where_status = "IS NULL";
    } else if($status == 'approved'){
        $where_status = "= '1'";
    } else{
        $where_status = "= '0'";
    }

    $where_column = ($column == '') ? "" : "AND $column $where_status";
    $conn=db();
    $sql="SELECT COUNT(id) AS total FROM v02_aims_medical WHERE created_at LIKE '%$year-%' $where_column";
    return $conn->query($sql)->fetch_object()->total;
}


function totalUsed($year){
    $conn=db();
    $sql="SELECT SUM(total_claim) AS total_used FROM v02_aims_medical WHERE hr_verify_status ='1' AND created_at LIKE '%$year-%'";
    return $conn->query($sql)->fetch_object()->total_used;
}

function totalEntitle($year){
    $conn=db();
    $sql="SELECT SUM(entitled_balance) AS total_entitle FROM v02_aims_medical_quota WHERE created_at LIKE '%$year-%';";
    return $conn->query($sql)->fetch_object()->total_entitle;
}

function paymentClosed ($year, $column = '', $status = 'unreleased'){
    if($status == 'unreleased'){
        $where_status = "IS NULL";
    } else{
        $where_status = '';
    }

    $conn=db();
    $sql="SELECT COUNT(id) AS total FROM v02_aims_medical WHERE created_at LIKE '%$year-%' AND $column $where_status";
    return $conn->query($sql)->fetch_object()->total;

}

function convertMonthNameToDigit($month){
    $digit = array(
        "January" => "01", "February" => "02","March" => "03", "April" => "04","May" => "05", "June" => "06",
        "July" => "07", "August" => "08","September" => "09", "October" => "10","November" => "11", "December" => "12",
    );
    return $digit[$month];
}

function getCountByMonth($year, $month){
    $month_digit = convertMonthNameToDigit($month);
    $conn = db();
    $sql = "SELECT COUNT(id) AS claim_month FROM v02_aims_medical WHERE hr_verify_status = '1' 
            AND MONTH(created_at) LIKE $month_digit AND YEAR(created_at) LIKE '%$year%'";
    return $conn->query($sql)->fetch_object()->claim_month;
}

function getAmountByMonth($year, $month){
    $month_digit = convertMonthNameToDigit($month);
    $conn = db();
    $sql = "SELECT SUM(total_claim) AS amount_by_month FROM v02_aims_medical WHERE hr_verify_status = '1' 
           AND MONTH(created_at) LIKE $month_digit AND YEAR(created_at) LIKE '%$year%'";
    return $conn->query($sql)->fetch_object()->amount_by_month;
}

function getCompanyCode(){
    $conn = db();
    $sql = "SELECT * FROM department";
    return $conn->query($sql);
}

function getCountByCompany($year, $company_name){
    $conn=db();
    $sql = "SELECT COUNT(m.total_claim) as total_request_year FROM v02_aims_medical m
		LEFT JOIN staff s ON s.id = m.staff_id 
		WHERE m.hr_verify_status = '1'
		AND YEAR(m.created_at) LIKE '%$year%'
		AND s.department_id LIKE '%$company_name%'";
    return $conn->query($sql)->fetch_object()->total_request_year;
}

function getAmountByCompany($year, $company_name){
    $conn = db();
    $sql = "SELECT SUM(m.total_claim) as total_amount_year FROM v02_aims_medical m
		LEFT JOIN staff s ON s.id = m.staff_id 
		WHERE m.hr_verify_status = '1'
		AND YEAR(m.created_at) LIKE '%$year%'
		AND s.department_id LIKE '%$company_name%'";
    return $conn->query($sql)->fetch_object()->total_amount_year;
}

function getMedicalList($year, $month, $company_name){
    $company = ($company_name == '0')?"":"AND s.department_id = '$company_name'";
    $conn=db();
    $sql = "SELECT s.name, s.department_id, s.department_sub, m.* FROM v02_aims_medical m
		LEFT JOIN staff s ON s.id = m.staff_id 
		WHERE m.created_at LIKE '%$year-$month%'
		  $company";
    return $conn->query($sql);
}



?>