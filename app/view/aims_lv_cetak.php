<?php

include ('../controller/auth.php');

require "../model/aims_lv_medical_function.php";

date_default_timezone_set("Asia/Kuala_Lumpur");

$sys = getSys(1)->fetch_assoc();

$id = $_GET['id'];
$staffinfo = getCetakInfoById($id)->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title><?echo $staffinfo['department_id']; ?></title>
    <script src="../../js/jquery/jquery.min.js"></script>
    <script src="../../js/html2canvas/html2canvas.js"></script>

    <style type="text/css">
        i{
            font-family: "Times New Roman";
        }
        body {
            font-family: Times New Roman;
            font-size: 14px;
        }

        div.invoice {
            border:0px solid #ccc;
            padding:10px;
            height:60%;
            width:90%;
        }

        .pagebreak {
            page-break-before: always;
        }

        div.company-address {
            border:1px solid #ccc;
            float:left;
            width:200pt;
        }

        div.invoice-details {
            border:0px solid #ccc;
            float:right;
            width:200pt;
        }

        div.customer-address {
            border:1px solid #ccc;
            float:right;
            margin-bottom:50px;
            margin-top:100px;
            width:200pt;
        }

        div.clear-fix {
            clear:both;
            float:none;
        }

        table {
            width:100%;

        }

        table.one {
            border-collapse:collapse;
            width:100%;

        }
        th {
            text-align: left;
            width: 30%;
        }

        td {
        }

        .text-left {
            text-align:left;
        }


        @media print {
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
        }
        table { page-break-inside:auto }
        tr { page-break-inside:avoid; page-break-after:auto }

        colorbox{
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
    </style>

    <script type="text/javascript">

        function SwapDivsWithClick(div1,div2)
        {
            d1 = document.getElementById(div1);
            d2 = document.getElementById(div2);
            if( d2.style.display == "none" )
            {
                d1.style.display = "none";
                d2.style.display = "block";
            }
            else
            {
                d1.style.display = "block";
                d2.style.display = "none";
            }
        }
    </script>
</head>

<body>
<div class="tooltip" id="swapper-first" style="display:block;" onclick="SwapDivsWithClick('swapper-first','swapper-other')">
    <span class="tooltiptext">Click on image to change logo</span>
    <img id="logo"
         src="../../resources/images/aims-logo.PNG" style="width:400px;height:90px;margin-left:15px;"/>
</div>
<div id="swapper-other" style="display:none;" onclick="SwapDivsWithClick('swapper-first','swapper-other')">
    <img id="logo"
         src="../../resources/images/avsb-logo.PNG" style="width:440px;height:90px;margin-left:15px;"/>
</div>






<br><br><br>

<div class="invoice">
    <div style="text-align:center">
        <div class="clear-fix"></div>

        <hr style="height:2px;color:gray;background-color:gray">
        <h3>MEDICAL CLAIM FORM</h3>
        <table border='0' cellspacing='0'>
            <tbody>
            <tr>
                <td colspan="2" class='text-left' height='35px' width="30%"><b>Staff Name</b></td>
                <td colspan="1" class='text-left' height='35px'><b>:</b></td>
                <td colspan="2" class='text-left' height='35px'><?echo $staffinfo['staff_name'] ;?></td>
            </tr>
            <tr>
                <td colspan="2" class='text-left' height='35px' width="30%"><b>IC Number</b></td>
                <td colspan="1" class='text-left' height='35px'><b>:</b></td>
                <td colspan="2" class='text-left' height='35px'><?echo $staffinfo['noic'];?></td>
            </tr>
            <!--  <tr>
            <td colspan="2" class='text-left' height='35px' width="30%"><b>Position</b></td>
            <td colspan="1" class='text-left' height='35px'><b>:</b></td>
            <td colspan="2" class='text-left' height='35px'><?echo $staffinfo['role_id']; ?></td>
            </tr> -->
            <tr>
                <td colspan="2" class='text-left' height='35px' width="30%"><b>Department</b></td>
                <td colspan="1" class='text-left' height='35px'><b>:</b></td>
                <td colspan="2" class='text-left' height='35px'><?echo $staffinfo['department_sub']; ?></td>
            </tr>
            <tr>
                <td colspan="2" class='text-left' height='35px' width="30%"><b>Company</b></td>
                <td colspan="1" class='text-left' height='35px'><b>:</b></td>
                <td colspan="2" class='text-left' height='35px'><?echo $staffinfo['department_id']; ?></td>
            </tr>
            <?  $created_date= new DateTime($staffinfo['created_date']);
            $ver_date= new DateTime($staffinfo['ver_date']);
            $appcfo_date= new DateTime($staffinfo['appcfo_date']);
            $app_date= new DateTime($staffinfo['app_date']);
            $mec_date= new DateTime($staffinfo['mec_date']);
            ?>
            <tr>
                <td colspan="2" class='text-left' height='35px' width="30%"><b>Date Applied</b></td>
                <td colspan="1" class='text-left' height='35px'><b>:</b></td>
                <td colspan="2" class='text-left' height='35px'><?echo $created_date->format('d-m-Y'); ?></td>
            </tr>


            <table class="one" border="1">
                <tr><br><br>
                    <th style="text-align:center;">DATE</th>
                    <th style="text-align:center;">DESCRIPTION</th>
                    <th style="text-align:center;">TOTAL CLAIM</th>
                </tr>

                <tr>
                    <td style="padding:30px;" align="center" type="date" size="20" name="mec_date" ><? echo $mec_date->format('d-m-Y');?></td>
                    <td style="padding:30px;" align="center" type="text" size="40" name="description"><? echo $staffinfo['description']; ?></td>
                    <td style="padding:30px;" align="center" type="text" size="20" name="total" ><? echo $staffinfo['total_claim'] ;?></td>
                </tr>

            </table>
            <br><br>

            <table class="one" border="1">
                <tr>
                    <!--	<th style="text-align:center;">BALANCE TOTAL(RM)</th> -->
                    <th style="text-align:center;">TOTAL CLAIM(RM)</th>
                    <th style="text-align:center;">BALANCE(RM)</th>
                    <th style="text-align:center;">REMARKS</th>
                </tr>
                <tr>
                    <!--	<td input style="padding:30px;" align="center" type="text" size="10" name="baki_claim"><? echo $staffinfo['baki_claim']; ?></td> -->
                    <td input style="padding:30px;" align="center" type="text" size="20" name="total_claim"><? echo $staffinfo['total_claim']; ?></td>
                    <td input style="padding:30px;" align="center" type="text" size="40" name="jumlah_claim"><? echo $staffinfo['jumlah_claim']; ?></td>
                    <td input style="padding:30px;" align="center" type="text" size="20" name="remarks"><? echo $staffinfo['remarks']; ?></td>
                </tr>

            </table>

            <br><br><br><br>


            <div class="clear-fix"></div>
            <table border='0' cellspacing='0'>


                <tr>
                    <th style="text-align:left;" width="30%">VERIFIED BY HR:</th>
                    <td>
                        <?'<b>'.$staffinfo['ver_status'].'</b>';
                        if($staffinfo['ver_status']=='PENDING'){
                            echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                        else {
                            echo"<span style='background-color:GREEN;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>VERIFIED</span>"
                            ;}'</b>'?>
                        <br><br>
                        <?echo $staffinfo ['ver_name'];?><br><br>
                        <?'<b>'.$staffinfo['ver_date'].'</b>';
                        if($staffinfo['ver_status'] == 'VERIFIED'||$staffinfo['ver_status'] == 'COMPLETE'){
                            echo $ver_date->format('d-m-Y');}?>
                    </td>


                    <th style="text-align:left;" width="30%">APPROVED BY CFO:</th>
                    <td>
                        <?'<b>'.$staffinfo['appcfo_status'].'</b>';
                        if($staffinfo['appcfo_status']=='PENDING'){
                            echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                        else if($staffinfo['appcfo_status']=='APPROVED'){
                            echo"<span style='background-color:GREEN;padding:5px;border-radius:5px;font-weight:bold;color:white;'>APPROVED</span>";}
                        else {
                            echo"<span style='background-color:RED;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISAPPROVED</span>"
                            ;}'</b>'?>
                        <br><br>
                        <?echo $staffinfo['appcfo_name'];?><br><br>
                        <?'<b>'.$staffinfo['appcfo_date'].'</b>';
                        if($staffinfo['appcfo_status'] == 'APPROVED'){
                            echo $appcfo_date->format('d-m-Y');}?>
                    </td>

                <tr><th style="text-align:left;" width="30%">APPROVED BY CEO:</th>
                    <td>
                        <br><br>
                        <?'<b>'.$staffinfo['app_status'].'</b>';
                        if($staffinfo['app_status']=='PENDING'){
                            echo"<span style='background-color:Grey;padding:5px;border-radius:5px;font-weight:bold;color:white;'>PENDING</span>";}
                        else if($staffinfo['app_status']=='APPROVED'){
                            echo"<span style='background-color:GREEN;padding:5px;border-radius:5px;font-weight:bold;color:white;'>APPROVED</span>";}
                        else {
                            echo"<span style='background-color:RED;padding:5px;border-radius: 5px; font-weight:bold;color:white;'>DISAPPROVED</span>"
                            ;}'</b>'?>
                        <br><br>
                        <?echo $staffinfo['app_name'];?><br><br>
                        <?'<b>'.$staffinfo['app_date'].'</b>';
                        if($staffinfo['app_status'] == 'APPROVED'){
                            echo $app_date->format('d-m-Y');}?>
                    </td>
                </tr>

                <tr>
                    <td colspan="2" class='text-left' height='35px' width="30%"></td>
                    <td colspan="2" class='text-left' height='35px'><b></b></td>
                </tr>
                <tr>
                    <td colspan="2" class='text-left' height='35px' width="30%"></td>
                    <td colspan="2" class='text-left' height='35px'><b></b></td>
                </tr>

                </th>
                </tr>
            </table> </table>

        </fieldset>
    </div>
</div>
<div style="text-align:center;">
    <br><input id="btn-Preview-Image" type="button" onclick="window.print()" value="Cetak"/>
    <br><br>
</div>
</div>
<th>

</th>

</tr>
</table>


</body>

<script>
    $(document).ready(function() {
        //window.onload = function() { window.print(); }
    });


</script>
</html>
