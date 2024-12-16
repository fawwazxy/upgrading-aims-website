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
	$sql = "SELECT s.*,c.name as cname,c.short_name,c.logo as clogo,c.registration_no as cregno,c.address as caddress, c.tel as ctel,c.email as cemail,c.logo_filename AS logo_filename FROM sys_setting s 
	LEFT JOIN company c ON c.sys_id=s.sys_id WHERE s.sys_id='$sys_id'";
	$result = $conn->query($sql);
return $result;
}
	
	// booking tahunan
	function getAnalisaTotalBookingByYear($no_staff,$value) {
 	$conn=db();
 	
 	$sql = "SELECT gl.gl_access FROM aims_access gl 
		LEFT JOIN staff s ON s.noic = gl.no_staff
		WHERE s.no_staff='$no_staff'";
		$gl_access=$conn->query($sql)->fetch_object()->gl_access;

		if ($gl_access == '1'){

			$sql = "SELECT IFNULL(count(id),0) AS total_booking FROM aims_gl_booking
   			WHERE DATE_FORMAT(pic_indate,'%Y') <= '$value'";
			}
			else {
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_gl_admin.php';
						</script>");
		}
 	
 	$result = $conn->query($sql);
 	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return ''.$row[0];
	}else{
		return '';
	}
}

// booking bulanan
	function getAnalisaTotalBookingByMonth($value) {
		$conn=db();
		$sql = "SELECT IFNULL(count(id),0) AS total_booking FROM aims_gl_booking
				WHERE DATE_FORMAT(pic_indate,'%Y%m') = '$value'";
		$result = $conn->query($sql);
		$row = mysqli_fetch_array($result, MYSQLI_NUM);
		if($result->num_rows > 0){
			return ''.$row[0];
		}else{
			return '';
		}
	}
	
	// booking mingguan
	function getAnalisaTotalJualanByWeek($start,$end) {
 	$conn=db();
 	$sql = "SELECT IFNULL(count(id),0) AS total_booking FROM aims_gl_booking
   			WHERE DATE_FORMAT(pic_indate,'%y-%m-%d') 
			BETWEEN DATE_FORMAT('$start','%y-%m-%d') AND DATE_FORMAT('$end','%y-%m-%d')";
 	$result = $conn->query($sql);
 	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return ''.$row[0];
	}else{
		return '';
	}
}

// booking harian
	function getAnalisaTotalBookingByDay($date) {
		$conn=db();
		$sql = "SELECT IFNULL(count(id),0) AS total_booking FROM aims_gl_booking
				WHERE DATE(pic_indate)='$date'";
		$result = $conn->query($sql);
		$row = mysqli_fetch_array($result, MYSQLI_NUM);
		if($result->num_rows > 0){
			return ''.$row[0];
		}else{
			return '';
		}
	}


$conn->close();
?>