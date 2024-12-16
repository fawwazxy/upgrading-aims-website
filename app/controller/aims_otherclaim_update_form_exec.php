<?php
   	include "../model/aims_others_claim_function.php";
    
	
	$id = $_POST['id'];
	$date_purchase = $_POST['date_purchase'];
	$time_departure = $_POST['time_departure'];
	$time_arrival = $_POST['time_arrival'];
	$description = $_POST['description'];
	
	 $result =updateformstaff($id,$date_purchase,$time_departure,$time_arrival,$description);

	//Check whether the query was successful or not
	if($result!="" && $result > 0)
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_others_claim_list.php';
						</script>");
		//header("location: ../view/list_faq.php");
		exit();
	}
	else 
	 {
		die("Query failed");
	 }
	
?>

