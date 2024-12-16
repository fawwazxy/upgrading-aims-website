<?php
include "../model/aims_gl_function.php";

$id = clean($_POST['id']);
$targetDir = "../../glphoto/";

if ($_FILES['document']['size'] <= 0){
    echo "<script type='text/javascript'>
            alert('No document were detected!');
            history.back();
            </script>";
    exit();
}else{
    $document_size = $_FILES['document']['size'];
    $tmp_name = $_FILES['document']['tmp_name'];
    $documentName = $_FILES['document']['name'];

    $array2 = explode(".", $documentName);
    $document_type = end($array2); //get "jpg" string

    $document_name= date('Ymd_His').'_'.str_replace(" ","_",$documentName);
    $targetPath = $targetDir . $document_name;
    $extensions= array('JPG','JPEG','PNG','PDF','jpg','jpeg','png','pdf','heic','HEIC','heif','HEIF');

    if($document_size > 4194304){
        $errors[]='File size must be below 4 MB';
    }

    if(empty($errors)==true){
        $docName = getAttachment($id); // pick old file name
        $filepath = '../../glphoto/'.$docName; // declare full path

        move_uploaded_file($tmp_name,$targetPath);
        $result = updateAttachment($id,$document_name,$document_size);

        if($result!="" && $result > 0) {
            if (!empty($docName)){ unlink($filepath); }
            echo ("<script type='text/javascript'>
                    alert('Successfully update Client Attachment. Please refresh the page.');
                    history.back();
                    </script>");
            exit();
        }
    } else {
        $err_text = '';
        foreach ($errors as $error){
            $err_text .= "- ".$error."<br>";
        }
        echo "<script type='text/javascript'>
                alert('Error occur: '.$err_text);
                    history.back();
                </script>";
    }
}