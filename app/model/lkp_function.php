  <?
  require '../../lib/db/connection.php';

  $action = ($_POST['action']);
  if ($action == "lkp_tugasan_projek_edit"){
	$id=($_POST['id']);
	 $company_shortname = ($_POST['company_shortname']);
	  $category_type = ($_POST['category_type']);

	$result = editTugasanProjek($company_shortname, $category_type, $id);
} 
else if ($action == "lkp_zon_update"){
	$id=($_POST['id']);
	$zone_name = ($_POST['zone_name']);
	$zone_desc = ($_POST['zone_desc']);

	$result = editZon($zone_name, $zone_desc, $id);

} else if ($action == "lkp_category_update"){
  $id=($_POST['id']);
   $category_type = ($_POST['category_type']);
   $company_shortname = ($_POST['company_shortname']);

  $result = editCategory($category_type, $company_shortname, $id);

  echo 'Tranksaksi berjaya.';
}  
else if ($action == "lkp_supplier_update"){
  $id=($_POST['id']);
   $supplier_type = ($_POST['supplier_type']);

  $result = editSupplier($supplier_type, $id);
}
//added for lkp_config
else if ($action == "lkp_config_category"){
  //var nameArray = ["category","subcategory","item","itemkod","oum","rowid"];
  $category=strtoupper($_POST['category']);
  $subcategory = strtoupper($_POST['subcategory']);
  $item = strtoupper($_POST['item']);
  $itemkod = strtoupper($_POST['itemkod']);
  $oum = strtoupper($_POST['oum']);
  $rowid = strtoupper($_POST['rowid']);

  $conn=db();

  //check if data exists
  $sql = "select count(id) as cnt, id from lkp_config_category where category='$category' 
  AND sub_category='$subcategory' AND item_code='$itemkod' limit 1";
  $cnt = $conn->query($sql)->fetch_object();

  if($cnt->cnt == 0 || $cnt->id == $rowid){

    if($rowid > 0){
      //update
      $sql = "update lkp_config_category set category='$category', sub_category='$subcategory',
      item='$item',item_code='$itemkod',uom='$oum' where id = '$rowid' ";
      $result = $conn->query($sql);
      echo "Berjaya mengemaskini data.";
    }else{
      
        //insert new record
        $sql = "insert into lkp_config_category (category, sub_category,item,item_code,uom)
        values('$category','$subcategory','$item','$itemkod','$oum')";
        $result = $conn->query($sql);
        echo "Berjaya memasukkan data.";
      
      
    }
  }else{
    echo "Data telah wujud! Sila buat semula.";
  }

}else if ($action == "removeLkp_config_category"){
  $rowid = ($_POST['rowid']);

  if($rowid > 0){
    //update nyah aktif
    $conn=db();
    $sql = "select status from lkp_config_category where id = '$rowid' ";
    $status = $conn->query($sql)->fetch_object()->status;
    if($status == 1){
      $status = 0;
    }else{
      $status = 1;
    }

    $sql = "update lkp_config_category set status='$status' where id = '$rowid' ";
    $result = $conn->query($sql);
  }else{
    //nothing
  }
  //$result = editSupplier($supplier_type, $id);
}else if ($action == "lkp_config_stage"){
  //var nameArray = ["stage","sequence_no","task","label","rowid"];
  $stage=strtoupper($_POST['stage']);
  $sequence_no = strtoupper($_POST['sequence_no']);
  $task = strtoupper($_POST['task']);
  $label = strtoupper($_POST['label']);
  $rowid = strtoupper($_POST['rowid']);

  $conn=db();

  //check if data exists
  $sql = "select count(id) as cnt, id from lkp_config_stage where stage='$stage' 
  AND task='$task' ";
  $cnt = $conn->query($sql)->fetch_object();

  if($cnt->cnt == 0 || $cnt->id == $rowid){

    if($rowid > 0){
      //update
      $sql = "update lkp_config_stage set stage='$stage', sequence_no='$sequence_no',
      task='$task',label='$label' where id = '$rowid' ";
      $result = $conn->query($sql);
      echo "Berjaya mengemaskini data.";
    }else{
      
        //insert new record
        $sql = "insert into lkp_config_stage (stage, sequence_no,task,label)
        values('$stage','$sequence_no','$task','$label')";
        $result = $conn->query($sql);
        echo "Berjaya memasukkan data.";
      
      
    }
  }else{
    echo "Data telah wujud! Sila buat semula.";
  }

}else if ($action == "removeLkp_config_stage"){
  $rowid = ($_POST['rowid']);

  if($rowid > 0){
    //update nyah aktif
    $conn=db();
    $sql = "select status from lkp_config_stage where id = '$rowid' ";
    $status = $conn->query($sql)->fetch_object()->status;
    if($status == 1){
      $status = 0;
    }else{
      $status = 1;
    }

    $sql = "update lkp_config_stage set status='$status' where id = '$rowid' ";
    $result = $conn->query($sql);
  }else{
    //nothing
  }
  //$result = editSupplier($supplier_type, $id);
}

  function clean($str) {
		$conn=db();
        $str = @trim($str);
        if(get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }
        return mysqli_real_escape_string($conn,$str);
    }

	function getSys($sys_id) {
		$conn=db();
		$sql = "SELECT * FROM sys_setting";
		if ($sys_id!='') {
			$sql .= " WHERE sys_id='$sys_id'";
		}
		$result = $conn->query($sql);
		return $result;
	}

	function login($username,$password) {
		$conn=db();
		$sql = "SELECT * FROM staff WHERE username='$username' AND accs_pwd='$password'";
		$result = $conn->query($sql);
		return $result;
	}

	function getLogUser($com_id) {
		$conn=db();
		$sql = "SELECT * FROM staff WHERE company_id='$com_id'";
		$result = $conn->query($sql);
		return $result;
	}

//nabilah

	function getCategory() {
    $conn=db();
   $sql = "SELECT * FROM lkp_category_type";  
    $result = $conn->query($sql);
    return $result;
  }
  function getSupplier() {
    $conn=db();
   $sql = "SELECT * FROM lkp_supplier_type";  
    $result = $conn->query($sql);
    return $result;
  }
  function addSupplier($supplier_type) {
    $conn=db();
   $sql = "INSERT INTO lkp_supplier_type(type) VALUES('$supplier_type')";  
    $result = $conn->query($sql);
    return $result;
  }

  function deleteSupplier($id){
    $conn=db();
      $sql = "DELETE FROM lkp_supplier_type WHERE id='$id'";
      $result = $conn->query($sql);
    return $result;
  }

  function addCategory($category_type, $company_shortname) {
    $conn=db();
   $sql = "INSERT INTO lkp_category_type(category_type, company_shortname) VALUES('$category_type', '$company_shortname')";  
    $result = $conn->query($sql);
    return $result;
  }

  function deleteCategory($id){
    $conn=db();
      $sql = "DELETE FROM lkp_category_type WHERE id='$id'";
      $result = $conn->query($sql);
    return $result;
  }

  function editCategory($category_type, $company_shortname, $id){
		$conn=db();
      $sql = "UPDATE lkp_category_type SET category_type='$category_type', company_shortname='$company_shortname' WHERE id='$id'";
      $result = $conn->query($sql);
    return $result;
	}

	 function editSupplier($supplier_type, $id){
		$conn=db();
      $sql = "UPDATE lkp_supplier_type SET type='$supplier_type' WHERE id='$id'";
      $result = $conn->query($sql);
    return $result;
	}
//end nabilah


//start wani

	function getTugasanProjek(){
		$conn=db();
		$sql="SELECT * FROM lkp_project_task_template";

		$result = $conn->query($sql);
		return $result;
	}

	function getZon(){
		$conn=db();
		$sql="SELECT * FROM lkp_zone";

		$result = $conn->query($sql);
		return $result;
	}

	 function addTugasanProjek($company_shortname, $category_type) {
    $conn=db();
   $sql = "INSERT INTO lkp_project_task_template(company_shortname, category_type) VALUES('$company_shortname', '$category_type')";  
    $result = $conn->query($sql);
    return $result;
  }

  function deleteTugasanProjek($id){
    $conn=db();
      $sql = "DELETE FROM lkp_project_task_template WHERE id='$id'";
      $result = $conn->query($sql);
    return $result;
  }

  function addZon($zone_name, $zone_desc) {
    $conn=db();
   $sql = "INSERT INTO lkp_zone(zone_name, zone_desc) VALUES('$zone_name', '$zone_desc')";  
    $result = $conn->query($sql);
    return $result;
  }

  function deleteZon($id){
    $conn=db();
      $sql = "DELETE FROM lkp_zone WHERE id='$id'";
      $result = $conn->query($sql);
    return $result;
  }

  function editZon($zone_name, $zone_desc, $id){
		$conn=db();
      $sql = "UPDATE lkp_zone SET zone_name='$zone_name', zone_desc='$zone_desc'  WHERE id='$id'";
      $result = $conn->query($sql);
    return $result;
	}

	 function editTugasanProjek($company_shortname, $category_type, $id){
		$conn=db();
      $sql = "UPDATE lkp_project_task_template SET company_shortname='$company_shortname', category_type='$category_type' WHERE id='$id'";
      $result = $conn->query($sql);
    return $result;
	}
	
	function addSkopKerja($role, $keterangan, $com_id) {
    $conn=db();
   $sql = "INSERT INTO penawaran_jawatan_skop(role, keterangan,company_id) VALUES('$role', '$keterangan', '$com_id')";  
    $result = $conn->query($sql);
    return $result;
  }

  function deleteSkopKerja($id){
    $conn=db();
      $sql = "DELETE FROM penawaran_jawatan_skop WHERE id='$id'";
      $result = $conn->query($sql);
    return $result;
  }

  function editSkopKerja($role, $keterangan, $id){
		$conn=db();
      $sql = "UPDATE penawaran_jawatan_skop SET role='$role',keterangan='$keterangan' WHERE id='$id'";
      $result = $conn->query($sql);
    return $result;
	}
	
	function getSkopKerja(){
		$conn=db();
		$sql="SELECT * FROM penawaran_jawatan_skop order by id DESC";
		$result = $conn->query($sql);
		return $result;
	}
	
	
	function getPrintSkopKerja($skopid) {
    $conn=db();
    $sql = "
    SELECT id,role,keterangan,status,DATE(created_date) as created_date,company_id 
    FROM penawaran_jawatan_skop 
    WHERE id='$skopid'";
    $result = $conn->query($sql);
    return $result;
  }
  
  function getCompany($id) {
		$conn=db();
		$sql = "SELECT * FROM company WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getMonthString($num)
    {

          
      switch($num)
      {
        case 1:
          $month="Januari";
          break;
        case 2:
          $month="Februari";
          break;
        case 3:
          $month="Mac";
          break;
        case 4:
          $month="April";
          break;
        case 5:
          $month="Mei";
          break;
        case 6:
          $month="Jun";
          break;
        case 7:
          $month="Julai";
          break;
        case 8:
          $month="Ogos";
          break;
        case 9:
          $month="September";
          break;
        case 10:
          $month="Oktober";
          break;
        case 11:
          $month="November";
          break;
        case 12:
          $month="Disember";
          break;
        default:
          $month="Invalid month";
      }
      return $month;
    }
	
    function getLkpConfigCategory() {
        $conn=db();
        $sql = "SELECT * FROM lkp_config_category order by id desc";
        $result = $conn->query($sql);
        return $result;
    }
    
    function getLkpConfigStage() {
        $conn=db();
        $sql = "SELECT * FROM lkp_config_stage order by label ASC,sequence_no ASC";
        $result = $conn->query($sql);
        return $result;
    }
    
    //department
    if($action == "department_list_update"){
		 $department_id = $_POST['id'];
		 $code_department =$_POST['code_department'];
		 $description =$_POST['description'];
		 $leave_approval =$_POST['leave_approval'];

		$result = updateDepartment($department_id,$code_department, $description, $leave_approval);
	}
    function getNoStaff() {
    $conn=db();
	   $sql = "SELECT no_staff, name FROM staff
				WHERE status='BEKERJA' AND noic IS NOT NULL
				ORDER BY no_staff ASC";  
    $result = $conn->query($sql);
    return $result;
  }
  
	 function getDepartmentList($status) {
    $conn=db();
	 $sql = "SELECT d.*,s.name FROM department d
			LEFT JOIN staff s ON d.leave_approval=s.no_staff
			WHERE d.status = $status
			ORDER BY id DESC";  
    $result = $conn->query($sql);
    return $result;
  }

  function addDepartment($code_department, $description, $leave_approval){
      $conn=db();
      $sql2 = "SELECT * FROM department WHERE code_department='$code_department'";
      $check = $conn->query($sql2);
      if($check->num_rows > 0 ){
          return false;
      }

      $sql = "INSERT INTO department (code_department, description, leave_approval) 
					VALUES ('$code_department', '$description', '$leave_approval')";
      $conn->query($sql);
      return $conn->insert_id;
  }
	
	function  updateStatusDepartment($status,$department_id) {
		$conn=db();
	    $sql = "UPDATE department SET status = '$status' WHERE id='$department_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function updateDepartment($department_id,$code_department, $description, $leave_approval){
		$conn=db();
		//checking - no staff telah wujud pada tahun tersebut
		 $sql2 = "SELECT * FROM department WHERE code_department='$code_department' AND id!='$department_id'";
		$check = $conn->query($sql2);
		if($check->num_rows > 0 ){
			echo ("<script LANGUAGE='JavaScript'>
					window.alert('Kemaskini tidak berjaya. Data telah wujud.');
					window.location.href='../view/department_list.php?status=1&flagScreen=tab_1';
					</script>");
		}else{
		$sql = "UPDATE department SET code_department='$code_department', description='$description', leave_approval='$leave_approval' 
				WHERE id='$department_id'";
		$result = $conn->query($sql);
		return $result;
		}
		
	}
	//sub department
    if($action == "sub_department_list_update"){
		 $sub_department_id = $_POST['id'];
		 $code_department =$_POST['code_department'];
		 $description =$_POST['description'];
		 $sub_code_department=$_POST['sub_code_department'];

		$result = updateSubDepartment($sub_department_id,$code_department, $description, $sub_code_department);
	}
	function getSubDepartmentList($status) {
    $conn=db();
	 $sql = "SELECT * FROM department_sub
			WHERE status = $status
			ORDER BY id DESC";  
    $result = $conn->query($sql);
    return $result;
  }
  function addSubDepartment($code_department, $description, $sub_code_department){
		$conn=db();
		//checking - no staff telah wujud pada tahun tersebut
		$sql2 = "SELECT * FROM department_sub WHERE code_sub_department='$sub_code_department'";
		$check = $conn->query($sql2);
		if($check->num_rows > 0 ){
			echo ("<script lANGUAGE='JavaScript'>
			window.alert('Tambah data tidak berjaya. Data telah wujud.');
			window.location.href='../view/sub_department_list.php?status=1&flagScreen=tab_3';
			</script>");
		}else{
		 $sql = "INSERT INTO department_sub (code_sub_department, description, code_department) 
					VALUES ('$sub_code_department', '$description', '$code_department')";
		$result = $conn->query($sql);
		}
		return $result;
	}
	function  updateStatusSubDepartment($status,$sub_department_id) {
		$conn=db();
	    $sql = "UPDATE department_sub SET status = '$status' WHERE id='$sub_department_id'";
		$result = $conn->query($sql);
		return $result;
	}
	function updateSubDepartment($sub_department_id,$code_department, $description, $sub_code_department){
		$conn=db();
		//checking - no staff telah wujud pada tahun tersebut
		 $sql2 = "SELECT * FROM department_sub WHERE code_sub_department='$sub_code_department' AND id!='$sub_department_id'";
		$check = $conn->query($sql2);
		if($check->num_rows > 0 ){
			echo ("<script LANGUAGE='JavaScript'>
					window.alert('Kemaskini tidak berjaya. Data telah wujud.');
					window.location.href='../view/sub_department_list.php?status=1&flagScreen=tab_3';
					</script>");
		}else{
		$sql = "UPDATE department_sub SET code_sub_department='$sub_code_department', description='$description', code_department='$code_department' 
				WHERE id='$sub_department_id'";
		$result = $conn->query($sql);
		return $result;
		}
		
	}
  //lokasi
    if($action == "lokasi_list_update"){
     $lokasi_id = $_POST['id'];
     $cawangan_kod =$_POST['cawangan_kod'];
     $nama =$_POST['nama'];
    $result = updateLokasi($lokasi_id,$cawangan_kod, $nama);
  }
   function getLokasiList($status) {
    $conn=db();
   $sql = "SELECT * FROM lkp_cawangan
      WHERE status = $status
      ORDER BY id DESC";  
    $result = $conn->query($sql);
    return $result;
  }
  function addLokasi($cawangan_kod, $nama){
    $conn=db();
    //checking - no staff telah wujud pada tahun tersebut
    $sql2 = "SELECT * FROM lkp_cawangan WHERE cawangan_kod='$cawangan_kod'";
    $check = $conn->query($sql2);
    if($check->num_rows > 0 ){
      echo ("<script lANGUAGE='JavaScript'>
      window.alert('Tambah data tidak berjaya. Data telah wujud.');
      window.location.href='../view/lokasi_list.php?status=1&flagScreen=tab_2';
      </script>");
    }else{
     $sql = "INSERT INTO lkp_cawangan (cawangan_kod, nama) 
          VALUES ('$cawangan_kod', '$nama')";
    $result = $conn->query($sql);
    }
    return $result;
  }
  function  updateStatusLokasi($status,$lokasi_id) {
    $conn=db();
      $sql = "UPDATE lkp_cawangan SET status = '$status' WHERE id='$lokasi_id'";
    $result = $conn->query($sql);
    return $result;
  }
  function updateLokasi($lokasi_id,$cawangan_kod, $nama){
    $conn=db();
    //checking - no staff telah wujud pada tahun tersebut
     $sql2 = "SELECT * FROM lkp_cawangan WHERE cawangan_kod='$cawangan_kod' AND id!='$lokasi_id'";
    $check = $conn->query($sql2);
    if($check->num_rows > 0 ){
      echo ("<script LANGUAGE='JavaScript'>
          window.alert('Kemaskini tidak berjaya. Data telah wujud.');
          window.location.href='../view/lokasi_list.php?status=1&flagScreen=tab_2';
          </script>");
    }else{
    $sql = "UPDATE lkp_cawangan SET cawangan_kod='$cawangan_kod', nama='$nama'
        WHERE id='$lokasi_id'";
    $result = $conn->query($sql);
    return $result;
    }
    
  }
	
?>