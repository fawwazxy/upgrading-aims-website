<?php
include "../model/v02_aims_others_claim_function.php";

$id = clean($_POST['id']);
$targetDir = "../../othersclaimphoto/";

if ($_FILES['document']['size'] <= 0){
    echo "<script type='text/javascript'>
            alert('No document were detected!');
            history.back();
            </script>";
    exit();
} else {
    $tmp_name = $_FILES['document']['tmp_name'];
    $documentName = str_replace(" ","_",$_FILES['document']['name']);
    $document_size = $_FILES['document']['size'];

    $array2 = explode(".", $documentName);
    $document_type = end($array2); //get "jpg" string

    $document_name = date('Ymd_His').'_'.$documentName;
    $targetPath = $targetDir . $document_name;
    $extensions= array('JPG','JPEG','PNG','PDF','jpg','jpeg','png','pdf','heic','HEIC','heif','HEIF');

    if(in_array($document_type,$extensions)=== false){
        $errors[]="Format failure not accepted, please choose JPG, PNG, HEIC, HEIF, or PDF file";
    }
    if($document_size > 4194304){
        $errors[]="File size must be 4MB and below";
    }

    if(empty($errors)==true){
        $docName = v02getAttachment($id); // pick old file name
        $filepath = '../../othersclaimphoto/'.$docName; // declare full path

        move_uploaded_file($tmp_name,$targetPath);
        $result = v02updateAttachment($id,$document_name,$document_size);

        //Check whether the query was successful or not
        if($result!="" && $result > 0) {
            if (!empty($docName)){ unlink($filepath); }
            echo ("<script type='text/javascript'>
                    alert('Successfully update Claim Attachment. Please refresh the page.');
                    history.back();
                    </script>");
            exit();
        }
    }else{
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