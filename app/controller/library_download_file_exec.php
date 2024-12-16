<?php
    include "../model/library_functions.php";

$action = $_GET['action'];
if($action == "elibrary"){
    $id=clean($_GET['id']);
    $result = getLibraryInfo($id)->fetch_object();
    $name =$result -> document_file;
    $dir = "../../elibrary/document/";
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
                    window.alert('Fail tidak wujud');
                    window.location.href='../view/library_kandungan_senarai.php';
                    </script>");
        exit();
    }
}else if($action == "terjemahan"){
    $id_terjemahan=clean($_GET['id_terjemahan']);
    $result = getTerjemahanById($id_terjemahan)->fetch_object();
    $name =$result -> document_file;
    $dir = "../../elibrary/document/";
    $file = $dir . $name;

    if(file_exists($file) && !empty($name))
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
                    window.alert('Fail tidak wujud');
                    window.location.href='../view/library_kandungan_senarai.php';
                    </script>");
        exit();
    }
}





 //- the missing closing brace
?>