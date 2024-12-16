<?php

include "../model/project_management_function.php";
	
	$no_staff = ($_GET['no_staff']);  
  $id_projek=($_POST['id_projek']);
	$staffs = ($_POST['staffs']);
 

	if(empty($staffs)) 
  {
    echo("You didn't select any buildings.");
  } 
  else 
  {
    $N = count($staffs);

    echo("You selected $N door(s): ");

    deleteStaff($id_projek);
    
    for($i=0; $i < $N; $i++)
    {
      echo($staffs[$i]. "<br>");

      

     $result = addPekerjaForProject($id_projek,$staffs[$i]);

    }

   // header("location: ../view/senarai_pengguna.php");
    echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/ahli_kumpulan_add.php?id=$id_projek';
            </script>");
  // header("location: ../view/ahli_kumpulan_add.php?id=$id_projek");

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