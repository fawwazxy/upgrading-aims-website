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
	
	case '1':
	    $nama = $JsonSystem->getGETPOST('username');
	    $pwd = $JsonSystem->getGETPOST('password');
		
		$output2 = $JsonSystem->getJSONData("select id, no_staff, noic, name, username, accs_pwd, phone, email, alamat_tetap, alamat_surat, umur, jawatan_code, role_id, department_id, company_id, status, created_date, martial_status, tanggungan, gender FROM staff where status='BEKERJA' and username='{$nama}' and accs_pwd='{$pwd}'");
		$output_to_send = "{\"output\":[{$output2}]}";
	break;

	case '9000':
		$output2 = $JsonSystem->getJSONData("select id, no_staff, noic, name, username, accs_pwd, phone, email, 
		alamat_tetap, alamat_surat, umur, jawatan_code, role_id, department_id, company_id, status, created_date, martial_status, tanggungan, gender FROM staff");
		
		$output_to_send = "{\"return\":[{$output2}]}";
		break;
		
	case 3:
	$nokp = $JsonSystem->getGETPOST('nokp');
	$output = $JsonSystem->executeOperation("insert into user(mobile,email,name,password,identity_card) values('{$mobile}','{$email}','{$nama}','{$pwd}','{$nokp}')");
	$output_to_send = "{\"output\":[{$output}]}";
	break;
	
	//update attendance masuk
	case '4':
	    $nokp = $JsonSystem->getGETPOST('noic');
	    $lokasi = $JsonSystem->getGETPOST('lokasi');
	    
	    $koor = explode(",", $lokasi);
	    $latitude = $koor[0];
	    $longitude = $koor[1];
	    
	    //check nearest location
	    $objectQuery = "SELECT *, ((acos(sin((" . $latitude . "*pi()/180)) * sin((`latitude`*pi()/180))+cos((" . $latitude . "*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((" . $longitude . "- `longitude`)* pi()/180))))*180/pi())*60*1.1515*1.609344  as distance FROM `lkp_location` HAVING distance <='0.1' ORDER BY distance asc";
	    $remark_lokasi = $JsonSystem->getData($objectQuery);
	    
		$remark_lokasi=$remark_lokasi[1];
		
		if($remark_lokasi == ""){
		    $remark_lokasi = "LUAR KAWASAN";
		}
	    
	    //$masa=getMasaBekerja()->fetch_assoc();
	    $masa = $JsonSystem->getData("SELECT masa_bekerja FROM masa_bekerja where shift_code = (select shift_kerja from staff where noic='$nokp' AND status='BEKERJA')");
	    
		$masa_bekerja=$masa[0];
		
		$sql1 = "SELECT IFNULL(id,0) AS id FROM  kehadiran WHERE nokp_staff='$nokp' 
		AND DATE_FORMAT(created_date,'%d-%m-%Y')=DATE_FORMAT(CURRENT_TIMESTAMP,'%d-%m-%Y')";
	
		//$checkId=$conn->query($sql1)->fetch_object()->id;
		$_checkId = $JsonSystem->getData($sql1);
		$checkId = $_checkId[0];
		$newid = "0";
		if($checkId>0){
		$sql3 = "INSERT INTO masa_kehadiran (id_kehadiran,masa_masuk,lokasi_masuk,remark_masuk) VALUES ('$checkId',CURRENT_TIMESTAMP,'$lokasi','$remark_lokasi')";
// 		$result = $conn->query($sql3);
		$newid = $JsonSystem->executeOperation2($sql3);
		}else{
		$sql = "INSERT INTO kehadiran (status_kehadiran, lokasi,nokp_staff,remark_lokasi) 
				VALUES (
				(
						SELECT CASE 
						WHEN DATE_FORMAT(CURRENT_TIMESTAMP,'%H:%i') = '$masa_bekerja' THEN 'TEPAT' 
						WHEN DATE_FORMAT(CURRENT_TIMESTAMP,'%H:%i') > '$masa_bekerja' THEN 'LEWAT' ELSE 'AWAL' END
				)
				, '$lokasi', '$nokp','$remark_lokasi')";
// 		$result = $conn->query($sql);
// 		$newid=$conn->insert_id;
		$newid = $JsonSystem->executeOperation2($sql);
		
		$sql2 = "INSERT INTO masa_kehadiran (id_kehadiran,masa_masuk,lokasi_masuk,remark_masuk) 
				VALUES ('$newid',CURRENT_TIMESTAMP,'$lokasi','$remark_lokasi')";
		//$result = $conn->query($sql2);
		$newid = $JsonSystem->executeOperation2($sql2);
		}
		
		$output2 = $JsonSystem->getJSONData("select * FROM masa_kehadiran where id='{$newid}'");
		$output_to_send = "{\"output\":[{$output2}]}";
		//echo 'Maklumat Berjaya dibuang';
	break;
	
	//update attendance keluar
	case '5':
	    $nokp = $JsonSystem->getGETPOST('noic');
	    $lokasi = $JsonSystem->getGETPOST('lokasi');
	    
	    $koor = explode(",", $lokasi);
	    $latitude = $koor[0];
	    $longitude = $koor[1];
	    
	    //check nearest location
	    $objectQuery = "SELECT *, ((acos(sin((" . $latitude . "*pi()/180)) * sin((`latitude`*pi()/180))+cos((" . $latitude . "*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((" . $longitude . "- `longitude`)* pi()/180))))*180/pi())*60*1.1515*1.609344  as distance FROM `lkp_location` HAVING distance <='0.1' ORDER BY distance asc";
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
		//$checkId=$conn->query($sql1)->fetch_object()->id;
		$_checkId = $JsonSystem->getData($sql1);
		$checkId = $_checkId[0];
		
		$masa_res = "0";
		if($checkId>0){
    		$sql3 = "SELECT id FROM masa_kehadiran WHERE id_kehadiran='$checkId' AND masa_keluar IS NULL 
    		AND id = (SELECT MAX(id) AS id FROM masa_kehadiran WHERE id_kehadiran='$checkId') ";
    		//$masa_res=$conn->query($sql3);
    		$_masa_res = $JsonSystem->getData($sql3);
		    $masa_res = $_masa_res[0];
		
    		if($masa_res > 0){
    		    $masa_id=$masa_res;
    		    if($masa_id>0){
            		$sql4 = "UPDATE masa_kehadiran SET masa_keluar=CURRENT_TIMESTAMP, total_time=TIMEDIFF(CURRENT_TIMESTAMP,masa_masuk),
            		lokasi_keluar='$lokasi',remark_keluar='$remark_lokasi' where id='$masa_id' ";
            		//$result=$conn->query($sql4);
            		$JsonSystem->executeOperation($sql4);
        		}
    		}
    		
		}
		
		$output2 = $JsonSystem->getJSONData("select * FROM masa_kehadiran where id='{$masa_res}'");
		$output_to_send = "{\"output\":[{$output2}]}";
		//echo 'Maklumat Berjaya dibuang';
	break;
	
	case '6':
		$nokp = $JsonSystem->getGETPOST('noic');
		$mnt = $JsonSystem->getGETPOST('mnt');
		$thn = $JsonSystem->getGETPOST('thn');

		$workdays = array();
		$type = CAL_GREGORIAN;
		$month = date('n'); // Month ID, 1 through to 12.
		$year = date('Y'); // Year in 4 digit 2009 format.
		$day_count = cal_days_in_month($type, $month, $year); // Get the amount of days

		$sql = "SELECT COUNT(tarikh_cuti) AS hari_cuti FROM cuti 
		WHERE DATE_FORMAT(tarikh_cuti,'%m')='$mnt' AND DATE_FORMAT(tarikh_cuti,'%Y')='$thn'";
		// //$masa_res=$conn->query($sql3);
		$_masa_res = $JsonSystem->getData($sql);
	    $cuti = $_masa_res[0];

		//loop through all days
		for ($i = 1; $i <= $day_count; $i++) {

			$date = $year.'/'.$month.'/'.$i; //format date
			$get_name = date('l', strtotime($date)); //get week day
			$day_name = substr($get_name, 0, 3); // Trim day name to 3 chars

			//if not a weekend add day to array
			if($day_name != 'Fri'){
				$workdays[] = $i;
			}

		}

		// length array
		$work=count($workdays);
		//workdays this month
		$masa_bekerja = $work-$cuti['hari_cuti'];


		$sql = "SELECT COUNT(DISTINCT(DATE_FORMAT(created_date,'%Y-%m-%d'))) AS hari_bekerja FROM kehadiran
				WHERE DATE_FORMAT(created_date,'%m')=DATE_FORMAT(CURRENT_TIMESTAMP,'%m') AND DATE_FORMAT(created_date,'%Y')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')
				 AND nokp_staff = '$nokp'";
		$_hari_kerja = $JsonSystem->getData($sql);
	    $hari_kerja = $_hari_kerja[0];

		$sql = "SELECT COUNT(DISTINCT(DATE_FORMAT(created_date,'%Y-%m-%d'))) AS hari_awal FROM kehadiran
				WHERE DATE_FORMAT(created_date,'%m')=DATE_FORMAT(CURRENT_TIMESTAMP,'%m') AND DATE_FORMAT(created_date,'%Y')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')
				AND status_kehadiran = 'AWAL' AND nokp_staff = '$nokp'";
		$_hari_awal = $JsonSystem->getData($sql);
	    $hari_awal = $_hari_awal[0];

	    $sql = "SELECT COUNT(DISTINCT(DATE_FORMAT(created_date,'%Y-%m-%d'))) AS hari_lewat FROM kehadiran
				WHERE DATE_FORMAT(created_date,'%m')=DATE_FORMAT(CURRENT_TIMESTAMP,'%m') AND DATE_FORMAT(created_date,'%Y')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')
				AND status_kehadiran = 'LEWAT' AND nokp_staff = '$nokp'";
		$_hari_lewat = $JsonSystem->getData($sql);
	    $hari_lewat = $_hari_lewat[0];
	    
	    $output2 = '{"hari_lewat":"'.$hari_lewat.'","hari_awal":"'.$hari_awal.'"}';
		
		$output_to_send = "{\"output\":[{$output2}]}";
	break;
	
	case '7':
		$nokp = $JsonSystem->getGETPOST('noic');
		$mnt = $JsonSystem->getGETPOST('mnt');
		$thn = $JsonSystem->getGETPOST('thn');

		$workdays = array();
		$type = CAL_GREGORIAN;
		$month = date('n'); // Month ID, 1 through to 12.
		$year = date('Y'); // Year in 4 digit 2009 format.
		$day_count = cal_days_in_month($type, $month, $year); // Get the amount of days

		$sql = "SELECT COUNT(tarikh_cuti) AS hari_cuti FROM cuti 
		WHERE DATE_FORMAT(tarikh_cuti,'%m')='$mnt' AND DATE_FORMAT(tarikh_cuti,'%Y')='$thn'";
		// //$masa_res=$conn->query($sql3);
		$_masa_res = $JsonSystem->getData($sql);
	    $cuti = $_masa_res[0];

		//loop through all days
		for ($i = 1; $i <= $day_count; $i++) {

			$date = $year.'/'.$month.'/'.$i; //format date
			$get_name = date('l', strtotime($date)); //get week day
			$day_name = substr($get_name, 0, 3); // Trim day name to 3 chars

			//if not a weekend add day to array
			if($day_name != 'Fri'){
				$workdays[] = $i;
			}

		}

		// length array
		$work=count($workdays);
		//workdays this month
		$masa_bekerja = $work-$cuti['hari_cuti'];


		$sql = "SELECT COUNT(DISTINCT(DATE_FORMAT(created_date,'%Y-%m-%d'))) AS hari_bekerja FROM kehadiran
				WHERE DATE_FORMAT(created_date,'%m')='$mnt' AND DATE_FORMAT(created_date,'%Y')='$thn'
				 AND nokp_staff = '$nokp'";
		$_hari_kerja = $JsonSystem->getData($sql);
	    $hari_kerja = $_hari_kerja[0];

		$sql = "SELECT COUNT(DISTINCT(DATE_FORMAT(created_date,'%Y-%m-%d'))) AS hari_awal FROM kehadiran
				WHERE DATE_FORMAT(created_date,'%m')=DATE_FORMAT(CURRENT_TIMESTAMP,'%m') AND DATE_FORMAT(created_date,'%Y')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')
				AND status_kehadiran = 'AWAL' AND nokp_staff = '$nokp'";
		$_hari_awal = $JsonSystem->getData($sql);
	    $hari_awal = $_hari_awal[0];

	    $sql = "SELECT COUNT(DISTINCT(DATE_FORMAT(created_date,'%Y-%m-%d'))) AS hari_lewat FROM kehadiran
				WHERE DATE_FORMAT(created_date,'%m')=DATE_FORMAT(CURRENT_TIMESTAMP,'%m') AND DATE_FORMAT(created_date,'%Y')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')
				AND status_kehadiran = 'LEWAT' AND nokp_staff = '$nokp'";
		$_hari_lewat = $JsonSystem->getData($sql);
	    $hari_lewat = $_hari_lewat[0];

		$sql1 = "SELECT s.noic,'$hari_kerja' AS hari_bekerja_sebenar,
		'$masa_bekerja' AS hari_kerja_sasaran,
		'$hari_awal' AS hari_awal,
		'$hari_lewat' AS hari_lewat,
		DATE_FORMAT(k.created_date,'%m') AS bulan,
		k.*,HOUR(SEC_TO_TIME(SUM(TIME_TO_SEC(total_time)))) AS jum_masa_kerja,
		HOUR(TIMEDIFF(SEC_TO_TIME(SUM(TIME_TO_SEC(total_time))),SEC_TO_TIME(TIME_TO_SEC('8:00:00')*$masa_bekerja))) AS jum_masa_baki,
		HOUR(SEC_TO_TIME(TIME_TO_SEC('8:00:00')*26)) AS sasaran_masa
		FROM kehadiran k
		LEFT JOIN staff s ON k.nokp_staff=s.noic
		LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
		WHERE CURRENT_TIMESTAMP >= DATE_FORMAT(CURDATE(), '%Y-%m-01') - INTERVAL 3 MONTH
		and s.noic = '$nokp'
		GROUP BY k.nokp_staff,bulan ORDER BY bulan desc";
		
		//WHERE DATE_FORMAT(k.created_date,'%m') in ($mnt) AND DATE_FORMAT(k.created_date,'%Y')='$thn'

		$sql2 = "select * from kehadiran";

		$output2 = $JsonSystem->getJSONData($sql1,'',null);
		
		$output_to_send = "{\"output\":[{$output2}]}";
	break;
	
	case 8:
	//$nokp = $JsonSystem->getGETPOST('nokp');
	$sql = "SELECT * FROM produk WHERE status=1 order by id asc";
	$output2 = $JsonSystem->getJSONData($sql,'',null);
	$output_to_send = "{\"output\":[{$output2}]}";
	break;
	
	case 9:
		//$nokp = $JsonSystem->getGETPOST('nokp');
		$sql = "select count(status) as cnt from lead where status=0 order by status asc";
		$_lead = $JsonSystem->getData($sql);
		$lead = $_lead[0];
		$sql = "select count(status) as cnt from lead where status=1 order by status asc";
		$_prospek = $JsonSystem->getData($sql);
		$prospek = $_prospek[0];
		$sql = "select count(status) as cnt from lead where status=2 order by status asc";
		$_client = $JsonSystem->getData($sql);
		$client = $_client[0];
		

		$output2 = '{"lead":"'.$lead.'","prospek":"'.$prospek.'","client":"'.$client.'"}';

		$output_to_send = "{\"output\":[{$output2}]}";
	break;
	
	case 10:
	//$nokp = $JsonSystem->getGETPOST('nokp');
	$sql = "select produk.code,
	(select count(lead.id) prospek from lead where lead.id_lead_segmen in (produk.segmen) and lead.status =0)  as cnt_lead,
(select count(lead.id) prospek from lead where lead.id_lead_segmen in (produk.segmen) and lead.status =1)  as cnt_prospek,
(select count(lead.id) prospek from lead where lead.id_lead_segmen in (produk.segmen) and lead.status =2)  as cnt_client
from produk";
	$output2 = $JsonSystem->getJSONData($sql,'',null);
	$output_to_send = "{\"output\":[{$output2}]}";
	break;
	
	case 11:
	//$nokp = $JsonSystem->getGETPOST('nokp');
	$sql = "select ls.code,(select count(lead.id) from lead where id_lead_segmen=ls.id and lead.status =0) as cnt_lead,
	(select count(lead.id) from lead where id_lead_segmen=ls.id and lead.status =1) as cnt_prospek,
	(select count(lead.id) from lead where id_lead_segmen=ls.id and lead.status =2) as cnt_client
	from lead_segmen ls";
	$output2 = $JsonSystem->getJSONData($sql,'',null);
	$output_to_send = "{\"output\":[{$output2}]}";
	break;
	
	case 12:
	//$nokp = $JsonSystem->getGETPOST('nokp');
	$sql = "select id,name from lkp_negeri where status=1 and id in (select id_negeri from lead group by id_negeri)";
	$output2 = $JsonSystem->getJSONData($sql,'',null);
	$output_to_send = "{\"output\":[{$output2}]}";
	break;
	
	case 13:
	$id_negeri = $JsonSystem->getGETPOST('id_negeri');
	$code = $JsonSystem->getGETPOST('code');
	
	$sql = "select produk.segmen from produk where produk.status =1 and produk.code = '{$code}'";
	$_segmen = $JsonSystem->getData($sql);
	$segmen = $_segmen[0];
	
	$sql = "select * from lead where lead.id_negeri='{$id_negeri}' and 
	lead.id_lead_segmen in ($segmen) ";
    // $sql = "select * from lead ";
	$output2 = $JsonSystem->getJSONData($sql,'',null);
	$output_to_send = "{\"output\":[{$output2}]}";
	break;
	
	case '14':
		
		$sql = "select id,name, no_staff, role_id, department_id, phone 
		FROM staff where status='BEKERJA' 
		and noic is not null order by name asc";
        
    	$output2 = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "{\"output\":[{$output2}]}";
	break;
	
	case '15':
		$newdate = $JsonSystem->getGETPOST('newdate');
		$sql = "select ev.*,lead.lead_name,lead.pic_name from events ev 
		left join lead on ev.id_lead = lead.id
		where DATE_FORMAT(ev.start,'%Y-%m')='{$newdate}' order by ev.start desc";
        
    	$output2 = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "{\"output\":[{$output2}]}";
	break;
	
	case '16':
		$newdate = $JsonSystem->getGETPOST('newdate');
		$sql = "select ev.*,lead.lead_name,lead.pic_name from events ev 
		select ev.*,lead.lead_name,lead.pic_name from events ev
        left join lead on ev.id_lead = lead.id
		where DATE_FORMAT(ev.start,'%Y-%m-%d')='{$newdate}' order by ev.start desc";
        
    	$output2 = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "{\"output\":[{$output2}]}";
	break;
	case '17':
		$prepared_by = $JsonSystem->getGETPOST('prepared_by');
		$title = $JsonSystem->getGETPOST('title');
		$color = "#FF0000";
		$status = "BARU";
		$event_type = $JsonSystem->getGETPOST('event_type');
		$description = $JsonSystem->getGETPOST('description');
		$start = $JsonSystem->getGETPOST('start');
		$end = $JsonSystem->getGETPOST('end');
		$id_staff = $JsonSystem->getGETPOST('id_staff');
		$id_lead = $JsonSystem->getGETPOST('id_lead');
		
		$sql = "INSERT INTO events(title,description,start,end,id_staff,status,event_type,color,prepared_by,id_lead) 
		VALUES ('$title',?,'$start','$end','$id_staff','$status','$event_type','$color','$prepared_by','$id_lead')";
		$stmt = $conn->prepare($sql) or die($conn->error);
		$stmt->bind_param("s",$description);
		
		$stmt->execute();
		$result = $stmt->insert_id;
		$stmt->close();
        
        $output = Array("result"=>"success");
        $jsonOutput = json_encode($output);
		$output_to_send = "{\"output\":[{$jsonOutput}]}";
	break;
	case 18:
    	//$nokp = $JsonSystem->getGETPOST('nokp');
    	$sql = "select id, keterangan as name from aktiviti_kategori";
    	$output2 = $JsonSystem->getJSONData($sql,'',null);
    	$output_to_send = "{\"output\":[{$output2}]}";
	break;
	case 19:
    	$sql = "SELECT * FROM lead_segmen WHERE status=1 order by id asc";
    	$output2 = $JsonSystem->getJSONData($sql,'',null);
    	$output_to_send = "{\"output\":[{$output2}]}";
	break;
	case 20:
    	$id_negeri = $JsonSystem->getGETPOST('id_negeri');
    	$code = $JsonSystem->getGETPOST('code');
    	
    	$sql = "select * from lead where lead.id_negeri='{$id_negeri}' and 
    	lead.id_lead_segmen = '$code' ";
        
    	$output2 = $JsonSystem->getJSONData($sql,'',null);
    	$output_to_send = "{\"output\":[{$output2}]}";
	break;
	
	case 21:
		$id_negeri = $JsonSystem->getGETPOST('id_negeri');
		$sql = "select count(status) as cnt from lead where status=0 and id_negeri='$id_negeri' ";
		$_lead = $JsonSystem->getData($sql);
		$lead = $_lead[0];
		$sql = "select count(status) as cnt from lead where status=1 and id_negeri='$id_negeri'";
		$_prospek = $JsonSystem->getData($sql);
		$prospek = $_prospek[0];
		$sql = "select count(status) as cnt from lead where status=2 and id_negeri='$id_negeri'";
		$_client = $JsonSystem->getData($sql);
		$client = $_client[0];
		

		$output2 = '{"lead":"'.$lead.'","prospek":"'.$prospek.'","client":"'.$client.'"}';

		$output_to_send = "{\"output\":[{$output2}]}";
	break;
	
	case 22:
    	$id_negeri = $JsonSystem->getGETPOST('id_negeri');
    	$sql = "select produk.code,
    	(select count(lead.id) prospek from lead where lead.id_lead_segmen in (produk.segmen) and lead.status =0 and lead.id_negeri='$id_negeri')  as cnt_lead,
    (select count(lead.id) prospek from lead where lead.id_lead_segmen in (produk.segmen) and lead.status =1 and lead.id_negeri='$id_negeri')  as cnt_prospek,
    (select count(lead.id) prospek from lead where lead.id_lead_segmen in (produk.segmen) and lead.status =2 and lead.id_negeri='$id_negeri')  as cnt_client
    from produk";
    	$output2 = $JsonSystem->getJSONData($sql,'',null);
    	$output_to_send = "{\"output\":[{$output2}]}";
	break;
	
	case 23:
    	$id_negeri = $JsonSystem->getGETPOST('id_negeri');
    	$sql = "select ls.code,(select count(lead.id) from lead where id_lead_segmen=ls.id and lead.status =0 and lead.id_negeri='$id_negeri') as cnt_lead,
    	(select count(lead.id) from lead where id_lead_segmen=ls.id and lead.status =1 and lead.id_negeri='$id_negeri') as cnt_prospek,
    	(select count(lead.id) from lead where id_lead_segmen=ls.id and lead.status =2 and lead.id_negeri='$id_negeri') as cnt_client
    	from lead_segmen ls";
    	$output2 = $JsonSystem->getJSONData($sql,'',null);
    	$output_to_send = "{\"output\":[{$output2}]}";
	break;
	case 24:
    	$sql = "select id, name from lkp_negeri where status=1";
    	$output2 = $JsonSystem->getJSONData($sql,'',null);
    	$output_to_send = "{\"output\":[{$output2}]}";
	break;
	case 25:
    	$sql = "select id, name from lead_segmen where status=1";
    	$output2 = $JsonSystem->getJSONData($sql,'',null);
    	$output_to_send = "{\"output\":[{$output2}]}";
	break;
	case '26':
		
    	$name = $JsonSystem->getGETPOST('lead_name');
    	$shrtname = $JsonSystem->getGETPOST('lead_shrtname');
    	$address = $JsonSystem->getGETPOST('lead_address'); 
    	$telno = $JsonSystem->getGETPOST('lead_telno');
        $email = $JsonSystem->getGETPOST('lead_email'); 
    	$pic_name = $JsonSystem->getGETPOST('pic_name'); 
    	$pic_position = $JsonSystem->getGETPOST('pic_position'); 
    	$lokasi = $JsonSystem->getGETPOST('lokasi');
    	$daerah = $JsonSystem->getGETPOST('daerah');
    	$negeri = $JsonSystem->getGETPOST('negeri');
    	$segmen = $JsonSystem->getGETPOST('segmen');
    	$status = $JsonSystem->getGETPOST('status');
    	$created_by = $JsonSystem->getGETPOST('created_by');
		
		$sql="INSERT INTO lead (lead_name,lead_shrtname,lead_address,lead_telno,lead_email,pic_name,pic_position,lokasi,daerah,id_negeri,id_lead_segmen,status,created_by)
		  VALUES('$name','$shrtname','$address','$telno','$email','$pic_name','$pic_position','$lokasi','$daerah','$negeri','$segmen','$status','$created_by')";
	    $result = $conn->query($sql);
        
        $output = Array("result"=>"success");
        $jsonOutput = json_encode($output);
		$output_to_send = "{\"output\":[{$jsonOutput}]}";
	break;
	case 27:
    	$sql = "select sys_id,sys_name,sys_owner,sys_domain,sys_email,sys_hotline,sys_address,version,shortcode from sys_setting where sys_id=1 limit 1";
    	$output2 = $JsonSystem->getJSONData($sql,'',null);
    	$output_to_send = "{\"output\":[{$output2}]}";
	break;
	
	case 28:
	    $no_staff = $JsonSystem->getGETPOST('no_staff');
	    $phone = $JsonSystem->getGETPOST('phone');
	    $accs_pwd = $JsonSystem->getGETPOST('accs_pwd');
	    
    	$sql = "update staff set accs_pwd = '$accs_pwd', phone='$phone' where no_staff='$no_staff' ";
    	$output2 = $JsonSystem->executeOperation($sql);
    	$output_to_send = "{\"output\":[{$output2}]}";
	break;
	case 29:
    	$sql = "select sh.pegawai_dalaman as id,s.name from inbois i 
        inner join sebut_harga sh on i.id_sebut_harga = sh.id_sebut_harga
        left join staff s on sh.pegawai_dalaman = s.no_staff
        group by sh.pegawai_dalaman
        order by name asc";
    	$output2 = $JsonSystem->getJSONData($sql,'',null);
    	$output_to_send = "{\"output\":[{$output2}]}";
	break;
	case 30:
    	$no_staff = $JsonSystem->getGETPOST('no_staff');
    	
    	$conditionj = "";
    	$conditiont = "";
    	
    	$sql = "select IFNULL(target_yearly_sale,0) from sales_target";
    	if(isset($no_staff) && strlen($no_staff)>0){
    	    $sql = "select IFNULL(sales_target_yearly,0) from sales_target_person where no_staff = '$no_staff' ";
    	    $conditionj = "where sh.pegawai_dalaman = '$no_staff'";
    	    $conditiont = "where pegawai_dalaman = '$no_staff'";
    	}
	    
    	
    	$_sasaran = $JsonSystem->getData($sql);
		$sasaran = $_sasaran[0];
		
    	$sql = "select IFNULL(sum(sh.jumlah_sebut_harga),0) from inbois i 
        inner join sebut_harga sh on i.id_sebut_harga = sh.id_sebut_harga $conditionj";
    	$_jualan = $JsonSystem->getData($sql);
		$jualan = $_jualan[0];
		
		$sql = "select IFNULL(sum(jumlah_bil_tunai),0) from bil_tunai $conditiont";
    	$_jualan_tunai = $JsonSystem->getData($sql);
		$jualan_tunai = $_jualan_tunai[0];
		
		$jum_jualan = $jualan + $jualan_tunai ;
		$jum_sasaran = $sasaran - $jum_jualan ;
		
    	
    	$output2 = '{"sasaran":"'.$jum_sasaran.'","jualan":"'.$jum_jualan.'"}';
    	$output_to_send = "{\"output\":[{$output2}]}";
	break;
	case 31:
	    //by staff
	    $no_staff = $JsonSystem->getGETPOST('no_staff');
	    
    	$conditionj = "";
    	$conditiont = "";
    	if(isset($no_staff) && strlen($no_staff)>0){
    	    $conditionj = "and sh.pegawai_dalaman = '$no_staff'";
    	    $conditiont = "and pegawai_dalaman = '$no_staff'";
    	}
    	
    // 	$sql = "select produk.code,
    //     IFNULL((select sum(sh.jumlah_sebut_harga) from inbois i 
    //     inner join sebut_harga sh on i.id_sebut_harga = sh.id_sebut_harga
    //     where sh.id_produk = produk.id $conditionj),0)  as jualan
    //     from produk";
        
        $sql = "select produk.code,
        (select IFNULL(sum(sh.jumlah_sebut_harga),0) from inbois i 
        inner join sebut_harga sh on i.id_sebut_harga = sh.id_sebut_harga
        where sh.id_produk = produk.id $conditionj) + 
        (select IFNULL(sum(jumlah_bil_tunai),0) from bil_tunai where id_produk=produk.id $conditiont)  as jualan
        from produk";
        
    	$output2 = $JsonSystem->getJSONData($sql,'',null);
    	$output_to_send = "{\"output\":[{$output2}]}";
	break;
	case 32:
	    //by staff
	    $no_staff = $JsonSystem->getGETPOST('no_staff');
	    
    	$conditionj = "";
    	$conditiont = "";
    	if(isset($no_staff) && strlen($no_staff)>0){
    	    $conditionj = "and sh.pegawai_dalaman = '$no_staff'";
    	    $conditiont = "and bil_tunai.pegawai_dalaman = '$no_staff'";
    	}
    	
    // 	$sql = "select lead_segmen.code,
    //     (select sum(sh.jumlah_sebut_harga) from inbois i 
    //     inner join sebut_harga sh on i.id_sebut_harga = sh.id_sebut_harga
    //     inner join lead on sh.id_lead = lead.id where lead.id_lead_segmen = lead_segmen.id
    //     $conditionj)  as jualan
    //     from lead_segmen";
    
        $sql = "select lead_segmen.code,
        (select IFNULL(sum(sh.jumlah_sebut_harga),0) from inbois i 
        inner join sebut_harga sh on i.id_sebut_harga = sh.id_sebut_harga
        inner join lead on sh.id_lead = lead.id 
        where lead.id_lead_segmen = lead_segmen.id $conditionj)+
        (select IFNULL(sum(bil_tunai.jumlah_bil_tunai),0) from bil_tunai 
        inner join lead on bil_tunai.id_lead = lead.id where lead.id_lead_segmen = lead_segmen.id $conditiont)  
        as jualan
        from lead_segmen";
        
    	$output2 = $JsonSystem->getJSONData($sql,'',null);
    	$output_to_send = "{\"output\":[{$output2}]}";
	break;
	
	case 33:
    	$no_staff = $JsonSystem->getGETPOST('no_staff');
    	
    	$conditionj = "";
    	$conditiont = "";
    	
    	if(isset($no_staff) && strlen($no_staff)>0){
    	    $conditionj = "where sh.pegawai_dalaman = '$no_staff'";
    	    $conditiont = "where pegawai_dalaman = '$no_staff'";
    	}
	    
    	$sql = "select IFNULL(sum(sh.jumlah_sebut_harga),0) from inbois i 
        inner join sebut_harga sh on i.id_sebut_harga = sh.id_sebut_harga $conditionj";
    	$_jualan = $JsonSystem->getData($sql);
		$jualan = $_jualan[0];
		
		$sql = "select IFNULL(sum(rb.jumlah_bayaran),0) from inbois i 
        inner join resit_bayaran rb on i.id_inbois = rb.id_inbois
        inner join sebut_harga sh on i.id_sebut_harga = sh.id_sebut_harga $conditionj";
    	$_bayaran = $JsonSystem->getData($sql);
		$bayaran = $_bayaran[0];
		
		$sql = "select IFNULL(sum(jumlah_bil_tunai),0) from bil_tunai $conditiont";
    	$_jualan_tunai = $JsonSystem->getData($sql);
		$jualan_tunai = $_jualan_tunai[0];
		
		$baki_jualan = $jualan - $bayaran;
    	
    	$output2 = '{"jualan":"'.$baki_jualan.'","bayaran":"'.($bayaran + $jualan_tunai).'"}';
    	$output_to_send = "{\"output\":[{$output2}]}";
	break;
	case 34:
	    //by staff
	    $no_staff = $JsonSystem->getGETPOST('no_staff');
	    
    	$conditionj = "";
    	$conditiont = "";
    	if(isset($no_staff) && strlen($no_staff)>0){
    	    $conditionj = "and sh.pegawai_dalaman = '$no_staff'";
    	    $conditiont = "and bil_tunai.pegawai_dalaman = '$no_staff'";
    	}
    	
    	$sql = "select produk.code,
        IFNULL((select sum(rb.jumlah_bayaran) from inbois i 
        inner join resit_bayaran rb on i.id_inbois = rb.id_inbois
        inner join sebut_harga sh on i.id_sebut_harga = sh.id_sebut_harga
        where sh.id_produk = produk.id $conditionj),0) + 
        (select IFNULL(sum(jumlah_bil_tunai),0) from bil_tunai where id_produk=produk.id $conditiont) as jualan
        from produk";
        
    	$output2 = $JsonSystem->getJSONData($sql,'',null);
    	$output_to_send = "{\"output\":[{$output2}]}";
	break;
	case 35:
	    //by staff
	    $no_staff = $JsonSystem->getGETPOST('no_staff');
	    
    	$conditionj = "";
    	$conditiont = "";
    	if(isset($no_staff) && strlen($no_staff)>0){
    	    $conditionj = "and sh.pegawai_dalaman = '$no_staff'";
    	    $conditiont = "and bil_tunai.pegawai_dalaman = '$no_staff'";
    	}
    	
    	$sql = "select lead_segmen.code,
        (select sum(rb.jumlah_bayaran) from inbois i 
        inner join resit_bayaran rb on i.id_inbois = rb.id_inbois
        inner join sebut_harga sh on i.id_sebut_harga = sh.id_sebut_harga
        inner join lead on sh.id_lead = lead.id where lead.id_lead_segmen = lead_segmen.id
        $conditionj)  + 
        (select IFNULL(sum(bil_tunai.jumlah_bil_tunai),0) from bil_tunai 
        inner join lead on bil_tunai.id_lead = lead.id where lead.id_lead_segmen = lead_segmen.id $conditiont)   as jualan
        from lead_segmen";
        
    	$output2 = $JsonSystem->getJSONData($sql,'',null);
    	$output_to_send = "{\"output\":[{$output2}]}";
	break;
	
	case '36':
	    $no_staff = $JsonSystem->getGETPOST('no_staff');
		
		$output2 = $JsonSystem->getJSONData("select id, no_staff, noic, name, username, accs_pwd, phone, email, alamat_tetap, alamat_surat, umur, jawatan_code, role_id, department_id, company_id, status, created_date, martial_status, tanggungan, gender FROM staff where no_staff='{$no_staff}'");
		$output_to_send = "{\"output\":[{$output2}]}";
	break;
	
	case '37':
		$output2 = $JsonSystem->getJSONData("select id,lead_name as name from lead");
		$output_to_send = "{\"output\":[{$output2}]}";
	break;
	
	case '38':
		$sql = "select noic as id,name
		FROM staff where status='BEKERJA' 
		and noic is not null order by name asc";
        
    	$output2 = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "{\"output\":[{$output2}]}";
	break;
	
	case '39':
		$sql = "select lead.created_by as code,staff.name as name,staff.no_staff as id from lead 
        left join staff on lead.created_by = staff.no_staff
        where created_by is not null and created_by <> ''
        group by lead.created_by,staff.name";
        
    	$output2 = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "{\"output\":[{$output2}]}";
	break;
	
	case '40':
	    $id_negeri = $JsonSystem->getGETPOST('id_negeri');
    	$code = $JsonSystem->getGETPOST('code');
    	
    	$sql = "select * from lead where lead.id_negeri='{$id_negeri}' and 
    	lead.created_by = '$code' ";
        
    	$output2 = $JsonSystem->getJSONData($sql,'',null);
    	$output_to_send = "{\"output\":[{$output2}]}";
	break;
}

// Closing connection
mysqli_close($con);
mysqli_close($conn);
echo $output_to_send;



?>