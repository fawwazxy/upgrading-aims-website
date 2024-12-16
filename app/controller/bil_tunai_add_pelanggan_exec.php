
<?php

include "../model/niaga_function.php";
	
    $lead_id=($_POST['agensi_rujukan']);
    $tajuk_bil_tunai=($_POST['tajuk_bil_tunai']);
    $jumlah_bil_tunai=($_POST['jumlah_bil_tunai']);
    $shortcode=($_POST['shortcode']);
    $id_produk=($_POST['id_produk']);
    $pegawai_dalaman=($_POST['pegawai_dalaman']);
	
	$lead=getLeadInformation($lead_id);
    $id_lead= $lead['id'];
    $nama_rujukan=$lead['pic_name'];
    $alamat_rujukan=$lead['lead_address'];
    $notel_rujukan=$lead['lead_telno'];
    $agensi_rujukan=$lead['lead_name'];



	$result =  addBiltunai($agensi_rujukan,$tajuk_bil_tunai,$jumlah_bil_tunai,$id_lead,$nama_rujukan,$alamat_rujukan,$notel_rujukan,$shortcode,$id_produk,$pegawai_dalaman);
  

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/bil_tunai_add_item.php?id_bil_tunai=$id_bil_tunai';
						</script>");
		//header("location: ../view/niaga_bil_tunai.php");
	exit();
	}else {
		die("Query failed");
	}
?>