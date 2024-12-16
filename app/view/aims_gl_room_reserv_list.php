<?php
include ('../controller/auth.php');
require "../model/aims_gl_function.php";
require "../model/lookup.php";
$month=$_GET['month'] ?: 0;
$year= $_GET['year'] ?: date('Y');
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <? require "../global/header.php"; ?>
</head>
<style type="text/css">
    body{
        font-size: 12.5px;
    }
    th, td{
        text-align: center;
    }
</style>
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
                <h1 class="page-header">Room Reservation List</h1>
            </div>
        </div>
        <? $flagScreen="tab_3";
        include ('../global/aims_gl_menu1.php');
        ?>
        <div class="row">
            <div class="col-lg-12">
                <br>
                <table>
                    <form method="GET">
                        <tr>
                            <td><label class="control-label">MONTH:</label></td>
                            <td>&nbsp;&nbsp;&nbsp;</td>
                            <td><select  required class="form-control" name="month" id="month" value="<?echo $month?>">
                                    <? echo getDropDownMonth($month) ;?>
                                </select>
                            </td>
                            <td>&nbsp;&nbsp;&nbsp;</td>
                            <td><label class="control-label">YEAR:</label></td>
                            <td>&nbsp;&nbsp;&nbsp;</td>
                            <td><select  required class="form-control" name="year" id="year" value="<?echo $year?>">
                                    <option value="">-- Choose Year --</option>
                                    <? echo getDropDownYear($year) ;?>
                                </select>
                            </td>
                            <td>&nbsp;&nbsp;&nbsp;</td>
                            <td><button type="submit" class="btn btn-info">Search</button></td>
                        </tr>
                    </form>
                </table>
            </div>
        </div>
        <div class="form-group" align="right">
            <a href="aims_gl_room_reserv_list_print.php?month=<? echo $month; ?>&year=<? echo $year; ?> " target="_blank">
                <button type="button" class="btn btn-primary">Print</button></a>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Room Reservation List</label>
                    </div>
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th rowspan="2" width="2%">NO.</th>
                                <th rowspan="2" width="13%">RR NO</th>
                                <th rowspan="2" width="10%">CREW NAME</th>
                                <th rowspan="2" width="10%">CLIENT</th>
                                <th rowspan="2" width="5%">IC/PASSPORT NO</th>
                                <th rowspan="2" width="5%">ROOM NO</th>
                                <th rowspan="2" width="5%">BED NO</th>
                                <th colspan="2">CHECK IN</th>
                                <th colspan="2">CHECK OUT</th>
                                <th rowspan="2">PIC</th>
                                <th rowspan="2">Action</th>

                            </tr>
                            <tr style="font-weight: bold;">
                                <td>Date</td>
                                <td>Time</td>
                                <td>Date</td>
                                <td style="border-right: inset; ">Time</td>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $rr = getRoomReservList($month, $year);
                            $i=1;
                            while($list_rr = $rr->fetch_assoc()) {?>
                                <tr>
                                    <td><? echo $i++;?></td>
                                    <td><? echo $list_rr['ref_no']; ?></td>
                                    <td><? echo $list_rr['client_name']; ?></td>
                                    <td><? echo $list_rr['client_company_id']; ?></td>
                                    <td><? echo $list_rr['client_ic']; ?></td>
                                    <td><? echo $list_rr['room_id']; ?></td>
                                    <td><? echo $list_rr['bed_id']; ?></td>
                                    <td><? echo $list_rr['arrival_date']; ?></td>
                                    <td><? echo $list_rr['arrival_time']; ?></td>
                                    <td><? echo $list_rr['departure_date']; ?></td>
                                    <td><? echo $list_rr['departure_time']; ?></td>
                                    <td><? echo $list_rr['attend']; ?></td>
                                    <td>
                                        <?php echo "<a href='#myModal1' class='btn btn-info btn-small' data-toggle='modal' data-id=".$list_rr['id'].">Edit</a>"; ?>
                                        <!-- <a href="#myModal1" data-toggle="modal" data-id="<? echo $list_booking['id'];?>"><button type="button" class="btn btn-success">Update</button></a> -->
                                        <a href="aims_gl_lost_item_form.php?id=<? echo $list_rr['id']; ?>" class="btn btn-primary" disabled target="_blank">Lost Item</a>

                                        <a href="../controller/aims_gl_room_reserv_delete_exec.php?id=<? echo $list_rr['id']; ?>"><button class="btn btn-danger" type="button" onclick="return confirm('Are you sure you want to delete this reservation?');">Delete</button></a>
                                    </td>
                                </tr>
                            <?}?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>

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
                        $.ajax({
                            type:'GET',
                            url:'aims_gl_room_reserv_update.php',
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
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
    /*$(document).ready(function() {
    $("#month").change(function(){

        var selected_month=$(this).val();
        reloadMonth(selected_month);
    });
    });
    function reloadMonth(month){
    //console.log(cawangan);
    location.href = "aims_gl_room_reserv_list.php?month="+month;
    }*/
</script>
</body>
</html>