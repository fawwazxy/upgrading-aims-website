<?php
require "../controller/auth.php";
require "../model/v02_aims_visitor_function.php";
date_default_timezone_set('Asia/Kuala_Lumpur');
$current_datetime = date('Y-m-d H:i', time());
$id = $_POST['id'];
$company = $_POST['company'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$list = getAttendanceListById($id)->fetch_assoc();
?>
<div class="row">
    <div class="col-lg-12">

        <table class="table table-borderless">
            <tbody>
            <tr>
                <th colspan="3" style="background-color: orange; color: white">Clock In</th>
            </tr>
            <tr>
                <th style="width: 12%">Time</th>
                <th style="width: 2%">:</th>
                <td><? echo $list['clock_in_time']; ?></td>
            </tr>
            <tr>
                <th>Location</th>
                <th>:</th>
                <td><? echo $list['clock_in_location']; ?></td>
            </tr>
            <tr>
                <th>QR Location</th>
                <th>:</th>
                <td><? echo $list['clock_in_qr']; ?></td>
            </tr>
            </tbody>
        </table>

        <form method="post" action="../controller/v02_aims_visitor_attendance_clock_out_modal_exec.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<? echo $id; ?>">
            <input type="hidden" name="company" value="<? echo $company; ?>">
            <input type="hidden" name="start_date" value="<? echo $start_date; ?>">
            <input type="hidden" name="end_date" value="<? echo $end_date; ?>">
            <div class="form-group row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label" for="clock_out">Clock Out: <span style="color: red; ">*</span></label>
                        <input class="form-control" type="datetime-local" id="clock_out" name="clock_out" value="<? echo $current_datetime; ?>" required>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label" for="clock_out_location">Clock Out Location: <span style="color: red; ">*</span></label>
                        <a class="btn btn-sm btn-primary" style="float: right" onclick="getCurrentCoordinate()"><i class="fa fa-refresh"></i></a>
                        <input class="form-control" id="clock_out_location" name="clock_out_location" readonly>
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

            <div class="form-group row">
                <div class="col-lg-6 col-lg-offset-3">
                    <button type="submit" class="btn btn-lg btn-block btn-primary" id="submit" disabled>Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function (){
        getCurrentCoordinate()
    });

    function getCurrentCoordinate(){
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
            $('#submit').attr('disabled', false);
            geoElement.blur();
        });
    }
</script>
</body>
</html>
