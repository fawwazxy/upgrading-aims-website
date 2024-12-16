<?php
	require '../../lib/db/connection.php';

	// Function to sanitize values received from the form. Prevents SQL injection
     $action = $_POST['action'];
    if($action == "getCutiInfo"){
        $code = $_POST['code'];
        $staff_record_id = $_POST['staff_record_id'];
        $conn=db();
        // $sql = "SELECT rule_cuti FROM staff_record WHERE staff_record_id='$staff_record_id'";
        // $rule_cuti = $conn->query($sql)->fetch_object()->rule_cuti;
        $sql = "SELECT * FROM staff_total_cuti WHERE jenis_cuti='$code' AND tahun = YEAR(CURRENT_TIMESTAMP) AND staff_record_id ='$staff_record_id'";
        $result = $conn->query($sql);
        if($result->num_rows>0) {
            $rows = array();
            while($r = $result->fetch_assoc()) {
            $rows[] = $r;
        }
          echo json_encode($rows);
        }
    else {
        $sql = "SELECT rule_cuti FROM staff_record WHERE id='$staff_record_id'";
        $rule_cuti = $conn->query($sql)->fetch_object()->rule_cuti;
        $sql = "INSERT INTO staff_total_cuti (staff_record_id,jenis_cuti,total_cuti,baki_cuti,baki_cuti_pohon,tahun) (SELECT '$staff_record_id',code,$rule_cuti,$rule_cuti,$rule_cuti,YEAR(CURRENT_TIMESTAMP) FROM jenis_cuti WHERE code = '$code')";
        $result = $conn->query($sql);
        $sql = "SELECT * FROM staff_total_cuti WHERE jenis_cuti='$code' AND tahun = YEAR(CURRENT_TIMESTAMP) AND staff_record_id ='$staff_record_id'";
        $result = $conn->query($sql);
        $rows = array();
        while($r = $result->fetch_assoc()) {
        $rows[] = $r;
      }
        echo json_encode($rows);
      }
    

    // echo $result[0]->fetch_object()->$total_cuti;
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
	
    function login($username,$password) {
  		  $conn=db();
  		  $sql = "SELECT * FROM staff WHERE username='$username' AND accs_pwd='$password'";
  		  $result = $conn->query($sql);
  		  return $result;
    }
	
    function getLogUser($com_id) {
		    $conn=db();
		    $sql = "SELECT * FROM staff WHERE company_id='$com_id'";
		    $result = $conn->query($sql);
        return $result;
    }
	
	function getDropDownAnnual($selected) {
		$conn=db();
		 $sql = "SELECT id,anual_type FROM aims_lv_anual_type";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[1]."\">".$row[1]."</option>";
		}
		
		
		return $txt_result;
	}	
	
	
	
    function addMohoncutikecemasan($staff_record_id,$cuti_dipohon,$tarikh_mula,$tarikh_akhir,$sebab,$alamat_cuti,$baki_cuti){
        $conn=db();
		    $sql = "INSERT INTO staff_holiday(staff_record_id,cuti_dipohon,tarikh_mula,tarikh_akhir,sebab,alamat_cuti,baki_cuti)
		        VALUES('$staff_record_id','$cuti_dipohon','$tarikh_mula','$tarikh_akhir','$sebab','$alamat_cuti','$baki_cuti')";
		    $result = $conn->query($sql);
		    return $result;
    }

    function addleaveold($staff_record_id,$departmant_id,$date_fill,$dic_leave,$date_lv_from,$date_lv_to,$day_lv_from,$day_lv_to,$type_leave,$reason_leave,$descrip,$total_lv_req,$document,$document_name,$fileType){
		$conn=db();
        $gambar = '';
        $gambar_val = '';
        if($document_name!=""){
            $gambar=" ,document,document_type,document_name";
            $gambar_val=",'$document','$fileType','$document_name'";
        }
		$sql = "INSERT INTO aims_lv_form (staff_record_id, department_id, date_fill, dic_leave, date_lv_from, date_lv_to, day_lv_from,day_lv_to, type_leave, reason_leave, descrip, total_lv_req, document, document_type, document_name) 
		VALUES('$staff_record_id','$departmant_id','$date_fill','$dic_leave',STR_TO_DATE('$date_lv_from','%d/%m/%Y'),STR_TO_DATE('$date_lv_to','%d/%m/%Y'),'$day_lv_from','$day_lv_to','$type_leave','$reason_leave','$descrip','$total_lv_req','$document','$fileType','$document_name')";
		$result = $conn->query($sql);
		
		$staff_holiday_id = $conn->insert_id;  
        //query insert data ke table holiday_approve
        $sql1 ="INSERT INTO approve_holiday(staff_holiday_id,approvement,support) VALUES('$staff_holiday_id','PENDING','PENDING')";
        $result = $conn->query($sql1);

        $sql="UPDATE staff_total_cuti SET baki_cuti_pohon=baki_cuti_pohon-'$total_lv_req' WHERE staff_record_id='$staff_record_id' AND jenis_cuti ='$type_leave' AND tahun = YEAR(CURRENT_TIMESTAMP)";
        $result = $conn->query($sql);

        return $result;   
    }
    
    function addleave($staff_record_id,$departmant_id,$date_fill,$dic_leave,$date_lv_from,$date_lv_to,$day_lv_from,$day_lv_to,$type_leave,$reason_leave,$descrip,$total_lv_req,$document,$document_name,$fileType){
		$conn=db();
		
		$sql = "SELECT baki_cuti_pohon FROM staff_total_cuti WHERE staff_record_id='$staff_record_id' AND jenis_cuti = 'AL'";
		$baki_cuti_pohon =$conn->query($sql)->fetch_object()->baki_cuti_pohon;
		
		$sql = "SELECT baki_cuti_pohon FROM staff_total_cuti WHERE staff_record_id='$staff_record_id' AND jenis_cuti = 'MC'";
		$baki_cuti_pohon1 =$conn->query($sql)->fetch_object()->baki_cuti_pohon;
		
		if($type_leave == 'AL'){
			if($baki_cuti_pohon < $total_lv_req){
				echo("<script LANGUAGE='JavaScript'>
					 alert('Maaf, baki cuti permohonan anda sudah habis atau tidak mencukupi!');
					 window.location.href='../view/aims_lv.php';
				</script>");
			}
			else{
			$gambar = '';
			$gambar_val = '';
			if($document_name!=""){
				$gambar=" ,document,document_type,document_name";
				$gambar_val=",'$document','$fileType','$document_name'";
			}
			$sql = "INSERT INTO aims_lv_form (staff_record_id, department_id, date_fill, dic_leave, date_lv_from, date_lv_to, day_lv_from,day_lv_to, type_leave, reason_leave, descrip, total_lv_req$gambar) 
			VALUES('$staff_record_id','$departmant_id','$date_fill','$dic_leave',STR_TO_DATE('$date_lv_from','%d/%m/%Y'),STR_TO_DATE('$date_lv_to','%d/%m/%Y'),'$day_lv_from','$day_lv_to','$type_leave','$reason_leave','$descrip','$total_lv_req'$gambar_val)";
			$result = $conn->query($sql);
			
			$staff_holiday_id = $conn->insert_id;  
			//query insert data ke table holiday_approve
			$sql1 ="INSERT INTO approve_holiday(staff_holiday_id,approvement,support) VALUES('$staff_holiday_id','IN PROGRESS','IN PROGRESS')";
			$result = $conn->query($sql1);

			$sql="UPDATE staff_total_cuti SET baki_cuti_pohon=baki_cuti_pohon-'$total_lv_req' WHERE staff_record_id='$staff_record_id' AND jenis_cuti ='$type_leave' AND tahun = YEAR(CURRENT_TIMESTAMP)";
			$result = $conn->query($sql);
			}
		}
		else if($type_leave == 'MC'){
			if($baki_cuti_pohon1 < $total_lv_req){
				echo("<script LANGUAGE='JavaScript'>
					 alert('Maaf, baki MC anda sudah habis atau tidak mencukupi!');
					 window.location.href='../view/aims_lv.php';
				</script>");
			} else{
			$gambar = '';
			$gambar_val = '';
			if($document_name!=""){
				$gambar=" ,document,document_type,document_name";
				$gambar_val=",'$document','$fileType','$document_name'";
			}
			$sql = "INSERT INTO aims_lv_form (staff_record_id, department_id, date_fill, dic_leave, date_lv_from, date_lv_to, day_lv_from,day_lv_to, type_leave, reason_leave, descrip, total_lv_req$gambar) 
			VALUES('$staff_record_id','$departmant_id','$date_fill','$dic_leave',STR_TO_DATE('$date_lv_from','%d/%m/%Y'),STR_TO_DATE('$date_lv_to','%d/%m/%Y'),'$day_lv_from','$day_lv_to','$type_leave','$reason_leave','$descrip','$total_lv_req'$gambar_val)";
			$result = $conn->query($sql);
			
			$staff_holiday_id = $conn->insert_id;  
			//query insert data ke table holiday_approve
			$sql1 ="INSERT INTO approve_holiday(staff_holiday_id,approvement,support) VALUES('$staff_holiday_id','IN PROGRESS','IN PROGRESS')";
			$result = $conn->query($sql1);

			$sql="UPDATE staff_total_cuti SET baki_cuti_pohon=baki_cuti_pohon-'$total_lv_req' WHERE staff_record_id='$staff_record_id' AND jenis_cuti ='$type_leave' AND tahun = YEAR(CURRENT_TIMESTAMP)";
			$result = $conn->query($sql);
			}
		}
		else{
			$gambar = '';
			$gambar_val = '';
			if($document_name!=""){
				$gambar=" ,document,document_type,document_name";
				$gambar_val=",'$document','$fileType','$document_name'";
			}
			$sql = "INSERT INTO aims_lv_form (staff_record_id, department_id, date_fill, dic_leave, date_lv_from, date_lv_to, day_lv_from,day_lv_to, type_leave, reason_leave, descrip, total_lv_req$gambar) 
			VALUES('$staff_record_id','$departmant_id','$date_fill','$dic_leave',STR_TO_DATE('$date_lv_from','%d/%m/%Y'),STR_TO_DATE('$date_lv_to','%d/%m/%Y'),'$day_lv_from','$day_lv_to','$type_leave','$reason_leave','$descrip','$total_lv_req'$gambar_val)";
			$result = $conn->query($sql);
			
			$staff_holiday_id = $conn->insert_id;  
			//query insert data ke table holiday_approve
			$sql1 ="INSERT INTO approve_holiday(staff_holiday_id,approvement,support) VALUES('$staff_holiday_id','IN PROGRESS','IN PROGRESS')";
			$result = $conn->query($sql1);

			$sql="UPDATE staff_total_cuti SET baki_cuti_pohon=baki_cuti_pohon-'$total_lv_req' WHERE staff_record_id='$staff_record_id' AND jenis_cuti ='$type_leave' AND tahun = YEAR(CURRENT_TIMESTAMP)";
			$result = $conn->query($sql);
			}
        return $result;   
    }
    
	function addspecialleave($staff_record_id,$department_id,$date_fill,$dic_leave,$date_lv_from,$date_lv_to,$day_lv_from,$day_lv_to,$type_leave,$reason_leave,$descrip,$total_lv_req,$document,$document_name,$fileType){
		$conn=db();
		$gambar = '';
			$gambar_val = '';
			if($document_name!=""){
				$gambar=" ,document,document_type,document_name";
				$gambar_val=",'$document','$fileType','$document_name'";
			}
			$sql = "INSERT INTO aims_lv_form (staff_record_id, department_id, date_fill, dic_leave, date_lv_from, date_lv_to, day_lv_from,day_lv_to, type_leave, reason_leave, descrip, total_lv_req$gambar) 
			VALUES('$staff_record_id','$departmant_id','$date_fill','$dic_leave',STR_TO_DATE('$date_lv_from','%d/%m/%Y'),STR_TO_DATE('$date_lv_to','%d/%m/%Y'),'$day_lv_from','$day_lv_to','$type_leave','$reason_leave','$descrip','$total_lv_req'$gambar_val)";
			$result = $conn->query($sql);
			
			$staff_holiday_id = $conn->insert_id;  
			//query insert data ke table holiday_approve
			$sql1 ="INSERT INTO approve_holiday(staff_holiday_id,approvement,support) VALUES('$staff_holiday_id','IN PROGRESS','TIADA')";
			$result = $conn->query($sql1);
			
        return $result; 
	}    

    function updateCuti($staff_record_id,$staff_holiday_id,$no_staff,$date_fill,$dic_leave,$date_lv_from,$date_lv_to,$day_lv_from,$day_lv_to,$type_leave,$reason_leave,$descrip,$total_lv_req,$document,$document_name,$fileType,$baki_cuti_pohon){               
        $conn=db();
        $sql="UPDATE aims_lv_form SET date_fill='$date_fill', dic_leave='$dic_leave', 
        total_lv_req='$total_lv_req', date_lv_from =STR_TO_DATE('$date_lv_from','%d/%m/%Y'),date_lv_to=STR_TO_DATE('$date_lv_to','%d/%m/%Y'), day_lv_from ='$day_lv_from', day_lv_to ='$day_lv_to',
        reason_leave='$reason_leave',type_leave='$type_leave', descrip='$descrip'";
        if($document_name!=""){
          $sql.=" ,document='$document',document_type='$fileType',document_name='$document_name' "; 
        }
        $sql.="  WHERE id='$staff_holiday_id'";
        $result=$conn->query($sql) or die($conn->error);

        $sql="UPDATE staff_total_cuti SET baki_cuti_pohon='$baki_cuti_pohon' WHERE staff_record_id='$staff_record_id' AND jenis_cuti ='$type_leave' AND tahun = YEAR(CURRENT_TIMESTAMP)";
        $result = $conn->query($sql); 
      
        return $result; 
    }

    function getJenisCuti(){
        $conn=db();
        $sql = "SELECT * FROM jenis_cuti";
        $result = $conn->query($sql);
        return $result;   
    }
    
    function getStaffInformation($no_staff){
        $conn=db();
        $sql = "SELECT MAX(sr.id),sr.*,d.description AS department_name,s.department_id,s.alamat_tetap,s.noic,s.phone,s.email,s.alamat_surat,s.name AS staff_name, r.role,stc.*
                FROM staff_record sr 
                LEFT JOIN staff s ON s.no_staff=sr.no_staff 
                LEFT JOIN department d ON d.code_department=s.department_id 
                LEFT JOIN role r ON sr.peranan=r.code
                LEFT JOIN staff_total_cuti stc ON sr.id=stc.staff_record_id
                WHERE s.status = 'BEKERJA' AND s.noic IS NOT NULL 
                AND s.no_staff='$no_staff'
				AND stc.tahun = YEAR(CURRENT_TIMESTAMP)"; 
        $result = $conn->query($sql);
  	    return $result;        
    }

    function getStaffInformationAL($no_staff){
        $conn=db();
        $sql = "SELECT MAX(sr.id),sr.*,d.description AS department_name,s.alamat_tetap,s.noic,s.phone,s.email,s.alamat_surat,s.name AS staff_name,ca.cuti_diberi,ca.pindah_cuti, r.role,stc.*
                FROM staff_record sr 
                LEFT JOIN staff s ON s.no_staff=sr.no_staff 
                LEFT JOIN department d ON d.code_department=s.department_id 
                LEFT JOIN role r ON sr.peranan=r.code
                LEFT JOIN staff_total_cuti stc ON sr.id=stc.staff_record_id
				LEFT JOIN cuti_analisis ca ON sr.id = ca.staff_record_id
                WHERE s.status = 'BEKERJA' AND s.noic IS NOT NULL 
                AND s.no_staff='$no_staff' AND ca.jenis_cuti = 'AL'
				AND stc.tahun = YEAR(CURRENT_TIMESTAMP)"; 
        $result = $conn->query($sql);
  	    return $result;        
    }
	
	    function getStaffInformationMC($no_staff){
        $conn=db();
        $sql = "SELECT MAX(sr.id),sr.*,d.description AS department_name,s.alamat_tetap,s.noic,s.phone,s.email,s.alamat_surat,s.name AS staff_name,ca.cuti_diberi,ca.pindah_cuti, r.role,stc.*
                FROM staff_record sr 
                LEFT JOIN staff s ON s.no_staff=sr.no_staff 
                LEFT JOIN department d ON d.code_department=s.department_id 
                LEFT JOIN role r ON sr.peranan=r.code
                LEFT JOIN staff_total_cuti stc ON sr.id=stc.staff_record_id
				LEFT JOIN cuti_analisis ca ON sr.id = ca.staff_record_id
                WHERE s.status = 'BEKERJA' AND s.noic IS NOT NULL 
                AND s.no_staff='$no_staff' AND ca.jenis_cuti = 'MC'
				AND stc.tahun = YEAR(CURRENT_TIMESTAMP)"; 
        $result = $conn->query($sql);
  	    return $result;        
    }

    function getCutiInformationAL($no_staff){
        $conn=db();
        $sql = "SELECT MAX(sr.id),sr.*,d.description AS department_name,s.alamat_tetap,s.noic,s.phone,s.email,s.alamat_surat,s.name AS staff_name, r.role,stc.*
                FROM staff_record sr 
                LEFT JOIN staff s ON s.no_staff=sr.no_staff 
                LEFT JOIN department d ON d.code_department=s.department_id 
                LEFT JOIN role r ON sr.peranan=r.code
                LEFT JOIN staff_total_cuti stc ON sr.id = stc.staff_record_id
                WHERE s.status = 'BEKERJA' AND s.noic IS NOT NULL 
                AND s.no_staff='$no_staff'
                AND stc.jenis_cuti = 'AL'
                AND stc.tahun = YEAR(CURRENT_TIMESTAMP)"; 
        $result = $conn->query($sql);
        return $result;        
    }

    function getCutiInformationMC($no_staff){
        $conn=db();
        $sql = "SELECT MAX(sr.id),sr.*,d.description AS department_name,s.alamat_tetap,s.noic,s.phone,s.email,s.alamat_surat,s.name AS staff_name, r.role,stc.*
                FROM staff_record sr 
                LEFT JOIN staff s ON s.no_staff=sr.no_staff 
                LEFT JOIN department d ON d.code_department=s.department_id 
                LEFT JOIN role r ON sr.peranan=r.code
                LEFT JOIN staff_total_cuti stc ON sr.id = stc.staff_record_id
                WHERE s.status = 'BEKERJA' AND s.noic IS NOT NULL 
                AND s.no_staff='$no_staff'
                AND stc.jenis_cuti = 'MC'
                AND stc.tahun = YEAR(CURRENT_TIMESTAMP)"; 
        $result = $conn->query($sql);
        return $result;        
    }
	
	function getCutiAnalisaMC($no_staff) {
        $conn=db();
        $sql = "SELECT MAX(sr.id),sr.*,d.description AS department_name,s.alamat_tetap,s.noic,s.phone,s.email,s.alamat_surat,s.name AS staff_name, r.role,ca.*
                FROM staff_record sr 
                LEFT JOIN staff s ON s.no_staff=sr.no_staff 
                LEFT JOIN department d ON d.code_department=s.department_id 
                LEFT JOIN role r ON sr.peranan=r.code
				LEFT JOIN cuti_analisis ca ON sr.id = ca.staff_record_id
                WHERE s.status = 'BEKERJA' AND s.noic IS NOT NULL 
                AND s.no_staff='$no_staff'
                AND ca.jenis_cuti = 'MC'
                AND ca.tahun = YEAR(CURRENT_TIMESTAMP)"; 
        $result = $conn->query($sql);
        return $result;  		
	}

	function getCutiAnalisaAL($no_staff) {
        $conn=db();
        $sql = "SELECT MAX(sr.id),sr.*,d.description AS department_name,s.alamat_tetap,s.noic,s.phone,s.email,s.alamat_surat,s.name AS staff_name,al.total_lv_req, r.role,ca.*
                FROM staff_record sr 
                LEFT JOIN staff s ON s.no_staff=sr.no_staff 
                LEFT JOIN department d ON d.code_department=s.department_id 
                LEFT JOIN role r ON sr.peranan=r.code
				LEFT JOIN cuti_analisis ca ON sr.id = ca.staff_record_id
				LEFT JOIN aims_lv_form al ON sr.id = al.staff_record_id
                WHERE s.status = 'BEKERJA' AND s.noic IS NOT NULL 
                AND s.no_staff='$no_staff'
                AND ca.jenis_cuti = 'AL'
                AND ca.tahun = YEAR(CURRENT_TIMESTAMP)"; 
        $result = $conn->query($sql);
        return $result;  		
	}


function gettotalcutidiambilAL($no_staff){
		$conn=db();
        $sql = "SELECT sh.total_cuti - sh.baki_cuti AS totalal,sh.jenis_cuti,sh.id FROM staff_total_cuti sh
		LEFT JOIN staff_record sr ON sh.staff_record_id = sr.id
		LEFT JOIN staff s ON sr.no_staff = s.no_staff
		LEFT JOIN approve_holiday ah ON ah.staff_holiday_id = sh.id
		WHERE sh.staff_record_id =sr.id 
		AND sh.jenis_cuti='AL'
		AND s.no_staff = '$no_staff'
		AND sh.tahun = YEAR(CURRENT_TIMESTAMP)"; 
        $result = $conn->query($sql);
        return $result;		 
 }	

 function gettotalcutidiambilMC($no_staff){
	    $conn=db();
         $sql = "SELECT sh.total_cuti - sh.baki_cuti AS totalmc FROM staff_total_cuti sh
		LEFT JOIN staff_record sr ON sh.staff_record_id = sr.id
		LEFT JOIN staff s ON sr.no_staff = s.no_staff
		LEFT JOIN approve_holiday ah ON ah.staff_holiday_id = sh.id
		WHERE sh.staff_record_id =sr.id 
		AND sh.jenis_cuti='MC'
		AND s.no_staff = '$no_staff'
		AND sh.tahun = YEAR(CURRENT_TIMESTAMP)"; 
        $result = $conn->query($sql);
        return $result;	 
 }
 
 function gettotalcutidiambilLP($no_staff){
	    $conn=db();
         $sql = "SELECT  SUM(total_lv_req) AS totallp FROM aims_lv_form sh
		LEFT JOIN staff_record sr ON sh.staff_record_id = sr.id
		LEFT JOIN staff s ON sr.no_staff = s.no_staff
		LEFT JOIN approve_holiday ah ON ah.staff_holiday_id = sh.id
		WHERE sh.staff_record_id =sr.id 
		AND sh.type_leave='LP'
		AND ah.approvement = 'APPROVE'
		AND s.no_staff = '$no_staff'
		AND YEAR(sh.created_date) = YEAR(CURRENT_TIMESTAMP)"; 
        $result = $conn->query($sql);
        return $result;	 
 }

 function gettotalcutidiambilCL($no_staff){
	    $conn=db();
         $sql = "SELECT  SUM(total_lv_req) AS totalcl FROM aims_lv_form sh
		LEFT JOIN staff_record sr ON sh.staff_record_id = sr.id
		LEFT JOIN staff s ON sr.no_staff = s.no_staff
		LEFT JOIN approve_holiday ah ON ah.staff_holiday_id = sh.id
		WHERE sh.staff_record_id =sr.id 
		AND type_leave='CL'
		AND ah.approvement = 'APPROVE'
		AND s.no_staff = '$no_staff'
		AND YEAR(sh.created_date) = YEAR(CURRENT_TIMESTAMP)"; 
        $result = $conn->query($sql);
        return $result;	 
 }

 function gettotalcutidiambilURL($no_staff){
	    $conn=db();
         $sql = "SELECT  SUM(total_lv_req) AS totalurl FROM aims_lv_form sh
		LEFT JOIN staff_record sr ON sh.staff_record_id = sr.id
		LEFT JOIN staff s ON sr.no_staff = s.no_staff
		LEFT JOIN approve_holiday ah ON ah.staff_holiday_id = sh.id
		WHERE sh.staff_record_id =sr.id 
		AND type_leave='URL'
		AND ah.approvement = 'APPROVE'
		AND s.no_staff = '$no_staff'
		AND YEAR(sh.created_date) = YEAR(CURRENT_TIMESTAMP)"; 
        $result = $conn->query($sql);
        return $result;	 
 } 
 
  function gettotalcutidiambilHL($no_staff){
	    $conn=db();
         $sql = "SELECT  SUM(total_lv_req) AS totalhl FROM aims_lv_form sh
		LEFT JOIN staff_record sr ON sh.staff_record_id = sr.id
		LEFT JOIN staff s ON sr.no_staff = s.no_staff
		LEFT JOIN approve_holiday ah ON ah.staff_holiday_id = sh.id
		WHERE sh.staff_record_id =sr.id 
		AND type_leave='HL'
		AND ah.approvement = 'APPROVE'
		AND s.no_staff = '$no_staff'
		AND YEAR(sh.created_date) = YEAR(CURRENT_TIMESTAMP)"; 
        $result = $conn->query($sql);
        return $result;	 
 } 
 
  function gettotalcutifowardAL($no_staff){
	    $conn=db();
         $sql = "SELECT  SUM(pindah_cuti) + SUM(cuti_diberi) - SUM(total_lv_req)  AS totalmc FROM aims_lv_form sh
		LEFT JOIN staff_record sr ON sh.staff_record_id = sr.id
		LEFT JOIN staff s ON sr.no_staff = s.no_staff
		WHERE sh.staff_record_id =sr.id 
		AND type_leave='MC'
		AND s.no_staff = '$no_staff'"; 
        $result = $conn->query($sql);
        return $result;	 
 }

    function getMaklumatCuti($staff_holiday_id,$staff_record_id){
          $conn=db();
          $sql=" SELECT sh.* ,ha.approvement,ha.support, sr.no_staff,stc.* FROM aims_lv_form sh 
                  LEFT JOIN approve_holiday ha ON ha.staff_holiday_id=sh.id
                  LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
                  LEFT JOIN staff_total_cuti stc ON sh.type_leave=stc.jenis_cuti
                  WHERE sh.id='$staff_holiday_id' 
                  AND stc.staff_record_id='$staff_record_id'
				  AND stc.tahun = YEAR(CURRENT_TIMESTAMP)";
          $result=$conn->query($sql);
          return $result;  
    }

    function getCutiStaffByCurYear($no_staff){
        $conn=db();
        $sql=" SELECT sh.*,DATE(sh.date_lv_from) AS monthss ,ha.approvement,ha.support,ha.remark,sr.no_staff FROM aims_lv_form sh
		LEFT JOIN approve_holiday ha ON ha.staff_holiday_id=sh.id
                LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
                WHERE sr.no_staff='$no_staff'
                AND DATE_FORMAT(sh.date_lv_from,'%Y') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')
                ORDER BY sh.id DESC";
        $result=$conn->query($sql);
        return $result;  
    }

    function getCutiStaffByPrevYear($no_staff){
        $conn=db();
        $sql=" SELECT sh.* ,ha.approvement,ha.support,sr.no_staff,sh.staff_record_id,sr.total_cuti FROM aims_lv_form sh
				LEFT JOIN approve_holiday ha ON ha.staff_holiday_id=sh.id
                LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
                WHERE sr.no_staff='$no_staff'
                AND DATE_FORMAT(sh.date_lv_from,'%Y') != DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')
                ORDER BY sh.id DESC";
        $result=$conn->query($sql);
        return $result;  
    }

    function getLampiranInfo($id){
        $conn=db();
        $sql=" SELECT * FROM aims_lv_form
                WHERE id='$id'";
        $result=$conn->query($sql);
        return $result;  
    }

   function getStatusCutiDiSenarai($approvement){
       	$conn=db();
       	$sql="SELECT ha.*, jk.jenis_lulus AS status_cuti FROM holiday_approve ha
              LEFT JOIN jenis_kelulusan jk ON jk.id=ha.approvement
              WHERE ha.approvement='$approvement'";
        $result=$conn->query($sql);
        return $result;
   }

  function batalCuti($staff_holiday_id,$staff_record_id,$type_leave,$total_lv_req) {
        $conn=db();
		
		$sql = "SELECT baki_cuti_pohon FROM staff_total_cuti WHERE staff_record_id='$staff_record_id' AND jenis_cuti = '$type_leave' AND tahun= YEAR(CURRENT_TIMESTAMP)";
		$baki_cuti_pohon =$conn->query($sql)->fetch_object()->baki_cuti_pohon;
		
		$_baki_cuti_pohon = $total_lv_req + $baki_cuti_pohon;
        $sql="UPDATE staff_total_cuti SET baki_cuti_pohon='$_baki_cuti_pohon' 
		WHERE staff_record_id='$staff_record_id' AND jenis_cuti = '$type_leave' AND tahun= YEAR(CURRENT_TIMESTAMP)";
        $result=$conn->query($sql);
		
			$sql = "DELETE aims_lv_form, approve_holiday FROM aims_lv_form 
			LEFT JOIN approve_holiday ON aims_lv_form.id = approve_holiday.staff_holiday_id 
			WHERE aims_lv_form.id = '$staff_holiday_id' AND approve_holiday.staff_holiday_id='$staff_holiday_id';";
        $result = $conn->query($sql);
		
        return $result;
    }
	//batal cuti yang sudah diluluskan
  function batalCuti2($staff_holiday_id,$staff_record_id,$type_leave,$total_lv_req) {
        $conn=db();
		
		$sql = "SELECT baki_cuti_pohon FROM staff_total_cuti WHERE staff_record_id='$staff_record_id' AND jenis_cuti = '$type_leave' AND tahun= YEAR(CURRENT_TIMESTAMP)";
		$baki_cuti_pohon =$conn->query($sql)->fetch_object()->baki_cuti_pohon;
		
		$_baki_cuti_pohon = $total_lv_req + $baki_cuti_pohon;
        $sql="UPDATE staff_total_cuti SET baki_cuti_pohon='$_baki_cuti_pohon' 
		WHERE staff_record_id='$staff_record_id' AND jenis_cuti = '$type_leave' AND tahun= YEAR(CURRENT_TIMESTAMP)";
        $result=$conn->query($sql);
		
		$sql = "SELECT baki_cuti FROM staff_total_cuti WHERE staff_record_id='$staff_record_id' AND jenis_cuti = '$type_leave' AND tahun= YEAR(CURRENT_TIMESTAMP)";
		$baki_cuti =$conn->query($sql)->fetch_object()->baki_cuti;
		
		 $_baki_cuti = $baki_cuti + $total_lv_req;
         $sql1="UPDATE staff_total_cuti SET baki_cuti='$_baki_cuti'
                WHERE  staff_record_id='$staff_record_id' AND jenis_cuti = '$type_leave' AND tahun= YEAR(CURRENT_TIMESTAMP)";
         $result=$conn->query($sql1);
		
			$sql = "DELETE aims_lv_form, approve_holiday FROM aims_lv_form 
			LEFT JOIN approve_holiday ON aims_lv_form.id = approve_holiday.staff_holiday_id 
			WHERE aims_lv_form.id = '$staff_holiday_id' AND approve_holiday.staff_holiday_id='$staff_holiday_id'";
        $result = $conn->query($sql);
		
        return $result;
    }	
    
    function checkCuti($staff_holiday_id,$staff_record_id) {
        $conn=db();
		
		$sql = "UPDATE aims_lv_form SET hr_checked = 'CHECKED' WHERE aims_lv_form.id = '$staff_holiday_id';";
        $result = $conn->query($sql);
		
        return $result;
    }	
	
	/*function updateanalisa($staff_record_id,$rule_cuti){
		
		$current_year = date('Y');
		$sql = "SELECT staff_record_id,pindah_cuti,cuti_diberi FROM cuti_analisis WHERE staff_record_id = '$staff_record_id' AND tahun = YEAR(CURRENT_TIMESTAMP)";
		$ = $conn->query($sql)->fetch_object()->tahun;

  	
		$sql = "";
		$result = $conn->query($sql);
  	
	}*/
	
	function Editentitlementanalisa($staff_record_id,$entitle_al,$entitle_mc,$prev_al,$prev_mc){
	$conn=db();
        $sql = "UPDATE cuti_analisis  SET cuti_diberi ='$entitle_al' WHERE staff_record_id='$staff_record_id' AND jenis_cuti='AL'";
        $result = $conn->query($sql);
       
		$sql2 = "UPDATE cuti_analisis  SET cuti_diberi ='$entitle_mc' WHERE staff_record_id='$staff_record_id' AND jenis_cuti='MC'";
        $result = $conn->query($sql2);
      
		
		$sql3 = "UPDATE cuti_analisis  SET pindah_cuti ='$prev_al' WHERE staff_record_id='$staff_record_id' AND jenis_cuti='AL'";
        $result = $conn->query($sql3);
      
		
		$sql4 = "UPDATE cuti_analisis  SET pindah_cuti ='$prev_mc' WHERE staff_record_id='$staff_record_id' AND jenis_cuti='MC'";
        $result = $conn->query($sql4);
        return $result;
	}

  function isCutiExist($staff_holiday_id) {
        $conn=db();
        $sql = "SELECT id FROM staff_holiday where id='$staff_holiday_id'";
        $result = $conn->query($sql);
        $temp = $result->num_rows;
        return $temp;
    }

  function getRekodCutiPekerja($id){
      $conn=db();
      $sql="SELECT sh.*,sr.baki_cuti_pohon AS baki_pohon_rekod FROM staff_holiday sh
            LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id WHERE sh.id='$id' ";
      $result=$conn->query($sql);
      return $result; 
  }

  function HantarCuti($staff_holiday_id){
      $conn=db();
      $sql=" SELECT * FROM holiday_approve WHERE staff_holiday_id='$staff_holiday_id'";
      $result=$conn->query($sql);
      return $result; 
  }

  function getMaklumatPemohonCuti($staff_holiday_id,$staff_record_id){
      $conn=db();
	  $sql = "SELECT type_leave FROM aims_lv_form WHERE id='$staff_holiday_id'";
      $type_leave=$conn->query($sql)->fetch_object()->type_leave;
	  
	  if($type_leave == 'MC'){
      $sql="SELECT ha.*,sr.id AS staff_record_id,sh.total_lv_req,sh.created_date AS tarikh_mohon,d.description AS department_name,s.*,sh.type_leave,sh.id AS sh_id,sh.date_lv_from,sh.date_lv_to,sh.reason_leave,stc.*,r.* FROM approve_holiday ha
             LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
             LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
             LEFT JOIN staff s ON s.no_staff= sr.no_staff
             LEFT JOIN department d ON d.code_department=s.department_id
             LEFT JOIN staff_total_cuti stc ON stc.jenis_cuti = '$type_leave'
             LEFT JOIN role r ON sr.peranan=r.code
             WHERE ha.staff_holiday_id='$staff_holiday_id'
             AND stc.staff_record_id = sr.id";
       $result=$conn->query($sql);
	  }
	  
	  else if ($type_leave == 'AL'){
		  $sql="SELECT ha.*,sr.id AS staff_record_id,sh.total_lv_req,sh.created_date AS tarikh_mohon,d.description AS department_name,s.*,sh.type_leave,sh.id AS sh_id,sh.date_lv_from,sh.date_lv_to,sh.reason_leave,stc.*,r.* FROM approve_holiday ha
             LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
             LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
             LEFT JOIN staff s ON s.no_staff= sr.no_staff
             LEFT JOIN department d ON d.code_department=s.department_id
             LEFT JOIN staff_total_cuti stc ON  stc.jenis_cuti = '$type_leave'
             LEFT JOIN role r ON sr.peranan=r.code
             WHERE ha.staff_holiday_id='$staff_holiday_id'
             AND stc.staff_record_id = sr.id";
       $result=$conn->query($sql); 
	  }
	  else {
		  
		 $sql="SELECT ha.*,sr.id AS staff_record_id,sh.total_lv_req,sh.created_date AS tarikh_mohon,d.description AS department_name,s.*,sh.type_leave,sh.id AS sh_id,sh.date_lv_from,sh.date_lv_to,sh.reason_leave,r.* FROM approve_holiday ha
             LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
             LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
             LEFT JOIN staff s ON s.no_staff= sr.no_staff
             LEFT JOIN department d ON d.code_department=s.department_id
             LEFT JOIN role r ON sr.peranan=r.code
             WHERE ha.staff_holiday_id='$staff_holiday_id'";
       $result=$conn->query($sql);  
	  }
       return $result; 
  }

  function getSenaraiPemohonCutiPageManager($no_staff){
      $conn=db();
      $sql="SELECT ha.*,s.no_staff,sr.baki_cuti_pohon AS baki_pohon_rekod,sr.total_cuti,sr.baki_cuti,sh.created_date AS tarikh_mohon,d.description AS department_name,jk.jenis_lulus AS status_cuti,jc.desc AS nama_cuti,s.name AS nama_pekerja,sh.*,sh.tarikh_mula,sh.tarikh_akhir,sh.sebab,st.name AS pelulus FROM holiday_approve ha
             LEFT JOIN staff_holiday sh ON sh.id=ha.staff_holiday_id
             LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
             LEFT JOIN staff s ON s.no_staff= sr.no_staff 
             LEFT JOIN staff st ON st.no_staff=ha.approve_by  
             LEFT JOIN jenis_kelulusan jk ON jk.code=ha.approvement
             LEFT JOIN jenis_cuti jc ON jc.code=sh.cuti_dipohon
             LEFT JOIN department d ON d.id=sh.department_id
             WHERE ha.approvement<>'BD'
             AND st.no_staff='$no_staff'
			 AND stc.tahun = YEAR(CURRENT_TIMESTAMP)
             ORDER BY ha.id ASC";
       $result=$conn->query($sql);
       return $result; 
  }
  
     function UpdateStatusCutiSpecial($staff_record_id,$staff_holiday_id,$approvement,$approve_by,$jumlah_cuti,$type_leave,$remark){
        $conn=db();
		$sql=" UPDATE approve_holiday SET date_approve= CURRENT_TIMESTAMP, approvement = '$approvement', approve_by='$approve_by', remark='$remark'
          WHERE staff_holiday_id='$staff_holiday_id'";
		$result=$conn->query($sql);
		
		$sql=" UPDATE aims_lv_form SET type_leave='$type_leave', total_lv_req = '$jumlah_cuti'
          WHERE id='$staff_holiday_id'";
		$result=$conn->query($sql);
		
		$sql = "SELECT baki_cuti FROM staff_total_cuti WHERE staff_record_id='$staff_record_id' AND jenis_cuti='AL' AND tahun = YEAR(CURRENT_TIMESTAMP)";
		$baki_cuti=$conn->query($sql)->fetch_object()->baki_cuti;
		
		$sql = "SELECT baki_cuti_pohon FROM staff_total_cuti WHERE staff_record_id='$staff_record_id' AND jenis_cuti='AL' AND tahun = YEAR(CURRENT_TIMESTAMP)";
		$baki_cuti_pohon=$conn->query($sql)->fetch_object()->baki_cuti_pohon;
		
		$sql = "SELECT baki_cuti FROM staff_total_cuti WHERE staff_record_id='$staff_record_id' AND jenis_cuti='MC' AND tahun = YEAR(CURRENT_TIMESTAMP)";
		$baki_cuti2=$conn->query($sql)->fetch_object()->baki_cuti;
		
		$sql = "SELECT baki_cuti_pohon FROM staff_total_cuti WHERE staff_record_id='$staff_record_id' AND jenis_cuti='MC' AND tahun = YEAR(CURRENT_TIMESTAMP)";
		$baki_cuti_pohon2=$conn->query($sql)->fetch_object()->baki_cuti_pohon;
		
        if($approvement == 'APPROVE' && $type_leave == 'AL') {
          $_baki_cuti = $baki_cuti - $jumlah_cuti;
		  
          $sql1="UPDATE staff_total_cuti SET baki_cuti='$_baki_cuti'
                  WHERE  staff_record_id='$staff_record_id' AND tahun = YEAR(CURRENT_TIMESTAMP) AND jenis_cuti = 'AL'";
            $result=$conn->query($sql1);
        
          $_baki_cuti_pohon = $baki_cuti_pohon - $jumlah_cuti;
          $sql2="UPDATE staff_total_cuti SET baki_cuti_pohon='$_baki_cuti_pohon'
                  WHERE  staff_record_id='$staff_record_id' AND tahun = YEAR(CURRENT_TIMESTAMP) AND jenis_cuti = 'AL'";
            $result=$conn->query($sql2);
        }
        
        
        else if($approvement == 'APPROVE' && $type_leave == 'MC') {
          $_baki_cuti = $baki_cuti2 - $jumlah_cuti;
		  
          $sql1="UPDATE staff_total_cuti SET baki_cuti='$_baki_cuti'
                  WHERE  staff_record_id='$staff_record_id' AND tahun = YEAR(CURRENT_TIMESTAMP) AND jenis_cuti = 'MC'";
            $result=$conn->query($sql1);
        
          $_baki_cuti_pohon = $baki_cuti_pohon2 - $jumlah_cuti;
          $sql2="UPDATE staff_total_cuti SET baki_cuti_pohon='$_baki_cuti_pohon'
                  WHERE  staff_record_id='$staff_record_id' AND tahun = YEAR(CURRENT_TIMESTAMP) AND jenis_cuti = 'MC'";
            $result=$conn->query($sql2);
        }
   return $result;  
  }
  
  //cutilebih 
  
  function addlebihancuti($staff_record_id,$department_id,$date_fill,$dic_leave,$date_lv_from,$date_lv_to,$day_lv_from,$day_lv_to,$type_leave,$reason_leave,$descrip,$total_lv_req,$approve_by){
		$conn=db();
		
			$sql = "INSERT INTO aims_lv_form (staff_record_id, department_id, date_fill, dic_leave, date_lv_from, date_lv_to, day_lv_from,day_lv_to, type_leave, reason_leave, descrip, total_lv_req) 
			VALUES('$staff_record_id','$departmant_id','$date_fill','$dic_leave',STR_TO_DATE('$date_lv_from','%d/%m/%Y'),STR_TO_DATE('$date_lv_to','%d/%m/%Y'),'$day_lv_from','$day_lv_to','$type_leave','$reason_leave','$descrip','$total_lv_req')";
			$result = $conn->query($sql);
			
			$staff_holiday_id = $conn->insert_id;  
			//query insert data ke table holiday_approve
			$sql1 ="INSERT INTO approve_holiday(staff_holiday_id,approve_by,approvement,support) VALUES('$staff_holiday_id','$approve_by','APPROVE','TIADA')";
			$result = $conn->query($sql1);
			
			$sql = "SELECT baki_cuti FROM staff_total_cuti WHERE staff_record_id='$staff_record_id' AND jenis_cuti='AL' AND tahun = YEAR(CURRENT_TIMESTAMP)";
			$baki_cuti=$conn->query($sql)->fetch_object()->baki_cuti;
		
			$sql = "SELECT baki_cuti_pohon FROM staff_total_cuti WHERE staff_record_id='$staff_record_id' AND jenis_cuti='AL' AND tahun = YEAR(CURRENT_TIMESTAMP)";
			$baki_cuti_pohon=$conn->query($sql)->fetch_object()->baki_cuti_pohon;
		
			$sql = "SELECT baki_cuti FROM staff_total_cuti WHERE staff_record_id='$staff_record_id' AND jenis_cuti='MC' AND tahun = YEAR(CURRENT_TIMESTAMP)";
			$baki_cuti2=$conn->query($sql)->fetch_object()->baki_cuti;
		
			$sql = "SELECT baki_cuti_pohon FROM staff_total_cuti WHERE staff_record_id='$staff_record_id' AND jenis_cuti='MC' AND tahun = YEAR(CURRENT_TIMESTAMP)";
			$baki_cuti_pohon2=$conn->query($sql)->fetch_object()->baki_cuti_pohon;
			
			if($type_leave == 'AL') {
			$_baki_cuti = $baki_cuti - $total_lv_req;
		  
			$sql1="UPDATE staff_total_cuti SET baki_cuti='$_baki_cuti'
                  WHERE  staff_record_id='$staff_record_id' AND tahun = YEAR(CURRENT_TIMESTAMP) AND jenis_cuti = 'AL'";
				$result=$conn->query($sql1);
        
			$_baki_cuti_pohon = $baki_cuti_pohon - $total_lv_req;
			$sql2="UPDATE staff_total_cuti SET baki_cuti_pohon='$_baki_cuti_pohon'
                  WHERE  staff_record_id='$staff_record_id' AND tahun = YEAR(CURRENT_TIMESTAMP) AND jenis_cuti = 'AL'";
            $result=$conn->query($sql2);
        }
		
		if($type_leave == 'MC') {
			$_baki_cuti = $baki_cuti2 - $total_lv_req;
		  
          $sql1="UPDATE staff_total_cuti SET baki_cuti='$_baki_cuti'
                  WHERE  staff_record_id='$staff_record_id' AND tahun = YEAR(CURRENT_TIMESTAMP) AND jenis_cuti = 'MC'";
				$result=$conn->query($sql1);
        
          $_baki_cuti_pohon = $baki_cuti_pohon2 - $total_lv_req;
          $sql2="UPDATE staff_total_cuti SET baki_cuti_pohon='$_baki_cuti_pohon'
                  WHERE  staff_record_id='$staff_record_id' AND tahun = YEAR(CURRENT_TIMESTAMP) AND jenis_cuti = 'MC'";
            $result=$conn->query($sql2);
        }
        return $result; 
	}
	
	//function retrieve cuti staff utk lebihan cuti special
	 function getCutiSpecialbyId($staff_holiday_id){
        $conn=db();
        $sql = "SELECT al.*,ah.date_approve,ah.approvement,ah.approve_by,ah.date_support,ah.support,ah.support_by,ah.remark
				FROM aims_lv_form al
				LEFT JOIN approve_holiday ah ON ah.staff_holiday_id = al.id
				WHERE al.id = '$staff_holiday_id'";
        $result = $conn->query($sql);
        return $result;   
    }
  
  //list for support

//   function getSenaraiPemohonCutiBaharu($department_sub,$name){
//       $conn=db();
      
//           $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
//               sh.created_date AS tarikh_mohon,d.description AS department_name,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
//               LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
//               LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
//               LEFT JOIN staff s ON s.no_staff= sr.no_staff 
//               LEFT JOIN staff st ON st.no_staff=ha.support_by  
//               LEFT JOIN staff stf ON s.leave_approval = stf.no_staff
// 			  LEFT JOIN department d ON d.id=sh.department_id 
//               LEFT JOIN department ds ON s.department_id=ds.code_department 
//               LEFT JOIN role r ON sr.peranan=r.code
//               WHERE ha.support<>'PENDING'
//               AND ha.support = 'IN PROGRESS'
//               AND s.status = 'BEKERJA'
// 			  AND s.department_sub = '$department_sub'
// 			  AND s.name <> '$name' 
// 			  ORDER BY tarikh_mohon DESC";

//       $result=$conn->query($sql);
//       return $result; 
//   }

//   function getSenaraiPemohonCutiLulusSemua($department_sub,$name){
//       $conn=db();
	  
//           $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
//               sh.created_date AS tarikh_mohon,d.description AS department_name,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
//               LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
//               LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
//               LEFT JOIN staff s ON s.no_staff= sr.no_staff 
//               LEFT JOIN staff st ON st.no_staff=ha.support_by  
//               LEFT JOIN staff stf ON s.leave_approval = stf.no_staff
// 			  LEFT JOIN department d ON d.id=sh.department_id 
//               LEFT JOIN department ds ON s.department_id=ds.code_department 
//               LEFT JOIN role r ON sr.peranan=r.code
//               WHERE ha.support<>'PENDING'
//               AND ha.support = 'APPROVE'
//               AND s.status = 'BEKERJA'
// 			  AND s.department_sub = '$department_sub'
// 			  AND s.name <> '$name'
//               ORDER BY tarikh_mohon DESC";

//       $result=$conn->query($sql);
//       return $result; 
//   }


//   function getSenaraiPemohonCutiTidakLulusSemua($department_sub,$name){
//       $conn=db();

//           $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
//               sh.created_date AS tarikh_mohon,d.description AS department_name,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
//               LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
//               LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
//               LEFT JOIN staff s ON s.no_staff= sr.no_staff 
//               LEFT JOIN staff st ON st.no_staff=ha.support_by  
//               LEFT JOIN staff stf ON s.leave_approval = stf.no_staff
// 			  LEFT JOIN department d ON d.id=sh.department_id 
//               LEFT JOIN department ds ON s.department_id=ds.code_department 
//               LEFT JOIN role r ON sr.peranan=r.code
//               WHERE ha.support<>'PENDING'
//               AND ha.support = 'DISAPPROVE'
//               AND s.status = 'BEKERJA'
// 			  AND s.department_sub = '$department_sub'
// 			  AND s.name <> '$name'
//               ORDER BY tarikh_mohon DESC";

//       $result=$conn->query($sql);
//       return $result; 
//   }

  function getSenaraiPemohonCutiBaharu($department_sub,$name){
      $conn=db();
      $sql = "SELECT role_id FROM staff WHERE name='$name'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
      
      $sql = "SELECT no_staff FROM staff WHERE name='$name'";
      $no_staff=$conn->query($sql)->fetch_object()->no_staff;
     
		if ( $role_id == 'EXECUTIVEAVSB' ) { //KEDUA DUA EXECUTIVEAVSB TELAH BERHENTI, JADI IF INI TIDAK DIGUNAKAN
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'IN PROGRESS'
              AND s.status = 'BEKERJA'
			  AND s.department_sub IN ('OPERATIONFAC-AVSB', 'OPERATION-AVSB')
			  AND s.role_id <> 'OPERATIONMANAGER'
			  AND s.name <> '$name'
              ORDER BY tarikh_mohon DESC";
		}
		
		else if ( $department_sub == 'OPERATION-AVSB' && $no_staff == 'INDEEP0329') { //CUSTOM CONDITION SYAFIQ HISYAMUDDIN. PERANAN UNTUK SUPPORT SEMUA STAFF DI BAWAH OPERATION-AVSB & OPERATIONFAC-AVSB
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'IN PROGRESS'
              AND s.status = 'BEKERJA'
			  AND s.department_sub IN ('OPERATION-AVSB', 'OPERATIONFAC-AVSB')
			  AND s.role_id NOT IN ('OPERATIONMANAGER', 'EXECUTIVEAVSB', 'EXECUTIVETKSB', 'SUPERVISORTKSB' ,'EXECUTIVE-DIRECTOR', 'MANAGING-DIRECTOR')
              AND s.no_staff <> '$no_staff'
              ORDER BY tarikh_mohon DESC";
		}

        else if ( in_array($department_sub, ['OPERATION-AVSB', 'OPERATIONFAC-AVSB'])) { //OPERATION-AVSB & OPERATIONFAC-AVSB support syafiq hisyamuddin
            $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'IN PROGRESS'
              AND s.status = 'BEKERJA'
			  AND s.no_staff IN ('INDEEP0329')
			  AND s.role_id NOT IN ('OPERATIONMANAGER', 'SUPERVISORAVSB', 'EXECUTIVEAVSB', 'EXECUTIVETKSB', 'SUPERVISORTKSB' ,'EXECUTIVE-DIRECTOR', 'MANAGING-DIRECTOR')
              ORDER BY tarikh_mohon DESC";
        }
		
		else if ( $role_id == 'SUPERVISORAVSB' ) {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'IN PROGRESS'
              AND s.status = 'BEKERJA'
			  AND s.role_id = 'EXECUTIVEAVSB'
              ORDER BY tarikh_mohon DESC";
		}
		
		else if ( $role_id == 'EXECUTIVETKSB' ) {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'IN PROGRESS'
              AND s.status = 'BEKERJA'
			  AND s.department_sub = 'OPERATION-TKSB'
			  AND s.role_id <> 'OPERATIONMANAGER'
			  AND s.name <> '$name'
              ORDER BY tarikh_mohon DESC";
		}
		
		else if ( $role_id == 'SUPERVISORTKSB' ) {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'IN PROGRESS'
              AND s.status = 'BEKERJA'
			  AND s.role_id = 'EXECUTIVETKSB'
              ORDER BY tarikh_mohon DESC";
		}
		
	 else if ( $role_id == 'EXECUTIVE-DIRECTOR') {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'IN PROGRESS'
              AND s.status = 'BEKERJA'
              AND s.role_id = 'MANAGING-DIRECTOR'
			  AND s.name <> '$name'
              ORDER BY tarikh_mohon DESC";
		}
		
		else if ( $role_id == 'MANAGING-DIRECTOR') {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'IN PROGRESS'
              AND s.status = 'BEKERJA'
              AND s.role_id IN ('EXECUTIVE-DIRECTOR','HOC','OPERATIONMANAGER')
			  AND s.name <> '$name'
              ORDER BY tarikh_mohon DESC";
		}
		
		else if ( $role_id == 'HOD' && $department_sub == 'HR') {
		    
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'IN PROGRESS'
              AND s.status = 'BEKERJA'
              AND s.department_sub IN ('ECOFFICE', 'HR')
              AND s.name <> '$name'
              ORDER BY tarikh_mohon DESC";
		  
		}
	

	else if ( $department_sub == 'FINACC' && ($role_id == 'STAFF' || $role_id == 'CONTRACT') ){
		$sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'IN PROGRESS'
              AND s.status = 'BEKERJA'
			  AND s.role_id='HOD'
			  AND s.department_sub = 'FINACC'
              ORDER BY tarikh_mohon DESC";
			  
		}
		
	   else if ( $department_sub == 'OPERATION-AGMHESB' && ($role_id == 'STAFF' || $role_id == 'CONTRACT') ){
		$sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'IN PROGRESS'
              AND s.status = 'BEKERJA'
			  AND s.role_id='HOD'
			  AND s.department_sub = 'OPERATION-AGMHESB'
              ORDER BY tarikh_mohon DESC";
			  
		}
		
		
		else if ($name == 'MOHD TARMIZI BIN MEJAM'){
		$sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'IN PROGRESS'
              AND s.status = 'BEKERJA'
              AND s.no_staff = '810415035497'
              ORDER BY tarikh_mohon DESC";
			  
		}
		
	
		
	    else if ( $department_sub == 'HR-AGMA'){
		$sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,d.description AS department_name,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.support_by  
              LEFT JOIN staff stf ON stf.no_staff = ha.approve_by
			  LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'IN PROGRESS'
              AND s.status = 'BEKERJA'
			  AND s.name <> '$name'
			  AND s.department_sub IN ('OPERATION-AGMSB', 'HR-AGMA')
              ORDER BY tarikh_mohon DESC";
			  
		}
		
			else if ($no_staff == '940331025617'){
		      $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'IN PROGRESS'
              AND s.status = 'BEKERJA'
              AND s.department_sub IN ('TECHOPERATION','PILOT-BOAT','MOORING-GANG')
              ORDER BY tarikh_mohon DESC";
			  
		}

            else if ($no_staff == '960215115701'){ //Lut
                $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'IN PROGRESS'
              AND s.status = 'BEKERJA'
              AND s.department_sub IN ('TECHNICAL-AVSB')
              ORDER BY tarikh_mohon DESC";

            }
		
		else if ($no_staff == '911011115100'){
		      $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'IN PROGRESS'
              AND s.status = 'BEKERJA'
              AND s.department_sub IN ('HR','SECRETARY-AVSB')
              ORDER BY tarikh_mohon DESC";
			  
		}

			else {  
			  $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'IN PROGRESS'
              AND s.status = 'BEKERJA'
			  AND s.department_sub = '$department_sub'
			  AND s.department_sub NOT IN ('OPERATION-AGMSB', 'MANAGEMENT', 'MOORING-GANG', 'PILOT-BOAT', 'OPERATION-AVSB', 'OPERATIONFAC-AVSB')
			  AND s.name <> '$name'
              ORDER BY tarikh_mohon DESC";
			}
      $result=$conn->query($sql);
      return $result; 
  }

  function getSenaraiPemohonCutiLulusSemua($department_sub,$name){
      $conn=db();
      $sql = "SELECT role_id FROM staff WHERE name='$name'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
      
      $sql = "SELECT no_staff FROM staff WHERE name='$name'";
      $no_staff=$conn->query($sql)->fetch_object()->no_staff;
	  
	  if ( $role_id == 'EXECUTIVEAVSB' ) {
		 
		$sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'APPROVE'
              AND s.status = 'BEKERJA'
			  AND s.department_sub IN ('OPERATIONFAC-AVSB', 'OPERATION-AVSB')
			  AND s.role_id <> 'OPERATIONMANAGER'
			  AND s.name <> '$name'
              ORDER BY tarikh_mohon DESC";
		 
	  }
		
		else if ( $department_sub == 'OPERATION-AVSB' && $no_staff == 'INDEEP0329') { //CUSTOM CONDITION SYAFIQ HISYAMUDDIN. PERANAN UNTUK SUPPORT SEMUA STAFF DI BAWAH OPERATION-AVSB & OPERATIONFAC-AVSB
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'APPROVE'
              AND s.status = 'BEKERJA'
			  AND s.department_sub IN ('OPERATION-AVSB', 'OPERATIONFAC-AVSB')
			  AND s.role_id NOT IN ('OPERATIONMANAGER', 'SUPERVISORAVSB', 'EXECUTIVEAVSB', 'EXECUTIVETKSB', 'SUPERVISORTKSB' ,'EXECUTIVE-DIRECTOR', 'MANAGING-DIRECTOR')
              ORDER BY tarikh_mohon DESC";
		}

        else if ( in_array($department_sub, ['OPERATION-AVSB', 'OPERATIONFAC-AVSB'])) { //OPERATION-AVSB & OPERATIONFAC-AVSB support syafiq hisyamuddin
            $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'APPROVE'
              AND s.status = 'BEKERJA'
			  AND s.no_staff IN ('INDEEP0329')
			  AND s.role_id NOT IN ('OPERATIONMANAGER', 'SUPERVISORAVSB', 'EXECUTIVEAVSB', 'EXECUTIVETKSB', 'SUPERVISORTKSB' ,'EXECUTIVE-DIRECTOR', 'MANAGING-DIRECTOR')
              ORDER BY tarikh_mohon DESC";
        }
	  
	  else if ( $role_id == 'SUPERVISORAVSB' ) {
		 
		$sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'APPROVE'
              AND s.status = 'BEKERJA'
			  AND s.role_id = 'EXECUTIVEAVSB'
			  AND s.name <> '$name'
              ORDER BY tarikh_mohon DESC";
		 
	  }
	  
	 else if ( $role_id == 'EXECUTIVETKSB' ) {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'APPROVE'
              AND s.status = 'BEKERJA'
			  AND s.department_sub IN ('OPERATION-TKSB')
			  AND s.role_id <> 'OPERATIONMANAGER'
			  AND s.name <> '$name'
              ORDER BY tarikh_mohon DESC";
		}
	  
	 else if ( $role_id == 'SUPERVISORTKSB' ) {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'APPROVE'
              AND s.status = 'BEKERJA'
			  AND s.role_id = 'EXECUTIVETKSB'
              ORDER BY tarikh_mohon DESC";
		} 
	  
	 else if ( $role_id == 'EXECUTIVE-DIRECTOR') {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'APPROVE'
              AND s.status = 'BEKERJA'
              AND s.role_id = 'MANAGING-DIRECTOR'
			  AND s.name <> '$name'
              ORDER BY tarikh_mohon DESC";
		}
		
		else if ( $role_id == 'MANAGING-DIRECTOR') {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'APPROVE'
              AND s.status = 'BEKERJA'
              AND s.role_id IN ('EXECUTIVE-DIRECTOR','HOC','OPERATIONMANAGER')
			  AND s.name <> '$name'
              ORDER BY tarikh_mohon DESC";
		}
		
		else if ( $department_sub == 'FINACC' && ($role_id == 'STAFF' || $role_id == 'CONTRACT')){
		$sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'APPROVE'
              AND s.status = 'BEKERJA'
			  AND s.role_id='HOD'
			  AND s.department_sub = 'FINACC'
              ORDER BY tarikh_mohon DESC";
			  
		}
		
	else if ($department_sub == 'OPERATION-AGMHESB' && ($role_id == 'STAFF' || $role_id == 'CONTRACT')){
		$sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'APPROVE'
              AND s.status = 'BEKERJA'
			  AND s.role_id='HOD'
			  AND s.department_sub = 'OPERATION-AGMHESB'
              ORDER BY tarikh_mohon DESC";
			  
		}
		
	    else if ( $department_sub == 'HR-AGMA'){
		$sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,d.description AS department_name,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.support_by  
              LEFT JOIN staff stf ON stf.no_staff = ha.approve_by
			  LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'APPROVE'
              AND s.status = 'BEKERJA'
			  AND s.name <> '$name'
			  AND s.department_sub IN ('OPERATION-AGMSB', 'HR-AGMA')
              ORDER BY tarikh_mohon DESC";
			  
		}
	  
	  else if ( $role_id == 'HOD' && $department_sub == 'HR') {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'APPROVE'
              AND s.status = 'BEKERJA'
              AND s.department_sub IN ('ECOFFICE', 'HR')
              AND s.name <> '$name'
              ORDER BY tarikh_mohon DESC";
		}
		
		else if ($name == 'MOHD TARMIZI BIN MEJAM'){
		$sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'APPROVE'
              AND s.status = 'BEKERJA'
              AND s.no_staff = '810415035497'
              ORDER BY tarikh_mohon DESC";
			  
		}
		
		else if ($no_staff == '940331025617'){
		$sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'APPROVE'
              AND s.status = 'BEKERJA'
              AND s.department_sub IN ('TECHOPERATION','PILOT-BOAT','MOORING-GANG')
              ORDER BY tarikh_mohon DESC";
			  
		}

		else if ($no_staff == '960215115701'){ //Lut
		$sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'APPROVE'
              AND s.status = 'BEKERJA'
              AND s.department_sub IN ('TECHNICAL-AVSB')
              ORDER BY tarikh_mohon DESC";

		}
		
		else if ($no_staff == '911011115100'){
		      $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'APPROVE'
              AND s.status = 'BEKERJA'
              AND s.department_sub IN ('HR','SECRETARY-AVSB')
              ORDER BY tarikh_mohon DESC";
			  
		}
	  
	  else {
		  
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'APPROVE'
              AND s.status = 'BEKERJA'
                AND s.leave_approval <> '$no_staff'
			  AND s.department_sub = '$department_sub'
			  AND s.department_sub NOT IN ('OPERATION-AGMSB', 'MANAGEMENT', 'MOORING-GANG', 'PILOT-BOAT', 'OPERATION-AVSB', 'OPERATIONFAC-AVSB')
			  AND s.name <> '$name'
              ORDER BY tarikh_mohon DESC";
	  }
		      //AND s.department_sub <>'OPERATION-AVSB'

      $result=$conn->query($sql);
      return $result; 
  }


  function getSenaraiPemohonCutiTidakLulusSemua($department_sub,$name){
      $conn=db();
      $sql = "SELECT role_id FROM staff WHERE name='$name'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
      
      $sql = "SELECT no_staff FROM staff WHERE name='$name'";
      $no_staff=$conn->query($sql)->fetch_object()->no_staff;
	  
	  if ( $role_id == 'EXECUTIVEAVSB' ){
		 
		$sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
			  AND s.department_sub IN ('OPERATIONFAC-AVSB', 'OPERATION-AVSB')
			  AND s.role_id <> 'OPERATIONMANAGER'
			  AND s.name <> '$name'
              ORDER BY tarikh_mohon DESC";
		 
	  }
		
		else if ( $department_sub == 'OPERATION-AVSB' && $no_staff == 'INDEEP0329') { //CUSTOM CONDITION SYAFIQ HISYAMUDDIN. PERANAN UNTUK SUPPORT SEMUA STAFF DI BAWAH OPERATION-AVSB & OPERATIONFAC-AVSB
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
			  AND s.department_sub IN ('OPERATION-AVSB', 'OPERATIONFAC-AVSB')
			  AND s.role_id NOT IN ('OPERATIONMANAGER', 'SUPERVISORAVSB', 'EXECUTIVEAVSB', 'EXECUTIVETKSB', 'SUPERVISORTKSB' ,'EXECUTIVE-DIRECTOR', 'MANAGING-DIRECTOR')
              ORDER BY tarikh_mohon DESC";
		}



        else if ( in_array($department_sub, ['OPERATION-AVSB', 'OPERATIONFAC-AVSB'])) { //OPERATION-AVSB & OPERATIONFAC-AVSB support syafiq hisyamuddin
            $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
			  AND s.no_staff IN ('INDEEP0329')
			  AND s.role_id NOT IN ('OPERATIONMANAGER', 'SUPERVISORAVSB', 'EXECUTIVEAVSB', 'EXECUTIVETKSB', 'SUPERVISORTKSB' ,'EXECUTIVE-DIRECTOR', 'MANAGING-DIRECTOR')
              ORDER BY tarikh_mohon DESC";
        }
	  
	  else if ( $role_id == 'SUPERVISORAVSB') {
		 
		$sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
			  AND s.role_id = 'EXECUTIVEAVSB'
			  AND s.name <> '$name'
              ORDER BY tarikh_mohon DESC";
		 
	  }
	  
	  else if ( $role_id == 'EXECUTIVETKSB' ) {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
			  AND s.department_sub IN ('OPERATION-TKSB')
			  AND s.role_id <> 'OPERATIONMANAGER'
			  AND s.name <> '$name'
              ORDER BY tarikh_mohon DESC";
		}
	  
	  else if ( $role_id == 'SUPERVISORTKSB' ) {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
			  AND s.role_id = 'EXECUTIVETKSB'
              ORDER BY tarikh_mohon DESC";
		}
	  
	   else if ( $role_id == 'EXECUTIVE-DIRECTOR') {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
              AND s.role_id = 'MANAGING-DIRECTOR'
			  AND s.name <> '$name'
              ORDER BY tarikh_mohon DESC";
		}
		
		else if ( $role_id == 'MANAGING-DIRECTOR') {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
              AND s.role_id IN ('EXECUTIVE-DIRECTOR','HOC','OPERATIONMANAGER')
			  AND s.name <> '$name'
              ORDER BY tarikh_mohon DESC";
		}
		
		else if ( $department_sub == 'FINACC' && ($role_id == 'STAFF' || $role_id == 'CONTRACT')){
		$sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
			  AND s.role_id='HOD'
			  AND s.department_sub = 'FINACC'
              ORDER BY tarikh_mohon DESC";
			  
		}
		
	else if ($department_sub == 'OPERATION-AGMHESB' && ($role_id == 'STAFF' || $role_id == 'CONTRACT')){
		$sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
			  AND s.role_id='HOD'
			  AND s.department_sub = 'OPERATION-AGMHESB'
              ORDER BY tarikh_mohon DESC";
			  
		}
	  
	  else if ( $role_id == 'HOD' && $department_sub == 'HR') {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
              AND s.department_sub IN ('ECOFFICE', 'HR')
              AND s.name <> '$name'
              ORDER BY tarikh_mohon DESC";
		}
		
		else if ( $department_sub == 'HR-AGMA'){
		$sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
			  AND s.department_sub IN ('OPERATION-AGMSB', 'HR-AGMA')
			  AND s.name <> '$name'
              ORDER BY tarikh_mohon DESC";
			  
		}
		
		else if ($name == 'MOHD TARMIZI BIN MEJAM'){
		$sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
              AND s.no_staff = '810415035497'
              ORDER BY tarikh_mohon DESC";
		}
		
	else if ($no_staff == '940331025617'){
		$sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
              AND s.department_sub IN ('TECHOPERATION','PILOT-BOAT','MOORING-GANG')
              ORDER BY tarikh_mohon DESC";
			  
		}

    else if ($no_staff == '960215115701'){ //Lut
        $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
              AND s.department_sub IN ('TECHNICAL-AVSB')
              ORDER BY tarikh_mohon DESC";

    }
		
		else if ($no_staff == '911011115100'){
		      $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
              AND s.department_sub IN ('HR','SECRETARY-AVSB')
              ORDER BY tarikh_mohon DESC";
			  
		}
	  
	  else {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.* FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.support<>'PENDING'
              AND ha.support = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
                AND s.leave_approval <> '$no_staff'
			  AND s.department_sub = '$department_sub'
			  AND s.name <> '$name'
			  AND s.department_sub NOT IN ('OPERATION-AGMSB', 'MANAGEMENT', 'MOORING-GANG', 'PILOT-BOAT', 'OPERATION-AVSB', 'OPERATIONFAC-AVSB')
              ORDER BY tarikh_mohon DESC";
	  }
		      //AND s.department_sub <>'OPERATION-AVSB'
	  
      $result=$conn->query($sql);
      return $result; 
  }
  
  //end list support
  
  //list for approvement

  function getSenaraiPemohonCutiBaharu1($leave_approval,$department_sub){
      $conn=db();
      $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
    
    if ( $role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB') {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,d.description AS department_name,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.support_by  
              LEFT JOIN staff stf ON ha.approve_by = stf.no_staff
			  LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement <> 'PENDING'
			  AND s.role_id <>'HOD'
              AND ha.approvement = 'IN PROGRESS'
              AND ha.support = 'APPROVE' 
              AND s.status = 'BEKERJA'
	          AND s.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')
              ORDER BY tarikh_mohon DESC";
		}
      
    else if ( $role_id == 'HOD' && $department_sub == 'HR') {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN staff stf ON stf.no_staff = ha.approve_by
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement <> 'PENDING'
			  AND s.role_id <>'HOD'
              AND ha.approvement = 'IN PROGRESS'
              AND ha.support = 'APPROVE' 
              AND s.status = 'BEKERJA'
	          AND s.department_sub IN ('HR', 'HR-SEA')
              ORDER BY tarikh_mohon DESC";
		}
		
		else if ( $role_id == 'HOD' && $department_sub == 'TECHOPERATION') {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN staff stf ON stf.no_staff = ha.approve_by
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement <> 'PENDING'
			  AND s.role_id <>'HOD'
              AND ha.approvement = 'IN PROGRESS'
              AND ha.support = 'APPROVE' 
              AND s.status = 'BEKERJA'
	          AND (s.department_sub IN ('TECHOPERATION', 'PILOT-BOAT','MOORING-GANG') OR s.no_staff = '900326115515')
	          AND (s.department_id <> 'AVSB')
              ORDER BY tarikh_mohon DESC";
		}
		
		else if ( $role_id == 'HOD' && $department_sub == 'COMMERCIAL') {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN staff stf ON stf.no_staff = ha.approve_by
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement <> 'PENDING'
			  AND s.role_id <>'HOD'
              AND ha.approvement = 'IN PROGRESS'
              AND ha.support = 'APPROVE' 
              AND s.status = 'BEKERJA'
	          AND s.department_sub IN ('COMMERCIAL', 'COMMERCIAL-AVSB')
              ORDER BY tarikh_mohon DESC";
		} 
      
     else if ( $role_id == 'HOD') {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN staff stf ON stf.no_staff = ha.approve_by
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement <> 'PENDING'
			  AND s.role_id <>'HOD'
              AND ha.approvement = 'IN PROGRESS'
              AND ha.support = 'APPROVE' 
              AND s.status = 'BEKERJA'
	          AND s.department_sub = '$department_sub'
			  AND s.department_sub NOT IN ('FINACC', 'OPERATION-AGMHESB', 'COMMERCIAL', 'HR')
              ORDER BY tarikh_mohon DESC";
		}
		
	  
	  
	  
	  
	  else if ($department_sub == 'HR') {
		 $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN staff stf ON stf.no_staff = ha.approve_by
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement = 'IN PROGRESS'
              AND ha.support = 'TIADA' 
              AND s.status = 'BEKERJA'
              ORDER BY tarikh_mohon DESC"; 
	  }
	  
	else if ($role_id == 'OPERATIONMANAGER') {
		 $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              LEFT JOIN staff stf ON stf.no_staff = ha.approve_by
              WHERE ha.approvement <> 'PENDING'
              AND ha.approvement = 'IN PROGRESS'
              AND ha.support = 'APPROVE' 
              AND s.status = 'BEKERJA'
			  AND s.leave_approval = '$leave_approval'
              ORDER BY tarikh_mohon DESC"; 
	  }
	  


	else {
		 $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              LEFT JOIN staff stf ON stf.no_staff = ha.approve_by
              WHERE ha.approvement <> 'PENDING'
              AND ha.approvement = 'IN PROGRESS'
              AND ha.support = 'APPROVE' 
              AND s.status = 'BEKERJA'
			  AND s.leave_approval = '$leave_approval'
              ORDER BY tarikh_mohon DESC"; 
	  }


      $result=$conn->query($sql);
      return $result; 
  }

  function getSenaraiPemohonCutiLulusSemua1($leave_approval,$department_sub){
      $conn=db();
      $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
      
      if ($role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB') {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,d.description AS department_name,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.support_by  
              LEFT JOIN staff stf ON ha.approve_by = stf.no_staff
			  LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement<>'PENDING'
			  AND s.role_id <>'HOD'
              AND ha.approvement = 'APPROVE'
              AND s.status = 'BEKERJA'
			  AND s.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')
              ORDER BY tarikh_mohon DESC";
      }
      
      else if ($role_id == 'HOD' && $department_sub == 'HR') {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN staff stf ON stf.no_staff = ha.approve_by
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement<>'PENDING'
			  AND s.role_id <>'HOD'
              AND ha.approvement = 'APPROVE'
              AND s.department_sub IN ('HR', 'HR-SEA')
              AND s.status = 'BEKERJA'
              ORDER BY tarikh_mohon DESC";
      }
      
      else if ( $role_id == 'HOD' && $department_sub == 'TECHOPERATION') {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN staff stf ON stf.no_staff = ha.approve_by
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement <> 'PENDING'
			  AND s.role_id <>'HOD'
              AND ha.approvement = 'APPROVE'
              AND ha.support = 'APPROVE' 
              AND s.status = 'BEKERJA'
	          AND (s.department_sub IN ('TECHOPERATION', 'PILOT-BOAT','MOORING-GANG') OR s.no_staff = '900326115515')
              ORDER BY tarikh_mohon DESC";
      }
      
     else if ($role_id == 'HOD') {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN staff stf ON stf.no_staff = ha.approve_by
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement<>'PENDING'
			  AND s.role_id <>'HOD'
              AND ha.approvement = 'APPROVE'
              AND s.status = 'BEKERJA'
			  AND s.department_sub = '$department_sub'
			  AND s.department_sub <> 'FINACC'
			  AND s.department_sub <> 'OPERATION-AGMHESB'
              ORDER BY tarikh_mohon DESC";
      }
      
      
	  else if ($role_id == 'OPERATIONMANAGER'){
		  $sql="SELECT ha.id AS ha_id,ha.date_approve,ha.approvement,ha.approve_by,ha.date_support,ha.support,ha.support_by,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              al.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,al.id,al.staff_record_id,
              al.department_id,al.date_fill,al.dic_leave,al.date_lv_from,al.date_lv_to,al.day_lv_from,al.day_lv_to,
              al.type_leave,al.total_lv_req,al.reason_leave,al.document_name,al.document_type,al.descrip,al.created_date,
              stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form al ON al.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=al.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN staff stf ON stf.no_staff = ha.approve_by
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement <> 'PENDING'
              AND ha.approvement = 'APPROVE'
              AND ha.support = 'APPROVE'
              AND s.status = 'BEKERJA'
			  AND s.leave_approval = '$leave_approval'
              ORDER BY tarikh_mohon DESC"; 
	  }	  

	  
	  else if ($department_sub  == 'HR') {
		 $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN role r ON sr.peranan=r.code
              LEFT JOIN staff stf ON stf.no_staff = ha.approve_by
              WHERE ha.approvement = 'APPROVE'
              AND ha.support = 'TIADA' 
              AND s.status = 'BEKERJA'
			  AND s.leave_approval = '$leave_approval'
              ORDER BY tarikh_mohon DESC"; 
	  }

	  else {
		 $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN staff stf ON stf.no_staff = ha.approve_by
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement<>'PENDING'
              AND ha.approvement = 'APPROVE'
              AND s.status = 'BEKERJA'
			  AND s.leave_approval = '$leave_approval'
              ORDER BY tarikh_mohon DESC";  
	  }	  
	  
      $result=$conn->query($sql);
      return $result; 
  }


  function getSenaraiPemohonCutiTidakLulusSemua1($leave_approval,$department_sub){
      $conn=db();
      $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
      
      if ( $role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB') {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,d.description AS department_name,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.support_by  
              LEFT JOIN staff stf ON ha.approve_by = stf.no_staff
			  LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement<>'PENDING'
			  AND s.role_id <>'HOD'
              AND ha.approvement = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
			  AND s.department_sub IN ('HR-AGMA','OPERATION-AGMSB','OPERATION-BUNKER')
              ORDER BY tarikh_mohon DESC";
      }
      
      else if ( $role_id == 'HOD' && $department_sub == 'HR') {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN staff stf ON stf.no_staff = ha.approve_by
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement<>'PENDING'
			  AND s.role_id <>'HOD'
              AND ha.approvement = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
			  AND s.department_sub IN ('HR', 'HR-SEA')
              ORDER BY tarikh_mohon DESC";
      }

    //   else if ( $role_id == 'HOD' && $department_sub == 'CORPADMIN') {
    //       $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
    //           sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha
    //           LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
    //           LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
    //           LEFT JOIN staff s ON s.no_staff= sr.no_staff
    //           LEFT JOIN staff stf ON stf.no_staff = ha.approve_by
    //           LEFT JOIN role r ON sr.peranan=r.code
    //           WHERE ha.approvement<>'PENDING'
			 // AND s.role_id <>'HOD'
    //           AND ha.approvement = 'DISAPPROVE'
    //           AND s.status = 'BEKERJA'
			 // AND s.department_sub IN ('CORPADMIN', 'IT')
    //           ORDER BY tarikh_mohon DESC";
    //   }
      
      else if ( $role_id == 'HOD' && $department_sub == 'TECHOPERATION') {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN staff stf ON stf.no_staff = ha.approve_by
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement <> 'PENDING'
			  AND s.role_id <>'HOD'
              AND ha.approvement = 'DISAPPROVE'
              AND ha.support = 'APPROVE' 
              AND s.status = 'BEKERJA'
	          AND (s.department_sub IN ('TECHOPERATION', 'PILOT-BOAT','MOORING-GANG') OR s.no_staff = '900326115515')
              ORDER BY tarikh_mohon DESC";
      }
      
       else if ( $role_id == 'HOD') {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN staff stf ON stf.no_staff = ha.approve_by
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement<>'PENDING'
			  AND s.role_id <>'HOD'
              AND ha.approvement = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
			  AND s.department_sub = '$department_sub'
			  AND s.department_sub <> 'FINACC'
			  AND s.department_sub <> 'OPERATION-AGMHESB'
              ORDER BY tarikh_mohon DESC";
      }
      
	  else if($role_id == 'OPERATIONMANAGER'){
		  $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN staff stf ON stf.no_staff = ha.approve_by
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement<>'PENDING'
              AND ha.approvement = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
			  AND s.leave_approval = '$leave_approval'
              ORDER BY tarikh_mohon DESC"; 
	  }	

	  else if($role_id == 'MANAGERAVSB'){
		  $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN staff stf ON stf.no_staff = ha.approve_by
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement<>'PENDING'
              AND ha.approvement = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
			  AND s.leave_approval = '$leave_approval'
			  AND s.department_id = 'AVSB'
              ORDER BY tarikh_mohon DESC"; 
	  }	
	  
	  
	  
	  else {
		 $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN staff stf ON stf.no_staff = ha.approve_by
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement = 'DISAPPROVE'
              AND ha.support = 'TIADA' 
              AND s.status = 'BEKERJA'
			  AND s.leave_approval = '$leave_approval'
              ORDER BY tarikh_mohon DESC"; 
	  }

      $result=$conn->query($sql);
      return $result; 
  }

//cuti special

function getSenaraiPemohonCutiIstimewaBaharu($leave_approval,$department_sub,$department_code){
      $conn=db();
      $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
      
	  
	  	if ($department_sub == 'HR') {
		 $sql="SELECT ha.approve_by,approvement,support,support_by,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,d.description AS department_name,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff  
              LEFT JOIN staff stf ON stf.no_staff = ha.approve_by
			  LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement = 'IN PROGRESS'
              AND ha.support = 'TIADA' 
              AND s.status = 'BEKERJA'
 			  AND s.department_id = '$department_code'
              ORDER BY tarikh_mohon DESC"; 
	  }

		else {
			echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_hr_specialleavemessage.php';
						</script>");
		}
	  
      $result=$conn->query($sql);
      return $result; 
  }

  function getSenaraiPemohonCutiIstimewaLulusSemua($leave_approval,$department_sub,$department_code){
      $conn=db();
      $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;

 if ($department_sub  == 'HR') {
		 $sql="SELECT ha.approve_by,approvement,support,support_by,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,d.description AS department_name,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff  
              LEFT JOIN staff stf ON stf.no_staff = ha.approve_by
			  LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement = 'APPROVE'
              AND ha.support = 'TIADA' 
              AND s.status = 'BEKERJA'
 			  AND s.department_id = '$department_code'
              ORDER BY tarikh_mohon DESC"; 
	  }	  
	  
      $result=$conn->query($sql);
      return $result; 
  }


  function getSenaraiPemohonCutiIstimewaTidakLulusSemua($leave_approval,$department_sub,$department_code){
      $conn=db();
      $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
      
	  
	  if ($department_sub == 'HR') {
		 $sql="SELECT ha.approve_by,approvement,support,support_by,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,d.description AS department_name,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff  
              LEFT JOIN staff stf ON stf.no_staff = ha.approve_by
			  LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement = 'DISAPPROVE'
              AND ha.support = 'TIADA' 
              AND s.status = 'BEKERJA'
 			  AND s.department_id = '$department_code'
              ORDER BY tarikh_mohon DESC"; 
	  }
	  
	  

      $result=$conn->query($sql);
      return $result; 
  }
  
  //end cuti special
  
  function getSenaraiPemohonCutiSpecial($leave_approval,$department_sub){
      $conn=db();
      $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
      
      if ( $role_id == 'FOUNDER') {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,d.description AS department_name,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.support_by  
              LEFT JOIN staff stf ON ha.approve_by = stf.no_staff
			  LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
			  WHERE ha.support = 'TIADA'
              ORDER BY tarikh_mohon DESC";
      }
	  
      else if ( $role_id == 'MANAGERAVSB') {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,d.description AS department_name,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.support_by  
              LEFT JOIN staff stf ON ha.approve_by = stf.no_staff
			  LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
			  WHERE ha.support = 'TIADA'
			  AND s.department_id = 'AVSB'
              ORDER BY tarikh_mohon DESC";
      }	  
	  
	  else if( $role_id == 'HOD'){
		  $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,d.description AS department_name,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.support_by  
              LEFT JOIN staff stf ON ha.approve_by = stf.no_staff
	      LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
	      WHERE s.department_sub = '$department_sub'
	      AND ha.support = 'TIADA'
              ORDER BY tarikh_mohon DESC";
	  }
      else {
         $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,d.description AS department_name,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.support_by  
              LEFT JOIN staff stf ON ha.approve_by = stf.no_staff
			  LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
			  WHERE s.leave_approval = '$leave_approval'
			  AND ha.support = 'TIADA'
              ORDER BY tarikh_mohon DESC"; 
      }
      $result=$conn->query($sql);
      return $result; 
  }

  function getSenaraiPemohonCutiBaharu1Old($leave_approval,$department_sub){
      $conn=db();
      $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
      
      if ( $role_id == 'SUPERADMIN' || $role_id == 'HOD' ) {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,d.description AS department_name,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.support_by  
              LEFT JOIN staff stf ON s.leave_approval = stf.no_staff
	      LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement <> 'PENDING'
              AND ha.approvement <> 'APPROVE'
              AND ha.support = 'APPROVE' 
              AND s.status = 'BEKERJA'
			  AND s.department_sub = '$department_sub'
              AND DATE_FORMAT(sh.date_lv_from,'%Y-%m-%d') >= DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')
              ORDER BY tarikh_mohon DESC";
      }
      else {
         $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,d.description AS department_name,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.support_by  
              LEFT JOIN staff stf ON s.leave_approval = stf.no_staff
			  LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement<>'PENDING'
			  AND ha.approvement <> 'APPROVE'
              AND ha.support = 'APPROVE'
              AND s.status = 'BEKERJA'
              AND s.leave_approval = '$leave_approval'
			  AND s.department_sub = '$department_sub'
              AND DATE_FORMAT(sh.date_lv_from,'%Y-%m-%d') >= DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')
              ORDER BY tarikh_mohon DESC"; 
      }
      $result=$conn->query($sql);
      return $result; 
  }

  function getSenaraiPemohonCutiLulusSemua1Old($leave_approval,$department_sub){
      $conn=db();
      $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
      
      if ($role_id == 'SUPERADMIN' || $role_id == 'HOD') {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,d.description AS department_name,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.support_by  
              LEFT JOIN staff stf ON s.leave_approval = stf.no_staff
			  LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement<>'PENDING'
              AND ha.approvement = 'APPROVE'
              AND s.status = 'BEKERJA'
			  AND s.department_sub = '$department_sub'
              ORDER BY tarikh_mohon DESC";
      }
      else {
         $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,d.description AS department_name,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.support_by  
              LEFT JOIN staff stf ON s.leave_approval = stf.no_staff
			  LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement<>'PENDING'
              AND ha.approvement = 'APPROVE'
              AND s.status = 'BEKERJA'
			  AND s.department_sub = '$department_sub'
              AND s.leave_approval = '$leave_approval'
              ORDER BY tarikh_mohon DESC"; 
      }
      $result=$conn->query($sql);
      return $result; 
  }


  function getSenaraiPemohonCutiTidakLulusSemua1Old($leave_approval,$department_sub){
      $conn=db();
      $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
      
      if ($role_id == 'SUPERADMIN' || $role_id == 'HOD') {
          $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,d.description AS department_name,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.support_by  
              LEFT JOIN staff stf ON s.leave_approval = stf.no_staff
			  LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement<>'PENDING'
              AND ha.approvement = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
			  AND s.department_sub = '$department_sub'
              ORDER BY tarikh_mohon DESC";
      }
      else {
         $sql="SELECT ha.*,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,d.description AS department_name,s.name AS nama_pekerja,s.department_id AS dept_code,s.role_id,sh.*,stf.name AS pelulus FROM approve_holiday ha 
              LEFT JOIN aims_lv_form sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.support_by  
              LEFT JOIN staff stf ON s.leave_approval = stf.no_staff
			  LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement<>'PENDING'
              AND ha.approvement = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
			  AND s.department_sub = '$department_sub'
              AND s.leave_approval = '$leave_approval'
              ORDER BY tarikh_mohon DESC"; 
      }
      $result=$conn->query($sql);
      return $result; 
  }

//end list for approvement

  function UpdatePelulus($staff_holiday_id,$approve_by){
    $conn=db();
    $sql="UPDATE holiday_approve SET approve_by='$approve_by'
          WHERE staff_holiday_id='$staff_holiday_id'";
    $result=$conn->query($sql);
    return $result; 
  }

  function UpdateStatusCuti($id){
    $conn=db();
    $sql="UPDATE approve_holiday SET support = 'IN PROGRESS' , approvement = 'IN PROGRESS'
          WHERE staff_holiday_id='$id'";
    $result=$conn->query($sql);
    return $result; 
  }
  
  function UpdateStatusCutisupport($id,$support_by){
    $conn=db();
    $sql="UPDATE approve_holiday SET support = 'APPROVE' , support_by = '$support_by'
          WHERE staff_holiday_id='$id'";
    $result=$conn->query($sql);
    return $result; 
  }
  
    function UpdateStatusCutisupport1($staff_holiday_id,$support_by,$staff_record_id,$total_lv_req,$type_leave){
    $conn=db();
    $sql="UPDATE approve_holiday SET support = 'DISAPPROVE' , support_by = '$support_by'
          WHERE staff_holiday_id='$staff_holiday_id'";
    $result=$conn->query($sql);
		
	$sql = "SELECT baki_cuti_pohon FROM staff_total_cuti WHERE staff_record_id='$staff_record_id' AND jenis_cuti = '$type_leave' AND tahun = YEAR(CURRENT_TIMESTAMP)";
	$baki_cuti_pohon =$conn->query($sql)->fetch_object()->baki_cuti_pohon;
		
	$_baki_cuti_pohon = $total_lv_req + $baki_cuti_pohon;
    $sql="UPDATE staff_total_cuti SET baki_cuti_pohon='$_baki_cuti_pohon' 
		  WHERE staff_record_id='$staff_record_id' AND jenis_cuti = '$type_leave' AND tahun = YEAR(CURRENT_TIMESTAMP)";
    $result=$conn->query($sql);
		
		
    return $result;
  }

  function UpdateStatusCutisupport1old($staff_holiday_id,$support_by,$staff_record_id,$total_lv_req,$type_leave){
    $conn=db();
    $sql="UPDATE approve_holiday SET support = 'DISAPPROVE' , support_by = '$support_by'
          WHERE staff_holiday_id='$staff_holiday_id'";
    $result=$conn->query($sql);
		
	$sql = "SELECT baki_cuti_pohon FROM staff_total_cuti WHERE staff_record_id='$staff_record_id' AND jenis_cuti = '$type_leave' AND tahun = YEAR(CURRENT_TIMESTAMP)";
	$baki_cuti_pohon =$conn->query($sql)->fetch_object()->baki_cuti_pohon;
		
	$_baki_cuti_pohon = $total_lv_req + $baki_cuti_pohon;
    $sql="UPDATE staff_total_cuti SET baki_cuti_pohon='$_baki_cuti_pohon' 
		  WHERE staff_record_id='$staff_record_id' AND jenis_cuti = '$type_leave' AND tahun = YEAR(CURRENT_TIMESTAMP)";
    $result=$conn->query($sql);
		
		
    return $result;
  }

  /*function addCatatan($catatan){
    $conn=db();
    $sql="UPDATE holiday_approve SET catatan= '$catatan'
          WHERE id='$staff_holiday_id'";
      return $conn->query($sql);
  }*/

  //DROPDOWN STATUS cuti


  function UpdateStatusCuti2($staff_holiday_id,$tarikh_approve,$approvement,$total_cuti,$baki_cuti_pohon,$jumlah_cuti,$staff_record_id,$baki_cuti,$approve_by,$jenis_cuti,$remark){
    $conn=db();
    $sql=" UPDATE approve_holiday SET date_approve=CURRENT_TIMESTAMP,approvement = '$approvement', approve_by='$approve_by', remark='$remark'
          WHERE staff_holiday_id='$staff_holiday_id'";
   $result=$conn->query($sql);
        if($approvement == 'APPROVE') {
          $_baki_cuti = $baki_cuti - $jumlah_cuti;
          $sql1="UPDATE staff_total_cuti SET baki_cuti='$_baki_cuti'
                  WHERE  staff_record_id='$staff_record_id' AND jenis_cuti = '$jenis_cuti' AND tahun = YEAR(CURRENT_TIMESTAMP)";
            $result=$conn->query($sql1);
        }
        else {
          $_baki_cuti_pohon = $baki_cuti_pohon + $jumlah_cuti;
          $sql2="UPDATE staff_total_cuti SET baki_cuti_pohon='$_baki_cuti_pohon'
                  WHERE  staff_record_id='$staff_record_id' AND jenis_cuti = '$jenis_cuti' AND tahun = YEAR(CURRENT_TIMESTAMP)";
            $result=$conn->query($sql2);
        }
   return $result; 
  }

function UpdateStatusCuti3($staff_holiday_id,$tarikh_approve,$approvement,$total_cuti,$baki_cuti_pohon,$jumlah_cuti,$staff_record_id,$baki_cuti,$approve_by,$jenis_cuti,$remark){
    $conn=db();
    $sql=" UPDATE approve_holiday SET date_approve=CURRENT_TIMESTAMP,approvement = '$approvement', approve_by='$approve_by', remark='$remark'
          WHERE staff_holiday_id='$staff_holiday_id'";
   $result=$conn->query($sql);
        if($approvement == 'APPROVE') {
          $_baki_cuti = $baki_cuti - $jumlah_cuti;
		  
          $sql1="UPDATE staff_total_cuti SET baki_cuti='$_baki_cuti'
                  WHERE  staff_record_id='$staff_record_id' AND jenis_cuti = '$jenis_cuti' AND tahun = YEAR(CURRENT_TIMESTAMP)";
            $result=$conn->query($sql1);
        
          $_baki_cuti_pohon = $baki_cuti_pohon - $jumlah_cuti;
          $sql2="UPDATE staff_total_cuti SET baki_cuti_pohon='$_baki_cuti_pohon'
                  WHERE  staff_record_id='$staff_record_id' AND jenis_cuti = '$jenis_cuti' AND tahun = YEAR(CURRENT_TIMESTAMP)";
            $result=$conn->query($sql2);
        }
   return $result; 
  }

  function getPelulus($no_staff){
      $conn=db();
      $sql="SELECT name FROM staff WHERE no_staff='$no_staff'";
      $result=$conn->query($sql);
      return $result; 
  }

  function getStaff() {
      $conn=db();
      $sql = "SELECT * FROM staff WHERE jawatan_code='Mng'";
      $result = $conn->query($sql);
      return $result;
  }

  function checkCheckbox($company_id,$staff_id){
      $conn=db();
      $sql = "SELECT * FROM staff WHERE staff_id='$staff_id' AND company_id='$company_id'";
      $result = $conn->query($sql);
      $row=$result->num_rows;
      if($row>0){
        return "checked";
      }
      else{
        return " ";
      }
   }

   function getCountBakiCutiSemasa($no_staff) {
      $conn=db();
      $sql = "SELECT SUM(DATEDIFF(DATE(sh.tarikh_akhir), DATE(sh.tarikh_mula))+1) AS baki_cuti_semasa FROM staff_holiday sh
              LEFT JOIN staff_record sr ON sh.staff_record_id = sr.id
              LEFT JOIN holiday_approve ha ON sh.id = ha.staff_holiday_id
              LEFT JOIN staff s ON sr.no_staff = s.no_staff 
              WHERE ha.approvement = 'APPROVE'
              AND s.status = 'BEKERJA'
              AND s.noic IS NOT NULL
              AND s.no_staff = '$no_staff'
              AND DATE_FORMAT(sh.tarikh_mula,'%Y') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')";
      $result = $conn->query($sql)->fetch_object()->baki_cuti_semasa;
      return $result;
  }

  function getCountBakiCutiPermohonan($no_staff) {
      $conn=db();
      $sql = "SELECT SUM(DATEDIFF(DATE(sh.tarikh_akhir), DATE(sh.tarikh_mula))+1) AS baki_cuti_permohonan FROM staff_holiday sh
              LEFT JOIN staff_record sr ON sh.staff_record_id = sr.id
              LEFT JOIN holiday_approve ha ON sh.id = ha.staff_holiday_id
              LEFT JOIN staff s ON sr.no_staff = s.no_staff 
              WHERE ha.approvement = 'SD'
              AND s.status = 'BEKERJA'
              AND s.noic IS NOT NULL
              AND s.no_staff = '$no_staff'
              AND DATE_FORMAT(sh.tarikh_mula,'%Y') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')";
      $result = $conn->query($sql)->fetch_object()->baki_cuti_permohonan;
      return $result;
  }

  function getBilBakiCutiSemasa() {
      $conn=db();
      $sql = "SELECT SUM(DATEDIFF(DATE(sh.tarikh_akhir), DATE(sh.tarikh_mula))+1) AS baki_cuti_semasa FROM staff_holiday sh
              LEFT JOIN holiday_approve ha ON sh.id = ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN jenis_kelulusan jk ON jk.code=ha.approvement
              LEFT JOIN jenis_cuti jc ON jc.code=sh.cuti_dipohon
              LEFT JOIN department d ON d.code_department=s.department_id
              WHERE ha.approvement = 'APPROVE'
              AND DATE_FORMAT(sh.tarikh_mula,'%Y') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')
              GROUP BY sh.staff_record_id";
      $result = $conn->query($sql)->fetch_object()->baki_cuti_semasa;
      return $result;
  }

  function getBilBakiCutiPermohonan() {
      $conn=db();
      $sql = "SELECT SUM(DATEDIFF(DATE(sh.tarikh_akhir), DATE(sh.tarikh_mula))+1) AS baki_cuti_permohonan FROM staff_holiday sh
              LEFT JOIN holiday_approve ha ON sh.id = ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff
              LEFT JOIN jenis_kelulusan jk ON jk.code=ha.approvement
              LEFT JOIN jenis_cuti jc ON jc.code=sh.cuti_dipohon
              LEFT JOIN department d ON d.code_department=s.department_id
              WHERE ha.approvement = 'SD'
              AND DATE_FORMAT(sh.tarikh_mula,'%Y') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')
              GROUP BY sh.staff_record_id";
      $result = $conn->query($sql)->fetch_object()->baki_cuti_permohonan;
      return $result;
  }

  function getCountCutiBaharu($leave_approval) {
      $conn=db();
      $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;

      if ($role_id == 'ADMIN' || $role_id == 'SUPERADMIN' || $role_id == 'HR' || $role_id == 'FOUNDER') {
      $sql="SELECT COUNT(*) AS count_cuti_baharu FROM holiday_approve ha 
              LEFT JOIN staff_holiday sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.approve_by  
              LEFT JOIN jenis_kelulusan jk ON jk.code=ha.approvement
              LEFT JOIN jenis_cuti jc ON jc.code=sh.cuti_dipohon
              LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement = 'SD'
              AND s.status = 'BEKERJA'
              AND DATE_FORMAT(sh.tarikh_mula,'%Y-%m-%d') >= DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
      $result = $conn->query($sql)->fetch_object()->count_cuti_baharu;
    }
    else {
       $sql="SELECT COUNT(*) AS count_cuti_baharu FROM holiday_approve ha 
              LEFT JOIN staff_holiday sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.approve_by  
              LEFT JOIN jenis_kelulusan jk ON jk.code=ha.approvement
              LEFT JOIN jenis_cuti jc ON jc.code=sh.cuti_dipohon
              LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement = 'SD'
              AND s.status = 'BEKERJA'
              AND s.leave_approval = '$leave_approval'
              AND DATE_FORMAT(sh.tarikh_mula,'%Y-%m-%d') >= DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
      $result = $conn->query($sql)->fetch_object()->count_cuti_baharu;
    }
      return $result;
  }

  function getCountCutiLulusBaharu($leave_approval) {
      $conn=db();
      $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;

      if ($role_id == 'ADMIN' || $role_id == 'SUPERADMIN' || $role_id == 'HR' || $role_id == 'FOUNDER') {
      $sql = "SELECT COUNT(*) AS count_cuti_lulus_baharu FROM holiday_approve ha 
              LEFT JOIN staff_holiday sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.approve_by  
              LEFT JOIN jenis_kelulusan jk ON jk.code=ha.approvement
              LEFT JOIN jenis_cuti jc ON jc.code=sh.cuti_dipohon
              LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement = 'APPROVE'
              AND s.status = 'BEKERJA'
              AND DATE_FORMAT(sh.tarikh_mula,'%Y-%m-%d') >= DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
      $result = $conn->query($sql)->fetch_object()->count_cuti_lulus_baharu;
    }
    else {
      $sql = "SELECT COUNT(*) AS count_cuti_lulus_baharu FROM holiday_approve ha 
              LEFT JOIN staff_holiday sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.approve_by  
              LEFT JOIN jenis_kelulusan jk ON jk.code=ha.approvement
              LEFT JOIN jenis_cuti jc ON jc.code=sh.cuti_dipohon
              LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement = 'APPROVE'
              AND s.status = 'BEKERJA'
              AND s.leave_approval = '$leave_approval'
              AND DATE_FORMAT(sh.tarikh_mula,'%Y-%m-%d') >= DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
      $result = $conn->query($sql)->fetch_object()->count_cuti_lulus_baharu;
    }
      return $result;
  }

  function getCountCutiLulusLama($leave_approval) {
      $conn=db();
      $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;

      if ($role_id == 'ADMIN' || $role_id == 'SUPERADMIN' || $role_id == 'HR' || $role_id == 'FOUNDER') {
      $sql = "SELECT COUNT(*) AS count_cuti_lulus_lama FROM holiday_approve ha 
              LEFT JOIN staff_holiday sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.approve_by  
              LEFT JOIN jenis_kelulusan jk ON jk.code=ha.approvement
              LEFT JOIN jenis_cuti jc ON jc.code=sh.cuti_dipohon
              LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement = 'APPROVE'
              AND s.status = 'BEKERJA'
              AND DATE_FORMAT(sh.tarikh_mula,'%Y-%m-%d') < DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
      $result = $conn->query($sql)->fetch_object()->count_cuti_lulus_lama;
    }
    else {
      $sql = "SELECT COUNT(*) AS count_cuti_lulus_lama FROM holiday_approve ha 
              LEFT JOIN staff_holiday sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.approve_by  
              LEFT JOIN jenis_kelulusan jk ON jk.code=ha.approvement
              LEFT JOIN jenis_cuti jc ON jc.code=sh.cuti_dipohon
              LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement = 'APPROVE'
              AND s.status = 'BEKERJA'
              AND s.leave_approval = '$leave_approval'
              AND DATE_FORMAT(sh.tarikh_mula,'%Y-%m-%d') < DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
      $result = $conn->query($sql)->fetch_object()->count_cuti_lulus_lama;
    }
      return $result;
  }

  function getCountCutiTidakLulusBaharu($leave_approval) {
      $conn=db();
      $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;

      if ($role_id == 'ADMIN' || $role_id == 'SUPERADMIN' || $role_id == 'HR' || $role_id == 'FOUNDER') {
      $sql = "SELECT COUNT(*) AS count_cuti_tidak_lulus_baharu FROM holiday_approve ha 
              LEFT JOIN staff_holiday sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.approve_by  
              LEFT JOIN jenis_kelulusan jk ON jk.code=ha.approvement
              LEFT JOIN jenis_cuti jc ON jc.code=sh.cuti_dipohon
              LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
              AND DATE_FORMAT(sh.tarikh_mula,'%Y-%m-%d') >= DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
      $result = $conn->query($sql)->fetch_object()->count_cuti_tidak_lulus_baharu;
    }
    else {
      $sql = "SELECT COUNT(*) AS count_cuti_tidak_lulus_baharu FROM holiday_approve ha 
              LEFT JOIN staff_holiday sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.approve_by  
              LEFT JOIN jenis_kelulusan jk ON jk.code=ha.approvement
              LEFT JOIN jenis_cuti jc ON jc.code=sh.cuti_dipohon
              LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
              AND s.leave_approval = '$leave_approval'
              AND DATE_FORMAT(sh.tarikh_mula,'%Y-%m-%d') >= DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
      $result = $conn->query($sql)->fetch_object()->count_cuti_tidak_lulus_baharu;
    }  
      return $result;
  }

  function getCountCutiTidakLulusLama($leave_approval) {
      $conn=db();
      $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;

      if ($role_id == 'ADMIN' || $role_id == 'SUPERADMIN' || $role_id == 'HR' || $role_id == 'FOUNDER') {
      $sql = "SELECT COUNT(*) AS count_cuti_tidak_lulus_lama FROM holiday_approve ha 
              LEFT JOIN staff_holiday sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.approve_by  
              LEFT JOIN jenis_kelulusan jk ON jk.code=ha.approvement
              LEFT JOIN jenis_cuti jc ON jc.code=sh.cuti_dipohon
              LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
              AND DATE_FORMAT(sh.tarikh_mula,'%Y-%m-%d') < DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
      $result = $conn->query($sql)->fetch_object()->count_cuti_tidak_lulus_lama;
    }
    else {
      $sql = "SELECT COUNT(*) AS count_cuti_tidak_lulus_lama FROM holiday_approve ha 
              LEFT JOIN staff_holiday sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.approve_by  
              LEFT JOIN jenis_kelulusan jk ON jk.code=ha.approvement
              LEFT JOIN jenis_cuti jc ON jc.code=sh.cuti_dipohon
              LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement = 'DISAPPROVE'
              AND s.status = 'BEKERJA'
              AND s.leave_approval = '$leave_approval'
              AND DATE_FORMAT(sh.tarikh_mula,'%Y-%m-%d') < DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
      $result = $conn->query($sql)->fetch_object()->count_cuti_tidak_lulus_lama;
    }  
      return $result;
  }

  function getCountCutiOverdue($leave_approval) {
      $conn=db();
      $sql = "SELECT role_id FROM staff WHERE no_staff='$leave_approval'";
      $role_id=$conn->query($sql)->fetch_object()->role_id;
      
      if ($role_id == 'ADMIN' || $role_id == 'SUPERADMIN' || $role_id == 'HR' || $role_id == 'FOUNDER') {
      $sql = "SELECT COUNT(*) AS count_cuti_overdue FROM holiday_approve ha 
              LEFT JOIN staff_holiday sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.approve_by  
              LEFT JOIN jenis_kelulusan jk ON jk.code=ha.approvement
              LEFT JOIN jenis_cuti jc ON jc.code=sh.cuti_dipohon
              LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement = 'SD'
              AND s.status = 'BEKERJA'
              AND DATE_FORMAT(sh.tarikh_mula,'%Y-%m-%d') < DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
      $result = $conn->query($sql)->fetch_object()->count_cuti_overdue;
    }
    else {
      $sql = "SELECT COUNT(*) AS count_cuti_overdue FROM holiday_approve ha 
              LEFT JOIN staff_holiday sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.approve_by  
              LEFT JOIN jenis_kelulusan jk ON jk.code=ha.approvement
              LEFT JOIN jenis_cuti jc ON jc.code=sh.cuti_dipohon
              LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement = 'SD'
              AND s.status = 'BEKERJA'
              AND s.leave_approval = '$leave_approval'
              AND DATE_FORMAT(sh.tarikh_mula,'%Y-%m-%d') < DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
      $result = $conn->query($sql)->fetch_object()->count_cuti_overdue;
    }
      return $result;
  }

  function getAnalisaPermohonanCutiByYear($value) {
      $conn=db();
      $sql = "SELECT COUNT(sh.id) AS bil_permohonan_tahunan FROM staff_holiday sh
              LEFT JOIN holiday_approve ha ON sh.id = ha.staff_holiday_id
              WHERE DATE_FORMAT(sh.tarikh_mula,'%Y') = '$value'
              AND ha.approvement NOT IN ('BD')";
      $result = $conn->query($sql);
      $row = mysqli_fetch_array($result, MYSQLI_NUM);
      if($result->num_rows > 0){
        return $row[0];
      }else{
        return '';
      }
  }

  function getAnalisaPermohonanCutiByMonth($value) {
      $conn=db();
      $sql = "SELECT COUNT(sh.id) AS bil_permohonan_bulanan FROM staff_holiday sh
              LEFT JOIN holiday_approve ha ON sh.id = ha.staff_holiday_id
              WHERE DATE_FORMAT(sh.tarikh_mula,'%Y%m') = '$value'
              AND ha.approvement NOT IN ('BD')";
      $result = $conn->query($sql);
      $row = mysqli_fetch_array($result, MYSQLI_NUM);
      if($result->num_rows > 0){
        return $row[0];
      }else{
        return '';
      }
  }

  function getAnalisaPermohonanCutiByWeek($start,$end) {
      $conn=db();
      $sql = "SELECT COUNT(sh.id) AS bil_permohonan_mingguan FROM staff_holiday sh
              LEFT JOIN holiday_approve ha ON sh.id = ha.staff_holiday_id
              WHERE DATE_FORMAT(sh.tarikh_mula,'%y-%m-%d') 
              BETWEEN DATE_FORMAT('$start','%y-%m-%d') AND DATE_FORMAT('$end','%y-%m-%d')
              AND ha.approvement NOT IN ('BD')";
      $result = $conn->query($sql);
      $row = mysqli_fetch_array($result, MYSQLI_NUM);
      if($result->num_rows > 0){
        return $row[0];
      }else{
        return '';
      }
  }

  function getAnalisaPermohonanCutiByDate($date) {
      $conn=db();
      $sql = "SELECT COUNT(sh.id) AS bil_permohonan_harian FROM staff_holiday sh
              LEFT JOIN holiday_approve ha ON sh.id = ha.staff_holiday_id
              WHERE DATE(sh.tarikh_mula)='$date'
              AND ha.approvement NOT IN ('BD')";
      $result = $conn->query($sql);
      $row = mysqli_fetch_array($result, MYSQLI_NUM);
      if($result->num_rows > 0){
        return $row[0];
      }else{
        return '';
      }
  }

  function getAnalisaPermohonanCutiMonthly($month,$current_year) {
    $conn=db();
    $sql = "SELECT COUNT(sh.id) AS bil_permohonan_bulan,jc.code,jc.desc FROM staff_holiday sh
            LEFT JOIN holiday_approve ha ON sh.id = ha.staff_holiday_id
            LEFT JOIN jenis_cuti jc ON sh.cuti_dipohon = jc.code
            WHERE DATE_FORMAT(sh.tarikh_mula,'%m') = '$month' AND DATE_FORMAT(sh.tarikh_mula,'%Y') = '$current_year' 
            AND ha.approvement NOT IN ('BD')
            GROUP BY sh.cuti_dipohon 
            ORDER BY bil_permohonan_bulan DESC";
    $result = $conn->query($sql);
    return $result;
  }

  function getTotalPermohonanCutiMonthly($month,$current_year) {
    $conn=db();
    $sql = "SELECT COUNT(sh.id) AS bil_permohonan_total FROM staff_holiday sh
            LEFT JOIN holiday_approve ha ON sh.id = ha.staff_holiday_id
            LEFT JOIN jenis_cuti jc ON sh.cuti_dipohon = jc.code
            WHERE DATE_FORMAT(sh.tarikh_mula,'%m') = '$month' AND DATE_FORMAT(sh.tarikh_mula,'%Y') = '$current_year' 
            AND ha.approvement NOT IN ('BD')";
    $result = $conn->query($sql);
    return $result->fetch_object()->bil_permohonan_total;
  }

  // function getAnalisaPermohonanCutiMonthly($month,$current_year) {
  //   $conn=db();
  //   echo $sql = "SELECT COUNT(CASE WHEN ha.approvement NOT IN ('BD') THEN 1 ELSE NULL END) AS bil_permohonan,
  //           COUNT(CASE WHEN ha.approvement = 'SD' THEN 1 ELSE NULL END) AS bil_permohonan_baharu,
  //           COUNT(CASE WHEN ha.approvement = 'APPROVE' THEN 1 ELSE NULL END) AS bil_permohonan_lulus,
  //           COUNT(CASE WHEN ha.approvement = 'DISAPPROVE' THEN 1 ELSE NULL END) AS bil_permohonan_lulus,jc.code,jc.desc 
  //           FROM staff_holiday sh
  //           LEFT JOIN holiday_approve ha ON sh.id = ha.staff_holiday_id
  //           LEFT JOIN jenis_cuti jc ON sh.cuti_dipohon = jc.code
  //           WHERE DATE_FORMAT(sh.tarikh_mula,'%m') = '$month' AND DATE_FORMAT(sh.tarikh_mula,'%Y') = '$current_year'
  //           GROUP BY sh.cuti_dipohon 
  //           ORDER BY bil_permohonan DESC";
  //   $result = $conn->query($sql);
  //   return $result;
  // }


  $conn->close();
  	
  ?>