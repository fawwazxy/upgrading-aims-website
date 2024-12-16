<?php

include ('../controller/auth.php');

date_default_timezone_set("Asia/Kuala_Lumpur");
require "../model/aims_cert_function.php";
require "../model/lookup.php";
$ct=$_POST['id'];
?>
 
					<form method="post" action="../controller/aims_cert_exec.php" enctype="multipart/form-data"> 
					<input type="hidden" class="form-control" placeholder="" id="id" name="id" value="<? echo $ct['id'] ?>" />
			      
						
								<div class="form-group"  align="left">
								  <label>Certificate Name</font>&nbsp;</label>
								  <select  required class="form-control" name="certificate_name" id="certificate_name">
									<option value="">-- Choose Certificate --</option>
									<? echo getDropCertificate("");?>
								  </select>
								</div>
							
								<div class="form-group"  align="left">
								  <label><font>Vessel</font></label><br>
							&emsp;<input type="radio"  name="vessel_code" value="AA1"  /> Aishah Aims 1
							&emsp;<input type="radio"  name="vessel_code" value="AA2"  /> Aishah Aims 2
							&emsp;<input type="radio"  name="vessel_code" value="AA3" /> Aishah Aims 3
							&emsp;<input type="radio"  name="vessel_code" value="AA4" /> Aishah Aims 4 <br>
							&emsp;<input type="radio"  name="vessel_code" value="AA5" /> Aishah Aims 5
								</div>
							
								<div class="form-group"  align="left">
								  <label>Expiry Date :</font>&nbsp;</label>
								  </div>
								
								<div class="form-group"  align="left">
								  <label><font color="blue">Date</font></label>
								  <input class="form-control" placeholder=" "  type="date" id="date_in" name="date_in" value="" onchange="date_ex()">
								  <input class="form-control" placeholder=" " type="hidden" id="date_exp" name="date_exp" value="" value="date_ex()">
								  <input class="form-control" placeholder=" " type="hidden" id="date_exp1" name="date_exp1" value="" value="date_ex()">
								</div>
								
								
						
								
								
								<div class="form-group"  align="left">
								  <label><font color="blue">Remark</font></label>
								  <input class="form-control" placeholder=" " type="text" name="remark" >
								</div>
								
                             <div class="modal-footer">
                                   <button type="submit" class="btn btn-success">SUBMIT</button>
                                   <button type="reset" class="btn btn-warning">RESET</button>
                             </div>
			</form>
						
<script>
	function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }


		function date_ex(){		
		var x = new Date(document.getElementById("date_in").value);
		x.setDate(x.getDate() - 60);
		var dd = x.getDate();
		var mm = x.getMonth()+1;
		var yyyy = x.getFullYear();
		if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm}
		var today = yyyy+'-'+mm+'-'+dd;
		document.getElementById("date_exp").value = today;
		
		var y = new Date(document.getElementById("date_in").value);
		y.setDate(y.getDate() - 30);
		var dd = y.getDate();
		var mm = y.getMonth()+1;
		var yyyy = y.getFullYear();
		if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm}
		var today = yyyy+'-'+mm+'-'+dd;
		document.getElementById("date_exp1").value = today;
}
	




</script>