<?php
   	include "../model/support_function.php";
    
	

	$id=($_GET['id']);

	$remarks=$_POST['aduancode'];
	$remarks = str_replace('^)·(', '(', $remarks);
    $remarks = str_replace('=?¿¡12', '{', $remarks);
    $remarks = str_replace('++ççcsacsa', '<', $remarks);
	//$client_feedback = ($_POST['client_feedback']);

	$result = addMaklumBalas($remarks,$id);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0)

	
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/maklum_balas_out.php?id=$id';
						</script>");
		//header("location: ../view/maklum_balas_out.php?id=$id");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>









