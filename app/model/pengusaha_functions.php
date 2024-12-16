<?php

	require '../../lib/db/connection.php';
    
    $action = $_POST['action'];
    if ($action=="get_ppk") {
	$kod_ppk = clean($_POST['kod_ppk']);
	$conn=db();
	$sql = "SELECT * FROM lkp_ppk
			WHERE kod_ppk='$kod_ppk'";

	$result = $conn->query($sql);
	$rows = array();
	while($r = $result->fetch_assoc()) {
		$rows[] = $r;
	}

	echo json_encode($rows);

	}else if($action == "nyahaktifLotTanah"){
		$id = $_POST['id'];
		$status_tanah = $_POST['status_tanah'];
		if ($status_tanah == '1') {
			$status_tanah = '0';
		}
		else {
			$status_tanah = '1';
		}

		$conn=db();
		$sql = "UPDATE lot_tanah set status_tanah='$status_tanah' WHERE id = '$id'";
		$result = $conn->query($sql);
		
	}else if($action == "nyahaktifPengusaha"){
		$id_pengusaha = $_POST['id_pengusaha'];
		$status_pengusaha = $_POST['status_pengusaha'];
		if ($status_pengusaha == '1') {
			$status_pengusaha = '0';
		}
		else {
			$status_pengusaha = '1';
		}

		$conn=db();
		$sql = "UPDATE pengusaha set status_pengusaha='$status_pengusaha' WHERE id_pengusaha = '$id_pengusaha'";
		$result = $conn->query($sql);
		
	}else if($action == "nyahAktifPengusahaLotTanah"){
		$id = $_POST['id'];
		$status_lot_tanah = $_POST['status_lot_tanah'];
		if ($status_lot_tanah == '1') {
			$status_lot_tanah = '0';
		}
		else {
			$status_lot_tanah = '1';
		}

		$conn=db();
		$sql = "UPDATE pengusaha_lot_tanah set status_lot_tanah='$status_lot_tanah' WHERE id = '$id'";
		$result = $conn->query($sql);
		
	}else if ($action=="get_daerah_list") {
		$kod_negeri = clean($_POST['kod_negeri']);
		$conn=db();
		$sql = "SELECT * FROM lkp_daerah
				WHERE kod_negeri='$kod_negeri'";
		$result = $conn->query($sql);
		echo '<option value="">-- Pilih Daerah --</option>'; 
        while($row = $result->fetch_assoc()){  
            echo '<option value="'.$row['kod_daerah'].'">'.$row['kod_daerah'].' - '.$row['daerah'].'</option>'; 
        } 
		
	}else if ($action=="get_jajahan_list") {
		$kod_negeri = clean($_POST['kod_negeri']);
		$conn=db();
		$sql = "SELECT * FROM lkp_jajahan
				WHERE kod_negeri='$kod_negeri'";
		$result = $conn->query($sql);
		echo '<option value="">-- Pilih Jajahan --</option>'; 
        while($row = $result->fetch_assoc()){  
            echo '<option value="'.$row['kod_jajahan'].'">'.$row['kod_jajahan'].' - '.$row['jajahan'].'</option>'; 
        } 

	}else if ($action=="get_mukim_list") {
		$kod_daerah = clean($_POST['kod_daerah']);
		$conn=db();
		$sql = "SELECT * FROM lkp_mukim
				WHERE kod_daerah='$kod_daerah'";
		$result = $conn->query($sql);
		echo '<option value="">-- Pilih Mukim --</option>'; 
        while($row = $result->fetch_assoc()){  
            echo '<option value="'.$row['kod_mukim'].'">'.$row['kod_mukim'].' - '.$row['mukim'].'</option>'; 
        } 

	}else if ($action=="get_mukim_ppk") {
		$kod_ppk = clean($_POST['kod_ppk']);
		$conn=db();
		$sql = "SELECT * FROM lkp_mukim
				WHERE kod_ppk='$kod_ppk'";
		$result = $conn->query($sql);
		echo '<option value="">-- Pilih Mukim --</option>'; 
        while($row = $result->fetch_assoc()){  
            echo '<option value="'.$row['kod_mukim'].'">'.$row['kod_mukim'].' - '.$row['mukim'].'</option>'; 
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

	//lookup -start-
	function getLKPKada($lkp_id){
		$conn=db();
		$sql = "SELECT column_name
				FROM information_schema.columns 
				WHERE (table_schema='indeepre_kada' AND table_name = '$lkp_id' AND column_name NOT IN ('created_date') AND ordinal_position NOT IN (1))
				ORDER BY ordinal_position";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	function getLKPKadaId($lkp_id){
		$conn=db();
		$sql = "SELECT column_name
				FROM information_schema.columns 
				WHERE (table_schema='indeepre_kada' AND table_name = '$lkp_id' AND ordinal_position IN (1))
				ORDER BY ordinal_position";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	function getLKPById($id, $table, $column){
		$conn=db();
		$sql = "SELECT * FROM $table WHERE $column = '$id' ";
		$result = $conn->query($sql);
		return $result;
	}

	function addLkp($table, $name_column, $column){
		$conn=db();
		$sql = "INSERT INTO $table ($name_column) VALUES ($column)";
		$result = $conn->query($sql);
		if($result){
			return 'success';
		}else{
			return 'duplicate';
		}
	}

	function editLKP($id, $id_table, $table, $set_update){
		$conn=db();
		$sql = "UPDATE $table SET $set_update WHERE $id_table='$id'";
		$result = $conn->query($sql);
		if($result){
			return 'success';
		}else{
			return 'duplicate';
		}
	}

	function getLookupDetails($lkp_name){
		$conn=db();
		$sql = "SELECT * FROM lkp_kada_lookup WHERE lkp_name='$lkp_name'";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	function getPPKByKod($kod_ppk){
		$conn=db();
		$sql = "SELECT * FROM lkp_ppk WHERE kod_ppk='$kod_ppk'";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	function getMukimById($id_mukim){
		$conn=db();
		$sql = "SELECT * FROM lkp_mukim WHERE id_mukim='$id_mukim'";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	function getNegeriById($id){
		$conn=db();
		$sql = "SELECT * FROM lkp_negeri WHERE id='$id'";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}
	
	function getDaerahById($id_daerah) {
		$conn=db();
		$sql = "SELECT * FROM lkp_daerah WHERE id_daerah='$id_daerah'";
		$result = $conn->query($sql);
		return $result;
	}

	function getJajahanById($id_jajahan) {
		$conn=db();
		$sql = "SELECT * FROM lkp_jajahan WHERE id_jajahan='$id_jajahan'";
		$result = $conn->query($sql);
		return $result;
	}

	function getUnitPeladangById($id_unit_peladang) {
		$conn=db();
		$sql = "SELECT * FROM lkp_unit_peladang WHERE id_unit_peladang='$id_unit_peladang'";
		$result = $conn->query($sql);
		return $result;
	}

	function getBendangById($id_bendang) {
		$conn=db();
		$sql = "SELECT * FROM lkp_bendang WHERE id_bendang='$id_bendang'";
		$result = $conn->query($sql);
		return $result;
	}

	function getCawanganById($id) {
		$conn=db();
		$sql = "SELECT * FROM lkp_cawangan WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}

	function getNegeriByKod($code){
		$conn=db();
		$sql = "SELECT * FROM lkp_negeri WHERE code='$code'";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	function getDaerahByKod($kod_daerah) {
		$conn=db();
		$sql = "SELECT * FROM lkp_daerah WHERE kod_daerah='$kod_daerah'";
		$result = $conn->query($sql);
		return $result;
	}

	function getMukimByKod($kod_mukim){
		$conn=db();
		$sql = "SELECT * FROM lkp_mukim WHERE kod_mukim='$kod_mukim'";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	function getJajahanByKod($kod_jajahan) {
		$conn=db();
		$sql = "SELECT * FROM lkp_jajahan WHERE kod_jajahan='$kod_jajahan'";
		$result = $conn->query($sql);
		return $result;
	}

	function getUnitPeladangByKod($kod_unit_peladang) {
		$conn=db();
		$sql = "SELECT * FROM lkp_unit_peladang WHERE kod_unit_peladang='$kod_unit_peladang'";
		$result = $conn->query($sql);
		return $result;
	}

	function getBendangByKod($kod_bendang) {
		$conn=db();
		$sql = "SELECT * FROM lkp_bendang WHERE kod_bendang='$kod_bendang'";
		$result = $conn->query($sql);
		return $result;
	}

	function getCawanganByKod($cawangan_kod) {
		$conn=db();
		$sql = "SELECT * FROM lkp_cawangan WHERE cawangan_kod='$cawangan_kod'";
		$result = $conn->query($sql);
		return $result;
	}

	function getPPKList(){
		$conn=db();
		$sql = "SELECT * FROM lkp_ppk ORDER BY nama_ppk ASC";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	function getMukimList(){
		$conn=db();
		$sql = "SELECT * FROM lkp_mukim ORDER BY mukim ASC";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	function getNegeriList(){
		$conn=db();
		$sql = "SELECT * FROM lkp_negeri ORDER BY name ASC";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}
	
	function getDaerahList() {
		$conn=db();
		$sql = "SELECT * FROM lkp_daerah ORDER BY daerah ASC";
		$result = $conn->query($sql);
		return $result;
	}

	function getJajahanList() {
		$conn=db();
		$sql = "SELECT * FROM lkp_jajahan ORDER BY jajahan ASC";
		$result = $conn->query($sql);
		return $result;
	}

	function getUnitPeladangList() {
		$conn=db();
		$sql = "SELECT * FROM lkp_unit_peladang ORDER BY unit_peladang ASC";
		$result = $conn->query($sql);
		return $result;
	}

	function getBendangList() {
		$conn=db();
		$sql = "SELECT * FROM lkp_bendang ORDER BY bendang ASC";
		$result = $conn->query($sql);
		return $result;
	}

	function getCawanganList() {
		$conn=db();
		$sql = "SELECT * FROM lkp_cawangan ORDER BY nama ASC";
		$result = $conn->query($sql);
		return $result;
	}

	function getLookupList($lkp_id){
		$conn=db();
		$sql = "SELECT * FROM $lkp_id";
		$result = $conn->query($sql);
		return $result;
	}

	function getMukimDetails($id_mukim) {
		$conn=db();
		$sql = "SELECT lm.*,ld.daerah,lng.name,lj.jajahan,lp.* FROM lkp_mukim lm 
				LEFT JOIN lkp_ppk lp ON lp.kod_ppk=lm.kod_ppk
				LEFT JOIN lkp_daerah ld ON lm.id_daerah=ld.id_daerah
				LEFT JOIN lkp_negeri lng ON ld.id_negeri=lng.id
				LEFT JOIN lkp_jajahan lj ON lng.id=lj.id_negeri
				WHERE lm.id_mukim='$id_mukim' GROUP BY lm.id_mukim";
		$result = $conn->query($sql);
		return $result;
	}

	function getPPKDetails($kod_ppk) {
		$conn=db();
		$sql = "SELECT lj.*, ld.*, lng.* FROM lkp_jajahan lj
				LEFT JOIN lkp_daerah ld ON lj.id_negeri=ld.id_negeri
				LEFT JOIN lkp_negeri lng ON ld.id_negeri=lng.id
				WHERE lng.id='$id_negeri'";
		$result = $conn->query($sql);
		return $result;
	}

	//lookup -end-
	
	//pengusaha -start-
	function getPengusahaList($status_pengusaha) {
		$conn=db();
		$sql = "SELECT p.*,plt.*,COUNT(plt.id) AS bil_lot_tanah FROM pengusaha p
				LEFT JOIN pengusaha_lot_tanah plt ON p.nokp = plt.pemilik
				WHERE p.status_pengusaha = '$status_pengusaha'
				GROUP BY p.nokp ORDER BY p.id_pengusaha DESC";
		$result = $conn->query($sql);
		return $result;
	}

	function getDropDownPengusaha($tablename,$value,$text,$column,$condition,$selected) {
		$conn=db();
		$sql = "SELECT ".$value.",".$text." FROM $tablename WHERE ".$column."='".$condition."' ORDER BY ".$text." ASC";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
		}
		//$conn->close();
		return $txt_result;
	}

	function getPengusahaById($id_pengusaha){
		$conn=db();
		$sql = "SELECT * FROM pengusaha WHERE id_pengusaha='$id_pengusaha'";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	function tambahPengusaha($kod_ppk,$nama,$nokp,$umur,$notel,$jantina,$no_pengusaha,$no_ahli,$kod_mukim,$alamat,$alamat2,$alamat3,$poskod,$bandar,$kod_negeri,$koordinat){
		$conn=db();
		$sql = "INSERT INTO pengusaha (kod_ppk,nama,nokp,umur,notel,jantina,no_pengusaha,no_ahli,kod_mukim,alamat,alamat2,alamat3,poskod,bandar,kod_negeri,koordinat) VALUES ('$kod_ppk','$nama','$nokp','$umur','$notel','$jantina','$no_pengusaha','$no_ahli','$kod_mukim','$alamat','$alamat2','$alamat3','$poskod','$bandar','$kod_negeri','$koordinat')";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	function kemaskiniPengusaha($id_pengusaha,$kod_ppk,$umur,$notel,$jantina,$no_pengusaha,$no_ahli,$kod_mukim,$alamat,$alamat2,$alamat3,$poskod,$bandar,$kod_negeri,$koordinat){
		$conn=db();
		$sql = "UPDATE pengusaha SET kod_ppk='$kod_ppk', umur='$umur', notel='$notel', jantina='$jantina', no_pengusaha='$no_pengusaha', no_ahli='$no_ahli', kod_mukim='$kod_mukim', alamat='$alamat', alamat2='$alamat2', alamat3='$alamat3', poskod='$poskod', bandar='$bandar', kod_negeri='$kod_negeri', koordinat='$koordinat' WHERE id_pengusaha='$id_pengusaha'";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}
	//pengusaha -end-

	//lot tanah -start-
	function getLotTanahList($status_tanah) {
		$conn=db();
		$sql = "SELECT lng.NAME AS negeri, lj.jajahan, ld.daerah, lm.mukim, lm.kod_ppk, lp.*, lt.* FROM lot_tanah lt 
				LEFT JOIN lkp_negeri lng ON lt.kod_negeri=lng.code
				LEFT JOIN lkp_jajahan lj ON lt.kod_jajahan=lj.kod_jajahan
				LEFT JOIN lkp_daerah ld ON lt.kod_daerah=ld.kod_daerah
				LEFT JOIN lkp_mukim lm ON lt.kod_mukim=lm.kod_mukim
				LEFT JOIN lkp_ppk lp ON lm.kod_ppk=lp.kod_ppk
				WHERE lt.status_tanah='$status_tanah' ORDER BY lm.mukim ASC";
		$result = $conn->query($sql);
		return $result;
	}

	function getLotTanahById($id) {
		$conn=db();
		$sql = "SELECT * FROM lot_tanah WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}

	function tambahLotTanah($kod_tanah,$kod_negeri,$kod_jajahan,$kod_daerah,$kod_mukim,$seksyen,$lot,$svy_area,$areaunit,$hektar,$unit,$apdate,$pa,$io,$pkp,$pengairan,$area,$perimeter,$koordinat){
		$conn=db();
		$sql_tanah = "SELECT * FROM lot_tanah WHERE kod_tanah='$kod_tanah'";
		$res_tanah = $conn->query($sql_tanah);
		if($res_tanah->num_rows>0){
			return 'duplicate';
		}else{
			$sql = "INSERT INTO lot_tanah (kod_tanah, kod_negeri,kod_jajahan,kod_daerah,kod_mukim,seksyen,lot,svy_area,areaunit,areawunit,hektar,unit,keluasan,apdate,pa,io,pkp,pengairan,area,perimeter,koordinat) VALUES ('$kod_tanah', '$kod_negeri','$kod_jajahan','$kod_daerah','$kod_mukim','$seksyen','$lot','$svy_area','$areaunit','$svy_area$areaunit','$hektar','$unit','$hektar$unit','$apdate','$pa','$io','$pkp','$pengairan','$area','$perimeter','$koordinat')";
			$result = $conn->query($sql) or die($conn->error);
			return 'success';
		}
	}

	function kemaskiniLotTanah($id,$kod_tanah,$kod_negeri,$kod_jajahan,$kod_daerah,$kod_mukim,$seksyen,$lot,$svy_area,$areaunit,$hektar,$unit,$apdate,$pa,$io,$pkp,$pengairan,$area,$perimeter,$koordinat){
		$conn=db();
		$sql = "UPDATE lot_tanah SET kod_tanah='$kod_tanah', kod_negeri='$kod_negeri', kod_jajahan='$kod_jajahan', kod_daerah='$kod_daerah', kod_mukim='$kod_mukim', seksyen='$seksyen', lot='$lot', svy_area='$svy_area', areaunit='$areaunit', areawunit='$svy_area$areaunit', hektar='$hektar', unit='$unit', keluasan='$hektar$unit', apdate='$apdate', pa='$pa', io='$io', pkp='$pkp', pengairan='$pengairan', area='$area' , perimeter='$perimeter', koordinat='$koordinat' WHERE id='$id'";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}
	//lot tanah -end-

	//pengusaha lot tanah -start-
	function pengusahaAddLotTanah($kod_tanah,$pemilik){
		$conn=db();
		$sql = "INSERT INTO pengusaha_lot_tanah (kod_tanah,pemilik) VALUES ('$kod_tanah','$pemilik')";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	function getLotTanahCheckboxList($kod_negeri,$kod_jajahan,$kod_daerah,$pemilik) {
		$conn=db();
		$sql = "SELECT lt.kod_tanah,lt.kod_negeri,lkpn.name,lt.kod_jajahan,lkpj.jajahan,lt.kod_daerah,lkpd.daerah,lt.kod_mukim,lkpm.mukim,lkpp.nama_ppk,lt.status_tanah FROM lot_tanah lt
				LEFT JOIN lkp_negeri lkpn ON lt.kod_negeri = lkpn.code
				LEFT JOIN lkp_jajahan lkpj ON lt.kod_jajahan = lkpj.kod_jajahan
				LEFT JOIN lkp_daerah lkpd ON lt.kod_daerah = lkpd.kod_daerah
				LEFT JOIN lkp_mukim lkpm ON lt.kod_mukim = lkpm.kod_mukim
				LEFT JOIN lkp_ppk lkpp ON lkpm.kod_ppk = lkpp.kod_ppk
				WHERE lt.status_tanah = '1' 
				AND lt.kod_negeri = '$kod_negeri' 
				AND lt.kod_jajahan = '$kod_jajahan'
				AND lt.kod_daerah = '$kod_daerah' 
				AND lt.kod_tanah NOT IN (SELECT kod_tanah FROM pengusaha_lot_tanah WHERE pemilik ='$pemilik')
				ORDER BY lt.id DESC";
		$result = $conn->query($sql);
		return $result;
	}

	function getPengusahaInfoById($nokp) {
		$conn=db();
		$sql = "SELECT * FROM pengusaha WHERE nokp = '$nokp'";
		$result = $conn->query($sql);
		return $result;
	}

	function getPengusahaLotTanahListByNokp($pemilik) {
		$conn=db();
		$sql = "SELECT plt.*,lt.kod_negeri,lkpn.name,lt.kod_jajahan,lkpj.jajahan,lt.kod_daerah,lkpd.daerah,lt.kod_mukim,lkpm.mukim,lkpp.nama_ppk,lt.koordinat FROM pengusaha_lot_tanah plt
				LEFT JOIN lot_tanah lt ON plt.kod_tanah = lt.kod_tanah
				LEFT JOIN lkp_negeri lkpn ON lt.kod_negeri = lkpn.code
				LEFT JOIN lkp_jajahan lkpj ON lt.kod_jajahan = lkpj.kod_jajahan
				LEFT JOIN lkp_daerah lkpd ON lt.kod_daerah = lkpd.kod_daerah
				LEFT JOIN lkp_mukim lkpm ON lt.kod_mukim = lkpm.kod_mukim
				LEFT JOIN lkp_ppk lkpp ON lkpm.kod_ppk = lkpp.kod_ppk
				WHERE plt.pemilik = '$pemilik' AND plt.status_lot_tanah = '1' 
				ORDER BY plt.id DESC";
		$result = $conn->query($sql);
		return $result;
	}

	function getPengusahaLotTanahDetailsByNokp($pemilik) {
		$conn=db();
		$sql = "SELECT plt.*,lt.kod_negeri,lkpn.name,lt.kod_jajahan,lkpj.jajahan,lt.kod_daerah,lkpd.daerah,lt.kod_mukim,lkpm.mukim,lkpp.nama_ppk,lt.koordinat,p.nama,p.nokp,p.notel FROM pengusaha_lot_tanah plt
				LEFT JOIN lot_tanah lt ON plt.kod_tanah = lt.kod_tanah
				LEFT JOIN lkp_negeri lkpn ON lt.kod_negeri = lkpn.code
				LEFT JOIN lkp_jajahan lkpj ON lt.kod_jajahan = lkpj.kod_jajahan
				LEFT JOIN lkp_daerah lkpd ON lt.kod_daerah = lkpd.kod_daerah
				LEFT JOIN lkp_mukim lkpm ON lt.kod_mukim = lkpm.kod_mukim
				LEFT JOIN lkp_ppk lkpp ON lkpm.kod_ppk = lkpp.kod_ppk
				LEFT JOIN pengusaha p ON plt.pemilik = p.nokp
				WHERE plt.pemilik = '$pemilik' AND plt.status_lot_tanah = '1'
				GROUP BY lt.id ORDER BY plt.id DESC";
		$result = $conn->query($sql);
		return $result;
	}

	function getPengusahaLotTanahDetailsById($id) {
		$conn=db();
		$sql = "SELECT plt.*,lt.*,lkpn.name,lkpj.jajahan,lkpd.daerah,lkpm.mukim,lkpp.kod_ppk,lkpp.nama_ppk,lt.koordinat,p.nama,p.nokp,p.notel, lkpp.alamat, lkpp.alamat2, lkpp.alamat3 FROM pengusaha_lot_tanah plt
				LEFT JOIN lot_tanah lt ON plt.kod_tanah = lt.kod_tanah
				LEFT JOIN lkp_negeri lkpn ON lt.kod_negeri = lkpn.code
				LEFT JOIN lkp_jajahan lkpj ON lt.kod_jajahan = lkpj.kod_jajahan
				LEFT JOIN lkp_daerah lkpd ON lt.kod_daerah = lkpd.kod_daerah
				LEFT JOIN lkp_mukim lkpm ON lt.kod_mukim = lkpm.kod_mukim
				LEFT JOIN lkp_ppk lkpp ON lkpm.kod_ppk = lkpp.kod_ppk
				LEFT JOIN pengusaha p ON plt.pemilik = p.nokp
				WHERE plt.id = '$id'";
		$result = $conn->query($sql);
		return $result;
	}
	//pengusaha lot tanah -end-
	
	//analisa -start-
	function getAnalisaByAge(){
		$conn=db();
		$sql = "SELECT p.umur , COUNT(p.id_pengusaha) AS bil, 
				CASE WHEN p.umur BETWEEN 1 AND 20 THEN 'Bawah 20 Tahun'
					WHEN p.umur BETWEEN 21 AND 30 THEN 'Bawah 30 Tahun'
					WHEN p.umur BETWEEN 31 AND 40 THEN 'Bawah 40 Tahun'
					WHEN p.umur BETWEEN 41 AND 50 THEN 'Bawah 50 Tahun'
					WHEN p.umur BETWEEN 51 AND 60 THEN 'Bawah 60 Tahun'
					WHEN p.umur BETWEEN 61 AND 70 THEN 'Bawah 70 Tahun'
					ELSE '70 Tahun Ke Atas' END AS kategori
					FROM pengusaha p GROUP BY kategori";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	function getPKJByKodAnalisa($kod_pkj){
		$conn=db();
		$sql = "SELECT lp.kod_ppk, lp.nama_ppk, COUNT(lp.id_ppk) AS bil FROM lkp_jajahan lj
				LEFT JOIN lkp_ppk lp ON lj.kod_jajahan=lp.kod_pkj
				WHERE lj.kod_jajahan='$kod_pkj' GROUP BY lp.id_ppk";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	function getPPKByPKJAnalisa($kod_pkj, $kod_ppk){
		$conn=db();
		$sql = "SELECT lp.kod_ppk, lp.nama_ppk, COUNT(lt.id) AS bil FROM lkp_ppk lp
				LEFT JOIN lkp_jajahan lj ON lp.kod_pkj=lj.kod_jajahan
				LEFT JOIN lot_tanah lt ON lj.kod_jajahan=lt.kod_jajahan
				WHERE lp.kod_pkj='$kod_pkj' AND lp.kod_ppk='$kod_ppk'
				GROUP BY lt.id";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	//analisa -end-


	
	$conn->close();
	
?>