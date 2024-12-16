<?php

    include ('../controller/auth.php');

    require "../model/agromart_functions.php";

    $no_resit = $_GET['no_resit'];
    $sys = getSys(1)->fetch_assoc();
    $resit_info = getInfoResitJualan($no_resit);
?>

<!DOCTYPE html>
<html>
 
    <head>
   <title>Resit Jualan</title>
        <style type="text/css">
        body {      
            /*font-family: Verdana;*/
            font-family: Times New Roman;
        }
         
        div.invoice {
        border:1px solid #ccc;
        padding:10px;
        height:740pt;
        width:570pt;
        }
 
        div.company-address {
            border:1px solid #ccc;
            float:left;
            width:200pt;
        }
         
        div.invoice-details {
            border:1px solid #ccc;
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
            padding-top: 3px;
            padding-bottom: 3px;
            padding-left: 5px;
        }
         
        td {
        }
         
        .text-left {
            text-align:left;
            padding-top: 3px;
            padding-bottom: 3px;
            padding-left: 5px;
        }
         
        .text-center {
            text-align:center;
        }
         
        .text-right {
            text-align:right;
        }
         
    
                     @media print {
  #printPageButton {
    display: none;
  }
} 
        </style>


    </head>
 
    <body>
    
            <button id="printPageButton" onClick="window.print();">Cetak Resit</button> 
            
              <button id="printPageButton" onclick="window.close()">Tutup</button>
    <center>
    <div class="invoice">
        <div style="text-align:center">
        
        
                <center><?echo '<img width="20%" alt="Snow" height="150" src="data:image/jpeg;base64,'.base64_encode( $resit_info['logo'] ).'"/>';?></center><br>
                <strong><? echo $resit_info['nama'];?> (<? echo $resit_info['no_pendaftaran'];?>)</strong>
                <br><br><? echo $resit_info['alamat']; ?>
                <br><br><? echo $resit_info['notel']; ?>
                <br><br><strong>RESIT JUALAN</strong><br>                
            </div>
            <br>
                <table>
                
                    <tbody>
                    <tr>
                    <td width="10%"><b>Tarikh :</b></td><td><? echo $resit_info['created_date']; ?></td> 
                    <td align="right"><b>No. Resit :</b> <? echo $resit_info['no_resit']; ?></td>
                    </tr>
                     <tr><td>&nbsp;<br></td></tr> 
                     <tr><td>&nbsp;<br></td></tr> 
         
        <div class="clear-fix"></div>
            <table border='1' cellspacing='0'>
                <tr>
                    <th width="10%">Kod Item</th>
                    <th width="30%">Nama Item</th>
                    <th width="15%">Kuantiti</th>
                    <th width="15%">Jumlah (RM)</th>
                </tr>
 
            <tbody>
                <?
                    $item = getItemResitJualan($no_resit);
                    $i=1;
                    while($list_item = $item->fetch_assoc()) {
                ?>
                <tr>
                    <td class='text-left'><?echo $list_item['kod_item'];?></td>
                    <td class="text-left"><?echo $list_item['nama_item'];?></td>
                    <td class='text-left'><?echo $list_item['kuantiti_item'];?></td>
                    <td class='text-right'><?echo $list_item['jumlah_harga_item'];?></td>
                    </tr>
           
                <?}?>    
            <tr> 
            <td colspan='3' class='text-right'><b>Jumlah Keseluruhan</b></td>
            <td class='text-right'><b>RM<? echo $resit_info['jumlah_jualan']; ?></b></td>
            </tr>
            <tr> 
            <td colspan='3' class='text-right'><b>Jumlah Bayaran</b></td>
            <td class='text-right'><b>RM<? echo $resit_info['jumlah_bayaran']; ?></b></td>
            </tr>
            <tr> 
            <td colspan='3' class='text-right'><b>Jumlah Baki</b></td>
            <td class='text-right'><b>RM<? echo $resit_info['jumlah_baki']; ?></b></td>
            </tr>

            </tbody>
           
            </table>
        </div>
    </body>
    <script>
    $(document).ready(function() {
         //window.onload = function() { window.print(); }
    });
    </script>
</html>