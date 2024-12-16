<?php

include ('../controller/auth.php');

require "../model/kehadiran_functions.php";
date_default_timezone_set("Asia/Kuala_Lumpur");
$date_month = date(m);
$date_year = date(Y);
$date_day = date(d);
$current_date = date("Y-m-d");

$yearmonth=$_GET['yearmonth'];
if(!isset($yearmonth)){
    $yearmonth=date('Y-m');
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

    <style>
        .column{
            width: 350px;
            border: 5px solid powderblue;
            padding: 15px;
            margin: 15px;
            text-align: center;
            justify-content: center;
            height: 300px;
        }.option {
             background: #eee;
             display: block;
             padding: 5px 10px 5px;
             color: #000;
             -moz-border-radius: 6px;
             -webkit-border-radius: 6px;
             -khtml-border-radius: 6px;
             border-radius: 6px;
             cursor: pointer;
         }.tableCenter{
              position: inherit;
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
                <h1 class="page-header">Pencapaian Terbaik</h1>
            </div>

            <div class="col-lg-4">
            </div>
            <div class="col-lg-4">
            </div>
            <div class="col-lg-4">
                <select  required class="form-control" name="tarikh" id="tarikh">
                    <? echo getDropDownYearMonth($yearmonth);?>
                </select>
                <br>
            </div>
        </div>


        <div class="row">
            <div class="column" style="background-color: aliceblue;" onclick="location.href='senarai_kakitangan_terbaik_kehadiran.php?yearmonth=<? echo $yearmonth;?>';">
                <div style="background-color: powderblue;padding-top: 5px;"><label>Kehadiran Terbaik</label></div><br>
                <table class="table table-striped table-bordered table-hover tableCenter" id="table_kehadiran">
                    <thead>
                    <tr>
                        <th width="10%">No</th>
                        <th width="60%">Nama</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?
                    $i= 1;

                    $data = getDashboardKehadiranTerbaik($yearmonth);
                    while($row_data = $data->fetch_assoc()) {
                        if($i==1){

                            $icon='<br><i class="fa fa-trophy" style="color: gold;"></i>';
                        }else if($i==2){

                            $icon='<br><i class="fa fa-trophy" style="color: silver;"></i>';
                        }else if($i==3){

                            $icon='<br><i class="fa fa-trophy" style="color: #cd7f32;"></i>';
                        }else{
                            $font="";
                            $icon="";
                        }
                        ?>
                        <tr class="odd gradeX">
                            <td ><?php echo $i; ?><? echo $icon;?></td>
                            <td ><?php echo $row_data['name']; ?><b> (<? echo $row_data['noic']; ?>)</b>

                            </td>
                        </tr>
                        <?php $i++; } ?>


                    </tbody>
                </table>
                <br>
            </div>
            <div class="column" style="background-color: aliceblue;" onclick="location.href='senarai_kakitangan_terbaik_masa_bekerja.php?yearmonth=<? echo $yearmonth;?>';">
                <div style="background-color: deepskyblue;padding-top: 5px;"><label>Jumlah Masa Bekerja Terbaik</label></div><br>
                <table class="table table-striped table-bordered table-hover tableCenter" id="table_masa_bekerja">
                    <thead>
                    <tr>
                        <th width="10%">No</th>
                        <th width="60%">Nama</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?
                    $i= 1;

                    $data = getDashboardMasaKehadiranTerbaikk($yearmonth);
                    while($row_data = $data->fetch_assoc()) {
                        if($i==1){

                            $icon='<br><i class="fa fa-trophy" style="color: gold;"></i>';
                        }else if($i==2){

                            $icon='<br><i class="fa fa-trophy" style="color: silver;"></i>';
                        }else if($i==3){

                            $icon='<br><i class="fa fa-trophy" style="color: #cd7f32;"></i>';
                        }else{
                            $font="";
                            $icon="";
                        }
                        ?>
                        <tr class="odd gradeX">
                            <td ><?php echo $i; ?><? echo $icon;?></td>
                            <td ><?php echo $row_data['name']; ?><b> (<? echo $row_data['noic']; ?>)</b>

                            </td>
                        </tr>
                        <?php $i++; } ?>


                    </tbody>
                </table>
            </div>

            <div class="column" style="background-color: snow;" onclick="location.href='senarai_kakitangan_terbaik_tugasan.php?yearmonth=<? echo $yearmonth;?>';;">
                <div style="background-color: coral;padding-top: 5px;"><label>Tugasan Peribadi Terbaik</label></div>
                <br>
                <table class="table table-striped table-bordered table-hover tableCenter" id="table_tugasan">
                    <thead>
                    <tr>
                        <th width="10%">No</th>
                        <th width="60%">Nama</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?
                    $i= 1;

                    $data = getDashboardTugasanTerbaik($yearmonth);
                    while($row_data = $data->fetch_assoc()) {
                        if($i==1){

                            $icon='<br><i class="fa fa-trophy" style="color: gold;"></i>';
                        }else if($i==2){

                            $icon='<br><i class="fa fa-trophy" style="color: silver;"></i>';
                        }else if($i==3){

                            $icon='<br><i class="fa fa-trophy" style="color: #cd7f32;"></i>';
                        }else{
                            $font="";
                            $icon="";
                        }
                        ?>
                        <tr class="odd gradeX">
                            <td ><?php echo $i; ?><? echo $icon;?></td>
                            <td ><?php echo $row_data['name']; ?><b> (<? echo $row_data['noic']; ?>)</b>

                            </td>
                        </tr>
                        <?php $i++; } ?>


                    </tbody>
                </table>

            </div>

            <div class="column" style="background-color: snow;" onclick="location.href='#';">
                <div style="background-color: coral;padding-top: 5px;"><label>Tugasan Sokongan Terbaik</label></div>
                <br><br><br><br>
                <h1>Coming SOON</h1>
            </div>
        </div>
        </tbody>
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
        $('#table_kehadiran').dataTable({searching: false, paging: false, info: false, ordering: false});
        $('#table_masa_bekerja').dataTable({searching: false, paging: false, info: false, ordering: false});
        $('#table_tugasan').dataTable({searching: false, paging: false, info: false, ordering: false});
        $('#table_sokongan').dataTable({searching: false, paging: false, info: false, ordering: false});
        $("#tarikh").change(function(){

            var selected_tarikh=$(this).val();
            sendType(selected_tarikh);
        });


    });
    function sendType(type)
    {
        window.location.href="dashboard_kakitangan_terbaik.php?yearmonth="+type;

    }


</script>

</body>

</html>