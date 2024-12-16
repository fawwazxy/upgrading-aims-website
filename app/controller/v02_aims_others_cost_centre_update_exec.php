<?
include "../model/v02_aims_others_claim_function.php";

$id = $_POST['id'];
$cost_centre = $_POST['cost_centre'];
$company_name = $_POST['company_name'];
$type_claim = $_POST['type_claim'];
$description = $_POST['description'];

$result = v02updateCostCentre($id, $cost_centre, $company_name, $type_claim, $description);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            alert('Cost Centre successfully updated.')
            window.location.href='../view/v02_aims_others_cost_centre_list.php';
            </script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
            alert('Failed to update cost centre.')
            history.back();
            </script>");
    exit();
}