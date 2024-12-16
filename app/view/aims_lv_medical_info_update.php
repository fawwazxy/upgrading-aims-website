<?php

include ('../controller/auth.php');

require "../model/staff_function.php";

$id=$_POST['id'];
$staff_record_id=$_POST['staff_record_id'];
$medical_info = getMedicalById($id)->fetch_assoc();
?>
 
<form method="post" action="../controller/aims_lv_medical_info_update_exec.php">
    <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
    <input name="staff_record_id" type="hidden" class="input-short" value="<? echo $staff_record_id;?>" />

    <div class="form-group row" align="left">
    <div class="col-xs-6">
    <label>Total Entitle</label>
    <input class="form-control" id="entitle_medical" name="entitle_medical" type="text" value="<?echo $medical_info['entitle_medical'];?>"/>
    </div>
    </div>

    <!--<div class="form-group row" align="left">-->
    <!--<div class="col-xs-6">-->
    <!--<label>Jumlah Claim</label>-->
    <!--<input class="form-control" id="jumlah_claim" name="jumlah_claim" type="text" value="<?echo $medical_info['jumlah_claim'];?>"/>-->
    <!--</div>-->
    <!--</div>-->

    <div class="form-group row" align="left">
    <div class="col-xs-6">
    <label class="control-label">Balance Claim<font color="red">&nbsp;**</font></label>
    <input class="form-control" id="baki_claim" name="baki_claim" type="text" required value="<?echo $medical_info['baki_claim'];?>"/>
    </div>
    </div>

	<div class="modal-footer">
		<button type="submit" class="btn btn-success">Simpan</button>
		<button type="reset" class="btn btn-warning">Tetapan Semula</button>
	</div>
</form>
<script>

</script>