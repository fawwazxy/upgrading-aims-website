<?php
include ('../controller/auth.php');
require "../model/aims_gl_function.php";
require "../model/lookup.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
    <? require "../global/header.php"; ?>
    <style type="text/css">
        body {
            font-family: "Arial", serif;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include ('../global/menu_top.php'); ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Add Client</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel panel-body">
                        <form method="post" action="../controller/aims_gl_client_exec.php" enctype="multipart/form-data">
                            <input id="id" name="id" type="hidden" value="<? echo $_SESSION['SESS_NAME']; ?>"/>

                            <div class="form-group row">
                                <div class="col-xs-12">
                                    <label for="client_name">Name <span style="color: red">*</span></label>
                                    <input class="form-control" name="client_name" id="client_name" required onkeyup="convertToUppercase(this)">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-xs-4">
                                    <label for="client_ic">IC/Passport Number <span style="color: red">*</span></label>
                                    <input class="form-control" name="client_ic" id="client_ic" required>
                                </div>

                                <div class="col-xs-4">
                                    <label for="client_phone_no">Phone Number <span style="color: red">*</span></label>
                                    <input class="form-control" name="client_phone_no" id="client_phone_no" required>
                                </div>

                                <div class="col-xs-4">
                                    <label for="client_car">Car Registration</label>
                                    <input class="form-control" name="client_car" id="client_car" onkeyup="convertToUppercase(this)">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-xs-4">
                                    <label for="client_company_id">Company <span style="color: red">*</span></label>
                                    <select  required class="form-control" name="client_company_id" id="client_company_id">
                                        <option value="">-- Choose Company Client --</option>
                                        <? echo getDropDownCompanyClient("");?>
                                    </select>
                                </div>

                                <div class="col-xs-8">
                                    <label for="client_address">Address <span style="color: red">*</span></label>
                                    <input class="form-control" name="client_address" id="client_address" required onkeyup="convertToUppercase(this)">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-xs-4">
                                    <label for="client_state">State</label>
                                    <select class="form-control" name="client_state" id="client_state">
                                        <option value="">-- Choose State --</option>
                                        <? echo getDropDownState("");?>
                                    </select>
                                </div>

                                <div class="col-xs-4">
                                    <label for="client_city">City</label>
                                    <input class="form-control" name="client_city" id="client_city" onkeyup="convertToUppercase(this)">
                                </div>

                                <div class="col-xs-4">
                                    <label for="client_postcode">Postcode</label>
                                    <input class="form-control" name="client_postcode" id="client_postcode">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-xs-4">
                                    <label for="document">Attachment <span style="color: red; "><i>(Only pdf/jpeg/jpg/png/heic/heif format file are allowed)</i></span></label>
                                    <input type="file" accept=".jpg,.jpeg,.png,.pdf,.heic,.heif" name="document" id="document" class="form-control">
                                </div>
                            </div>

                            <div style="text-align: right">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="reset" class="btn btn-secondary">Reset</button>
                            </div>
                        </form>
                    </div>
                </div>
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