<?php
require "../model/v02_aims_visitor_function.php";
$id = $_POST['id'];
$type = $_POST['type'];
$company = $_POST['company'];
$gender = $_POST['gender'];
$statusv= $_POST['status'];
$visitor = getVisitorListById($id)->fetch_assoc();
?>
<style>
    .account-status{
        margin: 4px 8px;
        padding: 4px 16px;
        border: 3px solid grey;
        border-radius: 5px;
        font-weight:bold;
        color: grey;
        cursor: pointer;
    }

    .account-status.active{
        border: 3px solid #003380;
        color: #002080;
        box-shadow: 0 0 8px 1px #1933d9;
    }
    .mr-1{
        margin-right: 1rem;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <form method="post" action="../controller/v02_aims_visitor_update_status_exec.php" enctype="multipart/form-data">
            <input type="hidden" name="id" id="id" value="<? echo $id; ?>">
            <input type="hidden" name="page_type" id="page_type" value="<? echo $type; ?>">
            <input type="hidden" name="company" id="company" value="<? echo $company; ?>">
            <input type="hidden" name="gender" id="gender" value="<? echo $gender; ?>">
            <input type="hidden" name="status" id="status" value="<? echo $status; ?>">
            <div class="form-group">
                <label class="control-label mr-1" for="status">Status: </label>
                <? foreach (getVisitorStatus('', true) as $index => $status) { ?>
                    <label for="input_type_<? echo $index ?>" id="type_<? echo $index ?>" class="account-status <? if ($index == $visitor['status']) echo 'active';?>"
                           data-value="<? echo $index ?>"><? echo $status ?></label>
                    <input style="display: none" type="radio" id="input_type_<? echo $index ?>" name="type" value="<? echo $index ?>"
                        <?php if($index == $visitor['status']) {echo "checked";}?> required>
                <? } ?>
            </div>
            <div class="form-group row">
                <div class="col-lg-12">
                    <button type="submit" class="btn btn-lg btn-block btn-primary">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(".account-status").on('click',function() {
        let element = '#type_' + $(this).data('value');
        $(".account-status").removeClass('active');

        $(element).addClass('active');
    });
</script>
