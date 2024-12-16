<?php
include "../model/v02_aims_medical_function.php";

$id = clean($_GET['id']);
$result = deleteMedicalQuota($id);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    echo ("<script>
			alert('Medical Quota successfully deleted');
			window.history.back();
			</script>");
} else {
    echo ("<script>
			alert('Failed to delete medical quota');
			window.history.back();
			</script>");
}









