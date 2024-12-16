<?
include "../model/v02_aims_others_claim_function.php";

/*Get verification from previous page*/
$prev_verification = $_POST['verification'];

/*If user checked the checkbox*/
if (isset($_POST['checkbox'])){
    /*get data*/
    $checkbox = $_POST['checkbox'];
    /*veficication_by == INDEEP0014 */
    $verification_by = $_POST['auth_id'];
    $verification_status = ($_POST['verification_status'] == "CHECK") ? '1' : '0';
    /*implode = returns string from elements of array */
    $id = "('" . implode("','", $checkbox) . "');";
    /* --> print_r($id) = ('11','13','14') */

    $result = v02OthersClaimCheck($id, $verification_by,$verification_status);

    if ($result!="" && $result > 0){
        echo ("<script type='text/javascript'>
        alert('Successfully Unchecked Selected Claim');
       history.back();
        </script>");
        /*window.history.back() == load the previous URL (page) */
        exit();
    } else {
        die("Failed to Unchecked ".$result);
    }
} else {
    echo ("<script type='text/javascript'>
    alert('Please select at least one claim');
    window.history.back();
    </script>");
    exit();
}

?>