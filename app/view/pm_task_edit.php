                <?php

  include ('../controller/auth.php');

 require "../model/task_function.php";

?>

<?      
         $id =$_GET['id'];
         $id_task =$_GET['id_task'];
 ?>
				<div class="row">
                <div class="col-lg-12">
					
         
                       
                        <!-- /.panel-heading -->
                        

                <form method="post" action="../controller/pm_task_edit_exec.php?id=<? echo $id ?>&id_task=<? echo $id_task; ?>">
						<!-- <form method="post" action="../controller/ahli_kumpulan_edit_exec.php?id=<? //echo $id; ?>"> -->  


                           <? $data=getTaskForEdit($id_task)->fetch_assoc()?>

                        <input type="text" name="id_projek" value="<? echo $id; ?>">   
                        <input type="text" name="id_task" value="<? echo $id_task?>"> 	

           
                        <div> 
                       
                         <label align="left"><font color="red">** Maklumat Wajib Diisi</font></label>                       
                           </div>

                     
                           

                        <div class="form-group" align="left">
                        <label>Task<font color="red">**</font>&nbsp;</label>
                        <select required class="form-control"  name="parent_id" value="<?php echo $data['parent_id']; ?>">
                        <option value="">-- Pilih --</option>

                        <? $task= getTaskPrev($id);
                        while ($pilih  = $task -> fetch_assoc()){ ?>

                              <option value="<? echo $pilih['task_id'];?>"<? echo $pilih['task_id']==$data['parent_id']?'selected':'';?>><? echo $pilih['task'];?></option>


                        <?
                        }       
                        ?>
                        </select>

                        <input type="text" class="form-control" name="task" id="task" value="<?php echo $data['task']; ?>"> 
                        </div>

                         
                       
                        <div class="form-group" align="left">
                        <label>Task Start<font color="red">**</font>&nbsp;</label>
                            <input type="date" class="form-control" name="task_start" id="task_start" value="<?php echo $data['task_start']; ?>">
                        </div>

                        <div class="form-group" align="left">
                            <label>Task Finish<font color="red">**</font>&nbsp;</label>
                            <input type="date" class="form-control" name="task_finish" id="task_finish" value="<?php echo $data['task_finish']; ?>"> 
                        </div>

                        <div class="form-group" align="left">
                        <label>Task Duration<font color="red">**</font>&nbsp;</label>
                            <input type="number" class="form-control" name="task_duration" id="task_duration" value="<?php echo $data['task_duration']; ?>">
                        </div>
                                                              
                        <div class="form-group" align="left">
                            <label>Progress<font color="red">**</font>&nbsp;</label>
                            <input type="number" class="form-control" name="progress" id=progress" value="<?php echo $data['progress']; ?>"> 
                        </div>
                            
                        <div class="modal-footer">
                            <button class="btn btn-primary">Simpan</button>
                        </div>
         
                </form>
                            </div></div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
            </div>
                <!-- /.row -->
            <!-- /.container-fluid -->

            <script type="text/javascript">
    $('#task_finish').on('change', function() {
  var date = $('#task_start').val();
  var date1 = $('#task_finish').val();
  var start = new Date(date).getTime();
  var end = new Date(date1).getTime();

    var distance = end - start;
    
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    document.getElementById("task_duration").value = days+1;
  
});
 
</script>