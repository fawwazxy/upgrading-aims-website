<?php

	require '../../lib/db/connection.php';
	
	$action=$_POST['action'];
	
	if ($action=="nyahaktifPengguna") {
		$id = $_POST['id'];
		$status = $_POST['status'];
		$conn=db();
		
		$sql = "UPDATE photobooth_users set status='$status' WHERE id='$id'";
		$result = $conn->query($sql) or die($conn->error);
		echo "Status Berjaya Ditukar";
		

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
	function getJenisSurat() {
		$conn=db();
		$sql = "SELECT * FROM jenis_surat  ";
		$result = $conn->query($sql);
		return $result;
	}
	function getJenisSuratInfo($id) {
		$conn=db();
		$sql = "SELECT * FROM jenis_surat WHERE id='$id' ";
		$result = $conn->query($sql);
		return $result;
	}
	function getJenisProduk() {
		$conn=db();
		$sql = "SELECT * FROM produk  ";
		$result = $conn->query($sql);
		return $result;
	}
	function getPenggunaProduk($id_produk) {
		$conn=db();
		$sql = "SELECT * FROM photobooth_users WHERE kod_produk='$id_produk' ORDER BY id DESC";
		$result = $conn->query($sql);
		return $result;
	}
	function PenggunaAddEdit($id,$kod_produk,$user_code,$user_name,$limit){
	$conn=db();

	if($id > 0){
		$sql = "UPDATE photobooth_users set user_code='$user_code',user_name='$user_name',`limit`='$limit' WHERE id='$id' ";
	}else{
	 
		$sql = "INSERT INTO photobooth_users (kod_produk,user_code,user_name,`limit`) 
				values ('$kod_produk','$user_code','$user_name','$limit')";
	}

	$result = $conn->query($sql) or die($conn->error);
	return $result;
}
function getMaklumatPenggunaBYid($id) {
		$conn=db();
		$sql = "SELECT * FROM photobooth_users WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	
	$conn->close();
	
?>