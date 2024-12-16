<?php
session_start();
require "../../lib/db/connection.php";

require_once('../../lib/spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
require_once('../../lib/spreadsheet-reader-master/SpreadsheetReader.php');

function icNumberIsExist($ic_number){
    $sql = "SELECT COUNT(id) as count  FROM temp_staff WHERE staff_ic = '$ic_number'";
    $count = db()->query($sql)->fetch_object()->count;
    return $count > 0;
}

function addTempStaff($id, $staff_ic, $staff_no){
    $sql = "INSERT INTO temp_staff (id, staff_ic, staff_no) VALUES ('$id','$staff_ic','$staff_no')";
    $result = db()->query($sql);

    return ($result) ? 'true' : db()->error;
}

$fail_to_insert = array();
$success = 0;
$failed = 0;
$count_row = 0;

$allowedFileType = ['application/vnd.ms-excel', 'text/csv', 'text/xls', 'text/xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
if (in_array($_FILES["csv_file"]["type"], $allowedFileType)) {

    $excel_name = date("Ymd_His_") . $_FILES['csv_file']['name'];
    $targetPath = '../../resources/upload/' . $excel_name;
    move_uploaded_file($_FILES['csv_file']['tmp_name'], $targetPath);

    try {
        $reader = new SpreadsheetReader($targetPath);
    } catch (Exception $e) {
        die("We encounter some problems when executing Class SpreadsheetReader()<br>".$e);
    }

    $sheetCount = count($reader->sheets());

    for ($i = 0; $i < $sheetCount; $i++) {
        $reader->ChangeSheet($i);
        $count_row = 1;
        foreach ($reader as $key => $row) {
            if ($key > 0){
                $id = $row[0];
                $staff_ic = str_replace("-", "", $row[1]);
                $staff_no = $row[2];

                $icNumberIsExist = icNumberIsExist($staff_ic);

                if ($icNumberIsExist){
                    $fail_to_insert[] = [$id, $staff_ic, $staff_no];
                    $failed++;
                }else{
                    $query_run = addTempStaff($id, $staff_ic, $staff_no);

                    if($query_run == 'true'){
                        $success++;
                    }else{
                        $failed++;
                        $fail_to_insert[] = [$id, $staff_ic, $staff_no, $query_run];
                    }
                }
                $count_row++;
            }
        }
    }

    echo "Total read: ".$count_row."<br>";
    echo "Total success: ".$success."<br>";

    if ($failed > 0){
        echo "Failed: ".$failed."<br><br>";
        foreach ($fail_to_insert as $fail){
            print_r($fail);
            echo "<br><br>";
        }
    }

    echo '<br><br><br><a href="../view/overwrite_staff_no.php" style="font-size: 32px; font-weight: bold">Back</a>';

//    echo "<script>
//            alert('You will redirected to previous page.')
//            window.history.back();
//            </script>";

} else {
    die("Error: Invalid File Type. Please upload an Excel/CSV File Format.");
}