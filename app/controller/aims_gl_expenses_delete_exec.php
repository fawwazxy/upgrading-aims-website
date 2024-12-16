<?php
include "../model/aims_gl_function.php";

$id = clean($_GET['id']);

$result = deleteExpenses($id);

if($result != "" && $result > 0) {
    echo ("<script type='text/javascript'>
		window.location.href='../view/aims_gl_expenses.php';
		</script>");
    exit();
} else {
    die("Query failed");
}