<?php
   	include "../model/cuti_function.php";
	

    $tarikh_approve=$_POST['tarikh_approve'];
   	$approvement=$_POST['approvement'];
   	$catatan=$_POST['catatan'];
   	$total_cuti=$_POST['total_cuti'];
   	$baki_cuti=$_POST['baki_cuti'];
   	$baki_cuti_pohon=$_POST['baki_cuti_pohon'];
   	$jumlah_cuti=$_POST['jumlah_cuti'];
   	$approve_by=$_POST['no_staff'];
   	$staff_record_id=clean($_POST['staff_record_id']);
	$staff_holiday_id=clean($_POST['staff_holiday_id']);
	$jenis_cuti=clean($_POST['jenis_cuti']);
	$remark=$_POST['remark'];
  
	
	$result =  UpdateStatusCuti2($staff_holiday_id,$tarikh_approve,$approvement,$total_cuti,$baki_cuti_pohon,$jumlah_cuti,$staff_record_id,$baki_cuti,$approve_by,$jenis_cuti,$remark);


	
	//Check whether the query was successful or not
	if($result) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/senarai_kelulusan_cuti_hod.php';
				            </script>");
    //header("location: ../view/senarai_kelulusan_cuti.php");
	//header("location: ../view/senarai_kelulusan_cuti.php?staff_holiday_id=".$staff_holiday_id."&staff_holiday_id=".$staff_holiday_id");

	exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>