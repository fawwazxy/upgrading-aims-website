<?php
include "../controller/auth.php";
require "../model/v02_aims_ot_function.php";

$id = $_POST['id'];
$ot_info = v02getOtById($id)->fetch_assoc();

//convert total hours to hours & minutes
$hours = floor($ot_info['total_hours']);
$minutes = ($ot_info['total_hours'] - $hours) * 60;
$minutes = number_format($minutes);

// 31/07/2022 - This page/features opened for HOC only (AVSB & TKSB) [Requested by Noraida Syafinaz]
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
    <form method="post" action="../controller/v02_aims_ot_hod_update_claim_exec.php" enctype="multipart/form-data">
        <input type="hidden" class="form-control" id="id" name="id" value="<? echo $id; ?>" />
        <input type="hidden" name="no_staff" value="<? echo $ot_info['no_staff'];?>" /><!-- This input is used if HR change month session id-->
        <label class="text-danger">** Required</label>
        <br>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="month_claim">Month Claim: <span style="color: red">**</span></label><br>
                <select required class="form-control" name="month_claim" id="month_claim" disabled>
                    <option value=""><? echo $ot_info['month_session'] ?></option>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label for="date_ot">Date: <span style="color: red">**</span>&nbsp;</label><br>
                <input type="date" required="" class="form-control" placeholder="" id="date_ot" name=""
                       value="<? echo date("Y-m-d", strtotime($ot_info['date'])) ?>" readonly/>
            </div>

            <div class="form-group col-md-4">
                <label for="day_ot">Day:<span style="color: red">**</span>&nbsp;</label><br>
                <input type="text" required class="form-control" placeholder="" id="day_ot" name=""
                       value="<? echo date("l", strtotime($ot_info['date'])) ?>" disabled />
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="start_ot">Start: <span style="color: red">**</span>&nbsp;</label><br>
                <input type="time" required class="form-control" placeholder="" id="start_ot" name="start_ot"
                       value="<? echo $ot_info['start_ot'] ?>" disabled /><!--onchange="diff()"-->
            </div>

            <div class="form-group col-md-4">
                <label for="end_ot">End:<span style="color: red">**</span>&nbsp;</label><br>
                <input type="time" required class="form-control" placeholder="" id="end_ot" name="end_ot"
                       value="<? echo $ot_info['end_ot'] ?>" disabled /><!--onchange="diff()"-->
                <span id="timeWarning" style="color: red"></span>
            </div>

            <div class="form-group col-md-4">
                <label for="working_hours">Working Period: <span style="color: red">**</span>&nbsp;</label><br>
                <div class="row">
                    <div class="col-sm-6" style="padding-right: 0">
                        <input autocomplete="off" required type="number" step="0.01" min="0" max="23.99" class="form-control col-sm-6" id="total_hours" name="total_hours" value="<? echo $ot_info['total_hours']?>" />
                    </div>
                    <div class="col-sm-6" style="padding-left: 0">
                        <input type="text" required class="form-control col-sm-6" placeholder="" id="working_hours" name=""
                               value="<? echo sprintf("%02s",$hours).'H '.sprintf("%02s",$minutes).'M'; ?>" disabled>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="type_claim">Types of Claim: <span style="color: red">**</span>&nbsp;</label><br>
                <input type="text" required class="form-control" placeholder="" id="type_claim" name="" value="OT CLAIM" disabled>
            </div>

            <div class="form-group col-md-8">
                <label for="rate_mode">Rate Mode: <span style="color: red">**</span>&nbsp;</label><br>
                <select required class="form-control" name="rate_mode" id="rate_mode">
                    <option value="1.5" <? if ($ot_info['rate_mode'] == 1.5) echo 'selected'; ?>>1.5 - NORMAL WORKING DAY</option>
                    <option value="2.0" <? if ($ot_info['rate_mode'] == 2.0) echo 'selected'; ?>>2.0 - OFF-DAY (WEEKEND)</option>
                    <option value="3.0" <? if ($ot_info['rate_mode'] == 3.0) echo 'selected'; ?>>3.0 - PUBLIC HOLIDAY</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-12">
                <label for="description">Work Description: </label><br>
                <input type="text" required class="form-control" placeholder="" id="description" name="description"
                       onkeyup="convertToUppercase(this)" value="<? echo $ot_info['description'] ?>">
            </div>
        </div>

        <div class="modal-footer">
            <div class="text-center">
                <button type="submit" class="btn btn-block btn-primary">SAVE</button>
            </div>
        </div>
    </form>
    <script>
        function convertToUppercase(el) {
            if (!el || !el.value) return;
            el.value = el.value.toUpperCase();
        }

        function convertDateForIos(date) {
            let arr = date.split(/[- :]/);
            date = new Date(arr[0], arr[1]-1, arr[2], arr[3], arr[4], arr[5]);
            return date;
        }

        $('#total_hours').on('input', function (evt) {
            let total_hours = $('#total_hours').val();
            let hours = Math.floor(total_hours);
            let minutes = Math.floor((total_hours-hours) * 60);

            minutes = minutes.toString().length<2?'0'+minutes:minutes;
            hours = hours.toString().length<2?'0'+hours:hours;

            $('#working_hours').val(hours + 'H ' + minutes + 'M');
        });

        /*function diff() {
            var timein = $('#start_ot').val(),
                timeout = $('#end_ot').val(),
                timeStart = "1970-1-1 " + timein+":00",
                timeEnd = "1970-1-1 " + timeout+":00";

            if(timeout<=timein){
                timeEnd =  "1970-1-2 " + timeout + ":00";
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

        $('#start_ot, #end_ot').change(function (){
            let timein = $('#start_ot').val(),
                timeout = $('#end_ot').val(),
                dateOt = $('#date_ot').val();

            let tomorrow = new Date(dateOt);
            tomorrow.setDate(tomorrow.getDate() + 1);

            let nextDay = String(tomorrow.getDate()).padStart(2,'0')+'/'+String(tomorrow.getMonth()+1).padStart(2,'0')+'/'+tomorrow.getFullYear();
            if(timeout<=timein){
                $('#timeWarning').html('END TIME > START TIME;<br> End time date has been set to '+nextDay);
            }else{
                $('#timeWarning').html('');
            }
        });*/
    </script>
</div>
</body>
</html>