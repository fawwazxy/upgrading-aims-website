<?php

    require '../../lib/db/connection.php';

    $action = $_POST['action'];

    // Function to sanitize values received from the form. Prevents SQL injection
    function clean($str) {
        $conn=db();
        $str = @trim($str);
        if(get_magic_quotes_gpc()) {
            $str = stripslashes($str);
        }
        return mysqli_real_escape_string($conn,$str);
    }

    function getSys($sys_id) {
        $conn=db();
        $sql = "SELECT s.*,c.short_name FROM sys_setting s LEFT JOIN company c ON c.sys_id=s.sys_id WHERE s.sys_id='$sys_id'";
        $result = $conn->query($sql);
        return $result;
    }

    function addNewTerms($title, $description, $file_path, $imagePath){
        $conn=db();

        $sql="INSERT INTO company_documents (title, description, file_path, thumbnail_path) 
            VALUES ('$title', '$description', '$file_path','$imagePath')";
        $result = $conn->query($sql);
        return $result;
    }

    function getTerms(){
        $conn=db();
        $sql=" SELECT * FROM company_documents";
        $result=$conn->query($sql);
        return $result;
    }

function deleteTerms($id){
    $conn=db();
    $sql = "DELETE FROM company_documents WHERE id ='$id'";
    return $conn->query($sql);
}

function updateTerms($id, $title, $description){
    $conn=db();
    $sql = "UPDATE company_documents SET title = '$title', description = '$description' WHERE id = '$id'";
    return $conn->query($sql);
}

function getTermsById($id){
    $conn=db();
    $sql=" SELECT * FROM company_documents WHERE id='$id'";
    return $conn->query($sql);
}

?>