<?php
include "../controller/auth.php";
require "../model/v02_aims_medical_analysis_function.php";
require "../model/lookup.php";
date_default_timezone_set("Asia/Kuala_lumpur");

$no_staff = $_SESSION['SESS_NO_STAFF'];
$code_department = $_SESSION['SESS_DEPARTMENT'];

$year = ($_GET['year'])?: date('Y');
$month = ($_GET['month'])?: '';
$code = ($_GET['code'])?: '0';

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

    <style type="text/css">
        .tab {
            overflow: hidden;
            border: 1px solid #ccc;
            background-color: #EEEEEE;
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
            background-color: rgba(150,211,255,0.5);
        }

        .text-muted{
            font-style: italic !important;
        }
    </style>
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
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    MEDICAL CLAIM <i class="fa fa-caret-right"></i> ANALYSIS REPORT <? echo $year; ?>

                </h1>
            </div>
        </div>
        <div class="row">
            <form method="get" action="">
                <input type="hidden" value="<? echo $code?>" name="code">
                <div class="col-md-2">
                    <select class="form-control" id="year" name="year" required>
                        <?echo getDropdownYear($year) ?>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-control" id="month" name="month" required>
                        <?echo getDropDownMonth($month) ?>
                    </select>
                </div>
                <div class="col-md-8">
                    <button type="submit" class="btn btn-primary" id="filterBtn">Search</button>
                </div>
            </form>
        </div>
        <div class="row" style="margin-top: 8px">
            <div class="col-lg-12">
                <div class="tab">
                    <div class="panel-heading text-center">
                        <label>MEDICAL CLAIM LIST</label>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="tab">
                    <a class="tabLinks <? if($code == "0") echo 'active'?>" href="v02_aims_medical_analysis_yearly_list.php?year=<? echo $year; ?>&month=<? echo $month; ?>&code=0">ALL</a>
                    <? $company = getCompanyCode();
                    while($row = $company->fetch_assoc()) { ?>
                            <a class="tabLinks <? if($row['code_department'] == $code) echo 'active'?>"
                               href="v02_aims_medical_analysis_yearly_list.php?year=<? echo $year; ?>&month=<? echo $month; ?>&code=<? echo $row['code_department']; ?>">
                                <? echo $row['code_department']?>
                            </a>
                    <? } ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body" style="overflow: auto">
                        <table class="table table-hover table-bordered" id="medical_claim_analysis">
                            <thead>
                            <tr>
                                <th style="width: 6%" class="text-center">No.</th>
                                <th style="width: 19%" class="text-center">Staff Info</th>
                                <th style="width: 19%" class="text-center">Medical Claim Info</th>
                                <th style="width: 10%" class="text-center">Amount (RM)</th>
                                <th style="width: 7%" class="text-center">Attachment</th>
                                <th style="width: 15%" class="text-center">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                                $i=1;
                                $medical_list = getMedicalList($year, $month, $code);
                                while($medical = $medical_list->fetch_assoc()){

                                    if ($medical['hr_verify_status'] == '1') {
                                        $status = "APPROVED";
                                        $status_colour = "green";
                                    } else if (($medical['hr_verify_status'] == '0')){
                                        $status = "REJECT";
                                        $status_colour = "red";
                                    } else{
                                        $status = "PENDING";
                                        $status_colour = "blue";
                                    }
                                ?>
                            <tr>
                                <td class="text-center"><? echo $i++;?></td>
                                <td>
                                    <p><b><? echo $medical['name'];?></b></p>
                                    <small><? echo $medical['department_id']?></small>
                                    <small>(<? echo $medical['department_sub']?>)</small>

                                </td>
                                <td>
                                    <p><b>Applied on: </b><? echo $medical['created_at'];?></p>
                                    <p><b>Description: </b><? echo ucfirst($medical['description']);?></p>
                                </td>
                                <td class="text-center">
                                    <b><? echo $medical['total_claim'];?></b><br>
                                </td>
                                <td class="text-center">
                                    <? if ($medical['document_name'] != '') {?>
                                        <a class="btn btn-warning" href="#medicalAttachment" data-toggle="modal" data-id="<? echo $medical['id'];?>"
                                           title="View Attachment"><i class="fa fa-image opt-icon"></i></a>
                                    <? } else {
                                        echo "<p class='text-muted'>No Attachment</p>";
                                    } ?>
                                </td>
                                <td class="text-center">
                                    <p><b><span style="background-color: <? echo $status_colour;?>; padding:5px; border-radius:5px; font-weight:bold; color:white">
                                    <? echo $status;?></span></b></p>
                                    <?
                                        if (!empty($medical['payment_closed_at'])){
                                            $payment_closed_at = date('d/m/Y', strtotime($medical['payment_closed_at']));
                                            echo "<p class='text-muted'>CLOSED AT ".$payment_closed_at."</p>";
                                        }else
                                            echo "";

                                    ?>
                                </td>
                            </tr>
                            <? } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <br>
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
        $('#medical_claim_analysis').DataTable({
            responsive: false,
            aLengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, "All"]
            ],
            order: [0, 'asc'],
            columnDefs: [
                { targets: -1, orderable: false }
            ]
        });

        $('[data-toggle="popover"]').popover();
    });
</script>
</body>
</html>