<?php
require "../model/v02_aims_inout_function.php";
$id = $_POST['id'];
$require_staff_info = $_POST['staff_info'];

if ($require_staff_info == 'yes'){
    $staff = getStaffInfo($id)->fetch_assoc();?>
    <div class="row" style="margin: 0 0 16px 4px">
        <div class="col-md-12">
            <table>
                <tr>
                    <th>Name</th>
                    <td style="padding: 0 8px">:</td>
                    <td><? echo $staff['name'] ?></td>
                </tr>
                <tr>
                    <th>Company</th>
                    <td style="padding: 0 8px">:</td>
                    <td><? echo $staff['department_id'] ?></td>
                </tr>
                <tr>
                    <th>Department</th>
                    <td style="padding: 0 8px">:</td>
                    <td><? echo $staff['department_sub'] ?></td>
                </tr>
            </table>
        </div>
    </div>
<? } ?>
<table class="table table-bordered">
    <thead>
    <tr>
        <th style="width: 20%; background-color: rgb(0,0,0); color: white">Month</th>
        <th style="width: 20%; background-color: rgba(145,145,145,0.5)">In/Out Quota</th>
        <th style="width: 20%; background-color: rgba(255,145,145,0.5)">Used</th>
        <th style="width: 20%; background-color: rgb(255,241,144)">In Progress</th>
        <th style="width: 20%; background-color: rgba(143,255,0,0.5)">Available</th>
    </tr>
    </thead>
    <tbody>
    <? for ($i=0; $i<3; $i++){
        $month = ($i == 0)? date('F Y') : date('F Y', strtotime('-'.$i.' months'));
        $used = getInOutUsageByMonth($id, $month, true);
        $pending = getInOutUsageByMonth($id, $month, false);

        $available = 2 - (count($used) + count($pending));
        ?>
        <tr class="bg-expired" <? if (date('F Y') == $month){ ?> style="background-color: transparent" <? } ?>>
            <td><? echo $month ?></td>
            <td class="text-center">2 &times; 2.0 hours</td>
            <td class="text-center">
                <?
                echo (count($used) == 0) ? "<span class='text-muted'>No usage</span>" : "";
                foreach ($used as $used_list){
                    echo '1 &times; '.number_format($used_list, 1).' hours<br>';
                } ?>
            </td>
            <td class="text-center">
                <?
                echo (count($pending) == 0) ? "<span class='text-muted'>No usage</span>" : "";
                foreach ($pending as $pending_list){
                    echo '1 &times; '.number_format($pending_list, 1).' hours<br>';
                } ?>
            </td>
            <td class="text-center"><? echo ($available > 0) ? "<b>".$available." &times; 2.0 hours</b>" : "<span class='text-red'>Max usage reached</span>"; ?></td>
        </tr>
    <? } ?>
    </tbody>
</table>
