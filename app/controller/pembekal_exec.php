<?
	include "../model/pembekal_function.php";

	$action = ($_GET['act']);

	//pembekal
if($action == "pembekal_add"){
	$nama_syarikat = ($_POST['nama_syarikat']);
	$short_name = ($_POST['short_name']);
	$person_incharge = ($_POST['person_incharge']);
	$supplier_code = ($_POST['supplier_code']);
	$address1 = ($_POST['address1']);
	$address2 = ($_POST['address2']);
	$district = ($_POST['district']);
	$city = ($_POST['city']);
	$state = ($_POST['state']);
	$country = ($_POST['country']);
	$contact_no = ($_POST['contact_no']);
	$fax_no = ($_POST['fax_no']);
	$official_email = ($_POST['official_email']);
	$dept_email = ($_POST['dept_email']);
	$facebook_id = ($_POST['facebook_id']);
	$bank = ($_POST['bank']);
	$account_no = ($_POST['account_no']);
	$zone = implode(',',$_POST['zone']);
	$type =implode (',', $_POST['type']);

		 $newId =addPembekal($nama_syarikat, $short_name, $person_incharge, $supplier_code, $address1,$address2,$district,$city,$state,$country,$contact_no,$fax_no,$official_email,$dept_email,$facebook_id,$bank,$account_no,$zone, $type);
	
	//Check whether the query was successful or not
	if($newId) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/pembekal_list.php';
            </script>");
		//header("location: ../view/pembekal_list.php");
		exit();
	}else {
		die("Query failed");
	}
}

else if($action == "pembekal_edit"){
	$id = ($_POST['id']);
	$nama_syarikat = ($_POST['nama_syarikat']);
	$short_name = ($_POST['short_name']);
	$person_incharge = ($_POST['person_incharge']);
	$supplier_code = ($_POST['supplier_code']);
	$address1 = ($_POST['address1']);
	$address2 = ($_POST['address2']);
	$district = ($_POST['district']);
	$city = ($_POST['city']);
	$state = ($_POST['state']);
	$country = ($_POST['country']);
	$contact_no = ($_POST['contact_no']);
	$fax_no = ($_POST['fax_no']);
	$official_email = ($_POST['official_email']);
	$dept_email = ($_POST['dept_email']);
	$facebook_id = ($_POST['facebook_id']);
	$bank = ($_POST['bank']);
	$account_no = ($_POST['account_no']);
	$zone = implode(',',$_POST['zone']);
	$type =implode (',', $_POST['type']);

	$result = editPembekal($nama_syarikat, $short_name, $person_incharge, $supplier_code, $address1,$address2,$district,$city,$state,$country,$contact_no,$fax_no,$official_email,$dept_email,$facebook_id,$bank,$account_no, $zone, $type, $id);
  

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/pembekal_detail.php?id=$id';
            </script>");
		//header("location: ../view/pembekal_detail.php?id=$id");
	exit();
	}
	else
	 {
		die("Query failed");
	}
}
else if ($action == "pembekal_delete"){
	
 $id=($_GET['id']);


		 $newId =deletePembekal($id);
	
	
if($newId > 0){
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/pembekal_list.php';
            </script>");
			//header("location: ../view/pembekal_list.php");
			exit();
		}else
	 {
		die("Query failed");
	}
	}

?>