<?php
session_start();
require "../model/staff_function.php";
$sess_id = $_SESSION['SESS_ID'];
$edu_id = $_POST['id'];
$edu_row = getEducationListById($edu_id)->fetch_assoc();
?>
<form method="post" action="../controller/staff_education_update_exec.php" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="cost_centre">Pencapaian : <span style="color: red">*</span></label>
                        <input class="form-control" type="text" name="pencapaian" id="cost_centre" value="<? echo $edu_row['pencapaian']?>" required>
                        <input class="form-control" type="hidden" name="edu_id" id="edu_id" value="<? echo $edu_id; ?>">
                        <input class="form-control" type="hidden" name="sess_id" id="sess_id" value="<? echo $sess_id; ?>">
                    </div>
                    <div class="form-group">
                        <label for="tempat">Tempat: </label>
                        <input class="form-control" type="text" name="tempat" id="tempat" value="<? echo $edu_row['tempat']?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tahun_mula">Tahun Mula: </label>
                        <input class="form-control" type="number" name="tahun_mula" id="tahun_mula" min="0" maxlength="4" value="<? echo ($edu_row['tahun_mula'] != '0000')?$edu_row['tahun_mula']:''; ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="tahun_akhir">Tahun Akhir: </label>
                        <input class="form-control" type="number" name="tahun_akhir" id="tahun_akhir" min="0" value="<? echo ($edu_row['tahun_akhir'] != '0000')?$edu_row['tahun_akhir']:''; ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="keputusan">Keputusan: </label>
                        <input class="form-control" type="text" name="keputusan" id="keputusan" value="<? echo $edu_row['keputusan']?>">
                    </div>
                </div>
            </div>
            <div class="modal-footer text-right">
                <input type="submit" class="btn btn-primary" value="Kemaskini">
            </div>
        </div>
    </div>
</form>



