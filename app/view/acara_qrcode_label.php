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
	
	$sys = getSys(1)->fetch_assoc();
    $sys_domain=$sys['sys_domain'];
    $shortcode=$sys['short_name'];

?>



<?php

$id = $_GET['id_sesi'];
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
    <script src="../../js/html2canvas/html2canvas.js"></script>
    <? require "../../resources/css/surat.css";?>
<script language="javascript" type="text/javascript">


</script>
<style type="text/css">
@media print {
  #html-content-holder {
    display: none;
  }
  #btn-Preview-Image {
    display: none;
  }
} 

</style>

</head>
		<?
			$acara = getSesiAcaraById($id)->fetch_assoc();
		
		?>
<body>
  
   <center>
       	<u><b><font size="10">Simulasi Log Kehadiran <? echo $acara['nama']; ?></font></b></u><br><br><br>
       	</center>
	            <center><div id="html-content-holder">
			    <?	
				$qr = new QRCode();
				$qr = QRCode::getMinimumQRCode($sys_domain, QR_ERROR_CORRECT_LEVEL_L);
				$qr->printHTML("12px");
			    ?>
				</div> <br>
				</center>
				<center>
				<div id="previewImage" width="20%">
				</div>
				</center>
	<br>
	<center>
	<br><br><br>
	<b>Imbas QR-CODE ini dengan menggunakan Mobile APP yang telah dibekalkan <br>bagi tujuan pendaftaran.</b><br><br><br>
   </center>
   <br>
   <center>
       Hakcipta Terpelihara ©<b><? echo $sys['sys_name']; ?></b> <? echo $date_year;?>.<br>
       Hasil Ciptaan, Konsep dan Rekabentuk oleh Indeepreneur.com
   </center>
   
<script>
$(document).ready(function(){

	
var element = $("#html-content-holder table tbody"); // global variable
var getCanvas; // global variable
 
// html2canvas(element, {
//      onrendered: function (canvas) {
//             $("#previewImage").append(canvas);
//             getCanvas = canvas;
//          }
//      });



html2canvas($('#html-content-holder table tbody')).then( function (canvas) {
console.log(canvas);
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