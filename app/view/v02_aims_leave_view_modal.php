<?php
require "../model/v02_aims_leave_function.php";
$id = $_POST['id'];
$leave = getLeaveById($id)->fetch_assoc();

$day = ($list['total_days'] > 1)?'days':'day';
$hr_day = ($leave['balance_after_checked'] > 1)?'days':'day';
$balance = "<b style='font-size: 24px'>".(float)$leave['balance_after_checked']." ".$hr_day."</b>";
if ($leave['balance_after_checked'] == ''){
    if (in_array($leave['leave_type'], getLeaveQuotaList(true))) {
        $quota = getLeaveQuotaByStaffId($leave['staff_id'], $leave['start_date'], $leave['leave_type'])
            ->fetch_assoc();
        $current_balance = ($quota['current_balance']) ?: 0;
        $current_balance_day = ($current_balance > 1)?'days':'day';
        $leave_day = ($leave['total_days'] > 1)?'days':'day';

        $pending_balance = getCountLeave($quota['leave_type'], $quota['staff_id'], $quota['start_date'], $quota['end_date']);
        $pending_balance_day = ($pending_balance > 1)?'days':'day';

        $available_balance = $current_balance - $pending_balance;
        $available_balance_day = ($available_balance > 1)?'days':'day';

        $this_balance = $current_balance ." ".$current_balance_day." - " . $leave['total_days'] . " ".$leave_day." = " . (float)($current_balance - $leave['total_days']);
        $this_balance_day = ($this_balance > 1)?'days':'day';

        $overall_balance = $current_balance . " ".$current_balance_day." - " . $pending_balance . " ".$pending_balance_day." = " . (float)($current_balance - $pending_balance);
        $overall_balance_day = ($overall_balance > 1)?'days':'day';

        $balance = "<ul>";
        $balance .= "<li><h5>Current Balance</h5>: " . $current_balance ." ".$current_balance_day."</li>";
        $balance .= "<li><h5>In Process</h5>: " . $pending_balance . " ".$pending_balance_day."</li>";
        $balance .= "<li><h5>Balance Available</h5>: " . $available_balance . " ".$available_balance_day."</li>";
        $balance .= "<li><h5>Current Application</h5>: " . $this_balance . " ".$this_balance_day."</li>";
        $balance .= "<li><h5>Overall Application</h5>: " . $overall_balance . " ".$overall_balance_day."</li>";
        $balance .= "</ul>";
    }else{
        $balance = "<span class='text-muted' style='font-size: 12px'>Not related - Type of leave without quota</span>";
    }
}

?>
<head>
    <style>
        /*Align colon*/
        ul {
            list-style: none;
            display: table;
        }
        li {
            display: table-row;
        }
        h5 {
            display: table-cell;
            padding-right: 1em;
            font-weight: bold;
        }
    </style>
</head>
<div class="table-responsive">
    <table class="table table-hover table-borderless" id="table_database" style="width: 100%">
        <tbody>
        <tr>
            <th style="width: 30%">Application date</th>
            <td><? echo date('d/m/Y h:i:sa', strtotime($leave['created_at']))?></td>
        </tr>
        <tr>
            <th>Leave start date</th>
            <td><? echo date('d/m/Y', strtotime($leave['start_date'])); ?></td>
        </tr>
        <tr>
            <th>Leave end date</th>
            <td><? echo date('d/m/Y', strtotime($leave['end_date'])); ?></td>
        </tr>
        <tr>
            <th>Total day</th>
            <td><? echo (float)($leave['total_days'])." ".$day; ?></td>
        </tr>
        <tr>
            <th>Type of Leave</th>
            <td><? echo getLeaveType($leave['leave_type']); ?></td>
        </tr>
        <tr>
            <th>Reason</th>
            <td><? echo $leave['description']; ?></td>
        </tr>
        <tr>
            <th>Remarks</th>
            <td><? echo ($leave['remark']) ?: "<span class='text-muted' style='font-size: 12px'>- No Remarks -</span>"; ?></td>
        </tr>
        <tr>
            <th>Support</th>
            <td>
                <?
                $support_by = ($leave['support_by'] == '0') ? "Auto-Supported" : getStaffName($leave['support_by']) ;
                $support_at = (!empty($leave['support_at'])) ? date('d/m/Y h:i:s a', strtotime($leave['support_at'])) : "";
                if ($leave['support_status'] == '1') { echo "<b class='text-green'>SUPPORTED</b>"; }
                else if ($leave['support_status'] == '0') { echo "<b class='text-red'>REJECTED</b>"; }
                else { echo "<b class='text-muted'>PENDING</b>"; }
                echo "<p>".$support_by."</p>";
                echo "<p>".$support_at."</p>";
                ?>
            </td>
        </tr>
        <tr>
            <th>Approval</th>
            <td>
                <?
                $approval_at = (!empty($leave['approval_at'])) ? date('d/m/Y h:i:s a', strtotime($leave['approval_at'])) : "";
                if ($leave['approval_status'] == '1') { echo "<b class='text-green'>APPROVED</b>"; }
                else if ($leave['approval_status'] == '0') { echo "<b class='text-red'>REJECTED</b>"; }
                else { echo "<b class='text-muted'>PENDING</b>"; }
                echo "<p>".getStaffName($leave['approval_by'])."</p>";
                echo "<p>".$approval_at."</p>";
                ?>
            </td>
        </tr>
        <tr>
            <th>HR Review</th>
            <td>
                <?
                $approval_at = (!empty($leave['hr_checked_at'])) ? date('d/m/Y h:i:s a', strtotime($leave['hr_checked_at'])) : "";
                if ($leave['hr_checked_status'] == '1') { echo "<b class='text-green'>REVIEWED</b>"; }
                else if ($leave['hr_checked_status'] == '0') { echo "<b class='text-red'>REJECTED</b>"; }
                else { echo "<b class='text-muted'>PENDING</b>"; }
                echo "<p>".getStaffName($leave['hr_checked_by'])."</p>";
                echo "<p>".$approval_at."</p>";
                ?>
            </td>
        </tr>
        <tr>
            <th>Application balance</th>
            <td><? echo $balance; ?></td>
        </tr>
        </tbody>
    </table>
</div>