<?php

    //include ('../controller/auth.php');

    require "../model/lawatan_functions.php";
    
    require_once("../../util/qrcode.php");
    
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $date_month = date(m);
    $date_year = date(Y);
    $date_day = date(d);
    $time_hour = date(H);
    $time_min = date(i);
    $time_sec = date(s);

    $sys = getSys(1)->fetch_assoc();

    $id_kad=$_GET['id_kad'];
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

    <link href="../../resources/css/kad_pelawat.css" rel="stylesheet">
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
<form action="">
    <input type="hidden" id="id_kad" value="<? echo $id_kad;?>"/>
</form>
 
<input id="btn-Preview-Image" type="button" onclick= "addJumlahCetakanPilihan()" class="view" href="lawatan_kad_senarai.php" value="Cetak"/> 
    
<center>    
<table border="0">   
    <?
    $kad_pilihan = getKadPelawatCetakanPilihan($id_kad);
        $i=1;
        while($list_kad_pilihan = $kad_pilihan->fetch_assoc()) {
           // echo $data_label['id_naskah'];
        if(($i%2) == 1){
            echo "</tr> <tr>";
        }  
    ?>  
        <td>        
<table border="0">

<tr>   
<th>  
        <!-- /#page-wrapper ----------------------------------------------------------------->
<fieldset class="first" style="background-image: url('../../photos/background_card/background_kad_pelawat.jpg');">
        <table align="center" border="0" >
        <tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
        <tr>
            <td colspan="2" align="center" style="font-size: 11px;  opacity: 0.8;" bgcolor="#FFFFFF"><strong><font color="black" size="5"><?echo $sys['name'];?></font></strong></b></td>
        </tr>
        <tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr><tr></tr>
            <td colspan="2" align="center" style="font-size: 11px;  opacity: 0.8;" bgcolor="#FFFFFF"><strong><font color="black" size="5"><?echo $list_kad_pilihan['nama_kad'];?></font></strong></b></td></tr>
            <tr></tr><tr></tr>
            <th colspan="2">
            <div align="center" valign="top" style="line-height: 0.9;">
        </tr>

        <tr>
        <td colspan="2" align="center"><strong><font color="black" size="5"><?echo $list_kad_pilihan['jenis_kad'];?></font></strong></b></td>
        <!--<td colspan="2" align="center" style="border-radius: 8px; font-size: 10px;  opacity: 0.9;" bgcolor="#FF0000"><b><?echo $list_peserta['nama'];?></b></td>-->
        </tr>
        <tr>
        <br><td colspan="2" align="center"><font style="font-size: 11px;"><b></b></font>
        <br><br><div id="html-content-holder<?echo $i;?>" >
            <? 
                $qr = new QRCode();
                $qr = QRCode::getMinimumQRCode($list_kad_pilihan['jenis_kad'].'-'.$list_kad_pilihan['kod_kad'], QR_ERROR_CORRECT_LEVEL_L);
                $qr->printHTML("8px");
            ?>
            </div>   
            <div id="previewImage<?echo $i;?>"></div><br>
            </td>
        </tr>
        <tr>
        <td colspan="2" align="center" style="border-radius: 8px; font-size: 11px;  opacity: 0.8;" bgcolor="#000000"><strong><font color="white" size="4"><?echo $list_kad_pilihan['kod_kad'];?></font></strong></b></td>
        <!--<td colspan="2" align="center" style="border-radius: 8px; font-size: 10px;  opacity: 0.9;" bgcolor="#FF0000"><b><?echo $list_peserta['nama'];?></b></td>-->
        </tr>
        <tr><tr></tr><br>
    </table>
</fieldset>
</th>
</tr>
</table>
</center>

<script>
    function addJumlahCetakanPilihan(){
        var id_kad=$("#id_kad").val();
        //alert(id_kad);
            $.ajax({
                url: "../model/lawatan_functions.php",
                type: "POST",
                data: {action:"addJumlahCetakanPilihan",id_kad:id_kad},
                success: function (response) {
                    // you will get response from your php page (what you echo or print)                 
                    //$.alert('test here:'+response);
                    //$( "#dataTables-example" ).load( "penternak_senarai.php #dataTables-example" );

                    window.print();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                   console.log(textStatus, errorThrown);
                }
            });
        }
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