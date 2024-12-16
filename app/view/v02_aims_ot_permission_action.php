<?php
require "../model/v02_aims_ot_function.php";

$id = $_POST['id'];
$otp_info = v02getOtPermissionById($id)->fetch_assoc();
$current_value = "";
if (!empty($otp_info['approval_at']) && $otp_info['approval_status'] == 1){
    $current_value = 1;
}else if (!empty($otp_info['approval_at']) && $otp_info['approval_status'] != 1){
    $current_value = 0;
}
?>
<div id="wrapper">
    <form method="post" action="../controller/v02_aims_ot_permission_approval_exec.php" enctype="multipart/form-data">
        <input type="hidden" id="id" name="id" value="<? echo $otp_info['id'] ?>" />
        <input type="hidden" id="current_value" name="" value="<? echo $current_value ?>" />

        <div class="form-group">
            <label>Applicant:</label>
            <p style="margin-left: 16px;"><?
                echo '<b>'.$otp_info['applicant_name'].'</b><br>';
                echo $otp_info['applicant_ic'].'<br>';
                echo $otp_info['applicant_no'];
                ?>
            </p>
        </div>

        <div class="form-group">
            <label>Description:</label>
            <p style="margin-left: 16px;"><? echo nl2br($otp_info['description']) ?></p>
        </div>

        <div class="form-group">
            <label for="approval_status">Status:</label><br>
            <? if(empty($otp_info['approval_at'])) { ?>
                <input type="radio" style="margin: 0 4px 0 16px" id="approval_status" name="approval_status"
                       value="" checked>PENDING
            <?}?>
                <input type="radio" style="margin: 0 4px 0 16px" id="approval_status" name="approval_status" value="1"
                    <?php if(!empty($otp_info['approval_at']) && $otp_info['approval_status']=="1") echo "checked"?>>APPROVE
                <input type="radio" style="margin: 0 4px 0 16px" id="approval_status" name="approval_status" value="0"
                    <?php if(!empty($otp_info['approval_at']) && $otp_info['approval_status']=="0") echo "checked"?>>DISAPPROVE
        </div>

        <div class="form-group row">
            <div class="col-sm-12">
                <label for="approval_by" class="control-label">Approval by:</label>
                <input type="text" required="" class="form-control" id="approval_by" style="text-transform:uppercase" value="<?php echo $otp_info['approval_name']; ?>" disabled/>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" id="save_btn" class="btn btn-block btn-primary" disabled>SAVE</button>
        </div>
    </form>
</div>
<script>
    $('input[name="approval_status"]').on('change', function (e) {
        let saveBtn = $('#save_btn');
        let currentVal = $('#current_value');
        if ($(this).val() === '' || $(this).val() ===  currentVal.val()){
            saveBtn.prop('disabled', true);
        }else {
            saveBtn.prop('disabled', false);
        }
    });
</script>