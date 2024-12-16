<?php
	include ('../controller/auth.php');
	require "../model/support_function.php";
?>
			<?      
            $no_staff = $_GET['no_staff'];
          	$no_staff_login = $_GET['SESS_NO_STAFF'];
            $id = $_GET['id'];
 			?>


							 

							<form method="post" enctype="multipart/form-data" action="../controller/update_aduan_exec.php?id=<?php echo $row_data['id']; ?>" >
					  
					  
					        <input name="id_support" type="text" class="input-short" value="<? echo $_GET['id_support']; ?>" />

					        	<? 
	                    		$row=  getCatatanPembatalan($id)->fetch_assoc();
			                	?>
							
						        XCTDFGVXGYSHXBGH
						    	<p><b><? echo $row['catatan'];?> <br><br>
						   
							</form>
</body>

</html>
