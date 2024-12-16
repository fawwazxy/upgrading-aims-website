<?php

include ('../controller/auth.php');


require "../model/library_functions.php";


$id_library=$_POST['id_library'];
$data_dokumen = getLibraryInfo($id_library)->fetch_assoc();
?>
<div align="center">
	<h3><strong>Tajuk : <? echo $data_dokumen['nama']; ?></strong></h3>
</div>
<form method="post" action="../controller/library_kandungan_exec.php" enctype="multipart/form-data">
    <input id="action" name="action" type="hidden" value="upload_terjemahan"/>
    <input id="id_elibrary" name="id_elibrary" type="hidden" value="<?echo $id_library;?>"/>
    <div class="form-group"> 
        <label class="control-label">Fail<font color="red"> **</font>&nbsp;(Fail pdf Sahaja)</label>
        <input accept=".pdf" type="file" name="document_file" id="document_file" class="btn btn-link">
    </div>
    <div class="form-group"> 
        <label class="control-label">Bahasa Terjemahan<font color="red"></font></label>
        <input class="form-control" id="language_" name="language_" type="text" required  value="" />
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-success">Simpan</button>
        <button type="reset" class="btn btn-warning">Tetapan Semula</button>
    </div>
</form>