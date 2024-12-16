<?
include ('../controller/auth.php');
require "../model/lookup.php";
require "../model/v02_aims_others_claim_function.php";
$id = $_GET['id'];
?>
<head>
    <title>View Attachment</title>
    <? require "../global/header.php"; ?>
</head>
<body>
<table width="100%"  border="0">
    <thead>
    <tr>
        <th style="text-align:center;" width="100%"></th>
    </tr>
    </thead>
    <tbody>
    <div style="text-align:center; padding-top:10px;" width="100%"><input type="button" class="btn btn-danger" value="Close" onclick="self.close()"></div>
    <?
    $attachment = v02getAttachment($id);
    $extension = explode('.', $attachment);
    $extension = end($extension);
    ?>
    <tr>
        <td style="text-align:center;align:center" width="100%">
            <b>Document Name : <? echo $attachment;?></b>
            <? if($extension == 'jpg' || $extension == 'JPG'  || $extension == 'jpeg' || $extension == 'JPEG'  || $extension == 'png' || $extension == 'PNG' || $extension == 'gif' || $extension == 'GIF' ) { ?>
                <center><img style="max-height:100vh;overflow-y: auto;" class="img-responsive" width="auto" height="auto" src="<?php echo '../../othersclaimphoto/'.$attachment; ?>" border="0"/></center>
            <? }else if($extension == 'pdf') { ?>
                <center><iframe width="100%" height="740" src="<?php echo '../../othersclaimphoto/'.$attachment; ?>" class="embed-responsive-item"></iframe></center>
            <? }?>
        </td>
    </tr>
    </tbody>
</body>

