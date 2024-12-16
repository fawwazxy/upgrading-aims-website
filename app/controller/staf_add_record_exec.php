
<?php

include "../model/staff_function.php";

	$no_staff = clean($_POST['no_staff']);
	$tarikh_mula = clean($_POST['tarikh_mula']);
	$tarikh_akhir = clean($_POST['tarikh_akhir']);
	$gaji = clean($_POST['gaji']);
	$cawangan = clean($_POST['id_lkp_cawangan']);
	$peranan = clean($_POST['peranan']);
	$department = clean($_POST['department']);
	$nama_bank = clean($_POST['nama_bank']);
	$no_akaun = clean($_POST['no_akaun']);
	$status = clean($_POST['status']);
	$total_cuti = clean($_POST['total_cuti']);
	$baki_cuti = clean($_POST['baki_cuti']);
	$baki_cuti_pohon = clean($_POST['baki_cuti_pohon']);
    $catatan = clean($_POST['catatan']);
    $rule_cuti = clean($_POST['rule_cuti']);
	$department_sub = $_POST['department_sub'];

	
	//$staff_id = clean($_POST['staff_id']);
	$id = clean($_POST['id']);

	$result = addStaffRecord($no_staff,$tarikh_mula,$tarikh_akhir,$gaji,$peranan,$department,$nama_bank,$no_akaun,$status,$total_cuti,$baki_cuti,$baki_cuti_pohon,$catatan,$cawangan,$rule_cuti,$department_sub);

	//Create UPDATE query

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/staff_add_record.php?no_staff=$no_staff&id=$id';
				            </script>");
		//header("location: ../view/staff_add_record.php?no_staff=".$no_staff."&id=".$id);
		exit();
	}else {
		die("Query failed");
	}
?>