<?php



   	include "../model/pemohon_functions.php";



    //file resume
   	$image_resume = $_FILES['document_resume']['tmp_name'];
    $imgContent_resume = addslashes(file_get_contents($image_resume));
    $nama_document_resume=$_FILES['document_resume']['name'];

    //file CV
    $image_cv = $_FILES['document_cv']['tmp_name'];
    $imgContent_cv = addslashes(file_get_contents($image_cv));
    $nama_document_cv=$_FILES['document_cv']['name'];

    //file CV
    $image_document = $_FILES['document']['tmp_name'];
    $imgContent_doc = addslashes(file_get_contents($image_document));
    $nama_document=$_FILES['document']['name'];



    $pemohon_id=$_POST['pemohon_id'];


    $result= addResumeCV($pemohon_id,$imgContent_resume,$nama_document_resume,$imgContent_cv,$nama_document_cv,$imgContent_doc,$nama_document);
	
	//Check whether the query was successful or not
	if($result) 
	
	{
        echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/permohonan_perjawatan_selesai.php?pemohon_id=$pemohon_id';
            </script>");
	   //header("location: ../view/permohonan_perjawatan_selesai.php?pemohon_id=$pemohon_id");
	exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>