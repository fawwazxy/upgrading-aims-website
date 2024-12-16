<?php
   	include "../model/support_function.php";
    
	
	
// $no_staff=($_POST['no_staff']);
	$tarikh_mula=($_POST['tarikh_mula']);
	$tarikh_tamat=($_POST['tarikh_tamat']);
		$jumlah_hari_siap=($_POST['jumlah_hari_siap']);

				$catatan=($_POST['catatan']);


	
	$id=($_POST['id']);
	$id_support=($_POST['id_support']);

	 $result = updateSupportDeveloperTarikh($tarikh_mula,$tarikh_tamat,$jumlah_hari_siap,$catatan,$id);
	
	//Check whether the query was successful or not
	  if($result) 
  
  {
  	echo ("<script LANGUAGE='JavaScript'>
                    window.location.href='../view/developer_support_belum_selesai.php?no_staff=$no_staff';
                    </script>");
  //header("location: ../view/developer_support_belum_selesai.php?no_staff=$no_staff");
  exit();
  }
  else 
  {
    die("Query failed");
  }
  
?>










