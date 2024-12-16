<?php
include "../model/aims_gl_function.php";

$id = clean($_POST['id']);
$description = clean($_POST['description']);
$code = clean($_POST['code']);

$result = updateUtilityDesc($description,$code,$id);

if($result != "" && $result > 0) {
    echo ("<script type='text/javascript'>
            window.location.href='../view/aims_gl_utility_desc.php';
            </script>");
    exit();
} else {
    die("Query failed");
}