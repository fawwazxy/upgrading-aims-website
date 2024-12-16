<?php

include ('../controller/auth.php');
require "../model/tarikh_bekerja_functions.php";
require "../model/lookup.php";

?>
<?
$flag=$_GET['flg'];

if(!isset($flag)){
    $flag='tb_2';

}
$cawangan_kod=$_GET['cawangan_kod'];
$jabatan_kod=$_GET['jabatan_kod'];
$statact = $_GET['statact'];
if(!isset($statact)){
    $statact = 'ACTIVE';

}

if(!isset($cawangan_kod)){
    $cawangan_kod = $_SESSION['SESS_CAWANGAN'];

}
if(!isset($jabatan_kod)){
    $jabatan_kod = $_SESSION['SESS_DEPARTMENT'];

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





<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

        <!-- /.navbar-header -->
        <? include ('../global/menu_top.php'); ?>

        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">

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
                <h1 class="page-header">Konfigurasi Shift Bekerja</h1>


            </div>
        </div>
        <?

        include ('../global/menu_shift.php');
        ?><br><br>


        <!--<div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Maklumat Pekerja</h1>
            </div>

        </div>-->


        <div class="row">

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Pekerja
                    </div>



                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>Bahagian</th>
                                <th width="25%">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data_staff = getBahagian($cawangan_kod,$jabatan_kod);
                            while($row_data_staff = $data_staff->fetch_assoc()) {

                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><b><?php echo $row_data_staff['description']; ?></b></td>
                                    <td>

                                        <a href="penentuan_shift_bekerja_bahagian.php?id=<? echo $row_data_staff['id'];?>" target=""><button class="btn btn-primary" type="button" >Tetapan Shift</button></a>

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

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
        $("#cawangan_kod,#jabatan_kod").change(function(){
            var selected_cawangan=$("#cawangan_kod").val();
            var selected_jabatan=$("#jabatan_kod").val();
            sendType(selected_cawangan,selected_jabatan);
        });

    });
    function sendType(cawangan,jabatan)
    {
        if(jabatan==undefined){
            window.location.href="konfigurasi_shift_mengikut_bahagian.php?cawangan_kod="+cawangan;
        }else{
            window.location.href="konfigurasi_shift_mengikut_bahagian.php?cawangan_kod="+cawangan+"&jabatan_kod="+jabatan;
        }

    }
</script>

</body>

</html>
