<?php

include "../model/language_functions.php";
	
	$action=clean($_POST['action']);
	if($action == "add_terjemahan"){
			$locale=$_POST['locale'];
			$locale_name=$_POST['locale_name'];
			$kod=$_POST['kod'];
			$translation=$_POST['translation'];
			
			$result = addTerjemahan($locale,$locale_name,$kod,$translation);
		
		if($result=="ada") {
			echo ("<script LANGUAGE='JavaScript'>
						window.alert('Terjemahan dah ada');
						window.location.href='../view/bahasa_senarai_terjemahan.php';
						</script>");
			//header("location: ../view/acara_senarai_acara.php");
			exit();
			
		}else if($result=="tiada"){
					echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/bahasa_senarai_terjemahan.php';
						</script>");
			exit();
		}else {
			die("Query failed");
		}
	}
		else if($action == "edit_terjemahan"){
			
			$kod=$_POST['kod'];
			
	            $data = getJenisBahasa();
	            while($jenis = $data->fetch_assoc()) {
	            	$locale=$jenis['local_kod'];
	            	$locale_name=$jenis['locale_name'];
	            	$translation=$_POST[$locale];

	            	$result = addEditTerjemahan($locale,$locale_name,$kod,$translation);
	            }

			echo ("<script LANGUAGE='JavaScript'>
				window.location.href='../view/bahasa_senarai_terjemahan.php';
				</script>");
			exit();
		
	}