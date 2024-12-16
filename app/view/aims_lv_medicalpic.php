<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
include ('../controller/auth.php');


require "../model/aims_lv_medical_function.php";

date_default_timezone_set("Asia/Kuala_Lumpur");
$date_month = date(m);
$date_year = date(Y);
$date_day = date(d);
$current_date = $date_year."-".$date_month."-".$date_day;
$id=$_POST['id'];
$lampiran = getLampiranInfo($id)->fetch_assoc();
header("Content-type: ".$lampiran['document_type']);

header('Content-Disposition: inline; filename="' . $lampiran['document_name'] . '"'); 
 header("Content-Transfer-Encoding: binary"); 
                    header('Expires: 0');
                    header('Pragma: no-cache');
				     ob_clean();
				     flush();
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
        		echo '<img class="img-responsive" width="100%" height="100%" src="data:image/jpeg;base64,'.base64_encode( $lampiran['document'] ).'"/><br>';}
        	else if($lampiran['document_type'] == 'pdf') {
        		echo '<object width="100" height="100" data="data:application/pdf;base64,'.base64_encode( $lampiran['document'] ).'"/><br>'.'
        		<p style="text-align:center"><font size="4" color="#ffffff" style="background-color:#333333;">Your web browser doesnt have a PDF plugin.</font></p></object>';
        //	echo '<iframe src="https://docs.google.com/gview?url=data:image/jpeg;base64,'.base64_encode( $lampiran['document'] ).'&embedded=true"></iframe>';
        	    
        	}
        ?>
</div>
    <!-- /.panel-body -->

 <script>
 
</script>