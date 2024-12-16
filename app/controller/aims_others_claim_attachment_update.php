<?
require "../model/aims_others_claim_hod_function.php";

$id = clean($_POST['id']);
$targetDir = "../../othersclaimphoto/";

if ($_FILES['document']['size'] <= 0){
    echo "<script>
            alert('No document were detected!');
           history.back();
            </script>";
    exit();
}else{
    $document_size = $_FILES['document']['size'];
    $tmp_name = $_FILES['document']['tmp_name'];
    $documentName = $_FILES['document']['name'];

    $array2 = explode(".", $documentName);
    $document_type = end($array2); //get "jpg" string

    $document_name= date('Ymd_His').'_'.$documentName;
    $targetPath = $targetDir . $document_name;
    $extensions= array('JPG','JPEG','PNG','GIF','PDF','jpg','jpeg','png','gif','pdf');

    if(in_array($document_type,$extensions)=== false){
        $errors[]="extension not allowed, please choose a JPEG or PNG file.";
    }
    if($document_size > 4194304){
        $errors[]='File size must be below 4 MB';
    }

    if(empty($errors)==true){
        $docName = getLampiranInfo($id)->fetch_object()->document_name; // pick old file name
        $filepath = '../../othersclaimphoto/'.$docName; // declare full path

        move_uploaded_file($tmp_name,$targetPath);
        $result = updateAttachment($id,$document_name,$document_type);

        //Check whether the query was successful or not
        if($result!="" && $result > 0) {
            if (!empty($docName)){ unlink($filepath); }
            echo ("<script>
                    alert('Successfully update Claim Attachment.');
                    history.back();
                    </script>");
            exit();
        }
    }else{
        $err_text = '';
        foreach ($errors as $error){
            $err_text .= "- ".$error."<br>";
        }
        echo "<script>
                alert('Error occur: '.$err_text);
                    history.back();
                </script>";
    }
}