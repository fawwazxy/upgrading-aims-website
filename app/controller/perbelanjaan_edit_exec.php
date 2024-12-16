
<?php
   	include "../model/perbelanjaan_functions.php";
 
  $bulan=$_GET['bulan'];
  $tahun=$_GET['tahun'];
  $flagtahun=$_GET['flagtahun'];

 
  // $hr_bertugas = ($_POST['name']);
  $id = ($_GET['id']);
  $perbelanjaan = ($_POST['perbelanjaan']);
  $jenis_perbelanjaan = ($_POST['jenis_perbelanjaan']); 
  $image = $_FILES['file_upload']['tmp_name'];
  $imgContent = addslashes(file_get_contents($image));
  $name_picture=$_FILES['file_upload']['name'];
  $catatan = ($_POST['catatan']);
  $amaun_bayaran = ($_POST['amaun_bayaran']);
  $tarikh_bayaran_dibuat = ($_POST['tarikh_bayaran_dibuat']);
  $nama_penerima = ($_POST['nama_penerima']);
  $rujukan = ($_POST['rujukan']);
  $details_rujukan = ($_POST['details_rujukan']);
  
   

  $result = editPerbelanjaan($perbelanjaan, $jenis_perbelanjaan, $imgContent, $name_picture, $catatan, $amaun_bayaran, $tarikh_bayaran_dibuat, $nama_penerima, $rujukan, $details_rujukan, $id);


	//Create UPDATE query
	

	
	//Check whether the query was successful or not
	if($result) {
    echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/perbelanjaan_syarikat.php?tahun=$tahun&flagtahun=$flagtahun';
            </script>");
		// header("location: ../view/perbelanjaan_syarikat.php?tahun=$tahun&flagtahun=$flagtahun");
	exit();
	}
	else
	 {
		die("Query failed");
	}
?>