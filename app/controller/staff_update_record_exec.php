<?php

include "../model/staff_function.php";
	
	$id = $_POST['id'];
	$staff_record_id = $_POST['staff_record_id'];
    $no_staff = $_POST['no_staff'];
	$tarikh_mula = $_POST['tarikh_mula'];
	$tarikh_akhir = $_POST['tarikh_akhir'];
	$gaji = $_POST['gaji'];
	$cawangan = clean($_POST['id_lkp_cawangan']);
	$peranan = $_POST['peranan'];
	$department = $_POST['department'];
	$nama_bank = $_POST['nama_bank'];
	$no_akaun = $_POST['no_akaun'];
	$status = $_POST['status'];
	$total_cuti = $_POST['total_cuti'];
	$baki_cuti = $_POST['baki_cuti'];
	$baki_cuti_pohon = $_POST['baki_cuti_pohon'];
    $catatan = $_POST['catatan'];
    $rule_cuti = $_POST['rule_cuti'];
	$department_sub = $_POST['department_sub'];
	//$staff_id = clean($_POST['staff_id']);
	

	
	 $result =  updateStaffRecord($staff_record_id,$tarikh_mula,$tarikh_akhir,$gaji,$peranan,$department,$nama_bank,$no_akaun,$status,$total_cuti,$baki_cuti,$baki_cuti_pohon,$catatan,$no_staff,$cawangan,$rule_cuti,$department_sub);
    
$staff = getValueName($no_staff)->fetch_assoc();

	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/staff_add_record.php?id=$id&staff_record_id=$staff_record_id&no_staff=$no_staff';
				            </script>");
		//header("location: ../view/staff_add_record.php?id=".$staff['id']."&no_staff=".$no_staff);
		exit();
	}else {
		die("Query failed");
	}
?>