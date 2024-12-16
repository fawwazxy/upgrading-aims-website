<?php
include "../controller/auth.php";
require "../model/v02_aims_ot_function.php";

$staff_id_verify = $_SESSION['SESS_ID'];
$department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];
$verify_by = $_SESSION['SESS_NAME'];
$verification = ($_GET['v']) ?: 'NULL';
$month = (isset($_GET['month'])) ? $_GET['month'] : '0';
$year = ($_GET['year']) ? $_GET['year'] : date('Y');
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

        /* Style the tab content */
        .tabContent {
            display: none;
            padding: 6px 12px;
            border: 1px solid #ccc;
            border-top: none;
        }

        .ot-status{
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
                    OVERTIME <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> CLAIM <i class="fa fa-caret-right"></i> VERIFICATION
                    <a href="aims_ot_hod_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_ot_migration_message.php"; ?>
        </div>

        <div class="row" style="margin-bottom: 16px">
            <form method="get" action="">
                <input type="hidden" name="v" value="<? echo $verification?>">
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
                    <button type="submit" class="btn btn-info">Filter</button>
                    <a href="v02_aims_ot_hod_list.php" class="btn btn-default" style="background-color: #b0b0b0">Reset</a>
                </div>
            </form>
        </div>
        <div class="tab">
            <a href="v02_aims_ot_hod_list.php?v=NULL&month=<? echo $month ?>&year=<? echo $year?>" class="tabLinks <? if($verification=="NULL") echo 'active'?>">
                NEW </a>
            <a href="v02_aims_ot_hod_list.php?v=YES&month=<? echo $month ?>&year=<? echo $year?>" class="tabLinks <? if($verification=="YES") echo 'active'?>">
                VERIFIED </a>
            <a href="v02_aims_ot_hod_list.php?v=NO&month=<? echo $month ?>&year=<? echo $year?>" class="tabLinks <? if($verification=="NO") echo 'active'?>">
                REJECTED </a>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <form name="frmactive" method="post" action="../controller/v02_aims_checkbox_ot_verification.php">
                            <div class="row" style="margin-left: 4px;margin-bottom: 16px">
                                <input type="checkbox" id="select_all"/>&nbsp;
                                <label for="select_all" style="font-size: medium;margin-right: 8px"> Select All</label>

                                <input type="submit" name="verification_status" class="btn btn-success" id="activate" value="VERIFY" <? if ($verification=='YES') echo 'disabled' ?>/>
                                <input type="submit" name="verification_status" class="btn btn-danger" id="activate" value="REJECT" <? if ($verification=='NO') echo 'disabled' ?>/>
                                <input type="hidden" name="verification" value="<? echo $verification ?>">
                                <input type="hidden" name="staff_id" value="<? echo $staff_id_verify ?>">
                            </div>
                            <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th style="width: 6%">No.</th>
                                    <th style="width: 28%">Staff Info</th>
                                    <th style="width: 28%">Month Claim</th>
                                    <th style="width: 28%">Status</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $month_session_list = v02getMonthSessionHOD($department_sub, $staff_id_verify, $verification, $month, $year);
                                $i= 1;
                                while($month_session = $month_session_list->fetch_assoc()) {
                                    //Take latest verification info using month_session id (loop)
                                    $verify_info = v02getLatestVerifyInfo($month_session['id'], $verification, $staff_id_verify)->fetch_assoc();

                                    if ($verify_info['selected_row'] > 0){
                                        //declare and set default value
                                        $status_color = 'RED';
                                        $status_text = 'REJECTED';
                                        $count_text = '&nbsp;&nbsp;( '.$verify_info['selected_row'].' / '.$verify_info['total_row'].' )';
                                        $verify_by = '<br>'.getStaffName($verify_info['verify_by']);
                                        $verify_at = '<br>'.$verify_info['verify_at'];

                                        if ($verification == 'NULL'){
                                            $status_color = 'GREY';
                                            $status_text = 'PENDING';
                                            $count_text = '&nbsp;&nbsp;( '.$verify_info['selected_row'].' )';
                                        }else if ($verification == 'YES'){
                                            $status_color = 'GREEN';
                                            $status_text = 'VERIFIED';
                                            $verify_by = '<br>'.getStaffName($verify_info['verify_by']);
                                            $verify_at = '<br>'.$verify_info['verify_at'];
                                        }
                                        ?>
                                        <tr>
                                            <td class="text-center">
                                                <input name="checkbox[]" type="checkbox" class="checkbox" id="checkbox[]" value="<?php echo $month_session['id']; ?>" />&nbsp;
                                                <label for="checkbox[]"><?php echo sprintf("%02d", $i++).'.'; ?></label>
                                            </td>
                                            <td>
                                                <b>Name:</b> <?echo $month_session['name'];?><br>
                                                <b>IC No:</b> <?echo $month_session['noic'];?><br>
                                                <b>Position:</b> <?echo $month_session['role_id'];?><br>
                                                <b>Department:</b> <?echo $month_session['department_sub'];?><br>
                                                <b>Company:</b> <?echo $month_session['department_id'];?>
                                            </td>
                                            <td class="text-center"><?echo $month_session['month_session'];?></td>
                                            <td class="text-center">
                                                <span class="ot-status" style="background-color: <? echo $status_color; ?>">
                                                    <? echo $status_text.$count_text; ?>
                                                </span>
                                                <p><? echo $verify_by.$verify_at; ?></p>
                                            </td>
                                            <td>
                                                <a href="v02_aims_ot_hod_list_details.php?month_session_id=<? echo $month_session['id']?>&verification=<?echo $verification?>"
                                                   target="_blank" class="btn btn-primary">
                                                    CLAIM DETAILS
                                                </a>
                                            </td>
                                        </tr>
                                    <?}
                                }?>
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
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true,
            columnDefs: [
                { targets: -1, orderable: false }
            ]
        });
    });

    $(document).ready(function(){
        // all checkbox checked if select all is checked
        $('#select_all').on('click',function(){
            $('input[class="checkbox"]').prop('checked', this.checked);
        });

        // select all checked if all checkbox checked
        $('.checkbox').on('click',function(){
            $('#select_all').prop('checked',$('.checkbox:checked').length === $('.checkbox').length);
        });
    });
</script>
</body>
</html>


