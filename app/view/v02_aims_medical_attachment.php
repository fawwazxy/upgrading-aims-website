<?php
require "../model/v02_aims_medical_function.php";
$id = $_POST['id'];
$allow_edit = $_POST['edit'];
?>
<div class="table-responsive">
    <table class="att-table" style="width: 100%">
        <tbody>
        <?
        $attachment = viewMedicalAttachment($id)->fetch_assoc();
        $i= 1;
        $filepath = '../../medicalphoto/'.$attachment['document_name'];
        $doc_name_array = explode('.',$attachment['document_name']);
        $file_type = end($doc_name_array);
       ?>
        <tr>
            <td style="width: 100%;" class="text-center">
                <? echo (empty($attachment['document_name'])) ? '' : '<b>Document: </b>'.$attachment['document_name'];
                if(in_array(strtolower($file_type), ['jpg','jpeg','png','pneg'])) { ?>
                <img  class="img-responsive" src="<?echo $filepath;?>" alt="medical_attachment" style="max-height:100vh;overflow-y: auto;margin: 8px auto 0 auto"/>
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
                    <i class="text-muted blink-me" style="margin-top: 32px; display: block" id="loadingImg">Loading...</i>
                <img class="img-responsive" id="heicImg" src="" alt="leave_attachment" style="max-height:100vh;overflow-y: auto;margin: 8px auto 0 auto;display: none"/>
                <? }else if(strtolower($file_type) == 'pdf') { ?>
                    <iframe width="100%" height="500" src="<?php echo $filepath; ?>" class="embed-responsive-item"></iframe>
                <? }else{ ?>
                    <i class="text-muted">- No attachment -</i>
                <? } ?>
            </td>
        </tr>
        </tbody>
    </table>
</div>





