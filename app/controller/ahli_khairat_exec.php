<?
include "../model/ahli_functions.php";
	
$action=clean($_POST['action']);
if($action == "addEditKhairat"){
		$id=clean($_POST['id']);
		$nokp_ahli=clean($_POST['nokp_ahli']);
		$status=clean($_POST['status']);
		$created_by=clean($_POST['created_by']);
		$jum_khairat=clean($_POST['jum_khairat']);
		$tarikh=clean($_POST['tarikh']);
		$tahun=clean($_POST['tahun']);
		
		
		$result = addEditKhairat($id,$tahun,$nokp_ahli,$status,$created_by,$jum_khairat,$tarikh);

	
	if($result) {
		 echo ("<script LANGUAGE='JavaScript'>
		 				window.location.href='../view/ahli_senarai_kutipan_khairat.php?tahun=$tahun&status=$status';
		 				</script>");
		// //header("location: ../view/acara_senarai_aturcara.php?id_sesi=$id_sesi");
		exit();
	}else {
		die("Query failed");
	}
}else if($action == "addEditBiayaKhairat"){
		$id=clean($_POST['id']);
		$nokp_ahli=clean($_POST['nokp_ahli']);
		$created_by=clean($_POST['created_by']);
		$jum_khairat=clean($_POST['jum_khairat']);
		$tarikh=clean($_POST['tarikh']);
		$tahun=clean($_POST['tahun']);
		$nota=clean($_POST['nota']);
		
		$result = addEditBiayaKhairat($id,$tahun,$nokp_ahli,$jum_khairat,$tarikh,$nota,$created_by);

	
	if($result) {
		 echo ("<script LANGUAGE='JavaScript'>
		 				window.location.href='../view/ahli_senarai_biaya_khairat.php?tahun=$tahun';
		 				</script>");
		
		exit();
	}else {
		die("Query failed");
	}
}
?>