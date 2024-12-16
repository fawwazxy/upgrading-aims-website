<?php

include ('../controller/auth.php');

require "../model/staff_function.php";
require "../model/lookup.php";


?>

<?
$id = $_GET['id'];
$no_staff = $_GET['no_staff'];
$staff_record_id = getStaffRecordId($no_staff);
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
                <h1 class="page-header">Maklumat Medical</h1>
            </div>
            <div class="panel-heading" align="right">
                <a href="staff_info.php" class="btn btn-primary">Kembali</a>
            </div>
        </div>

        <div class="row">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">

                        <!--<?
                        $log_staff = getStaffRecordDetails($staff_record_id)-> fetch_assoc();
                        ?>-->


                        <form method="post" action="../controller/aims_lv_medical_info_update_exec.php">
                            <div>
                                <input name="staff_record_id" type="hidden" class="input-short" value="<? echo $staff_record_id;?>" />
                                <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                                <input name="no_staff" type="hidden" class="input-short" value="<? echo $no_staff;?>" />
                            </div>

                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <label>Maklumat Medical</label>
                                </div>

                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                        <tr>
                                            <th width="5%">Bil.</th>
                                            <th width="18%" style="text-align: center;">Total Entitle</th>
                                            <!--<th width="18%" style="text-align: center;">Jumlah Claim</th>-->
                                            <th width="18%" style="text-align: center;">Balance Claim</th>
                                            <th width="15%">Tindakan</th>
                                        </tr>
                                        </thead>
                                        <tbody>

                                        <?
                                        $i= 1;
                                        $mc =  getSenaraiMedicalByStaff($staff_record_id);
                                        while($list_mc = $mc->fetch_assoc()) {

                                            ?>
                                            <tr class="odd gradeX">
                                                <td><?php echo $i; ?></td>
                                                <td align="center"><?php echo "<b><font size='5' color='black'>".$list_mc['entitle_medical']."</font></b>"; ?></td>
                                                <!--<td align="center"><?php echo "<b><font size='5' color='blue'>".$list_mc['jumlah_claim']."</font></b>"; ?></td>-->
                                                <td align="center"><?php echo "<b><font size='5' color='green'>".$list_mc['baki_claim']."</font></b>"; ?></td>
                                                <td><a href="#myModal2" class="btn btn-primary" data-toggle="modal" data-id="<? echo $list_mc['id'];?>">Kemaskini</a></td>


                                            </tr>
                                            <?php $i++; } ?>


                                        </tbody>

                                    </table>

                                </div>

                                <!-- /.panel-body -->
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
        <? include ('../global/footer.php'); ?>
    </div>



</div>


<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Kemaskini Maklumat Medical Claim</h4>
            </div>
            <div class="modal-body" id="demo2">
                <script type="text/javascript">
                    $('#myModal2').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'aims_lv_medical_info_update.php',
                            data:{id:rowid,staff_record_id:"<?echo $staff_record_id;?>"},
                            success:function(html){
                                $('#demo2').html(html);
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

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });


</script>

</body>

</html>
