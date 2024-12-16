<?php
   	include "../model/aims_carReserve_function.php";

	$id= clean($_GET['id']);
	
		$result = deletecarSummon($id);
		
        if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/aims_carSummon_list.php';
            </script>");
		//header("location: ../view/aims_carSummon_list");
		exit();
	}else {
		die("Query failed");
	}
		
		
?>