<?php

include ('../controller/auth.php');
require "../model/claim_function.php";

?>
<?

// $id = $_GET['id'];
// $id_sebut_harga = $_GET['id_sebut_harga'];
//$id_projek = $_GET['id_projek'];

$id = $_GET['id'];
$no_staff = $_GET['no_staff'];
$tahun = $_GET['tahun'];


?>

<?
//  if(isset($_GET['act']) && $_GET['act'] == "delete" && !empty($_GET['id']))
// {
//  deleteSebutHarga($id);
// }

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

        // -->
    </script>

    <script language="JavaScript" type="text/javascript">
        function checkDelete(){
            return confirm('Adakah anda pasti untuk padam Peranan ini?');
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
            </div>
            <?
            $flagScreen="tab_1";
            include ('../global/menu_tuntutan.php');
            ?>
            <h1 class="page-header">Jenis Tuntutan</h1>
            <div class="panel-heading" align="right">



                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                    Tambah Tuntutan
                </button>

            </div>




            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Tuntutan
                    </div>






                    <!--<button type="button" class="btn btn-primary">Add New Record</button-->

                    <!-- Button trigger modal -->


                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" align="left" id="myModalLabel">Tambah Tuntutan</h4>
                                </div>

                                <div class="modal-body">





                                    <form method="post" action="../controller/nama_tuntutan_add_exec.php" >






                                        <div>

                                            <label align="left"><font color="red">** Maklumat Wajib Diisi.</font></label>
                                        </div>
                                        <div class="form-group" align="left">
                                            <label>Nama Tuntutan<font color="red">**</font>&nbsp;</label>
                                            <input class="form-control" placeholder=" " id="nama_tuntutan" name="nama_tuntutan" required autocomplete="" type="text">
                                        </div>
                                        <div class="form-group" align="left">
                                            <label>Kod Singkatan<font color="red">**</font>&nbsp;</label>
                                            <input class="form-control" placeholder=" " id="code" name="code" required autocomplete="" type="text">
                                        </div>



                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                            <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                        </div>
                                    </form>


                                </div>

                            </div><!--modal-body-->

                        </div>
                        <!-- /.modal-content -->
                        <!-- /.modal-dialog -->
                    </div><!-- /.modal -->





                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#.</th>
                                <th>Nama Tuntutan</th>
                                <th>Kod Singkatan</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getNamaTuntutan();
                            while($row_data = $data->fetch_assoc()) {




                            ?>
                            <tr class="odd gradeX">
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row_data['nama_tuntutan']; ?></td>
                                <td><?php echo $row_data['code']; ?></td>
                                <td>

                                    <?
                                    if($row_data['code'] !=='TRNSPRT'){

                                    ?>
                                    <a href="../controller/delete_tuntutan_exec.php?id=<? echo $row_data['id']; ?>"><button type="button" class="btn btn-danger">Padam</button>
                                        <?

                                        } else {

                                        }
                                        ?>



                                </td>




                                <?php $i++; } ?>
                            </tr>






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
