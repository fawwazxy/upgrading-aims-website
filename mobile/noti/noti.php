<?php
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header('Content-type: application/json');
require '../../lib/json.inc';
require '../../app/model/v02_notification_function.php';

$cmd = $_GET['cmd'];
$output_to_send = '';

switch ($cmd){

    case '1':
        $no_staff = $_GET['no_staff'];
        $role = $_GET['role'];
        $department = $_GET['department'];
        $department_sub = $_GET['department_sub'];
        $staff_id = $_GET['staff_id'];
        $ic_number = $_GET['noic'];
        $i=0;
        $array = array();
        //overtime permission hod
        $otp_count= ($no_staff != "INTERN") ? v02notifyOtPermission($staff_id) : 0;
        if ($otp_count > 0){
            $array[$i]['type'] = 'overtime permission approval';
            $array[$i]['value'] = (string)$otp_count;
            $i++;
        }
        //overtime claim hod
        $ot_count_hod = ($role != "INTERN") ? v02notifyOtForHod($department_sub,$staff_id) : 0;
        if ($ot_count_hod > 0){
            $array[$i]['type'] = 'overtime claim verification';
            $array[$i]['value'] = (string)$ot_count_hod;
            $i++;
        }
        //overtime unclaimed ot
        $unclaimed_ot_count = ($role != "INTERN") ? v02notifyUnclaimedOt($staff_id) : 0;
        if ($unclaimed_ot_count > 0){
            $array[$i]['type'] = 'overtime unclaimed ot';
            $array[$i]['value'] = (string)$unclaimed_ot_count;
            $i++;
        }
        //overtime approval ceo
        $ot_count_ceo = ($role == "FOUNDER") ? v02notifyOtForCeo($staff_id): 0;
        if ($ot_count_ceo > 0 && $role == 'FOUNDER'){
            $array[$i]['type'] = 'ceo overtime approval';
            $array[$i]['value'] = (string)$ot_count_ceo;
            $i++;
        }
        //leave support
        $v02_leave_support_count= v02notifyLeaveSupport($staff_id, $ic_number,$role,$department,$department_sub);
        if ($v02_leave_support_count > 0) {
            $array[$i]['type'] = 'leave support';
            $array[$i]['value'] = (string)$v02_leave_support_count;
            $i++;
        }
        //leave approval
        $v02_leave_approval_count= v02notifyLeaveApproval($staff_id, $ic_number);
        if ($v02_leave_approval_count > 0){
            $array[$i]['type'] = 'leave approval';
            $array[$i]['value'] = (string)$v02_leave_approval_count;
            $i++;
        }
        //claim verification
        $claim_verification_count_v02= ($role != "INTERN") ? v02notifyClaimVerification($staff_id, $ic_number) : 0;
        if ($claim_verification_count_v02 > 0) {
            $array[$i]['type'] = 'claim verification';
            $array[$i]['value'] = (string)$claim_verification_count_v02;
            $i++;
        }
        //claim approval
        $claim_approval_count_v02= ($role == "FOUNDER") ? v02notifyClaimApproval($staff_id) : 0;
        if ($claim_approval_count_v02 > 0) {
            $array[$i]['type'] = 'claim approval';
            $array[$i]['value'] = $claim_approval_count_v02;
            $i++;
        }
        //inout support
        $v02_inout_support_count = v02NotifyInOutSupport($staff_id);
        if ($v02_inout_support_count > 0) {
            $array[$i]['type'] = 'in/out support';
            $array[$i]['value'] = (string)$v02_inout_support_count;
            $i++;
        }
        //inout approval
        $v02_inout_approval_count = v02NotifyInOutApproval($staff_id);
        if ($v02_inout_approval_count > 0){
            $array[$i]['type'] = 'in/out approval';
            $array[$i]['value'] = (string)$v02_inout_approval_count;
            $i++;
        }
            $output_to_send = json_encode($array);
        break;
}

echo $output_to_send;