
<?php
   	include "../model/support_function.php";
	




	$id_progress = ($_POST['id_progress']);
	 $id = ($_GET['id']);
	 $no_staff = ($_GET['no_staff']);

	$tarikh = ($_POST['tarikh']);
	$catatan = ($_POST['catatan']);
	

	

	echo $result = editProgress($tarikh,$catatan,$id_progress);
  

	//Create UPDATE query
	

	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/list_progress.php?id=$id&no_staff=$no_staff';
            </script>");
		//header("location: ../view/list_progress.php?id=$id&no_staff=$no_staff");
	exit();
	}
	else
	 {
		die("Query failed");
	}
?>