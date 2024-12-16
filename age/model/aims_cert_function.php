<?php

	require '../../lib/db/connection.php';
    

	
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
	
	function addCert($certificate, $aa1, $aa2, $aa3, $aa4, $aa5){
		$conn=db();
		$sql = "INSERT INTO aims_certificate (certificate, aa1, aa2, aa3, aa4, aa5) 
		VALUES ('$certificate', '$aa1', '$aa2', '$aa3', '$aa4', '$aa5')";
		$result = $conn->query($sql);
		return $result;
	}
	
	
	function listCert(){
		$conn=db();
		$sql = "SELECT *,
		DATE_SUB(aa1, INTERVAL 60 DAY) AS date_exp_aa1,
		DATE_SUB(aa2, INTERVAL 60 DAY) AS date_exp_aa2,
		DATE_SUB(aa3, INTERVAL 60 DAY) AS date_exp_aa3,
		DATE_SUB(aa4, INTERVAL 60 DAY) AS date_exp_aa4,
		DATE_SUB(aa5, INTERVAL 60 DAY) AS date_exp_aa5
		FROM aims_certificate where id = id";
		$result = $conn->query($sql);
		return $result;
	}
	

	
	function updateCert1($certificate, $aa1, $aa2, $aa3, $aa4, $aa5,$remark_1,$remark_2,$remark_3,$remark_4,$remark_5,$id){
		$conn=db();
		$sql = "UPDATE aims_certificate SET certificate='$certificate', aa1= '$aa1', aa2='$aa2', aa3= '$aa3', aa4='$aa4', aa5='$aa5',
		remark_1= '$remark_1', remark_2 = '$remark_2' , remark_3 = '$remark_3', remark_4 = '$remark_4', remark_5 = '$remark_5' WHERE id='$id'";
		$result=$conn->query($sql) or die($conn->error);
		return $result;
	}
	
	
	
	function getCertid($id){
		$conn=db();
		$sql = "SELECT * FROM aims_vesselcertificate WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	// certificate add
	
	function addcertificate($certificate_name, $vessel_code, $remark, $date_in, $date_exp, $date_exp1){
		$conn=db();
		$sql = "INSERT INTO aims_vesselcertificate (certificate_name, vessel_code, remark, date_in, date_exp,date_exp1) 
		VALUES ('$certificate_name', '$vessel_code', '$remark', '$date_in', '$date_exp','$date_exp1')";
		$result = $conn->query($sql);
		return $result;
	}
	
	function updateCert($certificate_name, $vessel_code, $remark, $date_in, $date_exp, $date_exp1,$id){
		$conn=db();
		$sql = "UPDATE aims_vesselcertificate SET certificate_name='$certificate_name', vessel_code= '$vessel_code', remark='$remark', date_in= '$date_in',
		date_exp ='$date_exp',date_exp1 ='$date_exp1'
		WHERE id='$id'";
		$result=$conn->query($sql) or die($conn->error);
		return $result;
	}
	
	function deleteCert($id){
		$conn=db();
		$sql = "DELETE FROM aims_vesselcertificate WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getDropCertificate($selected) {
		$conn=db();
		 $sql = "SELECT id, certificate_name FROM aims_certificatelist";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option ".($row[1] == $selected ? 'selected':'')." value=\"".$row[1]."\">".$row[1]."</option>";
		}
		
		//$conn->close();
		return $txt_result;
	}
	
	function listCert1(){
		$conn=db();
		$sql = "SELECT b.*,DATE(b.date_exp) AS month2 ,DATE(b.date_exp1) AS month1, a.code_vessel AS kapal FROM aims_vesselcertificate b
		LEFT JOIN aims_vessel a ON a.code_vessel = b.vessel_code
		WHERE a.code_vessel = 'AA1'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function listCert2(){
		$conn=db();
		$sql = "SELECT b.*,DATE(b.date_exp) AS month2 ,DATE(b.date_exp1) AS month1, a.code_vessel AS kapal FROM aims_vesselcertificate b
		LEFT JOIN aims_vessel a ON a.code_vessel = b.vessel_code
		WHERE a.code_vessel = 'AA2'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function listCert3(){
		$conn=db();
		$sql = "SELECT b.*,DATE(b.date_exp) AS month2 ,DATE(b.date_exp1) AS month1, a.code_vessel AS kapal FROM aims_vesselcertificate b
		LEFT JOIN aims_vessel a ON a.code_vessel = b.vessel_code
		WHERE a.code_vessel = 'AA3'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function listCert4(){
		$conn=db();
		$sql = "SELECT b.*,DATE(b.date_exp) AS month2 ,DATE(b.date_exp1) AS month1, a.code_vessel AS kapal FROM aims_vesselcertificate b
		LEFT JOIN aims_vessel a ON a.code_vessel = b.vessel_code
		WHERE a.code_vessel = 'AA4'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function listCert5(){
		$conn=db();
		$sql = "SELECT b.*,DATE(b.date_exp) AS month2 ,DATE(b.date_exp1) AS month1, a.code_vessel AS kapal FROM aims_vesselcertificate b
		LEFT JOIN aims_vessel a ON a.code_vessel = b.vessel_code
		WHERE a.code_vessel = 'AA5'";
		$result = $conn->query($sql);
		return $result;
	}
	
	$conn->close();
	
?>