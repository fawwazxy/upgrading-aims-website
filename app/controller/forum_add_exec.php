<?
	include "../model/chat_function.php";
	
	$name = ($_GET['name']);
	$forum_jenis= ($_POST['perbincangan']);
	$category = ($_POST['category_id']);
	//$topik = ($_POST['topik']);
	$topik=$_POST['catatancode'];
	$topik = str_replace('^)·(', '(', $topik);
    $topik = str_replace('=?¿¡12', '{', $topik);
    $topik = str_replace('++ççcsacsa', '<', $topik);
	$notel = ($_POST['notel']);
	$message = ($_POST['message']);
	$penerima = implode(',',$_POST['penerima']);
	$department =implode (',', $_POST['department']);


	echo $result = addForum($name, $forum_jenis, $category, $topik, $message,  $penerima, $department);


	if($result!="" && $result > 0)
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/forum_diusul.php?no_staff=$name';
						</script>");
		//header("location: ../view/forum_diusul.php?no_staff=$name");
		exit();
	}else
	{
		die("Query failed");
	}
?>