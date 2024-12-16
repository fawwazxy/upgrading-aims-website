<?php
   	include "../model/aims_cert_function.php";
    
	
	$id = ($_POST['id']);
	$certificate_name = ($_POST['certificate_name']);
	$vessel_code = ($_POST['vessel_code']);	
	$remark = ($_POST['remark']);	
	$date_in = ($_POST['date_in']);
	$date_exp = ($_POST['date_exp']);
	$date_exp1 = ($_POST['date_exp1']);

	$result = updateCert($certificate_name, $vessel_code, $remark, $date_in, $date_exp, $date_exp1,$id);
	
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







