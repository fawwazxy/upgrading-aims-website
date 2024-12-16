<?php
session_start();
include "../model/v02_aims_others_claim_function.php";

$staff_id = $_SESSION['SESS_ID'];
$company_name = $_POST['company_name'];
$datetime_departure = $_POST['datetime_departure'];
$datetime_arrival = $_POST['datetime_arrival'];
$job_no = $_POST['job_no'];
$month_claim = $_POST['month_claim'];
$description = str_replace("'", "\'", $_POST['description']);
$detail_claim = $_POST['desc'];
$rm_input = $_POST['rm_input'];
$total_claim = $_POST['total_input'];

$targetDir = "../../othersclaimphoto/";
$file_name = "";
$file_size = 0;

if($_FILES['document']['size'] > 0) {
    $file_tmp = $_FILES['document']['tmp_name'];
    $file_name = str_replace(" ","_",$_FILES['document']['name']);
    $file_size = $_FILES['document']['size'];

    $array2 = explode(".", $file_name);
    $document_type = end($array2); //get "jpg" string

    /*$document_name= date('Ymd_His').'_'.$file_name.'.'.$document_type;*/
    $document_name = date('Ymd_His').'_'.$file_name;
    $targetPath = $targetDir . $document_name;
    $extensions= array('jpg','jpeg','png','pdf','heic','heif');

    $errors = [];

    if(in_array(strtolower($document_type),$extensions)=== false){
        $errors[]="Format failure not accepted, please choose JPG, PNG, HEIC, HEIF, or PDF file";
    }
    if($file_size > 4175639){
        $errors[]="File size must be 4MB and below";
    }

    if(empty($errors)==true){
        move_uploaded_file($file_tmp,$targetPath);
    } else {
        $err_text = '';
        foreach ($errors as $error){
            $err_text .= "- ".$error."<br>";
        }

        echo "<script type='text/javascript'>
                alert('" . addslashes($err_text) . "');
                window.history.back();
              </script>";
        exit;
    }
}

$insert_claim = v02addOthersClaim($staff_id, $datetime_departure, $datetime_arrival, $description, $job_no, $month_claim, $total_claim, $document_name, $file_size);

foreach ($detail_claim as $index => $cost_centre_id){
    $result = v02addClaimCostCentre($cost_centre_id, $rm_input[$index], $insert_claim);
}

if($insert_claim!="" && $insert_claim > 0 && $result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
        alert('Claim successfully added.')
        window.location.href='../view/v02_aims_others_claim_list.php';
        </script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
            alert('Failed to add claim.')
            window.history.back();
            </script>");
    exit();
}