<?php

    // include ('../controller/auth.php');

    require "../model/ahli_functions.php";

    date_default_timezone_set("Asia/Kuala_Lumpur");
    $date_month = date('m');
    $date_year = date('Y');
    $date_day = date('d');
    $time_hour = date('H');
    $time_min = date('i');
    $time_sec = date('s');

    $current_date=$date_year."-".$date_month."-".$date_day." ".$time_hour.":".$time_min.":".$time_sec;

    $sys = getSys(1)->fetch_assoc();
    $tahun=$_GET['tahun'];

    $ahli_kelab_persatuan_info = getAhliKelabPersatuanInfo()->fetch_assoc();



    function getMonthString($num)
    {
 
          
      switch($num)
      {
        case 1:
          $month="JANUARI";
          break;
        case 2:
          $month="FEBRUARI";
          break;
        case 3:
          $month="MAC";
          break;
        case 4:
          $month="APRIL";
          break;
        case 5:
          $month="MEI";
          break;
        case 6:
          $month="JUN";
          break;
        case 7:
          $month="JULAI";
          break;
        case 8:
          $month="OGOS";
          break;
        case 9:
          $month="SEPTEMBER";
          break;
        case 10:
          $month="OKTOBER";
          break;
        case 11:
          $month="NOVEMBER";
          break;
        case 12:
          $month="DISEMBER";
          break;
        default:
          $month="Invalid month";
      }
      return $month;
    }

?>



<!DOCTYPE html>
<html>
    
    <title>iOffice::Sistem Pengurusan Pejabat Bersepadu</title>
    <head>
    <script src="../../js/jquery/jquery.min.js"></script>
    <script src="../../js/html2canvas/html2canvas.js"></script>

        <style type="text/css">
        i{
            font-family: "Times New Roman";
        }
        body {      
            font-family: Times New Roman;
            font size: 100px;
        }
         
        div.invoice {
        border:0px solid #ccc;
        padding:10px;
        height:740pt;
        width:570pt;
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
         
        th {
            text-align: left;
           padding-left: 5px;
            padding-bottom: 8px;
            padding-top: 8px;
        }
         
        td {
            padding-left: 5px;
            padding-bottom: 8px;
            padding-top: 8px;
        }
         
        .text-left {
            text-align:left;
        }
         
        .text-center {
            text-align:center;
        }
         
        .text-right {
            text-align:right;
        }

        .text-top {
            text-align:top;
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

    </style>

    </head>
 
    <body>
    <center>
            <br><br><br>
            <input id="btn-Preview-Image" type="button" onclick="window.print()" value="Cetak"/>
            
            <div class="invoice">
            <div style="text-align:center">

            <center>
            <div class="clear-fix"></div>

           
                <h3>PENYATA PERBELANJAAN</h3>
            
                <?if($ahli_kelab_persatuan_info['logo'] != ''){echo '<img width="100" height="100" src="data:image/jpeg;base64,'.base64_encode( $ahli_kelab_persatuan_info['logo'] ).'"/>';
                }?>  
                <br><b><?echo $ahli_kelab_persatuan_info['nama'];?></b><br><br>
                <h4 align="center">TAHUN : <? echo $tahun;?></h4>
                <h4 align="center">CETAKAN PADA : <? echo $current_date;?></h4>

                <table border="1">
                    <tr>
                        <td style="padding-top:10px;padding-bottom: 10px;font-size: 20px;"><b>JUMLAH KESELURUHAN</b></td>
                        <td style="padding-top:10px;padding-bottom: 10px;font-size: 20px;"><b>RM<? echo number_format(getJumlahPerbelanjaan($tahun),2,'.',',');?></b></td>
                    </tr>
                </table>
            <? 
            $i=1;
            $bulan =  getBulanBelanja($tahun);
            while($list_bulan = $bulan ->fetch_assoc()) { 
        ?>

               
        <h4 align="left">BULAN <? echo getMonthString($list_bulan['bulan']);?></h4>
            <table border='1' cellspacing='0'>
            <thead> 
                <tr>
                    <th>#</th>
                    <th>Tarikh</th>
                    <th>Nama Penerima</th>
                    <th>Keterangan</th>
                    <th style="text-align: right;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <? 
                $m=1;
                $ahli =  getPenyataBelanja($list_bulan['bulan'],$tahun);
                while($list_ahli= $ahli ->fetch_assoc()) { 
                    $$i+=$list_ahli['jumlah'];
                ?>        
                <tr>
                    <td><? echo $m;?></td>
                    <td><? echo $list_ahli['tarikh'];?></td>
                    <td><? echo $list_ahli['penerima'];?></td>
                    <td><? echo $list_ahli['keterangan'];?></td>
                    <td align="right">RM<? echo number_format($list_ahli['jumlah'],2,'.',',');?></td>
                </tr>
                <?$m++;}?>
                <tr>
                    <td colspan="4" align="right" style="padding-top: 10px;padding-bottom: 10px;"><b>JUMLAH KESELURUHAN &nbsp;</b></td>
                    <td align="right" style="padding-top: 10px;padding-bottom: 10px;"><b><u>RM<? echo number_format($$i,2,'.',',');?></u></b></td>

                </tr>
            </tbody>
            
           
    </table>
    <?$i++;}?>
    <div style="text-align:center;">
    <br><input id="btn-Preview-Image" type="button" onclick="window.print()" value="Cetak"/>
    <br><br>

 


            
    </body>

</html>
