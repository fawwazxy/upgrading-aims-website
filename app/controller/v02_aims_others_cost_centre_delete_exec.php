<?php
include "../model/v02_aims_others_claim_function.php";

$id = $_GET['id'];
$result =  v02DeleteCostCentre($id);

if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            alert('Cost Centre successfully delete.')
            window.location.href='../view/v02_aims_others_cost_centre_list.php';
            </script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
            alert('Failed to delete cost centre.')
            history.back();
            </script>");
    exit();
}

?>
