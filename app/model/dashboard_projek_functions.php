<?php

	require '../../lib/db/connection.php';
    
    $action = $_POST['action'];
    //lookup kumpulan (add,update,delete)
    if($action == "kumpulanAddEdit"){
		$nama_kumpulan = $_POST['nama_kumpulan'];
		$id_kumpulan = $_POST['id_kumpulan'];

		$conn=db();
		if($id_kumpulan > 0 ){
			$sql = "UPDATE lkp_projek_kumpulan SET nama_kumpulan = '$nama_kumpulan'  WHERE id_kumpulan = '$id_kumpulan'";
			$result = $conn->query($sql) or die($conn->error);
			echo "Data berjaya dikemaskini";
		}else{
			$sql = "INSERT INTO lkp_projek_kumpulan (nama_kumpulan) VALUES ('$nama_kumpulan')";
			$result = $conn->query($sql) or die($conn->error);
			echo "Data berjaya ditambah";
		}
	}
	//lookup kategori (add,update,delete)
    else if($action == "kategoriAddEdit"){
    	$code = $_POST['code'];
		$nama_kategori = $_POST['nama_kategori'];
		$id_kategori = $_POST['id_kategori'];

		$conn=db();
		if($id_kategori > 0 ){
			$sql = "UPDATE lkp_task_kategori SET nama_kategori = '$nama_kategori'  WHERE id_kategori = '$id_kategori'";
			$result = $conn->query($sql) or die($conn->error);
			echo "Data berjaya dikemaskini";
		}else{
			$sql = "INSERT INTO lkp_task_kategori (code,nama_kategori) VALUES ('$code','$nama_kategori')";
			$result = $conn->query($sql) or die($conn->error);
			echo "Data berjaya ditambah";
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

	//projek -start-
	function projekAdd($kod_projek,$nama_projek,$jenis_projek,$kod_projek_parent,$nama_client,$negeri,$negara,$tarikh_mula,$tarikh_tamat,$catatan,$created_by){
		$conn=db();
		$sql = "INSERT INTO projek_internal (kod_projek,nama_projek,jenis_projek,kod_projek_parent,nama_client,negeri,negara,tarikh_mula,tarikh_tamat,catatan,created_by) VALUES ('$kod_projek','$nama_projek','$jenis_projek','$kod_projek_parent','$nama_client','$negeri','$negara','$tarikh_mula','$tarikh_tamat','$catatan','$created_by')";
		$result = $conn->query($sql);
		return $result;
	}

	function projekEdit($id_projek,$nama_projek,$jenis_projek,$kod_projek_parent,$nama_client,$negeri,$negara,$tarikh_mula,$tarikh_tamat,$catatan){
		$conn=db();
		if($id_projek > 0 ) {
			$sql = "UPDATE projek_internal SET nama_projek = '$nama_projek', jenis_projek = '$jenis_projek', kod_projek_parent = '$kod_projek_parent', nama_client = '$nama_client', negeri = '$negeri', negara = '$negara', tarikh_mula = '$tarikh_mula', tarikh_tamat = '$tarikh_tamat', catatan = '$catatan' WHERE id_projek = '$id_projek'";
		}
		$result = $conn->query($sql);
		return $result;
	}

	function getDropDownKodProjek($tablename,$value,$text,$selected,$kod_projek_parent) {
		$conn=db();
		$sql = "SELECT ".$value.",".$text." FROM $tablename WHERE kod_projek_parent = ''";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
		}
		//$conn->close();
		return $txt_result;
	}

	function getMainProjekList() {
		$conn=db();
		$sql = "SELECT * FROM projek_internal WHERE kod_projek_parent = '' 
				ORDER BY id_projek DESC";
		$result = $conn->query($sql);
		return $result;
	}

	function getSubProjekList($main_projek_id) {
		$conn=db();
		$sql = "SELECT * FROM projek_internal WHERE kod_projek_parent = '$main_projek_id'
				ORDER BY id_projek ASC";
		$result = $conn->query($sql);
		return $result;
	}

	function getProjekInfoById($id_projek) {
		$conn=db();
		$sql = "SELECT * FROM projek_internal WHERE id_projek = '$id_projek'";
		$result = $conn->query($sql);
		return $result;
	}
	//projek -end-

	//lookup kumpulan -start-
	function getKumpulanList() {
		$conn=db();
		$sql = "SELECT * FROM lkp_projek_kumpulan ORDER BY id_kumpulan ASC";
		$result = $conn->query($sql);
		return $result;
	}	
	//lookup kumpulan -end-

	//lookup kategori -start-
	function getKategoriList() {
		$conn=db();
		$sql = "SELECT * FROM lkp_task_kategori ORDER BY id_kategori ASC";
		$result = $conn->query($sql);
		return $result;
	}
	//lookup kategori -end-


	$conn->close();
	
?>