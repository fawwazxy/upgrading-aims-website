<?php

include ('../controller/auth.php');

require "../model/aims_billing_function.php";
require "../model/lookup.php";

    date_default_timezone_set("Asia/Kuala_Lumpur");
    $date_month = date(m);
    $date_year = date(Y);
    $date_day = date(d);
    $time_hour = date(H);
    $time_min = date(i);
    $time_sec = date(s);


?>




<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <? require "../global/header.php"; ?>

</head>

<style>
#dataTables-example {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  
  width: 100%;
}

#dataTables-example td, #dataTables-example th {
  border: 1px solid #ddd;
  padding: 3px;
}

#dataTables-example tr:nth-child(even){background-color: #f2f2f2;}

#dataTables-example tr:hover {background-color: #ddd;}

#dataTables-example th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: orange;
  color: white;
}
</style>


<body>

    

        <!-- Navigation -->
        

            <div class="form-group" align="right">
            </div>
            
             <div class="form-group" align="right">
				<button type="button" class="btn btn-primary" onclick="window.print()">Print</button>
            </div>
			
			
             
             <div class="row">
                <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading" align="center">
                        <label class="control-label" for="date">COMMERCIAL DEPARTMENT</label>
                    </div>
					
					
                    <!-- /.panel-heading -->
                    
			<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
			<thead>
			<tr style="background-color:black;">
				<th>NO.</th>
				<th>NTI NO</th>
				<th>JOB NO</th>
				<th>DATE PREPARED</th>
				<th>COMPANY</th>
				<th>DESCRIPTION</th>
				<th>CLIENT</th>
				<th>AMOUNT INVOICE</th>
				<th>6% SST</th>
			</tr>
		</thead>
		
			<?
                                    $billing = getBillingListPrint();
								//	$client = getInvoiceListClientPrint();
									
                                    $i=1;
                                 
								 while($list_billing = $billing->fetch_assoc()){
                                ?>
			<tr>
				<td><?php echo $i++; ?></td>
				<td><?php echo $list_billing['tin_no']; ?></td>
				<td><?php echo $list_billing['job_no']; ?></td>
				<td><?php $d = new DateTime($list_billing['created_date']);
						echo $d->format('Y-m-d'); ?></td>
				<td><?php echo $list_billing['company_name']; ?></td>
				<td><?php echo $list_billing['job_description']; ?></td>
				<td><?php echo $list_billing['client_name']; ?></td>
				<td><?php echo $list_billing['amount_to_invoice']; ?></td>
				<td><?php echo $list_billing['sst']; ?></td>
			</tr>
									<? } ?>

							</table>
							</div>
                </div>
                <!-- /.col-lg-12 -->
            </div>

        <!-- /#page-wrapper -->

    
   

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });

        
    
    </script>

</body>

</html>




