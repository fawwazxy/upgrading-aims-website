<?php

include ('../controller/auth.php');

require "../model/aims_gl_function.php";


$id = $_GET['id'];
$data = getHkStockById($id)->fetch_assoc(); 
?> 


<form method="post" action="../controller/aims_gl_hk_stock_update_exec.php" >     
	<input id="id" name="id" type="hidden" value="<? echo $id?>"/>



	<label><font color="red">** Maklumat Wajib Diisi.</font></label>
	<br>


	<div class="form-group"  align="left">
		<label>ITEM<font color="red">**</font>&nbsp;</label>
		<select  required class="form-control" name="hk_item_id" id="hk_item_id">
			<option value="">-- Choose Item --</option>
			<? echo getDropDownHkItem($data['hk_item_id']); ?>
		</select>
	</div>

	<div class="form-group"  align="left">
		<label>TOTAL STOCK<font color="red">**</font>&nbsp;</label>
		<input class="form-control" name="stock" id="stock" value="<? echo $data['stock'];?>" >
	</div>

	<div class="form-group"  align="left"s>
		<label>EXPIRED DATE</label>
		<input class="form-control" id="expired" name="expired" type="date" value="<? echo $data['expired'];?>"/>
	</div>

	<div class="modal-footer">
		<button type="submit" class="btn btn-primary">Save</button>

	</div>

</form>

<script>

	function convertToUppercase(el) {
		if(!el || !el.value) return;
		el.value = el.value.toUpperCase();
	}


</script>
