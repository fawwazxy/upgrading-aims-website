<?php
require "../model/aims_gl_function.php";
$id = $_GET['id'];
?>
<style type="text/css">
    @media print {
        #btn-Preview-Image {
            display: none;
        }
</style>
<div class="table-responsive">
    <table class="att-table" style="width: 100%">
        <tbody>
        <? $attachment = getAttachment($id);
        $extension = explode('.', $attachment);
        $extension = end($extension); ?>
        <tr>
            <td style="text-align: center"><button id="btn-Preview-Image" onclick="window.print()" style="width: max-content">Print</button></td>
        </tr>
        <tr>
            <td style="text-align: center">
                <br>
                <? if  (in_array($extension, ['jpg','JPG','jpeg','JPEG','png','PNG'])) { ?>
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
                <? }  ?>
            </td>
        </tr>
        </tbody>
    </table>
</div>