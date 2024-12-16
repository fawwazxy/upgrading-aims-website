<?php

    require "../model/terms_condition_function.php";
    $id = $_POST['id'];
    $terms = getTermsById($id)->fetch_assoc();
?>

<form method="post" action="../controller/terms_condition_update_exec.php" enctype="multipart/form-data">
    <input type="hidden" class="input-short" name="id" value="<? echo $id;?>" />
    <div class="form-group">
        <div class="form-group">
            <label class="control-label" for="title">Title: <span style="color: red; ">*</span></label>
            <input class="form-control" type="text" id="title" name="title" value="<? echo $terms['title'] ?>" required>
        </div>

        <div class="form-group" >
            <label class="control-label" for="description">Description: <span style="color: red; ">*</span></label><br>
            <textarea class="form-control" rows="2" id="description" name="description" required><? echo $terms['description'] ?></textarea>
        </div>
        <br>
        <button type="submit" id="update_submitBtn" class="btn btn-block btn-success btn-rounded btn-md ml-4" onclick="return Confirm()">Update</button>
    </div>
</form>
