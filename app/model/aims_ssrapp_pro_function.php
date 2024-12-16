<?php

	require '../../lib/db/connection.php';
   
	$action = $_POST['action'];
	//agromart agensi -start-
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
	

	function listStaffaa1(){
		$conn=db();
		$sql = "SELECT * FROM aims_operationlist WHERE vessel='AA1'";
		$result = $conn->query($sql);
		return $result;
	}
	
		function listStaffaa2(){
		$conn=db();
		$sql = "SELECT * FROM aims_operationlist WHERE vessel='AA2'";
		$result = $conn->query($sql);
		return $result;
	}
		function listStaffaa3(){
		$conn=db();
		$sql = "SELECT * FROM aims_operationlist WHERE vessel='AA3'";
		$result = $conn->query($sql);
		return $result;
	}
		function listStaffaa4(){
		$conn=db();
		$sql = "SELECT * FROM aims_operationlist WHERE vessel='AA4'";
		$result = $conn->query($sql);
		return $result;
	}
		function listStaffaa5(){
		$conn=db();
		$sql = "SELECT * FROM aims_operationlist WHERE vessel='AA5'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function updateInfo($app_pro_name,$app_pro_status,$app_pro_date,$id){
		$conn=db();
		$sql = "UPDATE aims_operationlist SET app_pro_name='$app_pro_name',app_pro_status='$app_pro_status',app_pro_date=CURRENT_TIMESTAMP WHERE id = '$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	
	function getStaffById($id){
		$conn=db();
		$sql = "SELECT a.*, b.description, b.unit, b.quantity_required, b.balance, b.quantity_approved, b.sparepart_no, b.remarks FROM aims_operationlist a
				LEFT JOIN aims_shipstore b ON a.id = b.ssr_id
				WHERE a.id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
		function getSSRList1($status,$department_sub) {
	$conn=db();
	
	if ($department_sub=='PROCUREMENT'){
	$sql = "SELECT * FROM aims_operationlist 
			WHERE status = '$status'
			AND vessel='AA1'
			AND approved_status = '1'
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

function getSSRList2($status) {
	$conn=db();
	$sql = "SELECT * FROM aims_operationlist 
			WHERE status = '$status'
			AND vessel='AA2' AND approved_status = '1'
			ORDER BY id DESC";
	$result = $conn->query($sql);
	return $result;
}

function getSSRList3($status) {
	$conn=db();
	$sql = "SELECT * FROM aims_operationlist 
			WHERE status = '$status'
			AND vessel='AA3' AND approved_status = '1'
			ORDER BY id DESC";
	$result = $conn->query($sql);
	return $result;
}

function getSSRList4($status) {
	$conn=db();
	$sql = "SELECT * FROM aims_operationlist 
			WHERE status = '$status'
			AND vessel='AA4' AND approved_status = '1'
			ORDER BY id DESC";
	$result = $conn->query($sql);
	return $result;
}



function getSSRList5($status) {
	$conn=db();
	$sql = "SELECT * FROM aims_operationlist 
			WHERE status = '$status'
			AND vessel='AA5' AND approved_status = '1'
			ORDER BY id DESC";
	$result = $conn->query($sql);
	return $result;
}
	$conn->close();
	
?>