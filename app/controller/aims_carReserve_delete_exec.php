<?php
   	include "../model/aims_carReserve_function.php";

	$id= clean($_GET['id']);
	
		$result = deletecarRequest($id);
		
        if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_carReserve_list.php';
            </script>");
		//header("location: ../view/aims_carReserve_list");
		exit();
	}else {
		die("Query failed");
	}
		
		
?>