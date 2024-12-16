<?php
   	include "../model/claim_function.php";
	

    $no_pemohon=clean($_GET['no_pemohon']);
    $value=clean($_GET['value']);
    $table_ref=clean($_GET['table_ref']);

	


	
	
	$result = UpdateStatusHantar($value,$table_ref);
	
	//Check whether the query was successful or not
	if($result) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/senarai_tuntutan_belum_diluluskan.php?no_staff=$no_pemohon';
						</script>");
	//header("location: ../view/senarai_tuntutan_belum_diluluskan.php?no_staff=$no_pemohon");
	exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>