<?php
require "../model/v02_aims_visitor_function.php";
$current_year = date('Y');
$type = ($_GET['t'] != '') ? $_GET['t'] : '1';

$sys = getSys(1) -> fetch_assoc();
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
    <style>
        html{
            height: 100%;
        }
        body{
            background: url("../../resources/images/login-background.jpg") no-repeat fixed center;
            background-size: cover;
            height: 100%;
            width: 100%;
        }
        .app-logo{
            height: 150px;
            width: auto;
            border-radius: 8px;
            box-shadow: 10px 10px 8px #696969;
        }
        .tagline{
            margin: 4px 0 16px;
            font-style: italic;
        }
        .input-label{
            margin-right: 16px;
            padding-top: 4px;
            align-items: end;
        }
        .my-1{
            margin-top: 8px;
            margin-bottom: 8px;
        }
        .cancel-link{
            color: #a50001;
            font-weight: bold;
            float: right;
            cursor: pointer;
        }
        .form-row{
            margin-bottom: 0;
        }
        .form-group.row > div{
            padding: 0 4px
        }
    </style>
</head>
<body>
<h1 class="text-center" style="margin: 0; padding: 48px 0 24px">
    <img src="../../resources/images/app_logo.png" alt="app-logo" class="app-logo">
</h1>
<h1 style="margin-bottom: 4px" class="text-center"><? echo $sys['sys_name'] ?></h1>
<p class="tagline text-center text-muted"><? echo $sys['sys_tagline'] ?></p>
<div class="container">
    <div class="row">
        <? include "../global/it_announcement.php"; ?>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" style="box-shadow: 0 0 12px 4px #696969;">
                <div class="panel-heading">
                    <h3 class="text-center" style="margin: 2px 0"><b>Contractor and Visitor Registration</h3>
                </div>
                <div class="panel-body">
                    <div class="col-lg-9">
                        <form method="post" action="../controller/v02_aims_visitor_add_exec.php" enctype="multipart/form-data">
                            <input name="status" type="hidden" value="0">
                            <input name="auth" type="hidden" value="0">
                            <div class="form-group form-row row">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label class="control-label" for="name">Full Name: <span style="color: red; ">*</span></label>
                                        <input class="form-control" type="text" id="name" name="name" placeholder="Full Name" required>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="control-label" for="ic_number">IC Number: <span style="color: red; ">*</span></label>
                                        <input class="form-control" id="ic_number" maxlength="12" name="ic_number"
                                               oninput="this.value = this.value.replace(/[^0-9.]/g,'').replace(/(\..*)\./g,'$1');" placeholder="without dash (-)"
                                               required type="text">
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="control-label" for="phone_no">Phone No: <span style="color: red; ">*</span></label>
                                        <input class="form-control" id="phone_no" maxlength="15" name="phone_no"
                                               oninput="this.value = this.value.replace(/[^0-9.]/g,'').replace(/(\..*)\./g,'$1');" placeholder="without dash (-)"
                                               required type="text">
                                    </div>
                                </div>

                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label" for="email">Email Address: <span style="color: red; ">*</span></label>
                                        <input class="form-control" type="email" id="email" name="email" placeholder="example@xyz.com" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-5" id="companyContainer">
                                    <label class="control-label" for="company">Company</label>
                                    <small class="cancel-link" id="cancel-company" style="display: none">Cancel</small>
                                    <select class="form-control" id="company" name="company" style="display: block">
                                        <option value="custom">Other (Please specify company name)</option>
                                        <option value="" selected>-- Select Company --</option>
                                        <? $distinct_company = getDistinctCompany();
                                        while ($company = $distinct_company->fetch_assoc()) { ?>
                                            <option value="<? echo $company['company'] ?>"><? echo $company['company'] ?></option>
                                        <? } ?>
                                    </select>
                                    <input class="form-control" type="text" id="custom" name="custom" style="display: none"
                                           placeholder="Custom Company Name">
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="control-label" for="birth_year">Birth Year</label>
                                        <input type="number" class="form-control" id="birth_year" name="birth_year" value="<? echo $current_year-20 ?>"
                                               min="1955" max="<? echo $current_year ?>" step="1">
                                    </div>
                                </div>
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="control-label" for="gender">Gender</label>
                                        <select class="form-control" id="gender" name="gender">
                                            <option value="1">Male</option>
                                            <option value="0">Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <label class="control-label" for="type">Type</label>
                                        <select class="form-control" id="type" name="" style="cursor: default" disabled>
                                            <? foreach (getVisitorType('', true) as $index => $name) { ?>
                                                <option value="<? echo $index ?>" <? if($type == $index) echo 'selected'; ?>>
                                                    <? echo $name ?></option>
                                            <? } ?>
                                        </select>
                                        <input type="hidden" name="type" value="<? echo $type ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-lg btn-block btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-3">
                        <? include "v02_aims_visitor_form_notes.php"?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <? include ('../global/footer.php'); ?>
</div>
<script type="text/javascript">
    $('#company').on('change', function (){
        let companyValue = $(this).val();

        if (companyValue === 'custom'){
            $(this).attr('style', 'display: none');
            $('#custom, #cancel-company').attr('style', 'display: block');
        }
    });

    $('#cancel-company').on('click', function (){
        $('#custom, #cancel-company').attr('style', 'display: none');
        $('#custom, #company').val('');
        $('#company').attr('style', 'display: block');
    });

    $(document).on('submit', function () {
        let ic = $('#ic_number').val();
        let phone = $('#phone_no').val();
        if (ic.length < 12) {
            alert('IC Number should be 12 digits');
            return false;
        }
        if (phone.length < 10) {
            alert('Please input the correct phone number');
            return false;
        }
    });
</script>
</body>
</html>
