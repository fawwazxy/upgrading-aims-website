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
	
	function getMeetingInfo($id) {
		$conn=db();
		$sql = "SELECT * FROM `events`
		WHERE `start` >= CURDATE()
		AND `end` < CURDATE() + INTERVAL 30 DAY
		AND `status`<> 'BATAL'
		ORDER BY  `start` ASC";
		if ($id !='') $sql ="SELECT *,FIND_IN_SET('$id',id_staff) AS result FROM `events` WHERE FIND_IN_SET('$id',id_staff)!=0";
		$sql;
		$result = $conn->query($sql);
		return $result;
	}
	
		function getMeetingInfoBatal($id) {
		$conn=db();
		$sql = "SELECT * FROM `events`
		WHERE `start` >= CURDATE()
		AND `end` < CURDATE() + INTERVAL 30 DAY
		AND `status` = 'BATAL'
		ORDER BY  `start` ASC";
		if ($id !='') $sql ="SELECT *,FIND_IN_SET('$id',id_staff) AS result FROM `events` WHERE FIND_IN_SET('$id',id_staff)!=0";
		$sql;
		$result = $conn->query($sql);
		return $result;
	}

	function getAktivitiKategori() {
		$conn=db();
		 $sql = "SELECT * FROM aktiviti_kategori";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option value=\"".$row[1]."\">".$row[1]." </option>";
		}
		//$conn->close();
		return $txt_result;
	}
	
		function getAktivitiStatus() {
		$conn=db();
		 $sql = "SELECT * FROM aktiviti_status";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option value=\"".$row[1]."\">".$row[1]." </option>";
		}
		//$conn->close();
		return $txt_result;
	}

		function getEventDescription($id) {
		$conn=db();
		$sql = "
		SELECT id,title,color,`start`,`end`,description,id_staff,`status`,event_type FROM `events` WHERE id='$id' ";
        $result = $conn->query($sql);
		return $result;
}
	
		function deleteMeeting($id) {
		$conn=db();
		$sql = "DELETE FROM events WHERE id='$id' ";
        $result = $conn->query($sql);
		return $result;
}
	
		function addMeeting($title,$description, $start,$end,$id_staff,$status,$event_type,$color,$prepared_by){
		$conn=db();
	     $sql = "INSERT INTO events(title,description,start,end,id_staff,status,event_type,color,prepared_by) VALUES ('$title',?,'$start','$end','$id_staff','$status','$event_type','$color','$prepared_by')";
		$stmt = $conn->prepare($sql) or die($conn->error);
		$stmt->bind_param("s",$description);
		
		$stmt->execute();
		$result = $stmt->insert_id;
		$stmt->close();
		return $result;
	}
	
		function editMeeting($title,$start,$end,$id_staff,$status,$event_type,$description,$id){
		$conn=db();
		$sql = "UPDATE events SET title='$title', start='$start', end='$end',status='$status',event_type='$event_type', id_staff='$id_staff', description =?
		WHERE id='$id'" ;

		$stmt = $conn->prepare($sql) or die($conn->error);
		$stmt->bind_param("s",$description);
		
		$stmt->execute();
		$result = $stmt->insert_id;
		$stmt->close();
		return $result;
	}
		
		function getMeetingMonth($month,$year) {
		$conn=db();
		$sql = "SELECT *,DATE_FORMAT(date_start,'%d/%m/%Y') AS date_mula ,DATE_FORMAT(date_end,'%d/%m/%Y') AS date_akhir  FROM meeting WHERE MONTH(date_start)='$month' AND YEAR(date_start)='$year'";
		$result = $conn->query($sql);
		return $result;
	}
	
		function getUpcomingMeeting($id) {
		$conn=db();
		$sql = "SELECT masa_mula ,masa_tamat,description,staff.name,jenis_acara,meeting.status,staff.phone,DATE_FORMAT(date_start,'%Y-%m-%d') AS date_mula,DATE_FORMAT(date_start,'%w') AS hari_mula ,DATE_FORMAT(date_end,'%Y-%m-%d') 
		AS date_akhir,DATE_FORMAT(date_end,'%w') AS hari_akhir FROM meeting LEFT JOIN staff ON meeting.id_staff = staff.id 
		WHERE date_start >= CURDATE() + INTERVAL 1 DAY
		AND date_start < CURDATE() + INTERVAL 30 DAY 
		ORDER BY date_mula ASC 
		LIMIT 5";
		
		if ($id !='') $sql .=" WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}

		function getAktivitiStaff(){
		$conn=db();
		$sql = "SELECT meeting.id,meeting.id_staff,staff.name,staff.id ,COUNT(jenis_acara) AS kira FROM meeting
		LEFT JOIN staff ON meeting.id_STAFF = staff.id
		GROUP BY staff.id";
        $result = $conn->query($sql);
		return $result;
		}
		
		function getAktivitiByStaff($id){
		$conn=db();
		$sql = "SELECT staff.id,staff.name,description,date_start,date_end,jenis_acara,meeting.status FROM meeting 
		LEFT JOIN staff ON meeting.id_staff = staff.id 
		WHERE meeting.id_staff = '$id'  ";
        $result = $conn->query($sql);
		return $result;
		}
		
		function getStaffInfo(){
		$conn=db();
		$sql = "SELECT * from staff WHERE status = 'BEKERJA' AND noic IS NOT NULL ";
        $result = $conn->query($sql);
		return $result;
		}
		
		function getIdStaff($no_staff){
		$conn=db();
		$sql = "SELECT id from staff WHERE no_staff='$no_staff'";
        $result = $conn->query($sql);
		return $result->fetch_object()->id;
		}

		function printDay($day_num) {
	 		$hari=array("Ahad","Isnin","Selasa","Rabu","Khamis","Jumaat","Sabtu");
	 		echo $hari[$day_num];
	 	}
		
		function getStaffName(){
		$conn=db();
	    $sql = "
		SELECT * FROM staff s LEFT JOIN meeting m ON s.id = m.id_staff
		GROUP BY s.id";
		$result = $conn->query($sql);
		return $result;
	}
	
		function getStaffNameByID($id){
		$conn=db();
		 $sql = "
		SELECT * from staff where no_staff IN($id)";
		$result = $conn->query($sql);
		return $result;
	}
	
		function getKalendarDetails($id){
		$conn=db();
		$sql = "SELECT id, title, start, end, color FROM events ";
		if ($id !='') $sql ="SELECT *,FIND_IN_SET('$id',id_staff) AS result FROM `events` WHERE 
		id_staff like '%$id%'";

		//if ($id !='') $sql ="SELECT * FROM `events` WHERE id_staff like '%$id%'";


		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}
	
		function getAllKalendarInfo($id) {
		$conn=db();
		$sql = "SELECT e.id,s.id,e.title,e.color,e.start,e.end,e.description,e.id_staff,s.name 
		FROM events e LEFT JOIN staff s ON e.id_staff = s.id ";
		if ($id !='') $sql .=" WHERE e.id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
		function getAllMeetingInfo($id) {
		$conn=db();
		$sql = "SELECT * FROM events";
		if ($id !='') $sql .=" WHERE m.id='$id'";
		$result = $conn->query($sql);
		return $result;
	}

		function kemaskiniEvents($id) {
		$conn=db();
		$sql = "SELECT * FROM events WHERE id='$id' ";
        $result = $conn->query($sql);
		return $result;
}
	
	// SELECT COUNT(`start`) AS`start`  FROM `events` WHERE DATE_FORMAT(`start`,'%Y-%m')= DATE_FORMAT(NOW(),'%Y-%m')
		function getCountAktivitiStaff($no_staff) {
		$conn=db();
		$sql = "SELECT COUNT(start) AS kira  FROM events WHERE DATE_FORMAT(start,'%Y-%m')= DATE_FORMAT(NOW(),'%Y-%m')
		AND id_staff LIKE '%$no_staff%'";
		$result = $conn->query($sql);
		return $result;
	}
		function getAllCountAktivitiStaff() {
		$conn=db();
		$sql = "SELECT COUNT(`start`) AS`kira`  FROM `events` WHERE DATE_FORMAT(`start`,'%Y-%m')= DATE_FORMAT(NOW(),'%Y-%m')";
		$result = $conn->query($sql);
		return $result;
	}
	function getIndividu($id) {
		$conn=db();
		$sql = "SELECT * FROM events WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}

	$conn->close();
	
?>