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
                <h1 class="page-header">TRANSPORTATION EXPENSES</h1>
            </div>
        </div>

        <? $flagScreen="tab_3";
        include ('../global/aims_gl_expenses_menu.php'); ?>

        <div class="row">
            <div class="panel-heading" style="float: right">
                <button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Add New</button>
                <a href="aims_gl_transport_report.php? " target="_blank">
                    <button type="button" class="btn btn-primary">Report</button></a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Transportation Expenses List</label>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th>Company Vehicle</th>
                                <th>Date</th>
                                <th>Mileage In</th>
                                <th>Mileage Out</th>
                                <th>Total Mileage</th>
                                <th>Total Petrol (RM)</th>
                                <th style="width: 10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <? $i=1;
                            $utility = getTransportList();
                            while($list_utility = $utility ->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><? echo $i++; ?></td>
                                    <td><? echo $list_utility['company_vehicle']; ?></td>
                                    <td><? echo $list_utility['date_use']; ?></td>
                                    <td><? echo $list_utility['mileage_in']; ?></td>
                                    <td><? echo $list_utility['mileage_out']; ?></td>
                                    <td><? echo $list_utility['total_mileage']; ?></td>
                                    <td><? echo $list_utility['total']; ?></td>
                                    <td>
                                        <a href='#myModal1' data-toggle='modal' data-id="<? echo $list_utility['id'];?>"><span class="material-icons">border_color</span></a>
                                        <a href="../controller/aims_gl_transport_delete_exec.php?id=<? echo $list_utility['id']; ?>"><span style="color: red"  title="Delete" class="material-icons" onclick="return confirm('Are you sure you want to delete?');">delete</span></a>
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
                <h4 class="modal-title" id="myModalLabel">Add Transport</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="../controller/aims_gl_transport_exec.php" >
                    <input id="created_by" name="created_by" type="hidden" value="<?php echo $_SESSION['SESS_NAME']; ?>"/>

                    <div class="form-group">
                        <label for="company_vehicle">COMPANY VEHICLE <span style="color: red">*</span></label>
                        <input class="form-control" name="company_vehicle" id="company_vehicle" required onkeyup="convertToUppercase(this)">
                    </div>

                    <div class="form-group">
                        <label for="date_use">DATE <span style="color: red">*</span></label>
                        <input class="form-control" id="date_use" name="date_use" type="date">
                    </div>

                    <div class="form-group row">
                        <div class="col-xs-4">
                            <label for="mileage_in">MILEAGE IN <span style="color: red">*</span></label>
                            <input class="form-control" name="mileage_in" id="mileage_in" type="number" step="0.01" min="0" required onkeyup="subtract()">
                        </div>

                        <div class="col-xs-4">
                            <label for="mileage_out">MILEAGE OUT <span style="color: red">*</span></label>
                            <input class="form-control" name="mileage_out" id="mileage_out" type="number" step="0.01" min="0" required onkeyup="subtract()">
                        </div>

                        <div class="col-xs-4">
                            <label for="total_mileage">TOTAL MILEAGE <span style="color: red">*</span></label>
                            <input class="form-control" name="total_mileage" id="total_mileage" type="number" step="0.01" min="0" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="total">TOTAL PETROL</label>
                        <input class="form-control" id="total" name="total" type="number" step="0.01" min="0">
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
                <h4 class="modal-title" id="myModalLabel">Update Transport</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'aims_gl_transport_update.php',
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
    function subtract(){
        var mileage_in = document.getElementById('mileage_in').value;
        var mileage_out = document.getElementById('mileage_out').value;

        var t = (mileage_out - mileage_in);
        var totall = (t * 0.9);
        var totals = t;
        var total_mileage = document.getElementById('total_mileage');
        total_mileage.value = totals;
        var total = document.getElementById('total');
        total.value = totall.toFixed(2);
    }

    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>>

</body>
</html>