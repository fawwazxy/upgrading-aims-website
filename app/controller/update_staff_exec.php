<?php

include "../model/staff_function.php";
	
	
	$no_staff = $_POST['no_staff'];
	
	$name = $_POST['name'];
	$noic = $_POST['noic'];
	$umur = $_POST['umur'];
	$martial_status = $_POST['martial_status'];
	$tanggungan = $_POST['tanggungan'];
	$phone = $_POST['phone'];
	$email = $_POST['email'];
	$alamat_tetap = $_POST['alamat_tetap'];
	$alamat_surat = $_POST['alamat_surat'];

	// $jawatan_code = $_POST['jawatan_code'];
	// $role_id= $_POST['role_id'];
	// $department_id = $_POST['department_id'];
    $status = $_POST['status'];
	$username = $_POST['username'];
	$accs_pwd = $_POST['accs_pwd'];
	$leave_approval = $_POST['leave_approval'];
	$pantau_kehadiran = $_POST['pantau_kehadiran'];
	$gender = $_POST['gender'];
	$cawangan_kod = $_POST['id_lkp_cawangan'];
	$company_id = $_POST['company_id'];
	$jum_jam_kerja = $_POST['jum_jam_kerja'];
	$jum_jam_break = $_POST['jum_jam_break'];
	$status_qrcode = $_POST['status_qrcode'];
	$status_swafoto = $_POST['status_swafoto'];
	$status_tag = $_POST['status_tag'];
	//image
	$targetDir = "../../staffphoto/";
	if($_FILES['photo']['size'] > 0) {
		
	  	$image_document = $_FILES['photo']['tmp_name'];
	    $nama_photo = $_FILES['photo']['name'];
	    $targetPath = $targetDir . $nama_photo;
	  	move_uploaded_file($image_document,$targetPath);
	}
	else {
		$nama_photo = "";
	}

	
	      	
 
	
	
	$id= $_POST['id'];
	
	$result = updateStaff($id,$no_staff,$name,$noic,$umur,$martial_status,$tanggungan,$phone,$email,$alamat_tetap,$alamat_surat,
	$status,$username,$accs_pwd,$nama_photo,$leave_approval,$pantau_kehadiran,$gender,$cawangan_kod,$company_id,$jum_jam_kerja,$jum_jam_break,$status_qrcode,$status_swafoto,$status_tag) ;
	

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
                    window.location.href='../view/staff_add_record.php?id=$id&no_staff=$no_staff';
                    </script>");
		//header("location: ../view/staff_info.php?statact=ACTIVE&id=".$id."&no_staff=".$no_staff);
		//window.location.href='../view/staff_info.php?statact=ACTIVE&id=$id&no_staff=$no_staff';
		exit();
	}else {
		die("Query failed");
	}
?>