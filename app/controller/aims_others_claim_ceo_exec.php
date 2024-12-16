<?php
   	include "../model/aims_others_claim_function.php";
    
	

	$id = ($_POST['id']);
	$claim_id = ($_POST['claim_id']);
	$month=($_POST['month']);
	$approve_status = ($_POST['approve_status']);
	$approve_by =($_POST['approve_by']);
	$company = ($_POST['company']);
	
	 $result =updateStaff3($claim_id,$approve_by,$approve_status);

	//Check whether the query was successful or not
	if($result!="" && $result > 0)
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_others_claim_ceo_list.php?approve_status=$approve_status';
						</script>");
		//header("location: ../view/list_faq.php");
		exit();
	}
	else 
	 {
		die("Query failed");
	 }
	
?>









