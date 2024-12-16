<?php
   	include "../model/cuti_manual_function.php";
   	$jabatan_kod = clean($_GET['jabatan_kod']);
	$cawangan_kod = clean($_GET['cawangan_kod']);
	$act = clean($_GET['act']);

	if($act=="add_cuti"){
	$no_staff = $_POST['no_staff'];
	$staff_record_id = getStaffRecordId($no_staff);;

	$jenis_cuti = clean($_POST['jenis_cuti']);
	$pelulus_cuti = clean($_POST['pelulus_cuti']);
	$created_date= clean($_POST['created_date']);
	$created_by= clean($_POST['created_by']);
	$tarikh_mula = clean($_POST['tarikh_mula']);
	$tarikh_akhir = clean($_POST['tarikh_akhir']);

	$end = strtotime($tarikh_akhir); // or your date as well
	$start = strtotime($tarikh_mula);
	$datediff = $end - $start;

	$jumlah_cuti = round($datediff / (60 * 60 * 24))+1;
	
	
	$result = addCuti($staff_record_id,$jabatan_kod,$jenis_cuti,$tarikh_mula,$tarikh_akhir,$created_date,$pelulus_cuti,$jumlah_cuti,$created_by);
	
	//Check whether the query was successful or not
	if($result) 
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/rekod_cuti.php?cawangan_kod=$cawangan_kod&jabatan_kod=$jabatan_kod';
            </script>");
		//header("location: ../view/rekod_cuti.php?cawangan_kod=$cawangan_kod&jabatan_kod=$jabatan_kod");
	exit();
	}
	else 
	{
		die("Query failed");
	}
}else if($act=="del_cuti"){

	$holiday_approve_id=clean($_GET['id']);
	$staff_holiday_id=clean($_GET['staff_holiday_id']);
	$staff_record_id=clean($_GET['staff_record_id']);
	$jumlah_cuti=clean($_GET['jumlah_cuti']);
	$jenis_cuti=clean($_GET['jenis_cuti']);

	$result = delcuti($holiday_approve_id,$staff_record_id,$staff_holiday_id,$jumlah_cuti,$jenis_cuti);
	
	//Check whether the query was successful or not
	if($result) 
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/senarai_cuti.php?cawangan_kod=$cawangan_kod&jabatan_kod=$jabatan_kod';
            </script>");
		//header("location: ../view/rekod_cuti.php?cawangan_kod=$cawangan_kod&jabatan_kod=$jabatan_kod");
	exit();
	}
	else 
	{
		die("Query failed");
	}

}
	
?>