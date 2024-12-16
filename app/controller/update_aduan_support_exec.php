<?php
   	include "../model/support_function.php";
    
	
	$no_staff=($_POST['no_staff']);
	$level_aduan = ($_POST['level_aduan']);
	$developer = ($_POST['developer']);
	$previous_dev = ($_POST['previous_dev']);
	//$remarks = ($_POST['remarks']);
	$remarks=$_POST['catatancode'];
	$remarks = str_replace('^)·(', '(', $remarks);
    $remarks = str_replace('=?¿¡12', '{', $remarks);
    $remarks = str_replace('++ççcsacsa', '<', $remarks);
	$created_by = ($_POST['created_by']);
	$id = ($_POST['id']);
	$status_tindakan = ($_POST['status_tindakan']);
	

	$result =addDevLevelSupport($level_aduan,$previous_dev,$developer,$id,$remarks,$created_by, $status_tindakan);
	//Check whether the query was successful or not
	if($result){
		if($status_tindakan =='DP'){
			echo ("<script LANGUAGE='JavaScript'>
                    window.location.href='../view/list_support_dalam_penerimaan.php';
                    </script>");
		}else if($status_tindakan == 'T'){
			echo ("<script LANGUAGE='JavaScript'>
                    window.location.href='../view/list_support_dalam_proses.php';
                    </script>");
		}else if($status_tindakan == 'ST'){
			echo ("<script LANGUAGE='JavaScript'>
                    window.location.href='../view/list_support_semakan_terakhir.php';
                    </script>");
		}else{
			echo ("<script LANGUAGE='JavaScript'>
                    window.location.href='../view/list_support_belum_disahkan.php';
                    </script>");
		}
		
		//header("location: ../view/list_support_belum_disahkan.php");
		exit();
	}else{
		die("Query failed");
	}
	
?>










