<?php

	require '../../lib/db/connection.php';
	
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
	
	
	function addAccess($no_staff,$vehicle_access,$gl_access){
		$conn=db();
		$sql = "INSERT INTO aims_access(no_staff,vehicle_access,gl_access) VALUES ('$no_staff','$vehicle_access','$gl_access')";
		$result = $conn->query($sql);
		return $result;
	}
	
	function updateDataAccess($vehicle_access,$gl_access,$id){
		$conn=db();
		$sql = "UPDATE aims_access SET vehicle_access='$vehicle_access',gl_access='$gl_access' WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}

	function deleteAccess($id){
		$conn=db();
		$sql = "DELETE FROM aims_access WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}

	function getDataList(){
		$conn=db();
		$sql = "SELECT a.*,c.name FROM aims_access a LEFT JOIN staff c ON c.no_staff=a.no_staff";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getDataAccessbyId($id){
		$conn=db();
		$sql = "SELECT * FROM aims_access WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	 
	function getdropdownstaff($selected) {
		$conn=db();
		 $sql = "SELECT no_staff,name FROM staff ORDER BY name ASC";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
		}
		
		//$conn->close();
		return $txt_result;
	}
	
	$conn->close();
	
?>