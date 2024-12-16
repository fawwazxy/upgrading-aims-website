<?php
session_start();
include "../model/v02_aims_ot_function.php";

$staff_id = $_SESSION['SESS_ID'];
$approval_id = "auto";
$description = clean($_POST['description']);
$rate_mode = clean($_POST['rate_mode']);

$month_claim = clean($_POST['month_claim']);
$date_ot = clean($_POST['date_ot']);
$start_ot = clean($_POST['start_ot']);
$end_ot = clean($_POST['end_ot']);
$total_hours = clean($_POST['total_hours']);

$document_name = "";
$document_size = "";
$targetDir = "../../overtimephoto/";

if (!is_numeric($total_hours) || $total_hours < 0.01){
    echo "<script>
        alert('System cannot read total working hours. PLEASE TRY AGAIN or TRY USING DIFFERENT DEVICE. If this issue still occurs, contact IT department (Programming).');
        window.history.back();
    </script>";
    exit();
}

$result = v02addOtPermission($rate_mode,$staff_id,$description,$approval_id);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    $ot_permission_id = $result;

    $result_approval = v02autoApprovePermission($ot_permission_id);
    if($_FILES['document']['size'] > 0) {

        $document_size = $_FILES['document']['size'];
        $tmp_name = $_FILES['document']['tmp_name'];
        $documentName = $_FILES['document']['name'];

        $array2 = explode(".", $documentName);
        $document_type = end($array2); //get "jpg" string

        $document_name= date('Ymd_His').'_'.$documentName;
        $targetPath = $targetDir . $document_name;
        $extensions= array('JPG','JPEG','PNG','GIF','PDF','jpg','jpeg','png','gif','pdf');

        if(in_array($document_type,$extensions)=== false){
            $errors[]="extension not allowed, please choose a JPEG or PNG file.";
        }
        if($document_size > 4194304){
            $errors[]='File size must be below 4 MB';
        }

        if(empty($errors)==true){
            move_uploaded_file($tmp_name,$targetPath);
        }else{
            $err_text = '';
            foreach ($errors as $error){
                $err_text .= "- ".$error."<br>";
            }
        }
    }

    $result = v02addOt($staff_id,$ot_permission_id,$month_claim,$date_ot,$start_ot,$end_ot,$total_hours,$document_name,$document_size);

    if($result) {
        echo ("<script>
            alert('Successfully add new overtime claim');
			window.location.href='../view/v02_aims_ot_list_month.php';
			</script>");
        exit();
    } else {
        echo ("<script>
            alert('Failed to add new OT claim! Error: ".(isset($err_text) ?: '')."');
			window.history.back();
			</script>");
        exit();
    }
} else {
    echo ("<script>
        alert('Failed to add new OT Permission !!! ');
        window.location.href='../view/v02_aims_ot_form_op_agmsb.php';
        </script>");
    exit();
}