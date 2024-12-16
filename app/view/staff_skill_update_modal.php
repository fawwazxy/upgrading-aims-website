<?php
session_start();
require "../model/staff_function.php";
$sess_id = $_SESSION['SESS_ID'];
$skill_id = $_POST['id'];
$skill_row = getSkillListById($skill_id)->fetch_assoc();
?>
<form method="post" action="../controller/staff_skill_update_exec.php" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group row">
                <div class="col-md-9">
                    <div class="form-group">
                        <label for="skill">Kemahiran: <span style="color: red; ">*</span></label>
                        <input class="form-control" id="skill" name="skill" required
                               type="text" value="<? echo $skill_row['skill']?>">
                        <input class="form-control" id="skill_id" name="skill_id" type="hidden"
                               value="<? echo $skill_id; ?>">
                        <input class="form-control" id="sess_id" name="sess_id" type="hidden"
                               value="<? echo $sess_id; ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="level">Tahap: <span style="color: red; ">*</span>&nbsp</label><br>
                        <input class="form-control" id="level" name="level" required
                               type="text" value="<? echo $skill_row['level']?>">
                    </div>
                </div>
            </div>
            <div class="modal-footer text-right">
                <input class="btn btn-primary" type="submit" value="Kemaskini">
            </div>
        </div>
    </div>
</form>