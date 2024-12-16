<?php

include ('../controller/auth.php');
require "../model/staff_function.php";

?>

<?
$id = $_GET['id'];
$no_staff = $_GET['no_staff'];
$approve_status = $_GET['approve_status'];
$bulan= $_GET['bulan'];
$currently_selected=$_GET['tahun'];
$tahun= $_GET['tahun'];
$no_slip= $_GET['no_slip'];

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
<?        $list_staff =getStaffInfo($no_staff) -> fetch_assoc();
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
        <div class="row">
            <div class="col-lg-12">


                <h1 class="page-header">Maklumat Gaji</h1>
                <h4><b><font color="blue"><?echo $list_staff['name']?></font></b></h4>
            </div>

            <div class="panel-heading" align="left">
                <font color=black><strong>Pilih Tahun:&nbsp</strong></font>


                <?php
                // Sets the top option to be the current year. (IE. the option that is chosen by default).
                //$currently_selected = date('Y');
                $currently_selected = $tahun;

                // Year to start available options at
                //$earliest_year = 2014;

                $earliest_year = date('Y') - 6;

                // Set your latest year you want in the range, in this case we use PHP to just set it to the current year.
                $latest_year = date('Y');

                //print '<select name="tahun" id="tahun">';
                print '<select id="tahun" onChange="setTahun(this)">';

                // Loops over each int[year] from current year, back to the $earliest_year [1950]
                foreach ( range( $latest_year, $earliest_year ) as $i ) {

                    // Prints the option with the next year in range.
                    print '<option value="'.$i.'"'.($i == $currently_selected ? ' selected="selected"' : '').'>'.$i.'</option>';
                }
                print '</select>';
                ?>



            </div>

            <div class="panel-heading" align="right">
                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
            </div



            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Pilih Bulan
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">

                            <tbody>

                            <? //
                            // $log_monthly = getMonthlyReport($no_staff);
                            // while($list = $log_monthly->fetch_assoc()) {
                            //?>
                            <?
                            //$statusbulan=getStatusBulan($no_staff,$bulan,$tahun) -> fetch_assoc();

                            //$status=getStatusBulan($bulan,$currently_selected,$no_staff) -> fetch_assoc();
                            ?>


                            <div class="row">


                                <a href = "javascript:submiturl('../controller/bulan_salary_exec.php?no_staff=<? echo $no_staff; ?>&bulan=1&tahun=<? echo $currently_selected;?>');">
                                    <div class="column">
                                        <img src="../../resources/images/1.png"  alt="Snow" style="width:100%">
                                        <?
                                        $status=getStatusBulan("1",$currently_selected,$no_staff) -> fetch_assoc();
                                        if(isset($status['tarikh_bayar'])) {
                                        echo ""; ?>


                                        <center><i class="fa fa-check-circle" style="font-size:48px;color:red"></i>

                                            <?
                                            }
                                            else {
                                            echo "" ?> <center><i class="fa fa-close" style="font-size:48px;color:red"></i>


                                                <?
                                                }

                                                ?>


                                    </div>
                                </a>


                                <a href = "javascript:submiturl('../controller/bulan_salary_exec.php?no_staff=<? echo $no_staff; ?>&bulan=2&tahun=<? echo $currently_selected;?>');">
                                    <div class="column">
                                        <img src="../../resources/images/2.png" alt="Snow" style="width:100%">
                                        <?
                                        $status=getStatusBulan("2","$currently_selected","$no_staff") -> fetch_assoc();
                                        if(isset($status['tarikh_bayar'])) {
                                        echo ""; ?>


                                        <center><i class="fa fa-check-circle" style="font-size:48px;color:red"></i>

                                            <?
                                            }
                                            else {
                                            echo "" ?> <center><i class="fa fa-close" style="font-size:48px;color:red"></i>


                                                <?
                                                }

                                                ?>
                                    </div>
                                </a>

                                <a href = "javascript:submiturl('../controller/bulan_salary_exec.php?no_staff=<? echo $no_staff; ?>&bulan=3&tahun=<? echo $currently_selected;?>');">
                                    <div class="column">
                                        <img src="../../resources/images/3.png" alt="Snow" style="width:100%">
                                        <?
                                        $status=getStatusBulan("3","$currently_selected","$no_staff") -> fetch_assoc();
                                        if(isset($status['tarikh_bayar'])) {
                                        echo ""; ?>


                                        <center><i class="fa fa-check-circle" style="font-size:48px;color:red"></i>

                                            <?
                                            }
                                            else {
                                            echo "" ?> <center><i class="fa fa-close" style="font-size:48px;color:red"></i>


                                                <?
                                                }

                                                ?>
                                    </div>
                                </a>

                                <a href = "javascript:submiturl('../controller/bulan_salary_exec.php?no_staff=<? echo $no_staff; ?>&bulan=4&tahun=<? echo $currently_selected;?>');">
                                    <div class="column">
                                        <img src="../../resources/images/4.png" alt="Snow" style="width:100%">
                                        <?
                                        $status=getStatusBulan("4","$currently_selected","$no_staff") -> fetch_assoc();
                                        if(isset($status['tarikh_bayar'])) {
                                        echo ""; ?>


                                        <center><i class="fa fa-check-circle" style="font-size:48px;color:red"></i>

                                            <?
                                            }
                                            else {
                                            echo "" ?> <center><i class="fa fa-close" style="font-size:48px;color:red"></i>


                                                <?
                                                }

                                                ?>
                                    </div>
                                </a>

                                <a href = "javascript:submiturl('../controller/bulan_salary_exec.php?no_staff=<? echo $no_staff; ?>&bulan=5&tahun=<? echo $currently_selected;?>');">
                                    <div class="column">
                                        <img src="../../resources/images/5.png" alt="Snow" style="width:100%">
                                        <?
                                        $status=getStatusBulan("5","$currently_selected","$no_staff") -> fetch_assoc();
                                        if(isset($status['tarikh_bayar'])) {
                                        echo ""; ?>


                                        <center><i class="fa fa-check-circle" style="font-size:48px;color:red"></i>

                                            <?
                                            }
                                            else {
                                            echo "" ?> <center><i class="fa fa-close" style="font-size:48px;color:red"></i>


                                                <?
                                                }

                                                ?>
                                    </div>
                                </a>



                                <a href = "javascript:submiturl('../controller/bulan_salary_exec.php?no_staff=<? echo $no_staff; ?>&bulan=6&tahun=<? echo $currently_selected;?>');">
                                    <div class="column">
                                        <img src="../../resources/images/6.png" alt="Snow" style="width:100%">
                                        <?
                                        $status=getStatusBulan("6","$currently_selected","$no_staff") -> fetch_assoc();
                                        if(isset($status['gaji_bulan'])) {
                                        echo ""; ?>


                                        <center><i class="fa fa-check-circle" style="font-size:48px;color:red"></i>

                                            <?
                                            }
                                            else {
                                            echo "" ?> <center><i class="fa fa-close" style="font-size:48px;color:red"></i>


                                                <?
                                                }

                                                ?>
                                    </div>
                                </a>


                                <a href = "javascript:submiturl('../controller/bulan_salary_exec.php?no_staff=<? echo $no_staff; ?>&bulan=7&tahun=<? echo $currently_selected;?>');">
                                    <div class="column">
                                        <img src="../../resources/images/7.png" alt="Snow" style="width:100%">
                                        <?
                                        $status=getStatusBulan("7","$currently_selected","$no_staff") -> fetch_assoc();
                                        if(isset($status['gaji_bulan'])) {
                                        echo ""; ?>


                                        <center><i class="fa fa-check-circle" style="font-size:48px;color:red"></i>

                                            <?
                                            }
                                            else {
                                            echo "" ?> <center><i class="fa fa-close" style="font-size:48px;color:red"></i>


                                                <?
                                                }

                                                ?>
                                    </div>
                                </a>

                                <a href = "javascript:submiturl('../controller/bulan_salary_exec.php?no_staff=<? echo $no_staff; ?>&bulan=8&tahun=<? echo $currently_selected;?>');">
                                    <div class="column">
                                        <img src="../../resources/images/8.png" alt="Snow" style="width:100%">

                                        <?
                                        $status=getStatusBulan("8","$currently_selected","$no_staff") -> fetch_assoc();
                                        if(isset($status['gaji_bulan'])) {
                                        echo ""; ?>


                                        <center><i class="fa fa-check-circle" style="font-size:48px;color:red"></i>

                                            <?
                                            }
                                            else {
                                            echo "" ?> <center><i class="fa fa-close" style="font-size:48px;color:red"></i>


                                                <?
                                                }

                                                ?>
                                    </div>
                                </a>

                                <a href = "javascript:submiturl('../controller/bulan_salary_exec.php?no_staff=<? echo $no_staff; ?>&bulan=9&tahun=<? echo $currently_selected;?>');">
                                    <div class="column">
                                        <img src="../../resources/images/9.png" alt="Snow" style="width:100%">
                                        <?
                                        $status=getStatusBulan("9","$currently_selected","$no_staff") -> fetch_assoc();
                                        if(isset($status['tarikh_bayar'])) {
                                        echo ""; ?>


                                        <center><i class="fa fa-check-circle" style="font-size:48px;color:red"></i>

                                            <?
                                            }
                                            else {
                                            echo "" ?> <center><i class="fa fa-close" style="font-size:48px;color:red"></i>


                                                <?
                                                }

                                                ?>
                                    </div>
                                </a>

                                <a href = "javascript:submiturl('../controller/bulan_salary_exec.php?no_staff=<? echo $no_staff; ?>&bulan=10&tahun=<? echo $currently_selected;?>');">
                                    <div class="column">
                                        <img src="../../resources/images/10.png" alt="Snow" style="width:100%">

                                        <?
                                        $status=getStatusBulan("10","$currently_selected","$no_staff") -> fetch_assoc();
                                        if(isset($status['tarikh_bayar'])) {
                                        echo ""; ?>


                                        <center><i class="fa fa-check-circle" style="font-size:48px;color:red"></i>

                                            <?
                                            }
                                            else {
                                            echo "" ?> <center><i class="fa fa-close" style="font-size:48px;color:red"></i>


                                                <?
                                                }

                                                ?>
                                    </div>
                                </a>

                                <a href = "javascript:submiturl('../controller/bulan_salary_exec.php?no_staff=<? echo $no_staff; ?>&bulan=11&tahun=<? echo $currently_selected;?>');">
                                    <div class="column">
                                        <img src="../../resources/images/11.png" alt="Snow" style="width:100%">
                                        <?
                                        $status=getStatusBulan("11","$currently_selected","$no_staff") -> fetch_assoc();
                                        if(isset($status['tarikh_bayar'])) {
                                        echo ""; ?>

                                        <center>  <i class="fa fa-check-circle" style="font-size:48px;color:red"></i>

                                            <?
                                            }
                                            else {
                                            echo "" ?> <center><i class="fa fa-close" style="font-size:48px;color:red"></i>


                                                <?
                                                }

                                                ?>
                                    </div>
                                </a>

                                <a href = "javascript:submiturl('../controller/bulan_salary_exec.php?no_staff=<? echo $no_staff; ?>&bulan=12&tahun=<? echo $currently_selected;?>');">
                                    <div class="column">
                                        <img src="../../resources/images/12.png" alt="Snow" style="width:100%">
                                        <?
                                        $status=getStatusBulan("12","$currently_selected","$no_staff") -> fetch_assoc();
                                        if(isset($status['tarikh_bayar'])) {
                                        echo ""; ?>


                                        <center> <i class="fa fa-check-circle" style="font-size:48px;color:red"></i>

                                            <?
                                            }
                                            else {
                                            echo "" ?> <center><i class="fa fa-close" style="font-size:48px;color:red"></i>


                                                <?
                                                }

                                                ?>
                                    </div>
                                </a>

                                <?//
                                // }
                                // ?>

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

        </div>


        <? include ('../global/footer.php'); ?>
    </div></div></body></html>
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

    function setTahun(obj){
        location.href="bulan_salary.php?id=<? echo $id;?>&no_staff=<? echo $no_staff;?>&tahun="+obj.value;
    }



</script>
 
   