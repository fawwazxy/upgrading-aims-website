<?php

include ('../controller/auth.php');

require "../model/support_function.php";

?>
<?
$no_staff = $_GET['no_staff'];

$no_staff_login = $_GET['SESS_NO_STAFF'];
$id_support = $_GET['id'];
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
            return confirm('Aduan ini akan dihantar kepada Tim Sokongan/Developer?');
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


            <div class="col-lg-12">

                <h1 class="page-header">Senarai Perkembangan Kerja</h1>


            </div>


            <?
            $data = getProgressView($id_support) -> fetch_assoc();
            ?>


            <p><b> Nama Projek</b> : <?php echo $data['nama_projek']; ?> </p>
            <!--<p><b> Agensi Rujukan</b> :<?php echo $data['agensi_rujukan']; ?></p>-->
            <p><b> Nama Penghantar</b> :<?php echo $data['nama_client']; ?></p>

            <p><b> No. Telefon</b> :<?php echo $data['notel']; ?></p>


            <p><b> Jangka Masa</b> :<?php echo $data['tarikh_mula']; ?> HINGGA <?php echo $data['tarikh_tamat']; ?> </p>


        </div>
        <div class="row">
            <div class="panel-heading" align="right">

                <button class="btn btn-info" type="button" data-id="<? echo $data['id']; ?>" data-toggle="modal" data-target="#myModal1" >Papar Aduan</button></a>
                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">


            </div>


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








            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Progress
                    </div>








                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Tarikh</th>
                                <th>Catatan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getProgress($id_support);
                            while($row_data = $data->fetch_assoc()) {

                                ?>



                                <tr class="odd gradeX">
                                    <td width="5%"><?php echo $i; ?></td>
                                    <td width="25%"><?php echo $row_data['tarikh']; ?></td>

                                    <td><?php echo $row_data['catatan']; ?></td>


                                    <!--  modal -->
                                    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" id="myModalLabel"></h4>
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
                                    <!-- tutup modal -->


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

<script type="text/javascript">\

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
