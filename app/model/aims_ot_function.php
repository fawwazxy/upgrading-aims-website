<?php

	require '../../lib/db/connection.php';
	
	
	$action = $_POST['action'];
	//hr update
   if ($action=="update_otherclaim") {
    
	
	$date_ot = $_POST['date_ot'];
	$day_ot = $_POST['day_ot'];
	$start_ot = $_POST['start_ot'];
	$end_ot = $_POST['end_ot'];
	$working_hours = $_POST['working_hours'];
	$month_claim = $_POST['month_claim'];
	$description_ot = $_POST['description_ot'];
	$description_ot = str_replace("'", "", $description_ot);
	$review_remark = $_POST['review_remark'];
	$review_remark = str_replace("'", "", $review_remark);
	$id = $_POST['id'];
	
	$conn=db();
	
	if($id > 0 ){
      //need insert new data
	  $sql = "UPDATE aims_ot SET working_hours='$working_hours',month_claim='$month_claim',description_ot='$description_ot',
	  review_remark= UPPER('$review_remark') WHERE id='$id'";
			$result = $conn->query($sql) or die($conn->error);
			echo "Data berjaya dikemaskini";
     
    }else{
      echo "Data tidak berjaya dikemaskini";
    }
  }
  
 
  else if($action == "del_claim"){
		$id = $_POST['id'];
		
		$conn=db();
		$sql = "DELETE FROM aims_ot WHERE id = '$id'";
		$result = $conn->query($sql);
	}
	
    
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
//OT PERMISSION SECTION
	function addOtPermission($no_staff,$staff_name,$hod_name,$code_department,$otp_date,$otp_description) {
		$conn=db();
		$sql = "INSERT INTO aims_ot_permission(no_staff,staff_name,hod_name,code_department,otp_date,otp_description) VALUES 
		('$no_staff','$staff_name','$hod_name','$code_department','$otp_date','$otp_description')";
		$result = $conn->query($sql);
		
		$otp_id=$conn->insert_id;
		$sql = "INSERT INTO aims_ot_permission_approval(otp_id,no_staff) VALUES ('$otp_id','$no_staff')";	
		$result = $conn->query($sql);
		return $result;
	}
	
	function getOtPermissionList($no_staff,$otp_year,$otp_month){
    $conn=db();
    $sql = "SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
			FROM aims_ot_permission otp
			LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
			LEFT JOIN staff b ON b.no_staff = otp.no_staff
			LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
			WHERE otp.no_staff = '$no_staff'
			AND YEAR(otp.otp_date) = '$otp_year'
			AND MONTH(otp.otp_date) = '$otp_month'
			ORDER BY otp.created_date DESC";
	$result = $conn->query($sql);
	return $result;
	}
	
	function getOtPermissionById($id){
    $conn=db();
    $sql = "SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
			FROM aims_ot_permission otp
			LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
			LEFT JOIN staff b ON b.no_staff = otp.no_staff
			LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
			WHERE otp.id = '$id'";
	$result = $conn->query($sql);
	return $result;
	}
	
	function getStaffInformation($no_staff){
    $conn=db();
    $sql = "SELECT b.name,b.no_staff,b.department_id,b.department_sub,b.role_id,b.noic
			FROM aims_ot_permission otp
			LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
			LEFT JOIN staff b ON b.no_staff = otp.no_staff
			LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
			WHERE otp.no_staff = '$no_staff'";
	$result = $conn->query($sql);
	return $result;
	}
	
	function updateOtPermission($hod_name,$otp_date,$otp_description,$id){
    $conn=db();
    $sql = "UPDATE aims_ot_permission SET hod_name='$hod_name', otp_date='$otp_date', otp_description='$otp_description' WHERE id='$id'";
	$result = $conn->query($sql);
	return $result;
	}
	
	function deleteOtPermission($id){
		$conn=db();
		$sql = "DELETE FROM aims_ot_permission_approval WHERE otp_id = '$id'";
		$result = $conn->query($sql);
		
		$sql = "DELETE FROM aims_ot_permission WHERE id = '$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	
	function getDropDownMonth($selected) {
		$conn=db();
		$no_staff = $_SESSION['SESS_NO_STAFF'];
		
		 $sql = "SELECT month_num, month_description FROM aims_month ORDER BY month_num ASC";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
		}
		
		//$conn->close();
		return $txt_result;
	}
	
	function getDropDownYear($selected) {
		$conn=db();
		$no_staff = $_SESSION['SESS_NO_STAFF'];
		
		 $sql = "SELECT MONTH(otp_date), YEAR(otp_date) FROM aims_ot_permission WHERE no_staff='$no_staff' 
		 GROUP BY YEAR(otp_date) ORDER BY YEAR(otp_date) DESC";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option ".($row[1] == $selected ? 'selected':'')." value=\"".$row[1]."\">".$row[1]."</option>";
		}
		
		//$conn->close();
		return $txt_result;
	}
	
	//OT PERMISSION APPROVED VIEW
	function getOtPermissionPending($department_sub,$leave_approval){
      $conn=db();
	  $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
	  
	  
	/*  if($role_id == 'HOD' && $department_sub == 'FINACC'){
      $sql="SELECT a.* ,b.verified,b.verified_name,b.verified_date,b.approve,b.approve_name,b.approved_date,d.name,d.noic,d.department_id,d.department_sub,d.company_id,b.reason FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE b.approve='PENDING'
		AND b.verified = 'APPROVE'
		AND d.department_sub='$department_sub'
		AND d.department_sub <>'FINACC'
		ORDER BY a.date_mohon DESC";
       
	  } */
	  
	  if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMHESB'){
      $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND b.department_sub = 'OPERATION-AGMHESB'
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
       
	  }
	  
	  else if( $role_id == 'MANAGING-DIRECTOR' ) {
          $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
	 	AND b.no_staff IN ('860620295410','850126115526','930128016820','690615115252')
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
		}
		//AND (b.department_sub IN ('PROCUREMENT-AVSB','CORPADMIN-AVSB','COMMERCIAL-AVSB','CATERING','LOGISTIC') OR b.no_staff IN ('INDEEP0311','911011115100'))
		
		
		//otp kak siha approved
		else if( $role_id == 'OPERATIONMANAGER' ) {
          $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
    	AND (b.leave_approval = '$leave_approval' OR b.no_staff IN ('INDEEP0311'))
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
		}
// 		AND (b.department_sub IN ('OPERATION-AVSB','OPERATIONFAC-AVSB','OPERATIONFOOD-AVSB','PROCUREMENT-AVSB','CORPADMIN-AVSB','COMMERCIAL-AVSB','CATERING','LOGISTIC') OR b.no_staff IN ('INDEEP0311','911011115100'))
		
		//otp kak rini approved
		else if( $role_id == 'HOC' ) {
          $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND b.department_id = 'TKSB'
		AND b.no_staff NOT IN ('$leave_approval','901118115427')
		ORDER BY otp.created_date DESC";
		}
		
		//otp assistant manager approved   IC tu ic syahin commercial tksb
		else if( $role_id == 'ASSISTANT-MANAGER' ) {
          $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND b.no_staff = '901118115427'
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
		}
		
		//otp en alias approved
		else if ($leave_approval == '810415035497'){
	    $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
        AND b.department_sub = 'MARKETING&BUSINESS-DEV'
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
			  
		}
	  
	   //otpermission ceo approve
	  else if($leave_approval == '751206035485'){
      $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND b.role_id IN ('HOD','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR','MANAGER','OPERATIONMANAGER','HOC')
		AND b.department_sub <> 'OPERATION-AGMHESB'
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
       
	  }
	  //cfo approve hod finance
	  else if($role_id == 'CFO'){
      $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND b.role_id IN ('HOD')
		AND b.department_sub = 'FINACC'
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
       
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'HR'){
      $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND b.no_staff <> '$leave_approval'
		AND b.department_sub IN ('HR', 'HR-SEA', 'ECOFFICE')
		ORDER BY otp.created_date DESC";
       
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB'){
      $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND b.no_staff <> '$leave_approval'
		AND b.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')
		ORDER BY otp.created_date DESC";
       
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'TECHOPERATION'){
      $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND b.no_staff <> '$leave_approval'
		AND b.department_sub IN ('TECHOPERATION','PILOT-BOAT','MOORING-GANG')
		ORDER BY otp.created_date DESC";
       
	  }
	  
// 	  else if($role_id == 'HOD' && $department_sub == 'CORPADMIN'){
//       $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
// 		FROM aims_ot_permission otp
// 		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
// 		LEFT JOIN staff b ON b.no_staff = otp.no_staff
// 		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
// 		WHERE a.approved_status='PENDING'
// 		AND a.approved_status <> 'APPROVED'
// 		AND b.no_staff <> '$leave_approval'
// 		AND b.department_sub IN ('CORPADMIN','IT')
// 		ORDER BY otp.created_date DESC";
       
// 	  }
	  /* no staff finance avsb */
	  else if($role_id == 'HOD'){
      $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND b.department_sub='$department_sub'
		AND b.no_staff <> '$leave_approval'
		AND b.no_staff <> 'INDEEP0311'
		AND b.department_sub <> 'HR'
		AND b.department_sub <> 'OPERATION-AGMHESB'
		AND b.department_sub <> 'TECHOPERATION'
		AND b.department_sub <> 'PILOT-BOAT'
		AND b.department_sub <> 'MOORING-GANG'
		ORDER BY otp.created_date DESC";
       
	  }
	  
	  else{
		  
	/*	  $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND b.leave_approval = '$leave_approval'
		ORDER BY otp.created_date DESC"; */
        
	  }
	  $result=$conn->query($sql);
       return $result; 
  }
  
  function getOtPermissionApproved($department_sub,$leave_approval){
      $conn=db();
	  $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
	  
	  
	  if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMHESB'){
      $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='APPROVED'
		AND a.approved_status <> 'PENDING'
		AND b.department_sub = 'OPERATION-AGMHESB'
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
       
	  }
	  
	  else if( $role_id == 'MANAGING-DIRECTOR' ) {
          $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='APPROVED'
		AND a.approved_status <> 'PENDING'
		AND b.department_sub = 'SECRETARY-AVSB'
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
		}
		//otp kak siha approved
		else if( $role_id == 'OPERATIONMANAGER' ) {
          $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='APPROVED'
		AND a.approved_status <> 'PENDING'
		AND (b.leave_approval = '$leave_approval' OR b.no_staff IN ('INDEEP0311'))
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
		}
// 		AND (b.department_sub IN ('OPERATION-AVSB','OPERATIONFAC-AVSB','OPERATIONFOOD-AVSB','PROCUREMENT-AVSB','CORPADMIN-AVSB','COMMERCIAL-AVSB','CATERING','LOGISTIC') OR b.no_staff IN ('INDEEP0311','911011115100'))
		
			//otp kak rini approved
		else if( $role_id == 'HOC' ) {
          $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='APPROVED'
		AND a.approved_status <> 'PENDING'
		AND b.department_id = 'TKSB'
		AND b.no_staff NOT IN ('$leave_approval','901118115427')
		ORDER BY otp.created_date DESC";
		}
		
		//otp assistant manager approved   IC tu ic syahin commercial tksb
		else if( $role_id == 'ASSISTANT-MANAGER' ) {
          $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='APPROVED'
		AND a.approved_status <> 'PENDING'
		AND b.no_staff = '901118115427'
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
		}
		
		//en alias
		else if ($leave_approval == '810415035497'){
	    $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='APPROVED'
		AND a.approved_status <> 'PENDING'
        AND b.department_sub = 'MARKETING&BUSINESS-DEV'
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
			  
		}
	  
	  //otpermission ceo approve
	  else if($leave_approval == '751206035485'){
      $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='APPROVED'
		AND a.approved_status <> 'PENDING'
		AND b.role_id IN ('HOD','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR','MANAGER','OPERATIONMANAGER','HOC')
		AND b.department_sub <> 'OPERATION-AGMHESB'
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
       
	  }
	  
	  //cfo approve hod finance
	  else if($role_id == 'CFO'){
      $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='APPROVED'
		AND a.approved_status <> 'PENDING'
		AND b.role_id IN ('HOD')
		AND b.department_sub = 'FINACC'
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
       
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'HR'){
      $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='APPROVED'
		AND a.approved_status <> 'PENDING'
		AND b.no_staff <> '$leave_approval'
		AND b.department_sub IN ('HR', 'HR-SEA', 'ECOFFICE')
		ORDER BY otp.created_date DESC";
       
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB'){
      $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='APPROVED'
		AND a.approved_status <> 'PENDING'
		AND b.no_staff <> '$leave_approval'
		AND b.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')
		ORDER BY otp.created_date DESC";
       
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'TECHOPERATION'){
      $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='APPROVED'
		AND a.approved_status <> 'PENDING'
		AND b.no_staff <> '$leave_approval'
		AND b.department_sub IN ('TECHOPERATION','PILOT-BOAT','MOORING-GANG')
		ORDER BY otp.created_date DESC";
       
	  }
// 	  else if($role_id == 'HOD' && $department_sub == 'CORPADMIN'){
//       $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
// 		FROM aims_ot_permission otp
// 		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
// 		LEFT JOIN staff b ON b.no_staff = otp.no_staff
// 		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
// 		WHERE a.approved_status='APPROVED'
// 		AND a.approved_status <> 'PENDING'
// 		AND b.no_staff <> '$leave_approval'
// 		AND b.department_sub IN ('CORPADMIN','IT')
// 		ORDER BY otp.created_date DESC";
       
// 	  }
	  
	  else if($role_id == 'HOD'){
      $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='APPROVED'
		AND a.approved_status <> 'PENDING'
		AND b.department_sub='$department_sub'
		AND b.no_staff <> '$leave_approval'
		AND b.department_sub <> 'HR'
		AND b.department_sub <> 'OPERATION-AGMHESB'
		AND b.department_sub <> 'TECHOPERATION'
		AND b.department_sub <> 'PILOT-BOAT'
		AND b.department_sub <> 'MOORING-GANG'
		ORDER BY otp.created_date DESC";
       
	  }
	  
	  else{
		  
	/*	  $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='APPROVED'
		AND a.approved_status <> 'PENDING'
		AND b.leave_approval = '$leave_approval'
		ORDER BY otp.created_date DESC";
        */
	  }
	  $result=$conn->query($sql);
       return $result; 
  }
  
  function getOtPermissionDisapproved($department_sub,$leave_approval){
      $conn=db();
	  $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
	  
	  
	  if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMHESB'){
      $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='DISAPPROVED'
		AND a.approved_status <> 'PENDING'
		AND b.department_sub = 'OPERATION-AGMHESB'
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
       
	  }
	  
	  else if( $role_id == 'MANAGING-DIRECTOR' ) {
          $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='DISAPPROVED'
		AND a.approved_status <> 'PENDING'
		AND b.department_sub = 'SECRETARY-AVSB'
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
		}
		//otp kak siha approved
		else if( $role_id == 'OPERATIONMANAGER' ) {
          $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='DISAPPROVED'
		AND a.approved_status <> 'PENDING'
		AND b.leave_approval = '$leave_approval'
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
		}
// 		AND (b.department_sub IN ('OPERATION-AVSB','OPERATIONFAC-AVSB','OPERATIONFOOD-AVSB','PROCUREMENT-AVSB','CORPADMIN-AVSB','COMMERCIAL-AVSB','CATERING','LOGISTIC') OR b.no_staff IN ('INDEEP0311','911011115100'))
		
			//otp kak rini approved
		else if( $role_id == 'HOC' ) {
          $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='DISAPPROVED'
		AND a.approved_status <> 'PENDING'
		AND b.department_id = 'TKSB'
		AND b.no_staff NOT IN ('$leave_approval','901118115427')
		ORDER BY otp.created_date DESC";
		}
		
		//otp assistant manager approved   IC tu ic syahin commercial tksb
		else if( $role_id == 'ASSISTANT-MANAGER' ) {
          $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='DISAPPROVED'
		AND a.approved_status <> 'PENDING'
		AND b.no_staff = '901118115427'
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
		}
		
		//en alias
		else if ($leave_approval == '810415035497'){
	    $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='DISAPPROVED'
		AND a.approved_status <> 'PENDING'
        AND b.department_sub = 'MARKETING&BUSINESS-DEV'
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
			  
		}
	  
	  //otpermission ceo approve
	  else if($leave_approval == '751206035485'){
      $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='DISAPPROVED'
		AND a.approved_status <> 'PENDING'
		AND b.role_id IN ('HOD','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR','MANAGER','OPERATIONMANAGER','HOC')
		AND b.department_sub <> 'OPERATION-AGMHESB'
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
       
	  }
	  
	  //cfo approve hod finance
	  else if($role_id == 'CFO'){
      $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='DISAPPROVED'
		AND a.approved_status <> 'APPROVED'
		AND b.role_id IN ('HOD')
		AND b.department_sub = 'FINACC'
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
       
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'HR'){
      $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='DISAPPROVED'
		AND a.approved_status <> 'PENDING'
		AND b.no_staff <> '$leave_approval'
		AND b.department_sub IN ('HR', 'HR-SEA', 'ECOFFICE')
		ORDER BY otp.created_date DESC";
       
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB'){
      $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='DISAPPROVED'
		AND a.approved_status <> 'PENDING'
		AND b.no_staff <> '$leave_approval'
		AND b.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')
		ORDER BY otp.created_date DESC";
       
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'TECHOPERATION'){
      $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='DISAPPROVED'
		AND a.approved_status <> 'PENDING'
		AND b.no_staff <> '$leave_approval'
		AND b.department_sub IN ('TECHOPERATION','PILOT-BOAT','MOORING-GANG')
		ORDER BY otp.created_date DESC";
       
	  }
	  
// 	  else if($role_id == 'HOD' && $department_sub == 'CORPADMIN'){
//       $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
// 		FROM aims_ot_permission otp
// 		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
// 		LEFT JOIN staff b ON b.no_staff = otp.no_staff
// 		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
// 		WHERE a.approved_status='DISAPPROVED'
// 		AND a.approved_status <> 'PENDING'
// 		AND b.no_staff <> '$leave_approval'
// 		AND b.department_sub IN ('CORPADMIN','IT')
// 		ORDER BY otp.created_date DESC";
       
// 	  }
	  
	  else if($role_id == 'HOD'){
      $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='DISAPPROVED'
		AND a.approved_status <> 'PENDING'
		AND b.department_sub='$department_sub'
		AND b.no_staff <> '$leave_approval'
		AND b.department_sub <> 'HR'
		AND b.department_sub <> 'OPERATION-AGMHESB'
		AND b.department_sub <> 'TECHOPERATION'
		AND b.department_sub <> 'PILOT-BOAT'
		AND b.department_sub <> 'MOORING-GANG'
		ORDER BY otp.created_date DESC";
       
	  }
	  
	  else{
		  
	/*	  $sql="SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='DISAPPROVED'
		AND a.approved_status <> 'PENDING'
		AND b.leave_approval = '$leave_approval'
		ORDER BY otp.created_date DESC";
        */
	  }
	  $result=$conn->query($sql);
       return $result; 
  }
	
	function remarkOtPermission($id,$otp_remark){
    $conn=db();
    $sql = "UPDATE aims_ot_permission SET otp_remark='$otp_remark' WHERE id='$id'";
	$result = $conn->query($sql);
	return $result;
	}
	
	function approveOtPermission($id,$approved_by,$approved_status){
    $conn=db();
    $sql = "UPDATE aims_ot_permission_approval SET approved_by='$approved_by',approved_status='$approved_status',approved_date=CURRENT_TIMESTAMP 
	WHERE otp_id='$id'";
	$result = $conn->query($sql);
	return $result;
	}
	
	function getCheckboxApproveOtp($id,$staff_name){
	$conn=db();
	if(isset($_POST['checkbox'])){
	    $checkbox = $_POST['checkbox'];
    	if(isset($_POST['activate'])?$activate = $_POST["activate"]:$deactivate = $_POST["deactivate"])
    		$id = "('" . implode( "','", $checkbox ) . "');" ;
    	$sql="UPDATE aims_ot_permission_approval SET approved_status = '".(isset($activate)?'APPROVED':'DISAPPROVED')."',approved_by='$staff_name',approved_date=CURRENT_TIMESTAMP WHERE id IN $id" ;
    	$result=$conn->query($sql);
    	return $result;
    }
    }
    
    
    function getOtPermissionHr($department_sub,$department_id,$otp_year,$otp_month){
    $conn=db();
    
			if ( $department_sub == 'HR' ) {
            $sql = "SELECT otp.*,a.id AS otpapp_id,a.approved_by,a.approved_date,a.approved_status,b.department_id
        			FROM aims_ot_permission otp
        			LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
        			LEFT JOIN staff b ON b.no_staff = otp.no_staff
        			LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
        			WHERE b.department_id = '$department_id'
        			AND YEAR(otp.otp_date) = '$otp_year'
        			AND MONTH(otp.otp_date) = '$otp_month'
        			AND a.approved_status = 'APPROVED'
        			ORDER BY otp.created_date DESC";
        	}
        	else{
        		echo ("<script LANGUAGE='JavaScript'>
        						window.location.href='../view/aims_ot_message.php';
        						</script>");
        	}
        	$result = $conn->query($sql);
        	return $result;
	}
	
	function getDropDownMonthHr($selected) {
		$conn=db();
		$no_staff = $_SESSION['SESS_NO_STAFF'];
		
		 $sql = "SELECT month_num, month_description FROM aims_month ORDER BY month_num ASC";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
		}
		
		//$conn->close();
		return $txt_result;
	}
	
	function getDropDownYearHr($selected) {
		$conn=db();
		
		
		 $sql = "SELECT MONTH(otp_date), YEAR(otp_date) FROM aims_ot_permission GROUP BY YEAR(otp_date) ORDER BY YEAR(otp_date) DESC";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option ".($row[1] == $selected ? 'selected':'')." value=\"".$row[1]."\">".$row[1]."</option>";
		}
		
		//$conn->close();
		return $txt_result;
	}
	
	
	function getDropDownStaff($selected) {
  	$conn=db();
  	$sql = "SELECT s.name,s.role_id FROM staff s
			LEFT JOIN role r ON s.role_id = r.code
			WHERE r.status_pelulus_cuti = '1' 
			AND s.status = 'BEKERJA'
			ORDER BY s.name";
  	$result = $conn->query($sql);
  
  	$txt_result="";
  		while ($row  = $result -> fetch_array()){
    	$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
  	}
  //$conn->close();
  return $txt_result;
    }
	
	
	
//OT FORM SECTION 

    //column $staff_name,$icno,$company_id,$position,$month_claim,$date_ot,$day_ot,$start_ot,$end_ot,$working_hours,$type_claim,$description_ot,
	//$total_hours,$total_rates,$total_monthclaim,$review_remark,$created_date,$no_staff,$staff_record_id
	
	function addOt($staff_name,$icno,$company_id,$position,$month_claim,$date_ot,$day_ot,$start_ot,$end_ot,$working_hours,$type_claim,$description_ot,$no_staff,$staff_record_id,$document_name,$document_type,$document_size) {
		$conn=db();
		if($no_staff == '751206035485'|| $no_staff == '660512115105' || $no_staff == '000701110342'){
		$gambar = '';
        $gambar_val = '';
        if($document_name!=""){
            $gambar=" ,document_name,document_type,document_size";
            $gambar_val=",'$document_name','$document_type','$document_size'";
        }
		$sql = "INSERT INTO aims_ot(staff_name,icno,company_id,position,month_claim,date_ot,day_ot,start_ot,end_ot,working_hours,type_claim,description_ot,no_staff,staff_record_id$gambar)
		VALUES ('$staff_name','$icno','$company_id','$position','$month_claim','$date_ot','$day_ot','$start_ot','$end_ot','$working_hours','$type_claim','$description_ot','$no_staff','$staff_record_id'$gambar_val)";
		$result = $conn->query($sql);
		
		$ot_id=$conn->insert_id;
		$sql = "INSERT INTO aims_ot_approval(ot_id,no_staff,verify_by,verify_date,verify_status) VALUES ('$ot_id','$no_staff','AUTO VERIFIED',CURRENT_TIMESTAMP,'VERIFIED')";
		
		}
		
		else {
		$gambar = '';
        $gambar_val = '';
        if($document_name!=""){
            $gambar=" ,document_name,document_type,document_size";
            $gambar_val=",'$document_name','$document_type','$document_size'";
        }
		$sql = "INSERT INTO aims_ot(staff_name,icno,company_id,position,month_claim,date_ot,day_ot,start_ot,end_ot,working_hours,type_claim,description_ot,no_staff,staff_record_id$gambar)
		VALUES ('$staff_name','$icno','$company_id','$position','$month_claim','$date_ot','$day_ot','$start_ot','$end_ot','$working_hours','$type_claim','$description_ot','$no_staff','$staff_record_id'$gambar_val)";
		$result = $conn->query($sql);
		
		$ot_id=$conn->insert_id;
		$sql = "INSERT INTO aims_ot_approval(ot_id,no_staff) VALUES ('$ot_id','$no_staff')";	
		}
		$result = $conn->query($sql);
		return $result;
	}
		
	
	function getOtList($no_staff){
		$conn=db();
		
		$sql = "SELECT ot.*,a.id AS otapp_id,a.verify_by,a.verify_date,a.verify_status,a.review_by,a.review_date,a.review_status,a.approved_by,a.approved_date,a.approved_status,a.payment_status
				FROM aims_ot ot
				LEFT JOIN aims_ot_approval a ON a.ot_id = ot.id
				LEFT JOIN staff b ON b.no_staff = ot.no_staff
				LEFT JOIN staff_record c ON c.id = ot.staff_record_id
				WHERE ot.no_staff = '$no_staff' ORDER BY ot.date_ot DESC";
		$result = $conn->query($sql);
		return $result;
	}
		
	function getOtStaffInfo($no_staff){
		$conn=db();
		
		$sql = "SELECT s.*,a.id AS staff_record_id FROM staff s 
				LEFT JOIN staff_record a ON a.no_staff = s.no_staff
				WHERE s.no_staff = '$no_staff'";
		$result = $conn->query($sql);
		return $result;
	}
		
	function getOtById($id){
    $conn=db();
    $sql = "SELECT ot.*,a.id AS ot_id,a.verify_by,a.verify_date,a.verify_status,a.review_by,a.review_date,a.review_status,a.approved_by,a.approved_date,a.approved_status
			FROM aims_ot ot
			LEFT JOIN aims_ot_approval a ON a.ot_id = ot.id
			LEFT JOIN staff b ON b.no_staff = ot.no_staff
			LEFT JOIN staff_record c ON c.no_staff = ot.no_staff
			WHERE ot.id = '$id'";
	$result = $conn->query($sql);
	return $result;
	}	
		
	
	function updateOt($position,$month_claim,$date_ot,$day_ot,$start_ot,$end_ot,$working_hours,$type_claim,$description_ot,$id){
    $conn=db();
    $sql = "UPDATE aims_ot SET position='$position', month_claim='$month_claim', date_ot='$date_ot', day_ot='$day_ot', start_ot='$start_ot', end_ot='$end_ot', 
	working_hours='$working_hours', type_claim='$type_claim', description_ot='$description_ot' WHERE id='$id'";
	$result = $conn->query($sql);
	return $result;
	}
		
	function deleteOt($id){
		$conn=db();
		$sql = "DELETE FROM aims_ot_approval WHERE ot_id = '$id'";
		$result = $conn->query($sql);
		
		$sql = "DELETE FROM aims_ot WHERE id = '$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getOtDocInfo($id){
	$conn=db();
	$sql = "SELECT document_name FROM aims_ot WHERE id='$id'";
	$result = $conn->query($sql);
	return $result;
    }
	
	function getLampiranInfo($id){
        $conn=db();
        $sql=" SELECT id,staff_record_id,no_staff,document_name,document_type,document_size FROM aims_ot
                WHERE id='$id'";
        $result=$conn->query($sql);
        return $result;  
    }
    
    
    function getOtStaffNew($no_staff) {
    $conn=db();
	
    $sql = "SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON a.id = ap.ot_id
			WHERE a.no_staff = '$no_staff'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";

    
    $result = $conn->query($sql);
    return $result;
  }
	
	
	function getDropDownMonthHuruf($selected) {
		$conn=db();
		$no_staff = $_SESSION['SESS_NO_STAFF'];
		
		 $sql = "SELECT month_description FROM aims_month ORDER BY month_num ASC";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
		}
		
		//$conn->close();
		return $txt_result;
	}
	
	
	
	//OT FORM VERIFY HOD VIEW
	function getOtForHod($department_sub,$leave_approval) {
    $conn=db();
	$sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
    $role_id=$conn->query($sql)->fetch_object()->role_id;
	  
	  
	  //cfo verify ot form
	  if($role_id == 'CFO'){
      $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND s.department_sub = 'FINACC' AND s.no_staff <> 'INDEEP0311'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
	  } 
	  //kak lana     86-ic hoc  85-ic OM  93-ic secrertaryavsb
	  else if( $role_id == 'MANAGING-DIRECTOR' ) {
          $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND s.no_staff IN ('860620295410','850126115526','930128016820','690615115252')
			AND s.no_staff <> '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
		}
		//                 no staff finance avsb
 		else if( $role_id == 'OPERATIONMANAGER' ) {
           $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
 			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
 			a.month_claim,YEAR(a.created_date) AS tahun,a.position
 			FROM staff s
 			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
 			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
 			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
 			WHERE ap.verify_status = 'PENDING'
 			AND ap.verify_status <> 'VERIFIED'
 			AND (s.leave_approval = '$leave_approval' OR s.no_staff IN ('INDEEP0311'))
 			AND s.no_staff NOT IN ('$leave_approval','901118115427')
 			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
 			ORDER BY a.created_date DESC";
 		}
		
		//hoc kak rini verify tksb
/*		else if( $role_id == 'HOC' ) {
          $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND (s.department_sub IN ('OPERATION-TKSB','QR&D-TKSB') OR s.no_staff = '901118115427')
			AND s.no_staff <> '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
		} */
		
		// en alias verify ot
		else if ($leave_approval == '810415035497'){
		      $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
            AND s.department_sub = 'MARKETING&BUSINESS-DEV'
			AND s.no_staff <> '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
			  
		}
	  
	  else if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMHESB'){
      $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND s.department_sub = 'OPERATION-AGMHESB'
			AND s.no_staff <> '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
	  }
	  
	   //ot form ceo verify
	  else if($leave_approval == '751206035485'){
      $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND s.role_id IN ('HOD','MANAGER','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR')
			AND s.department_sub <> 'OPERATION-AGMHESB'
			AND s.no_staff <> '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'HR'){
      $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND s.no_staff <> '$leave_approval'
			AND s.department_sub IN ('HR', 'HR-SEA', 'ECOFFICE')
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB'){
      $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND s.no_staff <> '$leave_approval'
			AND s.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
       
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'TECHOPERATION'){
      $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND s.no_staff <> '$leave_approval'
			AND s.department_sub IN ('TECHOPERATION','PILOT-BOAT','MOORING-GANG')
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
       
	  }
	  
// 	  else if($role_id == 'HOD' && $department_sub == 'CORPADMIN'){
//       $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
// 			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
// 			a.month_claim,YEAR(a.created_date) AS tahun,a.position
// 			FROM staff s
// 			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
// 			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
// 			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
// 			WHERE ap.verify_status = 'PENDING'
// 			AND ap.verify_status <> 'VERIFIED'
// 			AND s.no_staff <> '$leave_approval'
// 			AND s.department_sub IN ('CORPADMIN','IT')
// 			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
// 			ORDER BY a.created_date DESC";
       
// 	  }
	  
	  else if($role_id == 'HOD'){
			$sql = "SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND s.department_sub = '$department_sub'
			AND s.no_staff <> '$leave_approval'
			AND s.department_sub <> 'HR'
			AND s.department_sub <> 'FINACC'
			AND s.department_sub <> 'OPERATION-AGMHESB'
			AND s.department_sub <> 'TECHOPERATION'
			AND s.department_sub <> 'PILOT-BOAT'
			AND s.department_sub <> 'MOORING-GANG'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
	  }
	  
	  else{
		  $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND s.leave_approval = '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
	  }
	  
    $result = $conn->query($sql);
    return $result;
  }
	
	
	function getOtForHodApproved($department_sub,$leave_approval) {
    $conn=db();
	$sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
    $role_id=$conn->query($sql)->fetch_object()->role_id;
	  
	  
	  //cfo verify ot form
	  if($role_id == 'CFO'){
      $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'VERIFIED'
			AND ap.verify_status <> 'PENDING'
			AND s.department_sub = 'FINACC'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
	  } 
	  
	  else if( $role_id == 'MANAGING-DIRECTOR' ) {
          $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'VERIFIED'
			AND ap.verify_status <> 'PENDING'
			AND s.no_staff IN ('860620295410','850126115526','930128016820','690615115252')
			AND s.no_staff <> '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
		}
		
 		else if( $role_id == 'OPERATIONMANAGER' ) {
           $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
 			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
 			a.month_claim,YEAR(a.created_date) AS tahun,a.position
 			FROM staff s
 			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
 			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
 			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
 			WHERE ap.verify_status = 'VERIFIED'
 			AND ap.verify_status <> 'PENDING'
 			AND (s.leave_approval = '$leave_approval' OR s.no_staff IN ('INDEEP0311'))
 			AND s.no_staff NOT IN ('$leave_approval','901118115427')
 			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
 			ORDER BY a.created_date DESC";
 		}
		
/*		else if( $role_id == 'HOC' ) {
          $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'VERIFIED'
			AND ap.verify_status <> 'PENDING'
			AND (s.department_sub IN ('OPERATION-TKSB','QR&D-TKSB') OR s.no_staff = '901118115427')
			AND s.no_staff <> '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
		}
		 */
		else if ($leave_approval == '810415035497'){
		      $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'VERIFIED'
			AND ap.verify_status <> 'PENDING'
            AND s.department_sub = 'MARKETING&BUSINESS-DEV'
			AND s.no_staff <> '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
			  
		}
	  
	  else if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMHESB'){
      $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'VERIFIED'
			AND ap.verify_status <> 'PENDING'
			AND s.department_sub = 'OPERATION-AGMHESB'
			AND s.no_staff <> '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
	  }
	  
	   //ot form ceo verify
	  else if($leave_approval == '751206035485'){
      $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'VERIFIED'
			AND ap.verify_status <> 'PENDING'
			AND s.role_id IN ('HOD','MANAGER','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR')
			AND s.department_sub <> 'OPERATION-AGMHESB'
			AND s.no_staff <> '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'HR'){
      $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'VERIFIED'
			AND ap.verify_status <> 'PENDING'
			AND s.no_staff <> '$leave_approval'
			AND s.department_sub IN ('HR', 'HR-SEA', 'ECOFFICE')
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB'){
      $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'VERIFIED'
			AND ap.verify_status <> 'PENDING'
			AND s.no_staff <> '$leave_approval'
			AND s.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
       
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'TECHOPERATION'){
      $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'VERIFIED'
			AND ap.verify_status <> 'PENDING'
			AND s.no_staff <> '$leave_approval'
			AND s.department_sub IN ('TECHOPERATION','PILOT-BOAT','MOORING-GANG')
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
       
	  }
	  
// 	  else if($role_id == 'HOD' && $department_sub == 'CORPADMIN'){
//       $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
// 			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
// 			a.month_claim,YEAR(a.created_date) AS tahun,a.position
// 			FROM staff s
// 			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
// 			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
// 			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
// 			WHERE ap.verify_status = 'VERIFIED'
// 			AND ap.verify_status <> 'PENDING'
// 			AND s.no_staff <> '$leave_approval'
// 			AND s.department_sub IN ('CORPADMIN','IT')
// 			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
// 			ORDER BY a.created_date DESC";
       
// 	  }
	  
	  else if($role_id == 'HOD'){
			$sql = "SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'VERIFIED'
			AND ap.verify_status <> 'PENDING'
			AND s.department_sub = '$department_sub'
			AND s.no_staff <> '$leave_approval'
			AND s.department_sub <> 'HR'
			AND s.department_sub <> 'FINACC'
			AND s.department_sub <> 'OPERATION-AGMHESB'
			AND s.department_sub <> 'TECHOPERATION'
			AND s.department_sub <> 'PILOT-BOAT'
			AND s.department_sub <> 'MOORING-GANG'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
	  }
	  
	  else{
		  $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'VERIFIED'
			AND ap.verify_status <> 'PENDING'
			AND s.leave_approval = '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
	  }
	  
    $result = $conn->query($sql);
    return $result;
  }
	
	
	function getOtForHodDisapproved($department_sub,$leave_approval) {
    $conn=db();
	$sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
    $role_id=$conn->query($sql)->fetch_object()->role_id;
	  
	  
	  //cfo verify ot form
	  if($role_id == 'CFO'){
      $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'REJECTED'
			AND ap.verify_status <> 'PENDING'
			AND s.department_sub = 'FINACC'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
	  } 
	  
	  else if( $role_id == 'MANAGING-DIRECTOR' ) {
          $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'REJECTED'
			AND ap.verify_status <> 'PENDING'
			AND s.no_staff IN ('860620295410','850126115526','930128016820','690615115252')
			AND s.no_staff <> '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
		}
		
 		else if( $role_id == 'OPERATIONMANAGER' ) {
           $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
 			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
 			a.month_claim,YEAR(a.created_date) AS tahun,a.position
 			FROM staff s
 			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
 			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
 			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
 			WHERE ap.verify_status = 'REJECTED'
 			AND ap.verify_status <> 'PENDING'
 			AND (s.leave_approval = '$leave_approval' OR s.no_staff IN ('INDEEP0311'))
 			AND s.no_staff NOT IN ('$leave_approval','901118115427')
 			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
 			ORDER BY a.created_date DESC";
 		}
		
		
	/*	else if( $role_id == 'HOC' ) {
          $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'REJECTED'
			AND ap.verify_status <> 'PENDING'
			AND (s.department_sub IN ('OPERATION-TKSB','QR&D-TKSB') OR s.no_staff = '901118115427')
			AND s.no_staff <> '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
		} */
		
		else if ($leave_approval == '810415035497'){
		      $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'REJECTED'
			AND ap.verify_status <> 'PENDING'
            AND s.department_sub = 'MARKETING&BUSINESS-DEV'
			AND s.no_staff <> '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
			  
		}
	  
	  else if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMHESB'){
      $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'REJECTED'
			AND ap.verify_status <> 'PENDING'
			AND s.department_sub = 'OPERATION-AGMHESB'
			AND s.no_staff <> '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
	  }
	  
	   //ot form ceo verify
	  else if($leave_approval == '751206035485'){
      $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'REJECTED'
			AND ap.verify_status <> 'PENDING'
			AND s.role_id IN ('HOD','MANAGER','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR')
			AND s.department_sub <> 'OPERATION-AGMHESB'
			AND s.no_staff <> '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'HR'){
      $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'REJECTED'
			AND ap.verify_status <> 'PENDING'
			AND s.no_staff <> '$leave_approval'
			AND s.department_sub IN ('HR', 'HR-SEA', 'ECOFFICE')
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB'){
      $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'REJECTED'
			AND ap.verify_status <> 'PENDING'
			AND s.no_staff <> '$leave_approval'
			AND s.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
       
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'TECHOPERATION'){
      $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'REJECTED'
			AND ap.verify_status <> 'PENDING'
			AND s.no_staff <> '$leave_approval'
			AND s.department_sub IN ('TECHOPERATION','PILOT-BOAT','MOORING-GANG')
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
       
	  }
	  
// 	  else if($role_id == 'HOD' && $department_sub == 'CORPADMIN'){
//       $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
// 			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
// 			a.month_claim,YEAR(a.created_date) AS tahun,a.position
// 			FROM staff s
// 			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
// 			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
// 			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
// 			WHERE ap.verify_status = 'REJECTED'
// 			AND ap.verify_status <> 'PENDING'
// 			AND s.no_staff <> '$leave_approval'
// 			AND s.department_sub IN ('CORPADMIN','IT')
// 			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
// 			ORDER BY a.created_date DESC";
       
// 	  }
	  
	  else if($role_id == 'HOD'){
			$sql = "SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'REJECTED'
			AND ap.verify_status <> 'PENDING'
			AND s.department_sub = '$department_sub'
			AND s.no_staff <> '$leave_approval'
			AND s.department_sub <> 'HR'
			AND s.department_sub <> 'FINACC'
			AND s.department_sub <> 'OPERATION-AGMHESB'
			AND s.department_sub <> 'TECHOPERATION'
			AND s.department_sub <> 'PILOT-BOAT'
			AND s.department_sub <> 'MOORING-GANG'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
	  }
	  
	  else{
		  $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'REJECTED'
			AND ap.verify_status <> 'PENDING'
			AND s.leave_approval = '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
	  }
	  
    $result = $conn->query($sql);
    return $result;
  }
  
	function  ListName($id) {
    $conn=db();
    $sql = "SELECT a.*,ap.verify_status,ap.verify_date,ap.verify_by,s.name
			FROM aims_ot a
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			LEFT JOIN staff_record st ON st.id = a.staff_record_id
			LEFT JOIN staff s ON s.no_staff = st.no_staff
			WHERE a.staff_record_id = '$id'
			ORDER BY a.created_date";
    

    $result = $conn->query($sql);
    return $result;
  }
	
	function ListBatchOt($department_sub,$month,$verify_status,$id) {
    $conn=db();
    $sql = "SELECT a.*,ap.verify_status,ap.verify_date,ap.verify_by,s.name
			FROM aims_ot a
			LEFT JOIN aims_ot_approval ap ON a.id = ap.ot_id
			LEFT JOIN staff_record st ON a.staff_record_id = st.id
			LEFT JOIN staff s ON s.no_staff = st.no_staff
			WHERE ap.verify_status = '$verify_status'
			AND a.month_claim = '$month'
			AND a.staff_record_id = '$id'
			ORDER BY a.created_date";
    
    $result = $conn->query($sql);
    return $result;
  }
  
  function getStaffOcById($id,$month){
		$conn=db();
		$sql = "SELECT a.*,ap.verify_status,ap.review_status,ap.approved_status FROM aims_ot a
		LEFT JOIN aims_ot_approval ap ON a.id = ap.ot_id
		WHERE a.staff_record_id='$id'
		AND month_claim = '$month'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getStaffHrById($id,$month){
		$conn=db();
		$sql = "SELECT a.*,ap.approve_status FROM aims_others_claim a
		LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
		WHERE a.staff_record_id='$id'
		AND a.month_claim = '$month'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getOtHodById($id){
    $conn=db();
    $sql = "SELECT id,working_hours,hod_remark
			FROM aims_ot
			WHERE id = '$id'";
	$result = $conn->query($sql);
	return $result;
	}	
	
	
	function updateOtHod($working_hours,$hod_remark,$id){
    $conn=db();
    $sql = "UPDATE aims_ot SET working_hours='$working_hours', hod_remark='$hod_remark' WHERE id='$id'";
	$result = $conn->query($sql);
	return $result;
	}
	
	function verifyOtClaim($id,$month,$verify_by,$verify_status){
    $conn=db();
    $sql = "UPDATE aims_ot_approval ap
			LEFT JOIN aims_ot a ON a.id = ap.ot_id
			SET ap.verify_by='$verify_by', ap.verify_status='$verify_status' , ap.verify_date = CURRENT_TIMESTAMP
			WHERE a.staff_record_id='$id'
			AND a.month_claim ='$month'";
	$result = $conn->query($sql);
	return $result;
	}
    
	
	//HR review ot form view
	function getOtHrNew($department_code,$department_sub) {
    $conn=db();
	
	if ( $department_sub == 'HR' ) {
    $sql = "SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,ap.payment_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON a.id = ap.ot_id
			WHERE ap.verify_status = 'VERIFIED'
			AND ap.review_status = 'PENDING'
			AND s.department_id = '$department_code'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
	}
	else{
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_ot_message.php';
						</script>");
	}
    
    $result = $conn->query($sql);
    return $result;
  }
  
  function getOtHrReviewed($department_code) {
    $conn=db();
    $sql = "SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,ap.payment_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON a.id = ap.ot_id
			WHERE ap.verify_status = 'VERIFIED'
			AND ap.review_status = 'REVIEWED'
			AND ap.review_status <> 'PENDING'
			AND ap.payment_status = 'OPEN'
			AND s.department_id = '$department_code'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date),ap.approved_status
			ORDER BY a.created_date DESC";
    

    $result = $conn->query($sql);
    return $result;
  }
  
  function getOtHrReviewedClosed($department_code) {
    $conn=db();
    $sql = "SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,ap.payment_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON a.id = ap.ot_id
			WHERE ap.verify_status = 'VERIFIED'
			AND ap.review_status = 'REVIEWED'
			AND ap.review_status <> 'PENDING'
			AND ap.payment_status = 'CLOSED'
			AND s.department_id = '$department_code'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
    

    $result = $conn->query($sql);
    return $result;
  }
  
  function getOtHrRejected($department_code) {
    $conn=db();
    $sql = "SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,ap.payment_status,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON a.id = ap.ot_id
			WHERE ap.verify_status = 'VERIFIED'
			AND ap.review_status = 'REJECTED'
			AND ap.review_status <> 'PENDING'
			AND s.department_id = '$department_code'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
    

    $result = $conn->query($sql);
    return $result;
  }
  
  
  function getStaffOT($id){
        $conn=db();
        $sql = "SELECT ot.*,s.name,s.department_id,ap.review_status FROM staff s
		 LEFT JOIN staff_record sr ON sr.no_staff = s.no_staff
		 LEFT JOIN aims_ot ot ON sr.id = ot.staff_record_id
		 LEFT JOIN aims_ot_approval ap ON ot.id = ap.ot_id
		 WHERE ot.staff_record_id = '$id'"; 
        $result = $conn->query($sql);
       return $result;        
    }
	
	
	function getTotal_claim($id,$month,$tahun){
    $conn=db();
    $sql ="SELECT SUM(total_rates) AS total FROM aims_ot WHERE staff_record_id = '$id' AND month_claim = '$month' AND YEAR(created_date) = '$tahun'";  
    $result = $conn->query($sql);
    return $result;
  }
  
  function gethrname($id,$month,$tahun){
    $conn=db();
    $sql ="SELECT ap.review_by from aims_ot_approval ap
	LEFT JOIN aims_ot a ON a.id = ap.ot_id
	WHERE a.staff_record_id = '$id' AND a.month_claim = '$month' AND YEAR(a.created_date) = '$tahun'";  
    $result = $conn->query($sql);
    return $result;
  }
  
  function getStaffForms($id,$month,$status,$tahun){
        $conn=db();
        $sql = "SELECT ot.*,s.name,ap.review_status,ap.review_by,YEAR(ot.created_date) AS tahun FROM staff s
		 LEFT JOIN staff_record sr ON sr.no_staff = s.no_staff
		 LEFT JOIN aims_ot ot ON sr.id = ot.staff_record_id
		 LEFT JOIN aims_ot_approval ap ON ot.id = ap.ot_id
		 WHERE ot.staff_record_id = '$id'
		 AND ot.month_claim = '$month'
		 AND YEAR(ot.created_date) = '$tahun'
		 ORDER BY ot.date_ot ASC"; 
		 //AND ap.review_status = '$status'
        $result = $conn->query($sql);
       return $result;        
    }
	
	//hr add attachment
	function updateHrAttachment($document_name,$document_type,$document_size,$id){
    $conn=db();
    $sql = "UPDATE aims_ot SET document_name='$document_name',document_type='$document_type',
	document_size='$document_size' WHERE id='$id'";
	$result = $conn->query($sql);
	return $result;
	}
	
	function reviewOtClaim($id,$tahun,$month_claim,$review_by,$review_status,$total_monthclaim,
	$r1_5,$s1_5,$t1_5,$r2,$s2,$t2,$r3,$s3,$t3,$r4,$s4,$t4){
    $conn=db();
    $sql = "UPDATE aims_ot_approval ap
	LEFT JOIN aims_ot a ON a.id = ap.ot_id
	SET ap.review_by='$review_by', ap.review_status='$review_status' , ap.review_date = CURRENT_TIMESTAMP, a.total_monthclaim = '$total_monthclaim', a.r1_5 = '$r1_5', a.s1_5 = '$s1_5', a.t1_5 = '$t1_5', 
	a.r2 = '$r2', a.s2 = '$s2', a.t2 = '$t2', a.r3 = '$r3', a.s3 = '$s3', a.t3 = '$t3', a.r4 = '$r4', a.s4 = '$s4', a.t4 = '$t4' WHERE a.staff_record_id='$id' AND a.month_claim='$month_claim' AND YEAR(a.created_date)='$tahun'";
	$result = $conn->query($sql);
	
	//$sql = "UPDATE aims_others_claim SET total_monthclaim ='$total_monthclaim' WHERE staff_record_id='$id' AND month_claim='$month_claim' AND YEAR(date_created)='$tahun'";
	//$result = $conn->query($sql);
	return $result;        
    }
    
    function closeOtClaim($id,$month,$tahun,$payment_status){
    $conn=db();
    $sql = "UPDATE aims_ot_approval ap
			LEFT JOIN aims_ot a ON a.id = ap.ot_id
			SET ap.payment_status='CLOSED' WHERE a.staff_record_id='$id'
			AND a.month_claim ='$month'
			AND YEAR(a.created_date) = '$tahun'
			AND ap.review_status = 'REVIEWED' 
			AND ap.approved_status = 'APPROVED'";
	$result = $conn->query($sql);
	return $result;
	}
	
	//HR report
	function getStaffss($id,$month){
        $conn=db();
        $sql = "SELECT MAX(sr.id),sr.*,d.code_department AS company_name,d.description AS department_name,s.alamat_tetap,
				s.role_id,s.department_id,s.noic,s.phone,s.email,s.alamat_surat,s.name AS staff_name,dl.code_department AS department_name, r.role,
				a.month_claim,a.position
                FROM staff_record sr 
                LEFT JOIN staff s ON s.no_staff=sr.no_staff 
                LEFT JOIN department d ON d.code_department=s.department_id 
                LEFT JOIN role r ON sr.peranan=r.code
				LEFT JOIN department_load dl ON dl.code_department=s.department_sub
				LEFT JOIN aims_ot a ON a.staff_record_id = sr.id
                WHERE s.status = 'BEKERJA' AND s.noic IS NOT NULL 
                AND sr.id='$id' AND a.month_claim = '$month'"; 
        $result = $conn->query($sql);
  	    return $result;        
    }
  // AND ap.review_status = '$status'
	function getOtClaimReport($id,$month,$status,$tahun){
        $conn=db();
        $sql = "SELECT ot.*,s.name,ap.review_status,ap.review_by,ap.review_date,ap.verify_by,ap.verify_status,ap.verify_date,
		ap.approved_by,ap.approved_status,ap.approved_date,YEAR(ot.created_date) AS tahun FROM staff s
		 LEFT JOIN staff_record sr ON sr.no_staff = s.no_staff
		 LEFT JOIN aims_ot ot ON sr.id = ot.staff_record_id
		 LEFT JOIN aims_ot_approval ap ON ot.id = ap.ot_id
		 WHERE ot.staff_record_id = '$id'
		 AND ot.month_claim = '$month'
		 AND YEAR(ot.created_date) = '$tahun' 
		 ORDER BY ot.date_ot ASC"; 
        $result = $conn->query($sql);
       return $result;        
    }
    
    function getOtClaimReportSign($id,$month,$status,$tahun){
        $conn=db();
        $sql = "SELECT ot.*,s.name,ap.review_status,ap.review_by,ap.review_date,ap.verify_by,ap.verify_status,ap.verify_date,
		ap.approved_by,ap.approved_status,ap.approved_date,YEAR(ot.created_date) AS tahun FROM staff s
		 LEFT JOIN staff_record sr ON sr.no_staff = s.no_staff
		 LEFT JOIN aims_ot ot ON sr.id = ot.staff_record_id
		 LEFT JOIN aims_ot_approval ap ON ot.id = ap.ot_id
		 WHERE ot.staff_record_id = '$id'
		 AND ot.month_claim = '$month'
		 AND YEAR(ot.created_date) = '$tahun' 
		 ORDER BY ot.created_date DESC"; 
        $result = $conn->query($sql);
       return $result;        
    }
    
    function getOtClaimReportRate($id,$month,$status,$tahun){
        $conn=db();
        $sql = "SELECT ot.*,s.name,ap.review_status,ap.review_by,ap.review_date,ap.verify_by,ap.verify_status,ap.verify_date,
		ap.approved_by,ap.approved_status,ap.approved_date,YEAR(ot.created_date) AS tahun FROM staff s
		 LEFT JOIN staff_record sr ON sr.no_staff = s.no_staff
		 LEFT JOIN aims_ot ot ON sr.id = ot.staff_record_id
		 LEFT JOIN aims_ot_approval ap ON ot.id = ap.ot_id
		 WHERE ot.staff_record_id = '$id'
		 AND ot.month_claim = '$month'
		 AND YEAR(ot.created_date) = '$tahun'
		 AND review_status = 'REVIEWED'
		 ORDER BY ot.date_ot DESC"; 
        $result = $conn->query($sql);
       return $result;        
    }
    
    function getOtRates($id,$month,$status,$tahun){
        $conn=db();
        $sql = "SELECT ot.*,s.name,ap.review_status,ap.review_by,ap.review_date,ap.verify_by,ap.verify_status,ap.verify_date,
		ap.approved_by,ap.approved_status,ap.approved_date,YEAR(ot.created_date) AS tahun FROM staff s
		 LEFT JOIN staff_record sr ON sr.no_staff = s.no_staff
		 LEFT JOIN aims_ot ot ON sr.id = ot.staff_record_id
		 LEFT JOIN aims_ot_approval ap ON ot.id = ap.ot_id
		 WHERE ot.staff_record_id = '$id'
		 AND ot.month_claim = '$month'
		 AND ap.review_status <> 'REJECTED'
		 AND YEAR(ot.created_date) = '$tahun' 
		 ORDER BY ot.date_ot ASC"; 
        $result = $conn->query($sql);
       return $result;        
    }
	
//OT FORM APPROVED CEO VIEW
	function getOtForCeo($company_id,$leave_approval) {
    $conn=db();
	$sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
    $role_id=$conn->query($sql)->fetch_object()->role_id;
	
	$company = '';
        if($company_id!="0"){
            $company=" AND s.department_id='$company_id'";
        }
	  
	  //ceo approved ot form
	  //AND s.no_staff NOT IN ('$leave_approval','790204045112','810415035497','951027115873','750915115141','740915115003','000701110342') list management
	  if($leave_approval == '751206035485'){
			$sql = "SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,a.document_name,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.review_status = 'REVIEWED' 
			AND ap.approved_status = 'PENDING'
			AND ap.approved_status <> 'APPROVED'
			AND s.no_staff <> '$leave_approval'
			AND s.role_id NOT IN ('HOD','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR','MANAGER')$company 
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
	  }
	  //chairman
	  else if($leave_approval == '660512115105'){
		  $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,a.document_name,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id 
			WHERE ap.review_status = 'REVIEWED'
			AND ap.approved_status = 'PENDING'
			AND ap.approved_status <> 'APPROVED'
			AND (s.role_id IN ('HOD','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR','MANAGER') OR s.no_staff = '000701110342')
			AND s.no_staff <> '$leave_approval'$company 
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
	  }
	  
    $result = $conn->query($sql);
    return $result;
  }
  
	function getOtForCeoApproved($company_id,$leave_approval) {
    $conn=db();
	$sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
    $role_id=$conn->query($sql)->fetch_object()->role_id;
	
	$company = '';
        if($company_id!="0"){
            $company=" AND s.department_id='$company_id'";
        }
	  
	  //ceo approved ot form
	  if($leave_approval == '751206035485'){
			$sql = "SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,a.document_name,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id 
			WHERE ap.approved_status = 'APPROVED'
			AND ap.approved_status <> 'PENDING'
			AND s.no_staff <> '$leave_approval'
			AND s.role_id NOT IN ('HOD','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR','MANAGER')$company
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
	  }
	  //chairman
	  else if($leave_approval == '660512115105'){
		  $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,a.document_name,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id 
			WHERE ap.approved_status = 'APPROVED'
			AND ap.approved_status <> 'PENDING'
			AND (s.role_id IN ('HOD','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR','MANAGER') OR s.no_staff = '000701110342')
			AND s.no_staff <> '$leave_approval'$company 
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
	  }
	  
    $result = $conn->query($sql);
    return $result;
  }
  
  function getOtForCeoDisapproved($company_id,$leave_approval) {
    $conn=db();
	$sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
    $role_id=$conn->query($sql)->fetch_object()->role_id;
	
	$company = '';
        if($company_id!="0"){
            $company=" AND s.department_id='$company_id'";
        }
	  
	  //ceo approved ot form
	  if($leave_approval == '751206035485'){
			$sql = "SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,a.document_name,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id 
			WHERE ap.approved_status = 'DISAPPROVED'
			AND ap.approved_status <> 'PENDING'
			AND s.no_staff <> '$leave_approval'
			AND s.role_id NOT IN ('HOD','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR','MANAGER')$company 
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
	  }
	  //chairman
	  else if($leave_approval == '660512115105'){
		  $sql="SELECT DISTINCT(s.name),s.noic,s.department_sub,s.department_id,st.id,ap.approved_status,ap.approved_by,ap.approved_date,
			ap.review_status,ap.review_by,ap.review_date,ap.verify_date,ap.verify_by,ap.verify_status,a.document_name,
			a.month_claim,YEAR(a.created_date) AS tahun,a.position
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id 
			WHERE ap.approved_status = 'DISAPPROVED'
			AND ap.approved_status <> 'PENDING'
			AND (s.role_id IN ('HOD','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR','MANAGER') OR s.no_staff = '000701110342')
			AND s.no_staff <> '$leave_approval'$company 
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)
			ORDER BY a.created_date DESC";
	  }
	  
    $result = $conn->query($sql);
    return $result;
  }
  
  
  //view all attachment ceo view
  function getOtFoto($id,$month){
    $conn=db();
    $sql="select * from aims_ot where staff_record_id = '$id' and month_claim ='$month'";
	$result = $conn->query($sql);
    return $result;
  }
  
  function approvedOtClaim($id,$month,$approved_by,$approved_status){
    $conn=db();
    $sql = "UPDATE aims_ot_approval ap
			LEFT JOIN aims_ot a ON a.id = ap.ot_id
			SET ap.approved_by='$approved_by', ap.approved_status='$approved_status' , ap.approved_date = CURRENT_TIMESTAMP
			WHERE a.staff_record_id='$id'
			AND a.month_claim ='$month'
			AND ap.review_status = 'REVIEWED'";
	$result = $conn->query($sql);
	return $result;
	}
	
	
	function getCheckboxUpdateOtHod($idchkbx,$staff_name){
	$conn=db();
	if(isset($_POST['checkbox'])){
	    $checkbox = $_POST['checkbox'];
    	if(isset($_POST['activate'])?$activate = $_POST["activate"]:$deactivate = $_POST["deactivate"])
    	//	$idchkbx = "('" . implode( "','", $checkbox ) . "')" ;
    		
    		$hold = implode( "-", $checkbox ); //turn array('1-2')('3-4') to string "1-2-3-4"
            

            $temp = preg_split("#-#", $hold); //turn string "1-2-3-4" to array('1')('2')('3')('4')

            $idchkbx = "('" . implode( "','", $temp ) . "')" ; //turn array('1')('2')('3')('4') to string "('1','2','3','4')"
    		
    		
    		
    	$sql="UPDATE aims_ot_approval SET verify_status = '".(isset($activate)?'VERIFIED':'REJECTED')."',verify_by='$staff_name',verify_date=CURRENT_TIMESTAMP WHERE ot_id IN $idchkbx";
    	$result=$conn->query($sql);
    	return $result;
    }
    }
    
    
    function hodBatch($department_sub,$month,$verify_status,$id) {
    $conn=db();
    $sql = "SELECT GROUP_CONCAT(a.id SEPARATOR '-') AS idchkbx
			FROM aims_ot a
			LEFT JOIN aims_ot_approval ap ON a.id = ap.ot_id
			LEFT JOIN staff_record st ON a.staff_record_id = st.id
			LEFT JOIN staff s ON s.no_staff = st.no_staff
			WHERE ap.verify_status = '$verify_status'
			AND s.department_sub = '$department_sub'
			AND a.month_claim = '$month'
			AND a.staff_record_id = '$id'
			ORDER BY a.created_date";
			
    $result = $conn->query($sql);
    return $result;
  }
  
  function getCheckboxUpdateOtCeo($idchkbx,$staff_name){
	$conn=db();
	if(isset($_POST['checkbox'])){
	    $checkbox = $_POST['checkbox'];
    	if(isset($_POST['activate'])?$activate = $_POST["activate"]:$deactivate = $_POST["deactivate"])
    	//	$idchkbx = "('" . implode( "','", $checkbox ) . "')" ;
    		
    		$hold = implode( "-", $checkbox ); 
            

            $temp = preg_split("#-#", $hold);

            $idchkbx = "('" . implode( "','", $temp ) . "')" ;
    		
    		
    		
    	$sql="UPDATE aims_ot_approval SET approved_status = '".(isset($activate)?'APPROVED':'DISAPPROVED')."',approved_by='$staff_name',approved_date=CURRENT_TIMESTAMP WHERE ot_id IN $idchkbx";
    	$result=$conn->query($sql);
    	return $result;
    }
    }
    
    
    function ceoBatch($department_sub,$month,$approved_status,$id) {
    $conn=db();
    $sql = "SELECT GROUP_CONCAT(a.id SEPARATOR '-') AS idchkbx
			FROM aims_ot a
			LEFT JOIN aims_ot_approval ap ON a.id = ap.ot_id
			LEFT JOIN staff_record st ON a.staff_record_id = st.id
			LEFT JOIN staff s ON s.no_staff = st.no_staff
			WHERE ap.approved_status = '$approved_status'
			AND s.department_sub = '$department_sub'
			AND a.month_claim = '$month'
			AND a.staff_record_id = '$id'
			ORDER BY a.created_date";
			
    $result = $conn->query($sql);
    return $result;
  }
    
  /*  DO NOT DELETE: CODE FOR CHECKBOX THAT HANDLE MULTIPLE VALUE
  function getCheckboxUpdateOtHod($id,$month_claim,$name){
	$conn=db();
	if(isset($_POST['checkbox'])){
	    $checkbox = $_POST['checkbox'];
    	if(isset($_POST['activate'])?$activate = $_POST["activate"]:$deactivate = $_POST["deactivate"])
    		$hold = implode( "','", $checkbox );
    		$month_claims = preg_split("/\d+/", $hold);
            array_shift($month_claims);
            $ids = preg_split("/[a-z]+/", $hold);
            array_pop($ids);
            $month_claim = "('" . implode( "','", $month_claims ) . "');" ;
            $id = "('" . implode( "','", $ids ) . "');" ;
    		
    	$sql="UPDATE aims_ot_approval ap LEFT JOIN aims_ot a ON a.id = ap.ot_id 
    	SET ap.verify_status = '".(isset($activate)?'VERIFIED':'REJECTED')."',ap.verify_by='$name',ap.verify_date=CURRENT_TIMESTAMP 
    	WHERE a.month_claim IN '$month_claim'
    	AND a.staff_record_id IN $id" ;
    	$result=$conn->query($sql);
    	return $result;
    }
    } 
*/
    
	
	$conn->close();
?>