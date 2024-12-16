<?php

require '../../lib/db/connection.php';

$action = $_POST['action'];
//jejakasnaf pentadbir -start-
if($action == "nyahAktifPentadbir"){
	$id = $_POST['id'];
	$status = $_POST['status'];
	if ($status == '1') {
		$status = '0';
	}
	else {
		$status = '1';
	}
	$conn=db();
	$sql = "UPDATE ja_admin SET status = '$status' 
			WHERE id = '$id'";
	$result = $conn->query($sql);
}
//jejakasnaf pentadbir -end-

//jejakasnaf lookup negeri & daerah -start-
else if($action == "checkDaerah"){
	$kod_negeri = $_POST['kod_negeri'];
	$conn=db();
	$sql = "SELECT kod_daerah,daerah FROM lkp_daerah 
			WHERE kod_negeri = '$kod_negeri'";

	$result = $conn->query($sql);

	$arr = array();

	while( $row = $result->fetch_assoc() ){
	    $kod_daerah = $row['kod_daerah'];
	    $daerah = $row['daerah'];

	    $arr[] = array("kod_daerah" => $kod_daerah, "daerah" => $daerah);
	}

	// encoding array to json format
	echo json_encode($arr);
}
//jejakasnaf lookup negeri & daerah -end-

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
	$sql = "SELECT s.*,c.name as cname,c.short_name,c.logo as clogo,c.registration_no as cregno,c.address as caddress, c.tel as ctel,c.email as cemail,c.logo_filename as clogo2 FROM sys_setting s 
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

//jejakasnaf pentadbir -start-
function getNegeriPentadbir($selected) {
	$conn=db();
	$sql = "SELECT jaa.negeri,ln.id,ln.code,ln.name FROM ja_admin jaa
			LEFT JOIN lkp_negeri ln ON jaa.negeri = ln.code
			WHERE jaa.negeri IS NOT NULL
			GROUP BY jaa.negeri
			ORDER BY ln.id ASC";

	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[3]."</option>";
	}
	//$conn->close();
	return $txt_result;
}

function getDaerahPentadbir($negeri,$selected) {
	$conn=db();
	$sql = "SELECT jaa.daerah,ld.id_daerah,ld.kod_daerah,ld.daerah FROM ja_admin jaa
	 		LEFT JOIN lkp_daerah ld ON jaa.daerah = ld.kod_daerah
	 		WHERE jaa.daerah IS NOT NULL 
	 		AND jaa.negeri = '$negeri'
	 		GROUP BY jaa.daerah
	 		ORDER BY ld.id_daerah ASC";
	
	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[3]."</option>";
	}
	//$conn->close();
	return $txt_result;
}

function getCountPentadbir($jenis_acc,$negeri,$daerah,$status) {
  	$conn=db();
  	if($jenis_acc == ""){
		$condition1 = "";
  	}
  	else{
		$condition1 = "lat.jenis_acc = '$jenis_acc' AND";
  	}
  	
  	if($negeri == '' && $daerah == ''){
	  	$condition2 = "$condition1 jaa.status = '$status'";
  	}
  	else if($negeri != '' && $daerah == ''){
	  $condition2 = "$condition1 jaa.status = '$status' AND jaa.negeri IS NOT NULL AND jaa.negeri = '$negeri'";
  	}
  	else{
	  	$condition2 = "$condition1 jaa.status = '$status' AND jaa.negeri IS NOT NULL AND jaa.negeri = '$negeri' AND jaa.daerah = '$daerah'";
  	}

	$sql = "SELECT COUNT(*) AS count_pentadbir FROM ja_admin jaa
			LEFT JOIN lkp_acc_type lat ON jaa.acc_type = lat.kod_acc
			LEFT JOIN lkp_negeri ln ON jaa.negeri = ln.code
			LEFT JOIN lkp_daerah ld ON jaa.daerah = ld.kod_daerah
			WHERE $condition2";
	$result = $conn->query($sql);
	return $result->fetch_object()->count_pentadbir;
}

function getPentadbirList($negeri,$daerah,$status) {
	$conn=db();
	if($negeri == '' && $daerah == ''){
		$condition = "jaa.status = '$status'";
	}
	else if($negeri != '' && $daerah == ''){
		$condition = "jaa.negeri IS NOT NULL AND jaa.negeri = '$negeri'";
	}
	else{
		$condition = "jaa.negeri IS NOT NULL AND jaa.negeri = '$negeri' AND jaa.daerah = '$daerah'";
	}
	$sql = "SELECT jaa.id,jaa.nama,jaa.notel,jaa.jawatan,jaa.status,lat.jenis_acc,ln.code AS kod_negeri,ln.name AS nama_negeri,ld.kod_daerah AS kod_daerah,ld.daerah AS nama_daerah FROM ja_admin jaa
			LEFT JOIN lkp_acc_type lat ON jaa.acc_type = lat.kod_acc
			LEFT JOIN lkp_negeri ln ON jaa.negeri = ln.code
			LEFT JOIN lkp_daerah ld ON jaa.daerah = ld.kod_daerah
			WHERE $condition
			ORDER BY jaa.id DESC";
	$result = $conn->query($sql);
	return $result;
}

function getPentadbirInfoById($id) {
	$conn = db();
	$sql = "SELECT jaa.id,jaa.nama,jaa.notel,jaa.emel,jaa.id_pengguna,jaa.katalaluan,jaa.jawatan,jaa.acc_type,jaa.negeri,jaa.daerah,jaa.status,lat.jenis_acc,ln.code AS kod_negeri,ln.name AS nama_negeri,ld.kod_daerah AS kod_daerah,ld.daerah AS nama_daerah FROM ja_admin jaa
			LEFT JOIN lkp_acc_type lat ON jaa.acc_type = lat.kod_acc
			LEFT JOIN lkp_negeri ln ON jaa.negeri = ln.code
			LEFT JOIN lkp_daerah ld ON jaa.daerah = ld.kod_daerah
			WHERE jaa.id = '$id'";
	$result = $conn->query($sql);
	return $result;
}

function pentadbirAdd($id,$nama,$notel,$emel,$id_pengguna,$katalaluan,$acc_type,$jawatan,$negeri,$daerah,$status) {
	$conn=db();
	$sql = "INSERT INTO ja_admin (nama,notel,emel,id_pengguna,katalaluan,acc_type,jawatan,negeri,daerah,status)
			VALUES ('$nama','$notel','$emel','$id_pengguna','$katalaluan','$acc_type','$jawatan','$negeri','$daerah','1')";
	$result = $conn->query($sql);
	return $result;
}

function pentadbirEdit($id,$nama,$notel,$emel,$id_pengguna,$katalaluan,$acc_type,$jawatan,$negeri,$daerah){
    $conn = db();
    $sql = "UPDATE ja_admin SET nama = '$nama', notel = '$notel', emel = '$emel', id_pengguna = '$id_pengguna', katalaluan = '$katalaluan', acc_type = '$acc_type', jawatan = '$jawatan', negeri = '$negeri', daerah = '$daerah' WHERE id = '$id'";
    $result = $conn->query($sql);
    return $result; 
}
//jejakasnaf pentadbir -end-

$conn->close();

?>