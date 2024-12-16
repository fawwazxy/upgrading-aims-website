<?php
include "../controller/auth.php";
require "../model/aims_travel_function.php";
require "../model/lookup.php";

$id = $_POST['id'];
$travel = getTravelById($id)->fetch_assoc();
?>
<style>
    .separator {
        display: flex;
        align-items: center;
        text-align: center;
        padding-bottom: 10px;
        padding-top: 10px;
    }
    .separator::before, .separator::after {
        content: '';
        flex: 1;
        border-top: 3px double #8c8b8b;
    <!--border-bottom: 1px solid #000;-->
    }
    .separator::before {
        margin-right: .25em;
    }
    .separator::after {
        margin-left: .25em;
    }
    @media print {
        #printPageButton {
            display: none;
        }
    }
    img {
        float: left;
    }
    .approval-status{
         padding:5px;
         border-radius:5px;
         font-weight:bold;
         color:white;
     }
</style>

<!--<table>
    <tr>
        <td style="width: 15%">
            <img src="https://www.mprc.gov.my/sites/default/files/styles/medium/public/directories-logo/aims_logo.png?itok=VRmQNKpL"
                 alt="Aims-Logo" style="width:auto;height:100px;margin-left:15px;">
        </td>
        <td>
            <b>Aims Global Holding</b>
            <br>Bestari Centre, No 20 & 21 , Blok B,
            <br>Jalan Hiliran, 20300 Kuala Terengganu, Terengganu
            <br>No Tel : 09-622 8848
        </td>
    </tr>
</table>-->

<div id="printThis">
    <form method="post" action="../controller/aims_travel_requestCeo_exec.php">
        <input id="id" name="id" type="hidden" value="<? echo $id?>"/>
        <div class="form-group row">
            <div class="col-lg-6">
                <label for="company_id" class="control-label">Company <? echo $id; ?></label>
                <input class="form-control" id="company_id" name="company_id" type="text" value="<? echo $travel['company_id'] ?>" readonly/>

            </div>
            <div class="col-lg-3">
                <label for="department_id" class="control-label">Department</label>
                <input class="form-control" id="department_id" name="department_id" type="text" value="<? echo $travel['department_id'] ?>" readonly/>
            </div>
            <div class="col-lg-3">
                <label for="no_staff" class="control-label">Staff No</label>
                <input class="form-control" id="no_staff" name="no_staff" type="text" value="<? echo $travel['no_staff'] ?>" readonly/>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-6">
                <label for="name" class="control-label">Name</label>
                <input class="form-control" id="name" name="name" type="text" value="<? echo $travel['name'] ?>" readonly/>
            </div>

            <div class="col-lg-3">
                <label for="staff_designation" class="control-label">Designation</label>
                <input class="form-control" id="staff_designation" name="staff_designation" type="text" value="<? echo $travel['staff_designation'] ?>" readonly/>
            </div>

            <div class="col-lg-3">
                <label for="noic" class="control-label">I/C No</label>
                <input class="form-control" id="noic" name="noic" type="text" value="<? echo $travel['noic'] ?>" readonly/>
            </div>
        </div>

        <div class="form-group row">
            <div class="col-lg-6">
                <label for="travel_purpose" class="control-label">Purpose</label>
                <textarea class="form-control" id="travel_purpose" name="travel_purpose" type="text"
                          rows="5" style="resize: none" readonly><? echo $travel['travel_purpose'] ?></textarea>
            </div>

            <div class="col-lg-3">
                <label for="travel_mode_id" class="control-label">Mode of Travel</label>
                <input class="form-control" id="travel_mode_id" name="travel_mode_id" type="text" value="<? echo $travel['travel_mode_id'] ?>" readonly/>
            </div>

            <div class="col-lg-3">
                <label for="job_no" class="control-label">Job No</label>
                <input class="form-control" id="job_no" name="job_no" type="text" value="<? echo $travel['job_no'] ?>" readonly/>
            </div>
            <div class="col-lg-3" style="margin-top:1%">
                <label for="departure_date" class="control-label">Departure Date</label>
                <input class="form-control" id="departure_date" name="departure_date" type="date" style="text-transform:uppercase;" value="<? echo $travel['departure_date'] ?>" readonly/>
            </div>

            <div class="col-lg-3" style="margin-top:1%">
                <label for="return_date" class="control-label">Return Date</label>
                <input class="form-control" id="return_date" name="return_date" type="date" style="text-transform:uppercase;" value="<? echo $travel['return_date'] ?>" readonly/>
            </div>
            <div class="col-lg-3" style="margin-top:1%">
                <label for="departure_time" class="control-label">Departure Time</label>
                <input class="form-control" id="departure_time" name="departure_time" type="time" value="<? echo $travel['departure_time'] ?>" style="text-transform:uppercase;" readonly/>
            </div>

            <div class="col-lg-3" style="margin-top:1%">
                <label for="return_time" class="control-label">Return Time</label>
                <input class="form-control" id="return_time" name="return_time" type="time" style="text-transform:uppercase;" value="<? echo $travel['return_time'] ?>" readonly/>
            </div>
        </div>

        <div class="separator"><b>HOTEL ACCOMODATION</b></div>

        <div class="form-group row">

            <div class="col-lg-3">
                <label for="request_hotel" class="control-label">Request for Hotel : </label>
                <input type="text" class="form-control" id="request_hotel" value="<? echo $travel['request_hotel'] ?>" disabled>
            </div>
            <div class="col-lg-3">
                <label for="hotel_duration" class="control-label">Duration of Stays (days):</label>
                <input class="form-control" id="hotel_duration" name="hotel_duration" type="text" required value="<? echo $travel['hotel_duration'] ?>" style="text-transform:uppercase;" readonly/>
            </div>

            <div class="col-lg-3">
                <label for="check_in" class="control-label">Date Check In</label>
                <input class="form-control" id="check_in" name="check_in" type="date" required value="<? echo $travel['check_in'] ?>" style="text-transform:uppercase;" readonly/>
            </div>

            <div class="col-lg-3">
                <label for="check_out" class="control-label">Date Check Out</label>
                <input class="form-control" id="check_out" name="check_out" type="date" required value="<? echo $travel['check_out'] ?>" style="text-transform:uppercase;" readonly/>
            </div>
        </div>

        <div class="separator"><b>TRANSPORTATION</b></div>

        <div class="form-group row">
            <div class="col-lg-5" style="padding-left: 16px">
                <ul style="list-style: square">
                    <li>
                        <label class="control-label">Transportation</label><br>
                        <ul style="margin: -8px 0 8px">
                            <li>From Airport (KT/KUA): <? echo $travel['transport_fairport'] ?></li>
                            <li>To Airport (KT/KUA): <? echo $travel['transport_tairport'] ?></li>
                        </ul>
                    </li>
                    <li>
                        <label class="control-label">Request for Company Driver:</label> <? echo $travel['request_driver'] ?> <br>
                    </li>
                    <li>
                        <label class="control-label">Advance Required:</label> <? echo $travel['advance_required'] ?>
                    </li>
                    <li>
                        <label for="destination" class="control-label">Destination: </label>
                        <span><? echo $travel['destination'] ?></span>
                    </li>
                    <li>
                        <label for="travel_advance" class="control-label">Total:</label>
                        <span> RM<? echo $travel['travel_advance'] ?></span>
                    </li>
                </ul>
            </div>
            <div class="col-lg-7">
                <div class="row">
                    <div class="col-md-12">
                        <label>Verification:</label><br>
                        <span class="approval-status" style="background-color: <? echo ($travel['hod_approval'] == "APPROVED") ? 'green' : 'red'; ?>">
                            <? echo $travel['hod_approval'] ?>
                        </span>
                        <p style="margin-top: 8px;"><? echo $travel['hod_by'] ?></p>
                        <p><? echo $travel['hod_date'] ?></p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <label>Approval:</label><br>
                        <span class="approval-status" style="margin-bottom: 16px;background-color: <? echo ($travel['ceo_approval'] == "APPROVED") ? 'green' : 'red'; ?>">
                            <? echo $travel['ceo_approval'] ?>
                        </span>
                        <p style="margin-top: 8px;"><? echo $travel['ceo_by'] ?></p>
                        <p><? echo $travel['ceo_date'] ?></p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<div class="text-center">
    <a id="printPageButton" target="blank" type="button" class="btn btn-info" href="../view/aims_travel_printpdf.php?id=<? echo $id ?>">Print</a>
</div>