<?php

include ('../controller/auth.php');

require "../model/staff_function.php";

$id=$_POST['id'];
$staff_record_id=$_POST['staff_record_id'];
$totalAL = getTotalcutiAL($id)->fetch_assoc();
$totalMC = getTotalcutiMC($id)->fetch_assoc();
$cuti_info = getCutiInfoByJenisCuti($id)->fetch_assoc();
?>
 
<form method="post" action="../controller/staff_update_cuti_exec.php">
    <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
    <input name="staff_record_id" type="hidden" class="input-short" value="<? echo $staff_record_id;?>" />

    <div class="form-group row" align="left">
    <div class="col-xs-6">
    <label>Jenis Cuti</label>
    <input class="form-control" id="jenis_cuti" name="jenis_cuti" type="text" readonly value="<?echo $cuti_info['jenis_cuti'];?>&nbsp;-&nbsp;<?echo $cuti_info['desc'];?>"/>
    </div>
    <div class="col-xs-6">
    <label>Jumlah Keseluruhan</label>
    <input class="form-control" id="total_cuti" name="total_cuti" type="text" value="<?echo $cuti_info['total_cuti'];?>"/>
    </div>
    </div>

    <div class="form-group row" align="left">
    <div class="col-xs-6">
    <label class="control-label">Baki Cuti Semasa<font color="red">&nbsp;**</font></label>
    <input class="form-control" id="baki_cuti" name="baki_cuti" type="text" required value="<?echo $cuti_info['baki_cuti'];?>"/>
    </div>
    <div class="col-xs-6">
    <label class="control-label">Baki Cuti Permohonan<font color="red">&nbsp;**</font></label>
    <input class="form-control" id="baki_cuti_pohon" name="baki_cuti_pohon" type="text" required value="<?echo $cuti_info['baki_cuti_pohon'];?>"/>
    </div>
    </div>
    
    <div class="form-group row" align="left">
    <div class="col-xs-6">
    <label class="control-label">Jumlah Cuti Diambil<font color="red">&nbsp;**</font></label>
    <input class="form-control" id="" name="" type="text" required value="<?echo $totalAL['totalal'];?>" readonly/>
    </div>
    <div class="col-xs-6">
    <label class="control-label">Jumlah MC Diambil<font color="red">&nbsp;**</font></label>
    <input class="form-control" id="" name="" type="text" required value="<?echo $totalMC['totalmc'];?>"readonly/>
    </div>
    </div>

	<div class="modal-footer">
		<button type="submit" class="btn btn-success">Simpan</button>
		<button type="reset" class="btn btn-warning">Tetapan Semula</button>
	</div>
</form>
<script>

</script>