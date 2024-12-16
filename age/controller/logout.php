<?php
	
	//Start session
	session_start();
	
	//Unset the variables stored in session
	unset($_SESSION['SESS_ID']);
	unset($_SESSION['SESS_USERNAME']);
	unset($_SESSION['SESS_NAME']);
	unset($_SESSION['SESS_EMAIL']);
	echo ("<script LANGUAGE='JavaScript'>
            window.location.href='../view/login.php';
            </script>");
	//header("location: ../view/login.php");
	
?>