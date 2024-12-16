<?php
   	include "../model/cuti_function.php";
	

    $no_staff=clean($_GET['no_staff']);
	$staff_record_id=clean($_GET['staff_record_id']);
    $staff_holiday_id=clean($_GET['staff_holiday_id']);
    $tahun=clean($_GET['tahun']);

	
	$result = checkCuti($staff_holiday_id,$staff_record_id);
	
	//Check whether the query was successful or not
	if($result) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.history.back();
						</script>");
	//header("location: ../view/maklumat_cuti.php?no_staff=$no_staff");
	exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>