<?php
require '../../lib/db/connection.php';

    $conn = db();
    $months = array('01', '02', '03','04','05','06','07','08','09','10','11','12');
    $year = ($_GET['year'])?: date('Y');
    $count_medical = array();
    $count_released = array();
    $count_unreleased = array();
    foreach ($months as $month) {
        $medical_analysis = "SELECT SUM(total_claim) AS medical_amount FROM v02_aims_medical WHERE hr_verify_status = '1' 
                                AND created_at LIKE '%$year-$month%'";
        $result = $conn->query($medical_analysis)->fetch_object()->medical_amount;
        array_push($count_medical, $result);

        $released_analysis = "SELECT COUNT(id) AS released_count FROM v02_aims_medical WHERE payment_closed_at IS NOT NULL  
                                AND created_at LIKE '%$year-$month%'";
        $result2 = $conn->query($released_analysis)->fetch_object()->released_count;
        array_push($count_released, $result2);


    }
    echo json_encode([$count_medical, $count_released]);

?>



