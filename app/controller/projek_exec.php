<?php
   	include "../model/project_management_function.php";
    
	
	//Sanitize the POST values
   	$id_pesanan_belian = ($_POST['id_pesanan_belian']);
   	$tarikh_mula = ($_POST['tarikh_mula']);
   	$tarikh_akhir = ($_POST['tarikh_akhir']);
   		$jumlah_hari = ($_POST['jumlah_hari']);
   	 $no_staff = ($_GET['no_staff']); 




	echo $result = addProjek($id_pesanan_belian,$tarikh_mula,$tarikh_akhir,$jumlah_hari);
	
	//Check whether the query was successful or not
	if($result!="" && $result > 0) 
	
	{
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/projek_list.php?no_staff=$no_staff';
            </script>");
		//header("location: ../view/projek_list.php?no_staff=$no_staff");
		exit();
	}
	else 
	{
		die("Query failed");
	}
	
?>