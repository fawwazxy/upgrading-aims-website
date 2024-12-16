<?php
   	include "../model/meeting_functions.php";
    
	
	//Sanitize the POST values
	
	$prepared_by = ($_POST['prepared_by']);
	$title = ($_POST['title']);
	$color = ($_POST['color']);
	$status = ($_POST['status']);
	$event_type = ($_POST['event_type']);
	//$description = ($_POST['description']);
	$description=$_POST['catatancode'];
	$description = str_replace('^)·(', '(', $description);
    $description = str_replace('=?¿¡12', '{', $description);
    $description = str_replace('++ççcsacsa', '<', $description);
	$start = ($_POST['start']);
	$end = ($_POST['end']);
	$id = ($_POST['id']);
	$id_staff = implode (',',$_POST['id_staff']);

	echo $result = addMeeting($title,$description, $start,$end,$id_staff,$status,$event_type,$color,$prepared_by);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/all_kalendar.php';
            </script>");
		//header("location: ../view/all_kalendar.php");
		
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>