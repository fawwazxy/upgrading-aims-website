
<?php

include "../model/niaga_function.php";
	
	$id=($_POST['id']);
	$id_bil_tunai=($_POST['id_bil_tunai']);
	$keterangan_item=($_POST['keterangan_item']);
    $kuantiti_item=($_POST['kuantiti_item']);
    $harga_item=($_POST['harga_item']);
    $jumlah_harga_item=($_POST['jumlah_harga_item']);


	echo $result = updateItemBiltunai($keterangan_item,$kuantiti_item,$harga_item,$jumlah_harga_item,$id,$id_bil_tunai);
  

	//Create UPDATE query
	

	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/bil_tunai_add_item.php?id_bil_tunai=$id_bil_tunai';
						</script>");
		//header("location: ../view/bil_tunai_add_item.php?id_bil_tunai=$id_bil_tunai");
	exit();
	}
	else
	 {
		die("Query failed");
	}
?>