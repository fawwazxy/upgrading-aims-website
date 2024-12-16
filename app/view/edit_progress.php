                <?php

  include ('../controller/auth.php');

 require "../model/support_function.php";

?>

<?      
         // $id=$_GET['id'];   
        $id_progress=$_GET['id_progress'];     
  
 ?>
				<div class="row">
                <div class="col-lg-12">
                <? 
                   
                     $list = ViewProgressUpdate($id_progress)->fetch_assoc();
            
                 ?>
                       
                    

                            
						<form method="post" action="../controller/progress_edit_exec.php?id=<? echo $id;?>">   					
                         <div class="form-group" align="left">

                                
                               
                  <input name="no_staff" type="hidden" class="input-short" value="<? echo $_GET['no_staff']; ?>" />

              <input name="id" type="hidden" class="input-short" value="<? echo $_GET['id']; ?>" />

                         <input name="id_support" type="text" class="input-short" value="<? echo $_GET['id_support']; ?>" />

<br>

                           <div class="form-group" align="left">
               <label>Tarikh Hari Ini</label><br>
               <input class="form-control"  name="tarikh" id="tarikh" required autocomplete="off"> 
   

          </div> 
               <br>           
                  <div class="form-group" align="left">
                         <label>Progress<font color="red"></font>&nbsp;</label>
                         <textarea class="form-control" name="catatan" rows="8" id="catatan"></textarea>
                         </div>





                     <br><br>

            
             
                  <br>
            
                  <button type="submit" class="btn btn-primary">Simpan</button>
                  <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
         
         </form>
                            </div></div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
            </div>
                <!-- /.row -->
            <!-- /.container-fluid -->