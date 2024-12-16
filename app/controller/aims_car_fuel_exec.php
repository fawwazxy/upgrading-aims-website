<?php
require "../model/aims_carReserve_function.php";

$id = ($_POST['id']);
$reserve_id = clean($_POST['reserve_id']);
$status = clean($_POST['status']);
$mileage_fuel = clean($_POST['mileage_fuel']);
$receipt_fuel = clean($_POST['receipt_fuel']);
$receipt_date = clean($_POST['receipt_date']);
$document_name = $document_type = "";
$file_name = $file_type = "";

$targetDir = "../../fuel_photo/";
$random_num=rand(0,100000);

if($_FILES['document']['size'] > 0) {

    $doc_tmp_name = $_FILES['document']['tmp_name'];
    $doc_name = $_FILES['document']['name'];

    $doc_name_array = explode(".", $doc_name);
    $document_type = end($doc_name_array);
    $doc_name = array_shift($doc_name_array);
    $document_name= $doc_name.date('Ymd_').$random_num.'.'.$document_type;

    $targetPath = $targetDir . $document_name;
    move_uploaded_file($doc_tmp_name,$targetPath);
}

if($_FILES['file']['size'] > 0) {

    $file_tmp_name = $_FILES['file']['tmp_name'];
    $filename = $_FILES['file']['name'];

    $file_name_array = explode(".",$filename);
    $file_type = end($file_name_array);
    $file_name = array_shift($file_name_array);

    $file_name= $file_name.date('Ymd_').$random_num.'.'.$file_type;

    $targetPaths = $targetDir . $file_name;
    move_uploaded_file($file_tmp_name,$targetPaths);
}

if($id > 0 ){
    $sql="SELECT document_name, file_name FROM aims_car_fuel WHERE id='$id'";
    $getFileName = db()->query($sql)->fetch_assoc();
    if(!empty($getFileName['document_name']) && $_FILES['document']['size'] > 0){
        unlink($targetDir.$getFileName['document_name']);
    }
    if(!empty($getFileName['file_name']) && $_FILES['file']['size'] > 0){
        unlink($targetDir.$getFileName['file_name']);
    }

    $result = updateCarFuel($mileage_fuel,$receipt_fuel,$document_name,$document_type,$file_name,$file_type,$id, $receipt_date);
}
else {
    $result = addCarFuel($reserve_id,$status,$mileage_fuel,$receipt_fuel,$document_name,$document_type,$file_name,$file_type, $receipt_date);
}

//Check whether the query was successful or not
if($result!="" && $result > 0){
    echo ("<script type='text/javascript'>
                alert('Successfully saved.');
                window.location.href = '../view/aims_car_claim_form.php?id=".$reserve_id."&status=".$status."';
            </script>");
} else {
    echo ("<script type='text/javascript'>
                alert('Failed to save info.');
                window.history.back();
            </script>");
}