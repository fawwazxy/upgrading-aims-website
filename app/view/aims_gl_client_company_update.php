<?php
include ('../controller/auth.php');
require "../model/aims_gl_function.php";
$id = $_GET['id'];
$data = getCLientCompanyById($id)->fetch_assoc();
?>

<form method="post" action="../controller/aims_gl_client_company_update_exec.php" >
    <input id="id" name="id" type="hidden" value="<? echo $id; ?>">

    <div class="form-group">
        <label for="code_company">Company Code <span style="color: red">*</span></label>
        <input class="form-control" name="code_company" id="code_company" onkeyup="convertToUppercase(this)" value="<? echo $data['code_company']; ?>" >
    </div>

    <div class="form-group">
        <label for="company_name">Company Name <span style="color: red">*</span></label>
        <input class="form-control" name="company_name" id="company_name" onkeyup="convertToUppercase(this)" value="<? echo $data['company_name']; ?>" >
    </div>

    <div class="form-group">
        <label for="status">Status: <? echo $data['status']; ?></label><br>
        <input type="radio" id="status" name="status" <? if($data['status']=="1") {echo "checked";} ?> value="1"> Active
        <input type="radio" id="status" name="status" <? if($data['status']=="0") {echo "checked";} ?> value="0"> Inactive
    </div>

    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Save</button>
    </div>
</form>