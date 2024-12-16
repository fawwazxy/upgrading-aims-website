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
	
	// function addHR($staff_record_id,$medical_id,$baki_claim,$jumlah_claim,$total_claim,$remarks){
	// 	$conn=db();
	// 	$sql = "INSERT INTO aims_lv_total_medical(staff_record_id,medical_id,entitle_medical,jumlah_claim,baki_claim,remarks) VALUES('$staff_record_id','$medical_id','$entitle_medical','$jumlah_claim','$baki_claim','remarks')";
	// 	$result = $conn->query($sql);
	// 	return $result;
	// }
	
	function listhr($no_staff){
		$conn=db();
		$sql = "SELECT a.id,s.name,s.noic,s.role_id,s.department_id,d.code_department AS company_name,a.mec_date,a.staff_record_id,a.description, a.total_claim,a.remarks,ap.ver_date,ap.ver_status,ap.ver_name,ap.app_status,ap.app_name,ap.appcfo_status,ap.appcfo_name,ap.appcfo_date, a.document,a.document_type,a.document_name, b.baki_claim,b.jumlah_claim,b.entitle_medical
		FROM aims_lv_medical a
		LEFT JOIN staff_record c ON a.staff_record_id=c.id
		LEFT JOIN staff s ON c.no_staff=s.no_staff
		LEFT JOIN aims_lv_total_medical b ON a.id = b.staff_record_id
		LEFT JOIN aims_lv_approve_medical ap ON a.id = ap.medical_id
		 LEFT JOIN department d ON d.code_department=s.department_id
		WHERE a.staff_record_id='$staff_record_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function listStaff($no_staff){
		$conn=db();
		$sql = "SELECT a.no_staff,b.* FROM staff_record a LEFT JOIN aims_lv_medical b ON b.staff_record_id = a.id
		WHERE a.no_staff='$no_staff'";
		$result = $conn->query($sql);
		return $result;
	}

	// function deleteMedical($medical_id,$staff_record_id,$total_claim){
 //    	$conn=db();

 //    	$sql = "SELECT jumlah_claim FROM aims_lv_total_medical WHERE staff_record_id='$staff_record_id'";
 //    	$jumlah_claim=$conn-> query($sql)->fetch_object()->jumlah_claim;

 //    	$new_jumlah_claim = $jumlah_claim + $total_claim;
 //    	$sql = "UPDATE aims_lv_total_medical SET jumlah_claim='$new_jumlah_claim'
 //    	WHERE staff_record_id='$staff_record_id'";
 //    	$result=$conn->query($sql);

 //    	$sql2 = "DELETE aims_lv_medical, aims_lv_approve_medical FROM aims_lv_medical
 //    	LEFT JOIN aims_lv_approve_medical ON aims_lv_medical.id = aims_lv_approve_medical.medical_id
 //    	WHERE aims_lv_medical.id ='$medical_id' AND aims_lv_approve_medical.medical_id='$medical_id'";
 //    	$result = $conn->query($sql2);

 //    	return $result;
 //    }
	
	function verifiedHR($staff_record_id,$total_claim,$ver_status,$ver_name,$medical_id,$id){
    $conn=db();

    $sql2 = "UPDATE aims_lv_approve_medical SET ver_status = '$ver_status',ver_name = '$ver_name',ver_date = CURRENT_TIMESTAMP WHERE medical_id = '$medical_id'";
    $result = $conn->query($sql2);
    
    $sql = "SELECT baki_claim FROM aims_lv_total_medical WHERE staff_record_id='$staff_record_id'";
	$baki_claim =$conn->query($sql)->fetch_object()->baki_claim;
		
	$new_baki_claim = $baki_claim - $total_claim;
    $sql="UPDATE aims_lv_total_medical SET baki_claim='$new_baki_claim' 
		  WHERE staff_record_id='$staff_record_id'";
	$result = $conn->query($sql);

	

	return $result;
	}
    
	
	function getStaffById($id){
		$conn=db();
		$sql = "SELECT a.*, am.staff_record_id, b.total_claim FROM aims_lv_approve_medical a 
		LEFT JOIN aims_lv_medical b ON b.id = a.medical_id
		LEFT JOIN aims_lv_total_medical am ON am.staff_record_id = b.staff_record_id
		WHERE medical_id = '$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getStaffInformation($no_staff){
        $conn=db();
        $sql = "SELECT MAX(sr.id),sr.*,d.code_department AS company_name,d.description AS department_name,s.role_id,s.department_id,s.department_sub,s.noic,s.phone,s.name AS staff_name,dl.code_department AS department_name,r.role
                FROM staff_record sr 
                LEFT JOIN staff s ON s.no_staff=sr.no_staff 
                LEFT JOIN department d ON d.code_department=s.department_id 
                LEFT JOIN role r ON sr.peranan=r.code
				LEFT JOIN department_load dl ON dl.code_department=s.department_sub
                WHERE s.status = 'BEKERJA' AND s.noic IS NOT NULL 
                AND s.no_staff='$no_staff'"; 
        $result = $conn->query($sql);
  	    return $result;        
    }
	function getStaffMedicalById($id){
        $conn=db();
        $sql = "SELECT a.no_staff,d.noic,d.role_id,d.department_id,d.department_sub,d.name,b.total_claim,c.* 
		FROM staff_record a 
		LEFT JOIN aims_lv_medical b ON b.staff_record_id = a.id 
		LEFT JOIN aims_lv_total_medical c ON c.staff_record_id = a.id 
		LEFT JOIN staff d ON d.no_staff = a.no_staff
		WHERE b.id='$id'"; 
        $result = $conn->query($sql);
  	    return $result;        
    }
	
	function getMECImg($id){
		$conn=db();
		$sql = "SELECT photo, photo_name FROM aims_lv_medical WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getstaffImg($id){
	$conn=db();
	$sql="	SELECT photo, photo_name FROM aims_lv_medical WHERE id ='$id'";

	$result = $conn->query($sql);
	$default= $result-> fetch_assoc();
	echo '<img src="data:image/jpeg;base64,'.$default['photo_name'].'" border="0" width="350px" height="350px"/>';

}


	
	$conn->close();
	
?>