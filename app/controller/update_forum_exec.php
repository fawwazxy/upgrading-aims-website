<?php

include "../model/chat_function.php";

$id = ($_GET['name']);

 $forum_id=($_GET['id']);

 $topic_id=($_GET['topic_id']);

	$result =  updateForum($forum_id);
  

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
                    window.location.href='../view/forum_diusul.php?no_staff=$id';
                    </script>");
		//header("location: ../view/forum_diusul.php?no_staff=$id");
		exit();
	}else {
		die("Query failed");
	}
?>