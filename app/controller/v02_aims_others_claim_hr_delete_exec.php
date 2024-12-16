<?php

include "../model/v02_aims_others_claim_function.php";

$id = $_GET['id'];

$search_file = v02getDocumentName($id)->fetch_object()->document_name;
$result =  v02DeleteClaim($id);
$result2 = v02deleteTypeClaimByClaimId($id);
$result3 = v02financeUseByClaimId($id);

if($result) {
    if (!empty($search_file)){
        unlink("../../othersclaimphoto/".$search_file);
    }
    echo ("<script type='text/javascript'>
            alert('Claim successfully delete.')
            history.back();
            </script>");
    exit();
} else {
    echo ("<script type='text/javascript'>
            alert('Failed to delete claim.')
            history.back();
            </script>");
    exit();
}