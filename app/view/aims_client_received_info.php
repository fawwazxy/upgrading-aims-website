<?php

include ('../controller/auth.php');

require "../model/aims_invoice_functions.php";
require "../model/lookup.php";

date_default_timezone_set("Asia/Kuala_Lumpur");
$date_month = date(m);
$date_year = date(Y);
$date_day = date(d);
$current_date = $date_year."-".$date_month."-".$date_day;
$year=$_GET['year'];

		
		if(!isset($year)){
			$year=date('Y');
			
		}

$received_client= getReceivedClient($id,$year)->fetch_assoc();

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
										<th>Amount</th>
										<th>Due Date</th>
									</tr>
								</thead>
								<tbody>
							
								<?
                                    $client_info = getReceivedClient($id,$year);
                                    $i=1;
                                    while($received_client = $client_info->fetch_assoc()) {
                                ?>
									<tr class="odd gradeX">
										<td><?php echo $i++; ?></td>
										<td><?php echo $received_client['client_name']; ?></td>
										<td><?php echo $received_client['client_phone_no']; ?></td>
										<td><?php echo $received_client['invoice_no']; ?></td>
								        <td><font color="green"><?php echo 'RM'.number_format($received_client['total_invoice'],2,'.',','); ?></font></td>
										<td><?php echo $received_client['duedate']; ?></td>
								
									</tr>
								<? } ?>
								
							
								</tbody>

							</table>