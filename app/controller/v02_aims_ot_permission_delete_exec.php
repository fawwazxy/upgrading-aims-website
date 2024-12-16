<?php
include "../model/v02_aims_ot_function.php";

$id = clean($_GET['id']);
$result = v02deleteOtPermission($id);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
	echo ("<script>
			alert('Successfully delete OT Permission');
			window.history.back();
			</script>");
	exit();
} else {
    echo ("<script>
			alert('Failed to delete OT Permission!');
			window.history.back();
			</script>");
    exit();
}









