<?php

include "../model/library_functions.php";
	
	$action=clean($_POST['action']);
	if($action == "konfigurasi_sistem_edit"){                       
		$sys_name = clean($_POST['sys_name']);                    
		$sys_tagline = clean($_POST['sys_tagline']);                 
		$sys_owner = clean($_POST['sys_owner']);                   
		$sys_domain = clean($_POST['sys_domain']);                  
		$sys_email = clean($_POST['sys_email']);                   
		$sys_hotline = clean($_POST['sys_hotline']);                 
		$sys_address = clean($_POST['sys_address']);                 
		$sys_fb = clean($_POST['sys_fb']);                      
		$version = clean($_POST['version']);          

		$image = $_FILES['logo']['tmp_name'];
	    $imgContent = addslashes(file_get_contents($image));
	    $nama_document=$_FILES['logo']['name'];

		sysSettingEdit($sys_name, $sys_tagline, $sys_owner, $sys_domain, $sys_email, $sys_hotline, $sys_address, $sys_fb, $version, $imgContent,$nama_document);
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/konfigurasi_sistem_view.php';
            </script>");
		//header("location: ../view/konfigurasi_sistem_view.php");
		exit();
		
	}else if($action == "company_edit"){                       
		$id = $_POST['id'];          
		$sys_id = $_POST['sys_id'];          
		$name_company = $_POST['nama_company'];          
		$short_name = $_POST['short_name'];          
		$registration_no = $_POST['registration_no'];          
		$tel = $_POST['tel'];          
		$email = $_POST['email'];          
		$website = $_POST['website'];          
		$address = $_POST['address'];          
		$authorized_name = $_POST['authorized_name'];          
		$tagline = $_POST['tagline'];          
		$slogan = $_POST['slogan'];          

		$authorized_signatory = $_FILES['authorized_signatory']['tmp_name'];
	    $imgContent_authorized_signatory = addslashes(file_get_contents($authorized_signatory));
	    $authorized_signatory_fn=$_FILES['authorized_signatory']['name'];

		$company_stamp = $_FILES['company_stamp']['tmp_name'];
	    $imgContent_company_stamp = addslashes(file_get_contents($company_stamp));
	    $company_stamp_fn=$_FILES['company_stamp']['name'];

		$logo = $_FILES['logo']['tmp_name'];
	    $imgContent_logo = addslashes(file_get_contents($logo));
	    $logo_fn=$_FILES['logo']['name'];

		companyEdit($id,$sys_id,$name_company,$short_name,$registration_no,$tel, $email, $website, $address, 
			$authorized_name, $tagline, $slogan, $imgContent_authorized_signatory, 
			$authorized_signatory_fn, $imgContent_company_stamp, $company_stamp_fn, 
			$imgContent_logo, $logo_fn);
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/company_view.php';
            </script>");
		//header("location: ../view/company_view.php");
		exit();
		
	}

	//niena

	else if($action == "kategoriAddEdit"){                       
		$id = $_POST['id'];          
		$jenis = $_POST['jenis'];          
		$status = $_POST['status'];

		$result = kategoriAddEdit($id,$jenis,$status);
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/library_kategori_senarai.php';
            </script>");
			//header("location: ../view/library_kategori_senarai.php");
			exit();
		}else {
			die("Query failed");
		}
		
	}
	//end niena
	
?>