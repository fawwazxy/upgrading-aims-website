
<?php

include "../model/niaga_function.php";
	

	$tarikh_pesanan_belian = ($_POST['tarikh_pesanan_belian']);
	$jumlah_harga = ($_POST['jumlah_harga']);



	//image
	$image = $_FILES['document']['tmp_name'];
    $document = addslashes(file_get_contents($image));
    $nama_document=$_FILES['document']['name'];
	


$id_sebut_harga = ($_POST['id_sebut_harga']);
$ketua_projek=($_POST['ketua_projek']);


// document for rujukan
	$doc = $_FILES['document_rujukan']['tmp_name'];
    $document_rujukan = addslashes(file_get_contents($doc));
    $nama_document_rujukan=$_FILES['document_rujukan']['name'];

   $pegawai_dalaman=($_POST['pegawai_dalaman']);

	echo $result = updatePesananBelian($id_sebut_harga,$tarikh_pesanan_belian,$jumlah_harga,$document,$nama_document,$ketua_projek,$document_rujukan,$nama_document_rujukan,$pegawai_dalaman);


  

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