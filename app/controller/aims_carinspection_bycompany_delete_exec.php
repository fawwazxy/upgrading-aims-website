<?php
   	include "../model/aims_carReserve_function.php";

	$id= clean($_GET['id']);
	$name= clean($_GET['name']);
	$month= clean($_GET['month']);
	
		$result = deletecarinspection1($id);
		
        if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_carinspection_list_bycompany.php?name=$name&month=$month';
            </script>");
		//header("location: ../view/aims_carinspection_list");
		exit();
	}else {
		die("Query failed");
	}
		
		
?>