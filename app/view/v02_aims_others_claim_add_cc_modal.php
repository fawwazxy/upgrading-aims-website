<?php
require "../model/v02_aims_others_claim_function.php";
$staff_id = $_SESSION['SESS_ID'];
$claim_id = $_POST['id'];
$isHumanResources = $_POST['hr'] ?: 'yes';
$res = v02getTypeClaimById($claim_id)->fetch_assoc();
?>
<form method="POST" action="../controller/v02_aims_others_claim_add_cc_exec.php">
    <input type="hidden" name="claim_id" value="<? echo $claim_id?>">
    <div class="table-responsive">
        <table class="table table-hover" id="table_database" style="width: 100%">
            <tbody>
            <tr>
                <th>Company</th>
                <td>
                    <? echo v02CompanyNameFromClaimId($claim_id); ?>
                </td>
            </tr>
            <tr>
                <th>Type Claim</th>
                <td>
                    <select class="form-control desc" name="desc" required>
                        <? $company_id = v02CompanyNameFromClaimId($claim_id, true);
                        $type_claim = v02getDropdownCostCentreByCompany($company_id,$staff_id);
                        while ($type = $type_claim->fetch_assoc()){ ?>
                            <option value="<? echo $type['id']?>" >
                                <? echo $type['cost_centre'].' - '.$type['description'];?>
                            </option>
                        <? } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Cost</th>
                <td>
                    <input type="number" step="0.01" class="form-control rm_input" id="rm_input" name="rm_input" required>
                </td>
            </tr>
            <tr>
                <th></th>
                <td class="text-right">
                    <button type="submit" class="btn btn-primary" id="btnSubmit">Add</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</form>

