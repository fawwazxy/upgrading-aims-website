<?php
    include "../model/acara_functions.php";
  
$id=clean($_GET['id']);
$result = getSumberKandungan($id) -> fetch_object();
$name =$result -> kandungan_filename;
$dir = "../../acara/sumber/";
$file = $dir . $name;

if (file_exists($file))
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
    }
 //- the missing closing brace
?>