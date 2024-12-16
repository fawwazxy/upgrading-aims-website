<?php
   	include "../model/cuti_function.php";
	

    $no_staff=clean($_GET['no_staff']);
    $staff_holiday_id=$_POST['staff_holiday_id'];
    $staffs = $_POST['staffs'];
  
	


	
	
		if(empty($staffs)) 
  {
    echo("You didn't select any buildings.");
  } 
  else 
  {
    $N = count($staffs);

    echo("You selected $N door(s): ");

    //deleteGroup($company_id,$user_id);
    
    for($i=0; $i < $N; $i++)
    {
      echo($staffs[$i]. "<br>");

     $result = UpdatePelulus($staff_holiday_id,$staffs[$i]);
    }

   // header("location: ../view/senarai_pengguna.php");
    echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/senarai_kelulusan_cuti.php?no_staff=$no_staff';
            </script>");
     // header("location: ../view/senarai_kelulusan_cuti.php?no_staff=$no_staff");

  exit();
  }
  
	//Create ADD query
	
	//Check whether the query was successful or not
	// if($result) {
		// header("location: ../view/kelulusan_pemohon.php?pemohon_id=".$pemohon_id);
		// exit();
	// }else {
		// die("Query failed");
	// }
?>
?>