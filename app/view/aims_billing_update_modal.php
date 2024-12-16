 <?php
include ('../controller/auth.php');
require "../model/aims_billing_function.php";
require "../model/lookup.php";

$id = $_POST['id'];
$billing_info = getBillingById($id)->fetch_assoc();
?>



<form method="post" action="../controller/aims_billing_update_exec.php" enctype="multipart/form-data">
					<input id="id" name="id" type="hidden" value="<? echo $billing_info['id'] ?>"/>
					
					<input id="updated_by" name="updated_by" type="hidden" value="<?php echo $_SESSION['SESS_NAME'] ?>"/>
					
				<div class="form-group row" align="left">
					<div class="col-xs-8">
						<label class="control-label">Client Name<font color="red">&nbsp;*</font></label>
						<select  required class="form-control" name="client_id" id="client_id">
									<option value="">-- Choose Client Name --</option>
									<? echo getDropDownClient($billing_info['client_id'])?>
									</select>
					</div>
				</div>

				<div class="form-group row" align="left">
					<div class="col-xs-8">
						<label class="control-label">Company Name<font color="red">&nbsp;*</font></label>
						<select  required class="form-control" name="company_id" id="company_id">
									<option value="">-- Choose Company Name --</option>
									<? echo getDropDownCompany($billing_info['company_id']);?>
									</select>
					</div>
				</div>
				
				<div class="form-group row" align="left">
					<div class="col-xs-8">
						<label class="control-label">Job No<font color="red">&nbsp;*</font></label>
						<input class="form-control" id="job_no" name="job_no" type="text" required value="<? echo $billing_info['job_no'] ?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
					</div>
				</div>
				
				<div class="form-group row" align="left">
					<div class="col-xs-8">
						<label class="control-label">Job Description<font color="red">&nbsp;*</font></label>
						<input class="form-control" id="job_description" name="job_description" type="text" required value="<? echo $billing_info['job_description'] ?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
						
					</div>
				</div>
				
				<div class="form-group row" align="left">
					<div class="col-xs-8">
						<label class="control-label">TIN No<font color="red">&nbsp;*</font></label>
						<input class="form-control" id="tin_no" name="tin_no" type="text" required value="<? echo $billing_info['tin_no'] ?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
					</div>
				</div>
				
				<div class="form-group row" align="left">
					<div class="col-xs-8">
						<label class="control-label">Amount to Invoice (RM)<font color="red">&nbsp;*</font></label>
						<input class="form-control" id="amount_to_invoice" name="amount_to_invoice" type="text" required value="<? echo $billing_info['amount_to_invoice'] ?>" style="text-transform:uppercase" onkeyup="multi()"/>
					</div>
				</div>
				
				<div class="form-group row" align="left">
					<div class="col-xs-8">
						<label class="control-label">SST<font color="red">&nbsp;</font></label>
						<input class="form-control" id="sst" name="sst" type="text" required value="<? echo $billing_info['sst'] ?>" style="text-transform:uppercase" onkeyup="multi()"/>
					</div>
				</div>
				
				<div class="form-group row" align="left">
					<div class="col-xs-8">
						<label class="control-label">Amount Credit Note (RM)<font color="red">&nbsp;</font></label>
						<input class="form-control" id="amount_credit_note" name="amount_credit_note" type="text" value="<? echo $billing_info['amount_credit_note'] ?>" style="text-transform:uppercase" onkeyup="multi()"/>
					</div>
				</div>
				
				<div class="form-group row" align="left">
				<div class="col-xs-8">
					<label class="control-label">Amount Debit Note (RM)</label>
					<input class="form-control" id="amount_debit_note" name="amount_debit_note" type="text" value="<? echo $billing_info['amount_debit_note'] ?>" style="text-transform:uppercase"  onkeyup="multi()"/>
				</div>
				</div>

				<div class="form-group row" align="left">
					<div class="col-xs-8">
						<label class="control-label">Total Amount (RM)<font color="red">&nbsp;*</font></label>
						<input class="form-control auto-number"  id="total_invoice" name="total_invoice" type="text" readonly required value="<? echo $billing_info['total_invoice'] ?>" style="text-transform:uppercase" value="multi()"/>
					</div>
				</div>
				
				<div class="form-group row" align="left">
					<div class="col-xs-8">
						<label class="control-label">Term Of Payment</label>
						<input class="form-control" id="term_of_payment" name="term_of_payment" type="number" value="<? echo $billing_info['term_of_payment']?>"  style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
					</div>
					<br><br>
					<b><span style="text-align:center;padding-left: -80px">Days</span></b>
				</div>
				
				<div class="form-group row" align="left">
					<div class="col-xs-8">
						<label class="control-label">PO No</label>
						<input class="form-control" id="po_no" name="po_no" type="text" value="<? echo $billing_info['po_no'] ?>" style="text-transform:uppercase" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
					</div>
				</div>
				
				<div class="form-group row" align="left">
					<div class="col-xs-8">
						<label class="control-label">DO No</label>
						<input class="form-control" id="do_no" name="do_no" type="text" value="<? echo $billing_info['do_no'] ?>" style="text-transform:uppercase" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/> 
					</div>
				</div>
				
				<div align="center">
					<button type="submit" class="btn btn-success">Save</button>
					<input class="btn btn-primary" type="button" value="Back" onclick="goBack()">
				</div>
			</form>
				<script>
				
					
				
					 function multi() {

						var amount_to_invoice = document.getElementById('amount_to_invoice').value;
						var sst = document.getElementById('sst').value;
						var amount_credit_note = document.getElementById('amount_credit_note').value;
						var amount_debit_note = document.getElementById('amount_debit_note').value;
						
						var b = (amount_to_invoice * sst);
						var total_inv = (((amount_to_invoice * 1) + b)-amount_credit_note).toFixed(2);
						var total_invo = ((+total_inv) + (+amount_debit_note));
						var total= total_invo.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
						var total_invoice = document.getElementById('total_invoice');
						total_invoice.value = total;
            
					}       
					

				</script>
				
	