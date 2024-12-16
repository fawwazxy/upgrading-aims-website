<?php

include ('../controller/auth.php');

require "../model/chat_function.php";

?>
<?
$id=$_GET['id'];


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
        $flagScreen="tab_4";
        include ('../global/menu_forum.php');

        ?>

        <div class="panel-heading" align="right">

            <a href="add_category.php" > <button type="button" class="btn btn-primary">Tambah Kategori</button></a>
        </div>
        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Kategori Arkib
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">


                            <thead>
                            <tr>
                                <th width="20px">#</th>
                                <th>Kategori</th>
                                <th>Tindakan</th>
                            </tr>

                            </thead>
                            <tbody>
                            <?
                            $i= 1;
                            $data = getCategory();
                            while($row_data = $data->fetch_assoc()) {
                                ?>


                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['category_name']; ?></td>
                                    <td width="20%">
                                        <a href="category_edit.php?id=<? echo $row_data['category_id']; ?>">
                                            <button class="btn btn-info" type="button" >Kemaskini</button></a>



                                        <a href="../controller/delete_category_exec.php?id=<? echo $row_data['category_id']; ?>">
                                            <button type="button" class="btn btn-danger" onClick="return confirm('adakah anda pasti mahu memadam data ini?')";\">Padam</button>

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