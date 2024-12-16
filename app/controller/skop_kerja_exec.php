<?
	include "../model/lkp_function.php";

 $action = ($_GET['act']);



//START WANI
if ($action == "add"){
	$role = ($_POST['role']);
	$keterangan = ($_POST['keterangan']);
	$com_id = ($_POST['com_id']);

	$result = addSkopKerja($role, $keterangan,$com_id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/skop_kerja.php';
            </script>");
		//header("location: ../view/skop_kerja.php");
		exit();
	}else {
		die("Query failed");
	}

} else if ($action == "update"){
	$id=($_GET['id']);
	$role = ($_POST['role']);
	$keterangan = ($_POST['keterangan']);

	$result = editSkopKerja($role, $keterangan, $id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/skop_kerja.php';
            </script>");
		//header("location: ../view/skop_kerja.php");
		exit();
	}else {
		die("Query failed");
	}
} else if($action == "delete"){
	$id=($_GET['id']);

	$result =  deleteSkopKerja($id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/skop_kerja.php';
            </script>");
		//header("location: ../view/skop_kerja.php");
		exit();
	}else {
		die("Query failed");
	}
}

//END WANI
?>