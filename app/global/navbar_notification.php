<?php
require "../model/v02_notification_function.php";

$module = [
    "ot" => "[OVERTIME]", "taf" => "[TAF]",
    "lv" => "[LEAVE]", "lv02" => "[LEAVE v2]",
    "oc" => "[CLAIM]", "oc02" => "[CLAIM v2]",
    "ssa" => "[SSA]", "ssr" => "[SSR]",
    "tr" => "[TRANSPORT]", "io" => "[INOUT]",
    "iov2" => "[INOUT v2]", "mcv2" => "[MEDICAL v2]",
    "vr" => "[AIMS-CORP]", "trf" => "[TRF]",
    "tafv2" => "[TAF v2]", "rca" => "[RCA]"
];
$color = [
    "ot" => "#e20000", "taf" => "#000083",
    "lv" => "#ff8d19", "lv02" => "#2ae200",
    "oc" => "#ffe400", "oc02" => "#d900ff",
    "ssa" => "#008374", "ssr" => "#008374",
    "tr" => "#4c00ff", "io" => "#00ff55",
    "iov2" => "#2ae200", "mcv2" => "#2ae200",
    "vr" => "#4c00ff", "trf" => "#e20000",
    "tafv2" => "#000083", "rca" => "#ff8d19"
];
?>

<!--
Notification list:

OVERTIME VERSION 2:-
- Overtime Permission Notification
- Unclaimed Overtime
- Verification Overtime Claim (HOD)
- Approval Overtime Claim (CEO/Chairman)

LEAVE:-
- Support
- Approval
- Approval Special Leave

LEAVE VERSION 2:-
- Support
- Approval

TRAVEL AUTHORIZATION FORM (TAF):-
- Verification
- CEO Verification
- CEO/EC Approval

SSR & SSA (PROCUREMENT):-
- SSA Procurement Approval
- SSR Procurement Approval
- SSA Mr. Khairul Approval
- SSR Mr. Khairul Approval

OTHERS CLAIM VERSION 1:-
- Claim Verification
- Claim Review
- Claim Approval

OTHERS CLAIM VERSION 2:-
- Claim Verification
- Claim Review
- Claim Approval

TRANSPORT REQUEST:-
- Transport PIC Approval
- Transport Admin Approval
- Transport HOD Approval

IN OUT:-
- In Out Verification (Staff in same department)
- In Out Approval (HOD)

IN OUT VERSION 2:-
- In Out Support (Staff in same department) -> use 'Verification' terms in v1
- In Out Approval (HOD)

MEDICAL CLAIM VERSION 2:-
- CFO Approval
- CEO Approval


-->
<li class="dropdown" style="text-align: right">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
        <i class="fa fa-bell fa-fw"></i> <sup id="notification-badge" class="fa fa-circle" style="color: red; font-size: 8px;display: none"></sup>
    </a>
    <ul class="dropdown-menu dropdown-user" id="notification-box">

        <!-- Here are the list of all notification
         <? print_r($_SESSION) ?>-->
        <?
        /* OVERTIME */

        // Overtime Permission Notification
        $otp_count= ($_SESSION["SESS_ROLE"] != "INTERN") ? v02notifyOtPermission($_SESSION['SESS_ID']) : 0;
        if ($otp_count > 0) { ?>
            <li class="notification-list">
                <a href="../view/v02_aims_ot_permission_approval.php">
                    <i class="fa fa-flag" style="color: <? echo $color['ot'] ?>"></i> &nbsp;
                    <b><?php echo $module['ot']; ?></b> You have <b><?php echo $otp_count; ?></b> approval action for OVERTIME PERMISSION.
                </a>
            </li>
        <? }

        // Unclaimed Overtime
        $unclaim_ot = v02notifyUnclaimedOt($_SESSION['SESS_ID']);
        if ($unclaim_ot > 0) { ?>
            <li class="notification-list">
                <a href="../view/v02_aims_ot_permission_list.php">
                    <i class="fa fa-flag" style="color: <? echo $color['ot'] ?>"></i> &nbsp;
                    <b><?php echo $module['ot']; ?></b> Your OT PERMISSION has been approved.<br> You can make <b><?php echo $unclaim_ot; ?></b> OVERTIME CLAIM.
                </a>
            </li>
        <? }

        // Verification Overtime Claim (HOD)
        $ot_count_hod = ($_SESSION["SESS_ROLE"] != "INTERN") ? v02notifyOtForHod($_SESSION['SESS_DEPARTMENT_SUB'],$_SESSION['SESS_ID']) : 0;
        if ($ot_count_hod > 0) { ?>
            <li class="notification-list">
                <a href="../view/v02_aims_ot_hod_list.php">
                    <i class="fa fa-flag" style="color: <? echo $color['ot'] ?>"></i> &nbsp;
                    <b><?php echo $module['ot']; ?></b> You have <b><?php echo $ot_count_hod; ?></b> verification action for OVERTIME CLAIM.
                </a>
            </li>
        <? }

        // Approval Overtime Claim (CEO/Chairman)
        $ot_count_ceo= ($_SESSION["SESS_ROLE"] == "FOUNDER") ? v02notifyOtForCeo($_SESSION['SESS_ID']): 0;
        if ($ot_count_ceo > 0 && $_SESSION['SESS_ROLE'] == 'FOUNDER') { ?>
            <li class="notification-list">
                <a href="../view/v02_aims_ot_ceo_list.php">
                    <i class="fa fa-flag" style="color: <? echo $color['ot'] ?>"></i> &nbsp;
                    <b><?php echo $module['ot']; ?></b> You have <b><?php echo $ot_count_ceo; ?></b> approval action for OVERTIME CLAIM.
                </a>
            </li>
        <? }

        /* LEAVE VERSION 1*/

        // Support
        $leave_support_count= notifyLeaveSupport($_SESSION['SESS_NOKP']);
        if ($leave_support_count > 0) { ?>
            <li class="notification-list">
                <a href="../view/senarai_kelulusan_cuti.php">
                    <i class="fa fa-flag" style="color: <? echo $color['lv'] ?>"></i> &nbsp;
                    <b><?php echo $module['lv']; ?></b> You have <b><?php echo $leave_support_count; ?></b> support action for LEAVE.
                </a>
            </li>
        <? }

        // Approval
        $leave_approval_count= ($_SESSION["SESS_ROLE"] != "INTERN") ? notifyLeaveApproval($_SESSION['SESS_NOKP']) : 0;
        /*if ($leave_approval_count > 0) { */?><!--
            <li class="notification-list">
                <a href="../view/senarai_kelulusan_cuti_hod.php">
                    <i class="fa fa-flag"  style="color: <?/* echo $color['lv'] */?>"></i> &nbsp;
                    <b><?php /*echo $module['lv']; */?></b> You have <b><?php /*echo $leave_approval_count; */?></b> approval action for LEAVE.
                </a>
            </li>
        --><?/* }*/

        // Approval Special Leave
        /*$special_leave_approval_count = ($_SESSION['SESS_DEPARTMENT_SUB'] == "HR") ? notifySpecialLeaveApprovalHR($_SESSION['SESS_NO_STAFF']) : 0;
        if ($special_leave_approval_count > 0) { */?><!--
            <li class="notification-list">
                <a href="../view/senarai_kelulusan_cuti_hod.php">
                    <i class="fa fa-flag" style="color: <?/* echo $color['lv'] */?>"></i> &nbsp;
                    <b><?php /*echo $module['lv']; */?></b> You have <b><?php /*echo $special_leave_approval_count; */?></b> approval action for SPECIAL LEAVE.
                </a>
            </li>
        --><?/* }*/

        /* LEAVE VERSION 2 */

        // Support
        if ($_SESSION['SESS_ROLE'] != 'INTERN'){
            $v02_leave_support_count= v02notifyLeaveSupport($_SESSION['SESS_ID'],$_SESSION['SESS_NOKP'],$_SESSION['SESS_ROLE'],$_SESSION['SESS_DEPARTMENT'],$_SESSION['SESS_DEPARTMENT_SUB']);
            if ($v02_leave_support_count > 0) { ?>
                <li class="notification-list">
                    <a href="../view/v02_aims_leave_support.php">
                        <i class="fa fa-flag" style="color: <? echo $color['lv02'] ?>"></i> &nbsp;
                        <b><?php echo $module['lv02']; ?></b> You have <b><?php echo $v02_leave_support_count; ?></b> support action for LEAVE v2.
                    </a>
                </li>
            <? }
        }


        // Approval
        $v02_leave_approval_count= v02notifyLeaveApproval($_SESSION['SESS_ID'], $_SESSION['SESS_NOKP']);
        if ($v02_leave_approval_count > 0) { ?>
            <li class="notification-list">
                <a href="../view/v02_aims_leave_approval.php">
                    <i class="fa fa-flag" style="color: <? echo $color['lv02'] ?>"></i> &nbsp;
                    <b><?php echo $module['lv02']; ?></b> You have <b><?php echo $v02_leave_approval_count; ?></b> approval action for LEAVE v2.
                </a>
            </li>
        <? }

        /* TRAVEL AUTHORIZATION FORM (TAF) */

        // Verification
        $taf_verification_count= ($_SESSION['SESS_NOKP'] != "660512115105") ? notifyTafVerification($_SESSION['SESS_NOKP']) : 0;
        if ($taf_verification_count > 0) { ?>
            <li class="notification-list">
                <a href="../view/aims_travel_requestlist.php">
                    <i class="fa fa-flag" style="color: <? echo $color['taf'] ?>"></i> &nbsp;
                    <b><?php echo $module['taf']; ?></b> You have <b><?php echo $taf_verification_count; ?></b> verification action for TRAVEL FORM.
                </a>
            </li>
        <? }

        // CEO Verification
        $taf_ceo_verification_count= ($_SESSION['SESS_NOKP'] == '751206035485') ? notifyTafCeoVerification($_SESSION['SESS_NOKP']) : 0;
        if ($taf_ceo_verification_count > 0) { ?>
            <li class="notification-list">
                <a href="../view/aims_travel_verificationCeo.php">
                    <i class="fa fa-flag" style="color: <? echo $color['taf'] ?>"></i> &nbsp;
                    <b><?php echo $module['taf']; ?></b> You have <b><?php echo $taf_ceo_verification_count; ?></b> verification action for TRAVEL FORM.
                </a>
            </li>
        <? }

        // CEO/EC Approval
        $taf_approval_count= ($_SESSION['SESS_ROLE'] == 'FOUNDER') ? notifyTafApproval($_SESSION['SESS_NOKP']) : 0;
        if ($taf_approval_count > 0) { ?>
            <li class="notification-list">
                <a href="../view/aims_travel_listCeo.php">
                    <i class="fa fa-flag" style="color: <? echo $color['taf'] ?>"></i> &nbsp;
                    <b><?php echo $module['taf']; ?></b> You have <b><?php echo $taf_approval_count; ?></b> approval action for TRAVEL FORM.
                </a>
            </li>
        <? }

        /* SSR & SSA (PROCUREMENT) */

        // SSA Procurement Approval
        $ssa_procurement_approval_count= ($_SESSION['SESS_DEPARTMENT_SUB'] == "PROCUREMENT") ? SSAProcurementApproval() : 0;
        if ($ssa_procurement_approval_count > 0) { ?>
            <li class="notification-list">
                <a href="../view/aims_ssa_proc_app.php">
                    <i class="fa fa-flag" style="color: <? echo $color['ssa'] ?>"></i> &nbsp;
                    <b><?php echo $module['ssa']; ?></b> You have <b><?php echo $ssa_procurement_approval_count; ?></b> approval action for SSA.
                </a>
            </li>
        <? }

        // SSR Procurement Approval
        for ($aa=1;$aa<=5;$aa++){
            $file = ($aa != 1) ? $aa : '';
            $url = "/aims/age/view/aims".$file."_ssrapp_pro_list.php";
            $ssr_procurement_approval_count= ($_SESSION['SESS_DEPARTMENT_SUB'] == "PROCUREMENT") ? SSRProcurementApproval('AA'.$aa) : 0;
            if ($ssr_procurement_approval_count > 0) { ?>
                <li class="notification-list">
                    <a href="<? echo $url ?>">
                        <i class="fa fa-flag" style="color: <? echo $color['ssr'] ?>"></i> &nbsp;
                        <b><?php echo $module['ssr']; ?></b> You have <b><?php echo $ssr_procurement_approval_count; ?></b> approval action for SSR (AA<? echo $aa ?>).
                    </a>
                </li>
            <? }
        }

        // SSA Mr. Khairul Approval
        $ssa_khairul_approval_count= ($_SESSION['SESS_NOKP'] == '740915115003') ? SSAKhairulApproval() : 0;
        if ($ssa_khairul_approval_count > 0) { ?>
            <li class="notification-list">
                <a href="../view/aims_ssa_app.php">
                    <i class="fa fa-flag" style="color: <? echo $color['ssa'] ?>"></i> &nbsp;
                    <b><?php echo $module['ssa']; ?></b> You have <b><?php echo $ssa_khairul_approval_count; ?></b> approval action for SSA.
                </a>
            </li>
        <? }

        // SSR Mr. Khairul Approval
        $ssr_khairul_approval_count= ($_SESSION['SESS_NOKP'] == '740915115003') ? SSRKhairulApproval() : 0;
        if ($ssr_khairul_approval_count > 0) { ?>
            <li class="notification-list">
                <a href="../view/aims_ssrapproved_list.php">
                    <i class="fa fa-flag" style="color: <? echo $color['ssr'] ?>"></i> &nbsp;
                    <b><?php echo $module['ssr']; ?></b> You have <b><?php echo $ssr_khairul_approval_count; ?></b> approval action for SSR.
                </a>
            </li>
        <? }

        /* OTHERS CLAIM VERSION 1*/

        // Claim Verification
        $claim_verification_count= ($_SESSION['SESS_ROLE'] != "INTERN") ? notifyClaimVerification($_SESSION['SESS_NOKP']) : 0;
        if ($claim_verification_count > 0) { ?>
            <li class="notification-list">
                <a href="../view/aims_others_claim_hod_list.php">
                    <i class="fa fa-flag" style="color: <? echo $color['oc'] ?>"></i> &nbsp;
                    <b><?php echo $module['oc']; ?></b> You have <b><?php echo $claim_verification_count; ?></b> verification action for CLAIM FORM.
                </a>
            </li>
        <? }

        // Claim Review
        /*$claim_review_count= ($_SESSION['SESS_DEPARTMENT_SUB'] == "HR") ? notifyClaimReview($_SESSION['SESS_DEPARTMENT']) : 0;
        if ($claim_review_count > 0) { */?><!--
            <li class="notification-list">
                <a href="../view/aims_others_claim_hr_list.php?department_id=<?/* echo $_SESSION['SESS_DEPARTMENT'] */?>">
                    <i class="fa fa-flag" style="color: <?/* echo $color['oc'] */?>"></i> &nbsp;
                    <b><?php /*echo $module['oc']; */?></b> You have <b><?php /*echo $claim_review_count; */?></b> reviewal action for CLAIM FORM.
                </a>
            </li>
        --><?/* }*/

        // Claim Approval
        $claim_approval_count= ($_SESSION['SESS_ROLE'] == "FOUNDER") ? notifyClaimApproval($_SESSION['SESS_NOKP']) : 0;
        if ($claim_approval_count > 0) { ?>
            <li class="notification-list">
                <a href="../view/aims_others_claim_ceo_list.php">
                    <i class="fa fa-flag" style="color: <? echo $color['oc'] ?>"></i> &nbsp;
                    <b><?php echo $module['oc']; ?></b> You have <b><?php echo $claim_approval_count; ?></b> approval action for CLAIM FORM.
                </a>
            </li>
        <? }

        /* OTHERS CLAIM VERSION 2*/

        // Claim Verification
        $claim_verification_count_v02= ($_SESSION['SESS_ROLE'] != "INTERN") ? v02notifyClaimVerification($_SESSION['SESS_ID'], $_SESSION['SESS_NOKP']) : 0;
        if ($claim_verification_count_v02 > 0) { ?>
            <li class="notification-list">
                <a href="../view/v02_aims_others_claim_hod_list.php">
                    <i class="fa fa-flag" style="color: <? echo $color['oc02'] ?>"></i> &nbsp;
                    <b><?php echo $module['oc02']; ?></b> You have <b><?php echo $claim_verification_count_v02; ?></b> verification action for CLAIM FORM.
                </a>
            </li>
        <? }

        // Claim Review
        /*$claim_review_count_v02= ($_SESSION['SESS_DEPARTMENT_SUB'] == "HR") ? v02notifyClaimReview($_SESSION['SESS_DEPARTMENT']) : 0;
        if ($claim_review_count_v02 > 0) { */?><!--
            <li class="notification-list">
                <a href="../view/v02_aims_others_claim_hr_list.php?department_code=<?/* echo $_SESSION['SESS_DEPARTMENT']*/?>">
                    <i class="fa fa-flag" style="color: <?/* echo $color['oc02'] */?>"></i> &nbsp;
                    <b><?php /*echo $module['oc02']; */?></b> You have <b><?php /*echo $claim_review_count_v02; */?></b> reviewal action for CLAIM FORM.
                </a>
            </li>
        --><?/* }*/

        // Claim Approval
        $claim_approval_count_v02= ($_SESSION['SESS_ROLE'] == "FOUNDER") ? v02notifyClaimApproval($_SESSION['SESS_ID']) : 0;
        if ($claim_approval_count_v02 > 0) { ?>
            <li class="notification-list">
                <a href="../view/v02_aims_others_claim_ceo_list.php">
                    <i class="fa fa-flag" style="color: <? echo $color['oc02'] ?>"></i> &nbsp;
                    <b><?php echo $module['oc02']; ?></b> You have <b><?php echo $claim_approval_count_v02; ?></b> approval action for CLAIM FORM.
                </a>
            </li>
        <? }

        /* TRANSPORT REQUEST */
        // Transport PIC Approval
        $transport_pic_approval_count= ($_SESSION['SESS_ROLE'] != "INTERN") ? notifyTransportPICApproval($_SESSION['SESS_NOKP']) : 0;
        if ($transport_pic_approval_count > 0) { ?>
            <li class="notification-list">
                <a href="../view/aims_car_companyapp.php">
                    <i class="fa fa-flag" style="color: <? echo $color['tr'] ?>"></i> &nbsp;
                    <b><?php echo $module['tr']; ?></b> You have <b><?php echo $transport_pic_approval_count; ?></b> PIC approval action for TRANSPORT REQUEST.
                </a>
            </li>
        <? }

        // Transport Admin Approval
        $transport_admin_approval_count= ($_SESSION['SESS_ROLE'] != "INTERN") ? notifyTransportAdminApproval($_SESSION['SESS_NOKP']) : 0;
        if ($transport_admin_approval_count > 0) { ?>
            <li class="notification-list">
                <a href="../view/aims_car_adUse_list.php">
                    <i class="fa fa-flag" style="color: <? echo $color['tr'] ?>"></i> &nbsp;
                    <b><?php echo $module['tr']; ?></b> You have <b><?php echo $transport_admin_approval_count; ?></b> Admin approval action for TRANSPORT REQUEST.
                </a>
            </li>
        <? }

        // Transport HOD Approval v2 (closed on 18/10/2023)
        /*$transport_hod_approval_count= ($_SESSION['SESS_ROLE'] != "INTERN") ? notifyTransportHodApproval($_SESSION['SESS_NOKP']) : 0;
        if ($transport_hod_approval_count > 0) { */?><!--
            <li class="notification-list">
                <a href="../view/aims_car_hod_list.php">
                    <i class="fa fa-flag" style="color: <?/* echo $color['tr'] */?>"></i> &nbsp;
                    <b><?php /*echo $module['tr']; */?></b> You have <b><?php /*echo $transport_hod_approval_count; */?></b> HOD approval action for TRANSPORT REQUEST.
                </a>
            </li>
        --><?/* }*/

        /* IN OUT VERSION 1 */
        // In Out Verification (Staff in same department)
        $inout_verification_count= ($_SESSION['SESS_ROLE'] != "INTERN") ? notifyInOutVerification($_SESSION['SESS_NOKP']) : 0;
        if ($inout_verification_count > 0) { ?>
            <li class="notification-list">
                <a href="../view/aims_list_verified_approve.php">
                    <i class="fa fa-flag" style="color: <? echo $color['io'] ?>"></i> &nbsp;
                    <b><?php echo $module['io']; ?></b> You have <b><?php echo $inout_verification_count; ?></b> verification action for IN OUT.
                </a>
            </li>
        <? }

        // In Out Approval (HOD)
        $inout_approval_count= ($_SESSION['SESS_ROLE'] != "INTERN") ? notifyInOutApproval($_SESSION['SESS_NOKP']) : 0;
        if ($inout_approval_count > 0) { ?>
            <li class="notification-list">
                <a href="../view/aims_list_approveinout.php">
                    <i class="fa fa-flag" style="color: <? echo $color['io'] ?>"></i> &nbsp;
                    <b><?php echo $module['io']; ?></b> You have <b><?php echo $inout_approval_count; ?></b> approval action for IN OUT.
                </a>
            </li>
        <? }

        /* IN OUT v2 */
        // In Out Verification (Staff in same department)
        $v02_inout_support_count= ($_SESSION['SESS_ROLE'] != "INTERN") ? v02NotifyInOutSupport($_SESSION['SESS_ID']) : 0;
        if ($v02_inout_support_count > 0) { ?>
            <li class="notification-list">
                <a href="../view/v02_aims_inout_support.php">
                    <i class="fa fa-flag" style="color: <? echo $color['iov2'] ?>"></i> &nbsp;
                    <b><?php echo $module['iov2']; ?></b> You have <b><?php echo $v02_inout_support_count; ?></b> support action for IN OUT v2.
                </a>
            </li>
        <? }

        // In Out Approval (HOD)
        $v02_inout_approval_count = ($_SESSION['SESS_ROLE'] != "INTERN") ? v02notifyInOutApproval($_SESSION['SESS_ID']) : 0;
        if ($v02_inout_approval_count > 0) { ?>
            <li class="notification-list">
                <a href="../view/v02_aims_inout_approval.php">
                    <i class="fa fa-flag" style="color: <? echo $color['iov2'] ?>"></i> &nbsp;
                    <b><?php echo $module['iov2']; ?></b> You have <b><?php echo $v02_inout_approval_count; ?></b> approval action for IN OUT v2.
                </a>
            </li>
        <? }

        // Medical Claim Approval - CFO
        $v02_medical_cfo_approval_count = ($_SESSION['SESS_ROLE'] == "CFO") ? v02notifyMedicalCfoApproval() : 0;
        if ($v02_medical_cfo_approval_count > 0) { ?>
            <li class="notification-list">
                <a href="../view/v02_aims_medical_cfo_list.php">
                    <i class="fa fa-flag" style="color: <? echo $color['mcv2'] ?>"></i> &nbsp;
                    <b><?php echo $module['mcv2']; ?></b> You have <b><?php echo $v02_medical_cfo_approval_count; ?></b> CFO approval action for MEDICAL CLAIM v2.
                </a>
            </li>
        <? }

        // Medical Claim Approval - CFO
        $v02_medical_ceo_approval_count = ($_SESSION['SESS_ROLE'] == "FOUNDER") ? v02notifyMedicalCeoApproval($_SESSION['SESS_ID']) : 0;
        if ($v02_medical_ceo_approval_count > 0) { ?>
            <li class="notification-list">
                <a href="../view/v02_aims_medical_ceo_list.php">
                    <i class="fa fa-flag" style="color: <? echo $color['mcv2'] ?>"></i> &nbsp;
                    <b><?php echo $module['mcv2']; ?></b> You have <b><?php echo $v02_medical_ceo_approval_count; ?></b> approval action for MEDICAL CLAIM v2.
                </a>
            </li>
        <? }

        //API aims-corp notification
        $notification_aims_corp = "https://corp.aimsglobal.com.my/api/get_notification_data_for_aims_office/".$_SESSION['SESS_ID'];
        $headers = array(
            'Content-Type:application/json'
        );

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$notification_aims_corp);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        $corp_notification = json_decode(curl_exec($ch), true);
        curl_close($ch);

        foreach ($corp_notification as $list){ ?>
            <li class="notification-list">
                <a href="<? echo $list['link'] ?>" target="_blank">
                    <i class="fa fa-flag" style="color: <? echo $color['vr'] ?>;"></i> &nbsp;
                    <b><?php echo $module['vr']; ?></b> <? echo $list['message']; ?>
                </a>
            </li>
        <? }

        //API pms notification
        $notification_pms = "https://aimsglobal.com.my/pms/controller/fetch_notification_exec.php?id=".$_SESSION['SESS_ID']."&role=".$_SESSION['SESS_ROLE']."&dept_sub=".$_SESSION['SESS_DEPARTMENT_SUB'];
        $headers = array(
            'Content-Type:application/json'
        );

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$notification_pms);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
        $corp_notification = json_decode(curl_exec($ch), true);
        curl_close($ch);

        foreach ($corp_notification as $list){ ?>
            <li class="notification-list">
                <a href="<? echo $list['href'] ?>" target="_blank">
                    <i class="fa fa-flag" style="color: <? echo $color[$list['code']] ?>;"></i> &nbsp;
                    <b><?php echo $module[$list['code']]; ?></b> <? echo $list['message']; ?>
                </a>
            </li>
        <? } ?>


    </ul>
</li>

<script>
    $(document).ready(function (){
        let notificationList = $('.notification-list').length;
        let notificationBadge = $('#notification-badge');
        let notificationBox = $('#notification-box');
        if (notificationList > 0){
            notificationBadge.css('display', 'inline-block');
        }else{
            notificationBadge.css('display', 'none');
            notificationBox.append('<li><a href="#"><i class="text-muted text-center">No notification at the moment</i></a></li>');
        }
    })
</script>
