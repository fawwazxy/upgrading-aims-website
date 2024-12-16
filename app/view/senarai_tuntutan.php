<?php

include ('../controller/auth.php');

require "../model/claim_function.php";

?>

<?
//$pemohon_id = $_GET['pemohon_id'];
$no_staff = $_GET['no_staff'];

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
                $flagScreen="tab_1";
                include ('../global/menu_tuntutan_1.php');
                ?>
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
                                <th>Nama Tuntutan</th>
                                <th>Nilai (RM)</th>
                                <th>Pelulus</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i= 1;
                            $log_tuntutan= getSenaraiTuntutan();
                            while($list = $log_tuntutan->fetch_assoc()) {
                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $list['tarikh_tuntut']; ?></td>
                                    <td><?php echo $list['nama_tuntut']; ?></td>
                                    <td><?php echo $list['nilai']; ?></td>
                                    <td><?php echo $list['pelulus']; ?></td>
                                    <td><font color=red><strong><?php echo $list['status_tuntutan'];?></strong></font></td>
                                    <td>
                                        <a href="pemohon_update.php?pemohon_id=<? echo $list['id']; ?>&act=update"><button type="button" class="btn btn-info">Kemaskini</button>
                                            <!--a href="pemohon_senarai.php?act=delete&id=<? //echo $list['id']; ?>&users=<?//php echo $list['name']; ?>"><button type="button" class="btn btn-danger" onclick="return checkDelete()">Padam</button-->
                                            <a href="hr_add_interview.php?pemohon_id=<? echo $list['id']; ?>&no_staff=<? echo $no_staff; ?>"><button type="button" class="btn btn-warning">Tetapkan Jadual</button>





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
<? include ('../global/footer.php'); ?>

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