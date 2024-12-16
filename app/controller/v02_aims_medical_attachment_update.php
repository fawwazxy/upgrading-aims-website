<?php
include "../model/v02_aims_medical_function.php";

$id = clean($_POST['id']);
$targetDir = "../../medicalphoto/";

if ($_FILES['document']['size'] <= 0){
    echo "<script>
            alert('Tiada dokumen dikesan. Sila cuba lagi.');
            window.location.href='../view/v02_aims_medical_hr_list.php';
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
        $errors[]="Format fail tidak diterima, sila pilih fail JPG, PNG, HEIC, HEIF atau PDF.";
    }
    if($document_size > 4175639){
        $errors[]='Saiz fail mestilah 4MB dan kebawah';
    }

    if(empty($errors)==true){
        $docName = viewMedicalAttachment($id)->fetch_object()->document_name; // pick old file name
        $filepath = $targetDir.$docName; // declare full path

        move_uploaded_file($tmp_name,$targetPath);
        $result = updateMedicalAttachment($id,$document_name,$document_size);


        //Check whether the query was successful or not
        if($result!="" && $result > 0) {
            if (!empty($docName)){ unlink($filepath); }
            echo ("<script>
                    alert('Lampiran berjaya dikemaskini');
                    window.location.href='../view/v02_aims_medical_hr_list.php';
                    </script>");
            exit();
        }
    }else{
        $err_text = '';
        foreach ($errors as $error){
            $err_text .= "- ".$error."<br>";
        }
        echo "<script>
                alert('Ralat: '.$err_text);
                    window.location.href='../view/v02_aims_medical_hr_list.php';
                </script>";
    }
}