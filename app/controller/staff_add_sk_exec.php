
<?php

include "../model/staff_function.php";
	
	
	$no_staff = clean($_POST['no_staff']);
	
	$skill = clean($_POST['skill']);
	$level = clean($_POST['level']);
	
	
	//$staff_id = clean($_POST['staff_id']);
	


	$id = clean($_POST['id']);
	
	
	
	
	
	$result = addStaffRecord($no_staff,$skill,$level);
    
	
	
	
	

	//Create UPDATE query
	

	
	
	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/staff_add_record.php?no_staff=$no_staff';
				            </script>");
		//header("location: ../view/staff_add_record.php?no_staff=".$no_staff);
		exit();
	}else {
		die("Query failed");
	}
?>