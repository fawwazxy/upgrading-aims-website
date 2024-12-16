<?php

include ('../controller/auth.php');

require "../model/surat_function.php";

?>
<?

$lead = $_GET['lead'];

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
                <h1 class="page-header">Senarai surat</h1>
            </div>
        </div>
        <div class="row">
            <div class="panel-heading" align="right">
                <a href="pilih_surat.php">
                    <button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Tambah Surat</button></a>

            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai surat
                    </div>






                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama lead</th>
                                <th>Produk</th>
                                <th>Jenis Surat</th>
                                <th>Kod Surat</th>
                                <th>created date</th>

                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getSurat();
                            while($row_data = $data->fetch_assoc()) {

                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['lead']; ?></td>
                                    <td><?php echo $row_data['produk']; ?></td>
                                    <td><?php echo $row_data['surat']; ?></td>
                                    <td><?php echo $row_data['kod']; ?></td>
                                    <td><?php echo $row_data['created_date']; ?></td>


                                    <td>
                                        <?
                                        if($row_data['kod'] == 'DEMO') {	?>

                                            <a target="_blank" href="../template/surat_minat_demo.php?lead=<? echo $row_data['lead'];?>&surat=<? echo $row_data['surat'];?>&produk=<? echo $row_data['produk'];?>&created_date=<? echo $row_data['created_date'];?>"><button class="btn btn-warning" type="button" >Surat Demo</button></a>

                                            <?
                                        }
                                        else if  ($row_data['kod'] == 'APPMT') {	?>

                                            <a target="_blank" href="../template/surat_minat_temujanji.php?lead=<? echo $row_data['lead'];?>&surat=<? echo $row_data['surat'];?>&produk=<? echo $row_data['produk'];?>&created_date=<? echo $row_data['created_date'];?>"><button class="btn btn-warning" type="button" >Surat Temujanji</button></a>

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
