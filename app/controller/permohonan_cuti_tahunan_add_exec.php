<?php
   	include "../model/cuti_function.php";

	$no_staff = $_POST['no_staff'];
	$staff_record_id = clean($_POST['staff_record_id']);
	$department_id = clean($_POST['department_id']);
	$alamat_cuti = clean($_POST['alamat_cuti']);
	$telepon = clean($_POST['telepon']);
	$cuti_dipohon = clean($_POST['cuti_dipohon']);
	$tarikh_mula = clean($_POST['tarikh_mula']);
	$tarikh_akhir = clean($_POST['tarikh_akhir']);
	$sebab = clean($_POST['sebab']);
	$jumlah_cuti = clean($_POST['jumlah_cuti']);
	$baki_cuti_pohon = clean($_POST['baki_cuti_pohon']);
	$total_cuti = clean($_POST['total_cuti']);
	$baki_cuti = clean($_POST['baki_cuti']);
	$baki_cuti_pohon = clean($_POST['baki_cuti_pohon']);
	if($_FILES['document']['size'] > 0) {

		$image_document = $_FILES['document']['tmp_name'];
		$documentAllowType = array('jpg','png','jpeg','gif','pdf');
		$imgContent_doc = addslashes(file_get_contents($image_document));
    	$document_name = $_FILES['document']['name'];
		$fileType = end((explode(".",$document_name)));
	}
	else {
		$imgContent_doc = "";
		$document_name = "";
		$fileType = "";
	}
	
	$result = addCutiPengguna($staff_record_id,$department_id,$baki_cuti_pohon,$alamat_cuti,$telepon,$cuti_dipohon,$tarikh_mula,$tarikh_akhir,$sebab,$jumlah_cuti,$total_cuti,$baki_cuti,$baki_cuti_pohon,$imgContent_doc,$document_name,$fileType);
	
	//Check whether the query was successful or not
	if($result) 
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/maklumat_cuti.php?no_staff=$no_staff';
            </script>");
		header("location: ../view/maklumat_cuti.php?no_staff=$no_staff");
	exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>