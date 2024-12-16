<?php

    // include ('../controller/auth.php');
    require "../model/aims_analysis_function.php";
	
	date_default_timezone_set("Asia/Kuala_Lumpur");
	$date_year = date(Y);
	$current_date = $date_year;

	//date_default_timezone_set("Asia/Kuala_Lumpur");
	$current_year=date("Y");
	$code_department = $_SESSION['SESS_DEPARTMENT'];
	$id = $_GET['id'];
	$company_id = $_GET['company_id'];
	$year=$_GET['year'];


		if(!isset($company_id)){
			$company_id="1";
			
		}
		
		if(!isset($year)){
			$year=date('Y');
			
		}
	$report_invoice=getInvoiceReport($company_id,$year);
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
	

<link rel="shortcut icon" type="image/x-icon" href="../../resources/images/<? echo $sys['logo_filename']; ?>" />


        <style type="text/css">
        i{
       
			font-family: "Arial";
        }
        
        body {      
            font-family: Arial;
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
		  padding-top: -20%;
        }

        thead {
          height: 60px;
        }

        tbody {
          height: 40px;
        }
        
        img {
          float: left;
		  padding-top: -24%;
        }

        h1 {
          font-size: 20px;
		  font-family: Times New Roman;
        }

        b {
          font-size: 20px;
		  font-family: arial;
		  color: #9BA41B;
        }
		
		 h2 {
          font-size: 20px;
		  font-family:Times New Roman;
		  color: blue;
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

.button{color:blue;} 

    </style>

    </head>
            <br>
            
<body id="refresh">

	<div class="wrapper">
			<?echo'<img src="data:image/jpeg;base64,'.base64_encode( $sys['clogo'] ).'" width="80px" height="90"/>';?>
				
			&nbsp;&nbsp;<b> &nbsp;&nbsp;REPORT COLLECTION PAYMENT MONITORING </b>
			&nbsp;&nbsp;<hr style="width:90%;height:3px;color:#333;background-color:#333;margin-left:8%" />

		</div>
		<br>
			<?    $company = getCompany($company_id) -> fetch_assoc();?>
			<div class="row">
	
			<div class="col-lg-12">
				
				<h2><strong><? echo $company['company_name'];?></strong></h2><br>
			</div>	
     		
		</div>
            <div class="row">
                <font size="2" face="Arial" >
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="color:black" bgcolor="MediumSeaGreen" width="7%"><center>NO</center></th>
                            <th style="color:black" bgcolor="MediumSeaGreen" width="20%"><center>CLIENT</center></th>
                            <th style="color:black" bgcolor="MediumSeaGreen" width="8%"><center>YEAR</center></th>
                            <th style="color:black" bgcolor="MediumSeaGreen" width="20%"><center>OVERALL INVOICE</center></th>
                            <th style="color:black" bgcolor="MediumSeaGreen" width="15%"><center>PAID</center></th>
                            <th style="color:black" bgcolor="MediumSeaGreen" width="15%"><center>UNPAID</center></th>
                            <th style="color:black" bgcolor="MediumSeaGreen" width="20%"><center>PERCENTAGE</center></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?

						$i=1;
						$total_inv=0;
						$total_paid=0;
						$total_unpaid=0;
						$report_invoice = getInvoiceReport($company_id,$year);
						while($row = $report_invoice->fetch_assoc()) { 
						 
						?>
		 
						<tr class="odd gradeX">
							
							<td class='text-right'><center><?php echo $i++; ?></td></center>
							<td><center><?php echo $row['client_name']; ?></br></td></center>
							<td><center><?php echo $year;?></br></td></center>
							<td><center><?php echo 'RM '.number_format($row['total_invoice'], 2); ?></td></center>
							<td><center><?php echo 'RM '.number_format($row['paid'], 2); ?></center></td>
							<td><center><?php echo 'RM '.number_format($row['unpaid'], 2); ?></center></td>
							<? $percentage = round(($row['unpaid']/$row['total_invoice'])*100) ?>
							<td><center><?php echo $percentage; ?>%</center></td>
                        </tr>
						
						<?
							$total_inv += (float)$row['total_invoice'];
							$total_paid += (float)$row['paid'];
							$total_unpaid += (float)$row['unpaid'];
							
						}?>

                    <tbody>
					
                        <tr>
                            <th style="color:black" colspan='2' bgcolor="#E7E588" width="20%"><center>TOTAL </center></th>
                            <th style="color:black" bgcolor="#E7E588" width="20%"><center><?echo $year; ?></center></th>
                            <th style="color:black" bgcolor="#E7E588" width="8%"><center><?echo 'RM '.number_format($total_inv, 2)?></center></th>
                            <th style="color:black" bgcolor="#E7E588" width="15%"><center><?echo 'RM '.number_format($total_paid, 2)?></center></th>
                            <th style="color:black" bgcolor="#E7E588" width="15%"><center><?echo 'RM '.number_format($total_unpaid, 2)?></center></th>
                            <th style="color:black" bgcolor="#E7E588" width="20%"><center>
							<? 
							if($total_inv>0)
							{ $total_per = round(($total_unpaid/$total_inv)*100); }
							else
							{$total_per ="0";}
							?>
							<?echo $total_per?>%</th></center>
                        </tr>
                    </tbody>   
                    </font>
    </table>
    <br><br>
	
    <div style="text-align:center;">
	<div>
    <div class="page">
    <div class="page-inner">
 <input  class="button" id="btn-Preview-Image" type="button" onclick="window.print()" value="Print"/><br>
 <br><input  class="button" id="btn-Preview-Image" type="button" onclick="window.location.href = 'aims_analysis_report.php';" value="Back"/>
	</div>   
    </div>
	</div>

    </div>

	
</body>

   
</html>
