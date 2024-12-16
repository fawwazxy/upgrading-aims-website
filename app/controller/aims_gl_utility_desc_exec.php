<?php
include "../model/aims_gl_function.php";

$description = clean($_POST['description']);
$code = clean($_POST['code']);

$result = addUtilityDesc($description,$code);

if($result != "" && $result > 0) {
    echo ("<script type='text/javascript'>
            window.location.href='../view/aims_gl_utility_desc.php';
            </script>");
    exit();
} else {
    die("Query failed");
}