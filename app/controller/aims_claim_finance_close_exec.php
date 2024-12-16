<?php
   	include "../model/aims_others_claim_function.php";
    
	
	$id = $_GET['id'];
	$finance_status = $_GET['finance_status'];
	$department_id = $_GET['department_id'];
	$finance_payment_status = $_GET['finance_payment_status'];
	
	 $result = closeClaimFinance($id,$finance_payment_status);

	//Check whether the query was successful or not
	if($result!="" && $result > 0)
	{
		echo ("<script LANGUAGE='JavaScript'>
		                 window.history.back();
						</script>");
		//header("location: ../view/list_faq.php"); window.location.href='../view/aims_ot_hr_list.php?review_status=REVIEWED';
		exit();
	}
	else 
	 {
		die("Query failed");
	 }
	
?>