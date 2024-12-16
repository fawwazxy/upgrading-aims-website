<?php
require "../../app/model/v02_aims_leave_function.php";
require  "../send_fcm.php";
require  "../log/log.php";
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header('Content-type: application/json');

$cmd = $_GET['cmd'];
$output = '';
$output_to_send = '';
$current_file='cuti.php';
$executor =$_POST['executor'];
switch ($cmd){

    case '1'://getLeaveType
        //for edit leave, this parameter is required
        $application_leave_type = clean($_GET['application_leave_type']);
        $application_total_days = clean($_GET['total_days']);
        //for add and edit, parameter staff_id
        $staff_id = clean($_GET['staff_id']);

        //get an array of leave type
        $all_leave_type = getLeaveType('',true);

        $available_balance = getDefaultLeaveBalance();

        $leave_quota = getLeaveQuotaByStaffId($staff_id, date('Y'));
        while ($quota = $leave_quota->fetch_assoc()){
            $current_days = ($application_leave_type == $quota['leave_type']) ? $application_total_days : 0;
            $pending_leave = getCountLeave($quota['leave_type'], $quota['staff_id'], $quota['start_date'], $quota['end_date']);
            $available_balance[$quota['leave_type']] = $quota['current_balance'] - $pending_leave + $current_days;
        }

        $i=0;
        foreach (array_keys($all_leave_type) as $index){
            if($available_balance[$index] <= 0){
                unset($all_leave_type[$index]);
                if ($index == 'ul' && $available_balance['al'] < 1){
                    $all_leave_type['ul'] = 'Unpaid Leave';
                }
            }
        }
        echo  json_encode($all_leave_type);
        //----------------
        break;

    case '2'://getStaffName
        $id = clean($_GET['id']);
        $output_to_send = getStaffName($id);
        break;

    case '3'://getLeaveTypeDetails
        $staff_id = clean($_GET['staff_id']);
        $year = clean($_GET['year']);
        $quota = getLeaveQuotaByStaffId($staff_id,$year);

        $i=0;
        $array = array();
        while ($list = $quota->fetch_assoc()){
            $leave_type_name = getLeaveType($list['leave_type']);
            $pending = getCountLeave($list['leave_type'], $list['staff_id'], $list['start_date'], $list['end_date']);
            $available = $list['current_balance'] - $pending;
            $used = $list['entitled_balance'] - $list['current_balance'];

            $array[$i]['id'] = $list['id'];
            $array[$i]['leave_type'] = $list['leave_type'];
            $array[$i]['leave_type_name'] = $leave_type_name;
            $array[$i]['entitled_balance'] = $list['entitled_balance'];
            $array[$i]['current_balance'] = $list['current_balance'];
            $array[$i]['staff_id'] = $list['staff_id'];
            $array[$i]['start_date'] = $list['start_date'];
            $array[$i]['end_date'] = $list['end_date'];
            $array[$i]['pending'] = $pending;
            $array[$i]['available'] = (string)number_format($available, 1);
            $array[$i]['used'] = (string)number_format($used, 1);
            $i++;
        }
//        $listJenisCuti= json_encode($quota->fetch_all(MYSQLI_ASSOC));
        echo json_encode($array);

        //$output_to_send = json_encode(getCountLeave($type,$staff_id,$quota_start,$quota_end,null));
        break;

    case '4'://getLeaveListByYear
        $staff_id = clean($_GET['staff_id']);
        $year = clean($_GET['year']);
        $leave_list=getLeaveListByYear($staff_id,$year);
        $i=0;
        $array = array();
        while($list = $leave_list->fetch_assoc()){
            if($list['support_by']!=null){
                $list['support_by'] = getStaffName($list['support_by']);
            }
            if($list['approval_by']!=null){
                $list['approval_by'] = getStaffName($list['approval_by']);
            }
            if($list['hr_checked_by']!=null){
                $list['hr_checked_by'] = getStaffName($list['hr_checked_by']);
            }
            $leave_type_name = getLeaveType($list['leave_type']);
            $array[$i] = $list;
            $array[$i]['leave_type_name'] = $leave_type_name;

            $i++;
        }
        $output_to_send =  json_encode($array);
        //$output_to_send = json_encode(getLeaveListByYear($staff_id,$year)->fetch_all(MYSQLI_ASSOC));
        break;

    case '5'://getLeaveById
        $id = clean($_GET['leave_id']);
        $output_to_send = json_encode(getLeaveById($id)->fetch_all(MYSQLI_ASSOC));
        break;

    case '6'://getDepartment
        $id = clean($_GET['staff_id']);
        $output_to_send = json_encode(getStaffDepartment($id)->fetch_object()->department_sub);
        break;

    case '7'://autocountleavedays
        $no_staff = clean($_GET['no_staff']);
        $start_date = clean($_GET['start_date']);
        $end_date = clean($_GET['end_date']);
        $output_to_send = json_encode(autoCountLeaveDays($no_staff,$start_date,$end_date));
        break;

    case '8'://addnewleave
        $staff_id = clean($_POST['staff_id']);
        $start_date = clean($_POST['start_date']);
        $end_date = clean($_POST['end_date']);
        $leave_type = clean($_POST['leave_type']);
        $total_days = clean($_POST['total_days']);
        $description = clean($_POST['description']);
        $filebytes = clean($_POST['filebytes']);
        $extension = clean($_POST['extension']);
        $file = base64_decode($filebytes);
        if($filebytes!='' and $extension!=''){
            $max_id =getMaxIdLeave()+1;
            $document_name=date('Ymd_his')."_".$max_id.'.'.$extension;
            $filepath = '../../leave_photo/'.$document_name;
            $file_size=strlen(base64_decode($filebytes));
            file_put_contents($filepath,base64_decode($filebytes));
        }
        $output_to_send = json_encode(addNewLeave($staff_id, $start_date, $end_date, $leave_type, $total_days, $description, $document_name, $file_size));
        $all_parameters = 'Staff ID: '.$staff_id.'; '.'Start Date: '.$start_date.'; '.'End Date: '.$end_date.'; '.'Leave Type: '.$leave_type.'; '.'Total Days: '.$total_days.'; '.'Description: '.$description;
        LogAccessHistory('CMD: '.$cmd, 'Executor: '.$executor, 'File Name: '.$current_file, $all_parameters);
        break;

    case '9'://deleteLeave
        $leave_id = clean($_POST['leave_id']);
        $document_name = clean($_POST['document_name']);
        if (is_file('../../leave_photo/'.$document_name))
        {
            unlink('../../leave_photo/'.$document_name);
        }
        $output_to_send = json_encode(deleteLeave($leave_id));
        $all_parameters = 'ID: '.$leave_id.'; '.'Document Name: '.$document_name;
        LogAccessHistory('CMD: '.$cmd, 'Executor: '.$executor, 'File Name: '.$current_file, $all_parameters);
        break;

    case '10'://getattachment
        $document_url = clean($_GET['document_url']);
        $output_to_send = base64_encode(file_get_contents('../../leave_photo/'.$document_url));
        break;

    case '11'://updateleave
        $leave_id = clean($_POST['leave_id']);
        $start_date = clean($_POST['start_date']);
        $end_date = clean($_POST['end_date']);
        $leave_type = clean($_POST['leave_type']);
        $total_days = clean($_POST['total_days']);
        $description = clean($_POST['description']);
        $filebytes = clean($_POST['filebytes']);
        $extension = clean($_POST['extension']);
        $file = base64_decode($filebytes);

        if($filebytes!='' and $extension!=''){
            $old_document = str_replace('"','',json_encode(viewLeaveAttachment($leave_id)->fetch_object()->document_url));
            if (is_file('../../leave_photo/'.$old_document))
            {
                unlink('../../leave_photo/'.$old_document);
            }
            $max_id =getMaxIdLeave()+1;
            $document_name=date('Ymd_his')."_".$max_id.'.'.$extension;
            $filepath = '../../leave_photo/'.$document_name;
            $file_size=strlen(base64_decode($filebytes));
            file_put_contents($filepath,base64_decode($filebytes));
        }
        $output_to_send = json_encode(updateLeave($leave_id, $start_date, $end_date, $leave_type, $total_days, $description, $document_name, $file_size));
        $all_parameters = 'Leave ID: '.$leave_id.'; '.'Start Date: '.$start_date.'; '.'End Date: '.$end_date.'; '.'Leave Type: '.$leave_type.'; '.'Total Days: '.$total_days.'; '.'Description: '.$description;
        LogAccessHistory('CMD: '.$cmd, 'Executor: '.$executor, 'File Name: '.$current_file, $all_parameters);
        break;

    case '12'://getsupport
        $staff_id = clean($_GET['staff_id']);
        $month = clean($_GET['month']);
        $year = clean($_GET['year']);
        $support = clean($_GET['support']);
        $leave_support_list=getLeaveSupportList($staff_id,$month,$year,$support);
        $i=0;
        $array = array();
        while($list = $leave_support_list->fetch_assoc()){
            $leave_type_name = getLeaveType($list['leave_type']);
            $array[$i] = $list;
            $list['support_by'] == "" ? : $array[$i]['support_by'] = getStaffName($list['support_by']);
            $array[$i]['leave_type_name'] = $leave_type_name;
            $i++;
        }
        $output_to_send = json_encode($array);
        break;

    case '13'://supportaction
        $leave_id = clean($_POST['leave_id']);
        $action = clean($_POST['action']);
        $support_by = clean($_POST['support_by']);
        $output_to_send=json_encode(supportLeave($leave_id, $action, $support_by));
        if($action=='1'){
            $staff_info = getLeaveById($leave_id)->fetch_object();
            $staff_id = $staff_info->staff_id;
            $staff_name = strtolower(getStaffName($staff_id));
            $token = getTokenLeaveApproval($staff_id);
            if($token!=''){
                $title = 'Kelulusan Permohonan Cuti';
                $body = 'Anda ada permohonan cuti baharu daripada '.ucwords($staff_name);
                sendFCM($token,$title,$body);
            }
        }

        $all_parameters = 'Leave ID: '.$leave_id.'; '.'Action: '.$action.'; '.'Support By: '.$support_by;
        LogAccessHistory('CMD: '.$cmd, 'Executor: '.$executor, 'File Name: '.$current_file, $all_parameters);
        break;

    case '14'://getleaveapprovallist
        $staff_id = clean($_GET['staff_id']);
        $month = clean($_GET['month']);
        $year = clean($_GET['year']);
        $approval = clean($_GET['approval']);
        $leave_approval_list=getLeaveApprovalList($staff_id,$month,$year,$approval);
        $i=0;
        $array = array();
        while($list = $leave_approval_list->fetch_assoc()){
            $leave_type_name = getLeaveType($list['leave_type']);
            $array[$i] = $list;
            $array[$i]['leave_type_name'] = $leave_type_name;
            $list['support_by'] == "" ? : $array[$i]['support_by'] = getStaffName($list['support_by']);
            $list['approval_by'] == "" ? : $array[$i]['approval_by'] = getStaffName($list['approval_by']);
            $i++;
        }
        $output_to_send = json_encode($array);
        break;

    case '15'://approveaction
        $leave_id = clean($_POST['leave_id']);
        $action = clean($_POST['action']);
        $approve_by = clean($_POST['approve_by']);
        $output_to_send=json_encode(approveLeave($leave_id, $action, $approve_by));

        $all_parameters = 'Leave ID: '.$leave_id.'; '.'Action: '.$action.'; '.'Approve By: '.$approve_by;
        LogAccessHistory('CMD: '.$cmd, 'Executor: '.$executor, 'File Name: '.$current_file, $all_parameters);
        break;

    case '16'://getmaklumatjeniscutitanpakuota
        $staff_id = clean($_GET['staff_id']);
        $year = clean($_GET['year']);
        $i=0;
        $array = array();
        foreach (getLeaveQuotaList(false) as $item){
            $usage = getCountLeave($item, $staff_id, $year."-01-01", $year."-12-31", 1);
            $pending_leave = getCountLeave($item, $staff_id, $year."-01-01", $year."-12-31");
            $array[$i]['leave_name'] = getLeaveType($item);
            $array[$i]['usage'] = $usage;
            $array[$i]['pending'] = $pending_leave;
            $i++;
        }
        $output_to_send=json_encode($array);
        break;
}
// Closing connection
//mysqli_close($connjson);
echo $output_to_send;
