<?
	include "../model/lkp_function.php";

 $action = ($_GET['act']);


//START NABILAH
if ($action == "lkp_supplier_add"){
  $supplier_type = ($_POST['supplier_type']);

  $result = addSupplier($supplier_type);

  //Check whether the query was successful or not
  if($result) {
  	echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/lkp_supplier_type.php';
            </script>");
    //header("location: ../view/lkp_supplier_type.php");
    exit();
  }else {
    die("Query failed");
  }

}else if($action == "lkp_supplier_delete"){
  $id=($_GET['id']);

  $result =  deleteSupplier($id);

  //Check whether the query was successful or not
  if($result) {
  	echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/lkp_supplier_type.php';
            </script>");
    //header("location: ../view/lkp_supplier_type.php");
    exit();
  }else {
    die("Query failed");
  }
}else if($action == "lkp_category_delete"){
  $id=($_GET['id']);

  $result =  deleteCategory($id);

  //Check whether the query was successful or not
  if($result) {
  	echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/lkp_category.php';
            </script>");
    //header("location: ../view/lkp_category.php");
    exit();
  }else {
    die("Query failed");
  }
}else if ($action == "lkp_category_add"){
  $category_type = ($_POST['category_type']);
  $company_shortname = ($_POST['company_shortname']);

  $result = addCategory($category_type, $company_shortname);

  //Check whether the query was successful or not
  if($result) {
  	echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/lkp_category.php';
            </script>");
    //header("location: ../view/lkp_category.php");
    exit();
  }else {
    die("Query failed");
  }

} else if ($action == "lkp_category_update"){
  $id=($_GET['id']);
   $category_type = ($_POST['category_type']);
   $company_shortname = ($_POST['company_shortname']);

  $result = editCategory($category_type, $company_shortname, $id);

  //Check whether the query was successful or not
  if($result) {
  	echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/lkp_category.php';
            </script>");
    //header("location: ../view/lkp_category.php");
    exit();
  }else {
    die("Query failed");
  }
} else if ($action == "lkp_supplier_update"){
  $id=($_GET['id']);
   $supplier_type = ($_POST['supplier_type']);

  $result = editSupplier($supplier_type, $id);

  //Check whether the query was successful or not
  if($result) {
  	echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/lkp_supplier_type.php';
            </script>");
   // header("location: ../view/lkp_supplier_type.php");
    exit();
  }else {
    die("Query failed");
  }
}
//END NABILAH
//START WANI
else if ($action == "lkp_tugasan_projek_add"){
	$company_shortname = ($_POST['company_shortname']);
	$category_type = ($_POST['category_type']);

	$result = addTugasanProjek($company_shortname, $category_type);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/lkp_tugasan_projek.php';
            </script>");
		//header("location: ../view/lkp_tugasan_projek.php");
		exit();
	}else {
		die("Query failed");
	}

} else if ($action == "lkp_tugasan_projek_edit"){
	$id=($_GET['id']);
	 $company_shortname = ($_POST['company_shortname']);
	  $category_type = ($_POST['category_type']);

	$result = editTugasanProjek($company_shortname, $category_type, $id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/lkp_tugasan_projek.php';
            </script>");
		//header("location: ../view/lkp_tugasan_projek.php");
		exit();
	}else {
		die("Query failed");
	}
} else if($action == "lkp_tugasan_projek_delete"){
	$id=($_GET['id']);

	$result =  deleteTugasanProjek($id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/lkp_tugasan_projek.php';
            </script>");
		//header("location: ../view/lkp_tugasan_projek.php");
		exit();
	}else {
		die("Query failed");
	}
}else if ($action == "lkp_zon_add"){
	$zone_name = ($_POST['zone_name']);
	$zone_desc = ($_POST['zone_desc']);

	$result = addZon($zone_name, $zone_desc);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/lkp_zon.php';
            </script>");
		//header("location: ../view/lkp_zon.php");
		exit();
	}else {
		die("Query failed");
	}

} else if ($action == "lkp_zon_update"){
	$id=($_GET['id']);
	$zone_name = ($_POST['zone_name']);
	$zone_desc = ($_POST['zone_desc']);

	$result = editZon($zone_name, $zone_desc, $id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/lkp_zon.php';
            </script>");
		//header("location: ../view/lkp_zon.php");
		exit();
	}else {
		die("Query failed");
	}
} else if($action == "lkp_zon_delete"){
	$id=($_GET['id']);

	$result =  deleteZon($id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/lkp_zon.php';
            </script>");
		//header("location: ../view/lkp_zon.php");
		exit();
	}else {
		die("Query failed");
	}
}

//END WANI
?>