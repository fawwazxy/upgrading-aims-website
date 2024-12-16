<?php
require "../model/v02_attendance_function.php";
$id = $_POST['id'];
$shift = getShiftById($id)->fetch_assoc();
$time = getShiftTime($shift['start_time'], $shift['work_hour'], $shift['break_hour']);
?>
<form action="../controller/v02_aims_attendance_shift_update_exec.php" method="post">
    <input type="hidden" name="id" id="id" value="<? echo $id ?>">
    <div class="form-group row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label" for="code">Shift Code <span style="color: red; ">*</span></label>
                <input class="form-control" type="text" maxlength="12" id="code" name="code" value="<? echo $shift['code'] ?>"
                       placeholder="P-01" required>
            </div>
        </div>

        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label" for="description">Description</label>
                <input class="form-control" type="text" id="description" name="description" value="<? echo $shift['description'] ?>"
                       placeholder="Normal working hour (0800 - 1700)">
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label" for="start_time_update">Start Time <span style="color: red; ">*</span></label>
                <input class="form-control" type="time" id="start_time_update" name="start_time" value="<? echo $shift['start_time'] ?>" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label" for="end_time_update">End Time <span style="color: red; ">*</span></label>
                <input class="form-control" type="time" id="end_time_update" name="" value="<? echo $time['end'] ?>" disabled>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label" for="status">Status <span style="color: red; ">*</span></label>
                <select class="form-control" name="status" id="status">
                    <option value="1" <? if ($shift['status'] == '1') echo 'selected' ?>>Active</option>
                    <option value="0" <? if ($shift['status'] == '0') echo 'selected' ?>>Inactive</option>
                </select>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label" for="work_hour_update">Work Hour(s) <span style="color: red; ">*</span></label>
                <input class="form-control" type="number" id="work_hour_update" name="work_hour" step="0.5" min="0"
                       value="<? echo number_format($shift['work_hour'] / 60 / 60, 1); ?>">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label" for="break_hour_update">Break Hour(s) <span style="color: red; ">*</span></label>
                <input class="form-control" type="number" id="break_hour_update" name="break_hour" step="0.5" min="0"
                       value="<? echo number_format($shift['break_hour'] / 60 / 60, 1); ?>">
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-12">
            <button type="submit" class="btn btn-block btn-primary">Update</button>
        </div>
    </div>
</form>

<script type="text/javascript">
    $("#work_hour_update, #break_hour_update").on('change',function(){
        let currentObj=$(this);
        let currentVal= currentObj.val();
        let totalHour = parseFloat($('#work_hour_update').val()) + parseFloat($('#break_hour_update').val());
        let startTime = new Date ("1970-01-01 " + $('#start_time_update').val());

        if(!isNaN(currentVal)){
            let updatedVal=parseFloat(currentVal).toFixed(1);
            currentObj.val(updatedVal);

            $('#end_time_update').val(addHoursAndMinutesToTime(startTime, totalHour));
        }
        else{
            currentObj.val("0.0");
            $('#end_time_update').val("00:00:00");
        }
    });

    $("#start_time_update").on('change',function() {
        let startTime = new Date ("1970-01-01 " + $(this).val());
        let totalHour = parseFloat($('#work_hour_update').val()) + parseFloat($('#break_hour_update').val());

        if(!isNaN(totalHour)){
            $('#end_time_update').val(addHoursAndMinutesToTime(startTime, totalHour));
        }
    });
</script>
