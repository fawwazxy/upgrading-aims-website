<?php

include ('../controller/auth.php');


require "../model/aims_invoice_functions.php";
require "../model/lookup.php";


$id = $_POST['id'];
$invoice_info = getInvoiceById($id)->fetch_assoc();
?>

<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Job No.</label>
		<input class="form-control" id="job_no" name="job_no" type="text" value=" <?echo $invoice_info['job_no'];?>" readonly/>
    </div>
	<div class="col-xs-4">
        <label class="control-label">Client Name</label>
		<input class="form-control" id="client_name" name="client_name" type="text" value=" <?echo $invoice_info['client_name'];?>" readonly/>
    </div>
	  <div class="col-xs-4">
        <label>Date Received Bill</label>
		<input class="form-control" id="date_received" name="date_received" type="text" value="<?echo $invoice_info['date_received'];?>" readonly/>
	</div>
</div>

<div class="form-group row" align="left">
	<div class="col-xs-4">
        <label>Invoice No</label>
		<input class="form-control" id="invoice_no" name="invoice_no" type="text" value="<?echo $invoice_info['invoice_no'];?>" readonly/>
    </div>
	<div class="col-xs-4">
        <label>Date Submit Invoice</label>
		<input class="form-control" id="date_submit" name="date_submit" type="text" value="<?echo $invoice_info['date_submit'];?>" readonly/>
    </div>
	    <div class="col-xs-4">
        <label>Submission By</label>
       <input class="form-control" id="submission" name="submission" type="text" value="<?echo $invoice_info['submission'];?>" readonly/>
    </div>
</div>

<div class="form-group row" align="left">
	<div class="col-xs-4">
        <label>Total Amount</label>
		<input class="form-control" id="total_invoice" name="total_invoice" type="text" value="<?echo 'RM'.number_format($invoice_info['total_invoice'],2,'.',',');?>" readonly/>
    </div>
	<div class="col-xs-4">
        <label>Total Paid</label>
		<input class="form-control" id="paid" name="paid" type="text" value="<?echo 'RM'.number_format($invoice_info['paid'],2,'.',',');?>" readonly/>
    </div>
	    <div class="col-xs-4">
        <label>Total Unpaid</label>
       <input class="form-control" id="unpaid" name="unpaid" type="text" value="<?echo 'RM'.number_format($invoice_info['unpaid'],2,'.',',');?>" readonly/>
    </div>
</div>

<div class="form-group row" align="left">
	  <div class="col-xs-4">
        <label>SES No Received</label>
       <input class="form-control" id="ses_no_received" name="ses_no_received" type="text" value="<?echo $invoice_info['ses_no_received'];?>" readonly/>
    </div>
	  <div class="col-xs-4">
        <label>Term of Payment (Days)</label>
       <input class="form-control" id="term_of_payment" name="term_of_payment" type="text" value="<? echo $invoice_info['term_of_payment'] ;?>" readonly/>
    </div>
	 <div class="col-xs-4">
        <label>Payment Status</label></br>
       <? '<b>' .$invoice_info['payment_status'];
					if($invoice_info['payment_status'] == 0){
						echo "<span style='background-color:Yellow; padding:5px; border-radius: 5px; font-weight: bold; color:black;'>PENDING</span>";
						}
					else {
						echo "<span style='background-color:Green; padding:5px; border-radius: 5px; font-weight: bold; color:black;'>RECEIVED</span>"; 
						} '</b>'?>
    </div>
</div>

	<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Date Received Payment</label>
		 <input class="form-control" id="date_received_payment" name="date_received_payment" type="text" value=" <?echo $invoice_info['date_received_payment'];?>" readonly/>
    </div>
	<div class="col-xs-4">
        <label>Due Date</label>
		<input class="form-control" id="duedate" name="duedate" type="text" value=" <?echo $invoice_info['duedate'];?>" readonly/>
    </div>
	
	   <div class="col-xs-4">
        <label>Status</label></br>
		<? '<b>' .$invoice_info['term_of_payment'];
					
					date_default_timezone_set("Asia/Kuala_Lumpur");
					//$date = strtotime($invoice_info['date_received_payment']);
					$period = $invoice_info['term_of_payment'];
					
					$myDateTime3 = DateTime::createFromFormat('Y-m-d', $invoice_info['date_submit']);
					$datesubmit = $myDateTime3->format('Y-m-d');
					
					$myDateTime = DateTime::createFromFormat('Y-m-d', $invoice_info['date_received_payment']);
					$date = $myDateTime->format('Y-m-d');
					
					$duedate1 = date("Y-m-d", strtotime($datesubmit.' + '.$invoice_info['term_of_payment'].' days'));
					
					$myDateTime2 = DateTime::createFromFormat('Y-m-d', $duedate1);
					$duedate = $myDateTime2->format('Y-m-d');
					
					//$duedate = date("Y-m-d", strtotime($date.' + '.$invoice_info['term_of_payment'].' days'));
					if($invoice_info['term_of_payment'] >= 2){
						if($invoice_info['date_received_payment'] == '0000-00-00'){
						echo "<span style='background-color:YELLOW; padding:8px; border-radius: 5px; font-weight: bold; color:black;'>PENDING</span>";
						}
						else if($date <= $duedate){
						echo "<span style='background-color:GREEN; padding:8px; border-radius: 7px; font-weight: bold; color:black;'>TIMELY</span>";
						}
						else if($date > $duedate){
						echo "<span style='background-color:RED; padding:8px; border-radius: 5px; font-weight: bold; color:black;'>OVERDUE</span>";
						}
					}

					else if($invoice_info['term_of_payment'] == 1){
						if($invoice_info['date_received_payment'] == '0000-00-00'){
						echo "<span style='background-color:YELLOW; padding:8px; border-radius: 5px; font-weight: bold; color:black;'>PENDING</span>";
						}
						else if($date <= $duedate){
						echo "<span style='background-color:GREEN; padding:8px; border-radius: 7px; font-weight: bold; color:black;'>TIMELY</span>";
						}
						else if($date > $duedate){
						echo "<span style='background-color:RED; padding:8px; border-radius: 5px; font-weight: bold; color:black;'>OVERDUE</span>";
						}
					}
					
					?>
    </div>
	
</div>

<div class="form-group row" align="left">
	<div class="col-xs-4">
        <label>Aging</label>
		<input class="form-control" id="aging" name="aging" type="text" value=" <?echo $invoice_info['aging'];?>" readonly/>
    </div>
	<div class="col-xs-4">
        <label>Created By</label>
		<input class="form-control" id="created_by" name="created_by" type="text" value=" <?echo $invoice_info['created_by'];?>" readonly/>
	</div>
	<div class="col-xs-4">
        <label>Created Date</label>
       <input class="form-control" id="created_date" name="created_date" type="text" value="<?echo $invoice_info['created_date'];?>" readonly/>
    </div>
</div>


<div class="form-group row" align="left">
<div class="col-xs-4">
        <label>Remarks</label>
		<input class="form-control" id="remarks" name="remarks" type="text" value=" <?echo $invoice_info['remarks'];?>" readonly/>
    </div>
	 <div class="col-xs-4">
        <label>Updated By</label>
       <input class="form-control" id="updated_by" name="updated_by" type="text" value="<?echo $invoice_info['updated_by'];?>" readonly/>
    </div>
	 <div class="col-xs-4">
        <label>Updated Date</label>
       <input class="form-control" id="updated_date" name="updated_date" type="text" value="<?echo $invoice_info['updated_date'];?>" readonly/>
    </div>
</div>

	

<script>
    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>
