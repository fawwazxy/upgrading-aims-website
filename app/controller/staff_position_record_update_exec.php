<?php
include "../model/staff_function.php";

$record_id = $_POST['record_id'];
$bank_name = $_POST['bank_name'];
$notes = $_POST['notes'];
$account_no = $_POST['account_no'];
$salary= $_POST['salary'];

$result = staffRecordUpdate($record_id,$bank_name,$notes,$account_no,$salary);

if ($result != "" && $result > 0) {
    echo("<script type='text/javascript'>
            alert('Berjaya kemaskini maklumat gaji')
            history.back();
            </script>");
    exit();
} else {
    echo("<script type='text/javascript'>
            alert('Gagal kemaskini maklumat gaji')
            history.back();
            </script>");
    exit();
}