                <?php

  include ('../controller/auth.php');

 require "../model/claim_function.php";

?>

<?      
         $id =$_GET['id'];
    $id_projek=$_GET['id_projek'];  
 ?>
				<div class="row">
                <div class="col-lg-12">
					
                <? 
                   
                     $list = getTarikhTuntutanById($id)->fetch_assoc();
            
                 ?>
                       
                        <!-- /.panel-heading -->
                        

                            <form method="post" action="../controller/tarikh_tuntutan_update_exec.php?id=<? echo $list['id']; ?>">
						<!-- <form method="post" action="../controller/ahli_kumpulan_edit_exec.php?id=<? //echo $id; ?>"> -->  

                        <input type="hidden" name="id" value="<? echo $list['id']?>" >   

           
                            
                  
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