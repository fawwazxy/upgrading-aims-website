<?php

include ('../controller/auth.php');
//require "../global/menu_bulan1.php";
require "../model/perbelanjaan_functions.php";

?>
<?
$id=$_GET['id'];
$no_staff=$_GET['no_staff'];
$bulan=$_GET['bulan'];
$tahun=$_GET['tahun'];
$flagtahun=$_GET['flagtahun'];
if($flagtahun == "") "tb_1";
$flag=$_GET['flg'];
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
        $flagScreen="tab_2";
        include ('../global/menu_analisa_perniagaan.php');
        ?>



        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">AKAN DATANG........</h1>
            </div>
        </div>


        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- /.panel-heading -->
<div class="panel-body">

    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
        <thead>
        <tr>
            <th>No</th>
            <th>Tahun</th>
            <th>Bulan</th>
            <th>Perbelanjaan</th>
            <th>Penerima Bayaran</th>
            <th>Kaedah Bayaran</th>
            <th>Amaun Bayaran (RM)</th>
            <th>Tarikh Bayaran</th>
            <th>No. Rujukan</th>
            <th>Tindakan</th>
        </tr>
        </thead>

        <tbody>

        <?
        $i= 1;

        $data = getPerbelanjaan($bulan,$tahun);
        while($row_data = $data->fetch_assoc()) {

            ?>
            <tr class="odd gradeX">
                <td><?php echo $i; ?></td>
                <td><?php echo $row_data['tahun']; ?></td>
                <td><?php echo $row_data['bulan']; ?></td>
                <td>
                    <a href="perbelanjaan_details.php?id=<? echo $row_data['id'];?>&bulan=<? echo $bulan?>&tahun=<? echo $tahun?>&flagtahun=<? echo $flagtahun?>"><?php echo $row_data['description']; ?></a>
                </td>
                <td><?php echo $row_data['nama_penerima']; ?></td>
                <td><?php echo $row_data['nama']; ?></td>
                <td><?php echo $row_data['amaun_bayaran']; ?></td>
                <td><?php echo $row_data['tarikh_bayaran_dibuat']; ?></td>
                <td><?php echo $row_data['no_rujukan']; ?></td>

                <td>

                    <div class="modal-footer">
                        <a href="perbelanjaan_edit.php?id=<? echo $row_data['id']; ?>&bulan=<? echo $bulan?>&tahun=<? echo $tahun?>&flagtahun=<? echo $flagtahun?>&no_staff=<? echo $_SESSION['SESS_NO_STAFF']?>"> <button class="btn btn-info" type="button" >Kemaskini</button></a>

                        <a href="../controller/perbelanjaan_delete_exec.php?id=<? echo $row_data['id']; ?>&bulan=<? echo $bulan?>&tahun=<? echo $tahun?>&flagtahun=<? echo $flagtahun?>&flg=<? echo $flag?>"><button type="button" class="btn btn-danger" onClick="return confirm('Adakah anda mahu memadam data ini?')";\">Padam</button>

                    </div>

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
