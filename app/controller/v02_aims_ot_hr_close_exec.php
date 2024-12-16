<?php
include "../model/v02_aims_ot_function.php";

$id = $_GET['id'];
$result = v02closeOtClaim($id);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
	echo ("<script>
			alert('Successfully Close Payment for selected month');
			window.history.back();
			</script>");
	exit();
} else {
	echo ("<script>
			alert('Failed to close payment!');
			window.history.back();
			</script>");
	exit();
}









