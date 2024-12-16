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
		$sql = "SELECT * FROM sys_setting";
		if ($sys_id!='') {
			$sql .= " WHERE sys_id='$sys_id'";
		}
		$result = $conn->query($sql);
		return $result;
	}
	function getNama($id){
		$conn=db();
		$sql="SELECT name FROM staff WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;

}
function getLogStaffByJabatan($cawangan_kod,$jabatan_kod) {
	$conn=db();

	if($cawangan_kod=="0" && $jabatan_kod=="0"){
		$cond="";
	}else if($cawangan_kod=="0" && $jabatan_kod!="0"){
		$cond="AND s.department_id='$jabatan_kod'";
	}else if($cawangan_kod!="0" && $jabatan_kod=="0"){
		$cond="AND s.cawangan_kod='$cawangan_kod'";
	}else{
		$cond="AND s.cawangan_kod='$cawangan_kod' AND s.department_id='$jabatan_kod'";
	}
	$sql = "SELECT s.*,d.description,r.role,rg.role_group_name,r.slip_gaji FROM staff s
	LEFT JOIN role r ON r.code=s.role_id
	LEFT JOIN department d ON d.code_department=s.department_id 
	LEFT JOIN role_group rg ON rg.id=r.role_group_id 
	LEFT JOIN martial mr ON mr.martial_status=s.martial_status 
	WHERE s.noic IS NOT NULL AND s.status='BEKERJA' $cond
	ORDER BY s.name ASC";
    
	$result = $conn->query($sql);
	
	
	
	return $result;
}

function getNoStaff($leave_approval) {
    $conn=db();
     echo $sql = "SELECT no_staff, name FROM staff
        WHERE status='BEKERJA' AND noic IS NOT NULL AND no_staff='$leave_approval'
        ORDER BY no_staff ASC";  
    $result = $conn->query($sql);
    return $result;
  }
  
  function getJenisCuti() {
    $conn=db();
	   $sql = "SELECT * FROM jenis_cuti";  
    $result = $conn->query($sql);
    return $result;
  }
  function getStaffRecordId($no_staff) {
    $conn=db();
	   $sql = "SELECT MAX(sr.id) AS id
				FROM staff_record sr 
				LEFT JOIN staff s ON s.no_staff=sr.no_staff 
				WHERE s.status = 'BEKERJA' AND s.noic IS NOT NULL 
				AND s.no_staff='$no_staff'";  
    $result = $conn->query($sql);
    return $result->fetch_object()->id;
  }
  function addCuti($staff_record_id,$jabatan_kod,$jenis_cuti,$tarikh_mula,$tarikh_akhir,$created_date,$pelulus_cuti,$jumlah_cuti,$created_by){
        $conn=db();
       
       $sql ="INSERT INTO staff_holiday
              (staff_record_id,department_id,cuti_dipohon,tarikh_mula,tarikh_akhir,jumlah_cuti,created_date) VALUES ('$staff_record_id','$jabatan_kod','$jenis_cuti','$tarikh_mula','$tarikh_akhir','$jumlah_cuti','$created_date')";
        $result = $conn->query($sql);
        $staff_holiday_id = $conn->insert_id;
        //query insert data ke table holiday_approve
        $sql1 ="INSERT INTO holiday_approve(staff_holiday_id,approvement,approve_by,manual_entered_by) VALUES('$staff_holiday_id','APPROVE','$pelulus_cuti','$created_by')";
        $result1 = $conn->query($sql1);

        $sql="UPDATE staff_total_cuti SET baki_cuti_pohon=baki_cuti_pohon-'$jumlah_cuti',baki_cuti=baki_cuti-'$jumlah_cuti' WHERE staff_record_id='$staff_record_id' AND jenis_cuti ='$jenis_cuti' AND tahun = YEAR(CURRENT_TIMESTAMP)";
        $result = $conn->query($sql);

        return $result;   
    }
    function getSenaraiCuti($cawangan_kod,$jabatan_kod,$status,$tarikh_mula,$tarikh_akhir) {
    $conn=db();

    if($status=='semasa'){
    	$cond="AND sh.tarikh_akhir>=NOW()";
    }else{
    	$cond="AND sh.tarikh_akhir BETWEEN '$tarikh_mula' AND '$tarikh_akhir'";
    }
	   $sql = "SELECT ha.*,sh.id AS staff_holiday_id,sr.id AS staff_record_id,s.name,s.noic,s.phone,s.email,s.alamat_surat,s.no_staff,r.role,
              sh.created_date AS tarikh_mohon,d.description AS department_name,jk.jenis_lulus,jc.desc AS nama_cuti,s.name AS nama_pekerja,s.department_id as dept_code,s.role_id,sh.*,sh.tarikh_mula,sh.tarikh_akhir,sh.sebab,sh.alamat_cuti,stf.name AS pelulus FROM holiday_approve ha 
              LEFT JOIN staff_holiday sh ON sh.id=ha.staff_holiday_id
              LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id
              LEFT JOIN staff s ON s.no_staff= sr.no_staff 
              LEFT JOIN staff st ON st.no_staff=ha.approve_by  
              LEFT JOIN staff stf ON s.leave_approval = stf.no_staff
              LEFT JOIN jenis_kelulusan jk ON jk.code=ha.approvement
              LEFT JOIN jenis_cuti jc ON jc.code=sh.cuti_dipohon
              LEFT JOIN department d ON d.id=sh.department_id 
              LEFT JOIN department ds ON s.department_id=ds.code_department 
              LEFT JOIN role r ON sr.peranan=r.code
              WHERE ha.approvement<>'BD'
              AND ha.approvement = 'APPROVE'
              AND s.status = 'BEKERJA' AND s.cawangan_kod='$cawangan_kod' AND s.department_id='$jabatan_kod' $cond
              ORDER BY tarikh_mohon DESC";  
    
    
    $result = $conn->query($sql);
    return $result;
  }
   function delcuti($holiday_approve_id,$staff_record_id,$staff_holiday_id,$jumlah_cuti,$jenis_cuti){
        $conn=db();
       
       

        $sql="UPDATE staff_total_cuti SET baki_cuti_pohon=baki_cuti_pohon+'$jumlah_cuti',baki_cuti=baki_cuti+'$jumlah_cuti' WHERE staff_record_id='$staff_record_id' AND jenis_cuti ='$jenis_cuti' AND tahun = YEAR(CURRENT_TIMESTAMP)";
        $result = $conn->query($sql);

        $sql ="DELETE FROM staff_holiday WHERE id='$staff_holiday_id'";
        $result = $conn->query($sql);
        //query insert data ke table holiday_approve
        $sql1 ="DELETE FROM holiday_approve WHERE id='$holiday_approve_id'";
        $result = $conn->query($sql1);

        return $result;   
    }

	
	$conn->close();
	
?>