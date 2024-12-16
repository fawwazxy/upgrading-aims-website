<?php
include ('../controller/auth.php');
require "../model/aims_gl_function.php";
require "../model/lookup.php";
$ref_no = $_GET['ref_no'];
$sys = getSys(1)->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <? require "../global/header.php"; ?>
    <style type="text/css">
        body {
            font-family: Arial, serif;
            font-size: 12px;
            color: black;
        }

        hr {
            border: 1px solid #000000;
        }

        h3 {
            font-size: 20pt;
            font-weight: bold;
            text-decoration: underline;
            text-align: center;
        }

        input,select {
            border: hidden;
        }

        table {
            border-collapse: collapse;
        }

        .table.table-borderless, .table.table-borderless th, .table.table-borderless td {
            border: none;
        }

        @media print {
            body{
                -webkit-print-color-adjust: exact;
            }
            #printPageButton {
                display: none;
            }
            #html-content-holder {
                display: none;
            }
            #btn-Preview-Image {
                display: none;
            }
            #request_by, #ref_no {
                background-image: none;
                -webkit-appearance: none;
                -moz-appearance: none;
            }

            input[type="date"]::-webkit-inner-spin-button,
            input[type="date"]::-webkit-calendar-picker-indicator {
                display: none;
                -webkit-appearance: none;
            }
        }


    </style>
</head>
<body>
<div id="wrapper">

    <!--report header-->
    <div class="row">
        <div class="col-lg-12">
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

    <!--report title-->
    <div class="row">
        <div class="col-lg-12">
            <h3>ROOM RESERVATION</h3>
        </div>
    </div>

    <!--booking reservation info-->
    <div class="row">
        <div class="col-lg-12">
            <table class="table table-borderless" style="width: 50%">
                <tbody>
                <tr>
                    <th style="width: 15px;">Ref No:</th>
                    <td>
                        <select name="ref_no" id="ref_no">
                            <option value="">-- Choose Ref NO --</option>
                            <? echo getDropDownRefNo($ref_no);?>
                        </select>
                    </td>
                </tr>

                <? $rrf = getReservByReff($ref_no);
                while($list_rrf = $rrf->fetch_assoc()) { ?>

                    <tr>
                        <th>Date:</th>
                        <td><input type="date" id="reserv_date" name="reserv_date" value="<? echo $list_rrf['reserv_date']; ?>"></td>
                    </tr>
                    <tr>
                        <th>To:</th>
                        <td>GLOBAL LOUNGE</td>
                    </tr>
                    <tr>
                        <th>Fax:</th>
                        <td>09-6238848</td>
                    </tr>
                    <tr>
                        <th>Attendant:</th>
                        <td>AISYAH ATHIRAH BINTI MD YUNUS</td>
                    </tr>
                    <tr>
                        <th>From:</th>
                        <td><? echo $list_rrf['company_name']; ?></td>
                    </tr>

                <? } ?>

                </tbody>
            </table>
        </div>
    </div>

    <!--client booking list-->
    <div class="row">
        <div class="col-lg-12">
            <p>Dear Sir / Madam</p>
            <p>Please reserve room for our crew as below :</p>

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th class="text-center">NO</th>
                    <th>NAME</th>
                    <th class="text-center">IC / PASSPORT NO.</th>
                    <th class="text-center">COMPANY</th>
                    <th class="text-center">CHECK IN</th>
                    <th class="text-center">CHECK OUT</th>
                </tr>
                </thead>
                <tbody>
                <? $i=1;
                $rr = getReservByRef($ref_no);
                while($list_rr = $rr->fetch_assoc()) { ?>
                    <tr>
                        <td class="text-center"><? echo $i++; ?></td>
                        <td> <? echo $list_rr['client_name']; ?></td>
                        <td class="text-center"><? echo $list_rr['client_ic'] ;?></td>
                        <td class="text-center"><? echo $list_rr['client_company_id'] ;?></td>
                        <td class="text-center"><? echo date('d/m/Y',strtotime($list_rr['arrival_date']));?></td>
                        <td class="text-center"><? echo date('d/m/Y',strtotime($list_rr['departure_date']));?></td>
                    </tr>
                <? } ?>
                </tbody>
            </table>

            <p>Should you have any queries or need further information, please contact the undersigned at any time.</p>
        </div>
    </div>

    <!--signature-->
    <? $r = getReservByRefs($ref_no);
    while($list_r = $r->fetch_assoc()) { ?>
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-borderless">
                    <tbody>
                    <tr>
                        <th colspan="2">REQUEST BY :</th>
                        <th colspan="2">CONFIRMED BY :</th>
                    </tr>
                    <tr>
                        <td style="width: 12%">NAME</td>
                        <td>
                            <select id="request_by">
                                <option value="">-- SELECT REQUEST BY --</option>
                                <option value=": AIMS GLOBAL ENGINEERING SDN BHD">: MUHAMMAD ARIF IDHAM BIN ABU BAKAR</option>
                                <option value=": AIMS GLOBAL ENGINEERING SDN BHD">: MUHAMMAD AMIR SYAFIQ BIN ABDULLAH</option>
                                <option value=": AIMS GLOBAL ENGINEERING SDN BHD">: NOOR AFIQAH BINTI ZAHARI</option>
                                <option value=": AIMS-GLOBAL MARITIME SDN BHD">: AHMAD ZUHDI BIN UZIR</option>
                                <option value=": AIMS-GLOBAL MARITIME SDN BHD">: SYED OMAR FAKHRUDDIN BIN SYED YASIN</option>
                                <option value=": AIMS-GLOBAL MARITIME SDN BHD">: HAFIZUDDIN B. SHUHAIMI</option>
                            </select>
                        </td>
                        <td style="width: 12%">NAME</td>
                        <td>: <? echo $list_r['confirm_by']; ?></td>
                    </tr>
                    <tr>
                        <td>COMPANY</td>
                        <td id="request_company"></td>
                        <td>COMPANY</td>
                        <td>: <? echo ($list_r['confirm_company'] == 'AGHSB')?'AIMS-GLOBAL HOLDING SDN BHD':''; ?></td>
                    </tr>
                    <tr>
                        <td>DATE</td>
                        <td>: <? echo date('d/m/Y h:i:s',strtotime($list_r['arrival_date'])); ?></td>
                        <td>DATE</td>
                        <td>: <? echo date('d/m/Y h:i:s',strtotime($list_r['confirm_date'])); ?></td>
                    </tr>
                    </tbody>
                </table>

                <div style="text-align:center;">
                    <br><input id="btn-Preview-Image" class="btn btn-primary" type="button" onclick="window.print()" value="Print"/>
                </div>
            </div>
        </div>
    <? } ?>

</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        const dropdown = document.getElementById('request_by');
        const display = document.getElementById('request_company');

        dropdown.addEventListener('change', function () {
            const selectedValue = dropdown.value;
            if (selectedValue) {
                display.textContent = selectedValue;
            } else {
                display.textContent = '--';
            }
        });
    });

    $(document).ready(function() {
        $("#ref_no").change(function(){

            var selected_ref_no=$(this).val();
            reloadRefNo(selected_ref_no);
        });

    });

    function reloadRefNo(ref_no){
        location.href = "aims_gl_room_reserv_new.php?ref_no="+ref_no;
    }
</script>

</body>
</html>