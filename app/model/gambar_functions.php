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
		$sql = "SELECT s.*,c.short_name,c.kad_depan_img,c.kad_belakang_img 
		FROM sys_setting s LEFT JOIN company c ON c.sys_id=s.sys_id WHERE s.sys_id='$sys_id'";
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
	
	//------------upload background---------
	function  updateBackgroundImage($flag,$image,$imgContent) {
		$conn=db();
		if($flag == 'depan'){
			$sql = "UPDATE company SET kad_depan_filename = '$image', kad_depan_img='$imgContent' WHERE id='1'";
		}else{
			$sql = "UPDATE company SET kad_belakang_filename = '$image', kad_belakang_img='$imgContent' WHERE id='1'";
		}
	    
		
		$result = $conn->query($sql);
		return $result;
	} 
	
	
	$conn->close();
	
?>