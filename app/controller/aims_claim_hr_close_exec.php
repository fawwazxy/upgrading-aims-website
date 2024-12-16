<?php
   	include "../model/aims_others_claim_function.php";
    
	
	$id = ($_GET['id']);
	$payment_status = ($_GET['payment_status']);
	
	 $result = closeClaim($id,$payment_status);

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