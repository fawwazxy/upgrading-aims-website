<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
include ('../controller/auth.php');


require "../model/aims_inout_function.php";

date_default_timezone_set("Asia/Kuala_Lumpur");
$date_month = date(m);
$date_year = date(Y);
$date_day = date(d);
$current_date = $date_year."-".$date_month."-".$date_day;
$id=$_POST['id'];
$lampiran = getLampiranInfo($id)->fetch_assoc();

?>


        <?
            if($lampiran['file_type'] == 'jpg' || $lampiran['file_type'] == 'jpeg' || $lampiran['file_type'] == 'png' || $lampiran['file_type'] == 'gif') {
        		echo '<img width="600" height="800" src="data:image/jpeg;base64,'.base64_encode( $lampiran['files'] ).'"/><br>';}
        	else if($lampiran['file_type'] == 'pdf') {
        		echo '<object width="600" height="800" data="data:application/pdf;base64,'.base64_encode( $lampiran['files'] ).'"/><br>'.'</object>';}
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