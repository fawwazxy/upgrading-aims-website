<?php
include "../model/v02_aims_ot_function.php";

$remark = clean($_POST['remark']);
$id = clean($_POST['id']);

$result = v02remarkOtPermission($id,$remark);

//Check whether the query was successful or not
if($result!="" && $result > 0){
    echo ("<script>
            alert('Successfully added remark');
            window.history.back();
            </script>");
    exit();
}else{
    echo ("<script>
            alert('Failed to added remark');
            window.history.back();
            </script>");
    exit();
}

