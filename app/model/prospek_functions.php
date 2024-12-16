<?php

	require '../../lib/db/connection.php';


   $action=$_POST['action'];
  
   if ($action=="autocomplete_elaun") {
   $nama_elaun=$_POST['nama_elaun'];
   $getNamaElaun=getNamaElaun($nama_elaun);
   }
  
  //elaun
  if ($action=="update_elaun") {
    
	$elaun_id= $_POST['elaun_id'];
    $nama_elaun = $_POST['nama_elaun'];
	$nilai_elaun = $_POST['nilai_elaun'];
	$status = $_POST['status'];
	$jenis_elaun = $_POST['jenis_elaun'];
	$table_ref = $_POST['table_ref'];
	$col_ref = $_POST['col_ref'];
	$ref = $_POST['ref'];
	
	if($elaun_id=='0'){
      //need insert new data
     addElaun($nama_elaun,$nilai_elaun,$status,$jenis_elaun,$table_ref,$col_ref,$ref);
    }else{
      //will update
     updateElaun($elaun_id,$nama,$elaun,$status);
    }
  }
  
 
  if ($action=="del_elaun") {
		echo $staff_edu_id=clean($_POST['elaun_id']);
		if($elaun_id == "0"){
			
		}else{
			deleteElaun($elaun_id);
		}
	}

//jenis_elaun
  if ($action=="update_jenis_elaun") {
    
	$jenis_elaun_id= $_POST['jenis_elaun_id'];
    $code = $_POST['code'];
	$jenis_elaun = $_POST['jenis_elaun'];
	$table_ref = $_POST['table_ref'];
	$value_ref = $_POST['value_ref'];
	$text_ref = $_POST['text_ref'];

	
	if($jenis_elaun_id=='0'){
      //need insert new data
     addJenisElaun($code,$jenis_elaun,$table_ref,$value_ref,$text_ref);
    }else{
      //will update
     updateJenisElaun($jenis_elaun_id,$code,$jenis_elaun,$table_ref,$value_ref,$text_ref);
    }
  }
  
 
  if ($action=="del_jenis_elaun") {
		echo $jenis_elaun_id=clean($_POST['jenis_elaun_id']);
		if($jenis_elaun_id == "0"){
			
		}else{
			deleteJenisElaun($jenis_elaun_id);
		}
	}

	
	
	//GLOBAL DROPDOWN
  if ($action=="getDropDownElaun") {
		$table_ref = $_POST['table_ref'];
		$value_ref = $_POST['value_ref'];
		$text_ref = $_POST['text_ref'];
		
		$conn=db();
		$sql = "SELECT ".$value_ref.",".$text_ref." FROM ".$table_ref;
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($list  = $result -> fetch_array()){
		  $txt_result .= "<option value=\"".$list[0]."\">".$list[1]." </option>";
		  
		}
		echo $txt_result;
		
		//return $txt_result;
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
	

	function addElaun($nama_elaun,$nilai_elaun,$status,$jenis_elaun,$table_ref,$col_ref,$ref) {
  
    $conn=db();
	
     $sql = "INSERT INTO elaun(nama_elaun,nilai_elaun,status,jenis_elaun,table_ref,col_ref,ref)
                 VALUES(UPPER('$nama_elaun'), '$nilai_elaun','$status','$jenis_elaun','$table_ref','$col_ref','$ref')";
    $result = $conn->query($sql);
    return $result;
  }
  
  function getTableReference($jenis_elaun){
  
  $conn=db();
		
		 $sql= " SELECT table_ref,col_ref,id FROM jenis_elaun  ";
        $result = $conn->query($sql);
		return $result;
  }
  
 	function deleteElaun($elaun_id) {
		$conn=db();
		$sql = "DELETE FROM elaun WHERE id = '$elaun_id'";
		$result = $conn->query($sql);
		return $result;
		
	}
	
	
		function updateElaun($nama,$elaun,$status) {
		$conn=db();
		$sql = "UPDATE elaun SET  nama = '$nama', elaun='$elaun', status='$status'
                WHERE id = '$elaun_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	//add jenis_elaun
	function addJenisElaun($code,$jenis_elaun,$table_ref,$value_ref,$text_ref) {
    $conn=db();
     $sql = "INSERT INTO jenis_elaun(code,jenis_elaun,table_ref,value_ref,text_ref)
                 VALUES('$code','$jenis_elaun','$table_ref','$value_ref','$text_ref')";
    $result = $conn->query($sql);
    return $result;
  }
  
  	function deleteJenisElaun($jenis_elaun_id ) {
		$conn=db();
		$sql = "DELETE FROM jenis_elaun WHERE id = '$jenis_elaun_id '";
		$result = $conn->query($sql);
		return $result;
	}

  function updateJenisElaun($jenis_elaun_id,$code,$jenis_elaun,$table_ref,$value_ref,$text_ref) {
		$conn=db();
		$sql = "UPDATE jenis_elaun SET  code = '$code', jenis_elaun='$jenis_elaun', table_ref='$table_ref', value_ref='$value_ref',
                text_ref='$text_ref' WHERE id = '$jenis_elaun_id'";
		$result = $conn->query($sql);
		return $result;
	}
  
		function getElaun($no_staff) {
		$conn=db();
		$sql = "SELECT *
        FROM Elaun WHERE no_staff='$no_staff'";
		$result = $conn->query($sql);
		return $result;
	}
	

	function getTableRujukan($nama_table,$nama_col) {
		$conn=db();
		$sql = "SELECT * FROM ".$nama_table;
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($list  = $result -> fetch_assoc()){
			$txt_result .= "<option value=\"".$list['code_department']."\">".$list['desc']." </option>";
		}
		return $txt_result;
	}
	
	//elaun_department
		function getDepartment() {
		$conn=db();
		$sql = "SELECT * FROM department";
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($list  = $result -> fetch_assoc()){
			$txt_result .= "<option value=\"".$list['code_department']."\">".$list['desc']." </option>";
		}
		return $txt_result;
	}
	

	//functions jenis_elaun(dropdown)
		function getJenisElaun() {
		$conn=db();
		$sql = "SELECT * FROM jenis_elaun";
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($list  = $result -> fetch_assoc()){
			$txt_result .= "<option value=\"".$list['jenis_elaun']."\" data=\"".$list['table_ref']."\" data2=\"".$list['value_ref']."\" data3=\"".$list['text_ref']."\"  data4=\"".$list['id']."\">".$list['jenis_elaun']." </option>";
		}
		return $txt_result;
	}
	
	
	//elaun_individu
	   function getNoStaff() {
		$conn=db();
		$sql = "SELECT * FROM staff  ";
		$result = $conn->query($sql);
		
		  $txt_result="";
		  while ($list  = $result -> fetch_assoc()){
			  $txt_result .= "<option value=\"".$list['no_staff']."\">".$list['name']." </option>";
			 
		  }
		
		
		return  $txt_result;
	}
	
	
	
	
		function getTableRef() {
		$conn=db();
		$sql = "SELECT table_ref FROM jenis_elaun  ";
		$result = $conn->query($sql);
		
		  $txt_result="";
		  while ($list  = $result -> fetch_assoc()){
			  $txt_result .= "<option value=\"".$list['table_ref']."\">".$list['table_ref']." </option>";
			 
		  }
		
		
		return  $txt_result;
	}
	
		function getLogLead() {
		$conn=db();
		$sql = "SELECT * FROM lead ORDER BY id DESC ";
		$result = $conn->query($sql);
		return $result;
	}
	
	
		function getLogJenisElaun() {
		$conn=db();
		$sql = "SELECT * FROM jenis_elaun ORDER BY id ASC ";
		$result = $conn->query($sql);
		return $result;
	}
	
	function activeElaun($elaun_id,$status) {
		$conn=db();
		$sql = "UPDATE elaun SET status= $status WHERE id = $elaun_id";
       	$result = $conn->query($sql);
		return $result;
	}
	
	
	
	
	$conn->close();
	
?>