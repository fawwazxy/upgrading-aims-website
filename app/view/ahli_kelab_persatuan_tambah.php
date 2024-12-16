<?php

include ('../controller/auth.php');

require "../model/ahli_functions.php";
require "../model/lookup.php";
$id = $_POST['id'];
?>
 
<form method="post" action="../controller/ahli_konfigurasi_exec.php" enctype="multipart/form-data">
	<input id="action" name="action" type="hidden" value="kelabPersatuanAdd"/>
	<input id="id" name="id" type="hidden" value="<? echo $id?>"/>
    
     <div class="form-group row" align="left">
        <div class="col-xs-12">
            <label class="control-label">Nama<font color="red">&nbsp;**</font></label>
            <input class="form-control" id="nama" name="nama" type="text" required value="" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
        </div>
    </div>

    <div class="form-group row" align="left">
        <div class="col-xs-12">
            <label class="control-label">Alamat<font color="red">&nbsp;**</font></label>
            <textarea class="form-control" rows="5" name="alamat" id="alamat" required autocomplete="off"></textarea>
        </div>
    </div>

    <div class="form-group row" align="left">
        <div class="col-xs-12">
            <label class="control-label">Nama Pengerusi<font color="red">&nbsp;**</font></label>
            <input class="form-control" id="nama_pengerusi" name="nama_pengerusi" type="text" required value=""/>
        </div>
    </div>

    <div class="form-group row" align="left">
        <div class="col-xs-12">
            <label class="control-label">No. Telefon<font color="red">&nbsp;**</font></label>
            <input class="form-control" id="tel" name="tel" type="text" required value=""/>
        </div>
    </div>

    <div class="form-group row" align="left">
        <div class="col-xs-12">
            <label class="control-label">Email<font color="red">&nbsp;**</font></label>
            <input class="form-control" id="email" name="email" type="text" required value=""/>
        </div>
    </div>

    <div class="form-group row" align="left">
        <div class="col-xs-12">
            <label class="control-label">Nama Bank<font color="red">&nbsp;**</font></label>
            <input class="form-control" id="nama_bank" name="nama_bank" type="text" required value=""/>
        </div>
    </div>

    <div class="form-group row" align="left">
        <div class="col-xs-12">
            <label class="control-label">No. Akaun Bank<font color="red">&nbsp;**</font></label>
            <input class="form-control" id="no_akaun" name="no_akaun" type="text" required value=""/>
        </div>
    </div>

    <div class="form-group row" align="left">
        <div class="col-xs-12">
            <label>Logo&nbsp;<font color="red"><i>(Hanya fail format jpeg/jpg/png/gif sahaja dibenarkan)</i></font></label>
            <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
            <input type="file" accept=".jpg,.jpeg,.png,.gif" name="logo" id="logo">
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