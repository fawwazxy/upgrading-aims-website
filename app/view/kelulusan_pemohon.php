<?php

include ('../controller/auth.php');

require "../model/pemohon_functions.php";

?>

<?

$pemohon_id = $_GET['pemohon_id'];

//$no_staff = $_GET['no_staff'];
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
        function checkDelete(){
            return confirm('Adakah anda pasti untuk padam Peranan ini?');
        }
    </script>

    <script language="javascript" type="text/javascript">


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
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Jadual Temuduga</h1>
            </div>

            <div class="panel-heading" align="right">
                <!--a href="permohonan_baru.php">
                <button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Tambah Permohonan Baru</button></a-->

            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Pemohon
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Pemohon</th>
                                <th>Peranan Dipohon</th>
                                <th>Tarikh Temuduga</th>
                                <!-- <th>Masa Temuduga</th> -->
                                <th>Tarikh Kemaskini</th>
                                <th>Catatan</th>
                                <th>Ditemuduga Oleh</th>
                                <th>Status</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i= 1;
                            $log_kelulusan = getLogKelulusan();
                            while($log = $log_kelulusan->fetch_assoc()) {
                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $log['nama_pemohon']; ?></td>
                                    <td><?php echo $log['role_id']; ?></td>
                                    <td><?php echo $log['tarikh_iv']; ?><br>Mula : <?php echo $log['masa_iv']; ?></td>
                                    <!--td><?php echo $log['masa_iv']; ?></td-->
                                    <td><?php echo $log['created_date']; ?></td>
                                    <td><?php echo $log['catatan']; ?></td>
                                    <td width="20%"><?//php echo $log['nama_staff']; ?>

                                        <?
                                        $ketua_no_staff='';
                                        $loop = getPenemuduga($log['id']);
                                        $no_list = 1;
                                        while($penemuduga = $loop->fetch_assoc()) {
                                            if($penemuduga['flag_ketua'] == '1'){
                                                echo $no_list.") ".$penemuduga['name']."<b>  (KETUA)</b><br>";
                                                $ketua_no_staff=$penemuduga['no_staff'];

                                            }else{
                                                echo $no_list.") ".$penemuduga['name']."<br>";
                                            }

                                            $no_list++;
                                        }
                                        ?>

                                    </td>
                                    <td><strong><font color=blue><?php echo $log['desc']; ?></font></strong></td>

                                    <td>
                                        <?

                                        $log_kelulusanByFlag=getPenemudugaByFlag($_SESSION['SESS_NO_STAFF'])->fetch_assoc();
                                        ?>
                                        <?
                                        if($log_kelulusanByFlag['peranan']=='ADMIN' && $_SESSION['SESS_NO_STAFF']==$ketua_no_staff && $log['desc'] == 'TEMUDUGA')
                                        {

                                        ?>

                                        <a href="update_kelulusan_pemohon.php?pemohon_id=<? echo$log['pemohon_id']; ?>"><button type="button" class="btn btn-warning">Pengesahan</button>

                                            <a href="hr_update_interview.php?pemohon_id=<? echo $log['pemohon_id']; ?>"><button type="button" class="btn btn-info">Kemaskini</button>

                                                <?

                                                } else if ($log_kelulusanByFlag['peranan'] !=='ADMIN' && $_SESSION['SESS_NO_STAFF']==$ketua_no_staff && $log['desc'] == 'TEMUDUGA'){

                                                ?>
                                                <a href="update_kelulusan_pemohon.php?pemohon_id=<? echo $log['pemohon_id']; ?>&act=normal"><button type="button" class="btn btn-warning">Pengesahan</button>

                                                    <?

                                                    } else if ($log_kelulusanByFlag['peranan'] =='ADMIN' && $_SESSION['SESS_NO_STAFF']!==$ketua_no_staff && $log['desc'] == 'TEMUDUGA'){

                                                    ?>
                                                    <a href="hr_update_interview.php?pemohon_id=<? echo $log['pemohon_id']; ?>"><button type="button" class="btn btn-info">Kemaskini</button>



                                                        <?


                                                        }


                                                        ?>

                                                        <a href=""><button type="button" class="btn btn-info" onclick="return popitup('pemohon_details.php?pemohon_id=<? echo $log['pemohon_id']; ?>')">Papar Permohonan</button>

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