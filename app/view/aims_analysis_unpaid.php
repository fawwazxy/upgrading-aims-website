<?php

    // include ('../controller/auth.php');

    require "../model/aims_analysis_function.php";
	
	//date_default_timezone_set("Asia/Kuala_Lumpur");
	$current_year=date("Y");
	$id = $_GET['id'];
	$client_id = $_GET['client_id'];
	$year=$_GET['year'];

		
	if(!isset($year)){
			$year=date('Y');
			
		}
	if(!isset($client_id)){
			$client_id="1";
			
		}
	
	$report_invoice= getInvoiceUnpaid($client_id,$year);
	
	date_default_timezone_set("Asia/Kuala_Lumpur");
	$date_year = date(Y);
	$current_date = $date_year;

?>

<!DOCTYPE html>
<html>
    
    <title>iOffice::Sistem Pengurusan Pejabat Bersepadu</title>
    <head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <? require "../global/header.php"; ?>
    <script src="../../js/jquery/jquery.min.js"></script>
    <script src="../../js/html2canvas/html2canvas.js"></script>
	
        <style type="text/css">
        i{
            font-family: "Arial";
			
        }
        
        body {      
            font-family: "Arial";
            font size: 100px;
			margin-left: 3%;
			margin-right: 3%;
        }

        table, td, th {
          border: 1px solid black;
        }

        table {
          border-collapse: collapse;
          width: 100%;
        }

        thead {
          height: 60px;
        }

        tbody {
          height: 40px;
        }
        
        img {
          float: left;
        }

        h1 {
          font-size: 20px;
        }

        h2 {
          font-size: 20px;
        }
		
		 b {
          font-size: 20px;
		  font-family: arial;
		  color: #9BA41B;
        }
		
		 div.clear-fix {
            clear:both;
            float:none;
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
	.button{color:blue;}
		

    </style>

    </head>
 
    <body>
			
		<div class="form-group" align="right">
        </div>
		<div class="clear-fix">
		<fieldset class="first" >
    

			<?echo'<img src="data:image/jpeg;base64,'.base64_encode( $sys['clogo'] ).'" width="80px" height="90"/>';?>
			
			&nbsp;&nbsp;<b> &nbsp;&nbsp;REPORT COLLECTION PAYMENT MONITORING </b>
			&nbsp;&nbsp;<hr style="width:90%;height:3px;color:#333;background-color:#333;margin-left:8%" />
		</div>
                <h3 style="color:blue">PENDING PAYMENT</h3>
                 
                <br>

            <div class="row">
                <font size="2" face="Arial" >
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="color:black" bgcolor="#FFD580" width="7%"><center>NO</center></th>
                            <th style="color:black" bgcolor="#FFD580" width="20%"><center>CLIENT</center></th>
                            <th style="color:black" bgcolor="#FFD580" width="8%"><center>MONTH</center></th>
                            <th style="color:black" bgcolor="#FFD580" width="20%"><center>UNPAID</center></th>
                        </tr>
                    </thead>
						<?

						$i=1;
						$total_unpaid=0;
						while($row = $report_invoice->fetch_assoc()) {
	
						?>
                    <tbody>
                        <tr class="odd gradeX">
							
							<td class='text-right'><center><?php echo $i++; ?></center></td>
							<td><center><?php echo $row['client_name']; ?></br></td>
							<td><center><?php echo date('F', strtotime($row['date_submit'])) ?></br></td>
							<td><center><?php echo 'RM '.number_format($row['unpaid'],2); ?></td>
                        </tr>
						
					<?
							$total_unpaid += (float)$row['unpaid'];
							
						} ?>

                    <tbody>
                        <tr>
                            <th style="color:black" bgcolor="#FFD580" width="7%"><center></center></th>
                            <th style="color:black" bgcolor="#FFD580" width="50%"><center> TOTAL </center></th>
                            <th style="color:black" bgcolor="#FFD580" width="20%"><center><?echo $year; ?></center></th>
                            <th style="color:black" bgcolor="#FFD580" width="23%"><center><?echo 'RM '.number_format($total_unpaid, 2)?></center></th>
                        </tr>
                    </tbody>   
                    </font>
    </table>
	</fieldset>
    <br><br>

        <div style="text-align:center;">
	<div>
    <div class="page">
        <div class="page-inner">
			<input  class="button" id="btn-Preview-Image" type="button" onclick="window.print()" value="Print"/>
				</div>  
			<br><input class="button" id="btn-Preview-Image" type="button" onclick="history.back()" value="Back"/>
		</div>
	</div>

    </div>

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



});
</script>
    </body>

   
</html>
