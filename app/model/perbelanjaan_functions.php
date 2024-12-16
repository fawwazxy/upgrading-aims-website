<?php

	require '../../lib/db/connection.php';

	$action=$_POST['action'];
	
	
	

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

	function login($username,$password) {
		$conn=db();
		$sql = "SELECT * FROM staff WHERE username='$username' AND accs_pwd='$password'";
		$result = $conn->query($sql);
		return $result;
	}
	
		
	function getLogUser($com_id) {
		$conn=db();
		$sql = "SELECT * FROM staff WHERE company_id='$com_id'";
		$result = $conn->query($sql);
		return $result;
	}

	function getCompany() {
		$conn=db();
		$sql = "SELECT * FROM company";
		$result = $conn->query($sql);
		return $result;
	}

	function getBaucarBayaran($id){
		$conn=db();
		$sql = "SELECT p.*,r.description AS perbelanjaan, n.notel_penerima, n.nama_penerima AS penerima_baucar,amaun_bayaran AS total_baucar, j.nama FROM rekod_perbelanjaan p
		LEFT JOIN perbelanjaan r ON p.perbelanjaan=r.id
		LEFT JOIN nama_penerima n ON p.nama_penerima=n.id
		LEFT JOIN jenis_perbelanjaan j ON p.jenis_perbelanjaan=j.id
		WHERE p.id='$id'";

		$result = $conn->query($sql);
		return $result;
	}



	function getPerbelanjaanDetails($id) {
		$conn=db();
		$sql = "SELECT p.*, j.nama, n.nama_penerima AS penerima, n.notel_penerima, r.description FROM rekod_perbelanjaan p 
		LEFT JOIN jenis_perbelanjaan j ON p.jenis_perbelanjaan=j.id
		LEFT JOIN nama_penerima n ON p.nama_penerima=n.id
		LEFT JOIN perbelanjaan r ON p.perbelanjaan=r.id
		WHERE p.id = '$id'";

		$result = $conn->query($sql);
		return $result;
	}

	function addPerbelanjaan($hr_bertugas, $perbelanjaan, $jenis_perbelanjaan, $file_upload, $file_name, $catatan, $amaun_bayaran, $tarikh_bayaran_dibuat, $nama_penerima, $rujukan, $details_rujukan, $shortcode){
		$conn=db();
		 $sql = "INSERT INTO rekod_perbelanjaan (hr_bertugas, perbelanjaan, jenis_perbelanjaan, file_upload, file_name, catatan, amaun_bayaran, 
		tarikh_bayaran_dibuat, nama_penerima, rujukan, details_rujukan, no_rujukan)  
 		VALUES ('$hr_bertugas', '$perbelanjaan', '$jenis_perbelanjaan', '$file_upload', '$file_name','$catatan', '$amaun_bayaran', 
 		'$tarikh_bayaran_dibuat', '$nama_penerima',  '$rujukan', '$details_rujukan',
 		(SELECT CONCAT('$shortcode','/','BLJ','/',YEAR(CURRENT_TIMESTAMP),'/', LPAD(IFNULL(MAX(p.id), 0) + 1, 4, '0')) AS no_rujukan 
		FROM rekod_perbelanjaan p))";

		
		$result = $conn->query($sql);
		return $result;
	}

	function editPerbelanjaan($perbelanjaan, $jenis_perbelanjaan, $file_upload, $file_name, $catatan, $amaun_bayaran, $tarikh_bayaran_dibuat, $nama_penerima, $rujukan, $details_rujukan, $id) {
		$conn=db();

		if($file_name != ""){
			$sqlfile = ", file_upload='$file_upload', 
		file_name='$file_name'";
		}

		$sql = "UPDATE rekod_perbelanjaan SET perbelanjaan='$perbelanjaan', jenis_perbelanjaan='$jenis_perbelanjaan', catatan='$catatan', amaun_bayaran='$amaun_bayaran', tarikh_bayaran_dibuat='$tarikh_bayaran_dibuat', nama_penerima='$nama_penerima', rujukan='$rujukan', details_rujukan='$details_rujukan' $sqlfile
		WHERE id='$id'" ;

		$result = $conn->query($sql);
		return $result;
	}

	function getBelanjaInfo($id){
		$conn=db();
		$sql = "
		SELECT p.*, n.nama_penerima AS penerima_baucar, r.description AS perbelanjaan_baucar FROM rekod_perbelanjaan p
		LEFT JOIN perbelanjaan r ON p.perbelanjaan=r.id
		LEFT JOIN nama_penerima n ON p.nama_penerima=n.id
		WHERE p.id='$id'";

		$result = $conn->query($sql);
		return $result;
	}
	function getPerbelanjaanInfo($id) {
		$conn=db();
		$sql = "SELECT * FROM rekod_perbelanjaan WHERE id='$id'" ;
		
		$result = $conn->query($sql);
		return $result;
	}

	function getNamaPerbelanjaanInfo($id) {
		$conn=db();
		$sql = "SELECT * FROM perbelanjaan WHERE id='$id'" ;
		
		$result = $conn->query($sql);
		return $result;
	}

	function getNamaPenerimaInfo($id) {
		$conn=db();
		$sql = "SELECT * FROM nama_penerima WHERE id='$id'" ;
		
		$result = $conn->query($sql);
		return $result;
	}


	function deletePerbelanjaan($id) {
	    $conn=db();
	    $sql = "DELETE FROM rekod_perbelanjaan WHERE id='$id' ";
	       
	    $result = $conn->query($sql);
		return $result;
	}
	
	function updateStatusPenerimaanBaucarBayaran($id,$status_jawapan){
		 $conn=db();
		  $sql = "UPDATE rekod_perbelanjaan 
		 SET status='$status_jawapan' 
		 WHERE id='$id'" ;
		 $result = $conn->query($sql);
		 return $result;
	}
	
	function getJenisPerbelanjaan(){
		$conn=db();
		$sql = "SELECT * FROM jenis_perbelanjaan" ;
		
		$result = $conn->query($sql);
		return $result;
	}

	function getPerbelanjaan($bulan,$tahun){
		$conn=db();
		if($bulan != ""){
			$sqlbulan = "AND DATE_FORMAT(tarikh_bayaran_dibuat,'%m') = '$bulan'";	
		}
		

	 	$sql = "SELECT DATE_FORMAT(tarikh_bayaran_dibuat,'%m') AS bulan, DATE_FORMAT(tarikh_bayaran_dibuat,'%Y') AS tahun,p.*, j.nama, 
	 	n.nama_penerima, r.description,n.notel_penerima
	 	FROM rekod_perbelanjaan p 
	 	LEFT JOIN jenis_perbelanjaan j ON p.jenis_perbelanjaan=j.id
	 	LEFT JOIN nama_penerima n ON p.nama_penerima=n.id
	 	LEFT JOIN perbelanjaan r ON p.perbelanjaan=r.id
	 	where DATE_FORMAT(tarikh_bayaran_dibuat,'%Y') = '$tahun' $sqlbulan
	 	ORDER BY created_date DESC";
		
		$result = $conn->query($sql);
	 	return $result;
	}

	function getNamaPerbelanjaan(){
			$conn=db();
			$sql = "SELECT * FROM perbelanjaan" ;
			
			$result = $conn->query($sql);
			return $result;
	}

	function addNamaPerbelanjaan($description){
	    $conn=db();
	    $sql = "INSERT INTO perbelanjaan (description) VALUES ('$description')";

	    $result = $conn->query($sql);
	    return $result;
	}

    function deleteNamaPerbelanjaan($id){
	    $conn=db();
	    $sql = "DELETE FROM perbelanjaan WHERE id='$id'";
	    
	    $result = $conn->query($sql);
	    return $result;
	}

    function editNamaPerbelanjaan($description, $id) {
		$conn=db();
		$sql = "UPDATE perbelanjaan SET description='$description' WHERE id='$id'" ;
		
		$result = $conn->query($sql);
		return $result;
    }
	

	function getNamaPenerima(){
		$conn=db();
		$sql = "SELECT * FROM nama_penerima" ;
		
		$result = $conn->query($sql);
		return $result;
	}

	function addNamaPenerima($nama_penerima, $notel_penerima){
	    $conn=db();
	    $sql = "INSERT INTO nama_penerima (nama_penerima, notel_penerima) VALUES ('$nama_penerima', '$notel_penerima')";

	    $result = $conn->query($sql);
	    return $result;
	}

    function deleteNamaPenerima($id){
	    $conn=db();
	    $sql = "DELETE FROM nama_penerima WHERE id='$id'";
	    
	    $result = $conn->query($sql);
	    return $result;
	}

    function editNamaPenerima($nama_penerima, $notel_penerima, $id) {
		$conn=db();
		$sql = "UPDATE nama_penerima SET nama_penerima='$nama_penerima', notel_penerima='$notel_penerima' WHERE id='$id'" ;
		
		$result = $conn->query($sql);
		return $result;
    }
	

	function getPerbelanjaanOverview($bulan, $tahun){
		$conn=db();
		$sql= " SELECT SUM(amaun_bayaran) AS total_bayaran, amaun_bayaran, DATE_FORMAT(p.tarikh_bayaran_dibuat,'%m')AS bulan ,
		DATE_FORMAT(p.tarikh_bayaran_dibuat,'%Y') AS tahun
	    FROM rekod_perbelanjaan p
	    WHERE tarikh_bayaran_dibuat='$tarikh_bayaran_dibuat'
	    AND DATE_FORMAT(p.tarikh_bayaran_dibuat,'%m') ='$bulan' AND DATE_FORMAT(p.tarikh_bayaran_dibuat,'%Y')='$tahun' ";

    	$result = $conn->query($sql);
		return $result;
	}

	function getOverviewPerbelanjaan($bulan,$tahun){
		$conn=db();
		$sql="SELECT SUM(p.amaun_bayaran) AS total_perbelanjaan, p.perbelanjaan, r.description,
		DATE_FORMAT(tarikh_bayaran_dibuat,'%Y') AS tahun, DATE_FORMAT(tarikh_bayaran_dibuat,'%m')AS bulan
		FROM rekod_perbelanjaan p
		LEFT JOIN perbelanjaan r ON p.perbelanjaan=r.id
		WHERE MONTH(tarikh_bayaran_dibuat)='$bulan' AND YEAR(tarikh_bayaran_dibuat)='$tahun'
		GROUP BY bulan, tahun, p.perbelanjaan";


        $result = $conn->query($sql);
		return $result;
	}

	function getTotalOverviewPerbelanjaan($bulan,$tahun){
		$conn=db();
		$sql="SELECT SUM(p.amaun_bayaran) AS total ,DATE_FORMAT(tarikh_bayaran_dibuat,'%m')AS bulan,
		DATE_FORMAT(tarikh_bayaran_dibuat,'%Y') AS tahun 
		FROM rekod_perbelanjaan p
		LEFT JOIN perbelanjaan r ON p.perbelanjaan=r.id
		WHERE DATE_FORMAT(tarikh_bayaran_dibuat,'%m')='$bulan' AND DATE_FORMAT(tarikh_bayaran_dibuat,'%Y')='$tahun' 
		GROUP BY bulan, tahun";


    	$result = $conn->query($sql);
		return $result;
	}

	function getTotalAmountPerMonth($tahun,$bulan){
		$conn=db();
		$sql="SELECT SUM(amaun_bayaran) AS total FROM rekod_perbelanjaan p 
		WHERE MONTH(tarikh_bayaran_dibuat)= '$bulan' AND
		YEAR(tarikh_bayaran_dibuat)= '$tahun'";


    	$result = $conn->query($sql);
		return $result->fetch_object()->total;
	}

	function getResitImg($id){
		$conn=db();
		$sql="SELECT * FROM rekod_perbelanjaan WHERE id='$id'";

		$result = $conn->query($sql);
		$default= $result-> fetch_assoc();
		echo '<img src="data:image/jpeg;base64,'.base64_encode( $default['file_upload'] ).'" style="width: 350px; height: 350px;"/>';

	}


	function getTotalPerbelanjaanJan(){
		$conn=db();
		$sql = "  SELECT COUNT(*) AS countTotalJan,
	    DATE_FORMAT(p.tarikh_bayaran_dibuat,'%M') AS bulan
	    FROM rekod_perbelanjaan p
	    WHERE MONTH(tarikh_bayaran_dibuat) = 1";
		

		$result = $conn->query($sql);
		$results =  $result->fetch_object()->countTotalJan;
		return $results;

	}


	function getTotalPerbelanjaanFeb(){
		$conn=db();
		$sql = " SELECT COUNT(*) AS countTotalFeb,
	    DATE_FORMAT(p.tarikh_bayaran_dibuat,'%M') AS bulan
	    FROM rekod_perbelanjaan p
	    WHERE MONTH(tarikh_bayaran_dibuat) = 2";
		 

		$result = $conn->query($sql);
		$results =  $result->fetch_object()->countTotalFeb;
		return $results;

	}


	function getTotalPerbelanjaanMac(){
		$conn=db();
		$sql = " SELECT COUNT(*) AS countTotalMac,
	    DATE_FORMAT(p.tarikh_bayaran_dibuat,'%M') AS bulan
	    FROM rekod_perbelanjaan p
	    WHERE MONTH(tarikh_bayaran_dibuat) = 3";
		  

		$result = $conn->query($sql);
		$results =  $result->fetch_object()->countTotalMac;
		return $results;

	}

	function getTotalPerbelanjaanApr(){
		$conn=db();
		$sql = " SELECT COUNT(*) AS countTotalApr,
	    DATE_FORMAT(p.tarikh_bayaran_dibuat,'%M') AS bulan
	    FROM rekod_perbelanjaan p
	    WHERE MONTH(tarikh_bayaran_dibuat) = 4";
		  

		$result = $conn->query($sql);
		$results =  $result->fetch_object()->countTotalApr;
		return $results;

	}


	function getTotalPerbelanjaanMei(){
		$conn=db();
		$sql = " SELECT COUNT(*) AS countTotalMei,
	    DATE_FORMAT(p.tarikh_bayaran_dibuat,'%M') AS bulan
	    FROM rekod_perbelanjaan p
	    WHERE MONTH(tarikh_bayaran_dibuat) = 5";
		  

		$result = $conn->query($sql);
		$results =  $result->fetch_object()->countTotalMei;
		return $results;

	}


	function getTotalPerbelanjaanJun(){
		$conn=db();
		$sql = " SELECT COUNT(*) AS countTotalJun,
	    DATE_FORMAT(p.tarikh_bayaran_dibuat,'%M') AS bulan
	    FROM rekod_perbelanjaan p
	    WHERE MONTH(tarikh_bayaran_dibuat) = 6";
		  

		$result = $conn->query($sql);
		$results =  $result->fetch_object()->countTotalJun;
		return $results;

	}


	function getTotalPerbelanjaanJul(){
		$conn=db();
		$sql = "  SELECT COUNT(*) AS countTotalJul,
	    DATE_FORMAT(p.tarikh_bayaran_dibuat,'%M') AS bulan
	    FROM rekod_perbelanjaan p
	    WHERE MONTH(tarikh_bayaran_dibuat) = 7";
		  

		$result = $conn->query($sql);
		$results =  $result->fetch_object()->countTotalJul;
		return $results;

	}


	function getTotalPerbelanjaanOgos(){
		$conn=db();
		$sql = " SELECT COUNT(*) AS countTotalOgos,
	    DATE_FORMAT(p.tarikh_bayaran_dibuat,'%M') AS bulan
	    FROM rekod_perbelanjaan p
	    WHERE MONTH(tarikh_bayaran_dibuat) = 8";
		 

		$result = $conn->query($sql);
		$results =  $result->fetch_object()->countTotalOgos;
		return $results;

	}


	function getTotalPerbelanjaanSept(){
		$conn=db();
		$sql = " SELECT COUNT(*) AS countTotalSept,
	    DATE_FORMAT(p.tarikh_bayaran_dibuat,'%M') AS bulan
	    FROM rekod_perbelanjaan p
	    WHERE MONTH(tarikh_bayaran_dibuat) = 9";
		  

		$result = $conn->query($sql);
		$results =  $result->fetch_object()->countTotalSept;
		return $results;

	}


	function getTotalPerbelanjaanOct(){
		$conn=db();
		$sql = " SELECT COUNT(*) AS countTotalOct,
	    DATE_FORMAT(p.tarikh_bayaran_dibuat,'%M') AS bulan
	    FROM rekod_perbelanjaan p
	    WHERE MONTH(tarikh_bayaran_dibuat) = 10";
		  

		$result = $conn->query($sql);
		$results =  $result->fetch_object()->countTotalOct;
		return $results;

	}


	function getTotalPerbelanjaanNov(){
		$conn=db();
		$sql = " SELECT COUNT(*) AS countTotalNov,
	    DATE_FORMAT(p.tarikh_bayaran_dibuat,'%M') AS bulan
	    FROM rekod_perbelanjaan p
	    WHERE MONTH(tarikh_bayaran_dibuat) = 11";
		  

		$result = $conn->query($sql);
		$results =  $result->fetch_object()->countTotalNov;
		return $results;

	}

	
	function getTotalPerbelanjaanDis(){
		$conn=db();
		$sql = " SELECT COUNT(*) AS countTotalDis,
	    DATE_FORMAT(p.tarikh_bayaran_dibuat,'%M') AS bulan
	    FROM rekod_perbelanjaan p
	    WHERE MONTH(tarikh_bayaran_dibuat) = 12";
		  

		$result = $conn->query($sql);
		$results =  $result->fetch_object()->countTotalDis;
		return $results;

	}


	function getPerbelanjaanMengikutNamaPenerima(){
		$conn=db();
		$sql = "SELECT COUNT(*) AS xcount, n.nama_penerima AS penerima
		FROM rekod_perbelanjaan p
		LEFT JOIN nama_penerima n ON p.nama_penerima=n.id
		GROUP BY n.nama_penerima";

		 $result = $conn->query($sql);
		return $result;

	}


	function getAnalisaPerbelanjaan(){
		$conn=db();
		$sql = "SELECT COUNT(*) AS xcount, r.description AS belanja
		FROM rekod_perbelanjaan p
		LEFT JOIN perbelanjaan r ON p.perbelanjaan=r.id
		GROUP BY r.description";

		$result = $conn->query($sql);
		return $result;

	}


	function getCountPerbelanjaanMengikutNamaPenerima(){
		$conn=db();
		$sql = "SELECT COUNT(*) AS COUNT
		FROM rekod_perbelanjaan p
		LEFT JOIN nama_penerima n ON p.nama_penerima=n.id";

		$result = $conn->query($sql);
		return $result;

	}


	function getCountRekodPerbelanjaan(){
		$conn=db();
		$sql = "SELECT COUNT(*) AS COUNT
		FROM rekod_perbelanjaan p
		LEFT JOIN perbelanjaan r ON p.perbelanjaan=r.id";

		$result = $conn->query($sql);
		return $result;


}
	function getTotalPerbelanjaanTahun($tahun){
		$conn=db();
		$sql ="SELECT COUNT(*) AS total FROM rekod_perbelanjaan p
		WHERE YEAR(tarikh_bayaran_dibuat) = '$tahun'";
		  
		$result = $conn->query($sql);
  		$results =  $result->fetch_object()->total;
		return $results;


	}


	function getAnalisaStatusPerbelanjaan(){
		$conn=db();
	    $sql = " SELECT COUNT(*) AS xcount, p.status, s.keterangan
		FROM rekod_perbelanjaan p
		LEFT JOIN status_baucar_bayaran s ON p.status=s.id_status
		GROUP BY p.status, s.keterangan";
		    

	    $result = $conn->query($sql);
		return $result;
	}

	function getMonthString($num)
{

          //Create a local variable to hold the string
	switch($num)
	{
		case 1:
		$month="Januari";
		break;
		case 2:
		$month="Februari";
		break;
		case 3:
		$month="Mac";
		break;
		case 4:
		$month="April";
		break;
		case 5:
		$month="Mei";
		break;
		case 6:
		$month="Jun";
		break;
		case 7:
		$month="Julai";
		break;
		case 8:
		$month="Ogos";
		break;
		case 9:
		$month="September";
		break;
		case 10:
		$month="Oktober";
		break;
		case 11:
		$month="November";
		break;
		case 12:
		$month="Disember";
		break;
		default:
		$month="Invalid month";
	}
	return $month;
}




	$conn->close();
?>