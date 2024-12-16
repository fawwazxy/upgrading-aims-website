<?php
require "../model/v02_aims_medical_function.php";

$id = clean($_GET['id']);

$result = hrResetMedicalClaimVerification($id);

if($result == true) {
    echo ("<script type='text/javascript'>
            alert('Medical Claim has been reset');
                window.history.back();
                </script>");
}else {
    echo ("<script type='text/javascript'>
            alert('Failed to reset Medical Claim');
                window.history.back();
                </script>");
}