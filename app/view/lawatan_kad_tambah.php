<?php

include ('../controller/auth.php');


require "../model/lawatan_functions.php";
require "../model/lookup.php";
$id_kad=$_POST['id'];
?>
 
<form method="post" action="../controller/lawatan_exec.php">
	<input id="action" name="action" type="hidden" value="kadPelawatAddEdit"/>
	<input id="id_kad" name="id_kad" type="hidden" value="<? echo $id_kad?>"/>

	<!-- <div class="form-group row" align="left">
        <div class="col-xs-8">
            <label class="control-label">Kod<font color="red">&nbsp;**</font></label>
            <input class="form-control" id="kod_kad" name="kod_kad" type="text" required value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
        </div>
    </div> -->
    
    <div class="form-group row" align="left">
        <div class="col-xs-8">
            <label class="control-label">Kod</label>
            <input class="form-control" placeholder=" " name="kod_kad" id="kod_kad" readonly value="<? echo getMaxKodKad(); ?>">
        </div>
    </div>

    <div class="form-group row" align="left">
        <div class="col-xs-8">
            <label class="control-label">Jenis Kad<font color="red">&nbsp;**</font></label>
            <input class="form-control" id="jenis_kad" name="jenis_kad" type="text" required value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
        </div>
    </div>

    <div class="form-group row" align="left">
        <div class="col-xs-8">
            <label class="control-label">Nama Kad<font color="red">&nbsp;**</font></label>
            <input class="form-control" id="nama_kad" name="nama_kad" type="text" required value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
        </div>
    </div>
	
	<div align="right">
		<button type="submit" class="btn btn-success">Simpan</button>
		<button type="reset" class="btn btn-warning">Tetapan Semula</button>
	</div>
</form>
<script>
	function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>