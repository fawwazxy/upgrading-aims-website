<?php
session_start();
require "../model/staff_function.php";
$sess_id = $_SESSION['SESS_ID'];
$exp_id = $_POST['id'];
$exp_row = getExperienceListById($exp_id)->fetch_assoc();
?>
<form method="post" action="../controller/staff_previous_employment_update_exec.php" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tempat_bekerja">Tempat Bekerja: <span style="color: red; ">*</span></label>
                        <input class="form-control" id="tempat_bekerja" name="tempat_bekerja" required
                               type="text" value="<? echo $exp_row['tempat_berkerja']?>">
                        <input class="form-control" id="exp_id" name="exp_id" type="hidden" value="<? echo $exp_id; ?>">
                        <input class="form-control" id="sess_id" name="sess_id" type="hidden" value="<? echo $sess_id; ?>">
                    </div>
                    <div class="form-group">
                        <label for="jawatan">Jawatan:</label>
                        <input class="form-control" id="jawatan" name="jawatan" type="text"
                               value="<? echo $exp_row['jawatan']?>">
                    </div>
                    <div class="form-group">
                        <label for="peranan">Peranan:</label>
                        <input class="form-control" id="peranan" name="peranan" type="text"
                               value="<? echo $exp_row['peranan']?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tarikh_mula">Tarikh Mula: </label>
                        <input class="form-control" id="tarikh_mula" name="tarikh_mula" type="date"
                               value="<? echo $exp_row['tarikh_mula']?>">
                    </div>
                    <div class="form-group">
                        <label for="gaji">Gaji: </label>
                        <input class="form-control" id="gaji" min="0" name="gaji" type="number"
                               value="<? echo $exp_row['gaji']?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tarikh_akhir">Tarikh Akhir: </label>
                        <input class="form-control" id="tarikh_akhir" name="tarikh_akhir" type="date"
                               value="<? echo $exp_row['tarikh_akhir']?>">
                    </div>
                </div>
            </div>
            <div class="modal-footer text-right">
                <input class="btn btn-primary" type="submit" value="Kemaskini">
            </div>
        </div>
    </div>
</form>