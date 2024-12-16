<?php
   	include "../model/aims_carReserve_function.php";

	$id= clean($_GET['id']);
	
		$result = deletecarinspection($id);
		
        if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.history.back();
            </script>");
		//header("location: ../view/aims_carinspection_list");
		exit();
	}else {
		die("Query failed");
	}
		
		
?>