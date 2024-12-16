<?php

	require '../../lib/db/connection.php';
	session_start();

	$action=$_POST['action'];

	if ($action=="add_sale_target") {
		$dataArray = $_POST['dataArray'];
		
		if(empty($dataArray)){
	    	//echo("Sila tanda pada kotak yang disediakan.");
	  	} else {
		    $N = count($dataArray);

		    //echo("You selected $N door(s): ");

		    if($N == 12){
		    	addSalesTarget($dataArray);
		    }

		    
		
		}
        echo("Data berjaya diproses");

	}

	function tofloat($num) {
	    $dotPos = strrpos($num, '.');
	    $commaPos = strrpos($num, ',');
	    $sep = (($dotPos > $commaPos) && $dotPos) ? $dotPos : 
	        ((($commaPos > $dotPos) && $commaPos) ? $commaPos : false);
	   
	    if (!$sep) {
	        return floatval(preg_replace("/[^0-9]/", "", $num));
	    } 

	    return floatval(
	        preg_replace("/[^0-9]/", "", substr($num, 0, $sep)) . '.' .
	        preg_replace("/[^0-9]/", "", substr($num, $sep+1, strlen($num)))
	    );
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

	function getSalesTarget($company_id) {
		$conn=db();
		$sql = "select * from sales_target WHERE company_id='$company_id'";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}

	function addSalesTarget($dataArray) {
		$conn=db();
		$company_id = $_SESSION['SESS_COM'];
		$sql = "INSERT INTO `sales_target` (`target_year`, `target_monthly_overhead`,target_yearly_overhead, `target_profit`, `target_profit_margin`, `target_cost_margin`, `target_monthly_bep`,`target_yearly_bep`, `target_monthly_bep_profit`,  `target_yearly_bep_profit`, `target_monthly_sale`, `target_yearly_sale`,  `company_id`)
			VALUES
			('".tofloat($dataArray[0])."', '".tofloat($dataArray[1])."', '".tofloat($dataArray[2])."]', '".tofloat($dataArray[3])."', '".tofloat($dataArray[4])."', 
			'".tofloat($dataArray[5])."', '".tofloat($dataArray[6])."', '".tofloat($dataArray[7])."', '".tofloat($dataArray[8])."', '".tofloat($dataArray[9])."', 
			'".tofloat($dataArray[10])."', '".tofloat($dataArray[11])."', '$company_id');
";
		$result = $conn->query($sql) or die($conn->error);
		return $result;
	}


	$conn->close();
?>