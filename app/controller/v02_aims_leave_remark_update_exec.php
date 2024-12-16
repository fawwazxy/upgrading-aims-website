<?php
include "../model/v02_aims_leave_function.php";

$id = clean($_POST['leave_id']);
$remark = clean($_POST['remark']);
$result = updateRemark($id, $remark);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    echo ("<script>
			alert('Leave application remarks has been successfully updated.');
			window.history.back();
			</script>");
} else {
    echo ("<script>
			alert('Failed to update leave application remarks');
			window.history.back();
			</script>");
}
