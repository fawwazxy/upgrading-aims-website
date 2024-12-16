<?php

include ('../controller/auth.php');

require "../model/pengusaha_functions.php";
require "../model/lookup.php";

$lkp_id=$_GET['lkp_id'];
$lkp_data=getLookupDetails($lkp_id)->fetch_assoc();
if($lkp_id == ''){
    $lkp_id='';
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
                <h1 class="page-header">Konfigurasi</h1>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <label class="control-label">Pilihan Konfigurasi</label>
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <div class="form-group" align="left">
                    <label>Konfigurasi<font color="red">&nbsp;**</font></label>
                    <select required class="form-control" id="lkp_id" name="lkp_id" value=""
                            onchange="reloadTable(this)">
                        <option value="0">-- Pilih --</option>
                        <?echo getDropDown("lkp_kada_lookup","lkp_name","name",$lkp_id);?>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading" align="left">
                        <label class="control-label" for="date">Senarai <?echo $lkp_data['name'];?></label>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="<?echo $lkp_id?>">
                            <thead>
                            <tr>
                                <? if($lkp_id ==''){
                                    echo 'Tiada Data';
                                }else{


                                $data_lkp = getLKPKada($lkp_id);
                                $a=1;
                                while($list_lkp = $data_lkp->fetch_assoc()) {
                                    ?>
                                    <td><strong><?echo $list_lkp['column_name'];?></strong></td>

                                <?}?>
                                <td><strong>Tindakan</strong></td>
                            </tr>
                            <tr>
                                <form method="post" action="../controller/pengusaha_exec.php" enctype="multipart/form-data">

                                    <?
                                    $data_lkp = getLKPKada($lkp_id);
                                    $b=1;
                                    //$name_column = '';
                                    ?>
                                    <div>
                                        <input type="hidden" name="action" value="addLKP" />
                                        <input type="hidden" name="table" value="<?echo $lkp_id?>" />
                                        <input type="hidden" name="id" id="id" value="0" />

                                    </div>
                                    <?
                                    while($list_lkp = $data_lkp->fetch_assoc()) {


                                        ?>
                                        <td>
                                            <input class="form-control" id="<?echo $list_lkp['column_name']?>" name="col<?echo $b++;?>" type="text" required style="text-transform:uppercase" onkeyup="convertToUppercase(this)"/>

                                        </td>


                                        <?
                                        $name_column[] = $list_lkp['column_name'];
                                        //$name_column = $list_lkp['column_name'].','.$name_column;
                                    }$name_column=implode(',', $name_column);?>
                                    <input type="hidden" name="name_column" id="name_column" value="<?echo $name_column;?>" />
                                    <input type="hidden" name="num" id="num" value="<?echo $b;?>" />
                                    <td>
                                        <div class="form-group" align="left">
                                            <button type="submit" class="btn btn-primary">Tambah</button>
                                        </div>
                                    </td>
                                </form>
                            </tr>
                            </thead>
                            <tbody><tr>
                                <?
                                $data = getLookupList($lkp_id);
                                $c=1;
                                while($list = $data->fetch_assoc()) {
                                ?>

                            <tr>
                                <?
                                $data_lkp = getLKPKada($lkp_id);
                                $d=1;
                                while($list_lkp = $data_lkp->fetch_assoc()) {
                                    ?>
                                    <td><?echo $list[$list_lkp['column_name']];?></td>

                                <?}?>
                                <? $data_id = getLKPKadaId($lkp_id)->fetch_assoc();?>

                                <td>
                                    <a href="#myModal1" class="btn btn-info" data-toggle="modal" data-id="<?echo $list[$data_id['column_name']]?>,<?echo $lkp_id?>,<?echo $data_id['column_name']?>">Kemaskini</a>
                                    <input type="hidden" name="id_lkp" id="id_lkp" value="<?echo $list[$data_id['column_name']]?>" />
                                </td>

                            </tr>
                            <?} }?></tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>

        <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
    </div>
</div>
<!-- /#wrapper -->

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Kemaskini Maklumat <?echo $lkp_data['name'];?></h4>
            </div>
            <div class="modal-body" id="demo1">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'POST',
                            url:'lkp_kada_kemaskini.php',
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
        $('#dataTables-<?echo $lkp_id?>').DataTable({
            responsive: true
        });
    });

    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }

    function reloadTable(obj){
        location.href = "lkp_konfigurasi_kada.php?lkp_id="+obj.value;
    }

</script>

</body>

</html>