<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
//include ('../controller/auth.php');
require "../model/library_functions.php";

$id_library=$_POST['id'];

?>


<div class="panel panel-default">
    <div class="panel-heading" align="left">
        <label class="control-label" for="date">Senarai Peminjam Belum Hantar</label>
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <table width="100%" class="table table-striped table-bordered table-hover" id="example3">
            <thead>
                <tr>
                    <th width="7%">Bil.</th>
                    <th width="30%">Maklumat Peminjam</th>
                    <th width="30%">Bahan Pinjaman</th>
                    <th width="18%">Tindakan</th>
                </tr>
            </thead>
            <tbody>
            <?
                $tempahan = getAnalisaBooking($id_library);
                $i=1;
                while($list_tempahan = $tempahan->fetch_assoc()) {
                
            ?>
                <tr>
                    <td><?echo $i++;?></td>
                    <td>
                        <strong>Nama</strong><br><?echo $list_tempahan['nama_peminjam'] ;?><br>
                        <strong>No. Kad Pengenalan</strong><br><?echo $list_tempahan['nokp'] ;?><br>
                        <strong>No. Telefon</strong><br><?echo $list_tempahan['notel'] ;?>
                    </td>
                    <td>
                        <strong>Tajuk</strong><br><a href="#myModal1" class="btn btn-link" data-toggle="modal" data-id="<? echo $list_tempahan['id_library'];?>"><?echo $list_tempahan['nama_library'] ;?></a><br>
                        <strong>Kategori</strong><br><?echo $list_tempahan['jenis'] ;?><br>
                        <strong>Tarikh Anggar Pinjam</strong><br><?echo date("d F Y",strtotime($list_tempahan['anggaran_tarikh_tempah']));?><br>
                        <strong>
                            <?if($list_tempahan['status_urgent']==1){?>
                                <font color="red">Segera</font>
                            <?}else{?>
                                <font color="blue">Tidak Segera</font>
                            <?}?>
                        </strong>
                    </td>
                    <td>
                        <?if($list_tempahan['status'] =='1'){?>
                          <a href="#myModal4" class="btn btn-info" data-toggle="modal" data-id="<? echo $list_tempahan['id_tempahan'];?>">Pinjaman</a>
                        <?}?>
                    </td>
                </tr>
            <?}?> 
             
            </tbody>
        </table>
    </div>

    <!-- /.panel-body -->
</div>
<div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title" id="myModalLabel">Tambah Tempahan</h4>
        </div>
        <div class="modal-body" id="demo4">
        <script type="text/javascript">
          $('#myModal4').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            // $('#demo').html(rowid);
            $.ajax({
              type:'POST',
              url:'library_pinjaman_tempahan.php',
              data:{id:rowid},
              success:function(html){
                $('#demo4').html(html);
              }
            });
          });
        </script>
        </div>                                                                       
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
 <script>
    $(document).ready(function() {
        $('#example3').DataTable({
            responsive: true
        }); 
    });
</script>