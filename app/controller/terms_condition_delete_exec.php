<?php
include "../model/terms_condition_function.php";

$id = clean($_GET['id']);
$result = deleteTerms($id);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    echo ("<script>
			alert('Terms & Condition successfully deleted');
			window.history.back();
			</script>");
} else {
    echo ("<script>
			alert('Terms & Condition to deleted');
			window.history.back();
			</script>");
}









