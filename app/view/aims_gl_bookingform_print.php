<?php
include ('../controller/auth.php');
require "../model/aims_gl_function.php";
require "../model/lookup.php";

$ref_no=$_GET['ref_no'];
$id = $_GET['id'];
$staffinfo = getBookingFormPrintById($id)->fetch_assoc();

$sys = getSys(1)->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <? require "../global/header.php"; ?>
    <style type="text/css">
        body {
            font-family: "Arial", serif;
            font-size: 12px;
            color: black;
        }
        hr {
            border: 1px solid #000000;
        }
        h3 {
            font-size: 18pt;
            font-weight: bold;
            text-decoration: underline;
            text-align: center;
        }
        h5 {
            font-weight: bold;

        }
        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }
            #btn-Preview-Image {
                display: none;
            }
        }
        table {
            border-collapse: collapse;
        }

        .table.table-borderless, .table.table-borderless th, .table.table-borderless td {
            border: none;
        }
        input {
            border: hidden;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <div style="text-align:center;">
                <br><input id="btn-Preview-Image" class="btn btn-primary" type="button" onclick="window.print()" value="Print"/>
            </div>
            <table>
                <tbody>
                <tr>
                    <td><img src="../../resources/images/aims_logo.png" alt="Aims-Global" style="width: 78px"></td>
                    <td style="padding-left: 10px">
                        <b>Aims-Global Maritime Sdn Bhd (1041517-X)</b><br>
                        02-03, Level 3, No. 2, Block C, Bestari Centre,<br>
                        Jalan Hiliran, 20300 Kuala Terengganu, Terengganu Darul Iman<br>
                        No. Tel: 09-6228848 &nbsp;&nbsp;&nbsp; No. Faks: 09-6238848<br>
                        Email: aims@aimsglobal.com.my &nbsp;&nbsp; Website: www.aimsglobal.com.my
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-lg-12">
            <h3>GLOBAL LOUNGE BOOKING FORM</h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h5>CLIENT INFORMATION</h5>
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th style="width: 22%">NAME:</th>
                    <td colspan="3"><? echo $staffinfo['client_name'] ;?></td>
                </tr>
                <tr>
                    <th>IC/PASSPORT NO:</th>
                    <td><? echo $staffinfo['client_ic'] ;?></td>
                    <th style="width: 20%">CONTACT NO:</th>
                    <td><? echo $staffinfo['client_phone_no'] ;?></td>
                </tr>
                <tr>
                    <th>COMPANY:</th>
                    <td colspan="3"><? echo $staffinfo['company_name'] ;?></td>
                </tr>
                <tr>
                    <th>ADDRESS:</th>
                    <td colspan="3"><? echo $staffinfo['client_address'] ;?></td>
                </tr>
                <tr>
                    <th>CITY:</th>
                    <td><? echo $staffinfo['client_city'] ;?></td>
                    <th>STATE:</th>
                    <td><? echo $staffinfo['client_state'] ;?></td>
                </tr>
                <tr>
                    <th>CAR REGISTRATION:</th>
                    <td colspan="3"><? echo $staffinfo['client_car'] ;?></td>
                </tr>
                </tbody>

            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <h5>BOOKING INFORMATION</h5>
            <table class="table table-bordered">
                <tbody>
                <tr>
                    <th style="width: 22%">ROOM:</th>
                    <td colspan="3"><? echo $staffinfo['room_id'] ;?></td>
                </tr>
                <tr>
                    <th>BED NO:</th>
                    <td><? echo $staffinfo['bed_id'] ;?></td>
                    <th style="width: 25%">LOCKER NO:</th>
                    <td><? echo $staffinfo['locker_id'] ;?></td>
                </tr>
                <tr>
                    <th>ARRIVAL DATE TIME:</th>
                    <td><? echo date('d/m/Y',strtotime($staffinfo['arrival_date'])).' '.$staffinfo['arrival_time'] ;?></td>
                    <th>DEPARTURE DATE TIME:</th>
                    <td><? echo date('d/m/Y',strtotime($staffinfo['departure_date'])).' '.$staffinfo['departure_time'] ;?></td>
                </tr>
                <tr>
                    <th>RETURN KEY STATUS:</th>
                    <td><? echo $staffinfo['key_status'] ;?></td>
                    <th>VERIFIED BY:</th>
                    <td><? echo $staffinfo['key_by'] ;?></td>
                </tr>
                <tr>
                    <th rowspan="2">OFFICE USE:</th>
                    <td colspan="3">
                        <b>Person In Charge Check In:</b><br>
                        Confirmed By: <? echo $staffinfo['pic_cin'].'<br>' ;?>
                        Date: <? echo date('d/m/Y',strtotime($staffinfo['arrival_date'])) ;?>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <b>Person In Charge Check Out:</b><br>
                        Confirmed By: <? echo $staffinfo['pic_cout'].'<br>' ;?>
                        Date: <? echo date('d/m/Y',strtotime($staffinfo['departure_date'])) ;?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div style="float: right; width: 50%">
                <span>
                    <p><b>REMARKS</b></p>
                    <p>* Please leave your driving license or passport for our record</p>
                    <p>* Please return this keycard to the receptionist upon check out</p>
                    <p>* Aims-Global not held responsibe for any valuables left by guest</p>
                    <p><b><u>Lost/Unreturned Key</u>:</b></p>
                    <p><b>The AIMS GLOBAL reserves the right to charge room occupants RM50.00 for any lost/unreturned key</b></p>
                </span>
            </div>
            <table class="table table-borderless" style="width: 50%;">
                <tbody>
                <tr>
                    <th colspan="2">AUTHORIZATION</th>
                </tr>
                <tr>
                    <th style="width: 26%">Status:</th>
                    <td>
                        <? if($staffinfo['autho_status']=='PENDING'){
                            echo"<span style='background-color:grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";
                        } else {
                            echo"<span style='background-color:green;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>AUTHORIZED</span>";
                        } ?>
                    </td>
                </tr>
                <tr>
                    <th>Approved By:</th>
                    <td><!--<input style="width:230px;" type="text" id="" name="" value="<?/* echo $staffinfo['autho_by'] */?>">-->
                        <? echo $staffinfo['autho_by'] ?>
                    </td>
                </tr>
                <tr>
                    <th>Date:</th>
                    <td><!--<input style="width:230px;" type="text" id="" name="" value="<?/* echo ($staffinfo['autho_by'] == '')?'':date('d/m/Y',strtotime($staffinfo['autho_date'])) */?>">-->
                        <? echo ($staffinfo['autho_by'] == '')?'':date('d/m/Y',strtotime($staffinfo['autho_date'])) ?>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>