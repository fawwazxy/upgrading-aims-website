<?php
include "../model/v02_aims_medical_function.php";

$id = clean($_GET['id']);
$result = deleteMedical($id);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    echo ("<script>
			alert('Medical claim successfully deleted');
			window.history.back();
			</script>");
} else {
    echo ("<script>
			alert('Medical claim fail to deleted');
			window.history.back();
			</script>");
}









