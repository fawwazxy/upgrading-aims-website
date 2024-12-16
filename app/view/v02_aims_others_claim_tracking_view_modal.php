<?php
require "../model/v02_aims_others_claim_function.php";
$id = $_POST['id'];
$tracking = getTrackingNoById($id);
?>
<form method="post" action="../controller/v02_aims_others_claim_update_tracking_no_exec.php" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<? echo $id; ?>">
    <div class="row">
        <div class="col-md-3">
            <label for="tracking_no">Tracking No: </label>
        </div>
        <div class="col-md-9">
            <input type="text" class="form-control" id="tracking_no" name="tracking_no" value="<? echo ($tracking)?: ''; ?>"/>
        </div>
        <div class="col-md-12">
            <button class="btn btn-primary" style="float: right; margin-top: 10px;" href="" id="btnSubmit" onclick="return confirm('Confirm update tracking no?')"
                    type="submit">Update</button>
        </div>
    </div>
</form>

<!--<table class="table table-bordered table-hover" id="dataTables-modal" style="width: 100%">
    <thead>
    <tr>
        <th style="width: 6%;">#</th>
        <th style="width: 15%;">Month Claim</th>
        <th>Description</th>
        <th style="width: 15%;">Total Claim</th>
        <th style="width: 25%;">Tracking No</th>
    </tr>
    </thead>
    <tbody>
    <?/* $i = 1;
    $tracking_list = v02getTrackingNoByClaimId($staff_id,$month_claim);
    while($list = $tracking_list->fetch_assoc()) { */?>
        <tr>
            <td><?/* echo $i++; */?></td>
            <td><b><?/* echo $list['month_claim']; */?></b></td>
            <td><?/* echo $list['description']; */?></td>
            <td><?/* echo 'RM '.number_format($list['total_claim'],2); */?></td>
            <td><?/* echo $list['tracking_no']; */?></td>
        </tr>
        <?/*
    }
    */?>
    </tbody>
</table>-->