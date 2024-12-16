<?php
require '../../lib/db/connection.php';
$conn = db();
$year = ($_GET['year'])?: date('Y');
$case = $_GET['case'] ?: 'graph_line';

//bar chart
$months = array('JANUARY', 'FEBRUARY', 'MARCH', 'APRIL', 'MAY', 'JUNE', 'JULY', 'AUGUST', 'SEPTEMBER', 'OCTOBER', 'NOVEMBER', 'DECEMBER');
//pie chart
$companies = array('AGHSB', 'AGESB', 'AGIRSB', 'AGMHESB', 'AGMSB', 'AVSB', 'MAHSB', 'KTPSB', 'TKSB', 'AMASB', 'KTSKILL', 'AGSHIMSB', 'MOCSB');

$data = [];

$data_weekday = array();
$data_weekend = array();
$data_holiday = array();
$data_special = array();

switch ($case){
    case 'graph_line':

        foreach ($months as $month) {
            $weekday_amount = "SELECT SUM(normal_totalwages) as weekday_amount FROM v02_aims_ot_month_session WHERE month_session LIKE '%$month $year%'";
            $result = $conn->query($weekday_amount)->fetch_object()->weekday_amount;

            array_push($data_weekday, $result);

            $weekend_amount = "SELECT SUM(weekend_totalwages) as weekend_amount FROM v02_aims_ot_month_session WHERE month_session LIKE '%$month $year%'";
            $result2 = $conn->query($weekend_amount)->fetch_object()->weekend_amount;

            array_push($data_weekend, $result2);

            $holiday_amount = "SELECT SUM(holiday_totalwages) as holiday_amount FROM v02_aims_ot_month_session WHERE month_session LIKE '%$month $year%'";
            $result3 = $conn->query($holiday_amount)->fetch_object()->holiday_amount;

            array_push($data_holiday, $result3);

            $special_amount = "SELECT SUM(special_totalwages) as special_amount FROM v02_aims_ot_month_session WHERE month_session LIKE '%$month $year%'";
            $result4 = $conn->query($special_amount)->fetch_object()->special_amount;

            array_push($data_special, $result4);
        }
        echo json_encode([$data_weekday,$data_weekend,$data_holiday,$data_special]);
        break;

    case 'pie_chart';
        foreach ($companies as $company){
            $department = "SELECT SUM(m.total_claim) as department_amount FROM v02_aims_ot_month_session m
            LEFT JOIN staff s ON s.id = m.staff_id
            WHERE m.month_session LIKE '%$year%' AND s.department_id LIKE '%$company%'";
            $data[] = ['label' => $company, 'data' => $conn->query($department)->fetch_object()->department_amount];
        }
        echo json_encode($data);
        break;
}
