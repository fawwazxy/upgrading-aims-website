<?php
include "../model/v02_aims_leave_function.php";

//sanitize the POST values
$staff_id = clean($_POST['staff_id']);
$start_date = clean($_POST['start_date']);
$end_date = clean($_POST['end_date']);
$total_days = clean($_POST['total_days']);
$leave_type = clean($_POST['leave_type']);
$description = clean($_POST['description']);
$document_name = "";
$file_size = "";

$targetDir = "../../leave_photo/";
if($_FILES['document']['size'] > 0) {

    $max_id = getMaxIdLeave()+1;

    $file_size = $_FILES['document']['size'];
    $file_tmp = $_FILES['document']['tmp_name'];
    $file_name = $_FILES['document']['name'];

    $array2 = explode(".", $file_name);
    $document_type = end($array2); //get "jpg" string

    $document_name= date('Ymd_His').'_'.$max_id.'.'.$document_type;
    $targetPath = $targetDir . $document_name;
    $extensions= array('jpg','jpeg','png','pdf','heic','heif');

    if(in_array(strtolower($document_type),$extensions)=== false){
        $errors[]="Format failure not accepted, please choose JPG, PNG, HEIC, HEIF, or PDF file.";
    }
    if($file_size > 4175639){
        $errors[]='File size must be 4MB and below';
    }

    if(empty($errors)==true){
        move_uploaded_file($file_tmp,$targetPath);
    }else{
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

$result = addNewLeave($staff_id, $start_date, $end_date, $leave_type, $total_days, $description, $document_name, $file_size);

if($result == true) {
    echo "<script>
            alert('Leave application successfully added');
			window.location.href='../view/v02_aims_leave_list.php';
			</script>";
}else{
    echo "<script>
            alert('Failed to submit leave application');
			window.location.href='../view/v02_aims_leave_form.php';
			</script>";
}
