<?
include "../model/staff_function.php";

$no_staff= clean($_GET['no_staff']);
$result= UpdateStatusStaff($no_staff);

if($result) {
    echo ("<script type='text/javascript'>
        history.back();
        </script>");
    exit();
}else {
    die("Query failed");
}
?>