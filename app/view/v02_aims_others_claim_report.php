<?php
require "../model/v02_aims_others_claim_function.php";
$id = $_GET['id'];
$staff = v02getClaimDetailsByID($id)->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<title>CLAIM - <? echo $staff['month_claim'] ?></title>
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
            /*text-align: right;*/
            font-size: 9pt;
            padding: 1% 2% 1% 2%;
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

        .claim-status{
            padding:5px;
            border-radius: 5px;
            font-weight:bold;
            color: white;
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

    <div class="">
        <table class="finance" style="float: right">
            <tbody>
            <?
            $finance_use = v02getFinanceUse($id)->fetch_assoc()
            ?>
            <tr>
                <th width="10%" class="text-center">Finance Use</th>
                <th width="10%" class="text-center">RM</th>
            </tr>
            <tr>
                <td class="text-center">Advance</td>
                <td class="text-center"><? echo $finance_use['advance']; ?></td>
            </tr>
            <tr>
                <td class="text-center">Less : Expenditure</td>
                <td class="text-center"><? echo $staff['total_claim']; ?></td>
            </tr>
            <tr>
                <td class="text-center">Refund</td>
                <td class="text-center"><? echo $finance_use['refund']; ?></td>
            </tr>
            <tr>
                <td class="text-center">Outstanding</td>
                <td class="text-center"><? echo $finance_use['outstanding']; ?></td>
            </tr>
            </tbody>
        </table>
    </div>


    <div class="float-left clear-left-100">
        <div class="text-center">
            <h2>CLAIM FORM</h2>
        </div>
        <div class="text-center">
            <table class="staff">
                <tr>
                    <th style="width: 3%">NAME </th>
                    <td style="width: 40%">: <? echo $staff['name'] ?></td>

                    <th style="width: 3%">POSITION </th>
                    <td style="width: 40%">: <?echo $staff['role_id']; ?></td>
                </tr>

                <tr>
                    <th>I/C NO. </th>
                    <td>: <?echo $staff['noic'];?></td>

                    <th rowspan="2">MONTH </th>
                    <td rowspan="2">: <?echo $staff['month_claim'] ;?></td>
                </tr>

                <tr>
                    <th><b>COMPANY </b></th>
                    <td>: <?echo $staff['department_id']; ?></td>
                </tr>
            </table>
        </div>

        <br>
        <table class="one" style="border: 1px solid black">
            <thead>
            <tr class="th-text-center">
                <th style="width: 10%">DATE</th>
                <th style="width: 10%">DEPARTURE</th>
                <th style="width: 10%">ARRIVAL</th>
                <th style="width: 10%">JOB NUMBER</th>
                <th style="width: 20%">DESCRIPTION</th>
                <th style="width: 20%">TYPE OF CLAIM</th>
                <th style="width: 10%">TOTAL CLAIM</th>
                <th style="width: 10%">REMARK</th>
            </tr>
            <thead>
            <tbody>
            <?
            $i=1;
            $total_cost=0.00;
            /*$claim_list = v02getStaffDetailsByID($id);
            while($row = $claim_list->fetch_assoc()) {*/

            //HOD
            if (empty($staff['verify_by']) && empty($staff['verify_at'])){
                $hod_text_color = 'GREY';
                $hod_text_status = 'PENDING';
            }else{
                if ($staff['verify_status'] == '1' && $staff['verify_by'] == 'AUTO VERIFIED'){
                    $hod_text_color = 'GREEN';
                    $hod_text_status = 'NO SUPPORT NEEDS';
                } elseif ($staff['verify_status'] == '1'){
                    $hod_text_color = 'GREEN';
                    $hod_text_status = 'VERIFIED';
                }else{
                    $hod_text_color = 'RED';
                    $hod_text_status = 'REJECTED';
                }
            }
            //HR
            if (empty($staff['review_by']) && empty($staff['review_at'])){
                $hr_text_color = 'GREY';
                $hr_text_status = 'PENDING';
            }else{
                if ($staff['review_status'] == '1'){
                    $hr_text_color = 'GREEN';
                    $hr_text_status = 'REVIEWED';
                }else{
                    $hr_text_color = 'RED';
                    $hr_text_status = 'DISAPPROVED';
                }
            }

            if ($staff['finance_status'] == '1'){
                $finance_text_color = 'GREEN';
                $finance_text_status = 'CHECKED';
            }else{
                $finance_text_color = 'GREY';
                $finance_text_status = 'UNCHECKED';
            }

            //CEO
            if (empty($staff['approve_by']) && empty($staff['approve_at'])){
                $ceo_text_color = 'GREY';
                $ceo_text_status = 'PENDING';
            }else{
                if ($staff['approve_status'] == '1'){
                    $ceo_text_color = 'GREEN';
                    $ceo_text_status = 'APPROVED';
                }else{
                    $ceo_text_color = 'RED';
                    $ceo_text_status = 'DISAPPROVED';
                }
            }
            ?>
            <tr>
                <td><? echo strtoupper(date('l', strtotime($staff['created_at']))).'<br>'.date('d/m/Y', strtotime($staff['created_at']));?></td>
                <td><? echo $staff['datetime_departure'] != '0000-00-00 00:00:00' ? date('d/m/Y', strtotime($staff['datetime_departure'])).'<br>'.date('h:i A', strtotime($staff['datetime_departure'])) :
                        '<i class="text-muted" style="font-size: 12px; color: grey">-- NO DATA --</i>';?></td>
                <td><? echo $staff['datetime_arrival'] != '0000-00-00 00:00:00' ? date('d/m/Y', strtotime($staff['datetime_arrival'])).'<br>'.date('h:i A', strtotime($staff['datetime_arrival'])) :
                        '<i class="text-muted" style="font-size: 12px; color: grey">-- NO DATA --</i>';?></td>
                <td>
                    <? echo !empty($staff['job_no']) ? $staff['job_no'] :
                        '<i class="text-muted" style="font-size: 12px; color: grey">-- NO DATA --</i>';?>
                </td>
                <td><? echo nl2br($staff['description']); ?></td>
                <td>
                    <ul style="list-style: square">
                        <? $type_claim = v02getTypeClaimByClaimId($id);
                        while ($type = $type_claim->fetch_assoc()){
                            $desc = getTypeClaimDescription($type['company_cc_id'])->fetch_assoc();
                            ?>
                            <li style="margin: 6px;" class="text-left">
                                <? echo '<b>'.$desc['cost_centre'].'</b>: <br>'.$desc['description'].' - RM '.$type['total']?>
                            </li>
                        <? }?>
                    </ul>

                </td>
                <td>
                    RM <? echo $staff['total_claim']?>
                </td>
                <td>
                    <? echo !empty($staff['remarks']) ? nl2br($staff['remarks']) :
                        '<i class="text-muted" style="font-size: 12px; color: grey">-- NO DATA --</i>';?>
                </td>
            </tr>

        <?/*}*/?>
            </tbody>
        </table>

        <table style="width: 100%; margin: 32px auto 0 auto">
            <tr>
                <th style="text-align:left; height: 30px; width: 20%">APPLIED BY :</th>
                <th style="text-align:left; height: 30px; width: 20%">VERIFIED BY :</th>
                <th style="text-align:left; height: 30px; width: 20%">REVIEWED BY :</th>
                <th style="text-align:left; height: 30px; width: 20%">CHECKED BY :</th>
                <th style="text-align:left; height: 30px; width: 20%">APPROVED BY :</th>
            </tr>
            <tr class="add-space-bottom">
                <td>
                    <span class="claim-status" style="background-color:GREEN;">
                        APPLIED
                    </span>
                </td>
                <td>
                    <span class="claim-status" style="background-color: <?php echo $hod_text_color?>"><?php echo $hod_text_status; ?></span>
                </td>
                <td>
                    <span class="claim-status" style="background-color: <?php echo $hr_text_color?>"><?php echo $hr_text_status; ?></span>
                </td>
                <td>
                    <span class="claim-status" style="background-color: <?php echo $finance_text_color?>"><?php echo $finance_text_status; ?></span>
                </td>
                <td>
                    <span class="claim-status" style="background-color: <?php echo $ceo_text_color?>"><?php echo $ceo_text_status; ?></span>
                </td>
            </tr>
            <tr class="add-space-bottom">
                <td><b>NAME : </b> <? echo $staff['name']; ?></td>
                <td><? if ($staff['verify_status'] == '1' || $staff['verify_status'] == '0'){ echo '<b>NAME : </b>' .v02getStaffName($staff['verify_by']);} ?></td>
                <td><? if ($staff['review_status'] == '1' || $staff['review_status'] == '0'){ echo '<b>NAME : </b>' .v02getStaffName($staff['review_by']);} ?></td>
                <td><? if ($staff['finance_status'] == '1' || $staff['finance_status'] == '0'){ echo '<b>NAME : </b>' .v02getStaffName($staff['finance_by']);} ?></td>
                <td><? if ($staff['approve_status'] == '1' || $staff['approve_status'] == '0'){ echo '<b>NAME : </b>' .v02getStaffName($staff['approve_by']);} ?></td>
            </tr>
            <tr>
                <td><b>DATE :</b> <? echo date("d/m/Y", strtotime($staff['created_at'])); ?></td>
                <td><? if ($staff['verify_status'] == '1' || $staff['verify_status'] == '0'){ echo '<b>DATE : </b>' .date("d/m/Y", strtotime($staff['verify_at']));} ?></td>
                <td><? if ($staff['review_status'] == '1' || $staff['review_status'] == '0'){ echo '<b>DATE : </b>' .date("d/m/Y", strtotime($staff['review_at']));} ?></td>
                <td><? if ($staff['finance_status'] == '1' || $staff['finance_status'] == '0'){ echo '<b>DATE : </b>' .date("d/m/Y", strtotime($staff['finance_at']));} ?></td>
                <td><? if ($staff['approve_status'] == '1' || $staff['approve_status'] == '0'){ echo '<b>DATE : </b>' .date("d/m/Y", strtotime($staff['approve_at']));} ?></td>
            </tr>
        </table>
        
        <div style="text-align:left;margin-top: 50px">
            <h3><b><i>** THIS FORM IS GENERATED BY SYSTEM AND NO SIGNATURE IS REQUIRED</i></b></h3>
        </div>

        <div style="text-align:center;margin-top: 16px">
            <input id="btn-Preview-Image" type="button" onclick="window.print()" value="Print" style="margin-left: 8px;margin-right: 8px;"/>
            <input id="btn-Preview-Image2" type="button" value="Close" onclick="self.close()" style="margin-left: 8px;margin-right: 8px;">
        </div>
    </div>
</div>
</body>
</html>