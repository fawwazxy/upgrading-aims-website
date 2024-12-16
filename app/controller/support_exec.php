<?php
   	include "../model/support_function.php";
	
	$action=clean($_GET['action']);
	if($action == "batal_1"){
		$id = ($_GET['id']);
		$id_support_developer = ($_GET['id_developer']);
		$result = batalAduan($id_support_developer,$id);
	
		//Check whether the query was successful or not
		if($result!="" && $result > 0){
			echo ("<script LANGUAGE='JavaScript'>
	                    window.location.href='../view/list_support_belum_disahkan.php';
	                    </script>");
			//header("location: ../view/list_support_belum_disahkan.php");
			exit();
		}else{
			die("Query failed");
		}
	}else if($action == "batal_2"){
		$id = ($_GET['id']);
		$id_support_developer = ($_GET['id_developer']);
		$result = batalAduan($id_support_developer,$id);
	
		//Check whether the query was successful or not
		if($result!="" && $result > 0){
			echo ("<script LANGUAGE='JavaScript'>
	                    window.location.href='../view/list_support_dalam_penerimaan.php';
	                    </script>");
			//header("location: ../view/list_support_belum_disahkan.php");
			exit();
		}else{
			die("Query failed");
		}
	}else if($action == "batal_3"){
		$id = ($_GET['id']);
		$id_support_developer = ($_GET['id_developer']);
		$result = batalAduan($id_support_developer,$id);
	
		//Check whether the query was successful or not
		if($result!="" && $result > 0){
			echo ("<script LANGUAGE='JavaScript'>
	                    window.location.href='../view/list_support_dalam_proses.php';
	                    </script>");
			//header("location: ../view/list_support_belum_disahkan.php");
			exit();
		}else{
			die("Query failed");
		}
	}else if($action == "batal_4"){
		$id = ($_GET['id']);
		$id_support_developer = ($_GET['id_developer']);
		$result = batalAduan($id_support_developer,$id);
	
		//Check whether the query was successful or not
		if($result!="" && $result > 0){
			echo ("<script LANGUAGE='JavaScript'>
	                    window.location.href='../view/list_support_semakan_terakhir.php';
	                    </script>");
			//header("location: ../view/list_support_belum_disahkan.php");
			exit();
		}else{
			die("Query failed");
		}
	}else if($action == "batal_5"){
		$id = ($_GET['id']);
		$id_support_developer = ($_GET['id_developer']);
		$result = batalAduan($id_support_developer,$id);
	
		//Check whether the query was successful or not
		if($result!="" && $result > 0){
			echo ("<script LANGUAGE='JavaScript'>
	                    window.location.href='../view/list_aduan.php';
	                    </script>");
			//header("location: ../view/list_support_belum_disahkan.php");
			exit();
		}else{
			die("Query failed");
		}
	}else if($action == "aduan_assign"){

		$created_by = ($_POST['created_by']);
		$support_parent = ($_POST['support_parent']);
		$staff_created = ($_POST['staff_created']);
		$nama_projek = ($_POST['nama_projek']);
		$nama_client = ($_POST['nama_client']);
		$notel = ($_POST['notel']);
		$level_aduan = ($_POST['level_aduan']);
		$developer = ($_POST['developer']);
		$shortcode=($_POST['shortcode']);
		//$remarks = ($_POST['remarks']);
		$remarks=$_POST['catatancode'];
		$remarks = str_replace('^)·(', '(', $remarks);
	    $remarks = str_replace('=?¿¡12', '{', $remarks);
	    $remarks = str_replace('++ççcsacsa', '<', $remarks);

	    $comments=$_POST['aduancode'];
		$comments = str_replace('^)·(', '(', $comments);
	    $comments = str_replace('=?¿¡12', '{', $comments);
	    $comments = str_replace('++ççcsacsa', '<', $comments);

		$result =separate_support($nama_projek,$support_parent,$nama_client,$notel,$level_aduan,$developer,$remarks,$shortcode,$created_by,$staff_created,$comments);
		
		//Check whether the query was successful or not
		if($result)
		
		{
			echo ("<script LANGUAGE='JavaScript'>
	                    window.location.href='../view/list_support_belum_disahkan.php';
	                    </script>");
			//header("location: ../view/list_support_belum_disahkan.php");
			exit();
		}
		else 
		{
			die("Query failed");
		}
	}else if($action == "dev_update_rate"){
		$status_tindakan=($_POST['status_tindakan']);
		//$id=($_POST['id']);
		$id_support_developer=($_POST['id_support_developer']);
		$level_developer=($_POST['level_developer']);

		$result = rateAduanDeveloper($id_support_developer,$level_developer);
		
		//Check whether the query was successful or not
		if($result) 
	  
		{
			if($status_tindakan=='T'){
				echo ("<script LANGUAGE='JavaScript'>
				window.location.href='../view/developer_support_belum_selesai.php?no_staff=$no_staff';
				</script>");
			}
			
			//header("location: ../view/developer_support_belum_selesai.php?no_staff=$no_staff");
			exit();
		}
		else 
		{
			die("Query failed");
		}
	}else if($action == "feedback"){

		$id=$_POST['id_sub'];
		$comments=$_POST['catatancode'];
		$comments = str_replace('^)·(', '(', $comments);
	    $comments = str_replace('=?¿¡12', '{', $comments);
	    $comments = str_replace('++ççcsacsa', '<', $comments);
		//$client_feedback = ($_POST['client_feedback']);

		$result = addMaklumBalas($comments,$id);
		
		//Check whether the query was successful or not
		if($result!="" && $result > 0)
		{
			echo ("<script LANGUAGE='JavaScript'>
							window.location.href='../view/maklum_balas.php?id=$id';
							</script>");
			//header("location: ../view/maklum_balas_out.php?id=$id");
			//exit();
		}
		else 
		{
			die("Query failed");
		}
	}
?>









