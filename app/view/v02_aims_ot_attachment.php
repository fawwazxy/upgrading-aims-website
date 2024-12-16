<?php
require "../model/v02_aims_ot_function.php";
$id = $_POST['id'];
?>
<div class="table-responsive">
    <table class="att-table" style="width: 100%">
        <tbody>
        <?
        $attachment = v02viewAttachment($id)->fetch_assoc();
        $i= 1;
        $filepath = '../../overtimephoto/'.$attachment['document_name'];
        $doc_name_array = explode('.',$attachment['document_name']);
        $file_type = end($doc_name_array);

        if ($attachment['review_at'] == null){ ?>
            <tr>
                <td style="width: 100%;background-color: #bbe3ff">
                    <form action="../controller/v02_aims_ot_attachment_update.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="<? echo $id; ?>">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="document">Add / Update Overtime Attachment:</label>
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
        <? } ?>
        <tr>
            <td style="width: 100%;" class="text-center">
                <? echo (empty($attachment['document_name'])) ? '' : '<b>Document: </b>'.$attachment['document_name'];
                if(in_array($file_type, ['JPG','JPEG','PNG','GIF','jpg','jpeg','png','gif'])) { ?>
                    <img  class="img-responsive" src="<?echo $filepath;?>" alt="ot_attachment" style="max-height:100vh;overflow-y: auto;margin: 8px auto 0 auto"/>
                <? }else if($file_type == 'pdf') { ?>
                    <iframe width="100%" height="500" src="<?php echo $filepath; ?>" class="embed-responsive-item"></iframe>
                <? }else{ ?>
                    <i class="text-muted">Image Not available</i>
                <? } ?>
            </td>
        </tr>
        </tbody>
    </table>
</div>





						