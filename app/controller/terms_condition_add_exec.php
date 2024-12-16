<?php
    include "../model/terms_condition_function.php";

    //sanitize the POST values
    $title = clean($_POST['title']);
    $description = clean($_POST['description']);



    $targetDir = "../../company_documents/";
    if($_FILES['document']['size'] > 0) {

        $document_size = $_FILES['document']['size'];
        $file_tmp = $_FILES['document']['tmp_name'];
        $file_name = $_FILES['document']['name'];

        $array2 = explode(".", $file_name);
        $document_type = end($array2); //get "jpg" string

        $document_name= $title.'.'.$document_type;
        $file_path = $targetDir . $document_name;
        $extensions= array('jpg','jpeg','png','pdf','heic','heif');

        if(in_array(strtolower($document_type),$extensions)=== false){
            $errors[]="Format fail tidak diterima, sila pilih fail JPG, PNG, HEIC, HEIF atau PDF.";
        }
        if($file_size > 10175639){
            $errors[]='File size must be below 10 MB';
        }

        if(empty($errors)==true){
            if (!is_dir($targetDir)) {//if dir != filepath
                mkdir($targetDir,0777,true);
            }
            //=====================================
                //imagick
                $uploadedFile = $_FILES["document"];
                $tmpFileName = $uploadedFile["tmp_name"];

                $imagick = new Imagick(); // Create an Imagick object
                $imagick->setBackgroundColor('white');

                $imagick->setResolution(150, 150); //For better quality

                try {
                    $imagick->readImage($file_tmp);

                } catch (ImagickException $e) {
                    echo $e;
                }

                // Convert the first page of the PDF to an image
                $imagick->setIteratorIndex(0); // Set the iterator to the first page)
                $imagick->setImageAlphaChannel(Imagick::ALPHACHANNEL_REMOVE);
                $imagick->setImageFormat('jpg');

                $image_name= $title.'.'.'jpg';
                $imagePath = $targetDir . $image_name;
                file_put_contents($imagePath,(string) $imagick);
            //=====================================

                move_uploaded_file($file_tmp,$file_path);
        }else{
            $err_text = '';
            foreach ($errors as $error){
                $err_text .= "- ".$error."<br>";
            }
        }
    }

    $result = addNewTerms($title, $description, $file_path,$imagePath);

    if($result == true) {
        echo "<script>
                alert('Terms & Condition successfully added');
                window.location.href='../view/terms_condition_hr_list.php';
                </script>";

    }

    else{
        echo "<script>
                alert('Terms & Condition failed to add');
                window.location.href='../view/terms_condition_hr_list.php';
                </script>";
    }
