<?php
session_start();
include "../model/staff_function.php";

require_once('../../lib/spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
require_once('../../lib/spreadsheet-reader-master/SpreadsheetReader.php');

$company_id = clean($_POST['company_id']);
$shortcode = clean($_POST['shortcode']);
$cawangan_kod = clean($_POST['cawangan_kod']);
$back_href = ($_SESSION['SESS_DEPARTMENT_SUB'] == 'HR-SEA')? 'staff_info_hr_sea.php':'staff_info.php';

$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

if(in_array($_FILES["csv_file"]["type"],$allowedFileType)){

    $targetPath = '../../resources/items/data_staf.xlsx';
    move_uploaded_file($_FILES['csv_file']['tmp_name'], $targetPath);

    $Reader = new SpreadsheetReader($targetPath);

    $sheetCount = count($Reader->sheets());

    for($i=0;$i<$sheetCount;$i++)
    {
        $Reader->ChangeSheet($i);
        $m=1;
        $tm=1;
        foreach ($Reader as $Key => $Row)
        {
            if ($Key< 5) continue;
            $noic = $Row[0];
            $nama = $Row[1];
            $username = $Row[2];
            $password = $Row[3];
            $phone = $Row[4];
            $email = $Row[5];
            $alamat_tetap = $Row[6];
            $alamat_surat = $Row[7];
            $umur = $Row[8];
            $martial_status = $Row[9];
            $tanggungan = $Row[10];
            $gender = $Row[11];
            $pantau_kehadiran = $Row[12];
            $result = addStaffExcel($shortcode,$noic,$nama,$username,$password,$phone,$email,$alamat_tetap,$alamat_surat,$umur,$martial_status,$tanggungan,$gender,$pantau_kehadiran,$company_id,$cawangan_kod);
            if($result){
                $masuk=$m++;

            }else{
                $tmasuk=$tm++;

            }
        }
    }

    echo '<script type="text/javascript">
       window.alert("Data Berjaya Di Muatnaik : '.$masuk.'\nData Tidak Berjaya Di Muatnaik  : '.$tmasuk.'");
       window.location.href="../view/'.$back_href.'";
       </script>';
    // header("location: ../view/staff_info.php");
    //exit();
}
else {
    $type = "error";
    $message = "Invalid File Type. Upload Excel File.";
}
?>