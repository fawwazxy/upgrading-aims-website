<?
	include "../model/chat_function.php";
	
	$id = ($_GET['id']);
	$username = ($_GET['name']);
	// $category = ($_POST['category_id']);
	// $topik = ($_POST['topik']);
	$message = ($_POST['message']);
	// $image = $_FILES['photo']['tmp_name'];
	// $imgContent = addslashes(file_get_contents($image));

	// $photo_name=$_FILES['photo']['name'];



	echo $result = addReply($id, $username,  $message);

	if($result!="" && $result > 0)
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/topik_view.php?id=$id';
						</script>");
		//header("location: ../view/topik_view.php?id=$id");
		exit();
	}else
	{
		die("Query failed");
	}
?>