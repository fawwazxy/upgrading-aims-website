<?php
include "../model/aims_gl_function.php";

	//Sanitize the POST values
	//Stitle = clean($_POST['title']);

$id = clean($_GET['id']);
$applicant_by = clean($_GET['applicant_by']);
$applicant_company = clean($_GET['applicant_company']);

$result = ApplicantConfirm($id,$applicant_by,$applicant_company);

if($result!='' && $result >0)
	
{
	echo ("<script LANGUAGE='JavaScript'>
		
		
		window.location.href='../view/aims_gl_room_reserv_applist.php';
		
		</script>");
	
	
	exit();
	
}
else
{
	die("Query failed");
}

?>