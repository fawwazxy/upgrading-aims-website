<?php
require "../model/v02_aims_inout_function.php";
$id = $_POST['id'];
$in_out = getInOutById($id)->fetch_assoc();
?>
<form method="post" action="../controller/v02_aims_inout_update_exec.php" enctype="multipart/form-data">
    <input type="hidden" class="input-short" name="id" value="<? echo $id;?>" />
    <div class="form-group">

        <div class="form-group row">
            <div class="col-lg-4">
                <div class="form-group">
                    <label class="control-label" for="date">Date: <span style="color: red; ">*</span></label>
                    <input class="form-control" type="date" id="date" name="date" value="<? echo $in_out['date'] ?>" required>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="form-group">
                    <label class="control-label" for="update_time_out">Time Out: <span style="color: red; ">*</span></label>
                    <input class="form-control" type="time" id="update_time_out" name="time_out" value="<? echo $in_out['time_out'] ?>" required>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="form-group">
                    <label class="control-label" for="update_time_in">Time In: <span style="color: red; ">*</span></label>
                    <input class="form-control" type="time" id="update_time_in" name="time_in" value="<? echo $in_out['time_in'] ?>" required>
                </div>
                <b id="update_timeWarning" style="font-size: 12px;color: red"></b>
            </div>
        </div>

        <div class="form-group" >
            <label class="control-label" for="description">Description: <span style="color: red; ">*</span></label><br>
            <textarea class="form-control" rows="2" id="description" name="description" required><? echo $in_out['description'] ?></textarea>
        </div>

        <div class="form-group">
            <label class="control-label" for="document">Attachment/Document</label>
            <? echo ($in_out['document_name']) ? '<p>'.$in_out['document_name'].'</p>' : '<p class="text-muted" style="font-style: italic">- No Attachment Saved -</p>'; ?>
            <label class="control-label" for="document">Update Attachment/Document <span class="text-muted">(pdf/jpg/png/HEIC/HEIF)</span></label>
            <input class="" type="file" id="document" name="document" accept=".jpg,.jpeg,.png,.gif,.pdf">
            <input type="hidden" name="MAX_FILE_SIZE" value="4175639">
        </div>
        <br>
        <button type="submit" id="update_submitBtn" class="btn btn-block btn-success btn-rounded btn-md ml-4" onclick="return Confirm()">Update</button>
    </div>
</form>

<script>
    $('#update_time_out, #update_time_in').change(function (){
        let timeIn = $('#update_time_in').val(),
            timeOut = $('#update_time_out').val();

        timeIn = (timeIn.length === 5) ? timeIn+':00' : timeIn;
        timeOut = (timeOut.length === 5) ? timeOut+':00' : timeOut;

        let diffInMinutes = (convertDateForIos("1970-1-1 " + timeIn) - convertDateForIos("1970-1-1 " + timeOut)) / 1000 / 60;
        console.log(diffInMinutes);

        if(timeOut > timeIn){
            $('#update_timeWarning').html('TIME IN must be greater than TIME OUT<br>');
            $('#update_submitBtn').attr('disabled', true);
        }else if(diffInMinutes > 120){
            $('#update_timeWarning').html('Maximum In Out period is 2 hours<br>');
            $('#update_submitBtn').attr('disabled', true);
        }else{
            $('#update_timeWarning').html('');
            $('#update_submitBtn').attr('disabled', false);
        }
    });
</script>