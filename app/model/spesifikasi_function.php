<?php

require '../../lib/db/connection.php';


//nabilah
$action = ($_POST['action']);
if ($action == "spesifikasi_jentera_update"){
	 $id_machinery=($_POST['id_machinery']);
	 $id_specs_machinery = ($_POST['id_specs_machinery']);

	$result = editMachinery( $id_machinery, $id_specs_machinery);
}

// Function to sanitize values received from the form. Prevents SQL injection
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
		$sql = "SELECT s.*,c.short_name FROM sys_setting s LEFT JOIN company c ON c.sys_id=s.sys_id WHERE s.sys_id='$sys_id'";
		$result = $conn->query($sql);
		return $result;
	}

	function getCompany() {
		$conn=db();
		$sql = "SELECT * FROM company";
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

	function getMachinery(){
		$conn=db();
		$sql = "SELECT * FROM machinery";
		$result = $conn->query($sql);
		return $result;
	}

	function getMachineryDetail($id) {
    $conn=db();
   $sql = "SELECT sm.*, sd.name AS detail_name, m.name AS machinery_name 
   FROM specs_machinery sm 
   LEFT JOIN specs_details sd ON sm.id_specs_details=sd.id 
   LEFT JOIN machinery m ON sm.id_machinery=m.id 
    WHERE sm.id_specs_details='$id'
   ";  
    $result = $conn->query($sql);
    return $result;
  }

  function getVideoDetail($id) {
    $conn=db();
   $sql = "SELECT sy.*, sd.name AS detail_name
FROM specs_youtube sy
   LEFT JOIN specs_details sd ON sy.id_specs_details=sd.id 
   WHERE sy.id_specs_details='$id'
   ";  
    $result = $conn->query($sql);
    return $result;
  }
  

  function deleteMachinery($id_delete){
    $conn=db();
      $sql = "DELETE FROM specs_machinery WHERE id='$id_delete'";
      $result = $conn->query($sql);
    return $result;
  }

	function addMachinery($id, $machinery_id){
		$conn=db();
		$sql = "INSERT INTO specs_machinery (id_specs_details, id_machinery) VALUES ('$id', '$machinery_id')";
		$result = $conn->query($sql);
		return $result;
	}

	function editMachinery($machinery_id,$id){
		$conn=db();
		$sql = "UPDATE specs_machinery SET id_machinery='$machinery_id' WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}

	function addYoutube($id,$youtube_name, $youtube_link){
		$conn=db();
		$sql = "INSERT INTO specs_youtube (id_specs_details, youtube_name, youtube_link) VALUES ('$id', '$youtube_name', '$youtube_link')";
		$result = $conn->query($sql);
		return $result;
	}

	function deleteYoutube($id_youtube){
		$conn=db();
      $sql = "DELETE FROM specs_youtube WHERE id='$id_youtube'";
      $result = $conn->query($sql);
    return $result;
	}


	function editYoutube($youtube_link, $youtube_name, $id_youtube){
		$conn=db();
      $sql = "UPDATE specs_youtube SET youtube_link='$youtube_link', youtube_name='$youtube_name' WHERE id='$id_youtube'";
      $result = $conn->query($sql);
    return $result;
	}

	function getYoutubeInfo($video_id) {
		$conn=db();
		$sql = "SELECT * FROM specs_youtube WHERE id='$video_id'" ;
		$result = $conn->query($sql);
		return $result;
	}
	//end nabilah
//thirah-------------
	  function getSpesifikasiList() {
    $conn=db();
    $sql = "SELECT * FROM specs_details WHERE status='1'
    ";
    $result = $conn->query($sql);
    return $result;
  }


  function addNamaSpesifikasi($name) {
    $conn=db();
    $sql = "INSERT INTO specs_details (name,status) VALUES ('$name','1')
";	
    $result = $conn->query($sql);
    return $conn->insert_id;
  }


    function getNamaSpesifikasiById($id) {
    $conn=db();
    $sql = "SELECT * FROM specs_details WHERE id='$id'
    ";
    $result = $conn->query($sql);
    return $result;
  }

    function updateNamaSpesifikasi($name,$id) {
    $conn=db();
    $sql = "UPDATE specs_details SET name='$name' WHERE id='$id'
    ";
    $result = $conn->query($sql);
    return $result;
  }
//----------------Bai-------------------------------------------------------------------------------------------------------------//
	function getContohGambar($id){
		$conn = db();
		$sql = "select sp.* from specs_photos sp 
left join specs_details sd 
ON sp.id_specs_details = sd.id WHERE sd.id = '$id'";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
		
	}
	
		function getTajukGambar($id){
		$conn = db();
		$sql = "SELECT sd.id,sd.name AS nama_spec,sd.status,sd.created_date,sp.id,sp.name,sp.photos FROM`specs_details` sd
		LEFT JOIN `specs_photos` sp
		ON sd.id = sp.id_specs_details
		WHERE sd.id = '$id'
		GROUP BY sd.name
		";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
		
	}	
		function addGambarBarang($id_specs_details,$name,$imgContent){
		$conn=db();
		
		$sql = "INSERT INTO specs_photos (id_specs_details,name,photos)
					 VALUES ('$id_specs_details','$name','$imgContent')";
		$result = $conn->query($sql) or die($conn->error);
	
		return $result;
		
	}	
		function getCth_gambar($id){
		$conn = db();
		$sql = "SELECT sd.id,sd.name AS nama_spec,sd.status,sd.created_date,sp.id,sp.name,sp.photos FROM`specs_details` sd
		LEFT JOIN `specs_photos` sp
		ON sd.id = sp.id_specs_details
		GROUP BY sd.name
		";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
		
	}
	function deleteCthGambar($id) {
    $conn=db();
    $sql = "DELETE FROM specs_photos WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;
    }
	
  function updateAllCthGambar($id_cth_gambar,$name,$imgContent) {
  $conn=db();
     $sql = "UPDATE specs_photos SET name='$name',photos='$imgContent'
    WHERE id='$id_cth_gambar'";
  $result = $conn->query($sql) or die($conn->error);
  return $result;
  }
  
  //jika user tak tukar gambar
  function updateNamaCthGambar($id_cth_gambar,$name) {
  $conn=db();
   $sql = "UPDATE specs_photos SET name='$name'
    WHERE id='$id_cth_gambar'";
  $result = $conn->query($sql) or die($conn->error);
  return $result;
  }
	
//------------/.Bai------------------------------------------------------------------------------------------------------------
	//edit bary ajax action
	if ($action=="editSpecCheclist") {
		$details = $_POST['details'];
		$id_specs_details = $_POST['id_specs_details'];
		$cheklist_id = $_POST['cheklist_id'];
		$conn=db();
		
		if($cheklist_id > 0 ){
			$sql = "update specs_checklist set details='$details' where id='$cheklist_id' ";
			$result = $conn->query($sql) or die($conn->error);
			echo "Data berjaya diproses";
		}else{
			$sql = "insert into specs_checklist (id_specs_details,details) 
			values('$id_specs_details','$details')";
			$result = $conn->query($sql) or die($conn->error);

			echo "Data berjaya diproses";
			
			
		}

	}
	if ($action=="removeSpecCheclist") {
		$cheklist_id = $_POST['cheklist_id'];
		$conn=db();
		
		$sql = "delete from specs_checklist where id='$cheklist_id' ";
		$result = $conn->query($sql) or die($conn->error);
		echo "Data berjaya dipadam";
		

	}
	//end edit bary ajax action
//edit by Bary 
	function getSpecChecklists($id_specs_details) {
		$conn=db();
		$sql = "SELECT * FROM specs_checklist WHERE id_specs_details='$id_specs_details'";
		$result = $conn->query($sql);
		return $result;
	}
//end edit by Bary 
//---------- Lan-----------
	function getDrawingList($id_specs_details) {
		$conn=db();
		$sql = "SELECT * FROM specs_drawing 
				WHERE id_specs_details='$id_specs_details'
				ORDER BY id ASC";
		$result = $conn->query($sql);
		return $result;
	}
	
	function addDrawing($id_specs_details,$nama,$imgContent) {
	$conn=db();
		
		$sql = "INSERT INTO specs_drawing (id_specs_details,name,photos)
				VALUES ('$id_specs_details','$nama','$imgContent')";
		$result = $conn->query($sql) or die($conn->error);
	
		return $result;
	}
	
	function updateLukisanGambar($id_lukisan,$nama,$imgContent) {
		$conn=db();
		$sql = "UPDATE specs_drawing SET name='$nama',photos='$imgContent'
				WHERE id='$id_lukisan'";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}
	
	//jika user tak tukar gambar
	function updateLukisan($id_lukisan,$nama) {
		$conn=db();
		$sql = "UPDATE specs_drawing SET name='$nama'
				WHERE id='$id_lukisan'";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}
	
	function deleteLukisan($id) {
		$conn=db();
		$sql = "DELETE FROM specs_drawing WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	//---------- /.Lan-----------	
//----------------------- Syazwani --------------------------------//
	function getDimensi($id_specs_details){
		$conn=db();
		$sql="SELECT sdi.* 
		FROM specs_dimension sdi 
		LEFT JOIN specs_details sd ON sdi.id_specs_details=sd.id 
		WHERE sdi.id_specs_details='id_specs_details'";

		$result = $conn->query($sql);
		return $result;
}
	// }WHERE sdi.id_specs_details='$id_specs_details'

	function getDimensiDetails(){
		$conn=db();
		$sql="SELECT * FROM specs_dimension sdi 
		LEFT JOIN specs_details sd ON sdi.id_specs_details=sd.id";

		$result = $conn->query($sql);
		return $result;

	}

	function addDimensi($id, $details){
	    $conn=db();
	    $sql = "INSERT INTO specs_dimension (id_specs_details, details) VALUES ('$id','$details')";

	    $result = $conn->query($sql);
	    return $result;
	}

	function editDimensi($details, $id) {
		$conn=db();
		$sql = "UPDATE specs_dimension SET details='$details' WHERE id='$id'" ;
		
		$result = $conn->query($sql);
		return $result;
    }

	function deleteDimensi($id){
	    $conn=db();
	    $sql = "DELETE FROM specs_dimension WHERE id='$id'";
	    
	    $result = $conn->query($sql);
	    return $result;
	}

	function getBahan(){
		$conn=db();
		$sql="SELECT * FROM material";

		$result = $conn->query($sql);
	    return $result;

	}

	function getBahanList($id){
		$conn=db();
		$sql="SELECT sm.*, m.*
FROM specs_material sm
LEFT JOIN material m ON sm.id_material=m.id WHERE sm.id='$id'";

		$result = $conn->query($sql);
	    return $result;

	}

	function getBahanDetails($id_specs_details){
		$conn=db();
		$sql="SELECT sm.*, m.name
		FROM specs_material sm
		LEFT JOIN material m ON sm.id_material=m.id 
		WHERE sm.id_specs_details='$id_specs_details'";

		$result = $conn->query($sql);
	    return $result;

	}

	function addBahan($id, $name){
	    $conn=db();
	    $sql = "INSERT INTO specs_material (id_specs_details, id_material) VALUES ('$id','$name')";

	    $result = $conn->query($sql);
	    return $result;
	}

	function editBahan($id_material, $id) {
		$conn=db();
		$sql = "UPDATE specs_material SET id_material='$id_material' WHERE id='$id'" ;
		
		$result = $conn->query($sql) or die($conn->error);
		return $result;
    }

	function deleteBahan($id_bahan){
	    $conn=db();
	    $sql = "DELETE FROM specs_material WHERE id='$id_bahan'";
	    
	    $result = $conn->query($sql);
	    return $result;
	}

	function getPelanTapak($projek_id) {
    $conn=db();
   $sql = "SELECT project_site_plan FROM project WHERE id = '$projek_id' ";  
    $result = $conn->query($sql);
    return $result->fetch_object()->project_site_plan;
  }

  //nabilah
$action = ($_POST['action']);
if ($action == "spesifikasi_jentera_update"){
	 $id_machinery=($_POST['id_machinery']);
	 $id_specs_machinery = ($_POST['id_specs_machinery']);

	$result = editMachinery( $id_machinery, $id_specs_machinery);

}else if ($action == "spesifikasi_jentera_lkp_update"){
	$id = ($_POST['id']);
	$machinery=($_POST['machinery']);
	$image = $_FILES['image']['tmp_name'];
	$imgContent = addslashes(file_get_contents($image)); // gambar
	//echo $filename = $_FILES['image']['name'];
	$result = editMachineryLkp($id,$machinery, $imgContent);
	} else if ($action == "spesifikasi_bahan_lkp_update"){
  $id = ($_POST['id']);
   $name=($_POST['name']);
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image)); // gambar

        $result = editMaterialLkp($id,$name, $imgContent);
          }else if($action == "lkp_manpower_update"){
      $id = ($_POST['id']);
   $groups=($_POST['groups']);
   $positions=($_POST['positions']); 
        $image = $_FILES['image']['tmp_name'];
        $imgContent = addslashes(file_get_contents($image)); // gambar

        $result = updateManpowerPhotos($groups,$positions,$imgContent,$id);
    }

//lkp
	function getMachineryLookup() {
    $conn=db();
   $sql = "SELECT * FROM lkp_machinery
   ORDER BY created_date DESC";  
    $result = $conn->query($sql);
    return $result;
  }
	
	function addMachineryLkp($machinery, $imgContent){
		$conn=db();
	 $sql = "INSERT INTO lkp_machinery (name, photos) VALUES ('$machinery', '$imgContent')";
		$result = $conn->query($sql);
		return $result;
	}

	function updateMachineryLkp($id){
		$conn=db();
      $sql = "UPDATE lkp_machinery SET status='0' WHERE id='$id'";
      $result = $conn->query($sql);
    return $result;
	}

	function editMachineryLkp($id, $machinery, $imgContent){
		$conn=db();
		 $sql = "UPDATE lkp_machinery SET name='$machinery', photos='$imgContent' WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}

	// function editMachineryName($id,$machinery) {
	// 	$conn=db();
	// 	$sql = "UPDATE lkp_machinery SET name='$machinery' WHERE id='$id'";
	// 	$result = $conn->query($sql) or die($conn->error);
	// 	return $result;
	// }

	//lkp_material
function getMaterialLookup(){ // get list bahan
	    $conn=db();
	    $sql = "SELECT * FROM lkp_material
	    ORDER BY created_date DESC";
	    
	    $result = $conn->query($sql);
	    return $result;
	}

	function addMaterialLookup($name,$imgContent) { // Add bahan
		$conn=db();
		$sql = "INSERT INTO lkp_material (name,photos)
		VALUES ('$name','$imgContent')";
		
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	function updateMaterialLookup($name,$imgContent) { // Update Bahan 
		$conn=db();
		$sql = "UPDATE lkp_material SET name='$name',photos='$imgContent'
		WHERE id='$id'";

		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}
	

	function updateMaterialStatus($id) { // Update Status 1-AKTIF and 0-TIDAK AKTIF
		$conn=db();
		$sql = "UPDATE lkp_material SET status='0'
		WHERE id='$id'";

		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	function editMaterialLkp($id, $name, $imgContent){ // Edit nama dan gambar
    $conn=db();
    $sql = "UPDATE lkp_material SET name='$name', photos='$imgContent'
    WHERE id='$id'";
    
    $result = $conn->query($sql);
    return $result;
  }

  function editMaterialName($id,$name) { // Edit nama sahaja
    $conn=db();
    $sql = "UPDATE lkp_material SET name='$name' WHERE id='$id'";
    $result = $conn->query($sql) ;
    return $result;
  }
     function getManpower(){
        $conn=db();
        $sql="SELECT groups FROM lkp_manpower";

        $result = $conn->query($sql);
        return $result;

    }

      function getManpowerById($id){
        $conn=db();
        $sql="SELECT * FROM lkp_manpower WHERE id='$id'";

        $result = $conn->query($sql);
        return $result;

    }
function addManpower($groups,$positions,$imgContent){

      $conn=db();
        $sql = "
                INSERT INTO lkp_manpower 
                (groups,positions,photos) 
                VALUES ('$groups','$positions','$imgContent')";

        $result = $conn->query($sql);
        return $result;
}

 function getManpowerList(){
        $conn=db();
        $sql="SELECT * FROM lkp_manpower";

        $result = $conn->query($sql);
        return $result;

    }
  // function updateManpower($groups,$positions,$id) {
  //   $conn=db();
  //   $sql = "UPDATE lkp_manpower SET groups='$groups',positions='$positions' WHERE id='$id'
  //   ";

  //   $result = $conn->query($sql);
  //   return $result;
  // }
   function updateManpowerPhotos($groups,$positions,$imgContent,$id) {
    $conn=db();
    $sql = "UPDATE lkp_manpower SET groups='$groups',positions='$positions',photos='$imgContent' WHERE id='$id'
    ";

    $result = $conn->query($sql);
    return $result;
  }
   function updateStatusManpower($id) {
    $conn=db();
    $sql = "UPDATE lkp_manpower SET status='0' WHERE id='$id'
    ";
    $result = $conn->query($sql);
    return $result;
  }
//end wani
//start Group dokumen (lan dan bai)
	function addGroup($nama_group,$nama_staf){
	    $conn=db();
	    $sql = "INSERT INTO group_dokumen (nama_group,created_by) VALUES ('$nama_group','$nama_staf')";

	    $result = $conn->query($sql);
	    return $result;
	}
	function getKumpulan(){
		$conn=db();
		 $sql = "SELECT * FROM group_dokumen";

		$result = $conn->query($sql);
	 	return $result;
	}
	function getDokumen($id_group_dokumen,$file_name){
		$conn=db();
		$sql = "SELECT * FROM dokumen_rujukan
		WHERE id_group_dokumen='$id_group_dokumen'
		AND file_name LIKE '%$file_name%'";

		$result = $conn->query($sql);
	 	return $result;
	}
	
		function addDokumen($id_group_dokumen,$file_name,$file_uploaded,$nama_file_upload){
	    $conn=db();
	    $sql = "INSERT INTO dokumen_rujukan (id_group_dokumen,file_name,document,nama_file_upload) VALUES ('$id_group_dokumen','$file_name','$file_uploaded','$nama_file_upload')";
	    $result = $conn->query($sql);
	    return $result;
	}
	function addDokumenNoFile($id_group_dokumen,$file_name){
	    $conn=db();
	    $sql = "INSERT INTO dokumen_rujukan (id_group_dokumen,file_name) VALUES ('$id_group_dokumen','$file_name')";

	    $result = $conn->query($sql);
	    return $result;
	}
	function deleteDokumen($id_dokumen){
	    $conn=db();
	    $sql = "DELETE FROM dokumen_rujukan WHERE id='$id_dokumen'";
	    
	    $result = $conn->query($sql);
	    return $result;
	}
	
	function deleteGroup($id_group){
	    $conn=db();
		 $sql1 = "DELETE FROM dokumen_rujukan WHERE id_group_dokumen='$id_group'";
		 $result1 = $conn->query($sql1);
	    $sql2 = "DELETE FROM group_dokumen WHERE id='$id_group'";
	    
	    $result2 = $conn->query($sql2);
	    return $result2;
	}
	function updateGroup($id_group_dokumen,$nama_group) {
		$conn=db();
		$sql = "UPDATE group_dokumen SET nama_group='$nama_group' WHERE id='$id_group_dokumen'" ;
		
		$result = $conn->query($sql) or die($conn->error);
		return $result;
    }
	function updateDokumenWithFile($id_dokumen,$file_name,$fileUploaded,$nama_file_upload) {
		$conn=db();
		$sql = "UPDATE dokumen_rujukan SET file_name='$file_name',document='$fileUploaded',nama_file_upload='$nama_file_upload' WHERE id='$id_dokumen'" ;
		
		$result = $conn->query($sql) or die($conn->error);
		return $result;
    }
	function updateDokumenNoFile($id_dokumen,$file_name) {
		$conn=db();
		$sql = "UPDATE dokumen_rujukan SET file_name='$file_name' WHERE id='$id_dokumen'" ;
		
		$result = $conn->query($sql) or die($conn->error);
		return $result;
    }
	function getDownloadDocument($id_dokumen){
	  $conn=db();
	  $sql="SELECT * FROM dokumen_rujukan
	  WHERE id='$id_dokumen'";
	  $result = $conn->query($sql); 
	  return $result;
	}
	
	function mimetype($data){
    //File signatures with their associated mime type
    $Types = array(
    "474946383761"=>"image/gif",                        //GIF87a type gif
    "474946383961"=>"image/gif",                        //GIF89a type gif
    "89504E470D0A1A0A"=>"image/png",
    "FFD8FFE0"=>"image/jpeg",                           //JFIF jpeg
    "FFD8FFE1"=>"image/jpeg",                           //EXIF jpeg
    "FFD8FFE8"=>"image/jpeg",                           //SPIFF jpeg
    "25504446"=>"application/pdf",
    "377ABCAF271C"=>"application/zip",                  //7-Zip zip file
    "504B0304"=>"application/zip",                      //PK Zip file ( could also match other file types like docx, jar, etc )
    );

    $Signature = substr($data,0,60); //get first 60 bytes shouldnt need more then that to determine signature
    $Signature = array_shift(unpack("H*",$Signature)); //String representation of the hex values

    foreach($Types as $MagicNumber => $Mime)
    {
        if( stripos($Signature,$MagicNumber) === 0 )
            return $Mime;  
    }

    //Return octet-stream (binary content type) if no signature is found
    return "application/octet-stream"; 
}
  //end

	?>