<?php
	include "../model/aims_carReserve_function.php";
	$name = $_GET['name'];
	//Start session
    session_start();
	
	//Sanitize the POST values
	$username = clean($_POST['username']);
	$password = clean($_POST['password']);
	
	//Call function
	$login = login($username,$password)->fetch_assoc();
	

		if ($login['username'] == 'AIMS') {
			echo ("<script LANGUAGE='JavaScript'>
		    window.location.href='../view/../view/aims_carinspection_list_bycompany.php?name=$name';
            </script>");
			//header("location: ../view/dashboard.php");
			exit();
		}

		
		else if ($login['username'] == 'ADMIN') {
			echo "<script LANGUAGE='JavaScript'>
			window.location.href='../view/../view/aims_carinspection_list_bycompany_admin.php';
            </script>";
			//header("location: ../view/dashboard.php");
			exit();
		}
		
		else {
		$fail = 'Log Masuk Gagal.\nNama atau Kata Laluan salah.';
		echo "<script> alert(\"$fail\"); location.href = '../view/aims_car_login.php';</script>";
		exit();
		}
		
		
	 
	
	//$conn->close();
?>