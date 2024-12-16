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
                   
                      $row=  getPerananById($id)->fetch_assoc();
            
                 ?>
                       
                        <!-- /.panel-heading -->
                        

                            <form method="post" action="../controller/struktur_kerja_update_exec.php?id=<? echo $row['id']; ?>&id_projek=<? echo $row['id_projek']; ?>">
						<!-- <form method="post" action="../controller/ahli_kumpulan_edit_exec.php?id=<? //echo $id; ?>"> -->  

              <input type="hidden" name="id" value="<? echo $row['id']?>" >   
            <input type="hidden" name="id_projek" value="<? echo $row['id_projek']?>">

                       <!--  <input type="hidden" name="id" value="<? echo $list['id']?>" >   
                        <input type="hidden" name="id_projek" value="<? echo $list['id_projek']?>">  -->	

           
                        <div> 
                       
                         <label align="left"><font color="red">** Maklumat Wajib Diisi</font></label>                       
                           </div>

                     
                           
                           

                             <div class="form-group" align="left">
                                    <label>Peringkat<font color="red">**</font>&nbsp;</label>
                                    <select required class="form-control"  name="id_peringkat" value="<?php echo $row['id_peringkat']; ?>">
                                    <option value="">-- Pilih --</option>

                                    <? $person= getPeringkatPeranan();
                                    while ($pilih  = $person -> fetch_assoc()){ ?>
                                    <option value="<? echo $pilih['id'];?>" <? echo ($pilih['id']==$row['id_peringkat']?'selected':'');?>><? echo $pilih['description'];?></option>

                                    <?
                                    }       
                                    ?>
                                    </select>
                                </div>

                        <div class="form-group" align="left">
                                  <label>Nama Peranan Projek<font color="red">**</font>&nbsp;</label>
                                  <input class="form-control" placeholder=" " id="nama_peranan" name="nama_peranan" value="<? echo $row['nama_peranan']; ?>" required autocomplete="" type="text">
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