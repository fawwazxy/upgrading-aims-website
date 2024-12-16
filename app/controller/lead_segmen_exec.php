<?
	include "../model/lead_produk_function.php";

 
//START WANI - LEAD SEGMEN

$action = ($_GET['act']);
if ($action == "lead_segmen_add"){
	$code = ($_POST['code']);
	$name = ($_POST['name']);

	$result = addLeadSegmen($code, $name);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/lead_segmen.php';
            </script>");
		//header("location: ../view/lead_segmen.php");
		exit();
	}else {
		die("Query failed");
	}

} else if ($action == "lead_segmen_edit"){
	$id=($_GET['id']);
	$code = ($_POST['code']);
	$name = ($_POST['name']);

	$result = editLeadSegmen($code, $name, $id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/lead_segmen.php';
            </script>");
		//header("location: ../view/lead_segmen.php");
		exit();
	}else {
		die("Query failed");
	}
} else if($action == "lead_segmen_delete"){
	$id=($_GET['id']);

	$result =  deleteLeadSegmen($id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/lead_segmen.php';
            </script>");
		//header("location: ../view/lead_segmen.php");
		exit();
	}else {
		die("Query failed");
	}
}else if ($action == "lead_segmen_status"){
   $id=($_GET['id']);

  $result =  updateLeadSegmenStatus($id);

  //Check whether the query was successful or not
  if($result) {
  	echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/lead_segmen.php';
            </script>");
    //header("location: ../view/lead_segmen.php");
    exit();
  }else {
    die("Query failed");
  }
}
else if ($action == "lead_segmen_status_baru"){
   $id=($_GET['id']);

  $result =  updateStatusLeadBaru($id);

  //Check whether the query was successful or not
  if($result) {
  	echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/lead_segmen.php';
            </script>");
    //header("location: ../view/lead_segmen.php");
    exit();
  }else {
    die("Query failed");
  }
}

//END WANI
?>