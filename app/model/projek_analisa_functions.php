<?php

require '../../lib/db/connection.php';
$action=clean($_POST['action']);
if($action=="staff_detail") {
	$search = clean($_POST['search']);
	$conn=db();
	$sql = "SELECT name,noic, no_staff  FROM staff WHERE (name LIKE '%$search%' OR noic LIKE '%$search%' OR no_staff LIKE '%$search%') AND role_id NOT IN ('ADMIN', 'SUPERADMIN') AND status = 'BEKERJA'";
	$result = $conn->query($sql);
	$rows = array();
	while($r = $result->fetch_assoc()) {
		$rows[] = array("value"=>$r['noic'],"label"=>$r['no_staff'].' - '.$r['name']);
		//$rows[] = $r;
	}

	echo json_encode($rows);

}else if($action=="project_detail") {
	$search = clean($_POST['search']);
	$conn=db();
	$sql = "SELECT kod_projek, nama_projek  FROM projek_internal WHERE status_projek = '1' AND (kod_projek LIKE '%$search%' OR nama_projek LIKE '%$search%') AND kod_projek_parent=''";
	$result = $conn->query($sql);
	$rows = array();
	while($r = $result->fetch_assoc()) {
		$rows[] = array("value"=>$r['kod_projek'],"label"=>$r['kod_projek'].' - '.$r['nama_projek']);
		//$rows[] = $r;
	}

	echo json_encode($rows);

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
	$sql = "SELECT s.*,c.name as cname,c.short_name,c.logo as clogo,c.registration_no as cregno,c.address as caddress, c.tel as ctel,c.email as cemail,c.logo_filename AS logo_filename FROM sys_setting s 
	LEFT JOIN company c ON c.sys_id=s.sys_id WHERE s.sys_id='$sys_id'";
	$result = $conn->query($sql);
return $result;
}

function login($username,$password) {
	$conn=db();
	$sql = "SELECT * FROM staff WHERE username='$username' AND accs_pwd='$password'";
	$result = $conn->query($sql);
	return $result;
}

function getProjectByKod($kod_projek) {
	$conn=db();
	$sql = "SELECT * FROM projek_internal WHERE kod_projek='$kod_projek'";
	$result = $conn->query($sql);
	return $result;
}

function getStaffByNoic($noic) {
	$conn=db();
	$sql = "SELECT * FROM staff WHERE noic='$noic' AND status='BEKERJA'";
	$result = $conn->query($sql);
	return $result;
}
function getBilanganProjekDay($date) {
	$conn=db();
	$sql = "SELECT COUNT(kod_projek) AS bil_projek FROM projek_internal 
			WHERE DATE(tarikh_mula)='$date' AND  kod_projek_parent = '' 
			GROUP BY kod_projek";
	$result=$conn->query($sql);
	return "<b><font size='3'>".$result->num_rows."</font></b>";
}

function getBilanganSubProjekDay($date) {
	$conn=db();
	$sql = "SELECT COUNT(kod_projek) AS bil_subprojek FROM projek_internal 
			WHERE DATE(tarikh_mula)='$date' AND  kod_projek_parent != ''";
	$result=$conn->query($sql)->fetch_object()->bil_subprojek;
	return "<b><font size='3'>".$result."</font></b>";
}

function getBilanganProjekWeek($start,$end) {
	$conn=db();
	$sql = "SELECT COUNT(kod_projek) AS bil_projek FROM projek_internal 
			WHERE date_format(tarikh_mula,'%y-%m-%d') BETWEEN DATE_FORMAT('$start','%y-%m-%d') AND DATE_FORMAT('$end','%y-%m-%d') AND kod_projek_parent = '' 
			GROUP BY kod_projek";
	$result=$conn->query($sql);
	return $result->num_rows;
}

function getBilanganSubProjekWeek($start,$end) {
	$conn=db();
	$sql = "SELECT COUNT(kod_projek) AS bil_subprojek FROM projek_internal 
			WHERE date_format(tarikh_mula,'%y-%m-%d') BETWEEN DATE_FORMAT('$start','%y-%m-%d') AND DATE_FORMAT('$end','%y-%m-%d') AND kod_projek_parent != ''";
	$result=$conn->query($sql)->fetch_object()->bil_subprojek;
	return $result;
}

function getBilanganProjekMonth($value) {
 	$conn=db();
 	$sql = "SELECT COUNT(kod_projek) AS bil_projek FROM projek_internal 
			WHERE date_format(tarikh_mula,'%Y%m')='$value' AND kod_projek_parent = ''  
			GROUP BY kod_projek;";
 	$result=$conn->query($sql);
	return $result->num_rows;
}

function getBilanganSubProjekMonth($value) {
 	$conn=db();
 	$sql = "SELECT COUNT(kod_projek) AS bil_subprojek FROM projek_internal 
			WHERE date_format(tarikh_mula,'%Y%m')='$value' AND kod_projek_parent != ''";
 	$result=$conn->query($sql)->fetch_object()->bil_subprojek;
	return $result;
}

function getBilanganProjekYear($value) {
 	$conn=db();
 	$sql = "SELECT COUNT(kod_projek) AS bil_projek FROM projek_internal 
			WHERE date_format(tarikh_mula,'%Y')='$value' AND kod_projek_parent = ''  
			GROUP BY kod_projek";
 	$result=$conn->query($sql);
	return $result->num_rows;
}

function getBilanganSubProjekYear($value) {
 	$conn=db();
 	$sql = "SELECT COUNT(kod_projek) AS bil_subprojek FROM projek_internal 
			WHERE date_format(tarikh_mula,'%Y')='$value' AND kod_projek_parent != ''";
 	$result=$conn->query($sql)->fetch_object()->bil_subprojek;
	return $result;
}

function getBilanganProjekDayStatus($date,$kod_projek,$noic,$id_category) {
	$conn=db();
	$today = date("Y-m-d");
	if($id_category=='TODO'){
		if($today > $date){
			return "<b><font size='3'>0</font></b>";
		}else{
			if($kod_projek == '' && $noic ==''){
			$sql = "SELECT COUNT(pt.id_task) AS bil_task FROM projek_task pt
	                WHERE (DATE_FORMAT('$date','%Y-%m-%d') BETWEEN 
	                        DATE_FORMAT(pt.tarikh_mula,'%Y-%m-%d') AND DATE_FORMAT(pt.tarikh_tamat,'%Y-%m-%d'))
	                AND pt.id_category='$id_category'";
		    }else if ($kod_projek != '') {
		    	$sql = "SELECT COUNT(pri.kod_projek) AS bil_task FROM projek_internal pri
						LEFT JOIN projek_task pt ON pri.kod_projek = pt.kod_projek
						WHERE (DATE_FORMAT('$date','%Y-%m-%d') BETWEEN 
	                        DATE_FORMAT(pt.tarikh_mula,'%Y-%m-%d') AND DATE_FORMAT(pt.tarikh_tamat,'%Y-%m-%d')) AND pt.kod_projek='$kod_projek' AND pri.kod_projek_parent = ''  AND pt.id_category='$id_category'";
		    }else if($noic != ''){
		    	$sql = "SELECT COUNT(pri.kod_projek) AS bil_task FROM projek_internal pri
						LEFT JOIN projek_task pt ON pri.kod_projek = pt.kod_projek
						WHERE (DATE_FORMAT('$date','%Y-%m-%d') BETWEEN 
	                        DATE_FORMAT(pt.tarikh_mula,'%Y-%m-%d') AND DATE_FORMAT(pt.tarikh_tamat,'%Y-%m-%d')) AND pt.assigned_to='$noic' AND pri.kod_projek_parent = ''  AND pt.id_category='$id_category'";
		    }
		}
		
	}else if($id_category=='INPROGRESS'){
		if($today == $date){
			if($kod_projek == '' && $noic ==''){
				$sql = "SELECT COUNT(pt.id_task) AS bil_task FROM projek_task pt
		                WHERE pt.id_category='$id_category'";
		    }else if ($kod_projek != '') {
		    	$sql = "SELECT COUNT(pri.kod_projek) AS bil_task FROM projek_internal pri
						LEFT JOIN projek_task pt ON pri.kod_projek = pt.kod_projek
						WHERE pt.kod_projek='$kod_projek' AND pri.kod_projek_parent = ''  AND pt.id_category='$id_category'";
		    }else if($noic != ''){
		    	$sql = "SELECT COUNT(pri.kod_projek) AS bil_task FROM projek_internal pri
						LEFT JOIN projek_task pt ON pri.kod_projek = pt.kod_projek
						WHERE pt.assigned_to='$noic' AND pri.kod_projek_parent = ''  AND pt.id_category='$id_category'";
		    }
		    $result=$conn->query($sql)->fetch_object()->bil_task;
   			return "<b><font size='3'>".$result."</font></b>";
		}else{
			return "<b><font size='3'>0</font></b>";
		}
		
	}else{
		if($kod_projek == '' && $noic ==''){
			$sql = "SELECT COUNT(pt.id_task) AS bil_task FROM projek_task pt
	                WHERE DATE_FORMAT('$date','%Y-%m-%d') = DATE_FORMAT(pt.tarikh_tamat,'%Y-%m-%d') AND pt.id_category='$id_category'";
	    }else if ($kod_projek != '') {
	    	$sql = "SELECT COUNT(pri.kod_projek) AS bil_task FROM projek_internal pri
					LEFT JOIN projek_task pt ON pri.kod_projek = pt.kod_projek
					WHERE DATE_FORMAT('$date','%Y-%m-%d') = DATE_FORMAT(pt.tarikh_tamat,'%Y-%m-%d') AND pt.kod_projek='$kod_projek' AND pri.kod_projek_parent = ''  AND pt.id_category='$id_category'";
	    }else if($noic != ''){
	    	$sql = "SELECT COUNT(pri.kod_projek) AS bil_task FROM projek_internal pri
					LEFT JOIN projek_task pt ON pri.kod_projek = pt.kod_projek
					WHERE DATE_FORMAT('$date','%Y-%m-%d') = DATE_FORMAT(pt.tarikh_tamat,'%Y-%m-%d') AND pt.assigned_to='$noic' AND pri.kod_projek_parent = ''  AND pt.id_category='$id_category'";
	    }
	}
	$result=$conn->query($sql)->fetch_object()->bil_task;
    return "<b><font size='3'>".$result."</font></b>";
	
}

function getBilanganProjekWeekStatus($start,$end,$kod_projek,$noic,$id_category) {
	$conn=db();
	if($kod_projek == '' && $noic ==''){
		$sql = "SELECT COUNT(pri.kod_projek) AS bil_task FROM projek_internal pri
				LEFT JOIN projek_task pt ON pri.kod_projek = pt.kod_projek
				WHERE (date_format(pt.tarikh_tamat,'%Y-%m-%d') BETWEEN DATE_FORMAT('$start','%Y-%m-%d') AND DATE_FORMAT('$end','%Y-%m-%d')) AND pri.kod_projek_parent = ''  AND pt.id_category='$id_category'";
	}else if($kod_projek != ''){
		$sql = "SELECT COUNT(pri.kod_projek) AS bil_task FROM projek_internal pri
				LEFT JOIN projek_task pt ON pri.kod_projek = pt.kod_projek
				WHERE (date_format(pt.tarikh_tamat,'%Y-%m-%d') BETWEEN DATE_FORMAT('$start','%Y-%m-%d') AND DATE_FORMAT('$end','%Y-%m-%d')) AND pt.kod_projek='$kod_projek' AND pri.kod_projek_parent = '' AND pt.id_category='$id_category'";
	}else if($noic != ''){
		$sql = "SELECT COUNT(pri.kod_projek) AS bil_task FROM projek_internal pri
				LEFT JOIN projek_task pt ON pri.kod_projek = pt.kod_projek
				WHERE (date_format(pt.tarikh_tamat,'%Y-%m-%d') BETWEEN DATE_FORMAT('$start','%Y-%m-%d') AND DATE_FORMAT('$end','%Y-%m-%d')) AND pt.assigned_to='$noic' AND pri.kod_projek_parent = '' AND pt.id_category='$id_category'";
	}
	$result=$conn->query($sql)->fetch_object()->bil_task;
	return "<b><font size='3'>".$result."</font></b>";
}

function getBilanganProjekMonthStatus($value,$kod_projek,$noic,$id_category) {
 	$conn=db();
 	if($kod_projek == '' && $noic ==''){
	 	$sql = "SELECT COUNT(pri.kod_projek) AS bil_task FROM projek_internal pri
				LEFT JOIN projek_task pt ON pri.kod_projek = pt.kod_projek
				WHERE date_format(pt.tarikh_tamat,'%Y%m')='$value' AND pri.kod_projek_parent = '' AND pt.id_category='$id_category'";
	}else if($kod_projek != ''){
		$sql = "SELECT COUNT(pri.kod_projek) AS bil_task FROM projek_internal pri
				LEFT JOIN projek_task pt ON pri.kod_projek = pt.kod_projek
				WHERE date_format(pt.tarikh_tamat,'%Y%m')='$value' AND pt.kod_projek='$kod_projek' AND pri.kod_projek_parent = '' AND pt.id_category='$id_category'";
	}else if($noic != ''){
		$sql = "SELECT COUNT(pri.kod_projek) AS bil_task FROM projek_internal pri
				LEFT JOIN projek_task pt ON pri.kod_projek = pt.kod_projek
				WHERE date_format(pt.tarikh_tamat,'%Y%m')='$value' AND pt.assigned_to='$noic' AND pri.kod_projek_parent = '' AND pt.id_category='$id_category'";
	}
	$result=$conn->query($sql)->fetch_object()->bil_task;
	return "<b><font size='3'>".$result."</font></b>";
}

function getBilanganProjekYearStatus($value,$kod_projek,$noic,$id_category) {
 	$conn=db();
 	if($kod_projek == '' && $noic ==''){
	 	$sql = "SELECT COUNT(pri.kod_projek) AS bil_task FROM projek_internal pri
				LEFT JOIN projek_task pt ON pri.kod_projek = pt.kod_projek
				WHERE date_format(pt.tarikh_tamat,'%Y')='$value' AND pri.kod_projek_parent = '' AND pt.id_category='$id_category'";
	}else if($kod_projek != ''){
		$sql = "SELECT COUNT(pri.kod_projek) AS bil_task FROM projek_internal pri
				LEFT JOIN projek_task pt ON pri.kod_projek = pt.kod_projek
				WHERE date_format(pt.tarikh_tamat,'%Y')='$value' AND pt.kod_projek='$kod_projek' AND pri.kod_projek_parent = '' AND pt.id_category='$id_category'";
	}else if($noic != ''){
		$sql = "SELECT COUNT(pri.kod_projek) AS bil_task FROM projek_internal pri
				LEFT JOIN projek_task pt ON pri.kod_projek = pt.kod_projek
				WHERE date_format(pt.tarikh_tamat,'%Y')='$value' AND pt.assigned_to='$noic' AND pri.kod_projek_parent = '' AND pt.id_category='$id_category'";
	}
	$result=$conn->query($sql)->fetch_object()->bil_task;
	return "<b><font size='3'>".$result."</font></b>";
}

$conn->close();

?>