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

    $id_sesi = $_GET['id_sesi'];
    $sys = getSys(1)->fetch_assoc();
    $data_sesi = getListSijilPeserta($id_sesi)->fetch_assoc();
    $datas = getPesertaList($id_sesi)->fetch_assoc();
        
        ?>
<html>
  <head>
  
    <!-- Body CSS -->  
   
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
    .a {
    background-image: url('../../acara/sijil/certificate.png');
      background-size: 100% auto;
      width:100%;
      height:100%;
      background-repeat: no-repeat;
      background-position: center top;
      
    }
    @media print{
      .footer{
        display: inline-block;
        position: fixed;
        bottom: 100px;
      }
    }
    </style>
  </head>
  <body>
    <input id="btn-Preview-Image" type="button" onclick="window.print()" value="Cetak"/>
     <?
    $datas = getListSijilPeserta($id_sesi);
    $i=1;
    while($list_peserta = $datas->fetch_assoc()) { 
       
    ?>

       <div align="center" class="a"><br><br><br>
    <!--<p><a href="#" id="print" class="button" onclick="window.print();return false;">Cetak Penyata</a><br><br></p>-->
    <h3 style="font-family:Times New Roman">
    <?echo'<img src="../../resources/images/'.$sys['clogo2'].'" height="140"/>';?><br><br>
    <strong><font color="black" size="5"><? echo $sys['cname'];?><br><? //echo $listx['agency_name'];?></font></strong></h3>
    <center>
	<table class="front" align="center" border="0">
    <tr>
        <td width="5%">&nbsp;</td>
        <td width="90%" align="center">
	<h2 style="font-family:Lucida Calligraphy"><strong><font color="red" size="8">SIJIL PENYERTAAN</font></strong></h2>    
    <h4 style="font-family:century gothic"><font color="#1872BB">Dengan sukacitanya merakamkan ucapan penghargaan kepada</font><br>
    <strong><font style="font-family:Times New Roman" color="black"><? echo $list_peserta['nama'];?><br>(No. K/P :&nbsp;<? echo $list_peserta['nokp'];?>)</font></strong></h4>
    <h4 style="font-family:century gothic"><font color="#1872BB">Di atas penglibatan dalam menjayakan</font><br>
    <strong><font style="font-family:Times New Roman" color="black"><? echo $data_sesi['nama_sesi'];?></font></strong></h4>
    <h4 style="font-family:century gothic"><font color="#1872BB">Sebagai</font><br>
    <strong><font style="font-family:Times New Roman" color="black"><? echo $data_sesi['nama_kumpulan'];?></font></strong></h4>
    <h4 style="font-family:century gothic"><font color="#1872BB">Pada</font><br>
    <strong><font style="font-family:Times New Roman" color="black"><?echo date("d F Y",strtotime($data_sesi['tarikh_mula']));?> hingga <?echo date("d F Y",strtotime($data_sesi['tarikh_tamat']));?>
	</font></strong></h4>    
    <h4 style="font-family:century gothic"><font color="#1872BB">Bertempat di</font><br>
    <strong><font style="font-family:Times New Roman" color="black"><? echo $data_sesi['lokasi'];?></font></strong></h4>    
    <h5 style="font-family:century gothic"><font color="#1872BB">&nbsp;</font><br><font color="red"><i>&nbsp;</i></font></h5>

      <div align="center"><font size="1">
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>
    (Dokumen ini adalah cetakan komputer dan tidak memerlukan tandatangan)<br>Cetakan dokumen pada : <?echo date('d-m-Y');?></font>
      </div>
	  </td>
        <td width="5%">&nbsp;</td>
    </tr>  
   </table>
   </center>
      <p style="page-break-after:always;"></p>
    <?php
      }
    ?>
  </body>
</html>
