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
		$sql = "SELECT s.*,c.short_name FROM sys_setting s LEFT JOIN company c ON c.sys_id=s.sys_id WHERE s.sys_id='$sys_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function addStaff($part_name,$minimum,$balance,$used,$supply,$rob,$vessel){
		$conn=db();
		$sql = "INSERT INTO aims_critical(part_name,minimum,balance,used,supply,rob,vessel) VALUES('$part_name','$minimum','$balance','$used','$supply','$rob','$vessel')";
		$result = $conn->query($sql);
		return $result;
	}
	
	function listStaffaa1($mnt,$yr){
		$conn=db();
		$sql = "SELECT * FROM aims_critical WHERE vessel='AA1' 
		AND DATE_FORMAT(created_date,'%m')='$mnt' AND DATE_FORMAT(created_date,'%Y') = '$yr'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function listStaffaa2($mnt,$yr){
		$conn=db();
		$sql = "SELECT * FROM aims_critical WHERE vessel='AA2'
		AND MONTH(created_date)='$mnt' AND YEAR(created_date) = '$yr'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function listStaffaa3($mnt,$yr){
		$conn=db();
		$sql = "SELECT * FROM aims_critical WHERE vessel='AA3'
		AND MONTH(created_date)='$month' AND YEAR(created_date) = '$yr'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function listStaffaa4($mnt,$yr){
		$conn=db();
		$sql = "SELECT * FROM aims_critical WHERE vessel='AA4'
		AND MONTH(created_date)='$month' AND YEAR(created_date) = '$yr'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function listStaffaa5($mnt,$yr){
		$conn=db();
		$sql = "SELECT * FROM aims_critical WHERE vessel='AA5'
		AND MONTH(created_date)='$mnt' AND YEAR(created_date) = '$yr'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function updateStaff($part_name,$minimum,$balance,$used,$supply,$rob,$vessel,$id){
		$conn=db();
		$sql = "UPDATE aims_critical SET part_name = '$part_name',minimum='$minimum',balance='$balance',used='$used',supply='$supply',rob='$rob',vessel='$vessel' WHERE id = '$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function deleteStaff($id){
		$conn=db();
		$sql = "DELETE FROM aims_critical WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getStaffById($id){
		$conn=db();
		$sql = "SELECT * FROM aims_critical WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getDropDownMonth($selected) { 
	$conn=db();
	$sql = "SELECT MONTH(created_date) FROM aims_critical WHERE vessel='AA1'
			GROUP BY MONTH(created_date)
			ORDER BY created_date DESC";
				
	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
	}
	return $txt_result;
	}
	
	function getDropDownMonth2($selected) { 
	$conn=db();
	$sql = "SELECT MONTH(created_date) FROM aims_critical WHERE vessel='AA2'
			GROUP BY MONTH(created_date)
			ORDER BY created_date DESC";
				
	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
	}
	return $txt_result;
	}
	
	function getDropDownMonth3($selected) { 
	$conn=db();
	$sql = "SELECT MONTH(created_date) FROM aims_critical WHERE vessel='AA3'
			GROUP BY MONTH(created_date)
			ORDER BY created_date DESC";
				
	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
	}
	return $txt_result;
	}
	
	function getDropDownMonth4($selected) { 
	$conn=db();
	$sql = "SELECT MONTH(created_date) FROM aims_critical WHERE vessel='AA4'
			GROUP BY MONTH(created_date)
			ORDER BY created_date DESC";
				
	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
	}
	return $txt_result;
	}
	
	function getDropDownMonth5($selected) { 
	$conn=db();
	$sql = "SELECT MONTH(created_date) FROM aims_critical WHERE vessel='AA5'
			GROUP BY MONTH(created_date)
			ORDER BY created_date DESC";
				
	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
	}
	return $txt_result;
	}
	


	
	function getDropDownYear($selected) { 
	$conn=db();
	$sql = "SELECT YEAR(created_date) FROM aims_critical WHERE vessel='AA1'
			GROUP BY YEAR(created_date)
			ORDER BY YEAR(created_date) DESC";
				
	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
	}
	return $txt_result;
	}
	
	function getDropDownYear2($selected) { 
	$conn=db();
	$sql = "SELECT YEAR(created_date) FROM aims_critical WHERE vessel='AA2'
			GROUP BY YEAR(created_date)
			ORDER BY YEAR(created_date) DESC";
				
	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
	}
	return $txt_result;
	}
	
	function getDropDownYear3($selected) { 
	$conn=db();
	$sql = "SELECT YEAR(created_date) FROM aims_critical WHERE vessel='AA3'
			GROUP BY YEAR(created_date)
			ORDER BY YEAR(created_date) DESC";
				
	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
	}
	return $txt_result;
	}
	
	function getDropDownYear4($selected) { 
	$conn=db();
	$sql = "SELECT YEAR(created_date) FROM aims_critical WHERE vessel='AA4'
			GROUP BY YEAR(created_date)
			ORDER BY YEAR(created_date) DESC";
				
	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
	}
	return $txt_result;
	}
	
	
	
	function getDropDownYear5($selected) { 
	$conn=db();
	$sql = "SELECT YEAR(created_date) FROM aims_critical WHERE vessel='AA5'
			GROUP BY YEAR(created_date)
			ORDER BY YEAR(created_date) DESC";
				
	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
	}
	return $txt_result;
	}
	
	function getDropDownVessel($selected) { 
	$conn=db();
	$sql = "SELECT code_vessel FROM aims_vessel 
			GROUP BY code_vessel
			ORDER BY code_vessel DESC";
				
	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
	}
	return $txt_result;
	}
	
	$conn->close();
	
?>