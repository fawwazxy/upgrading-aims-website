<?php

	include ('../controller/auth.php');

	require "../model/staff_function.php";
	
    require_once("../../util/qrcode.php");
    
    date_default_timezone_set("Asia/Kuala_Lumpur");
	$date_month = date(m);
	$date_year = date(Y);
	$date_day = date(d);
	$time_hour = date(H);
	$time_min = date(i);
	$time_sec = date(s);


        $sys = getSys(1)->fetch_assoc();

		$id=$_GET['id'];
		
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

</style>
</head>

<body>
 
 <input id="btn-Preview-Image" type="button" onclick="window.print()" value="Print"/>
 
  <?
								
									$log_pelajar_asrama = getStafIn($id);
									$row_data1 = $log_pelajar_asrama->fetch_assoc()
?>
	
<table border="0">

<tr>   
<th>  
        <!-- /#page-wrapper ----------------------------------------------------------------->
<fieldset class="first" style="background-image: url('../../photos/background_card/temp_bg.png');">
		<table class="front" align="center" border="0" >
		
		<tr>
			<th colspan="2">
			<?echo'<img src="data:image/jpeg;base64,'.base64_encode( $sys['clogo'] ).'" width="50px"/>';?>
			<?echo'<img src="data:image/jpeg;base64,'.base64_encode( $sys['logo'] ).'" width="60px"/>';?></th>
			
		</tr>	
		<tr>
			<td colspan="2" align="center"><font style="font-size: 11px;"><b><?echo $sys['cname']?></b></font><br>
			<?echo '<img src="../../staffphoto/'.$row_data1['nama_photo'].'" border="0" width="90px" height="100px"/>';?></td>
		
		</tr>
		<tr>
			
			<td align="center" valign="top" style="line-height: 0.9;"><font style="font-size:10px;">
		
			
			<? echo strtoupper($row_data1['name'])?><br><?echo $row_data1['no_staff'];?>
			</font>
			<br><br>
			</td>
		
		</tr>
		<tr>
		<br>
		<td colspan="2" align="center" style="border-radius: 8px;  opacity: 0.7;" bgcolor="#FF0000"><b><?echo $row_data1['description'];?></b></td>
		</tr>

    <!-- /#wrapper -->
	</table>
	 </fieldset>
</th>

<th>
	  
	  <!-- /#page-wrapper ------------------------------------------------------------------------->
<fieldset class="back">

		<table border="0">
		<br/>
		
		<tr>
			<td width="40%"align="center">
				<div id="html-content-holder" >
			
			<?	
				
				$qr = new QRCode();
				//$qr = QRCode::getMinimumQRCode($row_data1['noic'], QR_ERROR_CORRECT_LEVEL_L);
                $ic_encoded = base64_encode($row_data1['noic']);
                $name = $sys['caddress'];
                $message = 'If found please return to AIMS GLOBAL HOLDINGS SDN BHD. No. 20 & 21 Blok B, Bestari Centre Jalan Hiliran, 20300 Kuala Terengganu. Tel 609-6228848';
                //$message = 'Please call 609-6228848';
                $splitter = '#';
                $str = $ic_encoded.$splitter.$message;
                $qr = QRCode::getMinimumQRCode($str, QR_ERROR_CORRECT_LEVEL_L);
				$qr->printHTML("4px");
			?>
				</div>   
				<div id="previewImage">
                    <script defer>
                        $(document).ready(function () {
                            let elem = $('#previewImage').children('canvas:nth-child(1)');
                            elem.attr('style', 'max-height: 100px');
                        })
                    </script>
				</div>
				<font style="font-size: 8px;"> <p><font style="font-size: 7px; line-height: 6px;"><br>Imbas kod QR ini pada terminal pengimbas keluar/masuk.<br><br>Jika kad ini dijumpai, sila kembalikan kepada:</font></p></font>
									
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center"><font style="font-size: 8px;"> 
			
			<p><font style="font-size: 8px;"><?echo $sys['cname']?><br>
			<?echo $sys['caddress']?><br>
			Hotline: <?echo $sys['ctel']?><br>
			Emel: <?echo $sys['cemail']?></font></p> </font>
			</td>
			
		</tr>
		<tr>
			<td colspan="2" class="footer" align="center"><p style="line-height: 5px;">
			<span style="font-size: 7px; line-height: 0.9;">Hakcipta Terpelihara &copy;<strong><? echo $sys['sys_name']; ?></strong>&nbsp;<? echo $date_year;?></span></p>
			</td>
		</tr>
  
    <!-- /#wrapper -->
	</table>
	 </fieldset>
</th>

</tr>
</table>
	
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
