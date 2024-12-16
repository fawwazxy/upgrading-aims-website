<?php

    include ('../controller/auth.php');

    require "../model/keluar_masuk_functions.php";

	$month = $_GET['month'];
	date_default_timezone_set("Asia/Kuala_Lumpur");
	$current_year=date("Y");
	$current_month=date("m");
	$day_no=date("w");
	$week_no=date("W");
	date("d M Y");
	date("W",strtotime(date("n")));
	$month_selected = $current_month;
	if(!empty($_GET['month'])) {
	    $month_selected=$month;
	}
	$month_selected;
 ?>

<!DOCTYPE html>
<html>
    
    <title>iWarden::Sistem Pengurusan Warden Asrama Berkomputer</title>
    <head>
    <script src="../../js/jquery/jquery.min.js"></script>
    <script src="../../js/html2canvas/html2canvas.js"></script>

        <style type="text/css">
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

    </style>

    </head>
 
    <body>
    
            <button id="printPageButton" onClick="window.print();">CETAK</button>
            <center>

            <div class="pagebreak">
            <div class="invoice">
            <div class="clear-fix"></div>
            <font size="5"><b>REKOD BULANAN KELUAR MASUK</b></font><br>
            <font size="4"><b>BULAN&nbsp;:
                <?if($month_selected == '01') {echo 'JANUARI'.'&nbsp;'.$current_year;}
                else if($month_selected == '02') {echo 'FEBRUARI'.'&nbsp;'.$current_year;}
                else if($month_selected == '03') {echo 'MAC'.'&nbsp;'.$current_year;}
                else if($month_selected == '04') {echo 'APRIL'.'&nbsp;'.$current_year;}
                else if($month_selected == '05') {echo 'MEI'.'&nbsp;'.$current_year;}
                else if($month_selected == '06') {echo 'JUN'.'&nbsp;'.$current_year;}
                else if($month_selected == '07') {echo 'JULAI'.'&nbsp;'.$current_year;}
                else if($month_selected == '08') {echo 'OGOS'.'&nbsp;'.$current_year;}
                else if($month_selected == '09') {echo 'SEPTEMBER'.'&nbsp;'.$current_year;}
                else if($month_selected == '10') {echo 'OKTOBER'.'&nbsp;'.$current_year;}
                else if($month_selected == '11') {echo 'NOVEMBER'.'&nbsp;'.$current_year;}
                else {echo 'DISEMBER'.'&nbsp;'.$current_year;}
                ?>
                
            </b></font>
            <table border='1' cellspacing='0'>            
            <tbody>
            <br>
            <br>
            <!-- <tr>
            <td colspan='7' height='50px' class='text-center'><b>REKOD BULANAN KELUAR MASUK</b></td>
            </tr> --> 
                <th height='40px'><div class="form-group" align="center">&nbsp;&nbsp;No.</th>
                <th height='40px'><div class="form-group">&nbsp;&nbsp;Maklumat Pelajar</th>
                <th height='40px'><div class="form-group">&nbsp;&nbsp;Masa Keluar</th>
               	<th height='40px'><div class="form-group">&nbsp;&nbsp;Masa Masuk</th>
                <th height='40px'><div class="form-group">&nbsp;&nbsp;Catatan Semasa</th>
            
				<?
					$i= 1;
					$data = getKeluarListByMonth($month_selected,$current_year);
					while($row_data = $data->fetch_assoc()) {
					$fcolor = 'red';
					if($row_data['catatan_semasa'] == 'masuk'){
						$fcolor = 'green';
					}
				?>
					<tr class="odd gradeX">
						<td>&nbsp;&nbsp;<? echo $i; ?></td>
						<td>&nbsp;&nbsp;<? echo $row_data['nama']; ?>
						<br>&nbsp;&nbsp;<? echo $row_data['no_matrik']; ?>
						<br>&nbsp;&nbsp;<? echo $row_data['nokp']; ?></td>
				        <td>&nbsp;&nbsp;<? echo $row_data['masa_keluar']; ?></td>
						<td>&nbsp;&nbsp;<? if ($row_data['masa_masuk']< $row_data['masa_keluar'])
									{
									echo '';}
									else {
										echo $row_data['masa_masuk'];
									}
							?></td>
				        <td>&nbsp;&nbsp;<font color="<?echo $fcolor?>"><? echo $row_data['catatan_semasa']; ?></font></td>
					</tr>
						<? $i++; } ?>
            </tbody>
            </table>
            </div>
    </body>

    <script>
    $(document).ready(function() {
         //window.onload = function() { window.print(); }
    });
    function getRekodKeluarMasukByMonth(obj){
        location.href = "senarai_kehadiran_bulanan_cetak.php?month="+obj.value;
    }
    </script>
</html>
