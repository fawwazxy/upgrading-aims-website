<?php
     include "../model/claim_function.php";
  
    $id = clean($_GET['id']);
    // $id = clean($_POST['id']);
   
   
   
  


  
  
  $result = updateStatusTarikhTuntutan($id);
  
  //Check whether the query was successful or not
  if($result) 
  
  {
    echo ("<script LANGUAGE='JavaScript'>
                    window.location.href='../view/tarikh_tuntutan.php';
                    </script>");
  //header("location: ../view/tarikh_tuntutan.php");
  exit();
  }
  else 
  {
    die("Query failed");
  }
  
?>
?>