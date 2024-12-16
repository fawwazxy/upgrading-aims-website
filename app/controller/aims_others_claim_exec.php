<?php
include "../model/aims_others_claim_function.php";

//sanitize the POST values
//$title = clean($_POST['title']);
$no_staff = clean($_POST['no_staff']);
$date_purchase = clean($_POST['date_purchase']);
$time_departure = clean($_POST['time_departure']);
$time_arrival = clean($_POST['time_arrival']);
$description = clean($_POST['description']);
$milage = clean($_POST['milage']);
$hotel_allowance = clean($_POST['hotel_allowance']);
$daily_allowance = clean($_POST['daily_allowance']);
$total_claim = clean($_POST['total_claim']);
$month_claim = clean($_POST['month_claim']);
$staff_record_id = clean($_POST['staff_record_id']);
$job_no = clean($_POST['job_no']);
$company_claim = clean($_POST['company_claim']);
$targetDir = "../../othersclaimphoto/";
	if($_FILES['document']['size'] > 0) {
		
		$image_document = $_FILES['document']['tmp_name'];
	    $documentname = $_FILES['document']['name'];
	    $document_type = end((explode(".",$documentname)));
	    
	    $document_name_only = array_shift(explode(".",$documentname));
	    date_default_timezone_set("Asia/Kuala_Lumpur");
	    $randomnum=rand(0,100000);
	    $rename= $document_name_only.date('Ymd').$randomnum;
	    $document_name=$rename.'.'.$document_type;
	    
	    $targetPath = $targetDir . $document_name;
	  	move_uploaded_file($image_document,$targetPath);
	}
	else {
		$document_name = "";
	}

$result = addClaim($date_purchase,$time_departure,$time_arrival,$description,$milage,$hotel_allowance,$daily_allowance,$total_claim,$month_claim,$staff_record_id,$job_no,$company_claim,$document_name,$document_type,$no_staff);

//check wheter the query was succesful or not
if($result!="" && $result > 0)
{
	echo ("<script LANGUAGE='JavaScript'>
	
	window.location.href='../view/aims_others_claim_list.php';
	</script>");
	exit();
}
else
{
	die("Query failed");
}