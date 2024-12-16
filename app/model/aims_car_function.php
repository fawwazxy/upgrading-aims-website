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
    $sql = "SELECT s.*,c.short_name FROM sys_setting s 
				LEFT JOIN company c ON c.sys_id = s.sys_id 
				WHERE s.sys_id='$sys_id'";
    return $conn->query($sql);
}

function getcarList() {
    $conn=db();
    $sql = "SELECT * FROM aims_car_info";
    return $conn->query($sql);
}

function getcarListbyStaff($name) {
    $conn=db();
    $sql = "SELECT * FROM aims_car_info WHERE car_pic = '$name' OR car_pic2 = '$name'";
    return $conn->query($sql);
}

function getcarListbyStafff($location) {
    $conn=db();

    $where_location = ($location == 'NONE') ? "" : " WHERE car_location = '$location'";
    $sql = "SELECT * FROM aims_car_info $where_location";
    return $conn->query($sql);
}

function addcar($car_model,$car_plate_no,$car_type,$car_owner,$car_pic,$car_pic2,$car_category,$engine_no,$chassis_no,$cost_receipt,$date_receipt,$suppliers,
                $hire_account_no,$name_account,$last_service,$next_service,$current_mileage,$next_mileage,$date_ex_rtx,$value_rtx,$date_ex_ins,$type_ins,
                $value_ins,$color,$date_ex_priv,$sum_priv,$value_priv,$document, $document_name,$fileType){
    $conn=db();
    $gambar = '';
    $gambar_val = '';
    if($document_name!=""){
        $gambar=",document, document_type,document_name";
        $gambar_val=",'$document','$fileType','$document_name'";
    }
    $sql = "INSERT INTO aims_car_info (car_model,car_plate_no,car_type,car_owner,car_pic,car_pic2,car_category,engine_no,chassis_no,cost_receipt,date_receipt,suppliers,hire_account_no,
                                            name_account,last_service,next_service,current_mileage,next_mileage,date_ex_rtx,value_rtx,date_ex_ins,type_ins,value_ins,color,date_ex_priv,
                                                sum_priv,value_priv $gambar) VALUES 
                                          ('$car_model','$car_plate_no','$car_type','$car_owner','$car_pic','$car_pic2','$car_category','$engine_no','$chassis_no','$cost_receipt','$date_receipt',
                                                '$suppliers','$hire_account_no','$name_account','$last_service','$next_service','$current_mileage','$next_mileage','$date_ex_rtx','$value_rtx','$date_ex_ins',
                                                    '$type_ins','$value_ins','$color','$date_ex_priv','$sum_priv','$value_priv' $gambar_val)";
    return $conn->query($sql);
}

function updatecar($car_model,$car_plate_no,$car_type,$car_owner,$car_pic,$car_pic2,$car_category,$engine_no,$chassis_no,$cost_receipt,$date_receipt,$suppliers,$hire_account_no,$name_account,$last_service,$next_service,
                   $current_mileage,$next_mileage,$date_ex_rtx,$value_rtx,$date_ex_ins,$type_ins,$value_ins,$color,$date_ex_priv,$sum_priv,$value_priv,$updated_by,$imgContent_doc,$document_name,$fileType,$id) {
    $conn=db();

    $document_field = ($document_name!="") ? " ,document='$imgContent_doc',document_name='$document_name',document_type='$fileType' " : "";

    $sql = "UPDATE aims_car_info SET
        car_model='$car_model', car_plate_no='$car_plate_no' ,car_type='$car_type' , car_owner='$car_owner', car_pic='$car_pic', car_pic2='$car_pic2',
        car_category = '$car_category', engine_no= '$engine_no', chassis_no = '$chassis_no', cost_receipt = '$cost_receipt', date_receipt = '$date_receipt', 
        suppliers = '$suppliers', hire_account_no = '$hire_account_no', name_account = '$name_account', color = '$color',  updated_by='$updated_by' ,
        last_service = '$last_service', next_service = '$next_service', current_mileage = '$current_mileage', next_mileage = '$next_mileage',
        date_ex_rtx='$date_ex_rtx', value_rtx='$value_rtx', date_ex_ins='$date_ex_ins', type_ins='$type_ins', value_ins='$value_ins',
        date_ex_priv = '$date_ex_priv', sum_priv = '$sum_priv', value_priv = '$value_priv' $document_field WHERE id='$id'";

    return $conn->query($sql);
}

//delete car
function deleteCarInfo($id){
    $conn=db();
    $sql="DELETE FROM aims_car_info WHERE id = '$id'";
    return $conn->query($sql);
}

//update utk by company approve
function updatecarbycompany($car_status,$updated_by,$id) {
    $conn=db();
    $sql = "UPDATE aims_car_info SET car_status='$car_status', updated_by='$updated_by', update_date= CURRENT_TIMESTAMP WHERE id = '$id'";
    return $conn->query($sql);
}

function getDropDownstaff($selected) {
    $conn=db();
    $sql = "SELECT id, name FROM staff";
    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[1] == $selected ? 'selected':'')." value=\"".$row[1]."\">".$row[1]."</option>";
    }

    return $txt_result;
}

function getDropDesign($selected) {
    $conn=db();
    $sql = "SELECT id, jawatan FROM jawatan";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
    }

    return $txt_result;
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

function getDropDownCarlocation($selected) {
    $conn=db();
    $sql = "SELECT id, loc_code, location_name FROM aims_car_location";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[1] == $selected ? 'selected':'')." value=\"".$row[1]."\">".$row[2]."</option>";
    }

    return $txt_result;
}

function getDropDownCompany($selected) {
    $conn=db();
    $sql = "SELECT company_id,company_name FROM aims_company WHERE company_status = '1'";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[1]."</option>";
    }
    return $txt_result;
}

function getDropDownCompany2($selected) {
    $conn=db();
    $sql = "SELECT id,code_department,description FROM department WHERE status = '1' AND code_department <> ''";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[1] == $selected ? 'selected':'')." value=\"".$row[1]."\">".$row[2]."</option>";
    }
    return $txt_result;
}

function getcarById($id) {
    $conn=db();
    $sql = "SELECT a.*,b.return_milage FROM aims_car_info a
				LEFT JOIN aims_car_reserve b ON  b.car_plate_no = a.car_plate_no
				LEFT JOIN aims_car_admin c ON c.reserve_id = b.id
				WHERE a.id='$id'";
    return $conn->query($sql);
}

function getmilagecarById($id) {
    $conn=db();
    $sql = "SELECT a.*,b.return_milage FROM aims_car_info a
				LEFT JOIN aims_car_reserve b ON  b.car_plate_no = a.car_plate_no
				LEFT JOIN aims_car_admin c ON c.reserve_id = b.id
				WHERE a.id='$id'
				AND c.app_status = 'APPROVE'
                AND b.return_milage <> 0
				ORDER BY b.created_date DESC
				LIMIT 1";
    return $conn->query($sql);
}

function getTotalCar(){
    $conn=db();
    $sql = "SELECT count(id) as total FROM aims_car_info";
    $result = $conn->query($sql);
    return $result->fetch_object()->total;
}

function getTotalCarByStatus($status){
    $conn=db();
    $sql = "SELECT count(id) as total FROM aims_car_info WHERE car_status = '$status'";
    $result = $conn->query($sql);
    return $result->fetch_object()->total;
}

function getTotalCarSubmitted(){
    $conn=db();
    $sql = "SELECT count(a.id) as total FROM aims_car_reserve a
				LEFT JOIN aims_car_admin b ON b.reserve_id = a.id
				WHERE b.app_status = 'APPROVED' AND a.sbu_hod_app = 'APPROVED'";
    $result = $conn->query($sql);
    return $result->fetch_object()->total;
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

function getDropDownYear($selected) {
    $conn=db();
    $sql = "SELECT YEAR(dep_date) FROM aims_car_inspection GROUP BY YEAR(dep_date) ORDER BY dep_date DESC";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
    }
    return $txt_result;
}

function getcarByModel($car_model) {
    $conn=db();
    $sql = "SELECT a.*,b.description FROM aims_car_info a 
		LEFT JOIN department b ON a.car_owner = b.code_department
		WHERE a.car_model='$car_model'" ;
    return $conn->query($sql);
}

function getcarByinspec($car_model,$year) {
    $conn=db();
    $sql = "SELECT * FROM car_maintenance
		WHERE car_model ='$car_model'
		AND YEAR(dep_date)='$year'" ;
    return $conn->query($sql);
}

function getcarByinspecbyName($name) {
    $conn=db();
    $sql = "SELECT v.vehicle_access FROM aims_access v
		left join staff s ON s.noic = v.no_staff
		WHERE s.name='$name'";
    $vehicle_access=$conn->query($sql)->fetch_object()->vehicle_access;

    if($vehicle_access == '2'){
        $sql = "((SELECT a.id,a.dep_date,a.hd_vehicle,a.exterior_car,a.comment1, a.interior_car, a.comment, a.costing, a.status, b.id AS car_id, c.id AS main_id, c.km_read, c.odom_read, c.date, c.job_desc, c.item_desc, c.place_service, c.invoice_no, c.duration, c.status_1, c.status_2,c.issue FROM aims_car_inspection a
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN car_maintenance c ON (a.status = c.status AND c.inspection_id = a.id))
		UNION
		(SELECT a.id,a.dep_date,a.hd_vehicle,a.exterior_car,a.comment1, a.interior_car, a.comment, a.costing, a.status, b.id AS car_id, c.id AS main_id, c.km_read, c.odom_read, c.date, c.job_desc, c.item_desc, c.place_service, c.invoice_no, c.duration, c.status_1, c.status_2,c.issue FROM aims_car_inspection_bycompany a
		LEFT JOIN aims_car_info b ON a.car_plate_no = b.car_plate_no
		LEFT JOIN car_maintenance c ON (a.status = c.status AND c.inspection_id = a.id))" ;
    }

    else {
        echo ("<script type='text/javascript'>
						window.location.href='../view/aims_car_adminsign.php';
						</script>");
    }

    return $conn->query($sql);
}

function getMaintenancebyId($id) {
    $conn=db();
    $sql = "SELECT a.* FROM car_maintenance a
		LEFT JOIN aims_car_info b ON a.car_id = b.id
		WHERE a.id='$id'" ;
    return $conn->query($sql);
}

function getcarMaintenancebyId($id) {
    $conn=db();
    $sql = "SELECT a.* FROM car_maintenance a
		LEFT JOIN aims_car_info b ON a.car_id = b.id
		WHERE a.id='$id'" ;
    return $conn->query($sql);
}

function add_maintenance($car_model,$dep_date,$interior_car1,$exterior_car1,$km_read,$odom_read,$costing,$date,$job_desc,$item_desc,$place_service,$invoice_no,$duration,$issue){
    $conn=db();

    $sql = "INSERT INTO car_maintenance (car_model,dep_date,interior_car1,exterior_car1,km_read,odom_read,costing,date,job_desc,item_desc,place_service,invoice_no,duration,issue) 
		VALUES ('$car_model','$dep_date','$interior_car1','$exterior_car1','$km_read','$odom_read','$costing','$date','$job_desc','$item_desc','$place_service','$invoice_no','$duration','$issue')" ;
    return $conn->query($sql);
}

function update_maintenance($km_read,$odom_read,$date,$job_desc,$item_desc,$duration,$place_service,$invoice_no,$car_id,$id,$issue){
    $conn=db();
    $sql = "UPDATE car_maintenance 
                SET 
                    car_id='$car_id',
                    km_read = '$km_read', 
                    odom_read='$odom_read', 
                    date='$date', 
                    job_desc='$job_desc', 
                    item_desc='$item_desc',
                    place_service='$place_service',
                    invoice_no='$invoice_no'
                    ,duration='$duration', 
                    issue='$issue'
            WHERE id = '$id'" ;
    return $conn->query($sql);
}

function status1_maintenance($id,$status_1){
    $conn=db();
    $sql = "UPDATE car_maintenance SET status_1='$status_1' WHERE id = '$id'" ;
    return $conn->query($sql);
}

function status2_maintenance($id,$status_2){
    $conn=db();
    $sql = "UPDATE car_maintenance SET status_2='$status_2' WHERE id = '$id'" ;
    return $conn->query($sql);
}

function getDropDownYear_main($selected) {
    $conn=db();
    $sql = "SELECT YEAR(dep_date) FROM car_maintenance GROUP BY YEAR(dep_date) ORDER BY dep_date DESC";

    $result = $conn->query($sql);

    $txt_result="";
    while ($row  = $result -> fetch_array()){
        $txt_result .= "<option ".($row[0] == $selected ? 'selected':'')." value=\"".$row[0]."\">".$row[0]."</option>";
    }
    return $txt_result;
}