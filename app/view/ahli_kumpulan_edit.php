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
                   
                     $list = getAhliForEdit($id)->fetch_assoc();
            
                 ?>
                       
                        <!-- /.panel-heading -->
                        

                            <form method="post" action="../controller/ahli_kumpulan_edit_exec.php?id=<? echo $list['id']; ?>&id_projek=<? echo $list['id_projek']; ?>">
						<!-- <form method="post" action="../controller/ahli_kumpulan_edit_exec.php?id=<? //echo $id; ?>"> -->  

                        <input type="hidden" name="id" value="<? echo $list['id']?>" >   
                        <input type="hidden" name="id_projek" value="<? echo $list['id_projek']?>"> 	

           
                        <div> 
                       
                         <label align="left"><font color="red">** Maklumat Wajib Diisi</font></label>                       
                           </div>

                     
                           
                           

                             <div class="form-group" align="left">
                                <label>Peranan Dalam Projek<font color="red">**</font>&nbsp;</label>
                                <select required class="form-control"  name="id_peranan" value="<?php echo $list['id_peranan']; ?>">
                                <option value="">-- Pilih --</option>

                                <? $person= getPerananByProjekForEdit($id_projek);
                                while ($pilih  = $person -> fetch_assoc()){ ?>
                                <option value="<? echo $pilih['id'];?>"<? echo $pilih['id']==$list['id_peranan']?'selected':'';?>><? echo $pilih['description'];?> --- <? echo $pilih['nama_peranan'];?></option>

                                <?
                                }       
                                ?>
                                </select>
                            </div>
                       
                           
                        <div class="form-group" align="left">
                                    <label>Nama Ahli Projek <font color="red">**</font>&nbsp;</label>
                                    <select required class="form-control"  name="nama_ahli" value="<?php echo $list['nama_ahli']; ?>">
                                    <option value="">-- Pilih --</option>

                                    <? $person= getNamaPegawaiForEdit($id_projek);
                                    while ($pilih  = $person -> fetch_assoc()){ ?>
                                    <option value="<? echo $pilih['no_staff'];?>"<? echo $pilih['no_staff']==$list['nama_ahli']?'selected':'';?>><? echo $pilih['name'];?></option>

                                    <?
                                    }       
                                    ?>
                                    </select>
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