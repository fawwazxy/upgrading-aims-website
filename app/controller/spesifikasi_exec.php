<?
	include "../model/spesifikasi_function.php";

 $action = ($_GET['act']);

if ($action == "spesifikasi_detail"){
	$name = clean($_POST['name']);
	// echo "insert";
	

		$newId = addNamaSpesifikasi($name);

		if($newId > 0){
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/spesifikasi_detail.php?id=$newId';
            </script>");
			//header("location: ../view/spesifikasi_detail.php?id=$newId");
			exit();
		}else{
			echo "<script> alert('Data tidak dapat diproses. Sila cuba semula.'); 
			location.href = '../view/".$action.".php';</script>";
			exit();
		}

}else if($action == "spesifikasi_detail_update"){
			 $name = clean($_POST['name']);
		$id = clean($_POST['id']);
// echo "update";

		$newId = updateNamaSpesifikasi($name,$id);

		if($newId > 0){
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/spesifikasi_detail.php?id=$id';
            </script>");
			//header("location: ../view/spesifikasi_detail.php?id=$id");
			exit();
		}else{
			echo "<script> alert('Data tidak dapat diproses. Sila cuba semula.'); location.href = '../view/".$action.".php';</script>";
			exit();
		}

}else if ($action == "spesifikasi_jentera_delete"){
	$id=($_GET['id']);
	 $id_delete=($_GET['id_delete']);

	$result =  deleteMachinery($id_delete);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/spesifikasi_jentera.php?id=$id';
            </script>");
		//header("location: ../view/spesifikasi_jentera.php?id=$id");
		exit();
	}else {
		die("Query failed");
	}
}else if ($action == "spesifikasi_jentera_add"){
	 $id=($_GET['id']);
	 $machinery_id = ($_POST['machinery_id']);

	$result = addMachinery($id, $machinery_id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/spesifikasi_jentera.php?id=$id';
            </script>");
		//header("location: ../view/spesifikasi_jentera.php?id=$id");
		exit();
	}else {
		die("Query failed");
	}

}else if ($action == "spesifikasi_jentera_update"){
	 $id=($_GET['id']);
	 $machinery_id = ($_POST['machinery_id']);

	$result = editMachinery( $machinery_id, $id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/spesifikasi_jentera.php?id=$id';
            </script>");
		//header("location: ../view/spesifikasi_jentera.php?id=$id");
		exit();
	}else {
		die("Query failed");

	}
	} else if ($action == "spesifikasi_youtube_add"){
	 $id=($_GET['id']);
	 $youtube_name = ($_POST['youtube_name']);
	 $youtube_link = ($_POST['youtube_link']);
	 

	$result = addYoutube($id, $youtube_name, $youtube_link);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/spesifikasi_youtube.php?id=$id';
            </script>");
		//header("location: ../view/spesifikasi_youtube.php?id=$id");
		exit();
	}else {
		die("Query failed");
	}
	
} else if($action == "spesifikasi_youtube_delete"){
	$id=($_GET['id']);
	$id_youtube=($_GET['id_youtube']);
	$result =  deleteYoutube($id_youtube);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/spesifikasi_youtube.php?id=$id';
            </script>");
		//header("location: ../view/spesifikasi_youtube.php?id=$id");
		exit();
	}else {
		die("Query failed");
	}
} else if ($action == "spesifikasi_youtube_update"){
	$id=($_GET['id']);
	 $id_youtube=($_GET['id_youtube']);
	 $youtube_link = ($_POST['youtube_link']);
	 $youtube_name = ($_POST['youtube_name']);

	$result = editYoutube($youtube_link, $youtube_name, $id_youtube);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/spesifikasi_youtube.php?id=$id';
            </script>");
		//header("location: ../view/spesifikasi_youtube.php?id=$id");
		exit();
	}else {
		die("Query failed");
	}
}
//end nabilah
//start Lan
 else if ($action == "spesifikasi_lukisan"){
	
	$id_specs_details= $_POST['id_specs_details'];
	$nama=$_POST['nama'];
		
	if (($_FILES["image"]["type"] == "image/jpeg")
	|| ($_FILES["image"]["type"] == "image/png" )) {
      if ($_FILES["image"]["error"] > 0) {
         echo "Oh no! An error has occurred.";
         echo "Error Code: " . $_FILES["image"]["error"];
	  }else {
		 if ($_FILES["image"]["size"] <= 1048576*2 ){ 
			$image = $_FILES['image']['tmp_name'];
			$imgContent = addslashes(file_get_contents($image)); // gambar
			$filename = $_FILES['image']['name']; // nama asal gambar
		
		$result = addDrawing($id_specs_details,$nama,$imgContent);
      
			//Check whether the query was successful or not
			if($result) {
				echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/spesifikasi_lukisan.php?id=$id_specs_details';
            </script>");
				// header("location: ../view/spesifikasi_lukisan.php?id=$id_specs_details");
				exit();
			}else {
				die("Query failed");
			}
			
		 }else {
			echo "<script type='text/javascript'>alert('Files must be less than 2MB');
					window.location.href='../view/spesifikasi_lukisan.php;</script>";
	     }
	 }
	}else {
		echo "<script type='text/javascript'>alert('Files must be either JPEG or PNG');
					window.location.href='../view/spesifikasi_lukisan.php;</script>";
	}


	//mcm dlm exec biasa
}else if($action == "spesifikasi_lukisan_update"){
	
	$id_specs_details= $_POST['id_specs_details'];
	$id_lukisan= $_POST['id_lukisan'];	
	$nama=$_POST['nama'];
	
	
	if(!empty($_FILES['image']['name'])){ //new image uploaded
		
		if (($_FILES["image"]["type"] == "image/jpeg")
		|| ($_FILES["image"]["type"] == "image/png" )) {
		  if ($_FILES["image"]["error"] > 0) {
			 echo "Oh no! An error has occurred.";
			 echo "Error Code: " . $_FILES["image"]["error"];
		  }else {
			 if ($_FILES["image"]["size"] <= 10485760*2 ){ 
				$image = $_FILES['image']['tmp_name'];
				$imgContent = addslashes(file_get_contents($image)); // gambar
				$filename = $_FILES['image']['name']; // nama asal gambar
			
			
				
				$result = updateLukisanGambar($id_lukisan,$nama,$imgContent);
				  
				//Check whether the query was successful or not
				if($result) {
					echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/spesifikasi_lukisan.php?id=$id_specs_details';
				            </script>");
					//header("location: ../view/spesifikasi_lukisan.php?id=$id_specs_details");
					exit();
				}else {
					die("Query failed");
				}
			 }else {
				echo "<script type='text/javascript'>alert('Image must be less than 2MB');
						window.location.href='../view/spesifikasi_lukisan.php?id=.$id_specs_details';</script>";
			 }
		  }
		}else {
			echo "<script type='text/javascript'>alert('Files must be either JPEG or PNG');
						window.location.href='../view/spesifikasi_lukisan.php?id=.$id_specs_details';</script>";
		}
	}else{
		$result = updateLukisan($id_lukisan,$nama);
				  
		//Check whether the query was successful or not
		if($result){
			echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/spesifikasi_lukisan.php?id=$id_specs_details';
				            </script>");
		// header("location: ../view/spesifikasi_lukisan.php?id=$id_specs_details");
			exit();
		}else {
			die("Query failed");
		}
	}	
}else if ($action == "spesifikasi_lukisan_delete"){
	
	$id= clean($_GET['id']);
	$id_specs_details= clean($_GET['id_specs_details']);
	
		$result = deleteLukisan($id);
        if($result) {
        	echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/spesifikasi_lukisan.php?id=$id_specs_details';
				            </script>");
			//header("location: ../view/spesifikasi_lukisan.php?id=$id_specs_details");
			exit();
			
		}else {
			die("Query failed");
		}
}
// end Lan
//start wani
else if ($action == "spesifikasi_dimensi_delete"){
	 $id=($_GET['id']);
	 $id_specs_details=($_GET['id_specs_details']);

	$result =  deleteDimensi($id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/spesifikasi_lukisan.php?id=$id_specs_details';
				            </script>");
		//header("location: ../view/spesifikasi_dimensi.php?id=$id_specs_details");
		exit();
	}else {
		die("Query failed");
	}
}else if ($action == "spesifikasi_dimensi_add"){
	 $id=($_GET['id']);
	 $details = ($_POST['details']);

	$result = addDimensi($id,$details);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/spesifikasi_dimensi.php?id=$id';
				            </script>");
		//header("location: ../view/spesifikasi_dimensi.php?id=$id");
		exit();
	}else {
		die("Query failed");
	}

}else if ($action == "spesifikasi_dimensi_edit"){
	 $id=($_GET['id_dimensi']);
	 $id_specs_details = ($_POST['id_specs_details']);
	 $details = ($_POST['details']);

	$result = editDimensi( $details, $id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/spesifikasi_dimensi.php?id=$id_specs_details';
				            </script>");
		//header("location: ../view/spesifikasi_dimensi.php?id=$id_specs_details");
		exit();
	}else {
		die("Query failed");
	}
} else if ($action == "spesifikasi_bahan_add"){
	 $id=($_GET['id']);
	 $name = ($_POST['name']);
	
	$result = addBahan($id, $name);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/spesifikasi_bahan.php?id=$id';
				            </script>");
		//header("location: ../view/spesifikasi_bahan.php?id=$id");
		exit();
	}else {
		die("Query failed");
	}
	
} else if($action == "spesifikasi_bahan_delete"){
	 $id_bahan=($_GET['id_bahan']);
	 $id_specs_details=($_GET['id_specs_details']);
	$result =  deleteBahan($id_bahan);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/spesifikasi_bahan.php?id=$id_specs_details';
				            </script>");
		//header("location: ../view/spesifikasi_bahan.php?id=$id_specs_details");
		exit();
	}else {
		die("Query failed");
	}
} else if ($action == "spesifikasi_bahan_edit"){
	 $id=($_POST['id']);
	 $id_specs_details=($_POST['id_specs_details']);
	 // $youtube_link = ($_POST['youtube_link']);
	 $name = ($_POST['name']);

	$result = editBahan($name, $id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/spesifikasi_bahan.php?id=$id_specs_details';
				            </script>");
		//header("location: ../view/spesifikasi_bahan.php?id=$id_specs_details");
		exit();
	}else {
		die("Query failed");
	}
}
//end wani
//start bai
else if ($action == "spesifikasi_cth_gambar"){
	

		$id_specs_details = clean($_POST['id_specs_details']);
		$name = clean($_POST['name']);
		$id=($_GET['id']);
		$image = $_FILES['image']['tmp_name'];
	    $imgContent = addslashes(file_get_contents($image));
		
		$newId = addGambarBarang($id_specs_details,$name,$imgContent) ;

		if($newId > 0){
			echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/spesifikasi_cth_gambar.php?id=$id_specs_details';
				            </script>");
			//header("location: ../view/spesifikasi_cth_gambar.php?id=$id_specs_details");
			exit();
		}
		else{
			echo "<script> alert('Data tidak dapat diproses. Sila cuba semula.'); location.href = '../view/".$action.".php?stock_id=$stock_id';</script>";
			exit();
		}
}else if ($action == "spesifikasi_cth_gambar_delete"){
  
  $id= clean($_GET['id']);
  $id_speccccs_details = $_GET['id_speccccs_details'];
  
    $result = deleteCthGambar($id);
        if($result) 
  
  {
  	echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/spesifikasi_cth_gambar.php?id=$id_speccccs_details';
				            </script>");
    //header("location: ../view/spesifikasi_cth_gambar.php?id=$id_speccccs_details");
    exit();
  }
  else 
  {
    die("Query failed");
  }
  
}else if($action == "spesifikasi_cth_gambar_update"){
  
  $id_speccccs_details= $_POST['id_speccccs_details'];
  $id_cth_gambar= $_POST['id_cth_gambar'];  
  $name=$_POST['name'];
  
  
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
        $filename = $_FILES['image']['name']; // nama asal gambar
      
      
        
        $result = updateAllCthGambar($id_cth_gambar,$name,$imgContent);
          
        //Check whether the query was successful or not
        if($result) {
          echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/spesifikasi_cth_gambar.php?id=$id_speccccs_details';
				            </script>");
          //header("location: ../view/spesifikasi_cth_gambar.php?id=$id_speccccs_details");
          exit();
        }else {
          die("Query failed");
        }
       }else {
        echo "<script type='text/javascript'>alert('Image must be less than 2MB');
            window.location.href='../view/spesifikasi_cth_gambar.php?id=.$id_speccccs_details';</script>";
       }
      }
    }else {
      echo "<script type='text/javascript'>alert('Files must be either JPEG or PNG');
            window.location.href='../view/spesifikasi_cth_gambar.php?id=.$id_speccccs_details';</script>";
    }
  }else{
    $result = updateNamaCthGambar($id_cth_gambar,$name);
          
        //Check whether the query was successful or not
        if($result){
        	echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/spesifikasi_cth_gambar.php?id=$id_speccccs_details';
				            </script>");
         //header("location: ../view/spesifikasi_cth_gambar.php?id=$id_speccccs_details");
          exit();
        }else {
          die("Query failed");
        }
    }
}else if ($action == "spesifikasi_jentera_delete"){
	 $id=($_GET['id']);
	  $id_delete=($_GET['id_delete']);

	$result =  deleteMachinery($id_delete);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/spesifikasi_cth_gambar.php?id=$id_speccccs_details';
				            </script>");
		//header("location: ../view/spesifikasi_jentera.php?id=$id");
		exit();
	}else {
		die("Query failed");
	}
}else if ($action == "spesifikasi_jentera_add"){
	 $id=($_GET['id']);
	 $machinery_id = ($_POST['machinery_id']);

	$result = addMachinery($id, $machinery_id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/spesifikasi_jentera.php?id=$id';
				            </script>");
		//header("location: ../view/spesifikasi_jentera.php?id=$id");
		exit();
	}else {
		die("Query failed");
	}

}else if ($action == "spesifikasi_jentera_update"){
	 $id=($_GET['id']);
	 $machinery_id = ($_POST['machinery_id']);

	$result = editMachinery( $machinery_id, $id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/spesifikasi_jentera.php?id=$id';
				            </script>");
		//header("location: ../view/spesifikasi_jentera.php?id=$id");
		exit();
	}else {
		die("Query failed");

	}
} else if ($action == "spesifikasi_youtube_add"){
		$id=($_GET['id']);
		$youtube_name = ($_POST['youtube_name']);
		$youtube_link = ($_POST['youtube_link']);


		$result = addYoutube($id, $youtube_name, $youtube_link);

		//Check whether the query was successful or not
		if($result) {
			echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/spesifikasi_youtube.php?id=$id';
				            </script>");
		//header("location: ../view/spesifikasi_youtube.php?id=$id");
		exit();
		}else {
		die("Query failed");
		}
	
	
} else if($action == "spesifikasi_youtube_delete"){
	$id=($_GET['id']);
	$id_youtube=($_GET['id_youtube']);
	$result =  deleteYoutube($id_youtube);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/spesifikasi_youtube.php?id=$id';
				            </script>");
		//header("location: ../view/spesifikasi_youtube.php?id=$id");
		exit();
	}else {
		die("Query failed");
	}
} else if ($action == "spesifikasi_youtube_update"){
	$id=($_GET['id']);
	 $id_youtube=($_GET['id_youtube']);
	 $youtube_link = ($_POST['youtube_link']);
	 $youtube_name = ($_POST['youtube_name']);

	$result = editYoutube($youtube_link, $youtube_name, $id_youtube);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/spesifikasi_youtube.php?id=$id';
				            </script>");
		//header("location: ../view/spesifikasi_youtube.php?id=$id");
		exit();
	}else {
		die("Query failed");
	}
}
//end nabilah

// lkp machinery
else if ($action == "spesifikasi_jentera_lkp_add"){
	 $machinery= ($_POST['machinery']);
	if (($_FILES["image"]["type"] == "image/jpeg")
	|| ($_FILES["image"]["type"] == "image/png" )) {
      if ($_FILES["image"]["error"] > 0) {
         echo "Oh no! An error has occurred.";
         echo "Error Code: " . $_FILES["image"]["error"];
	  }else {
		 if ($_FILES["image"]["size"] <= 1048576*2 ){ 
			$image = $_FILES['image']['tmp_name'];
			$imgContent = addslashes(file_get_contents($image));

	$result = addMachineryLkp($machinery, $imgContent);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/daftar_data_asas.php';
				            </script>");
		//header("location: ../view/daftar_data_asas.php");
		exit();
	}else {
		die("Query failed");
	}
}
}
}
} else if ($action == "spesifikasi_jentera_lkp_status"){
	 $id=($_GET['id']);

	$result =  updateMachineryLkp($id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/daftar_data_asas.php';
				            </script>");
		//header("location: ../view/daftar_data_asas.php");
		exit();
	}else {
		die("Query failed");
	}
} else if ($action == "spesifikasi_jentera_lkp_update"){
	$id = ($_GET['id']);
	 $machinery=($_POST['machinery']);
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

				$result = editMachineryLkp($id,$machinery, $imgContent);
				  
				//Check whether the query was successful or not
				if($result) {
					echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/daftar_data_asas.php';
				            </script>");
					//header("location: ../view/daftar_data_asas.php");
					exit();
				}else {
					die("Query failed");
				}
			 }else {
				echo "<script type='text/javascript'>alert('Image must be less than 2MB');
						window.location.href='../view/daftar_data_asas.php';</script>";
			 }
		  }
		}else {
			echo "<script type='text/javascript'>alert('Files must be either JPEG or PNG');
						window.location.href='../view/daftar_data_asas.php';</script>";
		}
	}else{
		$result =editMachineryName($id,$machinery);
				  
		//Check whether the query was successful or not
		if($result){
			echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/daftar_data_asas.php';
				            </script>");
		 //header("location: ../view/daftar_data_asas.php");
			exit();
		}else {
			die("Query failed");
		}
	}	
}
//lkp_material
else if ($action == "lkp_list"){
 $name=$_POST['name'];
  if (($_FILES["image"]["type"] == "image/jpeg")
  || ($_FILES["image"]["type"] == "image/png" )) {
      if ($_FILES["image"]["error"] > 0) {
         echo "Oh no! An error has occurred.";
         echo "Error Code: " . $_FILES["image"]["error"];
    }else {
     if ($_FILES["image"]["size"] <= 1048576*2 ){ 
      $image = $_FILES['image']['tmp_name'];
      $imgContent = addslashes(file_get_contents($image));

  $result = addMaterialLookup($name,$imgContent);

  //Check whether the query was successful or not
  if($result) {
  	echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/daftar_data_asas.php';
				            </script>");
    //header("location: ../view/daftar_data_asas.php");
    exit();
  }else {
    die("Query failed");
  }
}
}
}
}else if ($action == "spesifikasi_bahan_lkp_status"){
   $id=($_GET['id']);

  $result =  updateMaterialStatus($id);

  //Check whether the query was successful or not
  if($result) {
  	echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/daftar_data_asas.php';
				            </script>");
    //header("location: ../view/daftar_data_asas.php?id=$id");
    exit();
  }else {
    die("Query failed");
  }
}
else if ($action == "spesifikasi_bahan_lkp_update"){
  $id = ($_GET['id']);
   $name=($_POST['name']);
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

        $result = editMaterialLkp($id,$name,$imgContent);
          
        //Check whether the query was successful or not
        if($result) {
          echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/daftar_data_asas.php';
				            </script>");
          //header("location: ../view/daftar_data_asas.php?id=$id");
          exit();
        }else {
          die("Query failed");
        }
       }else {
        echo "<script type='text/javascript'>alert('Image must be less than 2MB');
            window.location.href='../view/daftar_data_asas.php';</script>";
       }
      }
    }else {
      echo "<script type='text/javascript'>alert('Files must be either JPEG or PNG');
            window.location.href='../view/daftar_data_asas.php';</script>";
    }
  }else{
    $result =editMaterialName($id,$name);
          
    //Check whether the query was successful or not
    if($result){
    	echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/daftar_data_asas.php';
				            </script>");
     //header("location: ../view/daftar_data_asas.php?id=$id");
      exit();
    }else {
      die("Query failed");
    }
  }  
}
 else if ($action == "lkp_manpower_add"){
	
	$groups=$_POST['groups'];
	$positions=$_POST['positions'];
		
	if (($_FILES["image"]["type"] == "image/jpeg") || ($_FILES["image"]["type"] == "image/png" )) {
      if ($_FILES["image"]["error"] > 0) {
         echo "Oh no! An error has occurred.";
         echo "Error Code: " . $_FILES["image"]["error"];
	  }else {
		 if ($_FILES["image"]["size"] <= 1048576*2 ){ 
			$image = $_FILES['image']['tmp_name'];
			$imgContent = addslashes(file_get_contents($image)); // gambar
			$filename = $_FILES['image']['name']; // nama asal gambar
		
			$result = addManpower($groups,$positions,$imgContent);
      
			//Check whether the query was successful or not
			if($result) {
				echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/daftar_data_asas.php';
				            </script>");
				 //header("location: ../view/daftar_data_asas.php");
				exit();
			}else {
				die("Query failed");
			}
		}
	}
	}
}else if ($action == "lkp_manpower_status"){
  $id=($_GET['id']);
   // $id_delete=($_GET['id_delete']);

  $result =  updateStatusManpower($id);

  //Check whether the query was successful or not
  if($result) {
  	echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/daftar_data_asas.php';
				            </script>");
    //header("location: ../view/daftar_data_asas.php");
    exit();
  }else {
    die("Query failed");
  }
}  

//end bai
//start dokumen (lan dan bai)
else if ($action == "dokumen_group"){
	
	$nama_group= $_POST['nama_group'];
	$nama_staf=$_POST['nama_staf'];
		$result = addGroup($nama_group,$nama_staf);
        if($result) {
        	echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/dokumen_group.php';
				            </script>");
			//header("location: ../view/dokumen_group.php");
			exit();
			
		}else {
			die("Query failed");
		}
}else if ($action == "dokumen_group_add_dokumen"){
	
	
    $id_group_dokumen= $_POST['id_group_dokumen'];
	$file_name= $_POST['file_name'];
	$namaFiles= $_POST['namaFiles']; 
  
  
  if(!empty($_FILES['file']['name'])){ //new image uploaded
    
      if ($_FILES["file"]["error"] > 0) {
       echo "Oh no! An error has occurred.";
       echo "Error Code: " . $_FILES["file"]["error"];
      }else {
       if ($_FILES["file"]["size"] <= 1048576*2 ){ 
        $file = $_FILES['file']['tmp_name'];
        $file_uploaded = addslashes(file_get_contents($file)); 
		$nama_file_upload = $namaFiles.$_FILES['file']['name'];
      // $target_file = "../../resources/items/".$nama_file_upload;
	  // move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
	  
        $result = addDokumen($id_group_dokumen,$file_name,$file_uploaded,$nama_file_upload);
          
        //Check whether the query was successful or not
        if($result) {
          echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/dokumen_group.php';
				            </script>");
         // header("location: ../view/dokumen_group.php");
          exit();
        }else {
          die("Query failed");
        }
       }else {
        echo "<script type='text/javascript'>alert('File must be less than 2MB');
            window.location.href='../view/dokumen_group.php';</script>";
       }
      }
   
  }else{
    $result = addDokumenNoFile($id_group_dokumen,$file_name);
          
        //Check whether the query was successful or not
        if($result){
        	echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/dokumen_group.php';
				            </script>");
         //header("location: ../view/dokumen_group.php");
          exit();
        }else {
          die("Query failed");
        }
  }  
}else if ($action == "dokumen_group_delete_group"){
	
	$id_group= clean($_GET['id']);
	
		$result = deleteGroup($id_group);
        if($result) {
        	echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/dokumen_group.php';
				            </script>");
			//header("location: ../view/dokumen_group.php");
			exit();
			
		}else {
			die("Query failed");
		}
}else if ($action == "dokumen_group_delete_dokumen"){
	
	$id_dokumen= clean($_GET['id']);
	
		$result = deleteDokumen($id_dokumen);
        if($result) {
        	echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/dokumen_group.php';
				            </script>");
			//header("location: ../view/dokumen_group.php");
			exit();
			
		}else {
			die("Query failed");
		}
}
else if ($action == "dokumen_group_kemaskini_group"){
	
	 $id_group_dokumen = $_POST['id_group_dokumen'];
	 $nama_group = $_POST['nama_group'];
	 $namaFiles= $_POST['namaFiles']; 

	$result = updateGroup($id_group_dokumen,$nama_group);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/dokumen_group.php';
				            </script>");
		//header("location: ../view/dokumen_group.php");
		exit();
	}else {
		die("Query failed");
	}
}else if ($action == "dokumen_group_kemaskini_dokumen"){
	
	 $id_dokumen = $_POST['id_dokumen'];
	 $file_name = $_POST['file_name'];

	
  
  if(!empty($_FILES['file']['name'])){ //new file uploaded
    
      if ($_FILES["file"]["error"] > 0) {
       echo "Oh no! An error has occurred.";
       echo "Error Code: " . $_FILES["file"]["error"];
      }else {
       if ($_FILES["file"]["size"] <= 1048576*2 ){ 
        $file = $_FILES['file']['tmp_name'];
		$namaFiles= $_POST['namaFiles']; 
        $fileUploaded = addslashes(file_get_contents($file)); 
       $nama_file_upload = $namaFiles.$_FILES['file']['name'];
	   
      // $target_file = "../../resources/items/".$nama_file_upload;
	  // move_uploaded_file($_FILES["file"]["tmp_name"], $target_file);
	  
      
        
        $result = updateDokumenWithFile($id_dokumen,$file_name,$fileUploaded,$nama_file_upload);
          
        //Check whether the query was successful or not
        if($result) {
          echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/dokumen_group.php';
				            </script>");
          //header("location: ../view/dokumen_group.php");
          exit();
        }else {
          die("Query failed");
        }
       }else {
        echo "<script type='text/javascript'>alert('Image must be less than 2MB');
            window.location.href='../view/dokumen_group.php';</script>";
       }
      }
    
  }else{
    $result = updateDokumenNoFile($id_dokumen,$file_name);
          
        //Check whether the query was successful or not
        if($result){
        	echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/dokumen_group.php';
				            </script>");
         //header("location: ../view/dokumen_group.php");
          exit();
        }else {
          die("Query failed");
        }
  }  
}else if ($action == "dokumen_group_download"){

echo $id_dokumen=$_GET['id_dokumen'];
$result = getDownloadDocument($id_dokumen) -> fetch_object();


	$file_document = $result -> document;
	echo $filename = $result -> nama_file_upload;
	header("Content-Disposition: attachment; filename=$filename");
	ob_clean();
	flush();
	echo $file_document;


}
//end
?>