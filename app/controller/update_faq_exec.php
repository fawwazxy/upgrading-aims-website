<?php
   	include "../model/support_function.php";
    
	
	
	$faq_produk = ($_POST['faq_produk']);
	$faq_title = ($_POST['faq_title']);
	$faq_answer = ($_POST['faq_answer']);


	// //image
	// $image = $_FILES['document']['tmp_name'];
 //    $document = addslashes(file_get_contents($image));
 //    $nama_document=$_FILES['document']['name'];



		$faq_id = ($_POST['faq_id']);
	

	

	 $result =updateFaq($faq_produk,$faq_title,$faq_answer,$faq_id);
	
	//Check whether the query was successful or not
	if($result)

	
	{
		// header("location: ../view/list_faq.php");
		echo "<script>location.href = '../view/list_faq.php';</script>";
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>









