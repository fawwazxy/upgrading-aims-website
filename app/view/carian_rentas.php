<?php

include ('../controller/auth.php');

require "../model/functions.php";


$itemtofind = $_POST['itemtofind'];
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
                <h1 class="page-header">Carian Rentas</h1>
            </div>
            <form method="post" action="carian_rentas.php">
                <div class="col-lg-12">
                    <div class="form-group"> <!-- Date input -->
                        <label class="control-label" for="date">Katakunci Carian (Kod/No./Keterangan)</label>
                        <input class="form-control" id="itemtofind" name="itemtofind" value="<? echo $itemtofind?>" type="text"/>
                    </div>
                </div>

                <div class="panel-heading" align="right">
                    <button class="btn btn-primary" type="submit">Cari</button>

                </div>
            </form>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Carian Rentas
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>Bil.</th>
                                <th>Tarikh Dokumen</th>
                                <th>Jenis Dokumen & No. Rujukan</th>
                                <th>Nama Dokumen</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $datas = carianRentas($itemtofind);
                            $i=1;
                            while($list = $datas->fetch_assoc()) {
                                ?>

                                <tr class="odd gradeX">
                                    <td><?echo $i++;?></td>
                                    <td><?echo $list['tarikh_dokumen'];?></td>
                                    <td>
                                        <b><?echo $list['jenis_dokumen'];?></b><br>
                                        <b><?echo $list['kod_dokumen'];?></b>
                                    </td>
                                    <td><?echo $list['nama_dokumen'];?></td>
                                    <td>
                                        <a target="blank" href="<?echo $sys_domain.$list['link_dokumen'];?>"><button class="btn btn-warning" type="button" >Papar</button></a>

                                    </td>
                                </tr>
                            <?}?>


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