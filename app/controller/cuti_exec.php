<?php

include "../model/kehadiran_functions.php";
	
	 $id=clean($_GET['id']);
    $act=clean($_GET['act']);
    $perkara=clean($_POST['cuti']);
	$tarikh_cuti=clean($_POST['tarikh_cuti']);
    
	
    if($act=="add"){
		
	$result =  addCuti($perkara,$tarikh_cuti);
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/hari_cuti.php';
						</script>");
		//header("location: ../view/hari_cuti.php?");
		exit();
	}else {
		die("Query failed");
	}
    }
	else if($act=="updt"){
	$result =  updateMasaBekerja($id,$perkara,$tarikh_cuti);
	if($result) {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/hari_cuti.php';
						</script>");
		//header("location: ../view/hari_cuti.php?");
		exit();
	}else {
		die("Query failed");
	}	
	}
	else if($act == "uploadExcel"){
	require_once('../../lib/spreadsheet-reader-master/php-excel-reader/excel_reader2.php');
	require_once('../../lib/spreadsheet-reader-master/SpreadsheetReader.php');


	$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["csv_file"]["type"],$allowedFileType)){

        $targetPath = '../../resources/items/data_cuti.xlsx';
        move_uploaded_file($_FILES['csv_file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        $masuk=0;
        $tmasuk=0;
        for($i=0;$i<$sheetCount;$i++)
        {
            $Reader->ChangeSheet($i);
            $m=1;
            $tm=1;
            foreach ($Reader as $Key => $Row)
            {
                if ($Key< 1) continue;
          		$perkara = $Row[0];
				$tarikh_cuti = $Row[1];
				
               
                $result = addCuti($perkara,$tarikh_cuti);
                
            
            }
        
        }
       
       echo '<script type="text/javascript">
       window.location.href="../view/hari_cuti.php";
       </script>';
      // header("location: ../view/staff_info.php");
       //exit();
	}
	else
	{ 
        $type = "error";
        $message = "Invalid File Type. Upload Excel File.";
  	}
		

}
else{
		$result =  delCuti($id);
		if($result) {
		echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/hari_cuti.php';
						</script>");
		//header("location: ../view/hari_cuti.php?");
		exit();
	}else {
		die("Query failed");
	}
	}


?>