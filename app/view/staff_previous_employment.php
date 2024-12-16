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
            <div class="panel-heading" style="float: right">
                <button class="btn btn-primary" data-target="#myModal" data-toggle="modal" type="button">Tambah Baru</button>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        MAKLUMAT PEKERJAAN TERDAHULU
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example"
                               style="width: 100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Tempat Bekerja</th>
                                <th>Tarikh Mula</th>
                                <th>Tarikh Akhir</th>
                                <th>Gaji</th>
                                <th>Jawatan</th>
                                <th>Peranan</th>
                                <th style="width: 13%;">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i= 1;
                            $log_experience = getExperienceList($staff_no);
                            while($row = $log_experience->fetch_assoc()) {
                                ?>
                                <tr class="odd gradeX">
                                    <td><? echo $i++; ?></td>
                                    <td><? echo $row['tempat_berkerja']; ?></td>
                                    <td><? echo ($row['tarikh_mula'] != '0000-00-00')?$row['tarikh_mula']:'<i class="text-muted" style="font-size: 10pt">-- No Data --</i>';?></td>
                                    <td><? echo ($row['tarikh_akhir'] != '0000-00-00')?$row['tarikh_akhir']:'<i class="text-muted" style="font-size: 10pt">-- No Data --</i>';?></td>
                                    <td><? echo ($row['gaji'] != '0.00')?$row['gaji']:'<i class="text-muted" style="font-size: 10pt">-- No Data --</i>'; ?></td>
                                    <td><? echo ($row['jawatan'])?:'<i class="text-muted" style="font-size: 10pt">-- No Data --</i>'; ?></td>
                                    <td><? echo ($row['peranan'])?:'<i class="text-muted" style="font-size: 10pt">-- No Data --</i>'; ?></td>
                                    <td>
                                        <a class="btn btn-info" data-id="<? echo $row['id'];?>" data-toggle="modal" href="#edit_employ"
                                           id="clicktoView">Kemaskini</a>
                                        <a class="btn btn-danger"
                                           href="../controller/staff_previous_employment_delete_exec.php?id=<? echo $row['id']; ?>" onclick="return confirm('Sahkan padam tempat bekerja : <? echo $row['tempat_berkerja']?>')">Padam</a>
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
    <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">TAMBAH PEKERJAAN</h4>
                </div>
                <div class="modal-body">
                    <form action="../controller/staff_previous_employment_add_exec.php" enctype="multipart/form-data"
                          method="post">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tempat_bekerja">Tempat Bekerja: <span style="color: red; ">*</span></label>
                                            <input class="form-control" id="tempat_bekerja" name="tempat_bekerja"
                                                   required type="text">
                                            <input class="form-control" id="staff_no" name="staff_no" type="hidden"
                                                   value="<? echo $staff_no; ?>">
                                            <input class="form-control" id="staff_id" name="staff_id" type="hidden"
                                                   value="<? echo $staff_id; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="jawatan">Jawatan:</label>
                                            <input class="form-control" id="jawatan" name="jawatan" type="text">
                                        </div>
                                        <div class="form-group">
                                            <label for="peranan">Peranan:</label>
                                            <input class="form-control" id="peranan" name="peranan" type="text">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tarikh_mula">Tarikh Mula: </label>
                                            <input class="form-control" id="tarikh_mula" name="tarikh_mula" type="date">
                                        </div>
                                        <div class="form-group">
                                            <label for="gaji">Gaji: </label>
                                            <input class="form-control" id="gaji" min="0" name="gaji" type="number">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="tarikh_akhir">Tarikh Akhir: </label>
                                            <input class="form-control" id="tarikh_akhir" name="tarikh_akhir"
                                                   type="date">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer text-right">
                                    <input class="btn btn-primary" type="submit" value="Tambah Pekerjaan">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_employ" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="max-width: 50%;margin-top: 50px;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title" id="exampleModalLongTitle" style="font-size: 120%">KEMASKINI PEKERJAAN</span>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body" id="modal-edit">
                    <!--Modal Script-->
                </div>
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
        $('#edit_employ').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            console.log(rowid);
            $.ajax({
                type:'POST',
                url:'staff_previous_employment_update_modal.php',
                data:{id:rowid},
                success:function(html){
                    $('#modal-edit').html(html);
                }
            });
        });
    </script>
</body>
</html>
