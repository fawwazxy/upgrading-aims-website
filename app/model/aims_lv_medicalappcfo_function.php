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
	
	function getMecListCeo() {
		$conn=db();
		$sql = "SELECT * FROM aims_lv_approve_medical ";
		$result = $conn->query($sql);
		return $result;
	}
	
	function listStaff($no_staff){
		$conn=db();
		$sql = "SELECT a.no_staff,b.* FROM staff_record a 
		LEFT JOIN aims_lv_medical b ON b.staff_record_id = a.id
		WHERE a.no_staff='$no_staff'";
		$result = $conn->query($sql);
		return $result;
	}
	
	
	function listcfo(){
		$conn=db();
		$sql = "SELECT a.id,s.name,s.noic,s.role_id,s.department_id,d.code_department AS company_name,a.mec_date,a.staff_record_id,a.description, a.total_claim,a.remarks,ap.ver_date,ap.ver_status,ap.ver_name,ap.app_status,ap.app_name,ap.app_date,ap.appcfo_status,ap.appcfo_name,ap.appcfo_date, a.document,a.document_type,a.document_name, tm.entitle_medical,tm.jumlah_claim,tm.baki_claim
		FROM aims_lv_medical a
		LEFT JOIN staff_record c ON a.staff_record_id=c.id
		LEFT JOIN aims_lv_approve_medical ap ON ap.medical_id = a.id
		LEFT JOIN aims_lv_total_medical tm ON tm.staff_record_id = a.staff_record_id
		LEFT JOIN staff s ON c.no_staff=s.no_staff
		LEFT JOIN department d ON d.code_department=s.department_id
		WHERE ap.ver_status = 'VERIFIED' ORDER BY mec_date DESC";
		$result = $conn->query($sql);
		return $result;
	}
	
	function updateStaff($appcfo_status,$appcfo_name,$id){
    $conn=db();
    $sql = "UPDATE aims_lv_approve_medical SET appcfo_status='$appcfo_status', appcfo_name='$appcfo_name' , appcfo_date = CURRENT_TIMESTAMP WHERE id='$id'";
	$result = $conn->query($sql);
	return $result;
	}
    
	function getStaffById($id){
		$conn=db();
		$sql = "SELECT * FROM aims_lv_approve_medical WHERE medical_id = '$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	
	function getLampiranMedical($id){
        $conn=db();
        $sql=" SELECT id,document_name,document_type FROM aims_lv_medical WHERE id='$id'";
        $result=$conn->query($sql);
        return $result;  
    }
	
	function getStaffInformation($no_staff){
        $conn=db();
        $sql = "SELECT MAX(sr.id),sr.*,d.code_department AS company_name,d.description AS department_name,s.alamat_tetap,s.role_id,s.department_sub,s.noic,s.phone,s.email,s.alamat_surat,s.name AS staff_name,dl.code_department AS department_name, r.role,stc.*
                FROM staff_record sr 
                LEFT JOIN staff s ON s.no_staff=sr.no_staff 
                LEFT JOIN department d ON d.code_department=s.department_id 
                LEFT JOIN role r ON sr.peranan=r.code
				LEFT JOIN department_load dl ON dl.code_department=s.department_sub
                LEFT JOIN staff_total_cuti stc ON sr.id=stc.staff_record_id
                WHERE s.status = 'BEKERJA' AND s.noic IS NOT NULL 
                AND s.no_staff='$no_staff'"; 
        $result = $conn->query($sql);
  	    return $result;        
    }
	
	function getStaffMedicalById($id){
        $conn=db();
        $sql = "SELECT a.no_staff,d.noic,d.role_id,d.department_id,d.name,b.total_claim,c.* 
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

function getSenaraiMedicalBaru(){
      $conn=db();
          $sql="SELECT app.*,s.department_sub,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,d.description AS department_name,s.name,s.department_id AS dept_code,s.role_id,a.id,a.staff_record_id,a.department_id,a.created_date,a.mec_date,a.total_claim,a.description,a.remarks,a.document_type,a.document_name,tm.id AS total_id,tm.jumlah_claim,tm.baki_claim
              FROM aims_lv_approve_medical app
              LEFT JOIN aims_lv_medical a ON a.id= app.medical_id
              LEFT JOIN staff_record sr ON sr.id=a.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN aims_lv_total_medical tm ON tm.staff_record_id = sr.id
              LEFT JOIN department d ON d.code_department=s.department_id 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE app.ver_status = 'VERIFIED' AND app.appcfo_status = 'PENDING'
              AND s.status = 'BEKERJA'
              ORDER BY a.mec_date DESC";

      $result=$conn->query($sql);
      return $result; 
  }

  function getSenaraiMedicalLulus(){
      $conn=db();
      
          $sql="SELECT app.*,s.department_sub,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,d.description AS department_name,s.name,s.department_id AS dept_code,s.role_id,a.id,a.staff_record_id,a.department_id,a.created_date,a.mec_date,a.total_claim,a.description,a.remarks,a.document_type,a.document_name,tm.id AS total_id,tm.jumlah_claim,tm.baki_claim
              FROM aims_lv_approve_medical app
              LEFT JOIN aims_lv_medical a ON a.id= app.medical_id
              LEFT JOIN staff_record sr ON sr.id=a.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN aims_lv_total_medical tm ON tm.staff_record_id = sr.id
              LEFT JOIN department d ON d.code_department=s.department_id 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE app.appcfo_status = 'APPROVED'
              AND s.status = 'BEKERJA'
              ORDER BY a.mec_date DESC";

      $result=$conn->query($sql);
      return $result; 
  }

  function getSenaraiMedicalTidakLulus(){
      $conn=db();
      
          $sql="SELECT app.*,s.department_sub,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,d.description AS department_name,s.name,s.department_id AS dept_code,s.role_id,a.id,a.staff_record_id,a.department_id,a.created_date,a.mec_date,a.total_claim,a.description,a.remarks,a.document_type,a.document_name,tm.id AS total_id,tm.jumlah_claim,tm.baki_claim
              FROM aims_lv_approve_medical app
              LEFT JOIN aims_lv_medical a ON a.id= app.medical_id
              LEFT JOIN staff_record sr ON sr.id=a.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN aims_lv_total_medical tm ON tm.staff_record_id = sr.id
              LEFT JOIN department d ON d.code_department=s.department_id 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE app.appcfo_status = 'DISAPPROVED'
              AND s.status = 'BEKERJA'
              ORDER BY a.mec_date DESC";

      $result=$conn->query($sql);
      return $result; 
  }
  
  function getCheckboxUpdateMedicalCfo($id,$staff_name){
	$conn=db();
	if(isset($_POST['checkbox'])){
	    $checkbox = $_POST['checkbox'];
    	if(isset($_POST['activate'])?$activate = $_POST["activate"]:$deactivate = $_POST["deactivate"])
    		$id = "('" . implode( "','", $checkbox ) . "');" ;
    	$sql="UPDATE aims_lv_approve_medical SET appcfo_status = '".(isset($activate)?'APPROVED':'DISAPPROVED')."',appcfo_name='$staff_name',appcfo_date=CURRENT_TIMESTAMP WHERE medical_id IN $id" ;
    	$result=$conn->query($sql);
    	return $result;
    }
}
	
	$conn->close();
	
?>