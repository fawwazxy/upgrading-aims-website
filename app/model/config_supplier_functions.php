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
	
	function getCompanyDetails($sys_id) {
		$conn=db();
		$sql = "SELECT * FROM company WHERE sys_id='$sys_id'";
		$result = $conn->query($sql);
		return $result;
	}

	function login($username,$password) {
		$conn=db();
		$sql = "SELECT * FROM staff WHERE username='$username' AND accs_pwd='$password' AND status='BEKERJA'";
		$result = $conn->query($sql);
		return $result;
	}
	
		
	function getLogUser($com_id) {
		$conn=db();
		$sql = "SELECT * FROM staff WHERE company_id='$com_id'";
		$result = $conn->query($sql);
		return $result;
	}
	//config_supplier
    function getDropDownPembekal($supplier) {

		$conn=db();
		 $sql = "SELECT supplier_code, concat(supplier_code,'-',company_name) FROM supplier where status=1";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option ".($row[0] == $supplier ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
		}
		//$conn->close();
		return $txt_result;
	}

	function getCategory() {
		$conn=db();
		$sql = "SELECT distinct(category) FROM lkp_config_category WHERE status=1";
		$result = $conn->query($sql);
		return $result;
	}

	function getSubCategory($category) {
		$conn=db();
		$sql = "SELECT distinct(sub_category) FROM lkp_config_category WHERE status=1 and category='$category'";
		$result = $conn->query($sql);
		return $result;
	}

	function getSubCategoryItem($supplier_code,$category,$sub_category) {
		$conn=db();
		$sql = "SELECT lcc.*,cs.id AS cs_id FROM lkp_config_category lcc
		LEFT JOIN config_supplier cs ON lcc.category=cs.category 
		AND lcc.sub_category=cs.sub_category AND lcc.item_code=cs.item_code 
		AND cs.supplier_code='$supplier_code' AND cs.status=1
		WHERE lcc.status=1 AND lcc.category='$category' 
		AND lcc.sub_category='$sub_category' order by lcc.item_code asc";
		$result = $conn->query($sql);
		return $result;
	}

	function addSubCategoryItem($supplier_code,$lkp_id) {
		$conn=db();
		//get lkp_config_category data
		$sql = "select * from lkp_config_category where id='$lkp_id' ";
		$lkpcc = $conn->query($sql)->fetch_object();

		$sql = "select * from config_supplier where supplier_code='$supplier_code' 
		and category='$lkpcc->category' AND sub_category='$lkpcc->sub_category' 
		AND item_code='$lkpcc->item_code'";
		$config_supplier = $conn->query($sql)->fetch_object();

		if($config_supplier->id==""){
			//insert new
			$sql = "insert into config_supplier (supplier_code,category,sub_category,item,item_code,uom)
			select '$supplier_code',category,sub_category,item,item_code,uom from lkp_config_category where id='$lkp_id' ";
			$intable = $conn->query($sql) or die($conn->error);

		}else{
			//update
			$sql = "update config_supplier set status=1 where id='$config_supplier->id' ";
			$intable = $conn->query($sql) or die($conn->error);
		}

		return $result;
	}

	function subCategoryItemInactive($supplier_code,$category){
		$conn=db();
		$sql = "UPDATE config_supplier set status='0' WHERE supplier_code='$supplier_code' and category='$category'";
		
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	//end config_supplier

	//config_stage
    function getDropDownStage($stage) {

		$conn=db();
		 $sql = "SELECT concat(stage,'~',task), concat(stage,'-',task) FROM lkp_config_stage where status=1";
		
		$result = $conn->query($sql);
		
		$txt_result="";
		while ($row  = $result -> fetch_array()){
			$txt_result .= "<option ".($row[0] == $stage ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
		}
		//$conn->close();
		return $txt_result;
	}

	// function getCategory() {
	// 	$conn=db();
	// 	$sql = "SELECT distinct(category) FROM lkp_config_category WHERE status=1";
	// 	$result = $conn->query($sql);
	// 	return $result;
	// }

	// function getSubCategory($category) {
	// 	$conn=db();
	// 	$sql = "SELECT distinct(sub_category) FROM lkp_config_category WHERE status=1 and category='$category'";
	// 	$result = $conn->query($sql);
	// 	return $result;
	// }

	function getSubCategoryStage($stage,$category,$sub_category) {
		$conn=db();
		$sql = "SELECT lcc.*,cs.id AS cs_id FROM lkp_config_category lcc
		LEFT JOIN config_stage cs ON lcc.category=cs.category 
		AND lcc.sub_category=cs.sub_category AND lcc.item_code=cs.item_code 
		AND concat(cs.stage,'~', cs.task) = '$stage' AND cs.status=1
		WHERE lcc.status=1 AND lcc.category='$category' 
		AND lcc.sub_category='$sub_category' order by lcc.item_code asc";
		$result = $conn->query($sql);
		return $result;
	}

	function addSubCategoryStage($stage,$lkp_id) {
		$conn=db();
		$my_stages = explode("~",$stage);
			$vstage = $my_stages[0];
			$vtask = $my_stages[1];
		//get lkp_config_category data
		$sql = "select * from lkp_config_category where id='$lkp_id' ";
		$lkpcc = $conn->query($sql)->fetch_object();

		$sql = "select id from config_stage where stage='$vstage' AND task = '$vtask'
		and category='$lkpcc->category' AND sub_category='$lkpcc->sub_category' 
		AND item_code='$lkpcc->item_code'";
		$config_stage = $conn->query($sql) or die($conn->error);
		//echo '~~~'.$config_stage->num_rows.'~~~~';
		if($config_stage->num_rows==0){
			//insert new
			$sql = "insert into config_stage (stage,task,category,sub_category,item,item_code,uom)
			select '$vstage','$vtask',category,sub_category,item,item_code,uom from lkp_config_category where id='$lkp_id' ";
			$intable = $conn->query($sql) or die($conn->error);

		}else{
			$cs_id = $config_stage->fetch_object()->id;
			//update
			$sql = "update config_stage set stage='$vstage',task='$vtask',status=1 where id='$cs_id' ";
			$intable = $conn->query($sql) or die($conn->error);
		}

		return $result;
	}

	function subCategoryStageInactive($stage,$category){
		$conn=db();
		$sql = "UPDATE config_stage set status='0' WHERE concat(stage,'~', task) = '$stage' and category='$category'";
		
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	//end config_stage
	
	$conn->close();
	
?>