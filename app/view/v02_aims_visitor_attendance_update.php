<?php
require "../controller/auth.php";
require "../model/v02_aims_visitor_function.php";
$id = $_POST['id'];
$company = $_POST['company'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$list = getAttendanceListById($id)->fetch_assoc();
$disabled = "";
if ($list['clock_in_location'] == '' ){
    $disabled = 'disabled';
}
?>
<div class="row">
    <div class="col-lg-12">
        <form method="post" action="../controller/v02_aims_visitor_attendance_update_exec.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<? echo $id; ?>">
            <input type="hidden" name="company" value="<? echo $company; ?>">
            <input type="hidden" name="start_date" value="<? echo $start_date; ?>">
            <input type="hidden" name="end_date" value="<? echo $end_date; ?>">
            <div class="form-group row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label" for="clock_in">Clock In: <span style="color: red; ">*</span></label>
                        <input class="form-control" type="datetime-local" id="clock_in" name="clock_in" value="<? echo $list['clock_in_time']; ?>" required>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label" for="clock_in_location">Clock In Location: <span style="color: red; ">*</span></label>
                        <a class="btn btn-sm btn-primary" style="float: right" id="clock_in_refresh"><i class="fa fa-refresh"></i></a>
                        <input class="form-control" id="clock_in_location" name="clock_in_location" value="<? echo $list['clock_in_location']; ?>" readonly>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label" for="clock_in_qr">Clock In QR Location: <span style="color: red; ">*</span></label>
                        <select class="form-control" id="clock_in_qr" name="clock_in_qr" required>
                            <option value="">-- Select QR Location --</option>
                            <? echo getDropdownQRLocation($list['clock_in_qr']); ?>
                        </select>
                    </div>
                </div>
            </div>

            <? if (!empty($list['clock_out_time'])){ ?>
            <div class="form-group row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label" for="clock_out">Clock Out: <span style="color: red; ">*</span></label>
                        <input class="form-control" type="datetime-local" id="clock_out" name="clock_out" value="<? echo $list['clock_out_time']; ?>" required>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label" for="clock_out_location">Clock Out Location: <span style="color: red; ">*</span></label>
                        <a class="btn btn-sm btn-primary" style="float: right" id="clock_out_refresh"><i class="fa fa-refresh"></i></a>
                        <input class="form-control" id="clock_out_location" name="clock_out_location"  value="<? echo $list['clock_out_location']; ?>" readonly>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label" for="clock_out_qr">Clock Out QR Location: <span style="color: red; ">*</span></label>
                        <select class="form-control" id="clock_out_qr" name="clock_out_qr" required>
                            <option value="">-- Select QR Location --</option>
                            <? echo getDropdownQRLocation($list['clock_out_qr']); ?>
                        </select>
                    </div>
                </div>
            </div>
            <? } ?>

            <div class="form-group row">
                <div class="col-lg-8">
                    <div class="form-group">
                        <label class="control-label" for="purpose">Purpose:</label>
                        <textarea class="form-control" id="purpose" name="purpose" rows="4"><? echo $list['reason']; ?></textarea>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label" for="role">Role:</label>
                        <select class="form-control" id="role" name="role">
                            <? foreach (getVisitorType('', true) as $index => $name) { ?>
                                <option value="<? echo $index ?>" <? if ($index == $list['role']) echo 'selected'; ?>><? echo $name ?></option>
                            <? } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-6 col-lg-offset-3">
                    <button type="submit" class="btn btn-lg btn-block btn-primary" id="submit" <? echo $disabled ?>>Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function(){
        $("#clock_in_refresh").click(function(){
            getClockInCurrentCoordinate();
        });

        $("#clock_out_refresh").click(function(){
            getClockOutCurrentCoordinate();
        });
    });

    function getClockInCurrentCoordinate(){
        navigator.permissions.query({
            name: 'geolocation'
        }).then(function(result) {
            if (result.state === 'denied') {
                alert('Please allow location permission to use this feature.')
            }
            result.onchange = function() {
                console.log(result.state);
            }
        });

        let geoElement = $('#clock_in_location');

        navigator.geolocation.getCurrentPosition(function (position) {
            let latitude = position.coords.latitude;
            let longitude = position.coords.longitude;
            if (latitude == null) {
                alert("Location/GPS is off");
            }
            geoElement.val(latitude + ', ' + longitude);
            geoElement.blur();
        });
    }

    function getClockOutCurrentCoordinate(){
        navigator.permissions.query({
            name: 'geolocation'
        }).then(function(result) {
            if (result.state === 'denied') {
                alert('Please allow location permission to use this feature.')
            }
            result.onchange = function() {
                console.log(result.state);
            }
        });

        let geoElement = $('#clock_out_location');

        navigator.geolocation.getCurrentPosition(function (position) {
            let latitude = position.coords.latitude;
            let longitude = position.coords.longitude;
            if (latitude == null) {
                alert("Location/GPS is off");
            }
            geoElement.val(latitude + ', ' + longitude);
            geoElement.blur();
        });
    }
</script>
</body>
</html>
