<?php

require '../../lib/db/connection.php';

$action = $_POST['action'];
//agromart agensi -start-
if($action == "nyahAktifAgensi"){
	$id = $_POST['id'];
	$status = $_POST['status'];
	if ($status == '1') {
		$status = '0';
	}
	else {
		$status = '1';
	}
	$conn=db();
	$sql = "UPDATE agromart_agencies SET status='$status' WHERE id = '$id'";
	$result = $conn->query($sql);
}
//agromart agensi -end-

//agromart operator -start-
else if($action == "nyahAktifOperator"){
	$id = $_POST['id'];
	$id_agencies = $_POST['id_agencies'];
	$status = $_POST['status'];
	if ($status == '1') {
		$status = '0';
	}
	else {
		$status = '1';
	}
	$conn=db();
	$sql = "UPDATE agromart_admin SET status='$status' WHERE id = '$id' AND id_agencies = '$id_agencies'";
	$result = $conn->query($sql);
}
//agromart operator -end-

//agromart pembekal -start-
else if($action == "nyahAktifPembekal"){
	$id = $_POST['id'];
	$id_agencies = $_POST['id_agencies'];
	$status = $_POST['status'];
	if ($status == '1') {
		$status = '0';
	}
	else {
		$status = '1';
	}
	$conn=db();
	$sql = "UPDATE agromart_seller SET status='$status' WHERE id = '$id' AND id_agencies = '$id_agencies'";
	$result = $conn->query($sql);
}
//agromart pembekal -end-

//agromart konfigurasi produk (add,update,delete) -start-
else if($action == "hasilTaniAddEdit"){
	$kod = $_POST['kod'];
	$nama = $_POST['nama'];
	$harga_belian_semasa = $_POST['harga_belian_semasa'];
	$harga_jualan_semasa = $_POST['harga_jualan_semasa'];
	$id = $_POST['id'];

	$conn=db();
	if($id > 0 ){
		$sql = "UPDATE lkp_stock_type SET kod = '$kod', nama = '$nama', harga_belian_semasa = '$harga_belian_semasa', harga_jualan_semasa = '$harga_jualan_semasa' WHERE id = '$id'";
		$result = $conn->query($sql) or die($conn->error);
		echo "Data berjaya dikemaskini";
	}else{
		$sql = "INSERT INTO lkp_stock_type (kod,nama,harga_belian_semasa,harga_jualan_semasa) VALUES ('$kod','$nama','$harga_belian_semasa','$harga_jualan_semasa')";
		$result = $conn->query($sql) or die($conn->error);
		echo "Data berjaya ditambah";
	}
}
else if($action == "nyahAktifHasilTani"){
	$id = $_POST['id'];
	$status = $_POST['status'];
	if ($status == '1') {
		$status = '0';
	}
	else {
		$status = '1';
	}
	$conn=db();
	$sql = "UPDATE lkp_stock_type SET status = '$status' WHERE id = '$id'";
	$result = $conn->query($sql);
}
//agromart konfigurasi produk (add,update,delete) -end-

//agromart pembekal produk jualan -start-
else if ($action=="itemJualanDetails") {
	$barcode = clean($_POST['barcode']);
	$conn=db();
	$sql = "SELECT agst.*,agst.kuantiti AS kuantiti_item,lkps.kod AS kod_item,lkps.nama AS nama_item,lkps.harga_jualan_semasa AS harga_runcit FROM agromart_stocks agst
			LEFT JOIN lkp_stock_type lkps ON agst.id_stock_type = lkps.id
			WHERE agst.barcode = '$barcode'";
	$result = $conn->query($sql);
	$rows = array();
	while($r = $result->fetch_assoc()) {
		$rows[] = $r;
	}
	echo json_encode($rows);
}
else if ($action=="addItemJualanProses") {
	$id = $_POST['id'];
	$id_agencies = $_POST['id_agencies'];
	$no_resit = $_POST['no_resit'];
	$jumlah_jualan = $_POST['jumlah_jualan'];
	$jumlah_bayaran = $_POST['jumlah_bayaran'];
	$jumlah_baki = $_POST['jumlah_baki'];
	$created_by = $_POST['created_by'];
	$info = $_POST['info'];

 	$someArray = json_decode($info, true);
  	echo $returnResult = rekodJualanAddEdit($id,$id_agencies,$no_resit,$jumlah_jualan,$jumlah_bayaran,$jumlah_baki,$created_by,$someArray);

	}
//agromart pembekal produk jualan -end-

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

//agromart agensi -start-
function getAgensiList($status) {
	$conn=db();
	$sql = "SELECT * FROM agromart_agencies 
			WHERE status = '$status'
			ORDER BY id DESC";
	$result = $conn->query($sql);
	return $result;
}

function getAgensiInfoById($id) {
	$conn=db();
	$sql = "SELECT aga.*,lkpn.code,lkpn.name FROM agromart_agencies aga
			LEFT JOIN lkp_negeri lkpn ON aga.negeri = lkpn.name 
			WHERE aga.id = '$id'";
	$result = $conn->query($sql);
	return $result;
}

function agensiAdd($id,$nama,$no_pendaftaran,$notel,$email,$username,$password,$role,$alamat,$daerah,$negeri,$status,$logo,$logo_filename,$created_by) {
	$conn=db();
	$gambar = '';
    $gambar_val = '';
	    if($logo_filename != ""){
	        $gambar=" ,logo,logo_filename";
	        $gambar_val=",'$logo','$logo_filename'";
	    }
	$sql1 = "INSERT INTO agromart_agencies (nama,no_pendaftaran,notel,email,username,password,alamat,daerah,negeri,status$gambar,created_by)
			VALUES ('$nama','$no_pendaftaran','$notel','$email','$username','$password','$alamat','$daerah','$negeri','1'$gambar_val,'$created_by')";
	$result = $conn->query($sql1);
	$id_agencies = $conn->insert_id;
	$sql2 = "INSERT INTO agromart_admin (id_agencies,nama,notel,username,password,role,alamat,daerah,negeri,status)
			VALUES ('$id_agencies','$nama','$notel','$username','$password','ADMIN','$alamat','$daerah','$negeri','1')";
	$result = $conn->query($sql2);
	$sql3 = "INSERT INTO agromart_terminal (id_cawangan,created_by)
			VALUES ('$id_cawangan','$created_by')";
	$result = $conn->query($sql3);
	return $result;
}

function agensiEdit($id,$nama,$no_pendaftaran,$notel,$email,$username,$password,$alamat,$daerah,$negeri,$logo,$logo_filename){
    $conn=db();
    $sql = "UPDATE agromart_agencies SET nama = '$nama', no_pendaftaran = '$no_pendaftaran', notel = '$notel', email = '$email', username = '$username', password = '$password', alamat = '$alamat', daerah = '$daerah', negeri = '$negeri'";

    if($logo_filename != ""){
        $sql.=" ,logo='$logo',logo_filename='$logo_filename' "; 
    }
    
    $sql.="  WHERE id='$id'";
    $result=$conn->query($sql) or die($conn->error);
    $sql = "UPDATE agromart_admin SET nama = '$nama', notel = '$notel', username = '$username', password = '$password', alamat = '$alamat', daerah = '$daerah', negeri = '$negeri' WHERE id = '$id'";
    $result=$conn->query($sql) or die($conn->error);
    return $result; 
}
//agromart agensi -end-

//agromart operator -start-
function getOperatorList($id_agencies,$status) {
	$conn=db();
	$sql = "SELECT * FROM agromart_admin 
			WHERE id_agencies = '$id_agencies'
			AND status = '$status'
			ORDER BY id DESC";
	$result = $conn->query($sql);
	return $result;
}

function getOperatorInfoById($id,$id_agencies) {
	$conn=db();
	$sql = "SELECT agad.*,lkpn.code,lkpn.name,aga.nama AS nama_agensi,aga.no_pendaftaran,aga.negeri AS negeri_agensi FROM agromart_admin agad
			LEFT JOIN agromart_agencies aga ON agad.id_agencies = aga.id
			LEFT JOIN lkp_negeri lkpn ON agad.negeri = lkpn.name 
			WHERE agad.id = '$id'
			AND agad.id_agencies = '$id_agencies'";
	$result = $conn->query($sql);
	return $result;
}

function operatorAdd($id,$id_agencies,$nama,$nokp,$notel,$umur,$username,$password,$alamat,$daerah,$negeri,$jantina,$status,$photo,$photo_filename,$created_by) {
	$conn=db();
	$gambar = '';
    $gambar_val = '';
	    if($photo_filename != ""){
	        $gambar=" ,photo,photo_filename";
	        $gambar_val=",'$photo','$photo_filename'";
	    }
	$sql = "INSERT INTO agromart_admin (id_agencies,nama,nokp,notel,umur,username,password,alamat,daerah,negeri,jantina,status$gambar,created_by)
			VALUES ('$id_agencies','$nama','$nokp','$notel','$umur','$username','$password','$alamat','$daerah','$negeri','$jantina','1'$gambar_val,'$created_by')";
	$result = $conn->query($sql);
	return $result;
}

function operatorEdit($id,$id_agencies,$nama,$nokp,$notel,$umur,$username,$password,$alamat,$daerah,$negeri,$jantina,$photo,$photo_filename){
    $conn=db();
    $sql = "UPDATE agromart_admin SET nama = '$nama', nokp = '$nokp', notel = '$notel', umur = '$umur', username = '$username', password = '$password', alamat = '$alamat', daerah = '$daerah', negeri = '$negeri', jantina = '$jantina'";

    if($photo_filename != ""){
        $sql.=" ,photo='$photo',photo_filename='$photo_filename' "; 
    }
    
    $sql.="  WHERE id='$id' AND id_agencies = '$id_agencies'";
    $result=$conn->query($sql) or die($conn->error);
    return $result; 
}
//agromart operator -end-

//agromart konfigurasi produk -start-
function getKonfigurasiHasiTaniList($status) {
	$conn=db();
	$sql = "SELECT * FROM lkp_stock_type
			WHERE status = '$status'
			ORDER BY id DESC";
	$result = $conn->query($sql);
	return $result;
}

function getHasilTaniCheckboxList() {
	$conn=db();
	$sql = "SELECT * FROM lkp_stock_type WHERE status = '1' 
			ORDER BY id ASC";
	$result = $conn->query($sql);
	return $result;
}
//agromart konfigurasi produk -end-

//agromart pembekal -start-
function getPembekalList($id_agencies,$status) {
	$conn=db();
	$sql = "SELECT * FROM agromart_seller 
			WHERE id_agencies = '$id_agencies'
			AND status = '$status'
			ORDER BY id DESC";
	$result = $conn->query($sql);
	return $result;
}

function getPembekalInfoById($id,$id_agencies) {
	$conn=db();
	$sql = "SELECT ags.*,lkpn.code,lkpn.name,aga.nama AS nama_agensi,aga.no_pendaftaran,aga.negeri AS negeri_agensi FROM agromart_seller ags
			LEFT JOIN agromart_agencies aga ON ags.id_agencies = aga.id
			LEFT JOIN lkp_negeri lkpn ON ags.negeri = lkpn.name 
			WHERE ags.id = '$id'
			AND ags.id_agencies = '$id_agencies'";
	$result = $conn->query($sql);
	return $result;
}

function pembekalAdd($id,$id_agencies,$nama,$nokp,$notel,$umur,$alamat,$daerah,$negeri,$jantina,$status,$photo,$photo_filename,$created_by) {
	$conn=db();
	$gambar = '';
    $gambar_val = '';
	    if($photo_filename != ""){
	        $gambar=" ,photo,photo_filename";
	        $gambar_val=",'$photo','$photo_filename'";
	    }
	$sql = "INSERT INTO agromart_seller (id_agencies,nama,nokp,notel,umur,alamat,daerah,negeri,jantina,status$gambar,created_by)
			VALUES ('$id_agencies','$nama','$nokp','$notel','$umur','$alamat','$daerah','$negeri','$jantina','1'$gambar_val,'$created_by')";
	$result = $conn->query($sql);
	return $result;
}

function pembekalEdit($id,$id_agencies,$nama,$nokp,$notel,$umur,$alamat,$daerah,$negeri,$jantina,$photo,$photo_filename){
    $conn=db();
    $sql = "UPDATE agromart_seller SET nama = '$nama', nokp = '$nokp', notel = '$notel', umur = '$umur', alamat = '$alamat', daerah = '$daerah', negeri = '$negeri', jantina = '$jantina'";

    if($photo_filename != ""){
        $sql.=" ,photo='$photo',photo_filename='$photo_filename' "; 
    }
    
    $sql.="  WHERE id='$id' AND id_agencies = '$id_agencies'";
    $result=$conn->query($sql) or die($conn->error);
    return $result; 
}
//agromart pembekal -end-

//agromart pembekal produk -start-
function getPembekalHasilTaniList($id_agencies,$nokp_seller) {
	$conn=db();
	$sql = "SELECT agst.*,lkps.kod,lkps.nama AS nama_item,lkps.harga_jualan_semasa AS harga_runcit FROM agromart_stocks agst
			LEFT JOIN lkp_stock_type lkps ON agst.id_stock_type = lkps.id
			WHERE agst.id_agencies = '$id_agencies'
			AND agst.nokp_seller = '$nokp_seller'
			AND agst.status = '1'
			ORDER BY agst.id ASC";
	$result = $conn->query($sql);
	return $result;
}

function getPembekalHasilTaniChecked($id_stock_type,$id_agencies,$nokp_seller){
	$conn=db();
	$sql = "SELECT status FROM agromart_stocks 
			WHERE id_stock_type = '$id_stock_type'
			AND id_agencies = '$id_agencies'
			AND nokp_seller = '$nokp_seller'";
	$result = $conn->query($sql)->fetch_object()->status;		
	if($result > 0){
		return 'checked';
	}else{
		return '';
	}
}

function getPembekalHasilTaniKodbar($id_stock_type,$id_agencies,$nokp_seller){
	$conn=db();
	$sql = "SELECT barcode FROM agromart_stocks 
			WHERE id_stock_type = '$id_stock_type' 
			AND id_agencies = '$id_agencies'
			AND nokp_seller = '$nokp_seller'";
	$result = $conn->query($sql);		
	return $result->fetch_object()->barcode;
}

function getPembekalHasilTaniQty($id_stock_type,$id_agencies,$nokp_seller){
	$conn=db();
	$sql = "SELECT kuantiti FROM agromart_stocks 
			WHERE id_stock_type = '$id_stock_type' 
			AND id_agencies = '$id_agencies'
			AND nokp_seller = '$nokp_seller'";
	$result = $conn->query($sql);		
	return $result->fetch_object()->kuantiti;
}

function getPembekalHasilTaniPrice($id_stock_type,$id_agencies,$nokp_seller){
	$conn=db();
	$sql = "SELECT harga_jualan_semasa FROM agromart_stocks 
			WHERE id_stock_type = '$id_stock_type'
			AND id_agencies = '$id_agencies' 
			AND nokp_seller = '$nokp_seller'";
	$result = $conn->query($sql);		
	return $result->fetch_object()->harga_jualan_semasa;
}

function pembekalHasilTaniAddEdit($id_stock_type,$id_agencies,$nokp_seller,$barcode,$harga_jualan_semasa,$status,$kuantiti,$created_by) {
	$conn=db();
	$sql = "SELECT * FROM agromart_stocks 
			WHERE id_stock_type = '$id_stock_type'
			AND id_agencies = '$id_agencies'
			AND nokp_seller = '$nokp_seller'";
	$result = $conn->query($sql);	
	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		$sql = "UPDATE agromart_stocks SET harga_jualan_semasa = '$harga_jualan_semasa', kuantiti = '$kuantiti', status = '1'
				WHERE id_stock_type = '$id_stock_type' 
				AND id_agencies = '$id_agencies'
				AND nokp_seller = '$nokp_seller'";
		$result = $conn->query($sql);
		return $result;
	}
	else{
		$sql = "SELECT CONCAT(LPAD('$id_agencies',2,'0'),LPAD(IFNULL(MAX(a.id), 0) + 1,11,'0')) AS barcode_number 
				FROM agromart_stocks a";
		$result = $conn->query($sql);
		$barcode_number = $result->fetch_object()->barcode_number;
		$sql = "INSERT INTO agromart_stocks (id_stock_type,id_agencies,nokp_seller,barcode,harga_jualan_semasa,status,kuantiti,created_by) VALUES ('$id_stock_type','$id_agencies','$nokp_seller','$barcode_number','$harga_jualan_semasa','1','$kuantiti','$created_by')";
		$result=$conn->query($sql);
		return $result;
	}
}

function deactivePembekalHasilTani($id_agencies,$nokp_seller) {
	$conn=db();
	$sql = "UPDATE agromart_stocks SET status = '0' 
			WHERE id_agencies = '$id_agencies'
			AND nokp_seller = '$nokp_seller'";
	$result = $conn->query($sql);
	return $result;
}
//agromart pembekal produk -end-

//agromart pembekal produk tag harga -start-
function getTagHargaListByStock($id,$id_stock_type,$id_agencies,$nokp_seller) {
	$conn=db();
	$sql = "SELECT agst.*,lkps.kod,lkps.nama AS nama_item,lkps.harga_jualan_semasa AS  harga_runcit FROM agromart_stocks agst
			LEFT JOIN lkp_stock_type lkps ON agst.id_stock_type = lkps.id
			WHERE agst.id = '$id'
			AND agst.id_stock_type = '$id_stock_type'
			AND agst.id_agencies = '$id_agencies'
			AND agst.nokp_seller = '$nokp_seller'
			AND agst.status = '1'";
	$result = $conn->query($sql);
	return $result;
}

function getTagHargaListByPembekal($id_agencies,$nokp_seller) {
	$conn=db();
	$sql = "SELECT agst.*,lkps.kod,lkps.nama AS nama_item,lkps.harga_jualan_semasa AS  harga_runcit FROM agromart_stocks agst
			LEFT JOIN lkp_stock_type lkps ON agst.id_stock_type = lkps.id
			WHERE agst.id_agencies = '$id_agencies'
			AND agst.nokp_seller = '$nokp_seller'
			AND agst.status = '1'";
	$result = $conn->query($sql);
	return $result;
}
//agromart pembekal produk tag harga -end-

//agromart pembekal produk terminal jualan activation -start-
function getTerminalJualanActivation() {
	$conn=db();
	$sql = "SELECT COUNT(id) AS count FROM agromart_terminal 
			WHERE status = '1' 
			AND CURRENT_TIME between start_time and end_time";
 	$result = $conn->query($sql);
	return $result->fetch_object()->count;
}
//agromart pembekal produk terminal jualan activation -end-

//agromart pembekal produk jualan -start-
function getItemJualanDetails($barcode) {
	$conn=db();
	$sql = "SELECT agst.*,lkps.kod AS kod_item,lkps.nama AS nama_item,lkps.harga_jualan_semasa AS harga_runcit FROM agromart_stocks agst
			LEFT JOIN lkp_stock_type lkps ON agst.id_stock_type = lkps.id
			WHERE agst.barcode = '$barcode'";
	$result = $conn->query($sql);
	return $result->fetch_assoc();
}

function getNoResitJualan($id,$id_agencies) {
	$conn=db();
	$sql = "UPDATE agromart_sales_transaction SET no_resit = concat('J','-',if(length('$id_agencies') < 2 ,LPAD('$id_agencies',2,'0'),'$id_agencies'),'-',
		if(length('$id') < 4 ,LPAD('$id', 4, '0'),'$id')) WHERE id = '$id'";
 	$result = $conn->query($sql);

	$sql = "SELECT no_resit FROM agromart_sales_transaction WHERE id = '$id'";
 	$result = $conn->query($sql);
	return $result->fetch_object()->no_resit;
}

function getInfoResitJualan($no_resit) {
	$conn=db();
	$sql = "SELECT ast.*,aga.* FROM agromart_sales_transaction ast
			LEFT JOIN agromart_agencies aga ON ast.id_agencies = aga.id
			WHERE ast.no_resit = '$no_resit'";
 	$result = $conn->query($sql);
	return $result->fetch_assoc();
}

function getItemResitJualan($no_resit) {
	$conn=db();
	$sql = "SELECT asti.* FROM agromart_sales_transaction_item asti
			LEFT JOIN agromart_sales_transaction ast ON asti.id_sales_transaction = ast.id
			WHERE ast.no_resit = '$no_resit'";
 	$result = $conn->query($sql);
	return $result;
}

function rekodJualanAddEdit($id,$id_agencies,$no_resit,$jumlah_jualan,$jumlah_bayaran,$jumlah_baki,$created_by,$someArray) {
	$conn=db();
	$resit_front = "J-".$id_agencies."-" ;
	$newTrancID = 0;
	if($no_resit == ""){
 		$sql = "INSERT INTO agromart_sales_transaction (id_agencies,no_resit,jumlah_jualan,jumlah_bayaran,jumlah_baki,created_by)
		VALUES ('$id_agencies','$no_resit','$jumlah_jualan','$jumlah_bayaran','$jumlah_baki','$created_by')";
		
		//tambah rekod jualan produk dalam table agromart_sales_transaction
		$addJualanHasilTani = $conn->query($sql);
		$newTrancID = $conn->insert_id;
		$no_resit = getNoResitJualan($newTrancID,$id_agencies);

		//tambah rekod jualan produk dalam table agromart_sales_transaction_item
		foreach ($someArray as $key => $value) {
	    	itemJualanAddEdit($newTrancID,$value["nokp_seller"],$value["barcode_item"],$value["kod_item"],$value["nama_item"],$value["harga_item"],$value["jumlah_harga_item"],$value["kuantiti_item"],$created_by);
	  	}
 	}else{
	 	
	}
	return $no_resit;
}

function itemJualanAddEdit($newTrancID,$nokp_seller,$barcode_item,$kod_item,$nama_item,$harga_item,$jumlah_harga_item,$kuantiti_item,$created_by) {
	$conn=db();
	//$itemDetails = getItemJualanDetails($barcode);

	//tambah rekod jualan produk dalam table agromart_sales_transaction_item
	$sql = "INSERT INTO agromart_sales_transaction_item (id_sales_transaction,nokp_seller,barcode_item,kod_item,nama_item,harga_item,jumlah_harga_item,kuantiti_item,created_by)
	VALUES ('$newTrancID','$nokp_seller','$barcode_item', 
	'$kod_item','$nama_item','$harga_item','$jumlah_harga_item','$kuantiti_item','$created_by')";
 	$result = $conn->query($sql);

 	//kemaskini rekod stok jualan dalam table agromart_stocks
 	$sql = "SELECT * FROM agromart_stocks WHERE barcode = '$barcode_item'";
	$result = $conn->query($sql);	
	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		$sql = "UPDATE agromart_stocks SET kuantiti = (kuantiti - $kuantiti_item)   WHERE barcode = '$barcode_item' ";
		$result = $conn->query($sql);
		return $result;
	}
	return $result;
}
//agromart pembekal produk jualan -end-

//agromart pembekal analisa jualan -start-
function getAnalisaTotalJualanByYear($value) {
 	$conn=db();
 	$sql = "SELECT IFNULL(SUM(jumlah_jualan),0) AS total_jualan_year FROM agromart_sales_transaction
   			WHERE DATE_FORMAT(created_date,'%Y') <= '$value'";
 	$result = $conn->query($sql);
 	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return 'RM'.$row[0];
	}else{
		return '';
	}
}

function getAnalisaTotalJualanByMonth($value) {
 	$conn=db();
 	$sql = "SELECT IFNULL(SUM(jumlah_jualan),0) AS total_jualan_month FROM agromart_sales_transaction
   			WHERE DATE_FORMAT(created_date,'%Y%m') = '$value'";
 	$result = $conn->query($sql);
 	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return 'RM'.$row[0];
	}else{
		return '';
	}
}

function getAnalisaTotalJualanByWeek($start,$end) {
 	$conn=db();
 	$sql = "SELECT IFNULL(SUM(jumlah_jualan),0) AS total_jualan_week FROM agromart_sales_transaction
   			WHERE DATE_FORMAT(created_date,'%y-%m-%d') 
			BETWEEN DATE_FORMAT('$start','%y-%m-%d') AND DATE_FORMAT('$end','%y-%m-%d')";
 	$result = $conn->query($sql);
 	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return 'RM'.$row[0];
	}else{
		return '';
	}
}

function getAnalisaTotalJualanByDay($date) {
	$conn=db();
	$sql = "SELECT IFNULL(SUM(jumlah_jualan),0) AS total_jualan_day FROM agromart_sales_transaction
			WHERE DATE(created_date)='$date'";
	$result = $conn->query($sql);
	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return 'RM'.$row[0];
	}else{
		return '';
	}
}

function getAnalisaTotalJualanList() {
	$conn=db();
	$sql = "SELECT ast.*,DATE_FORMAT(ast.created_date,'%M') AS bulan_jualan,DATE_FORMAT(ast.created_date,'%d-%b-%Y') AS tarikh_jualan,IFNULL(SUM(asti.kuantiti_item),0) AS stok_jualan FROM agromart_sales_transaction ast
			LEFT JOIN agromart_sales_transaction_item asti ON ast.id = asti.id_sales_transaction
			WHERE DATE_FORMAT(ast.created_date,'%Y') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')
			GROUP BY asti.id_sales_transaction
			ORDER BY ast.jumlah_jualan DESC";
	$result = $conn->query($sql);
	return $result;
}

function getCountAnalisaTotalJualan() {
	$conn = db();
	$sql = "SELECT IFNULL(SUM(jumlah_jualan),0) AS jumlah_keseluruhan_jualan FROM agromart_sales_transaction
			WHERE DATE_FORMAT(created_date,'%Y') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')";
	$result = $conn->query($sql) or die($conn->error);
	return $result->fetch_object()->jumlah_keseluruhan_jualan;
}
//agromart pembekal analisa jualan -end-

//agromart pembekal analisa stok -start-
function getAnalisaTotalStokByYear($value) {
 	$conn=db();
 	$sql = "SELECT IFNULL(SUM(asti.kuantiti_item),0) AS total_stok_year FROM agromart_sales_transaction_item asti
 			LEFT JOIN agromart_sales_transaction ast ON asti.id_sales_transaction = ast.id
   			WHERE DATE_FORMAT(asti.created_date,'%Y') <= '$value'";
 	$result = $conn->query($sql);
 	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return $row[0];
	}else{
		return '';
	}
}

function getAnalisaTotalStokByMonth($value) {
 	$conn=db();
 	$sql = "SELECT IFNULL(SUM(asti.kuantiti_item),0) AS total_stok_month FROM agromart_sales_transaction_item asti
 			LEFT JOIN agromart_sales_transaction ast ON asti.id_sales_transaction = ast.id
   			WHERE DATE_FORMAT(asti.created_date,'%Y%m') = '$value'";
 	$result = $conn->query($sql);
 	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return $row[0];
	}else{
		return '';
	}
}

function getAnalisaTotalStokByWeek($start,$end) {
 	$conn=db();
 	$sql = "SELECT IFNULL(SUM(asti.kuantiti_item),0) AS total_stok_week FROM agromart_sales_transaction_item asti
 			LEFT JOIN agromart_sales_transaction ast ON asti.id_sales_transaction = ast.id
   			WHERE DATE_FORMAT(asti.created_date,'%y-%m-%d') 
			BETWEEN DATE_FORMAT('$start','%y-%m-%d') AND DATE_FORMAT('$end','%y-%m-%d')";
 	$result = $conn->query($sql);
 	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return $row[0];
	}else{
		return '';
	}
}

function getAnalisaTotalStokByDay($date) {
	$conn=db();
	$sql = "SELECT IFNULL(SUM(asti.kuantiti_item),0) AS total_stok_day FROM agromart_sales_transaction_item asti
			LEFT JOIN agromart_sales_transaction ast ON asti.id_sales_transaction = ast.id
			WHERE DATE(asti.created_date)='$date'";
	$result = $conn->query($sql);
	$row = mysqli_fetch_array($result, MYSQLI_NUM);
	if($result->num_rows > 0){
		return $row[0];
	}else{
		return '';
	}
}

function getAnalisaTotalStokList() {
	$conn=db();
	$sql = "SELECT asti.*,ast.*,lkps.*,ags.nama AS nama_pembekal,ags.nokp FROM agromart_sales_transaction_item asti
			LEFT JOIN agromart_sales_transaction ast ON asti.id_sales_transaction = ast.id
			LEFT JOIN lkp_stock_type lkps ON asti.kod_item = lkps.kod
			LEFT JOIN agromart_seller ags ON asti.nokp_seller = ags.nokp
			WHERE DATE_FORMAT(asti.created_date,'%Y') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')
			ORDER BY asti.kuantiti_item DESC";
	$result = $conn->query($sql);
	return $result;
}

function getCountAnalisaTotalStok() {
	$conn = db();
	$sql = "SELECT IFNULL(SUM(asti.kuantiti_item),0) AS jumlah_keseluruhan_stok FROM agromart_sales_transaction_item asti
			LEFT JOIN agromart_sales_transaction ast ON asti.id_sales_transaction = ast.id
			WHERE DATE_FORMAT(asti.created_date,'%Y') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')";
	$result = $conn->query($sql) or die($conn->error);
	return $result->fetch_object()->jumlah_keseluruhan_stok;
}
//agromart pembekal analisa stok -end-

//agromart pembekal analisa jualan semasa -start-
function getAnalisaJualanSemasa($month,$current_year) {
	$conn = db();
	$sql = "SELECT ast.*,DATE_FORMAT(ast.created_date,'%M') AS bulan_jualan,DATE_FORMAT(ast.created_date,'%d-%b-%Y') AS tarikh_jualan,IFNULL(SUM(asti.kuantiti_item),0) AS stok_jualan FROM agromart_sales_transaction ast
			LEFT JOIN agromart_sales_transaction_item asti ON ast.id = asti.id_sales_transaction
			WHERE DATE_FORMAT(ast.created_date,'%m') = '$month' AND DATE_FORMAT(ast.created_date,'%Y') = '$current_year'
			GROUP BY asti.id_sales_transaction
			ORDER BY ast.jumlah_jualan DESC";
	$result = $conn->query($sql);
	return $result;
}

function getCountAnalisaJualanSemasa($month,$current_year) {
	$conn = db();
	$sql = "SELECT IFNULL(SUM(jumlah_jualan),0) AS jumlah_keseluruhan_jualan FROM agromart_sales_transaction
			WHERE DATE_FORMAT(created_date,'%m') = '$month' AND DATE_FORMAT(created_date,'%Y') = '$current_year'";
	$result = $conn->query($sql) or die($conn->error);
	return $result->fetch_object()->jumlah_keseluruhan_jualan;
}

function getDropDownTahunJualan($selected) {
  	$conn=db();
  	echo $sql = "SELECT YEAR(created_date) AS year FROM agromart_sales_transaction_item
  			GROUP BY year
  			ORDER BY year DESC";
  	$result = $conn->query($sql);
  	$txt_result="";
  	while ($row  = $result -> fetch_array()){
    	$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
  	}
  	return $txt_result;
}
//agromart pembekal analisa jualan semasa -end-

//agromart pembekal analisa stok semasa -start-
function getAnalisaStokSemasa($month,$current_year) {
	$conn = db();
	$sql = "SELECT agst.*,ags.nama AS nama_pembekal,ags.nokp,lkps.*,(lkps.meter - agst.kuantiti) AS jumlah_baki_stok FROM agromart_stocks agst
			LEFT JOIN agromart_seller ags ON agst.nokp_seller = ags.nokp
			LEFT JOIN lkp_stock_type lkps ON agst.id_stock_type = lkps.id
			WHERE DATE_FORMAT(agst.created_date,'%m') = '$month' AND DATE_FORMAT(agst.created_date,'%Y') = '$current_year'
			ORDER BY agst.id ASC";
	$result = $conn->query($sql);
	return $result;
}

function getCountAnalisaStokSemasa($month,$current_year) {
	$conn = db();
	$sql = "SELECT IFNULL(SUM(kuantiti),0) AS jumlah_keseluruhan_stok FROM agromart_stocks
 			WHERE DATE_FORMAT(created_date,'%m') = '$month' AND DATE_FORMAT(created_date,'%Y') = '$current_year'";
	$result = $conn->query($sql) or die($conn->error);
	return $result->fetch_object()->jumlah_keseluruhan_stok;
}

function getDropDownTahunStok($selected) {
  	$conn=db();
  	echo $sql = "SELECT YEAR(created_date) AS year FROM agromart_stocks
  			GROUP BY year
  			ORDER BY year DESC";
  	$result = $conn->query($sql);
  	$txt_result="";
  	while ($row  = $result -> fetch_array()){
    	$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
  	}
  	return $txt_result;
}
//agromart pembekal analisa stok semasa -end-


$conn->close();

?>