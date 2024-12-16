<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
include ('../controller/auth.php');


require "../model/pengusaha_functions.php";

date_default_timezone_set("Asia/Kuala_Lumpur");
$date_month = date(m);
$date_year = date(Y);
$date_day = date(d);
$current_date = $date_year."-".$date_month."-".$date_day;

$pemilik=$_POST['nokp'];
$data_pemilik = getPengusahaLotTanahDetailsByNokp($pemilik)->fetch_assoc();
?>


<div class="panel panel-default">
    <div class="panel-heading" align="left">
        <label class="control-label" for="date">Nama Pengusaha &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;<?echo $data_pemilik['nama'];?>
        <br><label class="control-label" for="date">No. Kad Pengenalan&nbsp;&nbsp;&nbsp;:</label>&nbsp;<?echo $data_pemilik['nokp'];?>
        <br><label class="control-label" for="date">No. Telefon&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;<?echo $data_pemilik['notel'];?>
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <table width="100%" class="table table-striped table-bordered table-hover" id="example2">
            <thead>
                <tr>
                    <th width="10%">Bil.</th>
                    <th width="30%">Kod</th>
                    <th width="30%">Maklumat Lot Tanah</th>
                </tr>
            </thead>
            <tbody>
            <?
                $lot_tanah = getPengusahaLotTanahDetailsByNokp($pemilik);
                $i=1;
                while($list_lot_tanah = $lot_tanah->fetch_assoc()) {
            ?>
                <tr>
                    <td><?echo $i++;?></td>
                    <td><b><?echo $list_lot_tanah['kod_tanah'] ;?></b></td>
                    <td>
                        <?if($list_lot_tanah['kod_mukim']!=''){ echo '<b>'.$list_lot_tanah['nama_ppk'].'</b>'.'&nbsp;-&nbsp;'.$list_lot_tanah['mukim'];}?><br>
                        <?if($list_lot_tanah['kod_daerah']!=''){ echo $list_lot_tanah['daerah'];}?><br>
                        <?if($list_lot_tanah['kod_jajahan']!=''){ echo $list_lot_tanah['jajahan'];}?><br>
                        <?if($list_lot_tanah['kod_negeri']!=''){ echo $list_lot_tanah['name'];}?></td>
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