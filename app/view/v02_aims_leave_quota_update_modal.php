<?php
require "../model/v02_aims_leave_function.php";
$quota_id = $_POST['id'];
$quota = getLeaveQuotaById($quota_id)->fetch_assoc();
?>
<input name="quota_id" type="hidden" class="input-short" value="<? echo $quota['id'];?>" />
<input name="staff_id" type="hidden" class="input-short" value="<? echo $quota['staff_id'];?>" />

<div class="form-group row">
    <div class="col-lg-4">
        <div class="form-group">
            <label class="control-label" for="update_leave_type">Jenis cuti: <span style="color: red; ">*</span></label>
            <select class="form-control" name="leave_type" id="update_leave_type">
                <optgroup label="Cuti berkuota">
                    <? foreach (getLeaveQuotaList(true) as $index){ ?>
                        <option value="<? echo $index?>" <? if ($index == $quota['leave_type']) echo 'selected'?>>
                            <? echo getLeaveType($index) ?>
                        </option>
                    <? } ?>
                </optgroup>
                <!--<optgroup label="Cuti tanpa kuota (tidak disarankan)">
                    <?/* foreach (getLeaveQuotaList(false) as $index){ */?>
                        <option value="<?/* echo $index*/?>" <?/* if ($index == $quota['leave_type']) echo 'selected'*/?>>
                            <?/* echo getLeaveType($index) */?>
                        </option>
                    <?/* } */?>
                </optgroup>-->
            </select>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label class="control-label" for="update_start_date">Tarikh mula kuota: <span style="color: red; ">*</span></label>
            <input class="form-control" type="date" id="update_start_date" name="start_date" value="<? echo $quota['start_date'] ?>">
            <b id="update_dateWarning" class="text-danger" style="display: none">Tarikh mula mestilah sebelum tarikh akhir</b>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label class="control-label" for="update_end_date">Tarikh akhir kuota: <span style="color: red; ">*</span></label>
            <input class="form-control" type="date" id="update_end_date" name="end_date" value="<? echo $quota['end_date'] ?>">
        </div>
    </div>
</div>

<div class="form-group row">
    <div class="col-lg-4">
        <div class="form-group">
            <label class="control-label" for="update_entitled_balance">Kuota cuti: <span style="color: red; ">*</span></label>
            <input class="form-control" type="number" step="0.5" id="update_entitled_balance" name="entitled_balance" value="<? echo $quota['entitled_balance'] ?>">
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label class="control-label" for="update_current_balance">Baki terkini: <span style="color: red; ">*</span></label>
            <input class="form-control" type="number" step="0.5" id="update_current_balance" name="current_balance" value="<? echo $quota['current_balance'] ?>">
        </div>
    </div>

    <div class="col-lg-4">
        <div class="form-group">
            <label class="control-label" for="update_used_balance">Penggunaan: </label>
            <input class="form-control" type="text" id="update_used_balance" name="" value="<? echo number_format($quota['entitled_balance'] - $quota['current_balance'], 1)?>" disabled>
        </div>
    </div>
</div>

<script>
    $('#update_entitled_balance, #update_current_balance').on('focusout', function (){
        let entitled = $('#update_entitled_balance');
        let current =  $('#update_current_balance');
        let ent_value = parseFloat(entitled.val()); ent_value = (entitled.val() !== '') ? ent_value.toFixed(1) : 0;
        let cur_value = parseFloat(current.val()); cur_value = (current.val() !== '') ? cur_value.toFixed(1) : 0;

        entitled.val(ent_value);
        current.val(cur_value);

        let used = (ent_value-cur_value).toFixed(1);

        $('#update_used_balance').val(used);
    });

    $("#update_start_date, #update_end_date").on('change',function(){
        let startDate = $('#update_start_date').val();
        let endDate = $('#update_end_date').val();
        let dateWarning = $('#update_dateWarning');
        let submitBtn = $('#updateQuotaBtn');

        if (startDate > endDate){
            dateWarning.attr('style', 'display: block');
            submitBtn.attr('disabled', true);
        }else{
            dateWarning.attr('style', 'display: none');
            submitBtn.attr('disabled', false);
        }
    });
</script>
