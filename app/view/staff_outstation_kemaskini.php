<?php

include ('../controller/auth.php');


require "../model/kehadiran_functions.php";
require "../model/lookup.php";

date_default_timezone_set("Asia/Kuala_Lumpur");
$id=$_POST['id'];
$data=getStaffOutstationById($id)->fetch_assoc();
?>
 
<form method="post" action="../controller/outstation_exec.php">
	<input id="action" name="action" type="hidden" value="kemaskiniOutstation"/>
	<input id="id" name="id" type="hidden" value="<? echo $id?>"/>
	<div class="form-group row" align="left">
		<div class="col-xs-12">
    	<label class="control-label">No. Kad Pengenalan<font color="red">**</font>&nbsp;</label>
		<input class="form-control" id="nokp_staff" name="nokp_staff" type="text" required value="<?echo $data['nokp_staff']?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
		</div>
    </div>
    <div class="form-group row" align="left">
    	<div class="col-xs-12">
    	<label class="control-label">Lokasi<font color="red">**</font>&nbsp;</label>
		<input class="form-control" id="lokasi" name="lokasi" type="text" required value="<?echo $data['lokasi']?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
		</div>
    </div>
    <div class="form-group row" align="left">
    	<div class="col-xs-6">
    	<label class="control-label">Latitud<font color="red">**</font>&nbsp;</label>
		<input class="form-control" id="latitude" name="latitude" type="text" required value="<?echo $data['latitude']?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
		</div>
		<div class="col-xs-6">
    	<label class="control-label">Longitud<font color="red">**</font>&nbsp;</label>
		<input class="form-control" id="longitude" name="longitude" type="text" required value="<?echo $data['longitude']?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
		</div>
    </div>
    <div class="form-group row" align="left">
    	<div class="col-xs-6">
    	<label class="control-label">Mula<font color="red">**</font>&nbsp;</label>
		<input class="form-control" placeholder=" " type="date" name="tarikh_mula" id="tarikh_mula" required value="<?echo date("Y-m-d",strtotime($data['tarikh_mula']))?>">
		</div>
		<div class="col-xs-6">
    	<label class="control-label">Akhir<font color="red">**</font>&nbsp;</label>
		<input class="form-control" placeholder=" " type="date" name="tarikh_tamat" id="tarikh_tamat" required value="<?echo date("Y-m-d",strtotime($data['tarikh_tamat']))?>">
		</div>
    </div>
        
	
	<div class="modal-footer">
		<button type="submit" class="btn btn-primary">Simpan</button>
		<button type="reset" class="btn btn-warning">Tetapan Semula</button>
	</div>
</form>
<script>
	function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>