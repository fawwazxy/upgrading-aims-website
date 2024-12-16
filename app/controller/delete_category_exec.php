<?php

include "../model/chat_function.php";



 $category_id=($_GET['id']);

	$result =  deleteCategory($category_id);
  

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/category_view.php';
						</script>");
		//header("location: ../view/category_view.php");
		exit();
	}else {
		die("Query failed");
	}
?>