<?php

	require "../model/support_function.php";
?>
			<?      
            
            $id = $_GET['id'];
 			?>


							 

					  hgvgggggggggggggggggggggggggggggggggggggggggggg
					       
					        	<? 
	                    		$row=  getSupportView($id)->fetch_assoc();
			                	?>
							
						        
						    	<p><b>Maklum Balas </b></p> <? echo $row['client_feedback'];?> <br><br>
						   
 
						

</html>
