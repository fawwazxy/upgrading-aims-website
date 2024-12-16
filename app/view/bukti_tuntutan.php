 <?php

include ('../controller/auth.php');


require "../model/claim_function.php";

?>
<?
         
     $id = $_POST['rowid'];
        
?>
 
<center>
	<? 

		$data = getBuktiTuntutan($id);

		if($data['jenis_tuntutan']=='TRNSPRT'){
			echo $data['bukti_perjalanan'];
		} else {

		echo $data['document'];
		}
		


	?>
		
</center>
 