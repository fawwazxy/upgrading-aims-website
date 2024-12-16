<?php

include ('../controller/auth.php');


require "../model/aims_gl_function.php";
require "../model/lookup.php";


$id = $_POST['id'];
$book_info = getBookingById($id)->fetch_assoc();
date_default_timezone_set("Asia/Kuala_Lumpur");

?>


<!-- <div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Booking ID</label>
    </div>
    <div class="col-xs-8">
      <?echo '<b>'.$book_info['id'].'</b>';?>
    </div>
</div>  -->
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Name</label>
    </div>
    <div class="col-xs-8">
       <?echo '<b>'.$book_info['client_name'].'</b>';?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Phone No</label>
    </div>
    <div class="col-xs-8">
       <?echo '<b>'.$book_info['client_phone_no'].'</b>';?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Company</label>
    </div>
    <div class="col-xs-8">
       <?echo '<b>'.$book_info['company_name'].'</b>';?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Arrival Date</label>
    </div>
    <div class="col-xs-8">
       <?echo '<b>'.$book_info['arrival_date'].'</b>';?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Arrival Time</label>
    </div>
    <div class="col-xs-8">
       <?echo '<b>'.$book_info['arrival_time'].'</b>';?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Departure Date</label>
    </div>
    <div class="col-xs-8">
       <?echo '<b>'.$book_info['departure_date'].'</b>';?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Departure Time</label>
    </div>
    <div class="col-xs-8">
       <?echo '<b>'.$book_info['departure_time'].'</b>';?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Room No</label>
    </div>
    <div class="col-xs-8">
       <?echo '<b>'.$book_info['room_id'].'</b>';?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Bed No</label>
    </div>
    <div class="col-xs-8">
       <?echo '<b>'.$book_info['bed_id'].'</b>';?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Locker No</label>
    </div>
    <div class="col-xs-8">
       <?echo '<b>'.$book_info['locker_id'].'</b>';?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-12">
        <label><u><i>Person Incharge Check In</i></u></label>
    </div>
    <div class="col-xs-4">
        <label>Confirmed By</label>
    </div>
    <div class="col-xs-8">
       <?echo '<b>'.$book_info['pic_cin'].'</b>';?>
    </div>
</div>
<div class="form-group row" align="left">
    <div class="col-xs-4">
        <label>Date</label>
    </div>
    <div class="col-xs-8">
<? echo '<b>'.date('d/m/Y',strtotime($book_info['pic_indate'])).'</b>';?>    </div>
</div>

<script>
    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>
