<?php
include "../controller/auth.php";
require "../model/v02_aims_ot_function.php";
require "../model/lookup.php";

if ($_SESSION['SESS_DEPARTMENT_SUB'] != 'HR' ) {
    echo "<script>
            alert('This section can only be accessed by Human Resources')
            window.history.back();
            </script>";
    exit();
}

$department_code = ($_GET['department_code']) ?: 'AGHSB';
$month = ($_GET['month']) ?: '0';
$year = ($_GET['year']) ?: date('Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src='https://kit.fontawesome.com/a076d05399.js'></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <? require "../global/header.php"; ?>
    <style>
        .ot-status{
            padding: 4px 8px;
            border-radius: 5px;
            font-weight: bold;
            color: #000000;
            background-color: #e7e7e7;
            border: 1px dotted black;
            white-space: nowrap;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;" >
        <? include "../global/menu_top.php"; ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <? include "../global/menu_left.php"; ?>
                </ul>
            </div>
        </div>
    </nav>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    OVERTIME PERMISSION <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> HR
                    <a href="aims_otpermission_hr.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                </h1>
            </div>
        </div>


        <form action="" method="get">
            <div class="row" style="margin-bottom: 16px">
                <div class="col-md-4">
                    <select required class="form-control" name="department_code" id="department_code">
                        <? echo getDropDown("department","code_department","description",$department_code);?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select required class="form-control" name="month" id="month">
                        <? echo v02getDropDownMonth($month);?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select required class="form-control" name="year" id="year">
                        <? for ($i=0;$i<4;$i++){
                            $option_year = date('Y')-$i; ?>
                            <option value="<? echo $option_year ?>" <? if ($year == $option_year) echo 'selected'?>>
                                <? echo $option_year ?>
                            </option>
                        <? } ?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <button type="submit" class="btn btn-info">Filter</button>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Overtime Permission List</label>
                    </div>
                    <div class="panel-body">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th style="width: 6%" class="text-center">No.</th>
                                <th style="width: 20%">Name</th>
                                <th style="width: 12%" class="text-center">Date</th>
                                <th style="width: 22%">Description</th>
                                <th style="width: 20%">Approval</th>
                                <th style="width: 12%">Remark</th>
                                <th style="width: 8%">Claim?</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $ot_permission = v02getOtPermissionHr($department_code,$month,$year);
                            $i=1;
                            while($otp = $ot_permission->fetch_assoc()) {
                                $timestamp_color = ($otp['approval_status'] == 1) ? 'GREEN':'RED';
                                $claim_status = ($otp['claim_status'] == 1) ?
                                    '<i class="fa fa-check-circle text-success"></i>' : '<i class="fa fa-times-circle text-danger"></i>';
                                ?>
                                <tr>
                                    <td class="text-center"><?php echo $i++.'.'; ?></td>
                                    <td>
                                        <p>
                                            <b><? echo $otp['applicant_name'] ?></b><br>
                                            <? echo $otp['applicant_ic'] ?><br>
                                            <? echo $otp['applicant_no'] ?><br>
                                            <span class="ot-status"><? echo $otp['created_at'] ?></span>
                                        </p>
                                    </td>
                                    <td class="text-center"><?php echo date("Y-m-d", strtotime($otp['created_at'])); ?></td>
                                    <td><?php echo $otp['description']; ?></td>
                                    <td class="text-center"><?php
                                        if (!empty($otp['approval_at'])) {
                                            $staff_app_name = $otp['approval_name'];
                                            if ($otp['approval_id'] == 'auto' || $otp['approval_id'] == '0'){
                                                $staff_app_name = 'AUTO-APPROVAL';
                                            }
                                            echo '<p>'.$staff_app_name.'</p>';
                                            echo '<span class="ot-status" style="color: #FFFFFF; background-color: '.$timestamp_color.'">' . $otp['approval_at'] . '</span>';
                                        }else{
                                            echo '<p class="text-muted" style="font-style: italic; font-weight: bold">PENDING</p>';
                                        }
                                        ?>
                                    </td>
                                    <td class="text-center"><?php echo ($otp['remark']) ?:
                                            '<i class="text-muted" style="font-size: x-small">- No remark -</i>'; ?>
                                    </td>
                                    <td class="text-center"><? echo $claim_status ?></td>
                                </tr>
                            <? } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <? include "../global/footer.php"; ?>
    </div>

    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true,
            });
        });
    </script>
</body>
</html>