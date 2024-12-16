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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Tambah Baru</button>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        MAKLUMAT KEMAHIRAN
                    </div>
                    <div class="panel-body">
                        <table style="width: 100%" id="dataTables-example" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Kemahiran</th>
                                <th>Tahap Kemahiran</th>
                                <th style="width: 13%;">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i= 1;
                            $skill = getSkillList($staff_no);
                            while($list = $skill->fetch_assoc()) {
                                ?>
                                <tr class="odd gradeX">
                                    <td style="width: 5%"><? echo $i++; ?></td>
                                    <td><? echo $list['skill']; ?></td>
                                    <td><? echo $list['level']; ?></td>
                                    <td>
                                        <a href="#edit_skill" id="clicktoView" class="btn btn-info" data-toggle="modal" data-id="<? echo $list['id'];?>">Kemaskini</a>
                                        <a href="../controller/staff_skill_delete_exec.php?id=<? echo $list['id']; ?>" class="btn btn-danger" onclick="return confirm('Sahkan padam kemahiran : <? echo $list['skill']; ?>')">Padam</a>
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
                    <h4 class="modal-title">TAMBAH KEMAHIRAN</h4>
                </div>
                <div class="modal-body">
                    <form method="post" action="../controller/staff_skill_add_exec.php" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group row">
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <label for="skill">Kemahiran: <span style="color: red; ">*</span></label>
                                            <input class="form-control" id="skill" name="skill" required type="text">
                                            <input class="form-control" id="staff_no" name="staff_no" type="hidden"
                                                   value="<? echo $staff_no; ?>">
                                            <input class="form-control" id="staff_id" name="staff_id" type="hidden"
                                                   value="<? echo $staff_id; ?>">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="level">Tahap: <span style="color: red; ">*</span>&nbsp</label><br>
                                            <input class="form-control" id="level" name="level" required type="text">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer text-right">
                                    <input class="btn btn-primary" type="submit" value="Tambah Kemahiran">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit_skill" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" style="max-width: 50%;margin-top: 50px;" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title" id="exampleModalLongTitle" style="font-size: 120%">KEMASKINI KEMAHIRAN</span>
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
        $('#edit_skill').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            console.log(rowid);
            $.ajax({
                type:'POST',
                url:'staff_skill_update_modal.php',
                data:{id:rowid},
                success:function(html){
                    $('#modal-edit').html(html);
                }
            });
        });
    </script>
</body>
</html>
