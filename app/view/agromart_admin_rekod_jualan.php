<?php

include ('../controller/auth.php');

require "../model/agromart_functions.php";
require "../model/lookup.php";

$sys = getSys(1)->fetch_assoc();
$flagScreen = 'tab_1'

?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- <meta http-equiv="refresh" content="<?php echo $sec?>;URL='<?php echo $page?>'">
    </head>
    <body>
    <?php
    echo "Watch the page reload itself in 10 second!";
    ?>
    </body> -->

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
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Rekod Jualan</h1>
                <?include '../global/agromart_menu.php'?>
            </div>
        </div>

        <div class="panel panel-red">
            <div class="panel-heading" align="center">
                <label class="control-label" for="date">Analisa Transaksi Jualan Hasil Tani</label>
            </div>
            <!-- /.panel-heading -->
            <table width="100%" class="table table-striped table-bordered table-hover">
                <thead>
                <tr>
                    <th bgcolor="#D6DBDF" width="25%"><center>Hari Ini</center></th>
                    <th bgcolor="#D6DBDF" width="25%"><center>Minggu Ini</center></th>
                    <th bgcolor="#D6DBDF" width="25%"><center>Bulan Ini</center></th>
                    <th bgcolor="#D6DBDF" width="25%"><center>Tahun Ini</center></th>
                </tr>
                </thead>
                <?
                $transjualan_curdate = getCountTransJualanByCurDate();
                $transjualan_curweek = getCountTransJualanByCurWeek();
                $transjualan_curmonth = getCountTransJualanByCurMonth();
                $transjualan_curyear = getCountTransJualanByCurYear();

                ?>
                <tbody>
                <td bgcolor="#FDFEFE" align="center"><strong><font size="6" color="blue"><?echo $transjualan_curdate;?></font></strong></td>
                <td bgcolor="#FDFEFE" align="center"><strong><font size="6" color="purple"><?echo $transjualan_curweek;?></font></strong></td>
                <td bgcolor="#FDFEFE" align="center"><strong><font size="6" color="green"><?echo $transjualan_curmonth;?></font></strong></td>
                <td bgcolor="#FDFEFE" align="center"><strong><font size="6" color="orange"><?echo $transjualan_curyear;?></font></strong></td>
                </tbody>
            </table>
        </div>

        <div class="form-group" align="right">
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Senarai Rekod Jualan</label>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="7%">Bil</th>
                                <th width="15%">No. Resit</th>
                                <th width="20%">Jumlah Jualan (RM)</th>
                                <th width="20%">Jumlah Bayaran (RM)</th>
                                <th width="20%">Jumlah Baki (RM)</th>
                                <th width="15%">Tarikh Jualan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $rekod_jualan = getTransJualanList();
                            $i=1;
                            while($list_rekod_jualan = $rekod_jualan->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?echo $i++;?></td>
                                    <td><b><font color="black" size="4"><?echo $list_rekod_jualan['no_resit'];?></font></b></td>
                                    <td><b><font color="green" size="4"><?echo $list_rekod_jualan['jumlah_jualan'];?></font></b></td>
                                    <td><b><font color="blue" size="4"><?echo $list_rekod_jualan['jumlah_bayaran'];?></font></b></td>
                                    <td><b><font color="purple" size="4"><?echo $list_rekod_jualan['jumlah_baki'];?></font></b></td>
                                    <td><?echo $list_rekod_jualan['created_date'];?></td>
                                </tr>
                            <?}?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>

        <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /#wrapper -->

    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel2">Maklumat Agensi</h4>
                </div>
                <div class="modal-body" id="demo1">
                    <script type="text/javascript">
                        $('#myModal1').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'agromart_admin_agensi_info.php',
                                data:{id:rowid},
                                success:function(html){
                                    $('#demo1').html(html);
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

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });

        function convertToUppercase(el) {
            if(!el || !el.value) return;
            el.value = el.value.toUpperCase();
        }

        function nyahAktifAgensi(id,status){
            $.ajax({
                url: "../model/agromart_functions.php",
                type: "POST",
                data: {action:"nyahAktifAgensi",id:id,status:status},
                success: function (response) {
                    // you will get response from your php page (what you echo or print)
                    //$.alert('test here:'+response);

                    window.location='agromart_admin_agensi_senarai.php?status=<?echo $status;?>';
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }

    </script>

</body>

</html>