<?php
include "../controller/auth.php";
require "../model/v02_aims_ot_function.php";

$id = $_POST['id'];
$action = $_POST['action'];
$ot_info = v02getOtById($id)->fetch_assoc();
//convert hours to hours and minutes
$hours = floor($ot_info['total_hours']);
$minutes = ($ot_info['total_hours'] - $hours) * 60;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <? require "../global/header.php"; ?>
</head>
<body>
<div id="wrapper">

    <div class="row">
        <div class="col-md-12">
            <table class="table">
                <tr>
                    <th style="width: 25%">DATE / DAY</th>
                    <td>:</td>
                    <td class="text-uppercase"><? echo date("d/m/Y, l", strtotime($ot_info['date']))?></td>
                </tr>
                <tr>
                    <th>WORKING HOURS</th>
                    <td>:</td>
                    <td><?php echo sprintf("%02s",$hours).'H '.sprintf("%02s",$minutes).'M'; ?></td>
                </tr>
                <tr>
                    <th>DESCRIPTION</th>
                    <td>:</td>
                    <td><?php echo $ot_info['description']; ?></td>
                </tr>
            </table>
        </div>
    </div>

    <form method="post" action="../controller/v02_aims_ot_hod_edit_exec.php"
          enctype="multipart/form-data">
        <input type="hidden" class="form-control" placeholder="" id="id" name="id" value="<? echo $ot_info['id'] ?>" />

        <div class="form-group">
            <label for="verification_remark">Remark (if any)</label><br>
            <textarea class="form-control" id="verification_remark" name="verification_remark" type="text" onkeyup="convertToUppercase(this)"
                      rows="5"><? echo $ot_info['verification_remark']; ?></textarea>
        </div>

        <div class="text-center">
            <button type="submit" class="btn btn-block btn-primary">Update</button>
        </div>
    </form>
</div>

<script>
    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>
</body>
</html>