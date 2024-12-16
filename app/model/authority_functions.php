<?php

require '../../lib/db/connection.php';

date_default_timezone_set('Asia/Kuala_Lumpur');

$action = $_POST['action'];
//lookup kategori umur (add,update,delete)
    if($action == "delId"){
		$id = $_POST['id'];

		$conn=db();
		
			$sql = "DELETE FROM phone_authority WHERE id='$id'";
			$result = $conn->query($sql) or die($conn->error);
			echo "Data berjaya Dipadam";
		
	}else if($action == "truncate"){

		$conn=db();
		
			$sql = "TRUNCATE TABLE phone_authority";
			$result = $conn->query($sql) or die($conn->error);
			echo "Data berjaya Dipadam";
		
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
	$sql = "SELECT s.*,c.name as cname,c.short_name,c.logo as clogo,c.registration_no as cregno,c.address as caddress, c.tel as ctel,c.email as cemail,c.logo_filename as clogo2 FROM sys_setting s 
	LEFT JOIN company c ON c.sys_id=s.sys_id WHERE s.sys_id='$sys_id'";
	$result = $conn->query($sql);
	return $result;
}

function login($username,$password) {
	$conn=db();
	$sql = "SELECT * FROM staff WHERE username='$username' AND accs_pwd='$password'";
	$result = $conn->query($sql);
	return $result;
}

function getPhoneAuthority() {
	$conn=db();
	$sql = "SELECT p.*,s.name,s.no_staff FROM phone_authority p
			LEFT JOIN staff s ON p.nokp_staff=s.noic
			WHERE s.status='BEKERJA'
			ORDER BY s.name";
	$result = $conn->query($sql);
	return $result;
}
 function getAuditTrail($date_filter) {
    $conn=db();
     $sql = "SELECT a.*,s.name FROM audit_trail a
            LEFT JOIN staff s ON s.no_staff =a.no_staff 
             WHERE a.date_access LIKE '%$date_filter%'
            ORDER BY a.date_access DESC";
     return $conn->query($sql);
  }



		
$conn->close();

?>