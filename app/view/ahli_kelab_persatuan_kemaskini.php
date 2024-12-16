<?php

include ('../controller/auth.php');

require "../model/ahli_functions.php";
require "../model/lookup.php";
$id = $_POST['id'];
$kelab_persatuan_info = getKelabPersatuanInfoById($id)->fetch_assoc();
?>
 
<form method="post" action="../controller/ahli_konfigurasi_exec.php" enctype="multipart/form-data">
	<input id="action" name="action" type="hidden" value="kelabPersatuanEdit"/>
	<input id="id" name="id" type="hidden" value="<? echo $id?>"/>
    
     <div class="form-group row" align="left">
        <div class="col-xs-12">
            <label class="control-label">Nama<font color="red">&nbsp;**</font></label>
            <input class="form-control" id="nama" name="nama" type="text" value="<?echo $kelab_persatuan_info['nama'];?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
        </div>
    </div>

    <div class="form-group row" align="left">
        <div class="col-xs-12">
            <label class="control-label">Alamat<font color="red">&nbsp;**</font></label>
            <textarea class="form-control" rows="5" name="alamat" id="alamat" required autocomplete="off"><?echo $kelab_persatuan_info['alamat'];?></textarea>
        </div>
    </div>

    <div class="form-group row" align="left">
        <div class="col-xs-12">
            <label class="control-label">Nama Pengerusi<font color="red">&nbsp;**</font></label>
            <input class="form-control" id="nama_pengerusi" name="nama_pengerusi" type="text" value="<?echo $kelab_persatuan_info['nama_pengerusi'];?>"/>
        </div>
    </div>

     <div class="form-group row" align="left">
        <div class="col-xs-12">
            <label class="control-label">No. Telefon<font color="red">&nbsp;**</font></label>
            <input class="form-control" id="tel" name="tel" type="text" value="<?echo $kelab_persatuan_info['tel'];?>"/>
        </div>
    </div>

     <div class="form-group row" align="left">
        <div class="col-xs-12">
            <label class="control-label">Email<font color="red">&nbsp;**</font></label>
            <input class="form-control" id="email" name="email" type="text" value="<?echo $kelab_persatuan_info['email'];?>"/>
        </div>
    </div>

    <div class="form-group row" align="left">
        <div class="col-xs-12">
            <label class="control-label">Nama Bank<font color="red">&nbsp;**</font></label>
            <input class="form-control" id="nama_bank" name="nama_bank" type="text" value="<?echo $kelab_persatuan_info['nama_bank'];?>"/>
        </div>
    </div>

    <div class="form-group row" align="left">
        <div class="col-xs-12">
            <label class="control-label">No. Akaun Bank<font color="red">&nbsp;**</font></label>
            <input class="form-control" id="no_akaun" name="no_akaun" type="text" value="<?echo $kelab_persatuan_info['no_akaun'];?>"/>
        </div>
    </div>

    <div class="form-group row" align="left">
        <div class="col-xs-12">
            <label>Logo&nbsp;<font color="red"><i>(Hanya fail format jpeg/jpg/png/gif sahaja dibenarkan)</i></font></label>
            <br><?if($kelab_persatuan_info['logo'] != ''){
                echo '<img width="120" height="120" src="data:image/jpeg;base64,'.base64_encode( $kelab_persatuan_info['logo'] ).'"/><br>'.$kelab_persatuan_info['logo_filename'];
                }?>
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