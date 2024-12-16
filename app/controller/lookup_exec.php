<?
include "../model/lkp_function.php";

$action = $_GET['act'];

if ($action == "department_list_add"){
    //$id=($_GET['id_project']);

    $code_department =$_POST['code_department'];
    $description =$_POST['description'];
    $leave_approval =$_POST['leave_approval'];
    // $company_id =$_POST['company_id'];

    $result = addDepartment($code_department, $description, $leave_approval);

    //Check whether the query was successful or not
    if(!$result) {
        echo "<script> alert('Proses tidak berjaya.'); 
        location.href = '../view/department_list.php?status=1&flagScreen=tab_1';</script>";
        exit();
    }

    #send data to aims-corp
    $url = 'https://corp.aimsglobal.com.my/api/company/store';

    $headers = array(
        'token:AAAAw99tSIg:APA91bHUrbGeJJtT8RWCIvgK8mCIeg8IMCHcRwDhSqgOWkJnKpQI_qv0wfnGo20K6M8A5FWzkh0QhGZXpFa96vYnNskhn_XNaegkVYII72-7sqda-hpHfuMyEUU8fQfaRouuDqK_XYWS',
        'Content-Type:application/json',
        'Accept:application/json'
    );

    $data = [
        'id' => $result,
        'code' => $code_department,
        'name' => $description,
    ];

    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    $result2 = curl_exec($ch);
    curl_close($ch);

    $result2_decoded = json_decode($result2, true);

    if($result2_decoded["data"]!=true){
        deleteDepartment($result);
        echo ("<script type='text/javascript'> alert('Bahagian gagal ditambah - ".$result2_decoded["message"]."');
        location.href = '../view/department_list.php?status=1&flagScreen=tab_1';
        </script>");
        exit();
    }

    echo ("<script type='text/javascript'>
    alert('Bahagian berjaya ditambah');
    window.location.href='../view/department_list.php?status=1&flagScreen=tab_1';
    </script>");
    exit();
}
//---------------------------------------------------------------------------------------------------------------------
else if($action == "department_list_status"){
    $department_id= ($_GET['id']);
    $status= ($_GET['status']);

    $result = updateStatusDepartment($status,$department_id);

    //Check whether the query was successful or not
    if($result) {
        if($status==1){
            echo ("<script type='text/javascript'>
            window.location.href='../view/department_list.php?status=0&flagScreen=tab_1';
            </script>");
            //header("location: ../view/department_list.php?status=0&flagScreen=tab_2");
        }else if($status==0){
            echo ("<script type='text/javascript'>
            window.location.href='../view/department_list.php?status=1&flagScreen=tab_1';
            </script>");
            //header("location: ../view/department_list.php?status=1&flagScreen=tab_1");
        }
        exit();

    }else {
        die("Query failed");
    }


}else if ($action == "lokasi_list_add"){
    //$id=($_GET['id_project']);

    $cawangan_kod =$_POST['cawangan_kod'];
    $nama =$_POST['nama'];

    // $company_id =$_POST['company_id'];

    $result = addLokasi($cawangan_kod, $nama);

    //Check whether the query was successful or not
    if($result) {
        echo ("<script type='text/javascript'>
            window.location.href='../view/lokasi_list.php?status=1&flagScreen=tab_2';
            </script>");
        //header("location: ../view/department_list.php?status=1&flagScreen=tab_1");
        exit();
    }else {
        echo "<script> alert('Proses tidak berjaya.'); location.href = '../view/lokasi_list.php?status=1&flagScreen=tab_2';</script>";
        exit();
    }


}else if($action == "lokasi_list_status"){
    $lokasi_id= ($_GET['id']);
    $status= ($_GET['status']);

    $result = updateStatusLokasi($status,$lokasi_id);

    //Check whether the query was successful or not
    if($result) {
        if($status==1){
            echo ("<script type='text/javascript'>
            window.location.href='../view/lokasi_list.php?status=0&flagScreen=tab_2';
            </script>");
            //header("location: ../view/department_list.php?status=0&flagScreen=tab_2");
        }else if($status==0){
            echo ("<script type='text/javascript'>
            window.location.href='../view/lokasi_list.php?status=1&flagScreen=tab_2';
            </script>");
            //header("location: ../view/department_list.php?status=1&flagScreen=tab_1");
        }
        exit();

    }else {
        die("Query failed");
    }
}else if ($action == "sub_department_list_add"){
    //$id=($_GET['id_project']);

    $code_department =$_POST['code_department'];
    $description =$_POST['description'];
    $sub_code_department =$_POST['sub_code_department'];
    // $company_id =$_POST['company_id'];

    $result = addSubDepartment($code_department, $description, $sub_code_department);

    //Check whether the query was successful or not
    if($result) {
        echo ("<script type='text/javascript'>
            window.location.href='../view/sub_department_list.php?status=1&flagScreen=tab_3';
            </script>");
        //header("location: ../view/department_list.php?status=1&flagScreen=tab_1");
        exit();
    }else {
        echo "<script> alert('Proses tidak berjaya.'); location.href = '../view/sub_department_list.php?status=1&flagScreen=tab_3';</script>";
        exit();
    }


}else if($action == "sub_department_list_status"){
    $department_id= ($_GET['id']);
    $status= ($_GET['status']);

    $result = updateStatusSubDepartment($status,$department_id);

    //Check whether the query was successful or not
    if($result) {
        if($status==1){
            echo ("<script type='text/javascript'>
            window.location.href='../view/sub_department_list.php?status=1&flagScreen=tab_3';
            </script>");
            //header("location: ../view/sub_department_list.php?status=0&flagScreen=tab_2");
        }else if($status==0){
            echo ("<script type='text/javascript'>
            window.location.href='../view/sub_department_list.php?status=0&flagScreen=tab_3';
            </script>");
            //header("location: ../view/department_list.php?status=1&flagScreen=tab_1");
        }
        exit();

    }else {
        die("Query failed");
    }


}

else if($action == "department_list_update"){
    $department_id = $_POST['id'];
    $code_department =$_POST['code_department'];
    $description =$_POST['description'];
    $leave_approval =$_POST['leave_approval'];

    $old_department_data = getDepartmentById($department_id)->fetch_assoc();

    $result = updateDepartment($department_id,$code_department, $description, $leave_approval);

    if(!$result) {
        echo "<script> alert('Proses tidak berjaya.'); 
        location.href = '../view/department_list.php?status=1&flagScreen=tab_1';</script>";
        exit();
    }

    #send data to aims-corp
    $url = 'https://corp.aimsglobal.com.my/api/company/update/'.$department_id;

    $headers = array(
        'token:AAAw99tSIg:APA91bHUrbGeJJtT8RWCIvgK8mCIeg8IMCHcRwDhSqgOWkJnKpQI_qv0wfnGo20K6M8A5FWzkh0QhGZXpFa96vYnNskhn_XNaegkVYII72-7sqda-hpHfuMyEUU8fQfaRouuDqK_XYWS',
        'Content-Type:application/json',
        'Accept:application/json'
    );

    $data = [
        'code' => $code_department,
        'name' => $description,
    ];


    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
    curl_setopt($ch,CURLOPT_POSTFIELDS,json_encode($data));
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
    $result2 = curl_exec($ch);
    curl_close($ch);

    $result2_decoded = json_decode($result2, true);

    if($result2_decoded["data"]!=true){
        updateDepartment($department_id,$old_department_data['code_department'], $old_department_data["description"], $old_department_data["leave_approval"]);
        echo ("<script type='text/javascript'> alert('Bahagian gagal diedit - ".$result2_decoded["message"]."');
        location.href = '../view/department_list.php?status=1&flagScreen=tab_1';
        </script>");
        exit();
    }

    echo ("<script type='text/javascript'>
    alert('Bahagian berjaya diedit');
    window.location.href='../view/department_list.php?status=1&flagScreen=tab_1';
    </script>");
    exit();
}