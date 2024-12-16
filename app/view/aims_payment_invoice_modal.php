<?php

include ('../controller/auth.php');

require "../model/aims_invoice_functions.php";
require "../model/lookup.php";


date_default_timezone_set("Asia/Kuala_Lumpur");
$date_month = date(m);
$date_year = date(Y);
$date_day = date(d);
$current_date = $date_year."-".$date_month."-".$date_day;


//date_default_timezone_set("Asia/Kuala_Lumpur");
$current_year=date("Y");
$day_no=date("w");
$week_no=date("W");
date("d M Y");
date("W",strtotime(date("n")));
$id = $_POST['id'];
$payment_status = $_GET['payment_status'];

$date_received_payment = $_GET['date_received_payment'];
$invoice_info = getInvoiceById($id)->fetch_assoc();

?>

	<form method="post" action="../controller/aims_invoice_update_payment_exec.php">
		<input type="hidden" class="form-control" id="id" name="id" value="<? echo $invoice_info['id'] ?>" />
	
		<div class="form-group row" align="left">
					<div class="col-xs-8">
						<label class="control-label">Date Received Payment (UPDATE IF RECEIVED PAYMENT)<font color="red">&nbsp;</font></label>
						<input class="form-control" id="date_received_payment" name="date_received_payment" type="date" value="<? echo $invoice_info['date_received_payment'] ?>" style="text-transform:uppercase"/>
					</div>
				</div>
				<? 
				
				if($current_date > $invoice_info['duedate']){
				$status = 'OVERDUE';
				}
				else{
					$status = 'TIMELY';
				}
				?>
				<div class="form-group row" align="left">
					<div class="col-xs-8">
					<p><label class="control-label">Status<font color="red">&nbsp;*</font></label></p>
					<input class="form-control" id="status" name="status" type="text" value="<? echo $status; ?>" style="text-transform:uppercase" readonly/>
					</div>
				</div>
				
				<div class="form-group row" align="left">
					<div class="col-xs-8">
					<p><label class="control-label">Payment Status<font color="red">&nbsp;*</font></label></p>
					<input type="radio" <?php if($invoice_info['payment_status']==0) {echo "checked";}?> name="payment_status" id="payment_status" value="0"> PENDING&nbsp;&nbsp;
					<input type="radio" <?php if($invoice_info['payment_status']==1) {echo "checked";}?> name="payment_status" id="payment_status" value="1"> RECEIVED</p>
					</div>
				</div>
			

				<div align="center">
					<button type="submit" class="btn btn-success">Save</button>
					<button type="reset" class="btn btn-warning">Reset</button>
				</div>
	</form>		

 
						
			