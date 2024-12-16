<?php
include "../model/v02_aims_others_claim_function.php";

$id = $_POST['id'];
$job_no = $_POST['job_no'];
$datetime_departure = $_POST['datetime_departure'];
$datetime_arrival = $_POST['datetime_arrival'];
$month_claim = $_POST['month_claim'];
$auth_id = ($_POST['auth_id']) ?: null;
$description = str_replace("'", "\'", $_POST['description']);

$result = v02updateOthersClaim($id,$job_no,$datetime_departure,$datetime_arrival,$month_claim,$description, $auth_id);

$message = ($result!="" && $result > 0) ? "Claim updated successfully." : "Failed to update claim.";
?>
<script type='text/javascript'>
    alert('<? echo $message ?>');
    history.back();
</script>
