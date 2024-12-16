<?php

    $file_path = "photos/";

    $file_path = $file_path . basename( $_FILES['uploaded_file']['name']);
    $title =$_FILES['title'];
    //$descr=$file_path . basename( $_FILES['uploaded_file']['desc']);
    if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path)) {
        echo "success";
    } else{
        echo "fail";
    }
    $name=$_FILES['uploaded_file']['name'];
    
    echo "success";
 ?>