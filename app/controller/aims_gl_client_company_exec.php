<?php
include "../model/aims_gl_function.php";

$code_company = clean($_POST['code_company']);
$company_name = clean($_POST['company_name']);

$result = addCompanyClient($code_company,$company_name);

if($result != "" && $result > 0) {
    echo ("<script type='text/javascript'>
            window.location.href='../view/aims_gl_client_company.php';
            </script>");
    exit();
} else {
    die("Query failed");
}