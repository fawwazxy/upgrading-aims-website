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
	function getJenisSurat() {
		$conn=db();
		$sql = "SELECT * FROM jenis_surat  ";
		$result = $conn->query($sql);
		return $result;
	}
	function getJenisSuratInfo($id) {
		$conn=db();
		$sql = "SELECT * FROM jenis_surat WHERE id='$id' ";
		$result = $conn->query($sql);
		return $result;
	}
	function getJenisProduk() {
		$conn=db();
		$sql = "SELECT * FROM produk  ";
		$result = $conn->query($sql);
		return $result;
	}
	function getJenisProdukInfo($id) {
		$conn=db();
		$sql = "SELECT * FROM produk WHERE id='$id'";
		$result = $conn->query($sql)->fetch_assoc();
		return $result;
	}
    function getLead() {
		$conn=db();
		$sql = "SELECT * FROM lead  ";
		$result = $conn->query($sql);
		return $result;
	}
	function getLeadInfo($id) {
		$conn=db();
		$sql = "SELECT * FROM lead WHERE id='$id'";
		$result = $conn->query($sql)->fetch_assoc();
		return $result;
	}
	
	function getLeadInformation($lead) {
		$conn=db();
		$sql = "SELECT * FROM lead WHERE lead_name='$lead'";
		$result = $conn->query($sql)->fetch_assoc();
		return $result;
	}
   function getSuratInformation($surat) {
		$conn=db();
		$sql = "SELECT * FROM jenis_surat WHERE surat='$surat'";
		$result = $conn->query($sql)->fetch_assoc();
		return $result;
	}
	 function getProdukInformation($produk) {
		$conn=db();
		$sql = "SELECT * FROM produk WHERE produk='$produk'";
		$result = $conn->query($sql)->fetch_assoc();
		return $result;
	}
	
	
	//surat
	function getCompany() {
		$conn=db();
		$sql = "SELECT * FROM company";
		$result = $conn->query($sql);
		return $result;
	}
	function getTemplate() {
		$conn=db();
		$sql = "SELECT * FROM surat_template  ";
		$result = $conn->query($sql)->fetch_object();
		return $result;
	}
	//function to get 4 digit running no based on id
	function getRunningNo($num) 
		{
         return sprintf("%'.04d\n", $num);
        }
	//function to get month in string
	function getMonthString($num)
    {

          
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
	function addlead($name,$shrtname,$address,$telno,$email,$pic_name,$pic_position,$lokasi) {
		$conn=db();
		 $sql = "INSERT INTO lead(lead_name,lead_shrtname,lead_address,lead_telno,lead_email,pic_name,pic_position,lokasi)
				VALUES('$name', '$shrtname', '$address', '$telno', '$email','$pic_name','$pic_position','$lokasi')";
		$result = $conn->query($sql);
		return $result;
	} 
	function updatelead($id,$name,$shrtname,$address,$telno,$email,$pic_name,$pic_position,$lokasi) {
		$conn=db();
		 $sql = "UPDATE lead SET lead_name='$name' , lead_shrtname='$shrtname' , lead_address='$address' , lead_telno='$telno' , lead_email='$email' , pic_name='$pic_name' , pic_position='$pic_position', lokasi='$lokasi' WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	} 
	function addsurat($word,$produk,$lead) {
		$conn=db();
		 $sql = "INSERT INTO surat(surat,produk,lead)
				VALUES('$word', '$produk', '$lead')";
		$result = $conn->query($sql);
		return $result;
	}
	
	function addProduk($code,$produk,$penerangan) {
		$conn=db();
		 $sql = "INSERT INTO produk(code,produk,penerangan)
				VALUES('$code', '$produk', '$penerangan')";
		$result = $conn->query($sql);
		return $result;
	} 
	function updateProduk($id,$code,$produk,$penerangan) {
		$conn=db();
		 $sql = "UPDATE produk SET code='$code' , produk='$produk',penerangan='$penerangan' WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	} 		
		
	function addJenisSurat($code,$surat) {
		$conn=db();
		 $sql = "INSERT INTO jenis_surat(code,surat)
				VALUES('$code', '$surat')";
		$result = $conn->query($sql);
		return $result;
	} 	
	function updateJenisSurat($id,$code,$surat) {
		$conn=db();
		 $sql = "UPDATE jenis_surat SET code='$code' , surat='$surat' WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	} 
   	 
	
	function getSurat()
	{
		$conn=db();
		$sql = "SELECT s.*,j.code AS kod
				FROM surat s
				LEFT JOIN jenis_surat j ON j.surat=s.surat ORDER BY created_date DESC";
				
		
		$result = $conn->query($sql);
		
		return $result;
		
	}
	function getTarikh($created_date)
	{
		$conn=db();
		$sql = "SELECT s.*,j.code AS kod
				FROM surat s
				LEFT JOIN jenis_surat j ON j.surat=s.surat where created_date='$created_date'";
				
		
		$result = $conn->query($sql);
		
		return $result;
		
	}
	
	
	$conn->close();
	
?>