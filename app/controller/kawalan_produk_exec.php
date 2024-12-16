<?php

include "../model/kawalan_produk_functions.php";
	$action=clean($_POST['action']);
	if($action == "PenggunaAddEdit"){                       
		$id = $_POST['id'];          
		$kod_produk = $_POST['kod_produk'];          
		$user_code = $_POST['user_code'];
		$user_name = $_POST['user_name'];
		$limit = $_POST['limit'];

		$result = PenggunaAddEdit($id,$kod_produk,$user_code,$user_name,$limit);
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/kawalan_produk_senarai_pengguna.php?kod_produk=$kod_produk';
            </script>");
			//header("location: ../view/library_kategori_senarai.php");
			exit();
		}else {
			die("Query failed");
		}
	}
	//end nienas
	
?>