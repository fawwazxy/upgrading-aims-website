<?php
include "../model/aims_gl_function.php";


	//Sanitize the POST values

	//$title = clean($_POST['title']);

$hk_item_id = clean($_POST['hk_item_id']);
$stock = clean($_POST['stock']);
$expired = clean($_POST['expired']);

$result = addHkStock($hk_item_id,$stock,$expired);

	//Check whether the query was successful or not
if($result!="" && $result > 0) 
	
{
	echo ("<script LANGUAGE='JavaScript'>
		window.location.href='../view/aims_gl_hk_stock.php';
		</script>");
		//header("location: ../view/aims_billing_list.php");
	exit();
}
else 
{
	die("Query failed");
}

?>