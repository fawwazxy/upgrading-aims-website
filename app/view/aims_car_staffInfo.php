<?php
include "../controller/auth.php";
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$id = $_POST['id'];
$car_info = getcarRequestById($id)->fetch_assoc();
?>
<table class="table table-striped table-hover">
    <tr>
        <th>DRIVER NAME</th>
        <td><?echo $car_info['drivername'];?></td>
    </tr>

    <tr>
        <th>PURPOSE</th>
        <td><?echo $car_info['purpose'];?></td>
    </tr>

    <tr>
        <th>DESTINATION</th>
        <td><?echo $car_info['destination'];?></td>
    </tr>

    <tr>
        <th>COMPANY</th>
        <td><?echo $car_info['description'];?></td>
    </tr>

    <tr>
        <th>TYPE OF CAR</th>
        <td><?echo $car_info['car_type'];?></td>
    </tr>

    <tr>
        <th>NO. PASSENGERS</th>
        <td><?echo $car_info['no_passengers'];?></td>
    </tr>

    <tr>
        <th>PLATE NO</th>
        <td><?echo $car_info['car_plate_no'];?></td>
    </tr>

    <tr>
        <th>DEPARTURE DATE</th>
        <td><?echo $car_info['dep_date'];?></td>
    </tr>

    <tr>
        <th>DEPARTURE TIME</th>
        <td><?echo $car_info['dep_time'];?></td>
    </tr>

    <tr>
        <th>DEPARTURE MILEAGE</th>
        <td><?echo $car_info['dep_milage'];?></td>
    </tr>

    <tr>
        <th>RETURN DATE</th>
        <td><?echo $car_info['return_date'];?></td>
    </tr>

    <tr>
        <th>RETURN TIME</th>
        <td><?echo $car_info['return_time'];?></td>
    </tr>

    <tr>
        <th>RETURN MILEAGE</th>
        <td><?echo $car_info['return_milage'];?></td>
    </tr>
</table>
