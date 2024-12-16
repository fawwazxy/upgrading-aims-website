<?php

include ('../controller/auth.php');

require "../model/project_management_function.php";

?>
<?

$id = $_GET['id'];
//$id_peranan = $_GET['id'];
$id_sebut_harga = $_GET['id_sebut_harga'];
//$id_projek = $_GET['id_projek'];


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
            return confirm('Adakah Anda Pasti untuk padam fasa kerja ini?');
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



            <h1 class="page-header">Tetapan Jadual Kerja</h1></div>
        <div class="row">

            <div class="panel-heading" align="right">
                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">

                <!-- <a href="../report/carta_gantt_projek.php?id=<? //echo $id; ?>" target="_blank">
                <button type="button" class="btn btn-info">Carta Gantt</button></a> -->

                <!-- <a href="../report/gantt_chart.php?id=<? //echo $id; ?>" target="_blank">
                <button type="button" class="btn btn-info">Carta Gantt</button></a> -->



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
                                    <td><p><b>Pegawai Pelaksana</b></td>
                                    <td><p>:&nbsp;</td>
                                    <td><p><a href="" onclick="return popitup('staff_details.php?no_staff=<? echo $log['ketua_projek'];?>')"><u><?php echo $log['nama_ketua_projek'] ?></u> </a></td>
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


                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                    Tetapan Jadual
                </button>

            </div>
            <div class="col-lg-12">
                <div class="row">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Senarai Fasa Kerja Mengikut Projek
                        </div>






                        <!--<button type="button" class="btn btn-primary">Add New Record</button-->

                        <!-- Button trigger modal -->


                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" align="left" id="myModalLabel">Tambah Fasa Kerja Dalam Projek</h4>
                                    </div>

                                    <div class="modal-body">





                                        <form method="post" action="../controller/jadual_kerja_exec.php?id=<? echo $id; ?>" >



                                            <input name="id_projek" type="hidden" class="input-short" value="<?php echo $log['id_pesanan_belian']; ?>" />


                                            <div>

                                                <label align="left"><font color="red">** Maklumat Wajib Diisi.</font></label>
                                            </div>








                                            <div class="form-group" align="left">
                                                <label>Fasa Kerja<font color="red">**</font>&nbsp;</label>
                                                <input class="form-control" name="fasa" id="fasa" required autocomplete="" /><br>
                                            </div>

                                            <div class="form-group" align="left">
                                                <label>Tarikh Mula<font color="red">**</font>&nbsp;</label>
                                                <input class="form-control" type="date" name="mula" id="mula" min="<? echo $log['tarikh_mula'];?>"  max="<? echo $log['tarikh_akhir'];?>" required autocomplete="" /><br>
                                            </div>
                                            <div class="form-group" align="left">
                                                <label>Tarikh Akhir<font color="red">**</font>&nbsp;</label>
                                                <input class="form-control" type="date" name="akhir" id="akhir" min="<? echo $log['tarikh_mula'];?>"  max="<? echo $log['tarikh_akhir'];?>" required autocomplete="" /><br>
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


                        <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4 class="modal-title" id="myModalLabel">Kemaskini Fasa Kerja Dalam Projek</h4>
                                    </div>
                                    <div class="modal-body" id="demo">
                                        <script type="text/javascript">

                                            $('#myModal1').on('show.bs.modal', function (e) {
                                                var rowid = $(e.relatedTarget).data('id');
                                                var projek = $(e.relatedTarget).data('id-projek');
                                                // $('#demo').html(rowid);
                                                $.ajax({
                                                    type:'GET',
                                                    url:'jadual_kerja_edit.php',
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
                                    <th>Nama</th>
                                    <th>Tarikh Mula Jangkaan</th>
                                    <th>Tarikh Akhir Jangkaan</th>
                                    <th>Bilangan Hari Jangkaan</th>
                                    <th>Tarikh Mula Sebenar</th>
                                    <th>Tarikh Akhir Sebenar</th>
                                    <th>Bilangan Hari Sebenar</th>
                                    <th>Tindakan</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?
                                $i= 1;
                                $data = getJadual2($id);
                                while($row_data = $data->fetch_assoc()) {


                                    ?>
                                    <tr class="odd gradeX">
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $row_data['fasa']; ?></td>
                                        <td><?php echo $row_data['mula']; ?></td>
                                        <td><?php echo $row_data['akhir']; ?></td>
                                        <td>
                                            <?php
                                            $date1=date_create($row_data['mula']);
                                            $date2=date_create($row_data['akhir']);
                                            $diff=date_diff($date1,$date2);
                                            echo (($diff->format("%R%a")) + 1) ." hari";

                                            //date_sub($date,date_interval_create_from_date_string("1 years"));

                                            ?>
                                        </td>
                                        <td><?php echo $row_data['mula_sebenar']; ?></td>
                                        <td><?php echo $row_data['akhir_sebenar']; ?></td>
                                        <td>
                                            <?
                                            if(IS_NULL($row_data['mula_sebenar']) && IS_NULL($row_data['akhir_sebenar']))
                                            {

                                            } else{

                                                $date1=date_create($row_data['mula_sebenar']);
                                                $date2=date_create($row_data['akhir_sebenar']);
                                                $diff=date_diff($date1,$date2);
                                                echo (($diff->format("%R%a")) + 1) ." hari";

                                                //date_sub($date,date_interval_create_from_date_string("1 years"));
                                            }
                                            ?>
                                        </td>

                                        <td width="15%">

                                            <button type="button" class="btn btn-info" data-id="<? echo $row_data['id']; ?>"  data-id-projek="<? echo $id; ?>" data-toggle="modal" data-target="#myModal1" >Kemaskini</button>
                                            <input type="hidden" id="id_projek" value="<? echo $id?>">

                                            <a href="../controller/delete_jadual_exec.php?id=<? echo $row_data['id']; ?>&id_projek=<? echo $id; ?>"><button type="button" class="btn btn-danger" onclick="return Confirm()">Padam</button>
                                        </td>

                                    </tr>
                                    <? $i++; } ?>



                                </tbody>


                            </table>

                        </div>

                        <!-- /.panel-body -->
                    </div>

                    <center><a href="../view/projek_list.php?no_staff=<? echo $_SESSION['SESS_NO_STAFF'];?>"><button type="button" class="btn btn-primary">Selesai</button></a></center>
                    <!-- /.panel -->

                </div>
                <!-- /.col-lg-12 -->
            </div>


            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>

        <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
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
