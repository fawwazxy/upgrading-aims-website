 <?
  require '../../lib/db/connection.php';



$action = ($_POST['action']);
if ($action == "lead_segmen_edit"){
	$id=($_POST['id']);
	$code = ($_POST['code']);
	$name = ($_POST['name']);

	$result = editLeadSegmen($code, $name, $id);
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

// START WANI - LEAD SEGMEN

  	function getLeadSegmen($status){
		$conn=db();
		$sql="  SELECT * FROM lead_segmen
		WHERE status='$status'";
		$result = $conn->query($sql);
		return $result;
	}

	function addLeadSegmen($code, $name){
	    $conn=db();
		$sql2 = "SELECT * FROM lead_segmen WHERE code='$code'";
		$check = $conn->query($sql2);
		if($check->num_rows > 0 ){
			echo ("<script lANGUAGE='JavaScript'>
			window.alert('Kod telah wujud!');
			window.location.href='../view/lead_segmen.php';
			</script>");
		}else{
	    $sql = "INSERT INTO lead_segmen(code, name) VALUES('$code', '$name')"; 
	    $result = $conn->query($sql);
		}
		 return $result;
  	}


  	function editLeadSegmen($code, $name, $id){
		$conn=db();
	     $sql = "UPDATE lead_segmen SET code='$code', name='$name' WHERE id='$id'";
	     
	    $result = $conn->query($sql);
	    return $result;
	}


  	function deleteLeadSegmen($id){
    	$conn=db();
      	$sql = "DELETE FROM lead_segmen WHERE id='$id'";
      
      	$result = $conn->query($sql);
    	return $result;
  	}

  	function updateLeadSegmenStatus($id) { // Update Status 1-AKTIF and 0-TIDAK AKTIF
		$conn=db();
		$sql = "UPDATE lead_segmen SET status='0'
		WHERE id='$id'";

		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

// END WANI - LEAD SEGMEN

// START NABILAH - PRODUK
	
	function getProduk($status){
	    $conn=db();
	    $sql = "SELECT p.*, ls.id AS lead_id FROM produk p
	    LEFT JOIN lead_segmen ls ON p.segmen=ls.id
	    WHERE p.status='$status'";
	    
	    $result = $conn->query($sql);
	    return $result;
  	}

 	function getSegmen(){
	    $conn=db();
	    $sql = "SELECT * FROM lead_segmen WHERE status='1'";
	   
	    $result = $conn->query($sql);
	    return $result;
  	}

  	function getSegmenInfo($id){
	    $conn=db();
	    $sql = "SELECT * FROM lead_segmen WHERE id IN($id)";
	    
	    $result = $conn->query($sql);
	    return $result;
  	}

  function  addProduk($code, $produk, $penerangan, $segmen){
	    $conn=db();
	    $sql2 = "SELECT * FROM produk WHERE code='$code'";
		$check = $conn->query($sql2);
		if($check->num_rows > 0 ){
			echo ("<script lANGUAGE='JavaScript'>
			window.alert('Kod telah wujud!');
			window.location.href='../view/produk.php';
			</script>");
		}else{
	    $sql = "INSERT INTO produk(code, produk, penerangan, segmen)  
	     VALUES ('$code', '$produk', '$penerangan', '$segmen')";
	    $result = $conn->query($sql);
	}
	    return $result;
  	}

  	function deleteProduk($id){
	    $conn=db();
	    $sql = "DELETE FROM produk WHERE id='$id'";
	    
	    $result = $conn->query($sql);
	    return $result;
	}

  	function getProdukInfo($id){
	    $conn=db();
	    $sql = "SELECT * FROM produk
	    WHERE id='$id'";
	    
	    $result = $conn->query($sql);
	    return $result;
  	}

   	function updateProduk($code, $produk, $penerangan, $segmen, $id){
	    $conn=db();
	    $sql = "UPDATE produk SET code='$code', produk='$produk', penerangan='$penerangan', segmen='$segmen'
	    WHERE id='$id'";
	    
	    $result = $conn->query($sql);
	    return $result;
	}

  	function updateStatusProduk($id){
	    $conn=db();
	    $sql = "UPDATE produk SET status='0' WHERE id='$id'";
	    
	    $result = $conn->query($sql);
	    return $result;
  	}

function updateStatusLeadBaru($id){
	    $conn=db();
	    $sql = "UPDATE lead_segmen SET status='1' WHERE id='$id'";
	    
	    $result = $conn->query($sql);
	    return $result;
  	}

  	function updateStatusProdukBaru($id){
	    $conn=db();
	    $sql = "UPDATE produk SET status='1' WHERE id='$id'";
	    
	    $result = $conn->query($sql);
	    return $result;
  	}

?>