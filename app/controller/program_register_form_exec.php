<?php
include "../controller/auth.php";
require "../model/dashboard_functions.php";

$id = clean($_POST['id']);
$staff_id = clean($_POST['staff_id']);
$description = clean($_POST['description']);

if($id == ''){
    echo "<script type='text/javascript'>
            alert('We are sorry. Registration has been closed.');
            window.history.back();
            </script>";
    exit();
}

$result = programRegisterAddOrUpdate($id, $staff_id, $description);

if($result) {
    echo "<script>
            alert('You have successfully registered for Aims-Portal Mobile BETA');
			window.history.back();
			</script>";
}else{
    echo "<script>
            alert('Failed to registered for Aims-Portal Mobile BETA');
			window.history.back();
			</script>";
}
