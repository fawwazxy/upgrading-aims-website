<?php

    include ('../controller/auth.php');

    require "../model/library_functions.php";
    
    require_once("../../util/qrcode.php");
    
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $date_month = date(m);
    $date_year = date(Y);
    $date_day = date(d);
    $time_hour = date(H);
    $time_min = date(i);
    $time_sec = date(s);
    $sys = getSys(1)->fetch_assoc();
    $id = $_GET['id'];
    $id_elibrary = $_GET['id'];
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

<link href="../../resources/css/library_label.css" rel="stylesheet">
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
    <?
    $label = getLabelInfo($id);
        $i=1;
        while($data_label = $label->fetch_assoc()) {
        if(($i%3) == 1){
            echo "</tr> <tr>";
        }  
    ?>  
        <td>        
<table border="0">

<tr>   
<th>  
        <!-- /#page-wrapper ----------------------------------------------------------------->
<fieldset>
        <table class="front" align="center" border="0" >
        <tr>
            <tr>
            <td>
            <br><strong><font color="black" size="2"><?echo $data_label['jenis']?></font></strong></b><br>
            <strong><font color="black" size="2"><?echo $data_label['nama']?></font></strong></b>
            <br><strong><font color="green" size="2"><?echo $data_label['lokasi_fizikal_hardcopy']?></font></strong></b>
            <br><strong><font color="red" size="2"><?echo $data_label['isbn']?></font></strong></b></td></td>
            </tr>
        <td colspan="2" align="center"><font style="font-size: 11px;"><b></b></font>
        <br>
        <div id="html-content-holder<?echo $i;?>" >
            <? 
                $qr = new QRCode();
                $qr = QRCode::getMinimumQRCode('elib-'.$data_label['id_elibrary'].'-'.$data_label['id'], QR_ERROR_CORRECT_LEVEL_L);
                $qr->printHTML("4px");
                echo 'elib-'.$data_label['id_elibrary'].'-'.$data_label['id'];
            ?>
            </div>   
            <div id="previewImage<?echo $i;?>"></div><br>
            <a class="view" target="_blank" href="library_label_detail.php?id=<?echo $data_label['id'] ;?>"><button class="btn btn-success hidden-print"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Label</button></a>
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

    
var element = $("#html-content-holder<?echo $i;?>"); // global variable
var getCanvas; // global variable
 
// html2canvas(element, {
//      onrendered: function (canvas) {
//             $("#previewImage").append(canvas);
//             getCanvas = canvas;
//          }
//      });



html2canvas($('#html-content-holder<?echo $i;?>').get(0)).then( function (canvas) {
//console.log(canvas);
    $("#previewImage<?echo $i;?>").append(canvas);
    getCanvas = canvas;
    $("#html-content-holder<?echo $i;?>").css("display", "none");
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
</td>
<?php $i++;
$j++; } ?>
</table>
</body>

</html>