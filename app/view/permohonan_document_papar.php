<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
include ('../controller/auth.php');


require "../model/pemohon_functions.php";

date_default_timezone_set("Asia/Kuala_Lumpur");
$date_month = date(m);
$date_year = date(Y);
$date_day = date(d);
$current_date = $date_year."-".$date_month."-".$date_day;
$pemohon_id=$_POST['pemohon_id'];
$data_pemohon= getPemohonRecords($pemohon_id)->fetch_assoc();
?>


        <?
            echo '<object width="750" height="950" data="data:application/pdf;base64,'.base64_encode( $data_pemohon['document'] ).'"/><br>'.'</object>';
        ?>

    <!-- /.panel-body -->
</div>
 <script>
    $(document).ready(function() {
        $('#example2').DataTable({
            responsive: true
        }); 
    });
</script>