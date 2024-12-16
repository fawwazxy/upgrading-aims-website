<?php
require "../controller/auth.php";
require "../model/v02_aims_others_claim_function.php";
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
        .btn-remove{
            margin: 0.25rem auto;
        }
        .mt-1{
            margin-top: 0.5rem;
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
                    CLAIM <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> NEW
                    <a href="aims_others_claim_form.php" class="btn btn-default btn-sm"
                       style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>
                        Switch to Version 01
                    </a>
                    <a href="v02_aims_others_claim_list.php" class="btn btn-default btn-sm"
                       style="float: right;background-color: #FFA500; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-arrow-left" style="margin-right: 8px"></i>
                        Back to list
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <span style="font-weight: bold; font-size: 20px">Claim Form</span>
                        <p style="font-weight: bold;font-size: 12px; margin-bottom: 0" class="text-danger">
                            REMINDER: Please attach together the related supporting document</p>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="../controller/v02_aims_others_claim_add_exec.php" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-8">
                                    <h4 class="section-header">Claim Details Section</h4>

                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label for="company_name">Company Claim:</label>
                                            <select class="form-control companySelect" id="company_name"
                                                    name="company_name" required>
                                                <option value="">-- Select Company --</option>
                                                <? echo getCompanyDropdown(''); ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="month_claim">Month Claim: </label>
                                            <select class="form-control" id='month_claim' name="month_claim"
                                                    value="" required>
                                                <? echo v02getDropDownMonthClaimSelectedNew(strtoupper(date('F Y'))) ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="job_no">Job No: <span class="small">(optional)</span></label>
                                            <input class="form-control" type="text" name="job_no" id="job_no">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-4">
                                            <label for="date_claim">Date: </label>
                                            <input type="date" class="form-control" id="date_claim" name="date_claim"
                                                   value="<? echo date('Y-m-d') ?>" disabled/>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="datetime_departure">Date Time Departure: </label>
                                            <input type="datetime-local" class="form-control" id="datetime_departure"
                                                   name="datetime_departure" value="<? echo date('Y-m-d').' 08:00'; ?>"/>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="datetime_arrival">Date Time Arrival: </label>
                                            <input type="datetime-local" class="form-control" id="datetime_arrival"
                                                   name="datetime_arrival" value="<? echo date('Y-m-d').' 17:00'; ?>"/>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="description">Details Description:</label>
                                            <textarea name="description" id="description" class="form-control" rows="9" maxlength="500"
                                                      required></textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <label for="document">Attachment: <span style="color: red; "><i>(Only pdf/jpeg/jpg/png/gif/heic/heif format file are allowed)</i></span></label>
                                            <input type="file" accept=".jpg,.jpeg,.png,.gif,.pdf,.heic,.heif"
                                                   name="document" id="document" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <h4 class="section-header">Types of Claim Section</h4>

                                    <div class="form-group row claimType">
                                        <div class="col-lg-1">
                                            <span class="">1. </span>
                                        </div>
                                        <div class="col-lg-7">
                                            <select class="form-control desc" id="description_1" name="desc[]" required>
                                                <option value="">-- Please choose a company --</option>
                                                <option style="background-color: #e3e3e3; font-weight: bold" disabled>No Cost Centre</option>
                                            </select>
                                        </div>
                                        <div class="col-lg-4 price_row">
                                            <input type="number" step="0.01" class="form-control rm_input" id="rm_input_1"
                                                 name="rm_input[]" placeholder="RM" value="" required>
                                        </div>
                                    </div>

                                    <h4 id="totalClaimSeparator" style="border-top: 1px solid #989898;"></h4>
                                    <div class="form-group row" style="margin-bottom: 48px">
                                        <div class="col-md-3">
                                            <a id="addDropdown" class="btn btn-block btn-success">
                                                <i class="fa fa-plus"></i> Add</a>
                                        </div>
                                        <div class="col-md-5 text-right">
                                            <label for="total_input">Total Claim (RM):</label>
                                        </div>
                                        <div class="col-md-4">
                                            <input type="text" class="form-control total_input" id="total_input"
                                                   name="total_input" placeholder="RM" readonly>
                                        </div>
                                    </div>

                                    <h4 class="section-header">Submit Claim Section</h4>

                                    <div class="form-group row">
                                        <div class="col-md-12">
                                            <p style="font-size: 12px">By clicking submit button below, I hereby declare that the information provided is true and correct.
                                                I also understand that I may be taken any legal action for any willful dishonesty contained in the form.</p>
                                            <button href="" type="submit" class="btn btn-block btn-primary" id="btnSubmit"
                                                    onclick="return confirm('Confirm submit claim?')">Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <? include('../global/footer.php'); ?>
    </div>
    <script type="text/javascript">
        /*Validation company dropdown*/
        $(document).ready(function () {
            $('#btnSubmit').click(function () {
                if ($("#company_name").val() === "") {
                    alert('Please select a company')
                    return false;
                }
                return true;
            });
        });

        $(document).on('change', '.companySelect', function () {
            let company_id = $(this).val();
            let staff_id = <? echo $_SESSION['SESS_ID'] ?>;
            $.ajax({
                type: 'POST',
                url: '../controller/v02_aims_others_claim_retrieve_desc.php',
                data: {id: company_id, staff_id: staff_id},
                success: function (html) {
                    $("select.desc").each(function (index, element) {
                        $(element).html(html);
                    });
                }
            });
        });

        let descCount = 1;

        $('#addDropdown').on('click', function () {
            descCount++;

            let company_id = $('.companySelect').val();
            let staff_id = <? echo $_SESSION['SESS_ID'] ?>;
            let optionList = "";
            $.ajax({
                type: 'POST',
                url: '../controller/v02_aims_others_claim_retrieve_desc.php',
                data: {id: company_id, staff_id: staff_id},
                success: function (html) {
                    optionList += '<div class="form-group row claimType" id="claimType_' + descCount + '">' +
                        '<div class="col-lg-1"><span class="mt-1">'+ descCount +'. </span></div>' +
                        '<div class="col-lg-7">' +
                        '<select class="form-control desc" id="description_' + descCount + '" name="desc[]" required>' +
                        html +
                        '</select><span title="Delete" class="btn btn-xs btn-danger btn-remove" id="deleteRow" ' +
                        'data-typeclaim="claimType_' + descCount + '" data-rm="rm_input_' + descCount + '">' +
                        '<i class="">Remove</i></span></div>' +
                        '<div class="col-lg-4 price_row">' +
                        '<input type="number" step="0.01" class="form-control rm_input" id="rm_input_' + descCount + '"' +
                        ' name="rm_input[]" placeholder="RM" value="" required>' +
                        '</div></div>'
                    $('#totalClaimSeparator').before(optionList);
                }
            });
        });

        // Delete Type Claim row + New total calculation
        $(document).on('click', '#deleteRow', function () {

            let targetElement = "#" + $(this).data('typeclaim');
            let price = "#" + $(this).data('rm');
            let price_deduction = $(price).val();
            let total_input = $('#total_input');

            /*Formula new total -> Minus remove price*/
            let new_total = total_input.val() - price_deduction;
            /*New total calculation*/
            total_input.val(new_total.toFixed(2));
            /*Remove dropdown*/
            $(targetElement).remove();
        });

        /*Total sum of array RM*/
        $(document).on('change', '.rm_input', function () {
            let subtotal = 0;
            $('.claimType').each(function () {
                let price = $(this).find(".rm_input").val();
                let int_price = parseFloat(price);
                if ($.isNumeric(int_price)) {
                    subtotal += int_price;
                }
            });
            $("#total_input").val(subtotal.toFixed(2));
        });
    </script>
</body>
</html>