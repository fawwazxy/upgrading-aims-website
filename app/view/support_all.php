<?php
include ('../controller/auth.php');
require "../model/support_function.php";
?>
<?
$id=$_GET['id'];
$id_progress=$_GET['id_progress'];
$no_staff=$_GET['no_staff'];
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
        function popitup(url) {
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

            <?
            $flagScreen="tab_4";
            include ('../global/menu_developer_support.php');
            ?>


            <?
            $flagScreen="tab_1";
            include ('../global/menu_developer.php');
            ?>
            <div class="col-lg-12">

            </div>
        </div>
        <div class="row">
            <div class="panel-heading" align="right">




            </div>

            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Aduan
                    </div>








                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>No Rujukan</th>
                                <th>Nama Projek</th>

                                <th>Nama-Notel</th>

                                <th>Tarikh Terima</th>
                                <th>Masa Untuk Siap</th>
                                <th>Tahap Keutamaan</th>
                                <th>Status Tindakan</th>

                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getSupportDeveloperAll($no_staff,$nama_projek);
                            while($row_data = $data->fetch_assoc()) {



                                ?>



                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['norujukan_support']; ?></td>
                                    <td><?php echo $row_data['nama_projek']; ?><br> <?php echo $row_data['agensi_rujukan']; ?></td>
                                    <td><?php echo $row_data['nama_client']; ?><br><?php echo $row_data['notel']; ?></td>
                                    <td><?php echo $row_data['created_date']; ?></td>
                                    <td><?php echo $row_data['tarikh_mula']; ?> HINGGA <br><?php echo $row_data['tarikh_tamat']; ?></td>
                                    <td>


                                        <?php echo $row_data['level_aduan']; ?>







                                    </td>
                                    <td>

                                        <?php
                                        $status_tindakan= $row_data['status_tindakan'];
                                        if ($status_tindakan   == 'DP' ) {
                                            echo "<font color=red><strong>DALAM PENERIMAAN</strong></font>";
                                            ?>

                                            <!--  <a href="../controller/terima_exec.php?no_staff=</? echo $row_data['no_staff'];?>&no_staff_login=</? echo $_SESSION['SESS_NO_STAFF'];?>&id=</? echo $row_data['id'];?>"> <button class="btn btn-warning" onclick="return Confirm()">Terima</button> -->
                                            <?
                                        }
                                        else   if ($status_tindakan == 'T' ) {
                                        echo "<font color=blue><strong>SEDANG DIPROSES</strong></font><br>";
                                        ?>

                                        <a href="../controller/selesai_exec.php?no_staff=<? echo $row_data['no_staff'];?>&no_staff_login=<? echo $_SESSION['SESS_NO_STAFF'];?>&id=<? echo $row_data['id'];?>"> <button class="btn btn-warning" onclick="return Confirm()">Selesai</button>

                                            <? }

                                            else if ($status_tindakan == 'ST' ) {
                                                echo "<font color=blue><strong>SEMAKAN TERAKHIR</strong></font><br>";}
                                            else{
                                                echo "<font color=blue><strong>SELESAI</strong></font><br>";}
                                            ?>

                                    </td>






                                    <td><a href="developer_support_update.php?id=<? echo $row_data['id'];?>&no_staff=<? echo $no_staff; ?>"><button class="btn btn-info" type="button" >Kemaskini</button></a>



                                        <a href="list_progress.php?id=<? echo $row_data['id'];?>&no_staff=<? echo $no_staff; ?>" target="_blank"><button class="btn btn-info" type="button" >Progress</button></a>

                                        <!-- <a href="add_progress.php?id=<? echo $row_data['id'];?>&id_progress=<? echo $row_data['id_progress']; ?>&no_staff=<? echo $no_staff; ?>"><button class="btn btn-danger" type="button" >Cancel Aduan</button></a> -->












                                    </td>



                                    <!--<button type="button" class="btn btn-primary">Add New Record</button-->

                                    <!-- Button trigger modal -->


                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">

                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" align="left" id="myModalLabel">Jam Diperlukan Untuk Siapkan </h4>
                                                </div>

                                                <div class="modal-body">

                                                    <form method="post" action="../controller/add_jam_exec.php?id=<?php echo $row_data['id']; ?>" >






                                                        <div class="form-group">
                                                            <label for="comment">Jam</label>
                                                            <input class="form-control" rows="5" name="jam_siap" id="jam_siap" ></input>
                                                        </div>




                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Simpan</button></a>
                                                            <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                                        </div>
                                                </div>
                                                </form>
                                            </div><!--modal-body-->

                                        </div>
                                        <!-- /.modal-content -->
                                        <!-- /.modal-dialog -->
                                    </div><!-- /.modal -->



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
