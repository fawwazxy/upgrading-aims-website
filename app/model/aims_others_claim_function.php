<?php

	require '../../lib/db/connection.php';
	
	$action = $_POST['action'];
	//hr update
  if ($action=="update_otherclaim") {
    
	
	$date_purchase = clean($_POST['date_purchase']);
	$time_departure = clean($_POST['time_departure']);
	$time_arrival = clean($_POST['time_arrival']);
	$description = clean($_POST['description']);
	$company_claim =  clean($_POST['company_claim']);
	$milage = clean($_POST['milage']);
	$hotel_allowance = clean($_POST['hotel_allowance']);
	$daily_allowance = clean($_POST['daily_allowance']);
	$total_claim = clean($_POST['total_claim']);
	$month_claim = clean($_POST['month_claim']);
	$job_no = clean($_POST['job_no']);
	$remark = clean($_POST['remark']);
	$id = clean($_POST['id']);
	
	$conn=db();
	
	if($id > 0){
      //need insert new data
	  $sql = "UPDATE aims_others_claim SET month_claim='$month_claim',total_claim='$total_claim',milage='$milage',hotel_allowance='$hotel_allowance',daily_allowance='$daily_allowance',job_no= UPPER('$job_no'),remark= UPPER('$remark'), company_claim= '$company_claim', description= '$description' WHERE id='$id'";
			$result = $conn->query($sql) or die($conn->error);
			echo "Success";
     
    }else{
      echo "Failed";
    }
  }
  
 
  else if($action == "del_otclaim"){
		$id = $_POST['id'];
		
		$conn=db();
		$sql = "DELETE FROM aims_others_claim WHERE id = '$id'";
		$result = $conn->query($sql);
		
		$sql = "DELETE FROM aims_others_claim_approval WHERE other_claim_id = '$id'";
		$result = $conn->query($sql);
		return $result;
		
	}
	
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
	function listStaff($no_staff){
		$conn=db();
		$sql = "SELECT a.no_staff,b.* FROM staff_record a 
		LEFT JOIN aims_lv_medical b ON b.staff_record_id = a.id
		WHERE a.no_staff='$no_staff' AND b.appcfo_status = '1'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function listceo(){
		$conn=db();
		$sql = "SELECT a.id,s.name,s.noic,s.role_id,s.department_id,d.code_department AS company_name,a.mec_date,a.staff_record_id,a.description, a.total,a.ver_date,a.ver_status,a.ver_name,a.app_status,a.app_name,a.app_date,a.appcfo_status,a.appcfo_name,a.appcfo_date, a.document,a.document_type,a.document_name, b.balance,b.current_balance,b.total_mec
		FROM aims_lv_medical a
		LEFT JOIN aims_lv_medical_hr b ON a.id = b.medical_id
		LEFT JOIN staff_record c ON a.staff_record_id=c.id
		LEFT JOIN staff s ON c.no_staff=s.no_staff
		LEFT JOIN department d ON d.code_department=s.department_id
		WHERE a.appcfo_status = '1' ORDER BY mec_date DESC";
		$result = $conn->query($sql);
		return $result;
	}
	
	function UpdateClaimsz($document_name,$document_type,$id){
    $conn=db();
    $sql = "UPDATE aims_others_claim SET document_name='$document_name', document_type='$document_type' WHERE id='$id'";
	$result = $conn->query($sql);
	return $result;
	}
    
	
	
	function getStaffById($id){
		$conn=db();
		$sql = "SELECT * FROM aims_lv_medical WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getStaffById2($id){
		$conn=db();
		$sql = "SELECT * FROM aims_others_claim WHERE id='$id'";
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
	
	function getStaffss($claim_id){
        $conn=db();
        $sql = "SELECT MAX(sr.id),sr.*,d.code_department AS company_name,d.description AS department_name,s.alamat_tetap,
				s.role_id,s.department_id,s.noic,s.phone,s.email,s.alamat_surat,s.name AS staff_name,dl.code_department AS department_name, r.role,
				a.month_claim,a.job_no,a.company_claim
                FROM staff_record sr 
                LEFT JOIN staff s ON s.no_staff=sr.no_staff 
                LEFT JOIN department d ON d.code_department=s.department_id 
                LEFT JOIN role r ON sr.peranan=r.code
				LEFT JOIN department_load dl ON dl.code_department=s.department_sub
				LEFT JOIN aims_others_claim a ON a.staff_record_id = sr.id
                WHERE s.status = 'BEKERJA' AND s.noic IS NOT NULL 
                AND a.id='$claim_id'"; 
        $result = $conn->query($sql);
  	    return $result;        
    }
	
	
	function getCompanyDetails($sys_id) {
		$conn=db();
		$sql = "SELECT * FROM company WHERE sys_id='$sys_id'";
		$result = $conn->query($sql);
		return $result;
	}
	function getDropDownCompany($selected) { 
	$conn=db();
	$sql = "SELECT id, code_department, description FROM department WHERE code_department <> ''";
				
	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[1] == $selected ? 'selected':'')." value=\"".$row[1]."\">".$row[2]."</option>";
	}
	//$conn->close();
	return $txt_result;
}
	
	function addClaim($date_purchase,$time_departure,$time_arrival,$description,$milage,$hotel_allowance,$daily_allowance,$total_claim,$month_claim,$staff_record_id,$job_no,$company_claim,$document_name,$document_type,$no_staff){
		$conn=db();
		if($no_staff == '751206035485'){
		$gambar = '';
        $gambar_val = '';
        if($document_name!=""){
            $gambar=" ,document_name,document_type";
            $gambar_val=",'$document_name','$document_type'";
        }
		$sql = "INSERT INTO aims_others_claim(date_purchase,time_departure,time_arrival,description,milage,hotel_allowance,daily_allowance,total_claim,month_claim,staff_record_id,job_no,company_claim$gambar) 
		VALUES ('$date_purchase','$time_departure','$time_arrival','$description','$milage','$hotel_allowance','$daily_allowance','$total_claim','$month_claim','$staff_record_id','$job_no','$company_claim'$gambar_val)";
		$result = $conn->query($sql);
		
		$other_claim_id=$conn->insert_id;
		$sql = "INSERT INTO aims_others_claim_approval(other_claim_id,hod_review_by,hod_review_date,hod_review_status) VALUES ('$other_claim_id','NO NEED SUPPORT','CURRENT_TIMESTAMP','VERIFIED')";
		$result = $conn->query($sql);
		
		$sql = "INSERT INTO aims_claim_financeuse(other_claim_id) VALUES ('$other_claim_id')";
		$result = $conn->query($sql);		
		}
		
		else if ($no_staff == '660512115105'){
		$gambar = '';
        $gambar_val = '';
        if($document_name!=""){
            $gambar=" ,document_name,document_type";
            $gambar_val=",'$document_name','$document_type'";
        }
		$sql = "INSERT INTO aims_others_claim(date_purchase,time_departure,time_arrival,description,milage,hotel_allowance,daily_allowance,total_claim,month_claim,staff_record_id,job_no,company_claim$gambar) 
		VALUES ('$date_purchase','$time_departure','$time_arrival','$description','$milage','$hotel_allowance','$daily_allowance','$total_claim','$month_claim','$staff_record_id','$job_no','$company_claim'$gambar_val)";
		$result = $conn->query($sql);
		
		$other_claim_id=$conn->insert_id;
		$sql = "INSERT INTO aims_others_claim_approval(other_claim_id,hod_review_by,hod_review_date,hod_review_status) VALUES ('$other_claim_id','NO NEED SUPPORT','CURRENT_TIMESTAMP','VERIFIED')";
		$result = $conn->query($sql);
		
		$sql = "INSERT INTO aims_claim_financeuse(other_claim_id) VALUES ('$other_claim_id')";	
		$result = $conn->query($sql);
		
		}
		
		else if ($no_staff == '000701110342'){
		$gambar = '';
        $gambar_val = '';
        if($document_name!=""){
            $gambar=" ,document_name,document_type";
            $gambar_val=",'$document_name','$document_type'";
        }
		$sql = "INSERT INTO aims_others_claim(date_purchase,time_departure,time_arrival,description,milage,hotel_allowance,daily_allowance,total_claim,month_claim,staff_record_id,job_no,company_claim$gambar) 
		VALUES ('$date_purchase','$time_departure','$time_arrival','$description','$milage','$hotel_allowance','$daily_allowance','$total_claim','$month_claim','$staff_record_id','$job_no','$company_claim'$gambar_val)";
		$result = $conn->query($sql);
		
		$other_claim_id=$conn->insert_id;
		$sql = "INSERT INTO aims_others_claim_approval(other_claim_id,hod_review_by,hod_review_date,hod_review_status) VALUES ('$other_claim_id','NO NEED SUPPORT','CURRENT_TIMESTAMP','VERIFIED')";
		$result = $conn->query($sql);
		
		$sql = "INSERT INTO aims_claim_financeuse(other_claim_id) VALUES ('$other_claim_id')";	
		$result = $conn->query($sql);
		
		}
		
		else {
		$gambar = '';
        $gambar_val = '';
        if($document_name!=""){
            $gambar=" ,document_name,document_type";
            $gambar_val=",'$document_name','$document_type'";
        }
		$sql = "INSERT INTO aims_others_claim(date_purchase,time_departure,time_arrival,description,milage,hotel_allowance,daily_allowance,total_claim,month_claim,staff_record_id,job_no,company_claim$gambar) 
		VALUES ('$date_purchase','$time_departure','$time_arrival','$description','$milage','$hotel_allowance','$daily_allowance','$total_claim','$month_claim','$staff_record_id','$job_no','$company_claim'$gambar_val)";
		$result = $conn->query($sql);
		
		$other_claim_id=$conn->insert_id;
		$sql = "INSERT INTO aims_others_claim_approval(other_claim_id) VALUES ('$other_claim_id')";	
		$result = $conn->query($sql);
		
		
		
		$sql = "INSERT INTO aims_claim_financeuse(other_claim_id) VALUES ('$other_claim_id')";	
		$result = $conn->query($sql);
		}
		return $result;
	}
	
	function updateformstaff($id,$date_purchase,$time_departure,$time_arrival,$description){
    $conn=db();
    $sql ="UPDATE aims_others_claim SET date_purchase = '$date_purchase',time_departure = '$time_departure',time_arrival = '$time_arrival',description = '$description'
	WHERE id = '$id'";  
    $result = $conn->query($sql);
    return $result;
  }
	
	function OthersClaim($no_staff){
		$conn=db();
		
		$sql = "SELECT a.*,d.hod_review_by,d.hod_review_date,d.hod_review_status,d.hr_review_by,d.hr_review_date,d.hr_review_status,d.approve_by,d.approve_date,d.approve_status,d.payment_status,f.finance_status,f.finance_reviewby,f.finance_review_date,
		        f.finance_payment_status,f.date_payment_status
				FROM aims_others_claim a
				LEFT JOIN staff_record b ON a.staff_record_id = b.id
				LEFT JOIN staff c ON c.no_staff = b.no_staff
				LEFT JOIN aims_others_claim_approval d ON d.other_claim_id = a.id
				LEFT JOIN aims_claim_financeuse f ON a.id = f.other_claim_id
				WHERE c.no_staff = '$no_staff' 
				ORDER BY a.date_created DESC";
		$result = $conn->query($sql);
		return $result;
	}
	function list_others_claim($id){
		$conn=db();
		$sql = "SELECT id,date_purchase,description,total_claim,month_claim,company,staff_record_id,job_no,document,document_name,document_type,date_created FROM aims_others_claim WHERE id = '$id'";
		$result = $conn->query($sql);
		return $result;
	}

	function getOClaimInfo($id){
	$conn=db();
	$sql = "SELECT document_name FROM aims_others_claim WHERE id='$id'";
	$result = $conn->query($sql);
	return $result;
    }

	function DeletePassword($id){
		$conn=db();
		
		$sql = "DELETE FROM aims_others_claim WHERE id = '$id'";
		$result = $conn->query($sql);
		
		$sql = "DELETE FROM aims_others_claim_approval WHERE other_claim_id = '$id'";
		$result = $conn->query($sql);
		
		$sql = "DELETE FROM aims_claim_financeuse WHERE other_claim_id = '$id'";
		$result = $conn->query($sql);
		return $result;
	}
	function getValueName($no_staff){
	$conn=db();
	$sql="SELECT * FROM staff WHERE no_staff='$no_staff'";
	$result = $conn->query($sql);
	return $result;


}
function getStaffPendidikan($no_staff) {
	$conn=db();
	$sql = "SELECT *
	FROM staff_education WHERE no_staff='$no_staff' ORDER BY tahun_mula DESC";
	$result = $conn->query($sql);
	return $result;
}
function getStaffRecord($no_staff) {
	$conn=db();
	$sql = " SELECT s.*,sr.*,d.description,m.desc 
	FROM staff s LEFT JOIN staff_record sr ON s.no_staff=sr.no_staff
	AND s.jawatan_code=sr.jawatan
	LEFT JOIN department d ON d.code_department=s.department_id
	LEFT JOIN martial m ON m.id=s.martial_status
	WHERE s.no_staff='$no_staff'";
	$result = $conn->query($sql);
	return $result;
}

	function getStaffForms($claim_id,$status,$tahun){
        $conn=db();
        $sql = "SELECT ot.*,s.name,ap.hr_review_status,ap.hr_review_by,YEAR(ot.date_created) AS tahun FROM staff s
		 LEFT JOIN staff_record sr ON sr.no_staff = s.no_staff
		 LEFT JOIN aims_others_claim ot ON sr.id = ot.staff_record_id
		 LEFT JOIN aims_others_claim_approval ap ON ot.id = ap.other_claim_id
		 WHERE ot.id = '$claim_id'
		 AND ap.hr_review_status = '$status'
		 AND YEAR(ot.date_created) = '$tahun'"; 
        $result = $conn->query($sql);
       return $result;        
    }
	
	function getOtherclaimreport($claim_id,$status,$tahun){
        $conn=db();
        $sql = "SELECT ot.*,s.name,ap.hr_review_status,ap.hr_review_by,ap.hr_review_date,ap.hod_review_by,ap.hod_review_status,ap.hod_review_date,
		ap.approve_by,ap.approve_status,ap.approve_date,YEAR(ot.date_created) AS tahun,af.advance,
		af.total_monthclaim,af.refund,af.outstanding FROM staff s
		 LEFT JOIN staff_record sr ON sr.no_staff = s.no_staff
		 LEFT JOIN aims_others_claim ot ON sr.id = ot.staff_record_id
		 LEFT JOIN aims_others_claim_approval ap ON ot.id = ap.other_claim_id
		 LEFT JOIN aims_claim_financeuse af ON ot.id = af.other_claim_id
		 WHERE ot.id = '$claim_id'
		 AND ap.hr_review_status = '$status'
		 AND YEAR(ot.date_created) = '$tahun'"; 
        $result = $conn->query($sql);
       return $result;        
    }
	
	function getStaffOT($claim_id){
        $conn=db();
        $sql = "SELECT ot.*,s.name,s.noic,s.department_sub,ap.hr_review_status FROM staff s
		 LEFT JOIN staff_record sr ON sr.no_staff = s.no_staff
		 LEFT JOIN aims_others_claim ot ON sr.id = ot.staff_record_id
		 LEFT JOIN aims_others_claim_approval ap ON ot.id = ap.other_claim_id
		 WHERE ot.id = '$claim_id'"; 
        $result = $conn->query($sql);
       return $result;        
    }

	function getStaffForm($no_staff){
        $conn=db();
        $sql = " SELECT ot.*,s.name,s.department_sub,s.department_id ,s.noic,sr.id AS st_record_id FROM staff s
			LEFT JOIN staff_record sr ON sr.no_staff = s.no_staff	
			LEFT JOIN aims_others_claim ot ON sr.id = ot.staff_record_id
			WHERE s.no_staff = '$no_staff'"; 
        $result = $conn->query($sql);
       return $result;        
    }
	
	function updateStaff2($id,$tahun,$hr_review_by,$hr_review_status,$total_monthclaim){
    $conn=db();
    $sql = "UPDATE aims_others_claim_approval ap
	LEFT JOIN aims_others_claim a ON a.id = ap.other_claim_id
	SET ap.hr_review_by='$hr_review_by', ap.hr_review_status='$hr_review_status' , ap.hr_review_date = CURRENT_TIMESTAMP WHERE a.id='$id' AND YEAR(a.date_created)='$tahun'";
	$result = $conn->query($sql);
	
	$sql = "UPDATE aims_others_claim SET total_expenses ='$total_monthclaim' WHERE id='$id' AND YEAR(date_created)='$tahun'";
	$result = $conn->query($sql);
	return $result;
	}
	
	function updateStaff3($claim_id,$approve_by,$approve_status){
    $conn=db();
    $sql = "UPDATE aims_others_claim_approval ap
			LEFT JOIN aims_others_claim a ON a.id = ap.other_claim_id
			LEFT JOIN aims_claim_financeuse b ON a.id = b.other_claim_id
			SET ap.approve_by='$approve_by', ap.approve_status='$approve_status' , ap.approve_date = CURRENT_TIMESTAMP
			WHERE a.id='$claim_id'
			AND b.finance_status = 'CHECK'";
			
	$result = $conn->query($sql);
	return $result;
	}
	
	function getStaffOcById($claim_id){
		$conn=db();
		$sql = "SELECT a.*,ap.approve_status FROM aims_others_claim a
		LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
		WHERE a.id='$claim_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getStaffOcById2($id,$tahun){
		$conn=db();
		$sql = "SELECT a.*,ap.hr_review_status FROM aims_others_claim a
		LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
		WHERE a.id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function updateNotiPelulus($approve_by,$approve_date,$approve_status){
	$conn=db();
	$sql="UPDATE aims_others_claim_approval SET approve_status='1'
	WHERE description='$approve_by'
	AND status='$approve_status'";

	$result = $conn->query($sql);
	return $result;
}
	
function activeplatform($id){

        $conn = db();
		$sql = "UPDATE aims_others_claim_approval SET status = 'APPROVED' WHERE id='$id'";
		$result = $conn->query($sql);

		return $result;
    }
	
	  function deactiveplatform($id){

        $conn = db();
		$sql = "UPDATE aims_others_claim_approval SET status = 'DISAPPROVED' WHERE id='$id'";
		$result = $conn->query($sql);

		return $result;
    }
	
	function reviewplatform($id){

        $conn = db();
		$sql = "UPDATE aims_others_claim_approval SET status = 'REVIEW' WHERE id='$id'";
		$result = $conn->query($sql);

		return $result;
    }
	
	function pendingplatform($id){

        $conn = db();
		$sql = "UPDATE aims_others_claim_approval SET status = 'PENDING' WHERE id='$id'";
		$result = $conn->query($sql);

		return $result;
    }
	
	function getCutiStaffByPrevYear($no_staff){
        $conn=db();
        $sql=" SELECT sh.* ,jc.desc AS nama_cuti,ha.approvement,ha.catatan, jk.jenis_lulus,jk.code, sr.no_staff FROM staff_holiday sh 
                LEFT JOIN holiday_approve ha ON ha.staff_holiday_id=sh.id
                LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id 
                LEFT JOIN jenis_kelulusan jk ON jk.code=ha.approvement
                LEFT JOIN jenis_cuti jc ON jc.code=sh.cuti_dipohon
                WHERE sr.no_staff='$no_staff'
                AND DATE_FORMAT(sh.tarikh_mula,'%Y') < DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')
                ORDER BY sh.id DESC ";
        $result=$conn->query($sql);
        return $result;  
    }

    function getLampiranInfo($id){
        $conn=db();
        $sql=" SELECT * FROM aims_others_claim
                WHERE id='$id'";
        $result=$conn->query($sql);
        return $result;  
    }

	function getTravelVerifiednew($department_code,$department_sub) {
    $conn=db();
	
	if($department_sub == 'HR'){
    $sql = "SELECT s.name,s.noic,s.department_sub,s.department_id,st.id,ap.approve_status,ap.approve_by,
			ap.hr_review_status,ap.hr_review_by,ap.hod_review_status,ap.hod_review_date,ap.hod_review_by,ap.payment_status,a.company_claim,af.finance_review_date,
			af.finance_reviewby,af.finance_status,a.month_claim,YEAR(a.date_created) as tahun,a.id AS claim_id,a.document_name
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN aims_claim_financeuse af ON a.id = af.other_claim_id
			WHERE ap.hod_review_status = 'VERIFIED'
			AND ap.hr_review_status = 'PENDING'
			AND a.company_claim = '$department_code'
			ORDER BY a.date_created DESC";
    }
	else {
				echo ("<script LANGUAGE='JavaScript'>
						window.history.back();
						</script>");
		//header("location: ../view/list_faq.php");
		exit();
	}

    $result = $conn->query($sql);
    return $result;
  }
  
  
  
  	function getTravelVerifiedApprove($department_code) {
    $conn=db();
    $sql = "SELECT s.name,s.noic,s.department_sub,s.department_id,st.id,ap.approve_status,ap.approve_date,ap.approve_by,
			ap.hr_review_status,ap.hr_review_date,ap.hr_review_by,ap.hod_review_status,ap.hod_review_date,ap.hod_review_by,ap.payment_status,a.company_claim,af.finance_review_date,
			af.finance_reviewby,af.finance_status,a.month_claim,YEAR(a.date_created) as tahun,a.id AS claim_id,a.document_name
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN aims_claim_financeuse af ON a.id = af.other_claim_id
			WHERE ap.hod_review_status = 'VERIFIED'
			AND ap.hr_review_status = 'REVIEW'
			AND ap.payment_status = 'OPEN'
			AND a.company_claim = '$department_code'
			ORDER BY a.date_created DESC";
    

    $result = $conn->query($sql);
    return $result;
  }
  
  function  getClaimHrClosed($department_code) {
    $conn=db();
    $sql = "SELECT s.name,s.noic,s.department_sub,s.department_id,st.id,ap.approve_status,ap.approve_date,ap.approve_by,
			ap.hr_review_status,ap.hr_review_date,ap.hr_review_by,ap.hod_review_status,ap.hod_review_date,ap.hod_review_by,ap.payment_status,a.company_claim,af.finance_review_date,
			af.finance_reviewby,af.finance_status,a.month_claim,YEAR(a.date_created) as tahun,a.id AS claim_id,a.document_name
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN aims_claim_financeuse af ON a.id = af.other_claim_id
			WHERE ap.hod_review_status = 'VERIFIED'
			AND ap.hr_review_status = 'REVIEW'
			AND ap.payment_status = 'CLOSED'
			AND a.company_claim = '$department_code'
			ORDER BY a.date_created DESC";
    

    $result = $conn->query($sql);
    return $result;
  }
  
  	function getTravelVerifiedDisapprove($department_code) {
    $conn=db();
    $sql = "SELECT s.name,s.noic,s.department_sub,s.department_id,st.id,ap.approve_status,ap.approve_date,ap.approve_by,
			ap.hr_review_status,ap.hr_review_date,ap.hr_review_by,ap.hod_review_status,ap.hod_review_date,ap.hod_review_by,ap.payment_status,a.company_claim,af.finance_review_date,
			af.finance_reviewby,af.finance_status,a.month_claim,YEAR(a.date_created) as tahun,a.id AS claim_id,a.document_name
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN aims_claim_financeuse af ON a.id = af.other_claim_id
			WHERE ap.hod_review_status = 'VERIFIED'
			AND ap.hr_review_status = 'DISAPPROVE'
			AND a.company_claim = '$department_code'
			ORDER BY a.date_created DESC";
    

    $result = $conn->query($sql);
    return $result;
  }
  
  function closeClaim($id,$payment_status){
    $conn=db();
    $sql = "UPDATE aims_others_claim_approval ap
			LEFT JOIN aims_others_claim a ON a.id = ap.other_claim_id
			SET ap.payment_status='CLOSED' WHERE a.id='$id'
			AND ap.hod_review_status = 'VERIFIED' 
			AND ap.hr_review_status = 'REVIEW'";
	$result = $conn->query($sql);
	return $result;
	}
	
	function closeClaimFinance($id,$finance_payment_status){
    $conn=db();
    $sql = "UPDATE aims_claim_financeuse af 
			LEFT JOIN aims_others_claim a ON a.id = af.other_claim_id
            LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			SET af.finance_payment_status='$finance_payment_status', af.date_payment_status = CURRENT_TIMESTAMP
			WHERE af.other_claim_id='$id'
			AND ap.hod_review_status = 'VERIFIED' 
			AND ap.hr_review_status = 'REVIEW'
            AND af.finance_status = 'CHECK'";
	$result = $conn->query($sql);
	return $result;
	}
  
  function  getTravelApprovenew($no_staff) {
    $conn=db();
	  
	if ( $no_staff == '660512115105' ) {
    $sql = "SELECT s.name,s.noic,s.department_sub,s.department_id,st.id,ap.approve_status,ap.approve_by,ap.approve_date,
			ap.hr_review_status,ap.hr_review_by,ap.hr_review_date,ap.hod_review_status,ap.hod_review_date,ap.hod_review_by,
			a.month_claim,YEAR(a.date_created) AS tahun,a.company_claim,a.id AS claim_id
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN aims_claim_financeuse af ON a.id = af.other_claim_id
			WHERE ap.hod_review_status = 'VERIFIED'
			AND ap.hr_review_status = 'REVIEW'
			AND af.finance_status = 'CHECK'
			AND (s.role_id IN ('FOUNDER','HOD','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO') OR s.department_sub = 'ECOFFICE' OR s.no_staff = '810415035497')
			AND s.no_staff != '$no_staff'
			AND ap.approve_status = 'PENDING'
			ORDER BY a.date_created DESC";
    }
	
	else if ( $no_staff == '751206035485'){
    $sql = "SELECT s.name,s.noic,s.department_sub,s.department_id,st.id,ap.approve_status,ap.approve_by,ap.approve_date,
			ap.hr_review_status,ap.hr_review_by,ap.hr_review_date,ap.hod_review_status,ap.hod_review_date,ap.hod_review_by,
			a.month_claim,YEAR(a.date_created) AS tahun,a.company_claim,a.id AS claim_id
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN aims_claim_financeuse af ON a.id = af.other_claim_id
			WHERE ap.hod_review_status = 'VERIFIED'
			AND ap.hr_review_status = 'REVIEW'
			AND af.finance_status = 'CHECK'
			AND (s.role_id NOT IN ('HOD','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR','MANAGER') AND s.no_staff <> '810415035497') 
			AND s.department_sub !='ECOFFICE'
			AND s.no_staff != '$no_staff'
			AND ap.approve_status = 'PENDING'
			ORDER BY a.date_created DESC";
    }

    $result = $conn->query($sql);
    return $result;
  }
  
  	function  getTravelApprove($no_staff) {
    $conn=db();
     $sql = "SELECT role_id FROM staff WHERE name='$no_staff'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
	  
	if ( $no_staff == '660512115105' ) {
    $sql = "SELECT s.name,s.noic,s.department_sub,s.department_id,st.id,ap.approve_status,ap.approve_by,ap.approve_date,
			ap.hr_review_status,ap.hr_review_by,ap.hr_review_date,ap.hod_review_status,ap.hod_review_date,ap.hod_review_by,
			a.month_claim,YEAR(a.date_created) AS tahun,a.company_claim,a.id AS claim_id
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN aims_claim_financeuse af ON a.id = af.other_claim_id
			WHERE ap.hod_review_status = 'VERIFIED'
			AND ap.hr_review_status = 'REVIEW'
			AND af.finance_status = 'CHECK'
			AND (s.department_sub = 'ECOFFICE'
			OR s.role_id IN ('FOUNDER','HOD','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO') OR s.no_staff = '810415035497')
			AND s.no_staff != '$no_staff'
			AND ap.approve_status = 'APPROVED'
			ORDER BY a.date_created DESC";
    }
	
	else if ( $no_staff == '751206035485'){
    $sql = "SELECT s.name,s.noic,s.department_sub,s.department_id,st.id,ap.approve_status,ap.approve_by,ap.approve_date,
			ap.hr_review_status,ap.hr_review_by,ap.hr_review_date,ap.hod_review_status,ap.hod_review_date,ap.hod_review_by,
			a.month_claim,YEAR(a.date_created) AS tahun,a.company_claim,a.id AS claim_id
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN aims_claim_financeuse af ON a.id = af.other_claim_id
			WHERE ap.hod_review_status = 'VERIFIED'
			AND ap.hr_review_status = 'REVIEW'
			AND af.finance_status = 'CHECK'
			AND (s.role_id NOT IN ('HOD','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR','MANAGER') AND s.no_staff <> '810415035497')
			AND s.department_sub !='ECOFFICE'
			AND s.no_staff != '$no_staff'
			AND ap.approve_status = 'APPROVED'
			ORDER BY a.date_created DESC";
    }
    $result = $conn->query($sql);
    return $result;
  }
  
  	function  getTravelDisapprove($no_staff) {
    $conn=db();
   $sql = "SELECT role_id FROM staff WHERE name='$no_staff'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
	  
	if ( $no_staff == '660512115105' ) {
    $sql = "SELECT s.name,s.noic,s.department_sub,s.department_id,st.id,ap.approve_status,ap.approve_by,ap.approve_date,
			ap.hr_review_status,ap.hr_review_by,ap.hr_review_date,ap.hod_review_status,ap.hod_review_date,ap.hod_review_by,
			a.month_claim,YEAR(a.date_created) AS tahun,a.company_claim,a.id AS claim_id
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN aims_claim_financeuse af ON a.id = af.other_claim_id
			WHERE ap.hod_review_status = 'VERIFIED'
			AND ap.hr_review_status = 'REVIEW'
			AND af.finance_status = 'CHECK'
			AND (s.department_sub = 'ECOFFICE'
			OR s.role_id IN ('FOUNDER','HOD','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO') OR s.no_staff = '810415035497')
			AND s.no_staff != '$no_staff'
			AND ap.approve_status = 'DISAPPROVE'
			ORDER BY a.date_created DESC";
    }
	
	else if ( $no_staff == '751206035485'){
    $sql = "SELECT s.name,s.noic,s.department_sub,s.department_id,st.id,ap.approve_status,ap.approve_by,ap.approve_date,
			ap.hr_review_status,ap.hr_review_by,ap.hr_review_date,ap.hod_review_status,ap.hod_review_date,ap.hod_review_by,
			a.month_claim,YEAR(a.date_created) AS tahun,a.company_claim,a.id AS claim_id
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN aims_claim_financeuse af ON a.id = af.other_claim_id
			WHERE ap.hod_review_status = 'VERIFIED'
			AND ap.hr_review_status = 'REVIEW'
			AND af.finance_status = 'CHECK'
			AND (s.role_id NOT IN ('HOD','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR','MANAGER') AND s.no_staff = '810415035497')
			AND s.department_sub !='ECOFFICE'
			AND s.no_staff != '$no_staff'
			AND ap.approve_status = 'DISAPPROVE'
			ORDER BY a.date_created DESC";
    }
    $result = $conn->query($sql);
    return $result;
  }
  
  function getTravel_Verified_ApprovebyId($id){
    $conn=db();
    $sql ="SELECT * FROM aims_others_claim_approval WHERE id='$id'";  
    $result = $conn->query($sql);
    return $result;
  }
  
  function getTotal_claim($claim_id,$tahun){
    $conn=db();
    $sql ="SELECT SUM(milage) AS total_milage,SUM(total_claim) AS total, SUM(hotel_allowance) AS total_hotel, SUM(daily_allowance) AS total_daily,SUM(milage) + SUM(total_claim) + SUM(hotel_allowance) + SUM(daily_allowance) AS total_expenses, total_to_be_paid FROM aims_others_claim 
	WHERE id = '$claim_id' AND YEAR(date_created) = '$tahun'";  
    $result = $conn->query($sql);
    return $result;
  }
  
  
   function gethrname($claim_id,$tahun){
    $conn=db();
    $sql ="SELECT ap.hr_review_by from aims_others_claim_approval ap
	LEFT JOIN aims_others_claim a ON a.id = ap.other_claim_id
	WHERE a.id = '$claim_id' AND YEAR(a.date_created) = '$tahun'";  
    $result = $conn->query($sql);
    return $result;
  }
  
    function getothfoto($id,$month){
    $conn=db();
    $sql="select * from aims_others_claim where staff_record_id = '$id' and month_claim ='$month'";
	$result = $conn->query($sql);
    return $result;
  }
  
    function getCheckboxUpdateOthersclaimceo($claim_id,$staff_name){
	$conn=db();
	if(isset($_POST['checkbox'])){
	    $checkbox = $_POST['checkbox'];
    	if(isset($_POST['activate'])?$activate = $_POST["activate"]:$deactivate = $_POST["deactivate"])
    		$claim_id = "('" . implode( "','", $checkbox ) . "');" ;
    	$sql="UPDATE aims_others_claim SET approve_status = '".(isset($activate)?'APPROVED':'DISAPPROVED')."',approve_by='$staff_name',approve_date=CURRENT_TIMESTAMP 
			  WHERE id IN $claim_id" ;
    	$result=$conn->query($sql);
    	return $result;
    }
}

//finance user

function  getTravelVerifiednewfinance($department_code,$department_sub) {
    $conn=db();

	if ($department_sub == 'FINACC'){
    $sql = "SELECT s.name,s.noic,s.department_sub,s.department_id,st.id,ap.approve_status,ap.approve_by,
			ap.hr_review_status,ap.hr_review_by,ap.hod_review_status,ap.hod_review_date,ap.hod_review_by,a.company_claim,af.finance_review_date,
			af.finance_reviewby,af.finance_status,af.finance_payment_status,af.date_payment_status,a.month_claim,YEAR(a.date_created) AS tahun, a.id AS claim_id
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN aims_claim_financeuse af ON a.id = af.other_claim_id
			WHERE ap.hr_review_status = 'REVIEW'
			AND af.finance_status = 'PENDING'
			AND af.finance_payment_status = 'OPEN'
			AND a.company_claim = '$department_code'
			ORDER BY a.date_created DESC";
    }
	else {
		echo ("<script LANGUAGE='JavaScript'>
						window.history.back();
						</script>");
		//header("location: ../view/list_faq.php");
		exit();
	}

    $result = $conn->query($sql);
    return $result;
  }
  
  function getTravelVerifiedApprovefinance($department_code) {
    $conn=db();
	
    $sql = "SELECT s.name,s.noic,s.department_sub,s.department_id,st.id,ap.approve_status,ap.approve_by,
			ap.hr_review_status,ap.hr_review_by,ap.hod_review_status,ap.hod_review_date,ap.hod_review_by,a.company_claim,af.finance_review_date,
			af.finance_reviewby,af.finance_status,af.finance_payment_status,af.date_payment_status,a.month_claim,YEAR(a.date_created) AS tahun , a.id AS claim_id
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN aims_claim_financeuse af ON a.id = af.other_claim_id
			WHERE ap.hr_review_status = 'REVIEW'
			AND af.finance_status = 'CHECK'
			AND af.finance_payment_status = 'OPEN'
			AND a.company_claim = '$department_code'
			ORDER BY a.date_created DESC";
    

    $result = $conn->query($sql);
    return $result;
  }
  
  	function getTravelfinanceClosed($department_code) {
    $conn=db();
	
    $sql = "SELECT s.name,s.noic,s.department_sub,s.department_id,st.id,ap.approve_status,ap.approve_by,
			ap.hr_review_status,ap.hr_review_by,ap.hod_review_status,ap.hod_review_date,ap.hod_review_by,a.company_claim,af.finance_review_date,
			af.finance_reviewby,af.finance_status,af.finance_payment_status,af.date_payment_status,a.month_claim,YEAR(a.date_created) AS tahun , a.id AS claim_id
			FROM staff s
			LEFT JOIN staff_record st ON s.no_staff = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN aims_claim_financeuse af ON a.id = af.other_claim_id
			WHERE ap.hr_review_status = 'REVIEW'
			AND af.finance_status = 'CHECK'
			AND af.finance_payment_status = 'CLOSED'
			AND a.company_claim = '$department_code'
			ORDER BY a.date_created DESC";
    

    $result = $conn->query($sql);
    return $result;
  }
  
  
  function UpdateFinanceAction($claim_id,$tahun,$company,$advance,$total_monthclaim,$refund,$outstanding,$finance_status,$name_fin){
    $conn=db();
    
    if($finance_status == 'CHECK'){
    $sql ="UPDATE aims_claim_financeuse af
	LEFT JOIN aims_others_claim a ON a.id = af.other_claim_id
	SET af.advance = '$advance',af.total_monthclaim = '$total_monthclaim',af.refund = '$refund',af.outstanding = '$outstanding',af.finance_status = '$finance_status',af.finance_reviewby = '$name_fin',af.finance_review_date = CURRENT_TIMESTAMP
	WHERE a.id = '$claim_id'
	AND YEAR(a.date_created)='$tahun'"; 
    }
    else{
      $sql ="UPDATE aims_claim_financeuse af
	LEFT JOIN aims_others_claim a ON a.id = af.other_claim_id
	SET af.finance_status = '$finance_status'
	WHERE a.id = '$claim_id'
	AND YEAR(a.date_created)='$tahun'"; 
      
    }
    $result = $conn->query($sql);
    return $result;
  }
  
   function getfinanceAction($claim_id,$tahun){
    $conn=db();
    $sql ="SELECT af.* FROM aims_claim_financeuse af
	LEFT JOIN aims_others_claim a ON a.id = af.other_claim_id
	WHERE a.id='$claim_id'
	AND YEAR(a.date_created) = '$tahun'";
    $result = $conn->query($sql);
    return $result;
  }
  
  function getCheckboxUpdateOtCeo($claim_id,$staff_name){
	$conn=db();
	if(isset($_POST['checkbox'])){
	    $checkbox = $_POST['checkbox'];
    	if(isset($_POST['activate'])?$activate = $_POST["activate"]:$deactivate = $_POST["deactivate"])
    	    $claim_id = "('" . implode( "','", $checkbox ) . "')" ;
    		
    	$sql="UPDATE aims_others_claim_approval SET approve_status = '".(isset($activate)?'APPROVED':'DISAPPROVE')."',approve_by='$staff_name',approve_date=CURRENT_TIMESTAMP WHERE other_claim_id IN $claim_id";
    	$result=$conn->query($sql);
    	return $result;
    }
    }
  
  function ceoBatch($approve_status,$claim_id) {
    $conn=db();
    $sql = "SELECT GROUP_CONCAT(a.id SEPARATOR '-') AS claim_id
			FROM aims_others_claim a
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN staff_record st ON a.staff_record_id = st.id
			LEFT JOIN staff s ON s.no_staff = st.no_staff
			WHERE ap.approve_status = '$approve_status'
			AND a.id = '$claim_id'
			ORDER BY a.date_created";
			
    $result = $conn->query($sql);
    return $result;
  }
	$conn->close();
?>