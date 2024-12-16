<?
	include "../model/chat_function.php";
	
	$id_reply = ($_GET['id']);
	$forum_id = ($_GET['topik']);
	$no_staff = ($_GET['no_staff']);
	// $category = ($_POST['category_id']);
	// $topik = ($_POST['topik']);
	$message = ($_POST['messagenote']);
	// $image = $_FILES['photo']['tmp_name'];
	// $imgContent = addslashes(file_get_contents($image));

	// $photo_name=$_FILES['photo']['name'];



	echo $result = addReply1($id_reply, $forum_id, $no_staff, $message);

	if($result!="" && $result > 0)
	{
	echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/topik_view.php?id=$forum_id';
						</script>");
		//header("location: ../view/topik_view.php?id=$forum_id");
		exit();
	}else
	{
		die("Query failed");
	}
?>