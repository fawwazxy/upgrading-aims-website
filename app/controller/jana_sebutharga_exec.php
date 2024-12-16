<?php

include "../model/niaga_function.php";
	
    $lead_id=($_POST['agensi_rujukan']);
    //$reqid=($_POST['reqid']);
    $tajuk_sebut_harga=($_POST['tajuk_sebut_harga']);
    $jumlah_sebut_harga=($_POST['jumlah_sebut_harga']);
    $terma_sebut_harga=($_POST['terma_sebut_harga']);
    $tempoh_sah_sebut_harga=($_POST['tempoh_sah_sebut_harga']);
    $shortcode=($_POST['shortcode']);
	$lead=getLeadInformation($lead_id);
    
    $id_lead= $lead['id'];
    $nama_rujukan=$lead['pic_name'];
    $alamat_rujukan=$lead['lead_address'];
    $notel_rujukan=$lead['lead_telno'];
    $agensi_rujukan=$lead['lead_name'];



	echo $result =  addSebutHarga2($agensi_rujukan,$tajuk_sebut_harga,$jumlah_sebut_harga,$terma_sebut_harga,$tempoh_sah_sebut_harga,$id_lead,$nama_rujukan,$alamat_rujukan,$notel_rujukan,$shortcode);
  

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/niaga_reqsebut_harga.php';
            </script>");
		//header("location: ../view/niaga_reqsebut_harga.php");
	exit();
	}else {
		die("Query failed");
	}
?>