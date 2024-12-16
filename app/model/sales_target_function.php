<?php
	require '../../lib/db/connection.php';

	// Function to sanitize values received from the form. Prevents SQL injection
	
	
	$action=$_POST['action'];
	if($action == "sales_target_person_update"){
			 $sales_target_id = $_POST['id'];
			 $no_staff = $_POST['no_staff'];
			 $target = $_POST['target'];
			 $tahun = $_POST['tahun'];
				//$status= $_POST['status'];

	$result = updateSalesTarget($sales_target_id,$no_staff, $target, $tahun);
	}
	
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
		$sql = "SELECT * FROM sys_setting";
		if ($sys_id!='') {
			$sql .= " WHERE sys_id='$sys_id'";
		}
		$result = $conn->query($sql);
		return $result;
	}
	
	function addSalesTarget($no_staff, $target, $tahun,$company_id){
		$conn=db();
		//checking - no staff telah wujud pada tahun tersebut
		$sql2 = "SELECT * FROM sales_target_person WHERE no_staff='$no_staff' AND tahun='$tahun' ";
		$check = $conn->query($sql2);
		if($check->num_rows > 0 ){
			echo ("<script lANGUAGE='JavaScript'>
			window.alert('Tambah data tidak berjaya. Data telah wujud.');
			window.location.href='../view/sales_target_person.php?status=1&flagScreen=tab_1';
			</script>");
		}else{
		 $sql = "INSERT INTO sales_target_person (no_staff, sales_target_yearly, tahun, company_id) 
					VALUES ('$no_staff', '$target', '$tahun','$company_id')";
		$result = $conn->query($sql);
		}
		return $result;
	}

  function getSalesTargetPerson($status) {
    $conn=db();
	$sql = "SELECT stp.*,s.name FROM sales_target_person stp
			LEFT JOIN staff s ON stp.no_staff=s.no_staff
			WHERE stp.status = $status
			ORDER BY stp.id DESC";  
    $result = $conn->query($sql);
    return $result;
  }
	function updateSalesTarget($sales_target_id,$no_staff, $target, $tahun){
		$conn=db();
		//checking - no staff telah wujud pada tahun tersebut
		 $sql2 = "SELECT * FROM sales_target_person WHERE no_staff='$no_staff' AND tahun='$tahun' AND id!='$sales_target_id'";
		$check = $conn->query($sql2);
		if($check->num_rows > 0 ){
			echo ("<script LANGUAGE='JavaScript'>
					window.alert('Kemaskini tidak berjaya. Data telah wujud.');
					window.location.href='../view/sales_target_person.php?status=1&flagScreen=tab_1';
					</script>");
		}else{
		$sql = "UPDATE sales_target_person SET no_staff='$no_staff', sales_target_yearly='$target', tahun='$tahun' 
				WHERE id='$sales_target_id'";
		$result = $conn->query($sql);
		return $result;
		}
		
	}
	
	
	function getNoStaff() {
    $conn=db();
	   $sql = "SELECT no_staff, name FROM staff
				WHERE status='BEKERJA' AND noic IS NOT NULL
				ORDER BY no_staff ASC";  
    $result = $conn->query($sql);
    return $result;
  }
  
  function  updateStatusSalesTarget($status,$sales_target_id) {
		$conn=db();
	    $sql = "UPDATE sales_target_person SET status = '$status' WHERE id='$sales_target_id'";
		$result = $conn->query($sql);
		return $result;
	}
	
	
	$conn->close();
	
?>