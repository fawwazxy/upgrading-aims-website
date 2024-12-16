<?php

include "../model/chat_function.php";

 $id=($_GET['id']);


	$result =  addCounter($id);
  

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
                    window.location.href='../view/topik_view.php?id=$id';
                    </script>");
		//header("location: ../view/topik_view.php?id=$id");
		exit();
	}else {
		die("Query failed");
	}
?>