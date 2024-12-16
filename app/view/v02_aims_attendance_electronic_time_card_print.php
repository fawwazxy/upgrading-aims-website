<?php
require_once '../../lib/dompdf/autoload.inc.php';
require "../model/v02_attendance_function.php";
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$id = $_GET['id'];
$month = $_GET['month'];
$year = $_GET['year'];
$name_month = date('F', $month);
$staff_info = getStaffName($id)->fetch_assoc();


$description = "";
$i= 1;
$workday = 0;
$present = 0;
$absent = 0;
$sum_overtime = 0;
$sum_short = 0;
$data = getElectronicTimeCardDate($id, $month, $year);
if ($data->num_rows == 0){
    $description = '<tr><td colspan="11" class="text-center">No Data Found</td></tr>';
} else{
    while($row_data = $data->fetch_assoc()) {
        $row_present_absent = getTotalAttendance($row_data['date'], $id);
        $row_total_days = workHourArray($staff_info['noic'], $month, $year);
        $row_att = getElectronicTimeCardAttendance($row_data['date'], $id)->fetch_assoc();
        // attendance status
        if ($row_att['status'] == null) {
            $status = ' ';
        } elseif ($row_att['status'] == 0) {
            $font_color = 'RED';
            $status = 'LATE';
        } elseif ($row_att['status'] == 1) {
            $font_color = 'BLUE';
            $status = 'ON TIME';
        } elseif ($row_att['status'] == 2) {
            $font_color = 'GREEN';
            $status = 'EARLY';
        }
        // work day type
        if ($row_data['workday'] == 0) {
            $type = 'OFFDAY';
        } elseif ($row_data['workday'] == 1) {
            $type = 'WORKDAY';
        }
        // overtime & short
        $current_time = time();
        $time_in = strtotime($row_att['clock_in_time']);
        $total_time = $current_time - $time_in;
        $shift = getShiftDaily($row_data['date'], $id);
        $not_count = $shift - $row_att['total_time'];
        if ($row_att['total_time'] == null) {
            $overtime = '';
            $short = '';
        } else {
            if ($not_count < 0) {
                $overtime = abs($not_count);
                $short = '';
                $sum_overtime += $overtime;
            } else {
                $overtime = '';
                $short = abs($not_count);
                $sum_short += $short;
            }
        }
        // leave taken
        if ($row_data['public_holiday'] == 1) { //check holiday or not
            $leave_taken = $row_data['public_description'];
        } elseif ($row_data['workday'] == 0) { // check offday
            $leave_taken = '';
        }elseif ($row_att['clock_in_time'] == null) { //check cuti
            $row_leave = getElectronicTimeCardLeave($row_data['date'], $id)->fetch_assoc();
            $leave_types = [
                'al' => 'ANNUAL LEAVE',
                'ul' => 'UNPAID LEAVE',
                'pl' => 'PATERNITY LEAVE',
                'ml' => 'MATERNITY LEAVE',
                'cfl' => 'CARRY FORWARD LEAVE',
                'rl' => 'OVERTIME REPLACEMENT LEAVE',
                'cl' => 'COMPASSIONATE LEAVE',
                'hl' => 'HOSPITALIZATION LEAVE',
                'rlu' => 'REPLACEMENT LEAVE'
            ];
            $leave_type = $leave_types[$row_leave['leave_type']];
            if ($leave_type == ''){
                $absent++;
                $leave_taken="ABSENT";
            } else {
                $leave_taken = '<b>'.'<span>'.$leave_type.'</span>'.'</b>
                                <br>'.$row_leave['start'].' - '.$row_leave['end'];
                }
        } else {
            $leave_taken = '';
            $present++;
        }

        $description .= '<tr>
                            <td>'.$row_data['date'].'</td>
                            <td>'.$row_data['day'].'</td>
                            <td>'.(($row_data['public_holiday']==1)?'HOLIDAY':$type).'</td>
                            <td style="color: '.$font_color.'">'.$status.'</td>
                            <td>'.$row_att['time_in'].'</td>
                            <td>'.$row_att['time_out'].'</td>
                            <td>'.(($row_att['total_time']=='')?'':secondToHoursMinutesSeconds($row_att['total_time'])).'</td>
                            <td>'.(empty($overtime)?'':secondToHoursMinutesSeconds($overtime)).'</td>
                            <td>'.(empty($short)?'':secondToHoursMinutesSeconds($short)).'</td>
                            <td>In: '.$row_att['clock_in_remark'].'<br>
                                Out: '.$row_att['clock_out_remark'].'</td>
                            <td style="text-transform: uppercase">
                                '.$leave_taken.'
                            </td>
                        </tr>';
        $total_description ='<tr>
                                <td>'.$row_total_days['days'].'</td>
                                <td>'.$present.'</td>
                                <td>'.$absent.'</td>
                                <td>'.secondToHoursMinutesSeconds($sum_overtime).'</td>
                                <td>'.secondToHoursMinutesSeconds($sum_short).'</td>
                              </tr>';
    }
}

//Generate full html (to be converted to PDF) --------------------------------------------------------------------------
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/x-icon" href="../../resources/images/aims_logo.png" />
    <title>Electronic_Time_Card</title>
    <style>
        @page { 
            margin: 0.635cm;
        }
        .logo{
            width: 70px; 
            height: 80px;
        }
        body{
            font-family: "Times New Roman", Times, serif;
            font-size: 11px;
            margin: 0.635cm;
        }
        .img{
            width: 180px; 
            height: 200px;
        }
        .title{
            font-weight: bold;
            font-size: 20px;
        }
        .name {
            font-size: 15px;
        }
        .time{
            width: 100%;
            border-collapse: collapse;
        }
        table.time th{
            border: 1px solid black;
            border-collapse: collapse;
            height: 15px;
        }
        table.time td{
            padding: 5px 2% 5px 2%;
            border: 1px solid black;
            border-collapse: collapse;
        }
        .text-center{
            text-align: center;
        }
        .text-left{
            text-align: left;
        }
        .w-100{
            width: 100%;
        }
        .separator{
            margin: 4px 0;
        }
    </style>
</head>
<body>
    <table class="w-100" style="padding-bottom: 20px;">
        <tr>
            <td style="width: 20%; text-align: center"><img class="logo" src="../../resources/images/aims_logo.png" alt="logo"/></td>
            <td style="vertical-align: top">
                <div class="title">ELECTRONIC TIME CARD</div>
                <div class="name">'.$staff_info['name'].'<br>'.$staff_info['jabatan'].'</div>
            </td>
            <td class="title" style="vertical-align: top; font-weight: bold; text-transform: uppercase; text-align: right; padding-right: 30px">'.$name_month.' '.$year.'</td>
        </tr>
    </table>
    
    <table class="time" style="padding-bottom: 10px">
            <thead>
                <tr class="text-center">
                    <th style="width: 10%">Date</th>
                    <th style="width: 10%">Day</th>
                    <th style="width: 10%">Day Type</th>
                    <th style="width: 10%">Status</th>
                    <th style="width: 10%">In</th>
                    <th style="width: 10%">Out</th>
                    <th style="width: 20%">Work</th>
                    <th style="width: 20%">Overtime</th>
                    <th style="width: 20%">Short</th>
                    <th style="width: 20%">Location</th>
                    <th style="width: 20%">Leave Taken</th>
                </tr>
            </thead>
            <tbody>
                '.$description.'
          </tbody>
    </table>
    <table class="time">
            <thead>
                <tr class="text-center">
                    <th style="width: 20%">Total Days</th>
                    <th style="width: 20%">Present</th>
                    <th style="width: 20%">Absent</th>
                    <th style="width: 20%">Overtime</th>
                    <th style="width: 20%">Short</th>
                </tr>
            </thead>
            <tbody class="text-center">
                '.$total_description.'
          </tbody>
    </table>
</body>
</html>';
// Generate PDF from HTML ----------------------------------------------------------------------------------------------
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
ob_end_clean();
$dompdf->stream("Electronic Time Card",array("Attachment"=>0));
?>