<?php

include "../model/staff_function.php";
	
	$id = $_POST['id'];
	$staff_record_id = $_POST['staff_record_id'];
	$entitle_medical = $_POST['entitle_medical'];
	$baki_claim = $_POST['baki_claim'];
	$jumlah_claim = $_POST['baki_claim'];
	
 	$result =  updateStaffmedical($id,$entitle_medical,$jumlah_claim,$baki_claim);

	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/aims_lv_tetapan_medical.php?staff_record_id=$staff_record_id';
				            </script>");
		//header("location: ../view/staff_add_record.php?id=".$staff['id']."&no_staff=".$no_staff);
		exit();
	}else {
		die("Query failed");
	}
?>