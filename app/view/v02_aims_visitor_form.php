<?php
require "../controller/auth.php";
require "../model/v02_aims_visitor_function.php";

$current_year = date('Y');
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
        .cancel-link{
            color: #a50001;
            font-weight: bold;
            float: right;
            cursor: pointer;
        }
        .card-notes{
            background-color: rgba(255,240,0,0.4);
            padding: 8px;
            border-radius: 0 12px 0 12px;
            height: 100%;
            box-shadow: 6px 6px 4px #808080;
            border: 1px solid #000000;
        }
    </style>
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
                    VISITOR <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> NEW
                    <a href="v02_aims_visitor_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #FFA500; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-arrow-left" style="margin-right: 8px"></i>
                        Back to list
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_visitor_migration_message.php"; ?>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label">Visitor registration form</label>
                    </div>

                    <div class="panel-body">
                        <div class="col-lg-9">
                            <form method="post" action="../controller/v02_aims_visitor_add_exec.php" enctype="multipart/form-data">
                                <div class="form-group row">
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
                                    <div class="col-lg-4" id="companyContainer">
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
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="control-label" for="type">Type</label>
                                            <select class="form-control" id="type" name="type">
                                                <? foreach (getVisitorType('', true) as $index => $name) { ?>
                                                    <option value="<? echo $index ?>"><? echo $name ?></option>
                                                <? } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-2">
                                        <div class="form-group">
                                            <label class="control-label" for="status">Status</label>
                                            <select class="form-control" id="status" name="status">
                                                <? foreach (getVisitorStatus('', true) as $index => $status) { ?>
                                                    <option value="<? echo $index ?>"><? echo $status ?></option>
                                                <? } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-lg-6 col-lg-offset-3">
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
    </div>
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
