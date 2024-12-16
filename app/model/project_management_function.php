<?php

	require '../../lib/db/connection.php';

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

		
	function getPesananBelianDetails($no_staff) {
		$conn=db();
        $sql = "SELECT pb.*,sh.tajuk_sebut_harga, sh.agensi_rujukan, sh.nama_rujukan,sp.penerangan,s.name AS nama_pegawai_dalaman,s.phone AS notel_pegawai_dalaman
				FROM pesanan_belian pb
				LEFT JOIN sebut_harga sh
				ON pb.id_sebut_harga = sh.id_sebut_harga
				LEFT JOIN status_projek sp
				ON pb.status_penerimaan_tugas = sp.kod
				LEFT JOIN staff s
				ON pb.pegawai_dalaman = s.no_staff
				WHERE pb.ketua_projek='$no_staff' AND pb.status_penerimaan_tugas NOT IN ('TD')
				ORDER BY pb.id_pesanan_belian DESC ";
					
		$result = $conn->query($sql);
		return $result;
	}


	function updateStatusPenerimaanKerja($id){
		$conn=db();
		$sql = "UPDATE pesanan_belian
				SET status_penerimaan_tugas ='T'
				WHERE id_pesanan_belian= '$id'" ;
		$result = $conn->query($sql);
		return $result;
	}


	function updateStatusSelesaiKerja($id){
		$conn=db();
		$sql = "UPDATE pesanan_belian
				SET status_penerimaan_tugas ='SL'
				WHERE id_pesanan_belian= '$id'" ;
		$result = $conn->query($sql);
		return $result;
	}


	function updateStatusPenolakanKerja($id){
		$conn=db();
		$sql = "UPDATE pesanan_belian
				SET status_penerimaan_tugas ='TD'
				WHERE id_pesanan_belian= '$id'" ;
		$result = $conn->query($sql);
		return $result;
	}


	function getInfoPO($id_pesanan_belian){
		$conn=db();
		$sql= "SELECT pb.*, sh.norujukan_sebut_harga,sh.nama_rujukan, sh.agensi_rujukan, sh.tajuk_sebut_harga
				FROM pesanan_belian pb
				LEFT JOIN sebut_harga sh
				ON pb.id_sebut_harga  = sh.id_sebut_harga
				WHERE pb.id_pesanan_belian='$id_pesanan_belian'";
		$result = $conn->query($sql);
		return $result;
	}


	// function addProjek($id_pesanan_belian,$tarikh_mula,$tarikh_akhir,$jumlah_hari){
	// 	$conn=db();
	// 	$sql= "  INSERT INTO projek(id_pesanan_belian,tarikh_mula,tarikh_akhir,jumlah_hari)
	// 		    VALUES('$id_pesanan_belian',STR_TO_DATE('$tarikh_mula','%d/%m/%Y'),STR_TO_DATE('$tarikh_akhir','%d/%m/%Y'),'$jumlah_hari')";
	// 	$result = $conn->query($sql);

	// 	$sql2 = "UPDATE pesanan_belian SET status_penerimaan_tugas='SD' WHERE id_pesanan_belian='$id_pesanan_belian'";
	// 	$result = $conn->query($sql2);
	// 	return $result;
	// }

	function addProjek($id_pesanan_belian,$tarikh_mula,$tarikh_akhir,$jumlah_hari){
		$conn=db();
		$sql= " UPDATE pesanan_belian SET tarikh_mula=STR_TO_DATE('$tarikh_mula','%d/%m/%Y'), tarikh_akhir=STR_TO_DATE('$tarikh_akhir','%d/%m/%Y'), jumlah_hari='$jumlah_hari', status_penerimaan_tugas='SD'
				WHERE id_pesanan_belian='$id_pesanan_belian' ";
		$result = $conn->query($sql);

		return $result;
	}


	function getMaklumatProjek($id_pesanan_belian){
		$conn=db();
		$sql="SELECT * FROM projek WHERE id_pesanan_belian='$id_pesanan_belian'";
		$result = $conn->query($sql);
		return $result;
		$default= $result-> fetch_assoc();
	
	}


	function getProjekList($no_staff) {
		$conn=db();
        $sql = "SELECT pb.*, sh.tajuk_sebut_harga,sh.nama_rujukan, sh.agensi_rujukan,sp.penerangan
				FROM pesanan_belian pb
				LEFT JOIN sebut_harga sh
				ON pb.id_sebut_harga =  sh.id_sebut_harga
				LEFT JOIN status_projek sp
				ON pb.status_penerimaan_tugas = sp.kod
				WHERE pb.ketua_projek='$no_staff' AND pb.status_penerimaan_tugas='SD' ";
									
		$result = $conn->query($sql);
		return $result;
	}


	function getProjekSelesai($no_staff) {
		$conn=db();
        $sql = "SELECT pb.*, sh.tajuk_sebut_harga,sh.nama_rujukan, sh.agensi_rujukan,sp.penerangan
				FROM pesanan_belian pb 
				LEFT JOIN sebut_harga sh
				ON pb.id_sebut_harga =  sh.id_sebut_harga
				LEFT JOIN status_projek sp
				ON pb.status_penerimaan_tugas = sp.kod
				WHERE pb.ketua_projek='$no_staff' AND pb.status_penerimaan_tugas='SL' ";
									
		$result = $conn->query($sql);
		return $result;
	}


	function getAhliList($id_projek){
		$conn=db();
		$sql="SELECT ak.*, s.name AS nama_ahli
				FROM ahli_kumpulan ak
				LEFT JOIN staff s
				ON ak.ahli_kumpulan = s.no_staff
				WHERE ak.id_projek='$id_projek'";
		$result = $conn->query($sql);
		return $result;
	}


	function getAhliUtkProjek($id_projek){
		$conn=db();
		$sql = "SELECT *FROM ahli_kumpulan WHERE id_projek='$id_projek'";
		$result = $conn->query($sql);
		return $result;
	}


	function getJadualUtkProjek($id_projek){
		$conn=db();
		$sql = "SELECT * FROM jadual_projek WHERE id_projek='$id_projek'";
		$result = $conn->query($sql);
		return $result;
	}


	function getFileRujukan($id_pesanan_belian){
		$conn=db();
		$sql="SELECT pb.*
			FROM pesanan_belian pb
			WHERE pb.id_pesanan_belian='$id_pesanan_belian'";
		$result = $conn->query($sql); 
		return $result;
	}


	function getProjekDetailsById($id){
		$conn=db();
		$sql="  SELECT pb.*,sh.tajuk_sebut_harga, sh.agensi_rujukan, sh.nama_rujukan,s.name AS nama_pegawai_dalaman,ss.name AS nama_ketua_projek
				FROM pesanan_belian pb
				LEFT JOIN sebut_harga sh ON pb.id_sebut_harga = sh.id_sebut_harga
				LEFT JOIN staff s ON pb.pegawai_dalaman = s.no_staff
				LEFT JOIN staff ss ON pb.ketua_projek = ss.no_staff
				WHERE pb.id_pesanan_belian='$id'";
		$result = $conn->query($sql); 
		return $result;
	}


	
	function addPerananProjek($id_projek,$nama_peranan,$id_peringkat){
		$conn=db();
		$sql="  INSERT INTO peranan_projek(id_projek,nama_peranan,id_peringkat)
				VALUES ('$id_projek','$nama_peranan','$id_peringkat')";
		$result = $conn->query($sql); 
		return $result;
	}


	function getPeringkatPeranan(){
		$conn=db();
		$sql="  SELECT * FROM peringkat_peranan";
		$result = $conn->query($sql); 
		return $result;
	}


	function getPerananByProjek($id_projek){
		$conn=db();
		$sql="  SELECT pp.*,pr.description
				FROM peranan_projek pp
				LEFT JOIN peringkat_peranan pr
				ON pp.id_peringkat = pr.id
				WHERE pp.id_projek='$id_projek' AND pp.id_peringkat NOT IN 
				(SELECT ppr.id
				FROM ahli_kumpulan ak
				LEFT JOIN peranan_projek ppj
				ON ak.id_peranan =  ppj.id
				LEFT JOIN peringkat_peranan ppr
				ON ppj.id_peringkat = ppr.id
				WHERE ppr.id='1' AND ak.id_projek='$id_projek')
				ORDER BY pp.id_peringkat ASC";
		$result = $conn->query($sql); 
		return $result;
	}

	function getPerananByProjekForEdit($id_projek){
		$conn=db();
		$sql="  SELECT pp.*, pr.description
				FROM peranan_projek pp
				LEFT JOIN peringkat_peranan pr
				ON pp.id_peringkat = pr.id
				WHERE pp.id_projek='$id_projek'
				ORDER BY pp.id_peringkat ASC";
		$result = $conn->query($sql); 
		return $result;
	}


	function getPerananProjek($id_projek){
		$conn=db();
		$sql="  SELECT pp.*, pr.description
				FROM peranan_projek pp
				LEFT JOIN peringkat_peranan pr
				ON pp.id_peringkat = pr.id
				WHERE pp.id_projek='$id_projek'";
		$result = $conn->query($sql); 
		return $result;
	}


	function deletePerananProjek($id) {
    	$conn=db();
    	$sql = "DELETE FROM peranan_projek WHERE id='$id' ";
        $result = $conn->query($sql);
		return $result;
	}


	function getPegawai() {
	    $conn=db();
	    $sql = "SELECT s.*, d.description AS nama_bahagian
				FROM staff s
				LEFT JOIN department d
				ON s.department_id = d.code_department
				 ";
	    $result = $conn->query($sql);
	    return $result;
  	}


  	function getNamaPegawai($id_projek) {
	    $conn=db();
	    $sql = "SELECT ps.*,s.name,s.no_staff
				FROM projek_staff ps
				LEFT JOIN staff s
				ON ps.pekerja = s.no_staff
				WHERE ps.id_projek = '$id_projek' AND ps.pekerja NOT IN (SELECT ak.nama_ahli FROM ahli_kumpulan ak WHERE ak.id_projek='$id_projek')";
	    $result = $conn->query($sql);
	    return $result;
  	}

  	function getNamaPegawaiForEdit($id_projek) {
	    $conn=db();
	    $sql = "SELECT ps.*,s.name,s.no_staff
				FROM projek_staff ps
				LEFT JOIN staff s
				ON ps.pekerja = s.no_staff
				WHERE ps.id_projek = '$id_projek'";
	    $result = $conn->query($sql);
	    return $result;
  	}

  	function addAhliProjek($id_projek,$nama_ahli,$id_peranan){
		$conn=db();
		 $sql="  INSERT INTO ahli_kumpulan(id_projek,nama_ahli,id_peranan)
				VALUES ('$id_projek','$nama_ahli', '$id_peranan')";
		$result = $conn->query($sql); 
		return $result;
	}


	function addJadual($id_projek,$fasa,$mula,$akhir){
		$conn=db();
		$sql="  INSERT INTO jadual_projek(id_projek,fasa,mula,akhir)
				VALUES ('$id_projek','$fasa', '$mula','$akhir')";
		$result = $conn->query($sql); 
		return $result;
	}



function addProgress($id_projek,$tarikh,$perkembangan,$jadual_projek_id,$created_by){
		$conn=db();
		$sql="  INSERT INTO perkembangan_kerja_projek(id_projek,tarikh,perkembangan,
		jadual_projek_id,created_by)
				VALUES ('$id_projek',STR_TO_DATE('$tarikh','%d/%m/%Y'), '$perkembangan'
			,'$jadual_projek_id','$created_by')";
		$result = $conn->query($sql) or die($conn->error); 
		return $result;
	}


	function getAhliByProjek($id_projek){
		$conn=db();
		$sql="  SELECT ak.*, pp.nama_peranan,s.name
				FROM ahli_kumpulan ak
				LEFT JOIN peranan_projek pp
				ON ak.id_peranan = pp.id
				LEFT JOIN staff s
				ON ak.nama_ahli = s.no_staff
				WHERE ak.id_projek='$id_projek'
				ORDER BY pp.id_peringkat ASC";
		$result = $conn->query($sql); 
		return $result;
	}


	function getSenaraiAhliMengikutProjek($id_projek){
		$conn=db();
		$sql="  SELECT pp.*,ak.nama_ahli,s.name
				FROM peranan_projek pp
				LEFT JOIN ahli_kumpulan ak
				ON pp.nama_peranan = ak.peranan_projek
				LEFT JOIN staff s
				ON  ak.nama_ahli= s.no_staff
				WHERE pp.id_projek='$id_projek'
				ORDER BY pp.peringkat ASC";
		$result = $conn->query($sql); 
		return $result;
	}


	function deleteAhliProjek($id) {
    	$conn=db();
    	$sql = "DELETE FROM ahli_kumpulan WHERE id='$id' ";
        $result = $conn->query($sql);
		return $result;
	}


	function deleteJadual($id) {
    	$conn=db();
    	$sql = "DELETE FROM jadual_projek WHERE id='$id' ";
        $result = $conn->query($sql);
		return $result;
	}


	function getSenaraiAhli($id) {
    	$conn=db();
    	$sql = "				
SELECT ak.*,pp.nama_peranan,pr.description,s.*
FROM ahli_kumpulan ak
LEFT JOIN peranan_projek pp
ON ak.id_peranan = pp.id
LEFT JOIN peringkat_peranan pr
ON pp.id_peringkat = pr.id
LEFT JOIN staff s
ON ak.nama_ahli = s.no_staff
WHERE ak.id_projek='$id'
ORDER BY pr.id ASC ";
        $result = $conn->query($sql);
		return $result;
	}


	function getNama($id,$peranan_projek) {
    	$conn=db();
    	$sql = "SELECT ak.*,s.name,d.description
				FROM ahli_kumpulan ak
				LEFT JOIN staff s
				ON ak.nama_ahli = s.no_staff
				LEFT JOIN department d
				ON s.department_id = d.code_department
				WHERE ak.peranan_projek='$peranan_projek' AND ak.id_projek='$id'";
        $result = $conn->query($sql);
		return $result;
	}


	function getSebuthargaIfo($id){
	    $conn=db();
		$sql = "SELECT * FROM sebut_harga where id_sebut_harga='$id' ";
		$result = $conn->query($sql);
		return $result;
	}


	function getCompany() {
		$conn=db();
		$sql = "SELECT * FROM company";
		$result = $conn->query($sql);
		return $result;
	}


	function getJadual($id) {
			$conn=db();
			$sql = "SELECT * FROM jadual_projek WHERE id_projek='$id' GROUP BY mula";
			$result = $conn->query($sql);
			return $result;
	}

	function getJadual2($id) {
			$conn=db();
			$sql = "SELECT * FROM jadual_projek WHERE id_projek='$id' ORDER BY mula ASC";
			$result = $conn->query($sql);
			return $result;
	}


	function getPerananById($id) {
			$conn=db();
			$sql = "SELECT * FROM  peranan_projek WHERE id='$id'";
			$result = $conn->query($sql);
			return $result;
	}


	function editPerananProjek($nama_peranan,$peringkat,$id){
		$conn=db();
		$sql="  UPDATE peranan_projek 
				SET nama_peranan='$nama_peranan', peringkat='$peringkat'
				WHERE id='$id'";
		$result = $conn->query($sql); 
		return $result;
	}


	function editPerananProjek2($nama_peranan,$id_peringkat,$id){
		$conn=db();
		$sql="  UPDATE peranan_projek 
				SET nama_peranan='$nama_peranan',id_peringkat='$id_peringkat'
				WHERE id='$id'";
		$result = $conn->query($sql); 
		return $result;
	}

	function editJadualProjek($fasa,$mula,$akhir,$mula_sebenar,$akhir_sebenar,$id){
		$conn=db();
		$sql="  UPDATE jadual_projek
				SET fasa='$fasa', mula='$mula', akhir='$akhir',mula_sebenar='$mula_sebenar',akhir_sebenar='$akhir_sebenar'
				WHERE id='$id'";
		$result = $conn->query($sql); 
		return $result;
	}


function editAhliProjek($id_peranan,$nama_ahli,$id){
		$conn=db();
		$sql="  UPDATE ahli_kumpulan 
				SET nama_ahli='$nama_ahli', id_peranan='$id_peranan'
				WHERE id='$id'";
		$result = $conn->query($sql); 
		return $result;
	}

	function getStaffList() {
	    $conn=db();
	    $sql = "SELECT s.*,d.description AS department_name,r.role AS role_name 
			    FROM staff s
			    LEFT JOIN department d
			    ON d.code_department=s.department_id
			    LEFT JOIN role r
			    ON s.role_id=r.code
			    WHERE s.status='BEKERJA' AND s.noic IS NOT NULL " ;
	    $result = $conn->query($sql);
	    return $result;
    }

   function checkCheckbox($no_staff,$id_projek){
        $conn=db();
     	$sql = "SELECT * FROM projek_staff WHERE pekerja='$no_staff' AND id_projek='$id_projek'";

    	$result = $conn->query($sql);
    	$row=$result->num_rows;

    	if($row>0){
     		return "checked";

    	} else{


      		return " ";
    	}
    }


    function addPekerjaForProject($id_projek,$pekerja){

	   $conn=db();
	   $sql="INSERT INTO projek_staff (id_projek,pekerja) VALUES ('$id_projek','$pekerja')";
       $result = $conn->query($sql);
       return $result;
	}


	function deleteStaff($id_projek){
     	$conn=db();
     	$sql= "DELETE FROM projek_staff WHERE id_projek='$id_projek'";
     	$result = $conn->query($sql);
     	return $result;

    }


    function getAhliForEdit($id){
     	$conn=db();
     	$sql= "SELECT * FROM ahli_kumpulan WHERE id='$id'";
     	$result = $conn->query($sql);
     	return $result;

    }


    function getJadualForEdit($id){
     	$conn=db();
     	$sql= "SELECT * FROM jadual_projek WHERE id='$id'";
     	$result = $conn->query($sql);
     	return $result;

    }


    function getInfoProjek($id){
     	$conn=db();
     	$sql= "SELECT pb.*,sh.tajuk_sebut_harga,sh.nama_rujukan,sh.agensi_rujukan,ld.*
				FROM pesanan_belian pb
				LEFT JOIN sebut_harga sh
				ON pb.id_sebut_harga = sh.id_sebut_harga
				LEFT JOIN lead ld
				ON sh.id_lead = ld.id
				WHERE pb.id_pesanan_belian='$id'";
				     	$result = $conn->query($sql);
     	return $result;

    }


    function getGanttChart($id){
     	$conn=db();
     	$sql= "SELECT * FROM jadual_projek WHERE id_projek='$id' ORDER BY mula";
				     	$result = $conn->query($sql);
     	return $result;

    }

    function getPerkembanganProjek($id) {
			$conn=db();
			$sql = "SELECT pkp.*, s.name FROM perkembangan_kerja_projek pkp
			LEFT JOIN staff s ON pkp.created_by = s.no_staff 
			WHERE pkp.id_projek='$id' ORDER BY pkp.created_date DESC ";
			$result = $conn->query($sql);
			return $result;
	}


	function getPeringkatInfo($id) {
			$conn=db();
			$sql = "SELECT * FROM peranan_projek WHERE id='$id'";
			$result = $conn->query($sql);
			return $result;
	}

	function getDropDownFasa($id) {
		$conn=db();
		 $sql = "SELECT id,fasa FROM jadual_projek WHERE id_projek='$id'";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option value=\"".$row[0]."\">".$row[1]." </option>";
		}
		//$conn->close();
		return $txt_result;
	}

	function getCountPerkembanganKerja($id_projek,$jadual_projek_id,$yearmonth) {
		$conn=db();
		 $sql = "select count(id) as count from perkembangan_kerja_projek where id_projek='$id_projek' and jadual_projek_id='$jadual_projek_id' and DATE_FORMAT(created_date,'%Y%m') = '$yearmonth'";
		
		$result = $conn->query($sql);
		return $result->fetch_object()->count;
	}


	function getBulanAnalisa($id_projek) {
		$conn=db();
		 $sql = "select DATE_FORMAT(created_date,'%Y%m') as yearmonth,
		 		DATE_FORMAT(created_date,'%Y') as year,DATE_FORMAT(created_date,'%b') as month 
				from perkembangan_kerja_projek where id_projek='$id_projek' 
				group by  DATE_FORMAT(created_date,'%Y%m') ";
		
		$result = $conn->query($sql);
		return $result;
	}
	
	function getProjekYangTerlibat($no_staff) {
		$conn=db();
        $sql = "SELECT ps.*,pb.tarikh_mula,sh.nama_rujukan,sh.agensi_rujukan,sh.tajuk_sebut_harga,pb.tarikh_akhir,pb.id_pesanan_belian,
				pb.jumlah_hari,pb.status_penerimaan_tugas,sp.penerangan
				FROM projek_staff ps
				LEFT JOIN pesanan_belian pb
				ON ps.id_projek = pb.id_pesanan_belian
				LEFT JOIN sebut_harga sh
				ON pb.id_sebut_harga = sh.id_sebut_harga
				LEFT JOIN status_projek sp
				ON pb.status_penerimaan_tugas = sp.kod
				WHERE ps.pekerja = '$no_staff'";
													
		$result = $conn->query($sql);
		return $result;
	}


	function getPerkembanganProjekIndividu($id,$no_staff) {
			$conn=db();
			$sql = "SELECT * FROM perkembangan_kerja_projek
					WHERE id_projek ='$id' AND created_by='$no_staff' ORDER BY created_date DESC ";
			$result = $conn->query($sql);
			return $result;
	}

	function getNamaBukuLog($id,$no_staff) {
			$conn=db();
			$sql = "SELECT ps.*,s.name,s.noic
			FROM projek_staff ps
			LEFT JOIN staff s
			ON ps.pekerja=s.no_staff
			WHERE id_projek='$id' AND ps.pekerja='$no_staff' ";
			$result = $conn->query($sql);
			return $result;
	}

/*function addProgress($id_projek,$tarikh,$perkembangan,$created_by){
		$conn=db();
		echo $sql="  INSERT INTO perkembangan_kerja_projek(id_projek,tarikh,perkembangan,created_by)
				VALUES ('$id_projek',STR_TO_DATE('$tarikh','%d/%m/%Y'),?,'$created_by')";
		$stmt = $conn->prepare($sql) or die($conn->error);
    $stmt->bind_param("s",$perkembangan);
    
    $stmt->execute();
    $result = $stmt->insert_id;
    $stmt->close();
		return $result;
	}*/

function getTotalProject(){

 $conn=db();
$sql = "SELECT COUNT(status_penerimaan_tugas) AS countTotal
		FROM pesanan_belian";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotal;
return $results;

}


function getTotalSelesai(){

 $conn=db();
$sql = "SELECT COUNT(status_penerimaan_tugas) AS countTotalSelesai
FROM pesanan_belian
WHERE status_penerimaan_tugas='SL'
";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalSelesai;
return $results;

}

function getTotalDalamPelaksanaan(){

 $conn=db();
$sql = "SELECT COUNT(status_penerimaan_tugas) AS countTotalSelesai
FROM pesanan_belian
WHERE status_penerimaan_tugas='SD'
";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalSelesai;
return $results;

}

function getTotalDalamPenerimaann(){

 $conn=db();
$sql = "SELECT COUNT(status_penerimaan_tugas) AS countTotalSelesai
FROM pesanan_belian
WHERE status_penerimaan_tugas='DP'
";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalSelesai;
return $results;

}

function getWeekProject($start_week,$end_week){
  $conn=db();
    $sql = "SELECT COUNT(status_penerimaan_tugas) AS countTotalWeek
FROM pesanan_belian 
WHERE tarikh_jana_pesanan_belian BETWEEN '$start_week' AND '$end_week'

             ";
     $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalWeek;
return $results;

}

function getTotalJan(){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalJan,
DATE_FORMAT(pb.tarikh_jana_pesanan_belian,'%M') AS bulan
FROM pesanan_belian pb
WHERE MONTH(tarikh_jana_pesanan_belian) = '1' AND YEAR(tarikh_jana_pesanan_belian) = YEAR(CURDATE())";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalJan;
return $results;

}

function getTotalFeb(){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalJan,
DATE_FORMAT(pb.tarikh_jana_pesanan_belian,'%M') AS bulan
FROM pesanan_belian pb
WHERE MONTH(tarikh_jana_pesanan_belian) = '2' AND YEAR(tarikh_jana_pesanan_belian) = YEAR(CURDATE())";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalJan;
return $results;

}


function getTotalMarch(){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalJan,
DATE_FORMAT(pb.tarikh_jana_pesanan_belian,'%M') AS bulan
FROM pesanan_belian pb
WHERE MONTH(tarikh_jana_pesanan_belian) = '3' AND YEAR(tarikh_jana_pesanan_belian) = YEAR(CURDATE())";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalJan;
return $results;

}

function getTotalApril(){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalJan,
DATE_FORMAT(pb.tarikh_jana_pesanan_belian,'%M') AS bulan
FROM pesanan_belian pb
WHERE MONTH(tarikh_jana_pesanan_belian) = '4' AND YEAR(tarikh_jana_pesanan_belian) = YEAR(CURDATE())";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalJan;
return $results;

}

function getTotalMay(){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalJan,
DATE_FORMAT(pb.tarikh_jana_pesanan_belian,'%M') AS bulan
FROM pesanan_belian pb
WHERE MONTH(tarikh_jana_pesanan_belian) = '5' AND YEAR(tarikh_jana_pesanan_belian) = YEAR(CURDATE())";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalJan;
return $results;

}

function getTotalJune(){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalJan,
DATE_FORMAT(pb.tarikh_jana_pesanan_belian,'%M') AS bulan
FROM pesanan_belian pb
WHERE MONTH(tarikh_jana_pesanan_belian) = '6' AND YEAR(tarikh_jana_pesanan_belian) = YEAR(CURDATE())";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalJan;
return $results;

}

function getTotalJuly(){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalJan,
DATE_FORMAT(pb.tarikh_jana_pesanan_belian,'%M') AS bulan
FROM pesanan_belian pb
WHERE MONTH(tarikh_jana_pesanan_belian) = '7' AND YEAR(tarikh_jana_pesanan_belian) = YEAR(CURDATE())";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalJan;
return $results;

}


function getTotalAugust(){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalJan,
DATE_FORMAT(pb.tarikh_jana_pesanan_belian,'%M') AS bulan
FROM pesanan_belian pb
WHERE MONTH(tarikh_jana_pesanan_belian) = '8' AND YEAR(tarikh_jana_pesanan_belian) = YEAR(CURDATE())";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalJan;
return $results;

}


function getTotalSept(){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalJan,
DATE_FORMAT(pb.tarikh_jana_pesanan_belian,'%M') AS bulan
FROM pesanan_belian pb
WHERE MONTH(tarikh_jana_pesanan_belian) = '9' AND YEAR(tarikh_jana_pesanan_belian) = YEAR(CURDATE())";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalJan;
return $results;

}

function getTotalOct(){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalJan,
DATE_FORMAT(pb.tarikh_jana_pesanan_belian,'%M') AS bulan
FROM pesanan_belian pb
WHERE MONTH(tarikh_jana_pesanan_belian) = '10' AND YEAR(tarikh_jana_pesanan_belian) = YEAR(CURDATE())";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalJan;
return $results;

}

function getTotalNov(){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalJan,
DATE_FORMAT(pb.tarikh_jana_pesanan_belian,'%M') AS bulan
FROM pesanan_belian pb
WHERE MONTH(tarikh_jana_pesanan_belian) = '11' AND YEAR(tarikh_jana_pesanan_belian) = YEAR(CURDATE())";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalJan;
return $results;

}

function getTotalDec(){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalJan,
DATE_FORMAT(pb.tarikh_jana_pesanan_belian,'%M') AS bulan
FROM pesanan_belian pb
WHERE MONTH(tarikh_jana_pesanan_belian) = '12' AND YEAR(tarikh_jana_pesanan_belian) = YEAR(CURDATE())";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalJan;
return $results;

}


function getTotalTahun($tahun){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalDis  
FROM pesanan_belian pb
   WHERE  YEAR(tarikh_jana_pesanan_belian) = '$tahun' ";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalDis;
return $results;

}

function getAnalisaStatus(){

  $conn=db();
    $sql = "SELECT COUNT(*) AS countx, sp.penerangan
    FROM pesanan_belian pb
    LEFT JOIN status_projek sp
    ON pb.status_penerimaan_tugas = sp.kod
    GROUP BY CONCAT(sp.penerangan) ";
        $result = $conn->query($sql);
return $result;
}

/*---Function untuk analisa ketua projek---*/

function getMaklumatProjekUtkAnalisa($no_staff){
	$conn=db();
	$sql = "SELECT pb.*,s.name AS nama_ketua_projek
FROM pesanan_belian pb
LEFT JOIN staff s
ON pb.ketua_projek = s.no_staff
WHERE pb.ketua_projek = '$no_staff'";
	$result = $conn->query($sql);
	return $result;

}


function getTotalProjectByKetua($no_staff){

 $conn=db();
$sql = "SELECT COUNT(status_penerimaan_tugas) AS countTotal
		FROM pesanan_belian
		WHERE ketua_projek='$no_staff'";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotal;
return $results;

}

function getTotalSelesaiByKetua($no_staff){

 $conn=db();
$sql = "SELECT COUNT(status_penerimaan_tugas) AS countTotalSelesai
FROM pesanan_belian
WHERE status_penerimaan_tugas='SL' AND ketua_projek='$no_staff'
";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalSelesai;
return $results;

}

function getTotalDalamPelaksanaanByKetua($no_staff){

 $conn=db();
$sql = "SELECT COUNT(status_penerimaan_tugas) AS countTotalSelesai
FROM pesanan_belian
WHERE status_penerimaan_tugas='SD' AND ketua_projek='$no_staff'
";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalSelesai;
return $results;

}

function getTotalDalamPenerimaanByKetua($no_staff){

 $conn=db();
$sql = "SELECT COUNT(status_penerimaan_tugas) AS countTotalSelesai
FROM pesanan_belian
WHERE status_penerimaan_tugas='DP' AND ketua_projek='$no_staff'
";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalSelesai;
return $results;

}


function getWeekProjectByKetua($start_week,$end_week,$no_staff){
  $conn=db();
    $sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalWeek
FROM pesanan_belian pb
WHERE pb.ketua_projek='$no_staff' AND pb.tarikh_jana_pesanan_belian BETWEEN '$start_week' AND '$end_week'

             ";
     $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalWeek;
return $results;

}


function getTotalJanByKetua($no_staff){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalJan,
DATE_FORMAT(pb.tarikh_jana_pesanan_belian,'%M') AS bulan
FROM pesanan_belian pb
WHERE pb.ketua_projek='$no_staff' AND MONTH(tarikh_jana_pesanan_belian) = '1' AND YEAR(tarikh_jana_pesanan_belian) = YEAR(CURDATE())";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalJan;
return $results;

}

function getTotalFebByKetua($no_staff){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalJan,
DATE_FORMAT(pb.tarikh_jana_pesanan_belian,'%M') AS bulan
FROM pesanan_belian pb
WHERE MONTH(tarikh_jana_pesanan_belian) = '2' AND YEAR(tarikh_jana_pesanan_belian) = YEAR(CURDATE())";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalJan;
return $results;

}


function getTotalMarchByKetua($no_staff){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalJan,
DATE_FORMAT(pb.tarikh_jana_pesanan_belian,'%M') AS bulan
FROM pesanan_belian pb
WHERE pb.ketua_projek='$no_staff' AND MONTH(tarikh_jana_pesanan_belian) = '3' AND YEAR(tarikh_jana_pesanan_belian) = YEAR(CURDATE())";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalJan;
return $results;

}

function getTotalAprilByKetua($no_staff){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalJan,
DATE_FORMAT(pb.tarikh_jana_pesanan_belian,'%M') AS bulan
FROM pesanan_belian pb
WHERE pb.ketua_projek='$no_staff' AND MONTH(tarikh_jana_pesanan_belian) = '4' AND YEAR(tarikh_jana_pesanan_belian) = YEAR(CURDATE())";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalJan;
return $results;

}

function getTotalMayByKetua($no_staff){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalJan,
DATE_FORMAT(pb.tarikh_jana_pesanan_belian,'%M') AS bulan
FROM pesanan_belian pb
WHERE pb.ketua_projek='$no_staff' AND MONTH(tarikh_jana_pesanan_belian) = '5' AND YEAR(tarikh_jana_pesanan_belian) = YEAR(CURDATE())";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalJan;
return $results;

}

function getTotalJuneByKetua($no_staff){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalJan,
DATE_FORMAT(pb.tarikh_jana_pesanan_belian,'%M') AS bulan
FROM pesanan_belian pb
WHERE MONTH(tarikh_jana_pesanan_belian) = '6' AND YEAR(tarikh_jana_pesanan_belian) = YEAR(CURDATE())";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalJan;
return $results;

}

function getTotalJulyByKetua($no_staff){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalJan,
DATE_FORMAT(pb.tarikh_jana_pesanan_belian,'%M') AS bulan
FROM pesanan_belian pb
WHERE pb.ketua_projek='$no_staff' AND MONTH(tarikh_jana_pesanan_belian) = '7' AND YEAR(tarikh_jana_pesanan_belian) = YEAR(CURDATE())";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalJan;
return $results;

}


function getTotalAugustByKetua($no_staff){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalJan,
DATE_FORMAT(pb.tarikh_jana_pesanan_belian,'%M') AS bulan
FROM pesanan_belian pb
WHERE pb.ketua_projek='$no_staff' AND MONTH(tarikh_jana_pesanan_belian) = '8' AND YEAR(tarikh_jana_pesanan_belian) = YEAR(CURDATE())";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalJan;
return $results;

}


function getTotalSeptByKetua($no_staff){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalJan,
DATE_FORMAT(pb.tarikh_jana_pesanan_belian,'%M') AS bulan
FROM pesanan_belian pb
WHERE pb.ketua_projek='$no_staff' AND MONTH(tarikh_jana_pesanan_belian) = '9' AND YEAR(tarikh_jana_pesanan_belian) = YEAR(CURDATE())";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalJan;
return $results;

}

function getTotalOctByKetua($no_staff){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalJan,
DATE_FORMAT(pb.tarikh_jana_pesanan_belian,'%M') AS bulan
FROM pesanan_belian pb
WHERE pb.ketua_projek='$no_staff' AND MONTH(tarikh_jana_pesanan_belian) = '10' AND YEAR(tarikh_jana_pesanan_belian) = YEAR(CURDATE())";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalJan;
return $results;

}

function getTotalNovByKetua($no_staff){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalJan,
DATE_FORMAT(pb.tarikh_jana_pesanan_belian,'%M') AS bulan
FROM pesanan_belian pb
WHERE pb.ketua_projek='$no_staff' AND MONTH(tarikh_jana_pesanan_belian) = '11' AND YEAR(tarikh_jana_pesanan_belian) = YEAR(CURDATE())";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalJan;
return $results;

}

function getTotalDecByKetua($no_staff){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalJan,
DATE_FORMAT(pb.tarikh_jana_pesanan_belian,'%M') AS bulan
FROM pesanan_belian pb
WHERE pb.ketua_projek='$no_staff' AND MONTH(tarikh_jana_pesanan_belian) = '12' AND YEAR(tarikh_jana_pesanan_belian) = YEAR(CURDATE())";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalJan;
return $results;

}


function getTotalTahunByKetua($tahun,$no_staff){

 $conn=db();
$sql = "SELECT COUNT(pb.status_penerimaan_tugas) AS countTotalDis  
FROM pesanan_belian pb
   WHERE  pb.ketua_projek='$no_staff' AND YEAR(tarikh_jana_pesanan_belian) = '$tahun' ";
  $result = $conn->query($sql);
  $results =  $result->fetch_object()->countTotalDis;
return $results;

}

function getAnalisaStatusByKetua($no_staff){

  $conn=db();
    $sql = "SELECT COUNT(*) AS countx, sp.penerangan
    FROM pesanan_belian pb
    LEFT JOIN status_projek sp
    ON pb.status_penerimaan_tugas = sp.kod
    WHERE pb.ketua_projek='$no_staff'
    GROUP BY CONCAT(sp.penerangan) ";
        $result = $conn->query($sql);
return $result;
}

	$conn->close();

?>