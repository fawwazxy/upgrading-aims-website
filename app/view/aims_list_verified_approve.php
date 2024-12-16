<?php

include ('../controller/auth.php');

require "../model/aims_inout_function.php";

$id = $_GET['id'];

$no_staff = $_SESSION['SESS_NO_STAFF'];
$sys = getSys(1)-> fetch_assoc();
$verified_name = $_SESSION['SESS_NAME'];
$verified = ($_GET['verified']) ?: 'PENDING';

$status_color = ['PENDING' => 'grey', 'APPROVE' => 'green', 'DISAPPROVE' => 'red'];
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
        });
    </script>
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
                <h1 class="page-header"> IN OUT VERIFICATION </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label style="margin-right: 8px">Verified</label>
                        <a style="margin: 0 8px" href="aims_list_verified_approve.php?verified=PENDING">New</a> |
                        <a style="margin: 0 8px" href="aims_list_verified_approve.php?verified=APPROVE">Approved</a> |
                        <a style="margin: 0 8px" href="aims_list_verified_approve.php?verified=DISAPPROVE">Disapproved</a>

                    </div>
                    <div class="panel-body">

                        <input type="checkbox" id="select_all" /><label for="select_all" style="margin-left: 8px;"> Select All</label>

                        <? $data=getCheckboxVerify($id,$_SESSION['SESS_NAME'])?>
                        <form name="frmactive" method="post" action="">
                            <table>
                                <tr>
                                    <td colspan="5"><input class="btn btn-success" name="activate" type="submit" id="activate" value="Verify" />
                                        <input class="btn btn-danger" name="deactivate" type="submit" id="deactivate" value="Disapprove" />
                                    </td>
                            </table><br>

                            <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                            <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>

                                    <th style="width: 5%">No.</th>
                                    <th style="width: 30%">Staff Info</th>
                                    <th style="width: 30%">In Out Info</th>
                                    <th style="width: 20%">Verified</th>
                                    <th style="width: 15%">Action</th>

                                </tr>
                                </thead>
                                <tbody>

                                <?
                                if($_SESSION['SESS_DEPARTMENT_SUB'] == 'MOORING-GANG'){?>
                                    <script type="text/javascript">
                                        window.location.href='../view/aims_inout_specialmessage.php';
                                    </script>
                                <?}

                                $in_out_list = getInOutSupportList($_SESSION['SESS_NO_STAFF'], $verified);
                                /*if($verified == 'PENDING') {
                                    $password= getaims_verified_approvelisitbaharu($_SESSION['SESS_DEPARTMENT_SUB'],$_SESSION['SESS_NAME']);
                                }
                                else if($verified == 'APPROVE') {
                                    $password= getaims_verified_approvelisitlulus($_SESSION['SESS_DEPARTMENT_SUB'],$_SESSION['SESS_NAME']);
                                }
                                else {
                                    $password= getaims_verified_approvelisittidaklulus($_SESSION['SESS_DEPARTMENT_SUB'],$_SESSION['SESS_NAME']);
                                }*/
                                $i= 1;
                                while($row_data = $in_out_list->fetch_assoc()){ ?>

                                    <tr class="odd gradeX">
                                        <td>
                                            <label for="checkbox[]"><? echo $i++; ?></label>
                                            <input name="checkbox[]" type="checkbox" class="checkbox" id="checkbox[]" value="<?php echo $row_data['id']; ?>" >
                                        </td>

                                        <td>
                                            <label class="control-label">Nama :<?php echo $row_data['name']; ?></label><br>
                                            <label class="control-label">Ic :<?php echo $row_data['noic']; ?></label><br>
                                            <label class="control-label">Department :<?php echo $row_data['department_sub']; ?></label><br>
                                            <label class="control-label">Company :<?php echo $row_data['department_id']; ?></label>
                                        </td>

                                        <td>
                                            <label class="control-label">Date :<?php echo $row_data['date_mohon']; ?></label><br>
                                            <label class="control-label">Description :<?php echo $row_data['description']; ?></label><br>
                                            <label class="control-label">Time Out :<?php echo $row_data['time_out']; ?></label><br>
                                            <label class="control-label">Time In :<?php echo $row_data['time_in']; ?></label>

                                        </td>

                                        <td>
                                            <b style="color: <? echo $status_color[$row_data['verified']]; ?>"><? echo $row_data['verified'] ?></b>
                                            <p><? echo $row_data['verified_name'];?></p>
                                        </td>

                                        <td>

                                            <?
                                            if (in_array($row_data['verified'], ['PENDING', 'DISAPPROVE'])) { ?>
                                                <a href="../controller/hantar_buttonverified_exec.php?aims_inout_id=<? echo $row_data['id'];?>&verified_name=<?echo $verified_name;?>" class="btn btn-success" onclick="return Confirm()">VERIFY</a>

                                            <?  }
                                            if (in_array($row_data['verified'], ['PENDING', 'APPROVE'])) { ?>
                                                <a style="margin-top: 8px" href="../controller/hantar_buttonverified1_exec.php?aims_inout_id=<? echo $row_data['id'];?>&verified_name=<?echo $verified_name;?>" class="btn btn-danger" onclick="return Confirm()">DISAPPROVE</a>
                                            <?  }

                                            if ($row_data['images'] != '') { ?>
                                                <a href="#myModal3" data-toggle="modal" data-id="<? echo $row_data['id'];?>" style="margin-top: 8px" class="btn btn-info">SHOW ATTACHMENT</a>
                                            <? } ?>
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

    <!--Modal for Show Attachment    -->
    <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body" id="demo3">
                <script type="text/javascript">
                    $('#myModal3').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'aims_inout_lampiran.php',
                            data:{id:rowid},
                            success:function(html){
                                $('#demo3').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>
</body>
</html>