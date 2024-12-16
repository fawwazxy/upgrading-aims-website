<?php
require '../lib/db/connection.php';

$conn = db();
$tahun = $_GET['thn'];
$ic_number = $_GET['no_kp'];
$no_staff = $conn->query("SELECT no_staff FROM staff WHERE noic = '$ic_number'")->fetch_object()->no_staff;

$parent_arr = array();

$query = "SELECT DATE_FORMAT(tarikh,'%b') AS bulan,DATE_FORMAT(tarikh,'%m') AS bln FROM tarikh_bekerja WHERE DATE_FORMAT(tarikh,'%Y') ='$tahun' AND no_staff='$no_staff'
		GROUP BY bulan
		ORDER BY bln";
$bulan = $conn->query($query);

$i=0;

while ($month = $bulan->fetch_assoc()){
    $bln = $month['bln'];

    $stmt1 = "SELECT COUNT(*) AS awal FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic
				WHERE s.noic IS NOT NULL
				AND s.status = 'BEKERJA'
				AND k.nokp_staff = '$ic_number'
				AND (k.status_kehadiran = 'AWAL' OR k.status_kehadiran = 'TEPAT')
				AND DATE_FORMAT(k.created_date,'%Y-%m')=CONCAT('$tahun','-','$bln')";
    $sql1 = $conn->query($stmt1)->fetch_object()->awal;

    $stmt2 = "SELECT COUNT(*) AS lewat FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic
				WHERE s.noic IS NOT NULL
				AND s.status = 'BEKERJA'
				AND k.nokp_staff = '$ic_number'
				AND k.status_kehadiran = 'LEWAT'
				AND DATE_FORMAT(k.created_date,'%Y-%m')=CONCAT('$tahun','-','$bln')";
    $sql2 = $conn->query($stmt2)->fetch_object()->lewat;

    $child_arr = array($sql2,$sql1);

    array_push($parent_arr, $child_arr);

    $i++;
}

if(json_encode($parent_arr)=='[]'){
echo json_encode([["0","0"],["0","0"],["0","0"],["0","0"],["0","0"],["0","0"],["0","0"],["0","0"],["0","0"],["0","0"],["0","0"],["0","0"]]);
}
else{
    echo json_encode($parent_arr);
}