<?php
   	include "../model/cuti_function.php";
	

    $no_staff=clean($_GET['no_staff']);
    $staff_holiday_id=clean($_GET['staff_holiday_id']);
    $tahun=clean($_GET['tahun']);
	$support_by=clean($_GET['support_by']);

	


	
	
	$result = UpdateStatusCutisupport($staff_holiday_id,$support_by);
	
	//Check whether the query was successful or not
	if($result) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/senarai_kelulusan_cuti.php?no_staff=$no_staff&tahun=$tahun';
						</script>");
	//header("location: ../view/maklumat_cuti.php?no_staff=$no_staff");
	exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>