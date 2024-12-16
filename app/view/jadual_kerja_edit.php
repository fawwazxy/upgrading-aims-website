                <?php

  include ('../controller/auth.php');

 require "../model/project_management_function.php";

?>

<?      
         $id =$_GET['id'];
    $id_projek=$_GET['id_projek'];  
 ?>
				<div class="row">
                <div class="col-lg-12">
					
                <? 
                   
                     $list = getJadualForEdit($id)->fetch_assoc();
            
                 ?>
                       
                        <!-- /.panel-heading -->
                        

                            <form method="post" action="../controller/jadual_kerja_edit_exec.php?id=<? echo $list['id']; ?>&id_projek=<? echo $list['id_projek']; ?>">
						<!-- <form method="post" action="../controller/ahli_kumpulan_edit_exec.php?id=<? //echo $id; ?>"> -->  

                        <input type="hidden" name="id" value="<? echo $list['id']?>" >   
                        <input type="hidden" name="id_projek" value="<? echo $list['id_projek']?>"> 	

           
                        <div> 
                       
                         <label align="left"><font color="red">** Maklumat Wajib Diisi</font></label>                       
                           </div>

                     <div class="form-group" align="left">
                                    <label>Fasa Kerja<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" name="fasa" id="fasa" value="<?php echo $list['fasa']; ?>"  readonly="readonly"/><br>
                                </div>
                           
                           

                              <div class="form-group" align="left">
                                    <label>Tarikh Mula<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" type="date" name="mula" id="mula" min="<? echo $log['tarikh_mula'];?>"  max="<? echo $log['tarikh_akhir'];?>" value="<?php echo $list['mula']; ?>" readonly="readonly" /><br>
                                </div>
                         <div class="form-group" align="left">
                                    <label>Tarikh Akhir<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" type="date" name="akhir" id="akhir" min="<? echo $log['tarikh_mula'];?>"  max="<? echo $log['tarikh_akhir'];?>" value="<?php echo $list['akhir']; ?>" readonly="readonly" /><br>
                                </div>
                         <div class="form-group" align="left">
                                    <label>Tarikh Mula Sebenar&nbsp;</label>
                                    <input class="form-control" type="date" name="mula_sebenar" id="mula_sebenar" value="<?php echo $list['mula_sebenar']; ?>" /><br>
                                </div>
                         <div class="form-group" align="left">
                                    <label>Tarikh Akhir Sebenar&nbsp;</label>
                                    <input class="form-control" type="date" name="akhir_sebenar" id="akhir_sebenar" value="<?php echo $list['akhir_sebenar']; ?>" /><br>
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