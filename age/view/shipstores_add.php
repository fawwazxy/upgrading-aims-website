<?php session_start();
require "../model/aims_ssr_function.php";

$ssr_id = $_POST['id'];
$ssr_name = $_POST['no'];

?>

<form method="post" action="../controller/aims_ssr_add_exec.php" enctype="multipart/form-data">
    <input type="hidden" id="ssr_id" name="ssr_id" value="<?php echo $ssr_id?>" />
    <input type="hidden" id="ssr_name" name="ssr_name" value="<?php echo $ssr_name?>" />
    <div class="row" >
        <div class="col-lg-12">
            <div class="panel-body">
                <div class="col-sm-12">
                    <div class="form-group row" align="left">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>Description Of Items:</label> <font color="red">*</font>
                                <textarea class="form-control" name="descItem" id="descItem" rows="4" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label style="margin-top: 8px">Unit :</label> <font color="red">*</font>
                                <input class="form-control" type="text" name="unit" id="unit" value="PCS" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label style="margin-top: 8px">Quantity Required:</label> <font color="red">*</font>
                                <input type="number" class="form-control" id="quantity_required" name="quantity_required" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <div id="head2">
                                    <label style="margin-top: 8px">Balance On Board:</label> <font color="red">*</font>
                                    <input type="number" class="form-control" id="balance_board" name="balance_board" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label style="margin-top: 8px">Quantity Approved: </label><font color="red">*</font>
                                <input type="number" class="form-control" id="quantity_approved" name="quantity_approved" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row" align="left" >
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>IMPA Code: </label> <font color="red">*</font>
                                <input type="text" class="form-control" id="impa_code" name="impa_code" value="NONE" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Remarks: </label> <font color="red">*</font>
                                <input type="text" class="form-control" id="remarks" name="remarks" required>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <div align="right">
                            <button href="" type="submit" class="btn btn-primary" id="btnSubmit" onclick="return confirm('Confirm submit form?')">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>


