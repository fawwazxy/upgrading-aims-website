<?php
include "../model/v02_aims_leave_function.php";

$id = clean($_POST['id']);
$targetDir = "../../leave_photo/";

if ($_FILES['document']['size'] <= 0){
    echo "<script>
            alert('No documents found. Please try again.');
            window.location.href='../view/v02_aims_leave_list.php';
            </script>";
    exit();
}else{
    $document_size = $_FILES['document']['size'];
    $tmp_name = $_FILES['document']['tmp_name'];
    $documentName = $_FILES['document']['name'];

    $array2 = explode(".", $documentName);
    $document_type = end($array2); //get "jpg" string

    $document_name= date('Ymd_His').'_'.$id.'.'.$document_type;
    $targetPath = $targetDir . $document_name;
    $extensions= array('jpg','jpeg','png','pdf','heic','heif');

    if(in_array(strtolower($document_type),$extensions)=== false){
        $errors[]="Format failure not accepted, please choose JPG, PNG, HEIC, HEIF, or PDF file.";
    }
    if($document_size > 4175639){
        $errors[]='File size must be 4MB and below';
    }

    if(empty($errors)==true){
        $docName = viewLeaveAttachment($id)->fetch_object()->document_url; // pick old file name
        $filepath = $targetDir.$docName; // declare full path

        move_uploaded_file($tmp_name,$targetPath);
        $result = updateLeaveAttachment($id,$document_name,$document_size);


        //Check whether the query was successful or not
        if($result!="" && $result > 0) {
            if (!empty($docName)){ unlink($filepath); }
            echo ("<script>
                    alert('Leave attachment successfully updated');
                    window.location.href='../view/v02_aims_leave_list.php';
                    </script>");
            exit();
        }
    }else{
        $err_text = '';
        foreach ($errors as $error){
            $err_text .= "- ".$error."<br>";
        }
        echo "<script>
                alert('Error: '.$err_text);
                    window.location.href='../view/v02_aims_ot_list.php';
                </script>";
    }
}