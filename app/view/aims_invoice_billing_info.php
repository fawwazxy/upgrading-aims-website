<?php

include ('../controller/auth.php');


require "../model/aims_billing_function.php";
require "../model/lookup.php";


$id = $_POST['id'];
$billing_info = getBillingById($id)->fetch_assoc();
?>

<div class="form-group row" align="left">
    <div class="col-xs-6">
        <label>Client</label>
       <input class="form-control" id="client_name" name="client_name" type="text" value=" <?echo $billing_info['client_name'];?>" readonly/>
    </div>
    <div class="col-xs-6">
        <label>Company</label>
        <input class="form-control" id="company_name" name="company_name" type="text" value=" <?echo $billing_info['company_name'];?>" readonly/>
    </div>
</div>

<div class="form-group row" align="left">
    <div class="col-xs-6">
        <label>Job No</label>
       <input class="form-control" id="job_no" name="job_no" type="text" value=" <?echo $billing_info['job_no'];?>" readonly/>
    </div>
    <div class="col-xs-6">
        <label>Job Description</label>
       <input class="form-control" id="job_description" name="job_description" type="text" value=" <?echo $billing_info['job_description'];?>" readonly/>
    </div>
</div>

<div class="form-group row" align="left">
	<div class="col-xs-4">
        <label>Date Prepared</label>
       <input class="form-control" id="date_prepared" name="date_prepared" type="text" value=" <?echo $billing_info['date_prepared'];?>" readonly/>
    </div>
	<div class="col-xs-4">
        <label>Term Of Payment (Days)</label>
       <input class="form-control" id="term_of_payment" name="term_of_payment" type="text" value=" <?echo $billing_info['term_of_payment'];?>" readonly/>
    </div>
    <div class="col-xs-4">
        <label>TIN No</label>
       <input class="form-control" id="tin_no" name="tin_no" type="text" value="<?echo $billing_info['tin_no'];?>" readonly/>
    </div>
</div>

<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Amount to Invoice </label>
       <input class="form-control" id="amount_to_invoice" name="amount_to_invoice" type="text" value="<?echo 'RM '.number_format($billing_info['amount_to_invoice'],2);?>" readonly/>
    </div>
    <div class="col-xs-4">
        <label>SST</label>
       <input class="form-control" id="sst" name="sst" type="text" value="<?echo $billing_info['sst'];?> " readonly/>
    </div>
	<div class="col-xs-4">
        <label>Amount Credit Note</label>
       <input class="form-control" id="amount_credit_note" name="amount_credit_note" type="text" value="<?echo 'RM '.number_format($billing_info['amount_credit_note'],2);?> " readonly/>
    </div>
</div>

<div class="form-group row" align="left">
	<div class="col-xs-4">
        <label>Amount Debit Note</label>
       <input class="form-control" id="amount_debit_note" name="amount_debit_note" type="text" value="<?echo 'RM '.number_format($billing_info['amount_debit_note'],2);?> " readonly/>
    </div>
    <div class="col-xs-4">
        <label>Total Amount </label>
       <input class="form-control" id="total_invoice" name="total_invoice" type="text" value="<?echo 'RM '.number_format($billing_info['total_invoice'],2);?> " readonly/>
    </div>
    <div class="col-xs-4">
        <label>Status</label><br/>
       <? '<b>' .$billing_info['status_billing'];
					if($billing_info['status_billing'] == 4){
						echo "<span style='background-color:Green; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>NEW</span>";
						}
					else if($billing_info['status_billing'] == 1){
						echo "<span style='background-color:Orange; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>PROCESSED</span>"; 
						}
					else if($billing_info['status_billing'] == 3){
						echo "<span style='background-color:#FD7808; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>CLOSED</span>"; 
						}
						'</b>'?>
    </div>
</div>

<div class="form-group row" align="left">
    <div class="col-xs-6">
        <label>Created By</label>
        <input class="form-control" id="created_by" name="created_by" type="text" value="<?echo $billing_info['created_by'];?>" readonly/>
    </div>
    <div class="col-xs-6">
        <label>Created Date</label>
       <input class="form-control" id="created_date" name="created_date" type="text" value="<?echo $billing_info['created_date'];?> " readonly/>
    </div>
</div>

<div class="form-group row" align="left">
    <div class="col-xs-6">
        <label>Updated By</label>
        <input class="form-control" id="updated_by" name="updated_by" type="text" value="<?echo $billing_info['updated_by'];?>" readonly/>
    </div>
    <div class="col-xs-6">
        <label>Updated Date</label>
       <input class="form-control" id="updated_date" name="updated_date" type="text" value="<?echo $billing_info['updated_date'];?> " readonly/>
    </div>
</div>


<script>
    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>
