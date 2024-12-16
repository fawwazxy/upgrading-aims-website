<?php
require '../../lib/db/connection.php';
$conn = db();
$months = array('JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER');
$year = ($_GET['year'])?: date('Y');
$count_amount = array();
$count_closed = array();
foreach ($months as $month) {
    $request_amount = "SELECT SUM(total_claim) AS claim_amount FROM v02_aims_others_claim WHERE month_claim LIKE '%$month $year%'";
    $result = $conn->query($request_amount)->fetch_object()->claim_amount;
    array_push($count_amount, $result);

    $closed_amount = "SELECT SUM(total_claim) AS closed_amount FROM v02_aims_others_claim WHERE month_claim LIKE '%$month $year%' AND payment_status = 'CLOSED'";
    $result2 = $conn->query($closed_amount)->fetch_object()->closed_amount;
    array_push($count_closed, $result2);
}
echo json_encode([$count_amount,$count_closed]);
