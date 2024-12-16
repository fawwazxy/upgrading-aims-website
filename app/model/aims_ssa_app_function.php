<?php

	require '../../lib/db/connection.php';
    
	$action = $_POST['action'];
// -start-
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
	$sql = "UPDATE aims_ssa SET status='$status' WHERE id = '$id'";
	$result = $conn->query($sql);
}
// -end-


	
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
	
	function listSSAaa1(){
		$conn=db();
		$sql = "SELECT * FROM aims_ssa WHERE vessel='AA1'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function listSSAaa2(){
		$conn=db();
		$sql = "SELECT * FROM aims_ssa WHERE vessel='AA2'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function listSSAaa3(){
		$conn=db();
		$sql = "SELECT * FROM aims_ssa WHERE vessel='AA3'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function listSSAaa4(){
		$conn=db();
		$sql = "SELECT * FROM aims_ssa WHERE vessel='AA4'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function listSSAaa5(){
		$conn=db();
		$sql = "SELECT * FROM aims_ssa WHERE vessel='AA5'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function updateSSA($ssa_no, $date, $vessel, $location, $department, $ssa_raised, $aa, $bb, $cc, $dd, $document, $document_name, $fileType, $app_name, $app_status, $app_design, $status, $id){
		$conn=db();
		$sql = "UPDATE aims_ssa SET ssa_no='$ssa_no', date= '$date', vessel='$vessel', location='$location', department='$department', ssa_raised='$ssa_raised', aa='$aa', bb='$bb', cc='$cc', dd='$dd', app_name='$app_name', app_status='$app_status', app_design='$app_design', status='$status'";
		if($document_name!=""){
          $sql.=" ,document='$document',document_name='$document_name',document_type='$fileType' "; 
        }
		$sql.="  WHERE id='$id'";
		$result=$conn->query($sql) or die($conn->error);
		return $result;
	}

	function appOn($app_name, $app_status, $app_design, $app_on, $id){
		$conn=db();
		$sql = "UPDATE aims_ssa SET app_name = '$app_name', app_status = '$app_status', app_design = '$app_design', app_on=CURRENT_TIMESTAMP WHERE id = '$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getSSAid($id){
		$conn=db();
		$sql = "SELECT * FROM aims_ssa WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getLampiranInfo($id){
        $conn=db();
        $sql=" SELECT * FROM aims_ssa
                WHERE id='$id'";
        $result=$conn->query($sql);
        return $result;  
    }
	
	//OPEN CLOSE 
	
	function getSSAList1($status,$department_sub) {
	$conn=db();
	
	if($department_sub == 'MANAGEMENT'){
	$sql = "SELECT * FROM aims_ssa 
			WHERE status = '$status'
			AND vessel='AA1' AND ver_status='1'
			ORDER BY id DESC";
	}
		else {
			
			echo ("<script LANGUAGE='JavaScript'>
						window.history.back();
						</script>");
		exit();
		}	
	$result = $conn->query($sql);
	return $result;
}

function getSSAList2($status) {
	$conn=db();
	$sql = "SELECT * FROM aims_ssa 
			WHERE status = '$status'
			AND vessel='AA2' AND ver_status='1'
			ORDER BY id DESC";
	$result = $conn->query($sql);
	return $result;
}

function getSSAList3($status) {
	$conn=db();
	$sql = "SELECT * FROM aims_ssa 
			WHERE status = '$status'
			AND vessel='AA3' AND ver_status='1'
			ORDER BY id DESC";
	$result = $conn->query($sql);
	return $result;
}

function getSSAList4($status) {
	$conn=db();
	$sql = "SELECT * FROM aims_ssa 
			WHERE status = '$status'
			AND vessel='AA4' AND ver_status='1'
			ORDER BY id DESC";
	$result = $conn->query($sql);
	return $result;
}

function getSSAList5($status) {
	$conn=db();
	$sql = "SELECT * FROM aims_ssa 
			WHERE status = '$status'
			AND vessel='AA5' AND ver_status='1'
			ORDER BY id DESC";
	$result = $conn->query($sql);
	return $result;
}

	$conn->close();
	
?>