<?php

require '../../lib/db/connection.php';

$action = $_POST['action'];
//lookup kategori umur (add,update,delete)
    if($action == "kategoriUmurAddEdit"){
		$kod = $_POST['kod'];
		$umur_mula = $_POST['umur_mula'];
		$umur_tamat = $_POST['umur_tamat'];
		$keterangan = $_POST['keterangan'];
		$id = $_POST['id'];

		$conn=db();
		if($id > 0 ){
			$sql = "UPDATE ahli_kategori_umur SET kod = '$kod', umur_mula = '$umur_mula', umur_tamat = '$umur_tamat', keterangan = '$keterangan' WHERE id = '$id'";
			$result = $conn->query($sql) or die($conn->error);
			echo "Data berjaya dikemaskini";
		}else{
			$sql = "INSERT INTO ahli_kategori_umur (kod,umur_mula,umur_tamat,keterangan) VALUES ('$kod','$umur_mula','$umur_tamat','$keterangan')";
			$result = $conn->query($sql) or die($conn->error);
			echo "Data berjaya ditambah";
		}
	}

	else if($action == "nyahAktifKategoriUmur"){
		$id = $_POST['id'];
		$status = $_POST['status'];
		if ($status == '1') {
			$status = '0';
		}
		else {
			$status = '1';
		}
		$conn=db();
		$sql = "UPDATE ahli_kategori_umur SET status='$status' WHERE id = '$id'";
		$result = $conn->query($sql);
	}

//lookup galur (add,update,delete)
    else if($action == "galurAddEdit"){
		$kod = $_POST['kod'];
		$nama_galur = $_POST['nama_galur'];
		$id = $_POST['id'];

		$conn=db();
		if($id > 0 ){
			$sql = "UPDATE ahli_lkp_galur SET kod = '$kod', nama_galur = '$nama_galur' WHERE id = '$id'";
			$result = $conn->query($sql) or die($conn->error);
			echo "Data berjaya dikemaskini";
		}else{
			$sql = "INSERT INTO ahli_lkp_galur (kod,nama_galur) VALUES ('$kod','$nama_galur')";
			$result = $conn->query($sql) or die($conn->error);
			echo "Data berjaya ditambah";
		}
	}

	else if($action == "nyahAktifGalur"){
		$id = $_POST['id'];
		$status = $_POST['status'];
		if ($status == '1') {
			$status = '0';
		}
		else {
			$status = '1';
		}
		$conn=db();
		$sql = "UPDATE ahli_lkp_galur SET status='$status' WHERE id = '$id'";
		$result = $conn->query($sql);
	}
	//lookup asnaf (add,update,delete)
    else if($action == "asnafAddEdit"){
		$jenis_asnaf = $_POST['jenis_asnaf'];
		$id = $_POST['id'];

		$conn=db();
		if($id > 0 ){
			$sql = "UPDATE ahli_lkp_asnaf SET jenis_asnaf = '$jenis_asnaf' WHERE id = '$id'";
			$result = $conn->query($sql) or die($conn->error);
			echo "Data berjaya dikemaskini";
		}else{
			$sql = "INSERT INTO ahli_lkp_asnaf (jenis_asnaf) VALUES ('$jenis_asnaf')";
			$result = $conn->query($sql) or die($conn->error);
			echo "Data berjaya ditambah";
		}
	}

	else if($action == "nyahAktifAsnaf"){
		$id = $_POST['id'];
		$status = $_POST['status'];
		if ($status == '1') {
			$status = '0';
		}
		else {
			$status = '1';
		}
		$conn=db();
		$sql = "UPDATE ahli_lkp_asnaf SET status_asnaf='$status' WHERE id = '$id'";
		$result = $conn->query($sql);
	}
	//end
	else if($action == "tetapanAdmin"){
		$id = $_POST['id'];
		$status = $_POST['status'];
		
		$conn=db();
		$sql = "UPDATE ahli_users SET role='$status' WHERE id = '$id'";
		$result = $conn->query($sql);
	}
	else if($action == "updateStatusPengumuman"){
		$id = $_POST['id'];
		$status = $_POST['status'];
		
		$conn=db();
		$sql = "UPDATE ahli_pengumuman SET status='$status' WHERE id = '$id'";
		$result = $conn->query($sql);
	}
	else if($action == "nyahAktifAhli"){
		$id = $_POST['id'];
		$status = $_POST['status'];
		if ($status == '1') {
			$status = '0';
		}
		else {
			$status = '1';
		}
		
		$conn=db();
		$sql = "UPDATE ahli_users SET status='$status' WHERE id = '$id'";
		$result = $conn->query($sql);
	}
	else if($action == "delAhli"){
		$id = $_POST['id'];
		
		$conn=db();
		$sql = "DELETE FROM ahli_users WHERE id = '$id'";
		$result = $conn->query($sql);
	}

//lookup status keahlian (add,update,delete)
    else if($action == "statusKeahlianAddEdit"){
		$kod = $_POST['kod'];
		$keterangan = $_POST['keterangan'];
		$yuran = $_POST['yuran'];
		$id = $_POST['id'];

		$conn=db();
		if($id > 0 ){
			$sql = "UPDATE ahli_status_ahli SET kod = '$kod', keterangan = '$keterangan', yuran = '$yuran' WHERE id = '$id'";
			$result = $conn->query($sql) or die($conn->error);
			echo "Data berjaya dikemaskini";
		}else{
			$sql = "INSERT INTO ahli_status_ahli (kod,keterangan,yuran) VALUES ('$kod','$keterangan','$yuran')";
			$result = $conn->query($sql) or die($conn->error);
			echo "Data berjaya ditambah";
		}
	}

	else if($action == "nyahAktifStatusKeahlian"){
		$id = $_POST['id'];
		$status = $_POST['status'];
		if ($status == '1') {
			$status = '0';
		}
		else {
			$status = '1';
		}
		$conn=db();
		$sql = "UPDATE ahli_status_ahli SET status='$status' WHERE id = '$id'";
		$result = $conn->query($sql);
	}

//lookup kelab/persatuan
	else if($action == "nyahAktifKelabPersatuan"){
		$id = $_POST['id'];
		$status = $_POST['status'];
		if ($status == '1') {
			$status = '0';
		}
		else {
			$status = '1';
		}
		$conn=db();
		$sql = "UPDATE ahli_kelab_persatuan SET status='$status' WHERE id = '$id'";
		$result = $conn->query($sql);
	}
	else if($action == "checkDaerah"){

		$kod_negeri = $_POST['kod_negeri'];
		$conn=db();
		$sql = "SELECT kod_daerah,daerah FROM lkp_daerah WHERE kod_negeri='$kod_negeri'";

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

	//lookup khairat (add,update,delete)
    else if($action == "khairatAddEdit"){
		$jumlah_kutipan = $_POST['jumlah_kutipan'];
		$jumlah_biaya = $_POST['jumlah_biaya'];
		$id = $_POST['id'];

		$conn=db();
		if($id > 0 ){
			$sql = "UPDATE ahli_lkp_khairat SET jumlah_kutipan = '$jumlah_kutipan',jumlah_biaya='$jumlah_biaya' WHERE id = '$id'";
			$result = $conn->query($sql) or die($conn->error);
			echo "Data berjaya dikemaskini";
		}else{
			$sql = "INSERT INTO ahli_lkp_khairat (jumlah_kutipan,jumlah_biaya) VALUES ('$jumlah_kutipan','$jumlah_biaya')";
			$result = $conn->query($sql) or die($conn->error);
			echo "Data berjaya ditambah";
		}
	}
	else if($action == "searchAhli"){//padam penceramah
		$search = $_POST['search'];
		$conn=db();
		$sql = "SELECT nokp,CONCAT(nokp,' - ',nama) AS label FROM ahli_users WHERE ( nama like '%".$search."%' OR nokp like '%".$search."%' ) AND status_ahli NOT IN('BD')  ORDER BY nama ASC LIMIT 5 ";
		$result = $conn->query($sql) or die($conn->error);
		$response = array();
		 while($row = $result->fetch_assoc() ){
	        $response[] = array("value"=>$row['nokp'],"label"=>$row['label']);
	    }

		 echo json_encode($response);

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

function getAhli($statact) {
	$conn=db();
	$sql = "SELECT ak.*,aku.keterangan,alg.nama_galur,n.name,asa.keterangan AS kategori_ahli,asa.yuran FROM ahli_users ak
			LEFT JOIN ahli_kategori_umur aku ON aku.kod=ak.kategori_umur
			LEFT JOIN ahli_status_ahli asa ON asa.kod=ak.status_ahli
			LEFT JOIN ahli_lkp_galur alg ON alg.kod=ak.galur
			LEFT JOIN lkp_negeri n ON n.code=ak.negeri
			WHERE status_ahli='$statact'
			ORDER BY ak.nama ASC";
	$result = $conn->query($sql);
	return $result;
}

function getStatusAhli() {
	$conn=db();
	$sql = "SELECT * FROM ahli_status_ahli WHERE status='1' ORDER BY id ASC";
	$result = $conn->query($sql);
	return $result;
}
function getMenuStatusAhli() {
	$conn=db();
	$sql = "SELECT * FROM ahli_status_ahli WHERE status='1' ORDER BY id DESC";
	$result = $conn->query($sql);
	return $result;
}

function getAhliById($id) { 
	$conn=db();
	$sql = "SELECT * FROM ahli_users
			WHERE id='$id'";
	$result = $conn->query($sql);
	return $result;
}

function AhliAddEdit($id,$nama,$nokp,$notel,$gps_koordinat,$kategori_umur,$galur,$alamat,$negeri,$role,$password,$photo_filename,$nama_panggilan,$daerah,$asnaf,$anak_yatim,$oku,$nota) {
	$conn=db();
	 	$gambar = '';
        $gambar_val = '';
        $gambar_update = '';
        $asnaf_column='';
        $asnaf_value='';
        $asnaf_update='';


        if($asnaf!="" && $photo_filename == ""){
        	$asnaf_column=" ,asnaf";
            $asnaf_value=",'$asnaf'";
             $asnaf_update=" ,asnaf='$asnaf'";
        }else if($asnaf!="" && $photo_filename != ""){
        	$asnaf_column=" ,asnaf,";
            $asnaf_value=",'$asnaf',";
             $asnaf_update=" ,asnaf='$asnaf',";
        }

        if($photo_filename != ""){
            $gambar=" ,photo_filename";
            $gambar_val=",'$photo_filename'";
             $gambar_update=" ,photo_filename='$photo_filename' "; 
        }

	if($id == "0"){
		$sql1="SELECT id FROM ahli_users WHERE nokp='$nokp'";
			 $checkIfExist = $conn->query($sql1);
			 if($checkIfExist->num_rows == 0){
				echo $sql = "INSERT INTO ahli_users (nama,nokp,notel,gps_koordinat,kategori_umur,galur,alamat,negeri,status_ahli,password,nama_panggilan,daerah,anak_yatim,oku,nota$asnaf_column$gambar)
						VALUES ('$nama','$nokp','$notel','$gps_koordinat','$kategori_umur','$galur','$alamat','$negeri','BD','$nokp','$nama_panggilan','$daerah','$anak_yatim','$oku','$nota'$asnaf_value$gambar_val)";
				$result = $conn->query($sql);
				return "add";
				}else{
					return "exist";
				}
	}else{
		$sql = "UPDATE ahli_users SET nama='$nama',nokp='$nokp',notel='$notel',gps_koordinat='$gps_koordinat',kategori_umur='$kategori_umur',galur='$galur',alamat='$alamat',negeri='$negeri',role='$role',password='$password',nama_panggilan='$nama_panggilan',daerah='$daerah',anak_yatim='$anak_yatim',oku='$oku',nota='$nota'$asnaf_update$gambar_update WHERE id='$id'";

		$result = $conn->query($sql);
		return "update";
	}
	
	
}

function getDropDownStatusAhli($selected) {
	$conn=db();
	$sql = "SELECT kod,keterangan FROM ahli_status_ahli WHERE kod NOT IN('BD') AND status='1'";
				
	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
	}
	//$conn->close();
	return $txt_result;
}

function getDropDownKategoriUmur($selected) {
	$conn=db();
	$sql = "SELECT kod, CONCAT(umur_mula,' Tahun - ',umur_tamat,' Tahun') FROM ahli_kategori_umur WHERE status='1'";
				
	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
	}
	//$conn->close();
	return $txt_result;
}

function getNo_Ahli() {
	$conn=db();
	
	$sql= " SELECT LPAD(running_no, 6, '0') AS running_no FROM running_no WHERE reference='no_ahli'";
	$run_no = $conn->query($sql)->fetch_object()->running_no ;
	//update running no
	return $run_no;
}

function daftarAhli($id,$status_ahli,$no_ahli) {
	$conn=db();
	$sqlcheck="SELECT * FROM ahli_users WHERE no_ahli='$no_ahli'";
	$check = $conn->query($sqlcheck);
	if($check->num_rows>0){
		$sql = "UPDATE ahli_users SET status_ahli='$status_ahli' WHERE id='$id'";
		$result = $conn->query($sql);
	}else{
	$sql = "UPDATE ahli_users SET status_ahli='$status_ahli',no_ahli='$no_ahli'  WHERE id='$id'";
	$result = $conn->query($sql);
	$sql = "UPDATE running_no SET running_no=running_no+1 WHERE reference='no_ahli'";
	$running_no = $conn->query($sql);
	}
	return $result;
}

function getMaklumatYuran($id) {
	$conn=db();

	$sql = "SELECT ak.*,asa.yuran,IFNULL(SUM(ary.jum_yuran),'0') AS jum_bayaran,(asa.yuran-IFNULL(SUM(ary.jum_yuran),'0')) AS jum_belum_bayar FROM ahli_users ak
			LEFT JOIN ahli_status_ahli asa ON asa.kod=ak.status_ahli
			LEFT JOIN ahli_rekod_yuran ary ON ary.nokp_ahli=ak.nokp
			WHERE ak.id='$id'";
	$result = $conn->query($sql);
	return $result;
}

function addYuranAhli($id_yuran,$nokp_ahli,$jenis_ahli,$jum_yuran,$jenis_bayaran,$no_rujukkan) {
	$conn=db();
	if($id_yuran==""){
		$sql = "INSERT INTO ahli_rekod_yuran (tahun,nokp_ahli,jenis_ahli,jum_yuran,jenis_bayaran,no_rujukkan)
				VALUES (YEAR(NOW()),'$nokp_ahli','$jenis_ahli','$jum_yuran','$jenis_bayaran','$no_rujukkan')";
		$result = $conn->query($sql);
		return "tambah";
	}else{
		$sql = "UPDATE ahli_rekod_yuran SET jum_yuran='$jum_yuran', jenis_bayaran='$jenis_bayaran', no_rujukkan='$no_rujukkan' WHERE id='$id_yuran'";
		$result = $conn->query($sql);
		return "update";

	}
	
}

function getStatusYuran($nokp,$jenis_ahli) {
	$conn=db();
	$tahun="";
	if($jenis_ahli=="AB"){
		$tahun="AND tahun=YEAR(NOW())";
	}
	$sql = "SELECT *,SUM(jum_yuran) AS jum_bayaran FROM ahli_rekod_yuran WHERE nokp_ahli='$nokp' $tahun";
	$result = $conn->query($sql);
	return $result;
}

function getSenaraiBayaranYuran($tahun) {
	$conn=db();
	$sql = "SELECT ak.*,aku.keterangan,alg.nama_galur,n.name,ary.id AS id_yuran,ary.jum_yuran,ary.jenis_bayaran,ary.no_rujukkan,ary.created_date,asa.keterangan AS kategori_ahli FROM ahli_rekod_yuran ary
				LEFT JOIN ahli_users ak ON ak.nokp=ary.nokp_ahli
				LEFT JOIN ahli_kategori_umur aku ON aku.kod=ak.kategori_umur
				LEFT JOIN ahli_lkp_galur alg ON alg.kod=ak.galur
				LEFT JOIN lkp_negeri n ON n.code=ak.negeri
				LEFT JOIN ahli_status_ahli asa ON asa.kod=ary.jenis_ahli
				WHERE ary.tahun='$tahun'
				ORDER BY ary.created_date DESC";
	$result = $conn->query($sql);
	return $result;
}
function getMaklumatYuranByIdYuran($id) {
	$conn=db();
	$sql = "SELECT ak.*,asa.yuran,ary.tahun,ary.id AS id_yuran,ary.jum_yuran,ary.jenis_bayaran,ary.no_rujukkan,asa.keterangan AS kategori_ahli,ary.created_date AS tarikh_bayaran FROM ahli_rekod_yuran ary
				LEFT JOIN ahli_users ak ON ak.nokp=ary.nokp_ahli
				LEFT JOIN ahli_status_ahli asa ON asa.kod=ary.jenis_ahli
				WHERE ary.id='$id'
				ORDER BY ak.nama ASC";
	$result = $conn->query($sql);
	return $result;
}

//lookup kategori umur -start-
	function getKategoriUmurList() {
		$conn=db();
		$sql = "SELECT * FROM ahli_kategori_umur ORDER BY id ASC";
		$result = $conn->query($sql);
		return $result;
	}	
//lookup kategori umur -end-

//lookup galur -start-
	function getGalurList() {
		$conn=db();
		$sql = "SELECT * FROM ahli_lkp_galur ORDER BY id ASC";
		$result = $conn->query($sql);
		return $result;
	}	
//lookup galur -end-


//lookup status keahlian -start-
	function getStatusKeahlianList() {
		$conn=db();
		$sql = "SELECT * FROM ahli_status_ahli ORDER BY id ASC";
		$result = $conn->query($sql);
		return $result;
	}	
//lookup status keahlian -end-

//lookup kelab/persatuan -start-
	function kelabPersatuanAdd($nama,$alamat,$tel,$email,$nama_pengerusi,$status,$nama_bank,$no_akaun,$logo,$logo_filename){
    $conn=db();
     $gambar = '';
        $gambar_val = '';

        if($logo_filename != ""){
            $gambar=" ,logo,logo_filename";
            $gambar_val=",'$logo','$logo_filename'";
        }

    $sql = "INSERT INTO ahli_kelab_persatuan (nama,alamat,tel,email,nama_pengerusi,status,nama_bank,no_akaun$gambar)
        VALUES ('$nama','$alamat','$tel','$email','$nama_pengerusi','1','$nama_bank','$no_akaun'$gambar_val)";
    $result = $conn->query($sql)or die($conn->error);
    return $result;
  }

  function kelabPersatuanEdit($id,$nama,$alamat,$tel,$email,$nama_pengerusi,$nama_bank,$no_akaun,$logo,$logo_filename){
        $conn=db();
        $sql = "UPDATE ahli_kelab_persatuan SET nama = '$nama', alamat = '$alamat', tel = '$tel', email = '$email', nama_pengerusi = '$nama_pengerusi', nama_bank = '$nama_bank', no_akaun = '$no_akaun'";

        if($logo_filename != ""){
            $sql.=" ,logo='$logo',logo_filename='$logo_filename' "; 
        }
        
        $sql.="  WHERE id='$id'";
        $result=$conn->query($sql) or die($conn->error);
        return $result; 
    }

	function getKelabPersatuanList() {
		$conn=db();
		$sql = "SELECT * FROM ahli_kelab_persatuan ORDER BY id DESC";
		$result = $conn->query($sql);
		return $result;
	}	

	function getKelabPersatuanInfoById($id) {
		$conn=db();
		$sql = "SELECT * FROM ahli_kelab_persatuan WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getAhliKelabPersatuanInfo() {
		$conn=db();
		$sql = "SELECT * FROM ahli_kelab_persatuan";
		$result = $conn->query($sql);
		return $result;
	}
//lookup kelab/persatuan -end-
//analisa start
	function getBilAhliBYStatus($kod) {
			$conn=db();
			$sql = "SELECT COUNT(*) AS bil FROM ahli_users
					WHERE status_ahli='$kod'";
			$result = $conn->query($sql);
			return $result->fetch_object()->bil;
	}
	function getKategoriUmur() {
			$conn=db();
			$sql = "SELECT *, CONCAT(umur_mula,' Tahun - ',umur_tamat,' Tahun') AS ahli_kategori FROM ahli_kategori_umur WHERE status='1'";
			$result = $conn->query($sql);
			return $result;
	}
	function getGalur() {
			$conn=db();
			$sql = "SELECT * FROM ahli_lkp_galur WHERE status='1'";
			$result = $conn->query($sql);
			return $result;
	}
	function getBilAhliBYStatusAndUmur($kod,$kategori_umur) {
			$conn=db();
			$sql = "SELECT COUNT(*) AS bil FROM ahli_users
					WHERE status_ahli='$kod' AND kategori_umur='$kategori_umur'";
			$result = $conn->query($sql);
			return $result->fetch_object()->bil;
	}
	function getBilAhliBYStatusAndGalur($kod,$galur) {
			$conn=db();
			$sql = "SELECT COUNT(*) AS bil FROM ahli_users
					WHERE status_ahli='$kod' AND galur='$galur'";
			$result = $conn->query($sql);
			return $result->fetch_object()->bil;
	}
	function getYuran($kod) {
			$conn=db();
			$sql = "SELECT yuran FROM ahli_status_ahli
					WHERE kod='$kod'";
			$result = $conn->query($sql);
			return $result->fetch_object()->yuran;
	}
	function getBayaranYuran($kod) {
			$conn=db();
			$sql = "SELECT SUM(jum_yuran) AS jumlah FROM ahli_rekod_yuran
					WHERE jenis_ahli='$kod' AND tahun=YEAR(NOW())";
			$result = $conn->query($sql);
			return $result->fetch_object()->jumlah;
	}
	function getBulanYuran($tahun) {
			$conn=db();
			$sql = "SELECT MONTH(created_date)AS bulan FROM ahli_rekod_yuran
					WHERE YEAR(created_date)='$tahun'
					GROUP BY bulan
					ORDER BY bulan DESC";
			$result = $conn->query($sql);
			return $result;
	}
	function getBayaranYuranByMonth($kod,$bulan) {
			$conn=db();
			$sql = "SELECT SUM(jum_yuran) AS jumlah FROM ahli_rekod_yuran
					WHERE jenis_ahli='$kod' AND tahun=YEAR(NOW()) AND MONTH(created_date)='$bulan'";
			$result = $conn->query($sql);
			return $result->fetch_object()->jumlah;
	}
	function getPenyataKutipanByMonth($bulan,$tahun) {
			$conn=db();
			$sql = "SELECT au.nama,au.no_ahli,ar.jum_yuran,ar.jenis_ahli,DATE_FORMAT(ar.created_date,'%d %b %Y') AS tarikh_bayar FROM ahli_rekod_yuran ar
				LEFT JOIN ahli_users au ON au.nokp=ar.nokp_ahli
				WHERE MONTH(ar.created_date)='$bulan' AND YEAR(ar.created_date)='$tahun'";
			$result = $conn->query($sql);
			return $result;
	}
	function getBayaranYuranKeseluruhan($tahun) {
			$conn=db();
			$condition="";
			if($tahun!=""){
				$condition="WHERE YEAR(created_date)='$tahun'";
			}
			$sql = "SELECT SUM(jum_yuran) AS jumlah FROM ahli_rekod_yuran
					$condition";
			$result = $conn->query($sql);
			return $result->fetch_object()->jumlah;
	}
	function addAhliExcel($nama,$nokp,$notel) {
			$conn=db();
			 $sql1="SELECT id FROM ahli_users WHERE nokp='$nokp'";
			 $checkIfExist = $conn->query($sql1);
			 if($checkIfExist->num_rows == 0){
     
			$sql = "INSERT INTO ahli_users (nama,nokp,notel,status_ahli,password)
					VALUES ('$nama','$nokp','$notel','BD','$nokp')";
			$result = $conn->query($sql) ;
			return $result;
		}else{
			return 0;
		}
	}
	function getDropDownTahun($selected) { 
	$conn=db();
	$sql = "SELECT tahun FROM ahli_rekod_yuran
			GROUP BY tahun
			ORDER BY tahun DESC";
				
	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
	}
	//$conn->close();
	return $txt_result;
}
function daftarAhliOnline($nama,$nokp,$notel,$gps_koordinat,$kategori_umur,$galur,$alamat,$negeri,$photo_filename) {
	$conn=db();
	 	$gambar = '';
        $gambar_val = '';

        if($photo_filename != ""){
            $gambar=" ,photo_filename";
           $gambar_val=",'$photo_filename'";
        }

		$sql1="SELECT id FROM ahli_users WHERE nokp='$nokp'";
			 $checkIfExist = $conn->query($sql1);
			 if($checkIfExist->num_rows == 0){
				$sql = "INSERT INTO ahli_users (nama,nokp,notel,gps_koordinat,kategori_umur,galur,alamat,negeri,status_ahli,password$gambar)
						VALUES ('$nama','$nokp','$notel','$gps_koordinat','$kategori_umur','$galur','$alamat','$negeri','BD','$nokp'$gambar_val)";
				$result = $conn->query($sql);
				return "add";
				}else{
					return "exist";
				}
	
	
	
}
function getAhliTetapanAdmin() {
	$conn=db();
	$sql = "SELECT ak.*,aku.keterangan,alg.nama_galur,n.name,asa.keterangan AS kategori_ahli,asa.yuran FROM ahli_users ak
			LEFT JOIN ahli_kategori_umur aku ON aku.kod=ak.kategori_umur
			LEFT JOIN ahli_status_ahli asa ON asa.kod=ak.status_ahli
			LEFT JOIN ahli_lkp_galur alg ON alg.kod=ak.galur
			LEFT JOIN lkp_negeri n ON n.code=ak.negeri
			WHERE status_ahli IN('AB','SH')
			ORDER BY ak.role DESC";
	$result = $conn->query($sql);
	return $result;
}
function getRekodSumbangan($tahun) {
			$conn=db();
			$sql = "SELECT *,DATE_FORMAT(tarikh,'%d-%m-%Y') AS tarikh_sumbangan FROM ahli_sumbangan
					WHERE YEAR(tarikh)='$tahun'
					ORDER BY tarikh DESC";
			$result = $conn->query($sql);
			return $result;
	}
function addEditSumbangan($id,$tarikh,$keterangan,$penyumbang,$diterima_oleh,$no_rujukan,$jumlah,$created_by) {
	$conn=db();
	 	
	if($id == "0"){
		
				$sql = "INSERT INTO ahli_sumbangan (tarikh,keterangan,penyumbang,diterima_oleh,no_rujukan,jumlah,created_by)
						VALUES ('$tarikh','$keterangan','$penyumbang','$diterima_oleh','$no_rujukan','$jumlah','$created_by')";
				$result = $conn->query($sql);
				return $result;
				
	}else{
		$sql = "UPDATE ahli_sumbangan SET tarikh='$tarikh',keterangan='$keterangan',penyumbang='$penyumbang',diterima_oleh='$diterima_oleh',no_rujukan='$no_rujukan',jumlah='$jumlah',created_by='$created_by' WHERE id='$id'";

		$result = $conn->query($sql);
		return $result;
	}
	
	
}
function getRekodSumbanganById($id) {
			$conn=db();
			$sql = "SELECT *,YEAR(tarikh) AS tahun,DATE_FORMAT(tarikh,'%Y%m%d') AS tarikh_resit FROM ahli_sumbangan WHERE id='$id'";
			$result = $conn->query($sql);
			return $result;
	}
function getRekodPerbelanjaan() {
			$conn=db();
			$sql = "SELECT *,DATE_FORMAT(tarikh,'%d-%m-%Y') AS tarikh_belanja FROM ahli_perbelanjaan
					ORDER BY tarikh DESC";
			$result = $conn->query($sql);
			return $result;
	}
function addEditPerbelanjaan($id,$tarikh,$keterangan,$penerima,$diuruskan_oleh,$no_rujukan,$jumlah,$created_by){
	$conn=db();
	 	
	if($id == "0"){
		
				$sql = "INSERT INTO ahli_perbelanjaan (tarikh,keterangan,penerima,diuruskan_oleh,no_rujukan,jumlah,created_by)
						VALUES ('$tarikh','$keterangan','$penerima','$diuruskan_oleh','$no_rujukan','$jumlah','$created_by')";
				$result = $conn->query($sql);
				return $result;
				
	}else{
		$sql = "UPDATE ahli_perbelanjaan SET tarikh='$tarikh',keterangan='$keterangan',penerima='$penerima',diuruskan_oleh='$diuruskan_oleh',no_rujukan='$no_rujukan',jumlah='$jumlah',created_by='$created_by' WHERE id='$id'";

		$result = $conn->query($sql);
		return $result;
	}
	
	
}
function getRekodPerbelanjaanById($id) {
			$conn=db();
			$sql = "SELECT *,YEAR(tarikh) AS tahun,DATE_FORMAT(tarikh,'%Y%m%d') AS tarikh_resit FROM ahli_perbelanjaan WHERE id='$id'";
			$result = $conn->query($sql);
			return $result;
	}
function getJumlahSumbangan($tahun) {
			$conn=db();
			$condition="";
			if($tahun!=""){
				$condition="WHERE YEAR(created_date)='$tahun'";
			}
			$sql = "SELECT SUM(jumlah) AS jumlah FROM ahli_sumbangan
					$condition";
			$result = $conn->query($sql);
			return $result->fetch_object()->jumlah;
	}
function getJumlahPerbelanjaan($tahun) {
			$conn=db();
			$condition="";
			if($tahun!=""){
				$condition="WHERE YEAR(created_date)='$tahun'";
			}
			$sql = "SELECT SUM(jumlah) AS jumlah FROM ahli_perbelanjaan
					$condition";
			$result = $conn->query($sql);
			return $result->fetch_object()->jumlah;
	}
function getJumlahSumbanganByMonth($tahun,$bulan) {
			$conn=db();
			$sql = "SELECT SUM(jumlah) AS jumlah FROM ahli_sumbangan
					WHERE YEAR(tarikh)='$tahun' AND MONTH(tarikh)='$bulan'";
			$result = $conn->query($sql);
			return $result->fetch_object()->jumlah;
	}
function getJumlahPerbelanjaanByMonth($tahun,$bulan) {
			$conn=db();
			$sql = "SELECT SUM(jumlah) AS jumlah FROM ahli_perbelanjaan
					WHERE YEAR(tarikh)='$tahun' AND MONTH(tarikh)='$bulan'";
			$result = $conn->query($sql);
			return $result->fetch_object()->jumlah;
	}
function getBayaranYuranKeseluruhanByMonth($tahun,$bulan) {
			$conn=db();
			$sql = "SELECT SUM(jum_yuran) AS jumlah FROM ahli_rekod_yuran
					WHERE YEAR(created_date)='$tahun' AND MONTH(created_date)='$bulan'";
			$result = $conn->query($sql);
			return $result->fetch_object()->jumlah;
	}
function getDropDownTahunSumbangan($selected) { 
	$conn=db();
	$sql = "SELECT YEAR(tarikh) AS tahun FROM ahli_sumbangan
			GROUP BY tahun
			ORDER BY tahun DESC";
				
	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
	}
	//$conn->close();
	return $txt_result;
}
function getBulanSumbangan($tahun) {
			$conn=db();
			$sql = "SELECT MONTH(tarikh) AS bulan FROM ahli_sumbangan
					WHERE YEAR(tarikh)='$tahun'
					GROUP BY bulan
					ORDER BY bulan DESC";
			$result = $conn->query($sql);
			return $result;
	}
function getPenyataSumbangan($bulan,$tahun) {
			$conn=db();
			$sql = "SELECT * FROM ahli_sumbangan
					WHERE YEAR(tarikh)='$tahun' AND MONTH(tarikh)='$bulan'
					";
			$result = $conn->query($sql);
			return $result;
	}
function getDropDownTahunBelanja($selected) { 
	$conn=db();
	$sql = "SELECT YEAR(tarikh) AS tahun FROM ahli_perbelanjaan
			GROUP BY tahun
			ORDER BY tahun DESC";
				
	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
	}
	//$conn->close();
	return $txt_result;
}
function getBulanBelanja($tahun) {
			$conn=db();
			$sql = "SELECT MONTH(tarikh) AS bulan FROM ahli_perbelanjaan
					WHERE YEAR(tarikh)='$tahun'
					GROUP BY bulan
					ORDER BY bulan DESC";
			$result = $conn->query($sql);
			return $result;
	}
function getPenyataBelanja($bulan,$tahun) {
			$conn=db();
			$sql = "SELECT * FROM ahli_perbelanjaan
					WHERE YEAR(tarikh)='$tahun' AND MONTH(tarikh)='$bulan'
					";
			$result = $conn->query($sql);
			return $result;
	}
function getSenaraiPengumuman() {
			$conn=db();
			$sql = "SELECT * FROM ahli_pengumuman ORDER BY tarikh_mula DESC";
			$result = $conn->query($sql);
			return $result;
	}
function getPengumumanById($id) {
			$conn=db();
			$sql = "SELECT * FROM ahli_pengumuman WHERE id='$id'";
			$result = $conn->query($sql);
			return $result;
	}
function addEditPengumuman($id,$tajuk,$tarikh_mula,$tarikh_tamat,$kategori,$keterangan,$created_by,$dokumen_filename,$fileType) {
	$conn=db();
	 	
        $gambar_update = '';


        if($dokumen_filename != ""){
        	$file_name=$id.".".$fileType;
            $gambar_update=" ,dokumen_filename='$file_name' "; 
        }

	if($id == "0"){
				$sql = "INSERT INTO ahli_pengumuman (tajuk,tarikh_mula,tarikh_tamat,kategori,keterangan,created_by)
						VALUES ('$tajuk','$tarikh_mula','$tarikh_tamat','$kategori','$keterangan','$created_by')";
				$result = $conn->query($sql);
				$newid=$conn->insert_id;
				if($dokumen_filename != ""){
					$file_name=$newid.".".$fileType;
					$sql = "UPDATE ahli_pengumuman SET dokumen_filename='$file_name' WHERE id='$newid'";
					$result = $conn->query($sql);

				}
				return $newid;
				
	}else{
		$sql = "UPDATE ahli_pengumuman SET tajuk='$tajuk',tarikh_mula='$tarikh_mula',tarikh_tamat='$tarikh_tamat',kategori='$kategori',keterangan='$keterangan',created_by='$created_by'$gambar_update WHERE id='$id'";

		$result = $conn->query($sql);
		return $id;
	}
	
	
}
//lookup asnaf -start-
	function getAsnafList() {
		$conn=db();
		$sql = "SELECT * FROM ahli_lkp_asnaf ORDER BY id ASC";
		$result = $conn->query($sql);
		return $result;
	}
	function getDropDownAsnaf($selected) {
	$conn=db();
	$sql = "SELECT jenis_asnaf,jenis_asnaf FROM ahli_lkp_asnaf WHERE status_asnaf='1'";
	
	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
	}
	//$conn->close();
	return $txt_result;
}	
//lookup asnaf -end-
//konfigurasi button kemaskini and nyahaktif
function konfigurasiButtonKemaskiniNyahAktif($column,$value) {
		$conn=db();
		$sql = "SELECT COUNT(*) AS bil FROM ahli_users WHERE $column='$value'";
		$result = $conn->query($sql);
		return $result->fetch_object()->bil;
	}
	//end
	function getYearDana() {
		$conn=db();
		$sql = "SELECT YEAR(tarikh) AS tahun FROM ahli_sumbangan
				GROUP BY tahun
				ORDER BY tahun DESC";
		$result = $conn->query($sql);
		return $result;
	}
	//start khairat
	function getKhairatList() {
		$conn=db();
		$sql = "SELECT * FROM ahli_lkp_khairat ORDER BY id ASC";
		$result = $conn->query($sql);
		return $result;
	}
	function getCountData($nama_table) {
		$conn=db();
		$sql = "SELECT COUNT(*) AS bil FROM $nama_table";
		$result = $conn->query($sql);
		return $result->fetch_object()->bil;
	}
	function getSenaraiAhliKhairat($tahun,$status) {
		$conn=db();
		if($status==0){
			$sql = "SELECT ak.*,aku.keterangan,alg.nama_galur,n.name,asa.keterangan AS kategori_ahli 
				FROM ahli_users ak
				LEFT JOIN ahli_kategori_umur aku ON aku.kod=ak.kategori_umur
				LEFT JOIN ahli_lkp_galur alg ON alg.kod=ak.galur
				LEFT JOIN lkp_negeri n ON n.code=ak.negeri
				LEFT JOIN ahli_status_ahli asa ON asa.kod=ak.status_ahli
				WHERE ak.status_ahli NOT IN('BD') AND ak.nokp NOT IN (SELECT nokp_ahli FROM ahli_kutipan_khairat WHERE tahun='$tahun')
				ORDER BY ak.nama ASC";
		}else{
			$sql = "SELECT akk.*,ak.*,akk.id AS id_kutipan,aku.keterangan,alg.nama_galur,n.name,asa.keterangan AS kategori_ahli 
				FROM ahli_kutipan_khairat akk
				LEFT JOIN ahli_users ak ON akk.nokp_ahli=ak.nokp
				LEFT JOIN ahli_kategori_umur aku ON aku.kod=ak.kategori_umur
				LEFT JOIN ahli_lkp_galur alg ON alg.kod=ak.galur
				LEFT JOIN lkp_negeri n ON n.code=ak.negeri
				LEFT JOIN ahli_status_ahli asa ON asa.kod=ak.status_ahli
				WHERE akk.tahun='$tahun'
				ORDER BY akk.id DESC";

		}
		
		$result = $conn->query($sql);
		return $result;
	}
	function getDropDownTahunKhairat($selected) { 
	$conn=db();
	$sql = "SELECT tahun FROM ahli_kutipan_khairat
			GROUP BY tahun
			ORDER BY tahun DESC";
				
	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
	}
	//$conn->close();
	return $txt_result;
}
function getJumlahKhairat() {
		$conn=db();
		$sql = "SELECT * FROM ahli_lkp_khairat ORDER BY id ASC LIMIT 1";
		$result = $conn->query($sql);
		return $result;
	}
function addEditKhairat($id,$tahun,$nokp_ahli,$status,$created_by,$jum_khairat,$tarikh) {
	$conn=db();
	 	
	if($status == "0"){
				$sql = "INSERT INTO ahli_kutipan_khairat (tahun,nokp_ahli,tarikh,jum_khairat,created_by)
						VALUES ('$tahun','$nokp_ahli','$tarikh','$jum_khairat','$created_by')";
				$result = $conn->query($sql);
				
				
	}else{
		$sql = "UPDATE ahli_kutipan_khairat SET tarikh='$tarikh',created_by='$created_by' WHERE id='$id'";

		$result = $conn->query($sql);
		
	}
	return $result;
	
}
//start biayaa 
function getSenaraiBiayaKhairat($tahun) {
		$conn=db();
		$sql = "SELECT abk.*,ak.*,abk.id AS id_biaya,abk.nota AS nota_biaya,aku.keterangan,alg.nama_galur,n.name,asa.keterangan AS kategori_ahli 
			FROM ahli_biaya_khairat abk
			LEFT JOIN ahli_users ak ON abk.nokp_ahli=ak.nokp
			LEFT JOIN ahli_kategori_umur aku ON aku.kod=ak.kategori_umur
			LEFT JOIN ahli_lkp_galur alg ON alg.kod=ak.galur
			LEFT JOIN lkp_negeri n ON n.code=ak.negeri
			LEFT JOIN ahli_status_ahli asa ON asa.kod=ak.status_ahli
			WHERE abk.tahun='$tahun'
			ORDER BY abk.id DESC";
		$result = $conn->query($sql);
		return $result;
	}
	function getSenaraiBiayaKhairatById($id) {
		$conn=db();
		$sql = "SELECT abk.*,ak.*,abk.id AS id_biaya,abk.nota AS nota_biaya,CONCAT(ak.nokp,' - ',ak.nama) AS label,aku.keterangan,alg.nama_galur,n.name,asa.keterangan AS kategori_ahli 
			FROM ahli_biaya_khairat abk
			LEFT JOIN ahli_users ak ON abk.nokp_ahli=ak.nokp
			LEFT JOIN ahli_kategori_umur aku ON aku.kod=ak.kategori_umur
			LEFT JOIN ahli_lkp_galur alg ON alg.kod=ak.galur
			LEFT JOIN lkp_negeri n ON n.code=ak.negeri
			LEFT JOIN ahli_status_ahli asa ON asa.kod=ak.status_ahli
			WHERE abk.id='$id'
			";
		$result = $conn->query($sql);
		return $result;
	}
	function addEditBiayaKhairat($id,$tahun,$nokp_ahli,$jum_khairat,$tarikh,$nota,$created_by) {
	$conn=db();
	 	
	if($id == "0"){
				$sql = "INSERT INTO ahli_biaya_khairat (tahun,nokp_ahli,tarikh,jum_khairat,nota,created_by)
						VALUES (YEAR(NOW()),'$nokp_ahli','$tarikh','$jum_khairat','$nota','$created_by')";
				$result = $conn->query($sql);
				
				
	}else{
		$sql = "UPDATE ahli_biaya_khairat SET nokp_ahli='$nokp_ahli',tarikh='$tarikh',created_by='$created_by',jum_khairat='$jum_khairat',nota='$nota' WHERE id='$id'";

		$result = $conn->query($sql);
		
	}
	return $result;
	
}
function getTotalBiayaKhairatByTahun($tahun) {
		$conn=db();
		$sql = "SELECT IFNULL(SUM(jum_khairat),'0.00') AS total_khairat FROM ahli_biaya_khairat WHERE tahun='$tahun'
			";
		$result = $conn->query($sql)->fetch_object()->total_khairat;
		return $result;
	}
function getDropDownTahunBiayaKhairat($selected) { 
	$conn=db();
	$sql = "SELECT tahun FROM ahli_biaya_khairat
			GROUP BY tahun
			ORDER BY tahun DESC";
				
	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
	}
	//$conn->close();
	return $txt_result;
}
function getTotalKutipanKhairatTelahBayarByTahun($tahun) {
		$conn=db();
		$sql = "SELECT IFNULL(SUM(jum_khairat),'0.00') AS total_khairat FROM ahli_kutipan_khairat WHERE tahun='$tahun'
			";
		$result = $conn->query($sql)->fetch_object()->total_khairat;
		return $result;
	}
function getTotalKutipanKhairatBelumBayarByTahun($tahun) {
		$conn=db();
		$sql = "SELECT (COUNT(ak.id) * (SELECT jumlah_kutipan FROM ahli_lkp_khairat LIMIT 1)) AS total_khairat
				FROM ahli_users ak
				WHERE ak.status_ahli NOT IN('BD') AND ak.nokp NOT IN (SELECT nokp_ahli FROM ahli_kutipan_khairat WHERE tahun='$tahun')
			";
		$result = $conn->query($sql)->fetch_object()->total_khairat;
		return $result;
	}
	function getBulanKutipanKhairat($tahun) {
			$conn=db();
			$sql = "SELECT MONTH(tarikh)AS bulan FROM ahli_kutipan_khairat
					WHERE YEAR(tarikh)='$tahun'
					GROUP BY bulan
					ORDER BY bulan DESC";
			$result = $conn->query($sql);
			return $result;
	}
	function getPenyataKutipanKhairat($tahun,$bulan) {
			$conn=db();
			$sql = "SELECT akk.*,ak.no_ahli,ak.nama,asa.keterangan
					FROM ahli_kutipan_khairat akk
					LEFT JOIN ahli_users ak ON akk.nokp_ahli=ak.nokp
					LEFT JOIN ahli_status_ahli asa ON asa.kod=ak.status_ahli
					WHERE YEAR(akk.tarikh)='$tahun' AND MONTH(akk.tarikh)='$bulan'
					ORDER BY akk.tarikh DESC";
			$result = $conn->query($sql);
			return $result;
	}
	function getBulanBiayaKhairat($tahun) {
			$conn=db();
			$sql = "SELECT MONTH(tarikh)AS bulan FROM ahli_biaya_khairat
					WHERE YEAR(tarikh)='$tahun'
					GROUP BY bulan
					ORDER BY bulan DESC";
			$result = $conn->query($sql);
			return $result;
	}
	function getPenyataBiayaKhairat($tahun,$bulan) {
			$conn=db();
			$sql = "SELECT akk.*,ak.no_ahli,ak.nama,asa.keterangan
					FROM ahli_biaya_khairat akk
					LEFT JOIN ahli_users ak ON akk.nokp_ahli=ak.nokp
					LEFT JOIN ahli_status_ahli asa ON asa.kod=ak.status_ahli
					WHERE YEAR(akk.tarikh)='$tahun' AND MONTH(akk.tarikh)='$bulan'
					ORDER BY akk.tarikh DESC";
			$result = $conn->query($sql);
			return $result;
	}


		
$conn->close();

?>