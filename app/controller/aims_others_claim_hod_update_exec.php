<?php
   	include "../model/aims_others_claim_hod_function.php";
    
	
	$id = ($_POST['id']);
	$claim_id = ($_POST['claim_id']);
	$hod_review_status = ($_POST['hod_review_status']);
	$hod_review_by = ($_POST['hod_review_by']);
	
	 $result =updateStaff($claim_id,$hod_review_by,$hod_review_status);

	//Check whether the query was successful or not
	if($result!="" && $result > 0)
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_others_claim_hod_list.php?hod_review_status=$hod_review_status';
						</script>");
		//header("location: ../view/list_faq.php");
		exit();
	}
	else 
	 {
		die("Query failed");
	 }
	
?>









