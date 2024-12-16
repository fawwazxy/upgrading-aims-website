<?php
include ('../controller/auth.php');
require "../model/aims_ot_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$month = $_GET['month'];
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
function Kemaskini(){
    return confirm('Anda pasti untuk kemaskini maklumat permohonan claim?');
}

</script>
<script language="JavaScript" type="text/javascript">
function Confirm(){
    return confirm('Anda pasti untuk hantar permohonan claim?');
}

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

<style>
td {
	padding: 15px;
}



</style>

</head>



<body>

                 
        <div style="text-align:center; padding-top:10px;" width="100%"><input type="button" class="btn btn-danger" value="Close" onclick="self.close()"></div>
                        <table width="100%"  border="0">
                            <thead>
                                <tr>
                                 
								<th style="text-align:center;" width="100%"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                    $pemohon = getOtFoto($id,$month);
                                    $i= 1;
                                    while($lampiran = $pemohon->fetch_assoc()) {
										
										
										$filename = $lampiran['document_name'];
										$filepath = '../../overtimephoto/'.$lampiran['document_name'];

                                ?>
                                <tr>
                                    
									<td style="text-align:center;" width="100%"> 
									<b></b>
									<? if($lampiran['document_type'] == 'jpg' || $lampiran['document_type'] == 'jpeg' || $lampiran['document_type'] == 'png' || $lampiran['document_type'] == 'gif') { ?>
										<img style="max-height:100vh;overflow-y: auto;" class="img-responsive" width="auto" height="auto" src="<?echo $filepath;?>" border="0"/>

									<? }else if($lampiran['document_type'] == 'pdf') { ?>
										
										<iframe width="100%" height="500" src="<?php echo $filepath; ?>" class="embed-responsive-item"></iframe>
											
									<? }?>
									
									
									</td>
                                </tr>
                            <?}?>
                             
                            </tbody>
                        </table>




</body>

</html>





						