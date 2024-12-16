<?php
include ('../controller/auth.php');
require "../model/aims_gl_function.php";

$id = $_GET['id'];
$data = getDobbyById($id)->fetch_assoc();
?>

<form method="post" action="../controller/aims_gl_dobby_update_exec.php" >
    <input id="id" name="id" type="hidden" value="<? echo $id; ?>">

    <div class="form-group">
        <label for="dobby_date">DATE <span style="color: red">*</span></label>
        <input class="form-control" name="dobby_date" id="dobby_date" type="date" value="<? echo $data['dobby_date']; ?>" >
    </div>

    <div class="form-group">
        <label for="amount">AMOUNT(RM) <span style="color: red">*</span></label>
        <input class="form-control" name="amount" id="amount" value="<? echo $data['amount']; ?>">
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
                      