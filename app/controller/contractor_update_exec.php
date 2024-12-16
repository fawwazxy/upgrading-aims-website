<?php

include "../model/contractor_function.php";


$id = clean($_POST['id']);
$name = clean($_POST['name']);
$noic = clean($_POST['noic']);
$umur = clean($_POST['umur']);
$gender = clean($_POST['gender']);
$phone = clean($_POST['phone']);
$email = clean($_POST['email']);
  //  $status = $_POST['status'];
$username = clean($_POST['username']);
$accs_pwd = clean($_POST['accs_pwd']);
	//tambah db contractor syarikat di db
$syarikat = clean($_POST['syarikat']);
//pakai column role_id
$category_id = clean($_POST['category_id']);
$purpose = clean($_POST['purpose']);
$jum_jam_kerja = clean($_POST['jum_jam_kerja']);
$jum_jam_break = clean($_POST['jum_jam_break']);
$status_qrcode = clean($_POST['status_qrcode']);
$status_swafoto = clean($_POST['status_swafoto']);
$status_tag = clean($_POST['status_tag']);

$targetDir = "../../contractorphoto/";
	if($_FILES['document']['size'] > 0) {
		
		$image_document = $_FILES['document']['tmp_name'];
	    $documentname = $_FILES['document']['name'];
	    $document_type = end((explode(".",$documentname)));
	    $document_name_only = array_shift(explode(".",$documentname));
	    date_default_timezone_set("Asia/Kuala_Lumpur");
	    $randomnum=rand(0,100000);
	    $rename= $document_name_only.date('Ymd').$randomnum;
	    $document_name=$rename.'.'.$document_type;
	    
	    $targetPath = $targetDir . $document_name;
	  	move_uploaded_file($image_document,$targetPath);
	}
	else {
		$document_name = "";
	}
	
	if($id > 0 ){
		$sql="SELECT doc_name, doc_type FROM contractor_company WHERE contractor_id='$id'";
	    $getFileName = db()->query($sql)->fetch_assoc();
		unlink($targetDir.$getFileName['doc_name']);
	$result = updateContractor($name,$noic,$umur,$gender,$phone,$email,$username,$accs_pwd,$syarikat,$category_id,$jum_jam_kerja,$jum_jam_break,$status_qrcode,$status_swafoto,$status_tag,$purpose,$document_name,$document_type,$id);
	}
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	{

		echo ("<script LANGUAGE='JavaScript'>
						window.history.back();
						</script>");
		//header("location: ../view/contractor_list.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>