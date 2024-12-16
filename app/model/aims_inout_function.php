<?php

require '../../lib/db/connection.php';

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
    $result = $conn->query($sql);
    return $result;
}

function getCompanyDetails($sys_id) {
    $conn=db();
    $sql = "SELECT * FROM company WHERE sys_id='$sys_id'";
    $result = $conn->query($sql);
    return $result;
}
function addaims_inout($staff_record_id,$date_mohon,$description,$time_in,$time_out) {
    $conn=db();
    $i = 2;
    $sql = "SELECT SUM(total_take) AS total FROM aims_inout 
				WHERE staff_record_id ='$staff_record_id'
				AND MONTH(date_mohon) = MONTH('$date_mohon')
				AND YEAR(date_mohon) = YEAR('$date_mohon')";
    $total =$conn->query($sql)->fetch_object()->total;

    if ($total < $i ){
        $sql = "INSERT INTO aims_inout(staff_record_id,date_mohon,description,time_in,time_out)
		VALUES ('$staff_record_id','$date_mohon','$description','$time_in','$time_out')";
        $result = $conn->query($sql);


        $aims_inout_id=$conn -> insert_id;
        $sql = "INSERT INTO aims_inout_approve(aims_inout_id,verified,approve)
		VALUES ('$aims_inout_id','PENDING','PENDING')";
        $result = $conn->query($sql);
    }
    else {
        echo("<script LANGUAGE='JavaScript'>
					 alert('Maaf, baki INOUT anda sudah habis!');
					 window.location.href='../view/aims_inout_list.php';
				</script>");
    }
    return $result;
}
function getaims_inoutlisit($no_staff){
    $conn=db();
    $sql = "SELECT a.*,b.id AS inout_id,b.verified,b.verified_name,b.verified_date,b.approve,b.approve_name,b.approve_date
				FROM aims_inout a 
				LEFT JOIN aims_inout_approve b ON a.id = b.aims_inout_id 
				LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
				LEFT JOIN staff s ON sr.no_staff = s.no_staff
				WHERE s.no_staff ='$no_staff' 
				ORDER BY a.date_mohon DESC";
    $result = $conn->query($sql);
    return $result;
}
function getaims_inoutbyId($id){
    $conn=db();
    $sql = "SELECT * FROM aims_inout WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;
}
function updateaims_inout($date_mohon,$description,$time_in,$time_out,$id){
    $conn=db();
    $sql = "UPDATE aims_inout SET date_mohon='$date_mohon',description='$description',time_in='$time_in',time_out='$time_out' WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;
}
function deleteaims_inout($id) {
    $conn=db();
    $sql = "DELETE FROM aims_inout WHERE id='$id'";
    $conn->query($sql);

    $sql = "DELETE FROM aims_inout_approve WHERE aims_inout_id='$id'";
    return $conn->query($sql);
}
function getStaffInformation($no_staff){
    $conn=db();
    $sql = "SELECT MAX(sr.id),sr.*,sr.id AS staff_record_id,d.description AS department_name,s.alamat_tetap,s.noic,s.phone,s.email,s.alamat_surat,s.name AS staff_name, r.role, s.department_sub
                FROM staff_record sr 
                LEFT JOIN staff s ON s.no_staff=sr.no_staff 
                LEFT JOIN department d ON d.code_department=s.department_id 
                LEFT JOIN role r ON sr.peranan=r.code
                WHERE s.status = 'BEKERJA' AND s.noic IS NOT NULL 
                AND s.no_staff='$no_staff'";
    return $conn->query($sql);
}
function addaims_inout_approve($aims_inout_id,$verified,$verified_name,$verified_date,$approve,$approve_name,$approve_date) {
    $conn=db();
    $sql = "INSERT INTO aims_inout_approve(aims_inout_id,verified,verified_name,verified_date,approve,approve_name,approve_date)
		VALUES ('$aims_inout_id','$verified','$verified_name','$verified_date','$approve','$approve_name','$approve_date')";
    return $conn->query($sql);
}
function getaims_inout_approvelisit(){
    $conn=db();
    $sql = "SELECT a.*,b.id AS inout_id,b.verified,b.verified_name,b.verified_date,b.approve,b.approve_name,b.approve_date
		FROM aims_inout a 
		LEFT JOIN aims_inout_approve b ON a.id = b.aims_inout_id";
    $result = $conn->query($sql);
    return $result;
}
function getaims_inout_approvebyId($id){
    $conn=db();
    $sql = "SELECT * FROM aims_inout_approve WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;
}
function updateaims_inout_approve($aims_inout_id,$verified,$verified_name,$verified_date,$approve,$approve_name,$approve_date,$id) {
    $conn=db();
    $sql = "UPDATE aims_inout_approve SET aims_inout_id='$aims_inout_id',verified='$verified',verified_name='$verified_name',
		verified_date='$verified_date',approve='$approve',approve_name='$approve_name',approve_date='$approve_date' WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;
}
function deleteaims_inout_approve($id) {
    $conn=db();
    $sql = "DELETE FROM aims_inout_approve WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;
}



function addaims_verified_approve($aims_inout_id,$approve_name,$approve,$approve_by,$reason) {
    $conn=db();
    $sql = "UPDATE aims_inout_approve SET approve_name='$approve_name', reason='$reason',approve='$approve', approve_by='$approve_by' WHERE aims_inout_id='$aims_inout_id'";
    $result = $conn->query($sql);

    return $result;
}


function getCheckboxVerify($id,$staff_name){
    $conn=db();
    if(isset($_POST['checkbox'])){
        $checkbox = $_POST['checkbox'];
        if(isset($_POST['activate'])?$activate = $_POST["activate"]:$deactivate = $_POST["deactivate"])
            $id = "('" . implode( "','", $checkbox ) . "');" ;
        $sql="UPDATE aims_inout_approve SET verified = '".(isset($activate)?'APPROVE':'DISAPPROVE')."',verified_name='$staff_name',verified_date=CURRENT_TIMESTAMP WHERE aims_inout_id IN $id" ;
        $result=$conn->query($sql);
        return $result;
    }
}

function getCheckboxApprove($staff_name,$no_staff){
    $conn=db();
    if(isset($_POST['checkbox'])){
        $checkbox = $_POST['checkbox'];
        if(isset($_POST['activate'])?$activate = $_POST["activate"]:$deactivate = $_POST["deactivate"])
            $id = "('" . implode( "','", $checkbox ) . "');" ;
        $sql="UPDATE aims_inout_approve SET approve = '".(isset($activate)?'APPROVE':'DISAPPROVE')."',approve_name='$staff_name',approve_by='$no_staff',approve_date=CURRENT_TIMESTAMP WHERE aims_inout_id IN $id" ;
        return $conn->query($sql);
    }
    return false;
}


//support inout
function getInOutSupportList($no_staff, $verification){
    $conn=db();
    $staff = $conn->query("SELECT role_id, department_sub FROM staff WHERE no_staff = '$no_staff'")->fetch_assoc();
    $staff_role = $staff['role_id'];
    $staff_department_sub = $staff['department_sub'];

    if ($staff_role == '751206035485'){ //CEO
        $custom_condition = " AND d.no_staff = '810415035497'";

    }else if ($staff_role == 'EXECUTIVEAVSB'){ //staff resigned, may not be used
        $custom_condition = " AND d.department_sub IN ('OPERATIONFAC-AVSB', 'OPERATION-AVSB')
		                        AND d.role_id <> 'OPERATIONMANAGER'";

    }else if($staff_role == 'SUPERVISORAVSB'){
        $custom_condition = " AND d.role_id = 'EXECUTIVEAVSB'";

    }else if($staff_role == 'EXECUTIVETKSB'){
        $custom_condition = " AND d.department_sub = 'OPERATION-TKSB'";

    }else if($staff_role == 'SUPERVISORTKSB'){
        $custom_condition = " AND d.role_id = 'EXECUTIVETKSB'";

    }else if($staff_role == 'EXECUTIVE-DIRECTOR'){
        $custom_condition = " AND d.role_id = 'MANAGING-DIRECTOR'";

    }else if($staff_role == 'MANAGING-DIRECTOR'){
        $custom_condition = " AND d.role_id IN ('EXECUTIVE-DIRECTOR','HOC','OPERATIONMANAGER')";

    }else if($no_staff == '911011115100'){ //noraida syafinaz
        $custom_condition = " AND d.department_sub IN ('HR','SECRETARY-AVSB') AND d.department_id = 'AVSB'";

    }else if(in_array($staff_department_sub, ['OPERATION-AVSB', 'OPERATIONFAC-AVSB'])){
        if ($no_staff == 'INDEEP0329'){
            $custom_condition = " AND d.department_sub IN ('OPERATION-AVSB', 'OPERATIONFAC-AVSB')
			                        AND d.role_id NOT IN ('OPERATIONMANAGER', 'SUPERVISORAVSB', 'EXECUTIVEAVSB',
			                            'EXECUTIVETKSB', 'SUPERVISORTKSB' ,'EXECUTIVE-DIRECTOR', 'MANAGING-DIRECTOR')";
        }else{
            $custom_condition = " AND d.no_staff IN ('INDEEP0329')";
        }

    }else if($staff_role == 'HOD' && $staff_department_sub == 'HR'){ //HOD HR
        $custom_condition = " AND (d.department_sub = 'ECOFFICE' OR d.no_staff ='911011115100')";
    }else if(in_array($staff_role, ['HOD','STAFF', 'CONTRACT']) && in_array($staff_department_sub, ['FINACC', 'OPERATION-AGMHESB'])){
        $custom_condition = " AND d.department_sub = '$staff_department_sub'";
        if ($staff_role != 'HOD'){
            $custom_condition .= " AND d.role_id = 'HOD'";
        }
    }else if($staff_department_sub == 'HR-AGMA'){
        $custom_condition = " AND d.department_sub IN ('OPERATION-AGMSB', 'HR-AGMA')";
    }else if($no_staff == '940331025617'){
        $custom_condition = " AND d.department_sub IN ('TECHOPERATION','PILOT-BOAT','MOORING-GANG')";
    }else{
        $custom_condition = " AND d.department_sub='$staff_department_sub' 
                                AND d.department_sub NOT IN ('MANAGEMENT', 'OPERATION-AGMSB', 'HR-AGMA', 'TECHOPERATION','PILOT-BOAT','MOORING-GANG',
                                'HR','SECRETARY-AVSB', 'ECOFFICE', 'FINACC', 'OPERATION-AGMHESB', 'OPERATION-TKSB','OPERATION-AVSB', 'OPERATIONFAC-AVSB')";
    }

    $sql="SELECT a.* ,b.verified,b.verified_name,b.verified_date,b.approve,b.approve_name,b.approve_date,d.name,d.noic,d.department_id,d.department_sub,d.company_id,b.reason FROM aims_inout a
		LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
		LEFT JOIN staff_record c ON a.staff_record_id = c.id
		LEFT JOIN staff d ON c.no_staff = d.no_staff 
		WHERE d.no_staff <> '$no_staff'
		AND b.verified='$verification'
		$custom_condition
		ORDER BY a.date_mohon DESC";
    return $conn->query($sql);
}

//approve inout
function getInOutApprovalList($no_staff, $approval){
    $conn=db();
    $staff = $conn->query("SELECT role_id, department_sub FROM staff WHERE no_staff = '$no_staff'")->fetch_assoc();
    $staff_role = $staff['role_id'];

    if ($no_staff == '740915115003'){
        $custom_condition = "AND d.department_sub = 'OPERATION-AGMHESB'";
    }else if ($staff_role == 'CFO'){
        $custom_condition = "AND d.department_sub = 'FINACC'";
    }else{
        $custom_condition = "AND d.leave_approval = '$no_staff' AND d.department_sub NOT IN ('OPERATION-AGMHESB','FINACC')";
    }

    $sql = "SELECT a.* ,b.verified,b.verified_name,b.verified_date,b.approve,b.approve_name,b.approve_date,d.name,d.noic,d.department_id,d.department_sub,d.company_id,b.reason FROM aims_inout a
                LEFT JOIN aims_inout_approve b ON b.aims_inout_id = a.id
                LEFT JOIN staff_record c ON a.staff_record_id = c.id
                LEFT JOIN staff d ON c.no_staff = d.no_staff 
                WHERE b.approve='$approval'
                AND b.verified = 'APPROVE'
                $custom_condition
                ORDER BY a.date_mohon DESC";
    return $conn->query($sql);
}

function getaims_verified_approvebyId($id){
    $conn=db();
    $sql = "SELECT a.*, b.date_mohon,b.description,b.time_in,b.time_out,d.name,d.noic,d.department_id FROM aims_inout_approve a
				LEFT JOIN aims_inout b ON a.aims_inout_id = b.id
				LEFT JOIN staff_record c ON b.staff_record_id = c.id
				LEFT JOIN staff d ON c.no_staff = d.no_staff
				WHERE a.id = '$id'";
    $result = $conn->query($sql);
    return $result;
}


function aims_verified_inout($aims_inout_id,$verified_name){
    $conn=db();
    $sql = "UPDATE aims_inout_approve set verified='APPROVE', verified_date='CURRENT_TIMESTAMP',verified_name='$verified_name' WHERE aims_inout_id='$aims_inout_id'";
    $result = $conn->query($sql);
    return $result;
}

function aims_verified_inout1($aims_inout_id,$verified_name){
    $conn=db();
    $sql = "UPDATE aims_inout_approve set verified='DISAPPROVE', verified_date='CURRENT_TIMESTAMP',verified_name='$verified_name' WHERE aims_inout_id='$aims_inout_id'";
    $result = $conn->query($sql);
    return $result;
}

function getListInOut($mnt,$thn,$department_code,$department_sub) {
    $conn=db();

    if($department_code=="0"){
        $cond="";
    }else {
        $cond="AND s.department_id='$department_code'";
    }

    if ($department_sub == 'HR'){
        $sql = "SELECT a.*,b.id AS inout_id,b.verified,b.verified_name,b.verified_date,b.approve,b.approve_name,b.approve_date,s.name,s.department_sub,s.noic
			FROM aims_inout a 
			LEFT JOIN aims_inout_approve b ON a.id = b.aims_inout_id 
			LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
			LEFT JOIN staff s ON sr.no_staff = s.no_staff
			WHERE (b.approve = 'APPROVE' OR b.approve = 'CHECKED') AND DATE_FORMAT(a.date_mohon,'%m')='$mnt' AND DATE_FORMAT(a.date_mohon,'%Y')='$thn' $cond
			ORDER BY b.approve ASC, a.date_mohon DESC";
    }
    else {
        echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_hr_specialleavemessage.php';
						</script>");
    }
    $result = $conn->query($sql);

    return $result;
}
//tak guna lagi check ni
function getListInOutCheck($mnt,$thn,$department_code,$department_sub) {
    $conn=db();

    if($department_code=="0"){
        $cond="";
    }else {
        $cond="AND s.department_id='$department_code'";
    }

    if ($department_sub == 'HR'){
        $sql = "SELECT a.*,b.id AS inout_id,b.verified,b.verified_name,b.verified_date,b.approve,b.approve_name,b.approve_date,s.name,s.department_sub,s.noic
			FROM aims_inout a 
			LEFT JOIN aims_inout_approve b ON a.id = b.aims_inout_id 
			LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
			LEFT JOIN staff s ON sr.no_staff = s.no_staff
			WHERE b.approve = 'CHECKED' AND DATE_FORMAT(a.date_mohon,'%m')='$mnt' AND DATE_FORMAT(a.date_mohon,'%Y')='$thn' $cond
			ORDER BY a.date_mohon DESC";
    }
    else {
        echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_hr_specialleavemessage.php';
						</script>");
    }
    $result = $conn->query($sql);

    return $result;
}

function checkInout($id) {
    $conn=db();

    $sql = "UPDATE aims_inout_approve SET approve='CHECKED' WHERE id='$id'";

    $result = $conn->query($sql);

    return $result;
}

function getDropDownMonth($selected) {
    $conn=db();
    $sql = "SELECT MONTH(date_mohon), YEAR(date_mohon) FROM aims_inout GROUP BY MONTH(date_mohon) ORDER BY date_mohon DESC";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]." / ".$row[1]."</option>";
    }
    //$conn->close();
    return $txt_result;
}

function getListInOutprint($department_code,$month) {
    $conn=db();

    $sql = "SELECT a.*,b.id AS inout_id,b.verified,b.verified_name,b.verified_date,b.approve,b.approve_name,b.approve_date,s.name,s.department_sub,s.noic
			FROM aims_inout a 
			LEFT JOIN aims_inout_approve b ON a.id = b.aims_inout_id 
			LEFT JOIN staff_record sr ON sr.id = a.staff_record_id
			LEFT JOIN staff s ON sr.no_staff = s.no_staff
			WHERE s.department_id='$department_code'
			AND MONTH(a.date_mohon)='$month'
			AND b.approve = 'APPROVE'
			ORDER BY a.date_mohon DESC";

    $result = $conn->query($sql);

    return $result;
}

function  updateImage($id,$imgContent_doc, $document_name, $fileType) {
    $conn=db();

    $sql = "UPDATE aims_inout SET images = '$document_name', files ='$imgContent_doc', file_type ='$fileType' WHERE id ='$id'";

    $result = $conn->query($sql);
    return $result;
}

function getLampiranInfo($id) {
    $conn=db();

    $sql = "SELECT * FROM aims_inout WHERE id ='$id'";

    $result = $conn->query($sql);

    return $result;
}