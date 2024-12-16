<?php

include ('../controller/auth.php');

require "../model/perbelanjaan_functions.php";

?>
<?

$id = $_GET['id'];
$tahun=$_GET['tahun'];
$bulan=$_GET['bulan'];
//   $bln=$_GET['mnt'];
// $thn=$_GET['yr'];
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

</head>

<body>
<?

$list = getPerbelanjaanDetails($id) -> fetch_assoc();

?>

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
                        <h1 class="page-header">Keterangan Perbelanjaan</h1>
                    </div>
                </center>
                <div class="panel-heading" align="right">
                    <a href="perbelanjaan_edit.php?id=<? echo $id;?>&bulan=<? echo $bulan?>&tahun=<? echo $tahun?>&flagtahun=<? echo $flagtahun?>&no_staff=<? echo $_SESSION['SESS_NO_STAFF']?>"> <button class="btn btn-info" type="button" >Kemaskini</button></a>
                    <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">

                </div>
            </div>

            <center><?echo '<img src="data:image/jpeg;base64,'.base64_encode( $list['file_upload'] ).'" style="width: 300px; height: 400px;"/>'?>



                </br>

            </center>
            </br>
            <div class="col-lg-2"></div>
            <div class="col-lg-7">


                <div class="panel panel-default">
                    <div class="panel-heading">
                        Keterangan Perbelanjaan Syarikat
                    </div>
                    <!-- <div class="panel-heading"> -->
                    <!-- <font color="blue"><strong><b>Maklumat Peribadi</b></strong></font> -->
                    <!-- </div> -->

                    <input name="redirect" type="hidden" value="../view/perbelanjaan_details?id=<?echo $list['id'];?>"/>
                    <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />

                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example" enctype="multipart/form-data">


                        <thead>
                        <tbody>


                        <tr>
                            <th>Perbelanjaan</th>
                            <td><?php echo $list['description']; ?></td>
                        </tr>



                        <tr>
                            <th>Penerima Bayaran</th>
                            <td><?php echo $list['penerima']; ?></td>
                        </tr>



                        <tr>
                            <th>Kaedah Bayaran</th>
                            <td><?php echo $list['nama']; ?></td>
                        </tr>



                        <tr>
                            <th>Amaun Bayaran (RM)</th>
                            <td><?php echo $list['amaun_bayaran']; ?></td>
                        </tr>



                        <tr>
                            <th>Tarikh Bayaran</th>
                            <td><?php echo $list['tarikh_bayaran_dibuat']; ?></td>
                        </tr>


                        <tr>
                            <th>No.Telefon</th>
                            <td><?php echo $list['notel_penerima']; ?></td>
                        </tr>



                        <tr>
                            <th>Catatan</th>
                            <td><?php echo $list['catatan']; ?></td>
                        </tr>



                        <tr>
                            <th>HR Bertugas</th>
                            <td><?php echo $list['hr_bertugas']; ?></td>
                        </tr>



                        <!--  <tr>
                                                  <th>Rujukan</th>
                                                  <td><?php //echo $list['rujukan']; ?></td>
                                              </tr> -->



                        <!-- <tr>
                                                  <th>Maklumat Rujukan</th>
                                                  <td><?php //echo $list['details_rujukan']; ?></td>
                                              </tr> -->



                        <tr>
                            <th>No. Rujukan</th>
                            <td><?php echo $list['no_rujukan']; ?></td>
                        </tr>
                        </tbody>
                        </thead>

                    </table>

                    <div class="modal-footer">

                        <a href="perbelanjaan_edit.php?id=<? echo $id;?>&bulan=<? echo $bulan?>&tahun=<? echo $tahun?>&flagtahun=<? echo $flagtahun?>&no_staff=<? echo $_SESSION['SESS_NO_STAFF']?>"> <button class="btn btn-info" type="button" >Kemaskini</button></a>
                        <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">

                    </div>


                </div>

            </div>
        </div>



        <? include ('../global/footer.php'); ?>
    </div></div>
</div>


<div class="col-lg-1"></div>

<!--   <br>
  <? //include ('../global/footer.php'); ?>

  
 -->
</body>

</html>
