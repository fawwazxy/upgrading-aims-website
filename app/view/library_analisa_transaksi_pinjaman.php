<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
include ('../controller/auth.php');


require "../model/library_functions.php";

date_default_timezone_set("Asia/Kuala_Lumpur");
$date_month = date(m);
$date_year = date(Y);
$date_day = date(d);
$current_date = $date_year."-".$date_month."-".$date_day;

$nokp=$_POST['nokp'];
?>


<div class="panel panel-default">
    <div class="panel-heading" align="left">
        <label class="control-label" for="date">No. Kad Pengenalan :</label> <?echo $nokp;?>
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <table width="100%" class="table table-striped table-bordered table-hover" id="example2">
            <thead>
                <tr>
                    <th width="10%">Bil.</th>
                    <th width="30%">Tajuk</th>
                    <th width="30%">Kategori</th>
                </tr>
            </thead>
            <tbody>
            <?
                $peminjam = getPinjamanDetailByNokp($nokp);
                $i=1;
                while($list_peminjam = $peminjam->fetch_assoc()) {
            ?>
                <tr>
                    <td><?echo $i++;?></td>
                    <td><?echo $list_peminjam['nama_kandungan_digital'] ;?></td>
                    <td><?echo $list_peminjam['jenis'] ;?></td>
                    
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