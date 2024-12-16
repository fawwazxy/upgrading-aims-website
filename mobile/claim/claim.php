<?php
require "../../app/model/v02_aims_others_claim_function.php";
require  "../send_fcm.php";
require  "../log/log.php";
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header('Content-type: application/json');

$cmd = $_GET['cmd'];
$output = '';
$output_to_send = '';
$current_file='claim.php';
$executor =$_POST['executor'];
switch ($cmd){

    case '1'://getCompanyList
        $companies = getCompanyDropdown('',true);
        $i=0;
        $array = array();
        while($list = $companies->fetch_assoc()){
            if($list['id']!='7'){  //bukan mset
                $array[$i] = $list;
                $i++;
            }
        }
        $output_to_send =  json_encode($array);
        break;

    case '2'://getTypeClaim
        $company_id = clean($_GET['company_id']);
        $staff_id = clean($_GET['staff_id']);
        $output_to_send = json_encode(v02getDropdownCostCentreByCompany($company_id,$staff_id)->fetch_all(MYSQLI_ASSOC));
        break;

    case '3'://addClaim
        $staff_id = clean($_POST['staff_id']);
        $datetime_departure = clean($_POST['datetime_departure']);
        $datetime_arrival = clean($_POST['datetime_arrival']);
        $job_no = clean($_POST['jobno']);
        $month_claim = clean($_POST['month_claim']);
        $description = clean($_POST['description']);
        $total_claim = clean($_POST['total_input']);
        $filebytes = clean($_POST['filebytes']);
        $extension = clean($_POST['extension']);

        $file = base64_decode($filebytes);
        if($filebytes!='' and $extension!=''){
            $document_name=date('Ymd_his')."_".'.'.$extension;
            $filepath = '../../othersclaimphoto/'.$document_name;
            $document_size=strlen(base64_decode($filebytes));
            file_put_contents($filepath,base64_decode($filebytes));
        }
        $insert_claim = v02addOthersClaim($staff_id, $datetime_departure, $datetime_arrival, $description, $job_no, $month_claim, $total_claim, $document_name, $document_size);
        $claim_details = json_decode($_POST['claim_details']);
        foreach ($claim_details as $detail){
            $result = v02addClaimCostCentre($detail->cost_centre_id, $detail->value, $insert_claim);
        }
        $finance_use = v02addFinanceClaimId($insert_claim);
        if($result!="" && $result > 0) {
            echo 'true';
        }
        //$all_parameters = 'ID: '.$leave_id.'; '.'Document Name: '.$document_name;
        //LogAccessHistory('CMD: '.$cmd, 'Executor: '.$executor, 'File Name: '.$current_file, $all_parameters);
        break;

    case '4': //getallsubmittedclaim
        $staff_id = clean($_GET['staff_id']);
        $claims = getClaimListMobile($staff_id);
        $output_to_send = json_encode($claims->fetch_all(MYSQLI_ASSOC));
        break;

    case '5': //getclaimdetails
        $id = clean($_GET['claim_id']);
        $res = v02OthersClaimById($id);
        $i=0;
        $array = array();
        while($list = $res->fetch_assoc()){
            $array[$i] = $list;
            $array[$i]['company'] = v02CompanyNameFromClaimId($list['id']);
            $array[$i]['company_id'] = v02getCompanyId(v02CompanyNameFromClaimId($list['id']));
            $array[$i]['type_claim'] = v02getTypeClaimByClaimId($id)->fetch_all(MYSQLI_ASSOC);
            $i++;
        }
        $output_to_send = substr(json_encode($array),1,-1);
        break;

    case '6': //editclaim
        $claim_id = clean($_POST['claim_id']);
        $datetime_departure = clean($_POST['datetime_departure']);
        $datetime_arrival = clean($_POST['datetime_arrival']);
        $job_no = clean($_POST['job_no']);
        $month_claim = clean($_POST['month_claim']);
        $description = clean($_POST['description']);
        $filebytes = clean($_POST['filebytes']);
        $extension = clean($_POST['extension']);
        if($filebytes!='' and $extension!=''){
            $old_document = str_replace('"','',json_encode(v02getAttachment($claim_id)));
            if (is_file('../../othersclaimphoto/'.$old_document))
            {
                unlink('../../othersclaimphoto/'.$old_document);
            }
            $document_name=date('Ymd_his')."_".'.'.$extension;
            $filepath = '../../othersclaimphoto/'.$document_name;
            $file_size=strlen(base64_decode($filebytes));
            file_put_contents($filepath,base64_decode($filebytes));
            v02updateAttachment($claim_id,$document_name,$file_size);
        }
        v02updateOthersClaim($claim_id,$job_no,$datetime_departure,$datetime_arrival,$month_claim,$description);
        v02deleteTypeClaimByClaimId($claim_id);
        v02financeUseByClaimId($claim_id);
        $claim_details = json_decode($_POST['claim_details']);
        foreach ($claim_details as $detail){
            $result = v02addClaimCostCentre($detail->cost_centre_id, $detail->value, $claim_id);
        }
        $new_total_claim = v02getNewTotal($claim_id);
        $update_total_cost = v02updateNewTotal($claim_id,$new_total_claim);
        if($result!="" && $result > 0) {
            echo 'true';
        }
        break;

    case '7'://getattachment
        $document_url = clean($_GET['document_url']);
        $output_to_send = base64_encode(file_get_contents('../../othersclaimphoto/'.$document_url));
        break;

    case '8':
        $id = clean($_POST['id']);
        $search_file = v02getDocumentName($id)->fetch_object()->document_name;
        $result =  v02DeleteClaim($id);
        $result2 = v02deleteTypeClaimByClaimId($id);
        $result3 = v02financeUseByClaimId($id);
        if($result) {
            if (is_file('../../othersclaimphoto/' . $search_file)) {
                unlink('../../othersclaimphoto/' . $search_file);
            }
            echo 'true';
        }
        break;

    case '9': //hodlist
        $staff_id = clean($_GET['staff_id']);
        $verification = clean($_GET['verification']);
        $month = clean($_GET['month']);
        $year = clean($_GET['year']);
        $claim_by_month = v02getMonthClaimListHOD($staff_id, $verification, $month, $year);
        $i=0;
        $array = array();
        while($list = $claim_by_month->fetch_assoc()){
            $array[$i] = $list;
            $array[$i]['claim_count'] = v02getClaimListByStaff($list['staff_id'], $list['month_claim'],$verification);
            $i++;
        }
        $output_to_send = json_encode($array);
        break;

    case '10'://claimdetails
        $staff_id = clean($_GET['staff_id']);
        $month_claim = clean($_GET['month_claim']);
        $verification = clean($_GET['verification']);
        $claim_list = v02getDetailStaff($staff_id, $month_claim, $verification);
        $i=0;
        $array = array();
        while($list = $claim_list->fetch_assoc()){
            $array[$i] = $list;
            $array[$i]['type_claims'] = v02getTypeClaimByClaimId($list['id'])->fetch_all(MYSQLI_ASSOC);
            $i++;
        }
        $output_to_send = json_encode($array);
        break;

    case '11'://verifyclaim
        $id_list = clean($_POST['id_list']);
        $verification_by = clean($_POST['verification_by']);
        $verification_status = clean($_POST['verification_status']);
        $executor = clean($_POST['executor']);
        $ids = json_decode($id_list);
        $id_array = "('" . implode("','", $ids) . "');";
        $result = v02OthersClaimVerify($id_array, $verification_by,$verification_status);
        $output_to_send = json_encode($result);
        break;

    case '12'://ceolist
        $department_code = clean($_GET['department_code']);
        $staff_id = clean($_GET['staff_id']);
        $verification = clean($_GET['verification']);
        $month = clean($_GET['month']);
        $year = clean($_GET['year']);
        $claim_by_month = v02getMonthClaimListCEO($department_code, $staff_id, $verification, $month, $year);
        $i=0;
        $array = array();
        while($list = $claim_by_month->fetch_assoc()){
            $array[$i] = $list;
            //$array[$i]['staff_id'] = (int) $list['staff_id'];
            $array[$i]['ceo_cc'] = v02claimListCeoVerification($list['staff_id'], $list['month_claim'], $verification);
            $i++;
        }
        $output_to_send = json_encode($array);
        break;

    case '13'://getcompanydropdown;
        $output_to_send = json_encode(getCompanyDropdown('',true)->fetch_all(MYSQLI_ASSOC));
        break;

    case '14'://getceolistdetailed;
        $staff_id = clean($_GET['staff_id']);
        $month_claim = clean($_GET['month_claim']);
        $verification = clean($_GET['verification']);
        $i=0;
        //$total_cost=0.00;
        $array = Array();
        $claim_list = v02getClaimDetailByStaffCeo($staff_id,$month_claim,$verification);
        while($claim = $claim_list->fetch_assoc()) {
            //$total_cost+=$claim['total_claim'];
            $array[$i] = $claim;
            $array[$i]['type_claims'] = v02getTypeClaimByClaimId($claim['id'])->fetch_all(MYSQLI_ASSOC);
            $array[$i]['total_claim'] = (String)$claim['total_claim'];
            $i++;
        }
        $output_to_send = json_encode($array);
        break;

    case '15'://ceoupdateclaimapproval
        $id_list = clean($_POST['id_list']);
        $verification_by = clean($_POST['verification_by']);
        $verification_status = clean($_POST['verification_status']);
        $executor = clean($_POST['executor']);
        $ids = json_decode($id_list);
        $id_array = "('" . implode("','", $ids) . "');";
        $result = v02OthersClaimApproved($id_array, $verification_by,$verification_status);
        $output_to_send = json_encode($result);
        break;
}
// Closing connection
//mysqli_close($connjson);
echo $output_to_send;