<?php

include ('../controller/auth.php');

require "../model/cuti_manual_function.php";
require "../model/lookup.php";
// $company_id= $_SESSION['SESS_COM'];
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

    <script>
        $(function() {
            $('#code_department').on('keypress', function(e) {
                if (e.which == 32)
                    return false;
            });
        });
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
                <h1 class="page-header">Senarai Cuti</h1>
            </div>
        </div>
        <?
        $flag=$_GET['flg'];

        if(!isset($flag)){
            $flag='tb_2';

        }
        $cawangan_kod=$_GET['cawangan_kod'];
        $jabatan_kod=$_GET['jabatan_kod'];
        $status=$_GET['status'];
        $tarikh_mula=$_GET['tarikh_mula'];
        $tarikh_akhir=$_GET['tarikh_akhir'];
        if(!isset($status)){
            $status='semasa';
        }
        if(!isset($tarikh_mula)){
            $tarikh_mula='';
        }
        if(!isset($tarikh_akhir)){
            $tarikh_akhir='';
        }
        if(!isset($cawangan_kod)){
            $cawangan_kod = $_SESSION['SESS_CAWANGAN'];

        }
        if(!isset($jabatan_kod)){
            $jabatan_kod = $_SESSION['SESS_DEPARTMENT'];

        }

        include ('../global/menu_cuti_manual.php');
        if($status=='lepas'){?>
            <div class="col-lg-3">
                <input type="text" class="form-control" name="tarikh_mula" id="tarikh_mula" onfocus="(this.type='date')" size="20" placeholder="Tarikh Mula" value="<? echo $tarikh_mula;?>">
            </div>
            <div class="col-lg-3">
                <input type="text" class="form-control" name="tarikh_akhir" id="tarikh_akhir" onfocus="(this.type='date')" size="20" placeholder="Tarikh Akhir" value="<? echo $tarikh_akhir;?>">
            </div>

        <?}?>
    </div>
    <br><br>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Maklumat Rekod Cuti <a href="senarai_cuti.php?cawangan_kod=<? echo $cawangan_kod?>&jabatan_kod=<? echo $jabatan_kod;?>&status=<? echo 'semasa';?>">Semasa</a> |
                    <a href="senarai_cuti.php?cawangan_kod=<? echo $cawangan_kod?>&jabatan_kod=<? echo $jabatan_kod;?>&status=<? echo 'lepas';?>">Lepas</a>
                </div>
                <div class="panel-body">
                    <table id="dataTables-example"  width="100%" class="table table-striped table-bordered table-hover" >
                        <thead>
                        <tr>
                            <th width="">#</th>
                            <th width="">Maklumat Staf</th>
                            <th width="">Tarikh Permohonan</th>
                            <th width="">Tarikh Mula</th>
                            <th width="">Tarikh Akhir</th>
                            <th width="">Jenis Cuti</th>
                            <th width="">Pelulus Cuti</th>
                            <th width="">Tindakan</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?
                        $i=1;
                        $log = getSenaraiCuti($cawangan_kod,$jabatan_kod,$status,$tarikh_mula,$tarikh_akhir);
                        while($list = $log->fetch_assoc()) {

                            ?>

                            <tr class="odd gradeX">

                                <td><?php echo $i; ?></td>
                                <td><?php echo $list['name']; ?><br><?php echo $list['no_staff']; ?><br><?php echo $list['noic']; ?></td>
                                <td><?php echo $list['tarikh_mohon']; ?></td>
                                <td><?php echo $list['tarikh_mula']; ?></td>
                                <td><?php echo $list['tarikh_akhir']; ?></td>
                                <td><?php echo $list['nama_cuti']; ?></td>
                                <td><?php echo $list['pelulus']; ?></td>
                                <td>
                                    <a href="../controller/cuti_manual_exec.php?act=del_cuti&status=semasa&id=<?echo $list['id']; ?>&staff_holiday_id=<?echo $list['staff_holiday_id']; ?>&staff_record_id=<?echo $list['staff_record_id']; ?>&cawangan_kod=<? echo $cawangan_kod?>&jabatan_kod=<? echo $jabatan_kod;?>&jumlah_cuti=<? echo $list['jumlah_cuti'];?>&jenis_cuti=<?echo $list['cuti_dipohon']?>"><button type="button" class="btn btn-danger" onclick="return confirm('Anda pasti untuk padam Maklumat ini?');">Padam</button></a>


                                </td>


                            </tr>

                            <?php $i++; } ?>
                        </tbody>
                    </table>
                </div> <!-- /.panel-body -->
            </div>
        </div>
        <? include ('../global/footer.php'); ?><!-- /.col-lg-12 -->
    </div><!-- /.row -->

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
        $("#tarikh_akhir").change(function(){
            var tarikh_mula=$("#tarikh_mula").val();
            var tarikh_akhir=$("#tarikh_akhir").val();
            refr(tarikh_mula,tarikh_akhir);
        });

    });
    function sendType(cawangan,jabatan)
    {
        if(jabatan==undefined){
            window.location.href="senarai_cuti.php?cawangan_kod="+cawangan;
        }else{
            window.location.href="senarai_cuti.php?cawangan_kod="+cawangan+"&jabatan_kod="+jabatan;
        }

    }
    function refr(tarikh_mula,tarikh_akhir)
    {

        window.location.href="senarai_cuti.php?cawangan_kod=<? echo $cawangan_kod;?>&jabatan_kod=<? echo $jabatan_kod?>&tarikh_mula="+tarikh_mula+"&tarikh_akhir="+tarikh_akhir+"&status=<? echo $status;?>";


    }
</script>

</body>
</html>