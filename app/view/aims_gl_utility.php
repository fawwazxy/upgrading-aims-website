<?php
include ('../controller/auth.php');
require "../model/aims_gl_function.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <? require "../global/header.php"; ?>
    <style type="text/css">
        body {
            font-family: "Arial", serif;
        }
        th, td {
            text-align: center;
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
                <h1 class="page-header">UTILITIES EXPENSES</h1>
            </div>
        </div>

        <? $flagScreen="tab_2";
        include ('../global/aims_gl_expenses_menu.php'); ?>

        <div class="row">
            <div class="panel-heading" style="float: right">
                <button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Add New</button>
                <a href="aims_gl_utility_report.php? " target="_blank"><button type="button" class="btn btn-primary">Report</button></a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Utility List</label>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th>Description</th>
                                <th>Month</th>
                                <th>Block B No 20</th>
                                <th>Block B No 21</th>
                                <th>Total</th>
                                <th style="width: 10%;">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <? $i=1;
                            $utility = getUtilityList();
                            while($list_utility = $utility ->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><? echo $i++; ?></td>
                                    <td><? echo $list_utility['utility_desc_id']; ?></td>
                                    <td><? echo $list_utility['month']; ?> <? echo $list_utility['year']; ?></td>
                                    <td><? echo $list_utility['no_20']; ?></td>
                                    <td><? echo $list_utility['no_21']; ?></td>
                                    <td><? echo number_format($list_utility['total'],2); ?></td>
                                    <td>
                                        <a href='#myModal1' data-toggle='modal' data-id="<? echo $list_utility['id']; ?>"><span class="material-icons">border_color</span></a>
                                        <a href="../controller/aims_gl_utility_delete_exec.php?id=<? echo $list_utility['id']; ?>"><span style="color: red"  title="Delete" class="material-icons" onclick="return confirm('Are you sure you want to delete?');">delete</span></a>
                                    </td>
                                </tr>
                            <? } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Add Utility</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="../controller/aims_gl_utility_exec.php" >
                    <input id="created_by" name="created_by" type="hidden" value="<? echo $_SESSION['SESS_NAME']; ?>">

                    <div class="form-group">
                        <label for="utility_desc_id">UTILITY TYPE <span style="color: red">*</span></label>
                        <select required class="form-control" name="utility_desc_id" id="utility_desc_id">
                            <option value="">-- Choose UTILITY --</option>
                            <? echo getDropDownUtility(""); ?>
                        </select>
                    </div>

                    <div class="form-group row">
                        <div class="col-xs-4">
                            <label for="no_20">NO 20</label>
                            <input class="form-control auto-number" name="no_20" id="no_20" type="number" step="0.01" min="0" onkeyup="multi()">
                        </div>

                        <div class="col-xs-4">
                            <label for="no_21">NO 21</label>
                            <input class="form-control auto-number" name="no_21" id="no_21" type="number" step="0.01" min="0" onkeyup="multi()">
                        </div>

                        <div class="col-xs-4">
                            <label for="total">TOTAL <span style="color: red">*</span></label>
                            <input class="form-control auto-number" name="total" id="total" type="number" step="0.01" min="0" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-xs-6">
                            <label for="month">MONTH <span style="color: red">*</span></label>
                            <select required class="form-control" name="month" id="month">
                                <option>-- Choose MONTH --</option>
                                <option value="JANUARY">JANUARY</option>
                                <option value="FEBRUARY">FEBRUARY</option>
                                <option value="MARCH">MARCH</option>
                                <option value="APRIL">APRIL</option>
                                <option value="MAY">MAY</option>
                                <option value="JUNE">JUNE</option>
                                <option value="JULY">JULY</option>
                                <option value="AUGUST">AUGUST</option>
                                <option value="SEPTEMBER">SEPTEMBER</option>
                                <option value="OCTOBER">OCTOBER</option>
                                <option value="NOVEMBER">NOVEMBER</option>
                                <option value="DECEMBER">DECEMBER</option>
                            </select>
                        </div>
                        <div class="col-xs-6">
                            <label for="date-dropdown">YEAR <span style="color: red">*</span></label>
                            <select required class="form-control" id='date-dropdown' name="year"></select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Update Utility</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'aims_gl_utility_update.php',
                            data:'id='+rowid,
                            success:function(html){
                                $('#demo').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function multi(){
        var no_20 = document.getElementById('no_20').value;
        var no_21 = document.getElementById('no_21').value;

        var totals = ((+no_20) + (+no_21));
        var total = document.getElementById('total');
        total.value = totals.toFixed(2);
    }

    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    let dateDropdown = document.getElementById('date-dropdown');

    let currentYear = new Date().getFullYear();
    let earliestYear = 1970;

    while (currentYear >= earliestYear) {
        let dateOption = document.createElement('option');
        dateOption.text = currentYear;
        dateOption.value = currentYear;
        dateDropdown.add(dateOption);
        currentYear -= 1;
    }
</script>

</body>
</html>