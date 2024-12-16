<?php

require '../../lib/db/connection.php';
$action=clean($_POST['action']);
	
if($action == "nyahaktifKategori"){
	$id = $_POST['id'];
	$status = $_POST['status'];
	if ($status == '1') {
		$status = '0';
	}
	else {
		$status = '1';
	}

	$conn=db();
	$sql = "UPDATE lkp_elibrary_jenis set status='$status' WHERE id = '$id'";
	$result = $conn->query($sql);
}else if ($action=="peminjam_detail") {
	$nokp = clean($_POST['nokp']);
	$conn=db();
	$sql = "SELECT nama,nokp,notel FROM elibrary_peminjam
			WHERE nokp='$nokp' GROUP BY nokp";

	$result = $conn->query($sql);
	$rows = array();
	while($r = $result->fetch_assoc()) {
		$rows[] = $r;
	}

	echo json_encode($rows);

}else if($action == "batalTempahan"){
		$id = $_POST['id'];
		//$status = $_POST['status'];
		$conn=db();
		$sql = "UPDATE elibrary_tempahan set status='2' WHERE id = '$id'";
		$result = $conn->query($sql);
}else if ($action=="kategori_digital") {
	$search = clean($_POST['search']);
	$conn=db();
	$sql = "SELECT el.nama, lej.jenis FROM elibrary el
			LEFT JOIN lkp_elibrary_jenis lej ON lej.id=el.id_jenis
			WHERE nama LIKE '%$search%' OR id_jenis LIKE '%$search%' OR keterangan LIKE '%$search%' OR keyword LIKE '%$search%' OR topik LIKE '%$search%' OR subtopic LIKE '%$search%' OR penerbit LIKE '%$search%' OR pengarang LIKE '%$search%' GROUP BY id_jenis";

	$result = $conn->query($sql);
	$rows = array();
	while($r = $result->fetch_assoc()) {
		$rows[] = $r;
	}

	echo json_encode($rows);

}else if($action == "checkPemulangan"){
    $id_naskah = $_POST['id_naskah'];
    $conn=db();
    $sql = "SELECT COUNT(id) AS bil,id,nokp FROM elibrary_pinjaman
        WHERE id_naskah='$id_naskah' AND status='0'";
    $result = $conn->query($sql);
    $rows = array();
    while($r = $result->fetch_assoc()) {
      $rows[] = $r;
    }

    echo json_encode($rows);
}else if($action == "libraryPemulangan"){
    $id_naskah = $_POST['id_naskah'];
    $conn=db();
    $sql = "UPDATE elibrary_pinjaman SET status='1',tarikh_hantar=CURRENT_TIME,created_date=CURRENT_TIMESTAMP 
        WHERE id_naskah='$id_naskah' AND status='0'";
    $result = $conn->query($sql);
    return $result;
}else if($action == "BahanPinjamanDetails"){
    $id_naskah = $_POST['id_naskah'];
    $conn=db();
    $sql = "SELECT e.nama,e.topik,e.id_jenis, ep.status,epe.nama AS nama_peminjam, epe.notel, e.status_pinjam
			FROM elibrary_naskah en
	        LEFT JOIN elibrary e ON en.id_elibrary=e.id
	        LEFT JOIN elibrary_pinjaman ep ON en.id=ep.id_naskah AND ep.status=0
	        LEFT JOIN elibrary_peminjam epe ON ep.nokp=epe.nokp	        WHERE en.id='$id_naskah' LIMIT 1";
    $result = $conn->query($sql);
    $rows = array();
    while($r = $result->fetch_assoc()) {
      $rows[] = $r;
    }

    echo json_encode($rows);
}else if ($action=="prosesPinjaman") {
    $nokp = $_POST['nokp'];
    $nama = $_POST['nama'];
    $notel = $_POST['notel'];
    $created_by = $_POST['created_by'];


    $info = $_POST['info'];

     $someArray = json_decode($info, true);
      echo $result = setProsesPinjaman($nama, $nokp, $notel, $created_by,$someArray);

  }

if($_GET['action']=='agihTempahan'){
	$id_elibrary = clean($_GET['id_elibrary']);
	$conn=db();
	$sql = "SELECT en.id FROM elibrary_naskah en
			LEFT JOIN elibrary_pinjaman ep ON en.id=ep.id_naskah
			LEFT JOIN elibrary_tempahan et ON en.id_elibrary=et.id_elibrary
			WHERE (en.id NOT IN(SELECT et.id_naskah FROM elibrary_tempahan et
			WHERE et.id_elibrary='$id_elibrary' AND et.status='1')) AND en.id_elibrary='$id_elibrary' AND ep.status='1'
			LIMIT 1";
	$id_naskah=$conn->query($sql)->fetch_object()->id;
	$sql1 ="SELECT id FROM elibrary_tempahan 
			WHERE id_elibrary='$id_elibrary' AND status='0'
			ORDER BY status_urgent DESC,anggaran_tarikh_tempah ASC
			LIMIT 1";
	$id_tempahan=$conn->query($sql1)->fetch_object()->id;
	$sql2 = "UPDATE elibrary_tempahan SET id_naskah='$id_naskah',status='1' WHERE id='$id_tempahan'";
	$result=$conn->query($sql2);
	echo ("<script lANGUAGE='JavaScript'>
		window.location.href='../view/library_kandungan_senarai.php';
	</script>");

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

//start niena 21-07-2019

function libraryAddEdit($id,$id_jenis,$nama,$topik,$subtopic,$keterangan,$penerbit,$tahun_terbitan,$pengarang,$isbn,$bil_naskah_hardcopy,$lokasi_fizikal_hardcopy,$created_by,$bilangan,$status_naskah,$status_pinjam,$frontpage_filename,$document_filename,$targetFrontpage,$targetDir,$upload_frontpage,$upload_document,$frontpageType,$fileType,$status_naskah_sebelum){
	$conn=db();
	if($status_naskah == 0){
		$status_pinjam = 1;
		$bil_naskah_hardcopy = 0;
		$lokasi_fizikal_hardcopy = "";
	}else{
		$status_pinjam = $status_pinjam;
	}
	if($id>0){
		if($frontpage_filename =="" && $document_filename ==""){
		//update dua2
			$sql = "UPDATE elibrary SET id_jenis='$id_jenis',nama='$nama',topik='$topik',subtopic='$subtopic',penerbit='$penerbit',tahun_terbitan='$tahun_terbitan',status_naskah='$status_naskah',bil_naskah_hardcopy='$bil_naskah_hardcopy',pengarang='$pengarang',isbn='$isbn',keterangan='$keterangan',lokasi_fizikal_hardcopy='$lokasi_fizikal_hardcopy',bilangan='$bilangan',status_pinjam='$status_pinjam' WHERE id='$id' ";

		}else if($frontpage_filename !="" && $document_filename == ""){
		//update filename
			$sql = "UPDATE elibrary SET id_jenis='$id_jenis',nama='$nama',topik='$topik',subtopic='$subtopic',penerbit='$penerbit',tahun_terbitan='$tahun_terbitan',status_naskah='$status_naskah',bil_naskah_hardcopy='$bil_naskah_hardcopy',pengarang='$pengarang',isbn='$isbn',keterangan='$keterangan',lokasi_fizikal_hardcopy='$lokasi_fizikal_hardcopy',bilangan='$bilangan',status_pinjam='$status_pinjam',frontpage_cover_file='$frontpage_filename' WHERE id='$id' ";
		}else if($frontpage_filename =="" && $document_filename !=""){
		//update document
			$sql = "UPDATE elibrary SET id_jenis='$id_jenis',nama='$nama',topik='$topik',subtopic='$subtopic',penerbit='$penerbit',tahun_terbitan='$tahun_terbitan',status_naskah='$status_naskah',bil_naskah_hardcopy='$bil_naskah_hardcopy',pengarang='$pengarang',isbn='$isbn',keterangan='$keterangan',lokasi_fizikal_hardcopy='$lokasi_fizikal_hardcopy',bilangan='$bilangan',status_pinjam='$status_pinjam',document_file='$document_filename' WHERE id='$id' ";
		}else if($frontpage_filename != "" && $document_filename != ""){
		//tak update dua2
			$sql = "UPDATE elibrary SET id_jenis='$id_jenis',nama='$nama',topik='$topik',subtopic='$subtopic',penerbit='$penerbit',tahun_terbitan='$tahun_terbitan',status_naskah='$status_naskah',bil_naskah_hardcopy='$bil_naskah_hardcopy',pengarang='$pengarang',isbn='$isbn',keterangan='$keterangan',lokasi_fizikal_hardcopy='$lokasi_fizikal_hardcopy',bilangan='$bilangan',status_pinjam='$status_pinjam',frontpage_cover_file='$frontpage_filename',document_file='$document_filename' WHERE id='$id' ";
		}
		$result=$conn->query($sql);
		if($status_naskah_sebelum == 0){
			if($status_naskah != $status_naskah_sebelum){
				for($i = 1; $i <= $bil_naskah_hardcopy; $i++){
					$sql="INSERT INTO elibrary_naskah (id_elibrary,created_by) VALUES ('$id','$created_by')";
					$result=$conn->query($sql);
				}
				
			}
		}
		
		return $result;
		
	}else{
		$sql="INSERT INTO elibrary (id_jenis,nama,topik,subtopic,penerbit,tahun_terbitan,pengarang,isbn,keterangan,status_naskah,bil_naskah_hardcopy,lokasi_fizikal_hardcopy,bilangan,status_pinjam,frontpage_cover_file,document_file,created_by) VALUES ('$id_jenis','$nama','$topik','$subtopic','$penerbit','$tahun_terbitan','$pengarang','$isbn','$keterangan','$status_naskah','$bil_naskah_hardcopy','$lokasi_fizikal_hardcopy','$bilangan','$status_pinjam','$frontpage_filename','$document_filename','$created_by')";
		$result=$conn->query($sql);
		$id_elibrary = $conn->insert_id;
		$frontpage_filename = $id_elibrary.'.'.$frontpageType;
		$document_filename = $id_elibrary.'.'.$fileType;
		$sql="UPDATE elibrary SET frontpage_cover_file='$frontpage_filename',document_file='$document_filename' WHERE id='$id_elibrary';";
		$target_path_front = $targetFrontpage.$frontpage_filename;
		$target_path_doc = $targetDir.$document_filename;
		move_uploaded_file($upload_frontpage,$target_path_front);
		move_uploaded_file($upload_document,$target_path_doc);
		$result=$conn->query($sql);

		for($i = 1; $i <= $bil_naskah_hardcopy; $i++){
			$sql="INSERT INTO elibrary_naskah (id_elibrary,created_by) VALUES ('$id_elibrary','$created_by')";
			$result=$conn->query($sql);
		}
		return $result;
	}

	
}

function addLibraryExcel($id_jenis,$nama,$topik,$subtopik,$penerbit,$tahun_terbitan,$pengarang,$isbn,$keyword,$keterangan,$status_naskah,$bilangan_naskah,$lokasi_naskah,$jilid,$status_pinjam,$created_by){
	$conn = db();
	$sql="INSERT INTO elibrary (id_jenis,nama,topik,subtopic,penerbit,tahun_terbitan,pengarang,isbn,keyword,keterangan,status_naskah,bil_naskah_hardcopy,lokasi_fizikal_hardcopy,bilangan,status_pinjam,created_by) VALUES ('$id_jenis','$nama','$topik','$subtopik','$penerbit','$tahun_terbitan','$pengarang','$isbn','$keyword','$keterangan','$status_naskah','$bilangan_naskah','$lokasi_naskah','$jilid','$status_pinjam','$created_by')";
	$result=$conn->query($sql);
	$id_elibrary = $conn->insert_id;
	if($status_naskah!=0){
		for($i = 1; $i <= $bilangan_naskah; $i++){
			$sql="INSERT INTO elibrary_naskah (id_elibrary,created_by) VALUES ('$id_elibrary','$created_by')";
			$result=$conn->query($sql);
		}
	}
	return $result;
}

function getKandunganList(){
	$conn=db();
	$sql = "SELECT el.*,lkj.id AS jenis_id, lkj.jenis AS jenis FROM elibrary el
	LEFT JOIN lkp_elibrary_jenis lkj ON el.id_jenis=lkj.id ORDER BY el.id DESC";
	$result = $conn->query($sql);
	return $result;
}

function getLibraryInfo($id){
	$conn=db();
	$sql = "SELECT el.*, lej.id AS id_jenis, lej.jenis AS jenis FROM elibrary el
			LEFT JOIN lkp_elibrary_jenis lej ON lej.id = el.id_jenis WHERE el.id='$id'";
	$result = $conn->query($sql);
	return $result;
}

//24-07-2019
function getBahanDigitalList($id_jenis,$search){
	$conn=db();
	$sql = "SELECT el.*,lkj.id AS jenis_id, lkj.jenis AS jenis FROM elibrary el
			LEFT JOIN lkp_elibrary_jenis lkj ON el.id_jenis=lkj.id 
			WHERE el.id_jenis = '$id_jenis' AND (
			el.nama LIKE '%$search%' OR 
			el.keterangan LIKE '%$search%' OR 
			el.keyword LIKE '%$search%' OR 
			el.topik LIKE '%$search%' OR 
			el.subtopic LIKE '%$search%' OR 
			el.penerbit LIKE '%$search%' OR 
			el.pengarang LIKE '%$search%' OR
			lkj.jenis LIKE '%$search%')";
	$result = $conn->query($sql);
	return $result;
}
function getAdvSearchByKategori($id_kategori,$nama,$topik,$subtopic,$tahun_terbitan,$penerbit,$pengarang){
	$conn=db();
	$sql = "SELECT el.*,lkj.id AS jenis_id, lkj.jenis AS jenis FROM elibrary el
			LEFT JOIN lkp_elibrary_jenis lkj ON el.id_jenis=lkj.id 
			WHERE el.id_jenis = '$id_kategori' AND (
			el.nama LIKE '%$nama%' AND 
			el.tahun_terbitan LIKE '%$tahun_terbitan%' AND
			el.topik LIKE '%$topik%' AND 
			el.subtopic LIKE '%$subtopic%' AND 
			el.penerbit LIKE '%$penerbit%' AND 
			el.pengarang LIKE '%$pengarang%')";
	$result = $conn->query($sql);
	return $result;
}

function getSearchKategori($search) {
	$conn=db();
	$sql = "SELECT lkj.jenis,lkj.id AS id_jenis,el.*,COUNT(el.id) AS kuantiti FROM lkp_elibrary_jenis lkj 
			LEFT JOIN elibrary el ON lkj.id=el.id_jenis 
			WHERE el.nama LIKE '%$search%' OR el.id_jenis LIKE '%$search%' OR el.keterangan LIKE '%$search%' OR el.keyword LIKE '%$search%' OR el.topik LIKE '%$search%' OR el.subtopic LIKE '%$search%' OR el.penerbit LIKE '%$search%' OR el.pengarang LIKE '%$search%' OR lkj.jenis LIKE '%$search%'
			GROUP BY lkj.id ORDER BY kuantiti DESC";
	$result = $conn->query($sql);
	return $result;
}
function getSearchAll($search) {
	$conn=db();
	$sql = "SELECT lkj.jenis,el.*,COUNT(el.id) AS kuantiti FROM lkp_elibrary_jenis lkj 
			LEFT JOIN elibrary el ON lkj.id=el.id_jenis 
			WHERE el.nama LIKE '%$search%' OR el.id_jenis LIKE '%$search%' OR el.keterangan LIKE '%$search%' OR el.keyword LIKE '%$search%' OR el.topik LIKE '%$search%' OR el.subtopic LIKE '%$search%' OR el.penerbit LIKE '%$search%' OR el.pengarang LIKE '%$search%'
			GROUP BY el.id";
	$result = $conn->query($sql);
	return $result;
}
function getAdvSearch($kategori,$nama,$topik,$subtopic,$tahun_terbitan,$penerbit,$pengarang) {
	$conn=db();
	$sql = "SELECT lkj.jenis,el.*,COUNT(el.id) AS kuantiti FROM lkp_elibrary_jenis lkj 
			LEFT JOIN elibrary el ON lkj.id=el.id_jenis 
			WHERE lkj.jenis LIKE '%$kategori%' AND el.nama LIKE '%$nama%' AND el.tahun_terbitan LIKE '%$tahun_terbitan%' AND el.topik LIKE '%$topik%' AND el.subtopic LIKE '%$subtopic%' 
			AND el.penerbit LIKE '%$penerbit%' AND el.pengarang LIKE '%$pengarang%'
			GROUP BY el.id";
	$result = $conn->query($sql);
	return $result;
}

//end search


//niena 24-07-2019 (analisa)
function getAnalisaKategoriLibrary($id_jenis) {
	$conn=db();
	$sql = "SELECT  lej.id AS id_jenis, lej.jenis, (SELECT SUM(e.bil_naskah_hardcopy) FROM elibrary e WHERE e.id_jenis='$id_jenis') AS bilangan_kategori, COUNT(epin.id) AS bilangan_pinjam 
			FROM lkp_elibrary_jenis lej 
			LEFT JOIN elibrary e ON e.id_jenis = lej.id
			LEFT JOIN elibrary_naskah enas ON enas.id_elibrary = e.id
			LEFT JOIN elibrary_pinjaman epin ON epin.id_naskah = enas.id
			WHERE lej.id='$id_jenis'
			GROUP BY lej.id";
	$result = $conn->query($sql);
	return $result;
}

function getPeminjamBermasalahList() {
	$conn=db();
	$sql = "SELECT epem.nokp,epem.nama,epem.notel, DATE_ADD(epin.tarikh_pinjam, INTERVAL (epin.bil_hari_pinjam) DAY) AS tarikh_akhir,epin.id 
			FROM elibrary_peminjam epem
			LEFT JOIN elibrary_pinjaman epin ON epem.nokp=epin.nokp
			LEFT JOIN elibrary_naskah enas ON epin.id_naskah=enas.id
			LEFT JOIN elibrary e ON enas.id_elibrary=e.id
			WHERE CURRENT_DATE > DATE_ADD(epin.tarikh_pinjam, INTERVAL (epin.bil_hari_pinjam) DAY) OR epin.tarikh_hantar > DATE_ADD(epin.tarikh_pinjam, INTERVAL (epin.bil_hari_pinjam) DAY)	
			GROUP BY epem.nokp";
	$result = $conn->query($sql);
	return $result;
}

//end niena 24-07-2019


//start syafiqah 21-07-2019

function getKategoriList() {
	$conn=db();
	$sql = "SELECT lkj.id AS id_jenis,lkj.*,COUNT(el.id) AS kuantiti FROM lkp_elibrary_jenis lkj 
			LEFT JOIN elibrary el ON lkj.id=el.id_jenis 
			GROUP BY lkj.id DESC";
	$result = $conn->query($sql);
	return $result;
}
 
function kategoriAddEdit($id,$jenis,$status){
	$conn=db();

	if($id > 0){
		$sql = "UPDATE lkp_elibrary_jenis set jenis='$jenis' WHERE id='$id' ";
	}else{
	 
		$sql = "INSERT INTO lkp_elibrary_jenis (jenis,status) 
				values ('$jenis','1')";
	}

	$result = $conn->query($sql) or die($conn->error);
	return $result;
}


//end syafiqah
//nik
function peminjamAddEdit($id,$id_library,$nokp,$nama,$notel,$tarikh_pinjam,$tarikh_hantar,$bil_hari_pinjam,$created_by){
	$conn=db();
	if($id == ""){
		$sql1 = "SELECT COUNT(nokp) AS nokp FROM elibrary_peminjam WHERE nokp='$nokp'";
		$checkNokp=$conn->query($sql1)->fetch_object()->nokp;
		if($checkNokp==0){
			$sql2 = "INSERT INTO elibrary_peminjam (nama,nokp,notel) VALUES ('$nama','$nokp','$notel')";
			$result = $conn->query($sql2);
		}
		$sql3= "SELECT en.id AS id FROM elibrary_naskah en
				LEFT JOIN elibrary_pinjaman ep ON en.id=ep.id_naskah
				WHERE (ep.id_naskah IS NULL OR ep.status='1') AND en.id_elibrary='$id_library'
				LIMIT 1
		";
		$id_naskah=$conn->query($sql3)->fetch_object()->id;
		$sql = "INSERT INTO elibrary_pinjaman (id_naskah,nokp,tarikh_pinjam,bil_hari_pinjam,created_by)
		VALUES ('$id_naskah','$nokp','$tarikh_pinjam','$bil_hari_pinjam','$created_by')";
	}else{
		if ($tarikh_hantar=='') {
			$sql = "UPDATE elibrary_pinjaman SET tarikh_pinjam='$tarikh_pinjam',bil_hari_pinjam='$bil_hari_pinjam' WHERE id='$id'";
		}else{
			$sql = "UPDATE elibrary_pinjaman SET tarikh_pinjam='$tarikh_pinjam',tarikh_hantar='$tarikh_hantar',bil_hari_pinjam='$bil_hari_pinjam' WHERE id='$id'";
		}
	}

	$result = $conn->query($sql);
	return $result;
}

function tempahanAddPinjaman($id_tempahan,$id_naskah,$nokp,$tarikh_pinjam,$bil_hari_pinjam,$created_by){
	$conn=db();
	$sql = "INSERT INTO elibrary_pinjaman (id_naskah,nokp,tarikh_pinjam,bil_hari_pinjam,status,created_by)
			VALUES ('$id_naskah','$nokp','$tarikh_pinjam','$bil_hari_pinjam','0','$created_by')";
	$result = $conn->query($sql);
	$sql="UPDATE elibrary_tempahan SET status = '1' WHERE id='$id_tempahan'";
	$result = $conn->query($sql);
	return $result;
}

//24-07-2019
function getBilDokumenDipinjam($id_elibrary) {
	$conn=db();
	$sql = "SELECT COUNT(ep.id) AS bil FROM elibrary_pinjaman ep
			LEFT JOIN elibrary_naskah en ON ep.id_naskah=en.id
			WHERE en.id_elibrary='$id_elibrary' AND ep.status='0'";
	$result = $conn->query($sql);
	return $result->fetch_object()->bil;
}

function updateTarikhHantar($id_pinjaman,$tarikh_hantar,$created_by) {
	$conn=db();
	$sql = "UPDATE elibrary_pinjaman SET tarikh_hantar='$tarikh_hantar',created_by='$created_by',status='1',created_date=CURRENT_TIMESTAMP
			WHERE id='$id_pinjaman'";
	$result = $conn->query($sql);
	return $result;
}
function getPinjamanListByNokp($nokp){
	$conn=db();
	$sql = "SELECT DATE_ADD(elp.tarikh_pinjam, INTERVAL (elp.bil_hari_pinjam) DAY) AS tarikh_akhir, elp.*,el.nama AS nama_kandungan_digital 
			FROM elibrary_pinjaman elp
			LEFT JOIN elibrary_naskah enas ON elp.id_naskah=enas.id
			LEFT JOIN elibrary el ON  enas.id_elibrary=el.id
			WHERE elp.nokp='$nokp'
			ORDER BY elp.id DESC";
	$result = $conn->query($sql);
	return $result;
}
function getPeminjamInfo($id){
	$conn=db();
	$sql = "SELECT elp.*,eelp.* FROM elibrary_pinjaman elp
			LEFT JOIN elibrary_peminjam eelp ON elp.nokp=eelp.nokp
			WHERE elp.id='$id'";
	$result = $conn->query($sql);
	return $result;
}

//start syafiqah 24-07-2019
function getLabelInfo($id) {
$conn=db();
$sql = "SELECT enas.*,e.isbn,e.lokasi_fizikal_hardcopy,e.nama,lkj.jenis FROM elibrary_naskah enas
		LEFT JOIN elibrary e ON enas.id_elibrary=e.id
		LEFT JOIN lkp_elibrary_jenis lkj ON e.id_jenis=lkj.id
		WHERE enas.id_elibrary = '$id' ORDER BY enas.id ASC";
$result = $conn->query($sql);
return $result;
}

function getLabelList() {
$conn=db();
$sql = "SELECT enas.*,e.isbn,e.lokasi_fizikal_hardcopy,lkj.jenis FROM elibrary_naskah enas
		LEFT JOIN elibrary e ON enas.id_elibrary=e.id
		LEFT JOIN lkp_elibrary_jenis lkj ON e.id_jenis=lkj.id";
$result = $conn->query($sql);
return $result;
}

function getLabelDetail($id) {
$conn=db();
$sql = "SELECT enas.*,e.isbn,e.lokasi_fizikal_hardcopy,e.nama,lkj.jenis FROM elibrary_naskah enas
		LEFT JOIN elibrary e ON enas.id_elibrary=e.id
		LEFT JOIN lkp_elibrary_jenis lkj ON e.id_jenis=lkj.id
		WHERE enas.id = '$id' ORDER BY enas.id ASC";
$result = $conn->query($sql);
return $result;
}

//end syafiqah 24-07-2019

//edit nik 25/07/2019

//tempahan
function tempahanAddEdit($id_tempahan,$id_library,$nokp,$nama,$notel,$status_urgent,$anggaran_tarikh_tempah){
	$conn=db();
	if($id_tempahan == ""){
		$sql1 = "SELECT COUNT(nokp) AS nokp FROM elibrary_peminjam WHERE nokp='$nokp'";
		$checkNokp=$conn->query($sql1)->fetch_object()->nokp;
		if($checkNokp==0){
			$sql2 = "INSERT INTO elibrary_peminjam (nama,nokp,notel) VALUES ('$nama','$nokp','$notel')";
			$result = $conn->query($sql2);
		}
		$sql = "INSERT INTO elibrary_tempahan (id_elibrary,nokp,status_urgent,anggaran_tarikh_tempah)
		VALUES ('$id_library','$nokp','$status_urgent','$anggaran_tarikh_tempah')";
	}else{
		$sql = "UPDATE elibrary_tempahan SET status_urgent = '$status_urgent',anggaran_tarikh_tempah = '$anggaran_tarikh_tempah' WHERE id = '$id_tempahan'";
	}
	$result = $conn->query($sql);
	return $result;
}

function getBilDokumenDitempah($id_elibrary) {
	$conn=db();
	$sql = "SELECT COUNT(id) AS bil FROM elibrary_tempahan
			WHERE id_elibrary='$id_elibrary' AND status='0'";
	$result = $conn->query($sql);
	return $result->fetch_object()->bil;
}
//END TEMPAHAN

//start syafiqah 27-07-2019
function getTempahanListByNokp($nokp){
 $conn=db();
 $sql = "SELECT elt.*,el.nama AS tajuk FROM elibrary_tempahan ELT
    LEFT JOIN elibrary el ON elt.id_elibrary=el.id
    WHERE elt.nokp = '$nokp' ORDER BY elt.id DESC";
 $result = $conn->query($sql);
 return $result;
}

function getTempahanInfo($id){
	$conn=db();
	$sql = "SELECT elt.*,elp.*,el.nama AS tajuk FROM elibrary_tempahan elt
			LEFT JOIN elibrary_peminjam elp ON elt.nokp=elp.nokp
			LEFT JOIN elibrary el ON elt.id_elibrary=el.id
			WHERE elt.id = '$id'";
	$result = $conn->query($sql);
	return $result;
}
//end syafiqah 27-07-2019

//niena 28-07-2019
function getPeminjamByNokp($nokp){
	$conn=db();
	$sql = "SELECT * FROM elibrary_peminjam 
			WHERE nokp= '$nokp'";
	$result = $conn->query($sql);
	return $result;
}

//start syafiqah 31-07-2019
function getTransaksiPinjaman(){
	$conn=db();
	$sql = "SELECT DATE_ADD(elp.tarikh_pinjam, INTERVAL (elp.bil_hari_pinjam) DAY) AS tarikh_akhir,elp.*,ep.nama,ep.notel,el.nama AS nama_kandungan_digital,el.id AS id_kandungan,lkj.jenis
			FROM elibrary_pinjaman elp
			LEFT JOIN elibrary_naskah en ON elp.id_naskah=en.id
			LEFT JOIN elibrary el ON en.id_elibrary = el.id
			LEFT JOIN elibrary_peminjam ep ON elp.nokp=ep.nokp
			LEFT JOIN lkp_elibrary_jenis lkj ON el.id_jenis=lkj.id
			ORDER BY elp.id DESC";
	$result = $conn->query($sql);
	return $result;
}

function getTransaksiPinjamanList($status){
	$conn=db();
	$sql = "SELECT DATE_ADD(elp.tarikh_pinjam, INTERVAL (elp.bil_hari_pinjam) DAY) AS tarikh_akhir,
elp.id_naskah, ep.nokp,ep.nama,ep.notel,elp.tarikh_pinjam,elp.tarikh_hantar,elp.id,
el.id AS id_kandungan,el.nama AS nama_kandungan_digital,lkj.jenis
			FROM elibrary_pinjaman elp
			LEFT JOIN elibrary_naskah enas ON elp.id_naskah=enas.id
			LEFT JOIN elibrary el ON enas.id_elibrary=el.id
			LEFT JOIN elibrary_peminjam ep ON elp.nokp=ep.nokp
			LEFT JOIN lkp_elibrary_jenis lkj ON el.id_jenis=lkj.id
			WHERE elp.status='$status' ORDER BY elp.id DESC";
	$result = $conn->query($sql);
	return $result;
}

function getTransaksiPinjamanByNokp($nokp){
	$conn=db();
	$sql = "SELECT DATE_ADD(elp.tarikh_pinjam, INTERVAL (elp.bil_hari_pinjam) DAY) AS tarikh_akhir, elp.*,el.nama AS nama_kandungan_digital,lkj.jenis
			FROM elibrary_pinjaman elp
			LEFT JOIN elibrary_naskah enas ON elp.id_naskah=enas.id
			LEFT JOIN elibrary el ON  enas.id_elibrary=el.id
			LEFT JOIN lkp_elibrary_jenis lkj ON el.id_jenis=lkj.id
			WHERE elp.nokp='$nokp'
			ORDER BY elp.id DESC";
	$result = $conn->query($sql);
	return $result;
}

function getJumlahPeminjam(){
	$conn=db();
	$sql = "SELECT DATE_ADD(elp.tarikh_pinjam, INTERVAL (elp.bil_hari_pinjam) DAY) AS tarikh_akhir,elp.*,ep.nama,ep.notel,el.nama AS nama_kandungan_digital,el.id AS id_kandungan,lkj.jenis 
			FROM elibrary_pinjaman elp
			LEFT JOIN elibrary_naskah en ON elp.id_naskah=en.id
			LEFT JOIN elibrary el ON en.id_elibrary = el.id
			LEFT JOIN elibrary_peminjam ep ON elp.nokp=ep.nokp
			LEFT JOIN lkp_elibrary_jenis lkj ON el.id_jenis=lkj.id
			ORDER BY elp.created_date DESC";
	$result = $conn->query($sql);
	return $result;
}

function getTransaksiTempahanList($status) {
  	$conn = db();
  	$sql = "SELECT etem.id AS id_tempahan,etem.anggaran_tarikh_tempah,etem.status_urgent,etem.status,epem.nama,epem.nokp AS nokp,epem.notel,e.nama AS tajuk,e.id AS id_kandungan,etem.id_naskah FROM elibrary_tempahan etem
			LEFT JOIN elibrary_peminjam epem ON etem.nokp=epem.nokp
			LEFT JOIN elibrary e ON etem.id_elibrary=e.id
      WHERE etem.status= '$status' ORDER BY etem.id DESC";
  	$result = $conn->query($sql);
  	return $result;
}

function getTempahanList($status) {
  	$conn = db();
  	$sql = "SELECT etem.id AS id_tempahan,etem.anggaran_tarikh_tempah,etem.status_urgent,etem.status,etem.created_date,epem.nama,epem.nokp AS nokp,epem.notel,e.nama AS tajuk,e.id AS id_kandungan,etem.id_naskah,lkj.jenis FROM elibrary_tempahan etem
			LEFT JOIN elibrary_peminjam epem ON etem.nokp=epem.nokp
			LEFT JOIN elibrary e ON etem.id_elibrary=e.id
			LEFT JOIN lkp_elibrary_jenis lkj ON e.id_jenis=lkj.id
      WHERE etem.status= '$status' ORDER BY etem.id DESC";
  	$result = $conn->query($sql);
  	return $result;
}

function getSenaraiTempahan($status_pinjam,$status_naskah) {
  	$conn = db();
  	$sql = "SELECT el.*,lkj.jenis FROM elibrary el
  		LEFT JOIN lkp_elibrary_jenis lkj ON el.id_jenis=lkj.id
  		WHERE el.status_pinjam = '1' AND el.status_naskah ='1' ORDER BY el.id DESC";
  	$result = $conn->query($sql);
  	return $result;
}
//end syafiqah 31-07-2019

//start syafiqah 01-08-2019
function getPinjamanList(){
	$conn=db();
	$sql = "SELECT el.*,lkj.id AS jenis_id, lkj.jenis AS jenis FROM elibrary el
			LEFT JOIN lkp_elibrary_jenis lkj ON el.id_jenis=lkj.id 
			ORDER BY el.id DESC";
	$result = $conn->query($sql);
	return $result;
}
//end syafiqah 01-08-2019

//start niena 01-08-2019
function getAnalisaPinjamMonth($value) {
 	$conn=db();
 	$sql = "SELECT COUNT(epin.id) AS bil_pinjam FROM elibrary_pinjaman epin
   			WHERE date_format(epin.tarikh_pinjam,'%Y%m') = '$value'";

 	$result = $conn->query($sql);
 	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return $row[0];
	}else{
		return '';
	}
}

function getAnalisaPinjamYear($value) {
 	$conn=db();
 	$sql = "SELECT COUNT(epin.id) AS bil_pinjam FROM elibrary_pinjaman epin
   			WHERE date_format(epin.tarikh_pinjam,'%Y') = '$value'";

 	$result = $conn->query($sql);
 	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return $row[0];
	}else{
		return '';
	}
}

function getTempahanById($id_tempahan){
 	$conn=db();
 	$sql = "SELECT * FROM elibrary_tempahan 
   			WHERE id= '$id_tempahan'";
 	$result = $conn->query($sql);
 	return $result;
}

function getJenisById($id_jenis) {
	$conn=db();
	$sql = "SELECT *
			FROM lkp_elibrary_jenis
			WHERE id='$id_jenis'";
	$result = $conn->query($sql);
	return $result;
}

function getAnalisaJenis($id_jenis) {
	$conn=db();
	$sql = "SELECT lej.id AS id_jenis, lej.jenis,
			e.id AS id_library, e.nama AS nama_library, e.bil_naskah_hardcopy, e.frontpage_cover_file
			FROM lkp_elibrary_jenis lej 
			LEFT JOIN elibrary e ON lej.id=e.id_jenis
			WHERE lej.id='$id_jenis'";
	$result = $conn->query($sql);
	return $result;
}

function getAnalisaOverdueDetails($id_jenis,$status,$tarikh) {
	$conn=db();
	$sql = "SELECT epin.id AS id_pinjaman, epin.tarikh_pinjam,epin.tarikh_hantar, epem.id AS id_peminjam, enas.id AS id_naskah, e.id AS id_library, e.nama AS nama_library, 
			lej.id AS id_jenis, lej.jenis, epem.nama AS nama_peminjam,epem.nokp, epem.notel
			FROM elibrary_pinjaman epin 
			LEFT JOIN elibrary_peminjam epem ON epin.nokp=epem.nokp
			LEFT JOIN elibrary_naskah enas ON epin.id_naskah=enas.id
			LEFT JOIN elibrary e ON enas.id_elibrary=e.id
			LEFT JOIN lkp_elibrary_jenis lej ON e.id_jenis=lej.id
			WHERE epin.status='$status' AND lej.id='$id_jenis' AND $tarikh>DATE_ADD(epin.tarikh_pinjam, INTERVAL (epin.bil_hari_pinjam) DAY)";
	$result = $conn->query($sql);
	return $result;
}

function getPeminjamList($status){
  $conn=db();
  $sql = "SELECT DATE_ADD(elp.tarikh_pinjam, INTERVAL (elp.bil_hari_pinjam) DAY) AS tarikh_akhir,
elp.id_naskah, ep.nokp,ep.nama,ep.notel,elp.tarikh_pinjam,elp.tarikh_hantar,elp.id,
el.id AS id_kandungan,el.nama AS nama_kandungan_digital,lkj.jenis 
      FROM elibrary_pinjaman elp
      LEFT JOIN elibrary_naskah enas ON elp.id_naskah=enas.id
      LEFT JOIN elibrary el ON enas.id_elibrary=el.id
      LEFT JOIN elibrary_peminjam ep ON elp.nokp=ep.nokp
      LEFT JOIN lkp_elibrary_jenis lkj ON el.id_jenis=lkj.id
      WHERE elp.status='$status' ORDER BY elp.created_date DESC";
  $result = $conn->query($sql);
  return $result;
}

//end niena 01-08-2019

//start nik 01-08-2019
//imbas pinjaman
function setProsesPinjaman($nama, $nokp, $notel, $created_by,$someArray){
  	$conn=db();
  	$sql = "select id from elibrary_peminjam where nokp='$nokp'";

    $checkId= $conn->query($sql)->fetch_object()->id;
     	if($checkId > 0){
       		//update
       		$sql1 = "UPDATE elibrary_peminjam set nama='$nama', nokp='$nokp', notel='$notel' 
       				where id='$checkId'";
      
      	$result=$conn->query($sql1);
     	}else{
       		//insert peminjam
       		$sql2 = "INSERT INTO elibrary_peminjam (nama,nokp,notel) VALUES ('$nama','$nokp','$notel')";
      		$result=$conn->query($sql2);
     	}
    	foreach ($someArray as $key => $value) {
    		$id_naskah = $value["id_naskah"];
    		$sql = "SELECT id FROM elibrary_tempahan WHERE nokp='$nokp' AND id_naskah='$id_naskah'";
    		$result2=$conn->query($sql);
    		$id_tempahan=$conn->query($sql)->fetch_object()->id;
          	$add_pinjaman = insertPinjaman($nokp,$value["id_naskah"],$value["bil_hari_pinjam"],$created_by);
          	if($add_pinjaman){
          		if($result2->num_rows>0){
	    			$sql3="UPDATE elibrary_tempahan SET status='1' WHERE id='$id_tempahan';";
	    			$result3=$conn->query($sql3);
	    		}
          	}
          	
        }

  	return $result;
}

function insertPinjaman($nokp,$id_naskah,$bil_hari_pinjam,$created_by){
  	$conn=db();
  	$sql_ada = "SELECT * FROM elibrary_pinjaman WHERE 
				id_naskah ='$id_naskah' AND status='0'";
	$result_ada=$conn->query($sql_ada);
	if($result_ada->num_rows>0){
		return 0;
	}
  	$sql = "INSERT INTO elibrary_pinjaman (id_naskah,nokp,tarikh_pinjam,bil_hari_pinjam,created_by)
    		VALUES ('$id_naskah','$nokp',CURRENT_TIME,'$bil_hari_pinjam','$created_by')";
  	$result=$conn->query($sql);
  	return $result;
}

function logPemulangan($tarikh){
  	$conn=db();
    $sql = "SELECT elp.tarikh_hantar,DATE_ADD(elp.tarikh_pinjam, INTERVAL (elp.bil_hari_pinjam) DAY) AS tarikh_akhir,el.nama AS nama_bahan,ep.nama
    		FROM elibrary_pinjaman elp
    		LEFT JOIN elibrary_naskah en ON elp.id_naskah=en.id
    		LEFT JOIN elibrary el ON en.id_elibrary = el.id
    		LEFT JOIN elibrary_peminjam ep ON elp.nokp=ep.nokp
    		WHERE elp.tarikh_hantar='$tarikh' AND elp.status='1' ORDER BY elp.created_date DESC";
  	$result=$conn->query($sql);
  	return $result;
}
//end nik 01-08-2019

//start niena 4-8-2019
function getAnalisaLewatByMonth($value) {
	$conn=db();
	$sql = "SELECT COUNT(epin.id) AS bilangan_pinjam 
			FROM lkp_elibrary_jenis lej 
			LEFT JOIN elibrary e ON e.id_jenis = lej.id
			LEFT JOIN elibrary_naskah enas ON enas.id_elibrary=e.id
			LEFT JOIN elibrary_pinjaman epin ON epin.id_naskah = enas.id
			WHERE epin.STATUS='1'
			AND epin.tarikh_hantar > DATE_ADD(epin.tarikh_pinjam, INTERVAL (epin.bil_hari_pinjam) DAY)
			AND date_format(epin.tarikh_hantar,'%Y%m') = '$value'";
	$result = $conn->query($sql);
 	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return $row[0];
	}else{
		return '';
	}
}

function getAnalisaPinjamWeek($start,$end) {
 	$conn=db();
 	$sql = "SELECT COUNT(epin.id) AS bil_pinjam FROM elibrary_pinjaman epin
   			WHERE date_format(epin.tarikh_pinjam,'%y-%m-%d') 
			BETWEEN DATE_FORMAT('$start','%y-%m-%d') AND DATE_FORMAT('$end','%y-%m-%d')";

 	$result = $conn->query($sql);
 	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return $row[0];
	}else{
		return '';
	}
}

function getAnalisaLewatByWeek($start,$end) {
 	$conn=db();
 	$sql = "SELECT COUNT(epin.id) AS bilangan_pinjam 
			FROM lkp_elibrary_jenis lej 
			LEFT JOIN elibrary e ON e.id_jenis = lej.id
			LEFT JOIN elibrary_naskah enas ON enas.id_elibrary=e.id
			LEFT JOIN elibrary_pinjaman epin ON epin.id_naskah = enas.id
			WHERE epin.STATUS='1'
			AND epin.tarikh_hantar > DATE_ADD(epin.tarikh_pinjam, INTERVAL (epin.bil_hari_pinjam) DAY)
			AND date_format(epin.tarikh_hantar,'%y-%m-%d') 
			BETWEEN DATE_FORMAT('$start','%y-%m-%d') AND DATE_FORMAT('$end','%y-%m-%d')";

 	$result = $conn->query($sql);
 	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return $row[0];
	}else{
		return '';
	}
}

function getAnalisaPinjamanByMonth($id_jenis) {
	$conn=db();
	$sql = "SELECT lej.id AS id_jenis,enas.id AS id_naskah, COUNT(epin.id) AS bilangan_pinjam 
			FROM lkp_elibrary_jenis lej 
			LEFT JOIN elibrary e ON e.id_jenis = lej.id 
			LEFT JOIN elibrary_naskah enas ON enas.id_elibrary=e.id
			LEFT JOIN elibrary_pinjaman epin ON epin.id_naskah = enas.id 
			WHERE lej.id='$id_jenis' AND epin.`status`='0' and CURRENT_DATE >= epin.tarikh_pinjam
			GROUP BY lej.id";
	$result = $conn->query($sql);
	return $result;
}

function getAnalisaPinjamanLibrary($id_jenis,$status,$value) {
	$conn=db();
	$sql = "SELECT lej.id AS id_jenis, COUNT(epin.id) AS bilangan_pinjam 
			FROM lkp_elibrary_jenis lej 
			LEFT JOIN elibrary e ON e.id_jenis = lej.id 
			LEFT JOIN elibrary_naskah enas ON enas.id_elibrary=e.id
			LEFT JOIN elibrary_pinjaman epin ON epin.id_naskah = enas.id 
			WHERE epin.status='$status' AND lej.id='$id_jenis' AND date_format(epin.tarikh_pinjam,'%Y%m') = '$value'
			GROUP BY lej.id";
	$result = $conn->query($sql);
	return $result;
}

function getAnalisaLewatLibrary($id_jenis,$status,$condition,$value) {
	$conn=db();
	$sql = "SELECT COUNT(epin.id) AS bilangan_pinjam, DATE_ADD(epin.tarikh_pinjam, INTERVAL (epin.bil_hari_pinjam) DAY) AS tarikh_akhir,epin.id,lej.id AS id_jenis 
			FROM lkp_elibrary_jenis lej 
			LEFT JOIN elibrary e ON e.id_jenis = lej.id
			LEFT JOIN elibrary_naskah enas ON enas.id_elibrary=e.id
			LEFT JOIN elibrary_pinjaman epin ON epin.id_naskah = enas.id
			WHERE epin.STATUS='$status' AND lej.id='$id_jenis'
			AND $condition > DATE_ADD(epin.tarikh_pinjam, INTERVAL (epin.bil_hari_pinjam) DAY) 
			AND date_format($condition,'%Y%m') = '$value'";
	$result = $conn->query($sql);
	return $result;
}

function getAnalisaPeminjamYear($value) {
 	$conn=db();
 	$sql = "SELECT COUNT(epem.id) AS bil_peminjam FROM elibrary_peminjam epem
   			WHERE DATE_FORMAT(epem.created_date,'%Y') <= '$value'";

 	$result = $conn->query($sql);
 	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return $row[0];
	}else{
		return '';
	}
}

function tempahanTambah($id_library,$status,$nokp,$status_urgent,$anggaran_tarikh_tempah){
 $conn=db();
 $sql = "SELECT en.id FROM elibrary_naskah en
   LEFT JOIN elibrary_pinjaman ep ON en.id=ep.id_naskah
   LEFT JOIN elibrary_tempahan et ON en.id_elibrary=et.id_elibrary
   WHERE (en.id NOT IN(SELECT et.id_naskah FROM elibrary_tempahan et
   WHERE et.id_elibrary='$id_library' AND et.STATUS='0')) AND en.id_elibrary='$id_library' AND ep.STATUS='0'
   ORDER BY ABS( DATEDIFF(DATE_ADD(ep.tarikh_pinjam, INTERVAL (ep.bil_hari_pinjam) DAY), '$anggaran_tarikh_tempah')) LIMIT 1";
 $naskah_result=$conn->query($sql);
 $id_naskah=$conn->query($sql)->fetch_object()->id;
 if($naskah_result->num_rows>0){
  $sql2= "INSERT INTO elibrary_tempahan (id_elibrary, id_naskah, nokp, status, status_urgent, anggaran_tarikh_tempah) 
   VALUES ('$id_library','$id_naskah','$nokp','$status','$status_urgent','$anggaran_tarikh_tempah')";
  $result=$conn->query($sql2);
 }else{
  $sql = "SELECT id_naskah, COUNT(id) AS bil FROM elibrary_tempahan WHERE id_elibrary='3' GROUP BY id_naskah ORDER BY bil ASC LIMIT 1";
  $id_naskah=$conn->query($sql)->fetch_object()->id_naskah;
  $sql2= "INSERT INTO elibrary_tempahan (id_elibrary, id_naskah, nokp, status, status_urgent, anggaran_tarikh_tempah) 
   VALUES ('$id_library','$id_naskah','$nokp','$status','$status_urgent','$anggaran_tarikh_tempah')";
  $result=$conn->query($sql2);

 }
 
 return $result;
}

function getBookingList($status) {
	$conn=db();
	$sql = "SELECT et.id AS id_tempahan, et.status_urgent,et.status, et.anggaran_tarikh_tempah,
			e.id AS id_library, e.nama AS nama_library,
			ep.nokp, ep.nama AS nama_peminjam, ep.notel, lej.id AS id_jenis, lej.jenis
			FROM elibrary_tempahan et
			LEFT JOIN elibrary_peminjam ep ON et.nokp=ep.nokp
			LEFT JOIN elibrary e ON et.id_elibrary=e.id
			LEFT JOIN lkp_elibrary_jenis lej ON e.id_jenis=lej.id
			WHERE et.status='$status' ORDER BY et.id DESC";
	$result = $conn->query($sql);
	return $result;
}


//... 5-8-2019
function getLibraryByJenis($id_jenis){
	$conn=db();
	$sql = "SELECT lej.id AS id_jenis, lej.jenis,
			e.id AS id_elibrary, e.nama AS tajuk, e.lokasi_fizikal_hardcopy, e.isbn,
			en.id AS id_naskah
			FROM lkp_elibrary_jenis lej
			LEFT JOIN elibrary e ON lej.id=e.id_jenis
			LEFT JOIN elibrary_naskah en ON e.id=en.id_elibrary 
			WHERE lej.id='$id_jenis' AND e.status_naskah!='0'";
	$result = $conn->query($sql);
	return $result;
}

function getLibraryByElibrary($id_elibrary){
	$conn=db();
	$sql = "SELECT lej.id AS id_jenis, lej.jenis,
			e.id AS id_elibrary, e.nama AS tajuk, e.lokasi_fizikal_hardcopy, e.isbn,
			en.id AS id_naskah
			FROM elibrary e 
			LEFT JOIN lkp_elibrary_jenis lej ON e.id_jenis=lej.id
			LEFT JOIN elibrary_naskah en ON e.id=en.id_elibrary
			WHERE e.id='$id_elibrary'";
	$result = $conn->query($sql);
	return $result;
}

function getLibrarySemua(){
	$conn=db();
	$sql = "SELECT lej.id AS id_jenis, lej.jenis,
			e.id AS id_elibrary, e.nama AS tajuk, e.lokasi_fizikal_hardcopy, e.isbn,
			en.id AS id_naskah
			FROM lkp_elibrary_jenis lej
			LEFT JOIN elibrary e ON lej.id=e.id_jenis
			LEFT JOIN elibrary_naskah en ON e.id=en.id_elibrary 
			WHERE e.status_naskah!='0'";
	$result = $conn->query($sql);
	return $result;
}

//start syafiqah 06-08-2019
function getAnalisaTempahanByKategori(){
	$conn=db();
	$sql = "SELECT e.id_jenis,lkj.jenis,COUNT(etem.id) AS bil_tempahan
			FROM elibrary_tempahan etem
			LEFT JOIN elibrary_naskah enas ON etem.id_naskah = enas.id
			LEFT JOIN elibrary e ON etem.id_elibrary = e.id
			LEFT JOIN lkp_elibrary_jenis lkj ON e.id_jenis = lkj.id
			WHERE etem.status = '0'
			GROUP BY lkj.jenis ORDER BY bil_tempahan DESC";
	$result = $conn->query($sql);
	return $result;
}

function getAnalisaTempahanByTajuk() {
	$conn=db();
	$sql = "SELECT e.id AS id_library,e.bil_naskah_hardcopy,e.nama,e.id_jenis,lkj.jenis,COUNT(e.id) AS bil_tempahan
			FROM elibrary_tempahan et
			LEFT JOIN elibrary e ON et.id_elibrary = e.id
			LEFT JOIN lkp_elibrary_jenis lkj ON e.id_jenis = lkj.id
			WHERE et.status = '0'
			GROUP BY e.id ORDER BY COUNT(e.id) DESC";
	$result = $conn->query($sql);
	return $result;
}

function getLibraryById($id_library) {
	$conn=db();
	$sql = "SELECT e.*,lkj.jenis FROM elibrary e
			LEFT JOIN lkp_elibrary_jenis lkj ON e.id_jenis = lkj.id
			WHERE e.id='$id_library'";
	$result = $conn->query($sql);
	return $result;
}

function getAnalisaBooking($id_library) {
	$conn=db();
	$sql = "SELECT et.id AS id_tempahan, et.status_urgent,et.status, et.anggaran_tarikh_tempah,
			e.id AS id_library, e.nama AS nama_library,e.id_jenis,lkj.jenis,
			ep.nokp, ep.nama AS nama_peminjam, ep.notel
			FROM elibrary_tempahan et
			LEFT JOIN elibrary_peminjam ep ON et.nokp = ep.nokp
			LEFT JOIN elibrary e ON et.id_elibrary = e.id
			LEFT JOIN lkp_elibrary_jenis lkj ON e.id_jenis = lkj.id
			WHERE et.status='0' AND e.id='$id_library'";
	$result = $conn->query($sql);
	return $result;
}

function getAnalisaPeminjam() {
	$conn=db();
	$sql = "SELECT epin.id AS id_pinjaman,epin.id_naskah,epin.nokp,elp.*,COUNT(epin.id) AS bil_pinjaman 
			FROM elibrary_pinjaman epin
			LEFT JOIN elibrary_peminjam elp ON epin.nokp = elp.nokp
			GROUP BY epin.nokp ORDER BY bil_pinjaman DESC";
	$result = $conn->query($sql);
	return $result;
}

function getPinjamanDetailByNokp($nokp){
	$conn=db();
	$sql = "SELECT elp.*,el.nama AS nama_kandungan_digital,lkj.jenis,eep.nama FROM elibrary_pinjaman elp 
			LEFT JOIN elibrary_naskah enas ON elp.id_naskah=enas.id 
			LEFT JOIN elibrary el ON enas.id_elibrary=el.id 
			LEFT JOIN lkp_elibrary_jenis lkj ON el.id_jenis=lkj.id 
			LEFT JOIN elibrary_peminjam eep ON elp.nokp=eep.nokp
			WHERE elp.nokp='$nokp' ORDER BY elp.id DESC";
	$result = $conn->query($sql);
	return $result;
}

//end syafiqah 06-08-2019

//08-08-2019
function getElibraryInfo($id) {
$conn=db();
$sql = "SELECT enas.id AS id_naskah, enas.id_elibrary,e.frontpage_cover_file, e.isbn,e.lokasi_fizikal_hardcopy,e.nama FROM elibrary_naskah enas
		LEFT JOIN elibrary e ON enas.id_elibrary=e.id
		WHERE enas.id_elibrary = '$id' ORDER BY enas.id ASC";
$result = $conn->query($sql);
return $result;
}
function getElibraryDetails($id) {
$conn=db();
$sql = "SELECT e.*, lj.jenis FROM elibrary e
		LEFT JOIN lkp_elibrary_jenis lj ON e.id_jenis=lj.id
		WHERE e.id = '$id'";
$result = $conn->query($sql);
return $result;
}
function getElibraryChecked($id_elibrary,$id_naskah){
	$conn=db();
	$sql = "SELECT lej.id AS id_jenis, lej.jenis,
			e.id AS id_elibrary, e.nama AS tajuk, e.lokasi_fizikal_hardcopy, e.isbn,
			en.id AS id_naskah
			FROM elibrary e 
			LEFT JOIN lkp_elibrary_jenis lej ON e.id_jenis=lej.id
			LEFT JOIN elibrary_naskah en ON e.id=en.id_elibrary
			WHERE e.id='$id_elibrary' AND en.id IN ($id_naskah)";
	$result = $conn->query($sql);
	return $result;
}
//log analisa -start-
function addLogAnalisaDownload($id_elibrary,$nokp) {
	$conn=db();
	$sql = "INSERT INTO elibrary_log_analisa (id_elibrary,nokp,type) VALUES ('$id_elibrary','$nokp','2')";
	$result = $conn->query($sql);
	return $result;
}
//log analisa -end-

//analisa read online -start-
function getAnalisaReadOnlineByYear($value) {
 	$conn=db();
 	$sql = "SELECT COUNT(*) FROM elibrary_log_analisa
			WHERE type = '1' AND DATE_FORMAT(created_date,'%Y') <= '$value'";
 	$result = $conn->query($sql);
 	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return $row[0];
	}else{
		return '';
	}
}

function getAnalisaReadOnlineByMonth($value) {
	$conn=db();
	$sql = "SELECT COUNT(*) FROM elibrary_log_analisa
			WHERE type = '1' AND DATE_FORMAT(created_date,'%Y%m') = '$value'";
	$result = $conn->query($sql);
 	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return $row[0];
	}else{
		return '';
	}
}

function getAnalisaReadOnlineByWeek($start,$end) {
 	$conn=db();
 	$sql = "SELECT COUNT(*) FROM elibrary_log_analisa
			WHERE type = '1' AND DATE_FORMAT(created_date,'%y-%m-%d') 
			BETWEEN DATE_FORMAT('$start','%y-%m-%d') AND DATE_FORMAT('$end','%y-%m-%d')";
 	$result = $conn->query($sql);
 	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return $row[0];
	}else{
		return '';
	}
}

function getAnalisaReadOnlineByDay($date) {
	$conn=db();
	$sql = "SELECT COUNT(*) FROM elibrary_log_analisa
			WHERE type = '1' AND DATE(created_date)='$date'";
	$result = $conn->query($sql);
	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return $row[0];
	}else{
		return '';
	}
}

function getAnalisaReadOnlineByBahan() {
	$conn=db();
	$sql = "SELECT ela.*,COUNT(ela.id) AS bil_readonline,e.frontpage_cover_file,e.nama FROM elibrary_log_analisa ela
			LEFT JOIN elibrary e ON ela.id_elibrary = e.id
			WHERE ela.type = '1'
			GROUP BY ela.id_elibrary ORDER BY bil_readonline DESC";
	$result = $conn->query($sql);
	return $result;
}
//analisa read online -end-

//analisa download -start-
function getAnalisaDownloadByYear($value) {
 	$conn=db();
 	$sql = "SELECT COUNT(*) FROM elibrary_log_analisa
			WHERE type = '2' AND DATE_FORMAT(created_date,'%Y') <= '$value'";
 	$result = $conn->query($sql);
 	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return $row[0];
	}else{
		return '';
	}
}

function getAnalisaDownloadByMonth($value) {
	$conn=db();
	$sql = "SELECT COUNT(*) FROM elibrary_log_analisa
			WHERE type = '2' AND DATE_FORMAT(created_date,'%Y%m') = '$value'";
	$result = $conn->query($sql);
 	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return $row[0];
	}else{
		return '';
	}
}

function getAnalisaDownloadByWeek($start,$end) {
 	$conn=db();
 	$sql = "SELECT COUNT(*) FROM elibrary_log_analisa
			WHERE type = '2' AND DATE_FORMAT(created_date,'%y-%m-%d') 
			BETWEEN DATE_FORMAT('$start','%y-%m-%d') AND DATE_FORMAT('$end','%y-%m-%d')";
 	$result = $conn->query($sql);
 	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return $row[0];
	}else{
		return '';
	}
}

function getAnalisaDownloadByDay($date) {
	$conn=db();
	$sql = "SELECT COUNT(*) FROM elibrary_log_analisa
			WHERE type = '2' AND DATE(created_date)='$date'";
	$result = $conn->query($sql);
	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return $row[0];
	}else{
		return '';
	}
}

function getAnalisaDownloadByBahan() {
	$conn=db();
	$sql = "SELECT ela.*,COUNT(ela.id) AS bil_download,e.frontpage_cover_file,e.nama FROM elibrary_log_analisa ela
			LEFT JOIN elibrary e ON ela.id_elibrary = e.id
			WHERE ela.type = '2'
			GROUP BY ela.id_elibrary ORDER BY bil_download DESC";
	$result = $conn->query($sql);
	return $result;
}
//analisa download -end-

//analisa niena start 21/9/2019
function getBilanganPelawatDay($date) {
	$conn=db();
	$sql = "SELECT COUNT(pin.id) AS bil_pengunjung FROM elibrary_pinjaman pin
			WHERE DATE(pin.created_date)='$date'
			GROUP BY pin.nokp, pin.created_date";

	$result = $conn->query($sql);
	return "<b><font size='3'>".$result->num_rows."</font></b>";
}

function getBilanganPelawatWeek($start,$end) {
 	$conn=db();
 	$sql = "SELECT COUNT(pin.id) AS bil_pengunjung FROM elibrary_pinjaman pin
   			WHERE date_format(pin.created_date,'%y-%m-%d') 
			BETWEEN DATE_FORMAT('$start','%y-%m-%d') AND DATE_FORMAT('$end','%y-%m-%d')
			GROUP BY pin.nokp, pin.created_date";

 	$result = $conn->query($sql);
 	return $result->num_rows;
}

function getBilanganPelawatMonth($value) {
 	$conn=db();
 	$sql = "SELECT COUNT(pin.id) AS bil_pengunjung FROM elibrary_pinjaman pin
   			WHERE date_format(pin.created_date,'%Y%m') = '$value'
   			GROUP BY pin.nokp";

 	$result = $conn->query($sql);
 	return $result->num_rows;
}

function getBilanganPelawatYear($value) {
 	$conn=db();
 	$sql = "SELECT COUNT(pin.id) AS bil_pengunjung FROM elibrary_pinjaman pin
   			WHERE date_format(pin.created_date,'%Y') = '$value'
   			GROUP BY pin.nokp";

 	$result = $conn->query($sql);
 	return $result->num_rows;
}

function upload_terjemahan($id_elibrary,$language_,$document_filename,$targetDir,$upload_document,$fileType){
	$conn = db();
	
	$sql="INSERT INTO elibrary_terjemahan (id_elibrary,document_file,language) VALUES ('$id_elibrary','$document_filename','$language_')";
	$result=$conn->query($sql);
	$id_terjemahan = $conn->insert_id;
	$document_filename = $id_elibrary.'-'.$id_terjemahan.'.'.$fileType;
	$sql="UPDATE elibrary_terjemahan SET document_file='$document_filename' WHERE id='$id_terjemahan';";
	$target_path_doc = $targetDir.$document_filename;
	move_uploaded_file($upload_document,$target_path_doc);
	$result=$conn->query($sql);
	return $result;
}

function getTerjemahanByElibrary($id_elibrary){
	$conn = db();
	$sql = "SELECT * FROM elibrary_terjemahan WHERE id_elibrary='$id_elibrary'";
	$result = $conn->query($sql);
	return $result;
}

function getTerjemahanById($id){
	$conn = db();
	$sql = "SELECT * FROM elibrary_terjemahan WHERE id='$id'";
	$result = $conn->query($sql);
	return $result;
}

$conn->close();

?>