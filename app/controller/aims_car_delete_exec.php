<?php
include "../model/aims_car_function.php";

$id = $_GET['id'];

$result = deleteCarInfo($id);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            alert('Successfully delete car info');
            window.location.href='../view/aims_car_list.php';
            </script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
            alert('Failed to delete car info');
            window.history.back();
            </script>");
    exit();
}