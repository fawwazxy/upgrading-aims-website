<?php

    //include ('../controller/auth.php');

    require "../model/acara_functions.php";
    
    require_once("../../util/qrcode.php");
    
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $date_month = date(m);
    $date_year = date(Y);
    $date_day = date(d);
    $time_hour = date(H);
    $time_min = date(i);
    $time_sec = date(s);

    //$id=$_GET['id'];
    $nokp = $_GET['nokp'];
    $id_sesi = $_GET['id_sesi'];
    //$nama = $_GET['nama'];
    $sys = getSys(1)->fetch_assoc();
    $data_sesi = getInfoSijilPeserta($id_sesi,$nokp)->fetch_assoc();
    
    ?>

 
<!DOCTYPE html>
<html>
<head>
<title>Sijil Penyertaan</title>
<!-- Body CSS -->   
<style type="text/css"> 
@media print {
  #html-content-holder {
    display: none;
  }
  #btn-Preview-Image {
    display: none;
  }
} 
body {
    background-image: url('../../acara/sijil/certificate.png');
    background-size: 100% auto;
    background-repeat: no-repeat;
    background-position: center top;
}

</style>
</head>

<body>

<center>    
<table border="0" width="100%" height="100%">
<tr>   
<th>  
        <!-- /#page-wrapper ----------------------------------------------------------------->
    <table class="front" align="center" border="0" >

    <div align="center"><br><br>
    <!--<p><a href="#" id="print" class="button" onclick="window.print();return false;">Cetak Penyata</a><br><br></p>-->
    <h3 style="font-family:Times New Roman">
    <?echo'<img src="../../resources/images/'.$sys['clogo2'].'" height="150"/>';?><br><br>
    <strong><font color="black" size="5"><? echo $sys['cname'];?><br><? //echo $listx['agency_name'];?></font></strong></h3>
    </table>
    <table class="front" align="center" border="0">
    <tr>
        <td width="3%">&nbsp;</td>
        <td width="94%">
    <h2 style="font-family:Lucida Calligraphy"><strong><font color="red" size="8">SIJIL PENYERTAAN</font></strong></h2>    
    <h4 style="font-family:century gothic"><font color="#1872BB" size="5">Dengan sukacitanya merakamkan ucapan penghargaan kepada</font><br>
    <strong><font style="font-family:Times New Roman" color="black" size="6"><? echo $data_sesi['nama'];?><br>(No. K/P :&nbsp;<? echo $data_sesi['nokp'];?>)</font></strong></h4>
    <h4 style="font-family:century gothic"><font color="#1872BB" size="5">Di atas penglibatan dalam menjayakan</font><br>
    <strong><font style="font-family:Times New Roman" color="black" size="6"><? echo $data_sesi['nama_sesi'];?></font></strong></h4>
    <h4 style="font-family:century gothic"><font color="#1872BB" size="5">Sebagai</font><br>
    <strong><font style="font-family:Times New Roman" color="black" size="6"><? echo $data_sesi['nama_kumpulan'];?></font></strong></h4>
    <h4 style="font-family:century gothic"><font color="#1872BB" size="5">Pada</font><br>
    <strong><font style="font-family:Times New Roman" color="black" size="6"><?echo date("d F Y",strtotime($data_sesi['tarikh_mula']));?> hingga <?echo date("d F Y",strtotime($data_sesi['tarikh_tamat']));?>
    </font></strong></h4>    
    <h4 style="font-family:century gothic"><font color="#1872BB" size="5">Bertempat di</font><br>
    <strong><font style="font-family:Times New Roman" color="black" size="6"><? echo $data_sesi['lokasi'];?></font></strong></h4>    
    <h5 style="font-family:century gothic"><font color="#1872BB">&nbsp;</font><br><font color="red"><i>&nbsp;</i></font></h5>

    <div align="center"><font size="1">
        <br><br><br><br><br><br><br><br><br><br><br><br><br>
    (Dokumen ini adalah cetakan komputer dan tidak memerlukan tandatangan)<br>Cetakan dokumen pada : <?echo date('d-m-Y');?></font>
      </div>
            
        </td>
        <td width="3%">&nbsp;</td>
    </tr>
   
        
        
    
           
   </table>
</div>
</body>
</html>