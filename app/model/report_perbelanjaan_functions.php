<?php

	
    function getPenerima_table() { 
   		$conn=db();
		$sql = "SELECT p.nama_penerima AS penerima, n.nama_penerima FROM rekod_perbelanjaan p
		LEFT JOIN nama_penerima n ON p.nama_penerima= n.id
		GROUP BY p.nama_penerima
		ORDER BY p.nama_penerima  ";
			
		$result = $conn->query($sql);
		return $result;
	}
	
	
 	function getCountPerbelanjaan() { // Analisa Mengikut Jenis Perbelanjaan
		$conn=db();
		$sql = "SELECT COUNT(*) AS count, r.description AS belanja FROM rekod_perbelanjaan p 
		LEFT JOIN perbelanjaan r ON p.perbelanjaan=r.id 
		GROUP BY CONCAT(r.description)";
		
		$result = $conn->query($sql);
		return $result;
	}

	function getCountKaedahBayaran() { // Analisa Mengikut Jenis Perbelanjaan
		$conn=db();
		$sql = "SELECT COUNT(*) AS count, j.nama AS belanja FROM rekod_perbelanjaan p 
		LEFT JOIN jenis_perbelanjaan j ON p.jenis_perbelanjaan=j.id 
		GROUP BY CONCAT(j.nama)";
		
		$result = $conn->query($sql);
		return $result;
	}

	function getNamaPenerima_table() { 
    	$conn=db();
		$sql = "SELECT COUNT(*) AS xcount, n.nama_penerima AS penerima FROM rekod_perbelanjaan p
		LEFT JOIN nama_penerima n ON p.nama_penerima=n.id
        GROUP BY n.nama_penerima
		ORDER BY n.nama_Penerima ASC";
			
		$result = $conn->query($sql);
		return $result;
	}
	
	function getNamaPenerima_report(){ 
		$conn=db();
		$sql = "SELECT p.nama_penerima AS id, n.nama_penerima AS penerima
		FROM rekod_perbelanjaan p
		LEFT JOIN nama_penerima n ON p.nama_penerima=n.id
		GROUP BY p.nama_penerima";
				
		$result = $conn->query($sql);
		return $result;
	}

	function getMonth1(){
		$conn=db();
		$sql="SELECT DISTINCT(DATE_FORMAT(tarikh_bayaran_dibuat,'%M') )AS bulan
		FROM rekod_perbelanjaan p 
		ORDER BY p.tarikh_bayaran_dibuat ASC";

		$result = $conn->query($sql);
		
		$txt_result="";
		$i=0;
		while ($row  = $result -> fetch_array()){
			if($i > 0) $txt_result .= ",";
			$txt_result .= "'".$row[0]."'";
			$i++;
		}
		//$conn->close();
		return $txt_result;
	}


  function getCountStatus1() {
   		$conn=db();
    	$sql = "SELECT COUNT(*) AS xcount, p.nama_penerima AS id_status, n.nama_penerima AS penerima , 
    	DATE_FORMAT(p.tarikh_bayaran_dibuat,'%M') AS bulan
   		FROM rekod_perbelanjaan p
		LEFT JOIN nama_penerima n ON p.nama_penerima=n.id
		GROUP BY bulan
		ORDER BY p.tarikh_bayaran_dibuat ASC";


       $result = $conn->query($sql);
   		return $result;
  }

  function getCount($id,$bulan){
    $conn=db();
    $sql = "	SELECT COUNT(p.nama_penerima) AS xcount, n.nama_penerima AS penerima , 
    DATE_FORMAT(p.tarikh_bayaran_dibuat,'%M') AS bulan
    FROM rekod_perbelanjaan p
    LEFT JOIN nama_penerima n ON p.nama_penerima=n.id
    WHERE p.nama_penerima='$id' AND DATE_FORMAT(p.tarikh_bayaran_dibuat,'%M')='$bulan'";


    $result = $conn->query($sql);
    return $result->fetch_object()->xcount;
  }

	

    ?>