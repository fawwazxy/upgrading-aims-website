<?php
//phpinfo();
header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
header('Content-type: application/json');
date_default_timezone_set("Asia/Kuala_Lumpur");
require_once('../lib/json.inc');
require_once ('../lib/db/connection.php');

$cmd = $_GET['cmd'];
$output_to_send = '';
switch ($cmd){

    case '1'://tukar gmbar
        //read data
        $imagebytes = $_POST['imagebytes'];
        $extension = $_POST['extension'];
        $no_staff = $_POST['no_staff'];
        $image = base64_decode($imagebytes);
        //put new image;
        $document_name=date('Ymd_his').'.'.$extension;
        $filepath = '../staffphoto/'.$document_name;
        $file_size=strlen(base64_decode($imagebytes));
        file_put_contents($filepath,base64_decode($imagebytes));
        //read old image from db;
        $old_image_query = "SELECT nama_photo FROM `staff` where no_staff=".$no_staff;
        $old_image = $connjson->query($old_image_query)->fetch_object()->nama_photo;
        //delete old image if image default dont delete;
        if($old_image!='default-image.jpg' && is_file('../staffphoto/'.$old_image)){
                unlink('../staffphoto/'.$old_image);
        }
        //update new image in db;
        $update_image_query = "UPDATE staff SET nama_photo = '".$document_name. "' WHERE no_staff = ".$no_staff;
        //return new image name;
        $update_image_query_result = $connjson->query($update_image_query);
        echo $document_name;
        break;

    case '2'://announcementdata
        //read data
        $announcements = array();
        $data = $connjson->query("SELECT * FROM announcements WHERE CURRENT_DATE >= start_date AND CURRENT_DATE <= end_date");
        $i=0;
        while($r = $data->fetch_assoc()) {
            $announcements[$i] = $r;
            $i++;
        }
        $output_to_send = json_encode($announcements);
        break;

    case '3'://birthday
        $staff_id = $_GET['staff_id'];
        $today = date('m-d');

        $is_birthday_today = $connjson->query("SELECT count(id) as exist FROM staff WHERE id = '$staff_id' AND umur LIKE '%$today%'")->fetch_object()->exist > 0;

        $staffs_born_today = array();
        $staffs_born_today_query = $connjson->query("SELECT name,department_sub from staff WHERE umur LIKE '%$today%'");
        $i=0;
        while($staff_born_today = $staffs_born_today_query->fetch_assoc()) {
            $staffs_born_today[$i] = $staff_born_today;
            $i++;
        }
        $result = new StdClass();
        $result->is_birthday_today = $is_birthday_today;
        $result->staffs_born_today = $staffs_born_today;

        $output_to_send = json_encode($result);
        break;

    case '4'://company documents
        $company_documents = $connjson->query("SELECT * FROM company_documents")->fetch_all(MYSQLI_ASSOC);
        
        foreach ($company_documents as &$company_document){
            $company_document["file_path"] = str_replace("../..","",$company_document["file_path"]);
            $company_document["thumbnail_path"] = str_replace("../..","",$company_document["thumbnail_path"]);
        }
        
        $output_to_send = json_encode($company_documents,JSON_UNESCAPED_SLASHES);
        break;
}
// Closing connection
mysqli_close($connjson);
echo $output_to_send;