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

</head>

<style>
    body{
        font-size: 12.5px;
    }
    th, td{
        text-align: center;
    }
</style>
<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

        <!-- /.navbar-header -->
        <? include ('../global/menu_top.php'); ?>

        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <!--li>
                        <center><img src="images/pic.jpg" class="user-image img-responsive"/></center>
                      </li-->

                    <? include ('../global/menu_left.php'); ?>

                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">BEVERAGE & TOILETRIES STOCK</h1>
            </div>
        </div>

        <?
        $flagScreen="tab_6";
        include ('../global/aims_gl_expenses_menu.php');
        ?>


        <div class="row">
            <div class="panel-heading" align="right">

                <button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Add New</button>

            </div>
            <div class="col-lg-12">
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">

                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" align="left" id="myModalLabel">Add New</h4>
                    </div>

                    <div class="modal-body">

                        <form method="post" action="../controller/aims_gl_hk_stock_exec.php" >

                            <div class="form-group" align="left">
                            </div>


                            <label><font color="red">** NEW BAVERAGE AND TOILETRIES STOCK.</font></label>
                            <br>

                            <div class="form-group"  align="left">
                                <label>ITEM<font color="red">**</font>&nbsp;</label>
                                <select  required class="form-control" name="hk_item_id" id="hk_item_id">
                                    <option value="">-- Choose ITEM --</option>
                                    <? echo getDropDownHkItem(""); ?>
                                </select>
                            </div>

                            <div class="form-group"  align="left">
                                <label>TOTAL STOCK<font color="red">**</font>&nbsp;</label>
                                <input class="form-control" placeholder=" " name="stock" id="stock" required>
                            </div>

                            <div class="form-group"  align="left">
                                <label>EXPIRED DATE</label>
                                <input class="form-control" id="expired" name="expired" type="date" value=""/>
                            </div>



                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <button type="reset" class="btn btn-info">Reset</button>
                            </div>

                        </form>
                    </div><!--modal-body-->
                </div>
                <!-- /.modal-content -->
            </div><!-- /.modal-dialog -->

        </div><!-- /.modal -->


        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Beverage & Toiletries Stock List</label>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="5%">No.</th>
                                <th width="20%">Item</th>
                                <th width="15%">Total Stock</th>
                                <th width="15%">Expired date</th>
                                <th width="15%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $stock = getItemHkStockList();
                            $i=1;
                            while($list_stock = $stock ->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><? echo $i++;?></td>
                                    <td><? echo $list_stock['hk_item_id']; ?></td>
                                    <td><? echo $list_stock['stock']; ?></td>
                                    <td>
                                        <? if($list_stock['expired'] != '0000-00-00'){
                                            echo $list_stock['expired'];}
                                        else{
                                            echo " ";}?></td>
                                    <td><a href='#myModal1' data-toggle='modal' data-id="<? echo $list_stock['id'];?>"><span class="material-icons">border_color</span></a>

                                        <a href="../controller/aims_gl_hk_stock_delete_exec.php?id=<? echo $list_stock['id']; ?>"><span style="color: red"  title="Delete" class="material-icons" onclick="return confirm('Are you sure you want to delete?');">delete</span></a></td>
                                </tr>
                            <?}?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <!-- /.container-fluid -->
        <? include ('../global/footer.php'); ?>
    </div>

    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Update</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'GET',
                            url:'aims_gl_hk_stock_update.php',
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
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }


</script>

</body>

</html>