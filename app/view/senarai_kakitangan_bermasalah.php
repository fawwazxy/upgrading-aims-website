<?php

include ('../controller/auth.php');

require "../model/kehadiran_functions.php";
require "../model/lookup.php";
$cawangan=$_GET['cawangan_kod'];
$jabatan=$_GET['jabatan'];

if(!isset($cawangan)){
    $cawangan = $_SESSION['SESS_CAWANGAN'];

}
if(!isset($jabatan)){
    $jabatan = $_SESSION['SESS_DEPARTMENT'];

}
if($_SESSION['SESS_ROLE']=="ADMIN" || $_SESSION['SESS_ROLE']=="SUPERADMIN"){

    $disable="";
}else{

    $disable="disabled";
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
                <h1 class="page-header">Senarai Kakitangan Lewat</h1>
            </div>
        </div>
        <div class="col-lg-4">

        </div>
        <div class="col-lg-4">
            <select  required class="form-control" name="cawangan_kod" id="cawangan_kod" <? echo $disable;?>>
                <option value="">-- Pilih Cawangan--</option>
                <? echo getDropDown("lkp_cawangan","cawangan_kod","nama",$cawangan);?>
            </select>
        </div>
        <div class="col-lg-4">
            <select  required class="form-control" name="jabatan" id="jabatan" <? echo $disable;?>>
                <option value="">-- Pilih Jabatan--</option>
                <? echo getDropDownJabatan($jabatan);?>
            </select>
            <br>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Kakitangan Lewat
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Maklumat Kakitangan</th>
                                <th>Jawatan</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getStaffLewat($cawangan,$jabatan);
                            while($row_data = $data->fetch_assoc()) {
                                $bil_lewat= $row_data['lewat'];

                                if($bil_lewat>=3 && $bil_lewat<6 ){
                                    $amaran="Pertama";

                                }else if($bil_lewat>=6 && $bil_lewat<9){
                                    $amaran="Kedua";

                                }else if($bil_lewat==9){
                                    $amaran="Ketiga";

                                }else if($bil_lewat>9){
                                    $amaran="Terakhir";
                                }else{
                                    $amaran="";
                                }

                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php
                                        echo "Nama    : ".$row_data['name']."<br>";
                                        echo "No. Kad Pengenalan  : ".$row_data['noic']."<br>";
                                        echo "No. Telefon : ".$row_data['phone'];
                                        ?>

                                    </td>
                                    <td><?php echo $row_data['role']; ?></td>
                                    <td>
                                        <?if($amaran!=""){?>
                                            <strong>Bil. Lewat<br><font size="4"><? echo $bil_lewat;?></font></strong><br><br>
                                            <a href="../template/surat_amaran_kehadiran_lewat.php?nokp_staff=<? echo $row_data['noic'];?>&no_staff=<? echo $row_data['no_staff'];?>&amaran=<? echo $amaran;?>&lewat=<? echo $bil_lewat; ?>" target="_blank"><button class="btn btn-warning" type="button">Surat Amaran <? echo $amaran;?></button></a>
                                            <a button class="btn btn-success" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $row_data['phone']; ?>&text=<? echo "*".$sys['sys_name']."::Surat Amaran*"?>%0aSila klik link <?echo $sys['sys_domain']."/app/template/surat_amaran_kehadiran_lewat.php?nokp_staff%3d".$row_data['noic']."%26no_staff%3d".$row_data['no_staff']."%26amaran%3d".$amaran."%26lewat%3d".$bil_lewat." bagi melihat surat amaran anda."?>')">WhatsApp Amaran</a>
                                        <?}else{?>
                                            <strong>Bil. Lewat<br><font size="4"><? echo $bil_lewat;?></font></strong>
                                        <?}?>
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
        $("#cawangan_kod").change(function(){

            var selected_cawangan=$(this).val();
            sendType(selected_cawangan);
        });
        $("#jabatan").change(function(){
            if($("#cawangan_kod").val()==''){
                alert('SILA PILIH CAWANGAN DAHULU!');
                $("#jabatan").val('');
            }else{
                var selected_jabatan=$(this).val();
                var cawangan = $("#cawangan_kod").val();
                sendType2(selected_jabatan,cawangan);

            }
        });

    });
    function sendType(type)
    {
        window.location.href="senarai_kakitangan_bermasalah.php?cawangan_kod="+type;

    }
    function sendType2(jabatan,cawangan)
    {
        window.location.href="senarai_kakitangan_bermasalah.php?cawangan_kod="+cawangan+"&jabatan="+jabatan;

    }
</script>

</body>

</html>
