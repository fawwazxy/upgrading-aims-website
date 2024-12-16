<?php
   	include "../model/support_function.php";
    
	
	
	$no_staff=($_POST['no_staff']);
	$notel = ($_POST['notel']);

	$level_aduan = ($_POST['level_aduan']);
	$developer = ($_POST['developer']);
	$status_tindakan = ($_POST['status_tindakan']);
	//$remarks = ($_POST['remarks']);
	$remarks=$_POST['catatancode'];
	$remarks = str_replace('^)·(', '(', $remarks);
    $remarks = str_replace('=?¿¡12', '{', $remarks);
    $remarks = str_replace('++ççcsacsa', '<', $remarks);
	$created_by = ($_POST['created_by']);

	$id = ($_POST['id']);
		$id_support = ($_POST['id']);

	

	

	$result =addDevLevel($id_support,$level_aduan,$developer,$id,$notel,$remarks,$created_by);
	
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
	
?>









