<?php
require "../controller/auth.php";
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$id = $_POST['id'];
?>
<table class="table">
    <thead style="background-color:black;color:white;">
    <tr>
        <th>No</th>
        <th>Name</th>
        <th>Designation</th>
        <th>Department</th>
    </tr>
    </thead>
    <tbody>
    <?
    $car= getcarpassengerById2($id);
    $i=1;
    if ($car->num_rows < 1){
        echo "<tr><td colspan='4' class='text-center'>- No passenger added -</td></tr>";
    }
    while($car_info = $car->fetch_assoc() ) {
        ?>
        <tr>
            <td><? echo $i++;?></td>
            <td><? echo $car_info['name_passenger'];?></td>
            <td><? echo $car_info['jawatan'];?></td>
            <td><? echo $car_info['description'];?></td>
        </tr>
    <?}?>
    </tbody>
</table>
