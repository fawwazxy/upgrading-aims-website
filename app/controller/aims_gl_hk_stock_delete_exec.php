<?php
include "../model/aims_gl_function.php";

$id= clean($_GET['id']);


$result = deleteHkStock($id);

if($result) {
	echo ("<script LANGUAGE='JavaScript'>
		window.location.href='../view/aims_gl_hk_stock.php';
		</script>");
		//header("location: ../view/aims_billing_list");
	exit();
}else {
	die("Query failed");
}


?>