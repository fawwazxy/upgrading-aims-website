<?php
session_start();
require "../model/staff_function.php";
$sess_id = $_SESSION['SESS_ID'];
$family_id = $_POST['id'];
$family_row = getFamilyListById($family_id)->fetch_assoc();
?>
<form action="../controller/staff_family_update_exec.php" enctype="multipart/form-data" method="post">
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group row">
                <div class="col-md-9">
                    <div class="form-group">
                        <label for="name">Nama: <span style="color: red; ">*</span></label>
                        <input class="form-control" id="name" name="name" required
                               type="text" value="<? echo $family_row['nama']; ?>">
                        <input class="form-control" id="family_id" name="family_id" type="hidden"
                               value="<? echo $family_id; ?>">
                        <input class="form-control" id="sess_id" name="sess_id" type="hidden"
                               value="<? echo $sess_id; ?>">
                    </div>
                    <div class="form-group">
                        <label for="work">Pekerjaan:</label>
                        <input class="form-control" id="work" name="work" type="text"
                               value="<? echo $family_row['pekerjaan']; ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="relationship">Hubungan: <span style="color: red; ">*</span></label>
                        <input class="form-control" id="relationship" name="relationship" required
                               type="text" value="<? echo $family_row['hubungan']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone: </label>
                        <input class="form-control" id="phone" maxlength="15" name="phone" oninput="this.value = this.value.replace(/[^+0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                               type="text" value="<? echo ($family_row['phone'] != '+60' && !empty($family_row['phone']))?$family_row['phone']:'+60'; ?>">
                    </div>
                </div>
            </div>
            <div class="modal-footer text-right">
                <input class="btn btn-primary" id="addSubmit" type="submit" value="Kemaskini">
            </div>
        </div>
    </div>
</form>