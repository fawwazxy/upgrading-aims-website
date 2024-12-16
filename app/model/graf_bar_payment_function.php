<?php
require '../../lib/db/connection.php';

$conn = db();

$year = $_GET['year'];
$sql = "SELECT company_id, company_code FROM aims_company";
$result = $conn->query($sql);

$parent_arr = array();


$i=0;
				
while ($company = $result->fetch_assoc()){
	$c_id = $company['company_id'];
	$c_code = $company['company_code'];

    $stmt0 = "SELECT  SUM(i.unpaid) AS total_unpaid FROM aims_invoice i
		        LEFT JOIN aims_billing b ON b.id= i.billing_id
				LEFT JOIN aims_company c ON c.company_id= b.company_id
				WHERE c.company_id = '$c_id' AND YEAR(i.date_submit) = '$year'";
    $sql0 = $conn->query($stmt0)->fetch_object()->total_unpaid;

    $stmt1 = "SELECT  SUM(i.paid) AS total_paid FROM aims_invoice i
		        LEFT JOIN aims_billing b ON b.id= i.billing_id
				LEFT JOIN aims_company c ON c.company_id= b.company_id
				WHERE c.company_id = '$c_id' AND YEAR(i.date_submit) = '$year' ";
    $sql1 = $conn->query($stmt1)->fetch_object()->total_paid;

    $child_arr = array($c_code, $sql0, $sql1);

    array_push($parent_arr, $child_arr);

    $i++;
}

echo json_encode($parent_arr);



?>