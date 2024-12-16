<?php
require "../model/dashboard_functions.php";
$id = $_POST['id'];
$info = getStaffById($id)->fetch_assoc();
?>
<form method="post" action="../controller/dashboard_update_email.php" enctype="multipart/form-data">
    <input type="hidden" id="id" name="id" value="<? echo $id; ?>" required/>
    <div class="form-group row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="email">Email Address <span style="color: red; ">*</span></label>
                <input class="form-control" type="email" name="email" id="email" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="phoneNo">Phone Number</label>
                <input class="form-control" id="phoneNo" maxlength="15" name="phoneNo"
                       oninput="this.value = this.value.replace(/[^+0-9.]/g, '').replace(/(\..*)\./g, '$1');" type="text"
                       value="<? echo (empty($info['phone'])) ? '+60' : $info['phone']; ?>">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div style="float: right">
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function () {
        $("#phoneNo").change(function () {
            let phone = $('#phoneNo').val();
            if (phone.length < 10){
                alert('Sila masukkan nombor telefon yang betul');
                return false;
            }
        })
    });
</script>
