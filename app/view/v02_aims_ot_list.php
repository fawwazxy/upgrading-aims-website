<?php
include "../controller/auth.php";
require "../model/v02_aims_ot_function.php";

$staff_id = $_SESSION['SESS_ID'];
$staff_department = $_SESSION['SESS_DEPARTMENT_SUB'];

$non_permission = ["HR-AGMA", "OPERATION-AGMSB", "OPERATION-BUNKER"];
$sort = ($_GET['sort']) ?: 'DESC '; //if null, set DESC.
$month_session = ($_GET['month_session']) ?: '0'; //if null, set 0.

if ($month_session == '0'){
    echo "<script type='text/javascript'>
            alert('Overtime month session not valid!');
            window.history.back();
            </script>";
    exit();
}

$ot_date_list = v02getDateOt($staff_id, $sort, $month_session);
$session_details = v02getMonthSessionDetails($month_session)->fetch_assoc();
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
    <style type="text/css">
        .ot-status{
            padding: 3px 6px;
            border-radius: 5px;
            font-weight:bold;
            margin: 2px 0;
            color: white;
        }
        .date-summary{
            float: right;
            margin-right: 8px;
            padding-left: 8px;
            padding-right: 8px;
        }
        .text-white{
            color: #ffffff;
        }
        .text-dark{
            color: #000000;
        }
        .bg-white{
            background-color: #ffffff;
        }
        .bg-dark{
            background-color: #000000;
        }
        .hr-separator{
            margin: 16px 0;
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
                    OVERTIME <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> CLAIM
                    <i class="fa fa-caret-right"></i> <? echo strtoupper($session_details['month_session']) ?>
                    <a href="aims_ot_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                    <a href="v02_aims_ot_list_month.php" class="btn btn-default btn-sm" style="float: right;background-color: #FFA500; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-arrow-left" style="margin-right: 8px"></i>
                        Back to list
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_ot_migration_message.php"; ?>
        </div>

        <div class="row" style="margin: 0 0 16px;">
            <div class="col-lg-6">
                <table style="width: 100%">
                    <tr>
                        <th style="width: 14%">Name</th>
                        <th style="width: 2%">:</th>
                        <td><?php echo $_SESSION['SESS_NAME']; ?></td>
                    </tr>

                    <tr>
                        <th>IC No</th>
                        <th>:</th>
                        <td><?php echo $_SESSION['SESS_NOKP']; ?></td>
                    </tr>

                    <tr>
                        <th>Staff No</th>
                        <th>:</th>
                        <td><?php echo $_SESSION['SESS_NO_STAFF']; ?></td>
                    </tr>

                    <tr>
                        <th>Company</th>
                        <th>:</th>
                        <td><?php echo $_SESSION['SESS_DEPARTMENT']; ?></td>
                    </tr>

                    <tr>
                        <th>Department</th>
                        <th>:</th>
                        <td><?php echo $staff_department; ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-6">
                <table style="width: 100%">
                    <tr>
                        <th style="width: 20%">Month Session</th>
                        <th style="width: 2%">:</th>
                        <td><? echo $session_details['month_session'] ?></td>
                    </tr>
                    <tr>
                        <th>Total Hours</th>
                        <th>:</th>
                        <td><? echo getTotalHourByRate($month_session, null, false).' hours' ?></td>
                    </tr>
                    <tr>
                        <th>Total Claim</th>
                        <th>:</th>
                        <td><? echo $session_details['total_claim'] ? 'RM '.$session_details['total_claim']
                                : '<i class="text-muted">Waiting for review</i>' ?></td>
                    </tr>
                    <tr>
                        <th colspan="3" class="text-right">
                            <a href="v02_aims_ot_print.php?id=<? echo $month_session ?>" class="btn btn-success" target="_blank">
                                Print Report &nbsp;<i class="fa fa-print"></i></a>
                        </th>
                    </tr>
                </table>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-10">
                                <label for="sort_by" style="font-size: 18px">Overtime Claim List</label>
                            </div>
                            <div class="col-md-2">
                                <form id="filterForm" name="filterForm" action="v02_aims_ot_list.php" method="get">
                                    <select class="form-control" id="sort_by" name="sort" onchange="filterForm.submit()">
                                        <option value="DESC" <? if ($sort == 'DESC') echo 'selected' ?>>Sort by newest first</option>
                                        <option value="ASC" <? if ($sort == 'ASC') echo 'selected' ?>>Sort by oldest first</option>
                                    </select>
                                    <!--<div class="col-md-2">
                                    <select class="form-control" id="month_session" name="month_session" onchange="filterForm.submit()">
                                        <?/* echo v02getMonthSession($staff_id, $month_session) */?>
                                    </select>
                                </div>-->
                                    <input type="hidden" name="month_session" value="<? echo $month_session ?>">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body" style="overflow: auto">
                        <table class="table table-striped table-bordered table-hover" id="dataTables-example" style="width: 100%">
                            <thead>
                            <tr>
                                <th style="width: 10%" class="no-sort">No</th>
                                <th style="width: 10%">Time</th>
                                <th style="width: 30%">Work Description</th>
                                <th style="width: 10%">HOD </th>
                                <th style="width: 10%">HR</th>
                                <th style="width: 10%">EC / CEO</th>
                                <th style="width: 10%">Payment Status</th>
                                <th style="width: 10%" class="no-sort">Action</th>
                            </tr>
                            </thead>
                            <tbody class="text-center">
                            <?
                            $count_date = mysqli_num_rows($ot_date_list);
                            $count_ot = 0;
                            $count_unclaimed = 0;
                            $i=1;
                            $date_iteration = 1;
                            while ($date_ot = $ot_date_list->fetch_assoc()){
                                //convert previous hours to hours and minutes
                                $p_hours = floor($date_ot['previous_overused']);
                                $p_minutes = ($date_ot['previous_overused'] - $p_hours) * 60;
                                $p_minutes = number_format($p_minutes);

                                //convert total overtime hours to hours and minutes
                                $t_hours = floor($date_ot['total_overtime']);
                                $t_minutes = ($date_ot['total_overtime'] - $t_hours) * 60;
                                $t_minutes = number_format($t_minutes);

                                //convert today overused hours to hours and minutes
                                $o_hours = floor($date_ot['today_overused']);
                                $o_minutes = ($date_ot['today_overused'] - $o_hours) * 60;
                                $o_minutes = number_format($o_minutes);
                                ?>
                                <tr style="background-color: #cdcdcd">
                                    <td colspan="11">
                                    <span class="ot-status date-summary text-white bg-dark" style="float:left;">
                                            <? echo date("d / m / Y", strtotime($date_ot['date']))?>
                                        </span>
                                        <span class="ot-status date-summary text-white bg-dark" style="float:left;">
                                            <? echo strtoupper(date("l", strtotime($date_ot['date'])))?>
                                        </span>
                                        <span class="ot-status date-summary text-white" style="background-color: #9f191f">
                                            Today Overused: <? echo $o_hours.'h '.$o_minutes.'m'//echo $date_ot['today_overused']?>
                                        </span>
                                        <span class="ot-status date-summary text-white" style="background-color: #00b961">
                                            Total Overtime: <? echo $t_hours.'h '.$t_minutes.'m' //echo $date_ot['total_overtime']?>
                                        </span>
                                        <span class="ot-status date-summary text-white" style="background-color: #016fb7">
                                            Previous Overused: <? echo $p_hours.'h '.$p_minutes.'m' //echo $date_ot['previous_overused']?>
                                        </span>
                                    </td>
                                    <!-- To enable datatable features when using colspan, you need to add (10) invisible column -->
                                    <td style="display: none"></td><td style="display: none"></td>
                                    <td style="display: none"></td><td style="display: none"></td>
                                    <td style="display: none"></td><td style="display: none"></td>
                                    <td style="display: none"></td>
                                </tr>
                                <?
                                $overtime = v02getOtList($date_ot['id']);
                                if (mysqli_num_rows($overtime) == 0){ ?>
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            <i class="text-muted" style="font-size: 16px">- No claim added. This may be caused by overused quota (4 hours) of previous day.
                                                Click <a style="font-size: smaller; text-decoration: none">New Overtime Form</a>
                                                button to check for any unclaimed overtime -
                                            </i>
                                        </td>
                                        <!-- To enable datatable features when using colspan, you need to add (10) invisible column -->
                                        <td style="display: none"></td><td style="display: none"></td>
                                        <td style="display: none"></td><td style="display: none"></td>
                                        <td style="display: none"></td><td style="display: none"></td>
                                        <td style="display: none"></td>
                                    </tr>
                                    <? $count_unclaimed++;
                                }
                                while($ot = $overtime->fetch_assoc()) {
                                    //convert hours to hours and minutes
                                    $hours = floor($ot['total_hours']);
                                    $minutes = ($ot['total_hours'] - $hours) * 60;
                                    $minutes = number_format($minutes);

                                    //HOD status
                                    if (empty($ot['verify_by']) && empty($ot['verify_at'])){
                                        $hod_text_color = 'GREY';
                                        $hod_text_status = 'PENDING';
                                    }else{
                                        if ($ot['verify_status'] == '1'){
                                            $hod_text_color = 'GREEN';
                                            $hod_text_status = 'VERIFIED';
                                        }else{
                                            $hod_text_color = 'RED';
                                            $hod_text_status = 'REJECTED';
                                        }
                                    }

                                    //HR status
                                    if (empty($ot['review_by']) && empty($ot['review_at'])){
                                        $hr_text_color = 'GREY';
                                        $hr_text_status = 'PENDING';
                                    }else{
                                        if ($ot['review_status'] == '1'){
                                            $hr_text_color = 'GREEN';
                                            $hr_text_status = 'REVIEWED';
                                        }else{
                                            $hr_text_color = 'RED';
                                            $hr_text_status = 'REJECTED';
                                        }
                                    }

                                    //CEO status
                                    if (empty($ot['approved_by']) && empty($ot['approved_at'])){
                                        $ceo_text_color = 'GREY';
                                        $ceo_text_status = 'PENDING';
                                    }else{
                                        if ($ot['approved_status'] == '1'){
                                            $ceo_text_color = 'GREEN';
                                            $ceo_text_status = 'APPROVED';
                                        }else{
                                            $ceo_text_color = 'RED';
                                            $ceo_text_status = 'DISAPPROVED';
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td>
                                            <? echo $i++; ?>
                                            <hr class="hr-separator">
                                            <span class="text-muted">
                                                Applied at: <br><b><? echo $ot['created_at'] ?></b>
                                            </span>

                                        </td>
                                        <td>
                                            <p class="ot-status text-dark bg-danger">Start:<br> <?php echo date('h:i a', strtotime($ot['start_ot'])); ?></p>
                                            <p class="ot-status text-dark bg-warning">End:<br> <?php echo date('h:i a', strtotime($ot['end_ot'])); ?></p>
                                            <p class="ot-status text-dark bg-success">Total:<br> <?php echo sprintf("%02s",$hours).'h '.sprintf("%02s",$minutes).'m'; ?></p>
                                        </td>
                                        <td class="text-left"><?php echo nl2br($ot['description']); ?></td>
                                        <td class="text-center">
                                            <span class="ot-status" style="background-color:<?php echo $hod_text_color?>;">
                                                <?php echo $hod_text_status.'<br>' ?>
                                            </span>
                                            <p style="margin-top: 8px">
                                                <? echo $ot['verify_at'].'<hr class="hr-separator">'.getStaffName($ot['verify_by']) ?>
                                            </p>
                                        </td>
                                        <td>
                                            <span class="ot-status" style="background-color:<?php echo $hr_text_color?>;">
                                                <?php echo $hr_text_status.'<br>' ?>
                                            </span>
                                            <p style="margin-top: 8px">
                                                <? echo $ot['review_at'].'<hr class="hr-separator">'.getStaffName($ot['review_by']) ?>
                                            </p>
                                        </td>
                                        <td>
                                            <span class="ot-status" style="background-color:<?php echo $ceo_text_color?>;">
                                                <?php echo $ceo_text_status.'<br>' ?>
                                            </span>
                                            <p style="margin-top: 8px">
                                                <? echo $ot['approved_at'].'<hr class="hr-separator">'.getStaffName($ot['approved_by']) ?>
                                            </p>
                                        </td>
                                        <td>
                                        <span class="ot-status" style="background-color: <?php echo ($ot['payment_status'] == "OPEN") ? 'RED' : 'GREEN';?>">
                                            <?php echo $ot['payment_status'] ?></span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuLeave" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="true">
                                                    <i class="fa fa-caret-down"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLeave" style="margin-left: -96px">
                                                    <li><a style="display: block" href="#attachmentModal" data-toggle="modal" data-id="<? echo $ot['id'];?>">
                                                            <i class="fa fa-image opt-icon"></i>Attachment</a></li>
                                                    <? if($hr_text_status=='PENDING' && $ceo_text_status != "APPROVED"){
                                                        $del_otp = (in_array($staff_department, $non_permission)) ? '&del_otp=1' : '';
                                                        //Show button delete if HR status is PENDING or REVIEWED ?>
                                                        <li><a style="display: block" href="#updateOT" data-toggle="modal" data-id="<? echo $ot['id'];?>">
                                                                <i class="fa fa-pencil opt-icon"></i> Update</a></li>
                                                        <li><a onclick="confirmDel('../controller/v02_aims_ot_delete_exec.php?id=<? echo $ot['id'].$del_otp; ?>')"
                                                               style="display: block; color: #d70000"><i class="fa fa-trash opt-icon"></i> Delete</a></li>
                                                    <? } ?>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <? $count_ot++;
                                }
                                $date_iteration++;
                            }?>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-md-3">
                                <p style="border-top: 2px solid black"></p>
                                <p>Number of Overtime Days: <b><? echo $count_date ?> records</b></p>
                                <p>Number of  Claim: <b><? echo $count_ot ?> records</b></p>
                                <p>Days without Overtime Claim: <b><? echo $count_unclaimed ?> records</b></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <? include "../global/footer.php"; ?>
    </div>
</div>

<div class="modal fade" id="updateOT" tabindex="-1" role="dialog" aria-labelledby="updateOTLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Edit Overtime Claim</h4>
            </div>
            <div class="modal-body" id="updateOTBody">
                <script type="text/javascript">
                    $('#updateOT').on('show.bs.modal', function (e) {
                        let rowId = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_ot_update.php',
                            data:{id:rowId},
                            success:function(html){
                                $('#updateOTBody').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="attachmentModal" tabindex="-1" role="dialog" aria-labelledby="attachmentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="attachmentModalLabel">View Attachment</h4>
            </div>
            <div class="modal-body" id="attachmentModalBody">
                <script type="text/javascript">
                    $('#attachmentModal').on('show.bs.modal', function (e) {
                        let rowId = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_ot_attachment.php',
                            data:{id:rowId},
                            success:function(html){
                                $('#attachmentModalBody').html(html);
                            }
                        });
                    });
                </script>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-block btn-danger btn-rounded btn-md ml-4" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true,
            ordering: false,
            aLengthMenu: [
                [20, 50, 100, 200, -1],
                [20, 50, 100, 200, "All"]
            ],
        });
    });
</script>
</body>
</html>