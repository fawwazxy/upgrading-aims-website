<?php
require_once '../../lib/dompdf/autoload.inc.php';
require "../model/v02_attendance_function.php";
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$id = $_GET['id'];
$orientation = $_GET['orientation'] ?: 'landscape';
$date = $_GET['date'];
$list = getDailyReport($date, $id)->fetch_assoc();
$staff_info = getStaffName($id)->fetch_assoc();
$work_hour = getWorkHourReport($date, $id);
$current_time = time();
$time_in = strtotime($list['clock_in_time']);
if($list['clock_out_time'] == ''){
    $time = $current_time - $time_in;
    $total_time = secondToHoursMinutesSeconds($time);
    $reminder_time = $work_hour - $time;
    $target_description = '<tr>
                            <td>'.secondToHoursMinutesSeconds($work_hour).'</td>
                            <td>'.$total_time.'</td>
                            <td>'.secondToHoursMinutesSeconds($reminder_time).'</td>
                           </tr>';

} else {
    $total_time = secondToHoursMinutesSeconds($list['total_time']);
    $target_description = '<tr>
                            <td>'.secondToHoursMinutesSeconds($work_hour).'</td>
                            <td>'.$total_time.'</td>
                            <td>-</td>
                           </tr>';
}
if ($list['status'] == 0){
    $font_color = 'RED';
    $status = 'LATE';
} elseif ($list['status'] == 1) {
    $font_color = 'BLUE';
    $status = 'ON TIME';
} elseif ($list['status'] == 2) {
    $font_color = 'GREEN';
    $status = 'EARLY';
}
if($list['clock_in_method'] == 'PHOTO-LOG'){
    $image_in = '<tr>
                    <td style="width: 30%">Image</td>
                    <td style="width: 5%">:</td>
                    <td><img class="img" src="../../logphoto/'.$list['clock_in_photo'].'"/></td>
                 </tr>';
}
if($list['clock_out_method'] == 'PHOTO-LOG'){
    $image_out = '<tr>
                <td>Image</td>
                <td>:</td>
                <td><img class="img" src="../../logphoto/'.$list['clock_out_photo'].'"/></td>
              </tr>';
}
$clock_in_description = '<tr>
                        <td style="width: 30%">Time</td>
                        <td style="width: 5%">:</td>
                        <td>'.$list['clock_in_time'].'</td>
                      </tr>
                      <tr>
                        <td>Platform</td>
                        <td>:</td>
                        <td>'.$list['clock_in_method'].'</td>
                      </tr>
                      <tr>
                        <td>Location</td>
                        <td>:</td>
                        <td>'.$list['clock_in_remark'].'</td>
                      </tr>
                      <tr>
                        <td>Coordinate</td>
                        <td>:</td>
                        <td>'.$list['clock_in_location'].'</td>
                      </tr>';

$clock_out_description = '<tr>
                        <td style="width: 30%">Time</td>
                        <td style="width: 5%">:</td>
                        <td>'.$list['clock_out_time'].'</td>
                      </tr>
                      <tr>
                        <td>Platform</td>
                        <td>:</td>
                        <td>'.$list['clock_out_method'].'</td>
                      </tr>
                      <tr>
                        <td>Location</td>
                        <td>:</td>
                        <td>'.$list['clock_out_remark'].'</td>
                      </tr>
                      <tr>
                        <td>Coordinate</td>
                        <td>:</td>
                        <td>'.$list['clock_out_location'].'</td>
                      </tr>';
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
    <title>ATTENDANCE REPORT</title>
    <style>
        @page { 
            margin: 0.635cm;
        }
        .logo{
            width: 100px; 
            height: 120px;
            padding-bottom: 10px;
        }
        body{
            font-family: "Times New Roman", Times, serif;
            font-size: 15px;
            margin: 0.635cm;
        }
        .img{
            width: 180px; 
            height: 200px;
        }
        .title{
            font-weight: bold;
            font-size: 1.6em;
        }
        .staffphoto{
            padding-top: 10px;
            width: 80px; 
            height: 100px;
        }
        table.finance td:empty::after{
            content: "\00a0";
        }
        .total{
            width: 100%;
            border-collapse: collapse;
        }
        table.total th{
            border: 1px solid black;
            border-collapse: collapse;
            height: 15px;
        }
        table.total td{
            padding: 0 2% 0 2%;
            border: 1px solid black;
            border-collapse: collapse;
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
            padding: 0 2% 0 2%;
            border: 1px solid black;
            border-collapse: collapse;
        }
        .no{
        padding: 10px 5px 10px 5px;
            width: 100%;
            border-collapse: collapse;
        }
        table.no th{
            border: none;
            border-collapse: collapse;
            height: 15px;
        }
        table.no td{
            word-wrap: break-word;
            border: none;
            border-collapse: collapse;
            vertical-align: top;
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
    <table class="w-100 text-center" style="padding-bottom: 20px;">
        <tr>
            <td><img class="logo" src="../../resources/images/aims_logo.png" alt="logo"/></td>
        </tr>
        <tr>
            <td class="title">DAILY ATTENDANCE REPORT</td>
        </tr>
        <tr>
            <td><img src="../../staffphoto/'.$staff_info['nama_photo'].'" style="padding-top: 10px; width: 120px; height: 130px;"/></td>
        </tr>
    </table>
   
    <table class="w-100 text-left" style="padding-bottom: 20px;">
        <tr>
            <td style="width: 25%">Attendance Report For</td>
            <td style="width: 5%">:</td>
            <td>'.$staff_info['name'].'</td>
        </tr>
        <tr>
            <td style="width: 25%">Company</td>
            <td style="width: 5%">:</td>
            <td>'.$staff_info['jabatan'].'</td>
        </tr>
        <tr>
            <td>Report Date</td>
            <td>:</td>
            <td>'.$list['report_date'].'</td>
        </tr>
    </table>
    <table class="total" style="padding-bottom: 20px;">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 33.33%">Target Hour</th>
                            <th style="width: 33.33%">Total Hours</th>
                            <th style="width: 33.33%">Hours Remaining</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        '.$target_description.'
                  </tbody>
    </table>
    <table class="time">
                    <thead>
                        <tr class="text-center">
                            <th style="width: 43%">Clock In</th>
                            <th style="width: 43%">Clock Out</th>
                            <th style="width: 14%">Status</th>
                        </tr>
                    </thead>se
                    <tbody>
                        <tr>
                            <td sty>
                                <table class="no">
                                    '.$clock_in_description.'
                                </table>
                            </td>
                            <td>
                                <table class="no">
                                    '.$clock_out_description.'
                                </table>
                            </td>
                            <td rowspan="2" class="text-center" style="vertical-align: top; padding-top: 10px">'.$status.'</td>
                        </tr>
                        <tr>
                            <td>
                                <table class="no">
                                    '.$image_in.'
                                </table>
                            </td>
                            <td>
                                <table class="no">
                                    '.$image_out.'
                                </table>
                            </td>
                        </tr>
                  </tbody>
    </table>
</body>
</html>';

/*<div style="text-align:left;margin-top: 50px">
    <h3><b><i>** THIS FORM IS GENERATED BY SYSTEM AND NO SIGNATURE IS REQUIRED</i></b></h3>
</div>*/

// Generate PDF from HTML ----------------------------------------------------------------------------------------------
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'potrait');
$dompdf->render();
ob_end_clean();
$dompdf->stream("Daily_Report",array("Attachment"=>0));
?>