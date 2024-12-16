<?php
   	include "../model/aims_others_claim_function.php";
    
	
	$claim_id = ($_POST['id']);
	$tahun = ($_POST['tahun']);
	$hr_review_status = ($_POST['hr_review_status']);
	$hr_review_by = ($_POST['hr_review_by']);
	$total_monthclaim = ($_POST['total_expenses']);
	
	 $result =updateStaff2($claim_id,$tahun,$hr_review_by,$hr_review_status,$total_monthclaim,$company);

	//Check whether the query was successful or not
	if($result!="" && $result > 0)
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_others_claim_hr_list.php?id=$id&month=$month&hr_review_status=$hr_review_status&tahun=$tahun&department_id=$company';
						</script>");
		//header("location: ../view/list_faq.php");
		exit();
	}
	else 
	 {  
		die("Query failed");
	 }
	
?>









