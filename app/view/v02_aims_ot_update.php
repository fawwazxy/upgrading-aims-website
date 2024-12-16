<?php
require "../model/v02_aims_ot_function.php";

$id = $_POST['id'];
$ot_info = v02getOtById($id)->fetch_assoc();

//convert total hours to hours & minutes
$hours = floor($ot_info['total_hours']);
$minutes = ($ot_info['total_hours'] - $hours) * 60;
$minutes = number_format($minutes);
?>
<div id="wrapper">
    <form method="post" action="../controller/v02_aims_ot_update_exec.php" enctype="multipart/form-data">
        <input type="hidden" class="form-control" id="id" name="id" value="<? echo $ot_info['id'] ?>"/>
        <div class="row">
            <div class="form-group col-md-4">
                <label for="month_claim">Month Claim:</label><br>
                <select required class="form-control" name="" id="month_claim" disabled>
                    <option value=""><? echo $ot_info['month_session'] ?></option>
                </select>
            </div>

            <div class="form-group col-md-4">
                <label for="date_ot">Date:</label><br>
                <input type="text" required="" class="form-control" placeholder="" id="date_ot" name=""
                       value="<? echo date("d/m/Y", strtotime($ot_info['date'])) ?>" disabled/>
            </div>

            <div class="form-group col-md-4">
                <label for="day_ot">Day:</label><br>
                <input type="text" required class="form-control" placeholder="" id="day_ot" name=""
                       value="<? echo date("l", strtotime($ot_info['date'])) ?>" disabled />
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="start_ot">Start:</label><br>
                <input type="time" required onchange="diff()" class="form-control" placeholder="" id="start_ot" name="start_ot" value="<? echo $ot_info['start_ot'] ?>" />
            </div>

            <div class="form-group col-md-4">
                <label for="end_ot">End:</label><br>
                <input type="time" required onchange="diff()" class="form-control" placeholder="" id="end_ot" name="end_ot" value="<? echo $ot_info['end_ot'] ?>" />
                <span id="timeWarning" style="font-size: 12px;color: red"></span>
            </div>

            <div class="form-group col-md-4">
                <label for="working_hours">Working Period:</label><br>
                <input type="text" required readonly class="form-control" placeholder="" id="working_hours" name=""
                       value="<? echo sprintf("%02s",$hours).'H '.sprintf("%02s",$minutes).'M'; ?>" disabled>
                <input type="hidden" id="total_hours" name="total_hours" value="<? echo $ot_info['total_hours']?>" />
            </div>
        </div>

        <div class="row">
            <div class="form-group col-md-4">
                <label for="type_claim">Types of Claim:</label><br>
                <input type="text" required class="form-control" placeholder="" id="type_claim" name="" value="OT CLAIM" disabled>
            </div>

            <div class="form-group col-md-8">
                <label for="description_ot">Work Description:</label><br>
                <input type="text" required class="form-control" placeholder="" id="description_ot" name="description_ot" value="<? echo $ot_info['description'] ?>" disabled>
            </div>
        </div>

        <div class="text-center" style="margin-top: 16px">
            <button type="submit" id="updateBtn" class="btn btn-block btn-primary">UPDATE</button>
        </div>
    </form>
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

    $('#start_ot, #end_ot').change(function (){
        let timein = $('#start_ot').val(),
            timeout = $('#end_ot').val(),
            dateOt = $('#date_ot').val();

        let tomorrow = new Date(dateOt);
        tomorrow.setDate(tomorrow.getDate() + 1);

        let nextDay = tomorrow.getDate()+'/'+(tomorrow.getMonth()+1)+'/'+tomorrow.getFullYear();
        if(timeout<=timein){
            // alert('Please make sure END TIME is greater than START TIME');
            $('#timeWarning').html('END TIME > START TIME;<br> End time date has been set to '+nextDay);
            // $('#submitBtn').attr({'disabled': true, 'title': 'Please make sure END TIME is greater than START TIME'});
        }else{
            $('#timeWarning').html('');
            // $('#submitBtn').attr('disabled', false);
        }
    });
</script>
