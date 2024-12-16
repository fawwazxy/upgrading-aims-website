<?php
   	include "../model/support_function.php";
    //$sys_id = $
	$sys = getSys(1)->fetch_object()->sys_tagline;
	$id_support=($_POST['id_support']);
	$id=($_GET['id']);

	$shortcode=($_POST['shortcode']);

	$nama_projek = ($_POST['nama_projek']);
	$nama_client = ($_POST['nama_client']);
	//$aduan = ($_POST['aduan']);
	$aduan=$_POST['catatancode'];
	$aduan = str_replace('^)·(', '(', $aduan);
    $aduan = str_replace('=?¿¡12', '{', $aduan);
    $aduan = str_replace('++ççcsacsa', '<', $aduan);
	$notel = ($_POST['notel']);
	$created_by = $_POST['created_by'];

    
	$status_tindakan = ($_POST['status_tindakan']);

	
	

	$result = addSupport($nama_projek,$nama_client,$aduan,$notel,$status_tindakan,$id_support,$id,$shortcode,$created_by);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0)

	
	{
		echo ("<script LANGUAGE='JavaScript'>
			alert('Terima kasih kerana menggunakan $sys. Isu anda akan diproses dan akan dimaklumkan melalui Whatsapp kepada $nama_client');
			window.location.href='../view/client_support_staff.php';
			</script>");
		//header("location: ../view/client_support.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>