<?php
//phpinfo();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header('Content-type: application/json');

require_once('lib/json.inc');

error_log('json.php');
error_reporting(E_ALL);
ini_set("display_errors", 0);

$JsonSystem = new Json();

$cmd = $JsonSystem->getGETPOST('cmd');

$output = '';
$output_to_send = '';
switch($cmd) {
	
	//user verification
	case '1':
	
	    $nokp = $JsonSystem->getGETPOST('nokp');
		
		$sql="SELECT ap.nokp,ap.nama,ap.notel,ap.photo_filename FROM acara_peserta ap
			WHERE ap.nokp = '{$nokp}' GROUP BY ap.nokp";
		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	// analisa jumlah sesi
	case '2': 

	$nokp = $JsonSystem->getGETPOST('nokp');
	
	$output_jum = $JsonSystem->getData("SELECT COUNT(ap.id_sesi) AS jum_sesi FROM acara_peserta ap WHERE ap.nokp = '{$nokp}'" );
				
	$output_jum_sdg = $JsonSystem->getData("SELECT COUNT(acs.id) AS jum_sdg_berlangsung FROM acara_sesi acs 
											LEFT JOIN acara_peserta ap ON ap.id_sesi = acs.id
											WHERE ap.id_sesi IN (SELECT acs.id FROM acara_sesi acs 
											WHERE CURRENT_DATE BETWEEN acs.tarikh_mula AND acs.tarikh_tamat)
											AND ap.nokp = '{$nokp}'");
	
	$output_jum_blm = $JsonSystem->getData("SELECT COUNT(acs.id) AS jum_blm_berlangsung FROM acara_sesi acs 
											LEFT JOIN acara_peserta ap ON ap.id_sesi = acs.id
											WHERE ap.id_sesi IN (SELECT acs.id FROM acara_sesi acs 
											WHERE CURRENT_DATE < acs.tarikh_mula)
											AND ap.nokp = '{$nokp}'");
		
	$output_jum_tlh = $JsonSystem->getData("SELECT COUNT(acs.id) AS jum_tlh_berlangsung FROM acara_sesi acs 
											LEFT JOIN acara_peserta ap ON ap.id_sesi = acs.id
											WHERE ap.id_sesi IN (SELECT acs.id FROM acara_sesi acs 
											WHERE CURRENT_DATE > acs.tarikh_tamat)
											AND ap.nokp = '{$nokp}'");
	
	$output_to_send = '[{"jum_sesi":"'.$output_jum[0].'","jum_sdg_berlangsung":"'.$output_jum_sdg[0].'","jum_blm_berlangsung":"'.$output_jum_blm[0].'","jum_tlh_berlangsung":"'.$output_jum_tlh[0].'"}]';
	break;
	
	//display senarai sesi
	case '3':
	
		  $nokp = $JsonSystem->getGETPOST('nokp');
		  $jenis = $JsonSystem->getGETPOST('jenis');
		  
		  if($jenis == 1) // if sesi sdg berlangsung
		  {
			  $sql = "SELECT acs.id,acs.nama,acs.lokasi,
					DATE_FORMAT(acs.tarikh_mula,'%e/%c/%Y') AS tarikh_mula,
					DATE_FORMAT(acs.tarikh_tamat,'%e/%c/%Y') AS tarikh_tamat 
					FROM acara_sesi acs 
					LEFT JOIN acara_peserta ap ON ap.id_sesi = acs.id
					WHERE ap.id_sesi IN (SELECT acs.id FROM acara_sesi acs 
					WHERE CURRENT_DATE BETWEEN acs.tarikh_mula AND acs.tarikh_tamat)
					AND ap.nokp = '{$nokp}'";
		  }
		  else // if sesi telah berlangsung - jenis = 0
		  {
			  $sql = "SELECT acs.id,acs.nama,acs.lokasi,
					DATE_FORMAT(acs.tarikh_mula,'%e/%c/%Y') AS tarikh_mula,
					DATE_FORMAT(acs.tarikh_tamat,'%e/%c/%Y') AS tarikh_tamat 
					FROM acara_sesi acs 
					LEFT JOIN acara_peserta ap ON ap.id_sesi = acs.id
					WHERE ap.id_sesi IN (SELECT acs.id FROM acara_sesi acs 
					WHERE CURRENT_DATE > acs.tarikh_tamat)
					AND ap.nokp = '{$nokp}'";
		  }
					
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
					
	break;

	//analisa kehadiran peserta
	case '4':
		$sesi = $JsonSystem->getGETPOST('id_sesi');
		
		$output_jumPeserta = $JsonSystem->getData("SELECT COUNT(ap.id) as Jumlah_Penyertaan FROM acara_peserta ap WHERE id_sesi = '{$sesi}'");
		
		//$output_jumHadir = $JsonSystem->getData("SELECT COUNT(ah.id) as Jumlah_Hadir FROM acara_kehadiran ah 
		//WHERE id_sesi = '{$sesi}' AND DATE_FORMAT(tarikh,'%Y-%m-%d') = CURRENT_DATE");
		
		$output_jumHadir = $JsonSystem->getData("SELECT COUNT(ah.id) as Jumlah_Hadir FROM acara_kehadiran ah 
		WHERE ah.nokp IN (select ap.nokp from acara_peserta ap where ap.id_sesi = '{$sesi}') AND id_sesi = '{$sesi}' 
		AND DATE_FORMAT(tarikh,'%Y-%m-%d') = CURRENT_DATE");
										
		$output_to_send = '[{"Jumlah_Penyertaan":"'.$output_jumPeserta[0].'","Jumlah_Hadir":"'.$output_jumHadir[0].'"}]';
		
	break;
	
	//button kandungan digital
	case '5':
		
		$sesi = $JsonSystem->getGETPOST('id_sesi');
		
		$sql="SELECT acsu.kategori FROM acara_sumber acsu 
		WHERE acsu.id_sesi = '{$sesi}' GROUP BY acsu.kategori";
		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
		  
	break;

	//display kandungan digital based on kategori
	case '6':
	
		$sesi = $JsonSystem->getGETPOST('id_sesi');
		$kategori =$JsonSystem->getGETPOST('kategori');
		
	     $sql = "SELECT acsu.id,acsu.tajuk,acsu.kandungan_filename FROM acara_sumber acsu 
				WHERE acsu.id_sesi = '{$sesi}' AND acsu.kategori ='{$kategori}'";
			
			$output = $JsonSystem->getJSONData($sql,'',null);
			$output_to_send = "[{$output}]";
	break;
	
	// download dokumen
	/*case '7': 
		
	$id = $JsonSystem->getGETPOST('id');
	$sesi = $JsonSystem->getGETPOST('id_sesi');
	
	$file_name= '';
	$file_content= '';
	$filename= '';
	
	$sql = "SELECT acsu.tajuk,acsu.kandungan FROM acara_sumber acsu 
			WHERE acsu.id ='{$id}' AND acsu.id_sesi = '{$sesi}'";
	
				$dokumen = $conn->query($sql);
		
				if($dokumen->num_rows>0){
				$result = $dokumen->fetch_object();
				
				$file_content = $result -> kandungan;
				$file_name =$result -> tajuk;
				
				$filename = $file_name.'.pdf';
				}

		header('Content-type: application/pdf');
		header("Content-Disposition: attachment; filename=$filename");
		ob_clean();
		flush();
		echo $file_content;
		
	break;*/
	
	
	// sijil digital
	case '7': 
		
	$nokp = $JsonSystem->getGETPOST('nokp');
	$sesi = $JsonSystem->getGETPOST('id_sesi');
	
	$sql = "SELECT COUNT(ak.id) AS id FROM acara_kehadiran ak
	WHERE ak.id_sesi = '{$sesi}' AND ak.nokp = '{$nokp}'";
	
	$_checkId = $JsonSystem->getData($sql);
	$checkId = $_checkId[0];
		
			if($checkId>0){
				
				$output_to_send = "[1]";
			}else
			{
				$output_to_send = "[]";
			}
	
	break;
	

	//display carian kandungan digital based on kategori
	case '8':
	
		$sesi = $JsonSystem->getGETPOST('id_sesi');
		$kategori =$JsonSystem->getGETPOST('kategori');
		$query =$JsonSystem->getGETPOST('query');
		
	     $sql = "SELECT acsu.id,acsu.tajuk,acsu.kandungan_filename FROM acara_sumber acsu 
				WHERE acsu.tajuk LIKE '%$query%' AND acsu.id_sesi = '{$sesi}' AND acsu.kategori ='{$kategori}'";
			
			$output = $JsonSystem->getJSONData($sql,'',null);
			$output_to_send = "[{$output}]";
			
	break;

	//senarai galeri button
	case '9':
	
	$sesi = $JsonSystem->getGETPOST('id_sesi');

	$output = $JsonSystem->getJSONData("SELECT acg.id,(acg.tajuk_folder) as Galeri FROM acara_galeri acg 
										WHERE acg.id_sesi ='{$sesi}' GROUP BY acg.tajuk_folder",'',null);
		
	$output_to_send = "[{$output}]";
	break;

	//check kumpulan peserta
	case '10':
	
	$nokp = $JsonSystem->getGETPOST('nokp');
	$sesi = $JsonSystem->getGETPOST('id_sesi');

	$output = $JsonSystem->getJSONData("SELECT lkp.nama_kumpulan FROM lkp_kumpulan_peserta lkp
										INNER JOIN acara_peserta ap ON lkp.id = ap.kumpulan
										WHERE ap.id_sesi = '{$sesi}' AND ap.nokp = '{$nokp}'",'',null);
		
	$output_to_send = "[{$output}]";
	break;
	
	//urusetia imbasan
	case '11':
	$sesi = $JsonSystem->getGETPOST('id_sesi');
	$nokp = $JsonSystem->getGETPOST('nokp');
	$lokasi = $JsonSystem->getGETPOST('gps');
	$status = $JsonSystem->getGETPOST('status');

	$sql = "INSERT INTO acara_kehadiran (id_sesi,nokp,lokasi_gps, status) 
			VALUES ('".$sesi."','".$nokp."','".$lokasi."','".$status."')";
	
	$output = $JsonSystem->executeOperation($sql);
		
	$output_to_send = "[{$output}]";
	break;
	
	//check kehadiran peserta 
	case '12':
	$nokp = $JsonSystem->getGETPOST('nokp');
	$sesi = $JsonSystem->getGETPOST('id_sesi');

	//$sql1 = "SELECT count(ap.id) AS id FROM acara_peserta ap WHERE ap.id_sesi = '{$sesi}' AND ap.nokp = '{$nokp}'";
	
		//$_checkId = $JsonSystem->getData($sql1);
		//$checkId = $_checkId[0];
		
			//if($checkId>0){
				
				$sql2 = "SELECT ah.id FROM acara_kehadiran ah WHERE ah.id_sesi = '{$sesi}' 
				AND ah.nokp = '{$nokp}' AND DATE_FORMAT(tarikh,'%Y-%m-%d') = CURRENT_DATE";
				
				$output = $JsonSystem->getJSONData($sql2,'',null);
				$output_to_send = "[{$output}]";
			//}else
			//{
			//	$output_to_send = "[]";
			//}
	break;
	
	//check profil photo
	case '13':
	$nokp = $JsonSystem->getGETPOST('nokp');
		
		$sql="SELECT ap.photo_filename FROM acara_peserta ap
			WHERE ap.nokp = '{$nokp}' GROUP BY ap.nokp";
		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	//button tarikh
	case '14':
	$sesi = $JsonSystem->getGETPOST('id_sesi');
		
		$sql="SELECT DATE_FORMAT(aa.tarikh, '%d %M %Y') AS Tarikh FROM acara_aturcara aa
				WHERE aa.id_sesi = '{$sesi}' GROUP BY aa.tarikh ORDER BY aa.tarikh ASC";
		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	//button list aturcara
	case '15':
	$sesi = $JsonSystem->getGETPOST('id_sesi');
	$tarikh = $JsonSystem->getGETPOST('tarikh');
		
		$sql= "SELECT id,DATE_FORMAT(masa_mula,'%H:%i %p') AS masa_mula, DATE_FORMAT(masa_tamat,'%H:%i %p') AS masa_tamat, 
				tajuk, lokasi, kategori, youtube_link, lagu_tema_filename,lagu_tema_status,rating,qna 
				FROM acara_aturcara WHERE id_sesi = '{$sesi}' AND DATE_FORMAT(tarikh, '%d %M %Y') = '{$tarikh}' 
				ORDER BY masa_mula ASC";
		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	//daftar peserta
	case '16':
	$sesi = $JsonSystem->getGETPOST('id_sesi');

	$sql = "SELECT ap.id,ap.id_sesi,ap.nokp,ap.nama,ap.notel,ap.jawatan,lkp.nama_kumpulan,ap.`status` FROM acara_peserta ap
			INNER JOIN lkp_kumpulan_peserta lkp ON lkp.id = ap.kumpulan
			WHERE ap.id_sesi = '{$sesi}'";
	
	$output = $JsonSystem->getJSONData($sql,'',null);
		
	$output_to_send = "[{$output}]";
	break;

	//carian peserta
	case '17':
	$sesi = $JsonSystem->getGETPOST('id_sesi');
	$query =$JsonSystem->getGETPOST('query');
		
	     $sql = "SELECT ap.id,ap.id_sesi,ap.nokp,ap.nama,ap.notel,ap.jawatan,lkp.nama_kumpulan,ap.`status` FROM acara_peserta ap
				INNER JOIN lkp_kumpulan_peserta lkp ON lkp.id = ap.kumpulan
				WHERE ap.nama LIKE '%$query%' OR ap.nokp LIKE '%$query%' OR lkp.nama_kumpulan LIKE '%$query%' AND ap.id_sesi = '{$sesi}'";
			
			$output = $JsonSystem->getJSONData($sql,'',null);
			$output_to_send = "[{$output}]";
	break;	

	//daftar peserta
	case '18':
	$sesi = $JsonSystem->getGETPOST('id_sesi');
	$nokp = $JsonSystem->getGETPOST('nokp');
	$nama = $JsonSystem->getGETPOST('nama');
	$notel = $JsonSystem->getGETPOST('notel');
	$kumpulan = $JsonSystem->getGETPOST('kumpulan');
	$jawatan = $JsonSystem->getGETPOST('jawatan');
	$icurusetia = $JsonSystem->getGETPOST('icurusetia');
	
	$sql = "SELECT COUNT(ap.id) AS id FROM acara_peserta ap
			WHERE ap.nokp = '{$nokp}' AND ap.id_sesi='{$sesi}'";
			
	$_checkId = $JsonSystem->getData($sql);
	$checkId = $_checkId[0];
		
		//dah ada data
		if($checkId>0){
				
			$output_to_send = "Rekod telah wujud.";
		}
		//belum ada
		else
		{
			$kumpulanpeserta= '';
			$sql = "SELECT kp.id FROM lkp_kumpulan_peserta kp WHERE kp.nama_kumpulan = '{$kumpulan}' AND kp.id_sesi = '{$sesi}'";
 
			$kp = $conn->query($sql);
  
			if($kp->num_rows>0)
			{
				$result = $kp->fetch_object();
				$kumpulanpeserta = $result -> id;
			}
				$sql1 = "INSERT INTO acara_peserta (id_sesi, nokp, nama, notel, kumpulan, jawatan, STATUS, created_by) 
				VALUES ('".$sesi."','".$nokp."','".$nama."','".$notel."', '".$kumpulanpeserta."', '".$jawatan."', 'WALK-IN', '".$icurusetia."')";
	
				$output = $JsonSystem->executeOperation($sql1);
		
				$output_to_send = "Pendaftaran Berjaya.";
				
		}
	
	break;	
	
	//data dropdown kumpulan
	case '19':
	$sesi = $JsonSystem->getGETPOST('id_sesi');
		
	$sql = "SELECT kp.nama_kumpulan FROM lkp_kumpulan_peserta kp where kp.id_sesi = '{$sesi}' AND kp.nama_kumpulan NOT IN ('URUSETIA') 
			GROUP BY kp.nama_kumpulan";
			
	$output = $JsonSystem->getJSONData($sql,'',null);
	
	$output_to_send = "[{$output}]";
		
	break;
	
	//display speaker photo
	case '20':
	
	$id_aturcara = $JsonSystem->getGETPOST('id_aturcara');
		
	$sql = "SELECT ap.nama, ap.photo_filename FROM acara_peserta ap
			LEFT JOIN acara_speaker acsp ON ap.nokp = acsp.nokp_peserta
			WHERE acsp.id_aturcara = '{$id_aturcara}' GROUP BY ap.nokp ";
			
	$output = $JsonSystem->getJSONData($sql,'',null);
	
	$output_to_send = "[{$output}]";
		
	break;
	
	//verify peserta untuk sesi tsbt
	case '21':
	
	$nokp = $JsonSystem->getGETPOST('nokp');
	$sesi = $JsonSystem->getGETPOST('id_sesi');

	$sql = "SELECT ap.id FROM acara_peserta ap WHERE ap.id_sesi = '{$sesi}' AND ap.nokp = '{$nokp}'";
	
	$output = $JsonSystem->getJSONData($sql,'',null);
	$output_to_send = "[{$output}]";	
	break;
	
	//display bil QNA dan list QNA
	case '22':
	
	$id_aturcara = $JsonSystem->getGETPOST('id_aturcara');

	$sql = "SELECT aq.id,aq.nokp_peserta,ap.nama,ap.photo_filename,aq.qna_soalan FROM acara_qna aq 
			LEFT JOIN acara_peserta ap ON aq.nokp_peserta=ap.nokp
			WHERE aq.id_aturcara = '{$id_aturcara}' GROUP BY aq.qna_soalan,aq.nokp_peserta ORDER BY aq.id ASC";
	
	$output = $JsonSystem->getJSONData($sql,'',null);
	$output_to_send = "[{$output}]";	
	break;
	
	//insert user rating
	case '23':
	
	$id_aturcara = $JsonSystem->getGETPOST('id_aturcara');
	$nokp = $JsonSystem->getGETPOST('nokp');
	$rating = $JsonSystem->getGETPOST('rating');
	
	$sql = "SELECT COUNT(ar.peserta_rating) AS rating FROM acara_rating ar
			WHERE ar.id_aturcara = '{$id_aturcara}' AND ar.nokp_peserta = '{$nokp}'";
			
	$_checkRating = $JsonSystem->getData($sql);
	$checkRating = $_checkRating[0];
		
		//dah ada rating kena update
			if($checkRating>0){
				
				$sql1 = "UPDATE acara_rating SET peserta_rating = $rating WHERE id_aturcara = $id_aturcara AND 
				nokp_peserta = $nokp";
				
				$output = $JsonSystem->executeOperation2($sql1);
			}
		//belum ada rating insert
			else
			{
				$sql1 = "INSERT INTO acara_rating (id_aturcara, nokp_peserta, peserta_rating) 
				VALUES ('".$id_aturcara."','".$nokp."','".$rating."')";

				$output = $JsonSystem->executeOperation2($sql1);
			}
	
				$output_to_send = "[{$output}]";
	break;
	
	//select user_rating
	case '24':
	$id_aturcara = $JsonSystem->getGETPOST('id_aturcara');
	$nokp = $JsonSystem->getGETPOST('nokp');
	
	$sql = "SELECT ar.peserta_rating FROM acara_rating ar
			WHERE ar.id_aturcara = '{$id_aturcara}' AND ar.nokp_peserta = '{$nokp}'";
			
	$output = $JsonSystem->getJSONData($sql,'',null);
	$output_to_send = "[{$output}]";	
	break;
	
	//insert user qna
	case '25':
	
	$id_aturcara = $JsonSystem->getGETPOST('id_aturcara');
	$nokp = $JsonSystem->getGETPOST('nokp');
	$soalan = $JsonSystem->getGETPOST('soalan');
	
	$sql = "INSERT INTO acara_qna (id_aturcara, nokp_peserta, qna_soalan) 
			VALUES ('".$id_aturcara."','".$nokp."','".$soalan."')";

	$output = $JsonSystem->executeOperation2($sql);
	$output_to_send = "[{$output}]";
	
	break;
	
	//select average rating aturcara
	case '26':
	
	$id_aturcara = $JsonSystem->getGETPOST('id_aturcara');
	
	$sql = "SELECT COUNT(ar.nokp_peserta) AS bil_peserta ,IFNULL(SUM(ar.peserta_rating),0) AS total_rating FROM acara_rating ar
			WHERE ar.id_aturcara = '{$id_aturcara}'";
	
	$output = $JsonSystem->getJSONData($sql,'',null);
	$output_to_send = "[{$output}]";
	
	break;
	
	//select average rating aturcara
	case '27':
	
	$id_aturcara = $JsonSystem->getGETPOST('id_aturcara');
	
	$sql = "SELECT aq.id FROM acara_qna aq 
			LEFT JOIN acara_peserta ap ON aq.nokp_peserta=ap.nokp
			WHERE aq.id_aturcara = '{$id_aturcara}' GROUP BY aq.qna_soalan,aq.nokp_peserta ORDER BY aq.id ASC";
	
	$output = $JsonSystem->getJSONData($sql,'',null);
	$output_to_send = "[{$output}]";
	
	break;
	
	//select all language
	case '28':
	
	$sql = "SELECT l.locale,l.locale_name FROM language l GROUP BY l.locale ORDER BY l.locale_name ASC";
	
	$output = $JsonSystem->getJSONData($sql,'',null);
	$output_to_send = "[{$output}]";
	
	break;
	
	case '29':
	
	$kod_bahasa = $JsonSystem->getGETPOST('kod_bahasa');
	
	$sql = "SELECT l.kod,l.translation FROM language l WHERE l.locale='$kod_bahasa'";
	
	$result = $conn->query($sql);
	
	echo '[';
				
					if($result->num_rows > 0)//ada data
					{
						$i = 0;
						$output = "";
						echo '{';
						while($data = $result->fetch_assoc()) {
							
							if($i>0)
								echo ',';
							$i++;
							
							$kod = $data['kod'];
							$translation = $data['translation'];
							
							echo $output = '"'.$kod.'":"'.$translation.'"';
							
						}
						echo '}';
					}
					
	echo ']';
	
	
	break;
	
	
	
	
}

// Closing connection
mysqli_close($con);
mysqli_close($conn);
echo $output_to_send;



?>