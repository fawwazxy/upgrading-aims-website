<?php
    include "../model/acara_functions.php";
    $id=clean($_GET['id']);
    $result = getAturcaraAcara($id) -> fetch_object();
    $file = $result -> lagu_tema;
    $name =$result -> tajuk;
    $filename = $name.'.mp3';

    header('Content-type: application/mp3');
    header("Content-Disposition: attachment; filename=$filename");
    ob_clean();
    flush();
    echo $file;

?>