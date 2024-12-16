<?php
   	include "../model/aims_ot_function.php";
    
	
	$id = ($_POST['id']);
	$month=($_POST['month']);
	$verify_status = ($_POST['verify_status']);
	$verify_by = ($_POST['verify_by']);
	
	 $result = verifyOtClaim($id,$month,$verify_by,$verify_status);

	//Check whether the query was successful or not
	if($result!="" && $result > 0)
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_ot_hod_list.php?verify_status=PENDING';
						</script>");
		//header("location: ../view/list_faq.php");
		exit();
	}
	else 
	 {
		die("Query failed");
	 }
	
?>









