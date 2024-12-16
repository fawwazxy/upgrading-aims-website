<?php
include "../model/v02_aims_medical_function.php";

$staff_id = clean($_POST['staff_id']);
$id = clean($_POST['id']);
$receipt_date = clean($_POST['receipt_date']);
$description = clean($_POST['description']);
$total_claim = clean($_POST['total_claim']);
$created_at = clean($_POST['created_at']);

if($_FILES['document']['size'] > 0) {
    $image_document = $_FILES['document']['tmp_name'];
    $document_name = $_FILES['document']['name'];
    $document_size = $_FILES['document']['size'];
    $targetDir = "../../medicalphoto/";
    $targetPath = $targetDir . $document_name;
    move_uploaded_file($image_document,$targetPath);
}
else {
    $document_name = "";
    $document_size = 0;
}

$result = updateMedical($id, $receipt_date, $description, $total_claim, $document_name, $document_size);

if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
                alert('Medical claim successfully updated');
				window.location.href='../view/v02_aims_medical_list.php';
				</script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
                alert('Failed to update medical claim');
				window.history.back();
				</script>");
    exit();
}

