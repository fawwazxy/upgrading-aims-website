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

function getVisitorType($type, $all = false){
    $visitor = [
        '0' => 'Visitor',
        '1' => 'Contractor',
    ];

    if ($all){
        return $visitor;
    }

    return $visitor[$type];
}

function getVisitorStatus($status, $all = false){
    $visitor = [
        '0' => 'Pending',
        '1' => 'Suspended',
        '2' => 'Verified',
    ];

    if ($all){
        return $visitor;
    }

    return $visitor[$status];
}

function getDistinctCompany(){
    $conn=db();
    $sql="SELECT DISTINCT(company) FROM visitor WHERE company IS NOT NULL ORDER BY company";
    return $conn->query($sql);
}

function getVisitorSummary(){
    $summary = [];
    $conn=db();
    $sql = "SELECT type, status, COUNT(status) AS count FROM visitor GROUP BY type, status < 2 ORDER BY type";
    $result = $conn->query($sql);

    while ($list = $result->fetch_assoc()){
        $key =  ($list['status'] == '2') ? "active" : "inactive";

        $summary[$list['type']][$key] = $list['count'];
    }

    return $summary;
}

function getVisitorList($type, $company, $gender, $status){
    $where_type = ($type != 'all') ? "AND type = '$type'" : "";
    $where_company = ($company != 'all') ? "AND company = '$company'" : "";
    $where_gender = ($gender != 'all') ? "AND gender = '$gender'" : "";
    $where_status = ($status != 'all') ? "AND status = '$status'" : "";

    $conn=db();
    $sql = "SELECT * FROM visitor WHERE name <> '' $where_type $where_company $where_gender $where_status
            ORDER BY status DESC, name";
    return $conn->query($sql);
}

function addVisitor($name, $ic_number, $phone_no, $email, $reg_company, $birth_year, $gender, $type, $status){
    $company = ($reg_company == "")? "NULL":"'$reg_company'";
    $conn=db();
    $sql = "INSERT INTO visitor (name, ic_number, phone_number, email, type, company, birth_year, gender, status, created_at)
            VALUE ('$name', '$ic_number', '$phone_no', '$email', '$type', $company, '$birth_year', '$gender', '$status', CURRENT_TIMESTAMP)";
    return $conn->query($sql);
}

function updateVisitor($visitor_id, $name, $ic_number, $phone_no, $email, $reg_company, $birth_year, $gender, $type, $status){
    $company = ($reg_company == "")? "NULL":"'$reg_company'";
    $conn=db();
    $sql = "UPDATE visitor SET name = '$name', ic_number = '$ic_number', phone_number = '$phone_no', email = '$email', 
            company = $company, birth_year = '$birth_year', gender = '$gender', type = '$type', status = '$status' WHERE id = '$visitor_id'";
    return $conn->query($sql);
}

function updateStatus($visitor_id, $type){
    $conn=db();
    $sql = "UPDATE visitor SET status = '$type' WHERE id = '$visitor_id'";
    return $conn->query($sql);
}

function getVisitorListById($visitor_id){
    $conn=db();
    $sql = "SELECT * FROM visitor WHERE id = '$visitor_id'";
    return $conn->query($sql);
}

function getAttendanceListById($id){
    $conn=db();
    $sql = "SELECT * FROM visitor_attendance WHERE id = '$id' ORDER BY id DESC";
    return $conn->query($sql);
}

function getAttendanceListByVisitorId($visitor_id){
    $conn=db();
    $sql = "SELECT * FROM visitor_attendance WHERE visitor_id = '$visitor_id' ORDER BY id DESC";
    return $conn->query($sql);
}

function deleteVisitor($visitor_id){
    $conn=db();
    $sql = "DELETE FROM visitor WHERE id = '$visitor_id'";
    return $conn->query($sql);
}

function getAttendanceList($company, $start_date, $end_date){
    $where_company = ($company != 'all') ? "AND company = '$company'" : "";
    $conn=db();
    $sql = "SELECT va.*, v.name, v.ic_number, v.company FROM visitor_attendance va 
            LEFT JOIN visitor v ON va.visitor_id = v.id
            WHERE date(va.clock_in_time) BETWEEN '$start_date' AND '$end_date' $where_company ORDER BY id DESC";
    return $conn->query($sql);
}

function getVisitorInTerritory($role, $qr_location, $filter_status){
    $where_role = ($role != 'all') ? "AND role = '$role'" : "";
    $where_qr_location = ($qr_location != 'all') ? "AND clock_in_qr = '$qr_location'" : "";
    $clock_status = ($filter_status == 'clockin') ? "clock_in_time IS NOT NULL AND clock_out_time IS NULL" : "clock_in_time IS NOT NULL AND clock_out_time IS NOT NULL";
    $where_status = ($filter_status != 'all') ? "AND $clock_status" : "";
    $conn=db();
    $sql = "SELECT va.*, v.name, v.ic_number, v.company FROM visitor_attendance va 
            LEFT JOIN visitor v ON va.visitor_id = v.id
            WHERE visitor_id IS NOT NULL $where_role $where_qr_location $where_status ORDER BY id DESC";
    return $conn->query($sql);
}

function getDropdownQRLocation($name, $all = false){
    $conn = db();
    $result = $conn->query("SELECT id, cawangan_kod, name FROM lkp_location WHERE status=1");
    if ($all){
        return $result;
    }
    $txt_result = "";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[2] == $name ? 'selected':'')." value=\"".$row[2]."\">".$row[2]."</option>";
    }
    return $txt_result;
}

function getQrLocation(){
    $conn = db();
    return $conn->query("SELECT DISTINCT(clock_in_qr) AS qr_location FROM visitor_attendance WHERE clock_in_qr IS NOT NULL ORDER BY clock_in_qr ASC");
}

function addAttendance($visitor_id,$clock_in,$clock_in_location,$purpose, $role, $qr_location){
    $conn=db();
    $sql = "INSERT INTO visitor_attendance(visitor_id, role, clock_in_time, clock_in_location, clock_in_qr, reason) 
            VALUE ('$visitor_id', '$role', '$clock_in', '$clock_in_location', '$qr_location', '$purpose')";
    return $conn->query($sql);
}

function updateAttendance($id, $clock_in, $clock_in_location,$clock_in_qr, $clock_out, $clock_out_location, $clock_out_qr, $purpose, $role){
    $out_time = ($clock_out == '')?"NULL":"'$clock_out'";
    $out_location = ($clock_out_location == '')?"NULL":"'$clock_out_location'";
    $out_qr = ($clock_out_qr == '')?"NULL":"'$clock_out_qr'";
    $conn=db();
    $sql = "UPDATE visitor_attendance SET clock_in_time = '$clock_in', clock_in_location = '$clock_in_location', clock_in_qr = '$clock_in_qr', clock_out_time = $out_time,
            clock_out_location = $out_location, clock_out_qr = $out_qr, reason = '$purpose', role = '$role' WHERE id = '$id'";
    return $conn->query($sql) or die($conn->error);
}

function getVisitorByIc($ic_number){
    $conn=db();
    $sql = "SELECT id,name,status FROM visitor WHERE ic_number = '$ic_number'";
    return $conn->query($sql);
}

function updateClockOut($id, $clock_out, $clock_out_location, $clock_out_qr){
    $conn=db();
    if($clock_out == null){
        $clock_out = 'CURRENT_TIMESTAMP';
    }
    $sql = "UPDATE visitor_attendance SET clock_out_time = '$clock_out', clock_out_location = '$clock_out_location', clock_out_qr = '$clock_out_qr' WHERE id = '$id'";
    return $conn->query($sql);
}

function getTotalVisitor($type, $status = null){
    $where_status = "";
    if ($status == 'active'){
        $where_status = "AND status IN ('2')";
    }else if ($status == 'inactive'){
        $where_status = "AND status IN ('0','1')";
    }
    $conn=db();
    $sql = "SELECT COUNT(id) AS count FROM visitor WHERE type = '$type' $where_status";
    return $conn->query($sql)->fetch_object()->count;
}

function getTotalInTerritory($type_id){
    $conn=db();
    $sql = "SELECT DISTINCT(va.visitor_id) AS in_territory FROM visitor v LEFT JOIN visitor_attendance va ON va.visitor_id = v.id
            WHERE v.type = '$type_id' AND va.clock_in_time IS NOT NULL AND va.clock_out_time IS NULL";
    return $conn->query($sql)->num_rows;
    /*$sql = "SELECT DISTINCT(visitor_id) as visitor_id FROM visitor_attendance WHERE clock_in_time IS NOT NULL AND clock_out_time IS NULL";
    return $conn->query($sql)->num_rows;*/
}

/*function addVisitorAttendance($visitor_id, $role, $coordinate, $clock_in_qr, $reason){
    $conn=db();
    $sql = "INSERT INTO visitor_attendance (visitor_id, role, clock_in_time, clock_in_location, clock_in_qr, reason)
            VALUE ('$visitor_id', '$role', CURRENT_TIMESTAMP, '$coordinate', '$clock_in_qr', '$reason')";
    return $conn->query($sql);
}*/

function getVisitorLatestAttendance($visitor_id){
    $conn=db();
    $sql = "SELECT * FROM visitor_attendance WHERE visitor_id = '$visitor_id' ORDER BY id DESC LIMIT 1";
    return $conn->query($sql);
}

/*function checkOutVisitorAttendance($id, $coordinate, $clock_out_qr){
    $conn=db();
    $sql = "UPDATE visitor_attendance SET clock_out_time=CURRENT_TIMESTAMP, clock_out_location='$coordinate', clock_out_qr='$clock_out_qr' WHERE id='$id'";
    return $conn->query($sql);
}*/

function loginVisitor($email, $ic){
    $conn=db();
    $sql = "SELECT * FROM visitor WHERE email='".$email."' AND ic_number='".$ic."'";
    return $conn->query($sql);
}