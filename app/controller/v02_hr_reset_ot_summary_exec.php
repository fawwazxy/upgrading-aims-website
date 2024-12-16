<?php
include "../model/v02_aims_ot_function.php";

$id = $_GET['id'];

$result = v02resetSummaryTable($id);

//Check whether the query was successful or not
if($result!="" && $result > 0){
    echo ("<script>
            alert('Successfully reset table.')
            window.history.back();
            </script>");
    exit();
}else{
    echo ("<script>
            alert('Failed to reset table. Please contact IT Department')
            window.history.back();
            </script>");
    exit();
}
