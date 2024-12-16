<?php

include ('../controller/auth.php');

require "../model/aims_gl_function.php";
require "../model/lookup.php";

$month=$_GET['month'];
if(!isset($month)){
    $month=$date_year;
}
$sys = getSys(1)->fetch_assoc();
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
                <h1 class="page-header">Exchange Room List</h1>
            </div>
        </div>

        <?
        $flagScreen="tab_4";
        include ('../global/aims_gl_menu1.php');
        ?>

        <div class="row">
            <div class="col-lg-12">
                <br>
                <br>
                <br>

                <table border="0">
                    <tr>
                        <td><label class="control-label">MONTH:</label></td>
                        <td>&nbsp;&nbsp;&nbsp;</td>
                        <td><select  required class="form-control" name="month" id="month" value="<?echo $month?>">
                                <option value="">-- Choose Month --</option>
                                <? echo getDropDownMonthExchange($month) ;?>
                            </select>
                        </td>
                    </tr>
                </table>


                <!-- modal-content  -->
            </div><!-- modal-dialog -->
        </div>

        <div class="form-group" align="right">
            <a href="aims_gl_exchange_list_print.php?month=<? echo $month; ?>" target="_blank">
                <button type="button" class="btn btn-primary">Print</button></a>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Exchange Room List</label>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th rowspan="2">NO.</th>
                                <th rowspan="2">ERN NO</th>
                                <th rowspan="2">CREW NAME</th>
                                <th rowspan="2">CLIENT</th>
                                <th rowspan="2">REASON</th>
                                <th rowspan="2">DATE</th>
                                <th colspan="3">PRESENT ROOM</th>
                                <th colspan="3">NEW ROOM</th>
                                <th rowspan="2">ACTION</th>
                            </tr>

                            <tr style="font-weight: bold;">
                                <td>ROOM NO</td>
                                <td>BED NO</td>
                                <td>LOCKER NO</td>
                                <td>ROOM NO</td>
                                <td>BED NO</td>
                                <td>LOCKER NO</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $ex = getExchangeList($month);
                            $i=1;
                            while($list_ex = $ex->fetch_assoc()) {
                                ?>


                                <tr>
                                    <td><? echo $i++;?></td>
                                    <td><? echo $list_ex['er_no']; ?></td>
                                    <td><? echo $list_ex['client_name']; ?></td>
                                    <td><? echo $list_ex['client_company_id']; ?></td>
                                    <td><? echo $list_ex['reason']; ?></td>
                                    <td><? echo $list_ex['date_change']; ?></td>
                                    <td><? echo $list_ex['room_pass']; ?></td>
                                    <td><? echo $list_ex['bed_pass']; ?></td>
                                    <td><? echo $list_ex['locker_pass']; ?></td>
                                    <td><? echo $list_ex['room_id']; ?></td>
                                    <td><? echo $list_ex['bed_id']; ?></td>
                                    <td><? echo $list_ex['locker_id']; ?></td>
                                    <td>
                                        <a href="aims_gl_exchange_form_print.php?id=<? echo $list_ex['id']; ?>" class="btn btn-success" target="_blank"><i class="fa fa-print"></i> Print Form</a>
                                    </td>
                                    </td>

                                </tr>
                            <?}?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
        </div>
        <!-- /.row -->
        <!-- /.container-fluid -->
        <? include ('../global/footer.php'); ?>
    </div>

    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    $(document).ready(function() {
        $("#month").change(function(){

            var selected_month=$(this).val();
            reloadMonth(selected_month);
        });


    });

    function reloadMonth(month){
        //console.log(cawangan);
        location.href = "aims_gl_exchange_list.php?month="+month;
    }
</script>

</body>
</html>