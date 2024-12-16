<?php
include ('../controller/auth.php');
require "../model/aims_gl_function.php";

$id = $_GET['id'];
$data = getClientById($id)->fetch_assoc();
?>

<form method="post" action="../controller/aims_gl_client_update_exec.php" >
    <input id="id" name="id" type="hidden" value="<? echo $id; ?>">

    <div class="form-group row">
        <div class="col-xs-12">
            <label for="client_name">Name <span style="color: red">*</span></label>
            <input class="form-control" name="client_name" id="client_name" onkeyup="convertToUppercase(this)" value="<? echo $data['client_name']; ?>">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-xs-6">
            <label for="client_ic">IC/Passport Number <span style="color: red">*</span></label>
            <input class="form-control" name="client_ic" id="client_ic" value="<? echo $data['client_ic']; ?>">
        </div>

        <div class="col-xs-6">
            <label for="client_phone_no">Phone Number <span style="color: red">*</span></label>
            <input class="form-control" name="client_phone_no" id="client_phone_no" value="<? echo $data['client_phone_no']; ?>">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-xs-12">
            <label for="client_company_id">Company <span style="color: red">*</span></label>
            <select  required class="form-control" name="client_company_id" id="client_company_id">
                <option value="">-- Choose Company Client --</option>
                <? echo getDropDownCompanyClient($data['client_company_id']); ?>
            </select>
        </div>
    </div>

    <div class="form-group row">
        <div class="col-xs-12">
            <label for="client_address">Address <span style="color: red">*</span></label>
            <input class="form-control" onkeyup="convertToUppercase(this)" name="client_address" id="client_address" value="<? echo $data['client_address']; ?>">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-xs-6">
            <label for="client_state">State  <span style="color: red">*</span></label>
            <select  required class="form-control" name="client_state" id="client_state">
                <option value="">-- Choose State --</option>
                <? echo getDropDownState($data['client_state']); ?>
            </select>
        </div>

        <div class="col-xs-6">
            <label for="client_city">City  <span style="color: red">*</span></label>
            <input class="form-control" onkeyup="convertToUppercase(this)" name="client_city" id="client_city" value="<? echo $data['client_city']; ?>">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-xs-6">
            <label for="client_postcode">Postcode <span style="color: red">*</span></label>
            <input class="form-control" name="client_postcode" id="client_postcode" value="<? echo $data['client_postcode']; ?>">
        </div>
        <div class="col-xs-6">
            <label for="client_car">Car Registration</label>
            <input class="form-control" onkeyup="convertToUppercase(this)" name="client_car" id="client_car" value="<? echo $data['client_car'];?>">
        </div>
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>
<script type="text/javascript">
    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>

                      