
<?php

include "../model/staff_function.php";
	
	
	
	
	$tarikh_bayar = clean($_POST['tarikh_bayar']);
	$no_staff = clean($_POST['no_staff']);
	$kwsp = clean($_POST['kwsp']);
	$socso = clean($_POST['socso']);
	$elaun = clean($_POST['elaun']);
	$claim= clean($_POST['claim']);
	$gaji_kasar = clean($_POST['gaji_kasar']);
	
    $tolak_gaji = clean($_POST['tolak_gaji']);
	$gaji_bersih = clean($_POST['gaji_bersih']);
	$gaji_pokok= clean($_POST['gaji_pokok']);
	$gaji_dibayar = clean($_POST['gaji_dibayar']);
	$belum_bayar = clean($_POST['belum_bayar']);
	$bulan= clean($_POST['gaji_bulan']);
	$tahun= clean($_POST['gaji_tahun']);
	
	$jumlah_potongan= clean($_POST['jumlah_potongan']);
	$kwsp_majikan= clean($_POST['kwsp_majikan']);
	$socso_majikan= clean($_POST['socso_majikan']);
	$gaji_bulan= clean($_POST['gaji_bulan']);
	$gaji_tahun= clean($_POST['gaji_tahun']);
	$id = clean($_POST['id']);
	
	
	$result = addSalary($tarikh_bayar,$no_staff,$kwsp,$socso,$elaun,$claim,$gaji_kasar,$tolak_gaji,$gaji_bersih,$gaji_pokok,$gaji_dibayar,$belum_bayar,$jumlah_potongan,$kwsp_majikan,$socso_majikan,$gaji_bulan,$gaji_tahun) ;
    
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