<?php
   	include "../model/support_function.php";
    
	
	
	$faq_produk = ($_POST['faq_produk']);

	$faq_title = ($_POST['faq_title']);
	$faq_answer = ($_POST['faq_answer']);
	
		// $image = $_FILES['document']['tmp_name'];
  //   $document = addslashes(file_get_contents($image));

  //   $nama_document=$_FILES['document']['name'];
	

	 $result =addFaq($faq_produk,$faq_title,$faq_answer);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0)

	
	{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/list_faq.php';
						</script>");
		//header("location: ../view/list_faq.php");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>









