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
function getTarikhBekerja($tahun,$bulan,$minggu,$no_staff) {
    $conn=db();
    $sql = "SELECT * FROM tarikh_bekerja
WHERE DATE_FORMAT(tarikh,'%Y')='$tahun' AND DATE_FORMAT(tarikh,'%M')='$bulan' AND DATE_FORMAT(tarikh,'%V')='$minggu' AND no_staff='$no_staff'";
    $result = $conn->query($sql);
    return $result;
}
function getMingguBekerja($tahun,$bulan,$no_staff) {
    $conn=db();
    $sql = "SELECT DATE_FORMAT(tarikh,'%V') AS minggu,COUNT(tarikh) AS bil_hari  FROM tarikh_bekerja
WHERE DATE_FORMAT(tarikh,'%Y')='$tahun' AND DATE_FORMAT(tarikh,'%M')='$bulan' AND no_staff='$no_staff'
GROUP BY DATE_FORMAT(tarikh,'%V')";
    $result = $conn->query($sql);
    return $result;
}
function checkTahunAvailbility($tahun,$no_staff) {
    $conn=db();
    $sql = "SELECT COUNT(*) AS tahun FROM tarikh_bekerja
WHERE DATE_FORMAT(tarikh,'%Y')='$tahun' AND no_staff='$no_staff'";
    $result = $conn->query($sql);
    return $result->fetch_object()->tahun;
}
function janaTarikh($sys_id,$date,$status,$no_staff) {
    $conn=db();
    $ic_number = $conn->query("SELECT noic FROM staff WHERE no_staff = '$no_staff'")->fetch_object()->noic;
    $sql = "INSERT INTO tarikh_bekerja (id,no_staff,sys_id,tarikh,`status`)
VALUES (CONCAT(DATE_FORMAT(CURRENT_TIMESTAMP,'%Y%m%d%h%i%s'),'$ic_number','$date'),'$no_staff','$sys_id','$date', '$status')";
    $result = $conn->query($sql);
    return $result;
}
function janaHujungMinggu($sys_id,$no_staff) {
    $conn=db();
    $ic_number = $conn->query("SELECT noic FROM staff WHERE no_staff = '$no_staff'")->fetch_object()->noic;
    $sql = "INSERT INTO lkp_weekend (id,no_staff,sys_id,`desc`,`status`)
VALUES (CONCAT(DATE_FORMAT(CURRENT_TIMESTAMP,'%Y%m%d%h%i%s'),'$ic_number','1'),'$no_staff','$sys_id','Sunday','0'),
(CONCAT(DATE_FORMAT(CURRENT_TIMESTAMP,'%Y%m%d%h%i%s'),'$ic_number','2'),'$no_staff','$sys_id','Monday','0'),
(CONCAT(DATE_FORMAT(CURRENT_TIMESTAMP,'%Y%m%d%h%i%s'),'$ic_number','3'),'$no_staff','$sys_id','Tuesday','0'),
(CONCAT(DATE_FORMAT(CURRENT_TIMESTAMP,'%Y%m%d%h%i%s'),'$ic_number','4'),'$no_staff','$sys_id','Wednesday','0'),
(CONCAT(DATE_FORMAT(CURRENT_TIMESTAMP,'%Y%m%d%h%i%s'),'$ic_number','5'),'$no_staff','$sys_id','Thursday','0'),
(CONCAT(DATE_FORMAT(CURRENT_TIMESTAMP,'%Y%m%d%h%i%s'),'$ic_number','6'),'$no_staff','$sys_id','Friday','1'),
(CONCAT(DATE_FORMAT(CURRENT_TIMESTAMP,'%Y%m%d%h%i%s'),'$ic_number','7'),'$no_staff','$sys_id','Saturday','1')";
    $result = $conn->query($sql);
    return $result;
}
function tarikhBekerjaActive($id) {
    $conn=db();
    $sql = "UPDATE tarikh_bekerja SET `status`='1'
WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;
}
function tarikhBekerjaInactive($tahun,$no_staff) {
    $conn=db();
    $sql = "UPDATE tarikh_bekerja SET `status`='0'
		WHERE DATE_FORMAT(tarikh,'%Y')='$tahun' AND no_staff='$no_staff'";
    $result = $conn->query($sql);
    return $result;
}
function getHari($no_staff) {
    $conn=db();
    $sql = "SELECT * FROM lkp_weekend WHERE no_staff='$no_staff'";
    $result = $conn->query($sql);
    return $result;
}
function tarikhHujungMingguActive($id_hari) {
    $conn=db();
    $sql = "UPDATE lkp_weekend SET `status`='1'
WHERE id='$id_hari'";
    $result = $conn->query($sql);
    return $result;
}
function tarikhHujungMingguInactive($no_staff) {
    $conn=db();
    $sql = "UPDATE lkp_weekend SET `status`='0' WHERE no_staff='$no_staff'";
    $result = $conn->query($sql);
    return $result;
}
function getStatusHujungMinggu($hari,$no_staff) {
    $conn=db();
    $sql = "SELECT * FROM lkp_weekend WHERE `desc`='$hari' AND no_staff='$no_staff'";
    $result = $conn->query($sql);
    return $result;
}
function getBulanTarikhBekerja($tahun,$no_staff) {
    $conn=db();
    $sql = "SELECT DATE_FORMAT(tarikh,'%M') AS bulan FROM tarikh_bekerja
WHERE DATE_FORMAT(tarikh,'%Y')='$tahun' AND no_staff='$no_staff'
GROUP BY DATE_FORMAT(tarikh,'%m')
ORDER BY DATE_FORMAT(tarikh,'%m')";
    $result = $conn->query($sql);
    return $result;
}
function getHariById($hari_id) {
    $conn=db();
    $sql = "SELECT `desc` FROM lkp_weekend
WHERE id='$hari_id'";
    $result = $conn->query($sql);
    return $result->fetch_object()->desc;
}
function updateStatusHariBekerjaActive($endDate,$no_staff) {
    $conn=db();
    $sql = "UPDATE tarikh_bekerja SET `status` = '1'
WHERE tarikh BETWEEN DATE_FORMAT(NOW(),'%Y-%m-%d') AND '$endDate' AND no_staff='$no_staff'";
    $result = $conn->query($sql);
    return $result;
}
function updateStatusHariBekerjaInactive($hari,$endDate,$no_staff) {
    $conn=db();
    $sql = "UPDATE tarikh_bekerja SET `status` = '0'
WHERE DATE_FORMAT(tarikh,'%W')='$hari' AND tarikh BETWEEN DATE_FORMAT(NOW(),'%Y-%m-%d') AND '$endDate' AND no_staff='$no_staff'";
    $result = $conn->query($sql);
    return $result;
}
function getLogStaffByJabatan($cawangan_kod,$jabatan_kod,$statact) {
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
    if ($statact=='ACTIVE') {
        $sql = "SELECT s.*,d.description,r.role,rg.role_group_name,r.slip_gaji FROM staff s
	LEFT JOIN role r ON r.code=s.role_id
	LEFT JOIN department d ON d.code_department=s.department_id 
	LEFT JOIN role_group rg ON rg.id=r.role_group_id 
	LEFT JOIN martial mr ON mr.martial_status=s.martial_status 
	WHERE s.noic IS NOT NULL AND s.status='BEKERJA' AND s.role_id NOT IN ('INTERN') $cond
	ORDER BY s.name ASC";
    } else if ($statact=='INTERN') {
        $sql = "SELECT s.*,d.description,r.role,rg.role_group_name,r.slip_gaji FROM staff s
	LEFT JOIN role r ON r.code=s.role_id
	LEFT JOIN department d ON d.code_department=s.department_id 
	LEFT JOIN role_group rg ON rg.id=r.role_group_id 
	LEFT JOIN martial mr ON mr.martial_status=s.martial_status 
	WHERE s.noic IS NOT NULL AND s.status='BEKERJA' AND s.role_id='INTERN' $cond
	ORDER BY s.name ASC";
    }
    else {
        $sql = "SELECT s.*,d.description,r.role,rg.role_group_name,r.slip_gaji FROM staff s
	LEFT JOIN role r ON r.code=s.role_id
	LEFT JOIN department d ON d.code_department=s.department_id 
	LEFT JOIN role_group rg ON rg.id=r.role_group_id 
	LEFT JOIN martial mr ON mr.martial_status=s.martial_status 
	WHERE s.noic IS NOT NULL AND s.status NOT IN ('BEKERJA') $cond
	ORDER BY s.name ASC";
    }
    $result = $conn->query($sql);



    return $result;
}
function getStafTarikhBekerja($cawangan_kod,$jabatan_kod) {
    $conn=db();
    $sql = "SELECT s.* FROM staff s
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' AND s.role_id NOT IN ('INTERN') AND s.cawangan_kod='$cawangan_kod' AND s.department_id='$jabatan_kod' AND s.no_staff NOT IN(SELECT no_staff FROM tarikh_bekerja WHERE DATE_FORMAT(tarikh,'%Y')=YEAR(NOW()))";
    $result = $conn->query($sql);
    return $result;
}
function checkTahunAvailbilitysemua($cawangan_kod,$jabatan_kod) {
    $conn=db();
    $sql = "SELECT COUNT(s.id) AS bil FROM staff s
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' AND s.role_id NOT IN ('INTERN') AND s.cawangan_kod='$cawangan_kod' AND s.department_id='$jabatan_kod' AND s.no_staff NOT IN(SELECT no_staff FROM tarikh_bekerja WHERE DATE_FORMAT(tarikh,'%Y')=YEAR(NOW()))";
    $result = $conn->query($sql);
    return $result->fetch_object()->bil;
}
//start shift bekerja
function getDefaultShift() {
    $conn=db();
    $sql = "SELECT shift_code FROM masa_bekerja WHERE status='1'";
    $result = $conn->query($sql);
    return $result->fetch_object()->shift_code;
}
function updateShift($tarikh_id,$shift_code) {
    $conn=db();
    $sql = "UPDATE tarikh_bekerja SET shift_kerja='$shift_code'
				WHERE id='$tarikh_id'";
    $result = $conn->query($sql);
    return $result;
}
function getShiftBekerja($tahun,$bulan,$minggu,$no_staff) {
    $conn=db();
    $sql = "SELECT * FROM tarikh_bekerja
WHERE DATE_FORMAT(tarikh,'%Y')='$tahun' AND DATE_FORMAT(tarikh,'%M')='$bulan' AND DATE_FORMAT(tarikh,'%V')='$minggu' AND no_staff='$no_staff' AND status='1'";
    $result = $conn->query($sql);
    return $result;
}
function getBahagian($cawangan_kod,$jabatan_kod) {
    $conn=db();
    $sql = "SELECT d.* FROM department d 
					LEFT JOIN staff s ON d.code_department=s.department_id 
					WHERE s.cawangan_kod='$cawangan_kod' AND s.department_id='$jabatan_kod' AND s.status='BEKERJA'
					GROUP BY s.department_id";
    $result = $conn->query($sql);
    return $result;
}
function getBahagianById($id) {
    $conn=db();
    $sql = "SELECT * FROM department WHERE id='$id' ";
    $result = $conn->query($sql);
    return $result;
}
function getBulanTarikhBekerjaDepartment($tahun,$department_kod) {
    $conn=db();
    $sql = "SELECT DATE_FORMAT(t.tarikh,'%M') AS bulan FROM tarikh_bekerja t
				LEFT JOIN staff s ON s.no_staff=t.no_staff
				WHERE DATE_FORMAT(t.tarikh,'%Y')='$tahun' AND s.department_id='$department_kod'
				GROUP BY DATE_FORMAT(t.tarikh,'%m')
				ORDER BY DATE_FORMAT(t.tarikh,'%m')";
    $result = $conn->query($sql);
    return $result;
}
function getMingguBekerjaDepartment($tahun,$bulan,$department_kod) {
    $conn=db();
    $sql = "SELECT DATE_FORMAT(t.tarikh,'%V') AS minggu,COUNT(t.tarikh) AS bil_hari  FROM tarikh_bekerja t
LEFT JOIN staff s ON s.no_staff=t.no_staff
WHERE DATE_FORMAT(t.tarikh,'%Y')='$tahun' AND DATE_FORMAT(t.tarikh,'%M')='$bulan' AND s.department_id='$department_kod'
GROUP BY DATE_FORMAT(t.tarikh,'%V')";
    $result = $conn->query($sql);
    return $result;
}
function getShiftBekerjaDepartment($tahun,$bulan,$minggu,$department_kod) {
    $conn=db();
    $sql = "SELECT t.* FROM tarikh_bekerja t
				LEFT JOIN staff s ON s.no_staff=t.no_staff
				WHERE DATE_FORMAT(t.tarikh,'%Y')='$tahun' AND DATE_FORMAT(t.tarikh,'%M')='$bulan' 
				AND DATE_FORMAT(t.tarikh,'%V')='$minggu' AND s.department_id='$department_kod'
				GROUP BY t.tarikh";
    $result = $conn->query($sql);
    return $result;
}
function updateShiftBahagian($tarikh,$shift_code,$kod_bahagian) {
    $conn=db();
    $sql = "UPDATE tarikh_bekerja t
				LEFT JOIN staff s ON s.no_staff=t.no_staff
				SET t.shift_kerja='$shift_code'
				WHERE t.tarikh='$tarikh' AND s.department_id='$kod_bahagian'";
    $result = $conn->query($sql);
    return $result;
}