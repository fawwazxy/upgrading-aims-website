<?php

include ('../controller/auth.php');

require "../model/support_function.php";
$sys = getSys(1)->fetch_assoc();

$no_staff = $_GET['no_staff'];

$no_staff_login = $_SESSION['SESS_NO_STAFF'];
$id = $_GET['id'];
$nama_projek = $_GET['nama_projek'];

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
            return confirm('Semakan Terakhir selesai?');
        }
        function Cancel(){
            return confirm('Anda pasti aduan ini ingin dibatalkan?');
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

    <style>
        .A{
            width:10px;
        }



    </style>
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
            $flagScreen="tab_4";
            include ('../global/menu_support_hr.php');
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
                                <th width="1%">Bil.</th>
                                <th width="11%">No Rujukan</th>
                                <th width="11%">Nama Projek</th>
                                <!-- <th>Aduan</th> -->
                                <th width="11%">Nama-No. Tel</th>
                                <th width="11%">Tindakan Oleh</th>
                                <th width="11%">Tahap Keutamaan</th>
                                <th width="11%">Tarikh Terima</th>
                                <th width="11%">Masa Untuk Siap</th>
                                <th width="11%">Status Tindakan</th>
                                <th width="11%">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getSupportSemakanTerakhir('ST');
                            while($row_data = $data->fetch_assoc()) {



                                ?>



                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['norujukan_support'];
                                        if(!is_null($row_data['support_parent'])){
                                            echo '<br><br><label>Aduan Asal : </label><br>'.$row_data['support_parent'];
                                        }if(!is_null(getSubSupportList($row_data['norujukan_support'])->fetch_assoc())){
                                            $j= 1;
                                            $data_sub = getSubSupportList($row_data['norujukan_support']);
                                            echo '<br><br><label>Pembahagian Aduan</label>';
                                            while($list_sub = $data_sub->fetch_assoc()) {
                                                echo '<br>'.$list_sub['norujukan_support'];
                                            }
                                        }?>
                                    </td>
                                    <td><?php echo $row_data['nama_projek']; ?><br><?//php echo $row_data['agensi_rujukan']; ?></td>

                                    <td><?php echo $row_data['nama_client']; ?><br><?php echo $row_data['notel']; ?><br>
                                        <a button class="btn btn-success" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $row_data['notel']; ?>&text=<? echo "*".$row_data['kod_projek']."::Log-Ticket Pelanggan*"?>%0aNama Pelanggan : *<?echo $row_data['nama_client'];?>*%0aNo. Tiket : *<?php echo $row_data['norujukan_support']; ?>*%0a%0aSila klik pada link <?echo $sys['sys_domain']."/app/view/maklum_balas.php?id%3d".$row_data['id']?> untuk melihat status terkini aduan anda.')">WhatsApp</button></a>
                                    </td>
                                    <td><?php echo $row_data['namadev']; ?></td>
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
                                    <td><?php if($row_data['noti_status']=='1'){?>
                                            <div align="center"><i class="fa fa-bell" style="font-size:30px;color:red"></i><br><br></div>
                                        <?} echo date("d-m-Y h:i A", strtotime($row_data['created_date'])); ?></td>
                                    <td><center><?php if($row_data['tarikh_mula']!=''){echo date("d-m-Y",strtotime($row_data['tarikh_mula'])).'<br> HINGGA <br>'.date("d-m-Y",strtotime($row_data['tarikh_tamat']));}  ?></center></td>
                                    <td>
                                        <font color='red'><strong>SEMAKAN TERAKHIR</strong></font>
                                        <a href="../controller/support_selesai_exec.php?no_staff=<? echo $row_data['no_staff'];?>&no_staff_login=<? echo $_SESSION['SESS_NO_STAFF'];?>&id=<? echo $row_data['id'];?>nama_projek=<?php echo $row_data['nama_projek']; ?>"> <button class="btn btn-warning" onclick="return Confirm()">SELESAI</button></a>

                                    </td>




                                    <td>
                                        <!--  <a href="hr_support_update.php?id=<? echo $row_data['id'];?>"><button class="btn btn-info" type="button" >Kemaskini</button></a> -->

                                        <a href="hr_update_support.php?id=<? echo $row_data['id'];?>"><button class="btn btn-info" type="button" >Kemaskini</button></a>
                                        <a><button class="btn btn-success" type="button" data-id="<? echo $row_data['id']; ?>" data-toggle="modal" data-target="#myModal1" >Papar Aduan</button></a>
                                        <br><a target="blank"  href="maklum_balas.php?id=<? echo $row_data['id'];?>" ><button class="btn btn-warning" type="button" >Skrin Maklum Balas</button></a>
                                        <br><a href="papar_progress.php?id=<? echo $row_data['id'];?>" ><button class="btn btn-info" type="button" >Papar Perkembangan Kerja</button></a>
                                        <br><a href="../controller/support_exec.php?action=batal_4&id=<? echo $row_data['id'];?>&id_developer=<?echo $row_data['id_support_developer']?>"> <button class="btn btn-danger" onclick="return Cancel()">Batal</button></a>

                                        <!--  <a href="reassign.php?id=<? echo $row_data['id'];?>"><button class="btn btn-warning" type="button" >Reassign</button></a> -->
                                    </td>


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
                                                                url:'view_aduan.php',
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

<script>
    $('.Contact').click(function(){
        var id=$('.Contact').val();
        $.ajax({url:"ModalPage.php?id="+id,cache:false,success:function(result){
                $(".modal-content").html(result);
            }});
    });
</script>

<script type="text/javascript">

    $(document).ready(function(){
        $('#myModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $.ajax({
                type : 'post',
                url : 'fetch_record.php', //Here you will fetch records
                data :  'rowid='+ rowid, //Pass $id
                success : function(data){
                    $('.fetched-data').html(data);//Show fetched data from database
                }
            });
        });
    });
</script>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
</script>

</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>

</body>

</html>
