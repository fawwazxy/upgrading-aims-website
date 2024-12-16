<?php
    ini_set('session.gc_maxlifetime', 36000);
	//Start session
	session_start();
	
	//Check whether the session variable SESS_ID is present or not
	if(!isset($_SESSION['SESS_ID']) || (trim($_SESSION['SESS_ID']) == '')) {
		//header("location: login.php");
		echo ("<script type='text/javascript'>
						window.location.href='/aims/app/view/login.php';
						</script>");
		exit();
	}  
	
?>
