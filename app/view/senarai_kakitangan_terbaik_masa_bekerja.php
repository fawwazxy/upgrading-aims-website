<?php

include ('../controller/auth.php');



require "../model/kehadiran_functions.php";

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


    <script language="JavaScript" type="text/javascript">
        function Confirm(){
            return confirm('Adakah anda pasti untuk padam maklumat ini?');
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
                <h1 class="page-header">Senarai Kakitangan Terbaik ( Masa Bekerja )</h1>
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
            <div class="col-lg-12">
                <div class="form-group" align="right">
                    <a href="dashboard_kakitangan_terbaik.php"><button type="button" class="btn btn-success">Kembali</button></a>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Kakitangan
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="10%">No</th>
                                <th width="60%">Nama</th>
                                <th>Jum. Jam Bekerja</th>

                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;

                            $data = getMasaKehadiranTerbaik($yearmonth);
                            while($row_data = $data->fetch_assoc()) {
                                if($i==1){
                                    $font='style="font-size: 30px;"';
                                    $icon='<br><i class="fa fa-trophy" style="color: gold;font-size: 60px;"></i>';
                                }else if($i==2){
                                    $font='style="font-size: 25px;"';
                                    $icon='<br><i class="fa fa-trophy" style="color: silver;font-size: 50px;"></i>';
                                }else if($i==3){
                                    $font='style="font-size: 20px;"';
                                    $icon='<br><i class="fa fa-trophy" style="color: #cd7f32;font-size: 40px;"></i>';
                                }else{
                                    $font="";
                                    $icon="";
                                }
                                ?>
                                <tr class="odd gradeX">
                                    <td <?echo $font;?>><?php echo $i; ?><? echo $icon;?></td>
                                    <td <?echo $font;?>><?php echo $row_data['name']; ?><b> (<? echo $row_data['noic']; ?>)</b>

                                    </td>

                                    <td align="center" <?echo $font;?>>

                                        <?

                                        $jumlah_jam = $row_data['jam'];
                                        if($jumlah_jam=="00" || $jumlah_jam=="" ){
                                            $jumlah_jam="0";

                                        }
                                        $jumlah_minit = $row_data['minit'];
                                        if($jumlah_minit=="00" || $jumlah_minit=="" ){
                                            $jumlah_minit="0";

                                        }
                                        $jumlah_masa = $jumlah_jam." Jam ".$jumlah_minit." Minit";

                                        ?>
                                        <?echo '<b><font color="black">'.$jumlah_masa.'</font></b>';?>
                                    </td>

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
<? include ('../global/footer.php'); ?>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>

    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
        $("#tarikh").change(function(){

            var selected_tarikh=$(this).val();
            sendType(selected_tarikh);
        });


    });
    function sendType(type)
    {
        window.location.href="senarai_kakitangan_terbaik_masa_bekerja.php?yearmonth="+type;

    }

</script>

</body>

</html>
