<?php
require "../../app/model/v02_aims_inout_function.php";
require  "../send_fcm.php";
require  "../log/log.php";
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header('Content-type: application/json');

$cmd = $_GET['cmd'];
$output = '';
$output_to_send = '';
$current_file='inout.php';
$executor =$_POST['executor'];
switch ($cmd){

    case '1'://getInOutList
        $staff_id = clean($_GET['staff_id']);
        $year = clean($_GET['year']);
        $in_out_list = getInOutList($staff_id,$year);
        $i=0;
        $array = array();
        while($in_out = $in_out_list->fetch_assoc()){
            $in_out['support_by']==null ? : $in_out['support_by'] = getStaffName($in_out['support_by']);
            $in_out['approve_by']==null ? : $in_out['approve_by'] = getStaffName($in_out['approve_by']);
            $in_out['hr_checked_by']==null ? : $in_out['hr_checked_by'] = getStaffName($in_out['hr_checked_by']);
            $array[$i] = $in_out;
            $array[$i]['day'] = date('l', strtotime($in_out['created_at']));
            $i++;
        }
        $output_to_send =  json_encode($array);
        break;

    case '2'://addinout
        $staff_id = clean($_POST['staff_id']);
        $date = clean($_POST['date']);
        $time_out = clean($_POST['time_out']);
        $time_in = clean($_POST['time_in']);
        $description = clean($_POST['description']);
        $filebytes = clean($_POST['filebytes']);
        $extension = clean($_POST['extension']);
        if($filebytes!='' and $extension!=''){
            $document_name=date('Ymd_his').'.'.$extension;
            $filepath = '../../inout_photo/'.$document_name;
            $file_size=strlen(base64_decode($filebytes));
            file_put_contents($filepath,base64_decode($filebytes));
        }
        $output_to_send = json_encode(addNewInOut($staff_id, $date, $time_out, $time_in, $description, $document_name, $file_size));
        break;

    case '3'://deleteInOut
        $in_out_id = clean($_POST['in_out_id']);
        $document_name = clean($_POST['document_name']);
        if (is_file('../../inout_photo/'.$document_name))
        {
            unlink('../../inout_photo/'.$document_name);
        }
        $output_to_send = json_encode(deleteInOut($in_out_id));
        break;

    case '4'://getInOutData
        $in_out_id = clean($_GET['in_out_id']);
        $output_to_send = json_encode(getInOutById($in_out_id)->fetch_all(MYSQLI_ASSOC));
        break;

    case '5'://getInOutAttachment
        $document_url = clean($_GET['document_url']);
        $output_to_send = base64_encode(file_get_contents('../../inout_photo/'.$document_url));
        break;

    case '6'://UpdateInOut
        $in_out_id = clean($_POST['in_out_id']);
        $date = clean($_POST['date']);
        $time_out = clean($_POST['time_out']);
        $time_in = clean($_POST['time_in']);
        $description = clean($_POST['description']);
        $filebytes = clean($_POST['filebytes']);
        $extension = clean($_POST['extension']);
        if($filebytes!='' and $extension!=''){
            $old_document = str_replace('"','',json_encode(viewInOutAttachment($in_out_id)->fetch_object()->document_name));
            if (is_file('../../inout_photo/'.$old_document))
            {
                unlink('../../inout_photo/'.$old_document);
            }
            $document_name=date('Ymd_his').'.'.$extension;
            $filepath = '../../inout_photo/'.$document_name;
            $file_size=strlen(base64_decode($filebytes));
            file_put_contents($filepath,base64_decode($filebytes));
        }
        $output_to_send = json_encode(updateInOutForm($in_out_id, $date, $description, $time_out, $time_in, $document_name, $file_size));
        break;

    case '7'://getInOutSupportList
        $staff_id = clean($_GET['staff_id']);
        $month = clean($_GET['month']);
        $year = clean($_GET['year']);
        $support = clean($_GET['support']);
        $in_out_list = getInOutSupportList($staff_id, $month, $year, $support);
        $i=0;
        $array = array();
        while($in_out = $in_out_list->fetch_assoc()){
            $in_out['support_by']==null ? : $in_out['support_by'] = getStaffName($in_out['support_by']);
            $in_out['approve_by']==null ? : $in_out['approve_by'] = getStaffName($in_out['approve_by']);
            $in_out['hr_checked_by']==null ? : $in_out['hr_checked_by'] = getStaffName($in_out['hr_checked_by']);
            $array[$i] = $in_out;
            $array[$i]['day'] = date('l', strtotime($in_out['created_at']));
            $i++;
        }
        $output_to_send =  json_encode($array);
        break;

    case '8'://supportinout
        $in_out_id = clean($_POST['in_out_id']);
        $action = clean($_POST['action']);
        $support_by = clean($_POST['support_by']);
        $output_to_send = json_encode(supportInOut($in_out_id, $action, $support_by));
        break;

    case '9'://getInOutApprovalList
        $staff_id = clean($_GET['staff_id']);
        $month = clean($_GET['month']);
        $year = clean($_GET['year']);
        $approval = clean($_GET['approval']);
        $in_out_list = getInOutApprovalList($staff_id, $month, $year, $approval);
        $i=0;
        $array = array();
        while($in_out = $in_out_list->fetch_assoc()){
            $in_out['support_by']==null ? : $in_out['support_by'] = getStaffName($in_out['support_by']);
            $in_out['approve_by']==null ? : $in_out['approve_by'] = getStaffName($in_out['approve_by']);
            $in_out['hr_checked_by']==null ? : $in_out['hr_checked_by'] = getStaffName($in_out['hr_checked_by']);
            $array[$i] = $in_out;
            $array[$i]['day'] = date('l', strtotime($in_out['created_at']));
            $i++;
        }
        $output_to_send =  json_encode($array);
        break;

    case '10'://approveinout
        $in_out_id = clean($_POST['in_out_id']);
        $action = clean($_POST['action']);
        $approve_by = clean($_POST['approve_by']);
        $output_to_send = json_encode(approveInOut($in_out_id, $action, $approve_by));
        break;


}
// Closing connection
//mysqli_close($connjson);
echo $output_to_send;
