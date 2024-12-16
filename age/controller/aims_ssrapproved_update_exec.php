<?php
   	include "../model/aims_ssrapproved_function.php";
    
	
	$id = ($_POST['id']);
	
	$approved_name = ($_POST['approved_name']);
	$approved_designation = ($_POST['approved_designation']);
	$approved_status = ($_POST['approved_status']);
	$status = ($_POST['status']);
	
	

	 $result = updateInfo($approved_name,$approved_designation,$approved_status,$status=1,$id);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0)

	
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.history.back();
						</script>");
		//header("location: ../view/list_faq.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
		
?>

<!--echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims5_ssa_list.php';
						</script>");-->







