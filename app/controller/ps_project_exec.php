<?php
   	include "../model/project_schedule_function.php";
    
	
	//Sanitize the POST values
$action = ($_GET['act']);

if ($action == "ps_project_add"){
	$project_code = $_POST['project_code'];
	$project_name = $_POST['project_name'];
	$client_name = $_POST['client_name'];
	$state = $_POST['state'];
	$parliament = $_POST['parliament'];
	$country = $_POST['country'];
	$type_of_job = $_POST['type_of_job'];
	$start_date = $_POST['start_date'];
	$remark = $_POST['remark'];
	$created_by = $_POST['created_by'];
	$image = $_FILES['image']['tmp_name'];
	$imgContent = addslashes(file_get_contents($image));
		
		$result = addProjectDetails($project_code, $project_name, $client_name, $state, $parliament, $type_of_job, $remark, $created_by, $imgContent, $start_date, $country);

	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/ps_project_list.php?id_project=$result';
            </script>");
		//header("location: ../view/ps_project_list.php?id_project=$result");
		exit();
	}else {
		die("Query failed");
	}

} else if ($action == "ps_project_update"){
	$project_code = clean($_POST['project_code']);
	$project_name = clean($_POST['project_name']);
	$client_name = clean($_POST['client_name']);
	$state = clean($_POST['state']);
	$parliament = clean($_POST['parliament']);
	$country = clean($_POST['country']);
	$type_of_job = clean($_POST['type_of_job']);
	$start_date = clean($_POST['start_date']);
	$remark = clean($_POST['remark']);
	$created_by = clean($_POST['created_by']);
	// $image = clean($_FILES['image']['tmp_name']);
	// $imgContent = addslashes(file_get_contents($image));
	$id_project = clean($_POST['id_project']);
		
	if(!empty($_FILES['image']['name'])){ //new image uploaded
	
	if (($_FILES["image"]["type"] == "image/jpeg")
	|| ($_FILES["image"]["type"] == "image/png" )) {
      if ($_FILES["image"]["error"] > 0) {
         echo "Oh no! An error has occurred.";
         echo "Error Code: " . $_FILES["image"]["error"];
	  }else {
		 if ($_FILES["image"]["size"] <= 1048576*2 ){ 
			$image = $_FILES['image']['tmp_name'];
			$imgContent = addslashes(file_get_contents($image)); // gambar
			// $filename = $_FILES['image']['name']; // nama asal gambar
	

	$result = editProjectDetailsImage($project_code, $project_name, $client_name, $state, $parliament, $type_of_job, $remark, $created_by, $imgContent, $start_date, $country, $id_project);

		

		if($result){
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/ps_project_add.php?id_project=$id_project';
            </script>");
			//header("location: ../view/ps_project_add.php?id_project=$id_project");
			exit();
		}else{
					die("Query failed");
}
}else {
			echo "<script type='text/javascript'>alert('Files must be less than 2MB');
			window.location.href='../view/ps_project_add.php?id_project=$id_project';</script>";
	     }
	  }
	}else {
		echo "<script type='text/javascript'>alert('Files must be either JPEG or PNG');
					window.location.href='../view/ps_project_add.php?id_project=$id_project';</script>";
	    		
	}
}else{
	$result = editProjectDetailsWithoutImage($project_code, $project_name, $client_name, $state, $parliament, $type_of_job, $remark, $created_by, $start_date, $country, $id_project);
			  
		//Check whether the query was successful or not
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/ps_project_add.php?id_project=$id_project';
            </script>");
			 //header("location: ../view/ps_project_add.php?id_project=$id_project");
			exit();
			
		}else {
			die("Query failed");
		}
		
}	
}
	
?>