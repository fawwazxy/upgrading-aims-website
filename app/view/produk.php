<?php

include ('../controller/auth.php');
require "../model/lead_produk_function.php";

$id=$_GET['code'];
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
                <h1 class="page-header">Senarai Produk</h1>
            </div>
            <?
            $flagScreen="tab_2";
            include ('../global/menu_lead_produk.php');
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <?
                    $status= ($_GET['status']);
                    $flagScreen= ($_GET['flagScreen']);

                    if($flagScreen==''){
                        $flagScreen='tab_1';
                        $status='1';
                    }
                    $flagScreen=$_GET['flagScreen'];
                    include ('../global/menu_status_produk.php');

                    ?>
                </div>
            </div>


        </div>

        <div class="row">

            <div class="panel-heading" align="right">
                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Tambah Produk</button></a>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">

                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" align="left" id="myModalLabel">Tambah Produk</h4>
                        </div>

                        <div class="modal-body">


                            <form method="post" action="../controller/produk_exec.php?act=produk_add">


                                <div class="form-group" align="left">
                                    <label>Kod Produk</label>
                                    <input class="form-control" placeholder=" " id="code" name="code" required autocomplete="">
                                </div>

                                <div class="form-group" align="left">
                                    <label>Produk</label>
                                    <input class="form-control" placeholder=" " id="produk" name="produk" required autocomplete="">
                                </div>


                                <div class="form-group" align="left">
                                    <label>Penerangan</label>
                                    <textarea class="form-control" placeholder=" " id="penerangan" name="penerangan" required autocomplete=""></textarea>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Segmen</label>
                                    </br>
                                    <?
                                    $result = getSegmen();
                                    while($listN = mysqli_fetch_assoc($result)){?>
                                        <br>
                                        <input type = "checkbox" name = "segmen[]" value = "<?php echo "\'".$listN["id"]."\'" ?>">&nbsp;<?php echo $listN["code"];?> : <?php echo $listN["name"];?>

                                    <?}?>
                                </div>


                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" onClick="return confirm('Adakah anda pasti mahu menyimpan data ini?')";\">Simpan</button>
                                    <button type="reset" class="btn btn-warning" onClick="return confirm('Adakah anda pasti untuk membuat tatapan semua ?')";\">Tetapan Semula</button>
                                </div>



                            </form>

                        </div><!--modal-body-->

                    </div>
                    <!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->


            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Produk
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">


                            <thead>
                            <tr>
                                <th width="20px">#</th>
                                <th>Kod</th>
                                <th>Produk</th>
                                <th>Penerangan</th>
                                <th>Segmen</th>
                                <th>Status</th>
                                <th widht="50px">Tindakan</th>
                            </tr>

                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getProduk($status);
                            while($row_data = $data->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['code']; ?></a></td>
                                    <td><?php echo $row_data['produk']; ?></a></td>
                                    <td><?php echo $row_data['penerangan']; ?></a></td>
                                    <a class = "p2"><td><?php
                                            $j = 0;
                                            $result = getSegmenInfo($row_data['segmen']);
                                            while ($list = $result->fetch_assoc()){
                                                if ($j>0) echo "<br>";
                                                echo $list['code']."&nbsp
                    "."( ".$list['name'].")";
                                                $j++;
                                            }
                                            ?>
                                        </td></a>
                                    <td><font color="red"><strong>
                                                <? if($row_data['status']== '0'){
                                                echo "<font color=red><strong>TIDAK AKTIF</strong></font>";?>

                                                <font color="blue"><strong><?
                                                        } else if ($row_data['status'] == '1'){
                                                            echo  "<font color=blue><strong>AKTIF</strong></font>";
                                                        }?> </td>

                                    <td>
                                        <? if($row_data['status']== '0'){
                                            echo " ";?>
                                            <!-- <a href="produk_lead_edit.php?id=<?php// echo $row_data['id']; ?>"><button type="button" class="btn btn-info"  >Kemaskini</button></a> -->
                                            <a href="../controller/produk_exec.php?act=produk_update_status_baru&id=<? echo $row_data['id']; ?>">
                                                <button type="button" class="btn btn-success">Aktifkan</button></a>

                                        <?} else if ($row_data['status'] == '1'){
                                            echo  " ";
                                            ?>

                                            <a href="produk_lead_edit.php?id=<?php echo $row_data['id']; ?>"><button type="button" class="btn btn-info"  >Kemaskini</button></a>
                                            <!--
                                   <a href="../controller/produk_exec.php?act=produk_delete&id=<?php echo $row_data['id']; ?>">
                                    <button type="button" class="btn btn-danger" onClick="return confirm('Adakah anda pasti mahu memadam data ini?')";\">Padam</button></a> -->
                                            <a href="../controller/produk_exec.php?act=produk_update_status&id=<? echo $row_data['id']; ?>">
                                                <button type="button" class="btn btn-danger">Nyahaktif</button></a>
                                        <?}?>

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
        </div>
        <? include ('../global/footer.php'); ?>
    </div>


    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });

        $('.p2').collapser({
            mode: 'chars',
            truncate: 20
        });
    </script>

</body>

</html>
