<?php

include ('../controller/auth.php');

require "../model/aims_billing_function.php";
require "../model/lookup.php";

date_default_timezone_set("Asia/Kuala_Lumpur");
$current_date = $date_year;
$date_year = date(Y);


//date_default_timezone_set("Asia/Kuala_Lumpur");

$client_name=$_GET['client_name'];
$year=$_GET['year'];
$month=$_GET['month'];


		if(!isset($year)){
			$year=date('Y');
			
		}
		
		if (!isset($client_name) && $client_name == '') {
		$client_name = '0';
		}

if(!isset($month)){
			$month=date('m');
			
	}

	$track_sales= getSales($client_name,$year,$month)->fetch_assoc();
?>



<!DOCTYPE html>
<html lang="en">
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
			margin-left: 50px;
			margin-right: 5px;
        }

        table, td, th {
          border: 1px solid black;
        }

        table {
          border-collapse: collapse;
          width: 100%;
        }

        thead {
          height: 40px;
        }

        tbody {
          height: 30px;
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

		

    </style>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <? require "../global/header.php"; ?>

</head>
<body>
		<br><br>	
		<div class="form-group" align="right">
		</div>
		<div style="margin-right:40px; margin-left:50px">
		<div class="clear-fix">
		<fieldset class="first" >
 
			<?echo'<img src="data:image/jpeg;base64,'.base64_encode( $sys['clogo'] ).'" width="80px" height="90"/>';?>

			&nbsp;&nbsp;<b> &nbsp;&nbsp;SALES TRACKING </b>
			&nbsp;&nbsp;<hr style="width:90%;height:3px;color:#333;background-color:#333;margin-left:8%" />
		</div>
	<br>
	<br>
	
		<div class="col-lg-2">
	
				<!--BUAT TABLE MONTH-->
							
								<select  required class="form-control" name="year" id="year">
									<option value="0">-- Choose Year--</option>
									<? echo getDropDownYear($year);?>
								</select>
					
			</div>
					
				<div class="col-lg-3">
							<select  required class="form-control" name="client_name" id="client_name">
									<option value="0">-- Choose Client--</option>
									<? echo getDropDownClient($client_name);?>
							</select>
				</div>
				
			<div class="col-lg-2">
	
				<!--BUAT TABLE MONTH-->
							<select  required class="form-control" name="month" id="month" value="<?echo $month?>">
									<option value="0">-- Choose Month--</option>
									<? echo getDropDownMonthInvoice($month);?>
							</select>
			</div>
				
                 <br> <br> <br>
               

            <div class="row">
                <font size="2" face="Arial" >
                <table class="">
                    <thead>
                        <tr>
                            <th style="color:black" bgcolor="#FFD580" width="5%"><center>NO</center></th>
                            <th style="color:black" bgcolor="#FFD580" width="20%"><center>CLIENT</center></th>
							<th style="color:black" bgcolor="#FFD580" width="20%"><center>JOB NO</center></th>
                            <th style="color:black" bgcolor="#FFD580" width="10%"><center>MONTH</center></th>
                            <th style="color:black" bgcolor="#FFD580" width="20%"><center>SALES (RM)</center></th>
                        </tr>
                    </thead>
						<?
						$track_sales = getSales($client_name,$year,$month);
						$i=1;
						$total_sales=0;
						while($sales = $track_sales->fetch_assoc()) {
	
						?>
                    <tbody>
                        <tr class="odd gradeX">
							
							<td class='text-right'><center><?php echo $i++; ?></center></td>
							<td><center><?php echo $sales['client_name']; ?></br></td>
							<td><center><?php echo $sales['job_no']; ?></br></td>
							<td><center><?php echo date('F', strtotime($sales['date_prepared'])) ?></br></td>
							<td><center>RM <?php echo number_format($sales['total_invoice'],2); ?></td>
                        </tr>
						
					<?
							$total_sales += (float)$sales['total_invoice'];
							
						} ?>

                    <tbody>
                        <tr>
                            <th style="color:black" bgcolor="#FFD580" width="7%"><center></center></th>
                            <th style="color:black" bgcolor="#FFD580" width="50%"><center> TOTAL(RM)</center></th>
							<th style="color:black" bgcolor="#FFD580" width="20%"><center></center></th>
                            <th style="color:black" bgcolor="#FFD580" width="10%"><center><?echo $year; ?></center></th>
                            <th style="color:black" bgcolor="#FFD580" width="23%"><center>RM <?echo number_format($total_sales, 2)?></center></th>
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
			<input id="btn-Preview-Image" type="button" onclick="window.print()" value="Print"/>
		</div>   
		<br><input  id="btn-Preview-Image" type="button" onclick="window.location.href = 'aims_billing_list.php';" value="Back"/>
	</div>
	</div>

    </div>
</div>
    <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
       

    });
 	
	
	$("#year,#client_name,#month").change(function(){
			var selected_year=$("#year").val();
    		var selected_client=$('#client_name').val();
			var selected_month=$('#month').val();
    		 sendType(selected_year,selected_client,selected_month);
    	 });
		 
	        function sendType(selected_year,selected_client,selected_month){
	            //console.log(obj);
	            window.location.href = "aims_billing_track_sales.php?year="+selected_year+"&client_name="+selected_client+"&month="+selected_month;
	        }
    </script>
</body>

</html>