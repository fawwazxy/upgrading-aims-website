<?php
require "../controller/auth.php";
require "../model/v02_aims_others_claim_function.php";
require "../model/lookup.php";

$no_staff = $_SESSION['SESS_NO_STAFF'];
$id = $_SESSION['SESS_ID'];
$department = $_SESSION['SESS_DEPARTMENT'];
$department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];
$role_id = $_SESSION['SESS_ROLE'];

if($department_sub != 'FINACC' && $role_id != 'SUPERADMIN'){
    echo "<script type='text/javascript'>
            alert('Bahagian ini hanya untuk kegunaan Finance & Account Department sahaja');
            window.history.back();
            </script>";
    exit();
}
$department_code = ($_GET['department_code'])?: '';
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
    <style>
        .claim-status{
            padding:3px;
            border-radius: 5px;
            font-weight:bold;
            color: #ffffff;
        }
    </style>
</head>
<body>

<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include "../global/menu_top.php"; ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <? include "../global/menu_left.php"; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    CLAIM <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> COST CENTRE
                </h1>
            </div>
        </div>

         <div class="row">
            <? include "v02_aims_others_claim_migration_message.php"; ?>
        </div>

        <div class="row" style="margin-bottom: 16px">
            <form id="filterForm" method="GET" action="">
                <div class="col-lg-4">
                    <select required class="form-control" name="department_code" id="department_code" style="" onchange="filterForm.submit()">
                        <option value="SB" <? if ($department_code == '') echo 'selected';?>>All company</option>
                        <? echo getdropdown("department","code_department","description",$department_code);?>
                    </select>
                </div>
            </form>
            <div class="col-lg-8 text-right">
                <a href="#addModal"
                   id="clickToAdd" class="btn btn-primary" data-toggle="modal"
                   title="Add New Cost Centre">Add New</a>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body" style="overflow: auto">


                        <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th class="text-center">Cost Centre</th>
                                <th class="text-center">Type Claim</th>
                                <th class="text-center">Company</th>
                                <th class="text-center">Description</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $cost_centre = v02getCostCentreList($department_code);
                            $i = 1;
                            while($cc = $cost_centre->fetch_assoc()){
                                ?>
                                <tr>
                                    <td class="text-center" style="width: 2%"><? echo $i++?></td>
                                    <td class="text-center" style="width: 6%"><? echo $cc['cost_centre'];?></td>
                                    <td style="width: 20%"><? echo $cc['description'];?></td>
                                    <td style="width: 20%"><? echo $cc['company_name'];?></td>
                                    <td style="width: 20%"><? echo $cc['remarks'];?></td>
                                    <td class="text-center" style="width: 7%">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuInOut" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="true">
                                                <i class="fa fa-caret-down"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuInOut" style="margin-left: -64px">
                                                <li><a style="display: block" href="#updateModal" data-toggle="modal" data-id="<? echo $cc['id'] ?>">
                                                        <i class="fa fa-edit opt-icon"></i>Update</a></li>
                                                <li><a style="display: block; color: #9f191f" href="../controller/v02_aims_others_cost_centre_delete_exec.php?id=<? echo $cc['id']; ?>"
                                                       onclick="return confirm('Confirm delete cost centre?')">
                                                        <i class="fa fa-trash opt-icon"></i>Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <? } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <? include "../global/footer.php"; ?>
    </div>
</div>

<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 90%;margin-top: 50px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="exampleModalLongTitle" style="font-size: 120%">Create Cost Centre</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="modal-body">
                <script>
                    $('#addModal').on('show.bs.modal', function () {
                        $.ajax({
                            url:'v02_aims_others_cost_centre_add_modal.php',
                            success:function(html){
                                $('#modal-body').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" style="max-width: 90%;margin-top: 50px;" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title" id="exampleModalLongTitle" style="font-size: 120%">Update Cost Centre</span>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="update-body">
                <!--Modal Script-->
                <script>
                    $('#updateModal').on('show.bs.modal', function (e) {
                        let rowId = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_others_cost_centre_update.php',
                            data:{id:rowId},
                            success:function(html){
                                $('#update-body').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            columnDefs: [
                { targets: -1, orderable: false }
            ]
        });
    });
</script>
</body>
</html>



