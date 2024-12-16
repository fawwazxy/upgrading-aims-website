<?php

include ('../controller/auth.php');

require "../model/support_function.php";

?>
<?
$id=$_GET['id'];
$id_progress=$_GET['id_progress'];
$no_staff=$_SESSION['SESS_NO_STAFF'];
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

        function popitup(url) {
            /*newwindow=window.open(url,'name','height=842,width=595');*/
            newwindow=window.open(url,'name','height=595,width=842');
            if (window.focus) {newwindow.focus()}
            return false;
        }
        function Confirm(){
            return confirm('Anda pasti?');
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
            include ('../global/menu_developer_support.php');
            ?>
            <div class="col-lg-12">

            </div>
        </div>
        <div class="row">
            <div class="panel-heading" align="right">




            </div>

            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Aduan
                    </div>








                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="4%">Bil.</th>
                                <th width="12%">No Rujukan</th>
                                <th width="12%">Nama Projek</th>
                                <th width="12%">Nama-No. Tel</th>
                                <th width="12%">Tarikh Terima</th>
                                <th width="12%">Masa Untuk Siap</th>
                                <th width="12%">Tahap Keutamaan</th>
                                <th width="12%">Status Tindakan</th>
                                <th width="12%">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getSupportDeveloperBS($no_staff,$status_tindakan);
                            while($row_data = $data->fetch_assoc()) {



                                ?>



                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['norujukan_support'];?></td>
                                    <td><?php echo $row_data['kod_projek'].' - '.$row_data['nama_projek']; ?></td>
                                    <td><?php echo $row_data['nama_client']; ?><br><?php echo $row_data['notel']; ?><br>
                                        <!--
                          <button class="btn btn-success" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $row_data['notel']; ?>&text=Assalamualaikum <?php echo $row_data['nama_client']; ?>, No. tiket: <?php echo $row_data['norujukan_support']; ?> ')" >WhatsApp</button>
                        -->
                                    </td>
                                    <td><?php if($row_data['noti_status']=='1'){?>
                                            <div align="center"><i class="fa fa-bell" style="font-size:30px;color:red"></i><br><br></div>
                                        <?} echo date("d-m-Y h:i A", strtotime($row_data['created_date'])); ?></td>
                                    <td align="center"><?php echo date("d-m-Y",strtotime($row_data['tarikh_mula'])).'<br> HINGGA <br>'.date("d-m-Y",strtotime($row_data['tarikh_tamat']));; ?></td>
                                    <td align="center">
                                        <?
                                        if(!empty($row_data['level_developer'])){
                                            for ($k = 1; $k <= 5; $k++) {
                                                $ratingClass = 'style="font-size:20px;color:white;"';
                                                if($k <= $row_data['level_developer']) {
                                                    $ratingClass = 'style="font-size:20px;color:black"';
                                                }?>
                                                <span class="glyphicon glyphicon-star" <?php echo $ratingClass; ?> aria-hidden="true"></span>
                                            <?}?>
                                            <br><font size="2px"><b>Rujukan : </b><br>
                                                <?
                                                for ($j = 1; $j <= 5; $j++) {
                                                    $ratingClass = 'style="color:white"';
                                                    if($j <= $row_data['level_aduan']) {
                                                        $ratingClass = 'style="color:black"';
                                                    }
                                                    ?>
                                                    <span class="glyphicon glyphicon-star" <?php echo $ratingClass; ?> aria-hidden="true"></span>
                                                <?}?>

                                            </font>
                                        <?}else{?>
                                            <br><b>Rujukan : </b><br>
                                            <?
                                            for ($l = 1; $l <= 5; $l++) {
                                                $ratingClass = 'style="font-size:20px;color:white"';
                                                if($l <= $row_data['level_aduan']) {
                                                    $ratingClass = 'style="font-size:20px;color:black"';
                                                }?>
                                                <span class="glyphicon glyphicon-star" <?php echo $ratingClass; ?> aria-hidden="true"></span>
                                            <?}
                                        }?>

                                    </td>
                                    <td>
                                        <?php echo "<font color=blue><strong>DALAM PROSES</strong></font><br>";
                                        $tarikh_hrini=date("Y-m-d");
                                        if($row_data['tarikh_tamat']< $tarikh_hrini){
                                            $date1=date_create($row_data['tarikh_tamat']);
                                            $date2=date_create($tarikh_hrini);
                                            $diff=date_diff($date1,$date2);
                                            $hari=$diff->format("%a");
                                            echo "<font color=red><strong>".$hari." HARI MELEBIHI MASA</strong></font><br>";
                                        }?>
                                    </td>
                                    <td>
                                        <!--  <a href="developer_support_update.php?id=<? echo $row_data['id'];?>&no_staff=<? echo $no_staff; ?>"><button class="btn btn-info" type="button" >Kemaskini</button></a>  -->
                                        <a href="developer_update_rating.php?id=<? echo $row_data['id'];?>&id_support_developer=<? echo $row_data['id_support_developer'];?>&no_staff=<? echo $no_staff; ?>"><button class="btn btn-info" type="button" >Kemaskini</button></a>
                                        <a><button class="btn btn-success" type="button" data-id="<? echo $row_data['id']; ?>" data-toggle="modal" data-target="#myModal1" >Papar Aduan</button></a>

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
                                        <a href="list_progress.php?id=<? echo $row_data['id'];?>&no_staff=<? echo $no_staff; ?>&page=belum" ><button class="btn btn-info" type="button" >Perkembangan Kerja</button></a>

                                        <a href="../controller/selesai_exec.php?no_staff=<? echo $no_staff;?>&no_staff_login=<? echo $_SESSION['SESS_NO_STAFF'];?>&id=<? echo $row_data['id'];?>"> <button class="btn btn-warning" onclick="return Confirm()">Selesai</button></a>
                                        <!-- <a href="add_progress.php?id=<? echo $row_data['id'];?>&id_progress=<? echo $row_data['id_progress']; ?>&no_staff=<? echo $no_staff; ?>"><button class="btn btn-danger" type="button" >Cancel Aduan</button></a> -->

                                    </td>



                                    <!--<button type="button" class="btn btn-primary">Add New Record</button-->

                                    <!-- Button trigger modal -->


                                    <!-- Modal -->
                                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">

                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" align="left" id="myModalLabel">Jam Diperlukan Untuk Siapkan </h4>
                                                </div>

                                                <div class="modal-body">

                                                    <form method="post" action="../controller/add_jam_exec.php?id=<?php echo $row_data['id']; ?>" >






                                                        <div class="form-group">
                                                            <label for="comment">Jam</label>
                                                            <input class="form-control" rows="5" name="jam_siap" id="jam_siap" ></input>
                                                        </div>




                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Simpan</button></a>
                                                            <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                                        </div>
                                                </div>
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
