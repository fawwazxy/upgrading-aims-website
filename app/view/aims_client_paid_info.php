<?php

include ('../controller/auth.php');

require "../model/aims_analysis_function.php";
require "../model/lookup.php";

date_default_timezone_set("Asia/Kuala_Lumpur");
$date_month = date(m);
$date_year = date(Y);
$date_day = date(d);
$current_date = $date_year."-".$date_month."-".$date_day;
$paid_client= getPaidClient($id,$year)->fetch_assoc();
$year=$_GET['year'];

		
		if(!isset($year)){
			$year=date('Y');
			
		}
?>

<div class="row">
                <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Client Info</label>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
<table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
								<thead>
									<tr>
										<th>No.</th>
										<th>Client</th>
										<th>Contact Number</th>
										<th>Invoice No</th>
										<th>Total Paid (RM)</th>
										<th>Total Invoice (RM)</th>
										<th>Due Date</th>
									</tr>
								</thead>
								<tbody>
							
								<?
                                    $client_info = getPaidClient($id,$year);
                                    $i=1;
                                    while($paid_client = $client_info->fetch_assoc()) {
                                ?>
									<tr class="odd gradeX">
										<td><?php echo $i++; ?></td>
										<td><?php echo $paid_client['client_name']; ?></td>
										<td><?php echo $paid_client['client_phone_no']; ?></td>
										<td><?php echo $paid_client['invoice_no']; ?></td>
								        <td><font color="green"><?php echo number_format($paid_client['paid'],2,'.',','); ?></font></td>
										<td><?php echo number_format($paid_client['total_invoice'],2,'.',','); ?></td>
										<td><?php echo $paid_client['duedate']; ?></td>
								
									</tr>
								<? } ?>
								
							
								</tbody>

							</table>