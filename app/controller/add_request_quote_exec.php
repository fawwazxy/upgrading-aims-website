<?php
   	include "../model/functions.php";
    
	
	$nama_produk=($_POST['nama_produk']);
	$nama_penuh = ($_POST['nama_penuh']);
	$notel = ($_POST['notel']);
	$emel = ($_POST['emel']);
	$nama_syarikat = ($_POST['nama_syarikat']);
	$bil_pekerja = ($_POST['bil_pekerja']);
	$alamat = ($_POST['alamat']);
	

	 $result = addRequestQuote($nama_produk,$nama_penuh,$notel,$emel,$nama_syarikat,$bil_pekerja,$alamat);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0)

	
	{
		if ($nama_produk == 'iOffice') {
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../../index.php?act=request_sent';
						</script>");
		//header("location: ../../index.php?act=request_sent");
		}
		if ($nama_produk == 'iWarden') {
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='http://www.indeepreneur.com/iwarden/index.php?act=request_sent';
						</script>");

		//header("location: http://www.indeepreneur.com/iwarden/index.php?act=request_sent");
		}
		if ($nama_produk == 'iTaska') {
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='http://www.indeepreneur.com/itaska/index.php?act=request_sent';
						</script>");
		//header("location: http://www.indeepreneur.com/itaska/index.php?act=request_sent");
		}
		
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>