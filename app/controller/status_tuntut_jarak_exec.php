<?php
   	include "../model/claim_function.php";
	

    
   $approve_status=$_POST['approve_status'];
   $catatan=$_POST['catatan'];   
   $tuntut_jarak_id=$_POST['tuntut_jarak_id'];
   $tarikh_approvement=$_POST['tarikh_approvement'];
   $jenis_tuntutan=$_POST['jenis_tuntutan'];
   $no_staff =$_POST['no_staff'];
  
	
	$result =  UpdateStatusTuntutJarak($approve_status,$catatan,$tuntut_jarak_id,$tarikh_approvement,$jenis_tuntutan);


	
	//Check whether the query was successful or not
	if($result) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/senarai_pengesahan_tuntutan.php?no_staff=$no_staff';
				            </script>");

    //header("location: ../view/senarai_pengesahan_tuntutan.php?no_staff=$no_staff");
	//header("location: ../view/senarai_kelulusan_cuti.php?staff_holiday_id=".$staff_holiday_id."&staff_holiday_id=".$staff_holiday_id");

	exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>