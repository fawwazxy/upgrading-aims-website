<?php
require "../../app/model/v02_aims_medical_function.php";
require  "../send_fcm.php";
require  "../log/log.php";
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header('Content-type: application/json');

$cmd = $_GET['cmd'];
$output = '';
$output_to_send = '';
$current_file='medical.php';
$executor =$_POST['executor'];
switch ($cmd){

    case '1'://getMedicalQuota
        $staff_id = clean($_GET['staff_id']);
        $year = clean($_GET['year']);
        $quotas = getMedicalQuotaByStaffId($staff_id, $year , false);
        $i=0;
        $array = Array();
        while($quota = $quotas->fetch_assoc()){
            $pending_balance = getCountPending($quota['staff_id'], $quota['start_date'], $quota['end_date']);
            $array[$i] = $quota;
            $array[$i]['used_balance'] = strval(number_format((float)$quota['entitled_balance'] - $quota['current_balance'], 2, '.', '')) ;
            $array[$i]['pending_balance'] = $pending_balance;
            $array[$i]['available_balance'] = strval(number_format((float)$quota['current_balance'] - $pending_balance, 2, '.', '')) ;
            $i++;
        }
        $output_to_send =  json_encode($array);
        break;

    case '2'://getMedicalClaimList
        $staff_id = clean($_GET['staff_id']);
        $year = clean($_GET['year']);
        $medical_claims = getMedicalList($staff_id, $year);
        $i=0;
        $array = Array();
        while($medical_claim = $medical_claims->fetch_assoc()){
            $medical_claim['payment_closed_by']==null ? : $medical_claim['payment_closed_by'] = getStaffName($medical_claim['payment_closed_by']);
            $medical_claim['ceo_approval_by']==null ? : $medical_claim['ceo_approval_by'] = getStaffName($medical_claim['ceo_approval_by']);
            $medical_claim['cfo_approval_by']==null ? : $medical_claim['cfo_approval_by'] = getStaffName($medical_claim['cfo_approval_by']);
            $medical_claim['hr_verify_by']==null ? : $medical_claim['hr_verify_by'] = getStaffName($medical_claim['hr_verify_by']);
            $array[$i] = $medical_claim;
            $array[$i]['receipt_day'] = date('l', strtotime($medical_claim['receipt_date']));
            $i++;
        }
        $output_to_send =  json_encode($array);
        break;

    case '3'://addMedicalClaim
        $staff_id = clean($_POST['staff_id']);
        $receipt_date = clean($_POST['receipt_date']);
        $total_claim = clean($_POST['total_claim']);
        $description = clean($_POST['description']);
        $filebytes = clean($_POST['filebytes']);
        $extension = clean($_POST['extension']);
        if($filebytes!='' and $extension!=''){
            $document_name=date('Ymd_his').'.'.$extension;
            $filepath = '../../medicalphoto/'.$document_name;
            $file_size=strlen(base64_decode($filebytes));
            file_put_contents($filepath,base64_decode($filebytes));
        }
        $output_to_send = json_encode(addMedical($staff_id, $receipt_date, $description, $total_claim, $document_name, $file_size));
        break;

    case '4'://deleteMedicalClaim
        $medical_claim_id = clean($_POST['medical_claim_id']);
        $document_name = clean($_POST['document_name']);
        if (is_file('../../medicalphoto/'.$document_name))
        {
            unlink('../../medicalphoto/'.$document_name);
        }
        $output_to_send = json_encode(deleteMedical($medical_claim_id));
        break;

    case '5'://getMedicalClaimData
        $medical_claim_id = clean($_GET['medical_claim_id']);
        $output_to_send = json_encode(getMedicalById($medical_claim_id)->fetch_all(MYSQLI_ASSOC));
        break;

    case '6'://getMedicalClaimAttachment
        $document_url = clean($_GET['document_url']);
        $output_to_send = base64_encode(file_get_contents('../../medicalphoto/'.$document_url));
        break;

    case '7'://UpdateMedicalClaim
        $medical_claim_id = clean($_POST['medical_claim_id']);
        $receipt_date = clean($_POST['receipt_date']);
        $total_claim = clean($_POST['total_claim']);
        $description = clean($_POST['description']);
        $filebytes = clean($_POST['filebytes']);
        $extension = clean($_POST['extension']);
        if($filebytes!='' and $extension!=''){
            $old_document = str_replace('"','',json_encode(viewMedicalAttachment($medical_claim_id)->fetch_object()->document_name));
            if (is_file('../../medicalphoto/'.$old_document))
            {
                unlink('../../medicalphoto/'.$old_document);
            }
            $document_name=date('Ymd_his').'.'.$extension;
            $filepath = '../../medicalphoto/'.$document_name;
            $file_size=strlen(base64_decode($filebytes));
            file_put_contents($filepath,base64_decode($filebytes));
        }
        $output_to_send = json_encode(updateMedical($medical_claim_id, $receipt_date, $description, $total_claim, $document_name, $file_size));
        break;
}
// Closing connection
//mysqli_close($connjson);
echo $output_to_send;
