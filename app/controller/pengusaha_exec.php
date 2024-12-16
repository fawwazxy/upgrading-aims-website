<?php

include "../model/pengusaha_functions.php";
	
	$action=clean($_POST['action']);
	if($action == "tambahPengusaha"){
		$kod_ppk=clean($_POST['kod_ppk']);
		$nama=clean($_POST['nama']);
		$nokp=clean($_POST['nokp']);
		$umur=clean($_POST['umur']);
		$notel=clean($_POST['notel']);
		$jantina=clean($_POST['jantina']);
		$no_pengusaha=clean($_POST['no_pengusaha']);
		$no_ahli=clean($_POST['no_ahli']);
		$kod_mukim=clean($_POST['kod_mukim']);
		$alamat=clean($_POST['alamat']);
		$alamat2=clean($_POST['alamat2']);
		$alamat3=clean($_POST['alamat3']);
		$poskod=clean($_POST['poskod']);
		$bandar=clean($_POST['bandar']);
		$kod_negeri=clean($_POST['kod_negeri']);
		$koordinat=clean($_POST['koordinat']);

		$result =  tambahPengusaha($kod_ppk,$nama,$nokp,$umur,$notel,$jantina,$no_pengusaha,$no_ahli,$kod_mukim,$alamat,$alamat2,$alamat3,$poskod,$bandar,$kod_negeri, $koordinat);
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/pengusaha_senarai.php';
            </script>");
			//header("location: ../view/pengusaha_senarai.php");
			exit();
		}else {
			die("Query failed");
		}
	}else if($action == "kemaskiniPengusaha"){
		$id_pengusaha=clean($_POST['id_pengusaha']);
		$kod_ppk=clean($_POST['kod_ppk']);
		//$nama=clean($_POST['nama']);
		//$nokp=clean($_POST['nokp']);
		$umur=clean($_POST['umur']);
		$notel=clean($_POST['notel']);
		$jantina=clean($_POST['jantina']);
		$no_pengusaha=clean($_POST['no_pengusaha']);
		$no_ahli=clean($_POST['no_ahli']);
		$kod_mukim=clean($_POST['kod_mukim']);
		$alamat=clean($_POST['alamat']);
		$alamat2=clean($_POST['alamat2']);
		$alamat3=clean($_POST['alamat3']);
		$poskod=clean($_POST['poskod']);
		$bandar=clean($_POST['bandar']);
		$kod_negeri=clean($_POST['kod_negeri']);
		$koordinat=clean($_POST['koordinat']);

		$result =  kemaskiniPengusaha($id_pengusaha,$kod_ppk,$umur,$notel,$jantina,$no_pengusaha,$no_ahli,$kod_mukim,$alamat,$alamat2,$alamat3,$poskod,$bandar,$kod_negeri, $koordinat);
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/pengusaha_senarai.php';
            </script>");
			//header("location: ../view/pengusaha_senarai.php");
			exit();
		}else {
			die("Query failed");
		}
	}else if($action == "tambahLotTanah"){
		$kod_tanah=clean($_POST['kod_tanah']);
		$kod_negeri=clean($_POST['kod_negeri']);
		$kod_jajahan=clean($_POST['kod_jajahan']);
		$kod_daerah=clean($_POST['kod_daerah']);
		$kod_mukim=clean($_POST['kod_mukim']);
		$seksyen=clean($_POST['seksyen']);
		$lot=clean($_POST['lot']);
		$svy_area=clean($_POST['svy_area']);
		$areaunit=clean($_POST['areaunit']);
		$hektar=clean($_POST['hektar']);
		$unit=clean($_POST['unit']);
		$apdate=clean($_POST['apdate']);
		$pa=clean($_POST['pa']);
		$io=clean($_POST['io']);
		$pkp=clean($_POST['pkp']);
		$pengairan=clean($_POST['pengairan']);
		$area=clean($_POST['area']);
		$perimeter=clean($_POST['perimeter']);
		$koordinat=clean($_POST['koordinat']);

		$result =  tambahLotTanah($kod_tanah,$kod_negeri,$kod_jajahan,$kod_daerah,$kod_mukim,$seksyen,$lot,$svy_area,$areaunit,$hektar,$unit,$apdate,$pa,$io,$pkp,$pengairan,$area,$perimeter,$koordinat);
		if($result == 'success') {
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/lot_tanah_senarai.php';
            </script>");
			//header("location: ../view/lot_tanah_senarai.php");
			exit();
		}else if($result == 'duplicate'){
			echo ("<script lANGUAGE='JavaScript'>
					window.alert('Kod Jajahan : ".$kod_tanah." Telah Wujud');
					window.location.href='../view/lot_tanah_senarai.php';
					</script>");
		}else{
			die("Query failed");
		}
	}else if($action == "kemaskiniLotTanah"){
		$id=clean($_POST['id']);
		$kod_tanah=clean($_POST['kod_tanah']);
		$kod_negeri=clean($_POST['kod_negeri']);
		$kod_jajahan=clean($_POST['kod_jajahan']);
		$kod_daerah=clean($_POST['kod_daerah']);
		$kod_mukim=clean($_POST['kod_mukim']);
		$seksyen=clean($_POST['seksyen']);
		$lot=clean($_POST['lot']);
		$svy_area=clean($_POST['svy_area']);
		$areaunit=clean($_POST['areaunit']);
		$hektar=clean($_POST['hektar']);
		$unit=clean($_POST['unit']);
		$apdate=clean($_POST['apdate']);
		$pa=clean($_POST['pa']);
		$io=clean($_POST['io']);
		$pkp=clean($_POST['pkp']);
		$pengairan=clean($_POST['pengairan']);
		$area=clean($_POST['area']);
		$perimeter=clean($_POST['perimeter']);
		$koordinat=clean($_POST['koordinat']);

		$result = kemaskiniLotTanah($id,$kod_tanah,$kod_negeri,$kod_jajahan,$kod_daerah,$kod_mukim,$seksyen,$lot,$svy_area,$areaunit,$hektar,$unit,$apdate,$pa,$io,$pkp,$pengairan,$area,$perimeter,$koordinat);
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/lot_tanah_senarai.php';
            </script>");
			//header("location: ../view/lot_tanah_senarai.php");
			exit();
		}else {
			die("Query failed");
		}
	}else if($action == "pengusahaAddLotTanah"){
		$id=clean($_POST['id']);
		$pemilik=clean($_POST['pemilik']);

        if(isset($_POST['lot_tanah_ids'])){

	    	$checked_lot_tanah = count($_POST['lot_tanah_ids']);
			//echo "You have selected following ".$checked_lot_tanah." option(s): <br/>";

			foreach($_POST['lot_tanah_ids'] as $selected_lot_tanah) {
				//echo "<p>".$selected_lot_tanah." ~ Kuantiti : ".$_POST['kuantiti_vals'.$selected_lot_tanah]."</p>";
				$result = pengusahaAddLotTanah($selected_lot_tanah,$pemilik);
			}
    	}
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/pengusaha_lot_tanah_senarai.php?nokp=$pemilik';
            </script>");
			//header("location: ../view/pengusaha_lot_tanah_senarai.php?nokp=$pemilik");
			exit();
	 	}else {
			die("Query failed");
		}
	}else if($action=="addLKP"){
		$table=clean($_POST['table']);
		$name_column=clean($_POST['name_column']);
		$num=clean($_POST['num']);
		for ($i=1; $i < $num ; $i++) { 
			$name='col'.$i;
			$column_val=clean($_POST[$name]);
			$column[]="'".$column_val."'";
		}
		$column=implode(',', $column);
		$result = addLkp($table, $name_column, $column);
		if($result == 'success') {
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/lkp_konfigurasi_kada.php?lkp_id=$table';
            </script>");
			//header("location: ../view/lkp_konfigurasi_kada.php?lkp_id=$table");
			exit();
	 	}else if($result == 'duplicate') {
			echo ("<script lANGUAGE='JavaScript'>
						window.alert('Kod untuk $table telah wujud');
						window.location.href='../view/lkp_konfigurasi_kada.php?lkp_id=$table';
						</script>");
			exit();
	 	}else{
			die("Query failed");
		}
	}else if($action == "editLKP"){
		$id=clean($_POST['id']);
		$id_table=clean($_POST['id_table']);
		$table=clean($_POST['table']);
		$name_column=clean($_POST['name_column']);
		$each_name = explode(',', $name_column);
		$num=clean($_POST['num']);
		for ($i=1; $i <= $num ; $i++) { 
			$name='col'.$i;
			$column_val=clean($_POST[$name]);
			$column="'".$column_val."'";
			if(!empty($column_val)){
				$arr[] = $each_name[$i-1]."=".$column;
			}
		}
		$set_update = implode(", ", $arr);
		$result = editLKP($id, $id_table, $table, $set_update);
		if($result == 'success') {
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/lkp_konfigurasi_kada.php?lkp_id=$table';
            </script>");
			//header("location: ../view/lkp_konfigurasi_kada.php?lkp_id=$table");
			exit();
	 	}else if($result == 'duplicate') {
			echo ("<script lANGUAGE='JavaScript'>
						window.alert('Kod untuk $table telah wujud');
						window.location.href='../view/lkp_konfigurasi_kada.php?lkp_id=$table';
						</script>");
			exit();
	 	}else{
			die("Query failed");
		}
	}
	
?>