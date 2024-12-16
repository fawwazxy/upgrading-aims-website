<?php
   	include "../model/support_function.php";
    
	

			$id_support_developer = ($_POST['id_support_developer']);
		$id_support = ($_GET['id_support']);
	$level_aduan = ($_POST['level_aduan']);
	$developer = ($_POST['developer']);
	$tarikh_mula = ($_POST['tarikh_mula']);
	$tarikh_tamat = ($_POST['tarikh_tamat']);
	$jumlah_hari_siap = ($_POST['jumlah_hari_siap']);
	$created_by = ($_POST['created_by']);
	//$remarks = ($_POST['remarks']);
	$remarks=$_POST['catatancode'];
	$remarks = str_replace('^)·(', '(', $remarks);
    $remarks = str_replace('=?¿¡12', '{', $remarks);
    $remarks = str_replace('++ççcsacsa', '<', $remarks);
	
		//$no_staff=($_POST['no_staff']);

	//$status_tindakan = ($_POST['status_tindakan']);
		$status_reassign = ($_POST['status_reassign']);


	$id = ($_POST['id']);
		

	

	

	//$result =updateReassign($id_support_developer);
	$result =updateReassign($id_support_developer,$id_support,$level_aduan,$developer,$tarikh_mula,$tarikh_tamat,$jumlah_hari_siap,$created_by,$remarks);
	
	//Check whether the query was successful or not



	if($result)

	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/list_support_dalam_proses.php';
            </script>");
		//header("location: ../view/list_support_dalam_proses.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>









