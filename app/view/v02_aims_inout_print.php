<?php
session_start();
require_once '../../lib/dompdf/autoload.inc.php';
require "../model/v02_aims_inout_function.php";

use Dompdf\Dompdf;
$table_row = "";
$i=1;

//declare variable for session data
$staff_id = $_SESSION['SESS_ID'];
$staff_department = $_SESSION['SESS_DEPARTMENT'];

//get parameter from URL
$hr_check = ($_GET['c']) ?: 'NULL';
$company = ($_GET['company']) ?: ($staff_department) ?: 'AGHSB';
$custom_company = ($_GET['company'] == 'MOCSB') ? 'AGESB' : ($_GET['company'] ?: $staff_department ?: 'AGHSB');
$month = ($_GET['month']) ?: '0';
$year = ($_GET['year']) ?: '0';

$month_text = ($month=='0')?"All":$month;
$year_text = ($year=='0')?"All":$year;
if ($hr_check == 'NULL'){
    $check = "IN PROGRESS";
}else if ($hr_check == 'YES'){
    $check = "CHECKED";
}else{
    $check = "REJECTED";
}

$inout_list = getInOutCheckList($staff_id, $hr_check, $company, $month, $year);

if ($inout_list->num_rows == 0){
    $trow = '<tr><td colspan="10" class="text-center">No Data Found</td></tr>';
}
while ($list = $inout_list->fetch_assoc()) {
    $remark = ($list['remark']) ? "<br><br><b>Remark: </b><p>".$list['remark']."</p>" : "";
    $time_out = strtotime($list['time_out']);
    $time_in = strtotime($list['time_in']);

    $time_out_dmY = date('d/m/Y', $time_out);
    $time_in_dmY = date('d/m/Y', $time_in);

    $approve_by = ($list['approve_by'] == '0') ? "Auto-Approved" : strtolower(getStaffName($list['approve_by']));
    $approve_at = (!empty($list['approve_at'])) ? date('d/m/Y h:i:s a', strtotime($list['approve_at'])) : "";
    if ($list['approve_status'] == '1') { $approve_text = "<b class='text-green'>APPROVED</b>"; }
    else if ($list['approve_status'] == '0') { $approve_text = "<b class='text-red'>DISAPPROVED</b>"; }
    else { $approve_text = "<b class='text-muted'>IN PROGRESS</b>"; }

    $hr_checked_at = (!empty($list['hr_checked_at'])) ? date('d/m/Y h:i:s a', strtotime($list['hr_checked_at'])) : "";
    if ($list['hr_checked_status'] == '1') { $hr_check_text = "<b class='text-green'>CHECKED</b>"; }
    else if ($list['hr_checked_status'] == '0') { $hr_check_text = "<b class='text-red'>REJECTED</b>"; }
    else { $hr_check_text = "<b class='text-muted'>IN PROGRESS</b>"; }
    $hr_check_text .= "<br><span class='text-capitalize'>".strtolower(getStaffName($list['hr_checked_by']))."<br>".$hr_checked_at."</span>";

    $department_id = ($list['department_id'] == 'MOCSB')? "AGESB":$list['department_id'];

    //store all row data into variable
    $table_row .= '
    <tr>
        <td>'.$i++.'.</td>
        <td>'.date('d/m/Y h:i:sa, l', strtotime($list['created_at'])).'</td>
        <td>
            <b>Name: </b>'.$list['name'].'<br>
            <b>Department: </b>'.$department_id.'<br>
            <b>Unit: </b>'.$list['department_sub'].'<br>
        </td>
        <td>
             <b>Description: </b>'.$list['description'].'<br>
             <b>Date: </b>'.$list['date'].'<br>
             <b>Time Out: </b>'.$list['time_out'].'<br>
             <b>Time In: </b>'.$list['time_in'].'<br>
         </td>
        <td>
            <b class="text-green">'.$approve_text.'</b><br>
            <span class="text-capitalize">'.$approve_by.'<br>
            '.$approve_at. '</span>
        </td>
        <td>'.$hr_check_text.'</td>
        <td></td>
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
    <title>Print In/Out List</title>
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
<table class="" style="width: 100%;" role="grid" id="InOutPrint">
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
        <td colspan="4" style="padding-left: 1rem">
        <b>Check Status:</b> '.$check.'; &nbsp;
        <b>Company:</b> '.$custom_company.'; &nbsp;
        <b>Month:</b> '.$month_text.'; &nbsp;
        <b>Year:</b> '.$year_text.';
        </td>
        <th colspan="3" style="padding-left: 1rem" class="text-center">Generated On: '.date('d/m/Y h:i:sa', time()).'</th>
    </tr>
    <tr class="pdfTable" style="background-color: #3b3b3b" > 
        <th style="width: 3%">#</th>
        <th style="width: 17%">Date Applied On</th>
        <th style="width: 20%">Staff Info</th>
        <th style="width: 20%">In/Out Info</th>
        <th style="width: 20%">Approval</th>
        <th style="width: 20%">HR Review</th>
        <th></th>
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
$dompdf->stream("in_out_print",array("Attachment"=>0));
