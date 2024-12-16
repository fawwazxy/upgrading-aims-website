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
	
	function getStaffById($no_staff) {
		$conn=db();
	    $sql = "SELECT name,no_staff,noic FROM staff WHERE no_staff = '$no_staff'";
		$result = $conn->query($sql);
		return $result;
	}
	
	
	function getTravelListStaff($name) {
		$conn=db();
		$sql = "SELECT * FROM aims_travel WHERE name = '$name' ORDER BY created_date DESC";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getTravelListHr($department_sub) {
		$conn=db();
		if ( $department_sub == 'HR' || $department_sub == 'FINACC' ) {
		$sql = "SELECT * FROM aims_travel WHERE hod_approval = 'APPROVED' AND ceo_approval = 'APPROVED' ORDER BY created_date DESC";
		}
		else{
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_travel_specialleavemessage.php';
						</script>");
		}
		
		$result = $conn->query($sql);
		return $result;
	}
	
	function getTravelListHrCom($company_id) {
		$conn=db();
		
		$sql = "SELECT * FROM aims_travel 
		WHERE company_id = '$company_id' 
		AND hod_approval = 'APPROVED' 
		AND ceo_approval = 'APPROVED' 
		ORDER BY created_date DESC";
		
		$result = $conn->query($sql);
		return $result;
	}
	
	function getTravelList($department_id) {
		$conn=db();
		$sql = "SELECT * FROM aims_travel WHERE department_id = '$department_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	
	function getTravelListCeo() {
		$conn=db();
		$sql = "SELECT * FROM aims_travel WHERE hod_approval = 'APPROVED'";
		$result = $conn->query($sql);
		return $result;
	}
	
	
	function getTravelById($id) {
		$conn=db();
	    $sql = "SELECT * FROM aims_travel WHERE id = '$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function addTravel($company_id,$department_id,$no_staff,$name,$noic,$staff_designation,$destination,$travel_mode_id,$departure_date,$departure_time,$return_date,$return_time,$request_hotel,$hotel_duration,$check_in,$check_out,$job_no,$travel_purpose,$transport_fairport,$transport_tairport,$request_driver,$advance_required,$travel_advance,$created_by) {
		$conn=db();
		$sql = "SELECT role_id FROM staff WHERE name='$name'";
        $role_id=$conn->query($sql)->fetch_object()->role_id;
        
        if ( $role_id == 'FOUNDER' || $role_id == 'MANAGING-DIRECTOR' || $role_id == 'EXECUTIVE-DIRECTOR' ) {
        $sql = "INSERT into aims_travel (company_id,department_id,no_staff,name,noic,staff_designation,destination,travel_mode_id,departure_date,departure_time,return_date,return_time,request_hotel,hotel_duration,check_in,check_out,job_no,travel_purpose,transport_fairport,transport_tairport,request_driver,advance_required,travel_advance,created_by,hod_approval,hod_by,hod_date) 
        values('$company_id','$department_id','$no_staff','$name','$noic','$staff_designation','$destination','$travel_mode_id','$departure_date','$departure_time','$return_date','$return_time','$request_hotel','$hotel_duration','$check_in','$check_out','$job_no','$travel_purpose','$transport_fairport','$transport_tairport','$request_driver','$advance_required','$travel_advance','$created_by','APPROVED','TIADA',CURRENT_TIMESTAMP)";
        }
        else {
		$sql = "INSERT into aims_travel (company_id,department_id,no_staff,name,noic,staff_designation,destination,travel_mode_id,departure_date,departure_time,return_date,return_time,request_hotel,hotel_duration,check_in,check_out,job_no,travel_purpose,transport_fairport,transport_tairport,request_driver,advance_required,travel_advance,created_by) 
		values('$company_id','$department_id','$no_staff','$name','$noic','$staff_designation','$destination','$travel_mode_id','$departure_date','$departure_time','$return_date','$return_time','$request_hotel','$hotel_duration','$check_in','$check_out','$job_no','$travel_purpose','$transport_fairport','$transport_tairport','$request_driver','$advance_required','$travel_advance','$created_by')";
        }
		$result = $conn->query($sql);
	return $result;
	}
	
	function updateTravelList($company_id,$department_id,$no_staff,$name,$noic,$staff_designation,$destination,$travel_mode_id,
	$departure_date,$departure_time,$return_date,$return_time,$request_hotel,$hotel_duration,$check_in,$check_out,$job_no,
	$travel_purpose,$transport_fairport,$transport_tairport,$request_driver,$advance_required,$travel_advance,$id){
		$conn=db();
	    $sql = "UPDATE aims_travel SET company_id='$company_id', department_id='$department_id', no_staff='$no_staff', name='$name',
		noic='$noic', staff_designation='$staff_designation', destination='$destination', travel_mode_id='$travel_mode_id',
	departure_date='$departure_date', departure_time='$departure_time', return_date='$return_date', return_time='$return_time', 
	request_hotel='$request_hotel', hotel_duration='$hotel_duration', check_in='$check_in', check_out='$check_out', job_no='$job_no',
	travel_purpose='$travel_purpose', transport_fairport='$transport_fairport', transport_tairport='$transport_tairport', 
	request_driver='$request_driver',advance_required='$advance_required', travel_advance='$travel_advance' WHERE id = '$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function deleteTravel($id){
	    $conn=db();
		 $sql = "DELETE FROM aims_travel WHERE id='$id'";
		 $result = $conn->query($sql);
	    return $result;
	}
	
	function editTravel($id,$hod_approval,$hod_by) {
	$conn=db();
	
	$sql = "UPDATE aims_travel SET hod_approval='$hod_approval', hod_by='$hod_by', hod_date = CURRENT_TIMESTAMP WHERE id = '$id'";
	$result = $conn->query($sql);
	
	return $result;
	}
	
	function editTravelVehicle($id,$hod_approval,$hod_by,$sbu_hod_app) {
	$conn=db();
	
	$sql1 = "UPDATE aims_travel SET hod_approval='$hod_approval', hod_by='$hod_by', hod_date = CURRENT_TIMESTAMP WHERE id = '$id'";
	$result = $conn->query($sql1);

	$sql = "UPDATE aims_car_reserve SET sbu_hod_app='$sbu_hod_app', approve_by='$hod_by', hod_date = CURRENT_TIMESTAMP WHERE taf_id = '$id'";
	$result = $conn->query($sql);
	
	return $result;
	}
	
	function editTravelCeo($id,$ceo_approval,$ceo_by)  {
	$conn=db();
	$sql = "UPDATE aims_travel SET ceo_approval='$ceo_approval', ceo_by='$ceo_by', ceo_date = CURRENT_TIMESTAMP WHERE id = '$id'";
	$result = $conn->query($sql);
	return $result;
	
	}
	
	function editTravelVehicleCeo($id,$ceo_approval,$ceo_by,$ceo_app)  {
	$conn=db();
	$sql1 = "UPDATE aims_travel SET ceo_approval='$ceo_approval', ceo_by='$ceo_by', ceo_date = CURRENT_TIMESTAMP WHERE id = '$id'";
	$result = $conn->query($sql1);

	$sql = "UPDATE aims_car_reserve SET ceo_app='$ceo_app', app_by='$ceo_by', ceo_dateapp = CURRENT_TIMESTAMP WHERE taf_id = '$id'";
	$result = $conn->query($sql);
	return $result;
	
	}


	function getDropDownDepartment($selected) {
		$conn=db();
		 $sql = "SELECT id,description,code_department FROM department_load ORDER BY description";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option ".($row[1] == $selected ? 'selected':'')." value=\"".$row[1]."\">".$row[1]."</option>";
		}
		
		//$conn->close();
		return $txt_result;
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
	
	function getDropDownTravelMode($selected) {
		$conn=db();
		 $sql = "SELECT id,transport_type FROM aims_travel_mode";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option ".($row[1] == $selected ? 'selected':'')." value=\"".$row[1]."\">".$row[1]."</option>";
		}
		//$conn->close();
		return $txt_result;
	}
	
	
	function getCheckboxUpdateTravelHod($id,$staff_name){
	$conn=db();
	if(isset($_POST['checkbox'])){
	    $checkbox = $_POST['checkbox'];
    	if(isset($_POST['activate'])?$activate = $_POST["activate"]:$deactivate = $_POST["deactivate"])
    		$id = "('" . implode( "','", $checkbox ) . "');" ;
    	$sql="UPDATE aims_travel SET hod_approval = '".(isset($activate)?'APPROVED':'REJECTED')."',hod_by='$staff_name',hod_date=CURRENT_TIMESTAMP WHERE id IN $id" ;
		$result=$conn->query($sql);
		
		$sql="UPDATE aims_car_reserve SET sbu_hod_app = '".(isset($activate)?'APPROVE':'DISAPPROVE')."',approve_by='$staff_name',hod_date=CURRENT_TIMESTAMP WHERE taf_id IN $id" ;
    	$result=$conn->query($sql);
    	return $result;
    }
    }
    
    function getCheckboxUpdateTravelCeo($id,$staff_name){
	$conn=db();
	if(isset($_POST['checkbox'])){
	    $checkbox = $_POST['checkbox'];
    	if(isset($_POST['activate'])?$activate = $_POST["activate"]:$deactivate = $_POST["deactivate"])
    		$id = "('" . implode( "','", $checkbox ) . "');" ;
    	$sql="UPDATE aims_travel SET ceo_approval = '".(isset($activate)?'APPROVED':'REJECTED')."',ceo_by='$staff_name',ceo_date=CURRENT_TIMESTAMP WHERE id IN $id" ;
		$result=$conn->query($sql);
		
		$sql="UPDATE aims_car_reserve SET ceo_app = '".(isset($activate)?'APPROVE':'DISAPPROVE')."',app_by='$staff_name',ceo_dateapp=CURRENT_TIMESTAMP WHERE taf_id IN $id" ;
    	$result=$conn->query($sql);
    	return $result;
    }
    }
	
	//VERIFICATION HOD VIEW
	//PENDING
	function getSenaraiPemohonTravelBaharu($department_sub,$name){
      $conn=db();
      $sql = "SELECT role_id, no_staff FROM staff WHERE name='$name'";
      $sql_result = $conn->query($sql)->fetch_object();
      $no_staff=$sql_result->no_staff;

      $sql = "SELECT t.* FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'APPROVED'
              AND t.hod_approval = 'PENDING'
              AND s.status = 'BEKERJA'
              AND s.leave_approval = '$no_staff'
              AND s.no_staff <> '$no_staff'
              ORDER BY t.created_date DESC";

		return $conn->query($sql);
  }
  
  //SUDAH DI VERIFIED
  function getSenaraiPemohonTravelApprove($department_sub,$name){
      $conn=db();
      $sql = "SELECT role_id, no_staff FROM staff WHERE name='$name'";
      $sql_result = $conn->query($sql)->fetch_object();
      $no_staff=$sql_result->no_staff;

	  $sql = "SELECT t.* FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'PENDING'
              AND t.hod_approval = 'APPROVED'
              AND s.status = 'BEKERJA'
              AND s.leave_approval = '$no_staff'
              AND s.no_staff <> '$no_staff'
              ORDER BY t.created_date DESC";

	  return $conn->query($sql);
  }
  
  //TIDAK LULUS VERIFIED
  function getSenaraiPemohonTravelDisapprove($department_sub,$name){
      $conn=db();
      $sql = "SELECT role_id, no_staff FROM staff WHERE name='$name'";
      $sql_result = $conn->query($sql)->fetch_object();
      $no_staff=$sql_result->no_staff;

	  $sql = "SELECT t.* FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'PENDING'
              AND t.hod_approval = 'REJECTED'
              AND s.status = 'BEKERJA'
              AND s.leave_approval = '$no_staff'
              AND s.no_staff <> '$no_staff'
              ORDER BY t.created_date DESC";

	  return $conn->query($sql);
  }
  
  
  
  //VERIFICATION CEO VIEW
  //BELUM DI VERIFY CAPT PENDING
  function getSenaraiPemohonTravelBaharuCeo($department_sub,$name){
      $conn=db();
      $sql = "SELECT role_id FROM staff WHERE name='$name'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
      
      $sql = "SELECT no_staff FROM staff WHERE name='$name'";
      $no_staff=$conn->query($sql)->fetch_object()->no_staff;
     
		if ( $name == 'MOHD TARMIZI BIN MEJAM' ) {
			  $sql="SELECT t.* FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'APPROVED'
              AND t.hod_approval = 'PENDING'
              AND s.status = 'BEKERJA'
			  AND s.role_id IN ('HOD','MANAGER','CFO','DIRECTOR')
			  AND s.name <> '$name'
              ORDER BY t.created_date DESC";
		}
		else{
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_travel_specialleavemessage.php';
						</script>");
			
		}	
		
		
      $result=$conn->query($sql);
      return $result; 
  }
  
  //SUDAH DI VERIFY CAPT APPROVED
  function getSenaraiPemohonTravelApproveCeo($department_sub,$name){
      $conn=db();
      $sql = "SELECT role_id FROM staff WHERE name='$name'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
      
      $sql = "SELECT no_staff FROM staff WHERE name='$name'";
      $no_staff=$conn->query($sql)->fetch_object()->no_staff;
     
		if ( $name == 'MOHD TARMIZI BIN MEJAM' ) {
			  $sql="SELECT t.* FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'PENDING'
              AND t.hod_approval = 'APPROVED'
              AND s.status = 'BEKERJA'
			  AND s.role_id IN ('HOD','MANAGER','CFO','DIRECTOR')
			  AND s.name <> '$name'
              ORDER BY t.created_date DESC";
		}
		else{
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_travel_specialleavemessage.php';
						</script>");
			
		}	
		
		
      $result=$conn->query($sql);
      return $result; 
  }
  
   //TIDAK LULUS DISVERIFY CAPT DISAPPROVED
  function getSenaraiPemohonTravelDisapproveCeo($department_sub,$name){
      $conn=db();
      $sql = "SELECT role_id FROM staff WHERE name='$name'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
      
      $sql = "SELECT no_staff FROM staff WHERE name='$name'";
      $no_staff=$conn->query($sql)->fetch_object()->no_staff;
     
		if ( $name == 'MOHD TARMIZI BIN MEJAM' ) {
			  $sql="SELECT t.* FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'APPROVED'
              AND t.hod_approval = 'REJECTED'
              AND s.status = 'BEKERJA'
			  AND s.role_id IN ('HOD','MANAGER','CFO','DIRECTOR')
			  AND s.name <> '$name'
              ORDER BY t.created_date DESC";
		}
		else{
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_travel_specialleavemessage.php';
						</script>");
			
		}	
		
		
      $result=$conn->query($sql);
      return $result; 
  }
  
  
  //APPROVAL TAF CEO AND EC
  //PENDING APPROVAL
  function getTravelListBaharuCeo($department_sub,$name) {
		$conn=db();
		$sql = "SELECT role_id FROM staff WHERE name='$name'";
		  $role_id=$conn->query($sql)->fetch_object()->role_id;
		  
		  $sql = "SELECT no_staff FROM staff WHERE name='$name'";
		  $no_staff=$conn->query($sql)->fetch_object()->no_staff;
		  
		  
		if ( $name == 'MOHD TARMIZI BIN MEJAM' ) {
			$sql = "SELECT t.* FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'PENDING'
              AND t.hod_approval = 'APPROVED'
			  AND t.ceo_approval = 'PENDING'
              AND s.status = 'BEKERJA'
			  AND s.role_id NOT IN ('HOD','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO')
			  AND s.name <> '$name'
              ORDER BY t.created_date DESC";
		}
		
		else if ( $name == 'AMINUDIN BIN MAT YUSOF' ){
			$sql = "SELECT t.* FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'PENDING'
              AND t.hod_approval = 'APPROVED'
			  AND t.ceo_approval = 'PENDING'
              AND s.status = 'BEKERJA'
			  AND s.role_id IN ('FOUNDER','HOD','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO','DIRECTOR')
			  AND s.name <> '$name'
              ORDER BY t.created_date DESC";
		}
		else{
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_travel_specialleavemessage.php';
						</script>");
			
		}	
		
		
		$result = $conn->query($sql);
		return $result;
	}
	
	
	//APPROVED APPROVAL
	function getTravelListApproveCeo($department_sub,$name) {
		$conn=db();
		$sql = "SELECT role_id FROM staff WHERE name='$name'";
		  $role_id=$conn->query($sql)->fetch_object()->role_id;
		  
		  $sql = "SELECT no_staff FROM staff WHERE name='$name'";
		  $no_staff=$conn->query($sql)->fetch_object()->no_staff;
		  
		  
		if ( $name == 'MOHD TARMIZI BIN MEJAM' ) {
			$sql = "SELECT t.* FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'PENDING'
              AND t.hod_approval = 'APPROVED'
			  AND t.ceo_approval = 'APPROVED'
              AND s.status = 'BEKERJA'
			  AND s.role_id NOT IN ('HOD','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO')
			  AND s.name <> '$name'
              ORDER BY t.created_date DESC";
		}
		
		else if ( $name == 'AMINUDIN BIN MAT YUSOF' ){
			$sql = "SELECT t.* FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'PENDING'
              AND t.hod_approval = 'APPROVED'
			  AND t.ceo_approval = 'APPROVED'
              AND s.status = 'BEKERJA'
			  AND s.role_id IN ('FOUNDER','HOD','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO','DIRECTOR')
			  AND s.name <> '$name'
              ORDER BY t.created_date DESC";
		}
		else{
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_travel_specialleavemessage.php';
						</script>");
			
		}	
		
		
		$result = $conn->query($sql);
		return $result;
	}
	
	//DISAPPROVE APPROVAL
	function getTravelListDisapproveCeo($department_sub,$name) {
		$conn=db();
		$sql = "SELECT role_id FROM staff WHERE name='$name'";
		  $role_id=$conn->query($sql)->fetch_object()->role_id;
		  
		  $sql = "SELECT no_staff FROM staff WHERE name='$name'";
		  $no_staff=$conn->query($sql)->fetch_object()->no_staff;
		  
		  
		if ( $name == 'MOHD TARMIZI BIN MEJAM' ) {
			$sql = "SELECT t.* FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'PENDING'
              AND t.hod_approval = 'APPROVED'
			  AND t.ceo_approval = 'REJECTED'
              AND s.status = 'BEKERJA'
			  AND s.role_id NOT IN ('HOD','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO')
			  AND s.name <> '$name'
              ORDER BY t.created_date DESC";
		}
		
		else if ( $name == 'AMINUDIN BIN MAT YUSOF' ){
			$sql = "SELECT t.* FROM aims_travel t 
              LEFT JOIN staff s ON s.no_staff = t.no_staff
              WHERE t.hod_approval<>'PENDING'
              AND t.hod_approval = 'APPROVED'
			  AND t.ceo_approval = 'REJECTED'
              AND s.status = 'BEKERJA'
			  AND s.role_id IN ('FOUNDER','HOD','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO','DIRECTOR')
			  AND s.name <> '$name'
              ORDER BY t.created_date DESC";
		}
		else{
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_travel_specialleavemessage.php';
						</script>");
			
		}	
		
		$result = $conn->query($sql);
		return $result;
	}
	
	function getcarRequestPrintTravel($id) {
		$conn=db();
		$sql = "SELECT a.*,ad.name_admin,ad.date_app,ad.app_status,ad.descrip,ad.reason,acs.issue_distric,acs.summons_no,acs.offense,acs.enforcement_date,
		acs.offense_details,acs.original_amount,acs.summon_status,ap.name_passenger,ap.jawatan,ap.description
		FROM aims_car_reserve a
		LEFT JOIN aims_car_admin ad ON a.id = ad.reserve_id
		LEFT JOIN aims_car_summon acs ON a.id = acs.reserve_id
		LEFT JOIN aims_car_passenger ap ON a.id = ap.reserve_id
		LEFT JOIN aims_travel t ON t.id = a.taf_id
	    WHERE t.id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
		
	$conn->close();
	
?>
