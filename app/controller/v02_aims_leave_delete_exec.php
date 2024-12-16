<?php
include "../model/v02_aims_leave_function.php";

$id = clean($_GET['id']);
$result = deleteLeave($id);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    echo ("<script>
			alert('Leave application successfully deleted');
			window.history.back();
			</script>");
} else {
    echo ("<script>
			alert('Failed to delete leave request');
			window.history.back();
			</script>");
}









