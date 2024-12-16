<?
  // $com_id=$_GET['SESS_COM'];
  // $iklan_id = $_GET['iklan_id'];
  // $no_staff = $_GET['no_staff'];
?>    



  <!-- Modal -->
  <div class="modal fade" id="myModal3<?echo $iklan_id;?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
      
        <div class="modal-body">
     
        <div class="row">
            <div class="col-lg-12">
               
            </div>
        </div>
                <div class="row">
               
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong>Senarai Pemohon : <?php echo $list['peranan']; ?></strong>
							
							
							<? 
							//echo $iklan_id;
							
						
							?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Pemohon</th>
                                        <th>Perjawatan</th>
										<th>Status Permohonan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?
                                    $z= 1;
                                    $pemohon_list = getPemohonPerjawatan($iklan_id);
                                    while($list_pemohon = $pemohon_list ->fetch_assoc()) {
                                ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $z; ?></td>
                                        <td><?php echo $list_pemohon['name']; ?></td>
                                        <td><?php echo $list_pemohon['peranan']; ?></td>
										<td><font color=blue><strong><?php echo $list_pemohon['status_pemohon']; ?></strong></font></td>
                                    </tr>
                                <?php $z++; } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                
                <!-- /.col-lg-12 -->
            </div>
                <!-- /.row -->
            <!-- /.container-fluid -->
           
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-success" data-dismiss="modal">Kembali</button>
        </div>
      </div>
      
    </div>
  </div>
  
