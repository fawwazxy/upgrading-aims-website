<?php
//Start session
session_start();

//Unset the variables stored in session
unset($_SESSION['SESS_ID']);
unset($_SESSION['SESS_USERNAME']);
unset($_SESSION['SESS_NAME']);
unset($_SESSION['SESS_EMAIL']);
session_destroy();

echo ("<script type='text/javascript'>
        window.location.href='../view/login.php';
        </script>");