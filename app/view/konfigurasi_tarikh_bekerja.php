<?php

include ('../controller/auth.php');
require "../model/tarikh_bekerja_functions.php";
require "../model/lookup.php";

$id = $_GET['id'];
$no_staff = $_GET['no_staff'];
$tahun = $_GET['tahun'];
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
                <h1 class="page-header">Penentuan Tarikh Bekerja</h1>
                <div class="col-lg-4">

                    <select  required class="form-control" name="cawangan_kod" id="cawangan_kod" <? echo $disable;?>>
                        <option value="0">-- Pilih Cawangan--</option>
                        <? echo getDropDown("lkp_cawangan","cawangan_kod","nama",$cawangan_kod);?>
                    </select>
                </div>


                <div class="col-lg-4">

                    <select  required class="form-control" name="jabatan_kod" id="jabatan_kod" <? echo $disable;?>>
                        <option value="0">-- Pilih Jabatan--</option>
                        <? echo getDropDown("department","code_department","description",$jabatan_kod);?>
                    </select>
                </div>
                <br><br>

                <? if(checkTahunAvailbilitysemua($cawangan_kod,$jabatan_kod) > 0){?>
                    <!--<div class="panel-heading" align="right">
          <a href="../controller/tarikh_bekerja_exec.php?action=jana_tarikh_semua&cawangan_kod=<? //echo $cawangan_kod;?>&jabatan_kod=<? //echo $jabatan_kod;?>"><button class="btn btn-primary" type="button">Jana Tarikh</button></a>
        </div>-->
                <?}?>
            </div>
        </div>

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
                        <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                        <input name="no_staff" type="hidden" class="input-short" value="<? echo $no_staff;?>" />
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Pekerja</th>
                                <th>Kumpulan Peranan</th>
                                <th>Peranan</th>
                                <th>Bahagian</th>
                                <th>No Telefon</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data_staff = getLogStaffByJabatan($cawangan_kod,$jabatan_kod,$statact);
                            while($row_data_staff = $data_staff->fetch_assoc()) {

                                $peranan = $row_data_staff['role'];

                                $nostaff = $row_data_staff['no_staff'];
                                $btn="btn btn-danger";
                                if(checkTahunAvailbility(date('Y'),$nostaff)>0){
                                    $btn="btn btn-primary";
                                }
                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td>
                                        <b><a href="" onclick="return popitup('staff_details.php?no_staff=<? echo $row_data_staff['no_staff'];?>')"><?php echo $row_data_staff['name']; ?></a><br>
                                            &nbsp;<?php echo $row_data_staff['no_staff']; ?><br>
                                            &nbsp;<?php echo $row_data_staff['noic']; ?></b>
                                    </td>
                                    <td><b><?php echo $row_data_staff['role_group_name']; ?></b></td>
                                    <td><b><?php echo $row_data_staff['role']; ?></b></td>
                                    <td><b><?php echo $row_data_staff['description']; ?></b></td>
                                    <td>
                                        <b><?php echo $row_data_staff['phone']; ?></b><br>
                                        <button class="btn btn-success" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $row_data_staff['phone']; ?>')" >WhatsApp</button><br>
                                    </td>

                                    <td>

                                        <a href="penentuan_tarikh_bekerja_staff.php?id=<? echo $row_data_staff['id'];?>&no_staff=<? echo $row_data_staff['no_staff'];?>" target=""><button class="<? echo $btn;?>" type="button" >Tetapan Offday</button></a>

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
            window.location.href="konfigurasi_tarikh_bekerja.php?cawangan_kod="+cawangan;
        }else{
            window.location.href="konfigurasi_tarikh_bekerja.php?cawangan_kod="+cawangan+"&jabatan_kod="+jabatan;
        }

    }
</script>

</body>

</html>
