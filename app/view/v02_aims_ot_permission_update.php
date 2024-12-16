<?php
include "../controller/auth.php";
require "../model/v02_aims_ot_function.php";

$id = $_POST['id'];
$ot_permission = v02getOtPermissionById($id)->fetch_assoc();
?>
<div id="wrapper">
    <form method="post" action="../controller/v02_aims_ot_permission_update_exec.php"
          enctype="multipart/form-data">
        <input type="hidden" class="form-control" placeholder="" id="id" name="id" value="<? echo $ot_permission['id'] ?>" />
        <div class="form-group row">
            <div class="col-md-6">
                <label for="otp_date">DATE</label>
                <input readonly type="date" class="form-control" id="otp_date" name="" value="<? echo date("Y-m-d", strtotime($ot_permission['created_at'])) ?>" />
            </div>

            <div class="col-md-6">
                <label for="rate_mode">MODE</label>
                <select required class="form-control" name="rate_mode" id="rate_mode" <? echo !empty($ot_permission['approval_at']) ? 'disabled' : ''; ?>>
                    <? foreach (getRateMode() as $rate => $description) { ?>
                        <option value="<? echo $rate ?>" <? if ($ot_permission['rate_mode'] == $rate) echo 'selected'?>>
                            <? echo strtoupper($description); ?></option>
                    <? } ?>
                </select>
                <? if (!empty($ot_permission['approval_at'])){ ?>
                    <input type="hidden" name="rate_mode" value="<? echo $ot_permission['rate_mode']?>">
                <? } ?>
            </div>
        </div>

        <div class="form-group">
            <label for="approval_id">APPROVAL</label>
            <select required class="form-control" name="approval_id" id="approval_id" <? echo !empty($ot_permission['approval_at']) ? 'disabled' : ''; ?>>
                <option value="">-- HOD/SBU NAME --</option>
                <? echo getDropDownApproval($ot_permission['approval_id']); ?>
            </select>
            <? if (!empty($ot_permission['approval_at'])){ ?>
                <input type="hidden" name="approval_id" value="<? echo $ot_permission['approval_id']?>">
            <? } ?>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" rows="5" id="description" name="description" placeholder="Your description here..."><? echo $ot_permission['description'] ?></textarea>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-block btn-primary" style="margin-top: 2rem">UPDATE</button>
        </div>
    </form>
</div>