<?php
session_start();
require_once '../../lib/dompdf/autoload.inc.php';
require "../model/v02_aims_leave_function.php";

use Dompdf\Dompdf;
$table_row = "";
$i=1;

//declare variable for session data
$staff_id = $_SESSION['SESS_ID'];
$staff_department = $_SESSION['SESS_DEPARTMENT'];

//get parameter from URL
$hr_check = ($_GET['c']) ?: 'NULL';
$leave_type = ($_GET['type']) ?: 'al';
$company = ($_GET['company']) ?: ($staff_department) ?: 'AGHSB';
$custom_company = ($_GET['company'] == 'MOCSB') ? 'AGESB' : ($_GET['company'] ?: $staff_department ?: 'AGHSB');

$month = ($_GET['month']) ?: '0';
$year = ($_GET['year']) ?: date('Y');

$month_text = ($month=='0')?"Semua":$month;
if ($hr_check == 'NULL'){
    $check = "DALAM PROSES";
}else if ($hr_check == 'YES'){
    $check = "DISEMAK";
}else{
    $check = "DITOLAK";
}

$leave_list = getLeaveCheckList($staff_id, $hr_check, $leave_type, $company, $month, $year);

if ($leave_list->num_rows == 0){
    $trow = '<tr><td colspan="10" class="text-center">Tiada data dijumpai</td></tr>';
}
while ($list = $leave_list->fetch_assoc()) {
    $remark = ($list['remark']) ? "<br><br><b>Catatan: </b><p>".$list['remark']."</p>" : "";
    $balance = ($list['balance_after_checked']) ? "<b>Baki: </b>".(float)$list['balance_after_checked']." hari" : "";
    $start_time = strtotime($list['start_date']);
    $end_time = strtotime($list['end_date']);

    $start_date_dmY = date('d/m/Y', $start_time);
    $end_date_dmY = date('d/m/Y', $end_time);

    $leave_date = ($list['start_date'] == $list['end_date'])
        ? "<b class='text-green'>" . getDayName(date('w', $start_time)) . ", " . $start_date_dmY . "</b>"

        : "<b class='text-green'>" . getDayName(date('w', $start_time)) . ", " . $start_date_dmY . "</b>
                                                hingga <b class='text-red'>" . getDayName(date('w', $end_time)) . ", " . $end_date_dmY . "</b>";

    $hr_checked_at = (!empty($list['hr_checked_at'])) ? date('d/m/Y h:i:s a', strtotime($list['hr_checked_at'])) : "";
    if ($list['hr_checked_status'] == '1') { $hr_check_text = "<b class='text-green'>DISEMAK</b>"; }
    else if ($list['hr_checked_status'] == '0') { $hr_check_text = "<b class='text-red'>DITOLAK</b>"; }
    else { $hr_check_text = "<b class='text-muted'>DALAM PROSES</b>"; }
    $hr_check_text .= "<br><span class='text-capitalize'>".strtolower(getStaffName($list['hr_checked_by']))."<br>".$hr_checked_at."</span>";

    $approval_by = ($list['approval_by'] == '0')? "Auto-Approved":strtolower(getStaffName($list['approval_by']));
    $department_id = ($list['department_id'] == 'MOCSB')? "AGESB":$list['department_id'];

    //store all row data into variable
    $table_row .= '
    <tr>
        <td>'.$i++.'.</td>
        <td>'.$list['created_at'].", ".getDayName(date('w', strtotime($list['created_at']))).'</td>
        <td>
            <b>Nama: </b>'.$list['name'].'<br>
            <b>Bahagian: </b>'.$department_id.'<br>
            <b>Unit: </b>'.$list['department_sub'].'<br>
        </td>
        <td>
            <b>Tarikh: </b>'.$leave_date.'<br>
            <b>Jumlah: </b>'.(float)$list['total_days'].' hari<br>
            '.$balance.'
        </td>
        <td>'.$list['description'].$remark.'</td>
        <td>
            <b class="text-green">LULUS</b><br>
            <span class="text-capitalize">'.$approval_by.'<br>'.date('d/m/Y h:i:s a', strtotime($list['approval_at'])).'</span>
        </td>
        <td>'.$hr_check_text.'</td>
    </tr>';
}

$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/x-icon" href="../../resources/images/logo_ioffice.jpeg" />
    <title>Cetak senarai cuti</title>
    <style>
        body{
            font-family: Arial, sans-serif;
        }
        table{
        table-layout: fixed;
        }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
            font-size: 12px;
        }
        th {
            color: #ffffff;
            padding-left: 0.25rem;
        }
        td {
            padding-left: 0.25rem;
        }
        .text-capitalize{
            text-transform: capitalize;
        }
        .text-center{
            text-align: center !important;
        }
        .text-dark{
            color: #282f3a !important;
        }
        .text-white{
            color: #ffffff !important;
        }
        .text-muted{
            color: #737F8B !important;
        }
        .text-green{
        color: #00a900
        }
        .text-red{
            color: #d60008
        }
        img{
            margin: 0.5rem 0;
            height: 88px;
            width: auto;
        }
    </style>
</head>
<body>
<table class="" style="width: 100%;" role="grid" id="leavePrint">
    <thead>
    <tr class="text-dark">
        <td style="border-right-color: #ffffff"></td>
        <td colspan="1" class="" style="border-right-color: #ffffff; text-align: left">
            <img src="../../resources/images/aims_logo.png" alt="aims-logo">
        </td>
        <td colspan="5" class="text-left" style="line-height: 1.5; padding-left: -64px">
                <b>AIMS-GLOBAL GROUP</b><br>
                BLOK B & BLOK C, BESTARI CENTRE, JALAN HILIRAN,<br>
                20300 KUALA TERENGGANU, TERENGGANU<br>
                TEL: +603-622 8848
        </td>
    </tr>
    <tr class="text-dark">
        <td colspan="5" style="padding-left: 1rem">
        <b>Jenis Cuti:</b> '.getLeaveType($leave_type).'; &nbsp;
        <b>Status Semakan:</b> '.$check.'; &nbsp;
        <b>Syarikat:</b> '.$custom_company.'; &nbsp;
        <b>Bulan:</b> '.$month_text.'; &nbsp;
        <b>Tahun:</b> '.$year.';
        </td>
        <th colspan="2" style="padding-left: 1rem" class="text-center">Dijana pada: '.date('d/m/Y h:i:sa', time()).'</th>
    </tr>
    <tr class="" style="background-color: #3b3b3b">
        <th style="width: 3%">#</th>
        <th style="width: 15%">Tarikh mohon</th>
        <th style="width: 20%">Maklumat Pemohon</th>
        <th style="width: 15%">Maklumat Cuti</th>
        <th style="width: 15%">Sebab</th>
        <th style="width: 17%">Kelulusan</th>
        <th style="width: 15%">Semakan HR</th>
    </tr>
    </thead>
    <tbody>
    '.$table_row.'
    </tbody>
</table>';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
ob_end_clean();
$dompdf->stream("report_leave",array("Attachment"=>0));
