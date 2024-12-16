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

    <script language="JavaScript" type="text/javascript">
        function Kemaskini(){
            return confirm('Anda pasti untuk mengemaskini?');
        }

    </script>

    <script language="JavaScript" type="text/javascript">
        function Confirm(){
            return confirm('Adakah anda pasti untuk hantar?');
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

                <?
                $flagScreen="tab_2";
                include ('../global/menu_tuntutan_1.php');

                ?>
                <h1 class="page-header">Senarai Tuntutan Yang Belum Diluluskan</h1>
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
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i= 1;
                            $log_tuntutan= getSenaraiTuntutan($no_staff);
                            while($list = $log_tuntutan->fetch_assoc()) {
                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $i;?></td>
                                    <td><?php echo $list['tarikh_dipohon']; ?></td>
                                    <td>
                                        <? if ($list['jenis_tuntutan'] == 'TRNSPRT'){

                                            echo $list['nama_tuntutan']; ?><br><br>
                                            <? echo $list['tempat_from']; ?>-
                                            <? echo $list['tempat_to'];
                                        } else {
                                            echo $list['nama_tuntutan'];
                                        }
                                        ?>
                                    </td>
                                    <td>RM <?php echo $list['jumlah_tuntut']; ?></td>
                                    <td><?php echo $list['nama_pelulus']; ?></td>
                                    <td><font color=red><strong><?php echo $list['status_tuntut'];?></strong></font></td>
                                    <td>

                                        <?
                                        if ($list['approve_status'] == 'BD' && $list['jenis_tuntutan'] !=='TRNSPRT') { ?>

                                            <a href="../view/kemaskini_default_tuntutan.php?jenis_tuntutan=<? echo $list['jenis_tuntutan'];?>&nama_tuntutan=<? echo $list['nama_tuntutan'];?>&id=<? echo $list['id'];?>&no_pemohon=<? echo $list['no_pemohon'];?>"><button type="button" class="btn btn-info"  >Kemaskini</button></a>

                                            <!-- <a href="pemohon_senarai.php?act=delete&id=<? //echo $list['id']; ?>&users=<?//php echo $list['name']; ?>"><button type="button" class="btn btn-danger" onclick="return checkDelete()">Padam</button-->
                                            <a href="../controller/hantar_button_tuntutan_exec.php?nama_tuntutan=<? echo $list['nama_tuntutan'];?>&value=<? echo $list['value'];?>&no_pemohon=<? echo $list['no_pemohon'];?>&table_ref=<? echo $list['table_ref'];?>"><button type="button"  onclick="return Confirm()" class="btn btn-success">Hantar</button></a>



                                            <?
                                        }

                                        else if ($list['approve_status'] == 'BD' && $list['jenis_tuntutan'] =='TRNSPRT') {?>

                                            <a href="../view/kemaskini_tuntutan_perjalanan.php?jenis_tuntutan=<? echo $list['jenis_tuntutan'];?>&nama_tuntutan=<? echo $list['nama_tuntutan'];?>&id=<? echo $list['id'];?>&no_pemohon=<? echo $list['no_pemohon'];?>"><button type="button" class="btn btn-info" >Kemaskini</button></a>

                                            <a href="../controller/hantar_button_tuntutan_exec.php?nama_tuntutan=<? echo $list['nama_tuntutan'];?>&value=<? echo $list['value'];?>&no_pemohon=<? echo $list['no_pemohon'];?>&table_ref=<? echo $list['table_ref'];?>"><button type="button"  onclick="return Confirm()" class="btn btn-success">Hantar</button></a>

                                            <?
                                        }
                                        ?>





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
        <? include ('../global/footer.php'); ?>
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