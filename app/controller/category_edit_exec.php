<?
	include "../model/chat_function.php";

	$id = ($_POST['id']);

	$category_name = ($_POST['category_name']);


	echo $result = editCategory($category_name, $id);
  

	//Create UPDATE query
	

	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/category_view.php';
						</script>");
		//header("location: ../view/category_view.php");
	exit();
	}
	else
	 {
		die("Query failed");
	}
?>