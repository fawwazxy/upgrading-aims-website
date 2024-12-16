<?php
include "../controller/auth.php";
require "../model/v02_aims_ot_function.php";

$staff_id = $_SESSION['SESS_ID'];
$staff_department = $_SESSION['SESS_DEPARTMENT_SUB'];
$year = ($_GET['year']) ?: date('Y');

$non_permission = ["HR-AGMA", "OPERATION-AGMSB", "OPERATION-BUNKER"];
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
        .ot-status{
            border-radius: 8px;
            font-weight:bold;
            color: #ffffff;
            padding: 8px 12px;
            margin: 0 4px;
        }
        .panel-subtitle{
            border-radius: 16px;
            font-weight: bold;
            float: right;
            padding: 4px 8px 1px;
            margin-bottom: 0;
        }
        .panel-green{
            border-color: #00a903;
        }
        .panel-green .panel-heading{
            background-color: #00a903;
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
                    <a href="aims_ot_list_month.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                </h1>
            </div>
        </div>

        <div class="row" style="margin: 0 0 16px;">
            <div class="col-lg-8">
                <table style="width:100%">
                    <tr>
                        <th style="width: 14%">Name</th>
                        <th style="width: 2%">:</th>
                        <td><?php echo $_SESSION['SESS_NAME']; ?></td>
                    </tr>

                    <tr>
                        <th>IC No.</th>
                        <th>:</th>
                        <td><?php echo $_SESSION['SESS_NOKP']; ?></td>
                    </tr>

                    <tr>
                        <th>Staff No.</th>
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
            <div class="col-md-4 text-right">
                <? $link_attribute = (in_array($staff_department, $non_permission))
                    ? 'href="v02_aims_ot_form_op_agmsb.php"' //attribute for operation agmsb
                    : 'href="#newOT" data-toggle="modal" data-staff_id="'.$staff_id.'"'; //attribute for other staff ?>
                <a class="btn btn-primary" style="font-weight: bolder" <? echo $link_attribute ?>>New Overtime Form</a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-10">
                                <label for="leave_type" style="font-size: 18px">Overtime list by month session</label>
                            </div>
                            <div class="col-md-2">
                                <form method="get" action="" name="otYear" id="otYear" onchange="otYear.submit()">
                                    <select class="form-control" name="year" id="year">
                                        <? for ($option=date('Y'); $option >= 2022; $option--){ ?>
                                            <option value="<? echo $option?>" <? if ($option == $year) echo 'selected' ?>><? echo $option ?></option>
                                        <? } ?>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <?
                        $ot_month_session = v02getOtMonthSession($staff_id, $year);
                        $i= 1;
                        if ($ot_month_session->num_rows < 1){ ?>
                            <div class="col-md-12 text-center">
                                <span class="text-muted">You did not apply for any overtime claim yet.</span>
                            </div>
                        <? }
                        while($otm = $ot_month_session->fetch_assoc()) {
                            if(v02getCountOtMonthSession($otm['id']) > 0){
                                $getOtApproval = v02getOtApproval($otm['id']);
                                $total_hours = $otm['normal_hour'] + $otm['weekend_hour'] + $otm['holiday_hour'];

                                $hod_intersect = 1; $hr_intersect = 1; $ceo_intersect = 1; //set default to true (GREEN)
                                while ($otApproval = $getOtApproval->fetch_assoc()){
                                    //HOD status -- if hod false, hr and ceo will false (GREY)
                                    if (empty($otApproval['verify_by']) && empty($otApproval['verify_at'])){
                                        $hod_intersect = 0; $hr_intersect = 0; $ceo_intersect = 0;
                                        break;
                                    }else{
                                        if ($otApproval['verify_status'] == '1'){
                                            $hod_verify_at = $otApproval['verify_at'];
                                        }else{
                                            $hod_intersect = 0; $hr_intersect = 0; $ceo_intersect = 0;
                                            break;
                                        }
                                    }

                                    //HR status -- if hr false, ceo will false
                                    if (empty($otApproval['review_by']) && empty($otApproval['review_at'])){
                                        $hr_intersect = 0; $ceo_intersect = 0;
                                        break;
                                    }else{
                                        if ($otApproval['review_status'] == '1'){
                                            $hr_review_at = $otApproval['review_at'];
                                        }else{
                                            $hr_intersect = 0; $ceo_intersect = 0;
                                            break;
                                        }
                                    }

                                    //CEO status -- ceo will false if hod or hr is false
                                    if (empty($otApproval['approved_by']) && empty($otApproval['approved_at'])){
                                        $ceo_intersect = 0;
                                        break;
                                    }else{
                                        if ($otApproval['approved_status'] == '1'){
                                            $ceo_approved_at = $otApproval['approved_at'];
                                        }else{
                                            $ceo_intersect = 0;
                                            break;
                                        }
                                    }
                                }
                                ?>
                                <div class="col-md-3">
                                    <div class="panel <? echo ($hod_intersect == 1 && $hr_intersect == 1 && $ceo_intersect == 1) ? 'panel-green' : ' panel-default' ?>">
                                        <div class="panel-heading">
                                            <label class="panel-title"><?echo strtoupper($otm['month_session']);?></label>
                                            <label class="panel-subtitle <? echo ($otm['total_claim']) ? 'bg-success text-success' : 'text-muted' ?>">
                                                <? echo ($otm['total_claim']) ? 'RM '.$otm['total_claim']
                                                    : '<a href="#estimateWages" data-toggle="modal" data-id="'.$otm['id'].'" style="font-size: 90%">Calculate</a>'; ?>
                                            </label>
                                        </div>
                                        <div class="panel-body text-center">
                                            <table style="width: 100%">
                                                <tr>
                                                    <th>Total hours</th>
                                                    <td><? echo ($total_hours > 0) ? $total_hours.'h' : ''; ?></td>
                                                </tr>
                                                <tr>
                                                    <th>HOD Verification</th>
                                                    <td style="color:<?php echo ($hod_intersect == 1) ? 'GREEN': 'GREY';?>;">
                                                        <i class="fa <?php echo ($hod_intersect == 1) ? 'fa-check-circle': 'fa-exclamation-circle'; ?>"></i>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>HR Review</th>
                                                    <td style="color:<?php echo ($hr_intersect == 1) ? 'GREEN': 'GREY';?>;">
                                                        <i class="fa <?php echo ($hr_intersect == 1) ? 'fa-check-circle': 'fa-exclamation-circle'; ?>"></i>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>CEO/EC Approval</th>
                                                    <td style="color:<?php echo ($ceo_intersect == 1) ? 'GREEN': 'GREY';?>;">
                                                        <i class="fa <?php echo ($ceo_intersect == 1) ? 'fa-check-circle': 'fa-exclamation-circle'; ?>"></i>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <hr style="margin: 8px 0">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <a href="../view/v02_aims_ot_list.php?sort=DESC&month_session=<? echo $otm['id'] ?>"
                                                           class="btn btn-primary" style="width: 90%"> View <i class="fa fa-eye"></i></a>
                                                    </td>
                                                    <td>
                                                        <a href="v02_aims_ot_print.php?id=<? echo $otm['id'];?>" target="_blank" class="btn btn-success" style="width: 90%">
                                                            Print <i class="fa fa-print"></i></a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?}
                        }?>
                    </div>
                </div>
            </div>
        </div>
        <? include "../global/footer.php"; ?>
    </div>
</div>

<div class="modal fade" id="newOT" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">NEW OVERTIME CLAIM</h4>
            </div>
            <div class="modal-body" id="demo1">
                <script type="text/javascript">
                    $('#newOT').on('show.bs.modal', function (e) {
                        let staff_id = $(e.relatedTarget).data('staff_id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_ot_new.php',
                            data:{staff_id:staff_id},
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

<div class="modal fade" id="estimateWages" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Estimate your overtime wages.</h4>
            </div>
            <div class="modal-body" id="estimateWagesBody">
                <script type="text/javascript">
                    $('#estimateWages').on('show.bs.modal', function (e) {
                        let rowId = $(e.relatedTarget).data('id');

                        $.ajax({
                            type:'POST',
                            url:'v02_aims_ot_estimate_wages.php',
                            data:{id:rowId},
                            success:function(html){
                                $('#estimateWagesBody').html(html);
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
            columnDefs: [
                { targets: 0, orderable: false }
            ]
        });
        $("#department_code").change(function(){
            var selected_cawangan=$(this).val();
            sendType(selected_cawangan);
        });
    });
</script>
</body>
</html>



