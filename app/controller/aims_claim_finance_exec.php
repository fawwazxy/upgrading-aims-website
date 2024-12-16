<?php
   	include "../model/aims_others_claim_function.php";
    
	
	$id = ($_POST['staff_record_id']);
	$claim_id = ($_POST['claim_id']);
	$tahun = ($_POST['tahun']);
	$status = ($_POST['status']);
	$company = ($_POST['company']);
	$advance = ($_POST['advance']);
	$total_monthclaim = ($_POST['total_monthclaim']);
	$refund = ($_POST['refund']);
	$outstanding = ($_POST['outstanding']);
	$finance_status = ($_POST['finance_status']);
	$name_fin = ($_POST['name_fin']);
	
	 $result =UpdateFinanceAction($claim_id,$tahun,$company,$advance,$total_monthclaim,$refund,$outstanding,$finance_status,$name_fin);

	//Check whether the query was successful or not
	if($result!="" && $result > 0)
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_claim_financeuse.php?claim_id=$claim_id&hr_review_status=$status&tahun=$tahun&company_claim=$company';
						</script>");
		//header("location: ../view/list_faq.php");
		exit();
	}
	else 
	 {  
		die("Query failed");
	 }
	
?>









