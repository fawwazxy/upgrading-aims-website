<?php
require "v02_support_rules.php";
/* ------ OVERTIME NOTIFICATION ------- */
//OT Permission Approval
function v02notifyOtPermission($approval_id){
    $conn=db();

    $sql = "SELECT COUNT(id) as otp_count FROM v02_aims_ot_permission
            WHERE approval_id = '$approval_id' 
            AND approval_at IS NULL
            ORDER BY created_at DESC";
    return $conn->query($sql)->fetch_object()->otp_count;
}

//Unclaimed OT (Approved OT Permission) - Staff
function v02notifyUnclaimedOt($applicant_id){
    $conn=db();
    $sql = "SELECT COUNT(id) as unclaim_ot FROM v02_aims_ot_permission
            WHERE applicant_id = '$applicant_id'
            AND approval_at IS NOT NULL AND approval_status = 1
            AND approval_id <> 'auto' AND claim_status = 0";
    return $conn->query($sql)->fetch_object()->unclaim_ot;
}

//OT Claim Verification - HOD
function v02notifyOtForHod($department_sub, $approval_id) {
    $conn=db();
    //get role id for current logged in user
    $role_id=$conn->query("SELECT role_id FROM staff WHERE id='$approval_id'")->fetch_object()->role_id;

    if($role_id == 'CFO'){ //CFO account
        $custom_condition = "AND s.department_sub = 'FINACC'";
    }else if($role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB'){
        $custom_condition = "AND (s.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER') OR otp.approval_id = '$approval_id')";
    }else{
        $custom_condition = "AND otp.approval_id = '$approval_id' AND (s.department_sub NOT IN ('FINACC','OPERATION-AGMSB', 'HR-AGMA', 'OPERATION-BUNKER') OR
                                (s.department_sub ='FINACC' AND s.department_id = 'AVSB') )";
    }

    //Final Query Verify Notification
    $sql="SELECT otm.id
            FROM v02_aims_ot ot LEFT JOIN v02_aims_ot_date otd ON otd.id = ot.ot_date_id
            LEFT JOIN v02_aims_ot_month_session otm ON otm.id = otd.month_session_id
            LEFT JOIN v02_aims_ot_permission otp ON otp.id = ot.ot_permission_id
            LEFT JOIN staff s ON s.id = otm.staff_id
            WHERE otm.staff_id <> '$approval_id' AND verify_status IS NULL  
            $custom_condition
            GROUP BY otm.id";
    $result = $conn->query($sql);

    $i=0;
    while ($row = $result->fetch_assoc()){
        $count_data = "SELECT count(ot.id) as count_row FROM v02_aims_ot ot LEFT JOIN v02_aims_ot_date otd ON otd.id = ot.ot_date_id
            WHERE otd.month_session_id = '".$row['id']."' AND ot.verify_by IS NULL AND ot.verify_status IS NULL";
        $count_row = $conn->query($count_data)->fetch_object()->count_row;
        if ($count_row>0){
            $i++;
        }
    }

    return $i;
}

//OT Claim approval - CEO
function v02notifyOtForCeo($approval_id) {
    $conn=db();

    //set custom condition for logged in user
    if ($approval_id == '13'){ //if CEO account
        $custom_condition = "AND s.role_id NOT IN ('HOD','MANAGER','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR')";
    }else if($approval_id == '12'){ // if chairman account
        $custom_condition = "AND (s.role_id IN ('HOD','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR','MANAGER') OR s.noic = '980401115412')"; //PA baru haji, nazifah
    }else{
        $custom_condition = "";
    }
    //Final Query Monthly Listing
    $sql = "SELECT otm.id FROM v02_aims_ot ot LEFT JOIN v02_aims_ot_date otd ON otd.id = ot.ot_date_id
            LEFT JOIN v02_aims_ot_month_session otm ON otm.id = otd.month_session_id
            LEFT JOIN staff s ON s.id = otm.staff_id
            WHERE otm.staff_id <> '$approval_id' AND otm.month_session LIKE '%2023%'
			AND verify_by IS NOT NULL AND verify_status = '1'
            AND review_by IS NOT NULL AND review_status = '1'
			AND (ot.approved_by IS NULL AND ot.approved_status IS NULL) $custom_condition
			GROUP BY otm.id";
    $result = $conn->query($sql);

    $i=0;
    while ($row = $result->fetch_assoc()){
        $count_data = "SELECT count(ot.id) as count_row FROM v02_aims_ot ot LEFT JOIN v02_aims_ot_date otd ON otd.id = ot.ot_date_id
            WHERE otd.month_session_id = '".$row['id']."'
            AND verify_by IS NOT NULL AND verify_status = '1'
            AND review_by IS NOT NULL AND review_status = '1'
            AND (approved_by IS NULL AND approved_status IS NULL)";
        $count_row = $conn->query($count_data)->fetch_object()->count_row;
        if ($count_row>0){
            $i++;
        }
    }
    return $i;
}

/* ------ LEAVE NOTIFICATION VERSION 1 ------- */
//Leave Support
function notifyLeaveSupport($ic_number){
    $conn=db();
    $custom_condition = "";

    $staff = $conn->query("SELECT role_id, department_sub FROM staff
                WHERE noic = '$ic_number' AND status = 'BEKERJA'")->fetch_assoc();
    $role_id = $staff['role_id'];
    $department_sub = $staff['department_sub']; //department

    if ($role_id == 'FOUNDER'){
        if($ic_number == '751206035485'){ /* Chief Executive Officer */
            $custom_condition = "AND s.noic = '810415035497'"; // Alias Zakaria
        }else{
            return 0;
        }
    }else if($role_id == 'MANAGING-DIRECTOR'){ /* Fudhlanah AVSB */
        $custom_condition = "AND s.role_id IN ('EXECUTIVE-DIRECTOR','HOC','OPERATIONMANAGER')"; //Syafiq Sahamuddin, Nurul Akmal, Rosliha

    }else if($role_id == 'EXECUTIVE-DIRECTOR') { /* Syafiq Sahamuddin AVSB */
        $custom_condition = "AND s.role_id = 'MANAGING-DIRECTOR'"; //Fudhlanah

    }else if($role_id == 'EXECUTIVEAVSB' || $ic_number == '960221115249') { /* both EXECUTIVEAVSB has resigned, Syafiq Hisyamuddin (960221115249) take the responsibility */
        $custom_condition = "AND s.department_sub IN ('OPERATIONFAC-AVSB', 'OPERATION-AVSB')
                                AND s.role_id NOT IN ('OPERATIONMANAGER', 'EXECUTIVEAVSB', 
                                'EXECUTIVETKSB', 'SUPERVISORTKSB' ,'EXECUTIVE-DIRECTOR', 'MANAGING-DIRECTOR')";

    }else if($role_id == 'SUPERVISORAVSB') { /* Aziz Mat Amin (SUPERVISOR AVSB) */
        $custom_condition = "AND s.role_id = 'EXECUTIVEAVSB'";

    }else if($role_id == 'EXECUTIVETKSB') { /* Junaidi Jaafar (Executive TKSB) */
        $custom_condition = "AND s.department_sub = 'OPERATION-TKSB'";

    }else if($role_id == 'SUPERVISORTKSB') { /* Mahyuddin (SUPERVISOR TKSB) */
        $custom_condition = "AND s.role_id = 'EXECUTIVETKSB'";

    }else if($ic_number == '940331025617'){ /* Nazri AGESB */
        $custom_condition = "AND s.department_sub IN ('TECHOPERATION','PILOT-BOAT','MOORING-GANG')";

    }else if($ic_number == '960215115701'){ /* Lut AGESB */
        $custom_condition = "AND s.department_sub IN ('TECHNICAL-AVSB')";

    }else if($ic_number == '911011115100'){ /* Noraida AVSB (HR AVSB) */
        $custom_condition = "AND s.department_sub IN ('HR','SECRETARY-AVSB')";

    }else if($department_sub == 'HR-AGMA'){ /* Currently on 2022-10-01 -> 3 person */
        $custom_condition = "AND s.department_sub IN ('HR-AGMA','OPERATION-AGMSB')";

    }else if(in_array($department_sub, ['OPERATION-AVSB','OPERATIONFAC-AVSB'])){ /* Currently on 2022-10-01 -> 3 person */
        $custom_condition = "AND s.noic IN ('960221115249')";

    }else if(in_array($department_sub, ['FINACC','OPERATION-AGMHESB'])){ /* Finacc staff support hod */
        if ($role_id == 'HOD'){
            $custom_condition = "AND s.department_sub='$department_sub' AND s.role_id <> 'HOD'";
        }else if($role_id != 'INTERN'){
            $custom_condition = "AND s.department_sub='$department_sub' AND s.role_id = 'HOD'";
        }

    }else if($role_id == 'HOD' && $department_sub == 'HR'){
        $custom_condition = "AND s.department_sub IN ('ECOFFICE', 'HR')";

    }else if(!in_array($role_id, ['INTERN', 'MANAGER']) && !in_array($ic_number, ['940331025617', '911011115100', '960221115249'])
        && !in_array($department_sub, ['MANAGEMENT', 'FINACC', 'OPERATION-AGMSB', 'MOORING-GANG','PILOT-BOAT'])){
        $custom_condition = "AND s.department_sub='$department_sub' AND s.leave_approval <> '$ic_number'";
    }else{
        return 0;
    }

    $sql = "SELECT COUNT(a.id) AS leave_support, b.support, s.department_sub FROM aims_lv_form a
            LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
            LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
            LEFT JOIN staff s ON s.noic = sr.no_staff
            WHERE b.support = 'IN PROGRESS'
            AND s.status = 'BEKERJA' AND s.noic <> '$ic_number'
            $custom_condition";
    return $conn->query($sql)->fetch_object()->leave_support;
}

//Leave Verification
function notifyLeaveApproval($ic_number){
    $conn=db();

    $staff = $conn->query("SELECT role_id, department_sub FROM staff
                WHERE noic = '$ic_number' AND status = 'BEKERJA'")->fetch_assoc();
    $role_id = $staff['role_id'];
    $department_sub = $staff['department_sub'];

    $custom_condition = "AND s.leave_approval='$ic_number'";
    $no_support = "";
    if ($role_id == "HOD"){
        if ($department_sub == "OPERATION-AGMSB"){
            $custom_condition = "AND s.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')";
        }else if($department_sub == "COMMERCIAL"){
            $custom_condition = "AND s.department_sub IN ('COMMERCIAL', 'COMMERCIAL-AVSB')";
        }else if($department_sub == "TECHOPERATION"){
            $custom_condition = "AND s.department_sub IN ('TECHOPERATION', 'PILOT-BOAT','MOORING-GANG')";
        }else if($department_sub == 'HR'){
            $custom_condition = "AND s.department_sub IN ('HR-SEA','HR')";
        }else if(!in_array($department_sub, ['OPERATION-AGMSB', 'COMMERCIAL', 'TECHOPERATION', 'HR', 'FINACC', 'OPERATION-AGMHESB'])){
            $custom_condition = "AND s.department_sub = '$department_sub'";
        }else{
            return 0;
        }
    }else if ($department_sub == 'HR'){
        $custom_condition = "";
        $no_support = "OR b.support = 'TIADA'";
    }

    $sql="SELECT COUNT(a.id) AS leave_approval, b.approvement,s.department_sub FROM aims_lv_form a
            LEFT JOIN approve_holiday b ON a.id = b.staff_holiday_id
            LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
            LEFT JOIN staff s ON s.noic = sr.no_staff
            WHERE s.noic <> '$ic_number'
            AND s.status = 'BEKERJA'
            AND (b.support= 'APPROVE' $no_support)
            AND b.approvement= 'IN PROGRESS'
            $custom_condition";

    return $conn->query($sql)->fetch_object()->leave_approval;
}

/* ------ LEAVE NOTIFICATION VERSION 2 ------- */
//Leave Support Version 2
function v02notifyLeaveSupport($staff_id, $ic_number, $role, $department_id, $department_sub){
    $conn=db();
    $department_sub_filter = "'$department_sub'"; //used in query (variable may be override in if-else statement)

    //Set list of department that use custom rules as stated in if-else statement
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
            $custom_condition = "AND s.role_id IN ('EXECUTIVE-DIRECTOR','CONTRACT') OR (s.noic IN ('030330110462', '020618110315') AND s.role_id IN ('INTERN', 'CONTRACT') AND lv.support_status IS NULL)";
            $department_sub_filter = "'MANAGEMENT'";
        }

    }else if($role == 'EXECUTIVE-DIRECTOR'){ //Syafiq Sahamudin support rosliha (MANAGER AVSB)
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
                                            '001218110267', '001012110763', '990905115335') AND lv.support_status IS NULL)";
            $department_sub_filter .= ", 'OPERATIONFAC-AVSB'";

        }else if($ic_number == '850102115257'){ //fadzli support farizuwan, tengku farezwan & nik mohd syafiq (OPERATION-AVSB)
            $custom_condition = "AND (s.noic IN ('980123115235', '930331115103','890224115315') AND lv.support_status IS NULL)";

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
                $custom_condition = " OR (s.department_id IN ('AVSB','TKSB') AND s.department_sub = 'HR' AND lv.support_status IS NULL)";
            }
//            else if ($ic_number == '960805465058'){ //Syafiah support OPERATION-AGMSB (temp)
//                $custom_condition = "OR (s.department_sub = 'OPERATION-AGMSB' AND lv.support_status IS NULL)";
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
        $custom_condition = "OR (s.noic = '860105465147' AND s.department_sub = 'OPERATION-TKSB' AND lv.support_status IS NULL)";

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
            $custom_condition = "AND s.department_id = '$department_id' OR (s.noic IN ($avsb_condition) AND lv.support_status IS NULL)";

        }

    }else if($department_sub == 'TECHOPERATION' && $role != 'HOD') {
        if ($ic_number == '921030115797') { //Qomaruzzaman support all mooring-gang & techoperation MOCSB
            $custom_condition = "AND s.department_id IN ('$department_id','MOCSB') OR (s.department_sub IN ('MOORING-GANG','PILOT-BOAT') AND lv.support_status IS NULL)";

        }else if ($ic_number == '960215115701') { //Syahril huzairi support technical-avsb
            $custom_condition = "AND s.department_id = '$department_id' OR (s.department_sub = 'TECHNICAL-AVSB' AND lv.support_status IS NULL)";

        }else if ($ic_number == '840302115535') { //Wan zulkifl support techoperation agesb
            $custom_condition = "AND s.department_id = '$department_id'";

        }else if($department_id == 'AGESB'){ //staff support firdaus nasir - TECHASSISTANT
            $custom_condition = "AND s.department_id = '$department_id' OR (s.noic = '940409115285' AND lv.support_status IS NULL)";
        }

    }else if($department_sub == 'TECHASSISTANT') { //support same company
        $custom_condition = "AND s.department_id = '$department_id'";
        if($ic_number == '020618110315'){ //farhan aizaq support haflan(intern)
            $custom_condition = "AND (s.noic = '010605101939' AND lv.support_status IS NULL)";
            $department_sub_filter .= ", 'TECHNICAL-AVSB'";
        }

    }else if($department_sub == 'COMMERCIAL' && $role != 'HOD'){
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

    }else if(!in_array($department_sub, $contrary_from_default_rules) && !in_array($role, ['HOD', 'OPERATIONMANAGER'])){ // [$department_sub] staff (except HOD/OPERATIONMANAGER) support each other (including HOD)
        $custom_condition = "";
    }

    $sql="SELECT COUNT(lv.id) as v02_leave_support FROM v02_aims_leave lv LEFT JOIN staff s ON s.id = lv.staff_id
            WHERE lv.staff_id <> '$staff_id'
            AND lv.support_status IS NULL
            AND s.department_sub IN ($department_sub_filter) $custom_condition
            ORDER BY lv.created_at DESC";

    return $conn->query($sql)->fetch_object()->v02_leave_support;
}

//Leave Approval Version 2
function v02notifyLeaveApproval($staff_id, $ic_number){
    $conn=db();

    $sql="SELECT COUNT(lv.id) as v02_leave_approval FROM v02_aims_leave lv LEFT JOIN staff s ON s.id = lv.staff_id
            WHERE lv.staff_id <> '$staff_id' AND lv.support_status = '1'
                AND lv.approval_status IS NULL
                AND s.leave_approval = '$ic_number' ORDER BY lv.created_at DESC";
    return $conn->query($sql)->fetch_object()->v02_leave_approval;
}

/* ------ TAF NOTIFICATION ------- */
//TAF Verification
function notifyTafVerification($ic_number){
    $conn=db();

    $sql = "SELECT COUNT(t.id) AS taf_verify FROM aims_travel t 
              LEFT JOIN staff s ON s.noic = t.no_staff
              WHERE t.hod_approval = 'PENDING'
              AND s.status = 'BEKERJA'
			  AND s.noic <> '$ic_number'
			  AND s.leave_approval = '$ic_number'";
    return $conn->query($sql)->fetch_object()->taf_verify;
}

//TAF CEO Verification
function notifyTafCeoVerification($ic_number){
    $conn=db();
    $sql="SELECT COUNT(t.id) AS taf_approval FROM aims_travel t 
                  LEFT JOIN staff s ON s.noic = t.no_staff
                  WHERE t.hod_approval = 'PENDING'
                  AND s.status = 'BEKERJA'
    			  AND s.role_id IN ('HOD','MANAGER','CFO','DIRECTOR')
    			  AND s.noic <> '$ic_number'";
    return $conn->query($sql)->fetch_object()->taf_approval;
}

//TAF Approval (CEO/EC)
function notifyTafApproval($ic_number){
    $conn=db();

    if ($ic_number == "751206035485"){ //CEO - Capt. Tarmizi
        $custom_condition = "AND s.role_id NOT IN ('HOD','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO')";
    }else if($ic_number == "660512115105"){ //EC - Hj Aminuddin
        $custom_condition = "AND s.role_id IN ('FOUNDER','HOD','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO','DIRECTOR')";
    }else{
        return 0;
    }

    $sql = "SELECT COUNT(t.id) AS taf_approval FROM aims_travel t 
              LEFT JOIN staff s ON s.noic = t.no_staff
              WHERE t.hod_approval = 'APPROVED'
			  AND t.ceo_approval = 'PENDING'
			  AND s.noic <> '$ic_number'
              AND s.status = 'BEKERJA'
			  $custom_condition";
    return $conn->query($sql)->fetch_object()->taf_approval;
}

/* ------ SSR & SSA NOTIFICATION ------- */
//SSA Procurement Approval
function SSAProcurementApproval(){
    $conn=db();
    $sql="SELECT COUNT(id) AS ssa_proc_app FROM aims_ssa
				WHERE app_status = '1'
				AND ver_status <> '0'
				AND proc_status = '0'
				AND status ='1'";
    return $conn->query($sql)->fetch_object()->ssa_proc_app;
}

//SSR Procurement Approval
function SSRProcurementApproval($ship){
    $conn=db();
    $sql="SELECT COUNT(id) AS ssr_proc_app FROM aims_operationlist
            WHERE approved_status = '1'
              AND verified_status <> '0'
              AND app_pro_status = '0'
              AND status ='1'
              AND vessel = '$ship'";
    return $conn->query($sql)->fetch_object()->ssr_proc_app;
}

//SSA Mr. Khairul Approval
function SSAKhairulApproval(){
    $conn=db();
    $sql="SELECT COUNT(id) AS ssa_approval FROM aims_ssa
				WHERE app_status = '0'
				AND ver_status <> '0'
				AND status ='1'";
    return $conn->query($sql)->fetch_object()->ssa_approval;
}

//SSR Mr. Khairul Approval
function SSRKhairulApproval(){
    $conn=db();
    $sql="SELECT COUNT(id) AS ssr_approval FROM aims_operationlist
				WHERE approved_status = '0'
				AND verified_status <> '0'
				AND status ='1'";
    return $conn->query($sql)->fetch_object()->ssr_approval;
}

/* ------ OTHERS CLAIM NOTIFICATION ------- */
//Claim Verification (HOD)
function notifyClaimVerification($ic_number){
    $conn=db();

    $staff = $conn->query("SELECT role_id, department_sub FROM staff
                WHERE noic = '$ic_number' AND status = 'BEKERJA'")->fetch_assoc();
    $role_id = $staff['role_id'];
    $department_sub = $staff['department_sub'];

    if($role_id == "HOD"){
        if ($department_sub == "OPERATION-AGMSB"){
            $custom_condition = "AND s.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')";
        }else if ($department_sub == "HR"){
            $custom_condition = "AND s.department_sub IN ('HR', 'HR-SEA')";
        }else if ($department_sub == "TECHOPERATION"){
            $custom_condition = "AND s.department_sub IN ('TECHOPERATION', 'PILOT-BOAT','MOORING-GANG')";
        }else if ($department_sub == "COMMERCIAL"){
            $custom_condition = "AND s.department_sub IN ('COMMERCIAL', 'COMMERCIAL-AVSB')";
        }else{
            $custom_condition = "AND s.department_sub = '$department_sub' 
                                    AND s.department_sub NOT IN ('FINACC', 'TECHOPERATION', 'PILOT-BOAT',
                                        'MOORING-GANG', 'OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER',
                                            'HR', 'HR-SEA', 'COMMERCIAL', 'COMMERCIAL-AVSB')";
        }
    }else if($role_id == "HOC"){
        $custom_condition = "AND (s.department_sub IN ('OPERATION-TKSB', 'QR&D') OR s.noic = '941003115183')";
    }else if ($ic_number == "660512115105"){ // Hj Aminuddin - EC
        $custom_condition = "AND s.department_sub = 'ECOFFICE'";
    }else if ($ic_number == "751206035485"){ // Capt. Tarmizi - CEO
        $custom_condition = "AND s.role_id IN ('HOD','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO')";
    }else{
        $custom_condition = "AND s.leave_approval = '$ic_number'";
    }
    $sql="SELECT COUNT(*) AS claim_verify FROM (SELECT DISTINCT(s.name),a.staff_record_id,a.month_claim
			FROM staff s
			LEFT JOIN staff_record st ON s.noic = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			WHERE s.noic <> '$ic_number'
			AND ap.hod_review_status = 'PENDING'
			$custom_condition
		) aims_others_claim";

    return $conn->query($sql)->fetch_object()->claim_verify;
}

//Claim Verification (HOD) VERSION 2
function v02notifyClaimVerification($staff_id, $ic_number){
    $conn=db();
    $sql = "SELECT COUNT(c.id) AS claim_verify FROM v02_aims_others_claim c LEFT JOIN staff s ON s.id = c.staff_id
                WHERE c.staff_id <> '$staff_id' AND s.leave_approval = '$ic_number' AND c.verify_status IS NULL";

    return $conn->query($sql)->fetch_object()->claim_verify;
}

//Claim Reviewal (HR)
function notifyClaimReview($department_code){
    $conn=db();
    $sql="SELECT COUNT(a.id) AS claim_review
			FROM staff s
			LEFT JOIN staff_record st ON s.noic = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			WHERE ap.hod_review_status = 'VERIFIED'
			AND ap.hr_review_status = 'PENDING'
			AND a.company_claim = '$department_code'";
    return $conn->query($sql)->fetch_object()->claim_review;
}

//Claim Reviewal (HR) VERSION 2
function v02notifyClaimReview($department_code){
    $conn=db();
    $sql = "SELECT oc.id
            FROM v02_aims_others_claim oc
            LEFT JOIN v02_aims_claim_cost_centre cc ON cc.claim_id = oc.id
            LEFT JOIN v02_aims_cost_centre ac ON ac.id = cc.company_cc_id
            LEFT JOIN department d ON d.id = ac.company_id
            LEFT JOIN staff s ON s.id = oc.staff_id
            WHERE d.code_department LIKE '%$department_code%' 
            AND (oc.verify_by IS NOT NULL AND oc.verify_status = 1) 
            AND oc.review_status IS NULL
            GROUP BY oc.staff_id, oc.month_claim";
    $result = $conn->query($sql);
    return mysqli_num_rows($result);

}

//Claim Approval
function notifyClaimApproval($ic_number){
    $conn=db();

    $custom_condition = "";

    if ($ic_number == "660512115105"){
        $custom_condition = "AND (s.role_id IN ('FOUNDER','HOD','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO') OR s.department_sub = 'ECOFFICE')"; //PA haji
    }else if ($ic_number == "751206035485"){
        $custom_condition = "AND s.role_id NOT IN ('HOD','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR','MANAGER') AND s.department_sub !='ECOFFICE'"; //PA haji
    }
    $sql="SELECT COUNT(s.id) as claim_approval FROM staff s
			LEFT JOIN staff_record st ON s.noic = st.no_staff
			LEFT JOIN aims_others_claim a ON a.staff_record_id = st.id
			LEFT JOIN aims_others_claim_approval ap ON a.id = ap.other_claim_id
			LEFT JOIN aims_claim_financeuse af ON a.id = af.other_claim_id
			WHERE ap.hod_review_status = 'VERIFIED'
			AND ap.hr_review_status = 'REVIEW'
			AND ap.approve_status = 'PENDING'
			AND af.finance_status = 'CHECK'
            AND s.noic <> '$ic_number'
            $custom_condition";
    return $conn->query($sql)->fetch_object()->claim_approval;
}

//Claim Approval VERSION 2
function v02notifyClaimApproval($staff_id){
    $conn=db();

    $custom_condition = "";

    if ($staff_id == "12"){ //EC
        $custom_condition = "AND (s.role_id IN ('FOUNDER','HOD','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO') AND s.id NOT IN ('812','224'))"; //Or PA haji
    }else if ($staff_id == "13"){ //CEO
        $custom_condition = "AND (s.role_id NOT IN ('HOD','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR','MANAGER') OR s.id IN ('812','224'))"; //Not PA haji
    }
    $sql="SELECT SUM(a.total_claim) as total_claim FROM staff s LEFT JOIN v02_aims_others_claim a ON a.staff_id = s.id
			WHERE a.verify_status = '1' AND a.review_status = '1' AND a.finance_status = '1'
			AND a.approve_status IS NULL AND s.id <> '$staff_id'
            $custom_condition GROUP BY a.staff_id, a.month_claim";
    return $conn->query($sql)->num_rows;
}

//Transport PIC Approval
function notifyTransportPICApproval($ic_number){
    $conn=db();
    $sql_access = "SELECT a.vehicle_access, s.name FROM aims_access a
                                            LEFT JOIN staff s ON a.no_staff = s.noic
                                                WHERE s.noic='$ic_number'";
    $access = $conn->query($sql_access)->fetch_assoc();
    $vehicle_access = $access['vehicle_access'];
    $staff_name = $access['name'];

    if ($vehicle_access == '1'){
        $sql="SELECT COUNT(a.id) AS pic_approval FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		WHERE c.app_status = 'PENDING'
		AND (b.car_pic = '$staff_name' OR b.car_pic2 = '$staff_name')
		AND a.sbu_hod_app = 'APPROVE'";

        return $conn->query($sql)->fetch_object()->pic_approval;
    }
    return 0;
}

//Admin Approval
function notifyTransportAdminApproval($ic_number){
    $conn=db();
    $sql_access = "SELECT a.vehicle_access FROM aims_access a
                                            LEFT JOIN staff s ON a.no_staff = s.noic
                                                WHERE s.noic='$ic_number'";
    $vehicle_access = $conn->query($sql_access)->fetch_object()->vehicle_access;

    if ($vehicle_access == '2'){
        $sql = "SELECT COUNT(a.id) AS admin_approval FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
        LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		WHERE c.app_status = 'PENDING'
		AND a.sbu_hod_app = 'APPROVE'";

        return $conn->query($sql)->fetch_object()->admin_approval;
    }
    return 0;
}

//HOD Approval
function notifyTransportHodApproval($ic_number){
    $conn=db();

    $staff = $conn->query("SELECT name, role_id, department_sub FROM staff
                WHERE noic = '$ic_number' AND status = 'BEKERJA'")->fetch_assoc();
    $staff_name = $staff['name'];
    $role_id = $staff['role_id'];
    $department_sub = $staff['department_sub'];

    $custom_condition = "AND e.leave_approval = '$ic_number'";
    if ($role_id == "HOD"){
        if ($department_sub == "OPERATION-AGMSB"){
            $custom_condition = "AND e.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')";
        }else if ($department_sub == "HR"){
            $custom_condition = "AND e.department_sub IN ('HR', 'HR-SEA')";
        }else if ($department_sub == "TECHOPERATION"){
            $custom_condition = "AND e.department_sub IN ('TECHOPERATION', 'PILOT-BOAT','MOORING-GANG')";
        }else{
            $custom_condition = "AND e.department_sub = '$department_sub'";
        }
    }else if ($role_id == "CFO"){
        $custom_condition = "AND e.department_sub = 'FINACC'";
    }else if ($ic_number == "751206035485"){
        $custom_condition = "AND e.role_id = 'HOD'";
    }else if ($ic_number == "660512115105"){
        $custom_condition = "AND (e.role_id IN ('FOUNDER','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO') OR e.department_sub = 'ECOFFICE')";
    }else if ($role_id == "HODAGM"){ //May not be used (Confusing Entity)
        $custom_condition = "AND e.department_sub = 'OPERATION-AGMSB'";
    }
    $sql = "SELECT COUNT(a.id) AS hod_approval FROM aims_car_reserve a  
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE a.sbu_hod_app = 'PENDING'
		AND e.name <> '$staff_name'
		$custom_condition";
    return $conn->query($sql)->fetch_object()->hod_approval;
}

//In Out Verification (Staff in same department)
function notifyInOutVerification($ic_number){
    $conn=db();
    $staff = $conn->query("SELECT role_id, department_sub FROM staff WHERE noic = '$ic_number'")->fetch_assoc();
    $staff_role = $staff['role_id'];
    $staff_department_sub = $staff['department_sub'];

    if ($staff_role == '751206035485'){ //CEO
        $custom_condition = " AND s.noic = '810415035497'";

    }else if ($staff_role == 'EXECUTIVEAVSB'){ //staff resigned, may not be used
        $custom_condition = " AND s.department_sub IN ('OPERATIONFAC-AVSB', 'OPERATION-AVSB')
		                        AND s.role_id <> 'OPERATIONMANAGER'";

    }else if($staff_role == 'SUPERVISORAVSB'){
        $custom_condition = " AND s.role_id = 'EXECUTIVEAVSB'";

    }else if($staff_role == 'EXECUTIVETKSB'){
        $custom_condition = " AND s.department_sub = 'OPERATION-TKSB'";

    }else if($staff_role == 'SUPERVISORTKSB'){
        $custom_condition = " AND s.role_id = 'EXECUTIVETKSB'";

    }else if($staff_role == 'EXECUTIVE-DIRECTOR'){
        $custom_condition = " AND s.role_id = 'MANAGING-DIRECTOR'";

    }else if($staff_role == 'MANAGING-DIRECTOR'){
        $custom_condition = " AND s.role_id IN ('EXECUTIVE-DIRECTOR','HOC','OPERATIONMANAGER')";

    }else if($ic_number == '911011115100'){ //noraida syafinaz
        $custom_condition = " AND s.department_sub IN ('HR','SECRETARY-AVSB') AND s.department_id = 'AVSB'";

    }else if(in_array($staff_department_sub, ['OPERATION-AVSB', 'OPERATIONFAC-AVSB'])){
        if ($ic_number == '960221115249'){
            $custom_condition = " AND s.department_sub IN ('OPERATION-AVSB', 'OPERATIONFAC-AVSB')
			                        AND s.role_id NOT IN ('OPERATIONMANAGER', 'SUPERVISORAVSB', 'EXECUTIVEAVSB',
			                            'EXECUTIVETKSB', 'SUPERVISORTKSB' ,'EXECUTIVE-DIRECTOR', 'MANAGING-DIRECTOR')";
        }else{
            $custom_condition = " AND s.noic IN ('960221115249')";
        }

    }else if($staff_role == 'HOD' && $staff_department_sub == 'HR'){ //HOD HR
        $custom_condition = " AND (s.department_sub = 'ECOFFICE' OR s.noic ='911011115100')";
    }else if(in_array($staff_role, ['HOD','STAFF', 'CONTRACT']) && in_array($staff_department_sub, ['FINACC', 'OPERATION-AGMHESB'])){
        $custom_condition = " AND s.department_sub = '$staff_department_sub'";
        if ($staff_role != 'HOD'){
            $custom_condition .= " AND s.role_id = 'HOD'";
        }
    }else if($staff_department_sub == 'HR-AGMA'){
        $custom_condition = " AND s.department_sub IN ('OPERATION-AGMSB', 'HR-AGMA')";
    }else if($ic_number == '940331025617'){
        $custom_condition = " AND s.department_sub IN ('TECHOPERATION','PILOT-BOAT','MOORING-GANG')";
    }else{
        $custom_condition = " AND s.department_sub='$staff_department_sub' 
                                AND s.department_sub NOT IN ('MANAGEMENT', 'OPERATION-AGMSB', 'HR-AGMA', 'TECHOPERATION','PILOT-BOAT','MOORING-GANG',
                                'HR','SECRETARY-AVSB', 'ECOFFICE', 'FINACC', 'OPERATION-AGMHESB', 'OPERATION-TKSB','OPERATION-AVSB', 'OPERATIONFAC-AVSB')";
    }

    $sql="SELECT COUNT(a.id) AS in_out_verify FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff s ON c.no_staff = s.noic 
		WHERE b.verified='PENDING'
		AND s.noic <> '$ic_number'
		AND s.status = 'BEKERJA'
		$custom_condition";
    return $conn->query($sql)->fetch_object()->in_out_verify;
}

function notifyInOutApproval($ic_number){
    $conn=db();
    $staff = $conn->query("SELECT role_id, department_sub FROM staff WHERE noic = '$ic_number'")->fetch_assoc();
    $staff_role = $staff['role_id'];

    if ($ic_number == '740915115003'){
        $custom_condition = "AND s.department_sub = 'OPERATION-AGMHESB'";
    }else if ($staff_role == 'CFO'){
        $custom_condition = "AND s.department_sub = 'FINACC'";
    }else{
        $custom_condition = "AND s.leave_approval = '$ic_number' AND s.department_sub NOT IN ('OPERATION-AGMHESB','FINACC')";
    }

    $sql="SELECT COUNT(a.id) AS in_out_approval FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON a.id = b.aims_inout_id
		LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
		LEFT JOIN staff s ON s.noic = sr.no_staff
		WHERE b.approve= 'PENDING'
		AND b.verified= 'APPROVE'
		AND s.noic <> '$ic_number'
		$custom_condition";
    return $conn->query($sql)->fetch_object()->in_out_approval;
}

//In Out Support (staff in same department) -> v1 use 'In Out Verification' terms
function v02NotifyInOutSupport($staff_id){
    $conn=db();
    $staff = $conn->query("SELECT noic, role_id, department_id, department_sub FROM staff WHERE id = '$staff_id'")->fetch_assoc();
    $ic_number = $staff['noic'];
    $role = $staff['role_id'];
    $department_id = $staff['department_id'];
    $department_sub = $staff['department_sub']; //used in if-else condition
    $department_sub_filter = "'$department_sub'"; //used in query (variable may be override in if-else statement)

    $contrary_from_default_rules = ['MANAGEMENT','OPERATION-AGMHESB','HR', 'HR-SEA', 'ECOFFICE', 'FINACC','OPERATION-AGMSB', 'CORPADMIN-AVSB',
        'HR-AGMA', 'OPERATION-BUNKER', 'QR&D', 'TECHOPERATION', 'MOORING-GANG', 'TECHNICAL-AVSB', 'COMMERCIAL','OPERATION-AVSB', 'OPERATIONFAC-AVSB',
        'CATERING', 'OPERATION-TKSB', 'OPERATIONFOOD-AVSB'];
    //set an 'always false' condition for all non-involved staff
    $custom_condition = "AND io.date = '0000-00-00'";

    if($ic_number == '751206035485'){
        $custom_condition = "AND s.noic = '810415035497'";
        $department_sub_filter = "'MARKETING&BUSINESS-DEV'";

    }else if($role == 'MANAGER' && $department_sub != 'COMMERCIAL'){
        if($department_id == 'AGESB'){ //Khairul Aznam support MAWARIANI (OPERATION-AGMHESB)
            $custom_condition = "AND s.noic = '740505115019'";
            $department_sub_filter = "'OPERATION-AGMHESB'";

        }else if($department_id == 'AVSB'){ //Rosliha support EXECUTIVE-DIRECTOR, CONTRACT TECHASSISTANT (Farhan Aizaq) & NURIN SHARIF (INTERN AVSB) & NURIN ATHIRAH (INTERN QR&D)
            $custom_condition = "AND s.role_id IN ('EXECUTIVE-DIRECTOR','CONTRACT') OR s.noic IN ('030330110462', '020618110315') AND s.role_id IN ('INTERN', 'CONTRACT')";
            $department_sub_filter = "'MANAGEMENT'";
        }

    }else if($role == 'EXECUTIVE-DIRECTOR'){ //Syafiq Sahamudin support rosliha (MANAGER AVSB)
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
                                            '001218110267', '001012110763', '990905115335') AND io.support_status IS NULL)";
            $department_sub_filter .= ", 'OPERATIONFAC-AVSB'";

        }else if($ic_number == '850102115257') { //fadzli support farizuwan, tengku farezwan & nik mohd syafiq (OPERATION-AVSB)
            $custom_condition = "AND (s.noic IN ('980123115235', '930331115103','890224115315') AND io.support_status IS NULL)";

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
                $custom_condition = " OR (s.department_id IN ('AVSB','TKSB') AND s.department_sub = 'HR' AND io.support_status IS NULL)";
            }
//            else if ($ic_number == '960805465058'){ //Syafiah support OPERATION-AGMSB (temp)
//                $custom_condition = "OR (s.department_sub = 'OPERATION-AGMSB' AND io.support_status IS NULL)";
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
        $custom_condition = "OR (s.noic = '860105465147' AND s.department_sub = 'OPERATION-TKSB' AND io.support_status IS NULL)";

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
            $custom_condition = "AND s.department_id = '$department_id' OR (s.noic IN ($avsb_condition) AND io.support_status IS NULL)";
        }

    }else if($department_sub == 'TECHOPERATION' && $role != 'HOD') {
        if ($ic_number == '921030115797') { //Qomaruzzaman support all mooring-gang & techoperation MOCSB
            $custom_condition = "AND s.department_id IN ('$department_id','MOCSB') OR (s.department_sub IN ('MOORING-GANG','PILOT-BOAT') AND io.support_status IS NULL)";

        }else if ($ic_number == '960215115701') { //Syahril huzairi support technical-avsb
            $custom_condition = "AND s.department_id = '$department_id' OR (s.department_sub = 'TECHNICAL-AVSB' AND io.support_status IS NULL)";

        }else if ($ic_number == '840302115535') { //Wan zulkifl support techoperation agesb
            $custom_condition = "AND s.department_id = '$department_id'";

        }else if($department_id == 'AGESB'){ //staff support firdaus nasir - TECHASSISTANT
            $custom_condition = "AND s.department_id = '$department_id' OR (s.noic = '940409115285' AND io.support_status IS NULL)";
        }

    }else if($department_sub == 'TECHASSISTANT') { //support same company
        $custom_condition = "AND s.department_id = '$department_id'";
        if($ic_number == '020618110315'){ //farhan aizaq support haflan(intern)
            $custom_condition = "AND (s.noic = '010605101939' AND io.support_status IS NULL)";
            $department_sub_filter .= ", 'TECHNICAL-AVSB'";
        }

    }else if($department_sub == 'COMMERCIAL' && $role != 'HOD'){
        $ccd_array = commercialDepartmentSupportRules();
        $intern_condition = ($ic_number == '890506145555') ? "OR s.role_id = 'INTERN'" : ""; //Aidil support all interns

        $not_in = "(".implode(',', $ccd_array).")";

        if (array_key_exists($ic_number, $ccd_array)){
            $department_sub_filter = "'COMMERCIAL', 'COMMERCIAL-AVSB'";
            $custom_condition = "AND (s.noic IN (".$ccd_array[$ic_number].") $intern_condition)";
        }else{ //all except 6 staff in stated array support HOD
            $custom_condition = "AND s.noic NOT IN $not_in";
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

    $sql="SELECT COUNT(io.id) AS in_out_support FROM v02_aims_inout io LEFT JOIN staff s ON s.id = io.staff_id
            WHERE io.staff_id <> '$staff_id' AND io.support_status IS NULL AND s.department_sub IN ($department_sub_filter)
             $custom_condition";
    return $conn->query($sql)->fetch_object()->in_out_support;
}

//In Out Approval (by HOD)
function v02NotifyInOutApproval($staff_id){
    $conn=db();
    $ic_number = $conn->query("SELECT noic FROM staff WHERE id = '$staff_id'")->fetch_object()->noic;

    $sql="SELECT COUNT(io.id) AS in_out_approval FROM v02_aims_inout io LEFT JOIN staff s ON s.id = io.staff_id
            WHERE io.staff_id <> '$staff_id' AND io.support_status = '1'
            AND io.approve_status IS NULL AND s.leave_approval = '$ic_number' ORDER BY io.created_at DESC";
    return $conn->query($sql)->fetch_object()->in_out_approval;
}

function v02NotifyMedicalCfoApproval(){
    $conn=db();
    $sql = "SELECT COUNT(m.id) AS medical_approval FROM v02_aims_medical m LEFT JOIN staff s ON s.id = m.staff_id
                WHERE m.hr_verify_status = '1' AND m.cfo_approval_status IS NULL";
    return $conn->query($sql)->fetch_object()->medical_approval;
}

function v02NotifyMedicalCeoApproval($staff_id){
    $conn=db();
    if ($staff_id == '12'){ //Chairman
        $custom_condition = "AND s.role_id = 'FOUNDER'";
    }elseif($staff_id == '13'){ //CEO
        $custom_condition = "";
    }else{
        return null;
    }

    $sql="SELECT COUNT(m.id) AS medical_approval FROM v02_aims_medical m LEFT JOIN staff s ON s.id = m.staff_id
                WHERE m.hr_verify_status = '1' AND m.cfo_approval_status = '1' AND m.staff_id <> '$staff_id'
                AND m.ceo_approval_status IS NULL $custom_condition";
    return $conn->query($sql)->fetch_object()->medical_approval;
}