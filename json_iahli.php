<?php
//phpinfo();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header('Content-type: application/json');

require_once('lib/json.inc');

error_log('json_iahli.php');
error_reporting(E_ALL);
ini_set("display_errors", 0);

$JsonSystem = new Json();

$cmd = $JsonSystem->getGETPOST('cmd');

$output = '';
$output_to_send = '';
switch($cmd) {
	
	case '1'://Login
	    $nokp = $JsonSystem->getGETPOST('nokp');
	    $password = $JsonSystem->getGETPOST('password');
		
		$sql ="SELECT a.id,a.no_ahli,a.nama,a.alamat,a.nokp,a.password,a.notel,a.gps_koordinat,a.role,a.`status`,
		a.photo_filename ,akg.nama_galur AS galur
		FROM ahli_users a LEFT JOIN ahli_lkp_galur akg ON a.galur=akg.kod 
		WHERE a.`status` = '1' AND a.nokp = '$nokp' AND a.password= '$password'";
		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '2'://check status AKTIF/TIDAK
	
		$id = $JsonSystem->getGETPOST('id');
		
		$sql="SELECT status FROM ahli_users where id ='$id'";
		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '3'://dropdown kategori umur
	
		$sql="SELECT CONCAT(ak.umur_mula,' TAHUN',' - ',ak.umur_tamat,' TAHUN') AS kategori,ak.kod FROM ahli_kategori_umur ak WHERE ak.`status` = '1'";
		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '4'://jejak ahli & carian jejak ahli mengikut negeri
	
		$kategori_negeri = $JsonSystem->getGETPOST('kategori_negeri');
		$kategori_daerah = $JsonSystem->getGETPOST('kategori_daerah');
		$search_word = $JsonSystem->getGETPOST('search_word');
		
		if($search_word == '')//negeri
		{
			if($kategori_daerah =='') //negeri
			{
				$sql="SELECT
					a.id,a.no_ahli,UPPER(a.nama) AS nama,a.notel,a.gps_koordinat,
					UPPER(a.alamat) AS alamat,akg.nama_galur AS galur,ah.keterangan AS status_ahli,
					lkp.name AS negeri,ld.daerah AS daerah,IFNULL(a.asnaf,'TIDAK') AS asnaf,
					(CASE
						  WHEN a.anak_yatim = '1'
						  THEN 'YA'
						  ELSE 'TIDAK'
					END) AS anak_yatim, 
					(CASE
						  WHEN a.oku = '1'
						  THEN 'YA'
						  ELSE 'TIDAK'
					END)AS oku
					FROM ahli_users a 
					LEFT JOIN ahli_lkp_galur akg ON a.galur=akg.kod
					LEFT JOIN ahli_status_ahli ah ON a.status_ahli = ah.kod
					LEFT JOIN lkp_negeri lkp ON a.negeri= lkp.code
					LEFT JOIN lkp_daerah ld ON a.daerah= ld.kod_daerah
					WHERE a.negeri = '$kategori_negeri' AND a.`status`='1' ORDER BY a.nama ASC";
			}
			else //negeri dan daerah
			{
				$sql="SELECT
					a.id,a.no_ahli,UPPER(a.nama) AS nama,a.notel,a.gps_koordinat,
					UPPER(a.alamat) AS alamat,akg.nama_galur AS galur,ah.keterangan AS status_ahli,
					lkp.name AS negeri,ld.daerah AS daerah,IFNULL(a.asnaf,'TIDAK') AS asnaf,
					(CASE
						  WHEN a.anak_yatim = '1'
						  THEN 'YA'
						  ELSE 'TIDAK'
					END) AS anak_yatim, 
					(CASE
						  WHEN a.oku = '1'
						  THEN 'YA'
						  ELSE 'TIDAK'
					END)AS oku
					FROM ahli_users a 
					LEFT JOIN ahli_lkp_galur akg ON a.galur=akg.kod
					LEFT JOIN ahli_status_ahli ah ON a.status_ahli = ah.kod
					LEFT JOIN lkp_negeri lkp ON a.negeri= lkp.code
					LEFT JOIN lkp_daerah ld ON a.daerah= ld.kod_daerah
					WHERE a.negeri = '$kategori_negeri' AND a.daerah='$kategori_daerah' AND a.`status`='1' ORDER BY a.nama ASC";
			}
		}
		else
		{
			$sql="SELECT
					a.id,a.no_ahli,UPPER(a.nama) AS nama,a.notel,a.gps_koordinat,
					UPPER(a.alamat) AS alamat,akg.nama_galur AS galur,ah.keterangan AS status_ahli,
					lkp.name AS negeri,ld.daerah AS daerah,IFNULL(a.asnaf,'TIDAK') AS asnaf,
					(CASE
						  WHEN a.anak_yatim = '1'
						  THEN 'YA'
						  ELSE 'TIDAK'
					END) AS anak_yatim, 
					(CASE
						  WHEN a.oku = '1'
						  THEN 'YA'
						  ELSE 'TIDAK'
					END)AS oku
					FROM ahli_users a 
					LEFT JOIN ahli_lkp_galur akg ON a.galur=akg.kod
					LEFT JOIN ahli_status_ahli ah ON a.status_ahli = ah.kod
					LEFT JOIN lkp_negeri lkp ON a.negeri= lkp.code
					LEFT JOIN lkp_daerah ld ON a.daerah= ld.kod_daerah 
				WHERE (a.nama LIKE '%$search_word%' OR a.alamat LIKE '%$search_word%') AND a.`status`='1' ORDER BY a.nama ASC";
		}
		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '5'://dropdown negeri
	
		$sql="SELECT CONCAT(lkp.code,'-',lkp.name) AS negeri FROM lkp_negeri lkp WHERE lkp.`status` = '1' ORDER BY lkp.code ASC ";
		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
		
	break;
	
	case '6'://dropdown galur
	
		$sql="SELECT CONCAT(lkp.kod,'-',lkp.nama_galur) AS galur FROM ahli_lkp_galur lkp WHERE lkp.`status` = '1' ORDER BY lkp.kod ASC ";
		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
		
	break;
	
	case '7'://daftar ahli
	
	$nama = $JsonSystem->getGETPOST('nama');
	$nama_panggilan = $JsonSystem->getGETPOST('nama_panggilan');
	$nokp = $JsonSystem->getGETPOST('nokp');
	$notel = $JsonSystem->getGETPOST('notel');
	$umur = $JsonSystem->getGETPOST('umur');
	$negeri = $JsonSystem->getGETPOST('negeri');
	$daerah = $JsonSystem->getGETPOST('daerah');
	$galur = $JsonSystem->getGETPOST('galur');
	$alamat = $JsonSystem->getGETPOST('alamat');
	$koordinat = $JsonSystem->getGETPOST('koordinat');
	$asnaf = $JsonSystem->getGETPOST('asnaf');
	$anak_yatim = $JsonSystem->getGETPOST('anak_yatim');
	$oku = $JsonSystem->getGETPOST('oku');
	$nota = $JsonSystem->getGETPOST('nota');
	
	if($asnaf!='')
	{
		$_asnaf = ",'$asnaf'";
		$column_asnaf = ",asnaf";
	}
	else
	{
		$_asnaf = '';
		$column_asnaf = '';
	}
	
		$sql="INSERT INTO ahli_users (nama,nama_panggilan,nokp,password,notel,gps_koordinat,kategori_umur,galur,alamat,negeri,daerah,status_ahli,anak_yatim,oku,nota$column_asnaf) 
				VALUES (UPPER('$nama'),UPPER('$nama_panggilan')
				,'$nokp','$nokp','$notel','$koordinat','$umur','$galur',
				UPPER('$alamat'),'$negeri','$daerah','BD','$anak_yatim','$oku','$nota'$_asnaf)";
		
		$JsonSystem->executeOperation2($sql);
		$output_to_send = "Pendaftaran berjaya.";
		
	break;
						
	case '8'://maklumat kemaskini ahli
	
	$id = $JsonSystem->getGETPOST('id');
	
		$sql="SELECT a.id,UPPER(a.nama) AS nama,UPPER(a.nama_panggilan) AS nama_panggilan,a.nokp,UPPER(a.alamat) AS alamat,a.notel,a.gps_koordinat,
		CONCAT(ku.umur_mula,' TAHUN',' - ',ku.umur_tamat,' TAHUN') AS kategori_umur,ku.kod AS kod_umur,
		CONCAT(LN.code,'-',LN.name) AS negeri,CONCAT(Ld.kod_daerah,'-',Ld.daerah) AS daerah, CONCAT(lg.kod,'-',lg.nama_galur) AS galur, a.asnaf,
		a.anak_yatim,a.oku,a.nota
		FROM ahli_users a 
		LEFT JOIN lkp_negeri LN ON a.negeri = LN.code
		LEFT JOIN lkp_daerah Ld ON a.daerah = Ld.kod_daerah
		LEFT JOIN ahli_lkp_galur lg ON a.galur = lg.kod
		LEFT JOIN ahli_kategori_umur ku ON a.kategori_umur = ku.kod
		WHERE a.id = '$id'";
		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;

	case '9'://geolocation
	
	$lat = $JsonSystem->getGETPOST('lat');
	$lng = $JsonSystem->getGETPOST('lng'); 
	  
	$geocode = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$lng."&sensor=false&key=AIzaSyCyciSZxMmYCFy4GsJsEh0nKZezKwHvw_I";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $geocode);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);
    $output = json_decode($response);
    $dataarray = get_object_vars($output);
    if ($dataarray['status'] != 'ZERO_RESULTS' && $dataarray['status'] != 'INVALID_REQUEST') {
        if (isset($dataarray['results'][0]->formatted_address)) {

            $address = $dataarray['results'][0]->formatted_address;

        } else {
            $address = 'Tidak dijumpai';

        }
    } else {
        $address = 'Tidak dijumpai';
    }

	$output_to_send = '[{"address":"'.$address.'"}]';
	break;	
	
	case '10'://kemaskini ahli
	
	$id = $JsonSystem->getGETPOST('id');
	$nama = $JsonSystem->getGETPOST('nama');
	$nama_panggilan = $JsonSystem->getGETPOST('nama_panggilan');
	$nokp = $JsonSystem->getGETPOST('nokp');
	$notel = $JsonSystem->getGETPOST('notel');
	$umur = $JsonSystem->getGETPOST('umur');
	$negeri = $JsonSystem->getGETPOST('negeri');
	$daerah = $JsonSystem->getGETPOST('daerah');
	$galur = $JsonSystem->getGETPOST('galur');
	$alamat = $JsonSystem->getGETPOST('alamat');
	$koordinat = $JsonSystem->getGETPOST('koordinat');
	$asnaf = $JsonSystem->getGETPOST('asnaf');
	$anak_yatim = $JsonSystem->getGETPOST('anak_yatim');
	$oku = $JsonSystem->getGETPOST('oku');
	$nota = $JsonSystem->getGETPOST('nota');
	
	$column_asnaf = ",asnaf";
	
	if($asnaf!='')
	{
		$_asnaf = "='$asnaf'";
	}
	else
	{
		$_asnaf = "=NULL";
	}
	
		$sql= "UPDATE ahli_users SET nama=UPPER('$nama'),nama_panggilan='$nama_panggilan',nokp='$nokp',notel='$notel',gps_koordinat='$koordinat',kategori_umur='$umur',
		galur='$galur',alamat=UPPER('$alamat'),anak_yatim='$anak_yatim',oku='$oku',nota='$nota',daerah='$daerah',negeri='$negeri'$column_asnaf$_asnaf WHERE id='$id'";
							
		$JsonSystem->executeOperation2($sql);
		$output_to_send = "Kemaskini berjaya.";
		
	break;
	
	case '11'://display pengumuman
	
		$sql="SELECT ap.id,UPPER(ap.tajuk) AS tajuk,ap.keterangan,
		CONCAT(DATE_FORMAT(ap.tarikh_mula,'%d-%m-%Y'),' ~ ',DATE_FORMAT(ap.tarikh_tamat,'%d-%m-%Y')) AS tarikh,dokumen_filename
		FROM ahli_pengumuman ap WHERE ap.`status`='1' AND ap.kategori='0' ORDER BY tarikh DESC";
		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	//download dokumen
	// case '12':
	
	// //$id = $JsonSystem->getGETPOST('id');
	// //$domain = $JsonSystem->getGETPOST('domain');
	
	// $f_domain = $domain.'/iahli/lampiran/1.jpg';
	// $urld = urlencode($f_domain);
	// $file = urldecode($urld);
	// $filename= '';
	// // $sql = "SELECT ap.dokumen_filename FROM ahli_pengumuman ap WHERE ap.id = '$id'";
	
				// // $d = $connjson->query($sql);
				// // if($d->num_rows>0){
				// // $result = $d->fetch_object();
				// // $filename =$result -> dokumen_filename;
				
				// $url = $f_domain.$filename;
				// echo $filepath = basename($url);
		
				
				// // Process download
				// if(file_exists($url)) {
					// header('Content-Description: File Transfer');
					// header('Content-Type: application/octet-stream');
					// header('Content-Disposition: attachment; filename="'.basename($url).'"');
					// header('Expires: 0');
					// header('Cache-Control: must-revalidate');
					// header('Pragma: public');
					// header('Content-Length: ' . filesize($url));
					// flush(); // Flush system output buffer
					// readfile($url);
					// exit;
				// }
			// //}
	// break;
	
	//analisa mengikut status ahli - kategori umur
	case '13':
	
	$sql = "SELECT ash.kod,(SELECT CONCAT(COUNT(a.nokp),'=',ash.keterangan,' ( ',ash.kod,' )') FROM ahli_users a
			LEFT JOIN ahli_kategori_umur ak ON a.kategori_umur=ak.kod
			WHERE a.status='1' AND a.status_ahli=ash.kod AND ak.`status`='1') AS maklumat
			FROM ahli_status_ahli ash WHERE ash.`status`='1' ORDER BY ash.id ASC";
			
			$result = $conn->query($sql);
			$output = "";
			if($result->num_rows > 0)//ada data
							{
								$i = 0;
								echo '[';
								$jum_keseluruhan = 0;
								while($data = $result->fetch_assoc()) {
									
									if($i>0)
									$output .=",";
									$output .="{";
									$kod = $data['kod'];
									$output .='"0":"'.$kod.'",';
									$i++;
									
									$maklumat = $data['maklumat'];
									$data_jum = explode('=',$maklumat);
									$jum = $data_jum[0];
									
									$jum_keseluruhan = $jum_keseluruhan + $jum;
									//$array = $i - 1;
									$output .='"maklumat":"'.$maklumat.'"';
									$output .="}";
								}
								$output .=',{"0":"'.$maklumat.'",';
								$output .='"maklumat":"'.$jum_keseluruhan.'=JUM. KESELURUHAN"}';
							}
	echo $output;
	echo ']';
	break;
	
	//analisa mengikut kategori umur
	case '14':
	
	$sql_kategori = "SELECT CONCAT(aku.kod,'~','ANALISA AHLI KATEGORI ',UPPER(aku.keterangan),' ( ',aku.umur_mula,' TAHUN - ',aku.umur_tamat,' TAHUN ',')') AS
	kod FROM ahli_kategori_umur aku WHERE aku.`status`='1' ORDER BY aku.id ASC";
	
	$result_kategori = $conn->query($sql_kategori);
	
	$a = 0;
	$output_kategori = "";
	$last_output_kategori = "";
	while($data =$result_kategori->fetch_assoc())//ada data
	{
		if($a>0)
		$output_kategori .=",";
		
		$output_kategori .="{";
		
		$kg = explode('~',$data['kod']);
		$kod_kategori = $kg[0];
		$header_kategori = $kg[1];
		
		$output_kategori .='"0":"'.$kod_kategori.'",';
		
		$a++;
		
		$output_kategori .='"kod_kategori":"'.$header_kategori;					
		
			$sql = "SELECT ash.kod,(SELECT CONCAT(COUNT(a.nokp),'=',ash.keterangan,' ( ',ash.kod,' )') FROM ahli_users a
			WHERE a.status='1' AND a.status_ahli=ash.kod AND a.kategori_umur ='$kod_kategori') AS maklumat
			FROM ahli_status_ahli ash WHERE ash.`status`='1' ORDER BY ash.id ASC";
			
			$result = $conn->query($sql);
			$output = "";
			if($result->num_rows > 0)//ada data
							{
								$i = 0;
								$jum_keseluruhan = 0;
								while($data = $result->fetch_assoc()) {
									
									if($i>0)
									$output .=",";
									$output .="{";
									$kod = $data['kod'];
									$output .="~0~:~".$kod."~,";
									$i++;
									
									$maklumat = $data['maklumat'];
									$data_jum = explode('=',$maklumat);
									$jum = $data_jum[0];
									
									$jum_keseluruhan = $jum_keseluruhan + $jum;
									//$array = $i - 1;
									$output .="~maklumat~:~".$maklumat."~";
									$output .="}";
								}
								$output .=",{~0~:~".$maklumat."~,";
								$output .="~maklumat~:~".$jum_keseluruhan."=JUM. KESELURUHAN~}";
							}
		$output_kategori .='%['.$output.']"}';
	}
	echo $last_output_kategori = '['.$output_kategori.']';
	break;
	
	//analisa mengikut status ahli - galur
	case '15':
	
	$sql = "SELECT ash.kod,(SELECT CONCAT(COUNT(a.nokp),'=',ash.keterangan,' ( ',ash.kod,' )') FROM ahli_users a
			LEFT JOIN ahli_lkp_galur ag ON a.galur=ag.kod
			WHERE a.status='1' AND a.status_ahli=ash.kod AND ag.`status`='1') AS maklumat
			FROM ahli_status_ahli ash WHERE ash.`status`='1' ORDER BY ash.id ASC";
			
			$result = $conn->query($sql);
			$output = "";
			if($result->num_rows > 0)//ada data
							{
								$i = 0;
								echo '[';
								$jum_keseluruhan = 0;
								while($data = $result->fetch_assoc()) {
									
									if($i>0)
									$output .=",";
									$output .="{";
									$kod = $data['kod'];
									$output .='"0":"'.$kod.'",';
									$i++;
									
									$maklumat = $data['maklumat'];
									$data_jum = explode('=',$maklumat);
									$jum = $data_jum[0];
									
									$jum_keseluruhan = $jum_keseluruhan + $jum;
									//$array = $i - 1;
									$output .='"maklumat":"'.$maklumat.'"';
									$output .="}";
								}
								$output .=',{"0":"'.$maklumat.'",';
								$output .='"maklumat":"'.$jum_keseluruhan.'=JUM. KESELURUHAN"}';
							}
	echo $output;
	echo ']';
	break;
	
	//analisa mengikut galur
	case '16':
	
	$sql_kategori = "SELECT CONCAT(ag.kod,'~','ANALISA AHLI GALUR ',UPPER(ag.nama_galur)) AS
	kod FROM ahli_lkp_galur ag WHERE ag.`status`='1' ORDER BY ag.id ASC";
	
	$result_kategori = $conn->query($sql_kategori);
	
	$a = 0;
	$output_kategori = "";
	$last_output_kategori = "";
	while($data =$result_kategori->fetch_assoc())//ada data
	{
		if($a>0)
		$output_kategori .=",";
		
		$output_kategori .="{";
		
		$kg = explode('~',$data['kod']);
		$kod_kategori = $kg[0];
		$header_kategori = $kg[1];
		
		$output_kategori .='"0":"'.$kod_kategori.'",';
		
		$a++;
		
		$output_kategori .='"kod_kategori":"'.$header_kategori;					
		

			$sql = "SELECT ash.kod,(SELECT CONCAT(COUNT(a.nokp),'=',ash.keterangan,' ( ',ash.kod,' )') FROM ahli_users a
			WHERE a.status='1' AND a.status_ahli=ash.kod AND a.galur ='$kod_kategori') AS maklumat
			FROM ahli_status_ahli ash WHERE ash.`status`='1' ORDER BY ash.id ASC";
			
			$result = $conn->query($sql);
			$output = "";
			if($result->num_rows > 0)//ada data
							{
								$i = 0;
								$jum_keseluruhan = 0;
								while($data = $result->fetch_assoc()) {
									
									if($i>0)
									$output .=",";
									$output .="{";
									$kod = $data['kod'];
									$output .="~0~:~".$kod."~,";
									$i++;
									
									$maklumat = $data['maklumat'];
									$data_jum = explode('=',$maklumat);
									$jum = $data_jum[0];
									
									$jum_keseluruhan = $jum_keseluruhan + $jum;
									//$array = $i - 1;
									$output .="~maklumat~:~".$maklumat."~";
									$output .="}";
								}
								$output .=",{~0~:~".$maklumat."~,";
								$output .="~maklumat~:~".$jum_keseluruhan."=JUM. KESELURUHAN~}";
							}
		$output_kategori .='%['.$output.']"}';
	}
	echo $last_output_kategori = '['.$output_kategori.']';
	
	break;
	
	//analisa mengikut tahun semasa - yuran
	case '17':
	
	$tahun = $JsonSystem->getGETPOST('tahun');
	
	if($tahun == '')
	{
		$tahun = date('Y');
	}
	
	$sql = "SELECT ash.kod,(SELECT CONCAT(IFNULL(SUM(ar.jum_yuran),0.00),'=',ash.keterangan,' ( ',ash.kod,' )') FROM ahli_rekod_yuran ar
			WHERE DATE_FORMAT(ar.created_date,'%Y') = '$tahun' AND ar.jenis_ahli=ash.kod) AS maklumat
			FROM ahli_status_ahli ash WHERE ash.`status`='1' ORDER BY ash.id ASC";
			
			$result = $conn->query($sql);
			$output = "";
			if($result->num_rows > 0)//ada data
							{
								$i = 0;
								echo '[';
								$jum_keseluruhan = 0.00;
								while($data = $result->fetch_assoc()) {
									
									if($i>0)
									$output .=",";
									$output .="{";
									$kod = $data['kod'];
									$output .='"0":"'.$kod.'",';
									$i++;
									
									$maklumat = $data['maklumat'];
									$data_jum = explode('=',$maklumat);
									$jum = $data_jum[0];
									
									$jum_keseluruhan = $jum_keseluruhan + $jum;
									$output .='"maklumat":"'.$maklumat.'"';
									$output .="}";
								}
								$output .=',{"0":"'.$maklumat.'",';
								$output .='"maklumat":"'.number_format($jum_keseluruhan,2).'=JUM. KESELURUHAN"}';
							}
	echo $output;
	echo ']';
	break;
	
	//analisa mengikut yuran
	case '18':
	
	$tahun = $JsonSystem->getGETPOST('tahun');
	if($tahun == '')
	{
		$tahun = date('Y');
	}
	
	$sql_kategori = "SELECT CONCAT(DATE_FORMAT(ag.created_date,'%m'),'~','ANALISA KUTIPAN YURAN BULAN ',
	UPPER(DATE_FORMAT(ag.created_date,'%M'))) AS
	kod FROM ahli_rekod_yuran ag WHERE DATE_FORMAT(ag.created_date,'%Y') = '$tahun' 
	GROUP BY kod";
	
	$result_kategori = $conn->query($sql_kategori);
	
	$a = 0;
	$output_kategori = "";
	$last_output_kategori = "";
	while($data =$result_kategori->fetch_assoc())//ada data
	{
		if($a>0)
		$output_kategori .=",";
		
		$output_kategori .="{";
		
		$kg = explode('~',$data['kod']);
		$kod_kategori = $kg[0];
		$header_kategori = $kg[1];
		
		$output_kategori .='"0":"'.$kod_kategori.'",';
		
		$a++;
		
		$output_kategori .='"kod_kategori":"'.$header_kategori;					
		

			$sql = "SELECT ash.kod,(SELECT CONCAT(IFNULL(SUM(ar.jum_yuran),0.00),'=',ash.keterangan,' ( ',ash.kod,' )') 
					FROM ahli_rekod_yuran ar
					WHERE DATE_FORMAT(ar.created_date,'%Y%m') = CONCAT('$tahun' ,'$kod_kategori') 
					AND ar.jenis_ahli=ash.kod) AS maklumat
					FROM ahli_status_ahli ash WHERE ash.`status`='1' ORDER BY ash.id ASC";
			
			$result = $conn->query($sql);
			$output = "";
			if($result->num_rows > 0)//ada data
							{
								$i = 0;
								$jum_keseluruhan = 0.00;
								while($data = $result->fetch_assoc()) {
									
									if($i>0)
									$output .=",";
									$output .="{";
									$kod = $data['kod'];
									$output .="~0~:~".$kod."~,";
									$i++;
									
									$maklumat = $data['maklumat'];
									$data_jum = explode('=',$maklumat);
									$jum = $data_jum[0];
									
									$jum_keseluruhan = $jum_keseluruhan + $jum;
									//$array = $i - 1;
									$output .="~maklumat~:~".$maklumat."~";
									$output .="}";
								}
								$output .=",{~0~:~".$maklumat."~,";
								$output .="~maklumat~:~".number_format($jum_keseluruhan,2)."=JUM. KESELURUHAN~}";
							}
		$output_kategori .='%['.$output.']"}';
	}
	echo $last_output_kategori = '['.$output_kategori.']';
	
	break;
	
	
	//analisa dana semasa
	case '19':
	
	$sql1 = "SELECT CONCAT(IFNULL(SUM(ar.jum_yuran),0.00),'=','Jum. Kutipan Yuran') AS jum_yuran FROM ahli_rekod_yuran ar";
			
			$_yuran = $JsonSystem->getData($sql1);
			$output_yuran = $_yuran[0];
			
	$sql2 = "SELECT CONCAT(IFNULL(SUM(a.jumlah),0.00),'=','Jum. Sumbangan Dana') AS jum_sumbangan FROM ahli_sumbangan a";
			
			$_sumbangan = $JsonSystem->getData($sql2);
			$output_sumbangan = $_sumbangan[0];
			
	$sql3 = "SELECT CONCAT(IFNULL(SUM(ap.jumlah),0.00),'=','Jum. Perbelanjaan Dana') AS jum_perbelanjaan FROM ahli_perbelanjaan ap";
			
			$_perbelanjaan = $JsonSystem->getData($sql3);
			$output_perbelanjaan = $_perbelanjaan[0];
	
	$data1= explode('=',$output_yuran);
	$data2= explode('=',$output_sumbangan);
	$data3= explode('=',$output_perbelanjaan);
	
	$output_keseluruhan_dana= 0.00;
	$output_baki_dana= 0.00;
	$output_keseluruhan_dana= $data1[0] + $data2[0];
	$output_baki_dana= $output_keseluruhan_dana - $data3[0];
	
	
	$output_to_send = '[{"maklumat":"'.$output_yuran.'"},{"maklumat":"'.$output_sumbangan.'"},{"maklumat":"'.number_format($output_keseluruhan_dana,2).'=Jum. Keseluruhan Dana"},{"maklumat":"'.$output_perbelanjaan.'"},{"maklumat":"'.number_format($output_baki_dana,2).'=Baki Dana"}]';
		
	break;
	
	//analisa mengikut dana bulanan
	case '20':
	
	$sql_tahun = "SELECT DATE_FORMAT(a.tarikh,'%Y') AS tahun FROM ahli_sumbangan a GROUP BY tahun ORDER BY tahun DESC";
	
	$result_tahun = $connjson->query($sql_tahun);
	
	$month = array();
	while($data_tahun =$result_tahun->fetch_assoc())//ada data
	{
		$month[] = $data_tahun['tahun'];
	}
	
	//$month=array("01","02","03","04","05","06","07","08","09","10","11","12");
	$arrlength=count($month);
	$output = '';
	$output .= '[';
	$array_month = '';
	for ($x = 0; $x <$arrlength; $x++) 
	{
		$array_month = $month[$x];
		if($x>0)
		$output .=",";
		$output .= '{"header":"ANALISA DANA TAHUN '.$array_month.'%';
		
		$sql1 = "SELECT
			(SELECT CONCAT(IFNULL(SUM(ar.jum_yuran),0.00),'=','Jum. Kutipan Yuran') AS jum_yuran FROM ahli_rekod_yuran ar
						WHERE DATE_FORMAT(ar.created_date,'%Y') = '$array_month') AS s1,
			(SELECT CONCAT(IFNULL(SUM(a.jumlah),0.00),'=','Jum. Sumbangan Dana') AS jum_sumbangan FROM ahli_sumbangan a
						WHERE DATE_FORMAT(a.tarikh,'%Y') = '$array_month') AS s2,
			(SELECT CONCAT(IFNULL(SUM(ap.jumlah),0.00),'=','Jum. Perbelanjaan Dana') AS jum_perbelanjaan FROM ahli_perbelanjaan ap
			WHERE DATE_FORMAT(ap.tarikh,'%Y') = '$array_month') AS s3";
			
			$a = $JsonSystem->getData($sql1);
			$output_yuran = $a[0];
			$output_sumbangan = $a[1];
			$output_perbelanjaan = $a[2];
		
		$data1= explode('=',$output_yuran);
		$data2= explode('=',$output_sumbangan);
		$data3= explode('=',$output_perbelanjaan);
		
		$output_keseluruhan_dana= 0.00;
		$output_baki_dana= 0.00;
		$output_keseluruhan_dana= $data1[0] + $data2[0];
		$output_baki_dana= $output_keseluruhan_dana - $data3[0];
		
		
		$output .= '[{~maklumat~:~'.$output_yuran.'~},{~maklumat~:~'.$output_sumbangan.'~},{~maklumat~:~'.number_format($output_keseluruhan_dana,2).'=Jum. Keseluruhan Dana~},{~maklumat~:~'.$output_perbelanjaan.'~},{~maklumat~:~'.number_format($output_baki_dana,2).'=Baki Dana~}]';
		$output .= '"}';
	}
	$output .= ']';
	echo $output;
	break;
	
	case '21'://display aktiviti current month
	
	$tahun = $JsonSystem->getGETPOST('tahun');
	$bulan = $JsonSystem->getGETPOST('bulan');
	
	$t = $tahun.$bulan;
		
		$sql="SELECT ap.id,UPPER(ap.tajuk) AS tajuk,ap.keterangan,
		CONCAT(DATE_FORMAT(ap.tarikh_mula,'%d-%m-%Y'),' ~ ',DATE_FORMAT(ap.tarikh_tamat,'%d-%m-%Y')) AS tarikh,dokumen_filename
		FROM ahli_pengumuman ap WHERE ap.`status`='1' AND ap.kategori='1' 
		AND DATE_FORMAT(ap.tarikh_mula,'%Y%m') = '$t' OR DATE_FORMAT(ap.tarikh_tamat,'%Y%m') = '$t' ORDER BY ap.tarikh_mula ASC";
	
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '22'://tarikh view kalendar aktiviti
	
	$tahun = $JsonSystem->getGETPOST('tahun');
	$bulan = $JsonSystem->getGETPOST('bulan');
	
	$t = $tahun.$bulan;
		
		//$sql="SELECT DISTINCT(DATE_FORMAT(ap.tarikh_mula,'%d')) AS tarikh FROM ahli_pengumuman ap WHERE ap.`status`='1' AND ap.kategori='1' 
		//AND DATE_FORMAT(ap.tarikh_mula,'%Y%m') = '$t' ORDER BY ap.tarikh_mula ASC";
		
		$sql ="SELECT DATE_FORMAT(ap.tarikh_mula,'%Y-%m-%d') AS tarikh_mula,DATE_FORMAT(ap.tarikh_tamat,'%Y-%m-%d') AS tarikh_akhir 
		FROM ahli_pengumuman ap WHERE ap.`status`='1' AND ap.kategori='1' 
		AND DATE_FORMAT(ap.tarikh_mula,'%Y%m') = '$t' OR DATE_FORMAT(ap.tarikh_tamat,'%Y%m') = '$t' ORDER BY ap.tarikh_mula ASC";
	
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '23'://yuran infaq
	
	$id = $JsonSystem->getGETPOST('id');
	
		$sql1="SELECT au.nama,au.nokp,au.no_ahli,ash.keterangan AS status_ahli,au.photo_filename FROM ahli_users au
				LEFT JOIN ahli_status_ahli ash ON au.status_ahli=ash.kod
				WHERE au.id='$id'";
		
		$a = $JsonSystem->getData($sql1);
		
		$sql2="SELECT akp.nama_bank,akp.no_akaun,akp.nama_pengerusi,akp.tel FROM ahli_kelab_persatuan akp ";
		
		$b = $JsonSystem->getData($sql2);
	
		$output_to_send = '[{"nama":"'.$a[0].'","nokp":"'.$a[1].'","no_ahli":"'.$a[2].'","status_ahli":"'.$a[3].'","photo_filename":"'.$a[4].'","nama_bank":"'.$b[0].'","no_akaun":"'.$b[1].'","nama_pengerusi":"'.$b[2].'","tel":"'.$b[3].'"}]';
				
	break;
	
	case '24'://notification
	
	//$sql="SELECT ap.kategori,COUNT(ap.id) AS jumlah FROM ahli_pengumuman ap WHERE ap.`status`='1'
		//AND DATE_FORMAT(ap.tarikh_mula,'%Y%m%d') = DATE_FORMAT(CURRENT_DATE,'%Y%m%d') GROUP BY ap.kategori";
		
		$sql = "SELECT COUNT(ap.id) AS jumlah_pengumuman,
		(SELECT COUNT(ap.id) FROM ahli_pengumuman ap WHERE ap.`status`='1' AND ap.kategori ='1' 
		AND DATE_FORMAT(ap.tarikh_mula,'%Y%m%d') = DATE_FORMAT(CURRENT_DATE,'%Y%m%d')) AS jumlah_aktiviti
		FROM ahli_pengumuman ap WHERE ap.`status`='1' AND ap.kategori ='0'";
		
		$output = $JsonSystem->getData($sql);
		$output_to_send = '[{"pengumuman":"'.$output[0].'","aktiviti":"'.$output[1].'"}]';
		
	break;
	
	case '25'://update kemaskini info
	    $id = $JsonSystem->getGETPOST('id');
		$accs_pwd = $JsonSystem->getGETPOST('accs_pwd');
		$phone = $JsonSystem->getGETPOST('phone');
		
		$sql = "UPDATE ahli_users SET password='$accs_pwd', notel='$phone' WHERE id='$id'";
		$JsonSystem->executeOperation($sql);
	break;
	
	case '26'://dropdown daerah
	
	$kod_negeri = $JsonSystem->getGETPOST('kod_negeri');
	
		$sql="SELECT CONCAT(ld.kod_daerah,'-',ld.daerah) AS daerah FROM lkp_daerah ld WHERE ld.kod_negeri='$kod_negeri' ORDER BY ld.kod_daerah ASC";
		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
		
	break;
	
	case '27'://dropdown asnaf
	
		$sql="SELECT al.jenis_asnaf FROM ahli_lkp_asnaf al WHERE al.status_asnaf='1' ORDER BY al.jenis_asnaf ASC ";
		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
		
	break;
	
	case '28'://dropdown tahun
	
		$sql="SELECT DISTINCT(DATE_FORMAT(y.created_date,'%Y')) AS tahun FROM ahli_rekod_yuran y ORDER BY y.created_date DESC";
		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
		
	break;
	
	case '29'://jejak ahli kategori 
	
		$kategori = $JsonSystem->getGETPOST('kategori');
		$search_word = $JsonSystem->getGETPOST('search_word');
		
		if($kategori=='Seumur Hidup')
		{
			$condition = "WHERE a.status_ahli = 'SH'";
		}
		elseif($kategori=='OKU')
		{
			$condition = "WHERE a.oku = '1'";
		}
		elseif($kategori=='Permohonan Baru')
		{
			$condition = "WHERE a.status_ahli = 'BD'";
		}
		elseif($kategori=='Ahli Biasa')
		{
			$condition = "WHERE a.status_ahli = 'AB'";
		}
		else
		{
			$condition = "WHERE a.anak_yatim = '1'";
		}
		
		if($search_word == '')//kategori
		{
			$sql="SELECT
					a.id,a.no_ahli,UPPER(a.nama) AS nama,a.notel,a.gps_koordinat,
					UPPER(a.alamat) AS alamat,akg.nama_galur AS galur,ah.keterangan AS status_ahli,
					lkp.name AS negeri,ld.daerah AS daerah,IFNULL(a.asnaf,'TIDAK') AS asnaf,
					(CASE
						  WHEN a.anak_yatim = '1'
						  THEN 'YA'
						  ELSE 'TIDAK'
					END) AS anak_yatim, 
					(CASE
						  WHEN a.oku = '1'
						  THEN 'YA'
						  ELSE 'TIDAK'
					END)AS oku
					FROM ahli_users a 
					LEFT JOIN ahli_lkp_galur akg ON a.galur=akg.kod
					LEFT JOIN ahli_status_ahli ah ON a.status_ahli = ah.kod
					LEFT JOIN lkp_negeri lkp ON a.negeri= lkp.code
					LEFT JOIN lkp_daerah ld ON a.daerah= ld.kod_daerah
					$condition AND a.`status`='1' ORDER BY a.nama ASC";
		}
		else //search word
		{
			$sql="SELECT
					a.id,a.no_ahli,UPPER(a.nama) AS nama,a.notel,a.gps_koordinat,
					UPPER(a.alamat) AS alamat,akg.nama_galur AS galur,ah.keterangan AS status_ahli,
					lkp.name AS negeri,ld.daerah AS daerah,IFNULL(a.asnaf,'TIDAK') AS asnaf,
					(CASE
						  WHEN a.anak_yatim = '1'
						  THEN 'YA'
						  ELSE 'TIDAK'
					END) AS anak_yatim, 
					(CASE
						  WHEN a.oku = '1'
						  THEN 'YA'
						  ELSE 'TIDAK'
					END)AS oku
					FROM ahli_users a 
					LEFT JOIN ahli_lkp_galur akg ON a.galur=akg.kod
					LEFT JOIN ahli_status_ahli ah ON a.status_ahli = ah.kod
					LEFT JOIN lkp_negeri lkp ON a.negeri= lkp.code
					LEFT JOIN lkp_daerah ld ON a.daerah= ld.kod_daerah 
				$condition AND (a.nama LIKE '%$search_word%' OR a.alamat LIKE '%$search_word%') AND a.`status`='1' ORDER BY a.nama ASC";
		}
		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '30'://jejak ahli asnaf , asnaf & ank yatim
	
		$kategori = $JsonSystem->getGETPOST('kategori');
		$asnaf_selection = $JsonSystem->getGETPOST('asnaf_selection');
		$search_word = $JsonSystem->getGETPOST('search_word');
		
		if($kategori=='Asnaf')//Asnaf
		{
			$condition = "WHERE a.asnaf IS NOT NULL";
		}
		else //Asnaf & Anak Yatim
		{
			$condition = "WHERE a.asnaf IS NOT NULL AND a.anak_yatim = '1'";
		}
		
		if($search_word == '')//kategori
		{
			if($asnaf_selection != '')
			{
				$sql="SELECT
					a.id,a.no_ahli,UPPER(a.nama) AS nama,a.notel,a.gps_koordinat,
					UPPER(a.alamat) AS alamat,akg.nama_galur AS galur,ah.keterangan AS status_ahli,
					lkp.name AS negeri,ld.daerah AS daerah,IFNULL(a.asnaf,'TIDAK') AS asnaf,
					(CASE
						  WHEN a.anak_yatim = '1'
						  THEN 'YA'
						  ELSE 'TIDAK'
					END) AS anak_yatim, 
					(CASE
						  WHEN a.oku = '1'
						  THEN 'YA'
						  ELSE 'TIDAK'
					END)AS oku
					FROM ahli_users a 
					LEFT JOIN ahli_lkp_galur akg ON a.galur=akg.kod
					LEFT JOIN ahli_status_ahli ah ON a.status_ahli = ah.kod
					LEFT JOIN lkp_negeri lkp ON a.negeri= lkp.code
					LEFT JOIN lkp_daerah ld ON a.daerah= ld.kod_daerah
					$condition AND a.asnaf ='$asnaf_selection' AND a.`status`='1' ORDER BY a.nama ASC";
			}
			else
			{
				$sql="SELECT
					a.id,a.no_ahli,UPPER(a.nama) AS nama,a.notel,a.gps_koordinat,
					UPPER(a.alamat) AS alamat,akg.nama_galur AS galur,ah.keterangan AS status_ahli,
					lkp.name AS negeri,ld.daerah AS daerah,IFNULL(a.asnaf,'TIDAK') AS asnaf,
					(CASE
						  WHEN a.anak_yatim = '1'
						  THEN 'YA'
						  ELSE 'TIDAK'
					END) AS anak_yatim, 
					(CASE
						  WHEN a.oku = '1'
						  THEN 'YA'
						  ELSE 'TIDAK'
					END)AS oku
					FROM ahli_users a 
					LEFT JOIN ahli_lkp_galur akg ON a.galur=akg.kod
					LEFT JOIN ahli_status_ahli ah ON a.status_ahli = ah.kod
					LEFT JOIN lkp_negeri lkp ON a.negeri= lkp.code
					LEFT JOIN lkp_daerah ld ON a.daerah= ld.kod_daerah
					$condition AND a.`status`='1' ORDER BY a.nama ASC";
			}
		}
		else //search word
		{
			$sql="SELECT
					a.id,a.no_ahli,UPPER(a.nama) AS nama,a.notel,a.gps_koordinat,
					UPPER(a.alamat) AS alamat,akg.nama_galur AS galur,ah.keterangan AS status_ahli,
					lkp.name AS negeri,ld.daerah AS daerah,IFNULL(a.asnaf,'TIDAK') AS asnaf,
					(CASE
						  WHEN a.anak_yatim = '1'
						  THEN 'YA'
						  ELSE 'TIDAK'
					END) AS anak_yatim, 
					(CASE
						  WHEN a.oku = '1'
						  THEN 'YA'
						  ELSE 'TIDAK'
					END)AS oku
					FROM ahli_users a 
					LEFT JOIN ahli_lkp_galur akg ON a.galur=akg.kod
					LEFT JOIN ahli_status_ahli ah ON a.status_ahli = ah.kod
					LEFT JOIN lkp_negeri lkp ON a.negeri= lkp.code
					LEFT JOIN lkp_daerah ld ON a.daerah= ld.kod_daerah 
				$condition AND (a.nama LIKE '%$search_word%' OR a.alamat LIKE '%$search_word%') AND a.`status`='1' ORDER BY a.nama ASC";
		}
		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
}

// Closing connection
mysqli_close($connjson);
echo $output_to_send;



?>