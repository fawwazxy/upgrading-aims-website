<?php


//LEAVE

  


//INOUT	

    //INOUT Approve
    	function getnotiInoutApprove($department_sub,$leave_approval){
      $conn=db();
	  $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
	  
	  
	  if($role_id == 'HOD' && $department_sub == 'FINACC'){
      $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE b.approve='PENDING'
		AND b.verified = 'APPROVE'
		AND d.department_sub='$department_sub'
		AND d.department_sub <>'FINACC'
		ORDER BY a.date_mohon DESC";
       
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMHSB'){
      $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE b.approve='PENDING'
		AND b.verified = 'APPROVE'
		AND d.department_sub='$department_sub'
		AND d.department_sub <>'OPERATION-AGMHSB'
		ORDER BY a.date_mohon DESC";
       
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'HR'){
      $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE b.approve='PENDING'
		AND b.verified = 'APPROVE'
		AND d.no_staff <> '$leave_approval'
		AND d.department_sub IN ('HR', 'HR-SEA')
		ORDER BY a.date_mohon DESC";
       
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'CORPADMIN'){
      $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE b.approve='PENDING'
		AND b.verified = 'APPROVE'
		AND d.no_staff <> '$leave_approval'
		AND d.department_sub IN ('CORPADMIN', 'IT')
		ORDER BY a.date_mohon DESC";
       
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB'){
      $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE b.approve='PENDING'
		AND b.verified = 'APPROVE'
		AND d.no_staff <> '$leave_approval'
		AND d.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')
		ORDER BY a.date_mohon DESC";
       
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'TECHOPERATION'){
      $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE b.approve='PENDING'
		AND b.verified = 'APPROVE'
		AND d.no_staff <> '$leave_approval'
		AND d.department_sub IN ('TECHOPERATION','PILOT-BOAT','MOORING-GANG')
		ORDER BY a.date_mohon DESC";
       
	  }
	  
	  else if($role_id == 'HOD'){
      $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE b.approve='PENDING'
		AND b.verified = 'APPROVE'
		AND d.department_sub='$department_sub'
		AND d.no_staff <> '$leave_approval'
		AND d.department_sub <> 'FINACC'
		AND d.department_sub <> 'OPERATION-AGMHESB'
		ORDER BY a.date_mohon DESC";
       
	  }
	  
	  else{
		  
		  $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE b.approve='PENDING'
		AND b.verified = 'APPROVE'
		AND d.leave_approval = '$leave_approval'
		ORDER BY a.date_mohon DESC";
        
	  }
	  $result=$conn->query($sql);
       return $result; 
  }

    //INOUT Verify
	function getnotiInoutVerify($department_sub,$name){
		$conn=db();
		$sql = "SELECT role_id FROM staff WHERE name='$name'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
      
      $sql = "SELECT no_staff FROM staff WHERE name='$name'";
      $no_staff=$conn->query($sql)->fetch_object()->no_staff;
     
		if ( $role_id == 'SUPERVISORAVSB' ) {
			
		$sql = "SELECT COUNT(a.id) AS total FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE b.verified='PENDING'
		AND d.department_sub IN ('OPERATIONFAC-AVSB', 'OPERATION-AVSB')
		AND d.name <> '$name'
		ORDER BY a.date_mohon DESC";
		
		}
		
		else if ( $role_id == 'EXECUTIVEAVSB' ) {
          $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
			  LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
			  LEFT JOIN staff_record c ON a.staff_record_id = c.id
			  LEFT JOIN staff d ON c.no_staff = d.no_staff 
			  WHERE b.verified='PENDING'
              AND d.status = 'BEKERJA'
			  AND d.no_staff IN ('640508035251','940417115584')
			  AND d.name <> '$name'
              ORDER BY a.date_mohon DESC";
		}
		
		else if ( $role_id == 'EXECUTIVE-DIRECTOR' ) {
          $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
			  LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
			  LEFT JOIN staff_record c ON a.staff_record_id = c.id
			  LEFT JOIN staff d ON c.no_staff = d.no_staff 
			  WHERE b.verified='PENDING'
              AND d.status = 'BEKERJA'
			  AND d.role_id = 'MANAGING-DIRECTOR'
			  AND d.name <> '$name'
              ORDER BY a.date_mohon DESC";
		}
		
		else if ( $role_id == 'MANAGING-DIRECTOR' ) {
          $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
			  LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
			  LEFT JOIN staff_record c ON a.staff_record_id = c.id
			  LEFT JOIN staff d ON c.no_staff = d.no_staff 
			  WHERE b.verified='PENDING'
              AND d.status = 'BEKERJA'
			  AND d.role_id = 'EXECUTIVE-DIRECTOR'
			  AND d.name <> '$name'
              ORDER BY a.date_mohon DESC";
		}
		
		else if ( $role_id == 'HOD' && $department_sub == 'HR' ) {
          $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
			  LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
			  LEFT JOIN staff_record c ON a.staff_record_id = c.id
			  LEFT JOIN staff d ON c.no_staff = d.no_staff 
			  WHERE b.verified='PENDING'
              AND d.status = 'BEKERJA'
			  AND (d.department_sub = 'ECOFFICE' OR d.no_staff ='911011115100')
			  AND d.name <> '$name'
              ORDER BY a.date_mohon DESC";
		}
		
		else if ( $department_sub == 'FINACC' && ($role_id == 'STAFF' || $role_id == 'CONTRACT')){
		$sql="SELECT COUNT(a.id) AS total FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE b.verified='PENDING'
        AND d.status = 'BEKERJA'
		AND d.role_id='HOD'
		AND d.department_sub = 'FINACC '
		AND d.name <> '$name'
        ORDER BY a.date_mohon DESC";	  
		}
		
		else if ( $department_sub == 'OPERATION-AGMHESB' && ( $role_id == 'STAFF' || $role_id == 'CONTRACT')){
		$sql="SELECT COUNT(a.id) AS total FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE b.verified='PENDING'
        AND d.status = 'BEKERJA'
		AND d.role_id='HOD'
		AND d.department_sub = 'OPERATION-AGMHESB '
		AND d.name <> '$name'
        ORDER BY a.date_mohon DESC";	  
		}
		
		else if ( $department_sub == 'HR-AGMA' ) {
          $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
			  LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
			  LEFT JOIN staff_record c ON a.staff_record_id = c.id
			  LEFT JOIN staff d ON c.no_staff = d.no_staff 
			  WHERE b.verified='PENDING'
              AND d.status = 'BEKERJA'
			  AND d.department_sub IN ('OPERATION-AGMSB', 'HR-AGMA')
			  AND d.name <> '$name'
              ORDER BY a.date_mohon DESC";
		}
		
		else if ($name == 'MOHD TARMIZI BIN MEJAM'){
		$sql="SELECT COUNT(a.id) AS total FROM aims_inout a
			  LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
			  LEFT JOIN staff_record c ON a.staff_record_id = c.id
			  LEFT JOIN staff d ON c.no_staff = d.no_staff 
			  WHERE b.verified='PENDING'
              AND d.status = 'BEKERJA'
              AND d.no_staff = '810415035497'
              ORDER BY a.date_mohon DESC";
			  
		}
		
		else if ($no_staff == '940331025617'){
		      $sql="SELECT COUNT(a.id) AS total FROM aims_inout a
			  LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
			  LEFT JOIN staff_record c ON a.staff_record_id = c.id
			  LEFT JOIN staff d ON c.no_staff = d.no_staff 
			  WHERE b.verified='PENDING'
              AND d.status = 'BEKERJA'
              AND d.department_sub IN ('TECHOPERATION','PILOT-BOAT','MOORING-GANG')
              ORDER BY a.date_mohon DESC";
			  
		}
		
		else {
		$sql = "SELECT COUNT(a.id) AS total FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE b.verified='PENDING'
		AND d.status = 'BEKERJA'
		AND d.department_sub='$department_sub'
		AND d.department_sub <>'OPERATION-AGMSB'
		AND d.name <> '$name'
		ORDER BY a.date_mohon DESC";
		}
		$result = $conn->query($sql);
		return $result;
	}
	
	
//NOTIFICATION TRAVEL FORM
//VERIFY TAF
	function getnotiTravel($department_sub,$name){
      $conn=db();
      $sql = "SELECT role_id FROM staff WHERE name='$name'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
      
      $sql = "SELECT no_staff FROM staff WHERE name='$name'";
      $no_staff=$conn->query($sql)->fetch_object()->no_staff;
     
		if ( $role_id == 'MANAGING-DIRECTOR' ) {
          $sql="SELECT COUNT(t.id) AS total FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'APPROVED'
              AND t.hod_approval = 'PENDING'
              AND s.status = 'BEKERJA'
			  AND t.department_id IN ('OPERATION-AVSB','PROCUREMENT-AVSB','CORPADMIN-AVSB',
			  'COMMERCIAL-AVSB','OPERATIONFAC-AVSB','OPERATIONFOOD-AVSB')
			  AND s.name <> '$name'
              ORDER BY t.created_date DESC";
		}
		
		else if ( $role_id == 'HOD' && $department_sub == 'HR') {
		    
          $sql="SELECT COUNT(t.id) AS total FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'APPROVED'
              AND t.hod_approval = 'PENDING'
              AND s.status = 'BEKERJA'
              AND t.department_id IN ('ECOFFICE', 'HR','HR-SEA')
			  AND s.role_id IN ('STAFF','CONTRACT','INTERN')
              AND s.name <> '$name'
              ORDER BY t.created_date DESC";
		  
		}
		
		else if ( $role_id == 'HOD' && $department_sub == 'CORPADMIN') {
		    
          $sql="SELECT COUNT(t.id) AS total FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'APPROVED'
              AND t.hod_approval = 'PENDING'
              AND s.status = 'BEKERJA'
              AND t.department_id IN ('CORPADMIN', 'IT')
              AND s.name <> '$name'
              ORDER BY t.created_date DESC";
		  
		}
		
		//noic itu adalah milik fazrol bunker
	    else if ( $role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB'){
		$sql="SELECT COUNT(t.id) AS total FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'APPROVED'
              AND t.hod_approval = 'PENDING'
              AND s.status = 'BEKERJA'
			  AND s.name <> '$name'
			  AND (t.department_id IN ('OPERATION-AGMSB', 'HR-AGMA')
			  OR t.no_staff = '910619115673')
			  ORDER BY t.created_date DESC";
			  
		}
		//utk personal staff yg perlu verify
		//ayie support pilot n mooring-gang
			else if ($no_staff == '940331025617'){
		      $sql="SELECT COUNT(t.id) AS total FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'APPROVED'
              AND t.hod_approval = 'PENDING'
              AND s.status = 'BEKERJA'
              AND t.department_id IN ('TECHOPERATION','PILOT-BOAT','MOORING-GANG')
              ORDER BY t.created_date DESC";
			  
		}
		//fazrol staff biasa verify bunker team
		else if ($no_staff == '910619115673'){
		      $sql="SELECT COUNT(t.id) AS total FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'APPROVED'
              AND t.hod_approval = 'PENDING'
              AND s.status = 'BEKERJA'
              AND t.department_id = 'OPERATION-BUNKER'
			  AND s.name <> '$name'
              ORDER BY t.created_date DESC";
			  
		}
		
		//03-08-21 Verification assistant EnAlias
		else if ($no_staff == '810415035497'){
		      $sql="SELECT COUNT(t.id) AS total FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'APPROVED'
              AND t.hod_approval = 'PENDING'
              AND s.status = 'BEKERJA'
              AND t.department_id = 'MARKETING&BUSINESS-DEV'
			  AND s.name <> '$name'
              ORDER BY t.created_date DESC";
			  
		}

			else if($role_id == 'HOD'){  
			  $sql="SELECT COUNT(t.id) AS total FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'APPROVED'
              AND t.hod_approval = 'PENDING'
              AND s.status = 'BEKERJA'
			  AND t.department_id = '$department_sub'
			  AND t.department_id <> 'OPERATION-AGMSB'
			  AND t.department_id <> 'MANAGEMENT'
			  AND t.department_id <> 'MOORING-GANG'
			  AND t.department_id <> 'OPERATION-BUNKER'
		      AND t.department_id <> 'PILOT-BOAT'
			  AND s.name <> '$name'
              ORDER BY t.created_date DESC";
			}
		
	
		
      $result=$conn->query($sql);
      return $result; 
  }
  
//VERIFY BY CEO TAF
    function getnotiTravelCeo($department_sub,$name){
          $conn=db();
          $sql = "SELECT role_id FROM staff WHERE name='$name'";
          $role_id=$conn->query($sql)->fetch_object()->role_id;
          
          $sql = "SELECT no_staff FROM staff WHERE name='$name'";
          $no_staff=$conn->query($sql)->fetch_object()->no_staff;
         
    		if ( $name == 'MOHD TARMIZI BIN MEJAM' ) {
    			  $sql="SELECT COUNT(t.id) AS total FROM aims_travel t 
                  LEFT JOIN staff s ON s.no_staff = t.no_staff
                  WHERE t.hod_approval<>'APPROVED'
                  AND t.hod_approval = 'PENDING'
                  AND s.status = 'BEKERJA'
    			  AND s.role_id IN ('HOD','MANAGER','CFO')
    			  AND s.name <> '$name'
                  ORDER BY t.created_date DESC";
    		}
    	
    		
    		
          $result=$conn->query($sql);
          return $result; 
      }
      
//APPROVEMENT BY CEO/EC
         function getnotiTravelApproved($department_sub,$name) {
		$conn=db();
		$sql = "SELECT role_id FROM staff WHERE name='$name'";
		  $role_id=$conn->query($sql)->fetch_object()->role_id;
		  
		  $sql = "SELECT no_staff FROM staff WHERE name='$name'";
		  $no_staff=$conn->query($sql)->fetch_object()->no_staff;
		  
		  
		if ( $name == 'MOHD TARMIZI BIN MEJAM' ) {
			$sql = "SELECT COUNT(t.id) AS total FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'PENDING'
              AND t.hod_approval = 'APPROVED'
			  AND t.ceo_approval = 'PENDING'
              AND s.status = 'BEKERJA'
			  AND s.role_id IN ('STAFF','CONTRACT','INTERN')
			  AND s.name <> '$name'
              ORDER BY t.created_date DESC";
		}
		
		else if ( $name == 'AMINUDIN BIN MAT YUSOF' ){
			$sql = "SELECT COUNT(t.id) AS total FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'PENDING'
              AND t.hod_approval = 'APPROVED'
			  AND t.ceo_approval = 'PENDING'
              AND s.status = 'BEKERJA'
			  AND s.role_id IN ('FOUNDER','HOD','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO')
			  AND s.name <> '$name'
              ORDER BY t.created_date DESC";
		}
		
		
		
		$result = $conn->query($sql);
		return $result;
	}
	
	
//NOTOFICATION OVERTIME

//OT PERMISSION APPROVED VIEW
	function getnotiOtPermissionNew($department_sub,$leave_approval){
      $conn=db();
	  $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
      
	  
	  if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMHESB'){
      $sql="SELECT COUNT(otp.id) AS total
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND b.department_sub = 'OPERATION-AGMHESB'
		ORDER BY otp.created_date DESC";
       
	  }
	  
	  else if( $role_id == 'MANAGING-DIRECTOR' ) {
          $sql="SELECT COUNT(otp.id) AS total
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND (b.department_sub IN ('PROCUREMENT-AVSB','CORPADMIN-AVSB','COMMERCIAL-AVSB','CATERING','LOGISTIC') OR b.no_staff IN ('INDEEP0311','911011115100'))
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
		}
		//Operation manager
		 else if( $role_id == 'OPERATIONMANAGER' ) {
          $sql="SELECT COUNT(otp.id) AS total
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND b.department_sub IN ('OPERATION-AVSB','OPERATIONFAC-AVSB','OPERATIONFOOD-AVSB')
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
		}
		
		//en alias
	else if ($leave_approval == '810415035497'){
	    $sql="SELECT COUNT(otp.id) AS total
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
      $sql="SELECT COUNT(otp.id) AS total
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND b.role_id IN ('HOD','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR','MANAGER')
		AND b.no_staff <> '$leave_approval'
		ORDER BY otp.created_date DESC";
       
	  }
	  
	  else if($role_id == 'CFO'){
      $sql="SELECT COUNT(otp.id) AS total
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
      $sql="SELECT COUNT(otp.id) AS total
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
      $sql="SELECT COUNT(otp.id) AS total
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
      $sql="SELECT COUNT(otp.id) AS total
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
	  
	  else if($role_id == 'HOD'){
      $sql="SELECT COUNT(otp.id) AS total
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
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
		  
	/*	  $sql="SELECT COUNT(otp.id) AS total
		FROM aims_ot_permission otp
		LEFT JOIN aims_ot_permission_approval a ON a.otp_id = otp.id
		LEFT JOIN staff b ON b.no_staff = otp.no_staff
		LEFT JOIN staff_record c ON c.no_staff = otp.no_staff
		WHERE a.approved_status='PENDING'
		AND a.approved_status <> 'APPROVED'
		AND b.leave_approval = '$leave_approval'
		ORDER BY otp.created_date DESC";
    */
	  }
	  $result=$conn->query($sql);
       return $result; 
  }
	
//noti verify ot
	function getnotiOtHod($department_sub,$leave_approval) {
    $conn=db();
	$sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
    $role_id=$conn->query($sql)->fetch_object()->role_id;
	  
	  
	  //cfo verify ot form
	  if($role_id == 'CFO'){
      $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.no_staff,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND s.department_sub = 'FINACC'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)) aims_ot";
	  } 
	  
	  else if( $role_id == 'MANAGING-DIRECTOR' ) {
          $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.no_staff,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND (s.department_sub IN ('OPERATION-AVSB','PROCUREMENT-AVSB','CORPADMIN-AVSB','COMMERCIAL-AVSB','OPERATIONFAC-AVSB','OPERATIONFOOD-AVSB','CATERING','LOGISTIC') OR s.no_staff IN ('INDEEP0311','911011115100'))
			AND s.no_staff <> '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)) aims_ot";
		}
		//en alias
		else if ($leave_approval == '810415035497'){
		      $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.no_staff,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
            AND s.department_sub = 'MARKETING&BUSINESS-DEV'
			AND s.no_staff <> '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)) aims_ot";
			  
		}
	  
	  else if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMHESB'){
      $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.no_staff,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND s.department_sub = 'OPERATION-AGMHESB'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)) aims_ot";
	  }
	  
	   //ot form ceo verify
	  else if($leave_approval == '751206035485'){
      $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.no_staff,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND s.role_id IN ('HOD','MANAGER','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR')
			AND s.no_staff <> '$leave_approval'
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)) aims_ot";
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'HR'){
      $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.no_staff,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND s.no_staff <> '$leave_approval'
			AND s.department_sub IN ('HR', 'HR-SEA')
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)) aims_ot";
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB'){
      $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.no_staff,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND s.no_staff <> '$leave_approval'
			AND s.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)) aims_ot";
       
	  }
	  
	  else if($role_id == 'HOD' && $department_sub == 'TECHOPERATION'){
      $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.no_staff,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.verify_status = 'PENDING'
			AND ap.verify_status <> 'VERIFIED'
			AND s.no_staff <> '$leave_approval'
			AND s.department_sub IN ('TECHOPERATION','PILOT-BOAT','MOORING-GANG')
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)) aims_ot";
       
	  }
	  
	  else if($role_id == 'HOD'){
			$sql = "SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.no_staff,a.month_claim
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
			GROUP BY a.no_staff,a.month_claim,YEAR(a.created_date)) aims_ot";
	  }
	  
	  else{
		  
	  }
	  
    $result = $conn->query($sql);
    return $result;
  }
	
//noti review ot
    function getnotiOtHr($department_sub) {
    $conn=db();
    
 /*   $sql = "SELECT COUNT(s.id) AS total
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON a.id = ap.ot_id
			WHERE ap.verify_status = 'VERIFIED'
			AND ap.review_status = 'PENDING'
			ORDER BY a.created_date DESC";
   */
     $sql = "SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON a.id = ap.ot_id
			WHERE ap.verify_status = 'VERIFIED'
			AND ap.review_status = 'PENDING') aims_ot";
    
    $result = $conn->query($sql);
    return $result;
  }

  
  //noti approve ot
  function notiOtCeo($company_id,$leave_approval) {
    $conn=db();
	$sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
    $role_id=$conn->query($sql)->fetch_object()->role_id;
	
	  
	  //ceo approved ot form
	  if($leave_approval == '751206035485'){
			$sql = "SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.no_staff,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id
			WHERE ap.review_status = 'REVIEWED' 
			AND ap.approved_status = 'PENDING'
			AND ap.approved_status <> 'APPROVED'
			AND s.no_staff <> '$leave_approval'
			AND s.role_id NOT IN ('HOD','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR','MANAGER')) aims_ot";
	  }
	  //chairman
	  else if($leave_approval == '660512115105'){
		  $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.no_staff,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_ot a ON a.staff_record_id = st.id
			LEFT JOIN aims_ot_approval ap ON ap.ot_id = a.id 
			WHERE ap.review_status = 'REVIEWED'
			AND ap.approved_status = 'PENDING'
			AND ap.approved_status <> 'APPROVED'
			AND (s.role_id IN ('HOD','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR','MANAGER') OR s.no_staff = '000701110342')
			AND s.no_staff <> '$leave_approval') aims_ot";
	  }
	  
    $result = $conn->query($sql);
    return $result;
  }
  
//claimVerify notification
	function getnotiClaimVer($leave_approval,$department_sub) {
    $conn=db();
	$sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
    $role_id=$conn->query($sql)->fetch_object()->role_id;
	  
	if ( $role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB') {
          $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			WHERE ap.hod_review_status = 'PENDING'
	        AND s.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')) aims_others_claim";
		}
      
    else if ( $role_id == 'HOD' && $department_sub == 'HR') {
          $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			WHERE ap.hod_review_status = 'PENDING'
	        AND s.department_sub IN ('HR', 'HR-SEA')) aims_others_claim";
		}
		
	else if ( $role_id == 'HOD' && $department_sub == 'CORPADMIN') {
          $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			WHERE ap.hod_review_status = 'PENDING'
	        AND s.department_sub IN ('CORPADMIN', 'IT')) aims_others_claim";
		}
		
		else if ( $role_id == 'HOD' && $department_sub == 'TECHOPERATION') {
          $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			WHERE ap.hod_review_status = 'PENDING'
	        AND s.department_sub IN ('TECHOPERATION', 'PILOT-BOAT','MOORING-GANG')) aims_others_claim";
		} 
	  
	  
	else if ($role_id == 'OPERATIONMANAGER'){
		 $sql="SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			WHERE ap.hod_review_status = 'PENDING'
	        AND s.leave_approval = '$leave_approval') aims_others_claim"; 
	  }
	  


	else if ($role_id == 'HOD'){
		 $sql = "SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			WHERE ap.hod_review_status = 'PENDING'
	        AND s.department_sub = '$department_sub'
			AND s.department_sub <> 'FINACC') aims_others_claim";
	  }
	  
	  //capt verified
	  else if ($leave_approval == '751206035485'){
		 $sql = "SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			WHERE ap.hod_review_status = 'PENDING'
	        AND s.role_id IN ('HOD','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO')) aims_others_claim";
	  }
	  
	  //kak lana verified
	  else if ($leave_approval == '790204045112'){
		 $sql = "SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			WHERE ap.hod_review_status = 'PENDING'
	        AND s.department_sub IN ('CATERING','OPERATION-AVSB','PROCUREMENT-AVSB','CORPADMIN-AVSB','COMMERCIAL-AVSB','OPERATIONFAC-AVSB','OPERATIONFOOD-AVSB')) aims_others_claim";
	  }
	  
    $result = $conn->query($sql);
    return $result;
  }
  
 //claim for HR Reviewed
	function getnotiClaimReview($department_sub) {
    $conn=db();
    
  
    $sql = "SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN aims_claim_financeuse af ON a.id = af.other_claim_id
			WHERE ap.hod_review_status = 'VERIFIED'
			AND ap.hr_review_status = 'PENDING') aims_others_claim";
     
    $result = $conn->query($sql);
    return $result;
  }

//claim approvement capt n haji 
  
  function getnotiClaimApprove($leave_approval){
    $conn=db();
    
	//haji  
	if ($leave_approval == '660512115105'){
    $sql = "SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN aims_claim_financeuse af ON a.id = af.other_claim_id
			WHERE ap.hod_review_status = 'VERIFIED'
			AND ap.hr_review_status = 'REVIEW'
			AND ap.approve_status = 'PENDING'
			AND af.finance_status = 'CHECK'
			AND (s.role_id IN ('FOUNDER','HOD','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO') OR s.no_staff = '000701110342')
			AND s.no_staff != '660512115105') aims_others_claim";
    }
	
	//capt
	else if ($leave_approval == '751206035485'){
    $sql = "SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN aims_claim_financeuse af ON a.id = af.other_claim_id
			WHERE ap.hod_review_status = 'VERIFIED'
			AND ap.hr_review_status = 'REVIEW'
			AND ap.approve_status = 'PENDING'
			AND af.finance_status = 'CHECK'
			AND (s.no_staff != '000701110342'
			OR s.role_id NOT IN ('HOD','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO'))
			AND s.no_staff != '751206035485') aims_others_claim";
    }
    
    else{
    $sql = "SELECT COUNT(*) AS total FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN aims_claim_financeuse af ON a.id = af.other_claim_id
			WHERE ap.hod_review_status = 'VERIFIED'
			AND ap.hr_review_status = 'REVIEW'
			AND ap.approve_status = 'PENDING'
			AND af.finance_status = 'CHECK'
			AND (s.no_staff != '000701110342'
			OR s.role_id NOT IN ('HOD','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO'))
			AND s.no_staff != '751206035485') aims_others_claim";
    }
    

    $result = $conn->query($sql);
    return $result;
  }
  
//Transport notification
  
	function getnoticarRequestHod($department_sub,$name) {
		$conn=db();
		$sql = "SELECT role_id FROM staff WHERE name='$name'";
        $role_id=$conn->query($sql)->fetch_object()->role_id;
        
        $sql = "SELECT no_staff FROM staff WHERE name='$name'";
        $no_staff=$conn->query($sql)->fetch_object()->no_staff;
        
        if ($role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB') {
		$sql = "SELECT COUNT(a.id) AS total FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')
		AND a.taf_id = '0'
		AND sbu_hod_app = 'PENDING'
		ORDER BY a.created_date";
        }
        
        else if ($role_id == 'HOD' && $department_sub == 'HR') {
		$sql = "SELECT COUNT(a.id) AS total FROM aims_car_reserve a  
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub IN ('HR', 'HR-SEA')
		AND a.taf_id = '0'
		AND sbu_hod_app = 'PENDING'
		ORDER BY a.created_date";
        }
        
        else if ($role_id == 'HOD' && $department_sub == 'TECHOPERATION') {
		$sql = "SELECT COUNT(a.id) AS total FROM aims_car_reserve a  
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub IN ('TECHOPERATION', 'PILOT-BOAT','MOORING-GANG')
		AND a.taf_id = '0'
		AND sbu_hod_app = 'PENDING'
		ORDER BY a.created_date";
        }
        
        else if( $role_id == 'CFO' ) {
		$sql = "SELECT COUNT(a.id) AS total FROM aims_car_reserve a
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub = 'FINACC'
		AND a.taf_id = '0'
		AND e.role_id = 'HOD'
		AND sbu_hod_app = 'PENDING'
		ORDER BY a.created_date";
        }
        
        else if( $no_staff == '751206035485' ) {
		$sql = "SELECT COUNT(a.id) AS total FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE a.taf_id = '0'
		AND e.role_id = 'HOD'
		AND sbu_hod_app = 'PENDING'
		ORDER BY a.created_date";
        }
        
        else if( $no_staff == '660512115105' ) {
		$sql = "SELECT COUNT(a.id) AS total FROM aims_car_reserve a  
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE a.taf_id = '0'
		AND (s.role_id IN ('FOUNDER','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO') OR s.department_sub = 'ECOFFICE')
		AND sbu_hod_app = 'PENDING'
		ORDER BY a.created_date";
        }
        
         else if ($role_id == 'HOD' && $department_sub == 'CORPADMIN') {
		$sql = "SELECT COUNT(a.id) AS total FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub IN ('CORPADMIN', 'IT')
		AND a.taf_id = '0'
		AND sbu_hod_app = 'PENDING'
		ORDER BY a.created_date";
        }
        
        else if ( $role_id == 'HOD' ) {
		$sql = "SELECT COUNT(a.id) AS total FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub = '$department_sub'
		AND a.taf_id = '0'
		AND sbu_hod_app = 'PENDING'
		ORDER BY a.created_date";
        }
        
        
		$result = $conn->query($sql);
		return $result;
	} 
	
	
?>