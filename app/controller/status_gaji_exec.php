<?php
   	include "../model/staff_function.php";
	

    
   $jenis_kelulusan=$_POST['jenis_kelulusan'];
   $approve_by =$_POST['approve_by'];
  
   $catatan=$_POST['catatan'];

  

   // $id=$_POST['id'];
    $staff_salary_id=clean($_POST['staff_salary_id']);
	
	$result =  UpdateStatusSalary2($staff_salary_id,$jenis_kelulusan,$approve_by,$catatan);


	
	//Check whether the query was successful or not
	if($result) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/salary_approve.php?id=&staff_salary_id=$staff_salary_id';
				            </script>");
	//header("location: ../view/salary_approve.php?id=".$id."&staff_salary_id=".$staff_salary_id);
	exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>