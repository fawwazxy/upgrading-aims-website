<?php
   	include "../model/niaga_function.php";
    
	
	//Sanitize the POST values

	

	$jumlah_bayaran = ($_POST['jumlah_bayaran']);
	$tarikh_bayaran = ($_POST['tarikh_bayaran']);
	$kaedah_bayaran = ($_POST['kaedah_bayaran']);
	$no_cek_bayaran = ($_POST['no_cek_bayaran']);
	$nama_bank_bayaran = ($_POST['nama_bank_bayaran']);
	$shortcode = ($_POST['shortcode']);
	
	$id_inbois = ($_POST['id_inbois']);

	echo $result = addBayaran($id_inbois,$jumlah_bayaran,$tarikh_bayaran,$kaedah_bayaran,$no_cek_bayaran,$nama_bank_bayaran,$shortcode);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/niaga_bayaran.php';
						</script>");
		//header("location: ../view/niaga_bayaran.php?");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>