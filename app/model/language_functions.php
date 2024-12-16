<?php

	require '../../lib/db/connection.php';
	
	$action = $_POST['action'];
	
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
	
	function getCompanyDetails($sys_id) {
		$conn=db();
		$sql = "SELECT * FROM company WHERE sys_id='$sys_id'";
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
	function getJenisBahasa() {
		$conn=db();
		$sql = "SELECT DISTINCT(locale) AS local_kod,locale_name FROM `language`
ORDER BY local_kod ASC";
		$result = $conn->query($sql);
		return $result;
	}
	function getTerjemahan() {
		$conn=db();
		$sql = "SELECT DISTINCT(locale) AS local_kod,locale_name FROM `language`
				ORDER BY local_kod ASC";
		$result = $conn->query($sql);
		$queryStr="SELECT kod,";
		$i=0;
		while($data = $result->fetch_assoc()){
			$local=$data['local_kod'];
			if($i>0) 
			$queryStr.= ',';
			$i++;
		$queryStr.="MAX(CASE WHEN locale ='".$local."' THEN translation ELSE '-' END) ".$local;
		}
		
		$queryStr .= " FROM language GROUP BY kod ORDER BY kod ASC";
		$result = $conn->query($queryStr);
		return $result;
	}
	function addTerjemahan($locale,$locale_name,$kod,$translation) {
		$conn=db();
		$sqlcheck="SELECT * FROM language WHERE locale='$locale' AND kod='$kod'";
		$check = $conn->query($sqlcheck);
		if($check->num_rows>0){
			$result = "ada";
		}else{
			$sql = "INSERT INTO language (locale,localE_name,kod,translation) VALUES ('$locale','$locale_name','$kod','$translation')";
			$result = $conn->query($sql);
			$result="tiada";
		}
		return $result;
	}
	function getTranslation($kod,$locale) {
		$conn=db();
		$sql = "SELECT translation FROM `language` WHERE kod='$kod' AND locale='$locale'";
		$result = $conn->query($sql);
		return $result->fetch_object()->translation;
	}
	function addEditTerjemahan($locale,$locale_name,$kod,$translation) {
		$conn=db();
		$sqlcheck="SELECT * FROM language WHERE locale='$locale' AND kod='$kod'";
		$check = $conn->query($sqlcheck);
		if(!isset($translation)){
			$result="";
		}
		else if($check->num_rows>0){
			$sql = "UPDATE language SET translation='$translation' WHERE locale='$locale' AND kod='$kod' ";
			$result = $conn->query($sql);
		}else{
			$sql = "INSERT INTO language (locale,localE_name,kod,translation) VALUES ('$locale','$locale_name','$kod','$translation')";
			$result = $conn->query($sql);
			
		}
		return $result;
	}
	$conn->close();
	?>