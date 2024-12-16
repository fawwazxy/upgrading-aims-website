<?php

	require '../../lib/db/connection.php';
	
	

	$action=$_POST['action'];
  
	  //tolak gaji
		if ($action=="update_tolak_gaji") {
			
			$tolak_gaji_id= $_POST['tolak_gaji_id'];
			$jenis_penolakan = $_POST['jenis_penolakan'];
			$jumlah_tolak = $_POST['jumlah_tolak'];
			$catatan = $_POST['catatan'];
			$tarikh_tolak = $_POST['tarikh_tolak'];
			$no_staff= $_POST['no_staff'];
		
		if($tolak_gaji_id=='0'){
		  //need insert new data
			addTolakGaji($jenis_penolakan,$jumlah_tolak,$catatan,$tarikh_tolak,$no_staff);
		}
		else{
		  //will update
			echo updateTolakGaji($tolak_gaji_id,$jenis_penolakan,$jumlah_tolak,$catatan,$tarikh_tolak);
			}
		}
  
      if ($action=="del_tolak_gaji") {
		echo $tolak_gaji_id=clean($_POST['tolak_gaji_id']);
		if($tolak_gaji_id == "0"){
			
		}else{
			deleteTolakGaji($tolak_gaji_id);
		}
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
	
	function getLogStaff($no_staff) {
		$conn=db();
	    $sql = "   
                 SELECT s.*,ss.desc AS status_name,ss.code,d.description,r.role,j.jawatan AS jawatan_nama FROM staff s
                 LEFT JOIN role r ON r.id=s.role_id
				 LEFT JOIN status_staff ss ON ss.id=s.status
		         LEFT JOIN department d ON d.code_department=s.department_id 
		         LEFT JOIN jawatan j ON j.code=s.jawatan_code 
				 LEFT JOIN martial mr ON mr.martial_status=s.martial_status 
				 WHERE s.status='BEKERJA' AND s.noic IS NOT NULL 
				 ORDER BY s.no_staff ASC 
				 ";
		$result = $conn->query($sql);
		return $result;
	}
	 
	function getPekerja($no_staff) {
		$conn=db();
	    $sql = " SELECT s.*,ss.desc AS status_name,ss.code,d.desc,r.role,j.jawatan AS jawatan_nama FROM staff s
                 LEFT JOIN role r ON r.id=s.role_id
				 LEFT JOIN status_staff ss ON ss.id=s.status
		         LEFT JOIN department d ON d.id=s.department_id 
		         LEFT JOIN jawatan j ON j.code=s.jawatan_code 
				 LEFT JOIN martial mr ON mr.martial_status=s.martial_status 
				 WHERE s.no_staff='$no_staff'";
		$result = $conn->query($sql);
		  return $result;
	 }	
	
	function getNama($id){
        $conn=db();
        $sql="SELECT * FROM staff WHERE id='$id'";
        $result = $conn->query($sql);
        return $result;
     }
		
	function addTolakGaji($jenis_penolakan,$jumlah_tolak,$catatan,$tarikh_tolak,$no_staff) {
		$conn=db();
		 $sql = "INSERT INTO tolak_gaji(jenis_penolakan,jumlah_tolak,catatan,tarikh_tolak,no_staff) 
					VALUES('$jenis_penolakan','$jumlah_tolak','$catatan',STR_TO_DATE('$tarikh_tolak','%d/%m/%Y'),'$no_staff')";
		$result = $conn->query($sql);
		return $result;
	}
	
	function updateTolakGaji($tolak_gaji_id,$jenis_penolakan,$jumlah_tolak,$catatan,$tarikh_tolak) {
		$conn=db();
		$sql = "UPDATE tolak_gaji SET jenis_penolakan = '$jenis_penolakan', jumlah_tolak='$jumlah_tolak', catatan='$catatan', tarikh_tolak=STR_TO_DATE('$tarikh_tolak','%d/%m/%Y')
                WHERE id = '$tolak_gaji_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function deleteTolakGaji($tolak_gaji_id) {
		$conn=db();
		$sql = "DELETE FROM tolak_gaji WHERE id = '$tolak_gaji_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getTolakGaji($no_staff,$tahun,$bulan) {
		$conn=db();
		$sql = "SELECT *, YEAR(tarikh_tolak) AS tahun_mohon, MONTH(tarikh_tolak) AS bulan_mohon 
				FROM tolak_gaji 
				WHERE YEAR(tarikh_tolak)='$tahun' AND MONTH(tarikh_tolak)='$bulan' AND no_staff='$no_staff' ";
		$result=$conn->query($sql);
		return $result; 
	}
	
	// function getTolakGaji($no_staff,$tahun) {
		// $conn=db();
		// $sql = "SELECT *, year(tarikh_tolak) AS tahun_mohon
				// FROM tolak_gaji 
				// WHERE YEAR(tarikh_tolak)='$tahun'  AND no_staff='$no_staff' ";
		// $result=$conn->query($sql);
		// return $result; 
	// }
	
	// function getTolakGaji($no_staff) {
		// $conn=db();
		// $sql = "SELECT * FROM tolak_gaji 
				// WHERE no_staff='$no_staff' ";
		// $result=$conn->query($sql);
		// return $result; 
	// }
	
	function getMonth($code) {
		$conn=db();
		$sql="SELECT * FROM bulan WHERE code='$code'";
		$result=$conn->query($sql);
		return $result; 
	}
	
	function getStaffInformations($no_staff){
        $conn=db();
		$sql = "SELECT s.*, d.description AS bahagian, sr.gaji AS gaji_basic,r.role
				FROM staff s
				LEFT JOIN department d ON d.code_department=s.department_id
				LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
				LEFT JOIN role r ON sr.peranan=r.code
				WHERE s.status = 'BEKERJA' AND s.noic IS NOT NULL 
                      AND sr.tarikh_akhir IS NULL AND s.no_staff='$no_staff'";
        $result = $conn->query($sql);
		return $result;        
    }
	
	function getMonthlyReport($no_staff){
        $conn=db();
		$sql = "SELECT *, MONTH(tarikh_tolak) AS bulan_mohon 
				FROM tolak_gaji 
				WHERE MONTH(tarikh_tolak)='6'";
        $result = $conn->query($sql);
		return $result;        
    }
	
	function getAnnualReport($no_staff){
        $conn=db();
		$sql = "SELECT *, YEAR(tarikh_tolak) AS tahun_mohon 
				FROM tolak_gaji 
				WHERE YEAR(tarikh_tolak)='2018'";
        $result = $conn->query($sql);
		return $result;        
    }
	
	
$conn->close();
	

	
		
	
	?>
	
	