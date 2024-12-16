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
	
	$flag=$_GET['flg'];
	

		if(!isset($year)){
			$year=date('Y');
			
		}
		if(!isset($flag)){
			$flag='tb_1';
			
		}

		if(!isset($company_id)){
			$company_id="1";
			
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

        h5 {
          font-size: 10px;
		  font-family: Times New Roman;
        }
		
		b {
          font-size: 20px;
		  font-family: arial;
		  color: #9BA41B;
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



#mybutton{
background-color:dodgerblue;
border:none;
padding:10px;
color:white;
} 

    </style>

    </head>
            <br>
            
<body id="refresh">

				
					<div class="form-group" align="right">
            </div>
	<div class="wrapper">

			<?echo'<img src="data:image/jpeg;base64,'.base64_encode( $sys['clogo'] ).'" width="80px" height="90"/>';?>
				
			&nbsp;&nbsp;<b> &nbsp;&nbsp;REPORT COLLECTION PAYMENT MONITORING </b>
			&nbsp;&nbsp;<hr style="width:90%;height:3px;color:#333;background-color:#333;margin-left:8%" />

			</div>

			<br><br>
             <div id='cssmenu'>
            	<ul>
            		<li class="<? echo ($flag=='tb_1'?'active':'') ?>"><a href="aims_analysis_report.php?company_id=1&flg=<? echo tb_1;?>&year=<?echo $year;?>">AGHSB</a>
            		</li>
            
            		<li class="<? echo ($flag=='tb_2'?'active':'') ?>"><a href="aims_analysis_report.php?company_id=2&flg=<? echo tb_2;?>&year=<?echo $year;?>">AGESB</a>
            		</li>
            		
            		<li class="<? echo ($flag=='tb_5'?'active':'') ?>"><a href="aims_analysis_report.php?company_id=3&flg=<? echo tb_5;?>&year=<?echo $year;?>">AGMSB</a>
            		</li>
            		
            		<li class="<? echo ($flag=='tb_4'?'active':'') ?>"><a href="aims_analysis_report.php?company_id=4&flg=<? echo tb_4;?>&year=<?echo $year;?>">AGMHESB</a>
            		</li>
            		
            		<li class="<? echo ($flag=='tb_3'?'active':'') ?>"><a href="aims_analysis_report.php?company_id=5&flg=<? echo tb_3;?>&year=<?echo $year;?>">AGIRSB</a>
            		</li>
            		
            		<li class="<? echo ($flag=='tb_6'?'active':'') ?>"><a href="aims_analysis_report.php?company_id=6&flg=<? echo tb_6;?>&year=<?echo $year;?>">AVSB</a>
            		</li>
            		
            		<li class="<? echo ($flag=='tb_7'?'active':'') ?>"><a href="aims_analysis_report.php?company_id=7&flg=<? echo tb_7;?>&year=<?echo $year;?>">MSET-AIMS</a>
            		</li>
					
					<li class="<? echo ($flag=='tb_8'?'active':'') ?>"><a href="aims_analysis_report.php?company_id=8&flg=<? echo tb_8;?>&year=<?echo $year;?>">TKSB</a>
            		</li>
            
            	</ul>
        </div> <br><br>
			 
		
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
						while($row = $report_invoice->fetch_assoc()) {
						?>
		 
						<tr class="odd gradeX">
							
							<td class='text-right'><center><?php echo $i++; ?></td></center>
							<td><center><?php echo $row['client_name']; ?></br></td></center>
							<td><center><?php echo $year;?></br></td></center>
							<td><center><?php echo 'RM '.number_format($row['total_invoice'],2); ?></td></center>
							<td><center><?php echo 'RM '.number_format($row['paid'],2); ?></td></center>
							<td><center><?php echo 'RM '.number_format($row['unpaid'],2); ?></td></center>
							<? $percentage = round(($row['unpaid']/$row['total_invoice'])*100) ?>
							<td><center><?php echo $percentage; ?>%</td></center>
                        </tr>
						
						<?
							$total_inv += (float)$row['total_invoice'];
							$total_paid += (float)$row['paid'];
							$total_unpaid += (float)$row['unpaid'];
							
						} ?>

                    <tbody>
					
                        <tr>
                            <th style="color:black" colspan='2' bgcolor="#E7E588" width="20%"><center>TOTAL </center></th>
                            <center><th style="color:black" bgcolor="#E7E588" width="20%"><center><?echo $year; ?></center></th>
                            <center><th style="color:black" bgcolor="#E7E588" width="8%"><center><?echo 'RM '.number_format($total_inv, 2)?></center></th>
                            <center><th style="color:black" bgcolor="#E7E588" width="15%"><center><?echo 'RM '.number_format($total_paid, 2)?></center></th>
                            <center><th style="color:black" bgcolor="#E7E588" width="15%"><center><?echo 'RM '.number_format($total_unpaid, 2)?></center></th>
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
	<? $c_id = $_GET['company_id'];
		if ($c_id == null){
			$c_id = 1;
		}
	?>

		 <a href="" onclick="return popitup('aims_analysis_report_print.php?company_id=<? echo $c_id?>&year=<?echo $year;?>')"><button type="button" class="btn btn-info">Print</button></a> 
		 <br><br>
		 <a href="aims_analysis_unpaid.php?year=<? echo $year?>" class="btn btn-warning">PENDING PAYMENT</a>
		 <br><br>
		 <a href="aims_analysis_performance.php?year=<? echo $year?>" class="btn btn-primary">AIMS PERFORMANCE</a>
		 <br><br>
		 <a href="aims_analysis.php" ><button type="submit" class="btn btn-info">Back</button></a> 
		 </div>

</div>

    </div>

    </body>

   
</html>
