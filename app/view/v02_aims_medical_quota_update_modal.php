<?php
require "../model/v02_aims_medical_function.php";
$quota_id = $_POST['id'];
$quota = getMedicalQuotaById($quota_id)->fetch_assoc();
?>
<input name="quota_id" type="hidden" class="input-short" value="<? echo $quota['id'];?>" />
<input name="staff_id" type="hidden" class="input-short" value="<? echo $quota['staff_id'];?>" />

<div class="form-group row">
    <div class="col-lg-6">
        <div class="form-group">
            <label class="control-label" for="update_start_date">Quota Start Date: <span style="color: red; ">*</span></label>
            <input class="form-control" type="date" id="update_start_date" name="start_date" value="<? echo $quota['start_date'] ?>">
            <b id="update_dateWarning" class="text-danger" style="display: none">Start Date must before End Date</b>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="form-group">
            <label class="control-label" for="update_end_date">Quota End Date: <span style="color: red; ">*</span></label>
            <input class="form-control" type="date" id="update_end_date" name="end_date" value="<? echo $quota['end_date'] ?>">
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-lg-4">
        <div class="form-group">
            <label class="control-label" for="update_entitled_balance">Entitled Medical Quota: <span style="color: red; ">*</span></label>
            <input class="form-control" type="number" step="0.01" max="99999999.99" id="update_entitled_balance" name="entitled_balance" value="<? echo $quota['entitled_balance'] ?>">
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label class="control-label" for="update_current_balance">Current Balance: <span style="color: red; ">*</span></label>
            <input class="form-control" type="number" step="0.01" max="99999999.99" id="update_current_balance" name="current_balance" value="<? echo $quota['current_balance'] ?>">
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label class="control-label" for="update_used_balance">Usage: </label>
            <input class="form-control" type="text" id="update_used_balance" name="" value="<? echo number_format($quota['entitled_balance'] - $quota['current_balance'], 2) ?>" disabled>
        </div>
    </div>
</div>

<script>
    $('#update_entitled_balance, #update_current_balance').on('focusout', function (){
        let entitled = $('#update_entitled_balance');
        let current =  $('#update_current_balance');
        let ent_value = parseFloat(entitled.val()); ent_value = (entitled.val() !== '') ? ent_value.toFixed(2) : 0;
        let cur_value = parseFloat(current.val()); cur_value = (current.val() !== '') ? cur_value.toFixed(2) : 0;

        if($(this).attr('id') === 'entitled_balance'){
            cur_value = ent_value;
        }

        entitled.val(ent_value);
        current.val(cur_value);

        let used = (ent_value-cur_value).toFixed(2);

        $('#update_used_balance').val(used);
    });


    $("#update_start_date, #update_end_date").on('change',function(){
        let startDate = $('#update_start_date').val();
        let endDate = $('#update_end_date').val();
        let dateWarning = $('#update_dateWarning');
        let submitBtn = $('#update_submitQuotaBtn');

        if (startDate > endDate){
            dateWarning.attr('style', 'display: block');
            submitBtn.attr('disabled', true);
        }else{
            dateWarning.attr('style', 'display: none');
            submitBtn.attr('disabled', false);
        }
    });
</script>