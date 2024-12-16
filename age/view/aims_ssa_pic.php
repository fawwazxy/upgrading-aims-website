<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
include ('../controller/auth.php');


require "../model/aims_ssa_function.php";

date_default_timezone_set("Asia/Kuala_Lumpur");
$date_month = date(m);
$date_year = date(Y);
$date_day = date(d);
$current_date = $date_year."-".$date_month."-".$date_day;
$id=$_POST['id'];
$lampiran = getLampiranInfo($id)->fetch_assoc();

?>

<style>
    
    .embed-responsive {
    position: relative;
    display: block;
    height: 0;
    padding: 0;
    overflow: hidden;
}
</style>

<div class='embed-responsive' style='padding-bottom:150%'>
        <?
            if($lampiran['document_type'] == 'jpg' || $lampiran['document_type'] == 'jpeg' || $lampiran['document_type'] == 'png' || $lampiran['document_type'] == 'gif') {
        		echo '<img width="500" height="600" src="data:image/jpeg;base64,'.base64_encode( $lampiran['document'] ).'"/><br>';}
        	else if($lampiran['document_type'] == 'pdf') {
        		echo '<object width="600" height="700" data="data:application/pdf;base64,'.base64_encode( $lampiran['document'] ).'"/><br>'.'</object>';}
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