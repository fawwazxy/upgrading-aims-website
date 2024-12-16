<?php
include ('../controller/auth.php');
require "../model/aims_lv_medical_function.php";

$no_staff = $_GET['no_staff'];
$id = $_SESSION['SESS_ID'];
$staff_record_id = $_GET['staff_record_id'];
$staff = getStaffInformation($_SESSION['SESS_NO_STAFF'])-> fetch_assoc();
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
    <script type="text/javascript">
        function goBack() {
            window.history.back()
        }
    </script>
</head>
<style type="text/css">
    table {
        border-collapse: collapse;
        margin: 0 16px;
        padding: 0;
        table-layout: fixed;
        width: 98%;
    }
    table tr {
        background-color: #f8f8f8;
        border: 1px solid #ddd;
        padding: .35em;
    }
    table th,
    table td {
        padding: .625em;
        text-align: center;
    }
    @media screen and (max-width: 600px) {
        table thead {
            border: none;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }
        table tr {
            border-bottom: 3px solid #ddd;
            display: block;
        }
        table td {
            display: block;
            text-align: right;
        }
        table td::before {
            content: attr(data-label);
            float: left;
            font-weight: bold;
        }
    }
</style>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include ('../global/menu_top.php'); ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <!--li>
                        <center><img src="images/pic.jpg" class="user-image img-responsive"/></center>
                    </li-->
                    <? include ('../../app/global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">MEDICAL CLAIM FORM</h1>
                <div class="row">
                    <div class="col-lg-12">
                        <label>NAME &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;&nbsp;<?echo $staff['staff_name'];?>
                        <br><label>IC NUMBER &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;&nbsp;<?echo $staff['noic'];?>
                        <!--    <br><label>POSITION &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;&nbsp;<?echo $staff['role_id'];?> -->
                        <br><label>DEPARTMENT &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;&nbsp;<?echo $staff['department_sub'];?>
                        <br><label>COMPANY &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;&nbsp;<?echo $staff['company_name'];?>
                        <?
                        $staff_record_id = $staff['id'];
                        $balanceClaim = getBalanceInfo($staff_record_id) -> fetch_assoc();
                        ?>
                        <br>
                        <label>BALANCE CLAIM&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</label>&nbsp;&nbsp;RM<?echo $balanceClaim['baki_claim'];?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <form method="post" action="../controller/aims_lv_medical_exec.php" enctype="multipart/form-data">
                    <div>
                        <input name="id" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_ID'];?>" />
                        <input name="staff_record_id" type="hidden" class="input-short" value="<? echo $staff['id'];?>" />
                        <input name="staff_record_id" type="hidden" class="input-short" value="<? echo $staff_record_id;?>" />
                        <input name="department_id" type="hidden" class="input-short" value="<? echo $staff['department'];?>"/>
                        <input name="no_staff" type="hidden" class="input-short" value="<? echo $_SESSION['SESS_NO_STAFF'];?>" />
                        <input name="position" type="hidden" class="input-short" value="<? echo $staff['role_id'];?>"/>
                        <input name="code_department" type="hidden" class="input-short" value="<? echo $staff['company_name'];?>"/>
                    </div>

                    <div class="form-group text-right">
                        <input class="btn btn-primary" type="button" value="Kembali" onclick="goBack()">
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="control-label" for="date">MEDICAL CLAIM FORM</label>
                        </div>

                        <div class="panel-body">
                            <div class="form-group row">
                                <div class="col-xs-8">
                                    <label>Attachment&nbsp;<span style="color: red; "><i>(Only pdf/jpeg/jpg/png/gif format file are allowed. [MAX: 2MB])</i></span></label>
                                    <input type="hidden" name="MAX_FILE_SIZE">
                                    <input type="file" accept=".jpg,.jpeg,.png,.gif,.pdf" name="document" id="document">
                                </div>
                            </div>
                            <br><br>
                            <div class="form-group row text-center">
                                <table>
                                    <thead>
                                    <tr>
                                        <th scope="col" style="width:20%" class="text-center">DATE RECEIPT</th>
                                        <th scope="col" class="text-center">DESCRIPTION</th>
                                        <th scope="col" style=" width:20%" class="text-center">TOTAL(RM)</th></tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td data-label="DATE"><input class="input form-control" type="date" name="mec_date" style="text-transform:uppercase"value="<? echo $staffinfo['mec_date'] ?>" required></td>
                                        <td data-label="DESCRIPTION"><input class="input form-control" type="text" size="50" name="description" style="text-transform:uppercase" value="<? echo $staffinfo['description'] ?>" required></td>
                                        <td data-label="TOTAL(RM)"><input class="input form-control" type="number" name="total_claim" min="0" step="0.01" value="<? echo $staffinfo['total_claim'] ?>" required></td>
                                    </tr>
                                    </tbody>
                                </table></div>

                            <div class="col-sm-12">
                                <br>
                                <div class="form-group">
                                    <label>REMINDER</label>
                                    <p>1. PLEASE ATTACHED TOGETHER SUPPORTING DOCUMENT.</p>
                                    <p>2. THE FORM MUST BE VERIFIED BY HUMAN RESOUCES DEPARTMENT</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" align="center">
                        <button type="submit" class="btn btn-success" onclick="return Confirm()">Simpan</button>
                        <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                        <!-- <input class="btn btn-primary" type="button" value="Kembali" onclick="goBack()"> -->
                    </div>
                </form>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
<script type="text/javascript">
    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>
</body>
</html>