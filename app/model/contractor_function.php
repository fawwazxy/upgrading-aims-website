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

function addContactor($name,$noic,$umur,$gender,$phone,$email,$syarikat,$category_id,$status_qrcode,$status_swafoto,$status_tag,$purpose,$document_name,$document_type,$document_size) {
	$conn=db();

	$gambar = '';
	$gambar_val = '';
	if($document_name!=""){
		$gambar=",doc_name,doc_type,doc_size";
		$gambar_val=",'$document_name','$document_type','$document_size'";
	}

	$sql = "INSERT INTO staff(no_staff,noic,name,username,accs_pwd,phone,email,umur,gender,role_id,
	status,pantau_kehadiran,shift_kerja,jum_jam_kerja,jum_jam_break,status_qrcode,status_swafoto,status_tag,department_id,company_id) 
	VALUES('$noic','$noic','$name','$noic','$noic','$phone','$email','$umur','$gender','$category_id',
	'BEKERJA','0','pagi','08:00:00','01:00:00','1','1','0','AGMHESB','1')";
	$result = $conn->query($sql);

	$contractor_id=$conn->insert_id;
	$sql = "INSERT INTO contractor_company(syarikat,contractor_id,purpose$gambar) VALUES('$syarikat','$contractor_id','$purpose'$gambar_val)";	
	$result = $conn->query($sql);
	return $result;
}

// function updateCarFuel($mileage_fuel,$receipt_fuel,$document_name,$document_type,$file_name,$file_type,$id){
// 		$conn=db();
// 		$sql = "UPDATE aims_car_fuel SET mileage_fuel='$mileage_fuel', receipt_fuel= '$receipt_fuel'";
// 		if($document_name!=""){
//           $sql.=" ,document_name='$document_name',document_type='$document_type'";
		  
//         }
// 		else if($file_name!=""){
// 		$sql.=" ,file_name='$file_name',file_type='$file_type'"; 	
// 		}
// 		$sql.="  WHERE id='$id'";
// 		$result=$conn->query($sql) or die($conn->error);
// 		return $result;
// 	}

function updateContractor($name,$noic,$umur,$gender,$phone,$email,$username,$accs_pwd,$syarikat,$category_id,$jum_jam_kerja,$jum_jam_break,$status_qrcode,$status_swafoto,$status_tag,$purpose,$document_name,$document_type,$id){
	$conn=db();
	$sql = "UPDATE staff s
	LEFT JOIN contractor_company c ON s.id = c.contractor_id
	SET s.noic='$noic',s.name='$name',s.username='$username',s.accs_pwd='$accs_pwd',s.phone='$phone',s.email='$email',s.umur='$umur',s.gender='$gender',s.role_id='$category_id',
	s.jum_jam_kerja='$jum_jam_kerja',s.jum_jam_break='$jum_jam_break',s.status_qrcode='$status_qrcode',s.status_swafoto='$status_swafoto',s.status_tag='$status_tag',c.syarikat='$syarikat',c.purpose='$purpose'";
	if($document_name!=""){
	    $sql.=",c.doc_name='$document_name',c.doc_type='$document_type'";
	}
	$sql.=" WHERE s.id='$id'";
	$result = $conn->query($sql);
	return $result;
}


function getContractorList($category_id) {
	$conn=db();
	$sql = "SELECT s.id,s.noic,s.no_staff,s.name,s.username,s.accs_pwd,s.phone,s.email,s.umur,s.role_id,
	s.status,s.pantau_kehadiran,s.shift_kerja,s.jum_jam_kerja,s.jum_jam_break,s.status_qrcode,s.status_swafoto,s.status_tag,c.syarikat,c.contractor_id,c.purpose,c.doc_name,c.doc_type,c.doc_size
	FROM staff s
	LEFT JOIN contractor_company c ON s.id = c.contractor_id 
	WHERE s.role_id = '$category_id' ORDER BY s.name ASC";
	$result = $conn->query($sql);
	return $result;
}

function getVisitorList($category_id) {
	$conn=db();
	$sql = "SELECT s.id,s.noic,s.no_staff,s.name,s.username,s.accs_pwd,s.phone,s.email,s.umur,s.role_id,
	s.status,s.pantau_kehadiran,s.shift_kerja,s.jum_jam_kerja,s.jum_jam_break,s.status_qrcode,s.status_swafoto,s.status_tag,c.syarikat,c.contractor_id,c.purpose,c.doc_name,c.doc_type,c.doc_size,m.masa_masuk,m.masa_keluar,m.remark_masuk,m.remark_keluar
	FROM staff s
	LEFT JOIN contractor_company c ON s.id = c.contractor_id 
	LEFT JOIN masa_kehadiran m ON m.created_by = s.no_staff
	WHERE s.role_id = '$category_id' ORDER BY m.masa_masuk DESC";
	$result = $conn->query($sql);
	return $result;
}

function getLampiranVaksin($id){
        $conn=db();
        $sql="SELECT id,doc_name,doc_type FROM contractor_company WHERE id='$id'";
        $result=$conn->query($sql);
        return $result;  
    }

function getContractorById($id) {
	$conn=db();
	$sql = "SELECT s.id,s.noic,s.name,s.username,s.accs_pwd,s.phone,s.email,s.umur,s.role_id,s.gender,
	s.status,s.pantau_kehadiran,s.shift_kerja,s.jum_jam_kerja,s.jum_jam_break,s.status_qrcode,s.status_swafoto,s.status_tag,c.syarikat,c.purpose,c.doc_name,c.doc_type,c.doc_size
	FROM staff s
	LEFT JOIN contractor_company c ON s.id = c.contractor_id WHERE s.id = '$id'";
	$result = $conn->query($sql);
	return $result;
}

// function updateContractor($id){
// 	$conn=db();
// 	$sql = "UPDATE staff s
// 	LEFT JOIN contractor_company c ON s.id = c.contractor_id
// 	SET s.noic='$noic',s.name='$name',s.username='$username',s.accs_pwd='$accs_pwd',s.phone='$phone',s.email='$email',s.umur='$umur',s.role_id='$category_id',
// 	s.jum_jam_kerja='$jum_jam_kerja',s.jum_jam_break='$jum_jam_break',s.status_qrcode='$status_qrcode',s.status_swafoto='$status_swafoto',s.status_tag='$status_tag',c.syarikat='$syarikat'
// 	WHERE s.id='$id'";
// 	$result = $conn->query($sql);
// 	return $result;
// }

function deleteImageFromServer($id){
	$conn=db();
	$getImageURL = $conn->query("SELECT doc_name FROM contractor_company WHERE contractor_id = '$id'")->fetch_object()->doc_name;
	unlink("../../contractorphoto/".$getImageURL);
}


function deleteContractor($id){
	$conn=db();

	$sql = "DELETE FROM staff WHERE id = '$id'";
	$result = $conn->query($sql);

	$sql = "DELETE FROM contractor_company WHERE contractor_id = '$id'";
	$result = $conn->query($sql);
	return $result;
}

function getStaffName($noic){
	$conn=db();
	$sql = "SELECT * FROM staff
	where noic = '$noic'
	AND status = 'BEKERJA'";

	$result = $conn->query($sql);
	return $result;
}

function getCompanyDetails($sys_id) {
	$conn=db();
	$sql = "SELECT * FROM company WHERE sys_id='$sys_id'";
	$result = $conn->query($sql);
	return $result;
}

function getValueName($no_staff){
	$conn=db();
	$sql="SELECT * FROM staff WHERE no_staff='$no_staff'";
	$result = $conn->query($sql);
	return $result;


}

function getValuePhoto($id){
	$conn=db();
	$sql="SELECT * FROM contractor_company WHERE contractor_id='$id'";
	$result = $conn->query($sql);
	return $result;


}

function getStaffrecord($no_staff){
	$conn=db();
	$sql = "SELECT s.id,s.noic,s.name,s.username,s.accs_pwd,s.phone,s.email,s.umur,s.role_id,s.gender,s.status,s.pantau_kehadiran,s.shift_kerja,s.jum_jam_kerja,s.jum_jam_break,s.status_qrcode,s.status_swafoto,s.status_tag,c.syarikat,c.purpose,c.doc_name,c.doc_type,c.doc_size
	FROM staff s
	LEFT JOIN contractor_company c ON s.id = c.contractor_id WHERE s.no_staff = '$no_staff'";
	$result = $conn->query($sql);
	return $result;
}

// start card elektronik
function getTarikhBekerja($mnth,$yr){
	$conn=db();
	$sql = "SELECT *,DATE_FORMAT(tarikh,'%W') AS hari FROM tarikh_bekerja
	WHERE MONTH(tarikh)='$mnth' AND YEAR(tarikh)='$yr'
	ORDER BY tarikh ASC";

	$result = $conn->query($sql);
	return $result;
}

function getKehadiranElektronik($dateSelection,$noic) {
	$conn=db();
	$sql = "SELECT s.*,k.*,m.device_masuk,m.device_keluar,m.lokasi_masuk,m.lokasi_keluar,MIN(DATE_FORMAT(m.masa_masuk,'%H:%i')) AS masa_masuk,
	IFNULL(MAX(DATE_FORMAT(m.masa_keluar,'%H:%i')),'') AS masa_keluar,DATE_FORMAT(SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))-TIME_TO_SEC(s.jum_jam_break)),'%H:%i:%s') AS total,
	TIMEDIFF(SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))-TIME_TO_SEC(s.jum_jam_break)),s.jum_jam_kerja) AS beza,MAX(m.remark_keluar) AS remark_keluar  
	FROM kehadiran k
	LEFT JOIN staff s ON k.nokp_staff=s.noic
	LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
	WHERE DATE_FORMAT(k.created_date,'%d-%m-%Y')=DATE_FORMAT('$dateSelection','%d-%m-%Y')
	AND k.nokp_staff='$noic' AND s.status='BEKERJA'";
	$result = $conn->query($sql) or die($conn->error);
	return $result;
}

function checkKehadiran($dateSelection,$noic) {
	$conn=db();
	$sql = "SELECT COUNT(k.id) AS bil
	FROM kehadiran k
	LEFT JOIN staff s ON k.nokp_staff=s.noic
	LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
	WHERE DATE_FORMAT(k.created_date,'%d-%m-%Y')=DATE_FORMAT('$dateSelection','%d-%m-%Y')
	AND k.nokp_staff='$noic' AND s.status='BEKERJA'";
	$result = $conn->query($sql) or die($conn->error);
	return $result->fetch_object()->bil;
}

function seconds_from_time($time) {
	list($h, $m, $s) = explode(':', $time);
	return ($h * 3600) + ($m * 60) + $s;
}

function time_from_seconds($seconds) {
	$h = floor($seconds / 3600);
	$m = floor(($seconds % 3600) / 60);
	$s = $seconds - ($h * 3600) - ($m * 60);
	return sprintf('%03d:%02d:%02d', $h, $m,$s);
}

function workdays($mnt,$thn){
	$conn=db();
	$sql = "SELECT COUNT(id) AS workday FROM tarikh_bekerja
	WHERE YEAR(tarikh)='$thn' AND MONTH(tarikh)='$mnt' AND STATUS='1'";
	$result = $conn->query($sql)->fetch_object()->workday;
	return $result;
}

function getJumlahMasaBekerja($noic,$mnt,$thn) {
	$conn=db();
	$masa_bekerja=workdays($mnt,$thn);
	$sql = "SELECT s.*,k.*,SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))) AS total,TIMEDIFF(SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))),SEC_TO_TIME(TIME_TO_SEC(s.jum_jam_kerja)*$masa_bekerja)) AS beza
	FROM kehadiran k
	LEFT JOIN staff s ON k.nokp_staff=s.noic
	LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
	WHERE DATE_FORMAT(k.created_date,'%m')='$mnt' AND DATE_FORMAT(k.created_date,'%Y')='$thn' 
	AND s.status='BEKERJA' AND k.nokp_staff='$noic'";
	$result = $conn->query($sql);
	return $result->fetch_object()->total;
}
//report kehadiran keseluruhan
function getLaporanKehadiran($bln,$thn,$noic) {
	$conn=db();


	$masa_bekerja=workdays($mnt,$thn);
	$sql = "SELECT s.*,k.*,SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))) AS total,TIMEDIFF(SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))),SEC_TO_TIME(TIME_TO_SEC(s.jum_jam_kerja)*$masa_bekerja)) AS beza, SEC_TO_TIME(TIME_TO_SEC(s.jum_jam_kerja)*$masa_bekerja) AS sasaran
	FROM kehadiran k
	LEFT JOIN staff s ON k.nokp_staff=s.noic
	LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
	WHERE DATE_FORMAT(k.created_date,'%m')='$bln' AND DATE_FORMAT(k.created_date,'%Y')='$thn' AND s.noic='$noic'";
	$result = $conn->query($sql);
	return $result;
}

function getKeseluruhanLaporanKehadiran($bln,$thn,$noic) {
	$conn=db();
	$sql = "SELECT k.id, s.noic,s.name,m.device_masuk,m.device_keluar, m.lokasi_masuk, m.lokasi_keluar, m.remark_keluar, m.masa_masuk, m.masa_keluar, m.remark_masuk,k.created_date, DATE_FORMAT(k.created_date,'%m') AS bulan,
	DATE_FORMAT(k.created_date,'%Y') AS tahun,m.photo_masuk,m.photo_keluar  
	FROM masa_kehadiran m
	LEFT JOIN kehadiran k ON m.id_kehadiran=k.id
	LEFT JOIN staff s ON k.nokp_staff=s.noic
	WHERE DATE_FORMAT(k.created_date,'%m')='$bln' AND DATE_FORMAT(k.created_date,'%Y')='$thn' AND s.noic='$noic'";
	$result = $conn->query($sql);
	return $result;
}


$conn->close();

?>