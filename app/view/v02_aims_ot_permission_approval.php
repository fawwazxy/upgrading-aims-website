<?php
include "../controller/auth.php";
require "../model/v02_aims_ot_function.php";

$id=$_GET['id'];
$approval = $_GET['approval'] ?: 'NULL';
$month=$_GET['month'] ?: 0;
$year= $_GET['year'] ?: date('Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <? require "../global/header.php"; ?>

    <style>
        .ot-status{
            padding: 4px 8px;
            border-radius: 5px;
            font-weight: bold;
            color: #000000;
            background-color: #e7e7e7;
            border: 1px dotted black;
            white-space: nowrap;
        }

        /* Style the tab */
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #f1f1f1;
        }

        /* Style the buttons inside the tab */
        .tab a {
            background-color: inherit;
            float: left;
            border: none;
            outline: none;
            cursor: pointer;
            padding: 14px 16px;
            transition: 0.3s;
            font-size: 16px;
            text-decoration: none;
            color: #000000;
            border-radius: 5%;
        }

        /* Change background color of buttons on hover */
        .tab a:hover {
            background-color: #ddd;
            text-decoration: none;
        }

        /* Create an active/current tablink class */
        .tab a.active {
            background-color: #FFA500;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;" >
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
                    OVERTIME <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> PERMISSION <i class="fa fa-caret-right"></i> APPROVAL
                    <a href="aims_otpermission_approve.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_ot_migration_message.php"; ?>
        </div>

        <div class="row" style="margin-bottom: 8px">
            <form method="get" action="">
                <input type="hidden" name="approval" value="<? echo $approval?>">
                <div class="col-lg-2">
                    <select required class="form-control" name="month" id="month">
                        <? echo v02getDropDownMonth($month);?>
                    </select>
                </div>
                <div class="col-lg-2">
                    <select required class="form-control" name="year" id="year">
                        <? echo v02getDropDownYear($year);?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <button type="submit" class="btn btn-primary">Filter</button>
                    <a href="v02_aims_ot_permission_approval.php" class="btn btn-default" style="background-color: #b0b0b0">Reset</a>
                </div>
            </form>
        </div>
        <div class="tab">
            <a href="v02_aims_ot_permission_approval.php?approval=NULL&month=<? echo $month ?>&year=<? echo $year?>" class="tabLinks <? if($approval=="NULL") echo 'active'?>">
                NEW </a>
            <a href="v02_aims_ot_permission_approval.php?approval=YES&month=<? echo $month ?>&year=<? echo $year?>" class="tabLinks <? if($approval=="YES") echo 'active'?>">
                APPROVED </a>
            <a href="v02_aims_ot_permission_approval.php?approval=NO&month=<? echo $month ?>&year=<? echo $year?>" class="tabLinks <? if($approval=="NO") echo 'active'?>">
                DISAPPROVED </a>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form name="frmactive" method="post" action="../controller/v02_aims_checkbox_approval.php">
                            <div class="row" style="margin-left: 4px;margin-bottom: 16px">
                                <input type="checkbox" id="select_all"/>&nbsp;
                                <label for="select_all" style="font-size: medium;margin-right: 8px"> Select All</label>

                                <input type="submit" name="approval_status" class="btn btn-success" id="activate" value="APPROVE" <? if ($approval=='YES') echo 'disabled' ?>/>
                                <input type="submit" name="approval_status" class="btn btn-danger" id="activate" value="DISAPPROVE" <? if ($approval=='NO') echo 'disabled' ?>/>
                            </div>

                            <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th style="width: 8%" class="text-center">
                                        <label for="select_all">No. </label>
                                    </th>
                                    <th style="width: 20%">From</th>
                                    <th style="width: 10%" class="text-center">Date</th>
                                    <th style="width: 25%">Description</th>
                                    <th style="width: 12%" class="text-center">Status</th>
                                    <th style="width: 15%">Remark</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <? $ot = v02getOtPermissionApproval($_SESSION['SESS_ID'], $approval, $month, $year);
                                $i=1;
                                while($otp = $ot->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td class="text-center">
                                            <input name="checkbox[]" type="checkbox" class="checkbox" id="checkbox[]" value="<?php echo $otp['id']; ?>" />&nbsp;
                                            <label for="checkbox[]"><?php echo $i++.'.'; ?></label>
                                        </td>
                                        <td>
                                            <?php
                                            echo '<p><b>'.$otp['applicant_name'].'</b><br>'.$otp['applicant_ic'].'<br>'.$otp['applicant_no'].'<br>'.$otp['applicant_department'].'</p>';
                                            echo '<span class="ot-status">' . $otp['created_at'] . '</span>';
                                            ?>
                                        </td>
                                        <td class="text-center"><? echo date("Y-m-d", strtotime($otp['created_at'])); ?></td>
                                        <td><? echo nl2br($otp['description']); ?></td>
                                        <td class="text-center">
                                            <?
                                            if (empty($otp['approval_at'])){
                                                $text_color = "text-muted";
                                                $text_status = "PENDING";
                                            }else{
                                                if ($otp['approval_status'] == 0){
                                                    $text_color = "text-danger";
                                                    $text_status = "DISAPPROVED";
                                                }else{
                                                    $text_color = "text-success";
                                                    $text_status = "APPROVED";
                                                }
                                            }
                                            ?>
                                            <span class="g-bg-color--white <? echo $text_color; ?>" style="padding: 5px;border-radius: 5px;font-weight: bold"><? echo $text_status ?></span><br>
                                            <? echo $otp['approval_at']; ?>
                                        </td>
                                        <td class="text-center">
                                            <? echo (empty($otp['remark'])) ?
                                                "<a href='#remarkModal' class='btn btn-info btn-small' data-toggle='modal' data-id=".$otp['id'].">ADD REMARK</a>"
                                                : $otp['remark'];
                                            ?>
                                        </td>
                                        <td>
                                            <a href="#actionModal" class="btn btn-success" data-toggle="modal" data-id="<? echo $otp['id'] ?>">ACTION</a>
                                        </td>
                                    </tr>
                                <? } ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <? include "../global/footer.php"; ?>
    </div>
</div>

<div class="modal fade" id="remarkModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">ADD REMARK</h4>
            </div>
            <div class="modal-body" id="demo1">
                <script type="text/javascript">
                    $('#remarkModal').on('show.bs.modal', function (e) {
                        let rowId = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_ot_permission_remark.php',
                            data:{id:rowId},
                            success:function(html){
                                $('#demo1').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="actionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Overtime Permission</h4>
            </div>
            <div class="modal-body" id="demo2">
                <script type="text/javascript">
                    $('#actionModal').on('show.bs.modal', function (e) {
                        let rowId = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_ot_permission_action.php',
                            data:{id:rowId},
                            success:function(html){
                                $('#demo2').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        // all checkbox checked if select all is checked
        $('#select_all').on('click',function(){
            $('input[class="checkbox"]').prop('checked', this.checked);
        });

        // select all checked if all checkbox checked
        $('.checkbox').on('click',function(){
            $('#select_all').prop('checked',$('.checkbox:checked').length === $('.checkbox').length);
        });

        $('#dataTables-example').DataTable({
            "responsive": true,
            "order": [[ 2, "desc" ]],
            "columnDefs": [
                {"orderable": false, "targets": [0, -1] }, // 0 = 1st column from left; -1 = 1st column from right
            ]
        });
    });
</script>
</body>
</html>