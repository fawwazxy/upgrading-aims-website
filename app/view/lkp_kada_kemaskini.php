<?php

include ('../controller/auth.php');


require "../model/pengusaha_functions.php";
require "../model/lookup.php";
$lkp_table = $_POST['id'];
$pieces = explode(",", $lkp_table);
$id = $pieces[0]; // id dalam table
$table = $pieces[1]; // table
$column = $pieces[2]; // column
$data_lkp=getLKPById($id, $table, $column)->fetch_assoc();
?>
 
<form method="post" action="../controller/pengusaha_exec.php">
	<input id="action" name="action" type="hidden" value="editLKP"/>
	<input id="id" name="id" type="hidden" value="<?echo $id;?>"/>
	<input id="table" name="table" type="hidden" value="<?echo $table;?>"/>
	<input id="id_table" name="id_table" type="hidden" value="<?echo $column;?>"/>
	<?
        $data_column = getLKPKada($table);
        $d=1;
        while($list_column = $data_column->fetch_assoc()) {
    ?>
    	<div class="form-group">
			<label class="control-label"><?echo $list_column['column_name'];?><font color="red">**</font>&nbsp;</label>
			<input class="form-control" id="<?echo $list_column['column_name'];?>" name="col<?echo $d++;?>" type="text" required value="<? echo $data_lkp[$list_column['column_name']]?>" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>
		</div>
    
    <?
    	$name_column[] = $list_column['column_name'];
		}
		$name_column=implode(',', $name_column);
	?>
	<input id="name_column" name="name_column" type="hidden" value="<?echo $name_column;?>"/>
	<input id="num" name="num" type="hidden" value="<?echo $d;?>"/>
	

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