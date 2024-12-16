<?php
    include "../model/aims_hr_function.php";


    $id=clean($_GET['id']);
    $result = getLibraryInfo($id)->fetch_object();
    $name =$result -> document_name;
    $dir = "../../hrform/";
    $file = $dir . $name;

    if (file_exists($file) && !empty($name))
    {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($file));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        exit;
    }else{
        echo ("<script lANGUAGE='JavaScript'>
                    window.alert('File did not exist!');
                    window.location.href='../view/aims_hrform_list.php';
                    </script>");
        exit();
    }






 //- the missing closing brace
?>