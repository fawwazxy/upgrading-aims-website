
<?php

include "../model/niaga_function.php";
	

	$id_bil_tunai=($_POST['id_bil_tunai']);
	//$nama_rujukan=($_POST['nama_rujukan']);
    $agensi_rujukan=($_POST['agensi_rujukan']);
    //$alamat_rujukan=($_POST['alamat_rujukan']);
    //$notel_rujukan=($_POST['notel_rujukan']);
    $tajuk_bil_tunai=($_POST['tajuk_bil_tunai']);
    $id_produk=($_POST['id_produk']);
    $pegawai_dalaman=($_POST['pegawai_dalaman']);
    
    $lead=getLeadInformation($agensi_rujukan);
    $id_lead= $lead['id'];
    $nama_rujukan=$lead['pic_name'];
    $alamat_rujukan=$lead['lead_address'];
    $notel_rujukan=$lead['lead_telno'];
    $agensi_rujukan=$lead['lead_name'];


    



	$result = updateBiltunai($nama_rujukan,$agensi_rujukan,$alamat_rujukan,$notel_rujukan,$tajuk_bil_tunai,$id_bil_tunai,$id_produk,$pegawai_dalaman);
  

	//Create UPDATE query
	

	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/niaga_bil_tunai.php';
						</script>");
		//header("location: ../view/niaga_bil_tunai.php");
	exit();
	}
	else
	 {
		die("Query failed");
	}
?>