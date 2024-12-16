<?php

include ('../controller/auth.php');

require "../model/staff_function.php";
require "../model/lookup.php";
$tab_shift=$_GET['tab_shift'];
$cawangan_kod=$_GET['cawangan_kod'];
$jabatan_kod=$_GET['jabatan_kod'];

if(!isset($cawangan_kod)){
    $cawangan_kod = $_SESSION['SESS_CAWANGAN'];

}
if(!isset($jabatan_kod)){
    $jabatan_kod = $_SESSION['SESS_DEPARTMENT'];

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

</head>
<script>
    function confirmDelete(){
        confirm("are you sure to delete this?");
    }

</script>

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
                <h1 class="page-header">
                    <a href="v02_aims_attendance_homepage.php" class="btn btn-primary" style="float: right">Switch to version 2</a>
                    Shift Bekerja
                </h1>
            </div>
        </div>
        <div id='cssmenu'>
            <ul>

                <?
                $j= 1;
                $shift_description ="";
                $Allshift = getAllShift();
                while($listS = $Allshift->fetch_assoc()) {
                    if (!isset($tab_shift)){
                        $tab_shift = $listS['shift_code'];
                    }
                    if ($tab_shift==$listS['shift_code']){
                        $shift_description =$listS['description'];
                    }
                    ?>
                    <li class="<? echo ($tab_shift==$listS['shift_code']?'active':'') ?>"><a href="shift_bekerja.php?tab_shift=<?echo $listS['shift_code']?>&cawangan_kod=<? echo $cawangan_kod;?>&jabatan_kod=<? echo $jabatan_kod;?>"><?echo $listS['description'];?></a></li>
                <?}?>
            </ul>
        </div><br>

        <div class="row">
            <div class="col-lg-12">
                <div class="col-lg-4">

                    <select  required class="form-control" name="cawangan_kod" id="cawangan_kod">
                        <option value="0">-- Pilih Cawangan--</option>
                        <? echo getDropDown("lkp_cawangan","cawangan_kod","nama",$cawangan_kod);?>
                    </select>
                </div>
                <?
                if($_SESSION['SESS_CAWANGAN']=='HQ' ){?>
                    <div class="col-lg-4">

                        <select  required class="form-control" name="jabatan_kod" id="jabatan_kod">
                            <option value="0">-- Pilih Jabatan--</option>
                            <? echo getDropDown("department","code_department","description",$jabatan_kod);?>
                        </select><br>
                    </div>
                <?}?>

                <div class="panel-heading" align="right">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Reassign Shift</button>
                </div>
            </div>





            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Staff
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>No Staff</th>
                                <th>Shift</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i= 1;
                            $shiftStaff = getShiftStaff($tab_shift,$cawangan_kod,$jabatan_kod);
                            while($listX = $shiftStaff->fetch_assoc()) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><? echo $i; ?></td>
                                    <td><? echo $listX['name']; ?></td>
                                    <td><? echo $listX['no_staff']; ?></td>
                                    <td><? echo $listX['description']; ?></td>
                                </tr>
                                <? $i++; } ?>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <? include ('../global/footer.php'); ?>
        <!-- /.row -->
    </div>
    <!-- /#page-wrapper -->
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" align="left" id="myModalLabel">Tukar Shift</h4>
            </div>

            <div class="modal-body">


                <form method="post" action="../controller/shift_edit_exec.php?act=shift_update">

                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <label>Shift</label>
                            <br>
                            <? echo $shift_description?>

                            <br>
                            <br>
                            <input type="hidden" class="form-control" name="shift_code" value="<?echo $tab_shift;?>">

                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>No Staff</th>
                                <th>Shift</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i= 1;
                            $shiftStaff = getShiftStaffAll($cawangan_kod,$jabatan_kod);
                            while($list = $shiftStaff->fetch_assoc()) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><? echo $i; ?></td>
                                    <td><? echo $list['name']; ?></td>
                                    <td><? echo $list['no_staff']; ?></td>
                                    <td><? echo $list['description']; ?></td>
                                    <td><input class="form-control" type="checkbox" name="no_staff[]" value="<? echo $list['no_staff']; ?>"
                                            <? echo($tab_shift==$list['code_shift']?'checked disabled="true"':'');?>>
                                    </td>
                                </tr>
                                <? $i++; } ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-info" >Simpan</button>
                    </div>
                </form>
            </div><!--modal-body-->
        </div>
        <!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
        $("#cawangan_kod,#jabatan_kod").change(function(){
            var selected_cawangan=$("#cawangan_kod").val();
            var selected_jabatan=$("#jabatan_kod").val();
            sendType(selected_cawangan,selected_jabatan);
        });

    });
    function sendType(cawangan,jabatan)
    {

        window.location.href="shift_bekerja.php?tab_shift=<? echo $tab_shift;?>&cawangan_kod="+cawangan+"&jabatan_kod="+jabatan;

    }

</script>



</body>
</html>