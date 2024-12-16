<?php
	//test
	function getMonth() {
		$conn=db();
		$sql = "SELECT DISTINCT(MONTHNAME(`start`)) FROM `events`
		ORDER BY MONTH(`start`) ASC";
		
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

	function getEventCategory() {
		$conn=db();
		$sql = "SELECT event_type FROM `events`
		GROUP BY event_type";

	     $result = $conn->query($sql);

		return $result;
	}

	function getCountEvents() {
		$conn=db();
		$sql = "SELECT MONTHNAME(`start`) AS bulan , `start` FROM `events`
		GROUP BY MONTHNAME(`start`)
		ORDER BY MONTH(`start`) ASC";
	     $result = $conn->query($sql);

		return $result;
	}
	


	function getCount($event,$bln,$tahun){
		$conn=db();
		$sql = "SELECT COUNT(event_type) AS kira FROM `events`
				WHERE MONTHNAME(`start`)='$bln' AND event_type='$event' AND YEAR(`start`)='$tahun' ";

		$result = $conn->query($sql);
		return $result->fetch_object()->kira;
	}
	
	//=====================================================================================================================// 
		function getAktivitiStatus($tahun) {
    $conn=db();
    $sql = "SELECT COUNT(title) AS kira,`status` FROM `events`
	WHERE YEAR(`start`) = '$tahun'
       GROUP BY `status`";
    
    $result = $conn->query($sql);
    
    //$conn->close();
    return $result;
  }
		function getTotalAktiviti($bulan,$tahun){
		$conn=db();
		$sql = "SELECT COUNT(`start`) AS kira,MONTHNAME(`start`) FROM `events`
		WHERE  MONTH(`start`)='$bulan'
		AND YEAR(`start`)='$tahun'";
		

		$result = $conn->query($sql);
		$results =  $result->fetch_object()->kira;
		return $results;

	}
		function getCountAcaraTahun($tahun){
		$conn=db();
		$sql = "SELECT COUNT(`start`) AS kira,MONTHNAME(`start`) FROM `events`
		WHERE YEAR(`start`)= '$tahun'";

		$result = $conn->query($sql);
		return $result->fetch_object()->kira;
	}
	
		function getCountBatal($tahun){
		$conn=db();
		$sql = "SELECT COUNT(`start`) as kira FROM `events`
		WHERE `status` = 'BATAL'
		AND YEAR(`start`) = '$tahun'";

		$result = $conn->query($sql);
		return $result->fetch_object()->kira;
	}
	
		function getCountAktif($tahun){
		$conn=db();
		$sql = "SELECT COUNT(`start`) as kira FROM `events`
		WHERE `status` <> 'BATAL'
		AND YEAR(`start`) = '$tahun'";

		$result = $conn->query($sql);
		return $result->fetch_object()->kira;
	}
	
	

	?>