<?php
require '../../lib/db/connection.php';
date_default_timezone_set('Asia/Kuala_Lumpur');

// Function to sanitize values received from the form. Prevents SQL injection
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
    $sql = "SELECT s.*,c.short_name FROM sys_setting s 
				LEFT JOIN company c ON c.sys_id = s.sys_id 
				WHERE s.sys_id='$sys_id'";
    return $conn->query($sql);
}

function getCompanyName($department_id){
    $conn=db();
    $sql="SELECT description FROM department WHERE code_department = '$department_id'";
    return $conn->query($sql)->fetch_object()->description;
}

function addCarAdmin($app_status,$reason,$name_admin,$description,$department,$id) {
    $conn=db();
    $sql2 = "UPDATE aims_car_admin SET app_status='$app_status', reason='$reason', name_admin = '$name_admin', date_app = CURRENT_TIMESTAMP ,descrip = '$description', department = '$department',
			created_by = '$name_admin' WHERE id ='$id'";
    return $conn->query($sql2);
}

function getcarRequestById1($id) {
    $conn=db();
    $sql = "SELECT a.*,b.name as car_reserve_name, s.department_id FROM aims_car_admin a
		LEFT JOIN aims_car_reserve b ON b.id = a.reserve_id
		LEFT JOIN staff s ON s.name = b.name
	    WHERE a.id ='$id'";
    return $conn->query($sql);
}

//function getDropDownMonth1($selected) {
//    $conn=db();
//    $sql = "SELECT MONTH(dep_date), YEAR(dep_date) FROM aims_car_inspection GROUP BY MONTH(dep_date) ORDER BY dep_date";
//
//    $result = $conn->query($sql);
//
//    $txt_result="";
//    while ($row  = $result -> fetch_array()){
//        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]." / ".$row[1]."</option>";
//    }
//    return $txt_result;
//}

function getDropDownMonth2($selected) {
    $conn=db();
    $sql = "SELECT MONTH(dep_date), YEAR(dep_date) FROM aims_car_reserve WHERE YEAR(dep_date) = YEAR(CURDATE()) GROUP BY MONTH(dep_date) ORDER BY dep_date";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]." / ".$row[1]."</option>";
    }
    return $txt_result;
}

function getDropDownMonth5($selected) {
    $conn=db();
    $sql = "SELECT MONTH(dep_date), YEAR(dep_date) FROM aims_car_inspection_bycompany GROUP BY MONTH(dep_date) ORDER BY dep_date";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]." / ".$row[1]."</option>";
    }
    return $txt_result;
}

function getDropDownMonth($selected) {
    $conn=db();
    $sql = "SELECT MONTH(dep_date), YEAR(dep_date) FROM aims_car_passenger GROUP BY MONTH(dep_date) ORDER BY dep_date";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]." / ".$row[1]."</option>";
    }
    return $txt_result;
}

function getDropDownYear($selected) {
    $conn=db();
    $sql = "SELECT YEAR(dep_date) FROM aims_car_passenger GROUP BY YEAR(dep_date) ORDER BY dep_date";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
    }
    return $txt_result;
}

//car inspection Admin dropdown month and year

function getDropDownMonthInspec($selected) {
    $conn=db();

    $sql = "SELECT month_num, month_description FROM aims_month ORDER BY month_num";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
    }

    return $txt_result;
}

function getDropDownYearInspec($selected) {
    $conn=db();

    $sql = "SELECT YEAR(dep_date) FROM aims_car_inspection WHERE dep_date <> '0000-00-00' GROUP BY YEAR(dep_date) ORDER BY YEAR(dep_date) DESC";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
    }

    return $txt_result;
}
//end Admin car inspection dropdown

//car inspection Company dropdown month and year

function getDropDownMonthCom($selected) {
    $conn=db();
    $sql = "SELECT month_num, month_description FROM aims_month ORDER BY month_num";
    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
    }

    return $txt_result;
}

function getDropDownYearCom($selected) {
    $conn=db();
    $sql = "SELECT MONTH(dep_date), YEAR(dep_date) FROM aims_car_inspection_bycompany GROUP BY YEAR(dep_date) ORDER BY YEAR(dep_date) DESC";
    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[1] == $selected ? 'selected':'')." value=\"".$row[1]."\">".$row[1]."</option>";
    }

    return $txt_result;
}
//end Company car inspection dropdown

//user list
function getcarRequestList($name) {
    $conn=db();
    $sql = "SELECT a.*,b.car_plate_no,b.car_type, e.code_department,c.app_status,ac.summon_status,i.reserve_id AS inspection FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN department_load e ON a.department_name = e.code_department
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN aims_car_summon ac ON a.id = ac.reserve_id
		LEFT JOIN aims_car_inspection i ON a.id = i.reserve_id
		WHERE a.name ='$name'
		ORDER BY a.created_date DESC";
    return $conn->query($sql);
}

function getCarRequestHodApproval($no_staff, $app_status){
    $conn=db();

    $staff = $conn->query("SELECT name, role_id, department_sub FROM staff
                WHERE no_staff = '$no_staff' AND status = 'BEKERJA'")->fetch_assoc();
    $staff_name = $staff['name'];
    $role_id = $staff['role_id'];
    $department_sub = $staff['department_sub'];

    $custom_condition = "AND e.leave_approval = '$no_staff'";
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
    }else if ($no_staff == "751206035485"){
        $custom_condition = "AND e.role_id = 'HOD'";
    }else if ($no_staff == "660512115105"){
        $custom_condition = "AND (e.role_id IN ('FOUNDER','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO') OR e.department_sub = 'ECOFFICE')";
    }else if ($role_id == "HODAGM"){ //May not be used (Confusing Entity)
        $custom_condition = "AND e.department_sub = 'OPERATION-AGMSB'";
    }
    $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a  
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE a.sbu_hod_app = '$app_status'
		AND e.name <> '$staff_name'
		$custom_condition";
    return $conn->query($sql);
}

//hod list	
function getcarRequestHodBaharu($department_sub,$name) {
    $conn=db();
    $staff_info = $conn->query("SELECT role_id FROM staff WHERE name='$name'")->fetch_assoc();
    $role_id=$staff_info['role_id'];
    $no_staff=$staff_info['no_staff'];

    if ($role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB') {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')
		AND a.sbu_hod_app = 'PENDING'
		AND e.name <> '$name'
		ORDER BY a.created_date";
    }

    else if ($role_id == 'MANAGING-DIRECTOR') {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE (e.department_sub IN ('OPERATION-AVSB','PROCUREMENT-AVSB','CORPADMIN-AVSB',
		'COMMERCIAL-AVSB','OPERATIONFAC-AVSB','OPERATIONFOOD-AVSB','LOGISTIC','QR&D-TKSB','OPERATION-TKSB') OR e.role_id = 'HOC')
		AND a.sbu_hod_app = 'PENDING'
		AND e.name <> '$name'
		ORDER BY a.created_date";
    }

    else if ($role_id == 'HOD' && $department_sub == 'HR') {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub IN ('HR', 'HR-SEA')
		AND a.sbu_hod_app = 'PENDING'
		AND e.name <> '$name'
		ORDER BY a.created_date";
    }

    else if ($role_id == 'HOD' && $department_sub == 'TECHOPERATION') {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub IN ('TECHOPERATION', 'PILOT-BOAT','MOORING-GANG')
		AND a.sbu_hod_app = 'PENDING'
		AND e.name <> '$name'
		ORDER BY a.created_date";
    }

    else if( $role_id == 'CFO' ) {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub = 'FINACC'
		AND e.role_id = 'HOD'
		AND a.sbu_hod_app = 'PENDING'
		AND e.name <> '$name'
		ORDER BY a.created_date";
    }

    else if( $no_staff == '751206035485' ) {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.role_id = 'HOD'
		AND a.sbu_hod_app = 'PENDING'
		AND e.name <> '$name'
		ORDER BY a.created_date";
    }

    else if( $no_staff == '660512115105' ) {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE (e.role_id IN ('FOUNDER','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO') OR e.department_sub = 'ECOFFICE')
		AND a.sbu_hod_app = 'PENDING'
		AND e.name <> '$name'
		ORDER BY a.created_date";
    }


    else if ( $role_id == 'HOD' ) {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub = '$department_sub'
		AND e.name <> '$name'
		AND a.sbu_hod_app = 'PENDING'
		ORDER BY a.created_date";
    }

    else if ($role_id == 'HODAGM') {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub = 'OPERATION-AGMSB'
		AND a.sbu_hod_app = 'PENDING'
		AND e.name <> '$name'
		ORDER BY a.created_date";
    }

    else{
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.leave_approval = '$no_staff'
		AND e.name <> '$name'
		AND a.sbu_hod_app = 'PENDING'
		ORDER BY a.created_date";
    }

    return $conn->query($sql);
}

function getcarRequestHodLulus($department_sub,$name) {
    $conn=db();
    $staff_info = $conn->query("SELECT role_id FROM staff WHERE name='$name'")->fetch_assoc();
    $role_id=$staff_info['role_id'];
    $no_staff=$staff_info['no_staff'];

    if ($role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB') {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')
		AND e.name <> '$name'
		AND a.sbu_hod_app = 'APPROVE'
		ORDER BY a.created_date";
    }

    else if ($role_id == 'MANAGING-DIRECTOR') {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE (e.department_sub IN ('OPERATION-AVSB','PROCUREMENT-AVSB','CORPADMIN-AVSB',
		'COMMERCIAL-AVSB','OPERATIONFAC-AVSB','OPERATIONFOOD-AVSB','LOGISTIC','QR&D-TKSB','OPERATION-TKSB') OR e.role_id = 'HOC')
		AND a.sbu_hod_app = 'APPROVE'
		AND e.name <> '$name'
		ORDER BY a.created_date";
    }

    else if ($role_id == 'HOD' && $department_sub == 'HR') {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub IN ('HR', 'HR-SEA')
		AND e.name <> '$name'
		AND a.sbu_hod_app = 'APPROVE'
		ORDER BY a.created_date";
    }

    else if ($role_id == 'HOD' && $department_sub == 'TECHOPERATION') {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub IN ('TECHOPERATION', 'PILOT-BOAT','MOORING-GANG')
		AND e.name <> '$name'
		AND a.sbu_hod_app = 'APPROVE'
		ORDER BY a.created_date";
    }

    else if( $role_id == 'CFO' ) {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub = 'FINACC'
		AND e.name <> '$name'
		AND e.role_id = 'HOD'
		AND a.sbu_hod_app = 'APPROVE'
		ORDER BY a.created_date";
    }

    else if( $no_staff == '751206035485' ) {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.name <> '$name'
		AND e.role_id = 'HOD'
		AND a.sbu_hod_app = 'APPROVE'
		ORDER BY a.created_date";
    }

    else if( $no_staff == '660512115105' ) {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.name <> '$name'
		AND (e.role_id IN ('FOUNDER','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO') OR e.department_sub = 'ECOFFICE')
		AND a.sbu_hod_app = 'APPROVE'
		ORDER BY a.created_date";
    }

    else if ( $role_id == 'HOD' ) {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub = '$department_sub'
		AND e.name <> '$name'
		AND a.sbu_hod_app = 'APPROVE'
		ORDER BY a.created_date";
    }

    else if ($role_id == 'HODAGM') {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub = 'OPERATION-AGMSB'
		AND a.sbu_hod_app = 'APPROVE'
		AND e.name <> '$name'
		ORDER BY a.created_date";
    }

    else{
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.leave_approval = '$no_staff'
		AND e.name <> '$name'
		AND a.sbu_hod_app = 'APPROVE'
		ORDER BY a.created_date";
    }

    return $conn->query($sql);
}

function getcarRequestHodTLulus($department_sub,$name) {
    $conn=db();
    $staff_info = $conn->query("SELECT role_id FROM staff WHERE name='$name'")->fetch_assoc();
    $role_id=$staff_info['role_id'];
    $no_staff=$staff_info['no_staff'];

    if ($role_id == 'HOD' && $department_sub == 'OPERATION-AGMSB') {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub IN ('OPERATION-AGMSB','HR-AGMA','OPERATION-BUNKER')
		AND e.name <> '$name'
		AND a.sbu_hod_app = 'DISAPPROVE'
		ORDER BY a.created_date";
    }

    else if ($role_id == 'MANAGING-DIRECTOR') {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE (e.department_sub IN ('OPERATION-AVSB','PROCUREMENT-AVSB','CORPADMIN-AVSB',
		'COMMERCIAL-AVSB','OPERATIONFAC-AVSB','OPERATIONFOOD-AVSB','LOGISTIC','QR&D-TKSB','OPERATION-TKSB') OR e.role_id = 'HOC')
		AND a.sbu_hod_app = 'DISAPPROVE'
		AND e.name <> '$name'
		ORDER BY a.created_date";
    }

    else if ($role_id == 'HOD' && $department_sub == 'HR') {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub IN ('HR', 'HR-SEA')
		AND e.name <> '$name'
		AND a.sbu_hod_app = 'DISAPPROVE'
		ORDER BY a.created_date";
    }

    else if ($role_id == 'HOD' && $department_sub == 'TECHOPERATION') {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub IN ('TECHOPERATION', 'PILOT-BOAT','MOORING-GANG')
		AND e.name <> '$name'
		AND a.sbu_hod_app = 'DISAPPROVE'
		ORDER BY a.created_date";
    }

    else if( $role_id == 'CFO' ) {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub = 'FINACC'
		AND e.name <> '$name'
		AND e.role_id = 'HOD'
		AND a.sbu_hod_app = 'DISAPPROVE'
		ORDER BY a.created_date";
    }

    else if( $no_staff == '751206035485' ) {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.name <> '$name'
		AND e.role_id = 'HOD'
		AND a.sbu_hod_app = 'DISAPPROVE'
		ORDER BY a.created_date";
    }

    else if( $no_staff == '660512115105' ) {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.name <> '$name'
		AND (e.role_id IN ('FOUNDER','MANAGER','EXECUTIVE-DIRECTOR','MANAGING-DIRECTOR','CFO') OR e.department_sub = 'ECOFFICE')
		AND a.sbu_hod_app = 'DISAPPROVE'
		ORDER BY a.created_date";
    }

    else if ( $role_id == 'HOD' ) {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub = '$department_sub'
		AND e.name <> '$name'
		AND a.sbu_hod_app = 'DISAPPROVE'
		ORDER BY a.created_date";
    }

    else if ($role_id == 'HODAGM') {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.department_sub = 'OPERATION-AGMSB'
		AND a.sbu_hod_app = 'DISAPPROVE'
		AND e.name <> '$name'
		ORDER BY a.created_date";
    }

    else{
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin c ON a.id = c.reserve_id
		LEFT JOIN staff e ON a.name = e.name
		LEFT JOIN aims_travel t ON a.taf_id = t.id
		WHERE e.leave_approval = '$no_staff'
		AND e.no_staff <> '$no_staff'
		AND a.sbu_hod_app = 'DISAPPROVE'
		ORDER BY a.created_date";
    }

    return $conn->query($sql);
}

function getTransportRequestList($no_staff, $no_plate, $approval){
    $conn=db();
    $vehicle_access = $conn->query("SELECT vehicle_access FROM aims_access WHERE no_staff = '$no_staff'")->fetch_object()->vehicle_access;
    $where_no_plate = ($no_plate != '0') ? "AND a.car_plate_no = '$no_plate'" : "";

    if ($vehicle_access <> '2'){
        echo ("<script type='text/javascript'>
                alert('Authorization access only')
                window.location.href='../view/aims_car_adminsign.php';
                </script>");
        exit();
    }

    $sql = "SELECT a.*,b.car_plate_no,b.car_type, e.reason, e.name_admin,e.date_app,e.descrip,e.id AS admin_id, e.app_status FROM aims_car_reserve a 
                LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
                LEFT JOIN jawatan c ON a.jawatan = c.id
                LEFT JOIN aims_car_admin e ON a.id = e.reserve_id
                WHERE e.app_status='$approval'
                AND a.sbu_hod_app = 'APPROVE'
                $where_no_plate
                ORDER BY a.created_date DESC";

    return $conn->query($sql);
}

//car Request Report
function getcarRequestList3($app_status,$bdaymonth,$name,$status,$plate_no) {
    $where_taf_id = ($status == 'travel') ? "AND a.taf_id <> '0'" : "AND a.taf_id = '0'";
    $conn=db();
    $sql = "SELECT v.vehicle_access FROM aims_access v
		left join staff s ON s.noic = v.no_staff
		WHERE s.name='$name'";
    $vehicle_access=$conn->query($sql)->fetch_object()->vehicle_access;
    if($vehicle_access == '2'){
        $sql = "SELECT a.*,b.car_plate_no,b.car_type,c.summon_status,d.app_status,d.reason FROM aims_car_reserve a 
                    LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
                    LEFT JOIN aims_car_summon c ON a.id = c.reserve_id
                    LEFT JOIN aims_car_admin d ON a.id = d.reserve_id
                    WHERE DATE_FORMAT(dep_date, '%Y-%m')='$bdaymonth'
                    AND d.app_status = '$app_status'
                    AND b.car_plate_no = '$plate_no'
                    $where_taf_id
                    ORDER BY a.dep_date";
    }
    else {
        echo ("<script type='text/javascript'>
						window.location.href='../view/aims_car_adminsign.php';
						</script>");
    }
    return $conn->query($sql);
}

function getcarRequestList4NEW() {
    $conn=db();
    $sql = "SELECT a.*,b.car_plate_no,b.car_type,a.sbu_hod_app,e.app_status,a.ceo_app FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin e ON a.id = e.reserve_id
		WHERE a.ceo_app = 'PENDING'";
    return $conn->query($sql);
}

function getcarRequestList4APPROVE() {
    $conn=db();
    $sql = "SELECT a.*,b.car_plate_no,b.car_type,a.sbu_hod_app,e.app_status,a.ceo_app FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin e ON a.id = e.reserve_id
		WHERE a.ceo_app = 'APPROVE'";
    return $conn->query($sql);
}

function getcarRequestList4DISAPPROVE() {
    $conn=db();
    $sql = "SELECT a.*,b.car_plate_no,b.car_type,a.sbu_hod_app,e.app_status,a.ceo_app FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN aims_car_admin e ON a.id = e.reserve_id
		WHERE a.ceo_app = 'DISAPPROVE'";
    return $conn->query($sql);
}

function getcarRequestById($id) {
    $conn=db();
    $sql = "SELECT a.*,c.description,d.app_status, s.department_id FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN department c ON a.company_name = c.code_department
		LEFT JOIN department_load e ON a.department_name = e.code_department
		LEFT JOIN aims_car_admin d ON a.id = d.reserve_id
		LEFT JOIN staff s ON s.name = a.name
		WHERE a.id='$id'";
    return $conn->query($sql);
}

function  addcarRequest($taf_id,$name,$jawatan,$department_name,$drivername,$purpose,$destination,$company_name,$car_type,$no_passengers,$car_plate_no,$dep_date,$dep_time,$dep_milage,$return_date,$return_time,$return_milage,$created_by,$healty_status,$illness) {
    $conn=db();
    $sql = "INSERT INTO aims_car_reserve (taf_id,name, jawatan, department_name, drivername, purpose, destination,company_name, car_type, no_passengers,
		car_plate_no, dep_date, dep_time, dep_milage, return_date, return_time, return_milage, created_by,healty_status,illness) 
		VALUES('$taf_id','$name', '$jawatan', '$department_name', '$drivername', '$purpose', '$destination', '$company_name', '$car_type', 
		'$no_passengers', '$car_plate_no', '$dep_date', '$dep_time', '$dep_milage', '$return_date', 
		'$return_time', '$return_milage', '$created_by','$healty_status','$illness')";
    $conn->query($sql);

    $reserve_id = $conn->insert_id;
    $sql1 ="INSERT INTO aims_car_admin(reserve_id,app_status) VALUES('$reserve_id','PENDING')";
    return $conn->query($sql1);
}

function updatecarRequest($name,$jawatan,$department_name,$drivername,$purpose,$destination,$company_name,$car_type,$no_passengers,$car_plate_no,$dep_date,$dep_time,$dep_milage,$return_date,$return_time,$return_milage,$status_incep,$healty_status,$illness,$id) {
    $conn=db();
    $sql = "UPDATE aims_car_reserve SET NAME = '$name', jawatan = '$jawatan', department_name='$department_name', drivername = '$drivername', purpose = '$purpose', destination= '$destination', company_name='$company_name', car_type = '$car_type',
		no_passengers = '$no_passengers', car_plate_no = '$car_plate_no', dep_date= '$dep_date', dep_time='$dep_time', dep_milage='$dep_milage', return_date='$return_date', return_time='$return_time', return_milage='$return_milage', status_incep='$status_incep',
		updated_date = CURRENT_TIMESTAMP, healty_status = '$healty_status',illness = '$illness' WHERE id = '$id'";
    return $conn->query($sql);
}

function updatecarbyHod($approve_by,$sbu_hod_app,$id) {
    $conn=db();
    $sql = "UPDATE aims_car_reserve SET approve_by = '$approve_by', sbu_hod_app='$sbu_hod_app', 
		hod_date = CURRENT_TIMESTAMP WHERE id = '$id'";
    return $conn->query($sql);
}

function updatecarbyCeo($app_by,$ceo_app,$id) {
    $conn=db();
    $sql = "UPDATE aims_car_reserve SET ceo_app='APPROVED' AND app_by='$app_by',
		ceo_dateapp = CURRENT_TIMESTAMP WHERE id = '$id'";
    return $conn->query($sql);
}

function deletecarRequest($id){
    $conn=db();
    $sql = "DELETE FROM aims_car_reserve WHERE id='$id'";
    $conn->query($sql);

    $sql2 = "DELETE FROM aims_car_admin WHERE reserve_id='$id'";
    return $conn->query($sql2);
}

function getDropDownCarplate($selected) {
    $conn=db();
    $sql = "SELECT id, car_plate_no FROM aims_car_info";
    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[1] == $selected ? 'selected':'')." value=\"".$row[1]."\">".$row[1]."</option>";
    }

    return $txt_result;
}

function getDropDownstaff($selected) {
    $conn=db();
    $sql = "SELECT id, name FROM staff";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[1] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
    }

    return $txt_result;
}

function getDropDowndepartment($selected) {
    $conn=db();
    $sql = "SELECT id, code_department, description FROM department_load";
    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[1] == $selected ? 'selected':'')." value=\"".$row[1]."\">".$row[2]."</option>";
    }

    return $txt_result;
}

function getDropDesign($selected) {
    $conn=db();
    $sql = "SELECT id, jawatan FROM jawatan";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[1] == $selected ? 'selected':'')." value=\"".$row[1]."\">".$row[1]."</option>";
    }

    return $txt_result;
}

function getDropDownCompany($selected) {
    $conn=db();
    $sql = "SELECT company_code,company_name FROM aims_company WHERE company_status = '1'";
    $result = $conn->query($sql);
    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
    }
    return $txt_result;
}

//function getDropHODSBU($selected) {
//    $conn=db();
//    $sql = "SELECT id, hod_name FROM aims_hod";
//
//    $result = $conn->query($sql);
//
//    $txt_result="";
//    while ($row  = $result -> fetch_array()){
//        $txt_result .= "<option ".($row[1] == $selected ? 'selected':'')." value=\"".$row[1]."\">".$row[1]."</option>";
//    }
//
//    return $txt_result;
//}

//start carPassenger (LIST,ADD,UPDATE,DELETE)

//LIST for staff
function getcarPassengerList($name) {
    $conn=db();
    $sql = "SELECT a.*,b.name,c.dep_date AS tarikh,c.purpose,d.car_plate_no FROM aims_car_passenger a 
		LEFT JOIN staff b ON a.name = b.name
		LEFT JOIN aims_car_reserve c ON a.reserve_id = c.id 
		LEFT JOIN aims_car_info d ON a.car_plate_no = d.car_plate_no
		WHERE b.name ='$name'";
    return $conn->query($sql);
}

//LIST for admin
function getcarPassengerList1($month) {
    $conn=db();
    $sql = "SELECT a.*,c.purpose,d.car_plate_no FROM aims_car_passenger a 
		LEFT JOIN aims_car_reserve c ON a.dep_date = c.dep_date
		LEFT JOIN aims_car_info d ON a.car_plate_no = d.id
		WHERE  MONTH(a.dep_date)='$month'
		ORDER BY a.dep_date";
    return $conn->query($sql);
}
// end

function  addpassenger($reserve_id,$name,$dep_date,$purpose,$car_plate_no,$name_passenger,$jawatan,$description) {
    $conn=db();
    $sql = "INSERT INTO aims_car_passenger (reserve_id, name, dep_date, purpose, car_plate_no, name_passenger, jawatan, description) 
		VALUES('$reserve_id', '$name', '$dep_date', '$purpose', '$car_plate_no','$name_passenger', '$jawatan', 
		'$description')";
    return $conn->query($sql);
}

function updatecarpassenger($name_passenger,$jawatan,$description,$id) {
    $conn=db();
    $sql = "UPDATE aims_car_passenger SET name_passenger='$name_passenger', jawatan = '$jawatan',   description= '$description'
		WHERE id = '$id'";
    return $conn->query($sql);
}

function deletecarpassenger($id){
    $conn=db();
    $sql = "DELETE FROM aims_car_passenger WHERE id='$id'";
    return $conn->query($sql);
}

function getcarpassengerById($id) {
    $conn=db();
    $sql = "SELECT a.*,b.name,c.dep_date,c.purpose,d.car_plate_no FROM aims_car_passenger a 
		LEFT JOIN staff b ON a.name = b.id
		LEFT JOIN aims_car_reserve c ON a.dep_date = c.id 
		LEFT JOIN aims_car_info d ON a.car_plate_no = d.id
	    WHERE a.id='$id'";
    return $conn->query($sql);
}


function getcarpassengerById2($id) {
    $conn=db();
    $sql = "SELECT a.*,b.name,c.dep_date,c.purpose,d.car_plate_no FROM aims_car_passenger a 
		LEFT JOIN staff b ON a.name = b.id
		LEFT JOIN aims_car_reserve c ON a.dep_date = c.id 
		LEFT JOIN aims_car_info d ON a.car_plate_no = d.id
	    WHERE a.reserve_id='$id'";
    return $conn->query($sql);
}

//end car Passenger

//start car Inspection

//LIST for staff
function getcarInspectionList($name) {
    $conn=db();
    $sql = "SELECT * FROM aims_car_inspection 
		WHERE name ='$name'";
    return $conn->query($sql);
}

function getcarInspectionList2($name) {
    $conn=db();
    $sql = "SELECT a.* FROM aims_car_info a";
    return $conn->query($sql);
}

function getCarInspectionListByCompany($department_code) {
    $conn=db();
    $sql = "SELECT a.* FROM aims_car_info a
				WHERE a.car_owner='$department_code'";
    return $conn->query($sql);
}

function getcarInspectionList3($name,$month) {
    $conn=db();
    $sql = "SELECT a.*,b.car_owner FROM aims_car_inspection_bycompany a
		LEFT JOIN aims_car_info b ON b.car_plate_no = a.car_plate_no
		WHERE (b.car_pic='$name' OR b.car_pic2='$name')
		AND MONTH(a.dep_date) = '$month'
		ORDER BY a.dep_date DESC";
    return $conn->query($sql);
}

function getcarInspectionListadmin2($department_code,$month) {
    $conn=db();
    $sql = "SELECT a.*,b.car_owner FROM aims_car_inspection_bycompany a
		LEFT JOIN aims_car_info b ON b.car_plate_no = a.car_plate_no
		WHERE b.car_owner ='$department_code'
		AND MONTH(a.dep_date) = '$month'
		ORDER BY a.dep_date DESC";
    return $conn->query($sql);
}

function getcarInspectionList4($month,$year) {
    $conn=db();
    $sql = "(SELECT a.*,b.car_owner FROM aims_car_inspection_bycompany a
		LEFT JOIN aims_car_info b ON b.car_plate_no = a.car_plate_no
		WHERE MONTH(a.dep_date) = '$month'
		AND YEAR(a.dep_date) = '$year'
		ORDER BY a.dep_date DESC)
		UNION ALL
		(SELECT c.id AS col2,c.car_plate_no,c.dep_date,c.fuel,c.hd_vehicle,a.dep_milage AS dep_milage,a.return_milage AS return_milage,c.exterior_car,c.comment1,c.interior_car,c.comment,c.name AS created_name,c.dep_date AS created_date,c.admin_action AS status_remark,
		c.description AS remark,c.admin_actby AS remark_name,c.costing,c.date_action AS date_remark,c.status,b.car_owner FROM aims_car_inspection c
		LEFT JOIN aims_car_info b ON b.car_plate_no = c.car_plate_no
		LEFT JOIN aims_car_reserve a ON a.id = c.reserve_id
		WHERE MONTH(c.dep_date) = '$month'
		AND YEAR(c.dep_date) = '$year'
		ORDER BY c.dep_date DESC)";
    return $conn->query($sql);
}

//LIST for admin
function getCarInspectionListAdmin($month, $year) {
    $conn=db();
    $where_month = ($month != 'all') ? "AND MONTH(dep_date)='$month'" : "";
    $sql = "SELECT * FROM aims_car_inspection 
		WHERE YEAR(dep_date) = '$year' $where_month
		ORDER BY dep_date";
    return $conn->query($sql);
}

function addcarinspection($reserve_id,$name,$car_plate_no,$dep_date,$fuel,$chk,$chk1,$comment1,$chk2,$comment,$status_incep) {
    $conn=db();
    $sql = "INSERT INTO aims_car_inspection (reserve_id,name, car_plate_no, dep_date, fuel, hd_vehicle, exterior_car,comment1, interior_car, comment) 
		VALUES('$reserve_id','$name', '$car_plate_no', '$dep_date','$fuel', '$chk', '$chk1','$comment1', '$chk2', 
		'$comment')";
    $conn->query($sql);

    $sql = "UPDATE aims_car_reserve SET status_incep='$status_incep' WHERE id = '$reserve_id'";
    return $conn->query($sql);
}

function addcarinspection1($created_name,$car_plate_no,$dep_date,$fuel,$chk,$dep_milage,$return_milage,$chk1,$comment1,$chk2,$comment) {
    $conn=db();
    $sql = "INSERT INTO aims_car_inspection_bycompany (created_name, car_plate_no, dep_date, fuel, hd_vehicle, dep_milage, return_milage, exterior_car,comment1, interior_car, comment) 
		VALUES('$created_name', '$car_plate_no', '$dep_date','$fuel', '$chk','$dep_milage','$return_milage', '$chk1','$comment1', '$chk2', 
		'$comment')";
    return $conn->query($sql);
}

function updatecarinspection($reserve_id,$status_incep,$car_plate_no,$dep_date,$fuel,$chk,$chk1,$comment1,$chk2,$comment,$id) {
    $conn=db();
    $sql = "UPDATE aims_car_inspection SET car_plate_no='$car_plate_no', dep_date = '$dep_date',   fuel= '$fuel' , hd_vehicle ='$chk', exterior_car ='$chk1', comment1 ='$comment1', interior_car = '$chk2', comment ='$comment'
		WHERE id = '$id'";
    $conn->query($sql);

    $sql = "UPDATE aims_car_reserve SET status_incep='$status_incep' WHERE id = '$reserve_id'";
    return $conn->query($sql);
}

function updatecarinspection1($car_plate_no,$dep_date,$fuel,$chk,$dep_milage,$return_milage,$chk1,$comment1,$chk2,$comment,$id) {
    $conn=db();
    $sql = "UPDATE aims_car_inspection_bycompany SET car_plate_no='$car_plate_no', dep_date = '$dep_date',   fuel= '$fuel' , hd_vehicle ='$chk', dep_milage ='$dep_milage', return_milage ='$return_milage', exterior_car ='$chk1', comment1 ='$comment1', interior_car = '$chk2', comment ='$comment'
		WHERE id = '$id'";
    return $conn->query($sql);
}

function deletecarinspection($id){
    $conn=db();
    $sql = "DELETE FROM aims_car_inspection WHERE id='$id'";
    return $conn->query($sql);
}

function deletecarinspection1($id){
    $conn=db();
    $sql = "DELETE FROM aims_car_inspection_bycompany WHERE id='$id'";
    return $conn->query($sql);
}

//function updatelistcarinspection($id) {
//    $conn=db();
//    $sql = "SELECT * from aims_car_inspection
//		WHERE id = '$id'";
//    return $conn->query($sql);
//}

function getCarInspectionById($id) {
    $conn=db();
    $sql = "SELECT a.*,b.status_incep FROM aims_car_inspection a
		LEFT JOIN aims_car_reserve b ON a.reserve_id = b.id
	    WHERE a.id='$id'";
    return $conn->query($sql);
}

function getcarinspectionById1($id) {
    $conn=db();
    $sql = "SELECT * FROM aims_car_inspection_bycompany 
	    WHERE id='$id'";
    return $conn->query($sql);
}

function adminact($admin_action,$costing,$description,$id) {
    $conn=db();
    $sql = "UPDATE aims_car_inspection SET admin_action = '$admin_action', costing = '$costing',description = '$description', date_action = CURRENT_TIMESTAMP
	    WHERE id='$id'";
    return $conn->query($sql);
}
//end car Inspection

//car summon

function getcarsummonList($month, $year, $status) {
    $conn=db();
    $where_month = ($month != 'all') ? "AND MONTH(a.offense) = '$month'" : "";
    $sql = "SELECT a.*, a.name AS guest_name, a.company_name AS guest_company_name,
        a.car_plate_no AS guest_car_plate_no, a.destination AS guest_destination,
        d.name, d.destination,d.car_plate_no,d.company_name FROM aims_car_summon a
        LEFT JOIN aims_car_reserve d ON a.reserve_id = d.id
        WHERE YEAR(a.offense) = '$year' $where_month
        AND a.summon_status = '$status'
        ORDER BY created_date DESC";
    return $conn->query($sql);
}

function addcarsummonWithoutReserveId($summon_by,$destination,$issue_district,$summons_no,$offense,$enforcement_date,$offense_details,$original_amount,$name, $car_plate_no, $company_name) {
    $conn=db();
    $sql = "INSERT INTO aims_car_summon (summon_by,destination,issue_distric, summons_no, offense, enforcement_date, offense_details, original_amount, name, car_plate_no, company_name,summon_status, created_date) 
		VALUES('$summon_by','$destination','$issue_district', '$summons_no', '$offense','$enforcement_date', '$offense_details', '$original_amount','$name','$car_plate_no','$company_name','UNPAID', CURRENT_TIMESTAMP)";
    return $conn->query($sql);
}

function addcarsummon($reserve_id,$summon_by,$issue_district,$summons_no,$offense,$enforcement_date,$offense_details,$original_amount) {
    $conn=db();
    $sql = "INSERT INTO aims_car_summon (reserve_id,summon_by,issue_distric, summons_no, offense, enforcement_date, offense_details, original_amount, summon_status, created_date) 
		VALUES('$reserve_id', '$summon_by', '$issue_district', '$summons_no', '$offense','$enforcement_date', '$offense_details', '$original_amount','UNPAID', CURRENT_TIMESTAMP)";
    return $conn->query($sql);
}

function updatecarsummon($issue_district,$summons_no,$offense,$enforcement_date,$offense_details,$original_amount,$id) {
    $conn=db();
    $sql = "UPDATE aims_car_summon SET issue_distric = '$issue_district', summons_no = '$summons_no', offense = '$offense', enforcement_date = '$enforcement_date', 
		offense_details = '$offense_details', original_amount = '$original_amount' WHERE id = '$id'";
    return $conn->query($sql);
}

function guestUpdateCarSummon($name,$company_name,$car_plate_no,$destination,$issue_distric,$summons_no,$offense,$enforcement_date,$offense_details,$original_amount,$id){
    $conn=db();
    $sql = "UPDATE aims_car_summon 
                SET 
                    name = '$name',
                    company_name = '$company_name',
                    car_plate_no = '$car_plate_no',
                    destination = '$destination',
                    issue_distric = '$issue_distric',
                    summons_no = '$summons_no',
                    offense = '$offense',
                    enforcement_date = '$enforcement_date',
                    offense_details = '$offense_details',
                    original_amount = '$original_amount'
                WHERE id = '$id'";
    return $conn->query($sql);
}

function getcarsummonById($id) {
    $conn=db();
    $sql = "SELECT a.*, a.name AS guest_name, a.company_name AS guest_company_name, a.car_plate_no AS guest_car_plate_no, a.destination AS guest_destination,d.name, d.destination,d.car_plate_no,d.company_name FROM aims_car_summon a
		LEFT JOIN aims_car_reserve d ON a.reserve_id = d.id WHERE a.id='$id'";
    return $conn->query($sql);
}

function getcarsummonupdate1($status,$id) {
    $conn=db();
    $sql = "UPDATE aims_car_summon SET summon_status = '$status'
	    WHERE id='$id'";
    return $conn->query($sql);
}

function deletecarSummon($id){
    $conn=db();
    $sql = "DELETE FROM aims_car_summon WHERE id='$id'";
    return $conn->query($sql);
}
//end car Summon	
//login_car
function login($username,$password) {
    $conn=db();
    $sql = "SELECT a.* FROM login_car a 
        WHERE a.username='$username' AND a.password='$password'";
    return $conn->query($sql);
}


function getCheckboxUpdateCarCEO($id,$staff_name){
    $conn=db();
    if(isset($_POST['checkbox'])){
        $checkbox = $_POST['checkbox'];
        if(isset($_POST['activate'])?$activate = $_POST["activate"]:$deactivate = $_POST["deactivate"])
            $id = "('" . implode( "','", $checkbox ) . "');" ;
        $sql="UPDATE aims_car_reserve SET ceo_app = '".(isset($activate)?'APPROVE':'DISAPPROVE')."',app_by='$staff_name',ceo_dateapp=CURRENT_TIMESTAMP WHERE id IN $id" ;
        return $conn->query($sql);
    }
    return false;
}

function getCheckboxUpdateCarHOD($id,$staff_name){
    $conn=db();
    if(isset($_POST['checkbox'])){
        $checkbox = $_POST['checkbox'];
        if(isset($_POST['activate'])?$activate = $_POST["activate"]:$deactivate = $_POST["deactivate"])
            $id = "('" . implode( "','", $checkbox ) . "');" ;
        $sql="UPDATE aims_car_reserve SET sbu_hod_app = '".(isset($activate)?'APPROVE':'DISAPPROVE')."',approve_by='$staff_name',hod_date=CURRENT_TIMESTAMP WHERE id IN $id" ;
        return $conn->query($sql);
    }
    return false;
}

function getcarRequestPrint($id) {
    $conn=db();
    $sql = "SELECT a.*,ad.name_admin,ad.date_app,ad.app_status,ad.descrip,ad.reason,acs.issue_distric,acs.summons_no,acs.offense,acs.enforcement_date,
		acs.offense_details,acs.original_amount,acs.summon_status,ap.name_passenger,ap.jawatan,ap.description
		FROM aims_car_reserve a
		LEFT JOIN aims_car_admin ad ON a.id = ad.reserve_id
		LEFT JOIN aims_car_summon acs ON a.id = acs.reserve_id
		LEFT JOIN aims_car_passenger ap ON a.id = ap.reserve_id
	    WHERE a.id='$id'";
    return $conn->query($sql);
}

//remark by company
function update_remark($status_remark,$remark,$costing,$remark_name,$id){
    $conn=db();
    $sql = "UPDATE aims_car_inspection_bycompany SET status_remark='$status_remark', remark = '$remark',  remark_name= '$remark_name',
		costing = '$costing', date_remark = CURRENT_TIMESTAMP
		WHERE id = '$id'";
    return $conn->query($sql);
}

function getcarRemarkById($id) {
    $conn=db();
    $sql = "SELECT a.* FROM aims_car_inspection_bycompany a
	    WHERE a.id='$id'";
    return $conn->query($sql);
}

//company approve list
function getcarRequestListPendingCompany($name,$department_code) {
    $conn=db();
    $sql = "SELECT v.vehicle_access FROM aims_access v
		left join staff s ON s.noic = v.no_staff
		WHERE s.name='$name'";
    $vehicle_access=$conn->query($sql)->fetch_object()->vehicle_access;

    if ($vehicle_access == '1') {
        $sql = "SELECT a.*,b.car_plate_no,b.car_type, e.reason, e.name_admin,e.date_app,e.descrip,e.id AS admin_id, e.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN jawatan c ON a.jawatan = c.id
		LEFT JOIN aims_car_admin e ON a.id = e.reserve_id
		WHERE e.app_status='PENDING'
		AND (b.car_pic = '$name' OR b.car_pic2 = '$name')
		AND a.sbu_hod_app = 'APPROVE'
		ORDER BY a.created_date DESC";
    }else {
        echo ("<script type='text/javascript'>
						window.location.href='../view/aims_car_adminsign.php';
						</script>");
    }

    return $conn->query($sql);
}

function getcarRequestListApproveCompany($name) {
    $conn=db();
    $sql = "SELECT a.*,b.car_plate_no,b.car_type, e.reason,e.name_admin,e.date_app,e.descrip ,e.id AS admin_id, e.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN jawatan c ON a.jawatan = c.id
		LEFT JOIN aims_car_admin e ON a.id = e.reserve_id
		WHERE e.app_status='APPROVE'
		AND (b.car_pic = '$name' OR b.car_pic2 = '$name')
		AND a.sbu_hod_app = 'APPROVE'
		ORDER BY a.created_date DESC";

    return $conn->query($sql);
}

function getcarRequestListDisapproveCompany($name) {
    $conn=db();
    $sql = "SELECT a.*,b.car_plate_no,b.car_type, e.reason, e.name_admin,e.date_app,e.descrip ,e.id AS admin_id, e.app_status FROM aims_car_reserve a 
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN jawatan c ON a.jawatan = c.id
		LEFT JOIN aims_car_admin e ON a.id = e.reserve_id
		LEFT JOIN staff s ON s.name = a.name
		WHERE e.app_status='DISAPPROVE'
		AND (b.car_pic = '$name' OR b.car_pic2 = '$name')
		AND a.sbu_hod_app = 'APPROVE'
		ORDER BY a.created_date DESC";

    return $conn->query($sql);
}

//fuel start
function getFuelcarById($id,$status) {
    $conn=db();
    $sql = "SELECT a.* FROM aims_car_fuel a
		LEFT JOIN aims_car_reserve b ON b.id = a.reserve_id
	    WHERE b.id ='$id' AND status = '$status'";
    return $conn->query($sql);
}

function addCarFuel($reserve_id,$status,$mileage_fuel,$receipt_fuel,$document_name,$document_type,$file_name,$file_type,$receipt_date){
    $conn=db();
    $doc_file_field = ($document_name!="") ? ",document_type,document_name,file_name,file_type" : "";
    $doc_file_value = ($document_name!="") ? ",'$document_type','$document_name','$file_name','$file_type'" : "";

    $sql = "INSERT INTO aims_car_fuel (status, mileage_fuel, receipt_fuel, reserve_id, receipt_date $doc_file_field) 
		VALUES ('$status', '$mileage_fuel', '$receipt_fuel', '$reserve_id', '$receipt_date' $doc_file_value)";

    return $conn->query($sql);
}

function updateCarFuel($mileage_fuel,$receipt_fuel,$document_name,$document_type,$file_name,$file_type,$id,$receipt_date){
    $conn=db();

    $document_field = ($document_name!="") ? ",document_name='$document_name',document_type='$document_type'" : "";
    $file_field = ($file_name!="") ? ",file_name='$file_name',file_type='$file_type'" : "";

    $sql = "UPDATE aims_car_fuel SET mileage_fuel='$mileage_fuel', receipt_fuel= '$receipt_fuel', receipt_date = '$receipt_date'
                $document_field $file_field WHERE id='$id'";
    return $conn->query($sql);
}

function deletefuel($id){
    $conn=db();
    $sql = "DELETE FROM aims_car_fuel WHERE id='$id'";
    return $conn->query($sql);
}

//fuel report
function getcarFuelReport($start_date,$end_date,$name,$car_plate_no,$status,$mode) {
    $conn=db();
    $sql = "SELECT v.vehicle_access FROM aims_access v
		left join staff s ON s.noic = v.no_staff
		WHERE s.name='$name'";
    $vehicle_access=$conn->query($sql)->fetch_object()->vehicle_access;

    if($vehicle_access == '2'){
        if($status != ''  && $mode == 'travel'){
            $sql = "SELECT a.mileage_fuel,DATE(a.created_date) AS date_fuel,a.receipt_fuel, a.receipt_date,b.destination,b.return_milage,b.dep_milage,c.car_pic,b.dep_date,b.purpose, b.name as request_name FROM aims_car_fuel a 
		LEFT JOIN aims_car_reserve b ON a.reserve_id = b.id
		LEFT JOIN aims_car_info c ON b.car_plate_no = c.car_plate_no
		WHERE a.status = '$status'
		AND b.car_plate_no = '$car_plate_no'
		AND b.dep_date BETWEEN '$start_date' AND '$end_date'
		AND b.taf_id <> '0'
		ORDER BY b.dep_date";
        }
        else if($status != '' && $mode == 'daily'){
            $sql = "SELECT a.mileage_fuel,DATE(a.created_date) AS date_fuel,a.receipt_fuel, a.receipt_date,b.destination,b.return_milage,b.dep_milage,c.car_pic,b.dep_date,b.purpose, b.name as request_name  FROM aims_car_fuel a 
		LEFT JOIN aims_car_reserve b ON a.reserve_id = b.id
		LEFT JOIN aims_car_info c ON b.car_plate_no = c.car_plate_no
		WHERE a.status = '$status'
		AND b.car_plate_no = '$car_plate_no'
		AND b.dep_date BETWEEN '$start_date' AND '$end_date'
		AND b.taf_id = '0'
		ORDER BY b.dep_date";
        }
        else if ($mode == 'daily'){
            $sql = "SELECT a.mileage_fuel,DATE(a.created_date) AS date_fuel,a.receipt_fuel, a.receipt_date,b.destination,b.return_milage,b.dep_milage,c.car_pic,b.dep_date,b.purpose, b.name as request_name FROM aims_car_fuel a 
		LEFT JOIN aims_car_reserve b ON a.reserve_id = b.id
		LEFT JOIN aims_car_info c ON b.car_plate_no = c.car_plate_no
		WHERE b.car_plate_no = '$car_plate_no'
		AND b.dep_date BETWEEN '$start_date' AND '$end_date'
		AND b.taf_id = '0'
		ORDER BY b.dep_date";
        }
        else {
            $sql = "SELECT a.mileage_fuel,DATE(a.created_date) AS date_fuel,a.receipt_fuel, a.receipt_date,b.destination,b.return_milage,b.dep_milage,c.car_pic,b.dep_date,b.purpose, b.name as request_name FROM aims_car_fuel a 
		LEFT JOIN aims_car_reserve b ON a.reserve_id = b.id
		LEFT JOIN aims_car_info c ON b.car_plate_no = c.car_plate_no
		WHERE b.car_plate_no = '$car_plate_no'
		AND b.dep_date BETWEEN '$start_date' AND '$end_date'
		AND b.taf_id <> '0'
		ORDER BY b.dep_date";
        }
    }
    else {
        echo ("<script type='text/javascript'>
						window.location.href='../view/aims_car_adminsign.php';
						</script>");
    }
    return $conn->query($sql);
}

function getDropDownCarName($selected) {
    $conn=db();
    $sql = "SELECT id, car_plate_no , car_model FROM aims_car_info";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[1] == $selected ? 'selected':'')." value='".$row[1]."'>".$row[1]." - ".$row[2]."</option>";
    }

    return $txt_result;
}

function deletemaintanence($id){
    $conn=db();
    $sql = "DELETE FROM car_maintenance WHERE id='$id'";
    return $conn->query($sql);
}