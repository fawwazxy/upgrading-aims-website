<?php
include "../model/v02_aims_inout_function.php";

//sanitize the POST values
$id = clean($_POST['id']);
$date = clean($_POST['date']);
$time_out = clean($_POST['time_out']);
$time_in = clean($_POST['time_in']);
$description = clean($_POST['description']);
$document_name = "";
$document_size = "";

$targetDir = "../../inout_photo/";
if($_FILES['document']['size'] > 0) {

    $file_size = $_FILES['document']['size'];
    $file_tmp = $_FILES['document']['tmp_name'];
    $file_name = $_FILES['document']['name'];

    $array2 = explode(".", $file_name);
    $document_type = end($array2); //get "jpg" string

    $document_name= date('Ymd_His').'_'.$id.'.'.$document_type;
    $targetPath = $targetDir . $document_name;
    $extensions= array('jpg','jpeg','png','pdf','heic','heif');

    if(in_array(strtolower($document_type),$extensions)=== false){
        $errors[]="Format fail tidak diterima, sila pilih fail JPG, PNG, HEIC, HEIF atau PDF.";
    }
    if($file_size > 4175639){
        $errors[]='Saiz fail mestilah 4MB dan kebawah';
    }

    if(empty($errors)==true){
        move_uploaded_file($file_tmp,$targetPath);

        $docName = viewInOutAttachment($id)->fetch_object()->document_url; // pick old file name
        unlink($targetDir.$docName);
    }else{
        $err_text = '';
        foreach ($errors as $error){
            $err_text .= "- ".$error."<br>";
        }
    }

}

$result = updateInOutForm($id, $date, $description, $time_out, $time_in, $document_name, $document_size);

if($result == true) {
    echo "<script>
            alert('In/Out application successfully updated');
			window.location.href='../view/v02_aims_inout_list.php';
			</script>";
}else{
    echo "<script>
            alert('Failed to update the application');
			window.location.href='../view/v02_aims_inout_list.php';
			</script>";
}
