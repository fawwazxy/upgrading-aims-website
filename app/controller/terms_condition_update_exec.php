<?php
    include "../model/terms_condition_function.php";

    //sanitize the POST values
    $id = clean($_POST['id']);
    $title = clean($_POST['title']);
    $description = clean($_POST['description']);

    $result = updateTerms($id, $title, $description);

    if($result == true) {
        echo "<script>
                    alert('Terms & Condition successfully updated');
                    window.location.href='../view/terms_condition_hr_list.php';
                    </script>";

    }

else{
    echo "<script>
                alert('Failed to update Terms & Condition');
                window.location.href='../view/terms_condition_hr_list.php';
                </script>";
}
