<?php
require "../../lib/db/connection.php";

function clean($str) {
    $conn=db();
    $str = @trim($str);
    if(get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }
    return mysqli_real_escape_string($conn,$str);
}

function getSys($sys_id) {
    $conn=db();
    $sql = "SELECT s.*,c.short_name FROM sys_setting s LEFT JOIN company c ON c.sys_id=s.sys_id WHERE s.sys_id='$sys_id'";
    return $conn->query($sql);
}

function getStaffInfo($staff_id){
    $conn=db();
    $sql="SELECT no_staff, name, noic, role_id, department_id, department_sub FROM staff WHERE id = '$staff_id'";
    return $conn->query($sql);
}

function getLeaveType($type, $all = false){
    $leave = [
        'al' => 'Annual Leave',
        'mc' => 'Medical Leave',
        'ul' => 'Unpaid Leave',
        'pl' => 'Paternity Leave',
        'ml' => 'Maternity Leave',
        'cfl' => 'Carry Forward Leave',
        'rl' => 'Overtime Replacement Leave',
        'cl' => 'Compassionate Leave',
        'hl' => 'Hospitalization Leave',
        'rlu' => 'Replacement Leave',
    ];

    if ($all){
        return $leave;
    }

    return $leave[$type];
}

function getDefaultLeaveBalance(){
    return [
        'al' => 0, 'mc' => 0, 'rl' => 0, 'ul' => 0, 'cfl' => 0,
        'pl' => 7, 'ml' => 98, 'cl' => 21, 'hl' => 21, 'rlu' => 21
    ];
}

function getLeaveQuotaList($quota = true){
    $all_leave_type = array_keys(getLeaveType('', true));
    $quota_leave = ['al', 'mc', 'rl', 'cfl'];
    return ($quota) ? array_intersect($all_leave_type, $quota_leave) : array_diff($all_leave_type, $quota_leave);
}

function getDropDownMonth($selected){
    $months = [
        '01' => 'Januari', '02' => 'Februari', '03' => 'Mac', '04' => 'April', '05' => 'Mei', '06' => 'Jun',
        '07' => 'Julai', '08' => 'Ogos', '09' => 'September', '10' => 'Oktober', '11' => 'November', '12' => 'Disember',
    ];

    $txt_result="<option ".(0 == $selected ? 'selected':'')." value='0'>All Month</option>";
    foreach ($months as $index => $month){
        $txt_result .= "<option ".($index == $selected ? 'selected':'')." value=\"".$index."\">".$month."</option>";
    }
    return $txt_result;
}

function getDropDownYear($selected) {
    $yearNow = date("Y");
    $year_option="<option value='0'>All Year</option>";
    for ($i=-1; $i<3; $i++){
        $year = $yearNow - $i;
        $opt_selected = ($year == $selected) ? 'selected' : '';
        $year_option.= "<option value='".$year."' ".$opt_selected.">".$year."</option>";
    }
    return $year_option;
}

function getDropdownCompany($selected){
    $conn=db();
    $sql="SELECT code_department, description FROM department WHERE code_department <> ''";
    $result = $conn->query($sql);

    $txt_result = "";
    while ($row = $result->fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
    }

    return $txt_result;
}

function getHRSeaCompany($selected){
    $conn=db();
    $sql="SELECT code_department, description FROM department WHERE code_department IN ('AGSHIMSB','MOCSB')";
    $result = $conn->query($sql);

    $txt_result = "";
    while ($row = $result->fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
    }

    return $txt_result;

}

function getDayName($index){
    $days = ["Ahad","Isnin","Selasa","Rabu","Khamis","Jumaat","Sabtu"];
    return $days[$index];
}

function getStaffName($id){
    $conn=db();
    $sql="SELECT name FROM staff WHERE id='$id'";
    return $conn->query($sql)->fetch_object()->name;
}

function getStaffDepartment($id){ //used in mobile
    $conn=db();
    $sql="SELECT department_sub FROM staff WHERE id = '$id'";
    return $conn->query($sql);
}

function getLeaveQuotaByStaffId($staff_id, $year, $type = ''){
    $where_leave_type = ($type != '') ? "AND leave_type = '$type'" : "";

    if (substr_count($year, '-') == 2){
        $where_year = "AND start_date <= '$year' AND end_date >= '$year'";
    }else{
        $where_year = ($year != '0') ? "AND (YEAR(start_date) = '$year' OR YEAR(end_date) = '$year')" : "";
    }

    $conn=db();
    $sql="SELECT * FROM v02_aims_leave_quota WHERE staff_id = '$staff_id' 
             $where_year $where_leave_type ORDER BY end_date";
    return $conn->query($sql);
}

function getCountLeave($type, $staff_id, $quota_start, $quota_end, $hr_status = null){
    $hr_status_condition = ($hr_status == null) ? "IS NULL" : "= $hr_status";
    $conn=db();
    $sql = "SELECT IFNULL(SUM(total_days),0) as used FROM v02_aims_leave
            WHERE staff_id = '$staff_id'
            AND leave_type = '$type'
            AND hr_checked_status $hr_status_condition
            AND start_date BETWEEN '$quota_start'
            AND '$quota_end'";
    return $conn->query($sql)->fetch_object()->used;
    /*
    AND ( (support_status IS NULL AND approval_status IS NULL AND hr_checked_status $hr_status_condition)
                 OR (support_status = 1 AND approval_status IS NULL AND hr_checked_status $hr_status_condition)
                 OR (support_status = 1 AND approval_status = 1 AND hr_checked_status $hr_status_condition)
                )
    */
}

function getDistinctLeave($staff_id, $year){
    $conn=db();
    $sql="SELECT DISTINCT(leave_type) as leave_type FROM v02_aims_leave WHERE staff_id = '$staff_id'
            AND (YEAR(start_date) = '$year' OR YEAR(end_date) = '$year') ORDER BY leave_type";
    $result = $conn->query($sql);
    $distinct = [];

    while ($row = $result->fetch_array(2)){
        $distinct[] = $row[0];
    }
    return $distinct;
}

function getLeaveListByYear($staff_id, $year, $leave_type = 'all'){
    $where_leave_type = ($leave_type != 'all') ? "AND leave_type = '$leave_type'" : "";
    $conn=db();
    $sql="SELECT * FROM v02_aims_leave WHERE staff_id = '$staff_id' AND (YEAR(start_date) = '$year' OR YEAR(end_date) = '$year')
            $where_leave_type ORDER BY start_date DESC";
    return $conn->query($sql);
}

function getLeaveById($id){
    $conn=db();
    $sql="SELECT l.*, s.id as staff_id, s.name, s.noic, s.no_staff, s.department_id, s.department_sub FROM v02_aims_leave l LEFT JOIN staff s ON s.id = l.staff_id WHERE l.id='$id'";
    return $conn->query($sql);
}

function viewLeaveAttachment($id){
    $conn=db();
    $sql="SELECT document_url, document_size, approval_at FROM v02_aims_leave WHERE id = '$id'";
    return $conn->query($sql);
}

function autoCountLeaveDays($no_staff, $start_date, $end_date){
    $conn=db();
    $sql="SELECT COUNT(id) as days FROM tarikh_bekerja WHERE no_staff = '$no_staff' AND status = 1 AND tarikh BETWEEN '$start_date' AND '$end_date'";
    return $conn->query($sql)->fetch_object()->days;
}

function getMaxIdLeave(){
    $conn=db();
    $sql="SELECT MAX(id) as max_id FROM v02_aims_leave";
    return $conn->query($sql)->fetch_object()->max_id;
}

function addNewLeave($staff_id, $start_date, $end_date, $leave_type, $total_days, $description, $document_name, $file_size){
    //set staff who will get auto support
    $auto_support = [
        '660512115105', //EC - Aminuddin Mat Yusof
        '751206035485', //CEO - Tarmizi Mejam
        '750915115141', //CFO - Sharul Nazri
        '740915115003', //Khairul Aznam
        '900820115000', //Fatin Izzati
        '890102115325', //Khairani Kamaruddin (AMASB)
        '000829110288'  //Anis Zahirah (Intern AMASB)
    ];

    $conn=db();
    $staff_info = getStaffInfo($staff_id)->fetch_assoc();
    $ic_number = $staff_info['noic'];

    $sql="INSERT INTO v02_aims_leave (staff_id, start_date, end_date, leave_type, total_days, description, document_url, document_size, created_at, updated_at) 
            VALUES ('$staff_id', '$start_date', '$end_date', '$leave_type', '$total_days', '$description', '$document_name', '$file_size', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)";
    $result = $conn->query($sql);

    if ($result == true){
        if (in_array($ic_number, $auto_support)){
            $sql_auto_support = "UPDATE v02_aims_leave SET support_by = '0', support_at = CURRENT_TIMESTAMP, support_status = '1' WHERE id = '$conn->insert_id'";
            return $conn->query($sql_auto_support);
        }
        return true;
    }
    return false;
}

function insertLeaveQuota($staff_id, $leave_type, $entitled_balance, $current_balance, $start_date, $end_date, $created_by){
    $conn=db();
    $sql="INSERT INTO v02_aims_leave_quota (staff_id, leave_type, entitled_balance, current_balance, start_date, end_date, created_at, created_by, updated_at, updated_by)
            VALUES ('$staff_id', '$leave_type', '$entitled_balance', '$current_balance', '$start_date', '$end_date', CURRENT_TIMESTAMP, '$created_by', CURRENT_TIMESTAMP, '$created_by')";
    return $conn->query($sql);
}

function updateLeaveQuota($quota_id,$leave_type,$entitled_balance,$current_balance,$start_date,$end_date,$updated_by){
    $conn=db();
    $sql="UPDATE v02_aims_leave_quota SET leave_type = '$leave_type', entitled_balance = '$entitled_balance', current_balance = '$current_balance',
            start_date = '$start_date', end_date = '$end_date', updated_by = '$updated_by', updated_at = CURRENT_TIMESTAMP WHERE id = '$quota_id'";
    return $conn->query($sql);
}

function deleteLeaveQuota($id){
    $conn=db();
    $sql="DELETE FROM v02_aims_leave_quota WHERE id = '$id'";
    return $conn->query($sql);
}

function getLeaveQuotaById($id){
    $conn=db();
    $sql="SELECT * FROM v02_aims_leave_quota WHERE id = '$id'";
    return $conn->query($sql);
}

function updateLeave($id, $start_date, $end_date, $leave_type, $total_days, $description, $document_name, $file_size){
    $conn=db();
    $update_document = ($document_name != "") ? ", document_url = '$document_name', document_size = '$file_size'" : "";
    $sql = "UPDATE v02_aims_leave SET start_date = '$start_date', end_date = '$end_date', leave_type = '$leave_type', total_days = '$total_days',
                description = '$description' $update_document WHERE id = '$id'";
    return $conn->query($sql);
}

function deleteLeave($id){
    $conn=db();
    $sql="DELETE FROM v02_aims_leave WHERE id='$id'";
    return $conn->query($sql);
}

function updateLeaveAttachment($id,$document_name,$document_size){
    $conn=db();
    $sql="UPDATE v02_aims_leave SET document_url='$document_name', document_size='$document_size' WHERE id='$id'";
    return $conn->query($sql);
}

function getLeaveSupportList($staff_id, $month, $year, $support){
    $where_month = ($month == 0) ? "" : "AND MONTH(lv.start_date) = '$month'";
    $where_year = ($year == 'all') ? "" : "AND YEAR(lv.start_date) = '$year'";

    if ($support == 'NULL'){
        $where_support_status = "AND lv.support_status IS NULL"; //pending
    }else if ($support == 'YES'){
        $where_support_status = "AND lv.support_status = 1"; //supported
    }else{
        $where_support_status = "AND lv.support_status <> 1"; //rejected
    }

    $conn=db();
    $staff = getStaffInfo($staff_id)->fetch_assoc();
    $ic_number = $staff['noic'];
    $role = $staff['role_id'];
    $department_id = $staff['department_id'];
    $department_sub = $staff['department_sub']; //used in if-else condition
    $department_sub_filter = "'$department_sub'"; //used in query (variable may be override in if-else statement)

    //Set list of department that will not use default rules `all staff in same department`
    $contrary_from_default_rules = ['MANAGEMENT','OPERATION-AGMHESB','HR', 'HR-SEA', 'ECOFFICE', 'FINACC','OPERATION-AGMSB', 'CORPADMIN-AVSB',
        'HR-AGMA', 'OPERATION-BUNKER', 'QR&D', 'TECHOPERATION', 'MOORING-GANG', 'TECHNICAL-AVSB', 'COMMERCIAL','OPERATION-AVSB', 'OPERATIONFAC-AVSB',
        'CATERING', 'OPERATION-TKSB', 'OPERATIONFOOD-AVSB'];
    //set an 'always false' condition for all non-involved staff
    $custom_condition = "AND lv.total_days < 0.0";

    if($ic_number == '751206035485'){
        $custom_condition = "AND s.noic = '810415035497'";
        $department_sub_filter = "'MARKETING&BUSINESS-DEV'";

    }else if($role == 'MANAGER' && $department_sub != 'COMMERCIAL'){
        if($department_id == 'AGESB'){ //Khairul Aznam support MAWARIANI (OPERATION-AGMHESB)
            $custom_condition = "AND s.noic = '740505115019'";
            $department_sub_filter = "'OPERATION-AGMHESB'";

        }else if($department_id == 'AVSB'){ //Rosliha support EXECUTIVE-DIRECTOR, CONTRACT TECHASSISTANT (Farhan Aizaq) & NURIN SHARIF (INTERN AVSB) & NURIN ATHIRAH (INTERN QR&D)
            $custom_condition = "AND s.role_id IN ('EXECUTIVE-DIRECTOR','CONTRACT') OR (s.noic IN ('030330110462', '020618110315') AND s.role_id IN ('INTERN', 'CONTRACT') $where_support_status)";
            /*$custom_condition = "AND s.role_id IN ('EXECUTIVE-DIRECTOR','CONTRACT')";*/
            $department_sub_filter = "'MANAGEMENT'";
        }

    }else if($role == 'EXECUTIVE-DIRECTOR') { ///Syafiq Sahamudin support rosliha (MANAGER AVSB)
        $custom_condition = "AND s.role_id = 'MANAGER' AND s.department_id = 'AVSB'";

    }else if($department_id == 'AGSHIMSB'){
        if($ic_number == '891013115109') { //Sharimiza support techoperation AGSHIMSB
            $custom_condition = "AND s.department_sub = 'TECHOPERATION' AND s.department_id = '$department_id'";

        }else if($ic_number == '840324115149'){ //Shaifuddin support Sharimiza techoperation AGSHIMSB
            $custom_condition = "AND s.noic = '891013115109'";
        }

    }else if($department_id == 'KTSSB'){
        if ($role == 'ASSISTANT-MANAGER'){
            $custom_condition = "AND s.department_id = '$department_id'";
            $department_sub_filter = "'ELECTRICAL KTSKILL', 'AIRCOND KTSKILL', 'ADMINFIN-KTSKILL', 'MACHINERY KTSKILL', 'HEP KTSKILL'";
        }else{
            $custom_condition = "AND s.department_id = '$department_id' AND s.role_id IN ('ASSISTANT-MANAGER', 'DIRECTOR')";
            $department_sub_filter = "'MANAGEMENT'";
        }

    }
   /* else if(in_array($ic_number, ['941107115698', '900708115203'])){ //Asyikin / Junaidi will support HOC tkitchen
        $sub_custom_condition = "";

        if ($ic_number == '941107115698'){ //Asyikin
            $sub_custom_condition = "OR s.noic = '900708115203'";
            $department_sub_filter .= ", 'OPERATION-TKSB'";
        }
        $custom_condition = "AND ((s.role_id = 'HOC' AND s.department_id = 'TKSB') $sub_custom_condition OR
                                (s.department_sub = '$department_sub' AND s.department_id = '$department_id'))";
        $department_sub_filter .= ", 'MANAGEMENT'";
    }*/

    else if(in_array($ic_number, ['941107115698', '900708115203','960702115565','940921115225', '000306110094', '940910036089', '950121115437'])){

        if(in_array($ic_number, ['941107115698', '900708115203'])){ /*Asyikin / Junaidi support HOC tksb & operation-tksb*/

            if ($ic_number == '941107115698'){ //Asyikin
                $department_sub_filter .= ", 'OPERATION-TKSB'";
            }

            $custom_condition = "AND ((s.role_id = 'HOC' AND s.department_id = 'TKSB') OR
                                (s.department_sub = '$department_sub' AND s.department_id = '$department_id') AND s.noic NOT IN ('900708115203','940910036089','860105465147', '950121115437'))";
            $department_sub_filter .= ", 'MANAGEMENT'";

        }

        if (in_array($ic_number, ['960702115565', '940921115225'])){ /*mahyuddin / al-amin support junaidi*/
            $custom_condition = "AND s.noic = '900708115203'";
        }

        if ($ic_number == '000306110094'){ //mardhiyati support shafeeq & fatah
            $custom_condition = "AND s.noic IN ('940910036089', '950121115437')";
        }


    }else if($department_sub == 'CATERING'){
        $custom_condition = "AND s.department_sub = '$department_sub'";


    }else if($department_sub == 'OPERATION-AVSB'){
        if ($ic_number == '980123115235'){ //farizuwan support OPERATIONFAC-AVSB (boys only)
            $custom_condition = "AND (s.noic IN ('000207110697', '000923110823', '910603115505', '001220110629', '040213110542', '041019110519',
                                            '001218110267', '001012110763', '990905115335') $where_support_status)";
            $department_sub_filter .= ", 'OPERATIONFAC-AVSB'";

        }else if($ic_number == '850102115257'){ //fadzli support farizuwan, tengku farezwan & nik mohd syafiq (OPERATION-AVSB)
            $custom_condition = "AND (s.noic IN ('980123115235', '930331115103','890224115315') $where_support_status)";

        }else if($ic_number == '930331115103'){ //tengku farezwan support wahyu(intern)
            $custom_condition = "AND s.noic = '031112110151'";

        }else if($ic_number == '890224115315'){ //nik mohd syafiq support fadzli (OPERATION-AVSB)
            $custom_condition = "AND s.noic = '850102115257'";

        }else if($role != 'INTERN'){
            $custom_condition = "AND s.role_id != 'INTERN' AND s.noic NOT IN ('980123115235', '930331115103', '850102115257')";
        }

    }else if(in_array($department_sub, ['HR', 'HR-SEA'])){
        if($ic_number == '960805465058' || $department_sub == 'HR-SEA' || $role == 'HOD'){ //Syafiah support staff HR. staff support each other (temp)
            $custom_condition = "AND s.department_id != 'AVSB'"; //support OPERATION-AGMSB

            if ($role == 'HOD'){ //HOD HR support EC Office & HR-AVSB and HR-TKSB staff
                $department_sub_filter = "'ECOFFICE'";
                $custom_condition = " OR (s.department_id IN ('AVSB','TKSB') AND s.department_sub = 'HR' $where_support_status)";
            }
//            else if ($ic_number == '960805465058'){ //Syafiah support OPERATION-AGMSB (temp)
//                $custom_condition = "OR (s.department_sub = 'OPERATION-AGMSB' $where_support_status)";
//            }

        }else if($department_sub == 'HR'){ //HR staff support Syafiah
            $custom_condition = "AND s.noic = '960805465058'";

            if($ic_number == '911011115100'){ //Noraida support Syafiah, Shahira Samin
                $custom_condition = "AND s.noic IN ('960805465058','930128016820')";
                $department_sub_filter .= ", 'SECRETARY-AVSB'";

            }else if ($ic_number == '990909115236'){ //Azmiza support OPERATION-AGMSB (temp)
                $custom_condition = "AND (s.department_sub = 'OPERATION-AGMSB' OR s.noic = '960805465058' $where_support_status)";
                $department_sub_filter .= ", 'OPERATION-AGMSB'";

            }else if ($ic_number == '830406115186') { //Azimah support Alia Maisarah (Intern)
                $custom_condition = "AND s.noic = '041003020076'";

            }
        }

    }else if($department_sub == 'FINACC'){ //HOD FINACC will support FINACC staff && OPERATION-TKSB ibrahim
        $custom_condition = "OR (s.noic = '860105465147' AND s.department_sub = 'OPERATION-TKSB' $where_support_status)";

        if($ic_number == '811120115195'){
            $custom_condition = "AND s.role_id = 'INTERN' AND department_sub = 'FINACC' AND department_id = 'TKSB'";

        }else if ($role != 'HOD'){
            $custom_condition = "AND s.role_id = 'HOD'"; //FINACC staff will support HOD

        }

    }else if($department_sub == 'OPERATION-AGMHESB' && $role != 'HOD'){
        if ($ic_number == '940119115412'){
            $custom_condition = ""; //Fatin Nadiah support OPERATION-AGMHESB staff & HOD

        }else if ($ic_number == '970227115150'){
            $custom_condition = "AND s.noic = '940119115412'"; //Alissa will support only Fatin
        }

    }else if($department_sub == 'HR-AGMA'){
            $custom_condition = "";
            $department_sub_filter = "'HR-AGMA'"; //remove OPERATION-AGMSB

    }else if($department_sub == 'OPERATION-BUNKER'){
        if ($ic_number == '910619115673'){ //Fazrol bunker
            $custom_condition = "";
        }else{
            $custom_condition = "AND s.noic = '910619115673'";
        }

    }else if($department_sub == 'QR&D'){ // QR&D for AVSB & TKSB
        $custom_condition = "AND (s.department_sub = '$department_sub' OR s.noic = '020325110688')";
        $department_sub_filter .= ", 'OPERATIONFOOD-AVSB'";

        //OPERATIONFAC-AVSB (girls only)
        $avsb_condition = "'860919465154', '850609115280', '750617115426', '790917115408', '040213110542', '890804115450', '950818115648', '990612115630', '960418115648', '960828115456'";

        if ($role != 'INTERN'){
            $custom_condition = "AND s.department_id = '$department_id'";

        }else if ($ic_number == '940417115584'){ //shafiqah support OPERATIONFAC-AVSB (girls only)
            $custom_condition = "AND s.department_id = '$department_id' OR (s.noic IN ($avsb_condition) $where_support_status)";

        }

    }else if($department_sub == 'TECHOPERATION' && $role != 'HOD') {
        if ($ic_number == '921030115797') { //Qomaruzzaman support all mooring-gang & techoperation MOCSB
            $custom_condition = "AND s.department_id IN ('$department_id','MOCSB') OR (s.department_sub IN ('MOORING-GANG','PILOT-BOAT') $where_support_status)";

        }else if ($ic_number == '960215115701'){ //Syahril huzairi support technical-avsb
            $custom_condition = "AND s.department_id = '$department_id' OR (s.department_sub = 'TECHNICAL-AVSB' $where_support_status)";

        }else if ($ic_number == '840302115535') { //Wan zulkifl support techoperation agesb
            $custom_condition = "AND s.department_id = '$department_id'";

        }else if($department_id == 'AGESB'){ //staff support firdaus nasir - TECHASSISTANT
            $custom_condition = "AND s.department_id = '$department_id' OR (s.noic = '940409115285' $where_support_status)";
        }

    }else if($department_sub == 'TECHASSISTANT') { //support same company
        $custom_condition = "AND s.department_id = '$department_id'";
        if($ic_number == '020618110315'){ //farhan aizaq support haflan(intern)
            $custom_condition = "AND (s.noic = '010605101939' $where_support_status)";
            $department_sub_filter .= ", 'TECHNICAL-AVSB'";
        }

    }else if($department_sub == 'COMMERCIAL' && $role != 'HOD'){ //DEPARTMENT PALING MENGADA HAHAHAHAHA
        $ccd_array = commercialDepartmentSupportRules();
        $intern_condition = ($ic_number == '890506145555') ? "OR s.role_id = 'INTERN'" : ""; //Aidil support all interns

        $not_in = "(".implode(',', $ccd_array).")";

        if (array_key_exists($ic_number, $ccd_array)){
            $department_sub_filter = "'COMMERCIAL', 'COMMERCIAL-AVSB'";
            $custom_condition = "AND (s.noic IN (".$ccd_array[$ic_number].") $intern_condition)";
        }else{ //all except 6 staff in stated array support HOD
            $custom_condition = "AND s.noic NOT IN $not_in AND s.role_id <> 'INTERN'";
        }

    }else if($role == 'HOD'){
        if($department_sub == 'CORPADMIN'){ //Azlini
            $custom_condition = "AND s.department_id IN ('TKSB', 'AVSB')";
            $department_sub_filter .= ", 'CORPADMIN', 'CORPADMIN-AVSB'";
        }else if($department_sub == 'HSSE'){ //Zaily Zaki
            $custom_condition = "AND s.department_sub = 'HSSE' AND s.department_id = 'AVSB'";
        }

    }else if(!in_array($department_sub, $contrary_from_default_rules) && !in_array($role, ['HOD', 'OPERATIONMANAGER'])){ // [$department_sub] staff (except HOD) support each other (including HOD)
        $custom_condition = "";
    }

    $sql="SELECT lv.*, s.name, s.department_id, s.department_sub FROM v02_aims_leave lv LEFT JOIN staff s ON s.id = lv.staff_id
            WHERE lv.staff_id <> '$staff_id'
            $where_support_status $where_month $where_year
            AND s.department_sub IN ($department_sub_filter) $custom_condition
            ORDER BY lv.created_at DESC";
    return $conn->query($sql);
}

function getCurrentBalanceFromLeaveId($id){
    $conn=db();
    $leave_info = $conn->query("SELECT staff_id, leave_type, start_date FROM v02_aims_leave WHERE id = '$id'")->fetch_assoc();
    $current_balance_sql = "SELECT current_balance FROM v02_aims_leave_quota WHERE staff_id = '".$leave_info['staff_id']."' AND leave_type = '".$leave_info['leave_type']."'
                            AND (start_date <= '".$leave_info['start_date']."'  AND end_date >= '".$leave_info['start_date']."') LIMIT 1";
    return $conn->query($current_balance_sql)->fetch_object()->current_balance;
}

function supportLeave($id, $action, $support_by){
    $conn=db();
//    $set_balance = ($action == '0') ? ", balance_after_checked = '".getCurrentBalanceFromLeaveId($id)."'" : ""; //if not supported, set the current balance as balance_after_checked
    $set_balance = "";

    $sql="UPDATE v02_aims_leave SET support_at = CURRENT_TIMESTAMP, support_by = '$support_by', support_status = '$action' $set_balance WHERE id = '$id'";
    return $conn->query($sql);
}

function getLeaveApprovalList($staff_id, $month, $year, $approval){
    $where_month = ($month == 0) ? "" : "AND MONTH(lv.start_date) = '$month'";
    $where_year = ($year == 'all') ? "" : "AND YEAR(lv.start_date) = '$year'";

    if ($approval == 'NULL'){
        $where_approval_status = "AND lv.approval_status IS NULL"; //pending
    }else if ($approval == 'YES'){
        $where_approval_status = "AND lv.approval_status = 1"; //supported
    }else{
        $where_approval_status = "AND lv.approval_status <> 1"; //rejected
    }

    $conn=db();
    $ic_number = getStaffInfo($staff_id)->fetch_object()->noic;

    $sql="SELECT lv.*, s.name, s.department_id, s.department_sub FROM v02_aims_leave lv LEFT JOIN staff s ON s.id = lv.staff_id
            WHERE lv.staff_id <> '$staff_id' AND (support_status IS NULL OR support_status = '1')
                $where_approval_status $where_month $where_year
                AND s.leave_approval = '$ic_number' ORDER BY lv.created_at DESC";
    return $conn->query($sql);
}

function approveLeave($id, $action, $approve_by){
    $conn=db();
//    $set_balance = ($action == '0') ? ", balance_after_checked = '".getCurrentBalanceFromLeaveId($id)."'" : ""; //if not approved, set the current balance as balance_after_checked
    $set_balance = "";

    $sql="UPDATE v02_aims_leave SET approval_at = CURRENT_TIMESTAMP, approval_by = '$approve_by', approval_status = '$action' $set_balance WHERE id = '$id'";
    return $conn->query($sql);
}

function leaveMultipleApproval($leave_id, $action, $approval_by){
    $conn=db();
    $sql="UPDATE v02_aims_leave SET approval_at = CURRENT_TIMESTAMP, approval_by = '$approval_by', approval_status = '$action' WHERE id IN $leave_id";
    return $conn->query($sql);
}

function getLeaveCheckList($staff_id, $hr_check, $leave_type, $company, $month, $year){
    $where_month = ($month == 0) ? "" : "AND MONTH(lv.start_date) = '$month'";
    $where_year = ($year == 0) ? "" : "AND YEAR(lv.start_date) = '$year'";
    $where_loa = ($hr_check == 'NULL') ? "" : "AND lv.support_status = '1' AND lv.approval_status = '1'";

    if ($hr_check == 'NULL'){
        $where_checked_status = "AND lv.hr_checked_status IS NULL"; //pending
    }else if ($hr_check == 'YES'){
        $where_checked_status = "AND lv.hr_checked_status = 1"; //supported
    }else{
        $where_checked_status = "AND lv.hr_checked_status <> 1"; //rejected
    }

    $conn=db();
    $sql="SELECT lv.*, s.name, s.department_id, s.department_sub FROM v02_aims_leave lv LEFT JOIN staff s ON s.id = lv.staff_id
            WHERE lv.staff_id <> '$staff_id' $where_loa $where_checked_status $where_month $where_year
            AND lv.leave_type = '$leave_type' AND s.department_id = '$company'
            ORDER BY lv.start_date DESC";
    return $conn->query($sql);
}

function hrCheckLeave($id, $action, $checked_by, $current_balance){
    $current_balance_field = ($current_balance == null) ? "= NULL" : "= '$current_balance'";
    $conn=db();
    $sql="UPDATE v02_aims_leave SET hr_checked_at = CURRENT_TIMESTAMP, hr_checked_by = '$checked_by', hr_checked_status = '$action',
            balance_after_checked $current_balance_field WHERE id = '$id'";
    return $conn->query($sql);
}

function subtractLeaveQuota($staff_id, $leave_type, $start_date, $current_balance){
    $conn=db();
    $sql="UPDATE v02_aims_leave_quota SET current_balance = '$current_balance' WHERE staff_id = '$staff_id' AND leave_type = '$leave_type'
                            AND (start_date <= '$start_date'  AND end_date >= '$start_date')";
    return $conn->query($sql);
}

function updateRemark($id, $remark){
    $conn=db();
    $sql="UPDATE v02_aims_leave SET remark = '$remark' WHERE id = '$id'";
    return $conn->query($sql);
}

function getTokenLeaveApproval($staff_id){
    $conn=db();
    $sql="SELECT p.token FROM staff s 
          LEFT JOIN staff a
          ON s.leave_approval=a.noic
          LEFT JOIN push_notification_token p
          ON p.staff_id=a.id
          WHERE s.id='$staff_id'";
    return $conn->query($sql)->fetch_object()->token;
}