<?php
include "../../lib/db/connection.php";

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
    $sql="SELECT s.id, s.no_staff, s.name, s.noic, s.role_id, s.department_id, s.department_sub, s.preferred_shift,
            w.code as shift_code, w.description as shift_description
            FROM staff s LEFT JOIN v02_workday_shift w ON w.id = s.preferred_shift
            WHERE s.id = '$staff_id'";
    return $conn->query($sql);
}

function getStaffList($company = 'AGHSB'){
    $conn=db();
    $sql="SELECT id, no_staff, name, noic, role_id, department_id, department_sub FROM staff
            WHERE status = 'BEKERJA' AND department_id = '$company' ORDER BY name";
    return $conn->query($sql);
}

function getCompany($code = ''){
    $where_company = ($code == '') ? "" : "WHERE code_department = '$code'";
    $conn=db();
    $sql = "SELECT code_department, description FROM department $where_company";
    return $conn->query($sql);
}

function secondsToTime($seconds, $twelveHourFormat = false, $includeSeconds = false){
    if ($twelveHourFormat){
        $format = $includeSeconds ? 'h:i:sA' : 'h:iA';
    }else{
        $format = $includeSeconds ? 'H:i:s' : 'H:i';
    }
    return date($format, $seconds);
}

//General Calendar submodule -------------------------------------------------------------------------------------------
function getWorkdayCalendar($year, $returnAsArray = false){
    $conn=db();
    $sql = "SELECT * FROM v02_workday_calendar WHERE YEAR(date) = '$year' ORDER BY date";
    $result = $conn->query($sql);

    if ($returnAsArray){
        $array = [];
        while ($row = $result->fetch_assoc()){
            if ($row['default'] == 1){
                $type = 'workday';
            }else{
                $type = ($row['public_holiday'] == 1) ? 'public' : 'off-day';
            }

            $array[$row['date']] = ['id' => $row['id'], 'type' => $type, 'description' => $row['description']];
        }

        return $array;
    }
    return $result;
}

function getIndividualCalendar($staff_id, $year, $returnAsArray = false){
    $conn=db();
    $sql = "SELECT w.*, c.date, c.default, c.public_holiday, c.description as workday_description, s.code as shift_code, s.description as shift_description
            FROM v02_staff_workday w
            LEFT JOIN v02_workday_calendar c ON c.id = w.date_id 
            LEFT JOIN v02_workday_shift s on w.shift_id = s.id
            WHERE YEAR(c.date) = '$year' AND staff_id = '$staff_id'
            ORDER BY c.date";
    $result = $conn->query($sql);

    if ($returnAsArray){
        $array = [];
        while ($row = $result->fetch_assoc()){
            $array[$row['date']] = $row;
        }
        return $array;
    }
    return $result;
}

function getCalendarDateId($date){
    $conn=db();
    $sql = "SELECT id FROM v02_workday_calendar WHERE date = '$date' LIMIT 1";
    return $conn->query($sql)->fetch_object()->id;
}

function insertOrUpdateWorkdayCalendarByDate($date, $default, $public, $description, $action, $session_id){
    $conn=db();
    $description = ($description == "") ? "NULL" : "'$description'";
    if ($action == 'insert'){
        $sql = "INSERT INTO v02_workday_calendar (`date`, `default`, `public_holiday`, `description`, `created_at`, `created_by`) VALUES 
                ('$date', '$default', '$public', $description, CURRENT_TIMESTAMP, '$session_id')";
    }else{
        $sql = "UPDATE v02_workday_calendar SET `default` = '$default', `public_holiday` = '$public', `description` = $description
                    WHERE `date` = '$date'";
    }

    return $conn->query($sql);
}

function insertOrUpdateIndividualCalendarByDateID($staff_id, $date_id, $shift, $workday, $description, $action, $session_id){
    $conn=db();
    $shift = ($shift == "") ? "NULL" : "'$shift'";
    $description = ($description == "") ? "NULL" : "'$description'";

    if ($action == 'insert'){
        $sql = "INSERT INTO v02_staff_workday (staff_id, date_id, shift_id, workday, description, created_at, created_by) VALUES 
                ('$staff_id', '$date_id', $shift, '$workday', $description, CURRENT_TIMESTAMP, '$session_id')";
    }else{
        $sql = "UPDATE v02_staff_workday SET shift_id = $shift, workday = '$workday', `description` = $description
                    WHERE staff_id = '$staff_id' AND date_id = '$date_id'";
    }

    return $conn->query($sql);
}

function updateIndividualCalendarDescriptionByDateID($staff_id, $date_id, $description){
    $conn=db();
    $description = ($description == "") ? "NULL" : "'$description'";
    $sql = "UPDATE v02_staff_workday SET `description` = $description
                    WHERE staff_id = '$staff_id' AND date_id = '$date_id'";
    return $conn->query($sql);
}

function getPublicHolidayByYear($year){
    $conn=db();
    $sql = "SELECT * FROM v02_workday_calendar WHERE YEAR(date) = '$year' AND public_holiday = '1'";
    return $conn->query($sql);
}

//Shift submodule ------------------------------------------------------------------------------------------------------
function getShiftTime($start_time, $work_seconds, $break_seconds, $twelveHourFormat = false, $includeSeconds = true){
    $startTimeInSeconds = strtotime($start_time);
    $endTimeInSeconds = $startTimeInSeconds + $work_seconds + $break_seconds;
    return [
        'start' => secondsToTime($startTimeInSeconds, $twelveHourFormat, $includeSeconds),
        'end' => secondsToTime($endTimeInSeconds, $twelveHourFormat, $includeSeconds),
        'work' => number_format($work_seconds / 60 / 60, 1).' hour(s)',
        'break' => number_format($break_seconds / 60 / 60, 1).' hour(s)',
    ];
}

function getShiftList($orderByColumn = 'start_time'){
    $conn=db();
    $sql="SELECT * FROM v02_workday_shift ORDER BY $orderByColumn";
    return $conn->query($sql);
}

function getShiftById($id){
    $conn=db();
    $sql = "SELECT * FROM v02_workday_shift WHERE id = '$id' LIMIT 1";
    return $conn->query($sql);
}

function insertWorkShift($code, $description, $start_time, $work_hour, $break_hour, $status){
    $conn=db();
    $sql = "INSERT INTO v02_workday_shift (code, description, start_time, work_hour, break_hour, status)
            VALUES ('$code', '$description', '$start_time', '$work_hour', '$break_hour', '$status')";
    return $conn->query($sql);
}

function updateWorkShift($id, $code, $description, $start_time, $work_hour, $break_hour, $status){
    $conn=db();
    $sql = "UPDATE v02_workday_shift SET code = '$code', description = '$description', start_time = '$start_time',
             work_hour = '$work_hour', break_hour = '$break_hour', status = '$status' WHERE id = '$id'";
    return $conn->query($sql);
}

//QR Location submodule ------------------------------------------------------------------------------------------------
function getQrBranchList(){
    return db()->query("SELECT DISTINCT(cawangan_kod) FROM lkp_location ORDER BY cawangan_kod");
}

function getQrLocationList($branch = null){
    $where_branch = ($branch != 'all') ? "WHERE cawangan_kod = '$branch'" : "";
    $conn=db();
    $sql = "SELECT * FROM lkp_location $where_branch ORDER BY cawangan_kod";
    return $conn->query($sql);
}

function insertQrLocation($branch, $name, $latitude, $longitude, $status){
    $conn=db();
    $sql = "INSERT INTO lkp_location (cawangan_kod, name, latitude, longitude, status)
            VALUES ('$branch', '$name', '$latitude', '$longitude', '$status')";
    return $conn->query($sql);
}

function updateQrLocation($id, $branch, $name, $latitude, $longitude, $status){
    $conn=db();
    $sql = "UPDATE lkp_location SET cawangan_kod = '$branch', name = '$name', latitude = '$latitude',
            longitude = '$longitude', status = '$status' WHERE id = '$id'";
    return $conn->query($sql);
}

function deleteQrLocation($id){
    $conn=db();
    $sql = "DELETE FROM lkp_location WHERE id = '$id'";
    return $conn->query($sql);
}

function getQrLocationById($id){
    $conn=db();
    $sql = "SELECT * FROM lkp_location WHERE id = '$id'";
    return $conn->query($sql);
}
// Clock-In Module
function getLkpLocation($id, $all = false){
    $conn = db();
    $result = $conn->query("SELECT cawangan_kod, name FROM lkp_location");
    if ($all){
        return $result;
    }
    $txt_result = "";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $id ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
    }
    return $txt_result;
}

function getLkpBranch($id, $all = false){
    $conn = db();
    $result = $conn->query("SELECT cawangan_kod FROM lkp_cawangan");
    if ($all){
        return $result;
    }
    $txt_result = "";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $id ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
    }
    return $txt_result;
}

function getStaffId ($ic) {
    $conn=db();
    $sql = "SELECT id FROM staff WHERE noic = '$ic'";
    return $conn->query($sql)->fetch_object()->id;
}

function addClockIn ($created_by, $staff_ic, $location_code, $clockInMethod, $location = null){ //website location = null & mobile location != null
    $conn = db();
    $current_date = date('Y-m-d');
    // get staff id
    $staff_id = getStaffId($staff_ic);

    //check same date clock in
    $existed = "SELECT COUNT(id) AS existed_data FROM v02_attendance_date 
                WHERE created_at LIKE '%$current_date%' AND staff_id = '$staff_id'";
    $existed_result = $conn->query($existed)->fetch_object()->existed_data;

    // get start time shift for that day
    $start_shift = "SELECT DATE_FORMAT(v02ws.start_time, '%H:%i') AS time FROM v02_workday_shift v02ws
                LEFT JOIN v02_staff_workday v02sw on v02ws.id = v02sw.shift_id
                LEFT JOIN v02_workday_calendar v02wc on v02wc.id = v02sw.date_id
                WHERE v02wc.date LIKE '%$current_date%' AND v02sw.staff_id = '$staff_id'";
    $shift_result = $conn->query($start_shift)->fetch_object()->time;

    // set status
    $current_time = date('H:i');
    if ($shift_result != ''){
        if ($shift_result == $current_time){
            $status = 1; //ON TIME
        } elseif ($shift_result > $current_time){
            $status = 2; //EARLY
        } elseif ($shift_result < $current_time){
            $status = 0; //LATE
        }
    } else {
        $status = 2; //EARLY DEFAULT
    }
    // AVAILABILITY (0 = OUT, 1 = IN)
    // clock in for website-manual
    if ($existed_result == '0') {
        $attendanceDateSql = "INSERT INTO v02_attendance_date(staff_id, status, branch_code, location, staff_ic, availability, created_at)
                                VALUE ('$staff_id', '$status', '$location_code', '$location', '$staff_ic', 1, CURRENT_TIMESTAMP)";

        $clockInLocation = $location ? "'$location'" : NULL;

        $conn->query($attendanceDateSql);
        $attendanceDateId = $conn->insert_id;
        $attendanceTimeSql = "INSERT INTO v02_attendance_time(attendance_date_id, clock_in_time, clock_in_method, clock_in_location, clock_in_remark, created_by) 
                                VALUE ('$attendanceDateId', CURRENT_TIMESTAMP, '$clockInMethod', ".$clockInLocation.", '$location_code', '$created_by')";
        $result = $conn->query($attendanceTimeSql); // return true or false
    } else {
        $result = 'DATA ALREADY EXIST FOR TODAY';
    }
    return $result;
}

function updateClockOut ($created_by, $staff_ic, $location_code, $clockOutMethod, $location = null) { //website location = null & mobile location != null
    $conn = db();
    $current_date = date('Y-m-d');
    // get staff id
    $staff_id = getStaffId($staff_ic);

    $existed = "SELECT COUNT(id) AS existed_data, id FROM v02_attendance_date 
                WHERE created_at LIKE '%$current_date%' AND staff_id = '$staff_id'";
    $check_id = $conn->query($existed)->fetch_object()->id;
    $existed_result = $conn->query($existed)->fetch_object()->existed_data;
    $clock_out_time = date('Y-m-d H:i:s');
    $clock_in = "SELECT v02at.attendance_date_id AS no, v02ad.status AS status, v02at.clock_in_time AS start FROM v02_attendance_date v02ad
                    LEFT JOIN v02_attendance_time v02at on v02ad.id = v02at.attendance_date_id
                    WHERE v02ad.created_at LIKE '%$current_date%' AND v02ad.staff_id = '$staff_id'";
    $attendance_id = $conn->query($clock_in)->fetch_object()->no;
    $status = $conn->query($clock_in)->fetch_object()->status;
    $start = $conn->query($clock_in)->fetch_object()->start;

    $startTime = strtotime($start);
    $endTime = strtotime($clock_out_time);
    $total_time = $endTime - $startTime;
    // AVAILABILITY (0 = OUT, 1 = IN)
    if ($existed_result == '1') {
        $attendanceDateSql = "UPDATE v02_attendance_date SET availability = 0 WHERE staff_ic = '$staff_ic' AND id = '$check_id'";
        $result1 = $conn->query($attendanceDateSql);
        $clockInLocation = $location ? "'$location'" : NULL;
        if ($result1 != ""){
            $attendanceTimeSql = "UPDATE v02_attendance_time SET clock_out_time = CURRENT_TIMESTAMP, clock_out_method = '$clockOutMethod',  
                               clock_out_location = ".$clockInLocation.", clock_out_remark = '$location_code', created_by = '$created_by', total_time = '$total_time' 
                                WHERE attendance_date_id = '$attendance_id'";
            $result = $conn->query($attendanceTimeSql);
        } else {
            $result = 'THIS DATA ALREADY CLOCK OUT FOR TODAY';
        }
    } else {
        $result = 'PLEASE CLOCK IN FIRST';
    }
    return $result;
}

function addMobilePhotoClockIn ($staff_ic, $branch_code, $remark, $location, $file){ //website location = null & mobile location != null
    $conn = db();
    $current_date = date('Y-m-d');
    // get staff id
    $staff_id = getStaffId($staff_ic);

    //check same date clock in
    $existed = "SELECT COUNT(id) AS existed_data FROM v02_attendance_date 
                WHERE created_at LIKE '%$current_date%' AND staff_id = '$staff_id'";
    $existed_result = $conn->query($existed)->fetch_object()->existed_data;

    // get start time shift for that day
    $start_shift = "SELECT DATE_FORMAT(v02ws.start_time, '%H:%i') AS time FROM v02_workday_shift v02ws
                LEFT JOIN v02_staff_workday v02sw on v02ws.id = v02sw.shift_id
                LEFT JOIN v02_workday_calendar v02wc on v02wc.id = v02sw.date_id
                WHERE v02wc.date LIKE '%$current_date%' AND v02sw.staff_id = '$staff_id'";
    $shift_result = $conn->query($start_shift)->fetch_object()->time;

    // set status
    $current_time = date('H:i');
    if ($shift_result != ''){
        if ($shift_result == $current_time){
            $status = 1; //ON TIME
        } elseif ($shift_result > $current_time){
            $status = 2; //EARLY
        } elseif ($shift_result < $current_time){
            $status = 0; //LATE
        }
    } else {
        $status = 2; //EARLY DEFAULT
    }
    // AVAILABILITY (0 = OUT, 1 = IN)
    // clock in for website-manual
    if ($existed_result == '0') {
        $sql = "INSERT INTO v02_attendance_date(staff_id, status, branch_code, location, staff_ic, availability, created_at)
            VALUE ('$staff_id', '$status', '$branch_code', '$location', '$staff_ic', 1, CURRENT_TIMESTAMP)";
        $result = $conn->query($sql);
        $newid = $conn->insert_id;
        $sql2 = "INSERT INTO v02_attendance_time(attendance_date_id, clock_in_time, clock_in_method, clock_in_location, clock_in_remark, created_by, clock_in_photo) 
                VALUE ('$newid', CURRENT_TIMESTAMP, 'PHOTO-LOG', '$location', '$remark', '$staff_id', '$file')";
        $result = $conn->query($sql2);
    } else {
        $result = 'DATA ALREADY EXIST FOR TODAY';
    }
    return $result;
}

function updateMobilePhotoClockOut ($staff_ic, $remark, $location, $file) { //website location = null & mobile location != null
    $conn = db();
    $current_date = date('Y-m-d');
    // get staff id
    $staff_id = getStaffId($staff_ic);

    $existed = "SELECT COUNT(id) AS existed_data, id FROM v02_attendance_date 
                WHERE created_at LIKE '%$current_date%' AND staff_id = '$staff_id'";
    $check_id = $conn->query($existed)->fetch_object()->id;
    $existed_result = $conn->query($existed)->fetch_object()->existed_data;
    $clock_out_time = date('Y-m-d H:i:s');
    $clock_in = "SELECT v02at.attendance_date_id AS no, v02ad.status AS status, v02at.clock_in_time AS start FROM v02_attendance_date v02ad
                    LEFT JOIN v02_attendance_time v02at on v02ad.id = v02at.attendance_date_id
                    WHERE v02ad.created_at LIKE '%$current_date%' AND v02ad.staff_id = '$staff_id'";
    $attendance_id = $conn->query($clock_in)->fetch_object()->no;
    $status = $conn->query($clock_in)->fetch_object()->status;
    $start = $conn->query($clock_in)->fetch_object()->start;

    $startTime = strtotime($start);
    $endTime = strtotime($clock_out_time);
    $total_time = $endTime - $startTime;
    // AVAILABILITY (0 = OUT, 1 = IN)
    if ($existed_result == '1') {
        $sql = "UPDATE v02_attendance_date SET availability = 0 WHERE staff_ic = '$staff_ic' AND id = '$check_id'";
        $result1 = $conn->query($sql);
        if ($result1 != ""){
            $sql2 = "UPDATE v02_attendance_time SET clock_out_time = CURRENT_TIMESTAMP, clock_out_method = 'PHOTO-LOG', clock_out_location = '$location', 
                   clock_out_remark = '$remark', created_by = '$staff_id', total_time = '$total_time', clock_out_photo = '$file' WHERE attendance_date_id = '$attendance_id'";
            $result = $conn->query($sql2);
        } else {
            $result = 'THIS DATA ALREADY CLOCK OUT FOR TODAY';
        }
    } else {
        $result = 'PLEASE CLOCK IN FIRST';
    }
    return $result;
}

function addMatricClockIn ($created_by, $file, $staff_ic){
    $conn = db();
    $current_date = date('Y-m-d');
    // get staff id
    $staff_id = getStaffId($staff_ic);

    //check same date clock in
    $existed = "SELECT COUNT(id) AS existed_data FROM v02_attendance_date 
                WHERE created_at LIKE '%$current_date%' AND staff_id = '$staff_id'";
    $existed_result = $conn->query($existed)->fetch_object()->existed_data;

    // get start time shift for that day
    $start_shift = "SELECT DATE_FORMAT(v02ws.start_time, '%H:%i') AS time FROM v02_workday_shift v02ws
                LEFT JOIN v02_staff_workday v02sw on v02ws.id = v02sw.shift_id
                LEFT JOIN v02_workday_calendar v02wc on v02wc.id = v02sw.date_id
                WHERE v02wc.date LIKE '%$current_date%' AND v02sw.staff_id = '$staff_id'";
    $shift_result = $conn->query($start_shift)->fetch_object()->time;

    // set status
    $current_time = date('H:i');
    if ($shift_result != ''){
        if ($shift_result == $current_time){
            $status = 1; //ON TIME
        } elseif ($shift_result > $current_time){
            $status = 2; //EARLY
        } elseif ($shift_result < $current_time){
            $status = 0; //LATE
        }
    } else {
        $status = 2; //EARLY DEFAULT
    }
    // clock in for website-manual
    if ($existed_result == '0') {
        $sql = "INSERT INTO v02_attendance_date(staff_id, status, staff_ic, availability, created_at)
            VALUE ('$staff_id', '$status', '$staff_ic', 1, CURRENT_TIMESTAMP)";
        $result = $conn->query($sql);
        $newid = $conn->insert_id;
        $sql2 = "INSERT INTO v02_attendance_time(created_by, attendance_date_id, clock_in_time, clock_in_method, clock_in_photo)
            VALUE ('$created_by', '$newid', CURRENT_TIMESTAMP, 'MATRIC-DIGITAL', '$file')";
        $result = $conn->query($sql2);
    } else {
        $result = 'DATA ALREADY EXIST FOR TODAY';
    }
    return $result;
}

function updateMatricClockOut ($created_by, $file, $staff_ic) {
    $conn = db();
    $current_date = date('Y-m-d');
    // get staff id
    $staff_id = getStaffId($staff_ic);

    $existed = "SELECT COUNT(id) AS existed_data, id FROM v02_attendance_date 
                WHERE created_at LIKE '%$current_date%' AND staff_id = '$staff_id'";
    $check_id = $conn->query($existed)->fetch_object()->id;
    $existed_result = $conn->query($existed)->fetch_object()->existed_data;
    $clock_out_time = date('Y-m-d H:i:s');
    $clock_in = "SELECT v02at.attendance_date_id AS no, v02ad.status AS status, v02at.clock_in_time AS start FROM v02_attendance_date v02ad
                    LEFT JOIN v02_attendance_time v02at on v02ad.id = v02at.attendance_date_id
                    WHERE v02ad.created_at LIKE '%$current_date%' AND v02ad.staff_id = '$staff_id'";
    $attendance_id = $conn->query($clock_in)->fetch_object()->no;
    $status = $conn->query($clock_in)->fetch_object()->status;
    $start = $conn->query($clock_in)->fetch_object()->start;

    $startTime = strtotime($start);
    $endTime = strtotime($clock_out_time);;
    $total_time = $endTime - $startTime;
    // AVAILABILITY (0 = OUT, 1 = IN)
    if ($existed_result == '1') {
        $sql = "UPDATE v02_attendance_date SET availability = 0 WHERE staff_ic = '$staff_ic' AND id = '$check_id'";
        $result1 = $conn->query($sql);
        if ($result1 != ""){
            $sql2 = "UPDATE v02_attendance_time SET clock_out_time = CURRENT_TIMESTAMP, clock_out_method = 'WEBSITE-DIGITAL', 
                clock_out_photo = '$file', total_time = '$total_time', created_by = '$created_by' WHERE attendance_date_id = '$attendance_id'";
            $result = $conn->query($sql2);
        } else {
            $result = 'THIS DATA ALREADY CLOCK OUT FOR TODAY';
        }
    } else {
        $result = 'PLEASE CLOCK IN FIRST';
    }
    return $result;
}

function lateExcuse ($reason, $id) {
    $conn = db();
    $sql = "UPDATE v02_attendance_date SET late_excuse = '$reason' WHERE id = '$id'";
    return $conn->query($sql);
}

function getMonthArray(){
    return [
        '01' => 'Januari', '02' => 'Februari', '03' => 'Mac',
        '04' => 'April', '05' => 'Mei', '06' => 'Jun',
        '07' => 'Julai', '08' => 'Ogos', '09' => 'September',
        '10' => 'Oktober', '11' => 'November', '12' => 'Disember',
    ];
}

function getDropDown($tablename, $value, $text, $selected, $mobile=false) {
    $conn=db();
    $sql = "SELECT ".$value.",".$text." FROM $tablename";

    $result = $conn->query($sql);

    $txt_result="";
    if($mobile){
        $i=0;
        $array = array();
        foreach ($result as $res){
            $array[$i] = $res;
            $i++;
        }
        return  $array;
    }
    while ($row  = $result -> fetch_array()){
        if ($row[0] != '' || $row[1] != '') {
            $txt_result .= "<option " . ($row[0] == $selected ? 'selected' : '') . " value=\"" . $row[0] . "\">" . $row[1] . "</option>";
        }
    }

    return $txt_result;
}

function getAttendanceMonthlyList ($month, $year, $branch, $dept) {
    $conn=db();
    $where_branch = $branch!="0" ? "AND s.cawangan_kod='$branch'" : "";
    $where_department = $dept!="0" ? "AND s.department_id='$dept'" : "";

    $sql = "SELECT s.name, s.noic, s.no_staff, v02ad.* FROM v02_attendance_date v02ad 
                LEFT JOIN staff s on v02ad.staff_ic = s.noic
                WHERE MONTH(v02ad.created_at) = '$month' AND YEAR(v02ad.created_at) = '$year'
                 $where_branch $where_department GROUP BY v02ad.staff_ic ORDER BY s.name ASC";
    return $conn->query($sql);
}

function workHourArray($ic_number, $month, $year){
    $conn = db();
    $work_hour_sum =
        $conn -> query("SELECT SUM(v02at.total_time) AS work_hour_sum FROM v02_attendance_time v02at 
                        LEFT JOIN v02_attendance_date v02ad ON v02ad.id = v02at.attendance_date_id
                        WHERE v02ad.staff_ic = '$ic_number' AND MONTH(v02ad.created_at) = '$month' AND YEAR(v02ad.created_at) = '$year'")
        ->fetch_object()->work_hour_sum; //in second
    // work hour sum for 990613035368 = 1702084724
    $work_day_count = $conn
        ->query("SELECT COUNT(v02sw.id) AS work_day_count FROM v02_staff_workday v02sw 
                            LEFT JOIN v02_workday_calendar v02wc ON v02wc.id = v02sw.date_id
                            LEFT JOIN staff s ON s.id = v02sw.staff_id
			                WHERE MONTH(v02wc.date)='$month' AND YEAR(v02wc.date)='$year'
			                AND v02wc.default ='1' AND s.noic = '$ic_number'")
        ->fetch_object()->work_day_count; // in days

    $work_hour_indicator = $work_day_count * (8 * 60 * 60); //day * 8 hours  //in second
    $work_hour_difference = $work_hour_sum - $work_hour_indicator; //in seconds

    return [
        'sum' => secondToHoursMinutesSeconds($work_hour_sum),
        'difference' => secondToHoursMinutesSeconds($work_hour_difference),
        'days' => $work_day_count,
    ];
}

function secondToHoursMinutesSeconds($seconds){
    $hours = floor($seconds / (60 * 60)); $seconds -= $hours*(60*60); // update seconds balance
    $minutes = floor($seconds / 60);
    $seconds = $seconds - ($minutes*60); // update seconds balance
    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    /*
    $hours = floor($seconds / (60 * 60)); $seconds -= $hours*(60*60); // update seconds balance
    $minutes = floor($seconds / 60);
    $seconds = $seconds - ($minutes*60); // update seconds balance
    return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);*/
}

function personalAttendanceSummary($id,$month,$year) {
    $conn=db(); 
    $sql = "SELECT status, COUNT(id) AS total FROM v02_attendance_date
				WHERE staff_id='$id' AND availability='0'
				AND MONTH(created_at)='$month' AND YEAR(created_at)='$year'
				GROUP BY status";
    $result = $conn->query($sql);

    $status_array = array();
    while ($row = $result->fetch_assoc()){
        $status_array[$row['status']] = $row['total'];
    }
    return $status_array;
}

function getAttendanceDailyList ($dateSelection, $branch, $dept) {
    $conn=db();
    $where_branch = $branch != '0' ? "AND s.cawangan_kod='$branch'" : "";
    $where_dept = $dept != '0' ? "AND s.department_id='$dept'" : "";

    $sql = "SELECT v02ad.staff_ic, v02ad.staff_id, v02ad.status, v02ad.branch_code, s.name, v02ad.id,
            v02at.clock_in_method, v02at.clock_out_method, v02at.clock_in_remark, v02at.clock_out_remark, v02at.clock_in_location,
            v02at.clock_in_time, v02at.clock_out_time, v02at.total_time,
            DATE_FORMAT(v02at.clock_in_time,'%H:%i:%s') AS time_in, DATE_FORMAT(v02at.clock_out_time,'%H:%i:%s') AS time_out
            FROM v02_attendance_date v02ad 
            LEFT JOIN v02_attendance_time v02at ON v02at.attendance_date_id = v02ad.id
            LEFT JOIN staff s ON s.noic = v02ad.staff_ic
            LEFT JOIN v02_staff_workday v02sw ON v02sw.staff_id = s.id
            LEFT JOIN v02_workday_calendar v02wc ON v02wc.id = v02sw.date_id
            WHERE DATE_FORMAT(v02ad.created_at,'%Y-%m-%d')='$dateSelection'
               $where_branch $where_dept
              GROUP BY v02ad.staff_ic ORDER BY s.name ASC";
    return $conn->query($sql);
}

function getPins($id){
    $conn=db();
    $sql = "SELECT at.clock_in_location AS lokasi_masuk, at.clock_out_location AS lokasi_keluar, at.clock_in_time AS masa_masuk, at.clock_out_time AS masa_keluar
				FROM v02_attendance_date ad 
				LEFT JOIN v02_attendance_time at ON ad.id = at.attendance_date_id
				WHERE ad.id='$id'
				";
    return $conn->query($sql);
}

function getShiftDaily($dateSelection, $staff_id){
    $conn=db();
    $sql = "SELECT v02ws.work_hour FROM v02_workday_shift v02ws 
            LEFT JOIN v02_staff_workday v02sw ON v02sw.shift_id = v02ws.id
            LEFT JOIN v02_workday_calendar v02wc ON v02wc.id = v02sw.date_id
            WHERE DATE_FORMAT(v02wc.date, '%Y-%m-%d') = '$dateSelection' AND v02sw.staff_id = '$staff_id'";
    return $conn->query($sql)->fetch_object()->work_hour;
    /*return [
        'sum' => secondToHoursMinutesSeconds($work_hour_sum),
        'difference' => secondToHoursMinutesSeconds($work_hour_difference),
    ];*/
}

function getTotalWorkHourCurrentStaff($noic){
    $conn=db();
    $sql = "SELECT MAX(v02at.id) FROM v02_attendance_time v02at
            LEFT JOIN v02_attendance_date v02ad ON v02ad.id = v02at.attendance_date_id
            WHERE DATE_FORMAT(v02at.clock_in_time,'%d-%m-%Y') IN (DATE_FORMAT(CURRENT_TIMESTAMP,'%d-%m-%Y'))
              AND v02ad.staff_ic = '$noic'";
    $id = $conn->query($sql)->fetch_object()->id;

    $sql1 = "SELECT IFNULL(MAX(id),0) AS id, clock_in_time, attendance_date_id FROM v02_attendance_time
		WHERE id='$id' AND clock_out_time IS NULL";
    $id_attendance_time = $conn->query($sql1)->fetch_object()->id;

    if($id_attendance_time>0){
        $sql2 = "SELECT TIMEDIFF(CURRENT_TIMESTAMP, clock_in_time) AS belum_kira FROM v02_attendance_time
       WHERE id='$id_attendance_time'";
        $result = $conn->query($sql2) or die($conn->error);
        return $result->fetch_object()->belum_kira;
    }else{
        return "0";
    }
}
 function getDailyReport($selected_date, $id){
     $conn=db();
     $sql = "SELECT at.*, ad.status, DATE_FORMAT(at.clock_in_time, '%d/%m/%Y') AS report_date, ad.staff_id FROM v02_attendance_time at 
             LEFT JOIN v02_attendance_date ad ON ad.id = at.attendance_date_id
             WHERE ad.staff_id = '$id' AND DATE_FORMAT(ad.created_at, '%Y-%m-%d') = '$selected_date'";
     return $conn->query($sql);
 }

 function getWorkHourReport($date, $id){
     $conn=db();
     $sql = "SELECT ws.work_hour as hour FROM v02_workday_shift ws 
             LEFT JOIN v02_staff_workday v02sw on ws.id = v02sw.shift_id
             LEFT JOIN v02_workday_calendar v02wc on v02wc.id = v02sw.date_id
             WHERE v02sw.staff_id = '$id' AND DATE_FORMAT(v02wc.date, '%Y-%m-%d') = '$date'";
     return $conn->query($sql)->fetch_object()->hour;
 }

 function getStaffName($staff_id){
     $conn=db();
     $sql = "SELECT s.*, c.nama AS cawangan, d.description AS jabatan FROM staff s
            LEFT JOIN lkp_cawangan c ON c.cawangan_kod=s.cawangan_kod
            LEFT JOIN department d ON d.code_department=s.department_id
		    WHERE s.id = '$staff_id' AND s.status = 'BEKERJA'";
     return $conn->query($sql);
 }

function getMonthlyListByStaff($id, $month, $year){
    $conn = db();
    $sql = "SELECT s.*, d.*, DATE_FORMAT(d.created_at,'%d-%m-%Y') AS date, DATE_FORMAT(d.created_at,'%Y-%m-%d') AS today,
		        DATE_FORMAT(t.clock_in_time,'%H:%i:%s') AS time_in, DATE_FORMAT(t.clock_out_time,'%H:%i:%s') AS time_out,
                t.clock_in_time, t.clock_out_time, t.total_time, t.clock_in_location, t.clock_out_location,
		        t.clock_in_remark, t.clock_out_remark
				FROM v02_attendance_date d
				LEFT JOIN staff s ON d.staff_ic = s.noic
				LEFT JOIN v02_attendance_time t ON d.id = t.attendance_date_id 
				WHERE MONTH(d.created_at) = '$month' AND YEAR(d.created_at) = '$year' AND d.staff_id = '$id'
				GROUP BY t.id desc";
    return $conn->query($sql);
}

function getAttendanceMonthlyReport($id, $month, $year){
    $conn = db();
    $sql = "SELECT s.name, DATE_FORMAT(d.created_at,'%d/%m/%Y') AS date, d.status,
            DATE_FORMAT(t.clock_in_time,'%H:%i:%s') AS time_in, DATE_FORMAT(t.clock_out_time,'%H:%i:%s') AS time_out,
            t.clock_in_time, t.clock_out_time, t.total_time, t.clock_in_location, t.clock_out_location,
            t.clock_in_remark, t.clock_out_remark, t.clock_in_method, t.clock_out_method, t.clock_in_photo, t.clock_out_photo
            FROM v02_attendance_date d
            LEFT JOIN staff s ON d.staff_id = s.id
            LEFT JOIN v02_attendance_time t ON d.id = t.attendance_date_id
            WHERE MONTH(d.created_at) = '$month' AND YEAR(d.created_at) = '$year' AND d.staff_id = '$id' AND s.status='BEKERJA'
            GROUP BY t.id desc";
    return $conn->query($sql);
}

function getElectronicTimeCardDate($id, $month, $year){
    $conn=db();
    $sql = "SELECT sw.*, shift.description AS shift_description, DATE_FORMAT(calender.date, '%W') AS day, 
            calender.date, calender.public_holiday, calender.description AS public_description
            FROM v02_staff_workday sw
            LEFT JOIN v02_workday_calendar calender ON sw.date_id = calender.id
            LEFT JOIN v02_workday_shift shift on sw.shift_id = shift.id
            WHERE MONTH(calender.date)='$month' AND YEAR(calender.date)='$year' AND sw.staff_id='$id'
            ORDER BY calender.date";
    return $conn->query($sql);
}

function getElectronicTimeCardAttendance($dateSelection, $id){
    $conn=db();
    $sql = "SELECT d.status, DATE_FORMAT(t.clock_in_time,'%H:%i:%s') AS time_in, DATE_FORMAT(t.clock_out_time,'%H:%i:%s') AS time_out,
            t.clock_in_time, t.clock_out_time, t.total_time, t.clock_in_location, t.clock_out_location,
            t.clock_in_remark, t.clock_out_remark, t.clock_in_method, t.clock_out_method
            FROM v02_attendance_date d
            LEFT JOIN staff s on d.staff_id = s.id
            LEFT JOIN v02_attendance_time t on d.id = t.attendance_date_id
            WHERE DATE_FORMAT(d.created_at,'%d-%m-%Y')=DATE_FORMAT('$dateSelection','%d-%m-%Y')
			AND d.staff_id='$id' AND s.status='BEKERJA'";
    return $conn->query($sql);
}
 function getElectronicTimeCardLeave($dateSelection, $id){
     $conn=db();
     $sql = "SELECT COUNT(l.id) AS bil, DATE_FORMAT(l.start_date, '%d/%m/%Y') AS start, DATE_FORMAT(l.end_date, '%d/%m/%Y') AS end, l.leave_type
            FROM staff s
            LEFT JOIN v02_aims_leave l ON s.id = l.staff_id
            LEFT JOIN v02_aims_leave_quota q on s.id = q.staff_id
            WHERE l.hr_checked_status = '1' AND s.status = 'BEKERJA' AND s.id='$id'
            AND '$dateSelection' BETWEEN DATE(l.start_date) AND DATE(l.end_date)";
     return $conn->query($sql);
 }

 function getLeave($dateSelection, $id){
     $conn=db();
     $sql = "SELECT l.start_date, l.end_date, l.description
            FROM staff s
            LEFT JOIN v02_aims_leave l ON s.id = l.staff_id
            LEFT JOIN v02_aims_leave_quota q on s.id = q.staff_id
            WHERE l.hr_checked_status = '1' AND s.status = 'BEKERJA' AND s.id='$id'
            AND '$dateSelection' BETWEEN DATE(l.start_date) AND DATE(l.end_date)";
     return $conn->query($sql);
 }

 function getTotalAttendance($dateSelection, $id){
     $conn=db();
     $sql = "SELECT COUNT(d.id) AS bil
            FROM v02_attendance_date d
            LEFT JOIN staff s ON d.staff_id = s.id
            LEFT JOIN v02_attendance_time t on d.id = t.attendance_date_id
            WHERE DATE_FORMAT(d.created_at, '%d-%m-%Y') = DATE_FORMAT('$dateSelection','%d-%m-%Y')
            AND d.staff_id='$id' AND s.status='BEKERJA'";
     $result = $conn->query($sql);
     return $result->fetch_object()->bil;
 }

function checkKehadiran($dateSelection,$noic) {
    $conn=db();
    $sql = "SELECT COUNT(k.id) AS bil
			FROM kehadiran k
			LEFT JOIN staff s ON k.nokp_staff=s.noic
			LEFT JOIN masa_kehadiran m ON k.id=m.id_kehadiran 
			WHERE DATE_FORMAT(k.created_date,'%d-%m-%Y')=DATE_FORMAT('$dateSelection','%d-%m-%Y')
			AND k.no_staff='$noic' AND s.status='BEKERJA'";
    $result = $conn->query($sql);
    return $result->fetch_object()->bil;
}

function getDepartmentName($department_sub){
    $conn=db();
    $sql = "SELECT description FROM department_load WHERE code_department='$department_sub'";
    return $conn->query($sql)->fetch_object()->description;
}

function getAttendanceDepartmentList ($month, $year, $branch, $dept_sub) {
    $conn=db();
    $where_branch = $branch!="0" ? "AND s.cawangan_kod='$branch'" : "";
    $where_department_sub = $dept_sub!="0" ? "AND s.department_sub='$dept_sub'" : "";

    $sql = "SELECT s.name, s.noic, s.no_staff, v02ad.* FROM v02_attendance_date v02ad 
                LEFT JOIN staff s on v02ad.staff_ic = s.noic
                WHERE MONTH(v02ad.created_at) = '$month' AND YEAR(v02ad.created_at) = '$year'
                 $where_branch $where_department_sub GROUP BY v02ad.staff_ic ORDER BY s.name ASC";
    return $conn->query($sql);
}