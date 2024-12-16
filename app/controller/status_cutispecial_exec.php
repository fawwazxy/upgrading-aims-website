<?php
   	include "../model/cuti_function.php";
	

    $staff_record_id=clean($_POST['staff_record_id']);
	$staff_holiday_id=clean($_POST['staff_holiday_id']);
   	$approvement=$_POST['approvement'];
   	$approve_by=$_POST['no_staff'];
	$jumlah_cuti=$_POST['jumlah_cuti'];
	$type_leave=clean($_POST['type_leave']);
	$remark=$_POST['remark'];
  
	
	$result =  UpdateStatusCutispecial($staff_record_id,$staff_holiday_id,$approvement,$approve_by,$jumlah_cuti,$type_leave,$remark);


	
	//Check whether the query was successful or not
	if($result!="" && $result > 0)
	
	{
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/senarai_kelulusancuti_special_hr.php';
				            </script>");
   
	exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>