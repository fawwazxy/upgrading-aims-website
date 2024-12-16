<?php

include ('../controller/auth.php');

require "../model/support_function.php";

?>
<?
date_default_timezone_set("Asia/Kuala_Lumpur");
$current_year=date("Y");
$day_no=date("w");
$week_no=date("W");
date("d M Y");
date("W",strtotime(date("n")));

$no_staff = $_GET['no_staff'];
$no_staff_login = $_GET['SESS_NO_STAFF'];
$id = $_GET['id'];
//$nama_projek = $_GET['nama_projek'];
//$nama_projek = $_POST['nama_projek'];

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
            <?
            $flagScreen="tab_8";
            include ('../global/menu_support_hr.php');
            ?>

            <div class="col-lg-12">

            </div>
        </div>
        <div class="row">
            <div class="panel-heading" align="right">

                <a href="../report/analisa_keseluruhansokongan.php" target="blank"><button type="button" class="btn btn-primary">Lihat Analisa Keseluruhan</button></a>


            </div>

            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Sokongan Berdasarkan Jenis Sistem
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="5%">Bil.</th>
                                <th width="30%">Nama Projek</th>
                                <th width="25%">Bil. Aduan Semasa</th>
                                <th width="25%">Bil. Penolakan</th>
                                <th width="15%">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>


                            <?
                            $i= 1;
                            $data = getCountSistem();
                            while($row_data = $data->fetch_assoc()) {




                            ?>



                            <tr class="odd gradeX">
                                <td><?php echo $i; ?></td>
                                <td><?php echo $row_data['kod_projek'].'&nbsp;-&nbsp;'.$row_data['nama_projek']; ?></td>
                                <td><b><?php echo $row_data['bilangan_projek']; ?></b><br>

                                    ..................................<br>

                                    <?
                                    $i= 1;
                                    $list = getcountStatus($row_data['kod_projek']);
                                    while($list_data = $list->fetch_assoc()) {
                                        echo $list_data['keterangan']." : ".$list_data['countST']."<br>";
                                    }
                                    ?>

                                </td>
                                <td>
                                    <?
                                    echo '<font color="red" size="10px"><b><center>'.getCountRejected('',$row_data['kod_projek']).'</center></b></font>';
                                    ?>
                                </td>
                                <td><a target="_blank" href="../report/analisa_supportkpi.php?kod_projek=<? echo $row_data['kod_projek'];?>"><button type="submit" class="btn btn-primary">Lihat Analisa</button></a></td>
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
