<?php
require "../model/v02_aims_ot_function.php";

$id = $_GET['id'];
$contractors = v02getContractorList();

$staff_month_claim = v02getMonthClaimStaff($id)->fetch_assoc();
$ot_day_closed = 15;
if ($staff_month_claim['department_sub'] == 'MOORING-GANG'){
    $ot_day_closed = 20;
}else if (in_array($staff_month_claim['no_staff'], $contractors)){
    $ot_day_closed = 31;
} ?>
<!DOCTYPE html>
<html lang="en">
<title>OVERTIME CLAIM - <? echo $staff_month_claim['name'] ?></title>
<head>
    <script src="../../js/jquery/jquery.min.js"></script>
    <script src="../../js/html2canvas/html2canvas.js"></script>
    <style type="text/css">
        i{
            font-family: "Arial", serif;
        }
        body {
            font-family: Arial, serif;
            font-size: 11px;
        }
        input{
            padding: 5px;
        }
        form{
            float: right;
        }
        .text-left{
            text-align: left;
        }
        .text-center{
            text-align: center;
        }
        .text-right{
            text-align: right;
        }

        table {
            width:100%;
            page-break-inside:auto;
        }
        tr {
            page-break-inside:avoid; page-break-after:auto
        }

        th {
            text-align: left;
        }

        .th-text-center th{
            text-align: center;
        }

        table.finance td:empty::after{
            content: "\00a0";
        }

        .finance{
            width: 20%;
            border-collapse: collapse;
        }

        table.finance th{
            border: 1px solid black;
            border-collapse: collapse;
            height: 15px;
        }

        table.finance td{
            text-align: right;
            padding: 0 2% 0 2%;
            border: 1px solid black;
            border-collapse: collapse;
        }

        table.all-border td{
            border: 1px solid black;
            border-collapse: collapse;
        }

        table.staff tr {
            height: 20px;
            text-align: left;
        }

        table.one {
            width: 100%;
            border-collapse: collapse;
            margin-top:0;

        }

        table.one th {
            padding: 8px;
            border:1px solid ;
        }

        table.one td {
            padding: 2px;
            text-align: center;
            border-right: 1px solid;
            border-left: 1px solid;
            border-bottom: 1px solid;
            border-top: none;
        }

        @media print {
            body{
                -webkit-print-color-adjust: exact;
            }
            #printPageButton {
                display: none;
            }
        }

        @media print {
            #html-content-holder {
                display: none;
            }
            #btn-Preview-Image {
                display: none;
            }
            #btn-Preview-Image2 {
                display: none;
            }
        }

        .colorbox{
            float: left;
            width: 50px;
            height: 20px;
            margin: 5px;
            border: 1px solid rgba(0, 0, 0, .2);
        }

        img {
            float: left;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 120px;
            background-color: #428BCA;
            color: #fff;
            text-align: center;
            border-radius: 4px;
            padding: 5px 0;

        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
        }

        .float-left {
            float:left;
        }

        .float-right {
            float:right;
        }

        .clear-left-100{
            clear: left;
            width:100%;
        }

        .ot-status{
            padding:5px;
            border-radius: 5px;
            font-weight:bold;
            color:white;
        }

        .add-space-bottom td{
            padding-bottom: 8px;
        }
    </style>

    <script type="text/javascript">
        function SwapDivsWithClick() {
            let d1 = document.getElementById('swapper-first');
            let d2 = document.getElementById('swapper-other');
            if( d2.style.display === "none" ) {
                d1.style.display = "none";
                d2.style.display = "block";
            }else {
                d1.style.display = "block";
                d2.style.display = "none";
            }
        }
    </script>
</head>
<body>
<div id="wrapper1">
    <div class="float-left">
        <div class="tooltip" id="swapper-first" style="display:block;" onclick="SwapDivsWithClick()">
            <span class="tooltiptext" style="padding-left: 4px;padding-right: 4px;">Click on Image to change logo</span>
            <img id="logo" src="../../resources/images/aims-logo.PNG" style="width:400px;height:90px;margin-left:15px;" alt="aims-logo.png"/>
        </div>

        <div id="swapper-other" style="display:none;" onclick="SwapDivsWithClick()">
            <img id="logo" src="../../resources/images/avsb-logo.PNG" style="width:440px;height:90px;margin-left:15px;" alt="avsb-logo.png"/>
        </div>
    </div>

    <div class="float-right">
        <table class="float-right finance all-border" style="width: 360px;border: 2px solid black">
            <tr>
                <th colspan="4" class="text-left" style="padding-left:2%">HR Use</th>
            </tr>
            <tr>
                <th class="text-center">1.5</th>
                <td><? echo ($staff_month_claim['normal_hour'] != '0.00') ? $staff_month_claim['normal_hour'] : ''; ?></td>
                <td><? echo ($staff_month_claim['normal_wageperhour'] != '0.00') ? $staff_month_claim['normal_wageperhour'] : ''; ?></td>
                <td><? echo ($staff_month_claim['normal_totalwages'] != '0.00') ? $staff_month_claim['normal_totalwages'] : ''; ?></td>
            </tr>
            <tr>
                <th class="text-center">2.0</th>
                <td><? echo ($staff_month_claim['weekend_hour'] != '0.00') ? $staff_month_claim['weekend_hour'] : ''; ?></td>
                <td><? echo ($staff_month_claim['weekend_wageperhour'] != '0.00') ? $staff_month_claim['weekend_wageperhour'] : ''; ?></td>
                <td><? echo ($staff_month_claim['weekend_totalwages'] != '0.00') ? $staff_month_claim['weekend_totalwages'] : ''; ?></td>
            </tr>
            <tr>
                <th class="text-center">3.0</th>
                <td><? echo ($staff_month_claim['holiday_hour'] != '0.00') ? $staff_month_claim['holiday_hour'] : ''; ?></td>
                <td><? echo ($staff_month_claim['holiday_wageperhour'] != '0.00') ? $staff_month_claim['holiday_wageperhour'] : ''; ?></td>
                <td><? echo ($staff_month_claim['holiday_totalwages'] != '0.00') ? $staff_month_claim['holiday_totalwages'] : ''; ?></td>
            </tr>
            <tr>
                <th class="text-center">~</th>
                <td><? echo ($staff_month_claim['special_hour'] != '0.00') ? $staff_month_claim['special_hour'] : ''; ?></td>
                <td><? echo ($staff_month_claim['special_wageperhour'] != '0.00') ? $staff_month_claim['special_wageperhour'] : ''; ?></td>
                <td><? echo ($staff_month_claim['special_totalwages'] != '0.00') ? $staff_month_claim['special_totalwages'] : ''; ?></td>
            </tr>
            <tr>
                <th colspan="3" class="text-right">Total &nbsp;</th>
                <td><? echo ($staff_month_claim['total_claim'] != '0.00') ? $staff_month_claim['total_claim'] : ''; ?></td>
            </tr>
        </table>
    </div>

    <div class="float-left clear-left-100">
        <div class="text-center">
            <h2>OVERTIME FORM</h2>
        </div>
        <div class="text-center">
            <table class="staff">
                <tr>
                    <th style="width: 3%">NAME </th>
                    <td style="width: 40%">: <? echo $staff_month_claim['name'] ?></td>

                    <th style="width: 3%">POSITION </th>
                    <td style="width: 40%">: <?echo $staff_month_claim['role_id']; ?></td>
                </tr>

                <tr>
                    <th>I/C NO. </th>
                    <td>: <?echo $staff_month_claim['noic'];?></td>

                    <th rowspan="2">MONTH </th>
                    <td rowspan="2">: <?echo strtoupper($staff_month_claim['month_session']) ;?></td>
                </tr>

                <tr>
                    <th><b>COMPANY </b></th>
                    <td>: <?echo $staff_month_claim['department_id']; ?></td>
                </tr>
            </table>
        </div>

        <p>Please be informed that the employee is allowed to work overtime outside normal office hours.<p>
        <table class="one" style="border: 1px solid black">
            <thead>
            <tr class="th-text-center">
                <th style="width: 8%" rowspan="2">DATE</th>
                <th style="width: 8%" rowspan="2">DAY</th>
                <th style="width: 12%" colspan="2">TIME</th>
                <th style="width: 6%" rowspan="2">WORKING PERIOD</th>
                <th style="width: 6%" rowspan="2">TYPES OF CLAIM</th>
                <th style="width: 30%" rowspan="2">WORK DESCRIPTION</th>
                <th style="width: 5%" rowspan="2">HOD STATUS</th>
                <th style="width: 10%" rowspan="2">REMARK</th>
                <th style="width: 15%" rowspan="2">STATUS</th>
            </tr>

            <tr class="th-text-center" style="border:1px solid;">
                <th>START</th>
                <th>END</th>
            </tr>
            <thead>
            <tbody>
            <?
            $month_ot_list = v02getOtClaimReport($id);
            $i=1;

            //declare variable to store last data
            $latest_created_ot = "";
            $latest_verified_at = "";
            $latest_verified_by = "";
            $latest_approved_at = "";
            $latest_approved_by = "";
            $hod_score = 0;
            $hr_score = 0;
            $ceo_score = 0;

            while($ot_list = $month_ot_list->fetch_assoc()) {
                $i++;
                if (!empty($ot_list['created_at'])) { $latest_created_ot = $ot_list['created_at']; }
                if (!empty($ot_list['verify_at']) && $ot_list['verify_status'] == 1) { $latest_verified_at = $ot_list['verify_at']; }
                if (!empty($ot_list['verify_by']) && $ot_list['verify_status'] == 1) { $latest_verified_by = $ot_list['verify_by']; }
                if (!empty($ot_list['approved_at']) && $ot_list['approved_status'] == 1) { $latest_approved_at = $ot_list['approved_at']; }
                if (!empty($ot_list['approved_by']) && $ot_list['approved_status'] == 1) { $latest_approved_by = $ot_list['approved_by']; }

                //convert hours to hours and minutes
                $hours = floor($ot_list['total_hours']);
                $minutes = sprintf("%02d", ($ot_list['total_hours'] - $hours) * 60);

                //set text from approval column
                //HOD
                $hod_verify = "PENDING";
                if (!empty($ot_list['verify_by']) && !empty($ot_list['verify_at'])){
                    if ($ot_list['verify_status'] == 1){
                        $hod_verify = "VERIFIED";
                        $hod_score++;
                    }else{
                        $hod_verify = "REJECTED";
                    }
                }
                //HR
                $hr_review = "PENDING";
                if (!empty($ot_list['review_by']) && !empty($ot_list['review_at'])){
                    if ($ot_list['review_status'] == 1){
                        $hr_review = "REVIEWED";
                        $hr_score++;
                    }else{
                        $hr_review = "REJECTED";
                    }
                }
                //CEO
                $ceo_approved = "PENDING";
                if (!empty($ot_list['approved_by']) && !empty($ot_list['approved_at'])){
                    if ($ot_list['approved_status'] == 1){
                        $ceo_approved = "APPROVED";
                        $ceo_score++;
                    }else{
                        $ceo_approved = "DISAPPROVE";
                    }
                }
                ?>
                <tr>
                    <td><? echo date('d/m/Y', strtotime($ot_list['date'])); ?></td>
                    <td><? echo strtoupper( date( 'l', strtotime($ot_list['date']) ) );  ?></td>
                    <td><? echo date('h:i a', strtotime($ot_list['start_ot'])); ?></td>
                    <td><? echo date('h:i a', strtotime($ot_list['end_ot']));; ?></td>
                    <td><? echo $hours.'H '.$minutes.'M'; ?></td>
                    <td>OT CLAIM</td>
                    <td><? echo $ot_list['description']; ?></td>
                    <td><? echo $hod_verify; ?></td>
                    <td><? echo $ot_list['verification_remark']; ?></td>
                    <td><? echo 'HR: '.$hr_review.'<br>CEO: '.$ceo_approved; ?></td>
                </tr>

            <?}?>
            </tbody>
        </table>

        <?
        $half_month = date('Y-m', strtotime($staff_month_claim['month_session'])).'-'.$ot_day_closed;
        $total_overused = v02getOtOverused($id, $half_month);
        $total_overused = ($total_overused) ?: 0;

        if ($total_overused > 0){
            $conversion_offday = ($staff_month_claim['conversion_offday'])?:'0';
            $offday_total = $conversion_offday/8.0;
            $conversion_claim = ($staff_month_claim['conversion_claim'])?:'0';
        ?>
            <table style="border: 1px dashed black; width: 40%; font-size: 16px; margin-top: 32px; padding: 8px">
                <tr>
                    <td style="width: 50%;">Total Overused on <b><? echo $half_month ?></b></td>
                    <td>:</td>
                    <td><? echo $total_overused ?> hour(s)</td>
                </tr>
                <tr>
                    <td>Convert to claim</td>
                    <td>:</td>
                    <td><? echo $conversion_claim ?> hour(s)</td>
                </tr>
                <tr>
                    <td>Convert to off-day</td>
                    <td>:</td>
                    <td><? echo $conversion_offday ?> hour(s) &#8680; <? echo $offday_total ?> day(s)</td>
                </tr>
                <? if ($offday_total > 0){ ?>
                <tr>
                    <td colspan="3" style="color: red; font-size: 12px; font-weight: bold">
                        This staff is eligible for additional leave as mentioned above.
                        Refer to Leave v02 for replacement quota details.
                        Contact Human Resource (HR) Department for more details.
                    </td>
                </tr>
                <? } ?>
            </table>
        <? } ?>

        <table style="width: 100%; margin: 32px auto 0 auto">
            <tr>
                <th style="text-align:left; height: 30px; width: 33.33%">APPLIED BY :</th>
                <th style="text-align:left; height: 30px; width: 33.33%">VERIFIED BY :</th>
                <th style="text-align:left; height: 30px; width: 33.33%">APPROVED BY :</th>
            </tr>
            <tr class="add-space-bottom">
                <td>
                    <span class="ot-status" style="background-color:GREEN;">
                        APPLIED
                    </span>
                </td>
                <td>
                    <span class="ot-status" style="background-color:<? echo ($hod_score == 0) ? 'GREY' : 'GREEN'; ?>">
                        <? echo ($hod_score == 0) ? 'PENDING' : 'VERIFIED';?>
                    </span>
                </td>
                <td>
                    <span class="ot-status" style="background-color:<? echo ($ceo_score == 0) ? 'GREY' : 'GREEN'; ?>">
                        <? echo ($ceo_score == 0) ? 'PENDING' : 'APPROVED';?>
                    </span>
                </td>
            </tr>
            <tr class="add-space-bottom">
                <td><b>NAME :</b> <? echo $staff_month_claim['name']; ?></td>
                <td><? if ($hod_score != 0){ echo '<b>NAME :</b> '.getStaffName($latest_verified_by); } ?></td>
                <td><? if ($ceo_score != 0){ echo '<b>NAME :</b> '.getStaffName($latest_approved_by); } ?></td>
            </tr>
            <tr>
                <td><b>DATE :</b> <? echo date("d-m-Y", strtotime($latest_created_ot)); ?></td>
                <td><? if ($hod_score != 0){ echo '<b>DATE :</b> '.date("d-m-Y", strtotime($latest_verified_at)); } ?></td>
                <td><? if ($ceo_score != 0){ echo '<b>DATE :</b> '.date("d-m-Y", strtotime($latest_approved_at)); } ?></td>
            </tr>
        </table>

        <div style="text-align:center;margin-top: 16px">
            <input id="btn-Preview-Image" type="button" onclick="window.print()" value="Print" style="margin-left: 8px;margin-right: 8px;"/>
            <input id="btn-Preview-Image2" type="button" value="Close" onclick="self.close()" style="margin-left: 8px;margin-right: 8px;">
        </div>
    </div>
</div>
</body>
</html>