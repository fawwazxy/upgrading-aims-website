<?php
session_start();
require_once '../../lib/dompdf/autoload.inc.php';
require "../model/aims_travel_function.php";

use Dompdf\Dompdf;
$table_row = "";
$i=1;

//variable
$id=$_GET['id'];
$travel = getTravelById($id)->fetch_assoc();
$travel_check_in = ($travel['check_in'] != '0000-00-00') ? date("d/m/Y",strtotime($travel['check_in'])) : '';
$travel_check_out = ($travel['check_out'] != '0000-00-00') ? date("d/m/Y",strtotime($travel['check_out'])) : '';
$travel_hotel_duration = ($travel['hotel_duration']) ? $travel['hotel_duration'].' day(s)' : '';
$travel_request_hotel = ($travel['request_hotel']) ?: 'NO';

//print pdf start here
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
        <title>Travel Approval</title>
        <style>
            body{
                font-family: Arial, sans-serif;
            }
            table{
                table-layout: fixed;
            }
            .travel {
                border: 0;
                font-size: 12px;
                width: 100%;
            }
            tr.no-border td{
                border: 0;
            }
            th {
                padding-left: 0.75rem;
                border: 0;
            }
            td {
                padding: 0.5rem 0.75rem;
                border: 1px solid black;
                border-radius: 5px;
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
            .line-horizontal{
                width: 100%;
                height: 10px;
                border-bottom: 1px solid black;
                text-align: center;
                margin: 16px 0;
            }
            .line-horizontal span{
                font-size: 16px;
                background-color: white;
                padding: 0 10px;
            }
        </style>
    </head>
    <body>
    <table style="width: 100%;" role="grid" id="leavePrint" class="header">
        <tr class="text-dark no-border">
            <td style="width: 10%">
                <img src="../../resources/images/aims_logo.png" alt="aims-logo">
            </td>
            <td class="text-left" style="line-height: 1.5">
                    <b>AIMS-GLOBAL GROUP</b><br>
                    BLOK B & BLOK C, BESTARI CENTRE, JALAN HILIRAN,<br>
                    20300 KUALA TERENGGANU, TERENGGANU<br>
                    TEL: +603-622 8848
            </td>
        </tr>
    </table>
    <div class="line-horizontal" style="margin-top: 0">
          <span>Travel Information</span>
    </div>
    <table class="travel">
        <tr>
            <th style="width: 8%%;">Name: </th>
            <td style="width: 27%">' .$travel['name'].'</td>
            <th style="width: 15%%;">Designation: </th>
            <td style="width: 20%">'.$travel['staff_designation'].'</td>
            <th style="width: 10%%;">Company: </th>
            <td style="width: 20%">'.$travel['company_id'].'</td>
        </tr>
        <tr>
            <th>Staff Number: </th>
            <td>'.$travel['no_staff'].'</td>
            <th>I/C No: </th>
            <td>'.$travel['noic'].'</td>
            <th>Department: </th>
            <td>'.$travel['department_id'].'</td>
        </tr>
        <tr>
            <th rowspan="3">Purpose: </th>
            <td rowspan="3">'.$travel['travel_purpose'].'</td>
            <th>Mode Of Travel: </th>
            <td>'.$travel['travel_mode_id'].'</td>
            <th>Job No: </th>
            <td>'.$travel['job_no'].'</td>
        </tr>
        <tr>
            <th>Departure Date: </th>
            <td>'.date("d/m/Y",strtotime($travel['departure_date'])).'</td>
            <th>Return Date: </th>
            <td>'.date("d/m/Y",strtotime($travel['return_date'])).'</td>
        </tr>
        <tr>
            <th>Departure Time: </th>
            <td>'.date("h:i:s A",strtotime($travel['departure_time'])).'</td>
            <th>Return Time: </th>
            <td>'.date("h:i:s A",strtotime($travel['return_time'])).'</td>
        </tr>
    </table>
    <div class="line-horizontal" style="margin-top: 0">
          <span>Hotel Accommodation</span>
    </div>
    <table class="travel">
        <tr>
            <th>Request For Hotel: </th>
            <td>'.$travel_request_hotel.'</td>
            <th>Duration Of Stays: </th>
            <td>'.$travel_hotel_duration.'</td>
            <th>Date Check In: </th>
            <td>'.$travel_check_in.'</td>
            <th>Date Check Out: </th>
            <td>'.$travel_check_out.'</td>
        </tr>
    </table>
    <div class="line-horizontal" style="margin-top: 0">
          <span>Transportation</span>
    </div>
    <table class="travel">
        <tr>
            <th style="width: 20%">Advance Required: </th>
            <td style="width: 10%">'.$travel['advance_required'].'</td>
            <th style="width: 20%">Transportation From Airport (KT/KUA): </th>
            <td style="width: 10%">'.$travel['transport_fairport'].'</td>
            <th style="width: 10%">Destination: </th>
            <td style="width: 30%">'.$travel['destination'].'</td>
        </tr>
        <tr>
            <th>Request For Company Driver: </th>
            <td>'.$travel['request_driver'].'</td>
            <th>Transportation To Airport (KT/KUA): </th>
            <td>'.$travel['transport_tairport'].'</td>
            <th>Total (RM): </th>
            <td>'.$travel['travel_advance'].'</td>
        </tr>
    </table>
    <table class="travel" style="margin: 24px 0 4px">
        <tr>
            <th style="padding-left: 0.25rem">Verified By</th>
            <th style="padding-left: 0.25rem">Approved By</th>
            <th></th>
        </tr>
        <tr style="line-height: 2">
            <td>
            '.$travel['hod_by'].'<br>
            <b>Date:</b> '.date("d-m-Y h:i:s",strtotime($travel['hod_date'])).'
            </td>
            <td>
            '.$travel['ceo_by'].'<br>
            <b>Date:</b> '.date("d-m-Y h:i:s",strtotime($travel['ceo_date'])). '
            </td>
            <td style="border: 0"></td>
        </tr>
    </table>
    <i style="font-size: 12px; color: #484848; margin-left: 8px">Note: This is computer generated. No signature is required.</i>
    ';

$dompdf = new Dompdf();
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'landscape');
$dompdf->render();
ob_end_clean();
$dompdf->stream("travel_info",array("Attachment"=>0));