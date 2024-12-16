<?php
include "../model/acara_functions.php";

require_once('../../lib/spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
require_once('../../lib/spreadsheet-reader-master//SpreadsheetReader.php');

$id_sesi = clean($_POST['id_sesi']);
$created_by = clean($_POST['created_by']);
echo $id_kumpulan = clean($_POST['id_kumpulan']);
 
       
  $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["csv_file"]["type"],$allowedFileType)){

        $targetPath = '../../acara/data_peserta/'.$_FILES['csv_file']['name'];
        move_uploaded_file($_FILES['csv_file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        
        for($i=0;$i<$sheetCount;$i++)
        {
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
          		$nokp = $Row[0];
				$nama = $Row[1];
				$notel = $Row[2];
                $result = addPesertaExcel($id_sesi,$nokp,$nama,$notel,$id_kumpulan,$created_by);
                if (! empty($result)) {
                    $type = "success";
                    $message = "Excel Data Imported into the Database";
                } else {
                    $type = "error";
                    $message = "Problem in Importing Excel Data";
                }
            
            }
        
        }
        echo ("<script LANGUAGE='JavaScript'>
                    window.location.href='../view/acara_peserta_senarai.php?id_sesi=$id_sesi';
                    </script>");
        //header("location: ../view/acara_peserta_senarai.php?id_sesi=$id_sesi");
        exit();
	}
	else
	{ 
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
  	}

?>