<?php
include "../model/aims_car_function.php";
//Sanitize the POST values

$car_model = clean($_POST['car_model']);
$car_plate_no = clean($_POST['car_plate_no']);
$car_type = clean($_POST['car_type']);
$car_owner = clean($_POST['car_owner']);
$car_pic = clean($_POST['car_pic']);
$car_pic2 = clean($_POST['car_pic2']);
$car_category = clean($_POST['car_category']);
$engine_no = clean($_POST['engine_no']);
$chassis_no = clean($_POST['chassis_no']);
$cost_receipt = clean($_POST['cost_receipt']);
$date_receipt = clean($_POST['date_receipt']);
$hire_account_no = clean($_POST['hire_account_no']);
$name_account = clean($_POST['name_account']);
$last_service = clean($_POST['last_service']);
$next_service = clean($_POST['next_service']);
$current_mileage = clean($_POST['current_mileage']);
$next_mileage = clean($_POST['next_mileage']);
$suppliers = clean($_POST['suppliers']);
$date_ex_rtx = clean($_POST['date_ex_rtx']);
$value_rtx = clean($_POST['value_rtx']);
$date_ex_ins = clean($_POST['date_ex_ins']);
$type_ins = clean($_POST['type_ins']);
$value_ins = clean($_POST['value_ins']);
$date_ex_priv = clean($_POST['date_ex_priv']);
$sum_priv = clean($_POST['sum_priv']);
$value_priv = clean($_POST['value_priv']);
$color = clean($_POST['color']);
if($_FILES['document']['size'] > 0) {
    $image_document = $_FILES['document']['tmp_name'];
    $documentAllowType = array('jpg','png','jpeg','gif','pdf');
    $imgContent_doc = addslashes(file_get_contents($image_document));
    $document_name = $_FILES['document']['name'];
    $explode_name = explode(".", $document_name);
    $fileType = end($explode_name);
}
else {
    $imgContent_doc = "";
    $document_name = "";
    $fileType = "";
}

$result = addcar($car_model,$car_plate_no,$car_type,$car_owner,$car_pic,$car_pic2,$car_category,
                    $engine_no,$chassis_no,$cost_receipt,$date_receipt,$suppliers,$hire_account_no,$name_account,
                        $last_service,$next_service,$current_mileage,$next_mileage,$date_ex_rtx,$value_rtx,$date_ex_ins,
                            $type_ins,$value_ins,$color,$date_ex_priv,$sum_priv,$value_priv,$imgContent_doc,$document_name,$fileType);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            alert('Successfully add new car');
            window.location.href='../view/aims_car_list.php';
            </script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
            alert('Failed to add new car');
            window.history.back();
            </script>");
    exit();
}