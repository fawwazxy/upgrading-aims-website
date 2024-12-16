<?php
require "../model/v02_aims_leave_function.php";
$id = $_POST['id'];
$allow_edit = $_POST['edit'];
?>
<div class="table-responsive">
    <table class="att-table" style="width: 100%">
        <tbody>
        <?
        $attachment = viewLeaveAttachment($id)->fetch_assoc();
        $i= 1;
        $filepath = '../../leave_photo/'.$attachment['document_url'];
        $doc_name_array = explode('.',$attachment['document_url']);
        $file_type = end($doc_name_array);

        if ($attachment['approval_at'] == null && $allow_edit == 1){ ?>
            <tr>
                <td style="width: 100%;background-color: #bbe3ff">
                    <form action="../controller/v02_aims_leave_attachment_update.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id" id="id" value="<? echo $id; ?>">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="document">Add / Update Leave Attachment: <span class="text-muted">(pdf/jpg/png/HEIC/HEIF)</span></label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="file" name="document" id="document" class="form-control" required>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="submit" class="btn btn-block btn-primary">Save</button>
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
                <? echo (empty($attachment['document_url'])) ? '' : '<b>Document: </b>'.$attachment['document_url'];
                if(in_array(strtolower($file_type), ['jpg','jpeg','png','pneg'])) { ?>
                    <img  class="img-responsive" src="<?echo $filepath;?>" alt="leave_attachment" style="max-height:100vh;overflow-y: auto;margin: 8px auto 0 auto"/>
                <? }else if(in_array(strtolower($file_type), ['heic','heif'])) { ?>
                    <script type="text/javascript">
                        $(document).ready(function (){
                            fetch('<? echo $filepath ?>')
                                .then((res) => res.blob())
                                .then((blob) => heic2any({
                                    blob,
                                    toType: "image/jpg",
                                    quality: 0.1,
                                    gifInterval: 0.2,
                                }))
                                .then((conversionResult) => {
                                    const url = URL.createObjectURL(conversionResult);
                                    $('#heicImg').attr({'src': url, 'style': 'display: block'});
                                    $('#loadingImg').attr('style', 'display:none')
                                })
                                .catch((e) => {
                                    console.log(e);
                                });
                        });
                    </script>
                    <i class="text-muted blink-me" style="margin-top: 32px; display: block" id="loadingImg">Loading HEIC/HEIF image...</i>
                    <img class="img-responsive" id="heicImg" src="" alt="leave_attachment" style="max-height:100vh;overflow-y: auto;margin: 8px auto 0 auto;display: none"/>
                <? }else if(strtolower($file_type) == 'pdf') { ?>
                    <iframe width="100%" height="500" src="<?php echo $filepath; ?>" class="embed-responsive-item"></iframe>
                <? }else{ ?>
                    <i class="text-muted">- No Attachment -</i>
                <? } ?>
            </td>
        </tr>
        </tbody>
    </table>
</div>





