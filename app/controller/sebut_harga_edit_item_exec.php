
<?php

include "../model/niaga_function.php";
	
	$id=($_POST['id']);
	$id_sebut_harga=($_POST['id_sebut_harga']);
	$keterangan_item=($_POST['keterangan_item']);
    $kuantiti_item=($_POST['kuantiti_item']);
    $harga_item=($_POST['harga_item']);
    $jumlah_harga_item=($_POST['jumlah_harga_item']);



    



	echo $result = updateItemSebutHarga($keterangan_item,$kuantiti_item,$harga_item,$jumlah_harga_item,$id,$id_sebut_harga);
  

	//Create UPDATE query
	

	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/sebut_harga_add_item.php?id_sebut_harga=$id_sebut_harga';
            </script>");
		//header("location: ../view/sebut_harga_add_item.php?id_sebut_harga=$id_sebut_harga");
	exit();
	}
	else
	 {
		die("Query failed");
	}
?>