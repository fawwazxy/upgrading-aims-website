<?php
require "../controller/auth.php";
require "../model/v02_aims_visitor_function.php";
date_default_timezone_set('Asia/Kuala_Lumpur');
$current_datetime = date('Y-m-d H:i', time());
?>
<div class="row">
    <div class="col-lg-12">
        <form method="post" action="../controller/v02_aims_visitor_attendance_add_exec.php" enctype="multipart/form-data">
            <div class="form-group row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label" for="ic_number">Visitor IC Number: <span style="color: red; ">*</span></label>
                        <input class="form-control" id="ic_number" maxlength="12" name="ic_number"
                               oninput="this.value = this.value.replace(/[^0-9.]/g,'').replace(/(\..*)\./g,'$1');" placeholder="without dash (-)"
                               required type="text">
                        <div id="visitor_name"></div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label" for="clock_in">Clock In: <span style="color: red; ">*</span></label>
                        <input class="form-control" type="datetime-local" id="clock_in" name="clock_in" value="<? echo $current_datetime; ?>" required>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label" for="clock_in_location">Clock In Location: <span style="color: red; ">*</span></label>
                        <a class="btn btn-sm btn-primary" style="float: right" onclick="getCurrentCoordinate()"><i class="fa fa-map-marker"></i></a>
                        <input class="form-control" id="clock_in_location" name="clock_in_location" readonly>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label" for="purpose">Purpose:</label>
                        <textarea class="form-control" id="purpose" name="purpose" rows="4"></textarea>
                    </div>
                </div>


                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label" for="qr_location">QR Location: <span style="color: red; ">*</span></label>
                        <select class="form-control" id="qr_location" name="qr_location" required>
                            <option value="">-- Select QR Location --</option>
                            <? echo getDropdownQRLocation(''); ?>
                        </select>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="form-group">
                        <label class="control-label" for="role">Role:</label>
                        <select class="form-control" id="role" name="role">
                            <? foreach (getVisitorType('', true) as $index => $name) { ?>
                                <option value="<? echo $index ?>"><? echo $name ?></option>
                            <? } ?>
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
    $(document).ready(function () {
        getCurrentCoordinate();
    })

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

        let geoElement = $('#clock_in_location');

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
    /*let ic = $('#ic_number').val();
    if (ic.length < 12) {
        alert('IC Number should be 12 digits');
        return false;
    }
    });*/
    $("#ic_number").change(function () {
        let ic_no = $("#ic_number").val();
        $.ajax({
            type:'POST',
            url:'../controller/v02_aims_visitor_name_exec.php',
            data: {ic_number:ic_no},
            success:function(data){
                if (data){
                    $('#ic_number').addClass("is-valid");
                    $('#visitor_name').text(data).addClass("valid-feedback");
                } else {
                    $('#ic_number').addClass("is-invalid");
                    $('#visitor_name').text('Cannot recognize the ic number').addClass("invalid-feedback");
                }
            }
        });
        return false
    });
</script>
