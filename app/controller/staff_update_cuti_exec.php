<?php

include "../model/staff_function.php";
	
	$id = $_POST['id'];
	$staff_record_id = $_POST['staff_record_id'];
	$total_cuti = $_POST['total_cuti'];
	$baki_cuti = $_POST['baki_cuti'];
	$baki_cuti_pohon = $_POST['baki_cuti_pohon'];
	
 	$result =  updateStaffCuti($id,$total_cuti,$baki_cuti,$baki_cuti_pohon);

	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/staff_update_cuti.php?staff_record_id=$staff_record_id';
				            </script>");
		//header("location: ../view/staff_add_record.php?id=".$staff['id']."&no_staff=".$no_staff);
		exit();
	}else {
		die("Query failed");
	}
?>