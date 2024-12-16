<?php
     include "../model/staff_function.php";
  
    $tarikh_bayar = clean($_GET['tarikh_bayar']);

  //  $gaji_bulan= clean($_POST['gaji_bulan']);
  // $gaji_tahun= clean($_POST['gaji_tahun']);

    $no_staff=clean($_GET['no_staff']);
    $staff_salary_id=clean($_GET['staff_salary_id']);
    $no_staff_login=clean($_GET['no_staff_login']);




$bulan= clean($_GET['bulan']);
  $tahun= clean($_GET['tahun']);
   
  


  
  
  $result = UpdateStatusSalary($staff_salary_id,$no_staff_login);
  
  //Check whether the query was successful or not
  if($result) 
  
  {
    echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/salary_info.php?no_staff=$no_staff&bulan=$bulan&tahun=$tahun';
            </script>");
 // header("location: ../view/salary_info.php?no_staff=$no_staff&bulan=$bulan&tahun=$tahun");
  exit();
  }
  else 
  {
    die("Query failed");
  }
  
?>
?>