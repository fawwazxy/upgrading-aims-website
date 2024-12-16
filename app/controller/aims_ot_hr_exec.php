<?php
   	include "../model/aims_ot_function.php";
    
	
	$id = ($_POST['id']);
	$tahun = ($_POST['tahun']);
	$month_claim = ($_POST['month_claim']);
	$review_status = ($_POST['review_status']);
	$review_by = ($_POST['review_by']);
	$total_monthclaim = ($_POST['total_monthclaim']);
	$r1_5 = ($_POST['r1_5']);
	$s1_5 = ($_POST['s1_5']);
	$t1_5 = ($_POST['t1_5']);
	$r2 = ($_POST['r2']);
	$s2 = ($_POST['s2']);
	$t2 = ($_POST['t2']);
	$r3 = ($_POST['r3']);
	$s3 = ($_POST['s3']);
	$t3 = ($_POST['t3']);
	$r4 = ($_POST['r4']);
	$s4 = ($_POST['s4']);
	$t4 = ($_POST['t4']);
	
	$company_id = ($_POST['company_id']);
	
	
	 $result = reviewOtClaim($id,$tahun,$month_claim,$review_by,$review_status,$total_monthclaim,$r1_5,$s1_5,$t1_5,$r2,$s2,$t2,$r3,$s3,$t3,$r4,$s4,$t4);

	//Check whether the query was successful or not
	if($result!="" && $result > 0)
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_ot_hr_list.php?department_code=$company_id&review_status=PENDING';
						</script>");
		//header("location: ../view/list_faq.php");
		exit();
	}
	else 
	 {  
		die("Query failed");
	 }
	
?>









