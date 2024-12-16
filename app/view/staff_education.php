<?php
session_start();
include ('../controller/auth.php');
require "../model/staff_function.php";
require "../model/lookup.php";
$role = $_SESSION['SESS_ROLE'];
$staff_id = ($_GET['id'])?: $_SESSION['SESS_ID'];
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
            <div class="panel-heading">
                <button class="btn btn-primary" data-target="#addNew" data-toggle="modal" style="float: right"
                        type="button">
                    Tambah Baru
                </button>
            </div>
            <div class="col-lg-12" style="margin-top: 10px">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        MAKLUMAT PENDIDIKAN
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Pencapaian</th>
                                <th>Tempat</th>
                                <th>Tahun Mula</th>
                                <th>Tahun Akhir</th>
                                <th>Keputusan</th>
                                <th style="width: 13%;">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i= 1;
                            $list_education = getEducationListByStaffNo($staff_no);
                            while($row_data_education = $list_education->fetch_assoc()) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><? echo $i++; ?></td>
                                    <td><? echo $row_data_education['pencapaian']; ?></td>
                                    <td><? echo ($row_data_education['tempat'])?:'<i class="text-muted" style="font-size: 10pt">-- No Data --</i>'; ?></td>
                                    <td><? echo ($row_data_education['tahun_mula'] != '0000')?$row_data_education['tahun_mula']:'<i class="text-muted" style="font-size: 10pt">-- No Data --</i>'; ?></td>
                                    <td><? echo ($row_data_education['tahun_akhir'] != '0000')?$row_data_education['tahun_akhir']:'<i class="text-muted" style="font-size: 10pt">-- No Data --</i>'; ?></td>
                                    <td><? echo ($row_data_education['keputusan'])?:'<i class="text-muted" style="font-size: 10pt">-- No Data --</i>'; ?></td>
                                    <td>
                                        <a class="btn btn-info" data-id="<? echo $row_data_education['id'];?>" data-toggle="modal" href="#edit_educ"
                                           id="clicktoView">Kemaskini</a>
                                        <a class="btn btn-danger"
                                           href="../controller/staff_education_delete_exec.php?id=<? echo $row_data_education['id']; ?>" onclick="return confirm('Sahkan padam pencapaiaan : <? echo $row_data_education['pencapaian']?>')">Padam</a>
                                    </td>
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
    <!-- The Add Modal -->
    <div class="modal fade" id="addNew">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">TAMBAH PENDIDIKAN</h4>
                </div>
                <div class="modal-body">
                    <form action="../controller/staff_education_add_exec.php" enctype="multipart/form-data"
                          method="post">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="pencapaian">Pencapaian : <span style="color: red">*</span></label>
                                            <input class="form-control" id="pencapaian" name="pencapaian" required
                                                   type="text">
                                            <input class="form-control" id="staff_no" name="staff_no" type="hidden"
                                                   value="<? echo $staff_no; ?>">
                                            <input class="form-control" id="staff_id" name="staff_id" type="hidden"
                                                   value="<? echo $staff_id; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="tempat">Tempat: </label>
                                            <input class="form-control" id="tempat" name="tempat" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tahun_mula">Tahun Mula: </label>
                                            <input class="form-control" id="tahun_mula" min="0" name="tahun_mula"
                                                   type="number">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tahun_akhir">Tahun Akhir: </label>
                                            <input class="form-control" id="tahun_akhir" min="0"
                                                   name="tahun_akhir" type="number">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="keputusan">Keputusan: </label>
                                            <input class="form-control" id="keputusan"
                                                   name="keputusan" type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer text-right">
                                    <input type="submit" class="btn btn-primary" value="Tambah Pendidikan">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_educ" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="max-width: 50%;margin-top: 50px;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title" id="exampleModalLongTitle" style="font-size: 120%">KEMASKINI PENDIDIKAN</span>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="modal-edit"></div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true,
                pageLength: 5,
                lengthMenu: [5,10, 25, 50]
            });
        });
        $('#edit_educ').on('show.bs.modal', function (e) {
            /*id == staff education id*/
            var rowid = $(e.relatedTarget).data('id');
            console.log(rowid);
            $.ajax({
                type:'POST',
                url:'staff_education_update_modal.php',
                data:{id:rowid},
                success:function(html){
                    $('#modal-edit').html(html);
                }
            });
        });
        $(document).on('submit', function () {
            let tahun_mula = $('#tahun_mula').val();
            let tarikh_akhir = $('#tahun_akhir').val();
            if (tarikh_akhir < tahun_mula) {
                alert('Ralat tahun');
                return false;
            }
        });
    </script>
</body>
</html>
