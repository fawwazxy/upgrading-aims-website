<?php
   	include "../model/claim_function.php";
	

    
   $approve_status=$_POST['approve_status'];
   $catatan=$_POST['catatan'];   
   $default_id=$_POST['default_id'];
   $tarikh_approvement=$_POST['tarikh_approvement'];
   $jenis_tuntutan=$_POST['jenis_tuntutan'];
  
	
	$result =  UpdateStatusTuntutDefault($approve_status,$catatan,$default_id,$tarikh_approvement,$jenis_tuntutan);


	
	//Check whether the query was successful or not
	if($result) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/senarai_pengesahan_tuntutan.php';
				            </script>");
    //header("location: ../view/senarai_pengesahan_tuntutan.php");
	//header("location: ../view/senarai_kelulusan_cuti.php?staff_holiday_id=".$staff_holiday_id."&staff_holiday_id=".$staff_holiday_id");

	exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>