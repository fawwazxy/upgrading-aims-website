<?php
require "../model/staff_function.php";
$record_id = $_POST['id'];
$record_row = getStaffRecordListById($record_id)->fetch_assoc();
?>
<form action="../controller/staff_position_record_update_exec.php" enctype="multipart/form-data" method="post">
    <div class="row">
        <div class="col-lg-12">
            <div class="form-group row">
                <div class="col-md-7">
                    <div class="form-group">
                        <label for="bank_name">Nama Bank: <span style="color: red; ">*</span></label>
                        <input class="form-control" id="bank_name" name="bank_name" required
                               type="text" value="<? echo $record_row['nama_bank']; ?>">
                        <input class="form-control" id="record_id" name="record_id" type="hidden"
                               value="<? echo $record_id; ?>">
                    </div>
                    <div class="form-group">
                        <label for="notes">Catatan: </label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"><? echo $record_row['catatan']; ?></textarea>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-group">
                        <label for="account_no">Akaun No:<span style="color: red; ">*</span></label>
                        <input class="form-control" id="account_no" name="account_no" required type="text"
                               value="<? echo $record_row['no_akaun']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="salary">Gaji: </label>
                        <input class="form-control" id="salary" name="salary"
                               oninput="this.value = this.value.replace(/[^+0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                               type="text" value="<? echo $record_row['gaji']; ?>">
                    </div>
                </div>
            </div>
            <div class="modal-footer text-right">
                <input class="btn btn-primary" type="submit" value="Kemaskini">
            </div>
        </div>
    </div>
</form>