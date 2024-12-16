<?php

include ('../controller/auth.php');

require "../model/project_management_function.php";

?>
<?

$id = $_GET['id'];

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
            return confirm('Adakah anda pasti untuk padam Peranan ini?');
        }

        function Confirm2(){
            return confirm('Adakah Anda Pasti untuk tekan butang bekerja ini??');
        }



        function popitup(url) {
            /*newwindow=window.open(url,'name','height=842,width=595');*/
            newwindow=window.open(url,'name','height=595,width=842');
            if (window.focus) {newwindow.focus()}
            return false;
        }

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

            <?
            $flagScreen="tab_2";
            include ('../global/menu_pengurusan_projek.php');

            ?>
        </div>
        <div class="row">
            <?
            $flagScreen="tab_1";
            include ('../global/menu_struktur_kerja.php');

            ?>

            <div class="panel-heading" align="right">




            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">

                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <!-- /.list detail -->


                            <table  >
                                </tbody>

                                <?
                                $log = getProjekDetailsById($id) -> fetch_assoc();
                                ?>
                                <tr>
                                    <td><p><b>Tajuk Projek</b></td>
                                    <td><p>:&nbsp;</td>
                                    <td><p><?php echo $log['tajuk_sebut_harga'] ?> </td>
                                </tr>
                                <tr>
                                    <td><p><b>Pelanggan</b></td>
                                    <td><p>:&nbsp;</td>
                                    <td><p><?php echo $log['agensi_rujukan'] ?> </td>
                                </tr>
                                <tr>
                                    <td><p><b>Pegawai Rujukan Agensi</b></td>
                                    <td><p>:&nbsp;</td>
                                    <td><p><?php echo $log['nama_rujukan'] ?></td>
                                </tr>
                                <tr>
                                    <td><p><b>Pegawai Rujukan Dalaman </b></td>
                                    <td><p>:&nbsp;</td>
                                    <td><p><a href="" onclick="return popitup('staff_details.php?no_staff=<? echo $log['pegawai_dalaman'];?>')"><u><?php echo $log['nama_pegawai_dalaman'] ?></u> </a></td>
                                </tr>
                                <tr>
                                    <td><p><b>Jangka Masa Kerja</b></td>
                                    <td><p>:&nbsp;</td>
                                    <td><p><?php echo $log['tarikh_mula'] ?> hingga <?php echo $log['tarikh_akhir'] ?>&nbsp;&nbsp;(<?php echo $log['jumlah_hari'] ?> hari)</td>
                                </tr>


                                </tbody>
                            </table>



                        </div>
                    </div>

                </div>
            </div>





            <div class="panel-heading" align="right">




            </div>
            <div class="row">
                <div class="col-lg-12">

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Senarai Peranan Mengikut Projek
                        </div>






                        <!--<button type="button" class="btn btn-primary">Add New Record</button-->

                        <!-- Button trigger modal -->


                        <!-- Modal -->


                        <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Kemaskini Peranan Projek</h4>
                                    </div>
                                    <div class="modal-body" id="demo">
                                        <script type="text/javascript">

                                            $('#myModal1').on('show.bs.modal', function (e) {
                                                var rowid = $(e.relatedTarget).data('id');
                                                var projek = $(e.relatedTarget).data('id-projek');
                                                // $('#demo').html(rowid);
                                                $.ajax({
                                                    type:'GET',
                                                    url:'struktur_kerja_update.php',
                                                    data:{id: +rowid , id_projek: +projek},
                                                    success:function(html){
                                                        $('#demo').html(html);
                                                    }
                                                });
                                            });
                                        </script>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>




                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">




                                <thead>
                                <tr>
                                    <th>#.</th>
                                    <th>Peringkat</th>
                                    <th>Nama Peranan</th>
                                    <th>Tindakan</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?
                                $i= 1;
                                $data = getPerananProjek($id);
                                while($row_data = $data->fetch_assoc()) {




                                    ?>
                                    <tr class="odd gradeX">
                                        <td width="10%"><?php echo $i; ?></td>
                                        <td width="15%"><?php echo $row_data['description']; ?></td>
                                        <td><?php echo $row_data['nama_peranan']; ?></td>

                                        <td width="15%">


                                            <!--   <a href="struktur_kerja_edit.php?id_peranan=<? echo $row_data['id']; ?>&id_projek=<? echo $id; ?>"><button type="button" class="btn btn-info">Kemaskini</button> -->

                                            <button type="button" class="btn btn-info" data-id="<? echo $row_data['id']; ?>"  data-id-projek="<? echo $id; ?>" data-toggle="modal" data-target="#myModal1" >Kemaskini</button>
                                            <input type="hidden" id="id_projek" value="<? echo $id?>">

                                            <a href="../controller/delete_peranan_exec.php?id_peranan=<? echo $row_data['id']; ?>&id_projek=<? echo $id; ?>"><button type="button" class="btn btn-danger" onclick="return Confirm()">Padam</button></a>


                                        </td>

                                    </tr>
                                    <? $i++; } ?>



                                <tr>
                                    <form method="post" action="../controller/struktur_kerja_exec.php?id=<? echo $id; ?>" >

                                        <td>&nbsp;</td>
                                        <td>
                                            <input name="id_projek" type="hidden" class="input-short" value="<?php echo $log['id_pesanan_belian']; ?>" />

                                            <select required class="form-control"  name="id_peringkat" value="">
                                                <option value="">-- Pilih --</option>

                                                <? $person= getPeringkatPeranan();
                                                while ($pilih  = $person -> fetch_assoc()){ ?>
                                                    <option value="<? echo $pilih['id'];?>"><? echo $pilih['description'];?></option>

                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input class="form-control" placeholder=" " id="nama_peranan" name="nama_peranan" size="70" required autocomplete="" type="text">
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-primary">Tambah</button>
                                        </td>
                                    </form>
                                </tr>





                                </tbody>


                            </table>

                        </div>

                        <!-- /.panel-body -->
                    </div>

                    <!-- <center><a href="../view/ahli_kumpulan_add.php?id=<? echo $id ?>"><button type="button" class="btn btn-info">Seterusnya</button></a></center> -->

                    <center><a href="../view/senarai_ahli_projek.php?id=<? echo $id ?>"><button type="button" class="btn btn-info">Seterusnya</button></a></center>
                    <!-- /.panel -->

                </div>
                <!-- /.col-lg-12 -->
            </div>


            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>
        <? include ('../global/footer.php'); ?>

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
