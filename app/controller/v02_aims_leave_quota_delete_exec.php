<?php
include "../model/v02_aims_leave_function.php";

$id = clean($_GET['id']);
$result = deleteLeaveQuota($id);

//Check whether the query was successful or not
if($result!="" && $result > 0) {
    echo ("<script>
			alert('Kuota cuti pekerja berjaya dipadam');
			window.history.back();
			</script>");
} else {
    echo ("<script>
			alert('Gagal untuk memadam kuota cuti pekerja');
			window.history.back();
			</script>");
}









