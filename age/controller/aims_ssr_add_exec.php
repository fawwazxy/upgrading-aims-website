<?php

include "../model/aims_ssr_function.php";

$ssr_id = $_POST['ssr_id'];
$ssr_name = $_POST['ssr_name'];
$descItem= nl2br(strtoupper($_POST['descItem']));
//$descItem= $_POST['descItem'];
$unit = $_POST['unit'];
$quantity_required = $_POST['quantity_required'];
$balance_board = $_POST['balance_board'];
$quantity_approved = $_POST['quantity_approved'];
$impa_code= $_POST['impa_code'];
$remarks = $_POST['remarks'];

//print_r($_POST);
//exit();

$result = shipstoreTambahBaru($ssr_id,$ssr_name,$descItem,$unit,$quantity_required,$balance_board,$quantity_approved,$impa_code,$remarks);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            alert('Successfully added.')
            window.location.href='../view/shipstores.php?ssr_no=".$ssr_name."&id=".$ssr_id."';
            </script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
            alert('Failed to add new.')
            history.back();
            </script>");
    exit();
}

?>