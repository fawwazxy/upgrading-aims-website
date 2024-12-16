<?php

include ('../controller/auth.php');

require "../model/kehadiran_functions.php";
require "../model/lookup.php";

$status = $_GET['status'];
if (!isset($status) && $status == '') {
    $status = '1';
}
$cawangan_kod=$_GET['cawangan_kod'];
$jabatan_kod=$_GET['jabatan_kod'];

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
        <!--<?include '../global/menu_lkp_pengusaha.php'?>-->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Staff Outstation</h1>

                <div class="col-lg-4">

                    <select  required class="form-control" name="cawangan_kod" id="cawangan_kod">
                        <option value="0">-- Pilih Cawangan--</option>
                        <? echo getDropDown("lkp_cawangan","cawangan_kod","nama",$cawangan_kod);?>
                    </select>
                </div>
                <?
                if($_SESSION['SESS_CAWANGAN']=='HQ' ){?>
                    <div class="col-lg-4">

                        <select  required class="form-control" name="jabatan_kod" id="jabatan_kod">
                            <option value="0">-- Pilih Jabatan--</option>
                            <? echo getDropDown("department","code_department","description",$jabatan_kod);?>
                        </select><br>
                    </div>
                <?}?>

            </div>
            <a href="staff_outstation_senarai.php?status=1&cawangan_kod=<? echo $cawangan_kod;?>&jabatan_kod=<? echo $jabatan_kod;?>">Aktif</a> &nbsp;|&nbsp;
            <a href="staff_outstation_senarai.php?status=0&cawangan_kod=<? echo $cawangan_kod;?>&jabatan_kod=<? echo $jabatan_kod;?>">Tidak Aktif</a>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading" align="left">
                            <label class="control-label" for="date">Senarai Staff Outstation <?if($status=='1'){echo 'Aktif';}else{echo 'Tidak Aktif';}?></label>

                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th width="5%">Bil</th>
                                    <th width="30%">Staff</th>
                                    <th width="40%" colspan="3">Tempat</th>
                                    <th width="15%" colspan="2">Tempoh</th>
                                    <th width="10%">Tindakan</th>
                                </tr>
                                <tr>
                                    <form method="post" action="../controller/outstation_exec.php" enctype="multipart/form-data">
                                        <input type="hidden" name="action" value="tambahOutstation" />
                                        <td></td>
                                        <td>
                                            <label>No. Kad Pengenalan<font color="red">&nbsp;**</font></label>
                                            <input class="form-control" placeholder=" " name="nokp_staff" id="nokp_staff" required  style="text-transform:uppercase" onkeyup="convertToUppercase(this)">
                                        </td>
                                        <td>
                                            <div class="form-group" align="left">
                                                <label>Lokasi<font color="red">&nbsp;**</font></label>
                                                <input class="form-control" placeholder=" " name="lokasi" id="lokasi" required  style="text-transform:uppercase" onkeyup="convertToUppercase(this)">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group" align="left">
                                                <label>Latitud<font color="red">&nbsp;**</font></label>
                                                <input class="form-control" placeholder=" " name="latitude" id="latitude" required  style="text-transform:uppercase" onkeyup="convertToUppercase(this)">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group" align="left">
                                                <label>Longitud<font color="red">&nbsp;**</font></label>
                                                <input class="form-control" placeholder=" " name="longitude" id="longitude" required  style="text-transform:uppercase" onkeyup="convertToUppercase(this)">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group" align="left">
                                                <label>Mula<font color="red">&nbsp;**</font></label>
                                                <input class="form-control" placeholder=" " type="date" name="tarikh_mula" id="tarikh_mula" required value="">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group" align="left">
                                                <label>Akhir<font color="red">&nbsp;**</font></label>
                                                <input class="form-control" placeholder=" " type="date" name="tarikh_tamat" id="tarikh_tamat" required value="">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group" align="left">
                                                <button type="submit" class="btn btn-primary">Tambah</button>
                                            </div>
                                        </td>
                                    </form>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <?
                                    $data = getStaffOutstationList($status,$cawangan_kod,$jabatan_kod);
                                    $c=1;
                                    while($list = $data->fetch_assoc()) {
                                    $status_text = "";
                                    if ($list['status'] == '1') {
                                        $status_text = "Nyah Aktif";
                                        $color = "danger";
                                    }
                                    else {
                                        $status_text = "Aktif";
                                        $color = "success";
                                    }
                                    ?>

                                <tr>
                                    <td><?echo $c++;?></td>
                                    <td>
                                        <?echo $list['nokp_staff']?>
                                    </td>
                                    <td>
                                        <?echo $list['lokasi']?>
                                    </td>
                                    <td>
                                        <?echo $list['latitude']?>
                                    </td>
                                    <td>
                                        <?echo $list['longitude']?>
                                    </td>
                                    <td>
                                        <?php echo date("d-m-Y",strtotime($list['tarikh_mula']))?>
                                    </td>
                                    <td>
                                        <?php echo date("d-m-Y",strtotime($list['tarikh_tamat']))?>
                                    </td>
                                    <td>
                                        <a href="#myModal1" class="btn btn-info" data-toggle="modal" data-id="<?echo $list['id']?>">Kemaskini</a>
                                        <a onclick="nyahaktifOutstation(<?echo $list['id'] ;?>,<?echo $list['status'] ;?>)" ><button type="button" class="btn btn-<?echo $color ?>"><?echo $status_text?></button></a>
                                        <input type="hidden" name="id" id="id" value="<?echo $list['id']?>" />
                                    </td>
                                </tr>
                                <?}?>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
                <!-- /.container-fluid -->
            </div>

            <!-- /#page-wrapper -->

        </div>
        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /#wrapper -->

    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Kemaskini Maklumat Outstation</h4>
                </div>
                <div class="modal-body" id="demo1">
                    <script type="text/javascript">
                        $('#myModal1').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'staff_outstation_kemaskini.php',
                                data:{id:rowid},
                                success:function(html){
                                    $('#demo1').html(html);
                                }
                            });
                        });
                    </script>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $("#cawangan_kod,#jabatan_kod").change(function(){
                var selected_cawangan=$("#cawangan_kod").val();
                var selected_jabatan=$("#jabatan_kod").val();
                sendType(selected_cawangan,selected_jabatan);
            });

        });
        function sendType(cawangan,jabatan)
        {

            window.location.href="staff_outstation_senarai.php?status=<? echo $status;?>&cawangan_kod="+cawangan+"&jabatan_kod="+jabatan;

        }
        function nyahaktifOutstation(id,status){
            $.ajax({
                url: "../model/kehadiran_functions.php",
                type: "POST",
                data: {action:"nyahaktifOutstation",id:id,status:status},
                success: function (response) {
                    // you will get response from your php page (what you echo or print)                 
                    //$.alert('test here:'+response);
                    //$( "#dataTables-example" ).load( "penternak_senarai.php #dataTables-example" );

                    window.location='staff_outstation_senarai.php?status=<?echo $status?>';
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }

        function convertToUppercase(el) {
            if(!el || !el.value) return;
            el.value = el.value.toUpperCase();
        }

    </script>

</body>

</html>