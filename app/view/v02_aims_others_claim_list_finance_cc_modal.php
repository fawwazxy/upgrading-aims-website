<?php session_start();
require "../model/v02_aims_others_claim_function.php";
$id = $_SESSION['SESS_ID'];
$department = $_SESSION['SESS_DEPARTMENT'];
$sys = getSys(1)-> fetch_assoc();

$id_cc = $_POST['id'];
$getid = $_POST['get_id'];

$res = v02getTypeClaimById($id_cc)->fetch_assoc();

?>
<form method="POST" action="../controller/v02_aims_others_claim_list_finance_cc_modal_exec.php">
    <div class="table-responsive">
        <table class="table table-hover" id="table_database" style="width: 100%">
            <tbody>
            <tr>
                <th>Company</th>
                <td colspan="2">
                    <?php echo v02CompanyNameFromClaimId($res['claim_id']); ?>
                    <input type="hidden" id="id" name="id" value="<? echo $id_cc; ?>">
                    <input type="hidden" id="getid" name="getid" value="<? echo $getid; ?>">
                </td>

            </tr>
            <tr>
                <th>Type Claim</th>
                <td>
                    <select class="form-control desc" id="desc1" name="desc" required>
                        <? $company_id = v02getCostCentreInfoById($res['company_cc_id'])->fetch_object()->company_id;
                        $type_claim = v02getDropdownCostCentreOpenByCompany($company_id);
                        while ($type = $type_claim->fetch_assoc()){ ?>
                            <option value="<? echo $type['id']?>" <? echo ($type['id'] == $res['company_cc_id']) ? 'selected' :''; ?>>
                                <? echo $type['cost_centre'].' - '.$type['description'];?>
                            </option>
                        <? } ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th>Cost</th>
                <td colspan="2"><input type="text" class="form-control rm_input" style="" id="rm_input" name="rm_input" value="<? echo $res['total'];?>"
                                       oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" disabled></td>
            </tr>
            <tr>
                <th></th>
                <td class="text-right">
                    <button href="" type="submit" class="btn btn-primary" id="btnSubmit">SAVE CHANGES</button>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</form>

