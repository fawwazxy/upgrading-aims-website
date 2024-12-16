<?php
//phpinfo();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header('Content-type: application/json');

require_once('lib/json.inc');

error_log('json_jejakasnaf.php');
error_reporting(E_ALL);
ini_set("display_errors", 0);

$JsonSystem = new Json();

$cmd = $JsonSystem->getGETPOST('cmd');

$output = '';
$output_to_send = '';
switch($cmd) {
	
	case '1': //login
	
		//$role = $JsonSystem->getGETPOST('role');
	    $nama = $JsonSystem->getGETPOST('id_pengguna');
	    $pwd = $JsonSystem->getGETPOST('katalaluan');
			
		 /*if($role == "PUBLIC")
		 {
			 $sql ="SELECT id, nama, notel, emel, id_pengguna, katalaluan, negeri, daerah FROM ja_pelapor
					WHERE status = '1' AND ja_pelapor.id_pengguna = '$nama' AND ja_pelapor.katalaluan = '$pwd'"; 			 
		 }
		 else
		 {			
			 $sql ="SELECT ja_admin.id as id, nama, notel, emel, id_pengguna, katalaluan, acc_type, jawatan, negeri, daerah FROM ja_admin
					LEFT JOIN lkp_acc_type ON ja_admin.acc_type = lkp_acc_type.kod_acc
					WHERE status = '1' AND ja_admin.id_pengguna = '$nama' AND ja_admin.katalaluan = '$pwd'";			  
		 }*/
		 
		 $sql = "SELECT ja_admin.id,ja_admin.nama,ja_admin.id_pengguna,ja_admin.katalaluan,ja_admin.emel,
				ja_admin.notel,ja_admin.acc_type,ja_admin.jawatan,'ADMIN' AS pelapor_kumpulan,ja_admin.negeri,ja_admin.daerah,
				n.name AS nama_negeri,d.daerah AS nama_daerah 
				FROM ja_admin 
				LEFT JOIN lkp_negeri n ON n.code=ja_admin.negeri
				LEFT JOIN lkp_daerah d ON d.kod_daerah=ja_admin.daerah
				WHERE ja_admin.status='1' AND ja_admin.id_pengguna='$nama' AND ja_admin.katalaluan ='$pwd'
				UNION
				SELECT ja_pelapor.id,ja_pelapor.nama,ja_pelapor.id_pengguna,ja_pelapor.katalaluan,ja_pelapor.emel,
				ja_pelapor.notel,'PUBLIC' AS acc_type,'AWAM' AS jawatan,'AWAM' AS pelapor_kumpulan,ja_pelapor.negeri,ja_pelapor.daerah,
				n.name AS nama_negeri,d.daerah AS nama_daerah  
				FROM ja_pelapor
				LEFT JOIN lkp_negeri n ON n.code=ja_pelapor.negeri
				LEFT JOIN lkp_daerah d ON d.kod_daerah=ja_pelapor.daerah
				WHERE ja_pelapor.status='1' AND ja_pelapor.id_pengguna='$nama' AND ja_pelapor.katalaluan ='$pwd'";
		 
		
		$data = $conn->query($sql);
		
		if($data->num_rows > 0)//ada data
		{
			$output = $JsonSystem->getJSONData($sql,'',null);
	
			$output_to_send = "[{$output}]";
		}
		else
		{
			$output_to_send = "Log masuk gagal";
		}
		
	break;
	
	case '2'://check status AKTIF/TIDAK AKTIF
	
		$role = $JsonSystem->getGETPOST('role');
		$id = $JsonSystem->getGETPOST('id');
		
		$table = '';
		
		 if($role == "PUBLIC")
		 {
			 $table = 'ja_pelapor';		 
		 }
		 else
		 {			
			 $table ='ja_admin';			  
		 }
		 
		 $sql ="SELECT status FROM $table WHERE id = '$id'"; 			 
					
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '3'://geolocation
	
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
	
	case '4'://daftar login public
	
	$nama = $JsonSystem->getGETPOST('nama');
	$notel = $JsonSystem->getGETPOST('notel');
	$emel = $JsonSystem->getGETPOST('emel');
	$id_pengguna = $JsonSystem->getGETPOST('id_pengguna');
	$katalaluan = $JsonSystem->getGETPOST('katalaluan');
	$negeri = $JsonSystem->getGETPOST('negeri');
	$daerah = $JsonSystem->getGETPOST('daerah');
	
	//check existing registered id
	$sql1 = $JsonSystem->getData("select id FROM ja_admin
									where status='1' and id_pengguna ='$id_pengguna'
									UNION ALL
									select id FROM ja_pelapor 
									where STATUS='1' and id_pengguna ='$id_pengguna'");
								
	$check = $sql1[0];
	
		if($check > 0)
		{
			$output_to_send = '0-Id pengguna "' .$id_pengguna. '" sudah diambil. Sila masukkan id pengguna lain. ';
		}
		else
		{
			$sql2 = $JsonSystem->getData("select id FROM ja_admin
									where status='1' and notel ='$notel' OR emel = '$emel'
									UNION ALL
									select id FROM ja_pelapor 
									where STATUS='1' and notel ='$notel' OR emel = '$emel'");
								
			$check2 = $sql2[0];
			if($check2 > 0)
			{
				$output_to_send = "0-Pendaftaran gagal! Akaun telah wujud. No. telefon atau alamat emel sudah wujud didalam sistem.";
			}
			else
			{
				$sql = "INSERT INTO ja_pelapor (nama,notel,emel,id_pengguna,katalaluan,negeri,daerah,status,created_date) 
					VALUES (UPPER('$nama'),'$notel','$emel','$id_pengguna','$katalaluan',UPPER('$negeri'),UPPER('$daerah'),'1',CURRENT_TIMESTAMP)";
					
					$JsonSystem->executeOperation2($sql);
			
			$output_to_send = "1-Pendaftaran baru berjaya! Sila log masuk menggunakan maklumat yang telah didaftarkan.";
			}
		}		
				
	break;
	
	case '5'://status_semasa_laporan - LAPOR
		
		$kategori = $JsonSystem->getGETPOST('kategori');
		$acc_type = $JsonSystem->getGETPOST('acc_type');
		$pelapor_kumpulan = $JsonSystem->getGETPOST('pelapor_kumpulan');
		$negeri = $JsonSystem->getGETPOST('negeri');
		$daerah = $JsonSystem->getGETPOST('daerah');
		$pelapor_id = $JsonSystem->getGETPOST('pelapor_id');
		
		
		$cond = "";
		
		if($kategori == '2')//asnaf dilpaorkan
		{
			if($acc_type == 'A')//admin **senarai asnaf ikut negeri dan yang dia laporkan
			{
				$cond = "j.negeri= '$negeri'";
			}
			elseif($acc_type == 'PUBLIC')//awam **senarai asnaf yang dia laporkan shja
			{
				$cond = "pelapor_id = '$pelapor_id' AND pelapor_kumpulan='$pelapor_kumpulan'";
			}
			else//imam-penyiasat **senarai asnaf ikut daerah dan yang dia laporkan
			{
				$cond = "j.negeri= '$negeri' AND j.daerah = '$daerah'";
			}
		}
		else
		{
			$cond = "pelapor_id = '$pelapor_id' AND pelapor_kumpulan='$pelapor_kumpulan'";
		}
		
		
		
		$Baharu = $JsonSystem->getData("SELECT COUNT(j.id) AS Baharu FROM ja_laporan j 
					WHERE j.status_laporan = '0' AND $cond");
					
		$Dalam_Tindakan = $JsonSystem->getData("SELECT COUNT(j.id) AS Dlm_tindakan FROM ja_laporan j 
					WHERE j.status_laporan IN ('1','2','3') AND $cond");
					
		$Selesai = $JsonSystem->getData("SELECT COUNT(j.id) AS Selesai FROM ja_laporan j 
					WHERE j.status_laporan ='4' AND $cond");
		

		$output_to_send = '[{"Baharu":"'.$Baharu[0].'","Dlm_Tindakan":"'.$Dalam_Tindakan[0].'","Selesai":"'.$Selesai[0].'"}]';
	break;
	
	case '6'://Analisa Status Semasa JA - ANALISA SEMASA
	
		$negeri = $JsonSystem->getGETPOST('negeri');
		$daerah = $JsonSystem->getGETPOST('daerah');
		
		
		$cond = "";
		if($negeri =='' && $daerah == '') //tak pilih apa apa
		{
			$cond = "";
		}
		else if($negeri !='' && $daerah == '')  //negeri
		{
			$cond = "AND j.negeri='$negeri'";
		}
		else//negeri & daerah
		{
			$cond = "AND j.negeri='$negeri' AND j.daerah='$daerah'";
		}
		
		$Baharu = $JsonSystem->getData("SELECT COUNT(j.id) AS Baharu FROM ja_laporan j 
					WHERE j.status_laporan = '0' $cond");
					
		$Dalam_Siasatan = $JsonSystem->getData("SELECT COUNT(j.id) AS Dlm_Siasatan FROM ja_laporan j 
					WHERE j.status_laporan = '1' $cond");
					
		$Selesai_Siasatan = $JsonSystem->getData("SELECT COUNT(j.id) AS Selesai_Siasatan FROM ja_laporan j 
					WHERE j.status_laporan = '2' $cond");
					
		$Dalam_Tindakan = $JsonSystem->getData("SELECT COUNT(j.id) AS Dlm_Tindakan FROM ja_laporan j 
					WHERE j.status_laporan = '3' $cond");
					
		$Selesai = $JsonSystem->getData("SELECT COUNT(j.id) AS Selesai FROM ja_laporan j 
					WHERE j.status_laporan ='4' $cond");
					
		$Dalam_Tindakan2 = $Dalam_Siasatan[0] + $Dalam_Tindakan[0] + $Selesai_Siasatan[0];
		$Jum_Laporan = $Baharu[0] + $Dalam_Tindakan2 + $Selesai[0];
		
		
		if($Jum_Laporan != 0)
		{
			$Percent_Selesai = Round(($Selesai[0] / $Jum_Laporan) * 100,0);
		}
		else
		{
			$Percent_Selesai = 0;
		}
					
		$output_to_send = '[{"Jum_Laporan":"'.$Jum_Laporan.'","Baharu":"'.$Baharu[0].'","Dlm_Siasatan":"'.$Dalam_Siasatan[0].'","Selesai_Siasatan":"'.$Selesai_Siasatan[0].'","Dlm_Tindakan":"'.$Dalam_Tindakan[0].'","Dlm_Tindakan2":"'.$Dalam_Tindakan2.'","Selesai":"'.$Selesai[0].'","Percent_Selesai":"'.$Percent_Selesai.'%"}]';

	break;
	
	case '7'://Senarai Asnaf - ASNAF
	
		$acc_type = $JsonSystem->getGETPOST('acc_type');
		$pelapor_kumpulan = $JsonSystem->getGETPOST('pelapor_kumpulan');
		$negeri = $JsonSystem->getGETPOST('negeri');
		$daerah = $JsonSystem->getGETPOST('daerah');
		$pelapor_id = $JsonSystem->getGETPOST('pelapor_id');
		
		
		$cond = "";
		if($acc_type == 'A')//admin **ikut negeri
		{
			$cond = "AND j.negeri= '$negeri'";
		}
		elseif($acc_type == 'PUBLIC')//awam **dia laporkan shja
		{
			$cond = "AND pelapor_id = '$pelapor_id' AND pelapor_kumpulan='$pelapor_kumpulan'";
		}
		else//imam-penyiasat **senarai asnaf ikut daerah
		{
			$cond = "AND j.negeri= '$negeri' AND j.daerah = '$daerah'";
		}
	
		$Baharu = $JsonSystem->getData("SELECT COUNT(j.id) AS Baharu FROM ja_laporan j 
					WHERE j.status_laporan = '0' $cond");
					
		$Dalam_Siasatan = $JsonSystem->getData("SELECT COUNT(j.id) AS Dlm_Siasatan FROM ja_laporan j 
					WHERE j.status_laporan = '1' $cond");
					
		$Selesai_Siasatan = $JsonSystem->getData("SELECT COUNT(j.id) AS Selesai_Siasatan FROM ja_laporan j 
					WHERE j.status_laporan = '2' $cond");
					
		$Dalam_Tindakan = $JsonSystem->getData("SELECT COUNT(j.id) AS Dlm_Tindakan FROM ja_laporan j 
					WHERE j.status_laporan = '3' $cond");
					
		$Selesai = $JsonSystem->getData("SELECT COUNT(j.id) AS Selesai FROM ja_laporan j 
					WHERE j.status_laporan ='4' $cond");
					
		$Dalam_Tindakan2 = $Dalam_Siasatan[0] + $Dalam_Tindakan[0] + $Selesai_Siasatan[0];
		$Jum_Laporan = $Baharu[0] + $Dalam_Tindakan2 + $Selesai[0];
		
		
		if($Jum_Laporan != 0)
		{
			$Percent_Selesai = Round(($Selesai[0] / $Jum_Laporan) * 100,0);
		}
		else
		{
			$Percent_Selesai = 0;
		}
					
		$output_to_send = '[{"Jum_Laporan":"'.$Jum_Laporan.'","Baharu":"'.$Baharu[0].'","Dlm_Siasatan":"'.$Dalam_Siasatan[0].'","Selesai_Siasatan":"'.$Selesai_Siasatan[0].'","Dlm_Tindakan":"'.$Dalam_Tindakan[0].'","Dlm_Tindakan2":"'.$Dalam_Tindakan2.'","Selesai":"'.$Selesai[0].'","Percent_Selesai":"'.$Percent_Selesai.'%"}]';

		break;
	
	case '8':// Kemaskini Maklumat Asnaf -LAPOR
	
	$id = $JsonSystem->getGETPOST('id');
	$nama = $JsonSystem->getGETPOST('nama');
	$nama_panggilan = $JsonSystem->getGETPOST('nama_panggilan');
	$nokp = $JsonSystem->getGETPOST('nokp');
	$notel = $JsonSystem->getGETPOST('notel');
	$negeri = $JsonSystem->getGETPOST('negeri');
	$daerah = $JsonSystem->getGETPOST('daerah');
	$alamat = $JsonSystem->getGETPOST('alamat');
	$koordinat = $JsonSystem->getGETPOST('koordinat');
	$nota = $JsonSystem->getGETPOST('nota');
	$image_bytes = $JsonSystem->getGETPOST('gambar_laporan');
	$file_gambar = $JsonSystem->getGETPOST('file_gambar');
	
		$sql= "UPDATE ja_laporan SET nama_asnaf=UPPER('$nama'),nama_panggilan_asnaf=UPPER('$nama_panggilan'),nokp_asnaf='$nokp',notel_asnaf='$notel',
		koordinat_gps='$koordinat',alamat=UPPER('$alamat'),keterangan_laporan='$nota',daerah='$daerah',negeri='$negeri' WHERE id='$id'";
							
		$JsonSystem->executeOperation2($sql);
		/****************************************************************************************************************************/
	
	if($image_bytes != '')
	{
		$content = base64_decode($image_bytes);
			
			$size = getImageSizeFromString($content);

			// Check the MIME type to be sure that the binary data is an image
			if (empty($size['mime']) || strpos($size['mime'], 'image/') !== 0) {
			  $output_file = "Image value not valid";
			  die('Base64 value is not a valid image');
				
			}

			$directoryName = "jejakasnaf/gambar_laporan/";
			
			if(!is_dir($directoryName)){
			//Directory does not exist, so lets create it.
			mkdir($directoryName, 0755);
			}
			
			// Specify the location where you want to save the image
			$img_file = $directoryName.$file_gambar;
			
			// Save binary data as raw data (that is, it will not remove metadata or invalid contents)
			// In this case, the PHP backdoor will be stored on the server
			file_put_contents($img_file, $content);
			
			//update filename into table
			$sql_update = "UPDATE ja_laporan SET gambar_lapor= '$file_gambar' where id='$id'";
												
			$JsonSystem->executeOperation($sql_update);
			
			$output_to_send = "1-Maklumat asnaf berjaya dikemaskini!";
			/*****************************************************************************************************************************/
	}
	else
	{
		$output_to_send = "1-Maklumat asnaf berjaya dikemaskini!";
	}
			
		
	break;
	
	case '9':// Senarai_Asnaf -LAPOR
		
		$kategori = $JsonSystem->getGETPOST('kategori');
		$acc_type = $JsonSystem->getGETPOST('acc_type');
		$pelapor_kumpulan = $JsonSystem->getGETPOST('pelapor_kumpulan');
		$negeri = $JsonSystem->getGETPOST('negeri');
		$daerah = $JsonSystem->getGETPOST('daerah');
		$pelapor_id = $JsonSystem->getGETPOST('pelapor_id');
		
		
		$cond = "";
		
		if($kategori == '2')//asnaf dilpaorkan
		{
			if($acc_type == 'A')//admin **senarai asnaf ikut negeri dan yang dia laporkan
			{
				/*$cond = "negeri = '$negeri'
				UNION 
				SELECT id,pelapor_id,pelapor_kumpulan,DATE_FORMAT(tarikh_lapor,'%d') AS hari, DATE_FORMAT(tarikh_lapor,'%M') AS bulan,
					DATE_FORMAT(tarikh_lapor,'%Y') AS tahun,UPPER(nama_panggilan_asnaf) AS nama_panggilan,status_laporan,
					CASE WHEN nama_asnaf = '' OR nama_asnaf IS NULL THEN '-'
					ELSE UPPER(nama_asnaf)
					END AS nama_asnaf,
					CASE WHEN status_laporan = '0' THEN 'BAHARU'
					WHEN status_laporan = '1' THEN 'DALAM SIASATAN'
					WHEN status_laporan = '2' THEN 'SELESAI SIASATAN'
					WHEN status_laporan = '3' THEN 'DALAM TINDAKAN'
					ELSE 'SELESAI'
					END AS status_semasa_laporan  
					FROM ja_laporan  
					WHERE pelapor_id = '$pelapor_id' AND pelapor_kumpulan='$pelapor_kumpulan'";*/
					
					$cond = "negeri = '$negeri'";
			}
			elseif($acc_type == 'PUBLIC')//awam **senarai asnaf yang dia laporkan shja
			{
				$cond = "pelapor_id = '$pelapor_id' AND pelapor_kumpulan='$pelapor_kumpulan'";
			}
			else//imam-penyiasat **senarai asnaf ikut daerah dan yang dia laporkan
			{
				/*$cond = "negeri = '$negeri' AND daerah = '$daerah' 
				UNION 
				SELECT id,pelapor_id,pelapor_kumpulan,DATE_FORMAT(tarikh_lapor,'%d') AS hari, DATE_FORMAT(tarikh_lapor,'%M') AS bulan,
					DATE_FORMAT(tarikh_lapor,'%Y') AS tahun,UPPER(nama_panggilan_asnaf) AS nama_panggilan,status_laporan,
					CASE WHEN nama_asnaf = '' OR nama_asnaf IS NULL THEN '-'
					ELSE UPPER(nama_asnaf)
					END AS nama_asnaf,
					CASE WHEN status_laporan = '0' THEN 'BAHARU'
					WHEN status_laporan = '1' THEN 'DALAM SIASATAN'
					WHEN status_laporan = '2' THEN 'SELESAI SIASATAN'
					WHEN status_laporan = '3' THEN 'DALAM TINDAKAN'
					ELSE 'SELESAI'
					END AS status_semasa_laporan  
					FROM ja_laporan  
					WHERE pelapor_id = '$pelapor_id' AND pelapor_kumpulan='$pelapor_kumpulan'";*/
					
					$cond = "negeri = '$negeri' AND daerah = '$daerah'";
			}
		}
		else
		{
			$cond = "pelapor_id = '$pelapor_id' AND pelapor_kumpulan='$pelapor_kumpulan'";
		}
		
		
		$sql ="SELECT id,pelapor_id,pelapor_kumpulan,DATE_FORMAT(tarikh_lapor,'%d') AS hari, DATE_FORMAT(tarikh_lapor,'%M') AS bulan,
				DATE_FORMAT(tarikh_lapor,'%Y') AS tahun,UPPER(nama_panggilan_asnaf) AS nama_panggilan,status_laporan,
				CASE WHEN nama_asnaf = '' OR nama_asnaf IS NULL THEN '-'
				ELSE UPPER(nama_asnaf)
				END AS nama_asnaf,
				CASE WHEN status_laporan = '0' THEN 'BAHARU'
				WHEN status_laporan = '1' THEN 'DALAM SIASATAN'
				WHEN status_laporan = '2' THEN 'SELESAI SIASATAN'
				WHEN status_laporan = '3' THEN 'DALAM TINDAKAN'
				ELSE 'SELESAI'
				END AS status_semasa_laporan,penyiasat_id,IFNULL(nokp_asnaf,'-') AS nokp_asnaf
				FROM ja_laporan j 
				WHERE $cond ORDER BY id DESC";
				
		$result = $conn->query($sql);
		
				echo '[';
				
					if($result->num_rows > 0)//ada data
					{
						$i = 0;
						
						while($data = $result->fetch_assoc()) {
							
							if($i>0)
								echo ',';
							$i++;
							$kumpulan_pelapor = $data['pelapor_kumpulan'];
							$id_pelapor = $data['pelapor_id'];
							
							if($kumpulan_pelapor == 'ADMIN')
							{
								$table = 'ja_admin';
							}else
							{
								$table = 'ja_pelapor';
							}
							
							$sql_pelapor = "SELECT nama,notel FROM $table WHERE id='$id_pelapor'";
							$result2 = $conn->query($sql_pelapor);
							
							$data_pelapor = $result2->fetch_assoc();
							$nama_pelapor = $data_pelapor['nama'];
							$notel_pelapor = $data_pelapor['notel'];
							
							$data['nama_pelapor'] = $nama_pelapor;
							$data['notel_pelapor'] = $notel_pelapor;
							echo json_encode($data);
						}
					}
					
					echo ']';		
				
		
	break;
	
	case '10':// Papar/Kemaskini Asnaf - Lapor/Siasatan
		
		$laporan_id = $JsonSystem->getGETPOST('laporan_id');
		
		$sql ="SELECT j.id,j.nokp_asnaf,j.nama_asnaf,j.nama_panggilan_asnaf,j.notel_asnaf,j.alamat,
				CONCAT(n.code,'-',n.name) AS negeri,CONCAT(d.kod_daerah,'-',d.daerah) AS daerah,j.koordinat_gps,
				IFNULL(j.gambar_lapor,'-') AS gambar_lapor,j.keterangan_laporan,j.siasatan_maklumat_diri,j.siasatan_tanggungan,j.siasatan_kediaman,
				j.siasatan_harta,j.siasatan_lainlain,j.siasatan_pengesyoran,IFNULL(j.siasatan_gambar,'-') AS siasatan_gambar,
				IFNULL(CONCAT(k.kod_kes,'-',k.jenis_kes),'-') AS siasatan_jenis_kes 
				FROM ja_laporan j LEFT JOIN lkp_negeri n ON n.code=j.negeri
				LEFT JOIN lkp_daerah d ON d.kod_daerah = j.daerah
				LEFT JOIN lkp_jenis_kes k ON k.kod_kes = j.siasatan_jenis_kes
				WHERE j.id='$laporan_id'";
					
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '11'://tambah laporan asnaf - lapor
	
	$nama_panggilan_asnaf = $JsonSystem->getGETPOST('nama_panggilan_asnaf');
	$nama_asnaf = $JsonSystem->getGETPOST('nama_asnaf');
	$nokp_asnaf = $JsonSystem->getGETPOST('nokp_asnaf');
	$notel_asnaf = $JsonSystem->getGETPOST('notel_asnaf');
	$negeri = $JsonSystem->getGETPOST('negeri');
	$daerah = $JsonSystem->getGETPOST('daerah');
	$koordinat_gps = $JsonSystem->getGETPOST('koordinat_gps');
	$alamat = $JsonSystem->getGETPOST('alamat');
	$keterangan_laporan = $JsonSystem->getGETPOST('keterangan_laporan');
	$pelapor_id = $JsonSystem->getGETPOST('pelapor_id');
	$pelapor_kumpulan = $JsonSystem->getGETPOST('pelapor_kumpulan');
	$image_bytes = $JsonSystem->getGETPOST('gambar_laporan');
	$file_gambar = $JsonSystem->getGETPOST('file_gambar');
	
	if($nokp_asnaf != "") //check nokp_asnaf dalam table ja_asnaf
	{
		$sql ="SELECT id FROM ja_asnaf WHERE nokp = '$nokp_asnaf'";
		
		$id_mk=$conn->query($sql)->fetch_object()->id;
		
		$newid = "0";		
		if($id_mk > 0)//ada data
		{
			$sql = "INSERT INTO ja_laporan (nama_panggilan_asnaf,nama_asnaf,nokp_asnaf,notel_asnaf,negeri,daerah,koordinat_gps,alamat,
					keterangan_laporan,status_laporan,tarikh_lapor, pelapor_id,pelapor_kumpulan) 
					VALUES (UPPER('".$nama_panggilan_asnaf."'),UPPER('".$nama_asnaf."'),'".$nokp_asnaf."','".$notel_asnaf."',UPPER('".$negeri."'),
					UPPER('".$daerah."'),'".$koordinat_gps."',UPPER('".$alamat."'),'".$keterangan_laporan."','0', CURRENT_TIMESTAMP, '".$pelapor_id."', '".$pelapor_kumpulan."')";
					
			$newid = $JsonSystem->executeOperation2($sql);
		}
		else
		{
			$sql = "INSERT INTO ja_asnaf (nama,nama_panggilan,nokp,notel,alamat,negeri,daerah,koordinat_gps,status,created_date)  
					VALUES (UPPER('".$nama_asnaf."'),UPPER('".$nama_panggilan_asnaf."'),'".$nokp_asnaf."','".$notel_asnaf."',UPPER('".$alamat."'),
					UPPER('".$negeri."'), UPPER('".$daerah."'),'".$koordinat_gps."','1', CURRENT_TIMESTAMP)";
					
			$output = $JsonSystem->executeOperation2($sql);
			
			$sql2 = "INSERT INTO ja_laporan (nama_panggilan_asnaf,nama_asnaf,nokp_asnaf,notel_asnaf,negeri,daerah,koordinat_gps,alamat,
					keterangan_laporan,status_laporan,tarikh_lapor, pelapor_id,pelapor_kumpulan) 
					VALUES (UPPER('".$nama_panggilan_asnaf."'),UPPER('".$nama_asnaf."'),'".$nokp_asnaf."','".$notel_asnaf."',UPPER('".$negeri."'),
					UPPER('".$daerah."'),'".$koordinat_gps."',UPPER('".$alamat."'),'".$keterangan_laporan."','0', CURRENT_TIMESTAMP, '".$pelapor_id."', '".$pelapor_kumpulan."')";
					
			$newid = $JsonSystem->executeOperation2($sql2);
		}
	}
	else
	{
		$sql = "INSERT INTO ja_laporan (nama_panggilan_asnaf,nama_asnaf,notel_asnaf,negeri,daerah,koordinat_gps,alamat,
				keterangan_laporan,status_laporan,tarikh_lapor, pelapor_id,pelapor_kumpulan) 
					VALUES (UPPER('".$nama_panggilan_asnaf."'),UPPER('".$nama_asnaf."'),'".$notel_asnaf."',UPPER('".$negeri."'),
					UPPER('".$daerah."'),'".$koordinat_gps."',UPPER('".$alamat."'),'".$keterangan_laporan."','0', CURRENT_TIMESTAMP, '".$pelapor_id."', '".$pelapor_kumpulan."')";
					
		$newid = $JsonSystem->executeOperation2($sql);
		
	}		
	/****************************************************************************************************************************/
	
	if($image_bytes != '')
	{
		$content = base64_decode($image_bytes);
			
			$size = getImageSizeFromString($content);

			// Check the MIME type to be sure that the binary data is an image
			if (empty($size['mime']) || strpos($size['mime'], 'image/') !== 0) {
			  $output_file = "Image value not valid";
			  die('Base64 value is not a valid image');
				
			}

			$directoryName = "jejakasnaf/gambar_laporan/";
			
			if(!is_dir($directoryName)){
			//Directory does not exist, so lets create it.
			mkdir($directoryName, 0755);
			}
			
			// Specify the location where you want to save the image
			$img_file = $directoryName.$file_gambar;
			
			// Save binary data as raw data (that is, it will not remove metadata or invalid contents)
			// In this case, the PHP backdoor will be stored on the server
			file_put_contents($img_file, $content);
			
			
			
			//update filename into table
			$sql_update = "UPDATE ja_laporan SET gambar_lapor= '$file_gambar' where id='$newid'";
												
			$JsonSystem->executeOperation($sql_update);
			
			$output_to_send = "1-Maklumat asnaf berjaya dilaporkan!";
			/*****************************************************************************************************************************/
	}else
	{
		$output_to_send = "1-Maklumat asnaf berjaya dilaporkan!";
	}
			
		
	
	break;
		
	case '12': //dropdown negeri *
	$sql = "SELECT CONCAT (CODE, '-', NAME) AS negeri FROM lkp_negeri WHERE STATUS = '1' ORDER BY name ASC";
			
	$output = $JsonSystem->getJSONData($sql,'',null);
			
	$output_to_send = "[{$output}]";
	
	break;
	
	case '13': //dropdown daerah *
	
	$kod_negeri = $JsonSystem->getGETPOST('kod_negeri');
	
	$sql = "SELECT CONCAT (kod_daerah, '-', daerah) AS daerah FROM lkp_daerah WHERE kod_negeri = '$kod_negeri' ORDER BY daerah ASC";
			
	$output = $JsonSystem->getJSONData($sql,'',null);
			
	$output_to_send = "[{$output}]";
	
	break;
	
	case '14': //analisa asnaf - ANALISA
		
	$negeri = $JsonSystem->getGETPOST('negeri');
		
	$sql = "SELECT d.daerah, COUNT(a.id) AS bil_asnaf 
				FROM ja_asnaf a LEFT JOIN lkp_daerah d ON d.kod_daerah=a.daerah
				WHERE a.`status`='1' AND a.negeri='$negeri'
				GROUP BY d.daerah";
			
	$output = $JsonSystem->getJSONData($sql,'',null);
	$output_to_send = "[{$output}]";
	
	break;
	
	case '15': //Senarai Asnaf - ASNAF
	
	$negeri = $JsonSystem->getGETPOST('negeri');
	$daerah = $JsonSystem->getGETPOST('daerah');
	$search_word = $JsonSystem->getGETPOST('search_word');
	
	if($search_word == '')//negeri
	{
			if($negeri =='' && $daerah == '') //tak pilih apa apa
			{
				$sql = "SELECT ja.id, ja.nokp, UPPER(ja.nama) AS nama, UPPER(ja.nama_panggilan) AS nama_panggilan, ja.notel, 
						UPPER(ja.alamat) AS alamat, n.name as negeri,d.daerah, ja.koordinat_gps, 'AKTIF' as status 
						FROM ja_asnaf ja 
						LEFT JOIN lkp_negeri n ON n.code=ja.negeri
						LEFT JOIN lkp_daerah d ON d.kod_daerah=ja.daerah
						WHERE ja.`status`= '1' ORDER BY ja.nama ASC";
			}
			else if($negeri !='' && $daerah == '')  //negeri
			{
				$sql = "SELECT ja.id, ja.nokp, UPPER(ja.nama) AS nama, UPPER(ja.nama_panggilan) AS nama_panggilan, ja.notel, 
						UPPER(ja.alamat) AS alamat, n.name as negeri,d.daerah, ja.koordinat_gps, 'AKTIF' as status 
						FROM ja_asnaf ja 
						LEFT JOIN lkp_negeri n ON n.code=ja.negeri
						LEFT JOIN lkp_daerah d ON d.kod_daerah=ja.daerah
						WHERE ja.negeri = '$negeri' AND ja.`status`= '1' ORDER BY ja.nama ASC";
			}
			else//negeri & daerah
			{
				$sql = "SELECT ja.id, ja.nokp, UPPER(ja.nama) AS nama, UPPER(ja.nama_panggilan) AS nama_panggilan, ja.notel, 
						UPPER(ja.alamat) AS alamat, n.name as negeri,d.daerah, ja.koordinat_gps, 'AKTIF' as status 
						FROM ja_asnaf ja 
						LEFT JOIN lkp_negeri n ON n.code=ja.negeri
						LEFT JOIN lkp_daerah d ON d.kod_daerah=ja.daerah
						WHERE ja.negeri = '$negeri' AND ja.daerah = '$daerah' AND ja.`status`= '1' ORDER BY ja.nama ASC";
			}
	}
	else //search
	{
			if($negeri =='' && $daerah == '') //tak pilih apa apa
			{
				$sql="SELECT ja.id, ja.nokp, UPPER(ja.nama) AS nama, UPPER(ja.nama_panggilan) AS nama_panggilan, ja.notel, 
					UPPER(ja.alamat) AS alamat, n.name as negeri,d.daerah, ja.koordinat_gps, 'AKTIF' as status 
					FROM ja_asnaf ja 
					LEFT JOIN lkp_negeri n ON n.code=ja.negeri
					LEFT JOIN lkp_daerah d ON d.kod_daerah=ja.daerah 
					WHERE (ja.nama LIKE '%$search_word%' OR ja.nama_panggilan LIKE '%$search_word%' OR ja.alamat LIKE '%$search_word%' OR ja.nokp LIKE '%$search_word%') 
					AND ja.`status`='1' ORDER BY ja.nama ASC";
			}
			else if($negeri !='' && $daerah == '')  //negeri
			{
				$sql="SELECT ja.id, ja.nokp, UPPER(ja.nama) AS nama, UPPER(ja.nama_panggilan) AS nama_panggilan, ja.notel, 
					UPPER(ja.alamat) AS alamat, n.name as negeri,d.daerah, ja.koordinat_gps, 'AKTIF' as status 
					FROM ja_asnaf ja 
					LEFT JOIN lkp_negeri n ON n.code=ja.negeri
					LEFT JOIN lkp_daerah d ON d.kod_daerah=ja.daerah 
					WHERE (ja.nama LIKE '%$search_word%' OR ja.nama_panggilan LIKE '%$search_word%' OR ja.alamat LIKE '%$search_word%' OR ja.nokp LIKE '%$search_word%') 
					AND ja.negeri = '$negeri' AND ja.`status`='1' ORDER BY ja.nama ASC";
			}
			else//negeri & daerah
			{
				$sql="SELECT ja.id, ja.nokp, UPPER(ja.nama) AS nama, UPPER(ja.nama_panggilan) AS nama_panggilan, ja.notel, 
					UPPER(ja.alamat) AS alamat, n.name as negeri,d.daerah, ja.koordinat_gps, 'AKTIF' as status 
					FROM ja_asnaf ja 
					LEFT JOIN lkp_negeri n ON n.code=ja.negeri
					LEFT JOIN lkp_daerah d ON d.kod_daerah=ja.daerah 
					WHERE (ja.nama LIKE '%$search_word%' OR ja.nama_panggilan LIKE '%$search_word%' OR ja.alamat LIKE '%$search_word%' OR ja.nokp LIKE '%$search_word%') 
					AND ja.negeri = '$negeri' AND ja.daerah = '$daerah' AND ja.`status`='1' ORDER BY ja.nama ASC";
			}
	}
	
	$output = $JsonSystem->getJSONData($sql,'',null);
			
	$output_to_send = "[{$output}]";
	
	break;
	
	case '16': //analisa siasatan _ ANALISA
		
		$id_penyiasat = $JsonSystem->getGETPOST('id_penyiasat');
		
		$cond = "";
		if($id_penyiasat !='')  //penyiasat select
		{
			$cond = "AND j.penyiasat_id= '$id_penyiasat'";
		}
		else
		{
			$cond = "";
		}	
		
		$Baharu = $JsonSystem->getData("SELECT COUNT(j.id) AS Baharu FROM ja_laporan j 
					WHERE j.status_laporan = '0' $cond");
					
		$Dlm_Siasatan = $JsonSystem->getData("SELECT COUNT(j.id) AS Dlm_tindakan FROM ja_laporan j 
					WHERE j.status_laporan = '1' $cond");
					
		$Selesai_Siasatan = $JsonSystem->getData("SELECT COUNT(j.id) AS Selesai FROM ja_laporan j 
					WHERE j.status_laporan ='2' $cond");
		
		$Jum_Laporan = $Baharu[0] + $Dlm_Siasatan[0] + $Selesai_Siasatan[0];
		
		$output_to_send = '[{"Jum_Laporan":"'.$Jum_Laporan.'","Baharu":"'.$Baharu[0].'","Dlm_Siasatan":"'.$Dlm_Siasatan[0].'","Selesai_Siasatan":"'.$Selesai_Siasatan[0].'"}]';

	
	break;
	
	/*dropdown penyiasat*/
	case '17': 
	
	$sql = "SELECT CONCAT(j.penyiasat_id,'-',ja.nama) AS penyiasat 
			FROM ja_laporan j 
			LEFT JOIN ja_admin ja ON ja.id=j.pelapor_id 
			WHERE j.penyiasat_id IS NOT NULL
			GROUP BY penyiasat_id ASC";
			
	$output = $JsonSystem->getJSONData($sql,'',null);
	$output_to_send = "[{$output}]";
	
	break;

	case '18'://senarai asnaf - SIASATAN
	
	$kategori = $JsonSystem->getGETPOST('kategori');
	$daerah = $JsonSystem->getGETPOST('daerah');
	$negeri = $JsonSystem->getGETPOST('negeri');
	$acc_type = $JsonSystem->getGETPOST('acc_type');
	
		$cond = "";
		if($acc_type == 'A')//admin **senarai asnaf ikut negeri 
		{
			$cond = "AND j.negeri= '$negeri'";
		}
		else//imam-penyiasat **senarai asnaf ikut daerah 
		{
			$cond = "AND j.negeri= '$negeri' AND j.daerah = '$daerah'";
		}
	
		$sql ="SELECT j.id,j.pelapor_id,j.pelapor_kumpulan,DATE_FORMAT(j.tarikh_lapor,'%d') AS hari, DATE_FORMAT(j.tarikh_lapor,'%M') AS bulan,
				DATE_FORMAT(j.tarikh_lapor,'%Y') AS tahun,UPPER(j.nama_panggilan_asnaf) AS nama_panggilan,j.status_laporan,
				CASE WHEN nama_asnaf = '' OR nama_asnaf IS NULL THEN '-'
				ELSE UPPER(j.nama_asnaf)
				END AS nama_asnaf,
				CASE WHEN j.status_laporan = '0' THEN 'BAHARU'
				WHEN j.status_laporan = '1' THEN 'DALAM SIASATAN'
				WHEN j.status_laporan = '2' THEN 'SELESAI SIASATAN'
				WHEN j.status_laporan = '3' THEN 'DALAM TINDAKAN'
				ELSE 'SELESAI'
				END AS status_semasa_laporan,
				n.name AS negeri,d.daerah,j.notel_asnaf,
				j.penyiasat_id,IFNULL(nokp_asnaf,'-') AS nokp_asnaf
				FROM ja_laporan j 
				LEFT JOIN lkp_negeri n ON n.code=j.negeri
				LEFT JOIN lkp_daerah d ON d.kod_daerah=j.daerah
				WHERE j.status_laporan='$kategori' $cond ORDER BY j.tarikh_lapor ASC";
				
		$result = $conn->query($sql);
		
				echo '[';
				
					if($result->num_rows > 0)//ada data
					{
						$i = 0;
						
						while($data = $result->fetch_assoc()) {
							
							if($i>0)
								echo ',';
							$i++;
							$kumpulan_pelapor = $data['pelapor_kumpulan'];
							$id_pelapor = $data['pelapor_id'];
							$id_penyiasat = $data['penyiasat_id'];
							
							if($kumpulan_pelapor == 'ADMIN')
							{
								$table = 'ja_admin';
							}else
							{
								$table = 'ja_pelapor';
							}
							
							$sql_pelapor = "SELECT nama,notel FROM $table WHERE id='$id_pelapor'";
							$result2 = $conn->query($sql_pelapor);
							$data_pelapor = $result2->fetch_assoc();
							$nama_pelapor = $data_pelapor['nama'];
							$notel_pelapor = $data_pelapor['notel'];
							
							
							if($id_penyiasat == null)
							{
								$nama_penyiasat = "";
								$notel_penyiasat = "";
							}
							else
							{
								$sql_penyiasat = "SELECT nama,notel FROM ja_admin WHERE id='$id_penyiasat'";
								$result3 = $conn->query($sql_penyiasat);
								$data_penyiasat = $result3->fetch_assoc();
								$nama_penyiasat = $data_penyiasat['nama'];
								$notel_penyiasat = $data_penyiasat['notel'];
							}
							
							$data['nama_pelapor'] = $nama_pelapor;
							$data['notel_pelapor'] = $notel_pelapor;
							$data['nama_penyiasat'] = $nama_penyiasat;
							$data['notel_penyiasat'] = $notel_penyiasat;
							echo json_encode($data);
						}
					}
					
					echo ']';	
	break;
	
	case '19': //status semasa siasatan - SIASATAN
	
	$daerah = $JsonSystem->getGETPOST('daerah');
	$negeri = $JsonSystem->getGETPOST('negeri');
	$acc_type = $JsonSystem->getGETPOST('acc_type');
	
		$cond = "";
		if($acc_type == 'A')//admin **senarai asnaf ikut negeri 
		{
			$cond = "AND j.negeri= '$negeri'";
		}
		else//imam-penyiasat **senarai asnaf ikut daerah 
		{
			$cond = "AND j.negeri= '$negeri' AND j.daerah = '$daerah'";
		}
		
		
		$Baharu = $JsonSystem->getData("SELECT COUNT(j.id) AS Baharu FROM ja_laporan j 
					WHERE j.status_laporan = '0' $cond");
					
		$Dalam_Siasatan = $JsonSystem->getData("SELECT COUNT(j.id) AS Dlm_tindakan FROM ja_laporan j 
					WHERE j.status_laporan = '1' $cond");
					
		$Selesai_Siasatan = $JsonSystem->getData("SELECT COUNT(j.id) AS Selesai FROM ja_laporan j 
					WHERE j.status_laporan ='2' $cond");
		

		$output_to_send = '[{"Baharu":"'.$Baharu[0].'","Dlm_Siasatan":"'.$Dalam_Siasatan[0].'","Selesai_Siasatan":"'.$Selesai_Siasatan[0].'"}]';
	break;
	
	case '20': //update status siasatan, penyiasat id - SIASATAN
	
	$id_laporan = $JsonSystem->getGETPOST('id_laporan');
	$status_laporan = $JsonSystem->getGETPOST('status_laporan');
	$id_penyiasat = $JsonSystem->getGETPOST('id_penyiasat');
	
	if($status_laporan == "1")//update mula siasatan
	{
		$sql_update = "UPDATE ja_laporan SET status_laporan= '$status_laporan',penyiasat_id='$id_penyiasat',tarikh_siasatan_mula=CURRENT_TIMESTAMP 
					where id='$id_laporan'";
		$JsonSystem->executeOperation($sql_update);
		$output_to_send = "1-Status laporan berjaya dikemaskini! Laporan sedang disiasat.";	
	}
	else//selesai siasatan
	{
		$sql_update = "UPDATE ja_laporan SET status_laporan= '$status_laporan',penyiasat_id='$id_penyiasat',tarikh_siasatan_selesai=CURRENT_TIMESTAMP 
					where id='$id_laporan'";
		$JsonSystem->executeOperation($sql_update);
		$output_to_send = "1-Status laporan berjaya dikemaskini!. Laporan selesai disiasat.";	
	}
    
	
			
	
	break;	
	
	
	case '21'://dropdown jenis kes
	
	$sql = "SELECT CONCAT(k.kod_kes,'-',k.jenis_kes) AS jenis_kes FROM lkp_jenis_kes k";
			
	$output = $JsonSystem->getJSONData($sql,'',null);
			
	$output_to_send = "[{$output}]";
	break;
	
	case '22'://kemaskini info laporan - SIASATAN
	$id = $JsonSystem->getGETPOST('id');
	$nama = $JsonSystem->getGETPOST('nama');
	$nama_panggilan = $JsonSystem->getGETPOST('nama_panggilan');
	$nokp = $JsonSystem->getGETPOST('nokp');
	$notel = $JsonSystem->getGETPOST('notel');
	$negeri = $JsonSystem->getGETPOST('negeri');
	$daerah = $JsonSystem->getGETPOST('daerah');
	$alamat = $JsonSystem->getGETPOST('alamat');
	$koordinat = $JsonSystem->getGETPOST('koordinat');
	$nota = $JsonSystem->getGETPOST('nota');
	$image_bytes = $JsonSystem->getGETPOST('gambar_laporan');
	$file_gambar = $JsonSystem->getGETPOST('file_gambar');
	
	$file_gambar_siasatan = $JsonSystem->getGETPOST('file_gambar_siasatan');
	$jenis_kes = $JsonSystem->getGETPOST('jenis_kes');
	$gambar_siasatan = $JsonSystem->getGETPOST('gambar_siasatan');
	$tanggungan = $JsonSystem->getGETPOST('tanggungan');
	$lain2 = $JsonSystem->getGETPOST('lain2');
	$maklumat = $JsonSystem->getGETPOST('maklumat');
	$harta = $JsonSystem->getGETPOST('harta');
	$kediaman = $JsonSystem->getGETPOST('kediaman');
	$pengesyoran = $JsonSystem->getGETPOST('pengesyoran');
	
	
		$sql= "UPDATE ja_laporan SET nama_asnaf=UPPER('$nama'),nama_panggilan_asnaf=UPPER('$nama_panggilan'),nokp_asnaf='$nokp',notel_asnaf='$notel',
		koordinat_gps='$koordinat',alamat=UPPER('$alamat'),keterangan_laporan='$nota',daerah='$daerah',negeri='$negeri',
		siasatan_maklumat_diri = '$maklumat',siasatan_tanggungan = '$tanggungan',siasatan_kediaman ='$kediaman',siasatan_harta='$harta',
		siasatan_lainlain ='$lain2',siasatan_pengesyoran= '$pengesyoran',siasatan_jenis_kes= '$jenis_kes'
		WHERE id='$id'";
							
		$JsonSystem->executeOperation2($sql);
		
		/****************************************************************************************************************************/
	
	if($image_bytes != '')
	{
		$content = base64_decode($image_bytes);
			
			$size = getImageSizeFromString($content);

			// Check the MIME type to be sure that the binary data is an image
			if (empty($size['mime']) || strpos($size['mime'], 'image/') !== 0) {
			  $output_file = "Image value not valid";
			  die('Base64 value is not a valid image');
				
			}

			$directoryName = "jejakasnaf/gambar_laporan/";
			
			if(!is_dir($directoryName)){
			//Directory does not exist, so lets create it.
			mkdir($directoryName, 0755);
			}
			
			// Specify the location where you want to save the image
			$img_file = $directoryName.$file_gambar;
			
			// Save binary data as raw data (that is, it will not remove metadata or invalid contents)
			// In this case, the PHP backdoor will be stored on the server
			file_put_contents($img_file, $content);
			
			//update filename into table
			$sql_update = "UPDATE ja_laporan SET gambar_lapor= '$file_gambar' where id='$id'";
												
			$JsonSystem->executeOperation($sql_update);
			
			/*****************************************************************************************************************************/
			
			if($gambar_siasatan != '')
			{
				$content_siasatan = base64_decode($gambar_siasatan);
					
					$size = getImageSizeFromString($content_siasatan);

					// Check the MIME type to be sure that the binary data is an image
					if (empty($size['mime']) || strpos($size['mime'], 'image/') !== 0) {
					  $output_file = "Image value not valid";
					  die('Base64 value is not a valid image');
						
					}

					$directoryNameSiasatan = "jejakasnaf/gambar_siasatan/";
					
					if(!is_dir($directoryNameSiasatan)){
					//Directory does not exist, so lets create it.
					mkdir($directoryNameSiasatan, 0755);
					}
					
					// Specify the location where you want to save the image
					$img_file_siasatan = $directoryNameSiasatan.$file_gambar_siasatan;
					
					// Save binary data as raw data (that is, it will not remove metadata or invalid contents)
					// In this case, the PHP backdoor will be stored on the server
					file_put_contents($img_file_siasatan, $content_siasatan);
					
					//update filename into table
					$sql_update_siastan = "UPDATE ja_laporan SET siasatan_gambar= '$file_gambar_siasatan' where id='$id'";
														
					$JsonSystem->executeOperation($sql_update_siastan);
					
					/*****************************************************************************************************************************/
					
				$output_to_send = "1-Maklumat asnaf berjaya dikemaskini!";	
			}
			else
			{
				$output_to_send = "1-Maklumat asnaf berjaya dikemaskini!";	
			}
	}
	else
	{
		if($gambar_siasatan != '')
		{
			$content_siasatan = base64_decode($gambar_siasatan);
				
				$size = getImageSizeFromString($content_siasatan);

				// Check the MIME type to be sure that the binary data is an image
				if (empty($size['mime']) || strpos($size['mime'], 'image/') !== 0) {
				  $output_file = "Image value not valid";
				  die('Base64 value is not a valid image');
					
				}

				$directoryNameSiasatan = "jejakasnaf/gambar_siasatan/";
				
				if(!is_dir($directoryNameSiasatan)){
				//Directory does not exist, so lets create it.
				mkdir($directoryNameSiasatan, 0755);
				}
				
				// Specify the location where you want to save the image
				$img_file_siasatan = $directoryNameSiasatan.$file_gambar_siasatan;
				
				// Save binary data as raw data (that is, it will not remove metadata or invalid contents)
				// In this case, the PHP backdoor will be stored on the server
				file_put_contents($img_file_siasatan, $content_siasatan);
				
				//update filename into table
				$sql_update_siastan = "UPDATE ja_laporan SET siasatan_gambar= '$file_gambar_siasatan' where id='$id'";
													
				$JsonSystem->executeOperation($sql_update_siastan);
				
				/*****************************************************************************************************************************/
				
			$output_to_send = "1-Maklumat asnaf berjaya dikemaskini!";	
		}
		else
		{
			$output_to_send = "1-Maklumat asnaf berjaya dikemaskini!";
		}	
	}
	
	
	
		
	break;
	
	case '23'://kemaskini profil - KEMASKINI
	
	$id = $JsonSystem->getGETPOST('id');
	$acc_type = $JsonSystem->getGETPOST('acc_type');
	$notel = $JsonSystem->getGETPOST('notel');
	$emel = $JsonSystem->getGETPOST('emel');
	$katalaluan = $JsonSystem->getGETPOST('katalaluan');
	
	$table ="";
	
	if($acc_type == 'PUBLIC')
	{
		$table ="ja_pelapor";
	}else
	{
		$table ="ja_admin";
	}
	
	$sql = "UPDATE $table SET notel= '$notel',emel = '$emel',katalaluan = '$katalaluan' where id='$id'";
												
	$JsonSystem->executeOperation($sql);
			
	$output_to_send = "1-Kemaskini profil berjaya!";	
		
	break;
	
	
	case '24': //sejarah bantuan
	
	$nokp_asnaf = $JsonSystem->getGETPOST('nokp');
	
	$sql = "SELECT * FROM ja_bantuan jb WHERE jb.nokp='$nokp_asnaf'";
			
	$output = $JsonSystem->getJSONData($sql,'',null);
			
	$output_to_send = "[{$output}]";
	
	break;

	case '25': //update password -forgot password
	
	$emel = $JsonSystem->getGETPOST('emel');
	$katalaluan = $JsonSystem->getGETPOST('katalaluan');
	
	$sql = "UPDATE ja_pelapor SET katalaluan = '$katalaluan' where emel='$emel'";
												
	$JsonSystem->executeOperation($sql);
			
	$output_to_send = "1-Kata laluan baru anda berjaya dikemaskini!";
	
	break;	
	
	
	case '26'://check registered email
	
	$email = $JsonSystem->getGETPOST('email');
	$password = $JsonSystem->getGETPOST('password');
	
	$sql = "SELECT jp.nama,jp.id_pengguna,c.email FROM ja_pelapor jp,company c WHERE jp.emel='$email'";
			
	$result = $connjson->query($sql);
		
		if($result->num_rows > 0)//ada data
		{
			$sql1 = $JsonSystem->getData($sql);
								
			$nama = $sql1[0];
			$id_pengguna = $sql1[1];
			$sender = $sql1[2];
			
			$receiver = $email;
	    
	// Subject of email
	    	$subject = "JejakAsnaf::Kod Pengesahan";
	    
	    	// Design of the email
	    	$design = "<html><head><title></title></head><body>
	    	Assalamu'alaikum w.b.t,<br><br>
			Sila masukkan kod pengesahan dibawah dengan menggunakan aplikasi JejakAsnaf bagi tujuan mengemaskini katalaluan baru anda:<br><br>
			Maklumat akaun anda adalah seperti berikut : <br>
			Nama : $nama <br>
			ID Pengguna : $id_pengguna <br>
			Kod Pengesahan : $password <br>";

			"<br><br>Sekian,terima kasih.
			<br><br>JejakAsnaf</body></html>";
			
	    	// Headers
	    	$headers = "From: $sender\n"; // From address
	    	//$headers .= "Reply-To: $replyto\n"; // Reply-to address
	    	$headers .= "Organization: Some organisation\n"; // Organisation
	    	$headers .= "Content-Type: text/html; charset=iso-8859-1\n"; // Type
	    	//$name = "$list(reciever)";
	    	mail($receiver, $subject, $design, $headers); 
			
			$output_to_send = "1-Kod pengesahan telah dihantar ke alamat ".$email.". Sila semak dan kemaskini katalaluan anda.";		
		}
		else
		{
			$output_to_send = "0-Emel tidak wujud.Sila rujuk pihak pengurusan bagi tujuan semakan.";
		}
	
	break;

}

// Closing connection
mysqli_close($conn);
echo $output_to_send;



?>