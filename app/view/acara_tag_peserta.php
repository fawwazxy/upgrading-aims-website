<?php

    include ('../controller/auth.php');

    require "../model/acara_functions.php";
    
    require_once("../../util/qrcode.php");
    
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $date_month = date(m);
    $date_year = date(Y);
    $date_day = date(d);
    $time_hour = date(H);
    $time_min = date(i);
    $time_sec = date(s);

    $id=$_GET['id'];
    $nokp = $_GET['nokp'];
    $id_sesi = $_GET['id_sesi'];
    $nama = $_GET['nama'];
    $sys = getSys(1)->fetch_assoc();
    $data_sesi = getInfoTagPeserta($id_sesi,$nokp)->fetch_assoc();
    
    ?>

 
<!DOCTYPE html>
<html lang="en">

<head>
    <title><? echo $sys['sys_name']; ?>::<? echo $sys['sys_tagline']; ?></title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="../../js/jquery/jquery.min.js"></script>
<script src="../../js/html2canvas/html2canvas.js"></script>

<link href="../../resources/css/kad_matrik.css" rel="stylesheet">
<link rel="shortcut icon" type="image/x-icon" href="../../resources/images/<? echo $sys['logo_filename']; ?>" />

<style type="text/css">
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

</style>
</head>

<body>
<input id="btn-Preview-Image" type="button" onclick="window.print()" value="Cetak"/> 
<center>    
<table border="0">
<tr>   
<th>  
        <!-- /#page-wrapper ----------------------------------------------------------------->
<fieldset class="first" style="background-image: url('../../acara/design_pasmasuk/<?echo $data_sesi['pasmasuk_filename']?>');">
        <table class="front" align="center" border="0" >
        
        <tr><tr></tr>
            <td colspan="2" align="center" style="border-radius: 8px; font-size: 11px;  opacity: 0.9;" bgcolor="#000000"><strong><font color="white" size="2">PAS MASUK</font></strong></b></td></tr>
            <tr></tr><tr></tr>
            <tr><td colspan="2" align="center" style="border-radius: 8px; font-size: 10px;  opacity: 0.9;" bgcolor="#FFFFFF"><strong><font color="black" size="0.5"><?echo $data_sesi['nama_sesi']?></font></strong></b></td>
            </tr>
            <th colspan="2">
            <div><!--<strong><font color="black" size="2">PAS MASUK</font></strong>--></div>
            <div><!--<font color="red" size="1"><?echo $data_sesi['nama_sesi']?></font>--></div>
            <div align="center" valign="top" style="line-height: 0.9;">
            <font style="font-size:7px;">
            <h3><strong><b><?echo $data_sesi['lokasi']?></b></strong></h3>
            <h3><strong><b><?echo date("d F Y",strtotime($data_sesi['tarikh_mula']));?> - <?echo date("d F Y",strtotime($data_sesi['tarikh_tamat']));?></b></strong></h3>
            </font>
        </tr>

         <tr>
            <td colspan="2" align="center">
             <?echo '<img width="60" height="70" src="../../acara/foto_peserta/'.$data_sesi['photo_filename'].'"/>';?></td>
        </tr>

        <tr>
        <td colspan="2" align="center" style="border-radius: 8px; font-size: 11px;  opacity: 0.9;" bgcolor="#FF0000"><strong><font color="black"><?echo $data_sesi['nama'];?></font></strong></b></td>
        <!--<td colspan="2" align="center" style="border-radius: 8px; font-size: 10px;  opacity: 0.9;" bgcolor="#FF0000"><b><?echo $list_peserta['nama'];?></b></td>-->
        </tr>
        <td align="center" valign="top" style="line-height: 0.9;"><font style="font-size:10px;">
        <? echo strtoupper($data_sesi['nama_kumpulan'])?>
        </font>
        </td>

        <tr>
        <td colspan="2" align="center"><font style="font-size: 11px;"><b></b></font>
        <div id="html-content-holder<?echo $i;?>" >
            <? 
                $qr = new QRCode();
                $qr = QRCode::getMinimumQRCode($data_sesi['nokp'], QR_ERROR_CORRECT_LEVEL_L);
                $qr->printHTML("3px");
            ?>
            </div>   
            <div id="previewImage<?echo $i;?>"></div><br>
            </td>
        </tr>
       
    </table>
</fieldset>
</th>
</tr>
</table>
</center>

<script>
$(document).ready(function(){

    
var element = $("#html-content-holder"); // global variable
var getCanvas; // global variable
 
// html2canvas(element, {
//      onrendered: function (canvas) {
//             $("#previewImage").append(canvas);
//             getCanvas = canvas;
//          }
//      });



html2canvas($('#html-content-holder').get(0)).then( function (canvas) {
//console.log(canvas);
    $("#previewImage").append(canvas);
    getCanvas = canvas;
    $("#html-content-holder").css("display", "none");
});


//var imgageData = getCanvas.toDataURL("image/png");
var imgageData = getCanvas.toDataURL("image/png");
// Now browser starts downloading it instead of just showing it
var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
//$("#btn-Convert-Html2Image").attr("download", "your_pic_name.png").attr("href", newData);

//$("#html-content-holder").hide();
//$("#html-content-holder").css("visibility", "hidden");


});
</script>
</body>
</html>

