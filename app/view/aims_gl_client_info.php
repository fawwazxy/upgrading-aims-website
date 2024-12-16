<?php
include ('../controller/auth.php');
require "../model/aims_gl_function.php";
require "../model/lookup.php";

$id = $_POST['id'];
$client_info = getClientById($id)->fetch_assoc();
?>
<table class="table table-bordered">
    <tbody>
    <tr>
        <td>Name</td>
        <td><? echo '<b>'.$client_info['client_name'].'</b>'; ?></td>
    </tr>
    <tr>
        <td>IC/Passport No</td>
        <td><? echo '<b>'.$client_info['client_ic'].'</b>'; ?></td>
    </tr>
    <tr>
        <td>Phone No</td>
        <td><? echo '<b>'.$client_info['client_phone_no'].'</b>'; ?></td>
    </tr>
    <tr>
        <td>Car Registration</td>
        <td><? echo '<b>'.$client_info['client_car'].'</b>'; ?></td>
    </tr>
    <tr>
        <td>Company</td>
        <td><? echo '<b>'.$client_info['company_name'].'</b>'; ?></td>
    </tr>
    <tr>
        <td>Address</td>
        <td><? echo '<b>'.$client_info['client_address'].'</b>';?></td>
    </tr>
    <tr>
        <td>State</td>
        <td><? echo '<b>'.$client_info['client_state'].'</b>'; ?></td>
    </tr>
    <tr>
        <td>Postcode</td>
        <td><? echo '<b>'.$client_info['client_postcode'].'</b>'; ?></td>
    </tr>
    <tr>
        <td>City</td>
        <td><? echo '<b>'.$client_info['client_city'].'</b>'; ?></td>
    </tr>
    </tbody>

</table>

<script type="text/javascript">
    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>
