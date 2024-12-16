<?php
   	include "../model/aims_inout_function.php";
	

    $id=clean($_GET['inout_id']);

	
	$result = checkInout($id);
	
	//Check whether the query was successful or not
    if($result!="" && $result > 0) 
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.history.back();
						</script>");
	//header("location: ../view/maklumat_cuti.php?no_staff=$no_staff");
	exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>