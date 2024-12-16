<?php
   	include "../model/aims_travel_function.php";

	$id= clean($_GET['id']);
	
		$result = deleteTravel($id);
		
        if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_travel_list.php';
            </script>");
		//header("location: ../view/aims_billing_list");
		exit();
	}else {
		die("Query failed");
	}
		
		
?>