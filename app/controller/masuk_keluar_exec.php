<?php

    include "../model/kehadiran_functions.php";
    
    date_default_timezone_set("Asia/Kuala_Lumpur");
	$date_month = date(m);
	$date_year = date(Y);
	$date_day = date(d);
	$time_hour = date(H);
	$time_min = date(i);
	$time_sec = date(s);
	$current_date = $date_year.'-'.$date_month.'-'.$date_day.' '.$time_hour.':'.$time_min.':'.$time_sec;
	
	
	$sys = getSys(1)->fetch_assoc();
		
	$nokp = $_GET['nokp'];
	$act = $_GET['act'];

	$sys_data = getSys(1)->fetch_assoc();
	$semysmsdevice=$sys_data['semysmsdevice'];
	$semysmstoken=$sys_data['semysmstoken'];
								 
								 
		if($act=="masuk"){
	
		$result = addkehadiran($nokp);
		
		// start send sms out - makluman keluar premis
	/*
		$url = "https://semysms.net/api/3/sms.php"; //Url address for sending SMS
        $phone = $notel_penjaga; // Phone number
         $msg = 'RM0.00 Tuan/Puan, adalah dimaklumkan bahawa '.$nama_pelajar.' telahpun didaftarkan MASUK ke kawasan pusat jagaan pada hari ini;'.$current_date.'. Harap maklum. ('.$sys['sys_owner'].')';  // Message
         $device = $semysmsdevice;  //  Device code
         $token = $semysmstoken;  //  Your token (secret)
        
         $data = array(
                "phone" => $phone,
                "msg" => $msg,
                "device" => $device,
                "token" => $token
            );
        
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);     
            $output = curl_exec($curl);
            curl_close($curl);
        
            //echo $output;
		
		
		*/
		// end send sms out - makluman keluar premis
		
		
		//Check whether the query was successful or not
			if($result > 0) {
				 echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/panel_imbasan_photo.php?page=panel_imbasan_masuk&id=$result';
						</script>");
				//header("location: ../view/testscan.php");
				exit();
			}else {
				echo ("<script LANGUAGE='JavaScript'>
						window.alert('Tidak berjaya. Sila cuba imbas semula.');
						window.location.href='../view/panel_imbasan_photo.php?id=$result';
						</script>");
			}
	
		}else{
			$result = updatekehadiran($nokp);
		
			// start send sms out - makluman masuk premis
			/*
		$url = "https://semysms.net/api/3/sms.php"; //Url address for sending SMS
        $phone = $notel_penjaga; // Phone number
         $msg = 'RM0.00 Tuan/Puan, adalah dimaklumkan bahawa '.$nama_pelajar.' telahpun didaftarkan KELUAR dari kawasan pusat jagaan pada hari ini;'.$current_date.'. Harap maklum. ('.$sys['sys_owner'].')';  // Message
         $device = $semysmsdevice;  //  Device code
         $token = $semysmstoken;  //  Your token (secret)
        
         $data = array(
                "phone" => $phone,
                "msg" => $msg,
                "device" => $device,
                "token" => $token
            );
        
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);     
            $output = curl_exec($curl);
            curl_close($curl);
        
            //echo $output;
		
		// end send sms out - makluman masuk premis
			
		*/
			
			//Check whether the query was successful or not
				if($result > 0) {
					echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/panel_imbasan_photo.php?page=panel_imbasan_keluar&id=$result';
						</script>");
					//header("location: ../view/testscan.php");
					exit();
				}else {
					echo ("<script LANGUAGE='JavaScript'>
				window.alert('Tidak berjaya. Imbasan keluar telah dibuat.');
				window.location.href='../view/panel_imbasan_keluar.php';
				</script>");
				}
		}
	
    
?>