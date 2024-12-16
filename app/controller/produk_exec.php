<?
	include "../model/lead_produk_function.php";

 $action = ($_GET['act']);

if ($action == "produk_add"){
	$code = $_POST['code'];
	$produk = $_POST['produk'];
	$penerangan = $_POST['penerangan'];
	$segmen =implode (',', $_POST['segmen']);

	echo $result = addProduk($code, $produk, $penerangan, $segmen);


	if($result!="" && $result > 0)
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/produk.php';
            </script>");
		//header("location: ../view/produk.php");
		exit();
	}else
	{
		die("Query failed");
	}
}
else if ($action == "produk_delete"){
	$id=($_GET['id']);

	$result =  deleteProduk($id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/produk.php';
            </script>");
		//header("location: ../view/produk.php");
		exit();
	}else {
		die("Query failed");
	}
}
else if ($action == "produk_edit"){
	$id=($_POST['id']);
	$code = $_POST['code'];
	$produk = $_POST['produk'];
	$penerangan = $_POST['penerangan'];
	$segmen =implode (',', $_POST['segmen']);

	$result =  updateProduk($code, $produk, $penerangan, $segmen, $id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/produk.php';
            </script>");
		//header("location: ../view/produk.php");
		exit();
	}else {
		die("Query failed");
	}
}
else if ($action == "produk_update_status"){
	$id = ($_GET['id']);

	$result =  updateStatusProduk($id);
 
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/produk.php';
            </script>");
		//header("location: ../view/produk.php");
		exit();
	}else {
		die("Query failed");
	}
}
else if ($action == "produk_update_status_baru"){
	$id = ($_GET['id']);

	$result =  updateStatusProdukBaru($id);
 
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/produk.php';
            </script>");
		//header("location: ../view/produk.php");
		exit();
	}else {
		die("Query failed");
	}
}
?>