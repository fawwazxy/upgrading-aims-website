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
	
// 	staff add medical
	function addStaff($staff_record_id,$department_id,$role_id,$department_sub,$mec_date,$description,$total_claim,$document_name,$document_type){
		$conn=db();
		$gambar = '';
        $gambar_val = '';
        if($document_name!=""){
            $gambar=" ,document_name,document_type";
            $gambar_val=",'$document_name','$document_type'";
        }
		$sql = "INSERT INTO aims_lv_medical(staff_record_id,department_id,mec_date,description,total_claim$gambar) VALUES
		('$staff_record_id','$department_id','$mec_date','$description','$total_claim'$gambar_val)";
		$result = $conn->query($sql);
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            
		$newid=$conn->insert_id;
		$sql2 = "INSERT INTO aims_lv_approve_medical(medical_id,ver_status,appcfo_status,app_status) VALUES('$newid','PENDING','PENDING','PENDING')";
		$result = $conn->query($sql2);

		$sql = "UPDATE aims_lv_total_medical SET jumlah_claim=jumlah_claim-'$total_claim' WHERE tahun = YEAR(CURRENT_TIMESTAMP) AND staff_record_id='$staff_record_id'";
		$result = $conn->query($sql);
		return $result;


	}
	

// 	hr process
	function addClaim($medical_id,$staff_record_id,$baki_claim,$total_claim,$jumlah_claim,$remarks){
		$conn=db();
		$sql = "UPDATE aims_lv_total_medical SET baki_claim = '$baki_claim', jumlah_claim = '$jumlah_claim' WHERE staff_record_id = '$staff_record_id'";
		$result = $conn->query($sql);

		$sql2 ="UPDATE aims_lv_medical SET total_claim = '$total_claim', remarks = '$remarks' WHERE id='$medical_id'";
		$result = $conn->query($sql2);
		return $result;
	}
	
// 	list medical for staff
	function listStaff($no_staff){
		$conn=db();
		$sql = "SELECT a.no_staff,b.* 
		FROM staff_record a 
		LEFT JOIN aims_lv_medical b ON b.staff_record_id = a.id
		WHERE a.no_staff='$no_staff'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getLampiranInfo($id){
        $conn=db();
        $sql=" SELECT * FROM aims_lv_medical
                WHERE id='$id'";
        $result=$conn->query($sql);
        return $result;  
    }
	
	//hr add medicalphoto
	
	function Updatemedicalz($document_name,$document_type,$id){
    $conn=db();
    $sql = "UPDATE aims_lv_medical SET document_name='$document_name', document_type='$document_type' WHERE id='$id'";
	$result = $conn->query($sql);
	return $result;
	}
	
	function liststaff1($no_staff){
		$conn=db();
		$sql = "SELECT a.id,a.mec_date,a.staff_record_id,a.description, a.total_claim, a.document,a.document_type,a.document_name,a.remarks, app.*,tm.entitle_medical,tm.jumlah_claim, tm.baki_claim
		FROM aims_lv_medical a
		LEFT JOIN staff_record c ON a.staff_record_id=c.id
		LEFT JOIN staff s ON c.no_staff=s.no_staff
		LEFT JOIN aims_lv_total_medical tm ON c.id = tm.staff_record_id
		LEFT JOIN aims_lv_approve_medical app ON a.id= app.medical_id
		WHERE c.no_staff='$no_staff' ORDER BY mec_date DESC";
		$result = $conn->query($sql);
		return $result;
	}

	function updateStaff($id,$mec_date,$description,$total_claim,$document,$document_name,$fileType){
    $conn=db();
    $sql = "UPDATE aims_lv_medical SET mec_date = '$mec_date', description = '$description', total_claim='$total_claim'";

     if($document_name!=""){
          $sql.=" ,document='$document',document_name='$document_name',document_type='$fileType' "; 
        }
    $sql.="  WHERE id='$id'";
    $result=$conn->query($sql) or die($conn->error);

    // $sql2 = "UPDATE aims_lv_total_medical SET jumlah_claim = '$jumlah_claim' where medical_id ='$id'";
    // $result = $conn->query($sql2);
    return $result; 
	}
	

    function deleteMedical($medical_id,$staff_record_id,$total_claim){
    	$conn=db();

    	$sql = "SELECT jumlah_claim FROM aims_lv_total_medical WHERE staff_record_id='$staff_record_id'";
    	$jumlah_claim=$conn-> query($sql)->fetch_object()->jumlah_claim;

    	$new_jumlah_claim = $jumlah_claim + $total_claim;
    	$sql = "UPDATE aims_lv_total_medical SET jumlah_claim='$new_jumlah_claim'
    	WHERE staff_record_id='$staff_record_id'";
    	$result=$conn->query($sql);

    	$sql2 = "DELETE aims_lv_medical, aims_lv_approve_medical FROM aims_lv_medical
    	LEFT JOIN aims_lv_approve_medical ON aims_lv_medical.id = aims_lv_approve_medical.medical_id
    	WHERE aims_lv_medical.id ='$medical_id' AND aims_lv_approve_medical.medical_id='$medical_id'";
    	$result = $conn->query($sql2);

    	return $result;
    }
    
    function getMedicalDocInfo($medical_id){
	$conn=db();
	$sql = "SELECT document_name FROM aims_lv_medical WHERE id='$medical_id'";
	$result = $conn->query($sql);
	return $result;
}
	
	
	// function deleteStaff($id){
	// 	$conn=db();
	// 	$sql = "DELETE FROM aims_lv_medical WHERE id='$id'";
	// 	$result = $conn->query($sql);

	// 	$sql2 = "DELETE FROM aims_lv_total_medical WHERE id='$medical_id'";
	// 	$result = $conn->query($sql);
	// 	return $result;
	// }
	
	function getStaffById($id){
		$conn=db();
		$sql = "SELECT * FROM aims_lv_medical WHERE id='$id'";
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
    
// 	show balance at the information above
	function getBalanceInfo($staff_record_id){
        $conn=db();
        $sql = "SELECT tm.baki_claim FROM aims_lv_total_medical tm
		WHERE tm.staff_record_id = '$staff_record_id'"; 
        $result = $conn->query($sql);
  	    return $result;       
    }
	
		function getCetakInfoById($id) {
		$conn=db();
		$sql = "SELECT a.no_staff,d.noic,d.role_id,d.department_id,d.department_sub,d.name AS staff_name,b.*,c.*,tm.*
		FROM staff_record a 
		LEFT JOIN aims_lv_medical b ON b.staff_record_id = a.id
		LEFT JOIN aims_lv_total_medical tm ON tm.staff_record_id = a.id
		LEFT JOIN aims_lv_approve_medical c ON c.medical_id = b.id 
		LEFT JOIN staff d ON d.no_staff = a.no_staff
		WHERE b.id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
// 	cuti baharu
	function getSenaraiPemohonCutiBaharu($leave_approval){
      $conn=db();
      $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
      
      if ($role_id == 'ADMIN' || $role_id == 'SUPERADMIN' || $role_id == 'HR' || $role_id == 'FOUNDER') {
          $sql="sql query sni";
      }
      else {
         $sql="sql query sni"; 
      }
      $result=$conn->query($sql);
      return $result; 
  }
  
	function getStaffMedicalById($id){
        $conn=db();
        $sql = "SELECT a.no_staff,d.noic,d.role_id,d.name,d.department_sub,b.*, tm.entitle_medical, tm.jumlah_claim,tm.baki_claim
		FROM staff_record a 
		LEFT JOIN aims_lv_medical b ON b.staff_record_id = a.id 
		LEFT JOIN staff d ON d.no_staff = a.no_staff
		LEFT JOIN aims_lv_total_medical tm ON tm.staff_record_id = a.id
		WHERE b.id='$id'"; 
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

function getSenaraiMedicalBaru($department_code,$department_sub){
      $conn=db();
      if($department_sub == 'HR'){
          $sql="SELECT app.id AS app_id,app.appcfo_name,app.appcfo_date,app.appcfo_status,app.app_name,app.app_date,app.app_status,app.ver_name,app.ver_date,app.ver_status,
          s.department_sub,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,a.created_date,r.role,d.description AS department_name,s.name,s.department_id AS dept_code,s.role_id,
          a.id,a.staff_record_id,a.department_id,a.created_date,a.mec_date,a.total_claim,a.description,a.remarks,a.document_type,a.document_name,tm.id AS total_id,tm.jumlah_claim,tm.baki_claim
              FROM aims_lv_approve_medical app
              LEFT JOIN aims_lv_medical a ON a.id= app.medical_id
              LEFT JOIN staff_record sr ON sr.id=a.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN aims_lv_total_medical tm ON tm.staff_record_id = sr.id
              LEFT JOIN department d ON d.code_department=s.department_id 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE app.ver_status = 'PENDING'
			  AND a.department_id = '$department_code'
              ORDER BY a.created_date DESC";
//          AND s.status = 'BEKERJA'
}
else {
    echo ("<script LANGUAGE='JavaScript'>
				            window.location.href='../view/aims_hr_specialleavemessage.php';
				            </script>");
}
      $result=$conn->query($sql);
      return $result; 
  }

  function getSenaraiMedicalVerified($department_code){
      $conn=db();
      
          $sql="SELECT app.id AS app_id,app.appcfo_name,app.appcfo_date,app.appcfo_status,app.app_name,app.app_date,app.app_status,app.ver_name,app.ver_date,app.ver_status,
          s.department_sub,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,a.created_date,r.role,d.description AS department_name,s.name,s.department_id AS dept_code,s.role_id,
          a.id,a.staff_record_id,a.department_id,a.created_date,a.mec_date,a.total_claim,a.description,a.remarks,a.document_type,a.document_name,tm.id AS total_id,tm.jumlah_claim,tm.baki_claim
              FROM aims_lv_approve_medical app
              LEFT JOIN aims_lv_medical a ON a.id= app.medical_id
              LEFT JOIN staff_record sr ON sr.id=a.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN aims_lv_total_medical tm ON tm.staff_record_id = sr.id
              LEFT JOIN department d ON d.code_department=a.department_id 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE app.ver_status = 'VERIFIED'
			  AND a.department_id = '$department_code'
              ORDER BY a.created_date DESC";
//      AND s.status = 'BEKERJA'

      $result=$conn->query($sql);
      return $result; 
  }
  function getSenaraiMedicalDisapproved($department_code){
      $conn=db();
      
          $sql="SELECT app.id AS app_id,app.appcfo_name,app.appcfo_date,app.appcfo_status,app.app_name,app.app_date,app.app_status,app.ver_name,app.ver_date,app.ver_status,
          s.department_sub,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,a.created_date,r.role,d.description AS department_name,s.name,s.department_id AS dept_code,s.role_id,
          a.id,a.staff_record_id,a.department_id,a.created_date,a.mec_date,a.total_claim,a.description,a.remarks,a.document,a.document_type,a.document_name,tm.id AS total_id,tm.jumlah_claim,tm.baki_claim
              FROM aims_lv_approve_medical app
              LEFT JOIN aims_lv_medical a ON a.id= app.medical_id
              LEFT JOIN staff_record sr ON sr.id=a.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN aims_lv_total_medical tm ON tm.staff_record_id = sr.id
              LEFT JOIN department d ON d.code_department=a.department_id 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE app.ver_status = 'DISAPPROVED'
			  AND a.department_id = '$department_code'
              ORDER BY a.created_date DESC";
//      AND s.status = 'BEKERJA'

      $result=$conn->query($sql);
      return $result; 
  }
  
  	function getDropDownCompany($selected) {
		$conn=db();
		 $sql = "SELECT id,code_department,description FROM department WHERE status = '1'";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option ".($row[1] == $selected ? 'selected':'')." value=\"".$row[1]."\">".$row[2]."</option>";
		}
		//$conn->close();
		return $txt_result;
	}
	
	function getLampiranMedical($id){
        $conn=db();
        $sql=" SELECT id,document_name,document_type FROM aims_lv_medical WHERE id='$id'";
        $result=$conn->query($sql);
        return $result;  
    }
  
  function getSenaraiMedicalComplete($department_code){
      $conn=db();
      
          $sql="SELECT app.id AS app_id,app.appcfo_name,app.appcfo_date,app.appcfo_status,app.app_name,app.app_date,app.app_status,app.ver_name,app.ver_date,app.ver_status,
          s.department_sub,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,a.created_date,r.role,d.description AS department_name,s.name,s.department_id AS dept_code,s.role_id,
          a.id,a.staff_record_id,a.department_id,a.created_date,a.mec_date,a.total_claim,a.description,a.remarks,a.document_type,a.document_name,tm.id AS total_id,tm.jumlah_claim,tm.baki_claim
              FROM aims_lv_approve_medical app
              LEFT JOIN aims_lv_medical a ON a.id= app.medical_id
              LEFT JOIN staff_record sr ON sr.id=a.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN aims_lv_total_medical tm ON tm.staff_record_id = sr.id
              LEFT JOIN department d ON d.code_department=a.department_id
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE app.ver_status = 'COMPLETE' AND a.department_id = '$department_code'
              ORDER BY a.created_date DESC";
//      AND s.status = 'BEKERJA'

      $result=$conn->query($sql);
      return $result; 
  }
  
  function completeMedical($id){
       $conn=db();
       $sql="UPDATE aims_lv_approve_medical SET ver_status='COMPLETE' WHERE id='$id'";

      $result=$conn->query($sql);
      return $result; 
  }
  
  function getSenaraiMedicalTest($department_sub){
      $conn=db();
          $sql="SELECT app.id AS app_id,app.appcfo_name,app.appcfo_date,app.appcfo_status,app.app_name,app.app_date,app.app_status,app.ver_name,app.ver_date,app.ver_status,
          s.department_sub,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,a.created_date,r.role,d.description AS department_name,s.name,s.department_id AS dept_code,s.role_id,
          a.id,a.staff_record_id,a.department_id,a.created_date,a.mec_date,a.total_claim,a.description,a.remarks,a.document_type,a.document_name,tm.id AS total_id,tm.jumlah_claim,tm.baki_claim,a.dload_status
              FROM aims_lv_approve_medical app
              LEFT JOIN aims_lv_medical a ON a.id= app.medical_id
              LEFT JOIN staff_record sr ON sr.id=a.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN aims_lv_total_medical tm ON tm.staff_record_id = sr.id
              LEFT JOIN department d ON d.code_department=s.department_id 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE app.ver_status = 'PENDING'
              AND s.status = 'BEKERJA' AND a.document IS NOT NULL
              ORDER BY a.created_date DESC";

      $result=$conn->query($sql);
      return $result; 
  }

  function getSenaraiMedicalVerifiedTest(){
      $conn=db();
      
          $sql="SELECT app.id AS app_id,app.appcfo_name,app.appcfo_date,app.appcfo_status,app.app_name,app.app_date,app.app_status,app.ver_name,app.ver_date,app.ver_status,
          s.department_sub,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,a.created_date,r.role,d.description AS department_name,s.name,s.department_id AS dept_code,s.role_id,
          a.id,a.staff_record_id,a.department_id,a.created_date,a.mec_date,a.total_claim,a.description,a.remarks,a.document_type,a.document_name,tm.id AS total_id,tm.jumlah_claim,tm.baki_claim,a.dload_status
              FROM aims_lv_approve_medical app
              LEFT JOIN aims_lv_medical a ON a.id= app.medical_id
              LEFT JOIN staff_record sr ON sr.id=a.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN aims_lv_total_medical tm ON tm.staff_record_id = sr.id
              LEFT JOIN department d ON d.code_department=a.department_id 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE app.ver_status = 'VERIFIED'
              AND s.status = 'BEKERJA' AND a.document IS NOT NULL
              ORDER BY a.created_date DESC";

      $result=$conn->query($sql);
      return $result; 
  }
  function getSenaraiMedicalDisapprovedTest(){
      $conn=db();
      
          $sql="SELECT app.id AS app_id,app.appcfo_name,app.appcfo_date,app.appcfo_status,app.app_name,app.app_date,app.app_status,app.ver_name,app.ver_date,app.ver_status,
          s.department_sub,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,a.created_date,r.role,d.description AS department_name,s.name,s.department_id AS dept_code,s.role_id,
          a.id,a.staff_record_id,a.department_id,a.created_date,a.mec_date,a.total_claim,a.description,a.remarks,a.document_type,a.document_name,tm.id AS total_id,tm.jumlah_claim,tm.baki_claim,a.dload_status
              FROM aims_lv_approve_medical app
              LEFT JOIN aims_lv_medical a ON a.id= app.medical_id
              LEFT JOIN staff_record sr ON sr.id=a.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN aims_lv_total_medical tm ON tm.staff_record_id = sr.id
              LEFT JOIN department d ON d.code_department=a.department_id 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE app.ver_status = 'DISAPPROVED'
              AND s.status = 'BEKERJA' AND a.document IS NOT NULL
              ORDER BY a.created_date DESC";

      $result=$conn->query($sql);
      return $result; 
  }
  
  function getSenaraiMedicalCompleteTest(){
      $conn=db();
      
          $sql="SELECT app.id AS app_id,app.appcfo_name,app.appcfo_date,app.appcfo_status,app.app_name,app.app_date,app.app_status,app.ver_name,app.ver_date,app.ver_status,
          s.department_sub,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,a.created_date,r.role,d.description AS department_name,s.name,s.department_id AS dept_code,s.role_id,
          a.id,a.staff_record_id,a.department_id,a.created_date,a.mec_date,a.total_claim,a.description,a.remarks,a.document_type,a.document_name,tm.id AS total_id,tm.jumlah_claim,tm.baki_claim,a.dload_status
              FROM aims_lv_approve_medical app
              LEFT JOIN aims_lv_medical a ON a.id= app.medical_id
              LEFT JOIN staff_record sr ON sr.id=a.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN aims_lv_total_medical tm ON tm.staff_record_id = sr.id
              LEFT JOIN department d ON d.code_department=a.department_id
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE app.ver_status = 'COMPLETE' AND a.document IS NOT NULL
              AND s.status = 'BEKERJA'
              ORDER BY a.created_date DESC";

      $result=$conn->query($sql);
      return $result; 
  }
  
   function dload($id){
       $conn=db();
       $sql="UPDATE aims_lv_medical SET dload_status='DOWNLOADED' WHERE id='$id'";

      $result=$conn->query($sql);
      return $result; 
  }

	$conn->close();
	
?>