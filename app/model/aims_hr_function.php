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

	//addForm Section 
	function addForm($documentname,$document_type,$document_size,$company_name,$created_by,$form_name) {
		$conn=db();
		
		
		$doc = '';
        $doc_val = '';
        if($documentname!=""){
            $doc= ",document_name,document_type,document_size";
            $doc_val=",'$documentname','$document_type','$document_size'";
        }
		$sql = "INSERT INTO aims_hr_form (company_name,form_name,created_by$doc)
		VALUES ('$company_name','$form_name','$created_by'$doc_val)";
		
		
		$result = $conn->query($sql);
		return $result;
	}
		
	
	function getHrFormList($company_name){
		$conn=db();
		
		$sql = "SELECT * FROM aims_hr_form WHERE company_name = '$company_name' ORDER BY form_name ASC";
		$result = $conn->query($sql);
		return $result;
	}

	function getHrFormById($id){
    $conn=db();
    $sql = "SELECT form_name,company_name FROM aims_hr_form";
	$result = $conn->query($sql);
	return $result;
	}	
		
	function deleteHrForm($id){
		$conn=db();
		$sql = "DELETE FROM aims_hr_form WHERE id ='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getHrDocument($id){
        $conn=db();
        $sql=" SELECT * FROM aims_hr_form
                WHERE id='$id'";
        $result=$conn->query($sql);
        return $result;  
    }

    function getLibraryInfo($id){
	$conn=db();
	$sql = "SELECT * FROM aims_hr_form WHERE id='$id'";
	$result = $conn->query($sql);
	return $result;
}
	
	
	function getDropDownDepartment($selected) {
		$conn=db();
		
		
		 $sql = "SELECT code_department,description FROM department ORDER BY description ASC";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
		}
		
		//$conn->close();
		return $txt_result;
	}
	$conn->close();
