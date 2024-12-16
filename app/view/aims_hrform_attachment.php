<?php

include ('../controller/auth.php');
require "../model/aims_hr_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$document = $_GET['document'];
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

<style>
td {
	padding: 15px;
}



</style>

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
                                    $DocHR = getHrDocument($id);
                                    $i= 1;
                                    while($document = $DocHR->fetch_assoc()) {
										
										
										$filename = $document['document_name'];
										$filepath = '../../hrform/'.$document['document_name'];

                                ?>
                                <tr>
                                    
									<td style="text-align:center;" width="100%"> 
									<b></b>
									<? if($document['document_type'] == 'jpg' || $document['document_type'] == 'jpeg' || $document['document_type'] == 'png' || $document['document_type'] == 'gif') { ?>
										<img style="max-height:100vh;overflow-y: auto;" class="img-responsive" width="auto" height="auto" src="<?echo $filepath;?>" border="0"/>

									<? }else if($document['document_type'] == 'pdf') { ?>
										
										<iframe width="100%" height="500" src="<?php echo $filepath; ?>" class="embed-responsive-item"></iframe>
											
									<? }?>
									
									
									</td>
                                </tr>
                            <?}?>
                             
                            </tbody>
                        </table>


</body>

</html>





						