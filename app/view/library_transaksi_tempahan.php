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
$status=$_POST['status'];

?>


<div class="panel panel-default">
    <div class="panel-heading" align="left">
        <label class="control-label" for="date">Senarai Transaksi Tempahan</label>
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
        <table width="100%" class="table table-striped table-bordered table-hover" id="example2">
            <thead>
                <tr>
                    <th width="10%">Bil.</th>
                    <th width="25%">Bahan Pinjaman</th>
                    <th width="30%">Tarikh Anggaran Tempahan</th>
                    <th width="10%">Status</th>
                </tr>
            </thead>
            <tbody>
            <?
                $tempahan = getTempahanListByNokp($nokp,$status);
                $i=1;
                while($list_tempahan = $tempahan->fetch_assoc()) {
            ?>
                <tr>
                    <td><?echo $i++;?></td>
                    <td><?echo $list_tempahan['tajuk'] ;?>
                    </td>
                    <td><?echo date("d F Y",strtotime($list_tempahan['anggaran_tarikh_tempah'])); ?> </td>      
                    <td>
                    <?if($list_tempahan['status'] == '0'){
                        echo '<strong><font size="2px" color="blue">Dalam Tempahan</font></strong>';?>
                    <?}?>
                    <?if($list_tempahan['status'] == '2'){
                         echo '<strong><font size="2px" color="red">Batal Tempahan</font></strong>';?>
                    <?}?>
                    <?if($list_tempahan['status'] == '1'){
                         echo '<strong><font size="2px" color="green">Tempahan Lulus</font></strong>';?>
                    <?}?>
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