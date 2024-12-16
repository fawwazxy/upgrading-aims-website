<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
//include ('../controller/auth.php');


require "../model/library_functions.php";

$id_jenis=$_POST['id'];

?>


<div class="panel panel-default">
    <div class="panel-heading" align="left">
        <label class="control-label" for="date">Senarai Peminjam Lewat Hantar</label>
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <table width="100%" class="table table-striped table-bordered table-hover" id="example2">
            <thead>
                <tr>
                    <th width="10%">Bil.</th>
                    <th width="30%">Maklumat Peminjam</th>
                    <th width="30%">Bahan Pinjaman</th>
                    <th width="30%">Tindakan</th>
                </tr>
            </thead>
            <tbody>
            <?
                $overdue = getAnalisaOverdueDetails($id_jenis,1,'epin.tarikh_hantar');
                $i=1;
                while($list_overdue = $overdue->fetch_assoc()) {
            ?>
                <tr>
                    <td><?echo $i++;?></td>
                    <td><strong>Nama</strong><br><?echo $list_overdue['nama_peminjam'] ;?><br>
                        <strong>No. Kad Pengenalan</strong><br><?echo $list_overdue['nokp'] ;?><br>
                        <strong>No. Telefon</strong><br><?echo $list_overdue['notel'] ;?>
                    </td>
                    <td><strong>Tajuk</strong><br><?echo $list_overdue['nama_library'] ;?><br>
                        <strong>Kategori</strong><br><?echo $list_overdue['jenis'] ;?><br>
                        <strong>Tarikh Pinjam</strong><br><?echo date("d F Y",strtotime($list_overdue['tarikh_pinjam'])) ;?>
                    </td>
                    <td>
					</td>
                    
                </tr>
            <?}?> 
             
            </tbody>
        </table>
    </div>

    <!-- /.panel-body -->
</div>
 <script>
    $(document).ready(function() {
        $('#example2').DataTable({
            responsive: true
        }); 
    });
</script>