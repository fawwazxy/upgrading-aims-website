<?php
include ('../controller/auth.php');
require "../model/staff_function.php";
require "../model/lookup.php";
$staff_id = $_GET['id'];
$staff_no = getStaffNoById($staff_id);
$flagScreen = $_GET['flagScreen'] ?: 'tab_2';
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
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include ('../global/menu_top.php'); ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        <? include 'staff_info_panel.php'?>
        <div class="row">
            <div class="panel-heading"></div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        MAKLUMAT GAJI
                    </div>
                    <div class="panel-body">
                        <table style="width: 100%" id="dataTables-example" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>Nama Bank</th>
                                <th>No Akaun</th>
                                <th>Gaji</th>
                                <th>Catatan</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $data_staff_record = getStaffRecordList($staff_no);
                            while($list = $data_staff_record->fetch_assoc()) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><? echo ($list['nama_bank'])?:'<i class="text-muted" style="font-size: 10pt">-- No Data --</i>'; ?></td>
                                    <td><? echo ($list['no_akaun'])?:'<i class="text-muted" style="font-size: 10pt">-- No Data --</i>'; ?></td>
                                    <td><? echo ($list['gaji'] != '0.00' && !empty($list['gaji']))?'RM '.number_format($list['gaji'],2): '<i class="text-muted" style="font-size: 10pt">-- No Data --</i>'; ?></td>
                                    <td><? echo ($list['catatan'])?nl2br($list['catatan']):'<i class="text-muted" style="font-size: 10pt">-- No Data --</i>'; ?></td>
                                    <td><a href="#edit_record" id="clicktoView" class="btn btn-info" data-toggle="modal" data-id="<? echo $list['record_id'];?>">Kemaskini</a></td>
                                </tr>
                            <? } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
    <div class="modal fade" id="edit_record" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="max-width: 50%;margin-top: 50px;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title" id="exampleModalLongTitle" style="font-size: 120%">KEMASKINI GAJI</span>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="modal-edit">
                    <!--Modal Script-->
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#edit_record').on('show.bs.modal', function (e) {
        var rowid = $(e.relatedTarget).data('id');
        console.log(rowid);
        $.ajax({
            type:'POST',
            url:'staff_position_record_modal.php',
            data:{id:rowid},
            success:function(html){
                $('#modal-edit').html(html);
            }
        });
    });
</script>
</body>
</html>
