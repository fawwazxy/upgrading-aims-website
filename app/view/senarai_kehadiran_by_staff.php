<?php

include ('../controller/auth.php');

require "../model/kehadiran_functions.php";

?>
<?

$bln=$_GET['mnt'];
$name=$_GET['name'];
$noic=$_GET['noic'];
$thn=$_GET['thn'];


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
            return confirm('Adakah Anda Pasti untuk tekan butang berhenti ini?');
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

        include ('../global/menu_kehadiran.php');
        ?>

        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header"><font style="color:blue">Senarai Kehadiran <? echo $name;?></font></h3>
            </div>
            <div class="panel-heading" align="right">
                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
            </div>
        </div>

        <br>
        <div class="row">



            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Kehadiran
                    </div>






                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>

                                <th>No</th>
                                <th>Tarikh</th>
                                <th>Masa Masuk</th>
                                <th>Masa Keluar</th>
                                <th>Catatan</th>
                                <th>Status</th>
                                <th>Plot Pergerakan</th>
                                <th>Bil. jam bekerja</th>
                                <th>Baki Beza Masa</th>

                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getKehadiranByMonthStaff($bln,$thn,$noic);
                            while($row_data = $data->fetch_assoc()) {
                                $beza=$row_data['beza'];

                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['tarikh']; ?></td>
                                    <td><?php echo $row_data['masa_masuk']; ?><br>
                                        <? if( $row_data['remark_masuk']=="LUAR KAWASAN"){?>
                                            <strong><font color="red">
                                                    <?php echo $row_data['remark_masuk']; ?></font></strong>
                                        <? } else {?>
                                            <strong><font color="blue">
                                                    <?php echo $row_data['remark_masuk']; ?></font></strong>
                                        <?}?>
                                    </td>
                                    <td><?php echo $row_data['masa_keluar']; ?><br>
                                        <? if( $row_data['remark_keluar']=="LUAR KAWASAN"){?>
                                            <strong><font color="red">
                                                    <?php echo $row_data['remark_keluar']; ?></font></strong>
                                        <? } else {?>
                                            <strong><font color="blue">
                                                    <?php echo $row_data['remark_keluar']; ?></font></strong>
                                        <?}?>
                                    </td>
                                    <td><?php echo $row_data['catatan']; ?></td>
                                    <td><?
                                        if( $row_data['status_kehadiran']=="LEWAT"){?>
                                            <strong><font color="red">
                                                    <?php echo $row_data['status_kehadiran']; ?></font></strong>


                                        <?  }else if($row_data['status_kehadiran']=="AWAL"){?>
                                            <strong><font color="blue">
                                                    <?php echo $row_data['status_kehadiran']; ?></font></strong>
                                        <? }else {?>
                                            <strong><font color="green">
                                                    <?php echo $row_data['status_kehadiran']; ?></font></strong>
                                        <?}?></td>
                                    <td>

                                        <button class="btn btn-info" onclick="return popitup('../view/pinned_map.php?lokasi=<? echo $row_data['lokasi_masuk'];?>&id=<? echo $row_data['id']?>')">Papar Peta</button>

                                    </td>
                                    <td><?php echo $row_data['total'];?></td>
                                    <td><?
                                        if($beza>'00:00:00'){?>
                                            <b><font style="color:blue;"><?php echo $row_data['beza']; ?></font></b>
                                        <?}
                                        else {?>
                                            <b><font style="color:red;"><?php echo $row_data['beza']; ?></font></b>
                                        <?}?>

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
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>

</body>

</html>
