<?php

	require '../../lib/db/connection.php';
	
	$action=$_POST['action'];
	

  
 
	//pemohon education
	if ($action=="edit_education") {
		$pemohon_edu_id=clean($_POST['pemohon_edu_id']);
		$pencapaian=clean($_POST['pencapaian']);
		$tempat=clean($_POST['tempat']);
		$tahun_mula=clean($_POST['tahun_mula']);
		$tahun_akhir=clean($_POST['tahun_akhir']);
		$keputusan=clean($_POST['keputusan']);
		$pemohon_id=clean($_POST['pemohon_id']);
		
		if($pemohon_edu_id=='0'){
			//need insert new data
			addEducation($pencapaian,$tempat,$tahun_mula,$tahun_akhir,$keputusan,$pemohon_id);
		}else{
			//will update
			editEducation($pemohon_edu_id,$pencapaian,$tempat,$tahun_mula,$tahun_akhir,$keputusan);
		}
	}
	
	if ($action=="del_education") {
		echo $pemohon_edu_id=clean($_POST['pemohon_edu_id']);
		if($pemohon_edu_id == "0"){
			
		}else{
			delEducation($pemohon_edu_id);
		}
	}
	
	
	
	//pemohon experience
	if ($action=="edit_experience") {
		$pemohon_exp_id=clean($_POST['pemohon_exp_id']);
		$tempat_berkerja=clean($_POST['tempat_berkerja']);
		$tarikh_mula=clean($_POST['tarikh_mula']);
		$tarikh_akhir=clean($_POST['tarikh_akhir']);
		$gaji=clean($_POST['gaji']);
		$jawatan=clean($_POST['jawatan']);
		$peranan=clean($_POST['peranan']);
		 $pemohon_id=clean($_POST['pemohon_id']);
		
		if($pemohon_exp_id=='0'){
			//need insert new data
			addExperience($tempat_berkerja,$tarikh_mula,$tarikh_akhir,$gaji,$jawatan,$peranan,$pemohon_id);
		}else{
			//will update
			editExperience($pemohon_exp_id,$tempat_berkerja,$tarikh_mula,$tarikh_akhir,$gaji,$jawatan,$peranan);
		}
	}
	
	if ($action=="del_experience") {
		echo $pemohon_exp_id=clean($_POST['pemohon_exp_id']);
		if($pemohon_exp_id == "0"){
			
		}else{
			delExperience($pemohon_exp_id);
		}
	}
	
	
	//pemohon skill
	if ($action=="edit_skills") {
		$pemohon_skill_id=clean($_POST['pemohon_skill_id']);
		$skill=clean($_POST['skill']);
		$level=clean($_POST['level']);
		$pemohon_id=clean($_POST['pemohon_id']);
		
		if($pemohon_skill_id=='0'){
			//need insert new data
			addSkill($skill,$level,$pemohon_id);
		}else{
			//will update
			editSkill($pemohon_skill_id,$skill,$level);
		}
	}
	
	if ($action=="del_skill") {
		echo $pemohon_skill_id=clean($_POST['pemohon_skill_id']);
		if($pemohon_skill_id == "0"){
			
		}else{
			delSkill($pemohon_skill_id);
		}
	}
	
	//pemohon family
	if ($action=="edit_family") {
		$pemohon_fmly_id=clean($_POST['pemohon_fmly_id']);
		$nama=clean($_POST['nama']);
		$phone=clean($_POST['phone']);
		$pekerjaan=clean($_POST['pekerjaan']);
		$hubungan=clean($_POST['hubungan']);
		$pemohon_id=clean($_POST['pemohon_id']);
		
		if($pemohon_fmly_id=='0'){
			//need insert new data
			addFamily($nama,$phone,$pekerjaan,$hubungan,$pemohon_id);
		}else{
			//will update
			editFamily($pemohon_fmly_id,$nama,$phone,$pekerjaan,$hubungan);
		}
	}
	
	if ($action=="del_family") {
		echo $pemohon_fmly_id=clean($_POST['pemohon_fmly_id']);
		if($pemohon_fmly_id == "0"){
			
		}else{
			delFamily($pemohon_fmly_id);
		}
	}
	
	
	
	//intern functions
	//intern education
	if ($action=="updt_education") {
		$intern_edu_id=clean($_POST['intern_edu_id']);
		$pencapaian=clean($_POST['pencapaian']);
		$tempat=clean($_POST['tempat']);
		$tahun_mula=clean($_POST['tahun_mula']);
		$tahun_akhir=clean($_POST['tahun_akhir']);
		$keputusan=clean($_POST['keputusan']);
		$pemohon_id=clean($_POST['pemohon_id']);
		
		if($intern_edu_id=='0'){
			//need insert new data
			addEducationIntern($pencapaian,$tempat,$tahun_mula,$tahun_akhir,$keputusan,$pemohon_id);
		}else{
			//will update
			editEducationIntern($intern_edu_id,$pencapaian,$tempat,$tahun_mula,$tahun_akhir,$keputusan);
		}
	}
	
	if ($action=="delete_education") {
		echo $intern_edu_id=clean($_POST['intern_edu_id']);
		if($intern_edu_id == "0"){
			
		}else{
			delEducationIntern($intern_edu_id);
		}
	}
	
	
	
	//intern experience
	if ($action=="updt_experience") {
		$intern_exp_id=clean($_POST['intern_exp_id']);
		$tempat_berkerja=clean($_POST['tempat_berkerja']);
		$tarikh_mula=clean($_POST['tarikh_mula']);
		$tarikh_akhir=clean($_POST['tarikh_akhir']);
		$gaji=clean($_POST['gaji']);
		$jawatan=clean($_POST['jawatan']);
		$peranan=clean($_POST['peranan']);
		 $pemohon_id=clean($_POST['pemohon_id']);
		
		if($intern_exp_id=='0'){
			//need insert new data
			addExperienceIntern($tempat_berkerja,$tarikh_mula,$tarikh_akhir,$gaji,$jawatan,$peranan,$pemohon_id);
		}else{
			//will update
			editExperienceIntern($intern_exp_id,$tempat_berkerja,$tarikh_mula,$tarikh_akhir,$gaji,$jawatan,$peranan);
		}
	}
	
	if ($action=="delete_experience") {
		echo $intern_exp_id=clean($_POST['intern_exp_id']);
		if($intern_exp_id == "0"){
			
		}else{
			delExperienceIntern($intern_exp_id);
		}
	}
	
	
	//intern skill
	if ($action=="updt_skills") {
		$intern_skill_id=clean($_POST['intern_skill_id']);
		$skill=clean($_POST['skill']);
		$level=clean($_POST['level']);
		$pemohon_id=clean($_POST['pemohon_id']);
		
		if($intern_skill_id=='0'){
			//need insert new data
			addSkillIntern($skill,$level,$pemohon_id);
		}else{
			//will update
			editSkillIntern($intern_skill_id,$skill,$level);
		}
	}
	
	if ($action=="delete_skill") {
		echo $intern_skill_id=clean($_POST['intern_skill_id']);
		if($intern_skill_id == "0"){
			
		}else{
			delSkillIntern($intern_skill_id);
		}
	}
	
	//intern family
	if ($action=="updt_family") {
		$intern_fmly_id=clean($_POST['intern_fmly_id']);
		$nama=clean($_POST['nama']);
		$phone=clean($_POST['phone']);
		$pekerjaan=clean($_POST['pekerjaan']);
		$hubungan=clean($_POST['hubungan']);
		$pemohon_id=clean($_POST['pemohon_id']);
		
		if($intern_fmly_id=='0'){
			//need insert new data
			addFamilyIntern($nama,$phone,$pekerjaan,$hubungan,$pemohon_id);
		}else{
			//will update
			editFamilyIntern($intern_fmly_id,$nama,$phone,$pekerjaan,$hubungan);
		}
	}
	
	if ($action=="delete_family") {
		echo $intern_fmly_id=clean($_POST['intern_fmly_id']);
		if($intern_fmly_id == "0"){
			
		}else{
			delFamilyIntern($intern_fmly_id);
		}
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
		$result = $conn->query($sql);
		return $result;
	}
	
	function getLogPemohon($statact) {
		$conn=db();
		
		if ($statact=='DLMPOHON') {
		$sql = "SELECT p.*,r.role AS peranan,sp.desc,rg.role_group_name,pk.status_pemohon as statusmohon,pk.status_jawapan,pk.role_id,pk.tarikh_jawapan,pk.id as kelulusanid  
				FROM pemohon p
                LEFT JOIN role r ON r.code=p.role_id
				LEFT JOIN status_pemohon sp ON sp.code = p.status_pemohon
				LEFT JOIN role_group rg ON rg.id=r.role_group_id 
				LEFT JOIN pmohon_kelulusan pk ON pk.pemohon_id=p.id 
				WHERE p.status_pemohon='DLMPOHON'
				ORDER BY p.created_date DESC";
		}
		elseif ($statact=='TERIMA') {
		$sql = "SELECT p.*,r.role AS peranan,sp.desc,rg.role_group_name,pk.status_pemohon as statusmohon,pk.status_jawapan,pk.role_id,pk.tarikh_jawapan,pk.id as kelulusanid  
				FROM pemohon p
                LEFT JOIN role r ON r.code=p.role_id
				LEFT JOIN status_pemohon sp ON sp.code = p.status_pemohon
				LEFT JOIN role_group rg ON rg.id=r.role_group_id 
				LEFT JOIN pmohon_kelulusan pk ON pk.pemohon_id=p.id 
				WHERE p.status_pemohon='TERIMA'
				ORDER BY p.created_date DESC";
		}
		elseif ($statact=='IV') {
		$sql = "SELECT p.*,r.role AS peranan,sp.desc,rg.role_group_name,pk.status_pemohon as statusmohon,pk.status_jawapan,pk.role_id,pk.tarikh_jawapan,pk.id as kelulusanid  
				FROM pemohon p
                LEFT JOIN role r ON r.code=p.role_id
				LEFT JOIN status_pemohon sp ON sp.code = p.status_pemohon
				LEFT JOIN role_group rg ON rg.id=r.role_group_id 
				LEFT JOIN pmohon_kelulusan pk ON pk.pemohon_id=p.id 
				WHERE p.status_pemohon='IV'
				ORDER BY p.created_date DESC";
		}
		elseif ($statact=='STAFF') {
		$sql = "SELECT p.*,r.role AS peranan,sp.desc,rg.role_group_name,pk.status_pemohon as statusmohon,pk.status_jawapan,pk.role_id,pk.tarikh_jawapan,pk.id as kelulusanid  
				FROM pemohon p
                LEFT JOIN role r ON r.code=p.role_id
				LEFT JOIN status_pemohon sp ON sp.code = p.status_pemohon
				LEFT JOIN role_group rg ON rg.id=r.role_group_id 
				LEFT JOIN pmohon_kelulusan pk ON pk.pemohon_id=p.id
				WHERE p.status_pemohon='STAFF'
				ORDER BY p.created_date DESC";
		}
		else {
		$sql = "SELECT p.*,r.role AS peranan,sp.desc,rg.role_group_name,pk.status_pemohon as statusmohon,pk.status_jawapan,pk.role_id,pk.tarikh_jawapan,pk.id as kelulusanid  
				FROM pemohon p
                LEFT JOIN role r ON r.code=p.role_id
				LEFT JOIN status_pemohon sp ON sp.code = p.status_pemohon
				LEFT JOIN role_group rg ON rg.id=r.role_group_id 
				LEFT JOIN pmohon_kelulusan pk ON pk.pemohon_id=p.id
				WHERE p.status_pemohon='TDKTERIMA'
				ORDER BY p.created_date DESC";
		}
		$result = $conn->query($sql);
		return $result;
	}
	
	function getStaff() {
		$conn=db();
		$sql = "SELECT * FROM staff WHERE status = 'BEKERJA' AND noic IS NOT NULL";
		$result = $conn->query($sql);
		return $result;
	}
	
	//*get staff yg menjadi penemuduga
	function getPenemuduga($pmhn_lulus_id) {
		$conn=db();
		$sql = "SELECT p.*,s.name FROM penemuduga p
				LEFT JOIN staff s
				on p.no_staff = s.no_staff WHERE p.pmhn_kllusn_id='$pmhn_lulus_id' ";
		$result = $conn->query($sql);
		return $result;
	}
	
	
		//* get ketua penemuduga by flag 
		function getPenemudugaByFlag($no_staff){
       $conn=db();
      $sql = "SELECT p.*,sr.peranan
				FROM penemuduga p
				LEFT JOIN staff_record sr
				ON sr.no_staff=p.no_staff
				WHERE p.no_staff='$no_staff'";
       $result = $conn->query($sql);
	   return $result;


	}
	
	
	//* get  maklumat jadual temuduga by pemohon id
		function getLogKelulusan() {
		$conn=db();
        $sql = "  SELECT pk.*,p.name AS nama_pemohon,s.name AS nama,sp.desc 
					 FROM pmohon_kelulusan pk
					 LEFT JOIN pemohon p 
					 ON pk.pemohon_id=p.id 
					 LEFT JOIN staff s
					 ON s.no_staff=pk.penemuduga 
					 LEFT JOIN status_pemohon sp 
					 ON sp.code=pk.status_pemohon
					 LEFT JOIN pmohon_kelulusan pkk
					 ON pkk.pemohon_id=p.id 
					 ORDER BY pk.created_date DESC";
					
		$result = $conn->query($sql);
		return $result;
	}
	
	
	
	
	//*get maklumat jadual temuduga setelah dikemaskini
	function getUpdateLogKelulusan($pemohon_id) {
		$conn=db();
        $sql = "  SELECT pk.*,p.name AS nama_pemohon,s.name AS nama,sp.desc,p.cawangan_kod 
					 FROM pmohon_kelulusan pk
					 LEFT JOIN pemohon p 
					 ON pk.pemohon_id=p.id 
					 LEFT JOIN staff s
					 ON s.no_staff=pk.penemuduga 
					 LEFT JOIN status_pemohon sp 
					 ON sp.code=pk.status_pemohon
					 LEFT JOIN pmohon_kelulusan pkk
					 ON pkk.pemohon_id=p.id
					 WHERE pk.pemohon_id='$pemohon_id' ";
					
		$result = $conn->query($sql);
		return $result;
	}
	
	//* status kelulusan setelah ditemuduga
	function getStatusKelulusan() {
		$conn=db();
		$sql = "SELECT * FROM status_pemohon WHERE CODE IN ('TERIMA', 'TDKTERIMA') ";
		$result = $conn->query($sql);
		
		return $result;
	}
	
	function getLogEdu($pemohon_id) {
		$conn=db();
		$sql = "SELECT * FROM pmohon_education WHERE pemohon_id='$pemohon_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getLogExperience($pemohon_id) {
		$conn=db();
		$sql = "SELECT * FROM pmohon_experience WHERE pemohon_id='$pemohon_id' ";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getLogSkill($pemohon_id) {
		$conn=db();
		$sql = "SELECT * FROM pmohon_skill WHERE pemohon_id='$pemohon_id' ";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getFamily($pemohon_id) {
		$conn=db();
		$sql = "SELECT * FROM pmohon_family WHERE pemohon_id='$pemohon_id' ";
		$result = $conn->query($sql);
		return $result;
	}
		
	function getRole() {
		$conn=db();
		$sql = "SELECT * FROM role WHERE code NOT IN('SUPERADMIN')";
		$result = $conn->query($sql);
		return $result;
	}
	
	function 
	Status($id) {
		$conn=db();
		$sql = "SELECT * FROM status_pemohon WHERE code='DLMPOHON' ";
		$result = $conn->query($sql);
		
		return $result;
	}
	
	function getKawin() {
		$conn=db();
		$sql = "SELECT * FROM martial ";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getGender() {
		$conn=db();
		$sql = "SELECT * FROM gender ";
		$result = $conn->query($sql);
		return $result;
	  }
	
	function getRoleGroup() {
		$conn=db();
		$sql = "SELECT * FROM role_group WHERE role_group_name NOT IN ('SYSTEM')";
		$result = $conn->query($sql);
		return $result;
	  }
	
	function getJawatan() {
		$conn=db();
		$sql = "SELECT * FROM jawatan  ";
		$result = $conn->query($sql);
		return $result;
	}
	
	//pemohon details
	function getPemohonRecords($pemohon_id) {
		$conn=db();
		$sql = "SELECT p.*, m.desc, rcv.*,pe.* FROM pemohon p 
				LEFT JOIN martial m ON m.martial_status=p.martial_status 
				LEFT JOIN resume_cv rcv ON p.id = rcv.pemohon_id
				LEFT JOIN pmohon_education pe ON p.id = pe.pemohon_id
				WHERE p.id='$pemohon_id'";
		$result = $conn->query($sql);
		return $result;
	}

	 	function getPemohonPendidikan($pemohon_id) {
		$conn=db();
		$sql = "SELECT * FROM pmohon_education WHERE pemohon_id='$pemohon_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getPemohonPengalaman($pemohon_id) {
		$conn=db();
		$sql = "SELECT * FROM pmohon_experience  WHERE pemohon_id='$pemohon_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
		function getPemohonKemahiran($pemohon_id) {
		$conn=db();
		$sql = "SELECT * FROM pmohon_skill WHERE pemohon_id='$pemohon_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
		function getPemohonFamily($pemohon_id) {
		$conn=db();
		$sql = "SELECT * FROM pmohon_family  WHERE pemohon_id='$pemohon_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getValueName($pemohon_id){
        $conn=db();
        $sql="SELECT * FROM pemohon WHERE id='$pemohon_id'";
         $result = $conn->query($sql);
         return $result;


     }
//* get maklumat pemohon utk draf surat	
	function getPemohonKelulusan($id) {
    $conn=db();
    $sql = "SELECT pk.*,p.name,p.phone,p.email,p.alamat_surat,p.noic,sp.desc,sp.code,rg.role_group_name,
            p.role_id AS peranan,r.role AS jawatan,p.tarikh_mula AS tarikh_start,p.tarikh_tamat
            FROM pmohon_kelulusan pk
            LEFT JOIN role r ON r.code=pk.role_id 
            LEFT JOIN status_pemohon sp ON pk.status_pemohon=sp.code
            LEFT JOIN role_group rg ON rg.id=r.role_group_id
            LEFT JOIN pemohon p ON p.id=pk.pemohon_id
            WHERE pk.id='$id' AND pk.status_pemohon IN ('TERIMA','STAFF')";
    
    $result = $conn->query($sql);
    return $result;
  }
		
	//* get maklumat pemohon utk tentukan jadual temuduga	
	function getPemohon($id) {
    $conn=db();
    $sql = "
    SELECT p.*,r.role AS peranan
    FROM pemohon p 
    LEFT JOIN role r ON r.code=p.role_id
    WHERE p.id='$id'";
    $result = $conn->query($sql);
    return $result;
  }
	//senarai pemohon perjawatan
	function getPemohonPerjawatan($iklan_id) {
    $conn=db();
    $sql = "SELECT p.*,r.role AS peranan,sp.desc AS status_pemohon
			FROM pemohon p 
			LEFT JOIN role r ON r.code=p.role_id
			LEFT JOIN status_pemohon sp ON sp.code=p.status_pemohon
			WHERE p.iklan_id='$iklan_id'";
    $result = $conn->query($sql);
    return $result;
  }
	//update status jawapan pemohon
	function updateStatusJawapan($id,$status_jawapan,$tarikh_jawapan){
		 $conn=db();
		  $sql = "UPDATE pmohon_kelulusan SET status_jawapan='$status_jawapan' , tarikh_jawapan='$tarikh_jawapan' WHERE id='$id'" ;
		 $result = $conn->query($sql);
		 return $result;
	}
	
	
	
	
	//delete penemuduga
	function delPenemuduga($pmhn_kllusn_id) {
		$conn=db();
		$sql = "DELETE FROM penemuduga WHERE pmhn_kllusn_id = '$pmhn_kllusn_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	//* checkbox for penemuduga
	function checkCheckbox($no_staff,$pmhn_kllusn_id){
		$conn=db();
	    $sql = "SELECT * FROM penemuduga
			     WHERE no_staff='$no_staff' 
			     AND pmhn_kllusn_id='$pmhn_kllusn_id'";
		$result = $conn->query($sql);
		$row=$result->num_rows;

		if($row>0){

			return "checked";
		}
		else{
			return " ";
		}
     }
	 
	//* radio button for ketua penemuduga
	 function checkRadio($no_staff,$pmhn_kllusn_id){
		$conn=db();
	    $sql = "SELECT * FROM penemuduga 
				    WHERE flag_ketua='1' 
				    AND  no_staff='$no_staff'
				    AND pmhn_kllusn_id='$pmhn_kllusn_id' ";
		$result = $conn->query($sql);
		$row=$result->num_rows;

		if($row>0){

			return "checked";
		}
		else{
			return " ";
		}
     }
	
		//* add jadual temuduga
	function addInterview($pemohon_id,$tarikh_iv,$masa_iv,$role,$no_staff,$ketua,$cawangan_kod) {
		 $conn=db();
		$sql = "INSERT INTO pmohon_kelulusan(pemohon_id,tarikh_iv,masa_iv,role_id,penemuduga,status_pemohon) 
				VALUES('$pemohon_id',STR_TO_DATE('$tarikh_iv','%d/%m/%Y'),'$masa_iv','$role','$no_staff','IV')";
		$result = $conn->query($sql);
		
		$new_id=$conn->insert_id;
		
		
		  $sql3 = "UPDATE pemohon SET status_pemohon='IV',cawangan_kod='$cawangan_kod' WHERE id='$pemohon_id'";
		 $result3 = $conn->query($sql3);
		

		return $new_id;
	}
	
	
	//* set staff yg menjadi penemuduga
	function setPenemuduga($pmhn_kllusn_id,$no_staff,$flag_ketua) {
		 $conn=db();
		 $sql = "INSERT INTO penemuduga (pmhn_kllusn_id, no_staff, flag_ketua)
						VALUES ('$pmhn_kllusn_id', '$no_staff','$flag_ketua')";
		$result = $conn->query($sql);

		return $result;
	}
	
	      //update temuduga
 	function  updateInterview($pemohon_id,$tarikh_iv,$masa_iv,$no_staff,$cawangan_kod) {
		$conn=db();
		  $sql= "UPDATE pmohon_kelulusan SET tarikh_iv=STR_TO_DATE('$tarikh_iv','%d/%m/%Y'), masa_iv='$masa_iv', penemuduga='$no_staff' WHERE pemohon_id='$pemohon_id'";

		$result = $conn->query($sql);

		$sql1= "UPDATE pemohon SET cawangan_kod='$cawangan_kod' WHERE id='$pemohon_id'";

		$result = $conn->query($sql1);
       
		return $result;
		
	}
		
	function addPemohon($noic,$name,$phone,$email,$alamat_tetap,$alamat_surat,$umur,$role_id,$status_pemohon,$martial_status,$tanggungan,$tarikh_mula,$tarikh_tamat,$company_id,$gender,$iklan_id) {
		$conn=db();
		 $sql = "INSERT INTO pemohon (noic,name,phone,email,alamat_tetap,alamat_surat,umur,role_id,status_pemohon,martial_status,tanggungan,tarikh_mula,tarikh_tamat,company_id,gender,iklan_id)
				VALUES('$noic','$name','$phone','$email','$alamat_tetap','$alamat_surat','$umur','$role_id','$status_pemohon','$martial_status','$tanggungan','$tarikh_mula','$tarikh_tamat','$company_id','$gender','$iklan_id')";
		 $result = $conn->query($sql);
		return $conn->insert_id;
	}
	
	function addEducation($pencapaian,$tempat,$tahun_mula,$tahun_akhir,$keputusan,$pemohon_id) {
		$conn=db();
		 $sql = "INSERT INTO pmohon_education(pencapaian,tempat,tahun_mula,tahun_akhir,keputusan,pemohon_id)
				VALUES('$pencapaian', '$tempat', '$tahun_mula', '$tahun_akhir', '$keputusan','$pemohon_id')";
		$result = $conn->query($sql);
		return $result;
	} 
	
	function addExperience($tempat_berkerja,$tarikh_mula,$tarikh_akhir,$gaji,$jawatan,$peranan,$pemohon_id) {
		$conn=db();
		 $sql = "INSERT INTO pmohon_experience(tempat_berkerja,tarikh_mula,tarikh_akhir,gaji,jawatan,peranan,pemohon_id)
				VALUES('$tempat_berkerja', STR_TO_DATE('$tarikh_mula','%d/%m/%Y'), STR_TO_DATE('$tarikh_akhir','%d/%m/%Y'), '$gaji', '$jawatan', '$peranan','$pemohon_id')";
		$result = $conn->query($sql);
		return $result;
	} 
	
	function addSkill($skill,$level,$pemohon_id) {
		$conn=db();
		 $sql = "INSERT INTO pmohon_skill(skill,level,pemohon_id)
				VALUES('$skill', '$level','$pemohon_id')";
		$result = $conn->query($sql);
		return $result;
	}
	
	function addFamily($nama,$phone,$pekerjaan,$hubungan,$pemohon_id) {
		$conn=db();
		 $sql = "INSERT INTO pmohon_family(nama,phone,pekerjaan,hubungan,pemohon_id)
				VALUES('$nama', '$phone', '$pekerjaan', '$hubungan','$pemohon_id')";
		$result = $conn->query($sql);
		return $result;
	}
	
	function isPemohonExist($pemohon_id) {
		$conn=db();
		$sql = "SELECT pemohon_id FROM groups_users WHERE company_id='$company_id'";
		$result = $conn->query($sql);
		$temp = $result->num_rows;
		return $temp;
	}
	
	function update_PemohonActivity($status_pemohon,$id) {
		$conn=db();
		$sql = "UPDATE pemohon SET status = '$status_pemohon' WHERE id = '$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function updatePemohon($pemohon_id,$noic,$name,$phone,$email,$alamat_tetap,$alamat_surat,$umur,$status_pemohon,$martial_status,$tanggungan) {
		$conn=db();
		$sql = "UPDATE pemohon SET noic='$noic', name='$name', phone='$phone', email='$email', alamat_tetap='$alamat_tetap',
				alamat_surat='$alamat_surat', umur='$umur', status_pemohon='$status_pemohon', martial_status='$martial_status', tanggungan='$tanggungan'
				WHERE id = '$pemohon_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function editPemohon($pemohon_id,$noic,$name,$phone,$email,$alamat_tetap,$alamat_surat,$umur,$status_pemohon,$martial_status,$tanggungan) {
		$conn=db();
		$sql = "SELECT * FROM pemohon WHERE id='$pemohon_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	
	function editEducation($pemohon_edu_id,$pencapaian,$tempat,$tahun_mula,$tahun_akhir,$keputusan) {
		$conn=db();
		 $sql = "UPDATE pmohon_education SET pencapaian='$pencapaian', tempat='$tempat', tahun_mula='$tahun_mula', tahun_akhir='$tahun_akhir', keputusan='$keputusan'
				WHERE id = '$pemohon_edu_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function delEducation($pemohon_edu_id) {
		$conn=db();
		$sql = "DELETE FROM pmohon_education WHERE id = '$pemohon_edu_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function editExperience($pemohon_exp_id,$tempat_berkerja,$tarikh_mula,$tarikh_akhir,$gaji,$jawatan,$peranan) {
		$conn=db();
		$sql = "UPDATE pmohon_experience SET tempat_berkerja='$tempat_berkerja', tarikh_mula=STR_TO_DATE('$tarikh_mula','%d/%m/%Y'), tarikh_akhir=STR_TO_DATE('$tarikh_akhir','%d/%m/%Y'), 
				gaji='$gaji', jawatan='$jawatan', peranan='$peranan'
				WHERE id = '$pemohon_exp_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function delExperience($pemohon_exp_id) {
		$conn=db();
		$sql = "DELETE FROM pmohon_experience WHERE id = '$pemohon_exp_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function editSkill($pemohon_skill_id,$skill,$level) {
		$conn=db();
		$sql = "UPDATE pmohon_skill SET skill='$skill', level='$level'
				WHERE id = '$pemohon_skill_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function delSkill($pemohon_skill_id) {
		$conn=db();
		$sql = "DELETE FROM pmohon_skill WHERE id = '$pemohon_skill_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function editFamily($pemohon_fmly_id,$nama,$phone,$pekerjaan,$hubungan) {
		$conn=db();
		$sql = "UPDATE pmohon_family SET nama='$nama', phone='$phone', pekerjaan='$pekerjaan', hubungan='$hubungan'
				WHERE id = '$pemohon_fmly_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function delFamily($pemohon_fmly_id) {
		$conn=db();
		$sql = "DELETE FROM pmohon_family WHERE id = '$pemohon_fmly_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function updateKelulusan($pemohon_id,$gaji_dipersetujui,$status_pemohon,$catatan,$tarikh_mula,$no_rujukan,$tarikh_rujukan,$nomatrik,$program,$tempoh) {
		$conn=db();
		 $sql = "UPDATE pmohon_kelulusan 
		            SET 
		            status_pemohon='$status_pemohon', gaji_dipersetujui='$gaji_dipersetujui',catatan='$catatan', tarikh_mula='$tarikh_mula',
		            no_rujukan='$no_rujukan',tarikh_rujukan='$tarikh_rujukan',nomatrik='$nomatrik',program='$program',tempoh='$tempoh' 
				    WHERE pemohon_id = '$pemohon_id'";
		$result = $conn->query($sql);
		$sql2 = "UPDATE pemohon SET status_pemohon='$status_pemohon' WHERE id='$pemohon_id'";
		$result = $conn->query($sql2);
		
		return $result;
	}
	
	
	//intern functions
	function addIntern($noic,$name,$phone,$email,$alamat_tetap,$alamat_surat,$umur,$role_id,$status_pemohon,$martial_status,$tanggungan,$tarikh_mula,$tarikh_tamat,$company_id,$gender,$iklan_id) {
		$conn=db();
		 $sql = "INSERT INTO pemohon (noic,name,phone,email,alamat_tetap,alamat_surat,umur,role_id,status_pemohon,martial_status,tanggungan,tarikh_mula,tarikh_tamat,company_id,gender,iklan_id)
				VALUES('$noic','$name','$phone','$email','$alamat_tetap','$alamat_surat','$umur','$role_id','$status_pemohon','$martial_status','$tanggungan','$tarikh_mula','$tarikh_tamat','$company_id','$gender','$iklan_id')";
		 $result = $conn->query($sql);
		return $conn->insert_id;
	}
	
	//Education
	function addEducationIntern($pencapaian,$tempat,$tahun_mula,$tahun_akhir,$keputusan,$pemohon_id) {
		$conn=db();
		 $sql = "INSERT INTO pmohon_education(pencapaian,tempat,tahun_mula,tahun_akhir,keputusan,pemohon_id)
				VALUES('$pencapaian', '$tempat', '$tahun_mula', '$tahun_akhir', '$keputusan','$pemohon_id')";
		$result = $conn->query($sql);
		return $result;
	}
	
	function editEducationIntern($intern_edu_id,$pencapaian,$tempat,$tahun_mula,$tahun_akhir,$keputusan) {
		$conn=db();
		 $sql = "UPDATE pmohon_education SET pencapaian='$pencapaian', tempat='$tempat', tahun_mula='$tahun_mula', tahun_akhir='$tahun_akhir', keputusan='$keputusan'
				WHERE id = '$intern_edu_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function delEducationIntern($intern_edu_id) {
		$conn=db();
		$sql = "DELETE FROM pmohon_education WHERE id = '$intern_edu_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	//Experience
	function addExperienceIntern($tempat_berkerja,$tarikh_mula,$tarikh_akhir,$gaji,$jawatan,$peranan,$pemohon_id) {
		$conn=db();
		 $sql = "INSERT INTO pmohon_experience(tempat_berkerja,tarikh_mula,tarikh_akhir,gaji,jawatan,peranan,pemohon_id)
				VALUES('$tempat_berkerja', STR_TO_DATE('$tarikh_mula','%d/%m/%Y'), STR_TO_DATE('$tarikh_akhir','%d/%m/%Y'), '$gaji', '$jawatan', '$peranan','$pemohon_id')";
		$result = $conn->query($sql);
		return $result;
	}
	
	function editExperienceIntern($intern_exp_id,$tempat_berkerja,$tarikh_mula,$tarikh_akhir,$gaji,$jawatan,$peranan) {
		$conn=db();
		$sql = "UPDATE pmohon_experience SET tempat_berkerja='$tempat_berkerja', tarikh_mula=STR_TO_DATE('$tarikh_mula','%d/%m/%Y'), tarikh_akhir=STR_TO_DATE('$tarikh_akhir','%d/%m/%Y'), 
				gaji='$gaji', jawatan='$jawatan', peranan='$peranan'
				WHERE id = '$intern_exp_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function delExperienceIntern($intern_exp_id) {
		$conn=db();
		$sql = "DELETE FROM pmohon_experience WHERE id = '$intern_exp_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getTarikhMasaIv($id){
		$conn=db();
		$sql = "SELECT tarikh_iv,masa_iv,created_date FROM pmohon_kelulusan WHERE pemohon_id='$id'";
		$result = $conn->query($sql);
		return $result;
		
		
	}
	
	//Skills
	function addSkillIntern($skill,$level,$pemohon_id) {
		$conn=db();
		 $sql = "INSERT INTO pmohon_skill(skill,level,pemohon_id)
				VALUES('$skill', '$level','$pemohon_id')";
		$result = $conn->query($sql);
		return $result;
	}
	
	function editSkillIntern($intern_skill_id,$skill,$level) {
		$conn=db();
		$sql = "UPDATE pmohon_skill SET skill='$skill', level='$level'
				WHERE id = '$intern_skill_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function delSkillIntern($intern_skill_id) {
		$conn=db();
		$sql = "DELETE FROM pmohon_skill WHERE id = '$intern_skill_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	//Family
	function addFamilyIntern($nama,$phone,$pekerjaan,$hubungan,$pemohon_id) {
		$conn=db();
		 $sql = "INSERT INTO pmohon_family(nama,phone,pekerjaan,hubungan,pemohon_id)
				VALUES('$nama', '$phone', '$pekerjaan', '$hubungan','$pemohon_id')";
		$result = $conn->query($sql);
		return $result;
	}
	
	function editFamilyIntern($intern_fmly_id,$nama,$phone,$pekerjaan,$hubungan) {
		$conn=db();
		$sql = "UPDATE pmohon_family SET nama='$nama', phone='$phone', pekerjaan='$pekerjaan', hubungan='$hubungan'
				WHERE id = '$intern_fmly_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function delFamilyIntern($intern_fmly_id) {
		$conn=db();
		$sql = "DELETE FROM pmohon_family WHERE id = '$intern_fmly_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	//lampiran
	function addResumeCVIntern($pemohon_id,$document_resume,$nama_document_resume,$document_cv,$nama_document_cv,$document,$nama_document){
    $conn=db();
    $sql="INSERT INTO resume_cv(pemohon_id,document_resume,nama_document_resume,document_cv,nama_document_cv)
          VALUES('$pemohon_id','$document_resume','$nama_document_resume','$document_cv','$nama_document_cv')";
    $result = $conn->query($sql);

    $sql2="UPDATE pmohon_education SET document='$document', nama_document='$nama_document' WHERE pemohon_id='$pemohon_id'";
    $result2 = $conn->query($sql2);
      return $result;
    }
	
	
		//lampiran
	function addResumePemohon($pemohon_id,$document_resume,$nama_document_resume,$document_cv,$nama_document_cv,$document,$nama_document){
    $conn=db();
    $sql="INSERT INTO resume_cv(pemohon_id,document_resume,nama_document_resume,document_cv,nama_document_cv)
          VALUES('$pemohon_id','$document_resume','$nama_document_resume','$document_cv','$nama_document_cv')";
    $result = $conn->query($sql);

    $sql2="UPDATE pmohon_education SET document='$document', nama_document='$nama_document' WHERE pemohon_id='$pemohon_id'";
    $result2 = $conn->query($sql2);
      return $result;
    }
	
	//get Resume and CV
	  function getResumeCv($pemohon_id){
		$conn=db();
		$sql="SELECT rc.*,p.name AS nama_pemohon,pe.document AS document_transkrip
			  FROM resume_cv rc
			  LEFT JOIN pemohon p ON p.id=rc.pemohon_id
			  LEFT JOIN pmohon_education pe ON pe.pemohon_id=rc.pemohon_id
			  WHERE rc.pemohon_id='$pemohon_id'";
			$result = $conn->query($sql); 
			return $result;
  }
  
  //maklumat pendidikan permohonan perjawatan

	if ($action=="edit_education_perjawatan") {
		$pemohon_edu_id=clean($_POST['pemohon_edu_id']);
		$pencapaian=clean($_POST['pencapaian']);
		$tempat=clean($_POST['tempat']);
		$tahun_mula=clean($_POST['tahun_mula']);
		$tahun_akhir=clean($_POST['tahun_akhir']);
		$keputusan=clean($_POST['keputusan']);
		$pemohon_id=clean($_POST['pemohon_id']);
		
		if($pemohon_edu_id=='0'){
			//need insert new data
			addEducationJawatan($pencapaian,$tempat,$tahun_mula,$tahun_akhir,$keputusan,$pemohon_id);
		}else{
			//will update
			editEducationJawatan($pemohon_edu_id,$pencapaian,$tempat,$tahun_mula,$tahun_akhir,$keputusan);
		}
	}
	
	if ($action=="del_education_perjawatan") {
		echo $pemohon_edu_id=clean($_POST['pemohon_edu_id']);
		if($pemohon_edu_id == "0"){
			
		}else{
			delEducationJawatan($pemohon_edu_id);
		}
	}

	//maklumat pengalaman permohonan perjawatan

	if ($action=="edit_experience_jawatan") {
		$pemohon_exp_id=clean($_POST['pemohon_exp_id']);
		$tempat_berkerja=clean($_POST['tempat_berkerja']);
		$tarikh_mula=clean($_POST['tarikh_mula']);
		$tarikh_akhir=clean($_POST['tarikh_akhir']);
		$gaji=clean($_POST['gaji']);
		$jawatan=clean($_POST['jawatan']);
		$peranan=clean($_POST['peranan']);
		 $pemohon_id=clean($_POST['pemohon_id']);
		
		if($pemohon_exp_id=='0'){
			//need insert new data
			addExperienceJawatan($tempat_berkerja,$tarikh_mula,$tarikh_akhir,$gaji,$jawatan,$peranan,$pemohon_id);
		}else{
			//will update
			editExperienceJawatan($pemohon_exp_id,$tempat_berkerja,$tarikh_mula,$tarikh_akhir,$gaji,$jawatan,$peranan);
		}
	}
	
	if ($action=="del_experience_jawatan") {
		echo $pemohon_exp_id=clean($_POST['pemohon_exp_id']);
		if($pemohon_exp_id == "0"){
			
		}else{
			delExperienceJawatan($pemohon_exp_id);
		}
	}
	
		//maklumat skill permohonan perjawatan

	if ($action=="edit_skills_jawatan") {
		$pemohon_skill_id=clean($_POST['pemohon_skill_id']);
		$skill=clean($_POST['skill']);
		$level=clean($_POST['level']);
		$pemohon_id=clean($_POST['pemohon_id']);
		
		if($pemohon_skill_id=='0'){
			//need insert new data
			addSkillJawatan($skill,$level,$pemohon_id);
		}else{
			//will update
			editSkillJawatan($pemohon_skill_id,$skill,$level);
		}
	}
	
	if ($action=="del_skill_jawatan") {
		echo $pemohon_skill_id=clean($_POST['pemohon_skill_id']);
		if($pemohon_skill_id == "0"){
			
		}else{
			delSkillJawatan($pemohon_skill_id);
		}
	}
	
	//maklumat family permohonan perjawatan
	if ($action=="edit_family_jawatan") {
		$pemohon_fmly_id=clean($_POST['pemohon_fmly_id']);
		$nama=clean($_POST['nama']);
		$phone=clean($_POST['phone']);
		$pekerjaan=clean($_POST['pekerjaan']);
		$hubungan=clean($_POST['hubungan']);
		$pemohon_id=clean($_POST['pemohon_id']);
		
		if($pemohon_fmly_id=='0'){
			//need insert new data
			addFamilyJawatan($nama,$phone,$pekerjaan,$hubungan,$pemohon_id);
		}else{
			//will update
			editFamilyJawatan($pemohon_fmly_id,$nama,$phone,$pekerjaan,$hubungan);
		}
	}
	
	if ($action=="del_family_jawatan") {
		echo $pemohon_fmly_id=clean($_POST['pemohon_fmly_id']);
		if($pemohon_fmly_id == "0"){
			
		}else{
			delFamilyJawatan($pemohon_fmly_id);
		}
	}
	
	//dropdown penawaran jawatan
   function getPenawaranJawatan(){
		$conn=db();
		$sql = "SELECT code, peranan FROM penawaran_jawatan ";
		$result = $conn->query($sql);
		return $result;
       

	}
	
	function getPenawaranJawatanById($id){
    $conn=db();
    $sql = "SELECT pj.*,r.role AS peranan FROM penawaran_jawatan pj LEFT JOIN role r ON r.code=pj.role
    WHERE pj.id='$id'";
    $result = $conn->query($sql);
    return $result;

  }
 

	//GET PEMOHON BY ID PERJAWATAN
	function getPemohonJawatan($id) {
		$conn=db();
		$sql = "SELECT * FROM pemohon WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}

	    //maklumat peribadi bagi permohonan perjawatan
	function addPemohonPerjawatan($noic,$name,$phone,$email,$alamat_tetap,$alamat_surat,$umur,$role_id,$status_pemohon,$martial_status,$tanggungan,$company_id,$gender,$iklan_id) {
		$conn=db();
	    $sql = "INSERT INTO pemohon (noic,name,phone,email,alamat_tetap,alamat_surat,umur,role_id,status_pemohon,martial_status,tanggungan,company_id,gender,iklan_id)
				VALUES('$noic','$name','$phone','$email','$alamat_tetap','$alamat_surat','$umur','$role_id','$status_pemohon','$martial_status','$tanggungan','$company_id','$gender','$iklan_id')";
		 $result = $conn->query($sql);
		return $conn->insert_id;
		
	} 
	//kemasukan maklumat pendidikan bagi pemohon perjawatan
	function addEducationJawatan($pencapaian,$tempat,$tahun_mula,$tahun_akhir,$keputusan,$pemohon_id) {
		$conn=db();
		 $sql = "INSERT INTO pmohon_education(pencapaian,tempat,tahun_mula,tahun_akhir,keputusan,pemohon_id)
				VALUES('$pencapaian', '$tempat', '$tahun_mula', '$tahun_akhir', '$keputusan','$pemohon_id')";
		$result = $conn->query($sql);
		return $result;
	} 
	
    //kemasukan maklumat pengalaman bagi permohonan perjawatan
	function addExperienceJawatan($tempat_berkerja,$tarikh_mula,$tarikh_akhir,$gaji,$jawatan,$peranan,$pemohon_id) {
		$conn=db();
		 $sql = "INSERT INTO pmohon_experience(tempat_berkerja,tarikh_mula,tarikh_akhir,gaji,jawatan,peranan,pemohon_id)
				VALUES('$tempat_berkerja', STR_TO_DATE('$tarikh_mula','%d/%m/%Y'), STR_TO_DATE('$tarikh_akhir','%d/%m/%Y'), '$gaji', '$jawatan', '$peranan','$pemohon_id')";
		$result = $conn->query($sql);
		return $result;
	} 

	 //tambah skill bagi permohonan perjawatan
	function addSkillJawatan($skill,$level,$pemohon_id) {
		$conn=db();
		 $sql = "INSERT INTO pmohon_skill(skill,level,pemohon_id)
				VALUES('$skill', '$level','$pemohon_id')";
		$result = $conn->query($sql);
		return $result;
	}

	  //kemasukan maklumat family permohonan perjawatan
	function addFamilyJawatan($nama,$phone,$pekerjaan,$hubungan,$pemohon_id) {
		$conn=db();
		 $sql = "INSERT INTO pmohon_family(nama,phone,pekerjaan,hubungan,pemohon_id)
				VALUES('$nama', '$phone', '$pekerjaan', '$hubungan','$pemohon_id')";
		$result = $conn->query($sql);
		return $result;
	}
	 //kemaskini maklumat pendidikan bagi permohona perjawatan
	function editEducationJawatan($pemohon_edu_id,$pencapaian,$tempat,$tahun_mula,$tahun_akhir,$keputusan) {
		$conn=db();
		 $sql = "UPDATE pmohon_education SET pencapaian='$pencapaian', tempat='$tempat', tahun_mula='$tahun_mula', tahun_akhir='$tahun_akhir', keputusan='$keputusan'
				WHERE id = '$pemohon_edu_id'";
		$result = $conn->query($sql);
		return $result;
	}
	 //padamkan maklumat mengikut row bagi permohonan perjawatan
	function delEducationJawatan($pemohon_edu_id) {
		$conn=db();
		$sql = "DELETE FROM pmohon_education WHERE id = '$pemohon_edu_id'";
		$result = $conn->query($sql);
		return $result;
	}

	  //kemaskini maklumat pengalaman bagi permohonan perjawatan
	function editExperienceJawatan($pemohon_exp_id,$tempat_berkerja,$tarikh_mula,$tarikh_akhir,$gaji,$jawatan,$peranan) {
		$conn=db();
		$sql = "UPDATE pmohon_experience SET tempat_berkerja='$tempat_berkerja', tarikh_mula=STR_TO_DATE('$tarikh_mula','%d/%m/%Y'), tarikh_akhir=STR_TO_DATE('$tarikh_akhir','%d/%m/%Y'), 
				gaji='$gaji', jawatan='$jawatan', peranan='$peranan'
				WHERE id = '$pemohon_exp_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	 //padam maklumat pengalaman permohonan perjawatan

	function delExperienceJawatan($pemohon_exp_id) {
		$conn=db();
		$sql = "DELETE FROM pmohon_experience WHERE id = '$pemohon_exp_id'";
		$result = $conn->query($sql);
		return $result;
	}

	//kemaskini skill bagi permohonan perjawatan
	function editSkillJawatan($pemohon_skill_id,$skill,$level) {
		$conn=db();
		$sql = "UPDATE pmohon_skill SET skill='$skill', level='$level'
				WHERE id = '$pemohon_skill_id'";
		$result = $conn->query($sql);
		return $result;
	}
	//padam skill permohonan perjawatan
	function delSkillJawatan($pemohon_skill_id) {
		$conn=db();
		$sql = "DELETE FROM pmohon_skill WHERE id = '$pemohon_skill_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
   //kemaskini maklumat family permohonan perjawatan
	function editFamilyJawatan($pemohon_fmly_id,$nama,$phone,$pekerjaan,$hubungan) {
		$conn=db();
		$sql = "UPDATE pmohon_family SET nama='$nama', phone='$phone', pekerjaan='$pekerjaan', hubungan='$hubungan'
				WHERE id = '$pemohon_fmly_id'";
		$result = $conn->query($sql);
		return $result;
	}

	//padam maklumat keluarga permohonan perjawatan
	function delFamilyJawatan($pemohon_fmly_id) {
		$conn=db();
		$sql = "DELETE FROM pmohon_family WHERE id = '$pemohon_fmly_id'";
		$result = $conn->query($sql);
		return $result;
	}

	//lampir cv and resume for perjawatan
	function addResumeCV($pemohon_id,$document_resume,$nama_document_resume,$document_cv,$nama_document_cv,$document,$nama_document){
		$conn=db();
		$sql="INSERT INTO resume_cv(pemohon_id,document_resume,nama_document_resume,document_cv,nama_document_cv)
			  VALUES('$pemohon_id','$document_resume','$nama_document_resume','$document_cv','$nama_document_cv')";
		$result = $conn->query($sql);

		$sql2="UPDATE pmohon_education SET document='$document', nama_document='$nama_document' WHERE pemohon_id='$pemohon_id'";
		$result2 = $conn->query($sql2);
		  return $result;
    }
	
	//iklan
	
	    function addPenawaranJawatan2($role,$keterangan,$tarikh_mula,$tarikh_akhir,$company_id) {
		$conn=db();
		 $sql = "INSERT INTO penawaran_jawatan (role,keterangan,tarikh_mula,tarikh_akhir,company_id) 
		            VALUES ('$role',?,STR_TO_DATE('$tarikh_mula','%d/%m/%Y'), STR_TO_DATE('$tarikh_akhir','%d/%m/%Y'),$company_id)";
		
		$stmt = $conn->prepare($sql) or die($conn->error);
		$stmt->bind_param("s",$keterangan);
		
		$stmt->execute();
		$result = $stmt->insert_id;
		$stmt->close();
		
		return $result;
		//return $conn->insert_id;
	}
	
	
     function editPenawaranJawatan($id,$role,$keterangan,$tarikh_mula,$tarikh_akhir) {
		$conn=db();
		$sql = "UPDATE penawaran_jawatan SET role='$role', keterangan=?, tarikh_mula=STR_TO_DATE('$tarikh_mula','%d/%m/%Y'), tarikh_akhir=STR_TO_DATE('$tarikh_akhir','%d/%m/%Y') WHERE id = $id ";
		
		$stmt = $conn->prepare($sql) or die($conn->error);
		$stmt->bind_param("s",$keterangan);
		$stmt->execute();
		//$result = $stmt->insert_id;
		$stmt->close();
		return true;
		//$result = $conn->query($sql);
		//return $result;
	}
	
	
	function delPenawaranJawatan($penawaran_jawatan_id) {
		$conn=db();
		$sql = "DELETE FROM penawaran_jawatan WHERE id = '$penawaran_jawatan_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getLogPenawaranJawatan() {
		$conn=db();
		$sql = "SELECT pj.*, r.role AS jenis_role
                FROM penawaran_jawatan pj
                LEFT JOIN role r
                ON r.code=pj.role 
                WHERE CURRENT_DATE BETWEEN tarikh_mula  AND tarikh_akhir AND pj.status=1 ";
		$result = $conn->query($sql);
		return $result;
	}
	
	
	function  activePenawaranJawatan($penawaran_jawatan_id,$status) {
		$conn=db();
		$sql = "UPDATE penawaran_jawatan SET status= $status WHERE id = $penawaran_jawatan_id";
       	$result = $conn->query($sql);
		return $result;
	}
	
	
	
	
	
	//peranan
	function addPeranan($code,$role,$role_group_id,$slip_gaji,$status_pelulus_cuti) {
		$conn=db();
		$sql = "INSERT INTO role (code,role,role_group_id,slip_gaji,status_pelulus_cuti)
				VALUES('$code','$role','$role_group_id','$slip_gaji','$status_pelulus_cuti')";
		$result = $conn->query($sql);
		return $conn->insert_id;
	}
	
	
	 function editPeranan($id,$code,$role,$role_group_id,$slip_gaji,$status_pelulus_cuti) {
		$conn=db();
		 $sql = "UPDATE role SET code='$code',role='$role',role_group_id='$role_group_id',slip_gaji='$slip_gaji',status_pelulus_cuti='$status_pelulus_cuti'
	    WHERE id = '$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	
	function delPeranan($role_id) {
		$conn=db();
		$sql = "DELETE FROM role WHERE id = '$role_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	function  activePeranan($role_id,$status) {
		$conn=db();
		$sql = "UPDATE role SET status= $status WHERE id = $role_id";
       	$result = $conn->query($sql);
		return $result;
	}
	
	function getPerananAct($id) {
		$conn=db();
		$sql = "SELECT *
				FROM role WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	
	
	
	
	//Jenis Peranan
		function getJenisRole() {
		$conn=db();
		$sql = "SELECT * FROM role";
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($list  = $result -> fetch_assoc()){
		$txt_result .= "<option value=\"".$list['code']."\">".$list['role']." </option>";
		}
		return $txt_result;
	}
	
	
	function getJenisPeranan() {
		$conn=db();
		$sql = "SELECT * FROM role";
		$result = $conn->query($sql);
		return $result;
	}

	
	
	
	
	function getPenJawatan() {
		$conn=db();
		$sql = "SELECT pj.*,r.role AS peranan,rg.role_group_name
		FROM penawaran_jawatan pj
		LEFT JOIN role r 
		ON r.code=pj.role
		LEFT JOIN role_group rg ON rg.id=r.role_group_id
		group by pj.id
		ORDER BY pj.status DESC,pj.tarikh_akhir DESC";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getBilPemohon($iklan_id) {
		$conn=db();
		$sql = "SELECT COUNT(DISTINCT(noic)) AS cnt FROM pemohon WHERE iklan_id='$iklan_id' ";
		$result = $conn->query($sql);
		return $result;
	}
	
	
	function getPenawaranJaw($id) {
		$conn=db();
		$sql = "SELECT *
				FROM penawaran_jawatan WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	
	function getCompanyname($id) {
		$conn=db();
		$sql = "SELECT name FROM company WHERE id='$id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	
	
		function getPeranan() {
		$conn=db();
		$sql = "SELECT r.*,rg.role_group_name
				FROM role r
				LEFT JOIN role_group rg ON rg.id=r.role_group_id
				WHERE r.status='1' AND rg.status='1' ";
		$result = $conn->query($sql);
		return $result;
	}
	
	function getPerananEdit($id) {
		$conn=db();
		$sql = "SELECT r.*,rg.role_group_name
				FROM role r
				LEFT JOIN role_group rg ON rg.id=r.role_group_id
				WHERE r.id='$id' AND r.status='1' AND rg.status='1' ";
		$result = $conn->query($sql);
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
	//function running no offer intern
	function getRunning_NoOfferIntern($reference) {
		$conn=db();
		$new_running_no='';
		if ($reference=='pemohon_id'){
		$new_running_no='IND/INTERN/OFFER/';
		}else if($reference=='no_slip'){
		$new_running_no='SG';
		}
		
		$sql= " SELECT LPAD(running_no, 4, '0') AS running_no FROM running_no WHERE reference='$reference'";
        $run_no = $conn->query($sql)->fetch_object()->running_no ;
		$staff_number =$new_running_no.$run_no;
	
	//update running no
	
	$sql8 = "UPDATE running_no SET running_no=running_no+1 WHERE reference='$reference'";
	$result = $conn->query($sql8);
	
	return $staff_number;
	
	
		}
		//function running no offer perjawatan
	function getRunning_NoOfferPenjawatan($reference) {
		$conn=db();
		$new_running_no='';
		if ($reference=='pemohon_id'){
		$new_running_no='IND/STAFF/OFFER/';
		}else if($reference=='no_slip'){
		$new_running_no='SG';
		}
		
		$sql= " SELECT LPAD(running_no, 4, '0') AS running_no FROM running_no WHERE reference='$reference'";
        $run_no = $conn->query($sql)->fetch_object()->running_no ;
		$staff_number =$new_running_no.$run_no;
	
	//update running no
	
	$sql8 = "UPDATE running_no SET running_no=running_no+1 WHERE reference='$reference'";
	$result = $conn->query($sql8);
	
	return $staff_number;
	
	
		}
		//function running no  intern temuduga
		function getRunning_NoTemuduga($reference) {
		$conn=db();
		$new_running_no='';
		if ($reference=='pemohon_id'){
		$new_running_no='IND/INTERN/TMDG/';
		}
		
		
		
		$sql= " SELECT LPAD(running_no, 4, '0') AS running_no FROM running_no WHERE reference='$reference'";
        $run_no = $conn->query($sql)->fetch_object()->running_no ;
		$staff_number =$new_running_no.$run_no;
	
	//update running no
	
	$sql8 = "UPDATE running_no SET running_no=running_no+1 WHERE reference='$reference'";
	$result = $conn->query($sql8);
	
	return $staff_number;
	
	
		}
		
		//function running no tamat intern
		function getRunning_NoTmtIntern($reference) {
		$conn=db();
		$new_running_no='';
		if ($reference=='pemohon_id'){
		$new_running_no='IND/INTERN/TMT/';
		}else if($reference=='no_slip'){
		$new_running_no='SG';
		}
		
		$sql= " SELECT LPAD(running_no, 4, '0') AS running_no FROM running_no WHERE reference='$reference'";
        $run_no = $conn->query($sql)->fetch_object()->running_no ;
		$staff_number =$new_running_no.$run_no;
	
	//update running no
	
	$sql8 = "UPDATE running_no SET running_no=running_no+1 WHERE reference='$reference'";
	$result = $conn->query($sql8);
	
	return $staff_number;
	
	
		}
		
		
		function isRoledplct($role) {
		$conn=db();
		$sql = "SELECT * FROM role WHERE role='$role'" ;
		$result = $conn->query($sql);
		$duplicate=$result->num_rows;
		return $duplicate;
	}
	
	function getPemohonStatus($id) {
    $conn=db();
    $sql = "SELECT * FROM status_pemohon WHERE code='DLMPOHON' ";
    $result = $conn->query($sql);
    
    return $result;
  }
		
		
	function getStaffRecord($id) {
		$conn=db();
		$sql = "SELECT sr.*, r.code as myperanan,r.role as myjawatan 
        		FROM staff_record sr
        		LEFT JOIN role r ON r.code=sr.peranan 
        		WHERE sr.no_staff='$id' ORDER BY sr.id desc";
		$result = $conn->query($sql)->fetch_assoc();
		return $result;
	}


	
	
	function getStaffInfo($no_staff) {
    $conn=db();
     $sql = "SELECT s.*,sr.*,r.role,ss.desc 
            FROM staff s
            LEFT JOIN role r ON s.role_id=r.code 
            LEFT JOIN status_staff ss ON s.status=ss.code 
            LEFT JOIN staff_record sr ON s.no_staff=sr.no_staff
            LEFT JOIN department d ON d.code_department=s.department_id 
            WHERE s.no_staff='$no_staff'";
    $result = $conn->query($sql)->fetch_assoc();
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
    
    function getRecStart($nostaff) {
	$conn=db();
	$sql = "SELECT DATE_FORMAT(tarikh_mula,'%d/%m/%Y') AS tarikh_mula,peranan,department,gaji,sah_jawatan,DATE_FORMAT(tarikh_sah_jawatan,'%d/%m/%Y') AS tarikh_sah_jawatan  
	        FROM staff_record 
	        WHERE no_staff='$nostaff' 
	        ORDER BY tarikh_mula ASC 
	        LIMIT 1";
	$result = $conn->query($sql);
	return $result;
}

function getRecEnd($nostaff) {
	$conn=db();
	$sql = "SELECT DATE_FORMAT(tarikh_akhir,'%d/%m/%Y') AS tarikh_akhir,peranan,department,gaji,DATE_FORMAT(tarikh_akhir,'%Y') AS tahun_berhenti  
	        FROM staff_record 
	        WHERE no_staff='$nostaff' 
	        ORDER BY tarikh_mula DESC 
	        LIMIT 1";
	$result = $conn->query($sql);
	return $result;
}
    
    
    
	
	$conn->close();
	
?>