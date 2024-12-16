<?php

// graf start
	function getMonth() {
		$conn=db();
		$sql = "SELECT DISTINCT(MONTHNAME(`arrival_date`)) FROM `aims_gl_booking`
		ORDER BY MONTH(`arrival_date`) ASC";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		$i=0;
		while ($row  = $result -> fetch_array()){
			if($i > 0) $txt_result .= ",";
			$txt_result .= "'".$row[0]."<br>".$row[1]."'";
			$i++;
		}
		//$conn->close();
		return $txt_result;
	}

	function getClientCompany() {
		$conn=db();
		$sql = "SELECT client_company_id FROM `aims_gl_client`
		GROUP BY client_company_id";

	     $result = $conn->query($sql);

		return $result;
	}

	function getCountClientCompany() {
		$conn=db();
		$sql = "SELECT MONTHNAME(`arrival_date`) AS bulan , `arrival_date` FROM `aims_gl_booking`
		GROUP BY MONTHNAME(`arrival_date`)
		ORDER BY MONTH(`arrival_date`) ASC";
	     $result = $conn->query($sql);

		return $result;
	}
	


	function getCount($client,$bln,$tahun){
		$conn=db();
		$sql = "SELECT COUNT(client_company_id) AS kira FROM `aims_gl_client` a
		LEFT JOIN aims_gl_booking gl ON gl.client_id = a.id
		WHERE MONTHNAME(`arrival_date`)='$bln' AND client_company_id='$client' AND YEAR(`arrival_date`)='$tahun'";

		$result = $conn->query($sql);
		return $result->fetch_object()->kira;
	}
	
	//=====================================================================================================================// 
		function getAktivitiStatus($tahun) {
    $conn=db();
    $sql = "SELECT COUNT(client_id) AS kira,a.client_company_id FROM `aims_gl_booking` gl
LEFT JOIN aims_gl_client a ON gl.client_id = a.id
	WHERE YEAR(`arrival_date`) = '$tahun'
       GROUP BY a.client_company_id";
    
    $result = $conn->query($sql);
    
    //$conn->close();
    return $result;
  }
		function getTotalBooking($bulan,$tahun){
		$conn=db();
		$sql = "SELECT COUNT(`arrival_date`) AS kira,MONTHNAME(`arrival_date`) FROM `aims_gl_booking`
		WHERE  MONTH(`arrival_date`)='$bulan'
		AND YEAR(`arrival_date`)='$tahun'";
		

		$result = $conn->query($sql);
		$results =  $result->fetch_object()->kira;
		return $results;

	}
		function getCountBookingTahun($tahun){
		$conn=db();
		$sql = "SELECT COUNT(`arrival_date`) AS kira,MONTHNAME(`arrival_date`) FROM `aims_gl_booking`
		WHERE YEAR(`arrival_date`)= '$tahun'";

		$result = $conn->query($sql);
		return $result->fetch_object()->kira;
	}
	// graf end


?>