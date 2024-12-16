<?php
include "../model/v02_aims_ot_function.php";

if(isset($_POST['checkbox'])) {
	$checkbox = $_POST['checkbox'];
	$verification_by = clean($_POST['staff_id']);
	$verification_status = ($_POST['verification_status'] == "VERIFY") ? '1' : '0';
	$id = "('" . implode("','", $checkbox) . "');";
	$result = v02CheckboxVerifyOtClaim($id, $verification_by, $verification_status);

	//Check whether the query was successful or not
	if($result!="" && $result > 0){
		echo ("<script>
            alert('Successfully Verify/Reject selected OT Claim');
            window.history.back();
            </script>");
		exit();
	}else{
		die("Query failed: ".$result);
	}
}else{
	echo ("<script>
            alert('Please select at least one OT Claim');
            window.history.back();
            </script>");
	exit();
}
