<?php

	require '../../lib/db/connection.php';
	session_start();

	$action=$_POST['action'];
	if ($action=="updateStatusKtegori") {
		$id = $_POST['id'];
		$id_category= $_POST['id_category'];
		$conn=db();
		
		$sql = "UPDATE projek_task SET id_category='$id_category' WHERE id_task='$id' ";
		$result = $conn->query($sql) or die($conn->error);
		echo "Data berjaya dipindah";
		

	}else if($action=="updateStatusDone") {
		$id = $_POST['id'];
		$id_category= $_POST['id_category'];
		$conn=db();
		
		$sql = "UPDATE projek_task SET id_category='$id_category',tarikh_tamat=CURRENT_TIMESTAMP,duration=TIMEDIFF(DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d %H:%i:%s'),DATE_FORMAT(tarikh_mula,'%Y-%m-%d %H:%i:%s')) WHERE id_task='$id' ";
		$result = $conn->query($sql) or die($conn->error);
		echo "Data berjaya dipindah";
	}else if ($action=="subProjek") {
		$kod_projek = clean($_POST['kod_projek']);
		$conn=db();
		$sql = "SELECT * FROM projek_internal
				WHERE kod_projek_parent='$kod_projek'";
		$result = $conn->query($sql);
		echo '<option value="">-- Pilih Sub Projek --</option>'; 
        while($row = $result->fetch_assoc()){  
           echo '<option value="'.$row['kod_projek'].'">'.$row['kod_projek'].' - '.$row['nama_projek'].'</option>';
        } 
		
	}else if($action == "delTask"){//padam penceramah
		$id = $_POST['id'];
		$conn=db();
		$sql = "DELETE FROM projek_task WHERE id_task='$id'";
		$conn->query($sql);
		echo "Data berjaya dipadam";

	}else if($action == "searchStaff"){//padam penceramah
		$search = $_POST['search'];
		$conn=db();
		$sql = "SELECT noic,name FROM staff WHERE name like '%".$search."%' AND status='BEKERJA' AND name NOT IN('ADMIN','SUPERADMIN') ORDER BY name LIMIT 5 ";
		$result = $conn->query($sql) or die($conn->error);
		$response = array();
		 while($row = $result->fetch_assoc() ){
	        $response[] = array("value"=>$row['noic'],"label"=>$row['name']);
	    }

		 echo json_encode($response);

	}

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
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	function getTaskByNokp($id_category,$nokp) {
		$conn=db();
		$conditionTarikh="";
		if($id_category=="INPROGRESS"){
			$conditionAssigned = "assigned_to='$nokp'";
			$conditionOrder="id_task";
		}else if($id_category=="DONE"){
			$conditionAssigned = "(assigned_to='$nokp' OR assigned_by='$nokp')";
			$conditionOrder="tarikh_tamat";
			$conditionTarikh="AND DATE_FORMAT(pt.tarikh_tamat,'%m') = DATE_FORMAT(CURRENT_TIMESTAMP,'%m')";
		}else{
			$conditionAssigned = "(assigned_to='$nokp' OR assigned_by='$nokp')";
			$conditionOrder="id_task";
		}
		$sql = "SELECT pt.*,SUBSTRING_INDEX(pt.duration,':', 1) AS jam,SUBSTRING_INDEX(SUBSTRING_INDEX(pt.duration, ':', 2), ':', -1) AS minit,DATE_FORMAT(pt.tarikh_mula,'%d-%m-%Y %h:%i %p') AS tarikh_start,DATE_FORMAT(pt.tarikh_tamat,'%d-%m-%Y %h:%i %p') AS tarikh_end, s.name AS oleh FROM projek_task pt
		LEFT JOIN staff s ON s.noic=pt.assigned_by
		WHERE pt.id_category='$id_category' AND $conditionAssigned AND s.status='BEKERJA' $conditionTarikh ORDER BY $conditionOrder DESC";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	function getTaskById($id_task) {
		$conn=db();
		$sql = "SELECT *,s.name FROM projek_task pt
				LEFT JOIN staff s ON s.noic=pt.assigned_to
				WHERE pt.id_task='$id_task'";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	function getDetailsTaskById($id_task) {
		$conn=db();
		$sql = "SELECT pt.*,pint.nama_projek AS projek_utama,pit.nama_projek AS projek_sub,nama_kategori,nama_kumpulan,s.name AS oleh,s1.name AS kepada,DATE_FORMAT(pt.tarikh_mula,'%d-%m-%Y %r') AS tarikh_start,DATE_FORMAT(pt.tarikh_tamat,'%d-%m-%Y %r') AS tarikh_end FROM projek_task pt
			LEFT JOIN projek_internal pint ON pint.kod_projek=pt.kod_projek
			LEFT JOIN projek_internal pit ON pit.kod_projek=pt.kod_subprojek
			LEFT JOIN lkp_task_kategori ltk ON ltk.code=pt.id_category
			LEFT JOIN lkp_projek_kumpulan lpk ON lpk.id_kumpulan=pt.task_based
			LEFT JOIN staff s ON s.noic=pt.assigned_by
			LEFT JOIN staff s1 ON s1.noic=pt.assigned_to
			WHERE pt.id_task='$id_task' AND s.status='BEKERJA' AND s1.status='BEKERJA'";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	function getDropDownKodProjek($tablename,$value,$text,$selected,$kod_projek_parent) {
      	$conn=db();
       	 $sql = "SELECT ".$value.",".$text." FROM $tablename WHERE kod_projek_parent = '$kod_projek_parent'";
      	$result = $conn->query($sql);
      
      	$txt_result="";
 	 		while ($row  = $result -> fetch_array()){
        	$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]." - ".$row[1]."</option>";
  			}
      	//$conn->close();
      	return $txt_result;
   	}

  	function getDropDownStaf($selected) {
	    $conn=db();
	    $sql = "SELECT noic,name FROM staff WHERE STATUS='BEKERJA' AND role_id NOT IN('ADMIN','SUPERADMIN')";
	    $result = $conn->query($sql);
	    
	    $txt_result="";
	    	while ($row  = $result -> fetch_array()){
	      	$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
	    	}
	    //$conn->close();
	    return $txt_result;
  	}

  	function taskAddEdit($id,$kod_projek,$sub_projek,$tajuk,$assigned_by,$assigned_to,$task_based,$tarikh_mula,$tarikh_tamat,$catatan,$slack) {
		$conn=db();
		if($id == ""){
			$sql = "INSERT INTO projek_task (kod_projek,kod_subprojek,tajuk,id_category,assigned_by,assigned_to, task_based,tarikh_mula,tarikh_tamat,catatan,slack,duration) VALUES ('$kod_projek','$sub_projek','$tajuk','TODO','$assigned_by','$assigned_to','$task_based',DATE_FORMAT('$tarikh_mula','%Y-%m-%d %H:%i:%s'),DATE_FORMAT('$tarikh_tamat','%Y-%m-%d %H:%i:%s'),'$catatan','$slack',TIMEDIFF(DATE_FORMAT('$tarikh_tamat','%Y-%m-%d %H:%i:%s'),DATE_FORMAT('$tarikh_mula','%Y-%m-%d %H:%i:%s')))";
		}else{
			 $sql = "UPDATE projek_task SET kod_projek='$kod_projek',kod_subprojek='$sub_projek',tajuk='$tajuk',assigned_by='$assigned_by', assigned_to='$assigned_to',task_based='$task_based',tarikh_mula=DATE_FORMAT('$tarikh_mula','%Y-%m-%d %H:%i:%s'), tarikh_tamat=DATE_FORMAT('$tarikh_tamat','%Y-%m-%d %H:%i:%s'),catatan='$catatan',slack='$slack',duration=TIMEDIFF(DATE_FORMAT('$tarikh_tamat','%Y-%m-%d %H:%i:%s'),DATE_FORMAT('$tarikh_mula','%Y-%m-%d %H:%i:%s')) WHERE id_task='$id'";
		}
		
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	function getTaskList($nokp,$code) {
	  	$conn=db();
	  	$sql = "SELECT pt.*, s.*, lpk.nama_kumpulan, ltk.code,ltk.nama_kategori, pin.nama_projek FROM projek_task pt
		      	LEFT JOIN projek_internal pin ON pt.kod_projek = pin.kod_projek
		      	LEFT JOIN staff s ON pt.assigned_to = s.noic
		      	LEFT JOIN lkp_projek_kumpulan lpk ON pt.task_based = lpk.id_kumpulan
		      	LEFT JOIN lkp_task_kategori ltk ON pt.id_category = ltk.code
		      	WHERE s.status = 'BEKERJA' AND pt.assigned_to = '$nokp'
		      	AND ltk.code = '$code'
		      	ORDER BY pt.tarikh_mula DESC";
	  	$result = $conn->query($sql);
	  	return $result;
	}

	function getTaskListDoneByNokpDate($nokp) {
	  	$conn=db();
	  	$sql = "SELECT pt.*, s.*, lpk.nama_kumpulan, ltk.code,ltk.nama_kategori, pin.nama_projek FROM projek_task pt
		      	LEFT JOIN projek_internal pin ON pt.kod_projek = pin.kod_projek
		      	LEFT JOIN staff s ON pt.assigned_to = s.noic
		      	LEFT JOIN lkp_projek_kumpulan lpk ON pt.task_based = lpk.id_kumpulan
		      	LEFT JOIN lkp_task_kategori ltk ON pt.id_category = ltk.code
		      	WHERE s.status = 'BEKERJA' 
		      	AND pt.assigned_to = '$nokp'
		      	AND ltk.code = 'DONE'
		      	AND DATE_FORMAT(pt.tarikh_tamat,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')
		      	ORDER BY pt.tarikh_mula DESC";
	  	$result = $conn->query($sql);
	  	return $result;
	}

	function getTaskListDoneByNokpWeek($nokp) {
	  	$conn=db();
	  	$sql = "SELECT pt.*, s.*, lpk.nama_kumpulan, ltk.code,ltk.nama_kategori, pin.nama_projek FROM projek_task pt
		      	LEFT JOIN projek_internal pin ON pt.kod_projek = pin.kod_projek
		      	LEFT JOIN staff s ON pt.assigned_to = s.noic
		      	LEFT JOIN lkp_projek_kumpulan lpk ON pt.task_based = lpk.id_kumpulan
		      	LEFT JOIN lkp_task_kategori ltk ON pt.id_category = ltk.code
		      	WHERE s.status = 'BEKERJA' 
		      	AND pt.assigned_to = '$nokp'
		      	AND ltk.code = 'DONE'
		      	AND DATE_FORMAT(pt.tarikh_tamat,'%V') = DATE_FORMAT(CURRENT_TIMESTAMP,'%V')
		      	ORDER BY pt.tarikh_mula DESC";
	  	$result = $conn->query($sql);
	  	return $result;
	}

	function getTaskListDoneByNokpMonth($nokp) {
	  	$conn=db();
	  	$sql = "SELECT pt.*, s.*, lpk.nama_kumpulan, ltk.code,ltk.nama_kategori, pin.nama_projek FROM projek_task pt
		      	LEFT JOIN projek_internal pin ON pt.kod_projek = pin.kod_projek
		      	LEFT JOIN staff s ON pt.assigned_to = s.noic
		      	LEFT JOIN lkp_projek_kumpulan lpk ON pt.task_based = lpk.id_kumpulan
		      	LEFT JOIN lkp_task_kategori ltk ON pt.id_category = ltk.code
		      	WHERE s.status = 'BEKERJA' 
		      	AND pt.assigned_to = '$nokp'
		      	AND ltk.code = 'DONE'
		      	AND DATE_FORMAT(pt.tarikh_tamat,'%Y-%m') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')
		      	ORDER BY pt.tarikh_mula DESC";
	  	$result = $conn->query($sql);
	  	return $result;
	}

	function getTaskListDoneByNokpYear($nokp) {
	  	$conn=db();
	  	$sql = "SELECT pt.*, s.*, lpk.nama_kumpulan, ltk.code,ltk.nama_kategori, pin.nama_projek FROM projek_task pt
		      	LEFT JOIN projek_internal pin ON pt.kod_projek = pin.kod_projek
		      	LEFT JOIN staff s ON pt.assigned_to = s.noic
		      	LEFT JOIN lkp_projek_kumpulan lpk ON pt.task_based = lpk.id_kumpulan
		      	LEFT JOIN lkp_task_kategori ltk ON pt.id_category = ltk.code
		      	WHERE s.status = 'BEKERJA' 
		      	AND pt.assigned_to = '$nokp'
		      	AND ltk.code = 'DONE'
		      	AND DATE_FORMAT(pt.tarikh_tamat,'%Y') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')
		      	ORDER BY pt.tarikh_mula DESC";
	  	$result = $conn->query($sql);
	  	return $result;
	}

	function getStafTask() {
		$conn=db();
		$sql = "SELECT s.name,s.noic,s.no_staff,s.phone FROM projek_task pt
				LEFT JOIN staff s ON s.noic=pt.assigned_to
				WHERE s.status='BEKERJA'
				GROUP BY s.noic
				ORDER BY s.name";
		$result = $conn->query($sql);
		return $result;
	}

	function getBilTaskByCategory($id_category,$nokp) {
		$conn=db();
		$sql = "SELECT COUNT(*) AS bil FROM projek_task pt
				LEFT JOIN staff s ON s.noic=pt.assigned_to
				WHERE s.status='BEKERJA' AND pt.id_category='$id_category' AND pt.assigned_to='$nokp'";
		$result = $conn->query($sql);
		return $result->fetch_object()->bil;
	}

	function getBilTaskDoneByCurDate($nokp) {
		$conn=db();
		$sql = "SELECT COUNT(*) AS bil FROM projek_task pt
				LEFT JOIN staff s ON s.noic=pt.assigned_to
				WHERE s.status='BEKERJA' AND pt.id_category='DONE' AND pt.assigned_to='$nokp'
				AND DATE_FORMAT(pt.tarikh_tamat,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
		$result = $conn->query($sql);
		return $result->fetch_object()->bil;
	}

	function getBilTaskDoneByCurWeek($nokp) {
		$conn=db();
		$sql = "SELECT COUNT(*) AS bil FROM projek_task pt
				LEFT JOIN staff s ON s.noic=pt.assigned_to
				WHERE s.status='BEKERJA' AND pt.id_category='DONE' AND pt.assigned_to='$nokp'
				AND DATE_FORMAT(pt.tarikh_tamat,'%V') = DATE_FORMAT(CURRENT_TIMESTAMP,'%V')";
		$result = $conn->query($sql);
		return $result->fetch_object()->bil;
	}

	function getBilTaskDoneByCurMonth($nokp) {
		$conn=db();
		$sql = "SELECT COUNT(*) AS bil FROM projek_task pt
				LEFT JOIN staff s ON s.noic=pt.assigned_to
				WHERE s.status='BEKERJA' AND pt.id_category='DONE' AND pt.assigned_to='$nokp'
				AND DATE_FORMAT(pt.tarikh_tamat,'%Y-%m') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')";
		$result = $conn->query($sql);
		return $result->fetch_object()->bil;
	}

	function getBilTaskDoneByCurYear($nokp) {
		$conn=db();
		$sql = "SELECT COUNT(*) AS bil FROM projek_task pt
				LEFT JOIN staff s ON s.noic=pt.assigned_to
				WHERE s.status='BEKERJA' AND pt.id_category='DONE' AND pt.assigned_to='$nokp'
				AND DATE_FORMAT(pt.tarikh_tamat,'%Y') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')";
		$result = $conn->query($sql);
		return $result->fetch_object()->bil;
	}

	function getBilTaskOverdue($nokp) {
		$conn=db();
		$sql = "SELECT COUNT(*) AS bil FROM projek_task pt
				LEFT JOIN staff s ON s.noic=pt.assigned_to
				WHERE s.status='BEKERJA' AND pt.tarikh_tamat < CURRENT_TIMESTAMP  AND pt.assigned_to='$nokp' AND pt.id_category NOT IN('DONE')";
		$result = $conn->query($sql);
		return $result->fetch_object()->bil;
	}

	//start syafiqah 13-10-2019
	//tugasan hari ini -start-
	function getTaskListByCurDate($code) {
	    $conn=db();
	    $addquery = "pt.created_date";
	    if($code == 'DONE')  $addquery = "pt.tarikh_tamat";
	  
	    $sql = "SELECT pt.*, s.*,r.*,lpk.nama_kumpulan,ltk.code,ltk.nama_kategori,pin.nama_projek FROM projek_task pt
	        	LEFT JOIN projek_internal pin ON pt.kod_projek = pin.kod_projek
	          	LEFT JOIN staff s ON pt.assigned_to = s.noic
	          	LEFT JOIN role r ON s.role_id = r.code
	          	LEFT JOIN lkp_projek_kumpulan lpk ON pt.task_based = lpk.id_kumpulan
	          	LEFT JOIN lkp_task_kategori ltk ON pt.id_category = ltk.code
	          	WHERE s.status = 'BEKERJA'
	          	AND ltk.code = '$code' 
	          	AND DATE_FORMAT($addquery,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')
	          	ORDER BY pt.created_date DESC";
	  $result = $conn->query($sql);
	  return $result;
	}

	function getTaskCountByCurDate($id_category) {
	  	$conn=db();
 	 	$addquery = "pt.created_date";
	  	if($id_category == 'DONE')  $addquery = "pt.tarikh_tamat";
	  
	  	$sql = "SELECT COUNT(*) AS task_count FROM projek_task pt
  			  	LEFT JOIN staff s ON s.noic = pt.assigned_to
	      	  	WHERE s.status = 'BEKERJA' 
	      	  	AND pt.id_category = '$id_category'
	          	AND DATE_FORMAT($addquery,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
	  	$result = $conn->query($sql);
	  	return $result->fetch_object()->task_count;
	}

	function getTaskCountOverdueByCurDate() {
	  	$conn=db();
	  	$sql = "SELECT COUNT(*) AS task_count_overdue FROM projek_task pt
	      		LEFT JOIN staff s ON s.noic = pt.assigned_to
	      		WHERE s.status='BEKERJA' 
	      		AND pt.tarikh_tamat < CURRENT_TIMESTAMP
	      		AND pt.id_category NOT IN('DONE')";
	  	$result = $conn->query($sql);
	  	return $result->fetch_object()->task_count_overdue;
	}
	//tugasan hari ini -end-
	//tugasan semasa -start-
	function getTaskListInProgressByCurDate() {
	    $conn=db();
	    $sql = "SELECT pt.*, s.*,r.*,lpk.nama_kumpulan,ltk.code,ltk.nama_kategori,pin.nama_projek FROM projek_task pt
	      		LEFT JOIN projek_internal pin ON pt.kod_projek = pin.kod_projek
	          	LEFT JOIN staff s ON pt.assigned_to = s.noic
	          	LEFT JOIN role r ON s.role_id = r.code
	          	LEFT JOIN lkp_projek_kumpulan lpk ON pt.task_based = lpk.id_kumpulan
	          	LEFT JOIN lkp_task_kategori ltk ON pt.id_category = ltk.code
	          	WHERE s.status = 'BEKERJA'
         	 	AND ltk.code = 'INPROGRESS'
	          	AND DATE_FORMAT(pt.tarikh_mula,'%Y-%m-%d') <= DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')
	          	ORDER BY pt.created_date DESC";
	  	$result = $conn->query($sql);
	  	return $result;
	}

	function getTaskListToDoByCurDate() {
	    $conn=db();
	    $sql = "SELECT pt.*, s.*,r.*,lpk.nama_kumpulan,ltk.code,ltk.nama_kategori,pin.nama_projek FROM projek_task pt
	        	LEFT JOIN projek_internal pin ON pt.kod_projek = pin.kod_projek
	          	LEFT JOIN staff s ON pt.assigned_to = s.noic
	          	LEFT JOIN role r ON s.role_id = r.code
	          	LEFT JOIN lkp_projek_kumpulan lpk ON pt.task_based = lpk.id_kumpulan
	          	LEFT JOIN lkp_task_kategori ltk ON pt.id_category = ltk.code
	          	WHERE s.status = 'BEKERJA'
	          	AND ltk.code = 'TODO'
	          	AND DATE_FORMAT(pt.tarikh_mula,'%Y-%m-%d') <= DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')
	          	ORDER BY pt.created_date DESC";
	  	$result = $conn->query($sql);
  		return $result;
	}

	function getTaskListDoneByCurDate() {
	  	$conn=db();
	  	$sql = "SELECT pt.*, s.*,r.*,lpk.nama_kumpulan,ltk.code,ltk.nama_kategori,pin.nama_projek FROM projek_task pt
	  			LEFT JOIN projek_internal pin ON pt.kod_projek = pin.kod_projek
	      		LEFT JOIN staff s ON pt.assigned_to = s.noic
	      		LEFT JOIN role r ON s.role_id = r.code
	      		LEFT JOIN lkp_projek_kumpulan lpk ON pt.task_based = lpk.id_kumpulan
	      		LEFT JOIN lkp_task_kategori ltk ON pt.id_category = ltk.code
	      		WHERE s.status = 'BEKERJA'
	      		AND ltk.code = 'DONE'
	      		AND DATE_FORMAT(pt.tarikh_tamat,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')
	      		ORDER BY pt.created_date DESC";
	  $result = $conn->query($sql);
	  return $result;
	}

	function getTaskListDoneByCurWeek() {
	  	$conn=db();
	  	$sql = "SELECT pt.*, s.*,r.*,lpk.nama_kumpulan,ltk.code,ltk.nama_kategori,pin.nama_projek FROM projek_task pt
	  			LEFT JOIN projek_internal pin ON pt.kod_projek = pin.kod_projek
	      		LEFT JOIN staff s ON pt.assigned_to = s.noic
	      		LEFT JOIN role r ON s.role_id = r.code
	      		LEFT JOIN lkp_projek_kumpulan lpk ON pt.task_based = lpk.id_kumpulan
	      		LEFT JOIN lkp_task_kategori ltk ON pt.id_category = ltk.code
	      		WHERE s.status = 'BEKERJA'
	      		AND ltk.code = 'DONE'
	      		AND DATE_FORMAT(pt.tarikh_tamat,'%V') = DATE_FORMAT(CURRENT_TIMESTAMP,'%V')
	      		ORDER BY pt.created_date DESC";
	  $result = $conn->query($sql);
	  return $result;
	}

	function getTaskListDoneByCurMonth() {
	  	$conn=db();
	  	$sql = "SELECT pt.*, s.*,r.*,lpk.nama_kumpulan,ltk.code,ltk.nama_kategori,pin.nama_projek FROM projek_task pt
	  			LEFT JOIN projek_internal pin ON pt.kod_projek = pin.kod_projek
	      		LEFT JOIN staff s ON pt.assigned_to = s.noic
	      		LEFT JOIN role r ON s.role_id = r.code
	      		LEFT JOIN lkp_projek_kumpulan lpk ON pt.task_based = lpk.id_kumpulan
	      		LEFT JOIN lkp_task_kategori ltk ON pt.id_category = ltk.code
	      		WHERE s.status = 'BEKERJA'
	      		AND ltk.code = 'DONE'
	      		AND DATE_FORMAT(pt.tarikh_tamat,'%Y-%m') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')
	      		ORDER BY pt.created_date DESC";
	  $result = $conn->query($sql);
	  return $result;
	}

	function getTaskListDoneByCurYear() {
	  	$conn=db();
	  	$sql = "SELECT pt.*, s.*,r.*,lpk.nama_kumpulan,ltk.code,ltk.nama_kategori,pin.nama_projek FROM projek_task pt
	  			LEFT JOIN projek_internal pin ON pt.kod_projek = pin.kod_projek
	      		LEFT JOIN staff s ON pt.assigned_to = s.noic
	      		LEFT JOIN role r ON s.role_id = r.code
	      		LEFT JOIN lkp_projek_kumpulan lpk ON pt.task_based = lpk.id_kumpulan
	      		LEFT JOIN lkp_task_kategori ltk ON pt.id_category = ltk.code
	      		WHERE s.status = 'BEKERJA'
	      		AND ltk.code = 'DONE'
	      		AND DATE_FORMAT(pt.tarikh_tamat,'%Y') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')
	      		ORDER BY pt.created_date DESC";
	  $result = $conn->query($sql);
	  return $result;
	}

	function getTaskCountInProgressByCurDate() {
	  	$conn=db();
 	 	$sql = "SELECT COUNT(*) AS task_inprogress_count FROM projek_task pt
	      		LEFT JOIN staff s ON s.noic = pt.assigned_to
	      		WHERE s.status = 'BEKERJA' 
	      		AND pt.id_category = 'INPROGRESS'
	      		AND DATE_FORMAT(pt.tarikh_mula,'%Y-%m-%d') <= DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
	  $result = $conn->query($sql);
	  return $result->fetch_object()->task_inprogress_count;
	}

	function getTaskCountToDoByCurDate() {
	  	$conn=db();
	  	$sql = "SELECT COUNT(*) AS task_todo_count FROM projek_task pt
	      		LEFT JOIN staff s ON s.noic = pt.assigned_to
	      		WHERE s.status = 'BEKERJA' 
	      		AND pt.id_category = 'TODO'
	          	AND DATE_FORMAT(pt.tarikh_mula,'%Y-%m-%d') <= DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
	  $result = $conn->query($sql);
	  return $result->fetch_object()->task_todo_count;
	}

	function getTaskCountDoneByCurDate() {
		$conn=db();
		$sql = "SELECT COUNT(*) AS task_done_count FROM projek_task pt
				LEFT JOIN staff s ON s.noic = pt.assigned_to
				WHERE s.status = 'BEKERJA' 
				AND pt.id_category = 'DONE'
				AND DATE_FORMAT(pt.tarikh_tamat,'%Y-%m-%d') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d')";
		$result = $conn->query($sql);
		return $result->fetch_object()->task_done_count;
	}

	function getTaskCountDoneByCurWeek() {
		$conn=db();
		$sql = "SELECT COUNT(*) AS task_done_count FROM projek_task pt
				LEFT JOIN staff s ON s.noic = pt.assigned_to
				WHERE s.status = 'BEKERJA' 
				AND pt.id_category = 'DONE'
				AND DATE_FORMAT(pt.tarikh_tamat,'%V') = DATE_FORMAT(CURRENT_TIMESTAMP,'%V')";
		$result = $conn->query($sql);
		return $result->fetch_object()->task_done_count;
	}

	function getTaskCountDoneByCurMonth() {
		$conn=db();
		$sql = "SELECT COUNT(*) AS task_done_count FROM projek_task pt
				LEFT JOIN staff s ON s.noic = pt.assigned_to
				WHERE s.status = 'BEKERJA' 
				AND pt.id_category = 'DONE'
				AND DATE_FORMAT(pt.tarikh_tamat,'%Y-%m') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m')";
		$result = $conn->query($sql);
		return $result->fetch_object()->task_done_count;
	}

	function getTaskCountDoneByCurYear() {
		$conn=db();
		$sql = "SELECT COUNT(*) AS task_done_count FROM projek_task pt
				LEFT JOIN staff s ON s.noic = pt.assigned_to
				WHERE s.status = 'BEKERJA' 
				AND pt.id_category = 'DONE'
				AND DATE_FORMAT(pt.tarikh_tamat,'%Y') = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y')";
		$result = $conn->query($sql);
		return $result->fetch_object()->task_done_count;
	}

	function getTaskCountOverdateByCurDate() {
	  	$conn=db();
	  	$sql = "SELECT COUNT(*) AS task_overdue_count FROM projek_task pt
	      		LEFT JOIN staff s ON s.noic = pt.assigned_to
	      		WHERE s.status='BEKERJA' 
	      		AND pt.tarikh_tamat < CURRENT_TIMESTAMP
	      		AND pt.id_category NOT IN('DONE')";
	  $result = $conn->query($sql);
	  return $result->fetch_object()->task_overdue_count;
	}
	//tugasan semasa -end-
	//end syafiqah 13-10-2019

	function getStaffDetailsByNokp($nokp_staff) {
		$conn=db();
		$sql = "SELECT k.*,s.*,r.*,d.*,lkpc.* FROM kehadiran k
				LEFT JOIN staff s ON k.nokp_staff = s.noic
				LEFT JOIN role r ON s.role_id = r.code
				LEFT JOIN department d ON s.department_id = d.code_department
				LEFT JOIN lkp_cawangan lkpc ON s.cawangan_kod = lkpc.cawangan_kod
				WHERE k.nokp_staff = '$nokp_staff'
				AND s.status = 'BEKERJA'";
		$result = $conn->query($sql);
		return $result;
	}

	function kemaskiniCatatanProgress($id,$catatan,$jenis_catatan) {
		$conn=db();
			if($jenis_catatan=="inprogress"){
		   	$sql = "UPDATE projek_task SET catatan_inprogress='$catatan' WHERE id_task = '$id'";
	   		}else{
   		 	$sql = "UPDATE projek_task SET catatan_done='$catatan' WHERE id_task = '$id'";
	   		}
		$result = $conn->query($sql);
		return $result;
	}

	//update all tarikh tamat yg overdue category todo -start-
	function updateAllTarikhRTodoOver() {
		$conn=db();
		$sql = "UPDATE projek_task SET tarikh_tamat = DATE_FORMAT(CURRENT_TIMESTAMP,'%Y-%m-%d 23:59:00') 
				WHERE tarikh_tamat < CURRENT_TIMESTAMP AND id_category = 'TODO'";
		$result = $conn->query($sql);
		return $result;
	}
	//update all tarikh tamat yg overdue category todo -end-

	$conn->close();
?>