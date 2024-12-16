<?php

	include ('../controller/auth.php');
	require "../model/lookup.php";	
	require "../model/aims_ssa_function.php";

	$id = $_POST['id'];
	$staffinfo = getSSAImg($id)->fetch_assoc();
?>
<div align="center">
<?echo '<img src="data:image/jpeg;base64,'.base64_encode( $staffinfo['ee'] ).'" style="float:center;align:center;"/>';?></td>
</div>	