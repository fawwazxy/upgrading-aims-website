<?php

require "../../app/model/v02_aims_ot_function.php";
require "../../app/model/lookup.php";
require  "../send_fcm.php";
require  "../log/log.php";
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header('Content-type: application/json');

$cmd = $_GET['cmd'];
$output = '';
$output_to_send = '';
$current_file='ot.php';
$executor =$_POST['executor'];

$use_staff_id = true;

switch ($cmd) {

    case '1'://v02getOtPermissionList
        $no_staff = clean($_GET['no_staff']);
        $staff_id = clean($_GET['staff_id']);
        $year = clean($_GET['year']);
        $month = clean($_GET['month']);
        $permission_list = v02getOtPermissionList($staff_id,$year,$month);
        $i=0;
        $array = array();
        while($list = $permission_list->fetch_assoc()){
            $array[$i] = $list;
            $array[$i]['approver_name'] = getStaffName($list['approval_id']);
            $i++;
        }
        $output_to_send = json_encode($array);
        break;

    case '2'://v02getMonthSession
        $staff_id = clean($_GET['staff_id']);
        $selected = clean($_GET['selected']);
        $output_to_send = json_encode(v02getMonthSession($staff_id, $selected,true)->fetch_all(MYSQLI_ASSOC));
        break;

    case '3'://v02getDateOt
        $staff_id = clean($_GET['staff_id']);
        $sort = clean($_GET['sort']);
        $month_session_id = clean($_GET['month_session_id']);
        $ot_date = v02getDateOt($staff_id, $sort, $month_session_id);
        $i=0;
        $array = array();
        while($list = $ot_date->fetch_assoc()){
            $day=date('l',strtotime($list['date']));
            $array[$i] = $list;
            $array[$i]['day'] = $day;
            //$array[$i]['ot_list'] = v02getOtList($list['id'])->fetch_all(MYSQLI_ASSOC);
            //----------------
            $ot_list = v02getOtList($list['id']);
            $j=0;
            $inner_array = array();
            while($inner_list = $ot_list->fetch_assoc()){
                $inner_array[$j] = $inner_list;
                $inner_array[$j]['verify_by'] = getStaffName($inner_list['verify_by']);
                $inner_array[$j]['review_by'] = getStaffName($inner_list['review_by']);
                $inner_array[$j]['approved_by'] = getStaffName($inner_list['approved_by']);
                $j++;
            }
            $array[$i]['ot_list'] = $inner_array;
            //----------------
            $i++;
        }
        $output_to_send = json_encode($array);
        break;

    case '4'://getDropDownApproval
        $dropdown_approval = getDropDownApproval('', true);
        $i=0;
        $array = array();
        while($list = $dropdown_approval->fetch_assoc()){
            if($list['role_id']=='FOUNDER')
            {
                if($list['no_staff']=='751206035485'){
                    $list['role_id']='CEO';
                }
                else{
                    $list['role_id']='EC';
                }
            }
            $array[$i] = $list;
            $i++;
        }
        $output_to_send = json_encode($array);
        break;

    case '5'://v02addOtPermission
        $rate_mode = clean($_POST['rate_mode']);
        $applicant_id = clean($_POST['applicant_id']);
        $description = clean($_POST['description']);
        $approval_id = clean($_POST['approval_id']);
        $output_to_send = json_encode(v02addOtPermission($rate_mode, $applicant_id, $description, $approval_id));
        $token = getOtpApprovalFCMToken($approval_id);
        if($token!=''){
            $title = 'OT Permission Approval';
            $body = 'You have new permission from '.ucwords(getStaffName($applicant_id));
            sendFCM($token,$title,$body);
        }

        $all_parameters = 'Rate Mode: '.$rate_mode.'; '.'Applicant ID: '.$applicant_id.'; '.'Description: '.$description.'; '.'Approval ID: '.$approval_id;
        LogAccessHistory('CMD: '.$cmd, 'Executor: '.$executor, 'File Name: '.$current_file, $all_parameters);
        break;

    case '6'://v02editOtPermission
        $id = clean($_POST['id']);
        $rate_mode = clean($_POST['rate_mode']);
        $description = clean($_POST['description']);
        $approval_id = clean($_POST['approval_id']);
        $output_to_send = json_encode(v02updateOtPermission($id,$rate_mode,$approval_id,$description));
        $applicant_id = v02getOtPermissionById($id)->fetch_object()->applicant_id;
        $token = getOtpApprovalFCMToken($approval_id);
        if($token!=''){
            $title = 'OT Permission Approval';
            $body = 'You have updated permission from '.ucwords(getStaffName($applicant_id));
            sendFCM($token,$title,$body);
        }

        $all_parameters = 'ID: '.$id.'; '.'Rate Mode: '.$rate_mode.'; '.'Description: '.$description.'; '.'Approval id: '.$approval_id;
        LogAccessHistory('CMD: '.$cmd, 'Executor: '.$executor, 'File Name: '.$current_file, $all_parameters);
        break;

    case '7'://v02getUnclaimedOtp
        $staff_id = clean($_GET['staff_id']);
        $output_to_send = json_encode(v02getUnclaimedOtp($staff_id)->fetch_all(MYSQLI_ASSOC));
        break;

    case '8'://v02getDropDownMonthClaim
        $no_staff = clean($_GET['no_staff']);
        $ic_number = convertStaffNotoIcNumber($no_staff);
        $department_sub = clean($_GET['department_sub']);
        $otp_id = clean($_GET['otp_id']);
        $ot_permission = v02getOtPermissionById($otp_id)->fetch_assoc();
        $array_of_agmhesb_contractor = v02getContractorList();

        if ($ot_permission['approval_status'] == 0){
            echo "ot permission not approved yet";
            break;
        }

        $ot_day_closed = 15;

        if (in_array($ic_number, $array_of_agmhesb_contractor)){
            $ot_day_closed = 31;
        }
        else if ($department_sub == 'MOORING-GANG'){
            $ot_day_closed = 20;
        }

        $suggested_month_claim = date('d') <= $ot_day_closed ? date("Y-m"): date("Y-m", strtotime("first day of next month", time()));
        $listed_months = (in_array($ic_number, $array_of_agmhesb_contractor)) ? v02getDropDownMonthClaimContractor($suggested_month_claim, 0,0,true) : v02getDropDownMonthClaim($suggested_month_claim,0,0,true);
        $array =array();
        $array['ot_day_closed']=$ot_day_closed;
        $array['dropdown_list']=$listed_months;
        $array['ot_details']=$ot_permission;
        $array['ot_day']=date('l', strtotime($ot_permission['created_at']));
        $output_to_send = json_encode($array);
        break;

    case '9'://v02addOt
        $staff_id = clean($_POST['staff_id']);
        $ot_permission_id = clean($_POST['ot_permission_id']);
        $month_claim = clean($_POST['month_claim']);
        $date_ot = clean($_POST['date_ot']);
        $start_ot = clean($_POST['start_ot']);
        $end_ot = clean($_POST['end_ot']);
        $total_hours = clean($_POST['total_hours']);
        $file_bytes = clean($_POST['filebytes']);
        $extension = clean($_POST['extension']);

        $document_name = $file_size = null;

        $file = base64_decode($file_bytes);
        if($file_bytes!='' and $extension!=''){
            $document_name=date('Ymd_hisu')."_".'.'.$extension;
            $filepath = '../../overtimephoto/'.$document_name;
            $file_size=strlen(base64_decode($file_bytes));
            file_put_contents($filepath,base64_decode($file_bytes));
        }
        $token = getOtApprovalFCMToken($ot_permission_id);
        if($token!=''){
            $title = 'OT Claim Approval';
            $body = 'You have new OT Claim from '.ucwords(getStaffName($staff_id));
            sendFCM($token,$title,$body);
        }
        $output_to_send = json_encode(v02addOt($staff_id,$ot_permission_id,$month_claim,$date_ot,$start_ot,$end_ot,$total_hours,$document_name,$file_size));
        $all_parameters = 'Staff id: '.$staff_id.'; '.'OT Permission ID: '.$ot_permission_id.'; '.'Month Claim: '.$month_claim.'; '.'Date OT: '.$date_ot.'; '.'Start OT: '.$start_ot.'; '.'End OT: '.$end_ot.'; '.'Total Hours: '.$total_hours;
        LogAccessHistory('CMD: '.$cmd, 'Executor: '.$executor, 'File Name: '.$current_file, $all_parameters);
        break;

    case '10'://v02deleteOt
        $id = clean($_POST['id']);
        $department_sub = clean($_POST['department_sub']);
        $ot_info = v02getOtInfo($id)->fetch_assoc();
        $file = "../../overtimephoto/" . $ot_info['document_name'];
        $non_permission = ["HR-AGMA", "OPERATION-AGMSB", "OPERATION-BUNKER"];

        v02updateDateSummary($ot_info['ot_date_id'],$ot_info['total_hours']);
        $result = v02deleteOt($id);
        if (in_array($department_sub,$non_permission)){
            v02deleteOtPermission($ot_info['ot_permission_id']);
        }
        if (is_file($file))
        {
            unlink($file);
        }
        $output_to_send = json_encode($result);
        $all_parameters = 'ID: '.$id.'; '.'Department Sub: '.$department_sub;
        LogAccessHistory('CMD: '.$cmd, 'Executor: '.$executor, 'File Name: '.$current_file, $all_parameters);
        break;

    case '11'://v02updateOt
        $id = clean($_POST['id']);
        $start_ot = clean($_POST['start_ot']);
        $end_ot = clean($_POST['end_ot']);
        $total_hours = clean($_POST['total_hours']);
        $file_bytes = clean($_POST['filebytes']);
        $extension = clean($_POST['extension']);
        $old_document = v02viewAttachment($id)->fetch_object()->document_name;
        $old_filepath = "../../overtimephoto/" . $old_document;

        //remove old file if new file found and insert newfile;
        if($file_bytes!='' and $extension!=''){
            if (is_file($old_filepath))
            {
                unlink($old_filepath);
            }
            $new_document_name=date('Ymd_hisu')."_".'.'.$extension;
            $filepath = '../../overtimephoto/'.$new_document_name;
            $file_size=strlen(base64_decode($file_bytes));
            file_put_contents($filepath,base64_decode($file_bytes));
            v02updateAttachment($id,$new_document_name,$file_size);
        }

        $ot_info = v02getOtInfo($id)->fetch_assoc();
        $date_id = $ot_info['ot_date_id'];
        $previous_hour = $ot_info['total_hours'];

        hourAdjust($date_id, $previous_hour, $total_hours);

        $result = v02updateOt($id,$start_ot,$end_ot,$total_hours);

        $output_to_send = json_encode($result);
        $all_parameters = 'ID:: '.$id.'; '.'Start OT: '.$start_ot.'; '.'End OT: '.$end_ot.'; '.'Total Hours: '.$total_hours;
        LogAccessHistory('CMD: '.$cmd, 'Executor: '.$executor, 'File Name: '.$current_file, $all_parameters);
        break;

    case '12'://getAttachment
        $document_url = clean($_GET['document_url']);
        $output_to_send = base64_encode(file_get_contents('../../overtimephoto/'.$document_url));
        break;

    case '13'://gethodpermissionapprovalist
        $approval_id = clean($_GET['approval_id']);
        $approval = clean($_GET['approval']);
        $month = clean($_GET['month']);
        $year = clean($_GET['year']);
        $hod_approval_list = v02getOtPermissionApproval($approval_id, $approval, $month, $year);
        $i=0;
        $array = array();
        while($list = $hod_approval_list->fetch_assoc()){
            $array[$i] = $list;
            $array[$i]['name'] = getStaffName($list['applicant_id']);
            $i++;
        }
        $output_to_send = json_encode($array);
        break;

    case '14'://hodotpermissionremark
        $id = clean($_POST['id']);
        $remark = clean($_POST['remark']);
        $output_to_send = json_encode(v02remarkOtPermission($id,$remark));

        $all_parameters = 'ID: '.$id.'; '.'Remark: '.$remark;
        LogAccessHistory('CMD: '.$cmd, 'Executor: '.$executor, 'File Name: '.$current_file, $all_parameters);
        break;

    case '15'://hodapproveotpermission
        $id = clean($_POST['id']);
        $approval_status = clean($_POST['approval_status']);
        $output_to_send = json_encode(v02approveOtPermission($id,$approval_status));
        $token = getOtpApplicantFCMToken($id);
        if($token!='' && $approval_status=='1'){
            $title = 'OT Permission Approved';
            $body = 'You OT permission has been approved';
            sendFCM($token,$title,$body);
        }
        $all_parameters = 'ID: '.$id.'; '.'Approval Status: '.$approval_status;
        LogAccessHistory('CMD: '.$cmd, 'Executor: '.$executor, 'File Name: '.$current_file, $all_parameters);
        break;

    case '16'://hodapproveotclaim
        $department_sub = clean($_GET['department_sub']);
        $staff_id_verify = clean($_GET['staff_id_verify']);
        $verification_status = clean($_GET['verification_status']);
        $month = clean($_GET['month']);
        $year = clean($_GET['year']);
        $list_month = v02getMonthSessionHOD($department_sub, $staff_id_verify, $verification_status, $month, $year);
        $i=0;
        $array = array();
        while($list = $list_month->fetch_assoc()){
            $verify_info = v02getLatestVerifyInfo($list['id'], $verification_status, $staff_id_verify)->fetch_assoc();
            if($verify_info['selected_row'] > 0){
                $array[$i] = $list;
                $array[$i]['verify_by'] = $verify_info['verify_by'];
                $array[$i]['verify_at'] = $verify_info['verify_at'];
                $array[$i]['selected_row'] = $verify_info['selected_row'];
                $array[$i]['total_row'] = $verify_info['total_row'];
                $i++;
            }
        }
        $output_to_send = json_encode($array);
        break;

    case '17'://getOtByMonthSession
        $month_session_id = clean($_GET['month_session_id']);
        $verification_status = clean($_GET['verification_status']);
        $staff_id = clean($_GET['staff_id']);
        $ot_by_month_session = v02getOtByMonthSession($month_session_id, $verification_status, $staff_id);
        $i=0;
        $array = array();
        while($list = $ot_by_month_session->fetch_assoc()){
            $day=date('l',strtotime($list['date']));
            $array[$i] = $list;
            $array[$i]['day'] = $day;
            $i++;
        }
        $output_to_send = json_encode($array);
        break;

    case '18'://v02verificationRemark
        $id = clean($_POST['id']);
        $verification_remark = clean($_POST['verification_remark']);
        $output_to_send = json_encode(v02verificationRemark($id, $verification_remark));

        $all_parameters = 'ID: '.$id.'; '.'Verification Mark: '.$verification_remark;
        LogAccessHistory('CMD: '.$cmd, 'Executor: '.$executor, 'File Name: '.$current_file, $all_parameters);
        break;

    case '19'://v02CheckboxVerifyOtClaim
        $id_list = clean($_POST['id_list']);
        $verification_by = clean($_POST['verification_by']);
        $verification_status = clean($_POST['verification_status']);
        $ids = json_decode($id_list);
        $id_array = "('" . implode("','", $ids) . "');";
        echo $id_array;
        $output_to_send = json_encode(v02CheckboxVerifyOtClaim($id_array, $verification_by, $verification_status));
        $all_parameters = 'ID List: '.$id_list.'; '.'Verification By: '.$verification_by.'; '.'Verification Status: '.$verification_status;
        LogAccessHistory('CMD: '.$cmd, 'Executor: '.$executor, 'File Name: '.$current_file, $all_parameters);
        break;

    case '20'://v02CheckboxVerifyMonthClaim
        $id_list = clean($_POST['id_list']);
        $verification_by = clean($_POST['verification_by']);
        $verification_status = clean($_POST['verification_status']);
        $prev_verification = clean($_POST['prev_verification']);
        $ids = json_decode($id_list);
        $id_array = "('" . implode("','", $ids) . "');";
        echo $id_array;
        $output_to_send = json_encode(v02CheckboxVerifyMonthClaim($id_array, $verification_by, $verification_status,$prev_verification));

        $all_parameters = 'ID List: '.$id_list.'; '.'Verification By: '.$verification_by.'; '.'Verification Status: '.$verification_status.'; '.'Previous Verification: '.$prev_verification;
        LogAccessHistory('CMD: '.$cmd, 'Executor: '.$executor, 'File Name: '.$current_file, $all_parameters);
        break;

    case '21'://v02getDropDownmonthClaim-AGMSB/HR-AGMA/OPERATION-BUNKER
        $ot_day_closed = '16';
        $suggested_month_claim = date('d') <= $ot_day_closed ? date("Y-m"): date("Y-m", strtotime("first day of next month", time()));
        $listed_months = v02getDropDownMonthClaim($suggested_month_claim,0,0,true);
        $array =array();
        $array['dropdown_list']=$listed_months;
        $array['ot_day_closed']=$ot_day_closed;
        $output_to_send = json_encode($array);
        break;

    case '22'://v02addOtAgmsb
        $staff_id = clean($_POST['staff_id']);
        $month_claim = clean($_POST['month_claim']);
        $date_ot = clean($_POST['date_ot']);
        $start_ot = clean($_POST['start_ot']);
        $end_ot = clean($_POST['end_ot']);
        $total_hours = clean($_POST['total_hours']);
        $description = clean($_POST['description']);
        $rate_mode =  clean($_POST['rate_mode']);
        $file_bytes =  clean($_POST['filebytes']);
        $extension =  clean($_POST['extension']);

        $document_name = $file_size = null;

        $result = v02addOtPermission($rate_mode,$staff_id,$description,"auto");
        if($result!="" && $result > 0) {
            $ot_permission_id = $result;
            $result_approval = v02autoApprovePermission($ot_permission_id);
            $file = base64_decode($file_bytes);
            if($file_bytes!='' and $extension!=''){
                $document_name=date('Ymd_hisu')."_".'.'.$extension;
                $filepath = '../../overtimephoto/'.$document_name;
                $file_size=strlen(base64_decode($file_bytes));
                file_put_contents($filepath,base64_decode($file_bytes));
            }
            $result = v02addOt($staff_id,$ot_permission_id,$month_claim,$date_ot,$start_ot,$end_ot,$total_hours,$document_name,$file_size);
            $token = getAGMAHODFCMToken();
            if($token!=''){
                $title = 'OT Claim Approval';
                $body = 'You have new OT Claim from '.ucwords(getStaffName($staff_id));
                sendFCM($token,$title,$body);
            }
            $output_to_send = json_encode($result);

        }
        $all_parameters = 'Staff_id: '.$staff_id.'; '.'Month Claim: '.$month_claim.'; '.'Date OT: '.$date_ot.'; '.'Start OT: '.$start_ot.'; '.'End OT: '.$end_ot.'; '.'Total Hours: '.$total_hours.'; '.'Description: '.$description.'; '.'Rate Mode: '.$rate_mode;
        LogAccessHistory('CMD: '.$cmd, 'Executor: '.$executor, 'File Name: '.$current_file, $all_parameters);
        break;

    case '23'://v02getDropDownCompany
        $output_to_send = json_encode(getDropDown("department","code_department","description","dummyvalue",true));
        break;

    case '24'://getlistforCEOapproveotclaim
        $department_code = clean($_GET['department_code']);
        $staff_id = clean($_GET['staff_id']);
        $approved_status = clean($_GET['approved_status']);
        $year = clean($_GET['year']);
        $month_session_list = v02getMonthSessionCEO($department_code, $staff_id, $approved_status,0, $year);
        $i=1;
        $array = array();
        while($month_session = $month_session_list->fetch_assoc()){
            $approved_info = v02getLatestApprovalInfo($month_session['id'], $approved_status)->fetch_assoc();
            if($approved_info['selected_row'] > 0){
                $array[$i]['id'] = $month_session['id'];
                $array[$i]['name'] = $month_session['name'];
                $array[$i]['noic'] = $month_session['noic'];
                $array[$i]['role_id'] = $month_session['role_id'];
                $array[$i]['department_sub'] = $month_session['department_sub'];
                $array[$i]['month_session'] = $month_session['month_session'];
                $array[$i]['total_claim'] = $month_session['total_claim'];
                $array[$i]['department_id'] = $month_session['department_id'];
                $array[$i]['selected_row'] = $approved_info['selected_row'];
                $array[$i]['total_row'] = $approved_info['total_row'];
                $i++;
            }
        }
        $output_to_send = json_encode(array_values($array));
        break;

    case '25'://v02approveOtClaim
        $id = clean($_POST['id']);
        $approved_by = clean($_POST['approved_by']);
        $approved_status = clean($_POST['approved_status']);
        $output_to_send = json_encode(v02approveOtClaim($id, $approved_by, $approved_status));

        $all_parameters = 'ID: '.$id.'; '.'Approved By: '.$approved_by.'; '.'Approved Status: '.$approved_status;
        LogAccessHistory('CMD: '.$cmd, 'Executor: '.$executor, 'File Name: '.$current_file, $all_parameters);
        break;

    case '26'://v02CheckboxApproveMonthClaim
        $id_list = clean($_POST['id_list']);
        $approval_by = clean($_POST['approval_by']);
        $approval_status = clean($_POST['approval_status']);
        $prev_approval = clean($_POST['prev_approval']);
        $ids = json_decode($id_list);
        $id_array = "('" . implode("','", $ids) . "');";
        echo $id_array;
        $output_to_send = json_encode(v02CheckboxApproveMonthClaim($id_array, $approval_by, $approval_status, $prev_approval));

        $all_parameters = 'ID List: '.$id_list.'; '.'Approval By: '.$approval_by.'; '.'Approval Status: '.$approval_status.'; '.'Previous Approval: '.$prev_approval;
        LogAccessHistory('CMD: '.$cmd, 'Executor: '.$executor, 'File Name: '.$current_file, $all_parameters);
        break;

    case '27'://v02deleteOtPermission
        $id = clean($_POST['id']);
        $output_to_send = json_encode(v02deleteOtPermission($id));

        $all_parameters = 'ID: '.$id;
        LogAccessHistory('CMD: '.$cmd, 'Executor: '.$executor, 'File Name: '.$current_file, $all_parameters);
        break;

    case '28'://v02getOtMonthSessionSummary
        $staff_id = clean($_GET['staff_id']);
        $ot_month_session = v02getOtMonthSession($staff_id);
        $i= 0;
        $array = array();
        while($otm = $ot_month_session->fetch_assoc()) {
            if(v02getCountOtMonthSession($otm['id']) > 0){
                $getOtApproval = v02getOtApproval($otm['id']);
                $hod_intersect = 1; $hr_intersect = 1; $ceo_intersect = 1; //set default to true (GREEN)
                while ($otApproval = $getOtApproval->fetch_assoc()){
                    //HOD status -- if hod false, hr and ceo will false (GREY)
                    if (empty($otApproval['verify_by']) && empty($otApproval['verify_at'])){
                        $hod_intersect = 0; $hr_intersect = 0; $ceo_intersect = 0;
                        break;
                    }else{
                        if ($otApproval['verify_status'] == '1'){
                            $hod_verify_at = $otApproval['verify_at'];
                        }else{
                            $hod_intersect = 0; $hr_intersect = 0; $ceo_intersect = 0;
                            break;
                        }
                    }

                    //HR status -- if hr false, ceo will false
                    if (empty($otApproval['review_by']) && empty($otApproval['review_at'])){
                        $hr_intersect = 0; $ceo_intersect = 0;
                        break;
                    }else{
                        if ($otApproval['review_status'] == '1'){
                            $hr_review_at = $otApproval['review_at'];
                        }else{
                            $hr_intersect = 0; $ceo_intersect = 0;
                            break;
                        }
                    }

                    //CEO status -- ceo will false if hod or hr is false
                    if (empty($otApproval['approved_by']) && empty($otApproval['approved_at'])){
                        $ceo_intersect = 0;
                        break;
                    }else{
                        if ($otApproval['approved_status'] == '1'){
                            $ceo_approved_at = $otApproval['approved_at'];
                        }else{
                            $ceo_intersect = 0;
                            break;
                        }
                    }
                }
                $array[$i]['month_session'] = strtoupper($otm['month_session']);
                $array[$i]['total_claim'] = $otm['total_claim'];
                $array[$i]['hod_status'] = $hod_intersect;
                $array[$i]['hr_status'] =$hr_intersect;
                $array[$i]['ceo_status'] = $ceo_intersect;
                $array[$i]['report_id'] = $otm['id'];
                $i++;
            }

        }
        $output_to_send = json_encode($array);
        break;

}

echo $output_to_send;
