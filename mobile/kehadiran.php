<?php
//phpinfo();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header('Content-type: application/json');

require_once('../lib/json.inc');
require_once ('../lib/db/connection.php');
require_once ('./log/log_kehadiran.php');
require_once ('../app/model/v02_attendance_function.php');
require_once ('../app/global/uniqid_generator.php');

error_log('json_office.php');
error_reporting(E_ALL);
ini_set("display_errors", 0);

$JsonSystem = new Json();

$cmd = $JsonSystem->getGETPOST('cmd');

$output = '';
$output_to_send = '';
switch ($cmd){
    case '1'://select kehadiran bulan semasa

        $nokp = $JsonSystem->getGETPOST('nokp');
        $month = $JsonSystem->getGETPOST('month');

        /*if ($month == '') {
            $detail = "SELECT s.no_staff,s.noic,s.`name` FROM staff s WHERE s.noic = '$nokp' AND s.`status` ='BEKERJA' ";

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
        } else {

            $current_year = date('Y');

            $year_month = $current_year . "-" . $month;

            $detail = "SELECT s.no_staff,s.noic,s.`name` FROM staff s WHERE s.noic = '$nokp' AND s.`status`='BEKERJA'";

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
        if ($output_jum_hadir > 0) {
            //kira percent
            $output_percent_kehadiran = Round(($output_jum_hadir / $output_hari_bekerja) * 100, 0);
        } else {
            //takde percent
            $output_percent_kehadiran = 0;
        }

        $output_to_send = '{"nama":"' . $output_name . '","noic":"' . $output_noic . '","no_staff":"' . $output_no_staff . '","bil_awal":"' . $output_awal . '","bil_tepat":"' . $output_tepat . '","bil_lewat":"' . $output_lewat . '","jum_hari_bekerja":"' . $output_hari_bekerja . '","jum_hadir":"' . $output_jum_hadir . '","percent_hadir":"' . $output_percent_kehadiran . '%"}';*/

        //v02
        if ($month == '') {
            $detail = "SELECT id, no_staff, noic, name FROM staff WHERE noic = '$nokp' AND status ='BEKERJA'";

            $_detail = $JsonSystem->getData($detail);
            $staff_id = $_detail[0];
            $output_no_staff = $_detail[1];
            $output_noic = $_detail[2];
            $output_name = $_detail[3];

            $awal = "SELECT COUNT(d.id) AS bil_awal FROM v02_attendance_date d
                         LEFT JOIN staff s ON d.staff_id = s.id 
                         WHERE s.id IS NOT NULL AND s.status='BEKERJA' 
                         AND d.staff_id = '$staff_id' AND d.status='2'
                         AND DATE_FORMAT(d.created_at,'%Y-%m') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')";

            $_awal = $JsonSystem->getData($awal);
            $output_awal = $_awal[0];


            $tepat = "SELECT COUNT(d.id) AS bil_tepat FROM v02_attendance_date d
                          LEFT JOIN staff s ON d.staff_id = s.id 
                          WHERE s.id IS NOT NULL AND s.status='BEKERJA' 
                          AND d.staff_id = '$staff_id'  AND d.status='1'
                          AND DATE_FORMAT(d.created_at,'%Y-%m') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')";

            $_tepat = $JsonSystem->getData($tepat);
            $output_tepat = $_tepat[0];

            $lewat = "SELECT COUNT(d.id) AS bil_lewat FROM v02_attendance_date d
                          LEFT JOIN staff s ON d.staff_id = s.id 
                          WHERE s.id IS NOT NULL AND s.status='BEKERJA' 
                          AND d.staff_id = '$staff_id' AND d.status='0'
                          AND DATE_FORMAT(d.created_at,'%Y-%m') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')";

            $_lewat = $JsonSystem->getData($lewat);
            $output_lewat = $_lewat[0];

            $hari_bekerja ="SELECT COUNT(w.id) AS jum_bekerja FROM v02_staff_workday w 
                                LEFT JOIN v02_workday_calendar c on c.id = w.date_id
                                LEFT JOIN staff s ON w.staff_id = s.id
                                WHERE s.id = '$staff_id' AND s.status='BEKERJA' AND c.default = '1' 
                                AND DATE_FORMAT(c.date,'%Y-%m')=DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')";

            $_hari_bekerja = $JsonSystem->getData($hari_bekerja);
            $output_hari_bekerja = $_hari_bekerja[0];

        } else {

            $current_year = date('Y');
            $year_month = $current_year . "-" . $month;

            $detail = "SELECT id, no_staff, noic, name FROM staff WHERE noic = '$nokp' AND status ='BEKERJA'";

            $_detail = $JsonSystem->getData($detail);
            $staff_id = $detail[0];
            $output_no_staff = $_detail[1];
            $output_noic = $_detail[2];
            $output_name = $_detail[3];

            $awal = "SELECT COUNT(d.id) AS bil_awal FROM v02_attendance_date d
                         LEFT JOIN staff s ON d.staff_id = s.id 
                         WHERE s.id IS NOT NULL AND s.status='BEKERJA' 
                         AND d.staff_id ='$staff_id'AND d.status='2'
                         AND DATE_FORMAT(d.created_at,'%Y-%m')= '$year_month'";

            $_awal = $JsonSystem->getData($awal);
            $output_awal = $_awal[0];


            $tepat = "SELECT COUNT(d.id) AS bil_tepat FROM v02_attendance_date d
                          LEFT JOIN staff s ON d.staff_id = s.id
                          WHERE s.id IS NOT NULL AND s.status='BEKERJA' 
                          AND d.staff_id = '$staff_id'AND d.status='1'
                          AND DATE_FORMAT(d.created_at,'%Y-%m')= '$year_month'";

            $_tepat = $JsonSystem->getData($tepat);
            $output_tepat = $_tepat[0];

            $lewat = "SELECT COUNT(d.id) AS bil_lewat FROM v02_attendance_date d
                      LEFT JOIN staff s ON d.staff_id = s.id
                      WHERE s.id IS NOT NULL AND s.status='BEKERJA' 
                      AND d.staff_id = '$staff_id'AND d.status='0'
                      AND DATE_FORMAT(d.created_at,'%Y-%m')= '$year_month'";

            $_lewat = $JsonSystem->getData($lewat);
            $output_lewat = $_lewat[0];

            $hari_bekerja ="SELECT COUNT(w.id) AS jum_bekerja FROM v02_staff_workday w 
                                LEFT JOIN v02_workday_calendar c on c.id = w.date_id
                                LEFT JOIN staff s ON w.staff_id = s.id
                                WHERE s.id = '$staff_id' AND s.status='BEKERJA' AND c.default = '1'
                                AND DATE_FORMAT(c.date,'%Y-%m')= '$year_month'";

            $_hari_bekerja = $JsonSystem->getData($hari_bekerja);
            $output_hari_bekerja = $_hari_bekerja[0];

        }

        $output_jum_hadir = '';
        $output_jum_hadir = $output_awal + $output_tepat + $output_lewat;


        $output_percent_kehadiran = '';
        if ($output_jum_hadir > 0) {
            //kira percent
            $output_percent_kehadiran = Round(($output_jum_hadir / $output_hari_bekerja) * 100, 0);
        } else {
            //takde percent
            $output_percent_kehadiran = 0;
        }

        $output_to_send = '{"nama":"' . $output_name . '","noic":"' . $output_noic . '","no_staff":"' . $output_no_staff . '","bil_awal":"' . $output_awal . '","bil_tepat":"' . $output_tepat . '","bil_lewat":"' . $output_lewat . '","jum_hari_bekerja":"' . $output_hari_bekerja . '","jum_hadir":"' . $output_jum_hadir . '","percent_hadir":"' . $output_percent_kehadiran.'%"}';
        //v02
        break;

    case '2'://log kehadiran imbasan/tag lokasi

        $nokp = $JsonSystem->getGETPOST('nokp');
        $month = ($JsonSystem->getGETPOST('month')=='') ? date('m'): $JsonSystem->getGETPOST('month');
	    $current_year = ($JsonSystem->getGETPOST('year')=='') ? date('Y') : $JsonSystem->getGETPOST('year');

        $year_month = $current_year . "-" . $month;

        /*$sql = "SELECT k.id,DATE_FORMAT(k.created_date,'%d-%m-%Y') AS tarikh,
				DATE_FORMAT(k.created_date,'%W') AS hari,
				DATE_FORMAT(m.masa_masuk,'%d-%m-%Y  %r') AS masa_masuk,
				IFNULL(DATE_FORMAT(m.masa_keluar,'%d-%m-%Y  %r'),'BELUM LOG') AS masa_keluar,
				k.status_kehadiran,
				IFNULL(SEC_TO_TIME(TIME_TO_SEC(m.total_time)),'00:00:00') AS jam_bekerja,
				m.remark_masuk, IFNULL(m.remark_keluar,'-') AS remark_keluar,
				m.device_masuk,IFNULL(m.device_keluar,'-') AS device_keluar,IFNULL(k.sebab_kelewatan,'-') AS sebab_kelewatan
				FROM masa_kehadiran m 
				LEFT JOIN kehadiran k ON m.id_kehadiran=k.id
				LEFT JOIN staff s ON k.nokp_staff=s.noic
				WHERE k.nokp_staff = '$nokp' AND s.`status`='BEKERJA' AND
				DATE_FORMAT(m.masa_masuk,'%Y-%M')='$year_month' 
				ORDER BY m.masa_masuk DESC";*/
        //v02
        $sql = "SELECT d.id,DATE_FORMAT(d.created_at,'%d-%m-%Y') AS date,
				DATE_FORMAT(d.created_at,'%W') AS day,
				DATE_FORMAT(t.clock_in_time,'%d-%m-%Y  %r') AS time_in,
				IFNULL(DATE_FORMAT(t.clock_out_time,'%d-%m-%Y  %r'),'BELUM LOG') AS time_out,
				d.status,
				IFNULL(SEC_TO_TIME(t.total_time),'00:00:00') AS work_hour,
				t.clock_in_remark AS location_in, IFNULL(t.clock_out_remark,'-') AS location_out,
				t.clock_in_method AS method_in, IFNULL(t.clock_out_method,'-') AS method_out, IFNULL(d.late_excuse,'-') AS late_excuse
				FROM v02_attendance_time t 
				LEFT JOIN v02_attendance_date d ON d.id = t.attendance_date_id
				LEFT JOIN staff s ON s.id = d.staff_id
				WHERE s.noic = '$nokp' AND s.status='BEKERJA' 
                AND DATE_FORMAT(t.clock_in_time, '%Y-%m')='$year_month' 
				ORDER BY t.clock_in_time DESC";
        //v02
                //skrg x tolak waktu rehat 1jam. kalau nk nk tolok balik letok ni -> -TIME_TO_SEC(s.jum_jam_break) dkt line 153
        $output = $JsonSystem->getJSONData($sql, '', null);
        $output_to_send = "[{$output}]";

        break;

    case '3'://update attendance masuk
        $nokp = $JsonSystem->getGETPOST('noic');
        $lokasi = $JsonSystem->getGETPOST('lokasi');
        $cawangan_kod = $JsonSystem->getGETPOST('cawangan_kod');
        $nama_cawangan = $JsonSystem->getGETPOST('nama_cawangan');
        $no_staff = $JsonSystem->getGETPOST('no_staff');
        $inputmasuk = $JsonSystem->getGETPOST('masa_masuk');
        $inputkeluar = $JsonSystem->getGETPOST('masa_keluar');

        $device_id = $JsonSystem->getGETPOST('device_id') ?? '';
        $devive_name = $JsonSystem->getGETPOST('device_name') ?? '';
        $koor = explode(",", $lokasi);
        $latitude = $koor[0];
        $longitude = $koor[1];

        $created_by = getStaffId($nokp);

        //check nearest location
        /*$objectQuery = "SELECT *, ((acos(sin((" . $latitude . "*pi()/180))
        * sin((`latitude`*pi()/180))+cos((" . $latitude . "*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((" . $longitude . "- `longitude`)*
        pi()/180))))*180/pi())*60*1.1515*1.609344  as distance FROM `lkp_location` HAVING distance <='0.1' ORDER BY distance asc";*/

        if ($latitude == '0' && $longitude == '0') {
            $output_to_send = "Koordinat tidak sah.";
        } else {
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

            $objectQuery = "SELECT *, (" . $earth_radius . " * acos (
								  cos ( radians(" . $latitude . ") )
								  * cos( radians( `latitude` ) )
								  * cos( radians( `longitude` ) - radians(" . $longitude . ") )
								  + sin ( radians(" . $latitude . ") )
								  * sin( radians( `latitude` ) )
								)
							) AS distance
							FROM `lkp_location`
							HAVING distance < 1.5 
							ORDER BY distance ASC LIMIT 1";

            $remark_lokasi = $JsonSystem->getData($objectQuery);

            $remark_lokasi = $remark_lokasi[1];

            if ($remark_lokasi == "") {
                $remark_lokasi = "LUAR KAWASAN";
            }

            //v02
            addClockIn($created_by, $nokp, $remark_lokasi, 'QR-SCAN', $lokasi);
            //v02

            //$masa = $JsonSystem->getData("SELECT masa_bekerja FROM masa_bekerja where shift_code = (select shift_kerja from staff where noic='$nokp' AND status = 'BEKERJA')");
            if ($inputmasuk!=''){
                $masa_bekerja =$inputmasuk;
            }else{
                $masa = $JsonSystem->getData("SELECT masa_bekerja FROM masa_bekerja where shift_code = (select shift_kerja from tarikh_bekerja where no_staff='$no_staff' AND tarikh = CURRENT_DATE())");
                $masa_bekerja = $masa[0];
            }

            $sql = "SELECT MAX(mk.id) AS id FROM masa_kehadiran mk
			LEFT JOIN kehadiran k ON mk.id_kehadiran=k.id
			WHERE DATE_FORMAT(mk.masa_masuk,'%Y-%m-%d') NOT IN(DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')) AND k.nokp_staff='$nokp'";

            $id = $connjson->query($sql)->fetch_object()->id;

            $sql2 = "SELECT IFNULL(MAX(id),0) AS id,masa_masuk,id_kehadiran FROM masa_kehadiran
				WHERE id='$id' AND masa_keluar IS NULL";

            $id_mk = $connjson->query($sql2)->fetch_object()->id;
            $id_kehadiran = $connjson->query($sql2)->fetch_object()->id_kehadiran;

            if ($id_mk > 0)//ada data
            {
                $masa_masuk = $connjson->query($sql2)->fetch_object()->masa_masuk;
                $tarikh_masuk = date('Y-m-d', strtotime($masa_masuk));
                $masa_mk = $tarikh_masuk . " " . $masa_bekerja;
                if ($inputkeluar!=''){
                    $masa_keluar = $inputkeluar;
                }else{
                    $masa_keluar = date('Y-m-d H:i:s', strtotime('+9 hour', strtotime($masa_mk)));
                }


                if ($masa_masuk > $masa_keluar) {
                    $sql3 = "UPDATE masa_kehadiran SET masa_keluar='$masa_masuk', total_time=TIMEDIFF('$masa_masuk',masa_masuk),
						lokasi_keluar='0.0,0.0',remark_keluar='TIADA IMBASAN KELUAR',device_keluar='AUTO' where id='$id_mk'";
                } else {
                    $sql3 = "UPDATE masa_kehadiran SET masa_keluar='$masa_keluar', total_time=TIMEDIFF('$masa_keluar',masa_masuk),
						lokasi_keluar='0.0,0.0',remark_keluar='TIADA IMBASAN KELUAR',device_keluar='AUTO' where id='$id_mk'";
                }

                $output = $JsonSystem->executeOperation2($sql3);

                //update status availability kehadiran
                $sql10 = "UPDATE kehadiran SET availability='KELUAR' where id='$id_kehadiran'";
                $JsonSystem->executeOperation2($sql10);

            }

            $sql8 = "SELECT MAX(mk.id) AS id , mk.masa_masuk FROM masa_kehadiran mk
			LEFT JOIN kehadiran k ON mk.id_kehadiran=k.id
			WHERE DATE_FORMAT(mk.masa_masuk,'%Y-%m-%d') = (DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')) AND k.nokp_staff='$nokp'
			AND mk.masa_keluar IS NULL";

            $current_id = $connjson->query($sql8)->fetch_object()->id;
            if ($current_id > 0)//ada data
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
            if ($checkId > 0) {
                $sql5 = "INSERT INTO masa_kehadiran (id_kehadiran,masa_masuk,lokasi_masuk,remark_masuk,device_masuk,created_by) VALUES ('$checkId',CURRENT_TIMESTAMP,'$lokasi','$remark_lokasi','MOBILE-IMBASANQR','$no_staff')";

                $newid = $JsonSystem->executeOperation2($sql5);

                //update status availability kehadiran
                $sql11 = "UPDATE kehadiran SET availability='MASUK' where id='$checkId'";
                $JsonSystem->executeOperation2($sql11);

            } else {

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
			m.lokasi_masuk FROM masa_kehadiran m WHERE m.id='{$newid}'", '', null);

            $output_to_send = "{$output2}";

        }
        LogKehadiran($nokp.' '.$lokasi.' '.$device_id.' '.$devive_name);
        break;

    case '4'://update attendance keluar
        $nokp = $JsonSystem->getGETPOST('noic');
        $lokasi = $JsonSystem->getGETPOST('lokasi');
        $cawangan_kod = $JsonSystem->getGETPOST('cawangan_kod');
        $nama_cawangan = $JsonSystem->getGETPOST('nama_cawangan');

        $device_id = $JsonSystem->getGETPOST('device_id') ?? '';
        $devive_name = $JsonSystem->getGETPOST('device_name') ?? '';

        $koor = explode(",", $lokasi);
        $latitude = $koor[0];
        $longitude = $koor[1];

        $created_by = getStaffId($nokp);

        //check nearest location
        /*$objectQuery = "SELECT *, ((acos(sin((" . $latitude . "*pi()/180))
        * sin((`latitude`*pi()/180))+cos((" . $latitude . "*pi()/180)) * cos((`latitude`*pi()/180)) * cos(((" . $longitude . "- `longitude`)*
        pi()/180))))*180/pi())*60*1.1515*1.609344  as distance FROM `lkp_location` HAVING distance <='0.1' ORDER BY distance asc";*/

        if ($latitude == '0' && $longitude == '0') {
            $output_to_send = "Koordinat tidak sah.";
        } else {
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

            $objectQuery = "SELECT *, (" . $earth_radius . " * acos (
								  cos ( radians(" . $latitude . ") )
								  * cos( radians( `latitude` ) )
								  * cos( radians( `longitude` ) - radians(" . $longitude . ") )
								  + sin ( radians(" . $latitude . ") )
								  * sin( radians( `latitude` ) )
								)
							) AS distance
							FROM `lkp_location`
							HAVING distance < 1.5 
							ORDER BY distance ASC LIMIT 1";

            $remark_lokasi = $JsonSystem->getData($objectQuery);
            $remark_lokasi = $remark_lokasi[1];
            if ($remark_lokasi == "") {
                $remark_lokasi = "LUAR KAWASAN";
            }

            //v02
            updateClockOut ($created_by, $nokp, $remark_lokasi, 'QR-SCAN', $lokasi);
            //v02

            $output2 = "";
            $sql1 = "SELECT IFNULL(max(k.id),0) AS id 
						FROM kehadiran k
						LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
						WHERE nokp_staff='$nokp' AND m.masa_keluar IS NULL ";

            /*$sql1 = "SELECT IFNULL(id,0) AS id FROM  kehadiran WHERE nokp_staff='$nokp'
                AND DATE_FORMAT(created_date,'%d-%m-%Y')=DATE_FORMAT(CURRENT_TIMESTAMP,'%d-%m-%Y')";*/

            $_checkId = $JsonSystem->getData($sql1);
            $checkId = $_checkId[0];

            if ($checkId > 0) {
                $sql3 = "SELECT id FROM masa_kehadiran WHERE id_kehadiran='$checkId' AND masa_keluar IS NULL 
				AND id = (SELECT MAX(id) AS id FROM masa_kehadiran WHERE id_kehadiran='$checkId') ";

                $masa_res = $connjson->query($sql3);
                $masa_id = "0";
                if ($masa_res->num_rows > 0)//ada data
                {
                    $masa_id = $masa_res->fetch_object()->id;

                    if ($masa_id > 0) {

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

                    $output2 = $JsonSystem->getJSONData($sql5, '', null);
                    $output_to_send = "{$output2}";
                } else {
                    $output_to_send = "[]";
                }
            }
        }
        LogKehadiran($nokp.' '.$lokasi.' '.$device_id.' '.$devive_name);
        break;

    case '5'://upload photo -masuk

        $nokp = $JsonSystem->getGETPOST('noic');
        $lokasi = $JsonSystem->getGETPOST('lokasi');
        $cawangan_kod = $JsonSystem->getGETPOST('cawangan_kod');
        $image_bytes = $JsonSystem->getGETPOST('image_bytes');
        $no_staff = $JsonSystem->getGETPOST('no_staff');
        $flag = $JsonSystem->getGETPOST('flag');

        $device_id = $JsonSystem->getGETPOST('device_id') ?? '';
        $devive_name = $JsonSystem->getGETPOST('device_name') ?? '';

        $koor = explode(",", $lokasi);
        $latitude = $koor[0];
        $longitude = $koor[1];

        if ($latitude == '0' && $longitude == '0') {
            $output_to_send = "Koordinat tidak sah.";
        } else {
            //in km  //distance = 0.5 = 500 metres
            $earth_radius = 6371;
            $objectQuery = "SELECT *, (" . $earth_radius . " * acos (
								  cos ( radians(" . $latitude . ") )
								  * cos( radians( `latitude` ) )
								  * cos( radians( `longitude` ) - radians(" . $longitude . ") )
								  + sin ( radians(" . $latitude . ") )
								  * sin( radians( `latitude` ) )
								)
							) AS distance
							FROM `lkp_location`
							HAVING distance < 1.5
							ORDER BY distance ASC LIMIT 1";

            $remark_lokasi = $JsonSystem->getData($objectQuery);

            $remark_lokasi = $remark_lokasi[1];

            if ($remark_lokasi == "") {
                $remark_lokasi = "LUAR KAWASAN";
            }

            //$masa = $JsonSystem->getData("SELECT masa_bekerja FROM masa_bekerja where shift_code = (select shift_kerja from staff where noic='$nokp' AND status = 'BEKERJA')");
            $masa = $JsonSystem->getData("SELECT masa_bekerja FROM masa_bekerja where shift_code = (select shift_kerja from tarikh_bekerja where no_staff='$no_staff' AND tarikh = CURRENT_DATE())");

            $masa_bekerja = $masa[0];

            $sql = "SELECT MAX(mk.id) AS id FROM masa_kehadiran mk
				LEFT JOIN kehadiran k ON mk.id_kehadiran=k.id
				WHERE DATE_FORMAT(mk.masa_masuk,'%Y-%m-%d') NOT IN(DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')) AND k.nokp_staff='$nokp'";

            $id = $connjson->query($sql)->fetch_object()->id;

            $sql2 = "SELECT IFNULL(MAX(id),0) AS id,masa_masuk,id_kehadiran FROM masa_kehadiran
					WHERE id='$id' AND masa_keluar IS NULL";

            $id_mk = $connjson->query($sql2)->fetch_object()->id;
            $id_kehadiran = $connjson->query($sql2)->fetch_object()->id_kehadiran;

            if ($id_mk > 0)//ada data
            {
                $masa_masuk = $connjson->query($sql2)->fetch_object()->masa_masuk;
                $tarikh_masuk = date('Y-m-d', strtotime($masa_masuk));
                $masa_mk = $tarikh_masuk . " " . $masa_bekerja;
                $masa_keluar = date('Y-m-d H:i:s', strtotime('+9 hour', strtotime($masa_mk)));

                if ($masa_masuk > $masa_keluar) {
                    $sql3 = "UPDATE masa_kehadiran SET masa_keluar='$masa_masuk', total_time=TIMEDIFF('$masa_masuk',masa_masuk),
							lokasi_keluar='0.0,0.0',remark_keluar='TIADA IMBASAN KELUAR',device_keluar='AUTO' where id='$id_mk'";
                } else {
                    $sql3 = "UPDATE masa_kehadiran SET masa_keluar='$masa_keluar', total_time=TIMEDIFF('$masa_keluar',masa_masuk),
							lokasi_keluar='0.0,0.0',remark_keluar='TIADA IMBASAN KELUAR',device_keluar='AUTO' where id='$id_mk'";
                }

                $output = $JsonSystem->executeOperation2($sql3);
                //update status availability kehadiran
                $sql10 = "UPDATE kehadiran SET availability='KELUAR' where id='$id_kehadiran'";
                $JsonSystem->executeOperation2($sql10);
            }

            $sql8 = "SELECT MAX(mk.id) AS id , mk.masa_masuk FROM masa_kehadiran mk
				LEFT JOIN kehadiran k ON mk.id_kehadiran=k.id
				WHERE DATE_FORMAT(mk.masa_masuk,'%Y-%m-%d') = (DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')) AND k.nokp_staff='$nokp'
				AND mk.masa_keluar IS NULL";

            $current_id = $connjson->query($sql8)->fetch_object()->id;
            if ($current_id > 0)//ada data
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
            if ($checkId > 0) {

                if ($flag == '1')//pengesahan_kehadiran manual
                {
                    $sql5 = "INSERT INTO masa_kehadiran (id_kehadiran,masa_masuk,lokasi_masuk,remark_masuk,device_masuk,created_by) VALUES ('$checkId',CURRENT_TIMESTAMP,'$lokasi','$remark_lokasi','MOBILE-PENGESAHANMANUAL','$no_staff')";
                    $newid = $JsonSystem->executeOperation2($sql5);
                } else if ($flag == '2')//pengesahan_kehadiran qr
                {
                    $sql5 = "INSERT INTO masa_kehadiran (id_kehadiran,masa_masuk,lokasi_masuk,remark_masuk,device_masuk,created_by) VALUES ('$checkId',CURRENT_TIMESTAMP,'$lokasi','$remark_lokasi','MOBILE-PENGESAHANQR','$no_staff')";
                    $newid = $JsonSystem->executeOperation2($sql5);
                } else {
                    $sql5 = "INSERT INTO masa_kehadiran (id_kehadiran,masa_masuk,lokasi_masuk,remark_masuk,device_masuk,created_by) VALUES ('$checkId',CURRENT_TIMESTAMP,'$lokasi','$remark_lokasi','MOBILE-SWAFOTO','$no_staff')";
                    $newid = $JsonSystem->executeOperation2($sql5);
                }


                //update status availability kehadiran
                $sql12 = "UPDATE kehadiran SET availability='MASUK' where id='$checkId'";
                $JsonSystem->executeOperation2($sql12);

            } else {

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

                if ($flag == '1')//pengesahan_kehadiran manual
                {
                    $sql7 = "INSERT INTO masa_kehadiran (id_kehadiran,masa_masuk,lokasi_masuk,remark_masuk,device_masuk,created_by) 
							VALUES ('$newid',CURRENT_TIMESTAMP,'$lokasi','$remark_lokasi','MOBILE-PENGESAHANMANUAL','$no_staff')";

                    $newid = $JsonSystem->executeOperation2($sql7);
                } else if ($flag == '2')//pengesahan_kehadiran qr
                {
                    $sql7 = "INSERT INTO masa_kehadiran (id_kehadiran,masa_masuk,lokasi_masuk,remark_masuk,device_masuk,created_by) 
							VALUES ('$newid',CURRENT_TIMESTAMP,'$lokasi','$remark_lokasi','MOBILE-PENGESAHANQR','$no_staff')";

                    $newid = $JsonSystem->executeOperation2($sql7);
                } else {
                    $sql7 = "INSERT INTO masa_kehadiran (id_kehadiran,masa_masuk,lokasi_masuk,remark_masuk,device_masuk,created_by) 
							VALUES ('$newid',CURRENT_TIMESTAMP,'$lokasi','$remark_lokasi','MOBILE-SWAFOTO','$no_staff')";

                    $newid = $JsonSystem->executeOperation2($sql7);
                }
            }

            $output2 = $JsonSystem->getData("SELECT DATE_FORMAT(m.masa_masuk,'%r') AS masa_masuk,
				m.lokasi_masuk FROM masa_kehadiran m WHERE m.id='{$newid}'", '', null);

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
            $directoryName = "../logphoto/" . $folder . "/";

            if (!is_dir($directoryName)) {
                //Directory does not exist, so lets create it.
                mkdir($directoryName, 0755);
            }

            $filename = "M" . "_" . $newid . "_" . $nokp;
            // Specify the location where you want to save the image
            $img_file = $directoryName . $filename . ".{$ext}";

            $file = $filename . ".{$ext}";

            // Save binary data as raw data (that is, it will not remove metadata or invalid contents)
            // In this case, the PHP backdoor will be stored on the server
            file_put_contents($img_file, $content);
            $output_file = "Berjaya dimuat naik.";
            //update filename into table
            $sql11 = "UPDATE masa_kehadiran SET photo_masuk= '$file' where id='$newid' ";

            $JsonSystem->executeOperation($sql11);

            //v02
            $folderPath = "../logphoto/";
            $fileName = $nokp.'-'.create_guid().'-'.'.'.$ext;
            $v02file = $folderPath . $fileName;
            file_put_contents($folderPath.$fileName, $content);
            addMobilePhotoClockIn($nokp, $cawangan_kod, $remark_lokasi, $lokasi, $fileName);
            //v02

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
            $output_to_send = '{"masa_masuk":"' . $output2[0] . '","lokasi_masuk":"' . $output2[1] . '","message":"' . $output_file . '"}';

        }
        LogKehadiran($nokp.' '.$lokasi.' '.$device_id.' '.$devive_name);
        break;

    case '6'://upload photo - keluar

        $nokp = $JsonSystem->getGETPOST('noic');
        $lokasi = $JsonSystem->getGETPOST('lokasi');
        $cawangan_kod = $JsonSystem->getGETPOST('cawangan_kod');
        $image_bytes = $JsonSystem->getGETPOST('image_bytes');
        $no_staff = $JsonSystem->getGETPOST('no_staff');
        $flag = $JsonSystem->getGETPOST('flag');

        $device_id = $JsonSystem->getGETPOST('device_id') ?? '';
        $devive_name = $JsonSystem->getGETPOST('device_name') ?? '';

        $koor = explode(",", $lokasi);
        $latitude = $koor[0];
        $longitude = $koor[1];

        if ($latitude == '0' && $longitude == '0') {
            $output_to_send = "Koordinat tidak sah.";
        } else {
            //in km  //distance = 0.5 = 500 metres
            $earth_radius = 6371;
            $objectQuery = "SELECT *, (" . $earth_radius . " * acos (
								  cos ( radians(" . $latitude . ") )
								  * cos( radians( `latitude` ) )
								  * cos( radians( `longitude` ) - radians(" . $longitude . ") )
								  + sin ( radians(" . $latitude . ") )
								  * sin( radians( `latitude` ) )
								)
							) AS distance
							FROM `lkp_location`
							HAVING distance < 1.5 
							ORDER BY distance ASC LIMIT 1";

            $remark_lokasi = $JsonSystem->getData($objectQuery);
            $remark_lokasi = $remark_lokasi[1];
            if ($remark_lokasi == "") {
                $remark_lokasi = "LUAR KAWASAN";
            }

            $output2 = "";
            $sql1 = "SELECT IFNULL(max(k.id),0) AS id 
							FROM kehadiran k
							LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
							WHERE nokp_staff='$nokp' AND m.masa_keluar IS NULL ";


            $_checkId = $JsonSystem->getData($sql1);
            $checkId = $_checkId[0];


            if ($checkId > 0) {
                $sql3 = "SELECT id FROM masa_kehadiran WHERE id_kehadiran='$checkId' AND masa_keluar IS NULL 
					AND id = (SELECT MAX(id) AS id FROM masa_kehadiran WHERE id_kehadiran='$checkId') ";

                $masa_res = $connjson->query($sql3);
                $masa_id = "0";
                if ($masa_res->num_rows > 0)//ada data
                {
                    $masa_id = $masa_res->fetch_object()->id;

                    if ($masa_id > 0) {

                        $sql_staff = "SELECT s.no_staff FROM staff s WHERE s.noic = '$nokp' AND s.`status` = 'BEKERJA'";
                        $_checkNoStaff = $JsonSystem->getData($sql_staff);
                        $checkNoStaff = $_checkNoStaff[0];


                        if ($flag == '1')//pengesahan_kehadiran manual
                        {
                            $sql4 = "UPDATE masa_kehadiran SET masa_keluar=CURRENT_TIMESTAMP, total_time=TIMEDIFF(CURRENT_TIMESTAMP,masa_masuk),
								lokasi_keluar='$lokasi',remark_keluar='$remark_lokasi',device_keluar='MOBILE-PENGESAHANMANUAL' where id='$masa_id' ";

                            $JsonSystem->executeOperation($sql4);
                        } else if ($flag == '2')//pengesahan_kehadiran qr
                        {
                            $sql4 = "UPDATE masa_kehadiran SET masa_keluar=CURRENT_TIMESTAMP, total_time=TIMEDIFF(CURRENT_TIMESTAMP,masa_masuk),
								lokasi_keluar='$lokasi',remark_keluar='$remark_lokasi',device_keluar='MOBILE-PENGESAHANQR' where id='$masa_id' ";

                            $JsonSystem->executeOperation($sql4);
                        } else {
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

                    $output2 = $JsonSystem->getData($sql5, '', null);

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
                    $directoryName = "../logphoto/" . $folder . "/";

                    if (!is_dir($directoryName)) {
                        //Directory does not exist, so lets create it.
                        mkdir($directoryName, 0755);
                    }

                    $filename = "K" . "_" . $masa_id . "_" . $nokp;
                    // Specify the location where you want to save the image
                    $img_file = $directoryName . $filename . ".{$ext}";

                    $file = $filename . ".{$ext}";

                    // Save binary data as raw data (that is, it will not remove metadata or invalid contents)
                    // In this case, the PHP backdoor will be stored on the server
                    file_put_contents($img_file, $content);
                    $output_file = "Berjaya dimuat naik.";
                    //update filename into table
                    $sql4 = "UPDATE masa_kehadiran SET photo_keluar= '$file' where id='$masa_id'";
                    $JsonSystem->executeOperation($sql4);

                    //v02
                    $folderPath = "../logphoto/";
                    $fileName = $nokp.'-'.create_guid().'-'.'.'.$ext;
                    $v02file = $folderPath . $fileName;
                    file_put_contents($folderPath.$fileName, $content);
                    updateMobilePhotoClockOut($nokp, $remark_lokasi, $lokasi, $fileName);
                    //v02

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
                    $output_to_send = '{"masa_keluar":"' . $output2[0] . '","lokasi_keluar":"' . $output2[1] . '","message":"' . $output_file . '"}';

                } else {
                    $output_to_send = "[]";
                }
            }
        }
        LogKehadiran($nokp.' '.$lokasi.' '.$device_id.' '.$devive_name);
        break;

    case '7'://select jenis cuti
        $nokp = $JsonSystem->getGETPOST('noic');
        $sql = "SELECT name FROM `staff` WHERE no_staff='$nokp'";
        $output = $connjson->query($sql)->fetch_object()->name;
        $output_to_send=$output;
        break;

    case '8'://update sebab kelewatan
        $id_kehadiran = $JsonSystem->getGETPOST('id_kehadiran');
        $sebab_lewat = $JsonSystem->getGETPOST('sebab_lewat');
        $sql = "UPDATE `kehadiran` SET sebab_kelewatan='$sebab_lewat' WHERE id=$id_kehadiran";
        //v02
        lateExcuse ($sebab_lewat, $id_kehadiran);
        //v02
        $output_to_send = json_encode($JsonSystem->executeOperation($sql));
        break;
		
    case '9'://get location code
	$latitude = $JsonSystem->getGETPOST('latitude');
        $longitude = $JsonSystem->getGETPOST('longitude');
	$earth_radius = 6371;
    	$objectQuery = "SELECT *, (" . $earth_radius . " * acos (
								  cos ( radians(" . $latitude . ") )
								  * cos( radians( `latitude` ) )
								  * cos( radians( `longitude` ) - radians(" . $longitude . ") )
								  + sin ( radians(" . $latitude . ") )
								  * sin( radians( `latitude` ) )
								)
							) AS distance
							FROM `lkp_location`
							HAVING distance < 1.5 
							ORDER BY distance ASC LIMIT 1";

	$remark_lokasi = $JsonSystem->getData($objectQuery);

	$remark_lokasi = $remark_lokasi[1];

	if ($remark_lokasi == "") {
	$remark_lokasi = "LUAR KAWASAN";
	}
	echo $remark_lokasi;
        break;

    case '40'://select jenis cuti

        $sql = "SELECT CONCAT(jc.code, '-', jc.`desc`) AS jenis_cuti FROM jenis_cuti jc";

        //$output = $JsonSystem->getJSONData($sql, '', null);
        //$output_to_send = "[{$output}]"

        $output = $connjson->query($sql);
        $jenis2cuti = array();

        while($r = mysqli_fetch_assoc($output)) {
            $jenis2cuti[] = $r["jenis_cuti"];
        }
        echo json_encode($jenis2cuti);
        //$output_to_send = json_encode($output);
        break;
}
// Closing connection
mysqli_close($connjson);
echo $output_to_send;
