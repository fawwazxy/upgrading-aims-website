<?php

require '../../lib/db/connection.php';

//niena
$action = $_POST['action'];
if($action == "sumberRemove"){//padam sumber 
	$id = $_POST['row_id'];
	$conn=db();
	$sql = "DELETE FROM acara_sumber WHERE id='$id'";
	$conn->query($sql);
	echo "Data berjaya dipadam";
}else if($action == "speakerRemove"){//padam penceramah
	$id = $_POST['row_id'];
	$conn=db();
	$sql = "DELETE FROM acara_speaker WHERE id='$id'";
	$conn->query($sql);
	echo "Data berjaya dipadam";

}

//end niena
//Start Syafiqah Awang
else if($action == "deleteKumpulan"){
	$id = $_POST['row_id'];
	$conn=db();
	$sql = "DELETE FROM lkp_kumpulan_peserta WHERE id='$id'";
	$conn->query($sql);
	echo "Data berjaya dipadam";

}else if($action == "deletePeserta"){
	$id = $_POST['row_id'];
	$conn=db();
	$sql = "DELETE FROM acara_peserta WHERE id='$id'";
	$conn->query($sql);
	echo "Data berjaya dipadam";
}
//End Syafiqah Awang

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
//nik
function getSesiAcara() {
	$conn=db();
	$sql = "SELECT * FROM acara_sesi
ORDER BY tarikh_mula DESC";
	$result = $conn->query($sql);
	return $result;
}
function getSesiAcaraById($id) {
	$conn=db();
	$sql = "SELECT * FROM acara_sesi where id='$id'";
	$result = $conn->query($sql);
	return $result;
}
function checkStatusAcara($id_sesi) {
	$conn=db();
	$sql = "SELECT COUNT(*) AS bil FROM acara_sesi
WHERE ((CURRENT_DATE BETWEEN tarikh_mula AND tarikh_tamat) OR  (CURRENT_DATE <= tarikh_mula))AND id='$id_sesi'";
	$result = $conn->query($sql);
	return $result->fetch_object()->bil;
}
function addSesiAcara($nama,$lokasi,$tarikh_mula,$tarikh_tamat,$tahun,$created_by) {
	$conn=db();
	$sql = "INSERT INTO acara_sesi (nama,lokasi,tarikh_mula,tarikh_tamat,tahun,created_by)
VALUES ('$nama','$lokasi','$tarikh_mula','$tarikh_tamat','$tahun','$created_by')";
	$result = $conn->query($sql);
	$newid=$conn->insert_id;
	$sql2 = "INSERT INTO lkp_kumpulan_peserta (id_sesi,nama_kumpulan)
VALUES ('$newid','URUSETIA')";
	$result = $conn->query($sql2);
	return $result;
}
function editSesiAcara($id,$nama,$lokasi,$tarikh_mula,$tarikh_tamat,$tahun,$created_by) {
	$conn=db();
	$sql = "UPDATE acara_sesi SET nama='$nama' , lokasi='$lokasi' , tarikh_mula='$tarikh_mula' , tarikh_tamat='$tarikh_tamat' ,tahun='$tahun' , created_by='$created_by'
WHERE id='$id'";
	$result = $conn->query($sql);
	return $result;
}
function getGaleriAcara($id_sesi) {
	$conn=db();
	$sql = "SELECT * FROM acara_galeri
WHERE id_sesi='$id_sesi'";
	$result = $conn->query($sql);
	return $result;
}
function addGaleriAcara($id_sesi,$tajuk_folder) {
	$conn=db();
	$sql = "INSERT INTO acara_galeri (id_sesi,tajuk_folder)
VALUES ('$id_sesi','$tajuk_folder')";
	$result = $conn->query($sql);
	$newid=$conn->insert_id;
	$folder_code=$id_sesi.$newid;
	$sql2 = "UPDATE acara_galeri SET folder_code='$folder_code'
WHERE id='$newid'";
	$result = $conn->query($sql2);
	mkdir("../../acara/galeri/".$folder_code);
	
	return $result;
}
function getGaleriAcaraById($id_galeri) {
	$conn=db();
	$sql = "SELECT * FROM acara_galeri WHERE id='$id_galeri'";
	$result = $conn->query($sql);
	return $result;
}
function editGaleriAcara($id_galeri,$tajuk_folder) {
	$conn=db();
	$sql = "
UPDATE acara_galeri SET tajuk_folder='$tajuk_folder'
WHERE id='$id_galeri'";
	$result = $conn->query($sql);
	return $result;
}
function getAturcara($id_sesi,$tarikh) {
	$conn=db();
	$sql = "SELECT id,id_sesi,tarikh,DATE_FORMAT(masa_mula,'%H:%i') AS masa_mula,DATE_FORMAT(masa_tamat,'%H:%i') AS masa_tamat,tajuk,kategori,lokasi, youtube_link, lagu_tema_filename, lagu_tema_status ,rating,qna
            FROM acara_aturcara
			WHERE id_sesi='$id_sesi' AND tarikh='$tarikh' 
			ORDER BY masa_mula ASC";
	$result = $conn->query($sql);
	return $result;
}

//11-7-2019
function getPesertaHadir($id_sesi,$tarikh) {
	$conn=db();
	$sql = "SELECT p.nama,DATE_FORMAT(ak.tarikh,'%H:%i:%s') AS masa,ak.status,kp.nama_kumpulan,ak.nokp FROM acara_kehadiran ak
			LEFT JOIN acara_peserta p ON ak.nokp=p.nokp 
			LEFT JOIN lkp_kumpulan_peserta kp ON p.kumpulan=kp.id 
			WHERE ak.nokp IN (SELECT ap.nokp FROM acara_peserta ap WHERE ap.id_sesi='$id_sesi') AND 
			DATE_FORMAT(ak.tarikh,'%Y-%m-%d')='$tarikh' AND ak.id_sesi='$id_sesi'
			GROUP BY ak.nokp ORDER BY DATE_FORMAT(ak.tarikh,'%H:%i:%s') ASC";
	$result = $conn->query($sql);
	return $result;
}
function getPesertaTidakHadir($id_sesi,$tarikh) {
	$conn=db();
	$sql = "SELECT p.nama,kp.nama_kumpulan,p.nokp FROM acara_peserta p 
	        LEFT JOIN lkp_kumpulan_peserta kp ON p.kumpulan=kp.id 
			WHERE p.nokp NOT IN(SELECT ak.nokp FROM acara_kehadiran ak WHERE DATE_FORMAT(ak.tarikh,'%Y-%m-%d')='$tarikh') AND p.id_sesi='$id_sesi' 
			ORDER BY kp.nama_kumpulan ASC,p.nama ASC";
	$result = $conn->query($sql);
	return $result;
}

//end nik
//niena
function aturcaraAddEdit($id,$id_sesi,$tarikh,$masa_mula,$masa_tamat,$tajuk,$kategori,$status_lagu_tema,$rating,$qna,$created_by) {
	$conn=db();
	if($id == ""){
		$sql = "INSERT INTO acara_aturcara (id_sesi,tarikh,masa_mula,masa_tamat,tajuk,kategori,lagu_tema_status,rating,qna,created_by)
				VALUES ('$id_sesi','$tarikh','$masa_mula','$masa_tamat','$tajuk','$kategori','$status_lagu_tema','$rating','$qna','$created_by')";
	}else{
		$sql = "UPDATE acara_aturcara SET masa_mula='$masa_mula',masa_tamat='$masa_tamat',tajuk='$tajuk',kategori='$kategori',lagu_tema_status='$status_lagu_tema',rating='$rating',qna='$qna' WHERE id='$id'";
	}
	
	$result = $conn->query($sql);
	return $result;
}

function youtubeLinkEdit($id,$id_sesi,$youtube_link){
	$conn=db();
	$sql = "UPDATE acara_aturcara SET youtube_link='$youtube_link' WHERE id='$id' AND id_sesi='$id_sesi'";
	$result = $conn->query($sql);
	return $result;
}
//edit 10/7/2019
function musicEdit($id,$id_sesi,$lagu_tema){
	$conn=db();
	$sql = "UPDATE acara_aturcara SET lagu_tema_filename='$lagu_tema' WHERE id='$id' AND id_sesi='$id_sesi'";
	$result = $conn->query($sql);
	return $result;
}

function getSumberAcara($id_sesi){
	$conn = db();
	$sql = "SELECT * FROM acara_sumber
			WHERE id_sesi = '$id_sesi'";
	$result = $conn->query($sql);
	return $result;
}

function getSumberKandungan($id){
	$conn = db();
	$sql = "SELECT * FROM acara_sumber
			WHERE id = '$id'";
	$result = $conn->query($sql);
	return $result;
}
//edit 10/07/2019
function sumberAddEdit($id,$id_sesi,$created_by,$kategori,$tajuk,$kandungan){
	$conn = db();
	if($id > 0){
        	$sql = "UPDATE acara_sumber set kategori=UPPER('$kategori'),tajuk=UPPER('$tajuk'),kandungan_filename='$kandungan' WHERE id='$id' ";
        
    }else {
         $sql = "INSERT INTO acara_sumber (id_sesi, kategori, tajuk, kandungan_filename, created_by) values ('$id_sesi', UPPER('$kategori'), UPPER('$tajuk'), '$kandungan', '$created_by')";
	}
	
	$result = $conn->query($sql);
	return $result;
}

function getSpeakerAcara($id_aturcara){
	$conn = db();
	$sql = "SELECT acs.*, acp.nama AS speaker_name, acp.jawatan AS speaker_jawatan, acp.notel AS speaker_tel,acp.photo_filename AS speaker_photo 
	        FROM acara_speaker acs 
	        LEFT JOIN acara_peserta acp ON acp.nokp = acs.nokp_peserta 
	        LEFT JOIN acara_aturcara aa ON acs.id_aturcara=aa.id 
	        WHERE acs.id_aturcara = '$id_aturcara' GROUP BY acp.nokp";
			
			
	$result = $conn->query($sql);
	return $result;
}

function getPesertaAcara($id_sesi,$id_aturcara){
  $conn = db();
  $sql = "SELECT * FROM acara_peserta
WHERE nokp NOT IN ((SELECT nokp_peserta FROM acara_speaker WHERE id_aturcara='$id_aturcara')) AND id_sesi='$id_sesi'";
  $result = $conn->query($sql);
  return $result;
}
//
function addAcaraSpeaker($id_aturcara,$nokp_peserta){
  $conn = db();
  $sql = "INSERT INTO acara_speaker (id_aturcara,nokp_peserta)
VALUES ('$id_aturcara','$nokp_peserta')";
  $result = $conn->query($sql);
  return $result;
}

function getThumbnail($youtube_link){
	$conn = db();
	$linked = explode("?v=", $youtube_link);
	$link_id = $linked[1];
	echo '<iframe width="200" height="150" src="https://www.youtube.com/embed/'.$link_id.'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
	$sql = "SELECT * FROM acara_aturcara WHERE youtube_link = '$youtube_link'";
	$result = $conn->query($sql);
	return $result;
}

function getAturcaraAcara($id){
	$conn = db();
	$sql = "SELECT * FROM acara_aturcara
			WHERE id = '$id'";
	$result = $conn->query($sql);
	return $result;
}

function getKehadiranAcara($id_sesi,$tarikh){
	$conn = db();
	$sql = "SELECT ak.*,ap.photo_filename AS peserta_photo,ap.nama AS peserta_nama 
	        FROM acara_kehadiran ak
			LEFT JOIN acara_peserta ap ON ap.nokp = ak.nokp
			WHERE ak.nokp IN (SELECT app.nokp FROM acara_peserta app WHERE app.id_sesi='$id_sesi') AND ak.id_sesi = '$id_sesi' AND ak.tarikh LIKE '$tarikh%' GROUP BY ak.nokp ORDER BY ak.tarikh DESC LIMIT 50";
	$result = $conn->query($sql);
	return $result;
}

//edit 11/7/2019
function addPesertaExcel($id_sesi,$nokp,$nama,$notel,$id_kumpulan,$created_by){
	$conn = db();
	$sql = "INSERT INTO acara_peserta (id_sesi,nokp,nama,notel,kumpulan,created_by) VALUES ('$id_sesi','$nokp',UPPER('$nama'),'$notel','$id_kumpulan','$created_by')";
	$result = $conn->query($sql);
	return $result;
}

function getPeratusanKehadiran($id_sesi,$tarikh){
	$conn = db();
	$sql = "SELECT (SELECT COUNT(ap.id) FROM acara_peserta ap WHERE ap.id_sesi='$id_sesi') AS bilangan_peserta, 
			(SELECT COUNT(ak.id) FROM acara_kehadiran ak WHERE ak.nokp IN (SELECT app.nokp from acara_peserta app where app.id_sesi='$id_sesi') AND ak.id_sesi='$id_sesi' AND ak.tarikh LIKE '$tarikh%') AS bilangan_hadir
			FROM acara_kehadiran ak
			LEFT JOIN acara_peserta ap ON ap.nokp = ak.nokp
			WHERE ak.id_sesi = '$id_sesi' AND ak.tarikh LIKE '$tarikh%' GROUP BY ap.id_sesi LIMIT 1";
			
	$result = $conn->query($sql);
	return $result;
}
//end niena



//Start Syafiqah Awang
function getKumpulan($tablename,$value,$text,$selected,$id_sesi) {
	$conn=db();
	$sql = "SELECT ".$value.",".$text." FROM $tablename WHERE id_sesi = '$id_sesi'";
	
	$result = $conn->query($sql);
	
	$txt_result="";
	while ($row  = $result -> fetch_array()){
		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
	}
	//$conn->close();
	return $txt_result;
}

function getListTagPeserta($id_sesi) {
$conn=db();
$sql = "SELECT ap.*,acs.nama AS nama_sesi,acs.tarikh_mula,acs.tarikh_tamat,acs.lokasi,acs.pasmasuk_filename FROM acara_peserta ap
   		LEFT JOIN acara_sesi acs ON ap.id_sesi = acs.id
   		WHERE ap.id_sesi = '$id_sesi'";
$result = $conn->query($sql);
return $result;
}

function getInfoTagPeserta($id_sesi,$nokp) {
$conn=db();
$sql = "SELECT ap.*,acs.nama AS nama_sesi,acs.tarikh_mula,acs.tarikh_tamat,acs.lokasi,lk.nama_kumpulan,acs.pasmasuk_filename FROM acara_peserta ap
   		LEFT JOIN acara_sesi acs ON ap.id_sesi = acs.id
   		LEFT JOIN lkp_kumpulan_peserta lk ON ap.kumpulan = lk.id
   		WHERE ap.id_sesi = '$id_sesi' AND ap.nokp = '$nokp'";
 $result = $conn->query($sql);
 return $result;
}

function getKumpulanList($id_sesi) {
	$conn=db();
	$sql = "SELECT lk.id AS kumpulan_id, lk.*,acs.* FROM lkp_kumpulan_peserta lk
			LEFT JOIN acara_sesi acs ON lk.id_sesi = acs.id
			WHERE lk.id_sesi = '$id_sesi' ORDER BY lk.id DESC";
	$result = $conn->query($sql);
	return $result;
}

function getPesertaList($id_sesi) {
	$conn=db();
	$sql = "SELECT ap.*,acs.nama AS nama_sesi,acs.lokasi,acs.tarikh_mula,acs.tarikh_tamat,lk.nama_kumpulan FROM acara_peserta ap
			LEFT JOIN lkp_kumpulan_peserta lk ON ap.kumpulan = lk.id
			LEFT JOIN acara_sesi acs ON lk.id_sesi = acs.id
			WHERE ap.id_sesi = '$id_sesi' ORDER BY ap.id DESC";
	$result = $conn->query($sql);
	return $result;
}

function kumpulanAddEdit($id,$id_sesi,$nama_kumpulan,$daftar_online){
	$conn=db();
	  
		if($id > 0){
		   		$sql = "UPDATE lkp_kumpulan_peserta set nama_kumpulan=UPPER('$nama_kumpulan'),daftar_online='$daftar_online' WHERE id='$id' ";
		}else{
	      	
   			$sql = "INSERT INTO lkp_kumpulan_peserta (id_sesi,nama_kumpulan,daftar_online) 
   			values ('$id_sesi',UPPER('$nama_kumpulan'),'$daftar_online')";
	    }

	  	$result = $conn->query($sql) or die($conn->error);
	  	return $result;
	}
//edit 10/07/2019
function pesertaAddEdit($id,$id_sesi,$nokp,$nama,$notel,$kumpulan,$jawatan,$photo,$created_by){
	$conn=db();
	  
	if($id > 0){
	   
	   		$sql = "UPDATE acara_peserta set nokp='$nokp',nama=UPPER('$nama'),notel='$notel',jawatan='$jawatan',kumpulan='$kumpulan',photo_filename='$photo' WHERE id='$id' ";
		
	}else{
      	
			 $sql = "INSERT INTO acara_peserta (id_sesi,nokp,nama,notel,kumpulan,jawatan,created_by) 
			values ('$id_sesi','$nokp',UPPER('$nama'),'$notel','$kumpulan','$jawatan','$created_by')";
    }

  	$result = $conn->query($sql) or die($conn->error);
  	return $result;
}
function uploadPesertaExcel($id_sesi,$nokp,$nama,$notel,$created_by) {
	$conn=db();
	$sql = "INSERT INTO acara_peserta (id_sesi,nokp,nama,notel,created_by)
VALUES ('$id_sesi','$nokp','$nama','$notel','$created_by')";
	$result = $conn->query($sql);
	return $result;
}

//11-7-2019
function getListSijilPeserta($id_sesi) {
	$conn=db();
	$sql = "SELECT ak.id AS kehadiran,ak.nokp,ap.nama,ap.id,acs.nama AS nama_sesi,acs.tarikh_mula,acs.tarikh_tamat,acs.lokasi,acs.pasmasuk_filename,k.nama_kumpulan FROM acara_kehadiran ak
			LEFT JOIN acara_peserta ap ON ak.nokp=ap.nokp
			LEFT JOIN acara_sesi acs ON ak.id_sesi=acs.id 
			LEFT JOIN lkp_kumpulan_peserta k ON ap.kumpulan=k.id 
			WHERE ak.id_sesi='$id_sesi'
			GROUP BY ak.nokp";
	$result = $conn->query($sql);
	return $result;
}

function getInfoSijilPeserta($id_sesi,$nokp) {
	$conn=db();
	$sql = "SELECT ak.*,ap.nama,acs.nama AS nama_sesi,acs.tarikh_mula,acs.tarikh_tamat,acs.lokasi,acs.pasmasuk_filename,k.nama_kumpulan FROM acara_kehadiran ak
			LEFT JOIN acara_peserta ap ON ak.nokp=ap.nokp
			LEFT JOIN acara_sesi acs ON ak.id_sesi=acs.id
			LEFT JOIN lkp_kumpulan_peserta k ON ap.kumpulan=k.id 
			WHERE ak.id_sesi = '$id_sesi' AND ak.nokp = '$nokp'";
	$result = $conn->query($sql);
	return $result;
}

//End Syafiqah Awang
//latest
function editPasMasukFilename($id_sesi,$pasmasuk_filename) {
	$conn=db();
	$sql = "UPDATE acara_sesi SET pasmasuk_filename='$pasmasuk_filename'
			WHERE id='$id_sesi'";
	$result = $conn->query($sql);
	return $result;
}
function getPhotoFilenamePeserta($nokp) {
	$conn=db();
	$sql = "SELECT * FROM acara_peserta
			WHERE nokp='$nokp'
			GROUP BY nokp";
	$result = $conn->query($sql);
	return $result;
}
function uploadGambarPeserta($nokp,$photo_filename) {
	$conn=db();
	$sql = "UPDATE acara_peserta SET photo_filename='$photo_filename'
			WHERE nokp='$nokp'";
	$result = $conn->query($sql);
	return $result;
}

//14/7/2019
function getSesiAcaraByTahun($tahun) {
	$conn=db();
	$sql = "SELECT * FROM acara_sesi where tahun='$tahun'
ORDER BY tarikh_mula DESC";
	$result = $conn->query($sql);
	return $result;
}
function getKumpulanBasedOnSesi($id_sesi) {
	$conn=db();
	$sql = "SELECT * FROM lkp_kumpulan_peserta WHERE id_sesi='$id_sesi'";
	$result = $conn->query($sql);
	return $result;
}
function getBilKeselurahanPesertaBasedOnSesi($id_sesi) {
	$conn=db();
	$sql = "SELECT COUNT(*) AS bil FROM acara_peserta 
WHERE id_sesi='$id_sesi'";
	$result = $conn->query($sql);
	return $result->fetch_object()->bil;
}
function getBilPesertaHadirBasedOnSesi($id_sesi) {
	$conn=db();
	$sql = "SELECT COUNT(DISTINCT(ak.nokp)) AS bil FROM acara_kehadiran ak 
           WHERE ak.nokp IN (SELECT ap.nokp FROM acara_peserta ap WHERE ap.id_sesi='$id_sesi') AND ak.id_sesi='$id_sesi'";
	$result = $conn->query($sql);
	return $result->fetch_object()->bil;
}
function getBilKeselurahanPesertaBasedOnSesiKumpulan($id_sesi,$id_kumpulan) {
	$conn=db();
	$sql = "SELECT COUNT(*) AS bil FROM acara_peserta 
WHERE id_sesi='$id_sesi' AND kumpulan='$id_kumpulan'";
	$result = $conn->query($sql);
	return $result->fetch_object()->bil;
}
function getBilPesertaHadirBasedOnSesiKumpulan($id_sesi,$id_kumpulan) {
	$conn=db();
	$sql = "SELECT COUNT(DISTINCT(ak.nokp)) AS bil FROM acara_peserta ap
LEFT JOIN acara_kehadiran ak ON ap.nokp=ak.nokp
WHERE ap.id_sesi='$id_sesi' AND ap.kumpulan='$id_kumpulan'";
	$result = $conn->query($sql);
	return $result->fetch_object()->bil;
}
function getPesertaKeseluruhan() {
	$conn=db();
	$sql = "SELECT * FROM acara_peserta
GROUP BY nokp
ORDER BY nama";
	$result = $conn->query($sql);
	return $result;
}
function getBilAcaraByNokp($nokp) {
	$conn=db();
	$sql = "SELECT COUNT(ac.id) AS bil FROM acara_sesi ac
LEFT JOIN acara_peserta ap ON ac.id=ap.id_sesi
WHERE ap.nokp='$nokp'";
	$result = $conn->query($sql);
	return $result->fetch_object()->bil;
}
function getBilHadirByNokp($nokp) {
	$conn=db();
	$sql = "SELECT COUNT(DISTINCT(ap.id_sesi)) AS bil FROM acara_peserta ap
LEFT JOIN acara_kehadiran ak ON ap.nokp=ak.nokp
WHERE ak.nokp='$nokp'";
	$result = $conn->query($sql);
	return $result->fetch_object()->bil;
}
//end 14/7/2019

//start 17/7/2019
function getKumpulanDaftarOnline($id_sesi) {
		$conn=db();
		 $sql = "SELECT id,nama_kumpulan FROM lkp_kumpulan_peserta
WHERE id_sesi='$id_sesi' AND daftar_online='1'";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option value=\"".$row[0]."\">".$row[1]." </option>";
		}
		//$conn->close();
		return $txt_result;
	}
function pesertaDaftarOnline($id_sesi,$nokp,$nama,$notel,$kumpulan,$jawatan,$photo_filename){
	$conn=db();

	$sql = "INSERT INTO acara_peserta (id_sesi,nokp,nama,notel,kumpulan,jawatan,photo_filename) 
	values ('$id_sesi','$nokp',UPPER('$nama'),'$notel','$kumpulan','$jawatan','$photo_filename')";
  	$result = $conn->query($sql) or die($conn->error);
  	return $result;

}
function getRating($id_sesi,$tarikh) {
	$conn=db();
	$sql = "SELECT aa.tajuk,COUNT(ar.nokp_peserta) AS bil_peserta,SUM(ar.peserta_rating) AS jumlah_rating FROM acara_rating ar
LEFT JOIN acara_aturcara aa ON ar.id_aturcara=aa.id
WHERE aa.id_sesi='$id_sesi' AND aa.tarikh='$tarikh'
GROUP BY ar.id_aturcara
ORDER BY aa.id_sesi";
	$result = $conn->query($sql);
	return $result;
}
function getSesiQna($id_sesi,$tarikh) {
	$conn=db();
	$sql = "SELECT aa.tajuk,aa.id AS id_aturcara,COUNT(aq.qna_soalan) AS bil_soalan FROM acara_qna aq
LEFT JOIN acara_aturcara aa ON aq.id_aturcara=aa.id
WHERE aa.id_sesi='$id_sesi' AND aa.tarikh='$tarikh'
GROUP BY aq.id_aturcara
ORDER BY aa.id_sesi";
	$result = $conn->query($sql);
	return $result;
}
function getQnaAturcara($id_aturcara) {
	$conn=db();
	$sql = "SELECT ap.nama,ap.photo_filename,aq.qna_soalan FROM acara_qna aq
LEFT JOIN acara_peserta ap ON aq.nokp_peserta=ap.nokp
WHERE aq.id_aturcara='$id_aturcara'
GROUP BY ap.nokp";
	$result = $conn->query($sql);
	return $result;
}
function getJumlahAturcaraQna($id_sesi,$tarikh_mula) {
	$conn=db();
	$sql = "SELECT COUNT(aq.qna_soalan) AS bil_soalan,COUNT(DISTINCT(aq.id_aturcara)) AS bil_aturcara FROM acara_qna aq
LEFT JOIN acara_aturcara aa ON aq.id_aturcara=aa.id
WHERE aa.id_sesi='$id_sesi' AND aa.tarikh='$tarikh_mula'";
	$result = $conn->query($sql);
	return $result;
}
//end


$conn->close();

?>