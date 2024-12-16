<?php session_start();
require "../model/v02_aims_others_claim_function.php";

$staff_id = $_SESSION['SESS_ID'];
$id = $_POST['id'];
$claim_id = $_POST['claim_id'];

$res = v02getTypeClaimById($id)->fetch_assoc();
?>
<form method="POST" action="../controller/v02_aims_others_claim_list_cc_modal_exec.php">
    <input type="hidden" id="id" name="id" value="<? echo $id; ?>">
    <input type="hidden" id="claim_id" name="claim_id" value="<? echo $claim_id; ?>">
    <div class="table-responsive">
        <table class="table table-hover" id="table_database" style="width: 100%">
            <tbody>
            <tr>
                <th>Company</th>
                <td colspan="2">
                    <?php echo v02CompanyNameFromClaimId($res['claim_id']); ?>
                </td>
            </tr>
            <tr>
                <th>Type Claim</th>
                <td>
                    <select class="form-control desc" id="desc" name="desc" required>
                        <? $company_id = v02getCostCentreInfoById($res['company_cc_id'])->fetch_object()->company_id;
                        $type_claim = v02getDropdownCostCentreByCompany($company_id,$staff_id);
                        while ($type = $type_claim->fetch_assoc()){ ?>
                            <option value="<? echo $type['id']?>" <? echo ($type['id'] == $res['retrieve_claim_id']) ? 'selected' :''; ?>>
                                <? echo $type['cost_centre'].' - '.$type['description'];?>
                            </option>
                        <? } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Cost</th>
                <td colspan="2">
                    <input type="number" step="0.01" class="form-control rm_input" id="rm_input"
                           name="rm_input" value="<? echo $res['total'];?>" required>
                </td>
            </tr>
            <tr>
                <th></th>
                <td class="text-right">
                    <button href="" type="submit" class="btn btn-primary" id="btnSubmit">Update</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</form>

