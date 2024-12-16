<?
	include "../model/chat_function.php";
	
	$category_name = ($_POST['category_name']);

	echo $result = addCategory($category_name);

	if($result!="" && $result > 0)
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/category_view.php';
						</script>");
		//header("location: ../view/category_view.php");
		exit();
	}else
	{
		die("Query failed");
	}
?>