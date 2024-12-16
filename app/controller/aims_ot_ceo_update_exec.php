<?php
   	include "../model/aims_ot_function.php";
    
	

	$id = ($_POST['id']);
	$month=($_POST['month']);
	$approved_status = ($_POST['approved_status']);
	$approved_by =($_POST['approved_by']);
	
	$result =approvedOtClaim($id,$month,$approved_by,$approved_status);

	//Check whether the query was successful or not
	if($result!="" && $result > 0)
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_ot_ceo_list.php?department_code=0&approved_status=PENDING';
						</script>");
		//header("location: ../view/list_faq.php");
		exit();
	}
	else 
	 {
		die("Query failed");
	 }
	
?>









