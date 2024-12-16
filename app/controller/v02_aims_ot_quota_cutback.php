<?php
include "../model/v02_aims_ot_function.php";

$yesterday = date("Y-m-d", strtotime(" -1 day"));

$yesterday_ot = v02getYesterdayOt($yesterday);

$query_count = 0;
$success_count = 0;

while ($row = $yesterday_ot->fetch_assoc()){
    
    //re-check today overused in the loop using id (v02_aims_ot_date) - To encounter claim (more than 4 hours) with same created at
    $new_overused = v02getOverusedById($row['id']);
    
    $today = date("Y-m-d", strtotime($row['date'].' +1 day'));
    
    $result = v02createDateQuotaCutback($row['month_session_id'], $today, $new_overused); 
    // isu bila isi claim (yg ada overused) pada hari sama, loop xkan update date summary sblm buat quota cutback [solution trial 18/07/2022]

    //check whether the query was successful or not
    if($result){
        $success_count++;
    }
    $query_count++;
}
print_r($yesterday_ot);
echo "Success: ".$success_count.' / '.$query_count;