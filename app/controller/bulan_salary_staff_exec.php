<?php

include "../model/staff_function.php";



	
    $no_staff = $_GET['no_staff'];
    $tahun = $_GET['tahun'];
    $bulan = $_GET['bulan'];
   
   
	 $slip =getSalaryStaff($no_staff,$tahun,$bulan)->fetch_assoc();
	 $salary_id=$slip['id'];
             
		 if($slip['jenis_kelulusan']=='LULUS'){
		 	echo "<script> window.open('../view/payslip.php?no_staff=$no_staff&bulan=$bulan&tahun=$tahun&salary_id=$salary_id'); window.history.back();</script>";
		 	exit();

			}  
		else 
		{
			//header("location: ../view/salary_info.php?no_staff=$no_staff&bulan=$bulan&tahun=$tahun");
			exit();

		 }
		 
?>