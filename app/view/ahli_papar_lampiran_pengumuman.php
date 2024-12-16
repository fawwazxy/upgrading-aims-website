<?php

	include ('../controller/auth.php');

	require "../model/ahli_functions.php";
	require "../model/lookup.php";

?>
<?
         
		 $id = $_POST['id'];
		 $data=getPengumumanById($id)->fetch_assoc();
		 $str=$data['dokumen_filename'];
         $type=explode(".",$str);
         $file_type=end($type);
         echo "<center>";
	        if($file_type!="pdf") {
	            echo '<br><img width="500" height="600" src="../../iahli/lampiran/'.$data['dokumen_filename'].'"/><br>';}
	        else{
	          echo '<object width="500" height="600" data="../../iahli/lampiran/'.$data['dokumen_filename'].'"/><br>'.'</object>';}
	     echo "</center>";
 ?>  