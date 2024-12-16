<?php

include ('../controller/auth.php');

require "../model/kehadiran_functions.php";

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
        function Confirm(){
            return confirm('Adakah anda pasti untuk padam maklumat ini?');
        }

        function Confirm2(){
            return confirm('Adakah Anda Pasti untuk tekan butang bekerja ini??');
        }


    </script>
    <script language="javascript" type="text/javascript">
        <!--
        function popitup(url) {
            /*newwindow=window.open(url,'name','height=842,width=595');*/
            newwindow=window.open(url,'name','height=595,width=842');
            if (window.focus) {newwindow.focus()}
            return false;
        }


        // -->
    </script>



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
        <?
        $flagScreen="tab_5";
        include ('../global/menu_kehadiran.php');
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Senarai Cuti</h1>
            </div>
        </div>
        <div class="row">
            <div class="panel-heading" align="right">
                <button class="btn btn-warning" data-toggle="modal" data-target="#myModal3">Muat Naik Excel</button>
                <button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Tambah Cuti</button></a>

            </div>


            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai cuti
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" align="left" id="myModalLabel">Tambah Cuti</h4>
                                </div>

                                <div class="modal-body">

                                    <form method="post" action="../controller/cuti_exec.php?act=<? echo add;?>">
                                        <div class="form-group" align="left">
                                            <label><font color="red">** Maklumat Wajib Diisi.</font></label><br>
                                            <label>Nama Cuti<font color="red">**</font>&nbsp;</label>
                                            <input class="form-control" type="text" name="cuti" value="" required>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Tarikh Cuti<font color="red">**</font>&nbsp;</label>
                                            <input class="form-control" type="date" id="txtDate" name="tarikh_cuti" value="" required>
                                        </div>






                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                            <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                        </div>
                                    </form>
                                </div><!--modal-body-->

                            </div>
                            <!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>
                    <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" align="left" id="myModalLabel">Muat Naik Fail</h4>
                                </div>
                                <div class="modal-body">
                                    <form method="post" action="../controller/cuti_exec.php?act=uploadExcel" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <label class="control-label">Fail<font color="red"> **</font>&nbsp;(Fail Excel Sahaja)</label>
                                            <input required  accept=".xlsx" type="file" name="csv_file" id="csv_file" class="btn btn-link">

                                        </div>
                                        <div class="form-group">
                                            <label class="control-label">Contoh Excel : </label>
                                            <br><a href="../../resources/items/format_cuti.xlsx">Muat Turun Format</a>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Simpan</button>
                                            <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                        </div>
                                    </form>
                                </div><!--modal-body-->
                            </div>
                            <!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div>

                    <!-- /.modal -->





                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Cuti</th>
                                <th>Tarikh Cuti</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getCuti();
                            while($row_data = $data->fetch_assoc()) {

                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['perkara']; ?></td>
                                    <td><?php echo $row_data['tarikh_cuti']; ?></td>
                                    <td>
                                        <a href="../controller/cuti_exec.php?act=<? echo del;?>&id=<? echo $row_data['id'];?>"><button class="btn btn-danger" type="button" onclick="return Confirm()" >Padam</button></a>

                                    </td>


                                </tr>
                                <?php $i++; } ?>


                            </tbody>

                        </table>

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
<!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(function(){
        var dtToday = new Date();

        var month = dtToday.getMonth() + 1;
        var day = dtToday.getDate();
        var year = dtToday.getFullYear();
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();

        var maxDate = year + '-' + month + '-' + day;

        $('#txtDate').attr('min', maxDate);
    });
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>

</body>

</html>
