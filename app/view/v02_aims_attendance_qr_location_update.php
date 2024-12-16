<?php
require "../model/v02_attendance_function.php";
$id = $_POST['id'];
$qr_branch = getQrBranchList();
$location = getQrLocationById($id)->fetch_assoc();
?>
<form action="../controller/v02_aims_attendance_qr_location_update_exec.php" method="post">
    <input type="hidden" name="id" value="<? echo $location['id'] ?>">
    <div class="form-group row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label" for="update_cawangan_kod">Branch <span style="color: red; ">*</span></label>
                <small class="cancel-link" id="update-cancel-code" style="display: none">Cancel</small>
                <select class="form-control" id="update_cawangan_kod" name="branch" style="display: block">
                    <option value="custom">Other (Please specify branch name)</option>
                    <option value="" selected>-- Select Branch --</option>
                    <? foreach ($qr_branch as $option){ ?>
                        <option value="<? echo $option['cawangan_kod'] ?>"
                            <? if ($option['cawangan_kod'] == $location['cawangan_kod']) echo 'selected' ?>>
                            <? echo $option['cawangan_kod'] ?></option>
                    <? } ?>
                </select>
                <input class="form-control" type="text" id="update-custom" name="custom" style="display: none"
                       placeholder="Custom Branch Name">
            </div>
        </div>

        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label" for="name">Name</label>
                <input class="form-control" type="text" id="name" name="name" value="<? echo $location['name'] ?>"
                       placeholder="AGHSB-MAIN DOOR BLOCK B">
            </div>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label" for="status">Status <span style="color: red; ">*</span></label>
                <select class="form-control" name="status" id="status">
                    <option value="1" <? if ($location['status'] == '1') echo 'selected' ?>>Active</option>
                    <option value="0" <? if ($location['status'] == '0') echo 'selected' ?>>Inactive</option>
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label" for="latitude">Latitude <span style="color: red; ">*</span></label>
                <input class="form-control" type="text" id="latitude" name="latitude" value="<? echo $location['latitude'] ?>"
                       placeholder="5.322749124" required>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label" for="longitude">Longitude <span style="color: red; ">*</span></label>
                <input class="form-control" type="text" id="longitude" name="longitude" value="<? echo $location['longitude'] ?>"
                       placeholder="103.130074254" required>
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
    $('#update_cawangan_kod').on('change', function (){
        let codeValue = $(this).val();

        if (codeValue === 'custom'){
            $(this).attr('style', 'display: none');
            $('#update-custom, #update-cancel-code').attr('style', 'display: block');
        }
    });

    $('#update-cancel-code').on('click', function (){
        $('#update-custom, #update-cancel-code').attr('style', 'display: none');
        $('#update-custom').val('');
        $('#update_cawangan_kod').attr('style', 'display: block').val('<? echo $location['cawangan_kod'] ?>');
    });
</script>