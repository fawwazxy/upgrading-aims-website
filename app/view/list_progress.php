<?php

include ('../controller/auth.php');

require "../model/support_function.php";


$id_support=$_GET['id'];
$no_staff_login = $_SESSION['SESS_NO_STAFF'];
$no_staff=$_GET['no_staff'];
$tab = $_GET['page'];
if($tab == 'belum'){
    $page="developer_support_belum_selesai.php";
}else if($tab == 'terakhir'){
    $page="developer_support_semakan_terakhir_list.php";
}


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

                <h1 class="page-header">Perkembangan Kerja</h1>
            </div>
            <?

            $row_data= getSupportProgress($id_support) -> fetch_assoc();

            ?>

            <p><b> Nama Projek</b> : <?php echo $row_data['nama_projek']; ?> </p>
            <!--<p><b> Agensi Rujukan</b> : <?php echo $row_data['agensi_rujukan']; ?></p>-->
            <p><b> Nama Penghantar</b> : <?php echo $row_data['nama_client']; ?></p>
            <p><b> Tarikh Tiket</b> : <?php echo $row_data['created_date']; ?></p>

            <p><b> No. Telefon</b> : <?php echo $row_data['notel']; ?></p>


            <p><b> Jangka Masa</b> : <?php echo $row_data['tarikh_mula']; ?> HINGGA <?php echo $row_data['tarikh_tamat'];   ?> </p>



            <?                                $tarikh_hrini=date("Y-m-d");
            if($row_data['tarikh_tamat']< $tarikh_hrini){
                $date1=date_create($row_data['tarikh_tamat']);
                $date2=date_create($tarikh_hrini);
                $diff=date_diff($date1,$date2);
                $hari=$diff->format("%a");
                // echo "<font color=red ><strong>-".$hari." HARI MELEBIHI MASA</strong></font><br>";
                echo "<h1 style=font-size:50px;color:red;
                                  ><strong>-".$hari." HARI MELEBIHI MASA</strong></h1><br>";


            }



            ?>


        </div>

        <div class="row">
            <div class="panel-heading" align="right">

                <?

                if($row_data['status_tindakan'] !='ST' && $row_data['status_tindakan'] !='S') {


                    ?>
                    <button class="btn btn-info" type="button" data-id="<? echo $row_data['id']; ?>" data-toggle="modal" data-target="#myModal1" >Papar Aduan</button></a>

                    <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"> Tambah Perkembangan Kerja</button>
                    <a href="../controller/selesai_exec.php?no_staff=<? echo $no_staff;?>&no_staff_login=<? echo $_SESSION['SESS_NO_STAFF'];?>&id=<? echo $row_data['id'];?>"> <button class="btn btn-warning" onclick="return Confirm()">Selesai</button></a>
                <?}?>
                <a href="<? echo $page;?>"><button type="button" class="btn btn-success">Kembali</button></a>

            </div></div>



        <div class="col-lg-12">

            <div class="panel panel-default">
                <div class="panel-heading">
                    Senarai Perkembangan Kerja
                </div>


                <!--<button type="button" class="btn btn-primary">Add New Record</button-->

                <!-- Button trigger modal -->


                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">

                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" align="left" id="myModalLabel">Tambah Perkembangan Kerja</h4>
                            </div>

                            <div class="modal-body">



                                <form method="post" enctype="multipart/form-data" action="../controller/add_progress_exec.php?id=<? echo $id_support; ?>" >
                                    <input name="no_staff" type="hidden" class="input-short" value="<? echo $_GET['no_staff']; ?>" />

                                    <input name="id" type="hidden" class="input-short" value="<? echo $id_support; ?>" />
                                    <input name="created_by_progress" type="hidden" class="input-short" value="<? echo $no_staff_login ?>" />

                                    <div class="form-group" align="left">
                                        <label>Tarikh</label><br>
                                        <input readonly class="form-control"  name="tarikh" id="tarikh" required autocomplete="off" value="<?php
                                        echo " " . date("d/m/Y") . "";
                                        ?> ">

                                        <!-- <input class="form-control" id="tarikh" name="tarikh" placeholder="DD/MM/YYY" type="date" value="</? echo $row['tarikh_mula'];?>"/> -->


                                    </div>

                                    <div class="form-group" align="left">
                                        <label>Perkembangan Kerja<font color="red"></font>&nbsp;</label>
                                        <textarea class="form-control" name="catatan" rows="5" id="catatan"></textarea>
                                    </div>





                                    <br><br>



                                    <br>

                                    <button type="submit" class="btn btn-primary">Simpan</button>

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
                                <h4 class="modal-title" id="myModalLabel">Keterangan</h4>
                            </div>
                            <div class="modal-body" id="demo">
                                <script type="text/javascript">
                                    $('#myModal1').on('show.bs.modal', function (e) {
                                        var rowid = $(e.relatedTarget).data('id');
                                        // $('#demo').html(rowid);
                                        $.ajax({
                                            type:'GET',
                                            url:'view_aduan_progress.php',
                                            data:'id='+rowid,
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


                <!-- /.panel-heading -->
                <div class="panel-body">

                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th width="20%">Oleh</th>
                            <th width="20%">Tarikh</th>

                            <th>Catatan</th>


                        </tr>
                        </thead>
                        <tbody>

                        <?
                        $i= 1;
                        $data = getProgressList($id_support);
                        while($list = $data->fetch_assoc()) {

                        ?>



                        <tr class="odd gradeX">
                            <td><?php echo $i; ?></td>
                            <td><?php echo $list['oleh']; ?></td>
                            <td><?php echo $list['created_date']; ?></td>
                            <td><?php echo $list['catatan']; ?></td>



                            </form>
                </div><!--modal-body-->

            </div>
            <!-- /.modal-content -->
            <!-- /.modal-dialog -->
        </div><!-- /.modal -->



        </tr>
        <?php $i++; } ?>

        </tbody>
        </table>

        <? include ('../global/footer.php'); ?>
    </div>

    <!-- /.panel-body -->
</div>
<!-- /.panel -->

</div>
<!-- /.col-lg-12 -->
</div>


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
