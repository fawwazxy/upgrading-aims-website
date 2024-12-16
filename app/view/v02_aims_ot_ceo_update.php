<?php
session_start();
require "../model/v02_aims_ot_function.php";

$id = $_POST['id'];
$approved_status = $_POST['status'];
$approved_value = "";
if ($approved_status == "YES"){
    $approved_value = 1;
}else if ($approved_status == "NO"){
    $approved_value = 0;
}
?>
<div id="wrapper">
    <form method="post" action="../controller/v02_aims_ot_ceo_update_exec.php" enctype="multipart/form-data">
        <input type="hidden" id="id" name="id" value="<? echo $id ?>"/>
        <input type="hidden" id="current_value" name="" disabled value="<? echo $approved_value ?>"/>
        <div class="form-group">
            <label for="approved_status">STATUS:</label><br>
            <? if($approved_status == 'NULL') { ?>
                <input type="radio" style="margin: 0 4px 0 16px" id="approved_status" name="approved_status"
                    checked value="">PENDING
            <?}?>
            <input type="radio" style="margin: 0 4px 0 16px" id="approved_status" name="approved_status" value="1"
                <?php if($approved_status == 'YES') echo "checked"?>>APPROVE
            <input type="radio" style="margin: 0 4px 0 16px" id="approved_status" name="approved_status" value="0"
                <?php if($approved_status == 'NO') echo "checked"?>>DISAPPROVE
        </div>

        <div class="form-group row">
            <div class="col-sm-8">
                <label for="approved_by" class="control-label"> APPROVED BY :</label>
                <input type="text" class="form-control" id="approved_by" name="" value="<?php echo $_SESSION['SESS_NAME']?>" disabled/>
            </div>
        </div>
        <div class="text-center">
            <button type="submit" id="save_btn" class="btn btn-block btn-primary" disabled>SAVE</button>
        </div>
    </form>
</div>
<script>
    $('input[name="approved_status"]').on('change', function (e) {
        let saveBtn = $('#save_btn');
        let currentVal = $('#current_value');
        if ($(this).val() === '' || $(this).val() ===  currentVal.val()){
            saveBtn.prop('disabled', true);
        }else {
            saveBtn.prop('disabled', false);
        }
    });
</script>