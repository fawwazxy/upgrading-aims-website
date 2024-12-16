<?php

	require '../../lib/db/connection.php';
    
    $action = $_POST['action'];
    if($action == "addJumlahCetakanById"){
		$id_kad = $_POST['id_kad'];
		$status_cetak = $_POST['status_cetak'];
		$conn=db();
		$sql = "UPDATE pelawat_kad SET status_cetak = (status_cetak + 1) WHERE id_kad = '$id_kad'";
		$result = $conn->query($sql);
	}

	else if($action == "addJumlahCetakanSemua"){
		$conn=db();
		$sql = "UPDATE pelawat_kad SET status_cetak = (status_cetak + 1)";
		$result = $conn->query($sql);
	}

	else if($action == "addJumlahCetakanPilihan"){
		$conn=db();
		$id_kad = $_POST['id_kad'];
		$sql = "UPDATE pelawat_kad SET status_cetak = (status_cetak + 1) WHERE id_kad IN ($id_kad)";
		$result = $conn->query($sql);
	}

	else if($action == "updateStatusKadTidakHilang"){
		$id_lawatan = $_POST['id_lawatan'];
		$conn=db();
		$sql = "UPDATE pelawat_lawatan SET status_kad = '1' WHERE id_lawatan = '$id_lawatan'";
		$result = $conn->query($sql);
	}

	else if($action == "updateStatusKadHilang"){
		$id_lawatan = $_POST['id_lawatan'];
		$conn=db();
		$sql = "UPDATE pelawat_lawatan SET status_kad = '0' WHERE id_lawatan = '$id_lawatan'";
		$result = $conn->query($sql);
	}

	else if($action == "nyahAktifPelawat"){
		$id_pelawat = $_POST['id_pelawat'];
		$status_blacklist = $_POST['status_blacklist'];
		if ($status_blacklist == '1') {
			$status_blacklist = '0';
		}
		else {
			$status_blacklist = '1';
		}
		$conn=db();
		$sql = "UPDATE pelawat set status_blacklist='$status_blacklist' WHERE id_pelawat = '$id_pelawat'";
		$result = $conn->query($sql);
	}

	else if ($action=="getPelawatDetailsByNokp") {
		$nokp = clean($_POST['nokp']);
		$conn=db();
		$sql = "SELECT nama,nokp,notel FROM pelawat
				WHERE nokp='$nokp' GROUP BY nokp";
		$result = $conn->query($sql);
		$rows = array();
		while($r = $result->fetch_assoc()) {
			$rows[] = $r;
		}
		echo json_encode($rows);
		}

	else if ($action=="prosesTambahPelawat") {
		$kod_kad = $_POST['kod_kad'];
	    $nokp = $_POST['nokp'];
	    $nama = $_POST['nama'];
	    $notel = $_POST['notel'];
	    $nama_company = $_POST['nama_company'];
	    $jenis_kenderaan = $_POST['jenis_kenderaan'];
	    $no_kenderaan = $_POST['no_kenderaan'];
	    $nokp_staff = $_POST['nokp_staff'];

	    echo $result = pelawatAdd($nama,$nokp,$notel,$nokp_staff,$nokp_pelawat,$nama_company,$kod_kad,$jenis_kenderaan,$no_kenderaan);
  	}

  	else if($action == "checkStatusKadKeluar"){
	    $kod_kad = $_POST['kod_kad'];
	    $conn=db();
	    $sql = "SELECT COUNT(id_lawatan) AS bil,id_lawatan FROM pelawat_lawatan
	        	WHERE kod_kad = '$kod_kad' AND status_masuk_keluar = '1'";
	    $result = $conn->query($sql);
	    $rows = array();
	    while($r = $result->fetch_assoc()) {
	      $rows[] = $r;
	    }
	    echo json_encode($rows);
	}

	else if($action == "updateStatusKeluarByImbasan"){
		$kod_kad = $_POST['kod_kad'];
		$conn=db();
		$sql = "UPDATE pelawat_lawatan SET tarikh_masa_keluar = CURRENT_TIMESTAMP, status_pengesahan = '1', status_masuk_keluar = '0' 	WHERE kod_kad = '$kod_kad'";
		$result = $conn->query($sql);
	}

	else if($action == "updateStatusKeluarByList"){
		$id_lawatan = $_POST['id_lawatan'];
		$status_masuk_keluar = $_POST['status_masuk_keluar'];
		if ($status_masuk_keluar == '1') {
			$status_masuk_keluar = '0';
		}
		else {
			$status_masuk_keluar = '1';
		}
		$conn=db();
		$sql = "UPDATE pelawat_lawatan SET tarikh_masa_keluar = CURRENT_TIMESTAMP, status_pengesahan = '1', status_masuk_keluar = '$status_masuk_keluar' WHERE id_lawatan = '$id_lawatan'";
		$result = $conn->query($sql);
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
		$sql = "SELECT s.*,c.* FROM sys_setting s 
				LEFT JOIN company c ON c.sys_id = s.sys_id 
				WHERE s.sys_id='$sys_id'";
		$result = $conn->query($sql);
		return $result;
	}

	//pelawat -start-
	function pelawatAdd($nama,$nokp,$notel,$nokp_staff,$nokp_pelawat,$nama_company,$kod_kad,$jenis_kenderaan,$no_kenderaan){
		$conn=db();
		$sql1 = "SELECT COUNT(nokp) AS nokp FROM pelawat WHERE nokp = '$nokp'";
		$checkNokp = $conn->query($sql1)->fetch_object()->nokp;
		if($checkNokp == 0) {
			$sql2 = "INSERT INTO pelawat (nama,nokp,notel) VALUES ('$nama','$nokp','$notel')";
			$result = $conn->query($sql2);
		}
		
		$sql3 = "INSERT INTO pelawat_lawatan (nokp_staff,nokp_pelawat,nama_company,kod_kad,jenis_kenderaan,no_kenderaan)
				VALUES ('$nokp_staff','$nokp','$nama_company','$kod_kad','$jenis_kenderaan','$no_kenderaan')";
		$result = $conn->query($sql3);
		return $result;
	}

	function pelawatEdit($id_lawatan,$nokp_staff,$kod_kad,$jenis_kenderaan,$no_kenderaan){
		$conn=db();
		if($id_lawatan > 0 ) {
			$sql = "UPDATE pelawat_lawatan SET nokp_staff = '$nokp_staff', kod_kad = '$kod_kad', jenis_kenderaan = '$jenis_kenderaan', no_kenderaan = '$no_kenderaan' WHERE id_lawatan = '$id_lawatan'";
		}
		$result = $conn->query($sql);
		return $result;
	}

	function getPelawatList($status_masuk_keluar) {
		$conn=db();
		$sql = "SELECT pl.*,p.*,s.name,s.noic,pk.*,TIMEDIFF(DATE_FORMAT(pl.tarikh_masa_keluar,'%Y-%m-%d %H:%i:%s'),DATE_FORMAT(pl.tarikh_masa_masuk,'%Y-%m-%d %H:%i:%s')) AS jum_masa_lawatan FROM pelawat_lawatan pl
				LEFT JOIN pelawat p ON pl.nokp_pelawat = p.nokp 
				LEFT JOIN staff s ON pl.nokp_staff = s.noic
				LEFT JOIN pelawat_kad pk ON pl.kod_kad = pk.kod_kad
				WHERE pl.status_masuk_keluar = '$status_masuk_keluar' 
				AND s.status = 'BEKERJA'
				ORDER BY pl.id_lawatan DESC";
		$result = $conn->query($sql);
		return $result;
	}

	function getLogMasukPelawatSemasa() {
		$conn=db();
		$sql = "SELECT pl.*,p.* FROM pelawat_lawatan pl
				LEFT JOIN pelawat p ON pl.nokp_pelawat = p.nokp
				WHERE DATE_FORMAT(pl.tarikh_masa_masuk,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')
				GROUP BY p.nokp
				ORDER BY pl.id_lawatan DESC";
		$result = $conn->query($sql);
		return $result;
	}

	function getLogKeluarPelawatSemasa() {
		$conn=db();
		$sql = "SELECT pl.*,p.* FROM pelawat_lawatan pl
				LEFT JOIN pelawat p ON pl.nokp_pelawat = p.nokp
				WHERE DATE_FORMAT(pl.tarikh_masa_keluar,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')
				AND status_masuk_keluar = '0'
				GROUP BY p.nokp
				ORDER BY pl.id_lawatan DESC";
		$result = $conn->query($sql);
		return $result;
	}

	function getPelawatInfoById($id_lawatan) {
		$conn=db();
		$sql = "SELECT pl.*,p.*,s.name,s.noic,pk.*,TIMEDIFF(DATE_FORMAT(pl.tarikh_masa_keluar,'%Y-%m-%d %H:%i:%s'),DATE_FORMAT(pl.tarikh_masa_masuk,'%Y-%m-%d %H:%i:%s')) AS jum_masa_lawatan FROM pelawat_lawatan pl
				LEFT JOIN pelawat p ON pl.nokp_pelawat = p.nokp 
				LEFT JOIN staff s ON pl.nokp_staff = s.noic
				LEFT JOIN pelawat_kad pk ON pl.kod_kad = pk.kod_kad
				WHERE pl.id_lawatan = '$id_lawatan'";
		$result = $conn->query($sql);
		return $result;
	}

	function getPelawatRekodByCurDate() {
		$conn=db();
		$sql = "SELECT pl.*,p.*,s.name,s.noic,pk.*,TIMEDIFF(DATE_FORMAT(pl.tarikh_masa_keluar,'%Y-%m-%d %H:%i:%s'),DATE_FORMAT(pl.tarikh_masa_masuk,'%Y-%m-%d %H:%i:%s')) AS jum_masa_lawatan FROM pelawat_lawatan pl
				LEFT JOIN pelawat p ON pl.nokp_pelawat = p.nokp 
				LEFT JOIN staff s ON pl.nokp_staff = s.noic
				LEFT JOIN pelawat_kad pk ON pl.kod_kad = pk.kod_kad
				WHERE p.status_blacklist = '1' 
				AND s.status = 'BEKERJA'
				AND DATE_FORMAT(pl.tarikh_masa_masuk,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')
				ORDER BY pl.id_lawatan DESC";
		$result = $conn->query($sql);
		return $result;
	}

	function getPelawatRekodByCurWeek() {
		$conn=db();
		$sql = "SELECT pl.*,p.*,s.name,s.noic,pk.*,TIMEDIFF(DATE_FORMAT(pl.tarikh_masa_keluar,'%Y-%m-%d %H:%i:%s'),DATE_FORMAT(pl.tarikh_masa_masuk,'%Y-%m-%d %H:%i:%s')) AS jum_masa_lawatan FROM pelawat_lawatan pl
				LEFT JOIN pelawat p ON pl.nokp_pelawat = p.nokp 
				LEFT JOIN staff s ON pl.nokp_staff = s.noic
				LEFT JOIN pelawat_kad pk ON pl.kod_kad = pk.kod_kad
				WHERE p.status_blacklist = '1' 
				AND s.status = 'BEKERJA'
				AND DATE_FORMAT(pl.tarikh_masa_masuk,'%V') = DATE_FORMAT(CURRENT_TIMESTAMP,'%V')
				ORDER BY pl.id_lawatan DESC";
		$result = $conn->query($sql);
		return $result;
	}

	function getPelawatRekodByCurMonth() {
		$conn=db();
		$sql = "SELECT pl.*,p.*,s.name,s.noic,pk.*,TIMEDIFF(DATE_FORMAT(pl.tarikh_masa_keluar,'%Y-%m-%d %H:%i:%s'),DATE_FORMAT(pl.tarikh_masa_masuk,'%Y-%m-%d %H:%i:%s')) AS jum_masa_lawatan FROM pelawat_lawatan pl
				LEFT JOIN pelawat p ON pl.nokp_pelawat = p.nokp 
				LEFT JOIN staff s ON pl.nokp_staff = s.noic
				LEFT JOIN pelawat_kad pk ON pl.kod_kad = pk.kod_kad
				WHERE p.status_blacklist = '1' 
				AND s.status = 'BEKERJA'
				AND DATE_FORMAT(pl.tarikh_masa_masuk,'%Y-%m') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')
				ORDER BY pl.id_lawatan DESC";
		$result = $conn->query($sql);
		return $result;
	}

	function getPelawatRekodByCurYear() {
		$conn=db();
		$sql = "SELECT pl.*,p.*,s.name,s.noic,pk.*,TIMEDIFF(DATE_FORMAT(pl.tarikh_masa_keluar,'%Y-%m-%d %H:%i:%s'),DATE_FORMAT(pl.tarikh_masa_masuk,'%Y-%m-%d %H:%i:%s')) AS jum_masa_lawatan FROM pelawat_lawatan pl
				LEFT JOIN pelawat p ON pl.nokp_pelawat = p.nokp 
				LEFT JOIN staff s ON pl.nokp_staff = s.noic
				LEFT JOIN pelawat_kad pk ON pl.kod_kad = pk.kod_kad
				WHERE p.status_blacklist = '1' 
				AND s.status = 'BEKERJA'
				AND DATE_FORMAT(pl.tarikh_masa_masuk,'%Y') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')
				ORDER BY pl.id_lawatan DESC";
		$result = $conn->query($sql);
		return $result;
	}

	function getPelawatRekod($status_blacklist) {
		$conn=db();
		$sql = "SELECT pl.*,p.*,s.name,s.noic,pk.*,TIMEDIFF(DATE_FORMAT(pl.tarikh_masa_keluar,'%Y-%m-%d %H:%i:%s'),DATE_FORMAT(pl.tarikh_masa_masuk,'%Y-%m-%d %H:%i:%s')) AS jum_masa_lawatan FROM pelawat_lawatan pl
				LEFT JOIN pelawat p ON pl.nokp_pelawat = p.nokp 
				LEFT JOIN staff s ON pl.nokp_staff = s.noic
				LEFT JOIN pelawat_kad pk ON pl.kod_kad = pk.kod_kad
				WHERE status_blacklist = '$status_blacklist' 
				AND s.status = 'BEKERJA'
				AND DATE_FORMAT(pl.tarikh_masa_masuk,'%Y') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')
				ORDER BY pl.id_lawatan DESC";
		$result = $conn->query($sql);
		return $result;
	}
	//pelawat -end-

	//kad pelawat -start-
	function kadPelawatAddEdit($id_kad,$kod_kad,$jenis_kad,$nama_kad){
		$conn=db();
		$sql = "INSERT INTO pelawat_kad (kod_kad,jenis_kad,nama_kad) VALUES ('$kod_kad','$jenis_kad','$nama_kad')";
		if($id_kad > 0){
			$sql = "UPDATE pelawat_kad SET jenis_kad = '$jenis_kad', nama_kad = '$nama_kad' WHERE id_kad = '$id_kad' ";
		}
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	function getMaxKodKad() {
		$conn=db();
		$sql = "SELECT IFNULL((max(id_kad)+1),1) AS kod_kad FROM pelawat_kad";
		$result = $conn->query($sql) or die($conn->error);
		return 'PELAWAT-'.$result->fetch_object()->kod_kad;
	}

	function getKadPelawatList() {
		$conn=db();
		$sql = "SELECT * FROM pelawat_kad
				ORDER BY id_kad DESC";
		$result = $conn->query($sql);
		return $result;
	}

	function getKadPelawatInfoById($id_kad) {
		$conn=db();
		$sql = "SELECT * FROM pelawat_kad WHERE id_kad='$id_kad'";
		$result = $conn->query($sql);
		return $result;
	}

	function getKadPelawatCetakanSemua() {
		$conn=db();
		$sql = "SELECT * FROM pelawat_kad
				ORDER BY id_kad ASC";
		$result = $conn->query($sql);
		return $result;
	}

	function getKadPelawatCetakanPilihan($id_kad){
		$conn=db();
		$sql = "SELECT * FROM pelawat_kad
				WHERE id_kad IN ($id_kad)
				ORDER BY id_kad ASC";
		$result = $conn->query($sql);
		return $result;
	}

	function getKadPelawatCetakanById($id_kad) {
		$conn=db();
		$sql = "SELECT * FROM pelawat_kad
				WHERE id_kad = '$id_kad'";
		$result = $conn->query($sql);
		return $result;
	}
	//kad pelawat -end-

	//analisa pelawat -start-
	function getCountPelawatByCurDate() {
		$conn = db();
		$sql = "SELECT COUNT(*) AS pelawat_curdate FROM pelawat_lawatan pl
				LEFT JOIN pelawat p ON pl.nokp_pelawat = p.nokp
				WHERE DATE_FORMAT(pl.tarikh_masa_masuk,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')
				AND p.status_blacklist = '1'";
		$result = $conn->query($sql) or die($conn->error);
		return $result->fetch_object()->pelawat_curdate;
	}
	function getCountPelawatByCurWeek() {
		$conn = db();
		$sql = "SELECT COUNT(*) AS pelawat_curweek FROM pelawat_lawatan pl
				LEFT JOIN pelawat p ON pl.nokp_pelawat = p.nokp
				WHERE DATE_FORMAT(pl.tarikh_masa_masuk,'%V') = DATE_FORMAT(CURRENT_TIMESTAMP,'%V')
				AND p.status_blacklist = '1'";
		$result = $conn->query($sql) or die($conn->error);
		return $result->fetch_object()->pelawat_curweek;
	}
	function getCountPelawatByCurMonth() {
		$conn = db();
		$sql = "SELECT COUNT(*) AS pelawat_curmonth FROM pelawat_lawatan pl
				LEFT JOIN pelawat p ON pl.nokp_pelawat = p.nokp
				WHERE DATE_FORMAT(pl.tarikh_masa_masuk,'%Y-%m') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')
				AND p.status_blacklist = '1'";
		$result = $conn->query($sql) or die($conn->error);
		return $result->fetch_object()->pelawat_curmonth;
	}
	function getCountPelawatByCurYear() {
		$conn = db();
		$sql = "SELECT COUNT(*) AS pelawat_curyear FROM pelawat_lawatan pl
				LEFT JOIN pelawat p ON pl.nokp_pelawat = p.nokp
				WHERE DATE_FORMAT(pl.tarikh_masa_masuk,'%Y') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')
				AND p.status_blacklist = '1'";
		$result = $conn->query($sql) or die($conn->error);
		return $result->fetch_object()->pelawat_curyear;
	}
	//analisa pelawat -end-

	//staff -start-
	function getStaffList() {
		$conn=db();
		$sql = "SELECT * FROM staff WHERE noic != '' 
				AND status = 'BEKERJA'
				ORDER BY id ASC";
		$result = $conn->query($sql);
		return $result;
	}

	function getDropDownStaff($selected) {
      	$conn=db();
      	$sql = "SELECT noic, CONCAT(noic,' - ',name) FROM staff WHERE role_id NOT IN ('ADMIN', 'SUPERADMIN') AND status = 'BEKERJA' ORDER BY name";
      	$result = $conn->query($sql);
      
      	$txt_result="";
      		while ($row  = $result -> fetch_array()){
        	$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
      	}
      //$conn->close();
      return $txt_result;
    }
	//staff - end-
	
	$conn->close();
	
?>