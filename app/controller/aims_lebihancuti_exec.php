<?php
   	include "../model/cuti_function.php";
    
	
	//Sanitize the POST values
	
	//$title = clean($_POST['title']);
	
	$no_staff = $_POST['no_staff'];
	$staff_record_id = ($_POST['staff_record_id']);
	$department_id = ($_POST['department_id']);
	$date_fill = ($_POST['date_fill']);
	$dic_leave = ($_POST['dic_leave']);
	$date_lv_from = ($_POST['date_lv_from']);
	$date_lv_to = ($_POST['date_lv_to']);
	$day_lv_from = ($_POST['day_lv_from']);
	$day_lv_to = ($_POST['day_lv_to']);
	$type_leave = ($_POST['type_leave']);
	$reason_leave = ($_POST['reason_leave']);
	$descrip = ($_POST['descrip']);
	$total_lv_req = ($_POST['total_lv_req']);
	$approve_by = ($_POST['approve_by']);
	

	$result = addlebihancuti($staff_record_id,$department_id,$date_fill,$dic_leave,$date_lv_from,$date_lv_to,$day_lv_from,$day_lv_to,$type_leave,$reason_leave,$descrip,$total_lv_req,$approve_by);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/senarai_kelulusancuti_special_hr.php?approvement=APPROVE';
            </script>");
		header("location: ../view/senarai_kelulusancuti_special_hr.php?approvement=APPROVE");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>