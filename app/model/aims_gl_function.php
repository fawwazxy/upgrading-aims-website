<?php

require '../../lib/db/connection.php';


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
    $sql = "SELECT s.*,c.* FROM sys_setting s 
				LEFT JOIN company c ON c.sys_id = s.sys_id 
				WHERE s.sys_id='$sys_id'";
    $result = $conn->query($sql);
    return $result;
}

function getCompanyClientList($name) {
    $conn = db();
    $sql = "SELECT gl.gl_access FROM aims_access gl 
    LEFT JOIN staff s ON s.noic = gl.no_staff WHERE s.name='$name'";

    $gl_access = $conn->query($sql)->fetch_object()->gl_access;

    if ($gl_access == '1' || $gl_access == '6'){
        return $conn->query("SELECT * FROM aims_gl_client_company ORDER BY code_company ASC");
    } else {
        echo ("<script type='text/javascript'>
			window.location.href='../view/aims_gl_admin.php';
			</script>");
    }
}


function addCompanyClient($code_company,$company_name) {
    $conn = db();
    return $conn->query("INSERT INTO aims_gl_client_company (code_company,company_name) VALUE ('$code_company','$company_name')");
}

function getCLientCompanyById($id){
    $conn = db();
    return $conn->query("SELECT * FROM aims_gl_client_company WHERE id='$id'");
}

function updateClientCompany($code_company,$company_name,$status,$id) {
    $conn=db();
    $sql = "UPDATE aims_gl_client_company SET code_company='$code_company', company_name='$company_name', status='$status' WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;
}
//COMPANY CLIENT END

//JOB NUMBER START
function getJobNumberList($name) {
    $conn=db();
    $sql = "SELECT gl.gl_access FROM aims_access gl 
		LEFT JOIN staff s ON s.no_staff = gl.no_staff
		WHERE s.name='$name'";
    $gl_access=$conn->query($sql)->fetch_object()->gl_access;

    if ($gl_access == '1'){

        $sql = "SELECT * FROM aims_gl_job_no";
    }
    else {
        echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_gl_admin.php';
						</script>");
    }

    $result = $conn->query($sql);
    return $result;
}


function getJobNumberById($id){
    $conn=db();
    $sql = "SELECT * FROM aims_gl_job_no WHERE id='$id'" ;
    $result = $conn->query($sql);
    return $result;
}


function addJobNumber($company_name,$job_no) {
    $conn=db();
    $sql = "INSERT into aims_gl_job_no (company_name,job_no) values('$company_name','$job_no')";
    $result = $conn->query($sql);
    return $result;
}

function getDropDownJobNo($selected) {
    $conn=db();
    $sql = "SELECT company_name FROM aims_gl_client_company WHERE status = '1'";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
    }

    return $txt_result;
}

function updateJobNO($company_name,$job_no,$status,$id) {
    $conn=db();
    $sql = "UPDATE aims_gl_job_no SET company_name='$company_name', job_no='$job_no', status='$status' WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;
}

function getRoomList($name) {
    $conn=db();
    $sql = "SELECT gl.gl_access FROM aims_access gl 
		LEFT JOIN staff s ON s.noic = gl.no_staff
		WHERE s.name='$name'";
    $gl_access=$conn->query($sql)->fetch_object()->gl_access;

    if ($gl_access == '1'){

        $sql = "SELECT * FROM aims_gl_room";
    }
    else {
        echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_gl_admin.php';
						</script>");
    }

    $result = $conn->query($sql);
    return $result;
}

function getRoomById($id){
    $conn=db();
    $sql = "SELECT * FROM aims_gl_room WHERE id='$id'" ;
    $result = $conn->query($sql);
    return $result;
}

function addRoom($room_no,$capacity,$bed_type) {
    $conn=db();
    $sql = "INSERT into aims_gl_room (room_no,capacity,bed_type) values('$room_no','$capacity','$bed_type')";
    $result = $conn->query($sql);
    return $result;
}
function updateRoom($room_no,$capacity,$bed_type,$status,$id) {
    $conn=db();
    $sql = "UPDATE aims_gl_room SET room_no='$room_no', capacity='$capacity',bed_type='$bed_type',status='$status' WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;
}

function getDropDownRoom($selected) {
    $conn=db();
    $sql = "SELECT room_no FROM aims_gl_room WHERE status = '1'";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
    }


    return $txt_result;
}

function getBedList() {
    $conn=db();
    $sql = "SELECT bed.*,a.room_no FROM aims_gl_bed bed
		LEFT JOIN aims_gl_room a ON bed.room_id = a.id";
    $result = $conn->query($sql);
    return $result;
}

function getBedById($id){
    $conn=db();
    $sql = "SELECT bed.*,a.room_no FROM aims_gl_bed bed
		LEFT JOIN aims_gl_room a ON bed.room_id = a.room_no
		WHERE bed.id='$id'" ;
    $result = $conn->query($sql);
    return $result;
}

function addBed($room_id,$bed_no) {
    $conn=db();
    $sql = "INSERT into aims_gl_bed (room_id,bed_no) values('$room_id','$bed_no')";
    $result = $conn->query($sql);
    return $result;
}
function updateBed($room_id,$bed_no,$status,$id) {
    $conn=db();
    $sql = "UPDATE aims_gl_bed SET room_id='$room_id', bed_no='$bed_no', status='$status' WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;
}
function getLockerList() {
    $conn=db();
    $sql = "SELECT locker.*,a.room_no FROM aims_gl_locker locker
		LEFT JOIN aims_gl_room a ON locker.room_id = a.id";
    $result = $conn->query($sql);
    return $result;
}

function getLockerById($id){
    $conn=db();
    $sql = "SELECT locker.*,a.room_no FROM aims_gl_locker locker
		LEFT JOIN aims_gl_room a ON locker.room_id = a.room_no
		WHERE locker.id='$id'" ;
    $result = $conn->query($sql);
    return $result;
}

function addLocker($room_id,$locker_no) {
    $conn=db();
    $sql = "INSERT into aims_gl_locker (room_id,locker_no) values('$room_id','$locker_no')";
    $result = $conn->query($sql);
    return $result;
}
function updateLocker($room_id,$locker_no,$status,$id) {
    $conn=db();
    $sql = "UPDATE aims_gl_locker SET room_id='$room_id', locker_no='$locker_no', status='$status' WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;
}

function getAttnList() {
    $conn=db();
    $sql = "SELECT attn.*,attn.attn_name FROM aims_gl_client_attn attn
		LEFT JOIN aims_gl_client_company a ON attn.company_name = a.id";
    $result = $conn->query($sql);
    return $result;
}

function addAttn($attn_name,$company_name) {
    $conn=db();
    $sql = "INSERT into aims_gl_client_attn (attn_name,company_name) values('$attn_name','$company_name')";
    $result = $conn->query($sql);
    return $result;
}

function getDropDownClientCompany($selected) {
    $conn=db();
    $sql = "SELECT company_name FROM aims_gl_client_company WHERE status='1'";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
    }

    return $txt_result;
}

function getAttnById($id){
    $conn=db();
    $sql = "SELECT attn.*,attn.attn_name FROM aims_gl_client_attn attn
		LEFT JOIN aims_gl_client_company a ON attn.company_name = a.id
		WHERE attn.id='$id'" ;

    $result = $conn->query($sql);
    return $result;
}

function updateAttn($attn_name,$company_name,$status,$id) {
    $conn=db();
    $sql = "UPDATE aims_gl_client_attn SET attn_name='$attn_name', company_name='$company_name', status='$status' WHERE id='$id'";

    $result = $conn->query($sql);
    return $result;
}

function getHotelList() {
    $conn=db();
    $sql = "SELECT * FROM aims_gl_hotel";

    $result = $conn->query($sql);
    return $result;
}

function addHotel($hotel_name) {
    $conn=db();
    $sql = "INSERT into aims_gl_hotel (hotel_name) values('$hotel_name')";

    $result = $conn->query($sql);
    return $result;
}

function getHotelbyId($id){
    $conn=db();
    $sql = "SELECT * FROM aims_gl_hotel WHERE id='$id'";

    $result = $conn->query($sql);
    return $result;
}

function updateHotel($hotel_name,$status,$id) {
    $conn=db();
    $sql = "UPDATE aims_gl_hotel SET hotel_name='$hotel_name', status='$status' WHERE id='$id'";

    $result = $conn->query($sql);
    return $result;
}



function getClientList($name) {
    $conn=db();
    $sql = "SELECT gl.gl_access FROM aims_access gl 
		LEFT JOIN staff s ON s.noic = gl.no_staff
		WHERE s.name='$name'";
    $gl_access=$conn->query($sql)->fetch_object()->gl_access;

    if ($gl_access == '1'){
        $sql = "SELECT gl.*,cc.company_name FROM aims_gl_client gl
			LEFT JOIN aims_gl_client_company cc ON gl.client_company_id = cc.code_company
			ORDER BY gl.id DESC";
    } else {
        echo ("<script type='text/javascript'>
						window.location.href='../view/aims_gl_admin.php';
						</script>");
    }
    return $conn->query($sql);
}

function getClientById($id) {
    $conn=db();
    $sql = "SELECT gl.*,cc.company_name FROM aims_gl_client gl
	    LEFT JOIN aims_gl_client_company cc ON gl.client_company_id = cc.code_company
	    WHERE gl.id='$id'";
    $result = $conn->query($sql);
    return $result;
}

function getDropDownCompanyClient($selected) {
    $conn=db();
    $sql = "SELECT code_company,company_name FROM aims_gl_client_company WHERE status = '1'";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
    }
    //$conn->close();
    return $txt_result;
}

// function getDropDownStateClient($selected) {
// 	$conn=db();
// 	 $sql = "SELECT id,name FROM lkp_negeri";

// 	$result = $conn->query($sql);

// 	$txt_result="";
// 	while ($row  = $result -> fetch_array()){
// 		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
// 	}
// 	//$conn->close();
// 	return $txt_result;
// }

function addClient($client_name,$client_ic,$client_phone_no,$client_company_id,$client_address,$client_state,$client_city,$client_postcode,$client_car, $document_name, $document_size) {
    $conn=db();
    $sql = "INSERT INTO aims_gl_client (client_name,client_ic,client_phone_no,client_company_id,client_address,client_state,client_city,client_postcode,client_car, document_name, document_size) 
            VALUE ('$client_name','$client_ic','$client_phone_no','$client_company_id','$client_address','$client_state','$client_city','$client_postcode','$client_car', '$document_name', '$document_size')";
    return $conn->query($sql);
}

function UpdateClient($client_name,$client_ic,$client_phone_no,$client_company_id,$client_address,$client_state,$client_city,$client_postcode,$client_car,$id) {
    $conn=db();
    $sql = "UPDATE aims_gl_client SET client_name = '$client_name', client_ic = '$client_ic', client_phone_no = '$client_phone_no', client_company_id = '$client_company_id', client_address = '$client_address', client_state = '$client_state', client_city = '$client_city', client_postcode = '$client_postcode', client_car = '$client_car' WHERE id = '$id'";
    $result = $conn->query($sql);
    return $result;
}

function getAttachment($id){
    $conn = db();
    $sql = "SELECT document_name FROM aims_gl_client WHERE id = '$id'";
    return $conn->query($sql)->fetch_object()->document_name;
}

function updateAttachment($id,$document_name,$document_size){
    $conn = db();
    $sql = "UPDATE aims_gl_client SET document_name = '$document_name', document_size = '$document_size' WHERE id = '$id'";
    return $conn->query($sql);
}

function getBookingListCheckIn($name) {
    $conn=db();
    $sql = "SELECT gl.gl_access FROM aims_access gl 
	LEFT JOIN staff s ON s.noic = gl.no_staff WHERE s.name = '$name'";

    $gl_access=$conn->query($sql)->fetch_object()->gl_access;

    if ($gl_access == '1' || $gl_access == '6'){

        $sql = "SELECT gl.*,a.client_name,a.client_ic,a.client_address,a.client_state,a.client_city,a.client_postcode,a.client_car,a.client_phone_no,cc.company_name
		FROM aims_gl_booking gl
		LEFT JOIN aims_gl_client a ON gl.client_id = a.id
		LEFT JOIN aims_gl_client_company cc ON a.client_company_id = cc.code_company
		WHERE gl.status = '1' ORDER BY pic_indate DESC";
    }
    else {
        echo ("<script LANGUAGE='JavaScript'>
			window.location.href='../view/aims_gl_admin.php';
			</script>");
    }

    $result = $conn->query($sql);
    return $result;
}

function getBookingListCheckout($name) {
    $conn=db();
    $sql = "SELECT gl.gl_access FROM aims_access gl 
	LEFT JOIN staff s ON s.noic = gl.no_staff WHERE s.name = '$name'";
    $gl_access=$conn->query($sql)->fetch_object()->gl_access;

    if ($gl_access == '1' || $gl_access == '6'){

        $sql = "SELECT gl.*,a.client_name,a.client_ic,a.client_address,a.client_state,a.client_city,a.client_postcode,a.client_car,a.client_phone_no,cc.company_name
		FROM aims_gl_booking gl
		LEFT JOIN aims_gl_client a ON gl.client_id = a.id
		LEFT JOIN aims_gl_client_company cc ON a.client_company_id = cc.code_company
		WHERE gl.status = '0' ORDER BY pic_indate DESC";
    }
    else {
        echo ("<script LANGUAGE='JavaScript'>
			window.location.href='../view/aims_gl_admin.php';
			</script>");
    }

    $result = $conn->query($sql);
    return $result;
}

function getBookingListCancel($name) {
    $conn=db();
    $sql = "SELECT gl.gl_access FROM aims_access gl 
	LEFT JOIN staff s ON s.noic = gl.no_staff WHERE s.name = '$name'";
    $gl_access=$conn->query($sql)->fetch_object()->gl_access;

    if ($gl_access == '1' || $gl_access == '6'){

        $sql = "SELECT gl.*,a.client_name,a.client_ic,a.client_address,a.client_state,a.client_city,a.client_postcode,a.client_car,a.client_phone_no,cc.company_name
		FROM aims_gl_booking gl
		LEFT JOIN aims_gl_client a ON gl.client_id = a.id
		LEFT JOIN aims_gl_client_company cc ON a.client_company_id = cc.code_company
		WHERE gl.status = '2' ORDER BY pic_indate DESC";
    }
    else {
        echo ("<script LANGUAGE='JavaScript'>
			window.location.href='../view/aims_gl_admin.php';
			</script>");
    }

    $result = $conn->query($sql);
    return $result;
}

function getBookingById($id){
    $conn=db();
    $sql = "SELECT gl.*,a.client_name,a.client_ic,a.client_address,a.client_state,a.client_city,a.client_postcode,a.client_car,a.client_phone_no,cc.company_name FROM aims_gl_booking gl
				LEFT JOIN aims_gl_client a ON gl.client_id = a.id
				LEFT JOIN aims_gl_client_company cc ON a.client_company_id = cc.code_company
				WHERE gl.id='$id'";
    $result = $conn->query($sql);
    return $result;
}

function addBooking($client_id, $arrival_date, $arrival_time, $departure_date, $departure_time, $room_id, $locker_id, $bed_id,$pic_cin) {
    $conn=db();
    $sql = "INSERT into aims_gl_booking (client_id, arrival_date, arrival_time, departure_date, departure_time, room_id, locker_id, bed_id, pic_cin) 

		values('$client_id','$arrival_date','$arrival_time','$departure_date','$departure_time','$room_id','$locker_id','$bed_id','$pic_cin')";
    $result = $conn->query($sql);

    $sql = "UPDATE aims_gl_locker SET status='0' WHERE locker_no='$locker_id'";
    $result = $conn->query($sql);

    $sql = "UPDATE aims_gl_bed SET status='0' WHERE bed_no='$bed_id'";
    $result = $conn->query($sql);

    $sql = "SELECT SUM(status) as total FROM aims_gl_bed WHERE room_id = '$room_id'";

    $total = $conn->query($sql)->fetch_object()->total;

    if ($total == '0'){
        $sql = "UPDATE aims_gl_room SET status='0' WHERE room_no = '$room_id'";
        $result = $conn->query($sql);
    }
    return $result;
}
function updateBooking($arrival_date, $arrival_time, $departure_date, $departure_time, $room_id, $locker_id, $bed_id, $id) {
    $conn=db();
    $sql = "UPDATE aims_gl_booking
		SET
		arrival_date='$arrival_date', arrival_time='$arrival_time', departure_date='$departure_date', departure_time='$departure_time', room_id='$room_id', locker_id='$locker_id', bed_id='$bed_id'
		WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;
}

function checkout($id,$pic_cout,$room_id){
    $conn=db();
    $sql = "UPDATE aims_gl_booking gl
		LEFT JOIN aims_gl_bed b ON gl.bed_id=b.bed_no
		LEFT JOIN aims_gl_locker l ON gl.locker_id=l.locker_no
		SET gl.status='0',gl.pic_outdate=CURRENT_TIMESTAMP,
		gl.pic_cout='$pic_cout',b.status='1',l.status='1' WHERE gl.id='$id'";
    $result = $conn->query($sql);

    $sql = "SELECT SUM(status) as total FROM aims_gl_bed WHERE room_id = '$room_id'";

    $total = $conn->query($sql)->fetch_object()->total;

    if ($total > '0'){
        $sql = "UPDATE aims_gl_room SET status ='1' WHERE room_no='$room_id'";
        $result = $conn->query($sql);
    }
    return $result;
}

function cancelBooking($id,$room_id){
    $conn=db();
    $sql="UPDATE aims_gl_booking gl
       LEFT JOIN aims_gl_bed b ON gl.bed_id=b.bed_no
       LEFT JOIN aims_gl_locker l ON gl.locker_id=l.locker_no
       SET gl.status='2',b.status='1',l.status='1' WHERE gl.id='$id'";
    $result=$conn->query($sql);
    $sql = "SELECT SUM(status) as total FROM aims_gl_bed WHERE room_id = '$room_id'";

    $total = $conn->query($sql)->fetch_object()->total;

    if ($total > '0'){
        $sql = "UPDATE aims_gl_room SET status ='1' WHERE room_no='$room_id'";
        $result = $conn->query($sql);
    }
    return $result;
}

function deleteBooking($id,$room_id,$bed_id,$locker_id){
    $conn=db();
    $sql = "DELETE FROM aims_gl_booking WHERE id='$id'";
    $result = $conn->query($sql);

    $sql = "UPDATE aims_gl_locker SET status='1' WHERE locker_no='$locker_id'";
    $result = $conn->query($sql);

    $sql = "UPDATE aims_gl_bed SET status='1' WHERE bed_no='$bed_id'";
    $result = $conn->query($sql);

    $sql = "SELECT SUM(status) as total FROM aims_gl_bed WHERE room_id = '$room_id'";

    $total = $conn->query($sql)->fetch_object()->total;

    if ($total > '0'){
        $sql = "UPDATE aims_gl_room SET status='1' WHERE room_no = '$room_id'";
        $result = $conn->query($sql);
    }
    return $result;
}

function getBookingFormPrintById($id) {
    $conn=db();
    $sql = "SELECT gl.*,a.client_name,a.client_ic,a.client_address,a.client_state,a.client_city,a.client_postcode,a.client_car,a.client_phone_no,cc.company_name FROM aims_gl_booking gl
				LEFT JOIN aims_gl_client a ON gl.client_id = a.id
				LEFT JOIN aims_gl_client_company cc ON a.client_company_id = cc.code_company
				WHERE gl.id='$id'";
    $result = $conn->query($sql);
    return $result;
}

function verifiedKey($id,$key_by){
    $conn=db();
    $sql = "UPDATE aims_gl_booking SET key_status = 'VERIFIED', key_by = '$key_by', key_date = CURRENT_TIMESTAMP WHERE id='$id'";
    return $conn->query($sql);
}

//BOOKING PART END

//AUTHORIZATION PART START
function getAuthoList($name) {
    $conn=db();
    $sql = "SELECT gl.gl_access FROM aims_access gl 
	LEFT JOIN staff s ON s.noic = gl.no_staff
	WHERE s.name='$name'";
    $gl_access=$conn->query($sql)->fetch_object()->gl_access;

    if ($gl_access == '1' || $gl_access == '6'){

        $sql = "SELECT gl.gl_access,gl.no_staff FROM aims_access gl 
	LEFT JOIN aims_gl_client a ON a.id = gl.id
	LEFT JOIN aims_gl_booking c ON c.client_id = c.client_id
	WHERE a.client_name='$name";
    }
    else {
        echo ("<script LANGUAGE='JavaScript'>
			window.location.href='../view/aims_gl_admin.php';
			</script>");
    }


    $result = $conn->query($sql);
    return $conn->query($sql);
}


function getAuthorizeNew() {
    $conn=db();
    $sql = "SELECT a.client_name,a.client_ic,a.client_phone_no, cc.*
	FROM aims_gl_booking cc
	LEFT JOIN aims_gl_client a ON cc.client_id = a.id
	WHERE cc.autho_status = 'PENDING'
	ORDER BY cc.pic_indate DESC";
    return $conn->query($sql);
}

function getAuthorizeDone() {
    $conn=db();
    $sql = "SELECT a.client_name,a.client_ic,a.client_phone_no, cc.*
	FROM aims_gl_booking cc
	LEFT JOIN aims_gl_client a ON cc.client_id = a.id
	WHERE cc.autho_status = 'AUTHORIZE'
	ORDER BY cc.autho_date DESC";
    return $conn->query($sql);
}

function AuthorizedBooking($id,$autho_by){
    $conn=db();
    $sql = "UPDATE aims_gl_booking SET autho_status = 'AUTHORIZE', autho_by = '$autho_by', autho_date = CURRENT_TIMESTAMP WHERE id='$id'";
    return $conn->query($sql);
}
//AUTHORIZATION PART END
// function getDropDownRoomBookingUpdate($selected) {
// 	$conn=db();
// 	 $sql = "SELECT room_no FROM aims_gl_room";

// 	$result = $conn->query($sql);

// 	$txt_result="";
// 	while ($row  = $result -> fetch_array()){
// 		$txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
// 	}


// 	return $txt_result;
// }

// function getDropDownLockerBookingUpdate($selected) {
// 	$conn=db();
// 	 $sql = "SELECT id,locker_no FROM aims_gl_locker";

// 	$result = $conn->query($sql);

// 	$txt_result="";
// 	while ($row  = $result -> fetch_array()){
// 		$txt_result .= "<option ".($row[1] == $selected ? 'selected':'')." value=\"".$row[1]."\">".$row[1]."</option>";
// 	}


// 	return $txt_result;
// }

// function getDropDownBedBookingUpdate($selected) {
// 	$conn=db();
// 	 $sql = "SELECT id,bed_no FROM aims_gl_bed";

// 	$result = $conn->query($sql);

// 	$txt_result="";
// 	while ($row  = $result -> fetch_array()){
// 		$txt_result .= "<option ".($row[1] == $selected ? 'selected':'')." value=\"".$row[1]."\">".$row[1]."</option>";
// 	}


// 	return $txt_result;
// }

// function getClientList() {
// 	$conn=db();
// 	$sql = "SELECT gl.*,a.name FROM aims_gl_client gl
// 	LEFT JOIN lkp_negeri a ON gl.client_state = a.id";
// 	$result = $conn->query($sql);
// 	return $result;
// }

// function getClientById($id) {
// 	$conn=db();
//     $sql = "SELECT gl.*,a.name FROM aims_gl_client gl
//     LEFT JOIN lkp_negeri a ON gl.client_state = a.id WHERE gl.id='$id'";
// 	$result = $conn->query($sql);
// 	return $result;
// }

//EXCHANGE ROOM PART START
function getExById($id){
    $conn=db();
    $sql = "SELECT ex.*,a.client_name,cc.company_name,a.client_ic,a.client_phone_no
				FROM aims_gl_booking ex
				LEFT JOIN aims_gl_client a ON ex.client_id = a.id
				LEFT JOIN aims_gl_client_company cc ON a.client_company_id = cc.code_company
				WHERE ex.id = '$id'";
    $result = $conn->query($sql);
    return $result;
}
// function getRoomReservList($month){
// 	$conn=db();
// 	$sql = "SELECT rr.ref_no,rr.attend,a.*,b.client_name,b.client_company,b.client_ic,c.room_no,d.bed_no
// 	FROM aims_gl_room_reservation rr
// 	LEFT JOIN aims_gl_booking a ON rr.booking_id = a.id
// 	LEFT JOIN aims_gl_client b ON a.client_id = b.id
// 	LEFT JOIN aims_gl_room c ON a.room_id = c.id
// 	LEFT JOIN aims_gl_bed d ON a.bed_id = d.id
// 	WHERE MONTH(rr.reserv_date) = '$month'";
// 			$result = $conn->query($sql);
// 			return $result;
// }

function getExchangeList($month){
    $conn=db();
    $sql = "SELECT ex.id,ex.er_no,ex.reason,ex.date_change,ex.room_pass,ex.bed_pass,ex.locker_pass,a.client_id,a.room_id,a.bed_id,a.locker_id,a.arrival_date,a.arrival_time,a.departure_date,a.departure_time,a.pic_cin,a.pic_indate,a.pic_cout,a.pic_outdate,b.client_name,b.client_company_id,b.client_ic,b.client_phone_no
				FROM aims_gl_exchange ex
				LEFT JOIN aims_gl_booking a ON ex.booking_id = a.id
				LEFT JOIN aims_gl_client b ON a.client_id = b.id
				WHERE MONTH(ex.date_change) = '$month'";
    $result = $conn->query($sql);
    return $result;
}

function getRoomExchangePrint($month){
    $conn=db();
    $sql = "SELECT ex.er_no,ex.room_pass,ex.bed_pass,ex.locker_pass,ex.reason,ex.date_change,ex.room_id,ex.bed_id,ex.locker_id,a.id,b.client_name,b.client_company_id,b.client_ic,b.client_phone_no
		FROM aims_gl_exchange ex 
		LEFT JOIN aims_gl_booking a ON ex.booking_id = a.id 
		LEFT JOIN aims_gl_client b ON a.client_id = b.id
		WHERE MONTH(ex.date_change) = '$month'";
    $result = $conn->query($sql);
    return $result;
}
//belum ubah
function getExchangeFormPrintById($id) {
    $conn=db();
    $sql = "SELECT ex.*,a.client_name,a.client_ic,cc.company_name,a.client_phone_no,b.room_no,c.bed_no,d.locker_no
FROM aims_gl_exchange ex
LEFT JOIN aims_gl_booking gl ON ex.booking_id = gl.id
LEFT JOIN aims_gl_client a ON gl.client_id = a.id
LEFT JOIN aims_gl_client_company cc ON a.client_company_id = cc.code_company
LEFT JOIN aims_gl_room b ON ex.room_id = b.id
LEFT JOIN aims_gl_bed c ON ex.bed_id = c.id
LEFT JOIN aims_gl_locker d ON ex.locker_id = d.id
WHERE ex.id='$id'";
    $result = $conn->query($sql);
    return $result;
}

function getDropDownMonthExchange($selected) {
    $conn=db();
    $sql = "SELECT MONTH(date_change), YEAR(date_change) FROM aims_gl_exchange GROUP BY MONTH(date_change) ORDER BY date_change DESC";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]." / ".$row[1]."</option>";
    }
    //$conn->close();
    return $txt_result;
}

function getDropDownState($selected) {
    $conn=db();
    $sql = "SELECT id,name FROM lkp_negeri ORDER BY name";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[1] == $selected ? 'selected':'')." value=\"".$row[1]."\">".$row[1]."</option>";
    }


    return $txt_result;
}

function getDropDownRoom2($selected) {
    $conn=db();
    $sql = "SELECT id,room_no FROM aims_gl_room WHERE status = '1'";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[1] == $selected ? 'selected':'')." value=\"".$row[1]."\">".$row[1]."</option>";
    }


    return $txt_result;
}

function getDropDownLocker($selected) {
    $conn=db();
    $sql = "SELECT id,locker_no FROM aims_gl_locker WHERE status = '1' ORDER BY id";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[1] == $selected ? 'selected':'')." value=\"".$row[1]."\">".$row[1]."</option>";
    }


    return $txt_result;
}

function getDropDownBed($selected) {
    $conn=db();
    $sql = "SELECT id,bed_no FROM aims_gl_bed WHERE status = '1'";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[1] == $selected ? 'selected':'')." value=\"".$row[1]."\">".$row[1]."</option>";
    }


    return $txt_result;
}



function addExchange($booking_id, $er_no, $room_pass, $bed_pass, $locker_pass, $room_id, $bed_id, $locker_id, $reason, $date_change, $action_by) {
    $conn=db();
    $sql = "INSERT into aims_gl_exchange (booking_id, er_no, room_pass, bed_pass, locker_pass, room_id, bed_id, locker_id, reason, date_change, action_by)
				values ('$booking_id','$er_no','$room_pass','$bed_pass','$locker_pass','$room_id','$bed_id','$locker_id','$reason','$date_change','$action_by')";
    $result = $conn->query($sql);
    $sql2 = "UPDATE aims_gl_booking SET room_id='$room_id',bed_id='$bed_id',locker_id='$locker_id' WHERE id='$booking_id'";
    $result = $conn->query($sql2);
    return $result;
}
//EXCHANGE ROOM PART END

//ROOM RESERVATION PART START
function getRoomReservById($id){
    $conn=db();
    $sql = "SELECT rr.arrival_date,rr.departure_date,a.client_name,a.client_ic,cc.company_name 
		FROM aims_gl_booking rr 
		LEFT JOIN aims_gl_client a ON rr.client_id = a.id
		LEFT JOIN aims_gl_client_company cc ON a.client_company_id = cc.code_company
		WHERE rr.id = '$id'";
    $result = $conn->query($sql);
    return $result;
}

function convertDigitToTwoDigit($number){
    $month = array(
        "1" => "01", "2" => "02","3" => "03", "4" => "04","5" => "05", "6" => "06",
        "7" => "07", "8" => "08","9" => "09", "10" => "10","11" => "11", "12" => "12",
    );
    return $month[$number];
}

function getRoomReservList($month,$year){
    $month_digit = ($month == 0) ? "" : convertDigitToTwoDigit($month);
    $conn=db();
    $sql = "SELECT rr.id,rr.ref_no,rr.attend,a.client_id,a.room_id,a.bed_id,a.locker_id,a.arrival_date,a.arrival_time,a.departure_date,a.departure_time,a.pic_cin,a.pic_indate,a.pic_cout,a.pic_outdate,b.client_name,b.client_company_id,b.client_ic
		FROM aims_gl_room_reservation rr 
		LEFT JOIN aims_gl_booking a ON rr.booking_id = a.id 
		LEFT JOIN aims_gl_client b ON a.client_id = b.id 
		WHERE rr.reserv_date LIKE '$year-$month_digit%'";
    return $conn->query($sql);
}

function getRoomReservListPrint($month,$year){
    $month_digit = ($month == 0) ? "" : convertDigitToTwoDigit($month);
    $conn=db();
    $sql = "SELECT rr.ref_no,rr.attend,rr.reserv_date,a.*,b.client_name,b.client_company_id,b.client_ic,c.room_no,d.bed_no 
		FROM aims_gl_room_reservation rr 
		LEFT JOIN aims_gl_booking a ON rr.booking_id = a.id 
		LEFT JOIN aims_gl_client b ON a.client_id = b.id 
		LEFT JOIN aims_gl_room c ON a.room_id = c.id 
		LEFT JOIN aims_gl_bed d ON a.bed_id = d.id
		WHERE rr.reserv_date LIKE '$year-$month_digit%'";
    return $conn->query($sql);
}

function AddRoomReserv($booking_id,$ref_no, $reserv_date, $to, $fax, $attend, $client_company_id,$arrival_date,$room_id,$bed_id,$confirm_by,$confirm_company){
    $conn=db();
    $sql = "INSERT into aims_gl_room_reservation (booking_id,ref_no, reserv_date, to_gl, fax, attend, client_company_id, confirm_by, confirm_company)
	values ('$booking_id','$ref_no','$reserv_date','$to','$fax','$attend','$client_company_id','$confirm_by','$confirm_company')";
    $result = $conn->query($sql);

    $sql = "INSERT INTO aims_gl_expenses (booking_id,ref_no,arrival_date,room_id,bed_id)
	VALUES ('$booking_id','$ref_no','$arrival_date','$room_id','$bed_id')";
    $result = $conn->query($sql);
    return $result;
}

function getRoomReservUpdateById($id){
    $conn=db();
    $sql = "SELECT * FROM aims_gl_room_reservation
		WHERE id = '$id'";
    $result = $conn->query($sql);
    return $result;
}

function updateRoomReserv($id,$ref_no, $reserv_date){
    $conn=db();
    $sql = "UPDATE aims_gl_room_reservation SET ref_no='$ref_no',reserv_date='$reserv_date' WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;
}

function deleteRoomReservation($id){
    $conn=db();
    $sql = "DELETE FROM aims_gl_room_reservation WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;
}


function getDropDownRefNo($selected) {
    $conn=db();
    $sql = "SELECT ref_no FROM aims_gl_room_reservation GROUP BY ref_no ORDER BY ref_no DESC";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
    }
    //$conn->close();
    return $txt_result;
}

function getReservByReff($ref_no){
    $conn=db();
    $sql = "SELECT rr.ref_no,rr.attend, rr.reserv_date, rr.to_gl, rr.fax,a.*,b.client_name,cc.company_name,b.client_ic,c.room_no,d.bed_no 
		FROM aims_gl_room_reservation rr 
		LEFT JOIN aims_gl_booking a ON rr.booking_id = a.id 
		LEFT JOIN aims_gl_client b ON a.client_id = b.id
		LEFT JOIN aims_gl_client_company cc ON b.client_company_id = cc.code_company
		LEFT JOIN aims_gl_room c ON a.room_id = c.id 
		LEFT JOIN aims_gl_bed d ON a.bed_id = d.id
		WHERE rr.ref_no = '$ref_no' GROUP BY rr.ref_no = '$ref_no'";
    $result = $conn->query($sql);
    return $result;
}
function getReservByRef($ref_no){
    $conn=db();
    $sql = "SELECT rr.ref_no,rr.attend, rr.reserv_date, rr.to_gl, rr.fax,a.*,b.client_name,b.client_company_id,b.client_ic,c.room_no,d.bed_no 
		FROM aims_gl_room_reservation rr 
		LEFT JOIN aims_gl_booking a ON rr.booking_id = a.id 
		LEFT JOIN aims_gl_client b ON a.client_id = b.id 
		LEFT JOIN aims_gl_room c ON a.room_id = c.id 
		LEFT JOIN aims_gl_bed d ON a.bed_id = d.id
		WHERE rr.ref_no = '$ref_no'";
    $result = $conn->query($sql);
    return $result;
}

function getReservByRefs($ref_no){
    $conn=db();
    $sql = "SELECT rr.ref_no,rr.attend, rr.reserv_date, rr.to_gl, rr.fax,rr.confirm_by,rr.confirm_company,rr.confirm_date,rr.applicant_by,rr.applicant_company,rr.applicant_date,a.*,b.client_name,b.client_company_id,b.client_ic,c.room_no,d.bed_no 
	FROM aims_gl_room_reservation rr 
	LEFT JOIN aims_gl_booking a ON rr.booking_id = a.id 
	LEFT JOIN aims_gl_client b ON a.client_id = b.id 
	LEFT JOIN aims_gl_room c ON a.room_id = c.id 
	LEFT JOIN aims_gl_bed d ON a.bed_id = d.id
	WHERE rr.ref_no = '$ref_no' GROUP BY rr.ref_no = '$ref_no'";
    $result = $conn->query($sql);
    return $result;
}

function getRoomReservPrintById($id) {
    $conn=db();
    $sql = "SELECT rr.*,a.arrival_date,a.departure_date,b.client_name,b.client_company_id,b.client_ic
		FROM aims_gl_room_reservation rr 
		LEFT JOIN aims_gl_booking a ON rr.booking_id = a.id 
		LEFT JOIN aims_gl_client b ON a.client_id = b.id 
		WHERE b.id='$id'";
    $result = $conn->query($sql);
    return $result;
}

function getDropDownMonth($selected) {
    $conn=db();
    $sql = "SELECT month_num, month_description FROM aims_month ORDER BY month_num ASC";
    $result = $conn->query($sql);

    $txt_result="<option ".(0 == $selected ? 'selected':'')." value='0'>-- Choose Month --</option>";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
    }
    return $txt_result;
}


function getDropDownYear($selected) {
    /*$conn=db();
    $sql = "SELECT YEAR(reserv_date) FROM aims_gl_room_reservation GROUP BY YEAR(reserv_date) ORDER BY reserv_date DESC";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
    }
    return $txt_result;*/

    $year_option="";
    $yearNow = date("Y");
    for ($i=0; $i<3; $i++){
        $year = $yearNow - $i;
        $opt_selected = ($year == $selected) ? 'selected' : '';
        $year_option.= "<option value='".$year."' ".$opt_selected.">".$year."</option>";
    }
    return $year_option;
}
//ROOM RESERVATION PART END

// Applicant section
function getRoomReservAppListPending(){
    $conn=db();
    $sql = "SELECT rr.id,rr.ref_no,rr.client_company_id,rr.booking_id,rr.applicant_by,rr.applicant_company,rr.applicant_date,rr.applicant_status
	FROM aims_gl_room_reservation rr
	LEFT JOIN aims_gl_booking b ON rr.booking_id = b.id
	WHERE rr.applicant_status = '0'
	GROUP BY rr.ref_no ORDER BY rr.reserv_date DESC ";
    $result = $conn->query($sql);
    return $result;
}

function getRoomReservAppListDone(){
    $conn=db();
    $sql = "SELECT rr.id,rr.ref_no,rr.client_company_id,rr.booking_id,rr.applicant_by,rr.applicant_company,rr.applicant_date,rr.applicant_status
	FROM aims_gl_room_reservation rr
	LEFT JOIN aims_gl_booking b ON rr.booking_id = b.id
	WHERE rr.applicant_status = '1'
	GROUP BY rr.ref_no ORDER BY rr.reserv_date DESC";
    $result = $conn->query($sql);
    return $result;
}


function getInfoApp($ref_no){
    $conn=db();
    $sql = "SELECT r.ref_no,r.client_company_id
	FROM aims_gl_room_reservation r
	WHERE r.ref_no = '$ref_no'
	GROUP BY r.ref_no
	";
    $result = $conn->query($sql);
    return $result;
}

function getStaffApp($ref_no,$client_company_id){
    $conn=db();
    $sql = "SELECT DISTINCT(r.ref_no),cc.company_name,b.arrival_date,b.departure_date,c.client_name,c.client_ic
	FROM aims_gl_room_reservation r 
	LEFT JOIN aims_gl_booking b ON b.id = r.booking_id
	LEFT JOIN aims_gl_client c ON b.client_id = c.id
	LEFT JOIN aims_gl_client_company cc ON c.client_company_id = cc.id
	WHERE r.ref_no = '$ref_no'
	GROUP BY c.client_name
	ORDER BY r.reserv_date DESC
	
	";
    $result = $conn->query($sql);
    return $result;
}

function getAppName($id){
    $conn=db();
    $sql = "SELECT id,applicant_by,applicant_company
	FROM aims_gl_room_reservation
	WHERE id='$id';
	";
    $result = $conn->query($sql);
    return $result;
}

function ApplicantConfirm($id,$applicant_by,$applicant_company){
    $conn=db();
    $sql = "UPDATE aims_gl_room_reservation
	SET applicant_by='$applicant_by',applicant_company='$applicant_company',applicant_date=CURRENT_TIMESTAMP, applicant_status='1' WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;
}
//APPLICANT SECTION END

function getItemList() {
    $conn=db();
    $sql = "SELECT * FROM aims_gl_item";
    $result = $conn->query($sql);
    return $result;
}

function getItemById($id){
    $conn=db();
    $sql = "SELECT * FROM aims_gl_item WHERE id='$id'" ;
    $result = $conn->query($sql);
    return $result;
}

function addItem($item, $penalty) {
    $conn=db();
    $sql = "INSERT into aims_gl_item (item,penalty) values('$item','$penalty')";
    $result = $conn->query($sql);
    return $result;
}

function updateItem($item,$penalty,$id) {
    $conn=db();
    $sql = "UPDATE aims_gl_item SET item='$item', penalty='$penalty' WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;
}

function getLostItemList() {
    $conn=db();
    $sql = "SELECT * FROM aims_gl_lost_item";
    $result = $conn->query($sql);
    return $result;
}

function getLostItemById($id){
    $conn=db();
    $sql = "SELECT * FROM aims_gl_lost_item WHERE id='$id'" ;
    $result = $conn->query($sql);
    return $result;
}

function addLostItem($lost_item_no, $reservation_no, $room_no, $client_company_id, $date_stay, $duration_stay, $quantity, $total){
    $conn=db();
    $sql = "INSERT into aims_gl_lost_item (lost_item_no,reservation_no,room_no,client_company_id,date_stay,duration_stay,quantity,total) 
		values('$lost_item_no','$reservation_no','$room_no','$company','$date_of_stay','$duration_of_stay','$quantity','$total')";
    $result = $conn->query($sql);
    return $result;
}
function getDropDownRoom3($selected) {
    $conn=db();
    $sql = "SELECT id,room_no FROM aims_gl_room ORDER BY room_no";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[1]."\">".$row[1]."</option>";
    }


    return $txt_result;
}

//ITEM BAVERAGE & tOILETRIES

function getItemhKList() {
    $conn=db();
    $sql = "SELECT * FROM aims_gl_hk_item ORDER BY item ASC";
    $result = $conn->query($sql);
    return $result;
}

function addItemHk($item,$code) {
    $conn = db();
    return $conn->query("INSERT INTO aims_gl_hk_item (item,code) VALUE ('$item','$code')");
}

function getItemHkById($id){
    $conn = db();
    return $conn->query("SELECT * FROM aims_gl_hk_item WHERE id='$id'");
}

function updateItemHk($item,$code,$id) {
    $conn=db();
    $sql = "UPDATE aims_gl_hk_item SET item='$item', code='$code' WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;
}

function deleteItemHk($id){
    $conn = db();
    return $conn->query("DELETE FROM aims_gl_hk_item WHERE id='$id'");
}

function getDropDownHkItem($selected) {
    $conn=db();
    $sql = "SELECT item FROM aims_gl_hk_item";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
    }


    return $txt_result;
}

function getItemHkStockList() {
    $conn=db();
    $sql = "SELECT * FROM aims_gl_hk_stock ORDER BY expired DESC";
    $result = $conn->query($sql);
    return $result;
}

function addHkStock($hk_item_id,$stock,$expired) {
    $conn=db();
    $sql = "INSERT into aims_gl_hk_stock (hk_item_id,stock,expired) values('$hk_item_id','$stock','$expired')";
    $result = $conn->query($sql);
    return $result;
}

function getHkStockById($id){
    $conn=db();
    $sql = "SELECT * FROM aims_gl_hk_stock WHERE id='$id'" ;
    $result = $conn->query($sql);
    return $result;
}

function updateHkStock($hk_item_id,$stock,$expired,$id) {
    $conn=db();
    $sql = "UPDATE aims_gl_hk_stock SET hk_item_id='$hk_item_id', stock='$stock', expired='$expired' WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;
}

function deleteHkStock($id){
    $conn=db();
    $sql = "DELETE FROM aims_gl_hk_stock WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;
}
// END ITEM BAVERAGE & tOILETRIES

//UTILITY getUtilityByMonth($month)
function getUtilityDescList() {
    $conn=db();
    $sql = "SELECT * FROM aims_gl_utility_desc ORDER BY description ASC";
    $result = $conn->query($sql);
    return $result;
}

function addUtilityDesc($description,$code) {
    $conn = db();
    return $conn->query("INSERT into aims_gl_utility_desc (description,code) values('$description','$code')");
}

function getUtilityDescById($id){
    $conn = db();
    return $conn->query("SELECT * FROM aims_gl_utility_desc WHERE id='$id'");
}

function updateUtilityDesc($description,$code,$id) {
    $conn = db();
    return $conn->query("UPDATE aims_gl_utility_desc SET description='$description', code='$code' WHERE id='$id'");
}

function deleteUtilityDesc($id){
    $conn = db();
    return $conn->query("DELETE FROM aims_gl_utility_desc WHERE id='$id'");
}

function getDropDownUtility($selected) {
    $conn=db();
    $sql = "SELECT description FROM aims_gl_utility_desc";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
    }


    return $txt_result;
}
function getUtilityList() {
    $conn=db();
    $sql = "SELECT * FROM aims_gl_utility ORDER BY month,year ASC";
    $result = $conn->query($sql);
    return $result;
}

function addUtility($utility_desc_id, $no_20, $no_21, $total, $month, $year, $created_by) {
    $conn = db();
    $sql = "INSERT INTO aims_gl_utility (utility_desc_id,no_20,no_21,total,month,year,created_by) VALUE ('$utility_desc_id','$no_20','$no_21','$total','$month','$year','$created_by')";
    return $conn->query($sql);
}

function getUtilityById($id){
    $conn = db();
    return $conn->query("SELECT * FROM aims_gl_utility WHERE id='$id'");
}

function updateUtility($utility_desc_id, $no_20, $no_21, $total, $month, $year,$id){
    $conn = db();
    $sql = "UPDATE aims_gl_utility SET utility_desc_id='$utility_desc_id', no_20='$no_20', no_21='$no_21', total='$total', month = '$month', year='$year' WHERE id='$id'";
    return $conn->query($sql);
}

function deleteUtility($id){
    $conn = db();
    return $conn->query("DELETE FROM aims_gl_utility WHERE id='$id'");
}

function getDropDownMonthUtility($selected) {
    /*$conn=db();
    $sql = "SELECT u.month FROM aims_gl_utility u GROUP BY month ";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
    }
    //$conn->close();
    return $txt_result;*/

    $conn=db();
    $sql = "SELECT month_num, month_description FROM aims_month ORDER BY month_num ASC";
    $result = $conn->query($sql);

    $txt_result="<option ".(0 == $selected ? 'selected':'')." value='0'>-- Choose Month --</option>";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
    }
    return $txt_result;
}

function getUtilityByMonth($month,$year){
    $month_name = ($month == 0) ? "" : convertDigitToMonthName($month);
    $conn=db();
    $sql = "SELECT * FROM aims_gl_utility
	WHERE month = '$month_name' AND year = '$year'";
    $result = $conn->query($sql);
    return $result;
}

//END UTILITY

//TRANSPORT
function getTransportList() {
    $conn=db();
    $sql = "SELECT * FROM aims_gl_transport ORDER BY date_use DESC";
    $result = $conn->query($sql);
    return $result;
}

function addTransport($company_vehicle,$date_use,$mileage_in,$mileage_out,$total_mileage,$total,$created_by) {
    $conn = db();
    $sql = "INSERT INTO aims_gl_transport (company_vehicle,date_use,mileage_in,mileage_out,total_mileage,total,created_by) VALUE ('$company_vehicle','$date_use','$mileage_in','$mileage_out','$total_mileage','$total','$created_by')";
    return $conn->query($sql);
}

function getTransportById($id){
    $conn = db();
    return $conn->query("SELECT * FROM aims_gl_transport WHERE id='$id'");
}

function updateTransport($company_vehicle,$date_use,$mileage_in,$mileage_out,$total_mileage,$total,$id){
    $conn = db();
    $sql = "UPDATE aims_gl_transport SET company_vehicle='$company_vehicle', date_use='$date_use', mileage_in='$mileage_in',mileage_out='$mileage_out',total_mileage='$total_mileage', total='$total' WHERE id='$id'";
    return $conn->query($sql);
}

function deleteTransport($id){
    $conn = db();
    return $conn->query("DELETE FROM aims_gl_transport WHERE id='$id'");
}

function getDropDownMonthTransport($selected) {
    $conn=db();
    $sql = "SELECT MONTH(date_use), YEAR(date_use) FROM aims_gl_transport GROUP BY MONTH(date_use) ORDER BY date_use DESC";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]." / ".$row[1]."</option>";
    }
    //$conn->close();
    return $txt_result;
}

function getTransportByMonth($month,$year){
    $month_digit = ($month == 0) ? "" : convertDigit($month);
    $conn=db();
    $sql = "SELECT * FROM aims_gl_transport
	WHERE date_use LIKE '%$year-$month_digit%'";
    $result = $conn->query($sql);
    return $result;
}

//END TRANSPORT

//EXPENSES
function getHkExpensesList() {
    $conn=db();
    $sql = "SELECT * FROM aims_gl_hk_expenses ORDER BY date_purchase DESC";
    $result = $conn->query($sql);
    return $result;
}

function addHkExpenses($location,$date_purchase,$item,$unit,$price,$total,$created_by) {
    $conn=db();

    $sql = "INSERT into aims_gl_hk_expenses (location,date_purchase,item,unit,price,total,created_by) values('$location','$date_purchase','$item','$unit','$price','$total','$created_by')";
    $result = $conn->query($sql);
    return $result;
}

function getHkExpensesById($id){
    $conn=db();
    $sql = "SELECT * FROM aims_gl_hk_expenses WHERE id='$id'" ;
    $result = $conn->query($sql);
    return $result;
}

function updateHkExpenses($location,$date_purchase,$item,$unit,$price,$total,$id){
    $conn=db();
    $sql = "UPDATE aims_gl_hk_expenses SET location='$location', date_purchase='$date_purchase', item='$item',unit='$unit',price='$price', total='$total' WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;
}

function deleteHkExpenses($id){
    $conn=db();
    $sql = "DELETE FROM aims_gl_hk_expenses WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;
}

function getHkExpensesByMonth($month, $year){
    $month_digit = ($month == 0) ? "" : convertDigit($month);
    $conn=db();
    $sql = "SELECT * FROM aims_gl_hk_expenses
	WHERE date_purchase LIKE '%$year-$month_digit%'";
    return $conn->query($sql);
}
//HK EXPENSES END

//DOBBY
function getDobbyList() {
    $conn=db();
    $sql = "SELECT * FROM aims_gl_dobby ORDER BY dobby_date DESC";
    $result = $conn->query($sql);
    return $result;
}

function addDobby($dobby_date,$amount,$created_by) {
    $conn=db();

    $sql = "INSERT into aims_gl_dobby (dobby_date,amount,created_by) values('$dobby_date','$amount','$created_by')";
    $result = $conn->query($sql);
    return $result;
}

function getDobbyById($id){
    $conn=db();
    $sql = "SELECT * FROM aims_gl_dobby WHERE id='$id'" ;
    $result = $conn->query($sql);
    return $result;
}

function updateDobby($dobby_date,$amount,$id){
    $conn=db();
    $sql = "UPDATE aims_gl_dobby SET dobby_date='$dobby_date', amount='$amount' WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;
}

function deleteDobby($id){
    $conn=db();
    $sql = "DELETE FROM aims_gl_dobby WHERE id='$id'";
    $result = $conn->query($sql);
    return $result;
}

function getDropDownMonthDobby($selected) {
    $conn = db();
    $result = $conn->query("SELECT month_num, month_description FROM aims_month ORDER BY month_num ASC");

    $txt_result="<option ".(0 == $selected ? 'selected':'')." value='0'>-- All Month --</option>";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
    }
    return $txt_result;
}

function DropDownYear($selected) {
    $year_option="";
    $yearNow = date("Y");
    for ($i=0; $i<3; $i++){
        $year = $yearNow - $i;
        $opt_selected = ($year == $selected) ? 'selected' : '';
        $year_option.= "<option value='".$year."' ".$opt_selected.">".$year."</option>";
    }
    return $year_option;
}

function convertDigitToMonthName($number){
    $month = array(
        "1" => "JANUARY", "2" => "FEBRUARY","3" => "MARCH", "4" => "APRIL","5" => "MAY", "6" => "JUNE",
        "7" => "JULY", "8" => "AUGUST","9" => "SEPTEMBER", "10" => "OCTOBER","11" => "NOVEMBER", "12" => "DECEMBER",
    );
    return $month[$number];
}

function convertDigit($number){
    $month = array(
        "1" => "01", "2" => "02","3" => "03", "4" => "04","5" => "05", "6" => "06",
        "7" => "07", "8" => "08","9" => "09", "10" => "10","11" => "11", "12" => "12",
    );
    return $month[$number];
}

function getDobbyByMonth($month,$year){
    $month_digit = ($month == 0) ? "" : convertDigit($month);
    $conn=db();
    $sql = "SELECT * FROM aims_gl_dobby
	WHERE dobby_date LIKE '%$year-$month_digit%'";
    return $conn->query($sql);
}
/*function getDobbyByMonth($month){
	$conn=db();
	$sql = "SELECT * FROM aims_gl_dobby
	WHERE MONTH(dobby_date) = '$month'";
	$result = $conn->query($sql);
	return $result;
}*/
//EXPENSES END

//EXPENSES BY BOOKING
function getExpensesList($name) {
    $conn=db();
    $sql = "SELECT gl.gl_access FROM aims_access gl 
		LEFT JOIN staff s ON s.noic = gl.no_staff
		WHERE s.name='$name'";
    $gl_access=$conn->query($sql)->fetch_object()->gl_access;
    if ($gl_access == '1'){

        $sql = "SELECT * FROM aims_gl_expenses
		    ORDER BY created_date DESC";
    }
    else {
        echo ("<script LANGUAGE='JavaScript'>
						window.location.href='../view/aims_gl_admin.php';
						</script>");
    }

    $result = $conn->query($sql);
    return $result;
}

function getExpensesById($id){
    $conn = db();
    return $conn->query("SELECT * FROM aims_gl_expenses WHERE id='$id'");
}

function updateExpenses($hk_date,$hk_status,$dobby_bs,$dobby_bl,$dobby_twl,$tea,$sugar,$creamer,$soap,$shampoo,$water,$created_by,$id){
    $conn = db();
    $sql = "UPDATE aims_gl_expenses SET hk_date='$hk_date', hk_status='$hk_status', dobby_bs='$dobby_bs', dobby_bl='$dobby_bl', dobby_twl='$dobby_twl', tea='$tea', sugar='$sugar', creamer='$creamer', soap='$soap', shampoo='$shampoo', water='$water',created_by='$created_by' WHERE id='$id'";
    return $conn->query($sql);
}

function deleteExpenses($id){
    $conn = db();
    return $conn->query("DELETE FROM aims_gl_expenses WHERE id='$id'");
}

function getDropDownMonthExpenses($selected) {
    $conn=db();
    $sql = "SELECT MONTH(hk_date), YEAR(hk_date) FROM aims_gl_expenses WHERE hk_date IS NOT NULL GROUP BY MONTH(hk_date) ORDER BY hk_date DESC";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]." / ".$row[1]."</option>";
    }
    //$conn->close();
    return $txt_result;
}

/*Edited 10 Sept*/
function getExpensesByMonth($month,$year){

    $month_digit = ($month == 0) ? "" : convertDigit($month);
    $conn=db();
    /*$sql = "SELECT e.*,d.amount FROM aims_gl_expenses e
    LEFT JOIN aims_gl_dobby d ON MONTH(e.hk_date)=MONTH(d.dobby_date)
    WHERE MONTH(e.hk_date) = '$month'";*/
    $sql = "SELECT * FROM aims_gl_expenses WHERE hk_date LIKE '%$year-$month_digit%'";
    $result = $conn->query($sql);
    return $result;
}

//SUMMARY EXPENSES
function getSummaryList() {
    $conn=db();
    $sql = "SELECT MONTH(hk_date) as monthhk, YEAR(hk_date) as yearhk FROM aims_gl_expenses";
    $result = $conn->query($sql);
    return $result;
}

function getDropDownMonthSummary($selected) {
    /*$conn=db();
    $sql = "SELECT MONTH(hk_date), YEAR(hk_date) FROM aims_gl_expenses WHERE hk_date IS NOT NULL GROUP BY MONTH(hk_date) ORDER BY hk_date DESC";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]." / ".$row[1]."</option>";
    }
    //$conn->close();
    return $txt_result;*/


    $conn=db();
    $sql = "SELECT month_num, month_description FROM aims_month ORDER BY month_num ASC";
    $result = $conn->query($sql);

    $txt_result="<option ".(0 == $selected ? 'selected':'')." value='0'>-- Choose Month --</option>";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
    }
    return $txt_result;
}

function getSummaryDobbyByMonth($name,$month,$year){
    $month_digit = ($month == 0) ? "" : convertDigit($month);
    $conn=db();
    $sql = "SELECT gl.gl_access FROM aims_access gl 
	LEFT JOIN staff s ON s.noic = gl.no_staff
	WHERE s.name='$name'";
    $gl_access=$conn->query($sql)->fetch_object()->gl_access;

    if ($gl_access == '1' || $gl_access == '6'){

        $sql = "SELECT SUM(amount) AS amount FROM aims_gl_dobby
	WHERE dobby_date LIKE '%$year-$month_digit%'";
    }
    else {
        echo ("<script LANGUAGE='JavaScript'>
			window.location.href='../view/aims_gl_admin.php';
			</script>");
    }

    $result = $conn->query($sql);
    return $result;
}

function getSummarySugarByMonth($month,$year){
    $month_digit = ($month == 0) ? "" : convertDigit($month);
    $conn=db();
    $sql = "SELECT SUM(sugar) as sugar,SUM(tea) as tea,SUM(creamer) as creamer,SUM(soap) as soap,SUM(shampoo) as shampoo,SUM(water) as water FROM aims_gl_expenses
	WHERE hk_date LIKE '%$year-$month_digit%'";
    $result = $conn->query($sql);
    return $result;
}

function getSummaryWbilByMonth($month,$year){
    $conn=db();
    $sql = "SELECT SUM(total) as wbil FROM aims_gl_utility u
	LEFT JOIN aims_month m ON m.month_description = u.month
	WHERE u.utility_desc_id = 'WATER BILL' AND m.month_num='$month' AND u.year ='$year'";
    $result = $conn->query($sql);
    return $result;
}

function getSummaryEbilByMonth($month,$year){
    $conn=db();
    $sql = "SELECT SUM(total) as ebil FROM aims_gl_utility u
	LEFT JOIN aims_month m ON m.month_description = u.month
	WHERE u.utility_desc_id = 'ELECTRICITY BILL' AND m.month_num='$month' AND u.year ='$year'";
    $result = $conn->query($sql);

    return $result;
}

function getSummaryCowayByMonth($month,$year){
    $conn=db();
    $sql = "SELECT SUM(total) as coway FROM aims_gl_utility u
	LEFT JOIN aims_month m ON m.month_description = u.month
	WHERE u.utility_desc_id = 'COWAY' AND m.month_num='$month' AND u.year ='$year'";
    $result = $conn->query($sql);

    return $result;
}

function getSummaryTransportByMonth($month,$year){
    $month_digit = ($month == 0) ? "" : convertDigit($month);
    $conn=db();
    $sql = "SELECT SUM(total) AS transport FROM aims_gl_transport
	WHERE date_use LIKE '%$year-$month_digit%' ";
    $result = $conn->query($sql);

    return $result;
}

/*New function added -> 8 Sept 2022*/
function getSummaryHousekeepingByMonth($month,$year){
    $month_digit = ($month == 0) ? "" : convertDigit($month);
    $conn=db();
    $sql = "SELECT SUM(total) AS total FROM aims_gl_hk_expenses WHERE date_purchase LIKE '%$year-$month_digit%'";
    return $conn->query($sql);
}

function getTotalDobbyByMonth($month,$year){
    $month_digit = ($month == 0) ? "" : convertDigit($month);
    $conn=db();
    $sql = "SELECT SUM(amount) AS amount FROM aims_gl_dobby
	WHERE dobby_date LIKE '%$year-$month_digit%'";
    return $conn->query($sql);
}

$conn->close();

?>