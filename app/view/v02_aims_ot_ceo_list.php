<?php
include "../controller/auth.php";
require "../model/lookup.php";
require "../model/v02_aims_ot_function.php";

$approval_id = $_SESSION['SESS_ID'];

if($_SESSION['SESS_ROLE'] != 'FOUNDER'){ //current logged in user is not ceo or chairman
    echo "<script>
            alert('This section can only be accessed by CEO/Chairman for OVERTIME CLAIM approval')
            window.history.back();
            </script>";
    exit();
}

$department_code=($_GET['department_code']) ?: '0';
$approved_status = ($_GET['approved_status']) ?: 'NULL';
$month = ($_GET['month']) ?: '0';
$year = ($_GET['year']) ?: date('Y');
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

        .claim-card{
            width: 80%;
            color: #000000;
            border: dotted black;
            padding-top: 6px;
            margin: 0 auto;
        }

        .text-center th{
            text-align: center;
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
                    OVERTIME CLAIM <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> APPROVAL
                    <a href="aims_ot_ceo_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_ot_migration_message.php"; ?>
        </div>

        <form action="" method="get">
            <div class="row" style="margin-bottom: 16px">
                <input type="hidden" name="approved_status" id="approved_status" value="<? echo $approved_status ?>">
                <div class="col-md-4">
                    <select required class="form-control" name="department_code" id="department_code">
                        <option value="0">All Company</option>
                        <? echo getDropDown("department","code_department","description",$department_code);?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select required class="form-control" name="month" id="month">
                        <? echo v02getDropDownMonth($month);?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select required class="form-control" name="year" id="year">
                        <? for ($i=0;$i<4;$i++){
                            $option_year = date('Y')-$i; ?>
                            <option value="<? echo $option_year ?>" <? if ($year == $option_year) echo 'selected'?>>
                                <? echo $option_year ?>
                            </option>
                        <? } ?>
                    </select>
                </div>
                <div class="col-lg-3">
                    <button type="submit" class="btn btn-info">Filter</button>
                </div>
            </div>
        </form>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="tab">
                        <a href="v02_aims_ot_ceo_list.php?approved_status=NULL&department_code=<? echo $department_code;?>&month=<? echo $month ?>&year=<? echo $year ?>"
                           class="tabLinks <? if($approved_status == "NULL") echo 'active'?>">
                            NEW </a>
                        <a href="v02_aims_ot_ceo_list.php?approved_status=YES&department_code=<? echo $department_code;?>&month=<? echo $month ?>&year=<? echo $year ?>"
                           class="tabLinks <? if($approved_status == "YES") echo 'active'?>">
                            APPROVED </a>
                        <a href="v02_aims_ot_ceo_list.php?approved_status=NO&department_code=<? echo $department_code;?>&month=<? echo $month ?>&year=<? echo $year ?>"
                           class="tabLinks <? if($approved_status == "NO") echo 'active'?>">
                            DISAPPROVED </a>
                    </div>
                    <div class="panel-body">
                        <form name="formActive" method="post" action="../controller/v02_aims_checkbox_ot_approval.php">
                            <div class="row" style="margin-left: 4px;margin-bottom: 16px">
                                <input type="checkbox" id="select_all"/>&nbsp;
                                <label for="select_all" style="font-size: medium;margin-right: 8px"> Select All</label>

                                <input type="submit" name="approved_status" class="btn btn-success" id="activate" value="APPROVE" <? if ($approved_status=='YES') echo 'disabled' ?>/>
                                <input type="submit" name="approved_status" class="btn btn-danger" id="activate" value="DISAPPROVE" <? if ($approved_status=='NO') echo 'disabled' ?>/>
                                <input type="hidden" name="approval" value="<? echo $approved_status ?>">
                                <input type="hidden" name="approval_id" value="<? echo $approval_id ?>">
                            </div>
                            <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th style="width: 6%">No.</th>
                                    <th style="width: 30%">Staff Info</th>
                                    <th style="width: 17%">Month Claim</th>
                                    <th style="width: 17%">Company</th>
                                    <th style="width: 20%">CEO/Chairman Status</th>
                                    <th style="width: 10%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $month_session_list = v02getMonthSessionCEO($department_code, $approval_id, $approved_status, $month, $year);

                                $i= 1;
                                $total_wages = 0;
                                while($month_session = $month_session_list->fetch_assoc()) {
                                    $total_wages += $month_session['total_claim'];
                                    //Take latest approval info using month_session id (loop)
                                    $approved_info = v02getLatestApprovalInfo($month_session['id'], $approved_status)->fetch_assoc();
                                    //Take document name from same month claim

                                    if ($approved_info['selected_row'] > 0){
                                        //declare and set default value
                                        $status_color = 'RED';
                                        $status_text = 'REJECTED';
                                        $count_text = '&nbsp;&nbsp;( '.$approved_info['selected_row'].' / '.$approved_info['total_row'].' )';
                                        $approved_by = '<br>'.getStaffName($approved_info['approved_by']);
                                        $approved_at = '<br>'.$approved_info['approved_at'];

                                        if ($approved_status == 'NULL'){
                                            $status_color = 'GREY';
                                            $status_text = 'PENDING';
                                            $count_text = '&nbsp;&nbsp;( '.$approved_info['selected_row'].' )';
                                        }else if ($approved_status == 'YES'){
                                            $status_color = 'GREEN';
                                            $status_text = 'VERIFIED';
                                            $approved_by = '<br>'.getStaffName($approved_info['approved_by']);
                                            $approved_at = '<br>'.$approved_info['approved_at'];
                                        }
                                        ?>
                                        <tr>
                                            <td class="text-center">
                                                <input name="checkbox[]" type="checkbox" class="checkbox" id="checkbox[]" value="<?php echo $month_session['id']; ?>" />&nbsp;
                                                <label for="checkbox[]"><?php echo $i++.'.'; ?></label>
                                            </td>
                                            <td>
                                                <b>Name:</b> <?echo $month_session['name'];?><br>
                                                <b>IC No:</b> <?echo $month_session['noic'];?><br>
                                                <b>Staff No:</b> <?echo $month_session['no_staff'];?><br>
                                                <b>Department:</b> <?echo $month_session['department_sub'];?><br>
                                                <b>Company:</b> <?echo $month_session['department_id'];?>
                                            </td>
                                            <td class="text-center">
                                                <p><?echo $month_session['month_session'];?></p>
                                                <p class="ot-status claim-card">
                                                    Total Claim<br>
                                                    <span style="color: green; font-weight: bold; font-size: 24px">
                                                <? echo (!empty($month_session['total_claim']) && $month_session['total_claim']) ?
                                                    'RM'.$month_session['total_claim'] : '';?></span>
                                                </p>

                                            </td>
                                            <td class="text-center"><?echo $month_session['department_id'];?></td>
                                            <td class="text-center">
                                            <span class="ot-status" style="background-color: <? echo $status_color; ?>">
                                                <?
                                                echo $status_text.$count_text;
                                                ?>
                                            </span>
                                                <p><? echo $approved_by.$approved_at; ?></p>
                                            </td>
                                            <td class="text-center">
                                                <a class="btn btn-sm btn-info" href="v02_aims_ot_print.php?id=<? echo $month_session['id'];?>" target="_blank" style="font-weight: bold; margin-bottom: 8px">
                                                    CLAIM INFO</a>

                                                <?if(v02getDocumentListMonthSession($month_session['id'])->num_rows > 0) {?>
                                                    <a href="" class="btn btn-sm btn-primary" onclick="return popItUp('v02_aims_ot_all_images.php?id=<? echo $month_session['id'];?>')" style="font-weight: bold; margin-bottom: 8px">ATTACHMENT</a>
                                                <?}?>

                                                <a href="#ceoApproval" class="btn btn-success" data-toggle="modal" style="font-weight: bold; margin-bottom: 8px"
                                                   data-id ="<? echo $month_session['id'];?>" data-status="<? echo $approved_status ?>">
                                                    ACTION</a>
                                            </td>
                                        </tr>
                                    <?}
                                }?>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th class="text-right" colspan="2">Total Wages</th>
                                    <th class="text-center">
                                        <span style="color: green; font-size: 24px">
                                        <? echo 'RM '.number_format($total_wages, 2) ?>
                                        </span>
                                    </th>
                                    <td colspan="3"></td>
                                </tr>
                                </tfoot>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <? include "../global/footer.php"; ?>
    </div>
</div>

<div class="modal fade" id="ceoApproval" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">EC / CEO APPROVAL</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#ceoApproval').on('show.bs.modal', function (e) {
                        let rowId = $(e.relatedTarget).data('id');
                        let status = $(e.relatedTarget).data('status');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_ot_ceo_update.php',
                            data:{id:rowId,status:status},
                            success:function(html){
                                $('#demo').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="demo1">
                <script type="text/javascript">
                    $('#myModal2').on('show.bs.modal', function (e) {
                        let rowId = $(e.relatedTarget).data('id');
                        let month = $(e.relatedTarget).data('month');
                        $.ajax({
                            type:'GET',
                            url:'v02_aims_ot_all_images.php',
                            data:{id:rowId,month:month},
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
<script type="text/javascript">
    function popItUp(url) {
        let newWindow=window.open(url,'name','height=720,width=1080');
        if (window.focus) {
            newWindow.focus()
        }
        return false;
    }

    $(document).ready(function(){
        // all checkbox checked if select all is checked
        $('#select_all').on('click',function(){
            $('input[class="checkbox"]').prop('checked', this.checked);
        });

        // select all checked if all checkbox checked
        $('.checkbox').on('click',function(){
            $('#select_all').prop('checked',$('.checkbox:checked').length === $('.checkbox').length);
        });

        //datatable package
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>
</body>
</html>



