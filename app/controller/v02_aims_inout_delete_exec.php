<?php
include "../model/v02_aims_inout_function.php";

$id = clean($_GET['id']);
$result = deleteInOut($id);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    echo ("<script>
			alert('In/Out application successfully deleted');
			window.history.back();
			</script>");
} else {
    echo ("<script>
			alert('Failed to delete the application');
			window.history.back();
			</script>");
}










