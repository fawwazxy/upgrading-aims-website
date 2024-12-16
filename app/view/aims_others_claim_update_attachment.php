<?
date_default_timezone_set("Asia/Kuala_Lumpur");
include ('../controller/auth.php');
require "../model/aims_others_claim_hod_function.php";
require "../model/lookup.php";

$id = $_POST['id'];
?>

<head>
    <title>View Attachment</title>
    <? require "../global/header.php"; ?>
</head>

<body>
<div class="table-responsive">
    <table class="att-table" style="width: 100%">
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
            <td style="width: 100%;background-color: #bbe3ff">
                <form action="../controller/aims_others_claim_attachment_update.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="<? echo $id; ?>">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="document">Add / Update Claim Attachment:</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="file" name="document" id="document" class="form-control" required>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-block btn-primary">Submit</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </td>
        </tr>
        <tr>
            <td style="text-align:center;align:center" width="100%">
                <b style="color: white">Document Name : <? echo $filename;?></b>
                <? if($lampiran['document_type'] == 'jpg' || $lampiran['document_type'] == 'JPG'  || $lampiran['document_type'] == 'jpeg' || $lampiran['document_type'] == 'JPEG'  || $lampiran['document_type'] == 'png' || $lampiran['document_type'] == 'PNG' || $lampiran['document_type'] == 'gif' || $lampiran['document_type'] == 'GIF' ) {  ?>
                    <center><img style="max-height:100vh;overflow-y: auto;" class="img-responsive" width="auto" height="auto" src="<?php echo '../../othersclaimphoto/'.$filename; ?>" border="0"/></center>
                <? }else if($lampiran['document_type'] == 'pdf' || $lampiran['document_type'] == 'PDF') { ?>
                    <center><iframe width="100%" height="500" src="<?php echo '../../othersclaimphoto/'.$filename; ?>" class="embed-responsive-item"></iframe></center>
                <? }else{ ?>
                    <i class="text-muted" style="color: white">Document Not Available</i>
                <? } ?>
            </td>
        </tr>
        <? } ?>
        </tbody>
    </table>
</div>
</body>

