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
	
	function getMecListhod() {
		$conn=db();
		$sql = "SELECT * FROM aims_others_claim_approval";
		$result = $conn->query($sql);
		return $result;
	}
	
	function listStaff($no_staff){
		$conn=db();
		$sql = "SELECT a.no_staff,b.* FROM staff_record a 
		LEFT JOIN aims_others_claim_approval b ON b.staff_record_id = a.id
		WHERE a.no_staff='$no_staff'";
		$result = $conn->query($sql);
		return $result;
	}
	
	
	function listhod(){
		$conn=db();
		$sql = "SELECT id,hod_review_by,hod_review_date,hod_review_status,hr_review_by,hr_review_date,hr_review_status,approve_by, approve_date,approve_status,other_claim_id
		FROM aims_others_claim_approval a
		LEFT JOIN aims_others_claim_approval b ON a.id = b.other_claim_id
		LEFT JOIN staff_record c ON a.staff_record_id=c.id
		LEFT JOIN staff s ON c.no_staff=s.no_staff
		LEFT JOIN department d ON d.code_department=s.department_id
		WHERE a.ver_status = '1' ORDER BY approve_date DESC";
		$result = $conn->query($sql);
		return $result;
	}
	
	function updateStaff($claim_id,$hod_review_by,$hod_review_status){
    $conn=db();
    $sql = "UPDATE aims_others_claim_approval ap
			LEFT JOIN aims_others_claim a ON a.id = ap.other_claim_id
			SET ap.hod_review_by='$hod_review_by', ap.hod_review_status='$hod_review_status' , ap.hod_review_date = CURRENT_TIMESTAMP
			WHERE a.id='$claim_id'";
	$result = $conn->query($sql);
	return $result;
	}
    
	
	
	function getStaffOcById($claim_id){
		$conn=db();
		$sql = "SELECT a.*,ap.hod_review_status FROM aims_others_claim a
		LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
		WHERE a.id='$claim_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getStaffInformation($no_staff){
        $conn=db();
        $sql = "SELECT MAX(sr.id),sr.*,d.code_department AS company_name,d.description AS department_name,s.alamat_tetap,s.role_id,s.department_id,s.noic,s.phone,s.email,s.alamat_surat,s.name AS staff_name,dl.code_department AS department_name, r.role,stc.*
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
	
	function getStaffOthersClaimById($id){
        $conn=db();
        $sql = "SELECT a.no_staff,d.noic,d.role_id,d.department_id,d.name,b.*,c.other_claim_id 
		FROM staff_record a 
		LEFT JOIN aims_others_claim_approval b ON b.staff_record_id = a.id 
		LEFT JOIN aims_others_claim_approval c ON c.other_claim_id = b.id 
		LEFT JOIN staff d ON d.no_staff = a.no_staff
		WHERE b.id='$id'"; 
        $result = $conn->query($sql);
  	    return $result;        
    }
	
	function getOCImg($id){
		$conn=db();
		$sql = "SELECT photo, photo_name FROM aims_others_claim_approval WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getstaffImg($id){
	$conn=db();
	$sql="	SELECT photo, photo_name FROM aims_others_claim_approval WHERE id ='$id'";

	$result = $conn->query($sql);
	echo '<img src="data:image/jpeg;base64,'.$default['photo_name'].'" border="0" width="350px" height="350px"/>';

}
function updateNotiPelulus($hod_review_by,$hod_review_date,$hod_review_status){
	$conn=db();
	$sql="UPDATE aims_others_claim_approval SET hod_review_status='1'
	WHERE description='$hod_review_by'
	AND status='$hod_review_status'";

	$result = $conn->query($sql);
	return $result;
}
	
function activeplatform($id){

        $conn = db();
		$sql = "UPDATE aims_others_claim_approval SET hod_review_status = 'VERIFIED' WHERE id='$id'";
		$result = $conn->query($sql);

		return $result;
    }
	
	  function deactiveplatform($id){

        $conn = db();
		$sql = "UPDATE aims_others_claim_approval SET hod_review_status = 'PENDING' WHERE id='$id'";
		$result = $conn->query($sql);

		return $result;
    }
	function getLampiranInfo($id){
        $conn=db();
        $sql=" SELECT * FROM aims_others_claim
                WHERE id='$id'";
        $result=$conn->query($sql);
        return $result;  
    }
	
	function  getTravelVerifiedNew($leave_approval) {
        if ($leave_approval == '751206035485'){ // capt
            $custom_condition = "AND (s.leave_approval = '$leave_approval' OR s.no_staff = '810415035497')";
        } else if($leave_approval != '660512115105'){
            $custom_condition = "AND s.leave_approval = '$leave_approval'";
        }else{
            $custom_condition = "AND s.no_staff = '1111'";
        }
    $conn=db();
    $sql = "SELECT (s.name),s.noic,s.department_sub,s.department_id,st.id,ap.hod_review_status,a.month_claim,YEAR(a.date_created) AS tahun,a.company_claim,a.id AS claim_id
        FROM staff s
        LEFT JOIN staff_record st ON s.no_staff = st.no_staff
        LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
        LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
        WHERE ap.hod_review_status = 'PENDING'
        $custom_condition
        AND s.no_staff <> '$leave_approval'
        ORDER BY a.date_created DESC";
    return $conn->query($sql);
  }
  

  function  getTravelVerifiedApprove($leave_approval) {
      if ($leave_approval == '751206035485'){ // capt
          $custom_condition = "AND (s.leave_approval = '$leave_approval' OR s.no_staff = '810415035497')";
      } else if($leave_approval != '660512115105'){
          $custom_condition = "AND s.leave_approval = '$leave_approval'";
      }else{
          $custom_condition = "AND s.no_staff = '1111'";
      }
      $conn=db();
      $sql = "SELECT (s.name),s.noic,s.department_sub,s.department_id,st.id,ap.hod_review_status,a.month_claim,YEAR(a.date_created) AS tahun,a.company_claim,a.id AS claim_id
        FROM staff s
        LEFT JOIN staff_record st ON s.no_staff = st.no_staff
        LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
        LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
        WHERE ap.hod_review_status = 'VERIFIED'
        $custom_condition
        AND s.no_staff <> '$leave_approval'
        ORDER BY a.date_created DESC";
      return $conn->query($sql);
  }

  function  getTravelVerifiedDisapprove($leave_approval) {
      if ($leave_approval == '751206035485'){ // capt
          $custom_condition = "AND (s.leave_approval = '$leave_approval' OR s.no_staff = '810415035497')";
      } else if($leave_approval != '660512115105'){
          $custom_condition = "AND s.leave_approval = '$leave_approval'";
      }else{
          $custom_condition = "AND s.no_staff = '1111'";
      }
      $conn=db();
      $sql = "SELECT (s.name),s.noic,s.department_sub,s.department_id,st.id,ap.hod_review_status,a.month_claim,YEAR(a.date_created) AS tahun,a.company_claim,a.id AS claim_id
        FROM staff s
        LEFT JOIN staff_record st ON s.no_staff = st.no_staff
        LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
        LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
        WHERE ap.hod_review_status = 'DISVERIFIED'
        $custom_condition
        AND s.no_staff <> '$leave_approval'
        ORDER BY a.date_created DESC";
      return $conn->query($sql);
  }
  
  function  Listbatch($status,$claim_id) {
    $conn=db();
    $sql = "SELECT a.*,ap.hod_review_status,ap.hod_review_date,ap.hod_review_by,s.name
			FROM aims_others_claim a
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN staff_record st ON a.staff_record_id = st.id
			LEFT JOIN staff s ON s.no_staff = st.no_staff
			WHERE ap.hod_review_status = '$status'
			AND a.id = '$claim_id'
			ORDER BY a.date_created";
    

    $result = $conn->query($sql);
    return $result;
  }
  
    function  ListName($id) {
    $conn=db();
    $sql = "SELECT a.*,ap.hod_review_status,ap.hod_review_date,ap.hod_review_by,s.name,s.noic,s.department_sub
			FROM aims_others_claim a
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN staff_record st ON a.staff_record_id = st.id
			LEFT JOIN staff s ON s.no_staff = st.no_staff
			WHERE a.staff_record_id = '$id'
			ORDER BY a.date_created";
    

    $result = $conn->query($sql);
    return $result;
  }
  
  function getTravel_Verified_ApprovebyId($claim_id){
    $conn=db();
    $sql ="SELECT * FROM aims_others_claim_approval WHERE id='$claim_id'";  
    $result = $conn->query($sql);
    return $result;
  }
	
  function getTotal_claim($claim_id,$tahun,$company){
    $conn=db();
    $sql ="SELECT SUM(milage) AS total_milage,SUM(total_claim) AS total, SUM(hotel_allowance) AS total_hotel, SUM(daily_allowance) AS total_daily,SUM(milage) + SUM(total_claim) + SUM(hotel_allowance) + SUM(daily_allowance) AS total_expenses, total_to_be_paid FROM aims_others_claim 
	WHERE id = '$claim_id' AND YEAR(date_created) = '$tahun' AND company_claim = '$company'";  
    $result = $conn->query($sql);
    return $result;
  }	
  
  	function getCheckboxUpdateOtHod($claim_id,$staff_name){
	$conn=db();
	if(isset($_POST['checkbox'])){
	    $checkbox = $_POST['checkbox'];
    	if(isset($_POST['activate'])?$activate = $_POST["activate"]:$deactivate = $_POST["deactivate"])
    	    $claim_id = "('" . implode( "','", $checkbox ) . "')" ;
    		
    	$sql="UPDATE aims_others_claim_approval SET hod_review_status = '".(isset($activate)?'VERIFIED':'DISVERIFIED')."',hod_review_by='$staff_name',hod_review_date=CURRENT_TIMESTAMP WHERE other_claim_id IN $claim_id";
    	$result=$conn->query($sql);
    	return $result;
    }
    }
 
 // function getCheckboxUpdateMedicalCfo($id,$staff_name){
  // $conn=db();
  // if(isset($_POST['checkbox'])){
      // $checkbox = $_POST['checkbox'];
      // if(isset($_POST['activate'])?$activate = $_POST["activate"]:$deactivate = $_POST["deactivate"])
        // $id = "('" . implode( "','", $checkbox ) . "');" ;
      // $sql="UPDATE aims_lv_approve_medical SET appcfo_status = '".(isset($activate)?'APPROVED':'DISAPPROVED')."',appcfo_name='$staff_name',appcfo_date=CURRENT_TIMESTAMP WHERE medical_id IN $id" ;
      // $result=$conn->query($sql);
      // return $result;
    // }
// }
 
 
	
    
  function hodBatch($hod_review_status,$claim_id) {
    $conn=db();
    $sql = "SELECT GROUP_CONCAT(a.id SEPARATOR '-') AS claim_id
			FROM aims_others_claim a
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN staff_record st ON a.staff_record_id = st.id
			LEFT JOIN staff s ON s.no_staff = st.no_staff
			WHERE ap.hod_review_status = '$hod_review_status'
			AND a.id = '$claim_id'
			ORDER BY a.date_created";
			
    $result = $conn->query($sql);
    return $result;
  }

/*News update 14102022*/
function updateAttachment($id,$document_name,$document_type){
    $conn=db();
    $sql = "UPDATE aims_others_claim SET document_name = '$document_name', document_type = '$document_type' WHERE id = '$id'";
    return $conn->query($sql);
}
	
	$conn->close();
	
?>