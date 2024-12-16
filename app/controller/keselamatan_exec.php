<?php

include "../model/functions.php";
	
	$action=clean($_POST['action']);
	if($action == "menuAddEdit"){
		$id=clean($_POST['id']);
		$module_code=clean($_POST['module_code']);
		$menu=clean($_POST['menu']);
		$susunan=clean($_POST['susunan']);
		$link=clean($_POST['link']);
		$status=clean($_POST['status']);
		$new_tab =clean($_POST['new_tab']);

		$result =  menuAddEdit($id,$module_code,$menu,$susunan,$link,$status,$new_tab);
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/konfigurasi_menu.php?modul=$module_code';
            </script>");
			//header("location: ../view/konfigurasi_menu.php?modul=$module_code");
			exit();
		}else {
			die("Query failed");
		}
	}else if($action == "menuAccess"){
		$role_code=clean($_POST['role_code']);
		$menu_ids=$_POST['menu_ids'];
		//$result =  addCuti($perkara,$tarikh_cuti);

		if(empty($menu_ids)) {
			//echo("Sila tanda pada kotak yang disediakan.");
			$result = roleAccessInactive($role_code);
		}else {
			$N = count($menu_ids);
			//echo("You selected $N door(s): ");

			//inactive existing role
			roleAccessInactive($role_code);

			foreach($menu_ids as $menu_id){
				//echo $menu_id."<br>";
				$result = roleAddEdit($role_code,$menu_id);
			}


		}
		
		//view
		$view_ids=$_POST['view_ids'];
		//$result =  addCuti($perkara,$tarikh_cuti);

		if(empty($view_ids)) {
			//echo("Sila tanda pada kotak yang disediakan.");
			$result = rolePermissionInactive($role_code,'views');
		}else {
			$N = count($view_ids);
			//echo("You selected $N door(s): ");

			//inactive existing role
			rolePermissionInactive($role_code,'views');

			foreach($view_ids as $val){
				//echo $menu_id."<br>";
				rolePermission($role_code,$val,'views');
			}


		}
		//view end
		
		//edits
		$edits_ids=$_POST['edit_ids'];
		//$result =  addCuti($perkara,$tarikh_cuti);

		if(empty($edits_ids)) {
			//echo("Sila tanda pada kotak yang disediakan.");
			$result = rolePermissionInactive($role_code,'edits');
		}else {
			$N = count($edits_ids);
			//echo("You selected $N door(s): ");

			//inactive existing role
			rolePermissionInactive($role_code,'edits');

			foreach($edits_ids as $val){
				//echo $menu_id."<br>";
				rolePermission($role_code,$val,'edits');
			}


		}
		//edits end
		
		//adds
		$add_ids=$_POST['add_ids'];
		//$result =  addCuti($perkara,$tarikh_cuti);

		if(empty($add_ids)) {
			//echo("Sila tanda pada kotak yang disediakan.");
			$result = rolePermissionInactive($role_code,'adds');
		}else {
			$N = count($add_ids);
			//echo("You selected $N door(s): ");

			//inactive existing role
			rolePermissionInactive($role_code,'adds');

			foreach($add_ids as $val){
				//echo $menu_id."<br>";
				rolePermission($role_code,$val,'adds');
			}


		}
		//add_ids end
		
		//deletes
		$delete_ids=$_POST['delete_ids'];
		//$result =  addCuti($perkara,$tarikh_cuti);

		if(empty($delete_ids)) {
			//echo("Sila tanda pada kotak yang disediakan.");
			$result = rolePermissionInactive($role_code,'deletes');
		}else {
			$N = count($delete_ids);
			//echo("You selected $N door(s): ");

			//inactive existing role
			rolePermissionInactive($role_code,'deletes');

			foreach($delete_ids as $val){
				//echo $menu_id."<br>";
				rolePermission($role_code,$val,'deletes');
			}


		}
		//$delete_ids end
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/konfigurasi_role_menu.php?role=$role_code';
            </script>");
		//header("location: ../view/konfigurasi_role_menu.php?role=$role_code");
		exit();
		
	}else if($action == "konfigurasi_sistem_edit"){                       
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
	
?>