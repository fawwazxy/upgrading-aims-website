<?php

include "../model/perbelanjaan_functions.php";

    $bulan=$_GET['bulan'];
    $tahun=$_GET['tahun'];
    $flagtahun=$_GET['flagtahun'];
    $id=($_GET['id']);

	$result =  deletePerbelanjaan($id);
  

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/perbelanjaan_syarikat.php?bulan=$bulan&tahun=$tahun&flagtahun=$flagtahun';
            </script>");
		//header("location: ../view/perbelanjaan_syarikat.php?bulan=$bulan&tahun=$tahun&flagtahun=$flagtahun");
		exit();
	}else {
		die("Query failed");
	}
?>













?>