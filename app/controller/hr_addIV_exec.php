<?php

include "../model/pemohon_functions.php";
	
	$tarikh_iv = ($_POST['tarikh_iv']);
	$masa_iv = ($_POST['masa_iv']);
	$role_id = ($_POST['role_id']);
	$staffs = ($_POST['staffs']);
	$ketua = ($_POST['ketua']);
	$cawangan_kod = ($_POST['id_lkp_cawangan']);

	$pemohon_id = ($_POST['pemohon_id']);  
	
	
	if(empty($staffs)) 
  {
    echo("You didn't select any buildings.");
  } 
  else 
  {
    $N = count($staffs);

    echo("You selected $N door(s): ");
	$new_pemohon_id = addInterview($pemohon_id,$tarikh_iv,$masa_iv,$role_id,$ketua,$status_pemohon,$cawangan_kod);
    //deleteGroup($company_id,$user_id);
    
    for($i=0; $i < $N; $i++)
    {
      echo($staffs[$i]. "<br>");
	  $flag_ketua="0";
	  if($staffs[$i]==$ketua){
		  
		  $flag_ketua="1";
	  }
	  else{
		  $flag_ketua="0";
	  }
	  
	  
	  setPenemuduga($new_pemohon_id,$staffs[$i],$flag_ketua);
     
    }

      // header("location: ../view/pemohon_senarai.php?statact=IV");

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