<?php
include "../model/aims_ot_function.php";

//sanitize the POST values


$position = clean($_POST['position']);
$month_claim = clean($_POST['month_claim']);
$date_ot = clean($_POST['date_ot']);
$day_ot = clean($_POST['day_ot']);
$start_ot = clean($_POST['start_ot']);
$end_ot = clean($_POST['end_ot']);
$working_hours = clean($_POST['working_hours']);
$type_claim = clean($_POST['type_claim']);
$description_ot = clean($_POST['description_ot']);
$id = clean($_POST['id']);


$result = updateOt($position,$month_claim,$date_ot,$day_ot,$start_ot,$end_ot,$working_hours,$type_claim,$description_ot,$id);

//check wheter the query was succesful or not
if($result!="" && $result > 0)
{
	echo ("<script LANGUAGE='JavaScript'>
	window.location.href='../view/aims_ot_list.php';
	</script>");
	exit();
}
else
{
	die("Query failed");
}
