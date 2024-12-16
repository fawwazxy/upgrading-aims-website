<?php
require "../model/staff_function.php";
require_once("../../util/qrcode.php");
date_default_timezone_set("Asia/Kuala_Lumpur");
$sys = getSys(1)->fetch_assoc();
$id=$_GET['id'];
$staffInfo = getStafIn($id);
$row = $staffInfo->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Kad Digital Staf Aims-Global</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="../../js/jquery/jquery.min.js"></script>
    <script src="../../js/html2canvas/html2canvas.js"></script>

    <link href="../../resources/css/kad_staff_mobile.css" rel="stylesheet">
    <link rel="shortcut icon" type="image/x-icon" href="../../resources/images/<? echo $sys['logo_filename']; ?>" />

    <style>
        .pt-1{
            padding-top: 11px;
        }

        /*@media print {
            #html-content-holder {
                display: none;
            }
            #btn-Preview-Image {
                display: none;
            }
        }*/
    </style>

</head>
<body>
<fieldset class="first" style="background-image: url('../../photos/background_card/temp_bg.png');">
    <table class="front" style="width: 100%; border: 0">
        <tr>
            <th class="pt-1">
                <img src="data:image/jpeg;base64,<? echo base64_encode($sys['clogo']) ?>" style="width: 50px" alt="aims-logo"/>
               <img src="data:image/jpeg;base64, <? echo base64_encode($sys['logo']) ?>" style="width: 70px" alt="i-office-logo"/>
            </th>
        </tr>
        <tr>
            <th class="pt-1" style="font-size: 15px">
                <?echo $sys['cname']?>
            </th>
        </tr>
        <tr>
            <th class="pt-1" style="font-size: 15px">
                <img src="../../staffphoto/<? echo $row['nama_photo'];?>" style="width: 96px; height: 96px" alt="staff-photo"/>
            </th>
        </tr>
        <tr>
            <th class="pt-1">
                <? echo strtoupper($row['name'])?><br><?echo $row['no_staff'];?>
                <br><br>
                <b style="padding-bottom: 64px"><?echo $row['description'];?></b>
            </th>
        </tr>
        <tr>
            <th class="pt-1" style="">
                <div class="row">
                    <div style="width: 116px; margin-left: 115px; margin-bottom: 8px">
                        <?
                        $qr = new QRCode();
                        $ic_encoded = base64_encode($row['noic']);
                        $name = $sys['caddress'];
                        //$message = 'If found please return to AIMS GLOBAL HOLDINGS SDN BHD. No. 20 & 21 Blok B, Bestari Centre Jalan Hiliran, 20300 Kuala Terengganu. Tel 609-6228848';
                        $message = '\nPlease call 609-6228848';
                        $splitter = '#';
                        $str = $ic_encoded.$splitter.$message;
                        $qr = QRCode::getMinimumQRCode($str, QR_ERROR_CORRECT_LEVEL_L);
                        $qr->printHTML("4px");
                        ?>
                    </div>
                </div>

            </th>
        </tr>
    </table>
</fieldset>

<!--<script>
    $(document).ready(function(){
        let element = $("#html-content-holder"); // global variable
        let getCanvas; // global variable

        html2canvas($('#html-content-holder').get(0)).then( function (canvas) {
            $("#previewImage").append(canvas);
            getCanvas = canvas;
            $("#html-content-holder").css("display", "block");
        });

        var imgageData = getCanvas.toDataURL("image/png");
// Now browser starts downloading it instead of just showing it
        var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
//$("#btn-Convert-Html2Image").attr("download", "your_pic_name.png").attr("href", newData);
    });
</script>-->
</body>

</html>
