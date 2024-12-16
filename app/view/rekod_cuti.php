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
                <h1 class="page-header">Rekod Cuti Manual</h1>
            </div>
        </div>
        <?
        $flag=$_GET['flg'];

        if(!isset($flag)){
            $flag='tb_1';

        }
        $cawangan_kod=$_GET['cawangan_kod'];
        $jabatan_kod=$_GET['jabatan_kod'];

        if(!isset($cawangan_kod)){
            $cawangan_kod = $_SESSION['SESS_CAWANGAN'];

        }
        if(!isset($jabatan_kod)){
            $jabatan_kod = $_SESSION['SESS_DEPARTMENT'];

        }

        include ('../global/menu_cuti_manual.php');
        ?>
    </div>
    <br><br>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Maklumat Rekod Cuti
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
                        $log = getLogStaffByJabatan($cawangan_kod,$jabatan_kod);
                        while($list = $log->fetch_assoc()) {

                            ?>

                            <tr class="odd gradeX">
                                <form id="<?php echo $list['no_staff']; ?>" method="post" action="../controller/cuti_manual_exec.php?act=add_cuti&cawangan_kod=<? echo $cawangan_kod?>&jabatan_kod=<? echo $jabatan_kod;?>">
                                    <input type="hidden" name="no_staff" value="<?php echo $list['no_staff']; ?>">
                                    <input type="hidden" name="created_by" value="<?php echo $_SESSION['SESS_NO_STAFF']; ?>">

                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $list['name']; ?><br><?php echo $list['no_staff']; ?><br><?php echo $list['noic']; ?></td>
                                    <td><input type="date" class="form-control" name="created_date" id="created_date" size="20"> </td>
                                    <td><input type="date" class="form-control" name="tarikh_mula" id="tarikh_mula" size="20"></td>
                                    <td><input type="date" class="form-control" name="tarikh_akhir" id="tarikh_akhir" size="20"></td>

                                    <td>
                                        <div class="form-group" align="left">
                                            <select required class="form-control" name="jenis_cuti" value="" style="width: 270px">
                                                <option value="">--Pilih--</option>
                                                <?
                                                $row_cuti= getJenisCuti();
                                                while ($cuti  = $row_cuti -> fetch_assoc()){ ?>
                                                    <option value="<? echo $cuti['code'];?>"><? echo $cuti['code'];?> - <? echo $cuti['desc'];?></option>
                                                <?}?>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group" align="left">
                                            <select required class="form-control" name="pelulus_cuti" value="" style="width: 270px">
                                                <option value="">--Pilih--</option>
                                                <?
                                                $row_data= getNoStaff($list['leave_approval']);
                                                while ($pilih  = $row_data -> fetch_assoc()){ ?>
                                                    <option value="<? echo $pilih['no_staff'];?>"><? echo $pilih['no_staff'];?> - <? echo $pilih['name'];?></option>
                                                <?}?>
                                            </select>
                                        </div>
                                    </td>
                                    <td><a><button type="submit" class="btn btn-primary" form="<?php echo $list['no_staff']; ?>">Tambah</button></a></td>
                                </form>

                            </tr>

                            <?php $i++; } ?>
                        </tbody>
                    </table>
                </div> <!-- /.panel-body -->
            </div>
        </div><!-- /.col-lg-12 -->
        <? include ('../global/footer.php'); ?>
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

    });
    function sendType(cawangan,jabatan)
    {
        if(jabatan==undefined){
            window.location.href="rekod_cuti.php?cawangan_kod="+cawangan;
        }else{
            window.location.href="rekod_cuti.php?cawangan_kod="+cawangan+"&jabatan_kod="+jabatan;
        }

    }
</script>

</body>
</html>