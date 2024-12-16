
<?php

include "../model/niaga_function.php";
	

	$id_sebut_harga=($_POST['id_sebut_harga']);
	//$nama_rujukan=($_POST['nama_rujukan']);
    $agensi_rujukan=($_POST['agensi_rujukan']);
    //$alamat_rujukan=($_POST['alamat_rujukan']);
    //$notel_rujukan=($_POST['notel_rujukan']);
    $tajuk_sebut_harga=($_POST['tajuk_sebut_harga']);
    $terma_sebut_harga=($_POST['terma_sebut_harga']);
    $tempoh_sah_sebut_harga=($_POST['tempoh_sah_sebut_harga']);
    $id_produk=($_POST['id_produk']);
    $pegawai_dalaman=($_POST['pegawai_dalaman']);
    
    $lead=getLeadInformation($agensi_rujukan);
    $id_lead= $lead['id'];
    $nama_rujukan=$lead['pic_name'];
    $alamat_rujukan=$lead['lead_address'];
    $notel_rujukan=$lead['lead_telno'];
    $agensi_rujukan=$lead['lead_name'];


    



	echo $result = updateSebutHarga($nama_rujukan,$agensi_rujukan,$alamat_rujukan,$notel_rujukan,$tajuk_sebut_harga,$terma_sebut_harga,$tempoh_sah_sebut_harga,$id_sebut_harga,$id_produk,$pegawai_dalaman);
  

	//Create UPDATE query
	

	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/niaga_sebut_harga.php';
            </script>");
		//header("location: ../view/niaga_sebut_harga.php");
	exit();
	}
	else
	 {
		die("Query failed");
	}
?>