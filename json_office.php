<?php
//phpinfo();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header('Content-type: application/json');

require_once('lib/json.inc');

error_log('json_office.php');
error_reporting(E_ALL);
ini_set("display_errors", 0);

$JsonSystem = new Json();

$cmd = $JsonSystem->getGETPOST('cmd');

$output = '';
$output_to_send = '';
switch($cmd) {
	
	case '1'://Login
	    $nama = $JsonSystem->getGETPOST('username');
	    $pwd = $JsonSystem->getGETPOST('password');
		
		$sql ="SELECT s.id, s.no_staff, s.noic, s.name, s.username, 
		s.accs_pwd, s.phone, s.email, s.alamat_tetap, s.alamat_surat,s.jawatan_code, s.role_id, s.department_id,d.description AS jabatan, 
		s.company_id,s.`status`,s.cawangan_kod,c.`sys_name`,c.`sys_domain` ,s.status_qrcode,s.status_swafoto,s.status_tag
		FROM staff s,company b,sys_setting c,department d
		WHERE s.company_id=b.id AND b.`sys_id`=c.`sys_id` AND s.department_id=d.code_department AND b.status='1' 
		AND s.status='BEKERJA' 
		AND s.username='1' AND s.accs_pwd='1'";
		
		$output = $JsonSystem->getJSONData($sql,'',null);
		
		$output_to_send = null;
	break;
	
	case '2'://check status BEKERJA/TIDAK
	
		$id = $JsonSystem->getGETPOST('id');
		
		$sql="select status FROM staff where id ='88888888'";
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	//update attendance masuk
	case '3':
	    $nokp = $JsonSystem->getGETPOST('noic');
	    $lokasi = $JsonSystem->getGETPOST('lokasi');
		$cawangan_kod = $JsonSystem->getGETPOST('cawangan_kod');
		$nama_cawangan = $JsonSystem->getGETPOST('nama_cawangan');
		$no_staff = $JsonSystem->getGETPOST('no_staff');
	    
	    $koor = explode(",", $lokasi);
	    $latitude = $koor[0];
	    $longitude = $koor[1];
	    
	    //check nearest location
		/*$objectQuery = "SELECT *, ((acos(sin((" . $latitude . "*pi()/180)) 
		* sin((`latitude`*pi()/180))+cos((" . $latitude . "*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((" . $longitude . "- `longitude`)*
		pi()/180))))*180/pi())*60*1.1515*1.609344  as distance FROM `lkp_location` HAVING distance <='0.1' ORDER BY distance asc";*/
		
		if($latitude == '0' && $longitude == '0')
		{
			$output_to_send = "Koordinat tidak sah.";
		}
		else
		{
				//in km  //distance = 0.5 = 500 metres
			$earth_radius = 6371;
			/*$objectQuery = "SELECT *, (".$earth_radius." * acos (
							  cos ( radians(".$latitude.") )
							  * cos( radians( `latitude` ) )
							  * cos( radians( `longitude` ) - radians(".$longitude.") )
							  + sin ( radians(".$latitude.") )
							  * sin( radians( `latitude` ) )
							)
						) AS distance
						FROM `lkp_location`
						HAVING distance < 0.5 
						AND `name`='$nama_cawangan' AND `cawangan_kod`='$cawangan_kod'
						ORDER BY distance";*/
						
			$objectQuery = "SELECT *, (".$earth_radius." * acos (
								  cos ( radians(".$latitude.") )
								  * cos( radians( `latitude` ) )
								  * cos( radians( `longitude` ) - radians(".$longitude.") )
								  + sin ( radians(".$latitude.") )
								  * sin( radians( `latitude` ) )
								)
							) AS distance
							FROM `lkp_location`
							HAVING distance < 1.5 
							ORDER BY distance ASC LIMIT 1";
			
			$remark_lokasi = $JsonSystem->getData($objectQuery);
			
			$remark_lokasi=$remark_lokasi[1];
			
			if($remark_lokasi == ""){
				$remark_lokasi = "LUAR KAWASAN";
			}
			
			//$masa = $JsonSystem->getData("SELECT masa_bekerja FROM masa_bekerja where shift_code = (select shift_kerja from staff where noic='$nokp' AND status = 'BEKERJA')");
			$masa = $JsonSystem->getData("SELECT masa_bekerja FROM masa_bekerja where shift_code = (select shift_kerja from tarikh_bekerja where no_staff='$no_staff' AND tarikh = CURRENT_DATE())");
			$masa_bekerja=$masa[0];
			
			$sql ="SELECT MAX(mk.id) AS id FROM masa_kehadiran mk
			LEFT JOIN kehadiran k ON mk.id_kehadiran=k.id
			WHERE DATE_FORMAT(mk.masa_masuk,'%Y-%m-%d') NOT IN(DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')) AND k.nokp_staff='$nokp'";
			
			$id=$connjson->query($sql)->fetch_object()->id;
			
			$sql2= "SELECT IFNULL(MAX(id),0) AS id,masa_masuk,id_kehadiran FROM masa_kehadiran
				WHERE id='$id' AND masa_keluar IS NULL";
			
			$id_mk=$connjson->query($sql2)->fetch_object()->id;
			$id_kehadiran=$connjson->query($sql2)->fetch_object()->id_kehadiran;
			
			if($id_mk > 0)//ada data
			{
				$masa_masuk=$connjson->query($sql2)->fetch_object()->masa_masuk;
				$tarikh_masuk = date('Y-m-d',strtotime($masa_masuk));
				$masa_mk = $tarikh_masuk." ".$masa_bekerja;
				$masa_keluar = date('Y-m-d H:i:s',strtotime('+9 hour',strtotime($masa_mk)));
				
				if($masa_masuk > $masa_keluar)
				{
					$sql3 = "UPDATE masa_kehadiran SET masa_keluar='$masa_masuk', total_time=TIMEDIFF('$masa_masuk',masa_masuk),
						lokasi_keluar='0.0,0.0',remark_keluar='TIADA IMBASAN KELUAR',device_keluar='AUTO' where id='$id_mk'";
				}
				else
				{
					$sql3 = "UPDATE masa_kehadiran SET masa_keluar='$masa_keluar', total_time=TIMEDIFF('$masa_keluar',masa_masuk),
						lokasi_keluar='0.0,0.0',remark_keluar='TIADA IMBASAN KELUAR',device_keluar='AUTO' where id='$id_mk'";
				}
									
				$output = $JsonSystem->executeOperation2($sql3);
				
				//update status availability kehadiran
				$sql10 = "UPDATE kehadiran SET availability='KELUAR' where id='$id_kehadiran'";
				$JsonSystem->executeOperation2($sql10);
				
			}
			
			$sql8 ="SELECT MAX(mk.id) AS id , mk.masa_masuk FROM masa_kehadiran mk
			LEFT JOIN kehadiran k ON mk.id_kehadiran=k.id
			WHERE DATE_FORMAT(mk.masa_masuk,'%Y-%m-%d') = (DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')) AND k.nokp_staff='$nokp'
			AND mk.masa_keluar IS NULL";
			
			$current_id=$connjson->query($sql8)->fetch_object()->id;
			if($current_id > 0)//ada data
			{
				$sql9 = "UPDATE masa_kehadiran SET masa_keluar=CURRENT_TIMESTAMP, total_time=TIMEDIFF(CURRENT_TIMESTAMP,masa_masuk),
						lokasi_keluar='$lokasi',remark_keluar='$remark_lokasi',device_keluar='MOBILE-IMBASANQR' where id='$current_id'";
						
						$JsonSystem->executeOperation2($sql9);
			}
			

			$sql4 = "SELECT IFNULL(id,0) AS id FROM  kehadiran WHERE nokp_staff='$nokp' 
			AND DATE_FORMAT(created_date,'%d-%m-%Y')=DATE_FORMAT(CURRENT_TIMESTAMP,'%d-%m-%Y')";

			$_checkId = $JsonSystem->getData($sql4);
			$checkId = $_checkId[0];
			$newid = "0";
			if($checkId>0){
			$sql5 = "INSERT INTO masa_kehadiran (id_kehadiran,masa_masuk,lokasi_masuk,remark_masuk,device_masuk,created_by) VALUES ('$checkId',CURRENT_TIMESTAMP,'$lokasi','$remark_lokasi','MOBILE-IMBASANQR','$no_staff')";

			$newid = $JsonSystem->executeOperation2($sql5);
			
			//update status availability kehadiran
				$sql11 = "UPDATE kehadiran SET availability='MASUK' where id='$checkId'";
				$JsonSystem->executeOperation2($sql11);
				
			}else{
				
			$sql_staff = "SELECT s.no_staff FROM staff s WHERE s.noic = '$nokp' AND s.`status` = 'BEKERJA'";
			$_checkNoStaff = $JsonSystem->getData($sql_staff);
			$checkNoStaff = $_checkNoStaff[0];
			
				
			$sql6 = "INSERT INTO kehadiran (status_kehadiran, lokasi,nokp_staff,remark_lokasi,latitude,longitude,cawangan_kod,availability,no_staff) 
					VALUES (
					(
							SELECT CASE 
							WHEN TIME_TO_SEC(DATE_FORMAT(CURRENT_TIMESTAMP,'%H:%i')) = TIME_TO_SEC('$masa_bekerja') THEN 'TEPAT' 
							WHEN TIME_TO_SEC(DATE_FORMAT(CURRENT_TIMESTAMP,'%H:%i')) > TIME_TO_SEC('$masa_bekerja') THEN 'LEWAT' 
							ELSE 'AWAL' END
					)
					, '$lokasi', '$nokp','$remark_lokasi','$latitude','$longitude','$cawangan_kod','MASUK','$checkNoStaff')";
					
			$newid = $JsonSystem->executeOperation2($sql6);
			
			$sql7 = "INSERT INTO masa_kehadiran (id_kehadiran,masa_masuk,lokasi_masuk,remark_masuk,device_masuk,created_by) 
					VALUES ('$newid',CURRENT_TIMESTAMP,'$lokasi','$remark_lokasi','MOBILE-IMBASANQR','$no_staff')";
					
			$newid = $JsonSystem->executeOperation2($sql7);
			}
			
			$output2 = $JsonSystem->getJSONData("SELECT DATE_FORMAT(m.masa_masuk,'%r') AS masa_masuk,
			m.lokasi_masuk FROM masa_kehadiran m WHERE m.id='{$newid}'",'',null);
			
			$output_to_send = "[{$output2}]";
		}
		
	break;
	
	//update attendance keluar
	case '4':
	    $nokp = $JsonSystem->getGETPOST('noic');
	    $lokasi = $JsonSystem->getGETPOST('lokasi');
		$cawangan_kod = $JsonSystem->getGETPOST('cawangan_kod');
		$nama_cawangan = $JsonSystem->getGETPOST('nama_cawangan');
	    
	    $koor = explode(",", $lokasi);
	    $latitude = $koor[0];
	    $longitude = $koor[1];
	    
	    //check nearest location
		/*$objectQuery = "SELECT *, ((acos(sin((" . $latitude . "*pi()/180)) 
		* sin((`latitude`*pi()/180))+cos((" . $latitude . "*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((" . $longitude . "- `longitude`)*
		pi()/180))))*180/pi())*60*1.1515*1.609344  as distance FROM `lkp_location` HAVING distance <='0.1' ORDER BY distance asc";*/
		
		if($latitude == '0' && $longitude == '0')
		{
			$output_to_send = "Koordinat tidak sah.";
		}
		else
		{
				//in km  //distance = 0.5 = 500 metres
			$earth_radius = 6371;
			/*$objectQuery = "SELECT *, (".$earth_radius." * acos (
							  cos ( radians(".$latitude.") )
							  * cos( radians( `latitude` ) )
							  * cos( radians( `longitude` ) - radians(".$longitude.") )
							  + sin ( radians(".$latitude.") )
							  * sin( radians( `latitude` ) )
							)
						) AS distance
						FROM `lkp_location`
						HAVING distance < 0.5 
						AND `name`='$nama_cawangan' AND `cawangan_kod`='$cawangan_kod'
						ORDER BY distance";*/
						
			$objectQuery = "SELECT *, (".$earth_radius." * acos (
								  cos ( radians(".$latitude.") )
								  * cos( radians( `latitude` ) )
								  * cos( radians( `longitude` ) - radians(".$longitude.") )
								  + sin ( radians(".$latitude.") )
								  * sin( radians( `latitude` ) )
								)
							) AS distance
							FROM `lkp_location`
							HAVING distance < 1.5 
							ORDER BY distance ASC LIMIT 1";
			
			$remark_lokasi = $JsonSystem->getData($objectQuery);
			$remark_lokasi=$remark_lokasi[1];
			if($remark_lokasi == ""){
				$remark_lokasi = "LUAR KAWASAN";
			}
			
			$output2 ="";
			$sql1 ="SELECT IFNULL(max(k.id),0) AS id 
						FROM kehadiran k
						LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
						WHERE nokp_staff='$nokp' AND m.masa_keluar IS NULL ";
			
			/*$sql1 = "SELECT IFNULL(id,0) AS id FROM  kehadiran WHERE nokp_staff='$nokp' 
				AND DATE_FORMAT(created_date,'%d-%m-%Y')=DATE_FORMAT(CURRENT_TIMESTAMP,'%d-%m-%Y')";*/
				
			$_checkId = $JsonSystem->getData($sql1);
			$checkId = $_checkId[0];
			
			
			if($checkId>0){
				$sql3 = "SELECT id FROM masa_kehadiran WHERE id_kehadiran='$checkId' AND masa_keluar IS NULL 
				AND id = (SELECT MAX(id) AS id FROM masa_kehadiran WHERE id_kehadiran='$checkId') ";
				
				$masa_res = $connjson->query($sql3);
				$masa_id = "0";
				if($masa_res->num_rows > 0)//ada data
				{
					$masa_id=$masa_res -> fetch_object()->id;
					
					if($masa_id>0){
						
						$sql_staff = "SELECT s.no_staff FROM staff s WHERE s.noic = '$nokp' AND s.`status` = 'BEKERJA'";
						$_checkNoStaff = $JsonSystem->getData($sql_staff);
						$checkNoStaff = $_checkNoStaff[0];
						
						
						$sql4 = "UPDATE masa_kehadiran SET masa_keluar=CURRENT_TIMESTAMP, total_time=TIMEDIFF(CURRENT_TIMESTAMP,masa_masuk),
						lokasi_keluar='$lokasi',remark_keluar='$remark_lokasi',device_keluar='MOBILE-IMBASANQR' where id='$masa_id' ";
						$JsonSystem->executeOperation($sql4);
						
						//update status availability kehadiran
						$sql6 = "UPDATE kehadiran SET availability='KELUAR',no_staff='$checkNoStaff' where id='$checkId'";
						$JsonSystem->executeOperation2($sql6);
						
					}
					//}
					$sql5 = "SELECT DATE_FORMAT(m.masa_keluar,'%r') AS masa_keluar,
					m.lokasi_keluar FROM masa_kehadiran m WHERE m.id='{$masa_id}'";
					
					$output2 = $JsonSystem->getJSONData($sql5,'',null);
					$output_to_send = "[{$output2}]";
				}
				else
				{
					$output_to_send = "[]";
				}
			}
		}
		
	break;
	
	case '5'://update kemaskini info
	    $id = $JsonSystem->getGETPOST('id');
		$accs_pwd = $JsonSystem->getGETPOST('accs_pwd');
		$phone = $JsonSystem->getGETPOST('phone');
		
		$sql = "UPDATE staff SET accs_pwd='$accs_pwd', phone='$phone' WHERE id='$id'";
            		
		$output = $JsonSystem->executeOperation($sql);
	break;
	
	case '6'://select department
		
		// $sql = "SELECT d.code_department FROM department d WHERE 
		// d.code_department NOT IN('ADMIN','SUPERADMIN') AND 
		// d.`status` = '1' ORDER BY d.code_department ASC";
		
		$sql = "SELECT d.code_department FROM department d WHERE
		d.`status` = '1' ORDER BY d.code_department ASC";
            		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
		
	break;
	
	case '7'://select cawangan
		
		/*$cawangan = $JsonSystem->getGETPOST('cawangan');
		
		if($cawangan != 'HQ')
		{
			$sql ="SELECT c.nama FROM lkp_cawangan c WHERE c.cawangan_kod ='$cawangan'";
			$nama = $JsonSystem->getData($sql);
			$output = $nama[0];
			
			$output_to_send = '[{"nama":"'.$output.'"}]';
     	}
		else
		{
			$sql = "SELECT c.nama FROM lkp_cawangan c ORDER BY c.nama ASC";
			$output = $JsonSystem->getJSONData($sql,'',null);
			$output_to_send = "[{$output}]";
		}*/
		
		$sql = "SELECT c.nama FROM lkp_cawangan c ORDER BY c.nama ASC";
			$output = $JsonSystem->getJSONData($sql,'',null);
			$output_to_send = "[{$output}]";
		
	break;
	
	case '8'://SELECT DIREKTORI KAKITANGAN
		$cawangan = $JsonSystem->getGETPOST('cawangan');
		$department = $JsonSystem->getGETPOST('department');
		$query = $JsonSystem->getGETPOST('query');
		
		if($query != '')
		{
			$sql = "SELECT s.id,s.no_staff,s.noic,s.`name`,s.phone,r.`role` AS department_id
					FROM staff s LEFT JOIN role r ON r.`code` = s.role_id 
					WHERE s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
					AND s.department_id = '$department' AND s.status = 'BEKERJA' AND (s.`name` LIKE '%$query%') 
					AND s.role_id NOT IN ('ADMIN','SUPERADMIN') ORDER BY s.`name` ASC";
		}
		else
		{
			$sql = "SELECT s.id,s.no_staff,s.noic,s.`name`,s.phone,r.`role` AS department_id FROM staff s 
					LEFT JOIN role r ON r.`code` = s.role_id
					WHERE s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
					AND s.department_id = '$department' AND s.status = 'BEKERJA' AND s.role_id NOT IN ('ADMIN','SUPERADMIN')
					ORDER BY s.`name` ASC";
		}
		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
		
	break;
	
	/*GEOLOCATION - gps address location*/
	case '9':
	
	$lat = $JsonSystem->getGETPOST('lat');
	$lng = $JsonSystem->getGETPOST('lng'); 
	  
	$geocode = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$lat.",".$lng."&sensor=false&key=AIzaSyBLTdGQxl-f5ARZpMAIVrzSZepLf7TjNis";
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
            $address = 'Not Found';

        }
    } else {
        $address = 'Not Found';
    }

    //echo $address;
	$output_to_send = '[{"address":"'.$address.'"}]';
	
	break;
	
	case '10'://select ppk
		
		//$sql = "SELECT a.kod_ppk,a.nama_ppk FROM lkp_ppk a ORDER BY kod_ppk ASC";
		$sql = "SELECT p.kod_ppk,a.nama_ppk FROM pengusaha p 
				LEFT JOIN lkp_ppk a ON a.kod_ppk = p.kod_ppk
				GROUP BY p.kod_ppk ORDER BY p.kod_ppk ASC";
            		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '11'://SELECT DIREKTORI PENGUSAHA
		$pkj = $JsonSystem->getGETPOST('pkj');
		$ppk = $JsonSystem->getGETPOST('ppk');
		$query = $JsonSystem->getGETPOST('query');
		
		if($query != '')
		{
			$sql = "SELECT p.id_pengusaha,p.nokp,p.nama,p.notel,p.koordinat FROM pengusaha p 
			WHERE p.kod_ppk = (SELECT a.kod_ppk FROM lkp_ppk a WHERE a.kod_ppk = '$ppk' AND a.kod_pkj='$pkj')  
			AND p.status_pengusaha = '1' 
			AND (p.nama LIKE '%$query%' OR p.nokp LIKE '%$query%') ORDER BY p.nama ASC"; 
		}
		else
		{
			$sql = "SELECT p.id_pengusaha,p.nokp,p.nama,p.notel,p.koordinat FROM pengusaha p 
			WHERE p.kod_ppk = (SELECT a.kod_ppk FROM lkp_ppk a WHERE a.kod_ppk = '$ppk' AND a.kod_pkj='$pkj') 
			AND p.status_pengusaha = '1' ORDER BY p.nama ASC";
		}
		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
		
	break;
	
	case '12'://select pkj
		
		$sql = "SELECT a.kod_jajahan,a.nama_pkj FROM lkp_jajahan a 
		GROUP BY a.kod_jajahan ORDER BY a.nama_pkj ASC";
            		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '13'://select kehadiran bulan semasa
	
		$nokp = $JsonSystem->getGETPOST('nokp');
		$month = $JsonSystem->getGETPOST('month');
		
		if($month == '')
		{
		$detail ="SELECT s.no_staff,s.noic,s.`name` FROM staff s WHERE s.noic = '$nokp' AND s.`status` ='BEKERJA' ";
		
		$_detail = $JsonSystem->getData($detail);
		$output_no_staff = $_detail[0];
		$output_noic = $_detail[1];
		$output_name = $_detail[2];
		
		
		$awal = "SELECT COUNT(*) AS bil_awal FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic 
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND k.nokp_staff ='$nokp' AND k.status_kehadiran='AWAL'
				AND DATE_FORMAT(k.created_date,'%Y-%m')= DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')";
				
				$_awal = $JsonSystem->getData($awal);
				$output_awal = $_awal[0];
				
		$tepat = "SELECT COUNT(*) AS bil_tepat FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic 
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND k.nokp_staff ='$nokp' AND k.status_kehadiran='TEPAT'
				AND DATE_FORMAT(k.created_date,'%Y-%m')= DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')";
				
				$_tepat = $JsonSystem->getData($tepat);
				$output_tepat = $_tepat[0];
				
		$lewat = "SELECT COUNT(*) AS bil_lewat FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic 
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND k.nokp_staff ='$nokp' AND k.status_kehadiran='LEWAT'
				AND DATE_FORMAT(k.created_date,'%Y-%m')= DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')";
				
				$_lewat = $JsonSystem->getData($lewat);
				$output_lewat = $_lewat[0];
				
		$hari_bekerja = "SELECT COUNT(*) AS jum_bekerja FROM tarikh_bekerja a WHERE a.`status`='1' 
				AND a.sys_id= (SELECT c.sys_id FROM company c
				LEFT JOIN staff s ON c.id=s.company_id
				WHERE s.noic = '$nokp' AND s.status='BEKERJA') AND 
				a.no_staff=(SELECT no_staff FROM staff WHERE noic = '$nokp' AND status='BEKERJA')
				AND DATE_FORMAT(a.tarikh,'%Y-%m')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')";
				
				$_hari_bekerja = $JsonSystem->getData($hari_bekerja);
				$output_hari_bekerja = $_hari_bekerja[0];
		}
		else
		{
		
		$current_year = date('Y');
		
		$year_month = $current_year."-".$month;
		
		$detail ="SELECT s.no_staff,s.noic,s.`name` FROM staff s WHERE s.noic = '$nokp' AND s.`status`='BEKERJA'";
		
		$_detail = $JsonSystem->getData($detail);
		$output_no_staff = $_detail[0];
		$output_noic = $_detail[1];
		$output_name = $_detail[2];
		
		
		$awal = "SELECT COUNT(*) AS bil_awal FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic 
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND k.nokp_staff ='$nokp' AND k.status_kehadiran='AWAL'
				AND DATE_FORMAT(k.created_date,'%Y-%M')='$year_month'";
				
				$_awal = $JsonSystem->getData($awal);
				$output_awal = $_awal[0];
				
		$tepat = "SELECT COUNT(*) AS bil_tepat FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic 
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND k.nokp_staff ='$nokp' AND k.status_kehadiran='TEPAT'
				AND DATE_FORMAT(k.created_date,'%Y-%M')='$year_month'";
				
				$_tepat = $JsonSystem->getData($tepat);
				$output_tepat = $_tepat[0];
				
		$lewat = "SELECT COUNT(*) AS bil_lewat FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic 
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND k.nokp_staff ='$nokp' AND k.status_kehadiran='LEWAT'
				AND DATE_FORMAT(k.created_date,'%Y-%M')='$year_month'";
				
				$_lewat = $JsonSystem->getData($lewat);
				$output_lewat = $_lewat[0];
				
		$hari_bekerja = "SELECT COUNT(*) AS jum_bekerja FROM tarikh_bekerja a WHERE a.`status`='1' 
				AND a.sys_id= (SELECT c.sys_id FROM company c
				LEFT JOIN staff s ON c.id=s.company_id
				WHERE s.noic = '$nokp' AND s.status='BEKERJA' ) AND 
				a.no_staff=(SELECT no_staff FROM staff WHERE noic = '$nokp' AND status='BEKERJA')
				AND DATE_FORMAT(a.tarikh,'%Y-%M')='$year_month'";
				
				$_hari_bekerja = $JsonSystem->getData($hari_bekerja);
				$output_hari_bekerja = $_hari_bekerja[0];
		}
		
		
		$output_jum_hadir = '';
		$output_jum_hadir = $output_awal + $output_tepat + $output_lewat;
		
		$output_percent_kehadiran = '';
		if($output_jum_hadir > 0)
		{
			//kira percent
			$output_percent_kehadiran = Round(($output_jum_hadir / $output_hari_bekerja) * 100,0);
		}
		else
		{
			//takde percent
			$output_percent_kehadiran = 0;
		}
		
		$output_to_send = '[{"nama":"'.$output_name.'","noic":"'.$output_noic.'","no_staff":"'.$output_no_staff.'","bil_awal":"'.$output_awal.'","bil_tepat":"'.$output_tepat.'","bil_lewat":"'.$output_lewat.'","jum_hari_bekerja":"'.$output_hari_bekerja.'","jum_hadir":"'.$output_jum_hadir.'","percent_hadir":"'.$output_percent_kehadiran.'%"}]';
		
	break;
	
	case '14'://select log kehadiran bulan semasa
	
		$nokp = $JsonSystem->getGETPOST('nokp');
		$month = $JsonSystem->getGETPOST('month');
		
		$current_year = date('Y');
		
		$year_month = $current_year."-".$month;
		
		$sql = "SELECT DATE_FORMAT(k.created_date,'%d-%m-%Y') AS tarikh,
				DATE_FORMAT(k.created_date,'%W') AS hari,
				DATE_FORMAT(MIN(m.masa_masuk),'%d-%m-%Y  %r') AS masa_masuk,
				IFNULL(DATE_FORMAT(MAX(m.masa_keluar),'%d-%m-%Y  %r'),'BELUM LOG') AS masa_keluar,
				k.status_kehadiran,
				(SELECT CASE WHEN TIME_TO_SEC(TIMEDIFF(MAX(DATE_FORMAT(m.masa_keluar,'%H:%i:%s')),MIN(DATE_FORMAT(m.masa_masuk,'%H:%i:%s'))))-SUM(TIME_TO_SEC(total_time)) > TIME_TO_SEC(s.jum_jam_break) 
				THEN IFNULL(SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))),'00:00:00') 
				ELSE IFNULL(SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))-(TIME_TO_SEC(s.jum_jam_break)-(TIME_TO_SEC(TIMEDIFF(MAX(DATE_FORMAT(m.masa_keluar,'%H:%i:%s')),MIN(DATE_FORMAT(m.masa_masuk,'%H:%i:%s'))))-SUM(TIME_TO_SEC(total_time))))),'00:00:00') END) AS jam_bekerja,
				m.remark_masuk, IFNULL(m.remark_keluar,'-') AS remark_keluar,IFNULL(k.sebab_kelewatan,'-') AS sebab_kelewatan
				FROM masa_kehadiran m 
				LEFT JOIN kehadiran k ON k.id=m.id_kehadiran
				LEFT JOIN staff s ON k.nokp_staff=s.noic
				WHERE k.nokp_staff = '$nokp' AND 
				DATE_FORMAT(k.created_date,'%Y-%M')='$year_month' 
				GROUP BY m.id_kehadiran ORDER BY k.created_date DESC";
				
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	//update tag masuk
	case '15':
	    $nokp = $JsonSystem->getGETPOST('noic');
	    $lokasi = $JsonSystem->getGETPOST('lokasi');
		$cawangan_kod = $JsonSystem->getGETPOST('cawangan_kod');
		$no_staff = $JsonSystem->getGETPOST('no_staff');
	    
	    $koor = explode(",", $lokasi);
	    $latitude = $koor[0];
	    $longitude = $koor[1];
	    
	    //check nearest location
		/*$objectQuery = "SELECT *, ((acos(sin((" . $latitude . "*pi()/180)) 
		* sin((`latitude`*pi()/180))+cos((" . $latitude . "*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((" . $longitude . "- `longitude`)*
		pi()/180))))*180/pi())*60*1.1515*1.609344  as distance FROM `lkp_location` HAVING distance <='0.1' ORDER BY distance asc";*/
		if($latitude == '0' && $longitude == '0')
		{
			$output_to_send = "Koordinat tidak sah.";
		}
		else
		{
				//in km  //distance = 0.5 = 500 metres
			$earth_radius = 6371;
			$objectQuery = "SELECT *, (".$earth_radius." * acos (
							  cos ( radians(".$latitude.") )
							  * cos( radians( `latitude` ) )
							  * cos( radians( `longitude` ) - radians(".$longitude.") )
							  + sin ( radians(".$latitude.") )
							  * sin( radians( `latitude` ) )
							)
						) AS distance
						FROM `staff_outstation`
						HAVING distance < 1.5 
						AND `nokp_staff`='$nokp'
						ORDER BY distance";
						
			$remark_lokasi = $JsonSystem->getData($objectQuery);
			$remark_lokasi=$remark_lokasi[2];
			
			if($remark_lokasi == ""){
				$remark_lokasi = "LUAR KAWASAN";
			}
			
			//$masa = $JsonSystem->getData("SELECT masa_bekerja FROM masa_bekerja where shift_code = (select shift_kerja from staff where noic='$nokp' AND status = 'BEKERJA')");
			$masa = $JsonSystem->getData("SELECT masa_bekerja FROM masa_bekerja where shift_code = (select shift_kerja from tarikh_bekerja where no_staff='$no_staff' AND tarikh = CURRENT_DATE())");
			$masa_bekerja=$masa[0];
			
			$sql ="SELECT MAX(mk.id) AS id FROM masa_kehadiran mk
			LEFT JOIN kehadiran k ON mk.id_kehadiran=k.id
			WHERE DATE_FORMAT(mk.masa_masuk,'%Y-%m-%d') NOT IN(DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')) AND k.nokp_staff='$nokp'";
			
			$id=$connjson->query($sql)->fetch_object()->id;
			
			$sql2= "SELECT IFNULL(MAX(id),0) AS id,masa_masuk,id_kehadiran FROM masa_kehadiran
				WHERE id='$id' AND masa_keluar IS NULL";
			
			$id_mk=$connjson->query($sql2)->fetch_object()->id;
			$id_kehadiran=$connjson->query($sql2)->fetch_object()->id_kehadiran;
			
			if($id_mk > 0)//ada data
			{
				$masa_masuk=$connjson->query($sql2)->fetch_object()->masa_masuk;
				$tarikh_masuk = date('Y-m-d',strtotime($masa_masuk));
				$masa_mk = $tarikh_masuk." ".$masa_bekerja;
				$masa_keluar = date('Y-m-d H:i:s',strtotime('+9 hour',strtotime($masa_mk)));
				
				if($masa_masuk > $masa_keluar)
				{
					$sql3 = "UPDATE masa_kehadiran SET masa_keluar='$masa_masuk', total_time=TIMEDIFF('$masa_masuk',masa_masuk),
						lokasi_keluar='0.0,0.0',remark_keluar='TIADA IMBASAN KELUAR',device_keluar='AUTO' where id='$id_mk'";
				}
				else
				{
					$sql3 = "UPDATE masa_kehadiran SET masa_keluar='$masa_keluar', total_time=TIMEDIFF('$masa_keluar',masa_masuk),
						lokasi_keluar='0.0,0.0',remark_keluar='TIADA IMBASAN KELUAR',device_keluar='AUTO' where id='$id_mk'";
				}
									
				$output = $JsonSystem->executeOperation2($sql3);
				
				//update status availability kehadiran
				$sql10 = "UPDATE kehadiran SET availability='KELUAR' where id='$id_kehadiran'";
				$JsonSystem->executeOperation2($sql10);
				
			}
			
			$sql8 ="SELECT MAX(mk.id) AS id , mk.masa_masuk FROM masa_kehadiran mk
			LEFT JOIN kehadiran k ON mk.id_kehadiran=k.id
			WHERE DATE_FORMAT(mk.masa_masuk,'%Y-%m-%d') = (DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')) AND k.nokp_staff='$nokp'
			AND mk.masa_keluar IS NULL";
			
			$current_id=$connjson->query($sql8)->fetch_object()->id;
			if($current_id > 0)//ada data
			{
				$sql9 = "UPDATE masa_kehadiran SET masa_keluar=CURRENT_TIMESTAMP, total_time=TIMEDIFF(CURRENT_TIMESTAMP,masa_masuk),
						lokasi_keluar='$lokasi',remark_keluar='$remark_lokasi',device_keluar='MOBILE-TAGLOKASI' where id='$current_id'";
						
						$JsonSystem->executeOperation2($sql9);
			}
			
			$sql4 = "SELECT IFNULL(id,0) AS id FROM  kehadiran WHERE nokp_staff='$nokp' 
			AND DATE_FORMAT(created_date,'%d-%m-%Y')=DATE_FORMAT(CURRENT_TIMESTAMP,'%d-%m-%Y')";

			$_checkId = $JsonSystem->getData($sql4);
			$checkId = $_checkId[0];
			$newid = "0";
			if($checkId>0){
			$sql5 = "INSERT INTO masa_kehadiran (id_kehadiran,masa_masuk,lokasi_masuk,remark_masuk,device_masuk,created_by) VALUES ('$checkId',CURRENT_TIMESTAMP,'$lokasi','$remark_lokasi','MOBILE-TAGLOKASI','$no_staff')";

			$newid = $JsonSystem->executeOperation2($sql5);
			
			//update status availability kehadiran
				$sql11 = "UPDATE kehadiran SET availability='MASUK' where id='$checkId'";
				$JsonSystem->executeOperation2($sql11);
				
			}else{
				
			$sql_staff = "SELECT s.no_staff FROM staff s WHERE s.noic = '$nokp' AND s.`status` = 'BEKERJA'";
						$_checkNoStaff = $JsonSystem->getData($sql_staff);
						$checkNoStaff = $_checkNoStaff[0];
			
			$sql6 = "INSERT INTO kehadiran (status_kehadiran, lokasi,nokp_staff,remark_lokasi,latitude,longitude,cawangan_kod,availability,no_staff) 
					VALUES (
					(
							SELECT CASE 
							WHEN TIME_TO_SEC(DATE_FORMAT(CURRENT_TIMESTAMP,'%H:%i')) = TIME_TO_SEC('$masa_bekerja') THEN 'TEPAT' 
							WHEN TIME_TO_SEC(DATE_FORMAT(CURRENT_TIMESTAMP,'%H:%i')) > TIME_TO_SEC('$masa_bekerja') THEN 'LEWAT' 
							ELSE 'AWAL' END
					)
					, '$lokasi', '$nokp','$remark_lokasi','$latitude','$longitude','$cawangan_kod','MASUK','$checkNoStaff')";
					
			$newid = $JsonSystem->executeOperation2($sql6);
			
			$sql7 = "INSERT INTO masa_kehadiran (id_kehadiran,masa_masuk,lokasi_masuk,remark_masuk,device_masuk,created_by) 
					VALUES ('$newid',CURRENT_TIMESTAMP,'$lokasi','$remark_lokasi','MOBILE-TAGLOKASI','$no_staff')";
					
			$newid = $JsonSystem->executeOperation2($sql7);
			}
			
			$output2 = $JsonSystem->getJSONData("SELECT DATE_FORMAT(m.masa_masuk,'%r') AS masa_masuk,
			m.lokasi_masuk FROM masa_kehadiran m WHERE m.id='{$newid}'",'',null);
			
			$output_to_send = "[{$output2}]";
		}
		
	break;
	
	//update tag keluar
	case '16':
	    $nokp = $JsonSystem->getGETPOST('noic');
	    $lokasi = $JsonSystem->getGETPOST('lokasi');
	    
	    $koor = explode(",", $lokasi);
	    $latitude = $koor[0];
	    $longitude = $koor[1];
	    
	    //check nearest location
		/*$objectQuery = "SELECT *, ((acos(sin((" . $latitude . "*pi()/180)) 
		* sin((`latitude`*pi()/180))+cos((" . $latitude . "*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((" . $longitude . "- `longitude`)*
		pi()/180))))*180/pi())*60*1.1515*1.609344  as distance FROM `lkp_location` HAVING distance <='0.1' ORDER BY distance asc";*/
		if($latitude == '0' && $longitude == '0')
		{
			$output_to_send = "Koordinat tidak sah.";
		}
		else
		{
				//in km  //distance = 0.5 = 500 metres
			$earth_radius = 6371;
			$objectQuery = "SELECT *, (".$earth_radius." * acos (
							  cos ( radians(".$latitude.") )
							  * cos( radians( `latitude` ) )
							  * cos( radians( `longitude` ) - radians(".$longitude.") )
							  + sin ( radians(".$latitude.") )
							  * sin( radians( `latitude` ) )
							)
						) AS distance
						FROM `staff_outstation`
						HAVING distance < 1.5 
						AND `nokp_staff`='$nokp'
						ORDER BY distance";
						
			$remark_lokasi = $JsonSystem->getData($objectQuery);
			
			$remark_lokasi=$remark_lokasi[2];
			if($remark_lokasi == ""){
				$remark_lokasi = "LUAR KAWASAN";
			}
			
			$output2 ="";
			$sql1 ="SELECT IFNULL(max(k.id),0) AS id 
						FROM kehadiran k
						LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
						WHERE nokp_staff='$nokp' AND m.masa_keluar IS NULL ";
			
			/*$sql1 = "SELECT IFNULL(id,0) AS id FROM  kehadiran WHERE nokp_staff='$nokp' 
				AND DATE_FORMAT(created_date,'%d-%m-%Y')=DATE_FORMAT(CURRENT_TIMESTAMP,'%d-%m-%Y')";*/
				
			$_checkId = $JsonSystem->getData($sql1);
			$checkId = $_checkId[0];
			
			
			if($checkId>0){
				$sql3 = "SELECT id FROM masa_kehadiran WHERE id_kehadiran='$checkId' AND masa_keluar IS NULL 
				AND id = (SELECT MAX(id) AS id FROM masa_kehadiran WHERE id_kehadiran='$checkId') ";
				
				$masa_res = $connjson->query($sql3);
				$masa_id = "0";
				if($masa_res->num_rows > 0)//ada data
				{
					$masa_id=$masa_res -> fetch_object()->id;
					
					if($masa_id>0){
						
						$sql_staff = "SELECT s.no_staff FROM staff s WHERE s.noic = '$nokp' AND s.`status` = 'BEKERJA'";
						$_checkNoStaff = $JsonSystem->getData($sql_staff);
						$checkNoStaff = $_checkNoStaff[0];
						
						$sql4 = "UPDATE masa_kehadiran SET masa_keluar=CURRENT_TIMESTAMP, total_time=TIMEDIFF(CURRENT_TIMESTAMP,masa_masuk),
						lokasi_keluar='$lokasi',remark_keluar='$remark_lokasi',device_keluar='MOBILE-TAGLOKASI' where id='$masa_id' ";
						
						$JsonSystem->executeOperation($sql4);
						
						//update status availability kehadiran
						$sql6 = "UPDATE kehadiran SET availability='KELUAR',no_staff='$checkNoStaff' where id='$checkId'";
						$JsonSystem->executeOperation2($sql6);
					}
					//}
					$sql5 = "SELECT DATE_FORMAT(m.masa_keluar,'%r') AS masa_keluar,
					m.lokasi_keluar FROM masa_kehadiran m WHERE m.id='{$masa_id}'";
					
					$output2 = $JsonSystem->getJSONData($sql5,'',null);
					$output_to_send = "[{$output2}]";
				}
				else
				{
					$output_to_send = "[]";
				}
			}
		}
	break;
	
	case '17'://check status button kehadiran
	
		/*$nokp = $JsonSystem->getGETPOST('nokp');
		
		$sql = "SELECT s.id FROM staff_outstation s WHERE s.nokp_staff = '$nokp' AND s.`status`='1'
				AND DATE_FORMAT(CURRENT_DATE,'%Y-%m-%d') >= DATE_FORMAT(s.tarikh_mula ,'%Y-%m-%d')
				AND DATE_FORMAT(CURRENT_DATE,'%Y-%m-%d') <=DATE_FORMAT(s.tarikh_tamat ,'%Y-%m-%d')";
				
				*/
		$id = $JsonSystem->getGETPOST('id');
		
		$sql = "SELECT s.status_qrcode,s.status_swafoto,s.status_tag FROM staff s WHERE s.id='$id'";
		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '18'://update koordinat pengusaha
	
		$id = $JsonSystem->getGETPOST('id');
		$koordinat = $JsonSystem->getGETPOST('koordinat');
		
		$sql = "UPDATE pengusaha SET koordinat='$koordinat' WHERE id_pengusaha='$id'";
		$output = $JsonSystem->executeOperation($sql);
		
		$output_to_send = "Koordinat disimpan.";
	break;
	
	case '19'://select staff tidak hadir based on cawangan
	
		$tarikh = $JsonSystem->getGETPOST('tarikh');
		$cawangan = $JsonSystem->getGETPOST('cawangan');
		$department = $JsonSystem->getGETPOST('department');
				
		if($cawangan == '' && $department == '')
		{
			$sql = "SELECT s.id,s.no_staff,s.noic,s.`name`,s.phone,r.`role` AS department_id FROM staff s 
				LEFT JOIN role r ON r.`code` = s.role_id
				WHERE s.noic NOT IN (SELECT k.nokp_staff FROM kehadiran k WHERE DATE_FORMAT(k.created_date,'%Y-%m-%d') = '$tarikh')
				AND s.status = 'BEKERJA' AND s.pantau_kehadiran ='1' AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
				ORDER BY s.`name` ASC";
		}
		else if($cawangan != '' && $department == '')
		{
			$sql = "SELECT s.id,s.no_staff,s.noic,s.`name`,s.phone,r.`role` AS department_id FROM staff s 
				LEFT JOIN role r ON r.`code` = s.role_id
				WHERE s.noic NOT IN (SELECT k.nokp_staff FROM kehadiran k WHERE DATE_FORMAT(k.created_date,'%Y-%m-%d') = '$tarikh')
				AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
				AND s.status = 'BEKERJA' AND s.pantau_kehadiran ='1' AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
				ORDER BY s.`name` ASC";
		}
		else
		{
			$sql = "SELECT s.id,s.no_staff,s.noic,s.`name`,s.phone,r.`role` AS department_id FROM staff s 
				LEFT JOIN role r ON r.`code` = s.role_id
				WHERE s.noic NOT IN (SELECT k.nokp_staff FROM kehadiran k WHERE DATE_FORMAT(k.created_date,'%Y-%m-%d') = '$tarikh')
				AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
				AND s.department_id = '$department' AND s.status = 'BEKERJA' AND s.pantau_kehadiran ='1' 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
				ORDER BY s.`name` ASC";
		}
				
		$result = $connjson->query($sql);
		
				echo '[';
				
					if($result->num_rows > 0)//ada data
					{
						$i = 0;
						
						while($data = $result->fetch_assoc()) {
							
							if($i>0)
								echo ',';
							$i++;
							
							$result_nokp = $data['noic'];
							
							$sql2= "SELECT COUNT(sr.id) AS id FROM staff_record sr
									LEFT JOIN staff s ON s.no_staff=sr.no_staff
									LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
									LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
									WHERE hp.approvement = 'APPROVE' AND s.noic = '$result_nokp'
									AND '$tarikh' BETWEEN DATE_FORMAT(sh.tarikh_mula,'%Y-%m-%d') AND DATE_FORMAT(sh.tarikh_akhir,'%Y-%m-%d')";
							
							$_checkId = $JsonSystem->getData($sql2);
							$checkId = $_checkId[0];
				
							if($checkId>0){
								$status = 'BERCUTI';
							}
							else
							{
								$status = 'BELUM LOG';
							}
							
							$data['status'] = $status;
							
							echo json_encode($data);
						}
					}
					
				echo ']';
	break;
	
	case '20'://bilangan staff utk setiap cawangan dan department
	
		$cawangan = $JsonSystem->getGETPOST('cawangan');
		$department = $JsonSystem->getGETPOST('department');
		
		if($cawangan == '' && $department == '')
		{
			$sql = "SELECT COUNT(*) AS bil_staff FROM staff s 
					WHERE s.noic IS NOT NULL AND s.status='BEKERJA' AND 
					s.pantau_kehadiran='1' AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
		}
		else if($cawangan != '' && $department == '')
		{
			$sql = "SELECT COUNT(*) AS bil_staff FROM staff s
				WHERE s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
				AND s.pantau_kehadiran='1' AND s.status = 'BEKERJA' AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
		}
		else
		{
			$sql = "SELECT COUNT(*) AS bil_staff FROM staff s
				WHERE s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
				AND s.department_id = '$department' AND s.pantau_kehadiran='1' AND s.status = 'BEKERJA' 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
		}
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '21'://analisa pengusaha mengikut umur
		
		$sql = "SELECT COUNT(p.umur) AS bil_pengusaha,
				 CASE WHEN p.umur BETWEEN 0 AND 19 THEN '0-19 Tahun'
				 WHEN p.umur BETWEEN 20 AND 29 THEN '20-29 Tahun'
				 WHEN p.umur BETWEEN 30 AND 39 THEN '30-39 Tahun'
				 WHEN p.umur BETWEEN 40 AND 49 THEN '40-49 Tahun'
				 WHEN p.umur BETWEEN 50 AND 59 THEN '50-59 Tahun'
				 WHEN p.umur BETWEEN 60 AND 69 THEN '60-69 Tahun'
				 ELSE '70 Tahun Keatas' END AS kategori
				 FROM pengusaha p WHERE p.status_pengusaha = '1' GROUP BY kategori";
				
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '22'://jumlah pengusaha
		
		$sql = "SELECT COUNT(*) AS jumlah_pengusaha FROM pengusaha p
				WHERE p.status_pengusaha = '1'";
				
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '23'://jumlah pengusaha mengikut kawasan
		
		$pkj = $JsonSystem->getGETPOST('pkj');
		$ppk = $JsonSystem->getGETPOST('ppk');
		
		$sql = "SELECT COUNT(*) AS jumlah_pengusaha FROM pengusaha p 
			WHERE p.kod_ppk = (SELECT a.kod_ppk FROM lkp_ppk a WHERE a.kod_ppk = '$ppk' AND a.kod_pkj='$pkj') 
			AND p.status_pengusaha = '1'";
				
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	
	case '24'://select kehadiran keseluruhan kakitangan
	
	$cawangan = $JsonSystem->getGETPOST('cawangan');
	$department = $JsonSystem->getGETPOST('department');
		
		if($cawangan == '' && $department == '')//not select
		{
			$awal = "SELECT COUNT(*) AS bil_awal FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic 
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND s.pantau_kehadiran='1' AND s.role_id NOT IN ('ADMIN','SUPERADMIN')
				AND k.status_kehadiran='AWAL'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
				
				$_awal = $JsonSystem->getData($awal);
				$output_awal = $_awal[0];
				
			$tepat = "SELECT COUNT(*) AS bil_tepat FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic 
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND s.pantau_kehadiran='1' AND s.role_id NOT IN ('ADMIN','SUPERADMIN')
				AND k.status_kehadiran='TEPAT'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
				
				$_tepat = $JsonSystem->getData($tepat);
				$output_tepat = $_tepat[0];
				
			$lewat = "SELECT COUNT(*) AS bil_lewat FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic 
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND s.pantau_kehadiran='1' AND s.role_id NOT IN ('ADMIN','SUPERADMIN')
				AND k.status_kehadiran='LEWAT'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
				
				$_lewat = $JsonSystem->getData($lewat);
				$output_lewat = $_lewat[0];
				
			$bil_staff = "SELECT COUNT(*) AS bil_staff FROM staff s 
					WHERE s.noic IS NOT NULL AND s.status='BEKERJA' AND 
					s.pantau_kehadiran='1' AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
					
				$_bilangan_staff = $JsonSystem->getData($bil_staff);
				$output_bilangan_staff = $_bilangan_staff[0];
				
			$bil_bercuti = "SELECT COUNT(s.noic) AS bil_bercuti FROM staff s
					LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
					LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
					LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
					WHERE hp.approvement = 'APPROVE' 
					AND CURRENT_DATE BETWEEN DATE(sh.tarikh_mula) AND DATE(sh.tarikh_akhir) 
					AND s.status = 'BEKERJA' AND s.pantau_kehadiran ='1' 
					AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
					
					$_bil_bercuti = $JsonSystem->getData($bil_bercuti);
					$output_bilangan_bercuti = $_bil_bercuti[0];
				
		}
		else if($cawangan != '' && $department == '')//select cawangan
		{
			$awal = "SELECT COUNT(*) AS bil_awal FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic 
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND s.pantau_kehadiran='1' 
				AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN')
				AND k.status_kehadiran='AWAL'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
				
				$_awal = $JsonSystem->getData($awal);
				$output_awal = $_awal[0];
				
			$tepat = "SELECT COUNT(*) AS bil_tepat FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic 
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND s.pantau_kehadiran='1' 
				AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN')
				AND k.status_kehadiran='TEPAT'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
				
				$_tepat = $JsonSystem->getData($tepat);
				$output_tepat = $_tepat[0];
				
				
			$lewat = "SELECT COUNT(*) AS bil_lewat FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic 
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND s.pantau_kehadiran='1' 
				AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN')
				AND k.status_kehadiran='LEWAT'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
				
				$_lewat = $JsonSystem->getData($lewat);
				$output_lewat = $_lewat[0];
				
			$bil_staff = "SELECT COUNT(*) AS bil_staff FROM staff s
				WHERE s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
				AND s.pantau_kehadiran='1' AND s.status = 'BEKERJA' AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
				
				$_bilangan_staff = $JsonSystem->getData($bil_staff);
				$output_bilangan_staff = $_bilangan_staff[0];
				
			$bil_bercuti = "SELECT COUNT(s.noic) AS bil_bercuti FROM staff s
					LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
					LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
					LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
					WHERE hp.approvement = 'APPROVE' 
					AND CURRENT_DATE BETWEEN DATE(sh.tarikh_mula) AND DATE(sh.tarikh_akhir) 
					AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
					AND s.status = 'BEKERJA' AND s.pantau_kehadiran ='1' 
					AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
					
					$_bil_bercuti = $JsonSystem->getData($bil_bercuti);
					$output_bilangan_bercuti = $_bil_bercuti[0];
		}
		else //select cawangan and department
		{
			$awal = "SELECT COUNT(*) AS bil_awal FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic 
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND s.pantau_kehadiran='1' 
				AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
				AND s.department_id = '$department'
				AND k.status_kehadiran='AWAL'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
				
				$_awal = $JsonSystem->getData($awal);
				$output_awal = $_awal[0];
				
			$tepat = "SELECT COUNT(*) AS bil_tepat FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic 
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND s.pantau_kehadiran='1' 
				AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
				AND s.department_id = '$department'
				AND k.status_kehadiran='TEPAT'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
				
				$_tepat = $JsonSystem->getData($tepat);
				$output_tepat = $_tepat[0];
				
				
			$lewat = "SELECT COUNT(*) AS bil_lewat FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic 
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND s.pantau_kehadiran='1' 
				AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
				AND s.department_id = '$department'
				AND k.status_kehadiran='LEWAT'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
				
				$_lewat = $JsonSystem->getData($lewat);
				$output_lewat = $_lewat[0];
				
			$bil_staff = "SELECT COUNT(*) AS bil_staff FROM staff s
				WHERE s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
				AND s.department_id = '$department' AND s.pantau_kehadiran='1' AND s.status = 'BEKERJA' 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
				
				$_bilangan_staff = $JsonSystem->getData($bil_staff);
				$output_bilangan_staff = $_bilangan_staff[0];
				
			$bil_bercuti = "SELECT COUNT(s.noic) AS bil_bercuti FROM staff s
					LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
					LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
					LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
					WHERE hp.approvement = 'APPROVE' 
					AND CURRENT_DATE BETWEEN DATE(sh.tarikh_mula) AND DATE(sh.tarikh_akhir) 
					AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
					AND s.department_id = '$department' AND s.status = 'BEKERJA' AND s.pantau_kehadiran ='1' 
					AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
					
					$_bil_bercuti = $JsonSystem->getData($bil_bercuti);
					$output_bilangan_bercuti = $_bil_bercuti[0];
				
		}
		
		$output_jum_hadir = $output_awal + $output_tepat + $output_lewat;
		$output_bilangan_takhadir = $output_bilangan_staff - $output_jum_hadir - $output_bilangan_bercuti;	
		
		$output_percent_kehadiran = '';
		if($output_jum_hadir > 0)
		{
			//kira percent
			$output_percent_kehadiran = Round(($output_jum_hadir / $output_bilangan_staff) * 100,0);
		}
		else
		{
			//takde percent
			$output_percent_kehadiran = 0;
		}
		
		$output_to_send = '[{"bil_awal":"'.$output_awal.'","bil_tepat":"'.$output_tepat.'","bil_lewat":"'.$output_lewat.'","bil_staff":"'.$output_bilangan_staff.'","jum_hadir":"'.$output_jum_hadir.'","jum_tidak_hadir":"'.$output_bilangan_takhadir.'","jum_bercuti":"'.$output_bilangan_bercuti.'","percent_hadir":"'.$output_percent_kehadiran.'%"}]';
		
	break;
	
	case '25'://SELECT KAKITANGAN BASED ON CAWANGAN DAN DEPARTMENT 
	
		$cawangan = $JsonSystem->getGETPOST('cawangan');
		$department = $JsonSystem->getGETPOST('department');
		
		if($cawangan == '' && $department != '')
		{
			$sql = "SELECT s.id,s.no_staff,s.noic,s.`name`,s.phone,r.`role` AS department_id FROM staff s 
					LEFT JOIN role r ON r.`code` = s.role_id
					WHERE s.department_id = '$department' AND s.status = 'BEKERJA' AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
					AND s.pantau_kehadiran='1'
					ORDER BY s.`name` ASC";
		}
		else
		{
			$sql = "SELECT s.id,s.no_staff,s.noic,s.`name`,s.phone,r.`role` AS department_id FROM staff s 
					LEFT JOIN role r ON r.`code` = s.role_id
					WHERE s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
					AND s.department_id = '$department' AND s.status = 'BEKERJA' AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
					AND s.pantau_kehadiran='1'
					ORDER BY s.`name` ASC";
		}
		
		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
		
	break;
	
	case '26'://select bulan kehadiran 
	
		$nokp = $JsonSystem->getGETPOST('nokp');
		
		$sql = "SELECT DATE_FORMAT(k.created_date,'%M') AS bulan FROM kehadiran k
				LEFT JOIN staff s ON s.noic = k.nokp_staff
				WHERE s.noic = '$nokp' AND s.`status`='BEKERJA' 
				AND YEAR(k.created_date) = YEAR(CURRENT_DATE) GROUP BY bulan ORDER BY k.created_date ASC";
				
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '27'://check role id ANALISA TIDAK HADIR
	
		$role_id = $JsonSystem->getGETPOST('role_id');
		
		$sql="SELECT * FROM sec_role_menu a WHERE a.role_code = '{$role_id}'
			AND a.access_menu = '1'
			AND a.menu_id IN (SELECT b.id FROM sec_module_menu b WHERE b.module_code = 'SUMBERMANUSIA' 
			AND  b.menu = UPPER('ANALISA KAKITANGAN TIDAK HADIR'))";
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '28'://check role id ANALISA KEHADIRAN KESELURUHAN
	
		$role_id = $JsonSystem->getGETPOST('role_id');
		
		$sql="SELECT * FROM sec_role_menu a WHERE a.role_code = '{$role_id}'
			AND a.access_menu = '1'
			AND a.menu_id IN (SELECT b.id FROM sec_module_menu b WHERE b.module_code = 'SUMBERMANUSIA' 
			AND  b.menu = UPPER('ANALISA KEHADIRAN KESELURUHAN'))";
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '29'://upload photo -masuk
	
		$nokp = $JsonSystem->getGETPOST('noic');
	    $lokasi = $JsonSystem->getGETPOST('lokasi');
		$cawangan_kod = $JsonSystem->getGETPOST('cawangan_kod');
		$image_bytes = $JsonSystem->getGETPOST('image_bytes');
		$no_staff = $JsonSystem->getGETPOST('no_staff');
		$flag = $JsonSystem->getGETPOST('flag');
	    
	    $koor = explode(",", $lokasi);
	    $latitude = $koor[0];
	    $longitude = $koor[1];
	    
		if($latitude == '0' && $longitude == '0')
		{
			$output_to_send = "Koordinat tidak sah.";
		}
		else
		{
					//in km  //distance = 0.5 = 500 metres
				$earth_radius = 6371;
				$objectQuery = "SELECT *, (".$earth_radius." * acos (
								  cos ( radians(".$latitude.") )
								  * cos( radians( `latitude` ) )
								  * cos( radians( `longitude` ) - radians(".$longitude.") )
								  + sin ( radians(".$latitude.") )
								  * sin( radians( `latitude` ) )
								)
							) AS distance
							FROM `lkp_location`
							HAVING distance < 1.5
							ORDER BY distance ASC LIMIT 1";
				
				$remark_lokasi = $JsonSystem->getData($objectQuery);
				
				$remark_lokasi=$remark_lokasi[1];
				
				if($remark_lokasi == ""){
					$remark_lokasi = "LUAR KAWASAN";
				}
				
				//$masa = $JsonSystem->getData("SELECT masa_bekerja FROM masa_bekerja where shift_code = (select shift_kerja from staff where noic='$nokp' AND status = 'BEKERJA')");
				$masa = $JsonSystem->getData("SELECT masa_bekerja FROM masa_bekerja where shift_code = (select shift_kerja from tarikh_bekerja where no_staff='$no_staff' AND tarikh = CURRENT_DATE())");
				
				$masa_bekerja=$masa[0];
				
				$sql ="SELECT MAX(mk.id) AS id FROM masa_kehadiran mk
				LEFT JOIN kehadiran k ON mk.id_kehadiran=k.id
				WHERE DATE_FORMAT(mk.masa_masuk,'%Y-%m-%d') NOT IN(DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')) AND k.nokp_staff='$nokp'";
				
				$id=$connjson->query($sql)->fetch_object()->id;
				
				$sql2= "SELECT IFNULL(MAX(id),0) AS id,masa_masuk,id_kehadiran FROM masa_kehadiran
					WHERE id='$id' AND masa_keluar IS NULL";
				
				$id_mk=$connjson->query($sql2)->fetch_object()->id;
				$id_kehadiran=$connjson->query($sql2)->fetch_object()->id_kehadiran;
				
				if($id_mk > 0)//ada data
				{
					$masa_masuk=$connjson->query($sql2)->fetch_object()->masa_masuk;
					$tarikh_masuk = date('Y-m-d',strtotime($masa_masuk));
					$masa_mk = $tarikh_masuk." ".$masa_bekerja;
					$masa_keluar = date('Y-m-d H:i:s',strtotime('+9 hour',strtotime($masa_mk)));
					
					if($masa_masuk > $masa_keluar)
					{
						$sql3 = "UPDATE masa_kehadiran SET masa_keluar='$masa_masuk', total_time=TIMEDIFF('$masa_masuk',masa_masuk),
							lokasi_keluar='0.0,0.0',remark_keluar='TIADA IMBASAN KELUAR',device_keluar='AUTO' where id='$id_mk'";
					}
					else
					{
						$sql3 = "UPDATE masa_kehadiran SET masa_keluar='$masa_keluar', total_time=TIMEDIFF('$masa_keluar',masa_masuk),
							lokasi_keluar='0.0,0.0',remark_keluar='TIADA IMBASAN KELUAR',device_keluar='AUTO' where id='$id_mk'";
					}
										
					$output = $JsonSystem->executeOperation2($sql3);
					//update status availability kehadiran
					$sql10 = "UPDATE kehadiran SET availability='KELUAR' where id='$id_kehadiran'";
					$JsonSystem->executeOperation2($sql10);
				}
				
				$sql8 ="SELECT MAX(mk.id) AS id , mk.masa_masuk FROM masa_kehadiran mk
				LEFT JOIN kehadiran k ON mk.id_kehadiran=k.id
				WHERE DATE_FORMAT(mk.masa_masuk,'%Y-%m-%d') = (DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')) AND k.nokp_staff='$nokp'
				AND mk.masa_keluar IS NULL";
				
				$current_id=$connjson->query($sql8)->fetch_object()->id;
				if($current_id > 0)//ada data
				{
					$sql9 = "UPDATE masa_kehadiran SET masa_keluar=CURRENT_TIMESTAMP, total_time=TIMEDIFF(CURRENT_TIMESTAMP,masa_masuk),
							lokasi_keluar='$lokasi',remark_keluar='$remark_lokasi',device_keluar='MOBILE-SWAFOTO' where id='$current_id'";
							
							$JsonSystem->executeOperation2($sql9);
				}
				

				$sql4 = "SELECT IFNULL(id,0) AS id FROM  kehadiran WHERE nokp_staff='$nokp' 
				AND DATE_FORMAT(created_date,'%d-%m-%Y')=DATE_FORMAT(CURRENT_TIMESTAMP,'%d-%m-%Y')";

				$_checkId = $JsonSystem->getData($sql4);
				$checkId = $_checkId[0];
				$newid = "0";
				if($checkId>0){
					
					if($flag=='1')//pengesahan_kehadiran manual
					{
						$sql5 = "INSERT INTO masa_kehadiran (id_kehadiran,masa_masuk,lokasi_masuk,remark_masuk,device_masuk,created_by) VALUES ('$checkId',CURRENT_TIMESTAMP,'$lokasi','$remark_lokasi','MOBILE-PENGESAHANMANUAL','$no_staff')";
						$newid = $JsonSystem->executeOperation2($sql5);
					}
					else if($flag=='2')//pengesahan_kehadiran qr
					{
						$sql5 = "INSERT INTO masa_kehadiran (id_kehadiran,masa_masuk,lokasi_masuk,remark_masuk,device_masuk,created_by) VALUES ('$checkId',CURRENT_TIMESTAMP,'$lokasi','$remark_lokasi','MOBILE-PENGESAHANQR','$no_staff')";
						$newid = $JsonSystem->executeOperation2($sql5);
					}else
					{
						$sql5 = "INSERT INTO masa_kehadiran (id_kehadiran,masa_masuk,lokasi_masuk,remark_masuk,device_masuk,created_by) VALUES ('$checkId',CURRENT_TIMESTAMP,'$lokasi','$remark_lokasi','MOBILE-SWAFOTO','$no_staff')";
						$newid = $JsonSystem->executeOperation2($sql5);
					}
					
					
						//update status availability kehadiran
						$sql12 = "UPDATE kehadiran SET availability='MASUK' where id='$checkId'";
						$JsonSystem->executeOperation2($sql12);
				
				}else
				{
				
					$sql_staff = "SELECT s.no_staff FROM staff s WHERE s.noic = '$nokp' AND s.`status` = 'BEKERJA'";
							$_checkNoStaff = $JsonSystem->getData($sql_staff);
							$checkNoStaff = $_checkNoStaff[0];
					
					$sql6 = "INSERT INTO kehadiran (status_kehadiran, lokasi,nokp_staff,remark_lokasi,latitude,longitude,cawangan_kod,availability,no_staff) 
							VALUES (
							(
									SELECT CASE 
									WHEN TIME_TO_SEC(DATE_FORMAT(CURRENT_TIMESTAMP,'%H:%i')) = TIME_TO_SEC('$masa_bekerja') THEN 'TEPAT' 
									WHEN TIME_TO_SEC(DATE_FORMAT(CURRENT_TIMESTAMP,'%H:%i')) > TIME_TO_SEC('$masa_bekerja') THEN 'LEWAT' 
									ELSE 'AWAL' END
							)
							, '$lokasi', '$nokp','$remark_lokasi','$latitude','$longitude','$cawangan_kod','MASUK','$checkNoStaff')";
							
					$newid = $JsonSystem->executeOperation2($sql6);
					
					if($flag=='1')//pengesahan_kehadiran manual
					{
						$sql7 = "INSERT INTO masa_kehadiran (id_kehadiran,masa_masuk,lokasi_masuk,remark_masuk,device_masuk,created_by) 
							VALUES ('$newid',CURRENT_TIMESTAMP,'$lokasi','$remark_lokasi','MOBILE-PENGESAHANMANUAL','$no_staff')";
							
						$newid = $JsonSystem->executeOperation2($sql7);
					}
					else if($flag=='2')//pengesahan_kehadiran qr
					{
						$sql7 = "INSERT INTO masa_kehadiran (id_kehadiran,masa_masuk,lokasi_masuk,remark_masuk,device_masuk,created_by) 
							VALUES ('$newid',CURRENT_TIMESTAMP,'$lokasi','$remark_lokasi','MOBILE-PENGESAHANQR','$no_staff')";
							
						$newid = $JsonSystem->executeOperation2($sql7);
					}
					else
					{
						$sql7 = "INSERT INTO masa_kehadiran (id_kehadiran,masa_masuk,lokasi_masuk,remark_masuk,device_masuk,created_by) 
							VALUES ('$newid',CURRENT_TIMESTAMP,'$lokasi','$remark_lokasi','MOBILE-SWAFOTO','$no_staff')";
							
						$newid = $JsonSystem->executeOperation2($sql7);
					}
				}
				
				$output2 = $JsonSystem->getData("SELECT DATE_FORMAT(m.masa_masuk,'%r') AS masa_masuk,
				m.lokasi_masuk FROM masa_kehadiran m WHERE m.id='{$newid}'",'',null);
				
			/****************************************************************************************************************************/
			
			
			$content = base64_decode($image_bytes);
			
			$size = getImageSizeFromString($content);

			// Check the MIME type to be sure that the binary data is an image
			if (empty($size['mime']) || strpos($size['mime'], 'image/') !== 0) {
			  $output_file = "Image value not valid";
			  die('Base64 value is not a valid image');
				
			}

			// Mime types are represented as image/gif, image/png, image/jpeg, and so on
			// Therefore, to extract the image extension, we subtract everything after the “image/” prefix
			$ext = substr($size['mime'], 6);

			// Make sure that you save only the desired file extensions
			if (!in_array($ext, ['png', 'gif', 'jpeg'])) {
			  $output_file = "Unsupported image type";
			  die('Unsupported image type');	
			}
			
			$folder = date('Ymd');
			$directoryName = "logphoto/".$folder."/";
			
			if(!is_dir($directoryName)){
			//Directory does not exist, so lets create it.
			mkdir($directoryName, 0755);
			}
			
			$filename = "M"."_".$newid."_".$nokp;
			// Specify the location where you want to save the image
			$img_file = $directoryName.$filename.".{$ext}";
			
			$file = $filename.".{$ext}";
			
			// Save binary data as raw data (that is, it will not remove metadata or invalid contents)
			// In this case, the PHP backdoor will be stored on the server
			file_put_contents($img_file, $content);
			$output_file = "Berjaya dimuat naik.";	
			//update filename into table
			$sql11 = "UPDATE masa_kehadiran SET photo_masuk= '$file' where id='$newid' ";
												
			$JsonSystem->executeOperation($sql11);
			
			/*****************************************************************************************************************************/
			 /*
			 if($_FILES["file"]["type"] == "image/png")
			 {		
					if ($_FILES["file"]["error"] > 0)
						   { 
								 
								 $output_file = "Return Code: " . $_FILES["file"]["error"] . ""; 
						   } 
						   else  
								 { 
									 "Upload: " . $_FILES["file"]["name"] . ""; 
									 "Type: " . $_FILES["file"]["type"] . "";
									 echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb";
									 "Temp file: " . $_FILES["file"]["tmp_name"] . "";
									 
									 $filename = "M"."_".$newid."_".$nokp.".png";
									 $_FILES["file"]["name"] = $filename;
									 
									 $uploadfile =  'logphoto/' . $_FILES['file']['name'];

									 if (file_exists($uploadfile))
									 {
											$output_file =  $_FILES["file"]["name"] . " already exists. ";
									 }
									  else
									  {
										//once all safety checks are done, you can safely move the file from the temporary location to a public accessible location
										move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
										$output_file = "Berjaya dimuat naik.";	

										//update filename into table
										$sql4 = "UPDATE masa_kehadiran SET photo_masuk= '$filename' where id='$newid' ";
												
												$JsonSystem->executeOperation($sql4);
									   }
								 }	   
						
			 }
			 else 
			{
				$output_file = "Invalid file.";
			}
			*/
				$output_to_send = '[{"masa_masuk":"'.$output2[0].'","lokasi_masuk":"'.$output2[1].'","message":"'.$output_file.'"}]';
					
		}
		
	break;
	
	case '30'://log kehadiran imbasan/tag lokasi
	
		$nokp = $JsonSystem->getGETPOST('nokp');
		$month = $JsonSystem->getGETPOST('month');
		
		$current_year = date('Y');
		
		$year_month = $current_year."-".$month;
		
		$sql = "SELECT k.id,DATE_FORMAT(k.created_date,'%d-%m-%Y') AS tarikh,
				DATE_FORMAT(k.created_date,'%W') AS hari,
				DATE_FORMAT(m.masa_masuk,'%d-%m-%Y  %r') AS masa_masuk,
				IFNULL(DATE_FORMAT(m.masa_keluar,'%d-%m-%Y  %r'),'BELUM LOG') AS masa_keluar,
				k.status_kehadiran,
				IFNULL(SEC_TO_TIME((TIME_TO_SEC(m.total_time)-TIME_TO_SEC(s.jum_jam_break))),'00:00:00') AS jam_bekerja,
				m.remark_masuk, IFNULL(m.remark_keluar,'-') AS remark_keluar,
				m.device_masuk,IFNULL(m.device_keluar,'-') AS device_keluar,IFNULL(k.sebab_kelewatan,'-') AS sebab_kelewatan
				FROM masa_kehadiran m 
				LEFT JOIN kehadiran k ON m.id_kehadiran=k.id
				LEFT JOIN staff s ON k.nokp_staff=s.noic
				WHERE k.nokp_staff = '$nokp' AND s.`status`='BEKERJA' AND
				DATE_FORMAT(m.masa_masuk,'%Y-%M')='$year_month' 
				ORDER BY m.masa_masuk DESC";
				
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
		
	break;
	
	//upload photo - keluar
	case '31':
	
		$nokp = $JsonSystem->getGETPOST('noic');
	    $lokasi = $JsonSystem->getGETPOST('lokasi');
		$cawangan_kod = $JsonSystem->getGETPOST('cawangan_kod');
	    $image_bytes = $JsonSystem->getGETPOST('image_bytes');
		$no_staff = $JsonSystem->getGETPOST('no_staff');
		$flag = $JsonSystem->getGETPOST('flag');
		
	    $koor = explode(",", $lokasi);
	    $latitude = $koor[0];
	    $longitude = $koor[1];
	    
		if($latitude == '0' && $longitude == '0')
		{
			$output_to_send = "Koordinat tidak sah.";
		}
		else
		{
					//in km  //distance = 0.5 = 500 metres
				$earth_radius = 6371;
				$objectQuery = "SELECT *, (".$earth_radius." * acos (
								  cos ( radians(".$latitude.") )
								  * cos( radians( `latitude` ) )
								  * cos( radians( `longitude` ) - radians(".$longitude.") )
								  + sin ( radians(".$latitude.") )
								  * sin( radians( `latitude` ) )
								)
							) AS distance
							FROM `lkp_location`
							HAVING distance < 1.5 
							ORDER BY distance ASC LIMIT 1";
				
				$remark_lokasi = $JsonSystem->getData($objectQuery);
				$remark_lokasi=$remark_lokasi[1];
				if($remark_lokasi == ""){
					$remark_lokasi = "LUAR KAWASAN";
				}
				
				$output2 ="";
				$sql1 ="SELECT IFNULL(max(k.id),0) AS id 
							FROM kehadiran k
							LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
							WHERE nokp_staff='$nokp' AND m.masa_keluar IS NULL ";
				
					
				$_checkId = $JsonSystem->getData($sql1);
				$checkId = $_checkId[0];
				
				
				if($checkId>0){
					$sql3 = "SELECT id FROM masa_kehadiran WHERE id_kehadiran='$checkId' AND masa_keluar IS NULL 
					AND id = (SELECT MAX(id) AS id FROM masa_kehadiran WHERE id_kehadiran='$checkId') ";
					
					$masa_res = $connjson->query($sql3);
					$masa_id = "0";
					if($masa_res->num_rows > 0)//ada data
					{
						$masa_id=$masa_res -> fetch_object()->id;
						
						if($masa_id>0){
							
							$sql_staff = "SELECT s.no_staff FROM staff s WHERE s.noic = '$nokp' AND s.`status` = 'BEKERJA'";
							$_checkNoStaff = $JsonSystem->getData($sql_staff);
							$checkNoStaff = $_checkNoStaff[0];
							
							
							if($flag=='1')//pengesahan_kehadiran manual
							{
								$sql4 = "UPDATE masa_kehadiran SET masa_keluar=CURRENT_TIMESTAMP, total_time=TIMEDIFF(CURRENT_TIMESTAMP,masa_masuk),
								lokasi_keluar='$lokasi',remark_keluar='$remark_lokasi',device_keluar='MOBILE-PENGESAHANMANUAL' where id='$masa_id' ";
								
								$JsonSystem->executeOperation($sql4);
							}
							else if($flag=='2')//pengesahan_kehadiran qr
							{
								$sql4 = "UPDATE masa_kehadiran SET masa_keluar=CURRENT_TIMESTAMP, total_time=TIMEDIFF(CURRENT_TIMESTAMP,masa_masuk),
								lokasi_keluar='$lokasi',remark_keluar='$remark_lokasi',device_keluar='MOBILE-PENGESAHANQR' where id='$masa_id' ";
								
								$JsonSystem->executeOperation($sql4);
							}
							else
							{
								$sql4 = "UPDATE masa_kehadiran SET masa_keluar=CURRENT_TIMESTAMP, total_time=TIMEDIFF(CURRENT_TIMESTAMP,masa_masuk),
								lokasi_keluar='$lokasi',remark_keluar='$remark_lokasi',device_keluar='MOBILE-SWAFOTO' where id='$masa_id' ";
								
								$JsonSystem->executeOperation($sql4);
							}
						
							
							
							//update status availability kehadiran
							$sql6 = "UPDATE kehadiran SET availability='KELUAR',no_staff='$checkNoStaff' where id='$checkId'";
							$JsonSystem->executeOperation2($sql6);
						}
						//}
						$sql5 = "SELECT DATE_FORMAT(m.masa_keluar,'%r') AS masa_keluar,
						m.lokasi_keluar FROM masa_kehadiran m WHERE m.id='{$masa_id}'";
						
						$output2 = $JsonSystem->getData($sql5,'',null);
						
						/**********************************************************************************************************/
							$content = base64_decode($image_bytes);
							
							$size = getImageSizeFromString($content);

							// Check the MIME type to be sure that the binary data is an image
							if (empty($size['mime']) || strpos($size['mime'], 'image/') !== 0) {
							  die('Base64 value is not a valid image');
							  $output_file = "Image value not valid";	
							}

							// Mime types are represented as image/gif, image/png, image/jpeg, and so on
							// Therefore, to extract the image extension, we subtract everything after the “image/” prefix
							$ext = substr($size['mime'], 6);

							// Make sure that you save only the desired file extensions
							if (!in_array($ext, ['png', 'gif', 'jpeg'])) {
							  die('Unsupported image type');
							  $output_file = "Unsupported image type";	
							}
							
							$folder = date('Ymd');
							$directoryName = "logphoto/".$folder."/";
							
							if(!is_dir($directoryName)){
							//Directory does not exist, so lets create it.
							mkdir($directoryName, 0755);
							}
			
							$filename = "K"."_".$masa_id."_".$nokp;
							// Specify the location where you want to save the image
							$img_file = $directoryName.$filename.".{$ext}";
							
							$file = $filename.".{$ext}";
							
							// Save binary data as raw data (that is, it will not remove metadata or invalid contents)
							// In this case, the PHP backdoor will be stored on the server
							file_put_contents($img_file, $content);
							$output_file = "Berjaya dimuat naik.";	
							//update filename into table
							$sql4 = "UPDATE masa_kehadiran SET photo_keluar= '$file' where id='$masa_id'";
							$JsonSystem->executeOperation($sql4);		
			
						/**********************************************************************************************************/
						
						/*if (($_FILES["file"]["type"] == "image/png"))
						{		
						if ($_FILES["file"]["error"] > 0)
							   { 
									 
									 $output_file = "Return Code: " . $_FILES["file"]["error"] . ""; 
							   } 
							   else  
								{ 
										 "Upload: " . $_FILES["file"]["name"] . ""; 
										 "Type: " . $_FILES["file"]["type"] . "";
										 "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb";
										 "Temp file: " . $_FILES["file"]["tmp_name"] . "";
										 
										 if (($_FILES["file"]["name"] == $nokp.".png"))
										 {
											 $filename = "K"."_".$masa_id."_".$nokp.".png";
											 $_FILES["file"]["name"] = $filename;
										 }
										 
										 $uploadfile =  'logphoto/' . $_FILES['file']['name'];

										 if (file_exists($uploadfile))
										 {
												$output_file =  $_FILES["file"]["name"] . " already exists. ";
										 }
										  else
										  {
											//once all safety checks are done, you can safely move the file from the temporary location to a public accessible location
											move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
											$output_file = "Berjaya dimuat naik.";	

											//update filename into table
											$sql4 = "UPDATE masa_kehadiran SET photo_keluar= '$filename' where id='$masa_id' ";
													
													$JsonSystem->executeOperation($sql4);
										   }
									 }	 	   
							
						}
						else 
						{
							$output_file = "Invalid file.";
						}
						*/
							$output_to_send = '[{"masa_keluar":"'.$output2[0].'","lokasi_keluar":"'.$output2[1].'","message":"'.$output_file.'"}]';
				
					}
					else
					{
						$output_to_send = "[]";
					}
				}
		}
		
	break;
	
	case '32'://checking phone id
	
		$device_token = $JsonSystem->getGETPOST('device_token');
		$device_id = $JsonSystem->getGETPOST('device_id');
		$nokp = $JsonSystem->getGETPOST('nokp');
		
		$sql = "SELECT p.id,p.nokp_staff FROM phone_authority p WHERE p.device_id ='$device_id'";
		
		$result = $connjson->query($sql);
		
		
		$nokp_staff = "";
		
			if($result->num_rows > 0)//ada data
			{
				//$id_staff=$connjson->query($sql) -> fetch_object()->id;
    		    //$nokp_staff=$connjson->query($sql) -> fetch_object()->nokp_staff;
				
				$data = $result->fetch_assoc();
				
    		    $id_staff=$data['id'];
				$nokp_staff=$data['nokp_staff'];
				
    		    if($nokp_staff == $nokp)
				{
					$sql1 = "UPDATE phone_authority SET device_token= '$device_token' AND status = '1' where id='$id_staff'";
					$JsonSystem->executeOperation($sql1);
					
					$output_to_send = "Log masuk berjaya.";
				}
				else
				{
					$output_to_send = "Log masuk disekat.";
				}
			}
			else
			{
				$sql4 = "UPDATE phone_authority SET status= '0' where nokp_staff='$nokp'";
				$JsonSystem->executeOperation($sql4);
				
				$sql2="INSERT INTO phone_authority (nokp_staff,device_id,device_token) 
				VALUES ('$nokp','$device_id','$device_token')";
				$JsonSystem->executeOperation($sql2);
				
				$output_to_send = "Log masuk berjaya.";
			}
				
	break;
	
	case '33'://select staff yg hadir based on cawangan
	
		$tarikh = $JsonSystem->getGETPOST('tarikh');
		$cawangan = $JsonSystem->getGETPOST('cawangan');
		$department = $JsonSystem->getGETPOST('department');
				
		if($cawangan == '' && $department == '')
		{
			$sql = "SELECT mk.id_kehadiran,s.`name`,s.noic,s.phone,r.`role` AS department_id,mk.lokasi_masuk,
					DATE_FORMAT(mk.masa_masuk,'%r') AS masa_masuk,mk.device_masuk AS platform, k.status_kehadiran, k.availability,IFNULL(k.sebab_kelewatan,'-') AS sebab_kelewatan
					FROM masa_kehadiran mk
					LEFT JOIN kehadiran k ON k.id=mk.id_kehadiran
					LEFT JOIN staff s ON k.nokp_staff=s.noic
					LEFT JOIN role r ON r.`code` = s.role_id
					WHERE mk.id IN 
					(SELECT MAX(m.id) AS id FROM masa_kehadiran m 
					LEFT JOIN kehadiran k ON k.id=m.id_kehadiran
					LEFT JOIN staff s ON k.nokp_staff=s.noic
					WHERE DATE_FORMAT(m.masa_masuk,'%Y-%m-%d') = '$tarikh'
					GROUP BY k.nokp_staff) 
					AND s.status = 'BEKERJA' AND s.pantau_kehadiran ='1' 
					AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
					ORDER BY k.created_date DESC";
		}
		else if($cawangan != '' && $department == '')
		{
			$sql = "SELECT mk.id_kehadiran,s.`name`,s.noic,s.phone,r.`role` AS department_id,mk.lokasi_masuk,
					DATE_FORMAT(mk.masa_masuk,'%r') AS masa_masuk,mk.device_masuk AS platform, k.status_kehadiran, k.availability,IFNULL(k.sebab_kelewatan,'-') AS sebab_kelewatan
					FROM masa_kehadiran mk
					LEFT JOIN kehadiran k ON k.id=mk.id_kehadiran
					LEFT JOIN staff s ON k.nokp_staff=s.noic
					LEFT JOIN role r ON r.`code` = s.role_id
					WHERE mk.id IN 
					(SELECT MAX(m.id) AS id FROM masa_kehadiran m 
					LEFT JOIN kehadiran k ON k.id=m.id_kehadiran
					LEFT JOIN staff s ON k.nokp_staff=s.noic
					WHERE DATE_FORMAT(m.masa_masuk,'%Y-%m-%d') = '$tarikh'
					GROUP BY k.nokp_staff) 
					AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
					AND s.status = 'BEKERJA' AND s.pantau_kehadiran ='1' 
					AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
					ORDER BY k.created_date DESC";
		}
		else
		{
			$sql = "SELECT mk.id_kehadiran,s.`name`,s.noic,s.phone,r.`role` AS department_id,mk.lokasi_masuk,
					DATE_FORMAT(mk.masa_masuk,'%r') AS masa_masuk,mk.device_masuk AS platform, k.status_kehadiran, k.availability,IFNULL(k.sebab_kelewatan,'-') AS sebab_kelewatan
					FROM masa_kehadiran mk
					LEFT JOIN kehadiran k ON k.id=mk.id_kehadiran
					LEFT JOIN staff s ON k.nokp_staff=s.noic
					LEFT JOIN role r ON r.`code` = s.role_id
					WHERE mk.id IN 
					(SELECT MAX(m.id) AS id FROM masa_kehadiran m 
					LEFT JOIN kehadiran k ON k.id=m.id_kehadiran
					LEFT JOIN staff s ON k.nokp_staff=s.noic
					WHERE DATE_FORMAT(m.masa_masuk,'%Y-%m-%d') = '$tarikh'
					GROUP BY k.nokp_staff) 
					AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
					AND s.department_id = '$department' AND s.status = 'BEKERJA' AND s.pantau_kehadiran ='1' 
					AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
					ORDER BY k.created_date DESC";
		}
		
				$result = $connjson->query($sql);
		
				echo '[';
				
					if($result->num_rows > 0)//ada data
					{
						$i = 0;
						
						while($data = $result->fetch_assoc()) {
							
							if($i>0)
								echo ',';
							$i++;
							
							$geocode = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$data['lokasi_masuk']."&sensor=false&key=AIzaSyBLTdGQxl-f5ARZpMAIVrzSZepLf7TjNis";
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
							
							$data['address'] = $address;
							
							echo json_encode($data);
						}
					}
					echo ']';
	break;
	
	case '34'://jum staff,jum tidak hadir,jum bercuti 
	
		$tarikh = $JsonSystem->getGETPOST('tarikh');
		$cawangan = $JsonSystem->getGETPOST('cawangan');
		$department = $JsonSystem->getGETPOST('department');
		
		if($cawangan == '' && $department == '')
		{
			$sql1 = "SELECT COUNT(*) AS bil_staff FROM staff s 
					WHERE s.noic IS NOT NULL AND s.status='BEKERJA' AND 
					s.pantau_kehadiran='1' AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
					
					$output1 = $JsonSystem->getData($sql1,'',null);
					$bil_staff = $output1[0];
			
			$sql2 = "SELECT COUNT(*) AS bil_tdk_hadir FROM staff s 
					LEFT JOIN role r ON r.`code` = s.role_id
					WHERE s.noic NOT IN (SELECT k.nokp_staff FROM kehadiran k WHERE DATE_FORMAT(k.created_date,'%Y-%m-%d') = '$tarikh')
					AND s.noic NOT IN (SELECT s.noic FROM staff s
					LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
					LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
					LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
					WHERE hp.approvement = 'APPROVE' 
					AND '$tarikh' BETWEEN DATE_FORMAT(sh.tarikh_mula,'%Y-%m-%d') AND DATE_FORMAT(sh.tarikh_akhir,'%Y-%m-%d'))
					AND s.status = 'BEKERJA' AND s.pantau_kehadiran ='1' AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
					
					$output2 = $JsonSystem->getData($sql2,'',null);
					$bil_tdk_hadir = $output2[0];
					
			$sql3 = "SELECT COUNT(s.noic) AS bil_bercuti FROM staff s
					LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
					LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
					LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
					WHERE hp.approvement = 'APPROVE' 
					AND '$tarikh' BETWEEN DATE_FORMAT(sh.tarikh_mula,'%Y-%m-%d') AND DATE_FORMAT(sh.tarikh_akhir,'%Y-%m-%d')
					AND s.status = 'BEKERJA' AND s.pantau_kehadiran ='1' AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
					
					$output3 = $JsonSystem->getData($sql3,'',null);
					$bil_bercuti= $output3[0];
		}
		else if($cawangan != '' && $department == '')
		{
			$sql1 = "SELECT COUNT(*) AS bil_staff FROM staff s
					WHERE s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
					AND s.pantau_kehadiran='1' AND s.status = 'BEKERJA' AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
					
					$output1 = $JsonSystem->getData($sql1,'',null);
					$bil_staff = $output1[0];
					
			$sql2 = "SELECT COUNT(*) AS bil_tdk_hadir FROM staff s 
					LEFT JOIN role r ON r.`code` = s.role_id
					WHERE s.noic NOT IN (SELECT k.nokp_staff FROM kehadiran k WHERE DATE_FORMAT(k.created_date,'%Y-%m-%d') = '$tarikh')
					AND s.noic NOT IN (SELECT s.noic FROM staff s
					LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
					LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
					LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
					WHERE hp.approvement = 'APPROVE' 
					AND '$tarikh' BETWEEN DATE_FORMAT(sh.tarikh_mula,'%Y-%m-%d') AND DATE_FORMAT(sh.tarikh_akhir,'%Y-%m-%d'))
					AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
					AND s.status = 'BEKERJA' AND s.pantau_kehadiran ='1' AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
					
					$output2 = $JsonSystem->getData($sql2,'',null);
					$bil_tdk_hadir = $output2[0];
					
			$sql3 = "SELECT COUNT(s.noic) AS bil_bercuti FROM staff s
					LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
					LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
					LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
					WHERE hp.approvement = 'APPROVE' 
					AND '$tarikh' BETWEEN DATE_FORMAT(sh.tarikh_mula,'%Y-%m-%d') AND DATE_FORMAT(sh.tarikh_akhir,'%Y-%m-%d') 
					AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
					AND s.status = 'BEKERJA' AND s.pantau_kehadiran ='1' AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
					
					$output3 = $JsonSystem->getData($sql3,'',null);
					$bil_bercuti= $output3[0];
		}
		else
		{
			$sql1 = "SELECT COUNT(*) AS bil_staff FROM staff s
					WHERE s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
					AND s.department_id = '$department' AND s.pantau_kehadiran='1' AND s.status = 'BEKERJA' 
					AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
					
					$output1 = $JsonSystem->getData($sql1,'',null);
					$bil_staff = $output1[0];
					
			$sql2 = "SELECT COUNT(*) AS bil_tdk_hadir FROM staff s 
					LEFT JOIN role r ON r.`code` = s.role_id
					WHERE s.noic NOT IN (SELECT k.nokp_staff FROM kehadiran k WHERE DATE_FORMAT(k.created_date,'%Y-%m-%d') = '$tarikh')
					AND s.noic NOT IN (SELECT s.noic FROM staff s
					LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
					LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
					LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
					WHERE hp.approvement = 'APPROVE' 
					AND '$tarikh' BETWEEN DATE_FORMAT(sh.tarikh_mula,'%Y-%m-%d') AND DATE_FORMAT(sh.tarikh_akhir,'%Y-%m-%d'))
					AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
					AND s.department_id = '$department' AND s.status = 'BEKERJA' AND s.pantau_kehadiran ='1' 
					AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
					
					$output2 = $JsonSystem->getData($sql2,'',null);
					$bil_tdk_hadir = $output2[0];
					
			$sql3 = "SELECT COUNT(s.noic) AS bil_bercuti FROM staff s
					LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
					LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
					LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
					WHERE hp.approvement = 'APPROVE' 
					AND '$tarikh' BETWEEN DATE_FORMAT(sh.tarikh_mula,'%Y-%m-%d') AND DATE_FORMAT(sh.tarikh_akhir,'%Y-%m-%d') 
					AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
					AND s.department_id = '$department' AND s.status = 'BEKERJA' AND s.pantau_kehadiran ='1' 
					AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
					
					$output3 = $JsonSystem->getData($sql3,'',null);
					$bil_bercuti= $output3[0];
		}
					$output_percent_ketidakhadiran = '';
					if($bil_tdk_hadir > 0)
					{
						//kira percent
						$output_percent_ketidakhadiran = Round(($bil_tdk_hadir / $bil_staff) * 100,0);
					}
					else
					{
						//takde percent
						$output_percent_ketidakhadiran = 0;
					}
					
		$output_to_send = '[{"bil_staff":"'.$bil_staff.'","bil_tdk_hadir":"'.$bil_tdk_hadir.'","bil_bercuti":"'.$bil_bercuti.'","peratus_tdk_hadir":"'.$output_percent_ketidakhadiran.'%"}]';
	break;
	
	case '35'://select log tracking
	
		$nokp = $JsonSystem->getGETPOST('nokp');
		$tarikh = $JsonSystem->getGETPOST('tarikh');
		
		if($tarikh != "")
		{
			$sql = "SELECT DATE_FORMAT(m.masa_masuk,'%r') AS masa_masuk, 
				m.lokasi_masuk
				FROM masa_kehadiran m 
				LEFT JOIN kehadiran k ON m.id_kehadiran=k.id
				WHERE k.nokp_staff = '$nokp' AND 
				DATE_FORMAT(m.masa_masuk,'%Y-%m-%d')='$tarikh' 
				ORDER BY m.masa_masuk DESC";
		
				$result = $connjson->query($sql);
		
				echo '[';
				
					if($result->num_rows > 0)//ada data
					{
						$i = 0;
						
						while($data = $result->fetch_assoc()) {
							
							if($i>0)
								echo ',';
							$i++;
							
							$geocode = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$data['lokasi_masuk']."&sensor=false&key=AIzaSyBLTdGQxl-f5ARZpMAIVrzSZepLf7TjNis";
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
							
							$data['address'] = $address;
							
							echo json_encode($data);
						}
					}
					
					echo ']';
		}
		else
		{
			$sql = "SELECT DATE_FORMAT(m.masa_masuk,'%r') AS masa_masuk, 
				m.lokasi_masuk
				FROM masa_kehadiran m 
				LEFT JOIN kehadiran k ON m.id_kehadiran=k.id
				WHERE k.nokp_staff = '$nokp' AND 
				DATE(m.masa_masuk)=CURRENT_DATE 
				ORDER BY m.masa_masuk DESC";
		
				$result = $connjson->query($sql);
		
				echo '[';
				
					if($result->num_rows > 0)//ada data
					{
						$i = 0;
						
						while($data = $result->fetch_assoc()) {
							
							if($i>0)
								echo ',';
							$i++;
							
							$geocode = "https://maps.googleapis.com/maps/api/geocode/json?latlng=".$data['lokasi_masuk']."&sensor=false&key=AIzaSyBLTdGQxl-f5ARZpMAIVrzSZepLf7TjNis";
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
							
							$data['address'] = $address;
							
							echo json_encode($data);
						}
					}
					
					echo ']';
		}
		
		
	break;
	
	case '36'://analisa kehadiran harian
	
		$tarikh = $JsonSystem->getGETPOST('tarikh');
		
		$sql = "SELECT mk.id_kehadiran,s.`name`,s.noic,s.phone,r.`role` AS department_id,k.status_kehadiran,
				DATE_FORMAT(MIN(mk.masa_masuk),'%d-%m-%Y  %r') AS masa_masuk, 
				IFNULL(DATE_FORMAT(MAX(mk.masa_keluar),'%d-%m-%Y  %r'),'BELUM LOG') AS masa_keluar,
				MIN(mk.lokasi_masuk) AS lokasi_masuk, IFNULL(MAX(mk.lokasi_keluar),'0,0') AS lokasi_keluar,
				MIN(mk.remark_masuk) AS remark_masuk, IFNULL(MAX(mk.remark_keluar),'-') AS remark_keluar,
				MIN(mk.device_masuk) AS device_masuk, IFNULL(MAX(mk.device_keluar),'-') AS device_keluar,IFNULL(k.sebab_kelewatan,'-') AS sebab_kelewatan
				FROM masa_kehadiran mk 
				LEFT JOIN kehadiran k ON k.id=mk.id_kehadiran
				LEFT JOIN staff s ON k.nokp_staff=s.noic
				LEFT JOIN role r ON r.`code` = s.role_id
				WHERE DATE_FORMAT(k.created_date,'%Y-%m-%d')='$tarikh'
				AND s.status = 'BEKERJA' AND s.pantau_kehadiran ='1' 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN') GROUP BY k.nokp_staff
				ORDER BY k.created_date DESC";
		
				$result = $connjson->query($sql);
		
				echo '[';
				
					if($result->num_rows > 0)//ada data
					{
						$i = 0;
						
						while($data = $result->fetch_assoc()) {
							
							if($i>0)
								echo ',';
							$i++;
							
							$nokp_staff = $data['noic'];
							
							/*$sql2 = "SELECT (SELECT CASE 
							WHEN TIME_TO_SEC(TIMEDIFF(MAX(DATE_FORMAT(m.masa_keluar,'%H:%i:%s')),MIN(DATE_FORMAT(m.masa_masuk,'%H:%i:%s'))))-SUM(TIME_TO_SEC(total_time)) > TIME_TO_SEC('01:00:00') 
							THEN SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))) 
							ELSE SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))-(TIME_TO_SEC('01:00:00')-(TIME_TO_SEC(TIMEDIFF(MAX(DATE_FORMAT(m.masa_keluar,'%H:%i:%s')),MIN(DATE_FORMAT(m.masa_masuk,'%H:%i:%s'))))-SUM(TIME_TO_SEC(total_time))))) END) AS total_masa_bekerja,
							(SELECT CASE 
							WHEN TIME_TO_SEC(TIMEDIFF(MAX(DATE_FORMAT(m.masa_keluar,'%H:%i:%s')),MIN(DATE_FORMAT(m.masa_masuk,'%H:%i:%s'))))-SUM(TIME_TO_SEC(total_time)) > TIME_TO_SEC('01:00:00') 
							THEN TIMEDIFF(SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))),s.jum_jam_bekerja) 
							ELSE TIMEDIFF(SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))-(TIME_TO_SEC('01:00:00')-(TIME_TO_SEC(TIMEDIFF(MAX(DATE_FORMAT(m.masa_keluar,'%H:%i:%s')),MIN(DATE_FORMAT(m.masa_masuk,'%H:%i:%s'))))-SUM(TIME_TO_SEC(total_time))))),'08:00:00') END) AS total_beza
							FROM kehadiran k
							LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran
							LEFT JOIN staff s ON k.nokp_staff=s.noic
							WHERE DATE_FORMAT(k.created_date,'%Y-%m-%d')='$tarikh'
							AND k.nokp_staff='$nokp_staff'";
							*/
							
							
							//edit 04072020
							$sql2 = "SELECT SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))-TIME_TO_SEC(s.jum_jam_break)) AS total_masa_bekerja,
								TIMEDIFF(SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))-TIME_TO_SEC(s.jum_jam_break)),s.jum_jam_kerja) AS total_beza
								FROM kehadiran k
								LEFT JOIN staff s ON k.nokp_staff=s.noic
								LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
								WHERE DATE_FORMAT(k.created_date,'%Y-%m-%d')='$tarikh'
								AND k.nokp_staff='$nokp_staff'";
							
							$result2 = $connjson->query($sql2);
							
							$dataarray = $result2->fetch_assoc();
		
							if ($dataarray['total_masa_bekerja'] != null && $dataarray['total_beza'] != null) {
								
								$total_masa_bekerja = $dataarray['total_masa_bekerja'];
								$total_beza = $dataarray['total_beza'];

							} else {
								$total_masa_bekerja = '00:00:00';
								$total_beza = '00:00:00';
							}
							
							$data['total_masa_bekerja'] = $total_masa_bekerja;
							$data['total_beza'] = $total_beza;
							
							echo json_encode($data);
						}
					}
					
				echo ']';
	break;
	
	case '37'://analisa keseluruhan lewat,awal,tepat,bercuti,takhadir
	
	$cawangan = $JsonSystem->getGETPOST('cawangan');
	$department = $JsonSystem->getGETPOST('department');
	$status = $JsonSystem->getGETPOST('status');
	
	if($status == 'AWAL')
	{
		if($cawangan == '' && $department == '')//not select any
		{
			$sql = "SELECT s.`name`,s.phone,r.`role` AS department_id,d.description AS jabatan,
				DATE_FORMAT(k.created_date,'%r') AS masa_masuk
				FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic
				LEFT JOIN role r ON r.`code` = s.role_id
				LEFT JOIN department d ON d.code_department = s.department_id  
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND s.pantau_kehadiran='1' 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
				AND k.status_kehadiran='AWAL'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d') 
				ORDER BY k.created_date DESC";
				
			$output = $JsonSystem->getJSONData($sql,'',null);
		
		}
		else if($cawangan != '' && $department == '')//select cawangan
		{
			$sql = "SELECT s.`name`,s.phone,r.`role` AS department_id,d.description AS jabatan,
				DATE_FORMAT(k.created_date,'%r') AS masa_masuk
				FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic
				LEFT JOIN role r ON r.`code` = s.role_id
				LEFT JOIN department d ON d.code_department = s.department_id  
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND s.pantau_kehadiran='1' 
				AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
				AND k.status_kehadiran='AWAL'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d') 
				ORDER BY k.created_date DESC";
			$output = $JsonSystem->getJSONData($sql,'',null);
					
		}
		else //select cawangan & department
		{
			$sql = "SELECT s.`name`,s.phone,r.`role` AS department_id,d.description AS jabatan,
				DATE_FORMAT(k.created_date,'%r') AS masa_masuk
				FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic
				LEFT JOIN role r ON r.`code` = s.role_id
				LEFT JOIN department d ON d.code_department = s.department_id  
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND s.pantau_kehadiran='1' 
				AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
				AND s.department_id = '$department'
				AND k.status_kehadiran='AWAL'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d') 
				ORDER BY k.created_date DESC";
			$output = $JsonSystem->getJSONData($sql,'',null);
		}
	}
	
	if($status == 'TEPAT')
	{
		if($cawangan == '' && $department == '')//not select any
		{
			$sql = "SELECT s.`name`,s.phone,r.`role` AS department_id,d.description AS jabatan,
				DATE_FORMAT(k.created_date,'%r') AS masa_masuk
				FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic
				LEFT JOIN role r ON r.`code` = s.role_id
				LEFT JOIN department d ON d.code_department = s.department_id  
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND s.pantau_kehadiran='1' 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
				AND k.status_kehadiran='TEPAT'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d') 
				ORDER BY k.created_date DESC";
			$output = $JsonSystem->getJSONData($sql,'',null);
		
		}
		else if($cawangan != '' && $department == '')//select cawangan
		{
			$sql = "SELECT s.`name`,s.phone,r.`role` AS department_id,d.description AS jabatan,
				DATE_FORMAT(k.created_date,'%r') AS masa_masuk
				FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic
				LEFT JOIN role r ON r.`code` = s.role_id
				LEFT JOIN department d ON d.code_department = s.department_id  
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND s.pantau_kehadiran='1' 
				AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
				AND k.status_kehadiran='TEPAT'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d') 
				ORDER BY k.created_date DESC";
			$output = $JsonSystem->getJSONData($sql,'',null);
					
		}
		else //select cawangan & department
		{
			$sql = "SELECT s.`name`,s.phone,r.`role` AS department_id,d.description AS jabatan,
				DATE_FORMAT(k.created_date,'%r') AS masa_masuk
				FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic
				LEFT JOIN role r ON r.`code` = s.role_id
				LEFT JOIN department d ON d.code_department = s.department_id  
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND s.pantau_kehadiran='1' 
				AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
				AND s.department_id = '$department'
				AND k.status_kehadiran='TEPAT'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d') 
				ORDER BY k.created_date DESC";
			$output = $JsonSystem->getJSONData($sql,'',null);
		}
	}
	
	if($status == 'LEWAT')
	{
		if($cawangan == '' && $department == '')//not select any
		{
			$sql = "SELECT s.`name`,s.phone,r.`role` AS department_id,d.description AS jabatan,
				DATE_FORMAT(k.created_date,'%r') AS masa_masuk
				FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic
				LEFT JOIN role r ON r.`code` = s.role_id
				LEFT JOIN department d ON d.code_department = s.department_id   
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND s.pantau_kehadiran='1' 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
				AND k.status_kehadiran='LEWAT'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d') 
				ORDER BY k.created_date DESC";
			$output = $JsonSystem->getJSONData($sql,'',null);
		
		}
		else if($cawangan != '' && $department == '')//select cawangan
		{
			$sql = "SELECT s.`name`,s.phone,r.`role` AS department_id,d.description AS jabatan,
				DATE_FORMAT(k.created_date,'%r') AS masa_masuk
				FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic
				LEFT JOIN role r ON r.`code` = s.role_id
				LEFT JOIN department d ON d.code_department = s.department_id    
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND s.pantau_kehadiran='1' 
				AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
				AND k.status_kehadiran='LEWAT'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d') 
				ORDER BY k.created_date DESC";
			$output = $JsonSystem->getJSONData($sql,'',null);
					
		}
		else //select cawangan & department
		{
			$sql = "SELECT s.`name`,s.phone,r.`role` AS department_id,d.description AS jabatan,
				DATE_FORMAT(k.created_date,'%r') AS masa_masuk
				FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic
				LEFT JOIN role r ON r.`code` = s.role_id
				LEFT JOIN department d ON d.code_department = s.department_id   
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND s.pantau_kehadiran='1' 
				AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
				AND s.department_id = '$department'
				AND k.status_kehadiran='LEWAT'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d') 
				ORDER BY k.created_date DESC";
			$output = $JsonSystem->getJSONData($sql,'',null);
		}
	}
	
	if($status == 'BERCUTI')
	{
		if($cawangan == '' && $department == '')//not select any
		{
			$sql = "SELECT s.`name`,s.phone,r.`role` AS department_id,d.description AS jabatan,c.`desc` AS cuti_dipohon FROM staff s
					LEFT JOIN role r ON r.`code` = s.role_id 
					LEFT JOIN department d ON d.code_department = s.department_id  
					LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
					LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
					LEFT JOIN jenis_cuti c ON c.code = sh.cuti_dipohon
					LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
					WHERE hp.approvement = 'APPROVE' 
					AND CURRENT_DATE BETWEEN DATE(sh.tarikh_mula) AND DATE(sh.tarikh_akhir) 
					AND s.status = 'BEKERJA' AND s.pantau_kehadiran ='1' 
					AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
			$output = $JsonSystem->getJSONData($sql,'',null);
		
		}
		else if($cawangan != '' && $department == '')//select cawangan
		{
			$sql = "SELECT s.`name`,s.phone,r.`role` AS department_id,d.description AS jabatan,c.`desc` AS cuti_dipohon FROM staff s
					LEFT JOIN role r ON r.`code` = s.role_id 
					LEFT JOIN department d ON d.code_department = s.department_id  
					LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
					LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
					LEFT JOIN jenis_cuti c ON c.code = sh.cuti_dipohon
					LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
					WHERE hp.approvement = 'APPROVE' 
					AND CURRENT_DATE BETWEEN DATE(sh.tarikh_mula) AND DATE(sh.tarikh_akhir) 
					AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
					s.status = 'BEKERJA' AND s.pantau_kehadiran ='1' 
					AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
			$output = $JsonSystem->getJSONData($sql,'',null);
					
		}
		else //select cawangan & department
		{
			$sql = "SELECT s.`name`,s.phone,r.`role` AS department_id,d.description AS jabatan,c.`desc` AS cuti_dipohon FROM staff s
					LEFT JOIN role r ON r.`code` = s.role_id 
					LEFT JOIN department d ON d.code_department = s.department_id  
					LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
					LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
					LEFT JOIN jenis_cuti c ON c.code = sh.cuti_dipohon
					LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
					WHERE hp.approvement = 'APPROVE' 
					AND CURRENT_DATE BETWEEN DATE(sh.tarikh_mula) AND DATE(sh.tarikh_akhir) 
					AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
					AND s.department_id = '$department' AND s.status = 'BEKERJA' AND s.pantau_kehadiran ='1' 
					AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
			$output = $JsonSystem->getJSONData($sql,'',null);
		}
	}
	
	if($status == 'TIDAK HADIR')
	{
		if($cawangan == '' && $department == '')//not select any
		{
			$sql = "SELECT s.`name`,s.phone,r.`role` AS department_id,d.description AS jabatan FROM staff s 
					LEFT JOIN role r ON r.`code` = s.role_id
					LEFT JOIN department d ON d.code_department = s.department_id  
					WHERE s.noic NOT IN (SELECT k.nokp_staff FROM kehadiran k WHERE DATE(k.created_date) = CURRENT_DATE)
					AND s.noic NOT IN (SELECT s.noic FROM staff s
					LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
					LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
					LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
					WHERE hp.approvement = 'APPROVE' 
					AND CURRENT_DATE BETWEEN DATE(sh.tarikh_mula) AND DATE(sh.tarikh_akhir))
					AND s.status = 'BEKERJA' AND s.pantau_kehadiran ='1' 
					AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
			$output = $JsonSystem->getJSONData($sql,'',null);
		
		}
		else if($cawangan != '' && $department == '')//select cawangan
		{
			$sql = "SELECT s.`name`,s.phone,r.`role` AS department_id,d.description AS jabatan FROM staff s 
					LEFT JOIN role r ON r.`code` = s.role_id
					LEFT JOIN department d ON d.code_department = s.department_id
					WHERE s.noic NOT IN (SELECT k.nokp_staff FROM kehadiran k WHERE DATE(k.created_date) = CURRENT_DATE)
					AND s.noic NOT IN (SELECT s.noic FROM staff s
					LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
					LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
					LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
					WHERE hp.approvement = 'APPROVE' 
					AND CURRENT_DATE BETWEEN DATE(sh.tarikh_mula) AND DATE(sh.tarikh_akhir))
					AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
					AND s.status = 'BEKERJA' AND s.pantau_kehadiran ='1' 
					AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
			$output = $JsonSystem->getJSONData($sql,'',null);
					
		}
		else //select cawangan & department
		{
			$sql = "SELECT s.`name`,s.phone,r.`role` AS department_id,d.description AS jabatan FROM staff s 
					LEFT JOIN role r ON r.`code` = s.role_id
					LEFT JOIN department d ON d.code_department = s.department_id
					WHERE s.noic NOT IN (SELECT k.nokp_staff FROM kehadiran k WHERE DATE(k.created_date) = CURRENT_DATE)
					AND s.noic NOT IN (SELECT s.noic FROM staff s
					LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
					LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
					LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
					WHERE hp.approvement = 'APPROVE' 
					AND CURRENT_DATE BETWEEN DATE(sh.tarikh_mula) AND DATE(sh.tarikh_akhir))
					AND s.cawangan_kod = (SELECT a.cawangan_kod FROM lkp_cawangan a WHERE a.nama ='$cawangan') 
					AND s.department_id = '$department' AND s.status = 'BEKERJA' AND s.pantau_kehadiran ='1' 
					AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
			$output = $JsonSystem->getJSONData($sql,'',null);
		}
	}
	
	$output_to_send = "[{$output}]";
	break;
	
	case '38'://select baki cuti tahunan
	
		$no_staff = $JsonSystem->getGETPOST('no_staff');
		
		$sql="SELECT j.`desc` AS jenis,stc.total_cuti,stc.baki_cuti,stc.baki_cuti_pohon 
			FROM staff_total_cuti stc
			LEFT JOIN staff_record sr ON stc.staff_record_id=sr.id 
			LEFT JOIN jenis_cuti j ON stc.`jenis_cuti`= j.code 
			WHERE sr.no_staff= '$no_staff' AND stc.tahun = YEAR(CURRENT_DATE) AND j.code IN ('AL','MC')";
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '39'://select senarai cuti tahunan
	
		$no_staff = $JsonSystem->getGETPOST('no_staff');
		
		$sql="SELECT jc.`desc` AS nama_cuti,DATE_FORMAT(sh.tarikh_mula,'%d-%m-%Y') AS tarikh_mula,
				DATE_FORMAT(sh.tarikh_akhir,'%d-%m-%Y') AS tarikh_akhir,CONCAT(sh.jumlah_cuti,' HARI') as jumlah_cuti,UPPER(sh.sebab) AS sebab,
				UPPER(sh.alamat_cuti) AS alamat_cuti,
				sh.telepon, ha.approvement,ha.catatan FROM staff_holiday sh 
                LEFT JOIN holiday_approve ha ON ha.staff_holiday_id=sh.id
                LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id 
                LEFT JOIN jenis_kelulusan jk ON jk.code=ha.approvement
                LEFT JOIN jenis_cuti jc ON jc.code=sh.cuti_dipohon
                WHERE sr.no_staff='$no_staff'
                AND DATE_FORMAT(sh.tarikh_mula,'%Y') >= DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')
                ORDER BY sh.tarikh_mula DESC";
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '40'://select jenis cuti
	
		$sql="SELECT CONCAT(jc.code, '-', jc.`desc`) AS jenis_cuti FROM jenis_cuti jc";
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '41'://mohon cuti
	
		$no_staff = $JsonSystem->getGETPOST('no_staff');
		$department_id = $JsonSystem->getGETPOST('department_id');
		$sebab = $JsonSystem->getGETPOST('sebab');
		$alamat_cuti = $JsonSystem->getGETPOST('alamat');
		$telepon = $JsonSystem->getGETPOST('notel');
		$tarikh_mula = $JsonSystem->getGETPOST('tarikh_mula');
		$tarikh_akhir = $JsonSystem->getGETPOST('tarikh_akhir');
		$jumlah_cuti = $JsonSystem->getGETPOST('jum_cuti');
		$cuti_dipohon = $JsonSystem->getGETPOST('jenis_cuti');
		
		$sql_sr_rule = "SELECT sr.id,sr.rule_cuti FROM staff_record sr WHERE sr.no_staff = '$no_staff'";
				$result_sr_rule = $connjson->query($sql_sr_rule);
				
				$data_rule = $result_sr_rule->fetch_assoc();
				$sr_rule = $data_rule['rule_cuti'];
				//echo $sr_rule = $result_sr_rule->fetch_object()->rule_cuti;
				$staff_record_id = $data_rule['id'];
				
		$sql_check = "SELECT stc.jenis_cuti
		FROM staff_total_cuti stc
		LEFT JOIN staff_record sr ON stc.staff_record_id=sr.id
		WHERE stc.tahun = YEAR(CURRENT_DATE) AND sr.no_staff= '$no_staff'";
		
		$result_check = $connjson->query($sql_check);
		if($result_check->num_rows > 0)//ada data
		{
			//check jenis cuti yg apply ada ke tak
			$sql="SELECT stc.id AS staff_total_cuti_id,stc.baki_cuti_pohon
			FROM staff_total_cuti stc
			LEFT JOIN staff_record sr ON stc.staff_record_id=sr.id
			WHERE stc.tahun = YEAR(CURRENT_DATE) AND stc.`jenis_cuti`='$cuti_dipohon' AND sr.no_staff= '$no_staff'";
			$result = $JsonSystem->getData($sql);
			
			if(count($result)> 0)//ada data
			{
				$staff_total_cuti_id = $result[0];
				$baki_cuti = $result[1];
				
				$baki_cuti_pohon = $baki_cuti - $jumlah_cuti;
				
				//isi maklumat cuti pekerja
				$sql1 ="INSERT INTO staff_holiday
					  (staff_record_id,department_id,alamat_cuti,telepon,cuti_dipohon,tarikh_mula,tarikh_akhir,sebab,jumlah_cuti) 
					  VALUES ('$staff_record_id','$department_id','$alamat_cuti','$telepon','$cuti_dipohon','$tarikh_mula','$tarikh_akhir','$sebab','$jumlah_cuti')";
					  
				$connjson->query($sql1);
				$staff_holiday_id = $connjson->insert_id;
				
				//query insert data ke table holiday_approve
				$sql2 ="INSERT INTO holiday_approve(staff_holiday_id,approvement) VALUES('$staff_holiday_id','SD')";
				$result2 = $connjson->query($sql2);
				
				$sql3="UPDATE staff_total_cuti_1 SET baki_cuti_pohon='$baki_cuti_pohon' WHERE id='$staff_total_cuti_id'";
				$result3 = $connjson->query($sql3);
				
				$output_to_send = "Permohonan berjaya ditambah.";
			}
			else//takada data cuti
			{
				//insert into staff total cuti new row
				$sql_rule = "SELECT jc.$sr_rule AS total_cuti FROM jenis_cuti jc WHERE jc.code='$cuti_dipohon'";
				$result_rule = $connjson->query($sql_rule);
				$total_cuti_baru = $result_rule->fetch_object()->total_cuti;
				
				$sql_new_cuti ="INSERT INTO staff_total_cuti_1 (staff_record_id,`jenis_cuti`,total_cuti,baki_cuti,baki_cuti_pohon,tahun) 
						VALUES ('$staff_record_id','$cuti_dipohon','$total_cuti_baru','$total_cuti_baru','$total_cuti_baru',YEAR(CURRENT_DATE))";
				$connjson->query($sql_new_cuti);
				$staff_total_cuti_id = $connjson->insert_id;
				$baki_cuti = $total_cuti_baru;
				
				$baki_cuti_pohon = $baki_cuti - $jumlah_cuti;
				
				//isi maklumat cuti pekerja
				$sql1 ="INSERT INTO staff_holiday
					  (staff_record_id,department_id,alamat_cuti,telepon,cuti_dipohon,tarikh_mula,tarikh_akhir,sebab,jumlah_cuti) 
					  VALUES ('$staff_record_id','$department_id','$alamat_cuti','$telepon','$cuti_dipohon','$tarikh_mula','$tarikh_akhir','$sebab','$jumlah_cuti')";
					  
				$connjson->query($sql1);
				$staff_holiday_id = $connjson->insert_id;
				
				//query insert data ke table holiday_approve
				$sql2 ="INSERT INTO holiday_approve(staff_holiday_id,approvement) VALUES('$staff_holiday_id','SD')";
				$result2 = $connjson->query($sql2);
				
				$sql3="UPDATE staff_total_cuti_1 SET baki_cuti_pohon='$baki_cuti_pohon' WHERE id='$staff_total_cuti_id'";
				$result3 = $connjson->query($sql3);
				
				$output_to_send = "Permohonan berjaya ditambah.";
			}
		}
		else
		{
			//select AL,MC,EL total cuti
			$sql_rule1 = "SELECT jc.$sr_rule AS total_cuti_AL FROM jenis_cuti jc WHERE jc.code='AL'";
				$result_rule1 = $connjson->query($sql_rule1);
				$total_cuti_AL = $result_rule1->fetch_object()->total_cuti_AL;
				
			$sql_rule2= "SELECT jc.$sr_rule AS total_cuti_MC FROM jenis_cuti jc WHERE jc.code='MC'";
				$result_rule2 = $connjson->query($sql_rule2);
				$total_cuti_MC= $result_rule2->fetch_object()->total_cuti_MC;
				
			$sql_tambah="INSERT INTO staff_total_cuti_1 (staff_record_id,`jenis_cuti`,total_cuti,baki_cuti,baki_cuti_pohon,tahun) 
						VALUES ('$staff_record_id','AL','$total_cuti_AL','$total_cuti_AL','$total_cuti_AL',YEAR(CURRENT_DATE)),
						('$staff_record_id','MC','$total_cuti_MC','$total_cuti_MC','$total_cuti_MC',YEAR(CURRENT_DATE))";
			$connjson->query($sql_tambah);
			
			if($cuti_dipohon =='AL' || $cuti_dipohon =='MC') //insert new cuti pohon
			{
				$sql="SELECT stc.id AS staff_total_cuti_id,stc.baki_cuti_pohon
				FROM staff_total_cuti stc
				WHERE stc.tahun = YEAR(CURRENT_DATE) AND stc.`jenis_cuti`='$cuti_dipohon' AND stc.staff_record_id='$staff_record_id'";
				$result = $JsonSystem->getData($sql);
				$staff_total_cuti_id = $result[0];
				$baki_cuti = $result[1];
			}
			else//select from AL / MC
			{
				$sql_rule3 = "SELECT jc.$sr_rule AS total_cuti FROM jenis_cuti jc WHERE jc.code='$cuti_dipohon'";
				$result_rule3 = $connjson->query($sql_rule3);
				$total_cuti_baru = $result_rule3->fetch_object()->total_cuti;
				
				//insert AL ,MC dan jenis cuti yg diapply
					$sql="INSERT INTO staff_total_cuti_1 (staff_record_id,`jenis_cuti`,total_cuti,baki_cuti,baki_cuti_pohon,tahun) 
								VALUES ('$staff_record_id','$cuti_dipohon','$total_cuti_baru','$total_cuti_baru','$total_cuti_baru',YEAR(CURRENT_DATE))";
					$connjson->query($sql);
					$staff_total_cuti_id = $connjson->insert_id;
					$baki_cuti = $total_cuti_baru;
			}
			
				$baki_cuti_pohon = $baki_cuti - $jumlah_cuti;
				//isi maklumat cuti pekerja
				$sql1 ="INSERT INTO staff_holiday
					  (staff_record_id,department_id,alamat_cuti,telepon,cuti_dipohon,tarikh_mula,tarikh_akhir,sebab,jumlah_cuti) 
					  VALUES ('$staff_record_id','$department_id','$alamat_cuti','$telepon','$cuti_dipohon','$tarikh_mula','$tarikh_akhir','$sebab','$jumlah_cuti')";
					  
				$connjson->query($sql1);
				$staff_holiday_id = $connjson->insert_id;
				
				//query insert data ke table holiday_approve
				$sql2 ="INSERT INTO holiday_approve(staff_holiday_id,approvement) VALUES('$staff_holiday_id','SD')";
				$result2 = $connjson->query($sql2);
				
				$sql3="UPDATE staff_total_cuti_1 SET baki_cuti_pohon='$baki_cuti_pohon' WHERE id='$staff_total_cuti_id'";
				$result3 = $connjson->query($sql3);
				
				$output_to_send = "Permohonan berjaya ditambah.";
		}
	break;
	
	case '42'://select senarai kelulusan cuti
	
	$no_staff = $JsonSystem->getGETPOST('no_staff');
	
		$sql="SELECT sh.id,sr.id AS staff_record_id,s.name,s.noic,s.no_staff, jc.`desc` AS nama_cuti,DATE_FORMAT(sh.tarikh_mula,'%d-%m-%Y') AS tarikh_mula,
				DATE_FORMAT(sh.tarikh_akhir,'%d-%m-%Y') AS tarikh_akhir,
				CONCAT(sh.jumlah_cuti,' HARI') AS jumlah_cuti,
				CONCAT('( BAKI CUTI SEMASA: ',(SELECT stc.baki_cuti FROM staff_total_cuti stc WHERE stc.staff_record_id=sr.id 
				AND stc.`jenis_cuti`=jc.code),' HARI ',')') AS baki_cuti_semasa,
				UPPER(sh.sebab) AS sebab,UPPER(sh.alamat_cuti) AS alamat_cuti,sh.telepon, ha.approvement,ha.catatan 
				FROM staff_holiday sh 
                LEFT JOIN holiday_approve ha ON ha.staff_holiday_id=sh.id
                LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id 
                LEFT JOIN staff s ON s.no_staff=sr.no_staff
                LEFT JOIN jenis_kelulusan jk ON jk.code=ha.approvement
                LEFT JOIN jenis_cuti jc ON jc.code=sh.cuti_dipohon
                WHERE ha.approvement = 'SD' AND s.leave_approval = '$no_staff' AND s.status = 'BEKERJA' ORDER BY sh.tarikh_mula ASC";
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '43'://update kelulusan cuti
	
	$staff_holiday_id = $JsonSystem->getGETPOST('staff_holiday_id');
	$no_staff = $JsonSystem->getGETPOST('no_staff');
	$approvement = $JsonSystem->getGETPOST('approvement');
	$staff_record_id = $JsonSystem->getGETPOST('staff_record_id');
	$jumlah_cuti = $JsonSystem->getGETPOST('jumlah_cuti');
	$cuti_dipohon = $JsonSystem->getGETPOST('jenis_cuti');
	
	$sql = "SELECT stc.baki_cuti,stc.baki_cuti_pohon,j.code,stc.id
			FROM staff_total_cuti stc LEFT JOIN jenis_cuti j ON stc.`jenis_cuti`= j.code 
			WHERE stc.staff_record_id='$staff_record_id' AND j.`desc`='$cuti_dipohon' AND stc.tahun = YEAR(CURRENT_DATE)";
	
	$result = $JsonSystem->getData($sql);
		
		if(count($result)> 0)//ada data
		{
			$baki_cuti = $result[0];
			$baki_cuti_pohon = $result[1];
			$jenis_cuti = $result[2];
			$staff_total_cuti_id = $result[3];
			
			$update_baki = "";
			
			 $sql3 ="SELECT sh.jumlah_cuti FROM staff_holiday sh WHERE sh.id = '$staff_holiday_id'";
			 $result3 = $JsonSystem->getData($sql3);
			 $jum_cuti = $result3[0];
			
			if($approvement == 'APPROVE')
			{
				$update_baki = $baki_cuti - $jum_cuti;
				
				$sql1="UPDATE staff_total_cuti_1 SET baki_cuti='$update_baki' WHERE id='$staff_total_cuti_id'";
				$connjson->query($sql1);
			}
			else
			{
				$update_baki = $baki_cuti_pohon + $jum_cuti;
				
				$sql1="UPDATE staff_total_cuti_1 SET baki_cuti_pohon='$update_baki' WHERE id='$staff_total_cuti_id'";
				$connjson->query($sql1);
			}
			
			$sql2="UPDATE holiday_approve SET approvement='$approvement',catatan='TINDAKAN KELULUSAN DIBUAT MELALUI MOBILE',approve_by='$no_staff',tarikh_approve=CURRENT_TIMESTAMP 
			WHERE staff_holiday_id='$staff_holiday_id'";
			$connjson->query($sql2);
			
			$output_to_send = "Berjaya disimpan.";
		}
		else
		{
			$output_to_send = "Gagal.";
		}
	
	break;
	
	case '44'://check role kelulusan cuti
	
		$role_id = $JsonSystem->getGETPOST('role_id');
		$no_staff = $JsonSystem->getGETPOST('no_staff');
		
		$sql="SELECT * FROM sec_role_menu a WHERE a.role_code = '{$role_id}'
			AND a.access_menu = '1'
			AND a.menu_id IN (SELECT b.id FROM sec_module_menu b WHERE b.module_code = 'SUMBERMANUSIA' 
			AND  b.menu = UPPER('KELULUSAN CUTI'))";
			
			$result = $connjson->query($sql);
		
					if($result->num_rows > 0)//ada data
					{
						$sql1="SELECT COUNT(sh.id) as bil_permohonan FROM staff_holiday sh 
							LEFT JOIN holiday_approve ha ON ha.staff_holiday_id=sh.id
							LEFT JOIN staff_record sr ON sr.id=sh.staff_record_id 
							LEFT JOIN staff s ON s.no_staff=sr.no_staff
							LEFT JOIN jenis_kelulusan jk ON jk.code=ha.approvement
							LEFT JOIN jenis_cuti jc ON jc.code=sh.cuti_dipohon
							WHERE ha.approvement = 'SD' AND s.leave_approval = '$no_staff' AND s.status = 'BEKERJA'";
							
							$output = $JsonSystem->getJSONData($sql1,'',null);
							$output_to_send = "[{$output}]";
					}
					else
					{
						$output_to_send = "[]";
					}
	break;
	
	case '45'://tugasan peribadi
	
	$nokp = $JsonSystem->getGETPOST('nokp');
	
	$month = date('Y-m');
	$sql_kategori = "SELECT ltk.code FROM lkp_task_kategori ltk";
	
	$result_kategori = $conn->query($sql_kategori);
	
	$a = 0;
	$output_kategori = "";
	$last_output_kategori = "";
	while($data =$result_kategori->fetch_assoc())//ada data
	{
		if($a>0)
		$output_kategori .=",";
		
		$output_kategori .="{";
		$a++;
		
		$kod = $data['code'];
		$output_kategori .='"'.$kod.'":"';				
		
		if($kod == 'DONE')
		{
			$sql="SELECT pt.id_task,UPPER(pt.tajuk) AS tajuk,
			DATE_FORMAT(pt.tarikh_mula,'%d-%m-%Y  %r') AS tarikh_mula,DATE_FORMAT(pt.tarikh_tamat,'%d-%m-%Y  %r') AS tarikh_tamat
			FROM projek_task pt 
			LEFT JOIN staff s ON pt.assigned_by=s.noic
			LEFT JOIN staff st ON pt.assigned_to=st.noic
			LEFT JOIN lkp_projek_kumpulan lpk ON pt.task_based=lpk.id_kumpulan
			WHERE pt.id_category = '$kod' 
			AND pt.assigned_to ='$nokp' 
			AND DATE_FORMAT(pt.tarikh_tamat,'%Y-%m') = '$month'";
			
			/*$sql="SELECT pt.id_task,pt.kod_projek,pt.kod_subprojek,UPPER(pt.tajuk) AS tajuk,UPPER(lpk.nama_kumpulan) AS kumpulan,
			s.name AS ditugaskan_oleh,st.name AS ditugaskan_kepada,
			DATE_FORMAT(pt.tarikh_mula,'%d-%m-%Y  %r') AS tarikh_mula,DATE_FORMAT(pt.tarikh_tamat,'%d-%m-%Y  %r') AS tarikh_tamat,
			CONCAT(pt.slack,' JAM') AS slack, pt.duration
			FROM projek_task pt 
			LEFT JOIN staff s ON pt.assigned_by=s.noic
			LEFT JOIN staff st ON pt.assigned_to=st.noic
			LEFT JOIN lkp_projek_kumpulan lpk ON pt.task_based=lpk.id_kumpulan
			WHERE pt.id_category = '$kod' 
			AND pt.assigned_to ='$nokp' 
			AND DATE_FORMAT(pt.tarikh_tamat,'%Y-%m') = '$month'";*/
		}
		
		if($kod != 'DONE')
		{
			$sql="SELECT pt.id_task,UPPER(pt.tajuk) AS tajuk,
			DATE_FORMAT(pt.tarikh_mula,'%d-%m-%Y  %r') AS tarikh_mula,DATE_FORMAT(pt.tarikh_tamat,'%d-%m-%Y  %r') AS tarikh_tamat
			FROM projek_task pt 
			LEFT JOIN staff s ON pt.assigned_by=s.noic
			LEFT JOIN staff st ON pt.assigned_to=st.noic
			LEFT JOIN lkp_projek_kumpulan lpk ON pt.task_based=lpk.id_kumpulan
			WHERE pt.id_category = '$kod' 
			AND pt.assigned_to ='$nokp'";
			
			/*$sql="SELECT pt.id_task,pt.kod_projek,pt.kod_subprojek,UPPER(pt.tajuk) AS tajuk,UPPER(lpk.nama_kumpulan) AS kumpulan,
			s.name AS ditugaskan_oleh,st.name AS ditugaskan_kepada,
			DATE_FORMAT(pt.tarikh_mula,'%d-%m-%Y  %r') AS tarikh_mula,DATE_FORMAT(pt.tarikh_tamat,'%d-%m-%Y  %r') AS tarikh_tamat,
			CONCAT(pt.slack,' JAM') AS slack, pt.duration
			FROM projek_task pt 
			LEFT JOIN staff s ON pt.assigned_by=s.noic
			LEFT JOIN staff st ON pt.assigned_to=st.noic
			LEFT JOIN lkp_projek_kumpulan lpk ON pt.task_based=lpk.id_kumpulan
			WHERE pt.id_category = '$kod' 
			AND pt.assigned_to ='$nokp'";*/
		}
			
			$result = $conn->query($sql);
			$output = "";
			$string ="";
			if($result->num_rows > 0)//ada data
			{
				$output = $JsonSystem->getJSONData($sql,'',null);
				$string = str_replace('"', '|', $output);
			}
							
		$output_kategori .='['.$string.']"}';
	}
	echo $last_output_kategori = '['.$output_kategori.']';
	
	break;
	
	/*case '46'://update tugasan peribadi
	
	$id_task = $JsonSystem->getGETPOST('id_task');
	$status_task = $JsonSystem->getGETPOST('status_task');
	
	if($status_task == 'DONE')
	{
		$sql = "UPDATE projek_task SET id_category='$status_task',
				duration=TIMEDIFF(DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d %H:%i:%s'),DATE_FORMAT(tarikh_mula,'%Y-%m-%d %H:%i:%s')),
				tarikh_tamat = CURRENT_TIMESTAMP where id_task = '$id_task'";
	}
	else
	{
		$sql = "UPDATE projek_task SET id_category='$status_task' where id_task = '$id_task'";
	}
	
	$JsonSystem->executeOperation2($sql);
	break;
	
	case '47'://dropdown projek utama,subprojek,kumpulan projek
	
	$last_output="";
	
		$sql1="SELECT CONCAT(p.kod_projek,'-',p.nama_projek) AS projek_utama FROM projek_internal p WHERE p.status_projek='1'";
		
		$result1 = $connjson->query($sql1);
		$output1 = "";
		$a=0;
		
		echo $last_output = '[{"projek_utama":"';
			while($data1 =$result1->fetch_assoc())//ada data
			{
				if($a>0)
				$output1 ="|";
				$a++;
				
				$projek_utama = $data1['projek_utama'];
				echo $output1 .=$projek_utama;
			}
		
		echo $last_output ='"},';
		
		$sql2="SELECT CONCAT(p.kod_projek,'-',p.nama_projek) AS subprojek FROM projek_internal p WHERE p.kod_projek_parent = '' AND p.status_projek='1'";
		
		$result2 = $connjson->query($sql2);
		$output2 = "";
		$b=0;
		
		echo $last_output = '{"subprojek":"';
			while($data2 =$result2->fetch_assoc())//ada data
			{
				if($b>0)
				$output2 ="|";
				$b++;
				
				$subprojek = $data2['subprojek'];
				echo $output2 .=$subprojek;
			}
			
		echo $last_output ='"},';
			
		$sql3="SELECT lpk.id_kumpulan,lpk.nama_kumpulan FROM lkp_projek_kumpulan lpk";
		
		$result3 = $connjson->query($sql3);
		$output3 = "";
		$d=0;
		
		echo $last_output = '{"kumpulan_projek":"';
			while($data3 =$result3->fetch_assoc())//ada data
			{
				if($d>0)
				$output3 ="|";
				$d++;
				
				$id_kumpulan = $data3['id_kumpulan'];
				$nama_kumpulan = $data3['nama_kumpulan'];
				echo $output3 .= $id_kumpulan.','.$nama_kumpulan;
			}
		echo $last_output ='"}]';
	break;
	
	case '48'://delete task peribadi
	
	$id = $JsonSystem->getGETPOST('id');
	$sql="DELETE FROM projek_task where id_task ='$id' ";
	$output = $JsonSystem->executeOperation2($sql);
	
	break;
	
	case '49'://search nama assigned_to
	
	$query = $JsonSystem->getGETPOST('query');
		$sql="SELECT UPPER(s.`name`) AS nama FROM staff s WHERE s.`status` = 'BEKERJA' AND (s.`name` LIKE '%$query%') ORDER BY s.`name` ASC";
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '50'://info tugasan peribadi
	
	$id = $JsonSystem->getGETPOST('id');
	
	$sql="SELECT pt.kod_projek,pt.kod_subprojek,ltk.nama_kategori,pt.tajuk,lpk.nama_kumpulan AS kumpulan,
			s.name AS ditugaskan_oleh,st.name AS ditugaskan_kepada,
			DATE_FORMAT(pt.tarikh_mula,'%d-%m-%Y  %r') AS tarikh_mula,DATE_FORMAT(pt.tarikh_tamat,'%d-%m-%Y  %r') AS tarikh_tamat,
			CONCAT(pt.slack,' JAM') AS slack, pt.duration
			FROM projek_task pt 
			LEFT JOIN staff s ON pt.assigned_by=s.noic
			LEFT JOIN staff st ON pt.assigned_to=st.noic
			LEFT JOIN lkp_projek_kumpulan lpk ON pt.task_based=lpk.id_kumpulan
			LEFT JOIN lkp_task_kategori ltk ON pt.id_category=ltk.code
			WHERE pt.id_task='$id'";
			
	$output = $JsonSystem->getJSONData($sql,'',null);
	$output_to_send = "[{$output}]";
			
	break;
	
	case '51'://send notifications
	
	$googleServerKey = "AAAAkmGGLX4:AAAAkmGGLX4:APA91bGnJClkPTrmORIgyY0oS2mf_DhHbXf_lht0IymtGRkxBXiNb29zuyQxBHHHgOpNvL8sIDdDx27WO0RnijU34bUI1NcmgrYQE-rV3QLYCydvddWm0uyxKSNn_aU2OVpxFPBTFrwI-rV3QLYCydvddWm0uyxKSNn_aU2OVpxFPBTFrwI";
	//Sets the serverKey variable to the googleServerKey variable in the serverKeyInfo.php script.
	$serverKey = $googleServerKey;
	
	//URL that we will send our message to for it to be processed by Firebase.
	$url = "https://fcm.googleapis.com/fcm/send";

	//Recipient of the message. This can be a device token (to send to an individual device) 
	//or a topic (to be sent to all devices subscribed to the specified topic).
	
	//$recipient = "/topics/all";
	//$recipient = $_POST['recipient'];
	$recipient = $JsonSystem->getGETPOST('recipient');
	
	//Structure of our notification that will be displayed on the user's screen if the app is in the background.
	$notification =
	[
		'title'   => "4th of July Sale!",
		'body'   => "All skins half off until July 7th. Discounts up to 60% !"
	];

	//Structure of the data that will be sent with the message but not visible to the user.
	//We can however use Unity to access this data.
	$dataPayload = 
	[
		"powerLevel" => "9001",
		"dataString" => "This is some string data"
	];
	
	//Full structure of message inculding target device(s), notification, and data.
	$fields = 
	[
		'to'  => $recipient,
		'notification' => $notification,
		'data' => $dataPayload
	];

	//Set the appropriate headers
	$headers = 
	[
	'Authorization: key=' . $serverKey,
	'Content-Type: application/json'
	];

	//Send the message using cURL.
	$ch = curl_init();
	curl_setopt( $ch,CURLOPT_URL, $url);
	curl_setopt( $ch,CURLOPT_POST, true );
	curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
	curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
	$result = curl_exec($ch );
	curl_close( $ch );
	
	//Result is printed to screen.
	echo $result;
	break;
	
	case '52'://check device id status aktif/tak aktif
	
	$device_id = $JsonSystem->getGETPOST('device_id');
	$nokp = $JsonSystem->getGETPOST('nokp');
	
	$sql="SELECT p.id FROM phone_authority p WHERE p.device_id ='$device_id' 
	AND p.nokp_staff='$nokp' AND p.status='1'";
			
	$output = $JsonSystem->getJSONData($sql,'',null);
	$output_to_send = "[{$output}]";
	
	break;
	
	case '53'://konfigurasi button kehadiran
	
	$company_id = $JsonSystem->getGETPOST('company_id');
	
	$sql = "SELECT kk.scan_qr_code,kk.scan_swafoto,kk.scan_manual FROM konfigurasi_kehadiran kk WHERE kk.company_id='$company_id'";
	
	$output = $JsonSystem->getJSONData($sql,'',null);
	$output_to_send = "[{$output}]";
	break;
	
	case '54'://SELECT KAKITANGAN BASED DEPARTMENT 
	
		$department = $JsonSystem->getGETPOST('department');
		
		$sql = "SELECT s.id,s.no_staff,s.noic,s.`name`,s.phone,r.`role` AS department_id FROM staff s 
					LEFT JOIN role r ON r.`code` = s.role_id
					WHERE s.department_id = '$department' AND s.status = 'BEKERJA' AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
					AND s.pantau_kehadiran='1'
					ORDER BY s.`name` ASC";
		
		
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
		
	break;*/
	
	
	case '55'://select kehadiran keseluruhan jabatan
	
	$department = $JsonSystem->getGETPOST('department');
		
			$awal = "SELECT COUNT(*) AS bil_awal FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic 
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND s.pantau_kehadiran='1' 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
				AND s.department_id = '$department'
				AND k.status_kehadiran='AWAL'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
				
				$_awal = $JsonSystem->getData($awal);
				$output_awal = $_awal[0];
				
			$tepat = "SELECT COUNT(*) AS bil_tepat FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic 
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND s.pantau_kehadiran='1' 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
				AND s.department_id = '$department'
				AND k.status_kehadiran='TEPAT'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
				
				$_tepat = $JsonSystem->getData($tepat);
				$output_tepat = $_tepat[0];
				
				
			$lewat = "SELECT COUNT(*) AS bil_lewat FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic 
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND s.pantau_kehadiran='1' 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
				AND s.department_id = '$department'
				AND k.status_kehadiran='LEWAT'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
				
				$_lewat = $JsonSystem->getData($lewat);
				$output_lewat = $_lewat[0];
				
			$bil_staff = "SELECT COUNT(*) AS bil_staff FROM staff s
				WHERE s.department_id = '$department' AND s.pantau_kehadiran='1' AND s.status = 'BEKERJA' 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
				
				$_bilangan_staff = $JsonSystem->getData($bil_staff);
				$output_bilangan_staff = $_bilangan_staff[0];
				
			$bil_bercuti = "SELECT COUNT(s.noic) AS bil_bercuti FROM staff s
					LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
					LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
					LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
					WHERE hp.approvement = 'APPROVE' 
					AND CURRENT_DATE BETWEEN DATE(sh.tarikh_mula) AND DATE(sh.tarikh_akhir) 
					AND s.department_id = '$department' AND s.status = 'BEKERJA' AND s.pantau_kehadiran ='1' 
					AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
					
					$_bil_bercuti = $JsonSystem->getData($bil_bercuti);
					$output_bilangan_bercuti = $_bil_bercuti[0];
				
		
		
		$output_jum_hadir = $output_awal + $output_tepat + $output_lewat;
		$output_bilangan_takhadir = $output_bilangan_staff - $output_jum_hadir - $output_bilangan_bercuti;	
		
		$output_percent_kehadiran = '';
		if($output_jum_hadir > 0)
		{
			//kira percent
			$output_percent_kehadiran = Round(($output_jum_hadir / $output_bilangan_staff) * 100,0);
		}
		else
		{
			//takde percent
			$output_percent_kehadiran = 0;
		}
		
		$output_to_send = '[{"bil_awal":"'.$output_awal.'","bil_tepat":"'.$output_tepat.'","bil_lewat":"'.$output_lewat.'","bil_staff":"'.$output_bilangan_staff.'","jum_hadir":"'.$output_jum_hadir.'","jum_tidak_hadir":"'.$output_bilangan_takhadir.'","jum_bercuti":"'.$output_bilangan_bercuti.'","percent_hadir":"'.$output_percent_kehadiran.'%"}]';
		
	break;
	
	case '56'://analisa keseluruhan lewat,awal,tepat,bercuti,takhadir mngikut jabatan
	
	$department = $JsonSystem->getGETPOST('department');
	$status = $JsonSystem->getGETPOST('status');
	
	if($status == 'AWAL')
	{
		$sql = "SELECT s.`name`,s.phone,r.`role` AS department_id,DATE_FORMAT(k.created_date,'%r') AS masa_masuk FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic
				LEFT JOIN role r ON r.`code` = s.role_id  
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND s.pantau_kehadiran='1' 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
				AND s.department_id = '$department'
				AND k.status_kehadiran='AWAL'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d') 
				ORDER BY k.created_date DESC";
			$output = $JsonSystem->getJSONData($sql,'',null);
	}
	
	if($status == 'TEPAT')
	{
		$sql = "SELECT s.`name`,s.phone,r.`role` AS department_id,DATE_FORMAT(k.created_date,'%r') AS masa_masuk FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic
				LEFT JOIN role r ON r.`code` = s.role_id  
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND s.pantau_kehadiran='1' 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
				AND s.department_id = '$department'
				AND k.status_kehadiran='TEPAT'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d') 
				ORDER BY k.created_date DESC";
			$output = $JsonSystem->getJSONData($sql,'',null);
	}
	
	if($status == 'LEWAT')
	{
		$sql = "SELECT s.`name`,s.phone,r.`role` AS department_id,DATE_FORMAT(k.created_date,'%r') AS masa_masuk FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic
				LEFT JOIN role r ON r.`code` = s.role_id  
				WHERE s.noic IS NOT NULL AND s.status='BEKERJA' 
				AND s.pantau_kehadiran='1' 
				AND s.role_id NOT IN ('ADMIN','SUPERADMIN') 
				AND s.department_id = '$department'
				AND k.status_kehadiran='LEWAT'
				AND DATE_FORMAT(k.created_date,'%Y-%m-%d')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d') 
				ORDER BY k.created_date DESC";
			$output = $JsonSystem->getJSONData($sql,'',null);
	}
	
	if($status == 'BERCUTI')
	{
		$sql = "SELECT s.`name`,s.phone,r.`role` AS department_id,c.`desc` AS cuti_dipohon FROM staff s
					LEFT JOIN role r ON r.`code` = s.role_id 
					LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
					LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
					LEFT JOIN jenis_cuti c ON c.code = sh.cuti_dipohon
					LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
					WHERE hp.approvement = 'APPROVE' 
					AND CURRENT_DATE BETWEEN DATE(sh.tarikh_mula) AND DATE(sh.tarikh_akhir) 
					AND s.department_id = '$department' AND s.status = 'BEKERJA' AND s.pantau_kehadiran ='1' 
					AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
			$output = $JsonSystem->getJSONData($sql,'',null);
	}
	
	if($status == 'TIDAK HADIR')
	{
		$sql = "SELECT s.`name`,s.phone,r.`role` AS department_id FROM staff s 
					LEFT JOIN role r ON r.`code` = s.role_id
					WHERE s.noic NOT IN (SELECT k.nokp_staff FROM kehadiran k WHERE DATE(k.created_date) = CURRENT_DATE)
					AND s.noic NOT IN (SELECT s.noic FROM staff s
					LEFT JOIN staff_record sr ON sr.no_staff=s.no_staff
					LEFT JOIN staff_holiday sh ON sh.staff_record_id = sr.id
					LEFT JOIN holiday_approve hp ON hp.staff_holiday_id = sh.id
					WHERE hp.approvement = 'APPROVE' 
					AND CURRENT_DATE BETWEEN DATE(sh.tarikh_mula) AND DATE(sh.tarikh_akhir))
					AND s.department_id = '$department' AND s.status = 'BEKERJA' AND s.pantau_kehadiran ='1' 
					AND s.role_id NOT IN ('ADMIN','SUPERADMIN')";
			$output = $JsonSystem->getJSONData($sql,'',null);
	}
	
	$output_to_send = "[{$output}]";
	break;
	
	
	case '57'://check role id PENGESAHAN KEHADIRAN
	
		$role_id = $JsonSystem->getGETPOST('role_id');
		
		$sql="SELECT * FROM sec_role_menu a WHERE a.role_code = '{$role_id}'
			AND a.access_menu = '1'
			AND a.menu_id IN (SELECT b.id FROM sec_module_menu b WHERE b.module_code = 'SUMBERMANUSIA' 
			AND  b.menu = UPPER('PENGURUSAN KEHADIRAN'))";
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '58'://insert sebab kelewatan
	
		$id_kehadiran = $JsonSystem->getGETPOST('id_kehadiran');
		$sebab_kelewatan = $JsonSystem->getGETPOST('sebab_kelewatan');
		
		$sql = "UPDATE kehadiran SET sebab_kelewatan = UPPER('$sebab_kelewatan') WHERE id = '$id_kehadiran'";
						
		$JsonSystem->executeOperation2($sql);
		$output_to_send = "Berjaya disimpan.";
	break;
	
	case '59'://data sebab kelewatan
	
		$id_kehadiran = $JsonSystem->getGETPOST('id_kehadiran');
		
		$sql="SELECT sebab_kelewatan FROM kehadiran WHERE id = '$id_kehadiran'";
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '60'://log pengesahan sebab
	
		$no_staff = $JsonSystem->getGETPOST('no_staff');
		
		$sql="SELECT k.id,s.name,s.role_id,s.department_id,
				DATE_FORMAT(m.masa_masuk,'%d-%m-%Y  %r') AS masa_masuk,
				IFNULL(DATE_FORMAT(m.masa_keluar,'%d-%m-%Y  %r'),'BELUM LOG') AS masa_keluar,
				k.status_kehadiran,IFNULL(k.sebab_kelewatan,'-') AS sebab_kelewatan
				FROM masa_kehadiran m 
				LEFT JOIN kehadiran k ON m.id_kehadiran=k.id
				LEFT JOIN staff s ON k.nokp_staff=s.noic
				WHERE m.created_by = '$no_staff' AND s.status = 'BEKERJA' AND 
				DATE_FORMAT(m.masa_masuk,'%Y-%m-%d')= CURRENT_DATE
				ORDER BY m.masa_masuk DESC";
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '61'://check Nokp staff wujud
	
		$nokp_staff = $JsonSystem->getGETPOST('nokp_staff');
		
		$sql="SELECT s.id FROM staff s WHERE s.noic = '$nokp_staff' AND s.status='BEKERJA'";
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
}
// Closing connection
mysqli_close($connjson);
echo $output_to_send;



?>
