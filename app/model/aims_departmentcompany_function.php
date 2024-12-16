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
		$sql = "SELECT s.*,c.* FROM sys_setting s 
				LEFT JOIN company c ON c.sys_id = s.sys_id 
				WHERE s.sys_id='$sys_id'";
		$result = $conn->query($sql);
		return $result;
	}


	function getDepartmentList() {
		$conn=db();
		$sql = "SELECT * FROM department_load ORDER BY description ASC";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getDepartmentById($id) {
		$conn=db();
	    $sql = "SELECT * FROM department_load WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function addDepartment($description,$code_department) {
		$conn=db();
		$sql = "INSERT into department_load (description,code_department) values('$description','$code_department')";
		$result = $conn->query($sql);
	return $result;
	}
	
	function deleteDepartment($id){
	    $conn=db();
		 $sql = "DELETE FROM department_load WHERE id='$id'";
		 $result = $conn->query($sql);
		 
	    return $result;
	}
	
	function editDepartment($id,$description,$code_department) {
	$conn=db();
	$sql = "UPDATE department_load SET description='$description', code_department='$code_department' WHERE id = '$id'";
	$result = $conn->query($sql);
	return $result;
}

	
	
	$conn->close();
	
?>