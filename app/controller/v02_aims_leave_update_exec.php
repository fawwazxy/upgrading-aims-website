<?php
include "../model/v02_aims_leave_function.php";

//sanitize the POST values
$id = clean($_POST['id']);
$start_date = clean($_POST['start_date']);
$end_date = clean($_POST['end_date']);
$total_days = clean($_POST['total_days']);
$leave_type = clean($_POST['leave_type']);
$description = clean($_POST['description']);
$document_name = "";
$file_size = "";

$targetDir = "../../leave_photo/";
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

        $docName = viewLeaveAttachment($id)->fetch_object()->document_url; // pick old file name
        unlink($targetDir.$docName);
    }else{
        $err_text = '';
        foreach ($errors as $error){
            $err_text .= "- ".$error."<br>";
        }
    }

}

$result = updateLeave($id, $start_date, $end_date, $leave_type, $total_days, $description, $document_name, $file_size);

if($result == true) {
    echo "<script>
            alert('Permohonan cuti berjaya dikemaskini');
			window.location.href='../view/v02_aims_leave_list.php';
			</script>";
}else{
    echo "<script>
            alert('Gagal untuk kemaskini permohonan cuti');
			window.location.href='../view/v02_aims_leave_update.php';
			</script>";
}
