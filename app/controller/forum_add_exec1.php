<?
	include "../model/chat_function.php";
	
	$id = ($_GET['name']);
	$category = ($_GET['id']);
	$forum_jenis= ($_POST['perbincangan']);
	//$topik = ($_POST['topik']);
	$topik=$_POST['catatancode'];
	$topik = str_replace('^)·(', '(', $topik);
    $topik = str_replace('=?¿¡12', '{', $topik);
    $topik = str_replace('++ççcsacsa', '<', $topik);
	$message = ($_POST['message']);
	$penerima = ($_POST['penerima']);
	$department = ($_POST['department']);




    $result = addForum($id, $category, $forum_jenis, $topik, $message, $penerima, $department);

	if($result!="" && $result > 0)
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/forum_view_topik.php?id=$category';
						</script>");
		//header("location: ../view/forum_view_topik.php?id=$category");
		exit();
	}else
	{
		die("Query failed");
	}
?>