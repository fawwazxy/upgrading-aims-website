<?php

include "../model/meeting_functions.php";



 $id=($_GET['id']);

	$result =  deleteMeeting($id);
  

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/all_meeting.php';
						</script>");
		//header("location: ../view/all_meeting.php");
		exit();
	}else {
		die("Query failed");
	}
?>













?>