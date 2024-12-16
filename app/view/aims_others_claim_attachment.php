<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
include ('../controller/auth.php');
require "../model/aims_others_claim_hod_function.php";
require "../model/lookup.php";

$id = $_POST['id'];

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <? require "../global/header.php"; ?>
	
<script language="JavaScript" type="text/javascript">


</script>

<script language="javascript" type="text/javascript">
<!--
function popitup(url) {
	/*newwindow=window.open(url,'name','height=842,width=595');*/
	newwindow=window.open(url,'name','height=595,width=890');
	if (window.focus) {newwindow.focus()}
	return false;
}

// -->
</script>


</head>



<body>

                 
        
                        <table width="100%"  border="0">
                            <thead>
                                <tr>
                                 
								<th style="text-align:center;" width="100%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                    $pemohon = getLampiranInfo($id);
                                    $i= 1;
                                    while($lampiran = $pemohon->fetch_assoc()) {
										
										
										$filename = $lampiran['document_name'];
										$filepath = '../../othersclaimphoto/'.$lampiran['document_name'];

                                ?>
                                <tr>
                                    
									<td style="text-align:center;" width="100%"> 
									<b></b>
									<? if($lampiran['document_type'] == 'jpg' || $lampiran['document_type'] == 'JPG'  || $lampiran['document_type'] == 'jpeg' || $lampiran['document_type'] == 'JPEG'  || $lampiran['document_type'] == 'png' || $lampiran['document_type'] == 'PNG' || $lampiran['document_type'] == 'gif' || $lampiran['document_type'] == 'GIF' ) { ?>
										<img style="max-height:100vh;overflow-y: auto;" class="img-responsive" width="auto" height="auto" src="<?echo $filepath;?>" border="0"/>

									<? }else if($lampiran['document_type'] == 'pdf' || $lampiran['document_type'] == 'PDF') { ?>
										
										<iframe width="100%" height="500" src="<?php echo $filepath; ?>" class="embed-responsive-item"></iframe>
											
									<? }?>
									</td>
                                </tr>
                            <?}?>
                             
                            </tbody>
                        </table>




</body>

</html>