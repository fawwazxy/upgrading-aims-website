<?php
include "../controller/auth.php";
require "../model/v02_aims_ot_function.php";

$department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];

if (in_array($department_sub, ["HR-AGMA", "OPERATION-AGMSB", "OPERATION-BUNKER"])) {
    echo "<script>
            alert('This form cannot be filled by HR-AGMA, OPERATION-AGMSB, AND OPERATION-BUNKER')
            window.history.back();
            </script>";
    exit();
}
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
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
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
                    OVERTIME <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> PERMISSION
                        <i class="fa fa-caret-right"></i> NEW
                    <a href="aims_otpermission_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>
                        Switch to Version 01
                    </a>
                    <a href="v02_aims_ot_permission_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #FFA500; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-arrow-left" style="margin-right: 8px"></i>
                        Back to list
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_ot_migration_message.php"; ?>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        OVERTIME PERMISSION FORM
                    </div>
                    <div class="panel-body">
                        <form method="post" action="../controller/v02_aims_ot_permission_add_exec.php" enctype="multipart/form-data">
                            <div class="form-group row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="otp_date">DATE</label><br>
                                        <input type="date" class="form-control" placeholder="" id="otp_date" name="" value="<? echo date('Y-m-d')?>" readonly/>
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="applicant_name">APPLICANT</label><br>
                                        <input disabled type="text" class="form-control" placeholder="" id="applicant_name" name="" value="<?php echo $_SESSION['SESS_NAME'] ?>" />
                                    </div>
                                </div>

                                <div class="col-sm-5">
                                    <div class="form-group">
                                        <label for="approval_id">APPROVAL</label>
                                        <select required class="form-control" name="approval_id" id="approval_id">
                                            <option value="">-- HOD/SBU NAME --</option>
                                            <? echo getDropDownApproval(""); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="code_department">DEPARTMENT</label><br>
                                        <input readonly type="text" required class="form-control" placeholder="" id="code_department" name="" value="<?php echo $_SESSION['SESS_DEPARTMENT_SUB'] ?>" />
                                    </div>
                                </div>

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="rate_mode">MODE</label><br>
                                        <select required class="form-control" name="rate_mode" id="rate_mode">
                                            <? foreach (getRateMode() as $rate => $description) { ?>
                                                <option value="<? echo $rate ?>"><? echo strtoupper($description); ?></option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="description">DESCRIPTION</label><br>
                                        <textarea class="form-control" id="description" name="description" type="text" rows="1"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-success">Apply</button>
                                <button type="reset" class="btn btn-warning">Reset</button>
                            </div>
                        </form>
                    </div>

                    <div class="panel-footer">
                        <div class="form-group">
                            <label>REMINDER :</label>
                            <ol>
                                <li>THIS FORM MUST BE SUBMITTED BY YOUR LEAVE APPROVAL / HEAD OF DEPARTMENT ON SAME DAY OF OVERTIME WORK.</li>
                                <li>THIS FORM WILL BE LINKED TO OVERTIME CLAIM FOR HUMAN RESOURCE DEPARTMENT REVIEW.</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <? include "../global/footer.php"; ?>
    </div>
</div>
</body>
</html>