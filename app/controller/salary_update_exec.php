<?php

include "../model/staff_function.php";
	
    $tarikh_bayar = clean($_POST['tarikh_bayar']);
	
	$salary_id = clean($_POST['salary_id']);
	$no_staff= clean($_POST['no_staff']);


	$bulan= clean($_POST['gaji_bulan']);
  $tahun= clean($_POST['gaji_tahun']);



   
	
	$gaji_pokok= clean($_POST['gaji_pokok']);
	$elaun = clean($_POST['elaun']);
	$claim = clean($_POST['claim']);
	$gaji_kasar = clean($_POST['gaji_kasar']);
	$kwsp = clean($_POST['kwsp']);
	$socso = clean($_POST['socso']);
	$tolak_gaji= clean($_POST['tolak_gaji']);
	$gaji_bersih = clean($_POST['gaji_bersih']);
	$gaji_dibayar = clean($_POST['gaji_dibayar']);
	$belum_bayar = clean($_POST['belum_bayar']);
	$tarikh_bayar = clean($_POST['tarikh_bayar']);
	$kwsp_majikan = clean($_POST['kwsp_majikan']);
	$socso_majikan = clean($_POST['socso_majikan']);
	



	
	
	
	
	 $result =  updateSalary($salary_id,$gaji_pokok,$elaun,$claim,$gaji_kasar,$kwsp,$socso,$tolak_gaji,$gaji_bersih,$gaji_dibayar,$belum_bayar,$tarikh_bayar,$jumlah_potongan,$kwsp_majikan,$socso_majikan);
    

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/salary_info.php?no_staff=$no_staff&bulan=$bulan&tahun=$tahun';
            </script>");
		//header("location: ../view/salary_info.php?no_staff=$no_staff&bulan=$bulan&tahun=$tahun");
		exit();
	}else {
		die("Query failed");
	}
?>


