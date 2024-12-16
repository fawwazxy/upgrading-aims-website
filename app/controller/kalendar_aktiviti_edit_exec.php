
<?php
   	include "../model/meeting_functions.php";
	
	$id = ($_POST['id']);
	$title = ($_POST['title']);
	//$description = ($_POST['description']);
	$description=$_POST['catatancode'];
	$description = str_replace('^)·(', '(', $description);
    $description = str_replace('=?¿¡12', '{', $description);
    $description = str_replace('++ççcsacsa', '<', $description);
	$start = ($_POST['start']);
	$end = ($_POST['end']);
	$status = ($_POST['status']);
	$event_type = ($_POST['jenis_acara']);
	$id_staff = implode (',',$_POST['id_staff']);

	echo $result = editMeeting($title,$start,$end,$id_staff,$status,$event_type,$description,$id);
	//Create UPDATE query
	//Check whether the query was successful or not
		echo "<script>location.href = '../view/all_kalendar.php';</script>";
	exit();
?>
