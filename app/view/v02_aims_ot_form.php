<?php
include "../controller/auth.php";
require "../model/v02_aims_ot_function.php";

$otp_id = $_GET['otp_id']; //get otp id from otp list
$staff_id = $_SESSION['SESS_ID'];
$ot_permission = v02getOtPermissionById($otp_id)->fetch_assoc();
$isContractor = array_key_exists($staff_id, v02getContractorList());

if ($ot_permission['approval_status'] == 0){
    echo ("<script>
            alert('Your OT Permission is PENDING / DISAPPROVE. Please try again later.');
            window.history.back();
            </script>");
    exit();
}

$ot_day_closed = 15;
if ($_SESSION['SESS_DEPARTMENT_SUB'] == 'MOORING-GANG' || ($_SESSION['SESS_DEPARTMENT_SUB'] == 'TECHOPERATION' && $_SESSION['SESS_DEPARTMENT'] == 'AGSHIMSB')){
    $ot_day_closed = 20;
}else if ($isContractor){
    $ot_day_closed = 31;
}

$suggested_start_time = ($ot_permission['rate_mode'] == 1.5 ) ? "17:00" : "08:00";
$suggested_end_time = ($ot_permission['rate_mode'] == 1.5 ) ? "19:00" : "10:00";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <? require "../global/header.php"; ?>
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include "../global/menu_top.php"; ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <? include "../global/menu_left.php"; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    OVERTIME <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> CLAIM <i class="fa fa-caret-right"></i> NEW
                    <a href="aims_ot_form.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>
                        Switch to Version 01
                    </a>
                    <a href="v02_aims_ot_list_month.php" class="btn btn-default btn-sm" style="float: right;background-color: #FFA500; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-arrow-left" style="margin-right: 8px"></i>
                        Back to list
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_ot_migration_message.php"; ?>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label>P/S: YOUR OVERTIME CLAIM OF CURRENT MONTH ARE ONLY ACCEPTING DATE BEFORE <? echo $ot_day_closed ?>th.<br>
                            FOR OVERTIME SUBMITTED <span style="color: red; ">AFTER <? echo $ot_day_closed ?>th, YOUR CLAIM WILL BE PROCEED NEXT MONTH.</span></label>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-12">
                            <form method="post" action="../controller/v02_aims_ot_add_exec.php" enctype="multipart/form-data">
                                <input type="hidden" id="staff_id" name="staff_id" value="<?php echo $staff_id ?>" />
                                <input type="hidden" id="ot_permission_id" name="ot_permission_id" value="<? echo $otp_id; ?>" />

                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="month_claim">Month Claim:</label><br>
                                            <select required class="form-control" name="month_claim" id="month_claim">
                                                <? $suggested_month_claim = date('d') <= $ot_day_closed ? date("Y-m"): date("Y-m", strtotime("first day of next month", time()));
                                                if ($isContractor){
                                                    echo v02getDropDownMonthClaimContractor($suggested_month_claim, 0);
                                                }else{
                                                    echo v02getDropDownMonthClaim($suggested_month_claim, 0);
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="start_ot">Start:</label><br>
                                            <input type="time" required="" class="form-control" placeholder="" onchange="diff()" id="start_ot" name="start_ot" value="<? echo $suggested_start_time ?>" />
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="end_ot">End:</label><br>
                                            <input type="time" required class="form-control" placeholder="" onchange="diff()" id="end_ot" name="end_ot" value="<? echo $suggested_end_time ?>" />
                                            <span id="timeWarning" style="font-size: 12px;color: red"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="working_hours">Total Hours:</label><br>
                                            <input type="text" required readonly class="form-control" placeholder="" id="working_hours" name="working_hours" value="02H 00M" onkeyup="convertToUppercase(this)">
                                            <input type="hidden" id="total_hours" name="total_hours" value="2.0" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="date_ot">Date (Day):</label><br>
                                            <input type="text" class="form-control" name="" id="date-day" value="<? echo date('d/m/Y (l)', strtotime($ot_permission['created_at'])) ?>" disabled>
                                            <input type="hidden" id="date_ot" name="date_ot" value="<? echo date('Y-m-d', strtotime($ot_permission['created_at'])) ?>"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="form-group">
                                            <label>Attachment &nbsp; <span class="text-muted">(optional)</span>
                                                <span style="font-style: italic; color: red; margin-left: 8px">(Only pdf/jpeg/jpg/png/gif format file are allowed)</span>
                                            </label>
                                            <input type="hidden" name="MAX_FILE_SIZE">
                                            <input type="file" class="form-control" accept=".jpg,.jpeg,.png,.gif,.pdf" name="document" id="document">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="description">Work Description:</label><br>
                                            <textarea id="description" name="" rows="5" cols="70"  required="" class="form-control" placeholder=""
                                                      onkeyup="convertToUppercase(this)" disabled><? echo $ot_permission['description'] ?></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group text-center">
                                    <div class="col-lg-6 col-lg-offset-3">
                                        <button type="submit" id="submitBtn" class="btn btn-lg btn-block btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <? include "../global/footer.php"; ?>
    </div>
</div>

<script>
    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }

    function convertDateForIos(date) {
        let arr = date.split(/[- :]/);
        date = new Date(arr[0], arr[1]-1, arr[2], arr[3], arr[4], arr[5]);
        return date;
    }

    function diff() {
        let timeIn = $('#start_ot').val(),
            timeOut = $('#end_ot').val(),
            timeStart = "1970-1-1 " + timeIn+":00",
            timeEnd = "1970-1-1 " + timeOut+":00";

        if(timeOut<=timeIn){
            timeEnd =  "1970-1-2 " + timeOut + ":00";
        }

        let diffInMinutes = (convertDateForIos(timeEnd) - convertDateForIos(timeStart)) / 1000 / 60;
        let diffInHours = diffInMinutes/60;
        let hours = Math.floor(diffInHours);
        let minutes = Math.floor(diffInMinutes%60);

        minutes = minutes.toString().length<2?'0'+minutes:minutes;
        hours = hours.toString().length<2?'0'+hours:hours;

        $('#working_hours').val(hours + 'H ' + minutes + 'M');
        $('#total_hours').val(diffInHours.toFixed(2));
    }

    // old fx to calculate time difference (issue in iphone)
    // function diff() {
    //     var timein = $('#start_ot').val(),
    //         timeout = $('#end_ot').val(),
    //         timeStart = new Date("1970-1-1 " + timein),
    //         timeEnd = new Date("1970-1-1 " + timeout);

    //     if(timeout<=timein){
    //         timeEnd =  new Date("1970-1-2 " + timeout);
    //     }

    //     let diffInMinutes = (timeEnd - timeStart) / 1000 / 60;
    //     let diffInHours = diffInMinutes/60;
    //     let hours = Math.floor(diffInHours);
    //     let minutes = Math.floor(diffInMinutes%60);

    //     minutes = minutes.toString().length<2?'0'+minutes:minutes;
    //     hours = hours.toString().length<2?'0'+hours:hours;

    //     $('#working_hours').val(hours + 'H ' + minutes + 'M');
    //     $('#total_hours').val(diffInHours.toFixed(2));
    // }

    $('#start_ot, #end_ot').change(function (){
        let timeIn = $('#start_ot').val(),
            timeOut = $('#end_ot').val(),
            dateOt = $('#date_ot').val();

        let tomorrow = new Date(dateOt);
        tomorrow.setDate(tomorrow.getDate() + 1);

        let nextDay = String(tomorrow.getDate()).padStart(2,'0')+'/'+String(tomorrow.getMonth()+1).padStart(2,'0')+'/'+tomorrow.getFullYear();
        if(timeOut<=timeIn){
            $('#timeWarning').html('END TIME > START TIME;<br> End time date has been set to '+nextDay);
        }else{
            $('#timeWarning').html('');
        }
    });
</script>
</body>
</html>

