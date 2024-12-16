<?php

include "../model/claim_function.php";
	
	$no_staff = ($_GET['no_staff']);  
	$staffs = ($_POST['staffs']);
 

	if(empty($staffs)) 
  {
    echo("You didn't select any buildings.");
  } 
  else 
  {
    $N = count($staffs);

    echo("You selected $N door(s): ");

    deletePelulus();
    
    for($i=0; $i < $N; $i++)
    {
      echo($staffs[$i]. "<br>");

     $result = addPelulus($staffs[$i]);

    }

   // header("location: ../view/senarai_pengguna.php");
    echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/pelulus_tuntutan.php?no_staff=$no_staff';
            </script>");
   //header("location: ../view/pelulus_tuntutan.php?no_staff=$no_staff");

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