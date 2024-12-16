<?php

include ('../controller/auth.php');

require "../model/aims_ot_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$verify_status = $_GET['verify_status'];
$month = $_GET['month_claim'];
?>

<?

$sys = getSys(1)-> fetch_assoc();

$no_staff = $_SESSION['SESS_NO_STAFF'];
$company_id = $_SESSION['SESS_DEPARTMENT'];
$department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];
$verify_by = $_SESSION['SESS_NAME'];
$verify_status = $_GET['verify_status'];
if (!isset($verify_status) && $verify_status == '') {
    $verify_status = 'PENDING';
}
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

    <script language="JavaScript" type="text/javascript">
        function Kemaskini(){
            return confirm('Anda pasti untuk kemaskini maklumat permohonan claim?');
        }

    </script>
    <script language="JavaScript" type="text/javascript">
        function Confirm(){
            return confirm('Anda pasti untuk hantar permohonan claim?');
        }

    </script>

    <style>
        .horizontal-scroll {
            overflow: hidden;
            overflow-x: auto;
            clear: both;
            width: 100%;
        }

        .my-table {
            min-width: rem-calc(640);
        }
    </style>
</head>



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


        <div class="col-lg-12">
            <h1 class="page-header">Overtime Claim</h1>
        </div>
        <div class="row">
            <div class="panel-heading" align="right">

                <?
                $staff = ListName($id) -> fetch_assoc();
                ?>


                <table width="100%" >
                    <tr>
                        <th width="14%"></th>
                        <th width="2%"></th>
                        <th></th>
                    </tr>

                    <tr>
                        <td><label>STAFF NAME</label></td>
                        <td><label>:</label></td>
                        <td><?php echo $staff['name']?></td>
                    </tr>


                </table>

            </div>
        </div>
        <div class="panel-heading" align="right">

            <input type="button" class="btn btn-danger" value="CLOSE" onclick="self.close()">

        </div>


        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label>Overtime Claim By Month : <? echo $month; ?></label>&nbsp;&nbsp;&nbsp;
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                        <input name="id" type="hidden" class="input-short" value="<? echo $month;?>" />
                        <div class="horizontal-scroll">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-examples">
                                <thead>
                                <tr>
                                    <th style="text-align:center;" width="5%">No.</th>
                                    <th style="text-align:center;" width="15%">Date/Day</th>
                                    <th style="text-align:center;" width="20%">Time</th>
                                    <th style="text-align:center;" width="10%">Working Period</th>
                                    <th style="text-align:center;" width="20%">Work Description</th>
                                    <th style="text-align:center;" width="10%">Remark</th>
                                    <th style="text-align:center;" width="10%">Attachment</th>
                                    <th style="text-align:center;" width="10%">Action</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?

                                $pemohon= ListBatchOt($_SESSION['SESS_DEPARTMENT_SUB'],$month,$verify_status,$id);
                                $i= 1;
                                while($ot = $pemohon->fetch_assoc()) {

                                    $start_ot= date('h:i a', strtotime($ot['start_ot']));
                                    $end_ot= date('h:i a', strtotime($ot['end_ot']));
                                    ?>
                                    <tr>
                                        <td><?echo $i++;?></td>
                                        <td style="text-align:center;"><?php echo $ot['date_ot']; ?><br><?php echo $ot['day_ot']; ?></td>
                                        <td style="text-align:center;">
                                            <b>Start:</b> <?php echo $start_ot; ?>
                                            <br>
                                            <b>End:</b> <?php echo $end_ot; ?></td>
                                        <td style="text-align:center;"><?echo $ot['working_hours'];?></td>
                                        <td style="text-align:center;"><?echo $ot['description_ot'];?></td>
                                        <td style="text-align:center;"><?echo $ot['hod_remark'];?></td>
                                        <td>
                                            <?if($ot['document_name'] != '') {?>
                                            <a href="#myModal2" class="btn btn-warning" data-toggle="modal" data-id="<? echo $ot['id'];?>">ATTACHMENT</a><?}?>
                                        </td>
                                        <td>
                                            <a href="#myModal3" class="btn btn-primary" data-toggle="modal" data-id="<? echo $ot['id'];?>">EDIT</a>
                                        </td>
                                    </tr>
                                <?}?>
                                <tr>
                                    <td style="text-align:left;background-color:white;" colspan="5">
                                        <b>VERIFIED BY : <?echo $verify_by;?></b>
                                    </td>
                                    <td style="text-align:center;background-color:white;" colspan="3">
                                        <a href="#myModal1" class="btn btn-success" data-toggle="modal" data-id ="<? echo $id;?>" data-month ="<? echo $month;?>">VERIFY</a>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <!-- /.container-fluid -->

        <? include ('../global/footer.php'); ?>
    </div>

    <!-- /#page-wrapper -->


</div>

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">HOD/CEO SECTION</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var staff_record_id = $(e.relatedTarget).data('id');
                        var month = $(e.relatedTarget).data('month');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_ot_hod_update.php',
                            data:{id:staff_record_id,month:month},
                            success:function(html){
                                $('#demo').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">

        <!--Content-->
        <div class="modal-content">

            <!--Body-->
            <div class="modal-body" id="demo2">

                <script type="text/javascript">
                    $('#myModal2').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');

                        $.ajax({
                            type:'POST',
                            url:'aims_ot_attachment.php',
                            data:{id:rowid},
                            success:function(html){
                                $('#demo2').html(html);
                            }
                        });
                    });
                </script>

            </div>

            <!--Footer-->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-outline- btn-rounded btn-md ml-4" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!--/.Content-->

    </div>
</div>

<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">ADD REMARK</h4>
            </div>
            <div class="modal-body" id="demo3">
                <script type="text/javascript">
                    $('#myModal3').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_ot_hod_edit.php',
                            data:{id:rowid},
                            success:function(html){
                                $('#demo3').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    // Delete row on delete button click

    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });


    function popitup(url) {
        /*newwindow=window.open(url,'name','height=842,width=595');*/
        newwindow=window.open(url,'name','height=595,width=890');
        if (window.focus) {newwindow.focus()}
        return false;
    }

</script>
<script>
    function goBack() {
        window.history.back();
    }
</script>

</body>

</html>



