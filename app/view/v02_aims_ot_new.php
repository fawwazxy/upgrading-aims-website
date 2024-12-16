<?php
require "../model/v02_aims_ot_function.php";

$staff_id = $_POST['staff_id'];
?>
<table class="table table-striped table-bordered table-hover" id="dataTables-example" style="width: 100%">
    <thead style="background-color: #b9eec6">
    <tr>
        <th>No.</th>
        <th>Date</th>
        <th>Description</th>
        <th class="text-center">OT Mode</th>
        <th>Action</th>
    </tr>
    </thead>
    <tbody>

    <?
    $ot = v02getUnclaimedOtp($staff_id);
    $i=1;
    if (mysqli_num_rows($ot) == 0){ ?>
        <tr class='text-center'>
            <td colspan='5'>
                <i class='text-muted' style='font-size: small'>
                    - You have no UNCLAIMED OVERTIME -
                </i>
            </td>
        </tr>
    <? }
    while($otp = $ot->fetch_assoc()) {
        $mode = 'NORMAL';
        if ($otp['rate_mode'] == 2.0){
            $mode = 'WEEKEND';
        }else if ($otp['rate_mode'] == 3.0){
            $mode = 'PUBLIC HOLIDAY';
        }
        ?>
        <tr>
            <td><?php echo $i++; ?></td>
            <td><?php echo date("Y-m-d", strtotime($otp['created_at'])); ?></td>
            <td><?php echo $otp['description']; ?></td>
            <td class="text-center"><?php echo $mode; ?></td>
            <td>
                <a href="v02_aims_ot_form.php?otp_id=<? echo $otp['id']; ?>"
                   class="btn btn-success" title="Claim overtime here">CLAIM</a>
            </td>
        </tr>
    <? } ?>
    </tbody>
</table>

<script>
    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>
