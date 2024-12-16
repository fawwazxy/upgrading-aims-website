<?php

include ('../controller/auth.php');

require "../model/claim_function.php";

?>

<?
//$pemohon_id = $_GET['pemohon_id'];
$no_staff = $_GET['no_staff'];


updateNoti('1',$no_staff,'L');

?>


<!--<?
/*if(isset($_GET['act']) && $_GET['act'] == "delete" && !empty($_GET['id']))
{
deletePemohon($id);

}*/

?>


<?
//if(isset($_GET['act']) && $_GET['act'] == "active" && !empty($_GET['id']))
//{

//  update_PemohonActivity(1,$id);
//}

/* if(isset($_GET['act']) && $_GET['act'] == "inactive" && !empty($_GET['id']))
 {
  
      update_PemohonActivity(0,$id);
   
 }
 
 if(isset($_GET['act']) && $_GET['act'] == "delete" && !empty($_GET['id']))
 {
  
      deletePemohon($id);
   
 }*/
?>-->

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
        function checkDelete(){
            return confirm('Adakah anda pasti untuk padam Peranan ini?');
        }
    </script>

    <script language="javascript" type="text/javascript">


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

                <?
                $flagScreen="tab_3";
                include ('../global/menu_tuntutan_1.php');

                ?>
                <h1 class="page-header">Senarai Tuntutan Yang Lulus</h1>
                <div class="panel-heading" align="right">
                    <a href="pohon_tuntutan_baru.php?no_staff=<? echo $_SESSION['SESS_NO_STAFF']; ?>">
                        <button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Pohon Tuntutan Baru</button></a>

                </div>

            </div>

        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Maklumat Tuntutan
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Tarikh Tuntutan</th>
                                <th>Tarikh Pengesahan</th>
                                <th>Nama Tuntutan</th>
                                <th>Nilai (RM)</th>
                                <th>Catatan <font color=blue><strong>Dari Pelulus</strong></font></th>
                                <th>Pelulus</th>
                                <th>Status</th>

                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i= 1;
                            $log_tuntutan= getSenaraiTuntutanLulus($no_staff);
                            while($list = $log_tuntutan->fetch_assoc()) {
                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $list['tarikh_dipohon']; ?></td>
                                    <td><?php echo $list['tarikh_approvement']; ?></td>
                                    <td><?php
                                        if($list['jenis_tuntutan']=='TRNSPRT'){
                                            echo $list['nama_tuntutan']; ?><br><br>
                                            <? echo $list['tempat_from']; ?>-
                                            <? echo $list['tempat_to'];
                                        } else {
                                            echo $list['nama_tuntutan'];
                                        } ?>

                                    </td>
                                    <td><?php echo $list['jumlah_tuntut']; ?></td>
                                    <td><?php echo $list['catatan']; ?></td>
                                    <td><?php echo $list['nama_pelulus']; ?></td>
                                    <td>

                                        <font color=blue><strong><?php echo $list['status_tuntut'];?></strong></font></td>
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
        <? include ('../global/footer.php'); ?>


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