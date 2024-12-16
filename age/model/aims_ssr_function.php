<?php

	require '../../lib/db/connection.php';
   
	$action = $_POST['action'];
	//closeopen -start-
	if($action == "closeApp"){
	$id = $_POST['id'];
	$status = $_POST['status'];
	if ($status == '1') {
		$status = '0';
	}
	else {
		$status = '1';
	}
	$conn=db();
	$sql = "UPDATE aims_operationlist SET status='$status' WHERE id = '$id'";
	$result = $conn->query($sql);
	}

	//shipstore add n update
  if ($action=="update_claim") {
    
	
	$description = $_POST['description'];
	$unit = $_POST['unit'];
	$quantity_required = $_POST['quantity_required'];
	$balance = $_POST['balance'];
	$quantity_approved = $_POST['quantity_approved'];
	$sparepart_no = $_POST['sparepart_no'];
	$remarks = $_POST['remarks'];
	$ssr_no = $_POST['ssr_no'];
	$ssr_id = $_POST['ssr_id'];
	$id= $_POST['id'];
	
	$conn=db();
	
	if($id > 0 ){
      //need insert new data
	  $sql = "UPDATE aims_shipstore SET description= UPPER('$description'),unit= UPPER('$unit'),quantity_required='$quantity_required',balance='$balance',quantity_approved='$quantity_approved',sparepart_no= UPPER('$sparepart_no'),remarks= UPPER('$remarks') WHERE id='$id'";
			$result = $conn->query($sql) or die($conn->error);
			echo "Data berjaya dikemaskini";
     
    }else{
      $sql = "INSERT INTO aims_shipstore(description,unit,quantity_required,balance,quantity_approved,sparepart_no,remarks,ssr_no,ssr_id) VALUES (UPPER('$description'),UPPER('$unit'),'$quantity_required','$balance','$quantity_approved',UPPER('$sparepart_no'),UPPER('$remarks'),'$ssr_no','$ssr_id')";
			$result = $conn->query($sql) or die($conn->error);
			echo "Data berjaya ditambah";
    }
  }
  
 
  else if($action == "del_claim"){
		$id = $_POST['id'];
		
		$conn=db();
		$sql = "DELETE FROM aims_shipstore WHERE id = '$id'";
		$result = $conn->query($sql);
	}
	
	function shipshoresById($ssr_no){
		$conn=db();
		$sql = "SELECT a.id,a.ssr_no, a.description,a.unit,a.quantity_required,a.balance,a.quantity_approved,a.sparepart_no,a.remarks,
				c.vessel,b.location,b.ssr_date,b.department,b.item
				FROM aims_shipstore a
				LEFT JOIN aims_operationlist b ON a.ssr_id = b.id
				LEFT JOIN aims_vessel c ON b.vessel = c.code_vessel
				WHERE b.ssr_no = '$ssr_no'";
		$result = $conn->query($sql);
		return $result;
	}
	
	//end shipshores
	
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
	 function getLampiranInfo($id){
        $conn=db();
        $sql=" SELECT * FROM aims_operationlist
                WHERE id='$id'";
        $result=$conn->query($sql);
        return $result;  
    }

	
	function addStaff($ssr_no,$ssr_date,$vessel,$department,$location,$item,$status,$document,$document_name,$fileType){
		$conn=db();
        $gambar = '';
        $gambar_val = '';
        if($document_name!=""){
            $gambar=" ,document,document_type,document_name";
            $gambar_val=",'$document','$fileType','$document_name'";
        }
		$sql = "INSERT INTO aims_operationlist(ssr_no,ssr_date,vessel,department,location,item,status$gambar)
		VALUES(UPPER('$ssr_no'),UPPER('$ssr_date'),UPPER('$vessel'),UPPER('$department'),UPPER('$location'),UPPER('$item'),'$status'$gambar_val)";
		$result = $conn->query($sql);
		return $result;
	}
	
	function listStaffaa1(){
		$conn=db();
		$sql = "SELECT * FROM aims_operationlist 
		WHERE vessel='AA1'";
		$result = $conn->query($sql);
		return $result;
	}
	
		function listStaffaa2(){
		$conn=db();
		$sql = "SELECT * FROM aims_operationlist 
		WHERE vessel='AA2'";
		$result = $conn->query($sql);
		return $result;
	}
		function listStaffaa3(){
		$conn=db();
		$sql = "SELECT * FROM aims_operationlist 
		WHERE vessel='AA3'";
		$result = $conn->query($sql);
		return $result;
	}
		function listStaffaa4(){
		$conn=db();
		$sql = "SELECT * FROM aims_operationlist 
		WHERE vessel='AA4'";
		$result = $conn->query($sql);
		return $result;
	}
		function listStaffaa5(){
		$conn=db();
		$sql = "SELECT * FROM aims_operationlist 
		WHERE vessel='AA5'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function updateStaff($ssr_no,$ssr_date,$vessel,$department,$location,$item,$status,$document,$document_name,$fileType,$id){
		$conn=db();
		$sql = "UPDATE aims_operationlist SET ssr_no = UPPER('$ssr_no'), ssr_date = '$ssr_date',vessel = '$vessel', department = '$department',location = UPPER('$location'),item = '$item',status='$status'";
		 if($document_name!=""){
          $sql.=" ,document='$document',document_name='$document_name',document_type='$fileType' "; 
        }
        $sql.="WHERE id='$id'";
		$result = $conn->query($sql);
		
		$sql = "UPDATE aims_shipstore SET ssr_no = UPPER('$ssr_no') where ssr_id='$id'";
		$result = $conn->query($sql);
		
		return $result;
	}
	
	function deleteStaff($id){
		$conn=db();
		$sql = "DELETE FROM aims_operationlist WHERE id='$id'";
		$result = $conn->query($sql);
		
		$sql = "DELETE FROM aims_shipstore WHERE ssr_id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getStaffById($id){
		$conn=db();
		$sql = "SELECT * FROM aims_operationlist WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getSSRList1($status) {
	$conn=db();
	$sql = "SELECT * FROM aims_operationlist 
			WHERE status = '$status'
			AND vessel='AA1'
			ORDER BY id DESC";
	$result = $conn->query($sql);
	return $result;
}

function getSSRList2($status) {
	$conn=db();
	$sql = "SELECT * FROM aims_operationlist 
			WHERE status = '$status'
			AND vessel='AA2'
			ORDER BY id DESC";
	$result = $conn->query($sql);
	return $result;
}

function getSSRList3($status) {
	$conn=db();
	$sql = "SELECT * FROM aims_operationlist 
			WHERE status = '$status'
			AND vessel='AA3'
			ORDER BY id DESC";
	$result = $conn->query($sql);
	return $result;
}

function getSSRList4($status) {
	$conn=db();
	$sql = "SELECT * FROM aims_operationlist 
			WHERE status = '$status'
			AND vessel='AA4'
			ORDER BY id DESC";
	$result = $conn->query($sql);
	return $result;
}

function getSSRList5($status) {
	$conn=db();
	$sql = "SELECT * FROM aims_operationlist 
			WHERE status = '$status'
			AND vessel='AA5'
			ORDER BY id DESC";
	$result = $conn->query($sql);
	return $result;
}

  ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

  /*Pikah Update Here*/

function shipstoreTambahBaru($ssr_id,$ssr_name,$descItem,$unit,$quantity_required,$balance_board,$quantity_approved,$impa_code,$remarks){
    $conn=db();
    $sql="INSERT INTO aims_shipstore(ssr_id, ssr_no, description, unit, quantity_required, balance, quantity_approved, sparepart_no, remarks)
            VALUES ('$ssr_id','$ssr_name','$descItem','$unit','$quantity_required','$balance_board','$quantity_approved','$impa_code','$remarks')";
    return $conn->query($sql);
}
//	$conn->close();
	
?>