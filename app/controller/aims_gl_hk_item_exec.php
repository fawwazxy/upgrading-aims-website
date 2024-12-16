<?php
include "../model/aims_gl_function.php";

$item = clean($_POST['item']);
$code = clean($_POST['code']);

$result = addItemHk($item,$code);

if($result != "" && $result > 0) {
    echo ("<script type='text/javascript'>
            window.location.href='../view/aims_gl_hk_item.php';
            </script>");
    exit();
} else {
    die("Query failed");
}