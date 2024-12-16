<?php
//phpinfo();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header('Content-type: application/json');

require_once('../lib/json.inc');
require_once ('../lib/db/connection.php');

error_log('json_office.php');
error_reporting(E_ALL);
ini_set("display_errors", 0);

$JsonSystem = new Json();

$cmd = $JsonSystem->getGETPOST('cmd');

$output = '';
$output_to_send = '';
switch ($cmd){

    case '1'://get company list
        $sql = "SELECT * FROM `aims_company`";
        $output = $connjson->query($sql);
        $companies = array();
        while($r = mysqli_fetch_assoc($output)) {
            $companies[] = $r["company_code"];
        }
        $output_to_send = json_encode($companies);
        break;

    case '2'://get department_sub list
        $company_name = $JsonSystem->getGETPOST('company_name');
        if($company_name=='SEMUA SYARIKAT'){
            $sql = "SELECT DISTINCT department_sub from staff WHERE status='BEKERJA' AND department_sub <> '' ORDER BY department_sub ASC";
        }
        else{
            $sql = "SELECT DISTINCT department_sub from staff WHERE department_id='$company_name' AND status='BEKERJA' AND department_sub <> '' ORDER BY department_sub ASC";
        }

        $output = $connjson->query($sql);
        $departments = array();
        while($r = mysqli_fetch_assoc($output)) {
            $departments[] = $r["department_sub"];
        }
        $output_to_send = json_encode($departments);
        break;

    case '3'://get staff list
        $department_id = $JsonSystem->getGETPOST('department_id');
        $department_sub = $JsonSystem->getGETPOST('department_sub');
        if($department_sub=='SEMUA UNIT' and $department_id!='SEMUA SYARIKAT'){//select all staff from department
            $custom_condition = "SELECT name,phone,role_id FROM `staff` WHERE department_id='$department_id' AND status='BEKERJA' AND NOT name LIKE '%ADMIN%'";
        }
        else if($department_sub=='SEMUA UNIT' and $department_id=='SEMUA SYARIKAT'){//select all staff
            $custom_condition = "SELECT name,phone,role_id FROM `staff` WHERE status='BEKERJA' AND NOT name LIKE '%ADMIN%'";
        }
        else if($department_sub!='SEMUA UNIT' and $department_id=='SEMUA SYARIKAT'){//select all staff
            $custom_condition = "SELECT name,phone,role_id FROM `staff` WHERE status='BEKERJA' AND department_sub='$department_sub' AND NOT name LIKE '%ADMIN%'";
        }
        else{
            $custom_condition = "SELECT name,phone,role_id FROM `staff` WHERE department_id='$department_id' AND department_sub='$department_sub' AND status='BEKERJA' AND NOT name LIKE '%ADMIN%'";
        }
        $output = $connjson->query($custom_condition);
        $staffs = array();
        while($r = mysqli_fetch_object($output)) {
            $staffs[] = $r;
        }
        $output_to_send = json_encode($staffs);
        break;

}
// Closing connection
mysqli_close($connjson);
echo $output_to_send;