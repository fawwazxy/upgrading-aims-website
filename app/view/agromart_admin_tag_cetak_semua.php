<?php

    include ('../controller/auth.php');

    require "../model/agromart_functions.php"; 

    $id_agencies = $_GET['id_agencies'];
    $nokp_seller = $_GET['nokp_seller'];
    $sys = getSys(1)->fetch_assoc();

?>

<!DOCTYPE html>
<html>
 
    <head>
        <title><? echo $sys['sys_name']; ?>::<? echo $sys['sys_tagline']; ?></title>
        <? //require "../global/header.php"; ?>
        <style type="text/css">
        body {      
            font-family: Verdana;
        }
         
        div.invoice {
        border:0px solid #ccc;
        padding:10px;
        height:740pt;
        width:570pt;
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
        }
         
        td {
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
         
         @media print {
        #printPageButton {
        display: none;
             }
            }
        
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            text-align: left;    
        }
        table { page-break-inside:auto }
        tr { page-break-inside:avoid; page-break-after:auto }
        </style>
    </head>
 
    <body>
        
        <button id="printPageButton" onClick="window.print();">Cetak</button>
       
    <center>
    <div class="invoice">
                        
        
            <table border=1>
 

                <?
                    $tag = getTagHargaListByPembekal($id_agencies,$nokp_seller);
                    while ($list_tag = $tag->fetch_assoc()) {
                        $m=0;
                        $i=1;
                        while($m < $list_tag['kuantiti']) {
                        if(($i%5) == 1){
                            echo "</tr> <tr>";
                        }
                ?>  
                <td>
                <font style="padding: 10px;" size="1px"><?echo $list_tag['nama_item'];?> RM<?echo $list_tag['harga_runcit'];?></font>
                <br><img border=0 alt="<?echo $data['barcode']?>" src="../../util/barcode.php?codetype=Code25&size=20&text=<?echo $list_tag['barcode'];?>&print=true" />
                </td>
                
                <?php $i++;
                $m++; }} ?>
                
            </table>
           
            
        </div>
    </body>
</center>
 
</html>

