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
        <label class="control-label" for="date">Senarai Rekod Pinjaman</label>
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <table width="100%" class="table table-striped table-bordered table-hover" id="example2">
            <thead>
                <tr>
                    <th width="10%">Bil.</th>
                    <th width="30%">Bahan Pinjaman</th>
                    <th width="30%">Tarikh Pinjam</th>
                    <th width="30%">Tarikh Hantar</th>
                </tr>
            </thead>
            <tbody>
            <?
                $peminjam = getTransaksiPinjamanByNokp($nokp);
                $i=1;
                while($list_peminjam = $peminjam->fetch_assoc()) {
            ?>
                <tr>
                    <td><?echo $i++;?></td>
                    <td><label class="control-label" for="date">Tajuk :</label><br><?echo $list_peminjam['nama_kandungan_digital'] ;?>
                    <br><label class="control-label" for="date">Kategori :</label><br><?echo $list_peminjam['jenis'] ;?>
                    </td>
                    <td><?echo date("d F Y",strtotime($list_peminjam['tarikh_pinjam'])); ?> </td>
                    <td>
					<? 
                    if($list_peminjam['status']==1){
                        echo date("d F Y",strtotime($list_peminjam['tarikh_hantar'])).'<br>';
                        echo '<strong><font size="2px" color="green">**&nbsp;Telah Dihantar&nbsp;**</font></strong><br>';
                    }else{
                        echo '<strong>Tarikh Akhir Hantar </strong><br>'.date("d F Y",strtotime($list_peminjam['tarikh_akhir'])).'<br>';
                        echo '<strong><font size="2px" color="red">**&nbsp;Belum Dihantar&nbsp;**</font></strong><br>';
                    }
                    if($list_peminjam['tarikh_akhir'] < $current_date){
                        echo '<strong><font size="2px" color="red">**&nbsp;Melebihi Tempoh Pinjaman</font></strong>';
                    }
					?>
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