<?php
//phpinfo();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header('Content-type: application/json');

require_once('../lib/json.inc');
require_once ('../lib/db/connection.php');

error_log('json_office.php');
error_reporting(E_ALL);
ini_set("display_errors", 0);

$JsonSystem = new Json();

$cmd = $JsonSystem->getGETPOST('cmd');

$output = '';
$output_to_send = '';
switch ($cmd){

    case '1'://get allowed app versions

        $sql = "SELECT * FROM `mobile_app_allowed_version`";

        //$output = $JsonSystem->getJSONData($sql, '', null);
        //$output_to_send = "[{$output}]"

        $output = $connjson->query($sql);
        $allowed_versions = array();

        while($r = mysqli_fetch_assoc($output)) {
            $allowed_versions[] = $r["versions"];
        }
        echo json_encode($allowed_versions);
        //$output_to_send = json_encode($output);

        break;

    case '2'://Login
        $nama = $JsonSystem->getGETPOST('username');
        $pwd = $JsonSystem->getGETPOST('password');

        $encrypt = "SELECT accs_pwd FROM staff WHERE username='$nama' AND status='BEKERJA'";
        $db_pwd = db()->query($encrypt)->fetch_object()->accs_pwd;

        if (password_verify($pwd, $db_pwd)){
            $user_info = "SELECT s.id, s.no_staff, s.noic, s.name, s.username, 
            s.phone, s.email, s.alamat_tetap, s.alamat_surat,s.jawatan_code, s.role_id, s.department_id,s.department_sub, d.description AS jabatan, 
            s.company_id,s.`status`,s.cawangan_kod,c.`sys_name`,c.`sys_domain` ,s.status_qrcode,s.status_swafoto,s.status_tag,s.nama_photo
            FROM staff s,company b,sys_setting c,department d
            WHERE s.company_id=b.id AND b.`sys_id`=c.`sys_id` AND s.department_id=d.code_department AND b.status='1' 
            AND s.status='BEKERJA' 
            AND s.username='{$nama}'";

            $output = db()->query($user_info);
        } else {
            $output = null;
        }

//---------------------------------------------------------------------------------------------------------------------
        $sql2 = "SELECT DISTINCT s.role_id FROM staff s LEFT JOIN role r ON s.role_id = r.code WHERE r.status_pelulus_cuti = '1' 
			AND s.status = 'BEKERJA' ORDER BY s.no_staff";

        $output2 = db()->query($sql2);
        $pelulus_cuti = [];
        while ($list_role = $output2->fetch_array()){
            $pelulus_cuti[] = $list_role[0];
        }
//---------------------------------------------------------------------------------------------------------------------
        $pelulus_ot = array('HOD','MANAGER','FOUNDER','HOC','OPERATIONMANAGER','EXECUTIVEAVSB','SUPERVISORAVSB','CFO','MANAGING-DIRECTOR','EXECUTIVE-DIRECTOR');
//---------------------------------------------------------------------------------------------------------------------
        $i=0;
        $array = array();
        while($list = $output->fetch_assoc()){
            //print_r($role_array);
            $array[$i] = $list;
            $array[$i]['status_pelulus_cuti'] = (in_array($list['role_id'],$pelulus_cuti)) ? "1": "0";
            $array[$i]['status_pelulus_ot_kehadiran'] = (in_array($list['role_id'],$pelulus_ot)) ? "1": "0";
            $i++;
        }
        $output_to_send = json_encode($array[0]);
        break;

    case '3'://checking phone id

        $device_id = $JsonSystem->getGETPOST('device_id');
        $nokp = $JsonSystem->getGETPOST('nokp');
        $sql = "SELECT id,no_staff,device_id FROM phone_authority_v2 WHERE device_id ='$device_id'";
        $result = $connjson->query($sql);
        $nokp_staff = "";

        if($result->num_rows > 0)//ada data
        {
            $registered_nokp=$result->fetch_object()->no_staff;
            if ($registered_nokp == $nokp){
                $output_to_send = "Log masuk berjaya";
            }else{
                $output_to_send = 'Log masuk disekat';
            }
        }

        else
        {
            $sql2="INSERT INTO phone_authority_v2 (no_staff,device_id) 
				VALUES ('$nokp','$device_id')";
            $JsonSystem->executeOperation($sql2);
            $output_to_send = "Peranti baru ditambah";
        }

        break;

    case '4'://storetoken
        $staff_id = $JsonSystem->getGETPOST('staff_id');
        $token = $JsonSystem->getGETPOST('token');

        if($staff_id==''){
            break;
        }

        $count = db()->query("SELECT count(id) as count from push_notification_token where staff_id='$staff_id'")->fetch_object()->count;

        if($count<1){
            $sql = "INSERT INTO push_notification_token (staff_id, token) VALUES ('$staff_id','$token')";
        }
        else{
            $sql = "UPDATE push_notification_token set token='$token' WHERE staff_id='$staff_id'";
        }

        $output = db()->query($sql);

        $output_to_send = json_encode($output);     //return user data
        break;
        
    case '5'://get allowed app versions

        $sql = "SELECT * FROM `mobile_app_allowed_versions_v2`";

        //$output = $JsonSystem->getJSONData($sql, '', null);
        //$output_to_send = "[{$output}]"

        $output = $connjson->query($sql);
        $allowed_versions = $output->fetch_all(MYSQLI_ASSOC);

        /*while($r = mysqli_fetch_assoc($output)) {
            $allowed_versions[] = $r["version"];
            
        }*/
        echo json_encode($allowed_versions);
        //$output_to_send = json_encode($output);

        break;
}
// Closing connection
mysqli_close($connjson);
echo $output_to_send;
