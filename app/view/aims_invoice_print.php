<?php

include ('../controller/auth.php');

require "../model/aims_invoice_functions.php";
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
  border: !important;
  width: 100%;
}

#dataTables-example td, #dataTables-example th {
  border: 1px solid #ddd !important;
  padding: 0px;
}

#dataTables-example tr:nth-child(even){background-color: #f2f2f2;}

#dataTables-example tr:hover {background-color: #ddd;}

#dataTables-example th {
  padding-top: 0px;
  padding-bottom: 0px;
  text-align: left;
  background-color: orange;
  color: white;
  border: !important;
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
                        <label class="control-label" for="date">INVOICE SUMMARY</label>
                    </div>
					
					
                    <!-- /.panel-heading -->
                    
			<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
			<thead>
			<tr>
				<th>NO.</th>
				<th>CREATED ON</th>
				<th>JOB NO ISSUED</th>
				<th>CLIENT</th>
				<th>JOB DESCRIPTION</th>
				<th>TIN NO</th>
				<th>INVOICE NO</th>
				<th>DATE SENT INVOICE</th>
				<th>AMOUNT</th>
				<th>DATE RECEIVED PAYMENT</th>
				<th>STATUS</th>
				<th>PAYMENT DUE ON</th>
			</tr>
		</thead>
		
			<?
                                    $invoice = getInvoiceListPrint();
								//	$client = getInvoiceListClientPrint();
									
                                    $i=1;
                                 //   while(($list_invoice = $invoice->fetch_assoc()) && ($list_invoice2 = $client->fetch_assoc())) { 
								 while($list_invoice = $invoice->fetch_assoc()){
                                ?>
			<tr>
				<td><?php echo $i++; ?></td>
				<td><?php $d = new DateTime($list_invoice['created_date']);
						echo $d->format('Y-m-d'); ?></td>
				<td><?php echo $list_invoice['job_no']; ?></td>
				<td><?php echo $list_invoice['client_name']; ?></td>
				<td><?php echo $list_invoice['job_description']; ?></td>
				<td><?php echo $list_invoice['tin_no']; ?></td>
				<td><?php echo $list_invoice['invoice_no']; ?></td>
				<td><?php echo $list_invoice['date_submit']; ?></td>
				<td><?php echo $list_invoice['total_amount']; ?></td>
				<td><?php $list_invoice['date_received_payment'];
							if ($list_invoice['date_received_payment'] == '0000-00-00'){
								echo 'PENDING';} 
							else{
								echo $list_invoice['date_received_payment'];}?></td>
				<td><?php $list_invoice['status'];
							if ($list_invoice['status'] == '0'){
								echo 'PENDING';} 
							else if ($list_invoice['status'] == '1'){
								echo 'TIMELY';}
							else if ($list_invoice['status'] == '2'){
								echo 'OVERDUE';}?></td>
				<td><?php echo $list_invoice['duedate']; ?></td>
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