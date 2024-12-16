<?php
include "../controller/auth.php";
require "../model/v02_aims_ot_function.php";

$verification = ($_GET['verification']) ?: 'NULL';
$month_session_id = $_GET['month_session_id'];

$verify_id = $_SESSION['SESS_ID'];
$verify_by = $_SESSION['SESS_NAME'];

if ($verification == 'NULL'){
    $status_text = "PENDING";
}else if ($verification == 'YES'){
    $status_text = "VERIFIED";
}else{
    $status_text = "REJECTED";
}
$staff = v02getMonthSessionDetails($month_session_id)->fetch_assoc();
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
        .horizontal-scroll {
            overflow: hidden;
            overflow-x: auto;
            clear: both;
            width: 100%;
        }
        .text-center td{
            text-align: center;
        }

        .ot-status{
            padding:3px;
            border-radius: 5px;
            font-weight:bold;
        }
        .ot-timestamp{
            padding: 4px 8px;
            border-radius: 5px;
            font-weight: bold;
            color: #000000;
            background-color: #e7e7e7;
            border: 1px dotted black;
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
                    <i class="fa fa-caret-right"></i> VERIFICATION <i class="fa fa-caret-right"></i> DETAILS
                    <a href="aims_ot_hod_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                </h1>
            </div>
        </div>

        <div class="row" style="margin: 0 0 16px;">
            <div class="col-md-6">
                <table style="width: 100%">
                    <tr>
                        <th>Staff Name</th>
                        <th>:</th>
                        <td><?php echo $staff['name']?></td>
                    </tr>
                    <tr>
                        <th>IC Number</th>
                        <th>:</th>
                        <td><?php echo $staff['noic']?></td>
                    </tr>
                    <tr>
                        <th>Staff Number</th>
                        <th>:</th>
                        <td><?php echo $staff['noic']?></td>
                    </tr>
                    <tr>
                        <th>Company</th>
                        <th>:</th>
                        <td><?php echo $staff['department_id']?></td>
                    </tr>
                    <tr>
                        <th>Department</th>
                        <th>:</th>
                        <td><?php echo $staff['department_sub']?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6 text-right">
                <input type="button" class="btn btn-danger" value="CLOSE" onclick="self.close()">
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-8">
                                <label>Overtime Claim By Month: <? echo $staff['month_session']; ?></label>
                            </div>
                            <div class="col-md-2 text-right">
                                <label for="verification">Status: </label>
                            </div>
                            <div class="col-md-2">
                                <form action="" method="get" name="overtimeDetails">
                                    <input type="hidden" name="month_session_id" value="<? echo $month_session_id ?>">
                                    <select class="form-control form-control-sm" name="verification" id="verification" onchange="overtimeDetails.submit()">
                                        <option value="NULL" <? if ($verification == 'NULL') echo 'selected'; ?>>PENDING</option>
                                        <option value="YES" <? if ($verification == 'YES') echo 'selected'; ?>>VERIFIED</option>
                                        <option value="NO" <? if ($verification == 'NO') echo 'selected'; ?>>REJECTED</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="horizontal-scroll">
                            <form name="selectForm" method="post" action="../controller/v02_aims_ot_hod_update_exec.php">
                                <table class="table table-striped table-bordered table-hover" style="width: 100%" id="dataTables-examples">
                                    <thead>
                                    <tr class="text-center">
                                        <th style="width: 5%">No.</th>
                                        <th style="width: 15%">Date/Day</th>
                                        <th style="width: 15%">Time</th>
                                        <th style="width: 15%">Working Period</th>
                                        <th style="width: 20%">Work Description</th>
                                        <th style="width: 10%">Remark</th>
                                        <th style="width: 10%">Attachment</th>
                                        <th style="width: 10%">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?
                                    $list_by_month_session = v02getOtByMonthSession($month_session_id, $verification, $verify_id);
                                    $i=1;
                                    if ($list_by_month_session->num_rows < 1){ ?>
                                        <tr>
                                            <td class="text-center" colspan="8">- No overtime claim available for <? echo $status_text ?> -</td>
                                        </tr>
                                    <? }
                                    while($ot = $list_by_month_session->fetch_assoc()) {
                                        //convert hours to hours and minutes
                                        $hours = floor($ot['total_hours']);
                                        $minutes = ($ot['total_hours'] - $hours) * 60;
                                        $minutes = number_format($minutes);
                                        ?>
                                        <tr class="text-center">
                                            <td style="width: 5%">
                                                <input name="checkbox[]" type="checkbox" class="checkbox" id="checkbox[]" value="<?php echo $ot['id']; ?>" style="margin: 0; position: absolute" />&nbsp;
                                                <label for="checkbox[]" style="margin: 0; position: absolute"><?php echo $i++.'.'; ?></label>
                                            </td>
                                            <td class="text-left"><?
                                                echo '<p>'.$ot['date']; ?><br><? echo strtoupper(date("l", strtotime($ot['date']))).'</p>';
                                                echo '<span class="ot-timestamp">' . $ot['created_at'] . '</span>';
                                                ?>
                                            </td>
                                            <td>
                                                <p class="ot-status bg-success">Start:<br> <?php echo date('h:i a', strtotime($ot['start_ot'])); ?></p>
                                                <p class="ot-status bg-danger">End:<br> <?php echo date('h:i a', strtotime($ot['end_ot'])); ?></p>
                                            </td>
                                            <td><?php echo sprintf("%02s",$hours).'h '.sprintf("%02s",$minutes).'m'; ?></td>
                                            <td class="text-left"><?php echo nl2br($ot['description']); ?></td>
                                            <td>
                                                <? echo $ot['verification_remark'];?>
                                            </td>
                                            <td>
                                                <?if($ot['document_name'] != '') {?>
                                                    <a href="#myModal2" class="btn btn-warning btn-sm" data-toggle="modal"
                                                       data-id="<? echo $ot['id'];?>" style="margin: 4px 0;">ATTACHMENT</a>
                                                <?}?>
                                            </td>
                                            <td>
                                                <!-- [192] 850126115526: rosliha, [788] 690615115252: hoc t-kitchen => akmal ======== 04/08/2022 only open hod update features for akmal and rosliha -->
                                                <? if (in_array($verify_id, ['192','788']) && empty($ot['verify_by']) && empty($ot['verify_at'])){ ?>
                                                    <a href="#myModal1" class="btn btn-primary btn-sm" data-toggle="modal" data-id="<? echo $ot['id'];?>" style="margin: 4px 0; font-weight: bold">UPDATE CLAIM</a>
                                                <? } ?>
                                                <a href="#myModal3" class="btn btn-info btn-sm" data-toggle="modal" data-id="<? echo $ot['id'];?>" style="margin: 4px 0; font-weight: bold">EDIT REMARK</a>
                                            </td>
                                        </tr>
                                    <?}?>
                                    <tr>
                                        <td style="background-color:white;" colspan="5">
                                            <b>VERIFIED BY : <?echo $verify_by;?></b>
                                        </td>
                                        <td style="background-color:white;" class="text-right" colspan="3">
                                            <input type="checkbox" id="select_all"/>&nbsp;
                                            <label for="select_all" style="font-size: medium;margin-right: 8px"> Select All</label>

                                            <input type="submit" name="verification_status" class="btn btn-success" id="activate" value="VERIFY" <? if ($verification=='YES') echo 'disabled' ?>/>
                                            <input type="submit" name="verification_status" class="btn btn-danger" id="activate" value="REJECT" <? if ($verification=='NO') echo 'disabled' ?>/>
                                            <input type="hidden" name="staff_id" value="<? echo $verify_id?>">
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <? include "../global/footer.php"; ?>
    </div>
</div>

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Update Overtime Claim (HOC Only)</h4>
            </div>
            <div class="modal-body" id="demo1">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        let rowId = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_ot_hod_update.php',
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

<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="attachmentModalLabel">View Attachment</h4>
            </div>
            <div class="modal-body" id="demo2">
                <script type="text/javascript">
                    $('#myModal2').on('show.bs.modal', function (e) {
                        let rowId = $(e.relatedTarget).data('id');

                        $.ajax({
                            type:'POST',
                            url:'v02_aims_ot_attachment.php',
                            data:{id:rowId},
                            success:function(html){
                                $('#demo2').html(html);
                            }
                        });
                    });
                </script>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-block btn-danger btn-rounded btn-md ml-4"
                        data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Edit / Add Remark</h4>
            </div>
            <div class="modal-body" id="demo3">
                <script type="text/javascript">
                    $('#myModal3').on('show.bs.modal', function (e) {
                        let rowId = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_ot_hod_edit.php',
                            data:{id:rowId},
                            success:function(html){
                                $('#demo3').html(html);
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
            responsive: true
        });

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



