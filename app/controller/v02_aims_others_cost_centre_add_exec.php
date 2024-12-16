<?
include "../model/v02_aims_others_claim_function.php";

//Sanitize the POST values
$cost_centre = $_POST['cost_centre'];
$company_name = $_POST['company_name'];
$type_claim = $_POST['type_claim'];
$description = $_POST['description'];

$result = v02addCostCentre($cost_centre, $company_name, $type_claim, $description);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    echo ("<script type='text/javascript'>
            alert('Cost Centre successfully added.')
            window.location.href='../view/v02_aims_others_cost_centre_list.php';
            </script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
            alert('Failed to add cost centre.')
            history.back();
            </script>");
    exit();
}