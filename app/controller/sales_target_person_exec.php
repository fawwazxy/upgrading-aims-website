<?
	include "../model/sales_target_function.php";

 $action = $_GET['act'];

if ($action == "sales_target_person_add"){
	//$id=($_GET['id_project']);
	
	 $no_staff =$_POST['no_staff'];
	 $target =$_POST['target'];
	 $tahun =$_POST['tahun'];
	 $company_id =$_POST['company_id'];

	$result = addSalesTarget($no_staff, $target, $tahun,$company_id);

	//Check whether the query was successful or not
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/sales_target_person.php?status=1&flagScreen=tab_1';
            </script>");
		//header("location: ../view/sales_target_person.php?status=1&flagScreen=tab_1");
		exit();
	}else {
		echo "<script> alert('Proses tidak berjaya.'); location.href = '../view/sales_target_person.php?status=1&flagScreen=tab_1';</script>";
			exit();
	}


}else if($action == "sales_target_person_status"){
		$sales_target_id= ($_GET['id']);
		$status= ($_GET['status']);
	
    $result = updateStatusSalesTarget($status,$sales_target_id);
      
	//Check whether the query was successful or not
	if($result) {
		if($status==1){
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/sales_target_person.php?status=0&flagScreen=tab_2';
            </script>");
		 //header("location: ../view/sales_target_person.php?status=0&flagScreen=tab_2");
		}else if($status==0){
			echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/sales_target_person.php?status=1&flagScreen=tab_1';
            </script>");
		 //header("location: ../view/sales_target_person.php?status=1&flagScreen=tab_1");
		 }
		exit();
		
	}else {
		die("Query failed");
	}
	

}

?>