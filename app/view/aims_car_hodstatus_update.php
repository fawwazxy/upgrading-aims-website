<?php
include "../controller/auth.php";
require "../model/aims_carReserve_function.php";

$id = $_GET['id'];
$raw_data = getcarRequestById($id)->fetch_assoc();
?>
<form method="post" action="../controller/aims_carstatusHod_update.php?id=<? echo $id ?>" >
    <input type="hidden" name="id" value="<?php echo $raw_data['id']; ?>">
    <div class="form-group">
        <label>Name Applicant&nbsp;</label>
        <br><?php echo $raw_data['name'];?><br>
    </div>

    <div class="form-group">
        <label class="control-label">HOD/SBU (Approval)</label>
        <br><?php echo $_SESSION['SESS_NAME']; ?>
        <input type="hidden" name="approve_by" value="<?php echo $_SESSION['SESS_NAME']; ?>"/>
    </div>

    <div class="form-group">
        <label for="sbu_hod_app">Status:</label><br>
        <input type="radio" name="sbu_hod_app" id="sbu_hod_app" <?php if($raw_data['sbu_hod_app']=="PENDING") {echo "checked";}?> value="PENDING"> PENDING
        <input type="radio" name="sbu_hod_app" id="sbu_hod_app" <?php if($raw_data['sbu_hod_app']=="APPROVE") {echo "checked";}?> value="APPROVE"> APPROVE
        <input type="radio" name="sbu_hod_app" id="sbu_hod_app" <?php if($raw_data['sbu_hod_app']=="DISAPPROVE") {echo "checked";}?> value="DISAPPROVE"> DISAPPROVE
    </div>

    <button type="submit" class="btn btn-block btn-primary">Save</button>
</form>
                      