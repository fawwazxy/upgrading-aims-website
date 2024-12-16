<?php
   	include "../model/cuti_function.php";
	

    $no_staff=clean($_GET['no_staff']);
	$staff_record_id=clean($_GET['staff_record_id']);
    $staff_holiday_id=clean($_GET['staff_holiday_id']);
	$type_leave =clean($_GET['type_leave']);
	$total_lv_req =clean($_GET['total_lv_req']);
    $tahun=clean($_GET['tahun']);

	


	
	
	$result = batalCuti2($staff_holiday_id,$staff_record_id,$type_leave,$total_lv_req);
	
	//Check whether the query was successful or not
	if($result) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/senarai_kelulusancuti_special_hr.php?approvement=APPROVE';
						</script>");
	//header("location: ../view/maklumat_cuti.php?no_staff=$no_staff");
	exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>