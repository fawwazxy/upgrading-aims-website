<?php

include "../model/ahli_functions.php";
	
$action=clean($_POST['action']);
if($action == "addEditAhli"){
		$id=clean($_POST['id']);
		$nama=clean($_POST['nama']);
		$nama_panggilan=clean($_POST['nama_panggilan']);
		$nokp=clean($_POST['nokp']);
		$notel=clean($_POST['notel']);
		$gps_koordinat=clean($_POST['gps_koordinat']);
		$kategori_umur=clean($_POST['kategori_umur']);
		$galur=clean($_POST['galur']);
		$alamat=clean($_POST['alamat']);
		$negeri=clean($_POST['negeri']);
		$daerah=clean($_POST['daerah']);
		$asnaf=clean($_POST['asnaf']);
		$anak_yatim=clean($_POST['anak_yatim']);
		$oku=clean($_POST['oku']);
		$nota=clean($_POST['nota']);
		$role=clean($_POST['role']);
		$password=clean($_POST['password']);
		$targetDir = "../../iahli/user_photo/";

		if($_FILES['photo']['size'] > 0) {
			$image_document = $_FILES['photo']['tmp_name'];
	    	$filename = $_FILES['photo']['name'];
	    	$targetFilePath = $targetDir . $filename;
			$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
			$photo_filename=$nokp.".".$fileType;
			$targetPath = $targetDir . $photo_filename;
			move_uploaded_file($image_document,$targetPath);
		}
		else {
			
			$photo_filename = "";
		}

		$statact=clean($_POST['statact']);

		$tab=clean($_POST['tab']);
		
		
		$result = AhliAddEdit($id,$nama,$nokp,$notel,$gps_koordinat,$kategori_umur,$galur,$alamat,$negeri,$role,$password,$photo_filename,$nama_panggilan,$daerah,$asnaf,$anak_yatim,$oku,$nota);
	
	if($result=="add" || $result=="update") {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/ahli_senarai_ahli.php?statact=$statact&tab=$tab';
						</script>");
		
		exit();
	}else if($result=="exist") {
		echo ("<script LANGUAGE='JavaScript'>
			alert('Rekod Telah Wujud');
						window.location.href='../view/ahli_senarai_ahli.php?statact=$statact&tab=$tab';
						</script>");
	
		exit();
	}else {
		die("Query failed");
	}
}else if($action == "daftarAhli"){
		$id=clean($_POST['id']);
		$status_ahli=clean($_POST['status_ahli']);
		$no_ahli=clean($_POST['no_ahli']);
		//$statact=clean($_POST['statact']);
		if($status_ahli=="SH"){
			$tab="tab_3";
		}else{
			$tab="tab_2";
		}
		//$tab=clean($_POST['tab']);
		
		
		
		
		$result = daftarAhli($id,$status_ahli,$no_ahli);
	
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/ahli_senarai_ahli.php?statact=$status_ahli&tab=$tab';
						</script>");
		//header("location: ../view/acara_senarai_aturcara.php?id_sesi=$id_sesi");
		exit();
	}else {
		die("Query failed");
	}

}else if($action == "YuranAhli"){
		$id=clean($_POST['id']);
		$id_yuran=clean($_POST['id_yuran']);
		$nokp_ahli=clean($_POST['nokp_ahli']);
		$jenis_ahli=clean($_POST['jenis_ahli']);
		$jum_yuran=clean($_POST['jum_yuran']);
		$jenis_bayaran=clean($_POST['jenis_bayaran']);
		$no_rujukkan=clean($_POST['no_rujukkan']);
		$statact=clean($_POST['statact']);
		$tab=clean($_POST['tab']);

		$result = addYuranAhli($id_yuran,$nokp_ahli,$jenis_ahli,$jum_yuran,$jenis_bayaran,$no_rujukkan);
	
	if($result=="tambah") {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/ahli_senarai_ahli.php?statact=$statact&tab=$tab';
						</script>");
		//header("location: ../view/acara_senarai_aturcara.php?id_sesi=$id_sesi");
		exit();
	}if($result=="update") {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/ahli_senarai_yuran.php';
						</script>");
		//header("location: ../view/acara_senarai_aturcara.php?id_sesi=$id_sesi");
		exit();
	}else {
		die("Query failed");
	}

}else if($action == "uploadExcel"){
	require_once('../../lib/spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
	require_once('../../lib/spreadsheet-reader-master/SpreadsheetReader.php');


	$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["csv_file"]["type"],$allowedFileType)){

        $targetPath = '../../resources/items/data_ahli.xlsx';
        move_uploaded_file($_FILES['csv_file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        $masuk=0;
        $tmasuk=0;
        for($i=0;$i<$sheetCount;$i++)
        {
            $Reader->ChangeSheet($i);
            $m=1;
            $tm=1;
            foreach ($Reader as $Key => $Row)
            {
                if ($Key< 1) continue;
          		$nama = $Row[0];
				$nokp = $Row[1];
				$notel = $Row[2];
               
                $result = addAhliExcel($nama,$nokp,$notel);
                if($result){
                   $masuk=$m++;

                }else{
                   $tmasuk=$tm++;

                }
            
            }
        
        }
       
       echo '<script type="text/javascript">
       window.alert("Data Berjaya Di Muatnaik : '.$masuk.'\nData Tidak Berjaya Di Muatnaik  : '.$tmasuk.'");
       window.location.href="../view/ahli_senarai_ahli.php";
       </script>';
      // header("location: ../view/staff_info.php");
       //exit();
	}
	else
	{ 
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
  	}
		

}else if($action == "daftarOnline"){
		$nama=clean($_POST['nama']);
		$nokp=clean($_POST['nokp']);
		$notel=clean($_POST['notel']);
		$gps_koordinat=clean($_POST['gps_koordinat']);
		$kategori_umur=clean($_POST['kategori_umur']);
		$galur=clean($_POST['galur']);
		$alamat=clean($_POST['alamat']);
		$negeri=clean($_POST['negeri']);

		$targetDir = "../../iahli/user_photo/";

		if($_FILES['photo']['size'] > 0) {
			$image_document = $_FILES['photo']['tmp_name'];
	    	$filename = $_FILES['photo']['name'];
	    	$targetFilePath = $targetDir . $filename;
			$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
			$photo_filename=$nokp.".".$fileType;
			$targetPath = $targetDir . $photo_filename;
			move_uploaded_file($image_document,$targetPath);
		}
		else {
			$photo_filename = "";
		}
		
		
		
		$result = daftarAhliOnline($nama,$nokp,$notel,$gps_koordinat,$kategori_umur,$galur,$alamat,$negeri,$photo_filename);
	
	if($result=="add") {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/ahli_daftar_online.php?act=SUCCESS';
						</script>");
		//header("location: ../view/acara_senarai_aturcara.php?id_sesi=$id_sesi");
		exit();
	}else if($result=="exist") {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/ahli_daftar_online.php?act=FAILED';
						</script>");
		//header("location: ../view/acara_senarai_aturcara.php?id_sesi=$id_sesi");
		exit();
	}else {
		die("Query failed");
	}
}	
?>		
	