<?php
require "../model/aims_gl_function.php";
$id = $_POST['id'];
?>
<div class="table-responsive">
    <table class="att-table" style="width: 100%">
        <tbody>
        <? $attachment = getAttachment($id);
        $extension = explode('.', $attachment);
        $extension = end($extension); ?>
        <tr>
            <td style="width: 100%;background-color: #bbe3ff">
                <form action="../controller/aims_gl_client_update_attachment_exec.php" method="post"
                      enctype="multipart/form-data">
                    <input type="hidden" name="id" id="id" value="<? echo $id; ?>">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="document">Add / Update Client Attachment:</label>
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
            <td class="text-center">
                <? if  (in_array($extension, ['jpg','JPG','jpeg','JPEG','png','PNG'])) { ?>
                    <a target="_blank" href="aims_gl_client_attachment_print.php?id=<? echo $id; ?>"><button>Print Here</button></a>
                <img style="max-height:100vh;margin-left: auto;margin-right: auto" class="img-responsive" alt="client-attachment"
                     src="<? echo '../../glphoto/' . $attachment; ?>"/>
                <? } else if ($extension == 'pdf') { ?>
                    <iframe width="100%" height="740" src="<? echo '../../glphoto/' . $attachment; ?>"
                            class="embed-responsive-item"></iframe>
                <? } else if (in_array($extension, ['heic', 'heif'])) { ?>
                    <script type="text/javascript">
                        $(document).ready(function (){
                            fetch('<? echo '../../glphoto/' . $attachment; ?>')
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
                <? } else { ?>
                    <i class="text-muted">Document Not available</i>
                <? } ?>
            </td>
        </tr>
        </tbody>
    </table>
</div>

