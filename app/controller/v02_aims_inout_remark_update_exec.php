<?php
include "../model/v02_aims_inout_function.php";

$id = clean($_POST['inout_id']);
$remark = clean($_POST['remark']);
$result = inOutUpdateRemark($id, $remark);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    echo ("<script>
			alert('In/Out remark has been updated');
			window.history.back();
			</script>");
} else {
    echo ("<script>
			alert('In/Out remark failed to update');
			window.history.back();
			</script>");
}
