<?php
require "../model/staff_function.php";
$no_staff = $_POST['no_staff'];

//upload.php
$allowed_extension = ['jpg','png','heic','heif'];
$target_directory = "../../staffphoto/";
$get_current_photo = getStaffInfo($no_staff)->fetch_object()->nama_photo;
echo $get_current_photo;

if (isset($_POST["image_data"])) {
    $data = $_POST["image_data"];

    $image_array_1 = explode(";", $data);
    $type = explode("/", $image_array_1[0]);
    $extension = $type[1];

    $data_content = explode(",", $image_array_1[1]);

    $imageName = date('Ymd_his').'.'.$extension;
    $file_path = $target_directory.$imageName;

    $image_file = file_put_contents($file_path, base64_decode($data_content[1]));
}

$result = updatePhoto($no_staff, $imageName);

if ($result){
    if ($get_current_photo != "default-image.jpg"){
        //unlink file lama jika bukan default
        unlink($target_directory.$get_current_photo);
    }

    echo "<script>
            alert('Successfully update profile picture');
            window.location.href = '../view/dashboard.php'
            </script>";
}else{
    echo "<script>
            alert('Successfully update profile picture');
            window.history.back();
            </script>";
}
