<?php
include "../controller/auth.php";
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$id = $_POST['id'];
$car_info = getcarRequestById($id)->fetch_assoc();
$color_array = ['PENDING' => 'GREY', 'APPROVE' => 'GREEN', 'DISAPPROVE' => 'RED'];
?>

<table class="table table-striped table-hover">
    <tr>
        <th>Applicant Name</th>
        <td><? echo $car_info['name'];?></td>
    </tr>
    <tr>
        <th>Designation</th>
        <td><? echo $car_info['jawatan'];?></td>
    </tr>
    <tr>
        <th>Driver Name</th>
        <td><? echo $car_info['drivername'];?></td>
    </tr>
    <tr>
        <th>Purpose</th>
        <td><? echo $car_info['purpose'];?></td>
    </tr>
    <tr>
        <th>Destination</th>
        <td><? echo $car_info['destination'];?></td>
    </tr>
    <tr>
        <th>Company</th>
        <td><? echo $car_info['description'];?></td>
    </tr>
    <tr>
        <th>Type of Car</th>
        <td><? echo $car_info['car_type'];?></td>
    </tr>
    <tr>
        <th>No. of Passengers</th>
        <td><? echo $car_info['no_passengers'];?></td>
    </tr>
    <tr>
        <th>Plate No.</th>
        <td><? echo $car_info['car_plate_no'];?></td>
    </tr>
    <tr>
        <th>Departure Date & Time</th>
        <td><? echo date('d/m/Y', strtotime($car_info['dep_date'])).", ".date('h:i:sa', strtotime($car_info['dep_time']));?></td>
    </tr>
    <tr>
        <th>Departure Mileage</th>
        <td><? echo $car_info['dep_milage'];?></td>
    </tr>
    <tr>
        <th>Return Date & Time</th>
        <td><?echo date('d/m/Y', strtotime($car_info['return_date'])).", ".date('h:i:sa', strtotime($car_info['return_time']));?></td>
    </tr>
    <tr>
        <th>Return Mileage</th>
        <td><?echo $car_info['return_milage'];?></td>
    </tr>
    <tr>
        <th>Created by</th>
        <td><? echo $car_info['created_by'].", at ".date('d/m/Y h:i a', strtotime($car_info['created_date'])) ?></td>
    </tr>
    <tr>
        <th>Status Approval SBU/HOD</th>
        <td>
            <span class="transport-status" style="background-color:<? echo $color_array[$car_info['sbu_hod_app']] ?>;"> <? echo $car_info['sbu_hod_app']?> </span>
            <p style="margin-top: 8px;"><? echo $car_info['approve_by'];?></p>
            <p><? echo $car_info['hod_date'];?></p>
        </td>
    </tr>
    <tr>
        <th>Status Inspection</th>
        <td>
            <span class="transport-status" style="background-color: <? echo ($car_info['status_incep']==0) ? "grey" : "green"; ?>">
                <? echo ($car_info['status_incep']==0) ? "NO" : "YES"; ?></span>
        </td>
    </tr>
</table>
