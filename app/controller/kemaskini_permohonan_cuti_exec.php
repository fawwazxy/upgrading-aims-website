<?php
   	include "../model/cuti_function.php";
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	//echo 'yuuu'.clean($_POST['name']);

	$no_staff = clean($_POST['no_staff']);
	$staff_holiday_id = clean($_POST['staff_holiday_id']);
	$staff_record_id = clean($_POST['staff_record_id']);
	$alamat_cuti = clean($_POST['alamat_cuti']);
	$telepon = clean($_POST['telepon']);
	$cuti_dipohon = clean($_POST['cuti_dipohon']);
	$tarikh_mula = clean($_POST['tarikh_mula']);
	$tarikh_akhir = clean($_POST['tarikh_akhir']);
	$sebab = clean($_POST['sebab']);
	$jumlah_cuti = clean($_POST['jumlah_cuti']);
	$baki_cuti = clean($_POST['baki_cuti']);
    $baki_cuti_pohon = $_POST['baki_cuti_pohon'];
    $jenis_cuti =$_POST['jenis_cuti'];
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

	$result = updateCutiPengguna($staff_record_id,$staff_holiday_id,$no_staff,$alamat_cuti,$telepon,$cuti_dipohon,$tarikh_mula,$tarikh_akhir,$sebab, $jumlah_cuti,$baki_cuti_pohon,$baki_cuti,$imgContent_doc,$document_name,$fileType,$jenis_cuti);
	
	//Check whether the query was successful or not
	if($result) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/maklumat_cuti.php?staff_holiday_id=$staff_holiday_id&no_staff=$no_staff';
            </script>");
	//header("location: ../view/maklumat_cuti.php?staff_holiday_id=$staff_holiday_id&no_staff=$no_staff");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>