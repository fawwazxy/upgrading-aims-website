<?php
include "../model/library_functions.php";

require_once('../../lib/spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
require_once('../../lib/spreadsheet-reader-master/SpreadsheetReader.php');

//$id_sesi = clean($_POST['id_sesi']);
$created_by = clean($_POST['created_by']);
 
       
  $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["csv_file"]["type"],$allowedFileType)){

        $targetPath = '../../elibrary/koleksi_buku/'.$_FILES['csv_file']['name'];
        move_uploaded_file($_FILES['csv_file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        
        for($i=0;$i<$sheetCount;$i++)
        {
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Key => $Row)
            {
                if ($Key< 5) continue;
          		$id_jenis = $Row[0];
				$nama = $Row[1];
				$topik = $Row[2];
                $subtopik = $Row[3];
                $penerbit = $Row[4];
                $tahun_terbitan = $Row[5];
                $pengarang = $Row[6];
                $isbn = $Row[7];
                $keyword = $Row[8];
                $keterangan = $Row[9];
                $status_naskah = $Row[10];
                $bilangan_naskah = $Row[11];
                $lokasi_naskah = $Row[12];
                $jilid = $Row[13];
                $status_pinjam = $Row[14];

                $result = addLibraryExcel($id_jenis,$nama,$topik,$subtopik,$penerbit,$tahun_terbitan,$pengarang,$isbn,$keyword,$keterangan,$status_naskah,$bilangan_naskah,$lokasi_naskah,$jilid,$status_pinjam,$created_by);
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
            window.location.href='../view/library_kandungan_senarai.php';
            </script>");
        //header("location: ../view/library_kandungan_senarai.php");
        exit();
	}
	else
	{ 
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
  	}

?>