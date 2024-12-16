<?php

  include ('../controller/auth.php');

  require "../model/task_function.php";

?>

<?
 $pm_projek_id=$_GET['id'];
?> 
<html>
<head>
      <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">


</head>

<body>

 <form method="post" action="../controller/pm_projek_edit_exec.php?id=<? echo $pm_project_id; ?>" enctype="multipart/form-data" >
                           

                <? 
                   
                     $project_name = getProjectInfo($pm_projek_id)->fetch_assoc();
            
                 ?>
             </br>
                              <input name="id" type="hidden" class="input-short" value="<?  echo $_GET['id'];?>" />
                               
                          

                             <div class="form-group" align="left">
                                  <label>Nama Projek</label>
                                   <input class="form-control" placeholder=" " id="project_name" name="project_name" required autocomplete="" type="text" value="<? echo $project_name['project_name']; ?>">
                                </div>

                                
                                <div class="modal-footer">
                       <button type="submit" class="btn btn-primary" onclick="return alert('Data telah dikemaskini');">Simpan</button></a>
                        <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                            <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
                        </div>
                    </form>
</body>
</html>