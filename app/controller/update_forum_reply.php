<?php

include "../model/chat_function.php";

$id = ($_GET['id']);
$username = ($_GET['name']);

 $forum_id=($_GET['forum_id']);

	$result =  updateForumReply($id);
  

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
                    window.location.href='../view/topik_view.php?id=$forum_id';
                    </script>");
		//header("location: ../view/topik_view.php?id=$forum_id");
		exit();
	}else {
		die("Query failed");
	}
?>