<?php

require '../../lib/db/connection.php';

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
function countPenggunaBerdaftar() {
	$conn=db();
	$sql = "SELECT COUNT(id) AS jumlah
			FROM staff
			WHERE STATUS = 'BEKERJA' 
			AND pantau_kehadiran = '1'  
			AND role_id NOT IN ('ADMIN','SUPERADMIN')";
	$result = $conn->query($sql)->fetch_object()->jumlah;
    return $result;
}
function countPenggunaTelahPasang() {
	$conn=db();
	$sql = "SELECT COUNT(id) AS jumlah FROM staff
			WHERE status = 'BEKERJA' 
			AND pantau_kehadiran = '1'
			AND noic IN(
			SELECT DISTINCT(k.nokp_staff) FROM kehadiran k LEFT JOIN staff s2 ON k.nokp_staff=s2.noic 
			WHERE s2.status = 'BEKERJA' 
			AND s2.pantau_kehadiran = '1' 
			AND s2.role_id NOT IN ('ADMIN','SUPERADMIN')
			)    
			AND role_id NOT IN ('ADMIN','SUPERADMIN')";
	$result = $conn->query($sql)->fetch_object()->jumlah;
    return $result;
}
function getJabatanList($status) {
	$conn=db();
	$condition="";
	if($status=='belum')
	{
		$condition="NOT";
	}
	$sql = "SELECT d.code_department,d.description,COUNT(s.id) AS telah_pasang FROM staff s
			LEFT JOIN department d ON s.department_id=d.code_department
			WHERE s.status = 'BEKERJA' 
			AND s.pantau_kehadiran = '1'
			AND s.noic $condition IN(
			SELECT DISTINCT(k.nokp_staff) FROM kehadiran k LEFT JOIN staff s2 ON k.nokp_staff=s2.noic 
			WHERE s2.status = 'BEKERJA' 
			AND s2.pantau_kehadiran = '1' 
			AND s2.role_id NOT IN ('ADMIN','SUPERADMIN')
			)  
			AND s.role_id NOT IN ('ADMIN','SUPERADMIN') AND s.department_id IS NOT NULL
			GROUP BY s.department_id ORDER BY d.code_department";
	$result = $conn->query($sql);
    return $result;
}
function getPenggunaList($dept_id,$status) {
	$conn=db();
	$condition="";
	if($status=='belum')
	{
		$condition="NOT";
	}
	$sql = "SELECT name,no_staff,phone FROM staff
			WHERE status = 'BEKERJA' 
			AND pantau_kehadiran = '1'  
			AND noic $condition IN(
			SELECT DISTINCT(k.nokp_staff) FROM kehadiran k LEFT JOIN staff s2 ON k.nokp_staff=s2.noic 
			WHERE s2.status = 'BEKERJA' 
			AND s2.pantau_kehadiran = '1' 
			AND s2.role_id NOT IN ('ADMIN','SUPERADMIN')
			)
			AND role_id NOT IN ('ADMIN','SUPERADMIN') AND department_id='$dept_id' ORDER BY no_staff";
	$result = $conn->query($sql);
    return $result;
}

$conn->close();

?>