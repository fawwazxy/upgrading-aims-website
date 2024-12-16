<?php
//phpinfo();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header('Content-type: application/json');

require_once('lib/json.inc');

error_log('json_ilibrary.php');
error_reporting(E_ALL);
ini_set("display_errors", 0);

$JsonSystem = new Json();

$cmd = $JsonSystem->getGETPOST('cmd');

$output = '';
$output_to_send = '';
switch($cmd) {
	
	case '1': //login
	
		$role = $JsonSystem->getGETPOST('role');
	    $nama = $JsonSystem->getGETPOST('username');
	    $pwd = $JsonSystem->getGETPOST('password');
		
		if($role == "PUBLIC")
		{
			$sql ="select id, noic, name, username, accs_pwd, phone, email, role_id, status
		FROM elibrary_public_login where STATUS='1' and username='$nama' and accs_pwd='$pwd'";
		}
		else
		{
			$sql ="select id, noic, name, username, accs_pwd, phone, email, role_id, status
		FROM staff where status='BEKERJA' and username='$nama' and accs_pwd='$pwd'";
		}
		
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
	
	case '2'://check status BEKERJA/TIDAK
	
		$id = $JsonSystem->getGETPOST('id');
		$role = $JsonSystem->getGETPOST('role');
		
		if($role == "PUBLIC")
		{
			$sql="select status FROM elibrary_public_login where id ='{$id}'";
		}
		else
		{
			$sql="select status FROM staff where id ='{$id}'";
		}
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '3'://check role id user
	
		$role_id = $JsonSystem->getGETPOST('role_id');
		
		$sql="SELECT * FROM sec_role_menu a WHERE a.role_code = '{$role_id}'
			AND a.access_menu = '1'
			AND a.menu_id IN (SELECT b.id FROM sec_module_menu b WHERE b.module_code = 'PERPUSTAKAANDIGITAL' 
			AND  b.menu = UPPER('PILIHAN TERMINAL'))";
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '4'://select list jenis elibrary
	
		$sql="SELECT a.id,UPPER(a.jenis) AS jenis FROM lkp_elibrary_jenis a WHERE a.`status` = '1' ";
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '5'://select senarai bahan bacaan 
	
		$jenis = $JsonSystem->getGETPOST('jenis');
		$query = $JsonSystem->getGETPOST('query');
		
		if($query != '')
		{
			$sql1="SELECT id,frontpage_cover_file,nama,penerbit,tahun_terbitan,pengarang,
			keterangan,document_file FROM elibrary WHERE id_jenis = (SELECT a.id FROM lkp_elibrary_jenis a WHERE a.jenis ='{$jenis}')
			AND (nama LIKE '%$query%' OR pengarang LIKE '%$query%' OR penerbit LIKE '%$query%')
			AND status_naskah NOT IN(2) ORDER BY nama ASC";
			
			$result = $connjson->query($sql1);
		
			echo '[';
				
				if($result->num_rows > 0)//ada data
				{
					$i = 0;
					while($data = $result->fetch_assoc()) {
					if($i>0)
							echo ',';
							$i++;
							
							$id_elibrary = $data['id'];
							
							$sql2="SELECT COUNT(et.id) AS jumlah_terjemahan FROM elibrary_terjemahan et 
									LEFT JOIN elibrary e ON et.id_elibrary=e.id 
									WHERE e.id= '$id_elibrary'";
							
							$result2 = $connjson->query($sql2);
							$jumlah=$result2 -> fetch_object()->jumlah_terjemahan;
							
							$data['jumlah_terjemahan'] = $jumlah;
							
							echo json_encode($data);
						}
				}
					
				echo ']';
		}
		else
		{
			$sql1="SELECT id,frontpage_cover_file,nama,penerbit,tahun_terbitan,pengarang,
			keterangan,document_file FROM elibrary WHERE id_jenis = (SELECT a.id FROM lkp_elibrary_jenis a WHERE a.jenis ='{$jenis}')
			AND status_naskah NOT IN(2) ORDER BY nama ASC";
			
			$result = $connjson->query($sql1);
		
			echo '[';
				
				if($result->num_rows > 0)//ada data
				{
					$i = 0;
					while($data = $result->fetch_assoc()) {
					if($i>0)
							echo ',';
							$i++;
							
							$id_elibrary = $data['id'];
							
							$sql2="SELECT COUNT(et.id) AS jumlah_terjemahan FROM elibrary_terjemahan et 
									LEFT JOIN elibrary e ON et.id_elibrary=e.id 
									WHERE e.id= '$id_elibrary'";
							
							$result2 = $connjson->query($sql2);
							$jumlah=$result2 -> fetch_object()->jumlah_terjemahan;
							
							$data['jumlah_terjemahan'] = $jumlah;
							
							echo json_encode($data);
						}
				}
					
				echo ']';
		}
		
		
	break;
	
	case '6'://insert imbasan pinjaman
	
	$id_naskah = $JsonSystem->getGETPOST('id_naskah');
	$resultqr = $JsonSystem->getGETPOST('resultqr');
	$nama = $JsonSystem->getGETPOST('nama');
	$nokp = $JsonSystem->getGETPOST('nokp');
	$notel = $JsonSystem->getGETPOST('notel');
	$bil_hari_pinjam = $JsonSystem->getGETPOST('bil_hari');
	$created_by = $JsonSystem->getGETPOST('created_by');
	
	$sql = $JsonSystem->getData("SELECT e.nama,e.status_pinjam FROM elibrary e LEFT JOIN elibrary_naskah en ON en.id_elibrary = e.id
								WHERE en.id = '{$id_naskah}'");
								
	$check = $sql[1];
	
		if($check == 0)//tak boleh pinjam
		{
			$message = "Naskhah " .$resultqr. " tidak boleh dipinjam.";
			$output_to_send = '[{"nama_buku":"","message":"'.$message.'","id_pinjaman":""}]';
		}
		else//boleh pinjam
		{
			/*kalau boleh pinjam , check dah ada org pinjam ke belum*/
			/*ada org pinjam dan belum hantar*/
			$sql1 = "SELECT ep.* FROM elibrary_pinjaman ep WHERE ep.id_naskah = '{$id_naskah}' AND ep.`status` ='0'"; 

			$data = $conn->query($sql1);
			
			if($data->num_rows > 0)//ada data
			{
				$sql2 = $JsonSystem->getData("SELECT a.nama,a.notel FROM elibrary_peminjam a 
						WHERE a.nokp = (SELECT nokp FROM elibrary_pinjaman WHERE id_naskah = '{$id_naskah}')");

				$check_nama_peminjam = $sql2[0];
				$check_notel_peminjam = $sql2[1];
									
				$message = "Naskah " .$resultqr. " sedang dipinjam oleh: \\nNama : " .$check_nama_peminjam. "\\nNo Telefon : " .$check_notel_peminjam;
				$output_to_send = '[{"nama_buku":"","message":"'.$message.'","id_pinjaman":""}]';
			}
			else
			{
				$sql3 = "INSERT INTO elibrary_pinjaman (id_naskah,nokp,tarikh_pinjam,bil_hari_pinjam,created_by) VALUES
						('{$id_naskah}','{$nokp}',CURRENT_DATE,'{$bil_hari_pinjam}','{$created_by}')";
				
				$output_insert = $JsonSystem->executeOperation2($sql3);
				
				$sql4="SELECT COUNT(nokp) AS nokp FROM elibrary_peminjam WHERE nokp='{$nokp}'";
		
				$check_nokp = $JsonSystem->getData($sql4);
			
				$_check = $check_nokp[0];
			
				if($_check > 0)//ada data
				{
					$sql5="UPDATE elibrary_peminjam SET notel='{$notel}' WHERE nokp ='{$nokp}'";
				}
				else //takde data
				{
					$sql5="INSERT INTO elibrary_peminjam(nama,nokp,notel) VALUES ('{$nama}','{$nokp}','{$notel}')";
				}
		
				$output2 = $JsonSystem->executeOperation2($sql5);
				
				$sql6="SELECT e.id FROM elibrary_pinjaman e WHERE e.id_naskah = '{$id_naskah}' AND e.nokp = '{$nokp}'";
				$check_id = $JsonSystem->getData($sql6);
			
				$_check_id = $check_id[0];
				
				$message = "Naskah berjaya dipinjam.";
				$output_to_send = '[{"nama_buku":"'.$sql[0].'","message":"'.$message.'","id_pinjaman":"'.$_check_id.'"}]';
			}
		}
		
	break;
	
	
	case '7'://update pemulangan
	
	$id_naskah = $JsonSystem->getGETPOST('id_naskah');
	$id_elibrary = $JsonSystem->getGETPOST('id_elibrary');
	
	$sql = $JsonSystem->getData("SELECT COUNT(id) AS bil FROM elibrary_pinjaman
								WHERE id_naskah='{$id_naskah}' AND status='0'");
								
	$check = $sql[0];
	
		if($check > 0)//buku belum dipulangkan
		{
			$sql1="UPDATE elibrary_pinjaman SET status='1',tarikh_hantar=CURRENT_DATE
				WHERE id_naskah='{$id_naskah}' AND status='0'";
				
			$output = $JsonSystem->executeOperation2($sql1);
			
			$sql2 = $JsonSystem->getData("SELECT a.jenis,e.nama,e.lokasi_fizikal_hardcopy
					FROM elibrary e
					LEFT JOIN lkp_elibrary_jenis a ON e.id_jenis = a.id
					WHERE e.id = '{$id_elibrary}'");
			
			$message = "Telah berjaya dipulangkan";
			
			$check_jenis = $sql2[0];
			$check_nama = $sql2[1];
			$check_lokasi_fizikal_hardcopy = $sql2[2];
			
			$output_to_send = '[{"jenis":"'.$check_jenis.'","nama":"'.$check_nama.'","lokasi_fizikal_hardcopy":"'.$check_lokasi_fizikal_hardcopy.'","message":"'.$message.'"}]';
			
		}
		else//buku sudah dipulangkan
		{
			$message = "Tiada rekod untuk pemulangan";
			
			$output_to_send = '[{"jenis":"","nama":"","lokasi_fizikal_hardcopy":"","message":"'.$message.'"}]';
		}
		
	break;
	
	case '8'://select maklumat peminjam
	
	$nokp = $JsonSystem->getGETPOST('nokp');
	
	$sql = $JsonSystem->getData("SELECT COUNT(nokp) AS nokp FROM elibrary_peminjam WHERE nokp='{$nokp}'");
								
	$check = $sql[0];
	
		if($check > 0)//dah ada data
		{
			$sql1="SELECT UPPER(ep.nama) AS nama,ep.notel FROM elibrary_peminjam ep WHERE ep.nokp = '{$nokp}'";
				
			$output = $JsonSystem->getJSONData($sql1,'',null);
			$output_to_send = "[{$output}]";
		}
		else//belum ada data
		{
			$output_to_send = "[]";
		}
		
	break;
	
	case '9'://delete pinjaman
	
	$id_pinjaman = $JsonSystem->getGETPOST('id_pinjaman');
	
	$sql="DELETE FROM elibrary_pinjaman where id ='{$id_pinjaman}' ";
				
	$output = $JsonSystem->executeOperation2($sql);
			
	$output_to_send = "Berjaya dipadam.";
	
	break;
	
	case '10'://select senarai peminjam dan carian
	
	$nokp = $JsonSystem->getGETPOST('nokp');
	
	$sql="SELECT UPPER(a.nama) AS nama,a.nokp,a.notel,
			(SELECT e.nama FROM elibrary e LEFT JOIN elibrary_naskah en ON en.id_elibrary = e.id
			WHERE en.id = ep.id_naskah) AS nama_buku,ep.tarikh_pinjam,
			DATE_ADD(ep.tarikh_pinjam, INTERVAL (ep.bil_hari_pinjam) DAY) AS tarikh_tamat FROM elibrary_peminjam a
			LEFT JOIN elibrary_pinjaman ep ON ep.nokp = a.nokp
			WHERE ep.nokp = '{$nokp}' AND ep.`status` = '0'";
			
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '11'://analisa bulanan mengikut tahun bacaan online
	
	$year = $JsonSystem->getGETPOST('year');
	$type = $JsonSystem->getGETPOST('type');
	
	$sql="SELECT DATE_FORMAT(created_date,'%m') AS bulan, COUNT(*) AS jumlah FROM elibrary_log_analisa
			WHERE type = '$type' AND DATE_FORMAT(created_date,'%Y') = '$year' GROUP BY bulan";
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	/*case '12'://analisa tahunan bacaan online
	
	$type = $JsonSystem->getGETPOST('type');
	$year = $JsonSystem->getGETPOST('year');
	
	$sql = "SELECT COUNT(*) AS jumlah FROM elibrary_log_analisa
			WHERE type = '$type' AND DATE_FORMAT(created_date,'%Y') = '$year'";
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;*/
	
	case '12'://analisa tahunan bacaan online
	
	$nokp = $JsonSystem->getGETPOST('nokp');
	$id_elibrary = $JsonSystem->getGETPOST('id_elibrary');
	$type = $JsonSystem->getGETPOST('type');
	
	$sql = "INSERT INTO elibrary_log_analisa (id_elibrary,nokp,type) VALUES ('$id_elibrary','$nokp','$type')";
	$JsonSystem->executeOperation2($sql);
	
	break;
	
	case '13'://dropdown tahun analisa online
	
	$type = $JsonSystem->getGETPOST('type');
	
	$sql = "SELECT DATE_FORMAT(created_date,'%Y') AS tahun FROM elibrary_log_analisa
			WHERE type = '$type' GROUP BY tahun ORDER BY tahun DESC";
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '14'://analisa harian bacaan online
	
	$date = $JsonSystem->getGETPOST('tarikh');
	$type = $JsonSystem->getGETPOST('type');
	
	$sql = "SELECT COUNT(*) AS jumlah FROM elibrary_log_analisa
			WHERE type = '$type' AND DATE(created_date)='$date'";
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '15'://analisa mengikut bahan bacaan online harian
	
	$date = $JsonSystem->getGETPOST('tarikh');
	$type = $JsonSystem->getGETPOST('type');
	
	$sql = "SELECT e.frontpage_cover_file,e.nama,COUNT(ela.id) AS jumlah FROM elibrary_log_analisa ela
			LEFT JOIN elibrary e ON ela.id_elibrary = e.id
			WHERE ela.type = '$type' AND DATE(ela.created_date) = '$date'
			GROUP BY ela.id_elibrary ORDER BY jumlah DESC";
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '16'://analisa mengikut bahan bacaan online tahunan
	
	$year = $JsonSystem->getGETPOST('year');
	$type = $JsonSystem->getGETPOST('type');
	
	$sql = "SELECT e.frontpage_cover_file,e.nama,COUNT(ela.id) AS jumlah FROM elibrary_log_analisa ela
			LEFT JOIN elibrary e ON ela.id_elibrary = e.id
			WHERE ela.type = '$type' AND YEAR(ela.created_date) = '$year'
			GROUP BY ela.id_elibrary ORDER BY jumlah DESC";
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	/*case '17'://analisa tahunan pengunjung
	
	$year = $JsonSystem->getGETPOST('year');
	
	$sql = "SELECT COUNT(pin.nokp) AS jumlah FROM elibrary_pinjaman pin
   			WHERE DATE_FORMAT(created_date,'%Y') = '$year'";
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;*/
	case '17'://select senarai bahan bacaan 
	
		$query = $JsonSystem->getGETPOST('query');
		
		$sql1="SELECT id,frontpage_cover_file,nama,penerbit,tahun_terbitan,pengarang,
			keterangan,document_file FROM elibrary WHERE status_naskah NOT IN(2) 
			AND (nama LIKE '%$query%' OR pengarang LIKE '%$query%' OR penerbit LIKE '%$query%')
			ORDER BY nama ASC";
			
		$result = $connjson->query($sql1);
		
			echo '[';
				
				if($result->num_rows > 0)//ada data
				{
					$i = 0;
					while($data = $result->fetch_assoc()) {
					if($i>0)
							echo ',';
							$i++;
							
							$id_elibrary = $data['id'];
							
							$sql2="SELECT COUNT(et.id) AS jumlah_terjemahan FROM elibrary_terjemahan et 
									LEFT JOIN elibrary e ON et.id_elibrary=e.id 
									WHERE e.id= '$id_elibrary'";
							
							$result2 = $connjson->query($sql2);
							$jumlah=$result2 -> fetch_object()->jumlah_terjemahan;
							
							$data['jumlah_terjemahan'] = $jumlah;
							
							echo json_encode($data);
						}
				}
					
				echo ']';
	break;
	
	case '18'://analisa pengunjung tahunan mengikut bulan
	
	$year = $JsonSystem->getGETPOST('year');
	
	$sql = "SELECT DATE_FORMAT(pin.created_date,'%m') AS bulan,COUNT(DISTINCT(pin.nokp)) AS jumlah FROM elibrary_pinjaman pin
   			WHERE DATE_FORMAT(created_date,'%Y') = '$year' GROUP BY bulan";
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '19'://dropdown tahun analisa pengunjung
	
	$sql = "SELECT DATE_FORMAT(pin.created_date,'%Y') AS tahun FROM elibrary_pinjaman pin
   			GROUP BY tahun ORDER BY tahun DESC";
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '20'://analisa mengikut pengunjung harian
	
	$date = $JsonSystem->getGETPOST('tarikh');
	
	$sql = "SELECT COUNT(DISTINCT(pin.nokp)) AS jumlah FROM elibrary_pinjaman pin
			WHERE DATE(pin.created_date)='$date'";
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '21'://senarai terjemahan
	
	$id_elibrary = $JsonSystem->getGETPOST('id_elibrary');
	
	$sql = "SELECT et.document_file,UPPER(et.`language`) AS language FROM elibrary_terjemahan et 
			LEFT JOIN elibrary e ON et.id_elibrary=e.id 
			WHERE e.id='$id_elibrary' ORDER BY et.`language` ASC";
			
		$output = $JsonSystem->getJSONData($sql,'',null);
		$output_to_send = "[{$output}]";
	break;
	
	case '22'://select senarai bahan bacaan hardcopy -OPAC
	
		$query = $JsonSystem->getGETPOST('query');
		
		$sql1="SELECT id,frontpage_cover_file,nama,penerbit,tahun_terbitan,pengarang,
			lokasi_fizikal_hardcopy,bilangan AS jilid,bil_naskah_hardcopy
			FROM elibrary WHERE status_naskah NOT IN(0) AND status_pinjam ='1'
			AND (nama LIKE '%$query%' OR pengarang LIKE '%$query%' OR penerbit LIKE '%$query%')
			ORDER BY nama ASC";
			
		$result = $connjson->query($sql1);
		
			echo '[';
				
				if($result->num_rows > 0)//ada data
				{
					$i = 0;
					while($data = $result->fetch_assoc()) {
					if($i>0)
							echo ',';
							$i++;
							
							$id_elibrary = $data['id'];
							
							$sql2="SELECT COUNT(id) AS bil_sdg_dipinjam FROM elibrary_pinjaman WHERE STATUS = '0' 
									AND id_naskah IN (SELECT en.id FROM elibrary_naskah en WHERE en.id_elibrary='$id_elibrary')";
							
							$result2 = $connjson->query($sql2);
							$jumlah=$result2 -> fetch_object()->bil_sdg_dipinjam;
							
							$data['bil_sdg_dipinjam'] = $jumlah;
							
							echo json_encode($data);
						}
				}
					
				echo ']';
	break;
	
	case '23'://daftar login public
	
	$nama = $JsonSystem->getGETPOST('nama');
	$noic = $JsonSystem->getGETPOST('noic');
	$email = $JsonSystem->getGETPOST('email');
	$alamat = $JsonSystem->getGETPOST('alamat');
	$gender = $JsonSystem->getGETPOST('gender');
	$umur = $JsonSystem->getGETPOST('umur');
	$username = $JsonSystem->getGETPOST('username');
	$accs_pwd = $JsonSystem->getGETPOST('acss_pwd');
	$phone = $JsonSystem->getGETPOST('phone');
	$platform = $JsonSystem->getGETPOST('platform');
	
	//check existing registered ic
	$sql1 = $JsonSystem->getData("select id
								FROM staff where status='BEKERJA' and noic='$noic'
								UNION ALL
								select id
								FROM elibrary_public_login where STATUS='1' and noic='$noic'");
								
	$check = $sql1[0];
	
		if($check > 0)
		{
			$output_to_send = "Data " .$noic. " telah wujud";
		}
		else
		{
			$sql = "INSERT INTO elibrary_public_login (name,noic,username,accs_pwd,alamat,gender,umur,email,phone,platform,created_date) 
					VALUES (UPPER('$nama'),'$noic','$username','$accs_pwd',UPPER('$alamat'),UPPER('$gender'),'$umur','$email','$phone','$platform',CURRENT_TIMESTAMP)";
					
			$JsonSystem->executeOperation2($sql);
			
			$output_to_send = "Berjaya didaftarkan.";
		}
	
	break;
	
	case '24'://check registered email
	
	$email = $JsonSystem->getGETPOST('email');
	$password = $JsonSystem->getGETPOST('password');
	
	$sql = "SELECT epl.id,epl.username,c.email FROM elibrary_public_login epl,company c WHERE epl.email='$email'";
			
	$result = $connjson->query($sql);
		
		if($result->num_rows > 0)//ada data
		{
			$sql1 = $JsonSystem->getData($sql);
								
			$id = $sql1[0];
			$username = $sql1[1];
			$sender = $sql1[2];
			
			
			$receiver = $email;
	    
	// Subject of email
	    	$subject = "iLibrary::Tetapan Semula Kata Laluan";
	    
	    	// Design of the email
	    	$design = "<html><head><title></title></head><body>
	    	Assalamu'alaikum w.b.t,<br><br>Kata laluan anda telah berjaya ditetapkan semula.<br><br>
			Sila log masuk menggunakan ID Pengguna dan Kata Laluan baharu:<br><br>
			Maklumat akaun anda adalah seperti berikut : <br>
			ID Pengguna : $username <br>
			Katalaluan : $password <br>";

			"<br><br>Sekian,terima kasih.
			<br><br>iLibrary</body></html>";
			
	    	// Headers
	    	$headers = "From: $sender\n"; // From address
	    	//$headers .= "Reply-To: $replyto\n"; // Reply-to address
	    	$headers .= "Organization: Some organisation\n"; // Organisation
	    	$headers .= "Content-Type: text/html; charset=iso-8859-1\n"; // Type
	    	//$name = "$list(reciever)";
	    	mail($receiver, $subject, $design, $headers); 
			
			$sql2 = "UPDATE elibrary_public_login SET accs_pwd='$password'
				WHERE id='$id'";
				
				$JsonSystem->executeOperation2($sql2);
				
				$output_to_send = "Tetapan semula berjaya. Sila semak emel anda bagi tujuan log masuk.";		
		}
		else
		{
			$output_to_send = "Emel tidak wujud. Sila rujuk pihak pengurusan bagi tujuan semakan.";
		}
	
	break;
	
	
	
}

// Closing connection
mysqli_close($conn);
echo $output_to_send;



?>