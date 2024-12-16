<?php

include ('../controller/auth.php');
require "../model/spesifikasi_function.php";
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



    <script language="javascript" type="text/javascript">
        <!--
            function popitup(url) {
                /*newwindow=window.open(url,'name','height=842,width=595');*/
                newwindow=window.open(url,'name','height=595,width=842');
                if (window.focus) {newwindow.focus()}
                return false;
            }

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
        <div class="row">
            <div class="col-lg-12">


                <h1 class="page-header">Senarai Spesifikasi</h1>
            </div>
        </div>




        <div class="row">
            <div class="panel-heading" align="right">

                <a href="spesifikasi_detail.php"> <button class="btn btn-primary" type="button" >Tambah</button></a>
            </div>




            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Spesifikasi
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">


                            <thead>
                            <tr>
                                <th width="20px">#</th>
                                <th width="50px">Spesifikasi</th>
                                <th width="50px">Tarikh Spesifikasi Dicipta</th>
                                <th width="50px">Tindakan</th>
                            </tr>

                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getSpesifikasiList();
                            while($row_data = $data->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['name']; ?></a></td>
                                    <td><?php echo $row_data['created_date']; ?></a></td>

                                    <td>






                                        <a href="spesifikasi_detail.php?id=<?php echo $row_data['id']; ?>"> <button class="btn btn-info" type="button" >Kemaskini</button></a>



                                        <a href="spesifikasi_checklist.php?id=<?php echo $row_data['id']; ?>"><button type="button" class="btn btn-primary">Senarai Semak</button></a>

                                        <a onclick="return popitup('spesifikasi_cetak.php?id=<?php echo $row_data['id']; ?>&sys_id=<?php echo $sys['sys_id']; ?>')"> <button class="btn btn-warning" type="button" >Cetak</button></a>
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
        </div>
        <? include ('../global/footer.php'); ?>
    </div>




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
