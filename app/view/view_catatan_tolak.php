<?php
	include ('../controller/auth.php');
	require "../model/support_function.php";
    
	$id = $_GET['id'];
	$row=  getCatatanTolak($id)->fetch_assoc();
?>

    	<p><b><? echo $row['catatan'];?> <br><br>
						   
</body>

</html>
