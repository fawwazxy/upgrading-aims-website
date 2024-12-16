<?php

include ('../controller/auth.php');

require "../model/chat_function.php";

?>
<?
$carian = $_GET['carian'];
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
        <?
        $flagScreen="tab_5";
        include ('../global/menu_forum.php');

        ?>
        </br>
        <div class="row" align="right">
            <div class="col-lg-12">
                <!--  <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
                 --></div>
        </div>

        <div class="col-lg-12" align="center">
            <form action="../controller/search_exec.php" method="POST">
                <h3>Carian**</h3>
                <table>
                    <tr>
                        <td><input class="form-control" type="text" placeholder="cari" id="name" name="name"" ></td>
                        <td><input class="btn btn-info" type="submit" name="submit" value="Cari"></td>
                    </tr>
                </table>
                <h6>** masukkan kata kunci carian anda</h6>
            </form>
        </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Senarai Topik Mengikut Carian
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">

                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">


                        <thead>
                        <tr>
                            <th width="20px">#</th>
                            <th width="50px">Tajuk</th>
                            <th>Kategori</th>
                            <th>Topik</th>
                            <th>Respon</th>
                            <th>Tindakan</th>

                        </thead>

                        <tbody>
                        <?
                        $i= 1;
                        $data = getCarian($carian);
                        while($row_data = $data->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $i; ?></td>
                                <td>
                                    <? echo $row_data['topik'];?></td>

                                <td>
                                    <?echo $row_data['category_name'];?>
                                </td>

                                <td>
                                    <? echo $row_data['forum_message'];?>
                                </td>

                                <td>
                                    <? echo $row_data['respon_message'];?>
                                </td>


                                <td><a href="../controller/update_counter_exec.php?id=<? echo $row_data['id']; ?>">
                                        <button class="btn btn-info" type="button">Lihat Topik</button></td>
                            </tr>
                            <?php $i++; } ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.panel-body -->
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