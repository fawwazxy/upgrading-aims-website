<?php

include ('../controller/auth.php');

require "../model/perbelanjaan_functions.php";

?>
<?php

$id = $_GET['id'];
$bulan=$_GET['bulan'];
$tahun=$_GET['tahun'];
// $flag=$_GET['flg'];

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
    <style>

        @media print {
            #btn_cetak {
                display: none;
                size: landscape;

            }
            #btn_kembali {
                display: none;

            }
        }
    </style>

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
        <br>
        <div class="row">

            <div class="row">
                <center>
                    <div class="col-lg-12">
                        <h2 class="page-header">Ringkasan Rekod Perbelanjaan </h2>
                        <h4>Ringkasan Bagi : <?echo getMonthString($bulan)?> <?echo $tahun?></h4>
                        <h4>Syarikat : <?echo $sys['sys_owner']?></h4>

                    </div>
                </center>
            </div>

            <br>

            <div class="panel-heading" align="right">
                <button class="btn btn-warning" id="btn_cetak" onclick="myFunction()">Cetak</button>
                <input class="btn btn-success" id="btn_kembali" type="button" value="Kembali" onclick="goBack()">
            </div>

            <!-- /Maklumat Peribadi-->
            <div><div class="col-lg-2"></div>
                <div class="row">
                    <div class="col-lg-8">

                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Ringkasan Rekod Perbelanjaan Mengikut Jenis Perbelanjaan
                            </div>

                            <input name="redirect" type="hidden" value="../view/ringkasan_perbelanjaan.php?id=<?echo $list['id'];?>"/>
                            <!-- <input name="id" type="hidden" class="input-short" value="<? //echo $id;?>" /> -->
                            <center>
                                <table width="100%" align="center" class="table table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Perbelanjaan</th>
                                        <th>Jumlah (RM) </th>
                                    </tr>
                                    </thead>

                                    <tbody>

                                    <?

                                    $i= 1;
                                    $data = getOverviewPerbelanjaan($bulan,$tahun);
                                    while($row_data = $data->fetch_assoc()) {

                                        ?>
                                        <tr>
                                            <td><? echo $i ?></td>
                                            <td><?php echo $row_data['description']; ?></td>
                                            <td><?php echo number_format($row_data['total_perbelanjaan'],2); ?></td>
                                        </tr>

                                        <?php

                                        $i++; }

                                    ?>


                                    <?


                                    $i= 1;
                                    $data = getTotalOverviewPerbelanjaan($bulan,$tahun);
                                    while($row_data = $data->fetch_assoc()) {
                                        ?>

                                        <tr>
                                            <td colspan="1"> &nbsp </td>
                                            <td align="right"><b> Jumlah (RM)</b></td>
                                            <td><b><u><? echo number_format($row_data['total'],2);?></u></b></td>
                                        </tr>
                                    <?}?>
                                    </tbody>

                                </table>
                            </center>
                            <br><br>
                            </tbody>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>


    <div class="col-lg-1"></div>
    <script>

        function myFunction() {
            window.print();
        }
    </script>
    <!--   <br>
  <? //include ('../global/footer.php'); ?>

  
 -->
</body>

</html>
