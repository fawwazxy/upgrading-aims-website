<?php

include ('../controller/auth.php');

require "../model/tolak_gaji.php";

?>

<?
$id = $_GET['id'];
$no_staff = $_GET['no_staff'];
$nama = getNama($id) -> fetch_assoc();
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


    </script>

    <style>
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
                <h1 class="page-header">Maklumat Penolakan Gaji</h1>
            </div>

            <?

            $staff = getStaffInformations($no_staff) -> fetch_assoc();

            ?>

            <div class="panel-body">
                <table>
                    <input name="no_staff" type="hidden" class="input-short" value="<? echo $no_staff;?>" />
                    <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />

                    <tr>
                        <td><p><b> Nama </b></p></td> <td><p><b>:&nbsp;</b></p></td> <td><p><?php echo $staff['name'] ?></p></td>
                    </tr>

                    <tr>
                        <td><p><b> Jawatan </b></p></td> <td><p><b>:&nbsp;</b></p></td> <td><p><?php echo $staff['role'] ?></p></td>
                    </tr>

                    <tr>
                        <td><p><b> Bahagian </b></p></td> <td><p><b>:&nbsp;</b></p></td> <td><p><?php echo $staff['bahagian'] ?></p></td>
                    </tr>

                    <tr>
                        <td><p><b> Gaji </b></p></td> <td><p><b>:&nbsp;</b></p></td> <td><p>RM<?php echo $staff['gaji_basic'] ?></p></td>
                    </tr>

                    <br>
                    <tr>
                        <td><font color=blue><strong>Pilih Tahun</td> <td><b>:</b></td>&nbsp;</strong></font>

                        <td>
                            <?php
                            // Sets the top option to be the current year. (IE. the option that is chosen by default).
                            $currently_selected = date('Y');
                            // Year to start available options at
                            $earliest_year = 2014;
                            // Set your latest year you want in the range, in this case we use PHP to just set it to the current year.
                            $latest_year = date('Y');

                            print '<select id="tahun">';
                            // Loops over each int[year] from current year, back to the $earliest_year [1950]
                            foreach ( range( $latest_year, $earliest_year ) as $i ) {
                                // Prints the option with the next year in range.
                                print '<option value="'.$i.'"'.($i === $currently_selected ? ' selected="selected"' : '').'>'.$i.'</option>';
                            }
                            print '</select>';
                            ?></td>
                    </tr>
            </div>
            </table>
        </div>

        <div class="panel-heading" align="right">
            <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Pilih Bulan
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <tbody>

                        <div class="row">
                            <a href = "javascript:submiturl('add_penolakan.php?no_staff=<? echo $no_staff; ?>&bulan=1');">
                                <div class="column">
                                    <img src="../../resources/images/1.png" style="width:100%">
                                </div>
                            </a>

                            <a href = "javascript:submiturl('add_penolakan.php?no_staff=<? echo $no_staff; ?>&bulan=2');">
                                <div class="column">
                                    <img src="../../resources/images/2.png" style="width:100%">
                                </div>
                            </a>

                            <a href = "javascript:submiturl('add_penolakan.php?no_staff=<? echo $no_staff; ?>&bulan=3');">
                                <div class="column">
                                    <img src="../../resources/images/3.png" style="width:100%">
                                </div>
                            </a>

                            <a href = "javascript:submiturl('add_penolakan.php?no_staff=<? echo $no_staff; ?>&bulan=4');">
                                <div class="column">
                                    <img src="../../resources/images/4.png" style="width:100%">
                                </div>
                            </a>

                            <a href = "javascript:submiturl('add_penolakan.php?no_staff=<? echo $no_staff; ?>&bulan=5');">
                                <div class="column">
                                    <img src="../../resources/images/5.png" style="width:100%">
                                </div>
                            </a>

                            <a href = "javascript:submiturl('add_penolakan.php?no_staff=<? echo $no_staff; ?>&bulan=6');">
                                <div class="column">
                                    <img src="../../resources/images/6.png" style="width:100%">
                                </div>
                            </a>

                            <a href = "javascript:submiturl('add_penolakan.php?no_staff=<? echo $no_staff; ?>&bulan=7');">
                                <div class="column">
                                    <img src="../../resources/images/7.png" style="width:100%">
                                </div>
                            </a>

                            <a href = "javascript:submiturl('add_penolakan.php?no_staff=<? echo $no_staff; ?>&bulan=8');">
                                <div class="column">
                                    <img src="../../resources/images/8.png" style="width:100%">
                                </div>
                            </a>

                            <a href = "javascript:submiturl('add_penolakan.php?no_staff=<? echo $no_staff; ?>&bulan=9');">
                                <div class="column">
                                    <img src="../../resources/images/9.png" style="width:100%">
                                </div>
                            </a>

                            <a href = "javascript:submiturl('add_penolakan.php?no_staff=<? echo $no_staff; ?>&bulan=10');">
                                <div class="column">
                                    <img src="../../resources/images/10.png" style="width:100%">
                                </div>
                            </a>

                            <a href = "javascript:submiturl('add_penolakan.php?no_staff=<? echo $no_staff; ?>&bulan=11');">
                                <div class="column">
                                    <img src="../../resources/images/11.png" style="width:100%">
                                </div>
                            </a>

                            <a href = "javascript:submiturl('add_penolakan.php?no_staff=<? echo $no_staff; ?>&bulan=12');">
                                <div class="column">
                                    <img src="../../resources/images/12.png" style="width:100%">
                                </div>
                            </a>

                        </div>

                        </tbody>

                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                    <!--a href="#" class="btn btn-primary" type="button">Button</a-->
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

        function submiturl(url) {
            var tahun=document.getElementById('tahun').value;
            location.href=url+"&tahun="+tahun;
        }
    </script>

</body>

</html>
