<?php
include ('../controller/auth.php');
require "../model/lookup.php";
require "../model/v02_aims_medical_function.php";

$staff_id = $_SESSION['SESS_ID'];
$staff_role = $_SESSION['SESS_ROLE'];

$sys = getSys(1)-> fetch_assoc();

if ($staff_role != 'FOUNDER' ) {
    echo "<script>
            alert('This page is only accessible to CHAIRMAN / CEO')
            window.history.back();
            </script>";
    exit();
}

$department_code=($_GET['department_code']) ?: '0';
$ceo_approval = ($_GET['ceo']) ?: 'NULL';
$month= (!empty($_GET['month']))  ?$_GET['month'] : '0';
$year=(!empty($_GET['year'])) ? $_GET['year'] : '0';
?>

<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <? require "../global/header.php"; ?>
    <!--simbol loading-->
    <style>
        #loader {
            border: 12px solid #f3f3f3;
            border-radius: 50%;
            border-top: 12px solid #444444;
            width: 70px;
            height: 70px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            100% {
                transform: rotate(360deg);
            }
        }

        .center {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            margin: auto;
            z-index: 99999 ;
        }
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

        .app-status{
            background-color:WHITE;
            padding:5px;
            border-radius: 5px;
            font-weight:bold;
        }

        a{
            text-decoration: none;
        }
        .text-center{
            text-align: center;
        }
        .text-white{
            color: #FFFFFF;
        }
    </style>
</head>

<body>
<!--simbol loading-->
<div id="loader" class="center"></div>
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
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    MEDICAL <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> <? echo ($staff_id == '13') ? 'CEO' : 'CHAIRMAN'; ?> APPROVAL
                    <a href="aims_lv_medicalapp_list.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <? include "v02_aims_medical_migration_message.php"; ?>
        </div>

        <div class="row">
            <form method="GET" action="">
                <input type="hidden" name="ceo" value="<? echo $ceo_approval ?>">
                <div class="col-lg-4" style="margin-bottom: 8px">
                    <select  required class="form-control" name="department_code" id="department_code">
                        <option value="0" <? if ($department_code == '0') echo 'selected' ?>>All</option>
                        <? echo getDropdownCompany($department_code);?>
                    </select>
                </div>
                <div class="col-lg-2">
                    <select required class="form-control" name="month" id="month">
                        <? echo v02getDropDownMonth($month);?>
                    </select>
                </div>
                <div class="col-lg-2">
                    <select required class="form-control" name="year" id="year">
                        <option value="0" <? if ($year == '0') echo 'selected' ?>>All</option>
                        <? echo v02getDropDownYear($year);?>
                    </select>
                </div>

                <div class="col-lg-3">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="tab">
                    <a href="v02_aims_medical_ceo_list.php?department_code=<? echo $department_code;?>&ceo=NULL&month=<? echo $month ?>&year=<? echo $year ?>"
                       class="tabLinks <? if($ceo_approval == "NULL") echo 'active'?>">
                        NEW </a>
                    <a href="v02_aims_medical_ceo_list.php?department_code=<? echo $department_code;?>&ceo=YES&month=<? echo $month ?>&year=<? echo $year ?>"
                       class="tabLinks <? if($ceo_approval == "YES") echo 'active'?>">
                        APPROVED </a>
                    <a href="v02_aims_medical_ceo_list.php?department_code=<? echo $department_code;?>&ceo=NO&month=<? echo $month ?>&year=<? echo $year ?>"
                       class="tabLinks <? if($ceo_approval == "NO") echo 'active'?>">
                        DISAPPROVED </a>
                    <a href="v02_aims_medical_ceo_list.php?department_code=<? echo $department_code;?>&ceo=CLOSED&month=<? echo $month ?>&year=<? echo $year ?>"
                       class="tabLinks <? if($ceo_approval == "CLOSED") echo 'active'?>">
                        COMPLETED </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body" style="overflow: auto">
                        <form name="checkMultiple" method="post" action="../controller/v02_aims_medical_approval_multiple_exec.php">
                            <input type="hidden" name="level" value="3"> <? //level 2: cfo, level 3: ceo/chairman?>
                            <? if ($ceo_approval == 'NULL'){ ?>
                                <div class="row" style="margin-left: 4px;margin-bottom: 16px">
                                    <input type="checkbox" id="select_all"/>&nbsp;
                                    <label for="select_all" style="font-size: medium;margin-right: 8px"> Select All</label>

                                    <input type="submit" name="approval_status" class="btn btn-success" id="activate" value="APPROVE"/>
                                    <input type="submit" name="approval_status" class="btn btn-danger" id="activate" value="DISAPPROVE"/>
                                </div>
                            <? } ?>
                            <table class="table table-striped table-bordered table-hover" id="dataTables-example" style="width: 100%">
                                <thead>
                                <tr>
                                    <th class="text-center" style="width: 5%">No.</th>
                                    <th class="text-center" style="width: 17%">Staff Info</th>
                                    <th class="text-center" style="width: 10%">Info</th>
                                    <th class="text-center" style="width: 10%">Balance</th>
                                    <th class="text-center" style="width: 10%">Remarks</th>
                                    <th class="text-center" style="width: 20%">HR</th>
                                    <th class="text-center" style="width: 10%">CFO</th>
                                    <th class="text-center" style="width: 10%">CEO</th>
                                    <th class="text-center" style="width: 8%">Action</th>
                                </tr>
                                </thead>
                                <tbody>

                                <?
                                $medical = getMedicalCEOList($staff_id, $department_code, $month , $year, $ceo_approval);
                                $i=1;
                                while($list = $medical->fetch_assoc()) {
                                    //payment status -> OPEN / CLOSED
                                    if (empty($list['payment_closed_at'])){
                                        $payment_text_color = 'RED';
                                        $payment_text_status = 'OPEN';
                                    }else{
                                        $payment_text_color = 'GREEN';
                                        $payment_text_status = 'CLOSED';
                                    }

                                    //CEO status -> PENDING / APPROVED / REJECTED
                                    if (empty($list['ceo_approval_by']) && empty($list['ceo_approval_at'])){
                                        $ceo_text_color = 'GREY';
                                        $ceo_text_status = 'PENDING';
                                    }else{
                                        if ($list['ceo_approval_status'] == '1'){
                                            $ceo_text_color = 'GREEN';
                                            $ceo_text_status = 'APPROVED';
                                        }else{
                                            $ceo_text_color = 'RED';
                                            $ceo_text_status = 'REJECTED';
                                        }
                                    }

                                    ?>
                                    <tr class="staffInfoTable">
                                        <td>
                                            <? if ($ceo_approval == 'NULL'){ ?>
                                                <input name="medical_id[]" type="checkbox" class="checkbox" id="medical_id[]" value="<?php echo $list['id']; ?>" />&nbsp;
                                            <? } ?>
                                            <label for="medical_id[]"><?php echo $i++.'.'; ?></label>
                                        </td>
                                        <td>
                                            <b>Name: </b><? echo $list['name'];?> <br>
                                            <b>Staff no.: </b><? echo $list['no_staff'];?> <br>
                                            <b>Company: </b><? echo $list['department_id'];?> <br>
                                            <b>Department: </b><? echo $list['department_sub'];?> <br>
                                        </td>
                                        <td>
                                            <label class="control-label">Receipt Date:</label><br> <?echo $list['receipt_date'];?><br>
                                            <label class="control-label">Description:</label> <?echo $list['description'];?> <br>
                                            <label class="control-label">Date Applied:</label><br> <?echo $list['created_at'];?><br>
                                        </td>

                                        <td>
                                            <label style="margin-right: 20px" class="control-label">Total Claim: </label>RM<?echo $list['total_claim'];?> <br>
                                            <label style="margin-right: 5px" class="control-label">Balance: </label><br>
                                            <? echo ($list['balance_after_approval'] != '') ? 'RM'.$list['balance_after_approval'] : '<i style="font-size: 12px" class="text-muted">- Pending -</i>';?>
                                        </td>

                                        <td><? echo $list['remark'];?></td>

                                        <td class="text-center">
                                            <p class="app-status text-white" style="background-color: green;">VERIFIED</p>
                                            <? echo getStaffName($list['hr_verify_by']).'<br>'; ?>
                                            <? echo $list['hr_verify_at'];?><br>
                                            <p class="app-status text-white" style="background-color:<?php echo $payment_text_color?>;"><?php echo $payment_text_status ?></p>
                                            <? echo ($list['payment_closed_at'] != '') ? getStaffName($list['payment_closed_by']).'<br>'.$list['payment_closed_at'] : ''; ?>
                                        </td>

                                        <td class="text-center">
                                            <p class="app-status text-white" style="background-color: green;">VERIFIED</p>
                                            <? echo getStaffName($list['cfo_approval_by']); ?>
                                            <br>
                                            <? echo $list['cfo_approval_at'];?>
                                        </td>

                                        <td class="text-center">
                                            <p class="app-status text-white" style="background-color:<?php echo $ceo_text_color?>;"><?php echo $ceo_text_status ?></p>
                                            <? echo ($list['ceo_approval_status'] != '') ? getStaffName($list['ceo_approval_by']) : ''; ?>
                                            <br>
                                            <? echo $list['ceo_approval_at'];?>
                                        </td>

                                        <td class="text-center">
                                            <div class="dropdown">
                                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuMed" data-toggle="dropdown"
                                                        aria-haspopup="true" aria-expanded="true">
                                                    <i class="fa fa-caret-down"></i>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuMedical" style="margin-left: -50px">
                                                    <li><a style="display: block" href="#medicalAttachment" data-toggle="modal" data-id="<? echo $list['id'] ?>"><i class="fa fa-image opt-icon"></i> Attachment</a></li>
                                                    <li><a style="display: block" target="blank" href="v02_aims_medical_print.php?id=<? echo $list['id'] ?>"><i class="fa fa-print opt-icon"></i> Print</a></li>
                                                    <li><a style="display: block;color:#00a900" href="../controller/v02_aims_medical_approval_exec.php?id=<? echo $list['id'] ?>&action=1&level=3"><i class="fa fa-check opt-icon"></i> Approve</a></li>
                                                    <li><a style="display: block;color:#d60008" href="../controller/v02_aims_medical_approval_exec.php?id=<? echo $list['id'] ?>&action=0&level=3"><i class="fa fa-times opt-icon"></i> Disapprove</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                <?}?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>

<div class="modal fade" id="medicalAttachment" tabindex="-1" role="dialog" aria-labelledby="viewMedicalAttachmentLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="viewMedicalAttachmentLabel">Medical Claim Attachment</h4>
            </div>
            <div class="modal-body" id="viewAttachmentMedical">
                <script type="text/javascript">
                    $('#medicalAttachment').on('show.bs.modal', function (e) {
                        let id = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_medical_attachment.php',
                            data:{id:id, edit:1},
                            success:function(html){
                                $('#viewAttachmentMedical').html(html);
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
            responsive: true
        });

        $('[data-toggle="popover"]').popover();

        // all checkbox checked if select all is checked
        $('#select_all').on('click',function(){
            $('input[class="checkbox"]').prop('checked', this.checked);
        });

        // select all checked if all checkbox checked
        $('.checkbox').on('click',function(){
            $('#select_all').prop('checked',$('.checkbox:checked').length === $('.checkbox').length);
        });
    });
    document.onreadystatechange = function() {
        if (document.readyState !== "complete") {
            document.querySelector(
                "body").style.visibility = "hidden";
            document.querySelector(
                "#loader").style.visibility = "visible";
        } else {
            document.querySelector(
                "#loader").style.display = "none";
            document.querySelector(
                "body").style.visibility = "visible";
        }
    };
</script>
</body>
</html>


