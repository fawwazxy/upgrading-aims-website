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
                <h1 class="page-header">HOUSEKEEPING EXPENSES</h1>
            </div>
        </div>
        <? $flagScreen="tab_5";
        include ('../global/aims_gl_expenses_menu.php'); ?>

        <div class="row">
            <div class="panel-heading" style="float: right">
                <button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Add New</button>
                <a href="aims_gl_hk_expenses_report.php? " target="_blank"><button type="button" class="btn btn-primary">Report</button></a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Housekeeping Expenses List</label>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th style="width: 5%">No</th>
                                <th>Location</th>
                                <th>Date</th>
                                <th>Item</th>
                                <th>Unit</th>
                                <th>Price (RM)</th>
                                <th>Total (RM)</th>
                                <th style="width: 10%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <? $i=1;
                            $utility = getHkExpensesList();
                            while($list_utility = $utility ->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><? echo $i++; ?></td>
                                    <td><? echo $list_utility['location']; ?></td>
                                    <td><? echo $list_utility['date_purchase']; ?></td>
                                    <td><? echo $list_utility['item']; ?></td>
                                    <td><? echo $list_utility['unit']; ?></td>
                                    <td><? echo $list_utility['price']; ?></td>
                                    <td><? echo $list_utility['total']; ?></td>
                                    <td>
                                        <a href='#myModal1' data-toggle='modal' data-id="<? echo $list_utility['id']; ?>"><span class="material-icons">border_color</span></a>
                                        <a href="../controller/aims_gl_hk_expenses_delete_exec.php?id=<? echo $list_utility['id']; ?>"><span style="color: red"  title="Delete" class="material-icons" onclick="return confirm('Are you sure you want to delete?');">delete</span></a>
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
                <h4 class="modal-title" id="myModalLabel">Add Housekeeping</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="../controller/aims_gl_hk_expenses_exec.php" >
                    <input id="created_by" name="created_by" type="hidden" value="<?php echo $_SESSION['SESS_NAME']; ?>"/>

                    <div class="form-group">
                        <label for="location">LOCATION <span style="color: red">*</span></label>
                        <input class="form-control" name="location" id="location" required onkeyup="convertToUppercase(this)">
                    </div>

                    <div class="form-group">
                        <label for="date_purchase">DATE <span style="color: red">*</span></label>
                        <input class="form-control" id="date_purchase" name="date_purchase" type="date" required>
                    </div>

                    <div class="form-group">
                        <label for="item">ITEM <span style="color: red">*</span></label>
                        <input class="form-control" name="item" id="item" required onkeyup="convertToUppercase(this)">
                    </div>


                    <div class="form-group row">
                        <div class="col-xs-4">
                            <label for="unit">UNIT <span style="color: red">*</span></label>
                            <input class="form-control auto-number"  name="unit" id="unit" required onkeyup="multi()">
                        </div>

                        <div class="col-xs-4">
                            <label for="price">PRICE <span style="color: red">*</span></label>
                            <input class="form-control auto-number" name="price" id="price" required onkeyup="multi()">
                        </div>


                        <div class="col-xs-4">
                            <label for="total">TOTAL <span style="color: red">*</span></label>
                            <input class="form-control" id="total" name="total"/>
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
                <h4 class="modal-title" id="myModalLabel">Update housekeeping</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'aims_gl_hk_expenses_update.php',
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
        var unit = document.getElementById('unit').value;
        var price = document.getElementById('price').value;

        var totals = (unit * price);
        var total = document.getElementById('total');
        total.value = totals.toFixed(2);
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