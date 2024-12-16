<?php
include "../controller/auth.php";
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$sys = getSys(1)->fetch_assoc();

$app_status = ($_GET['app_status']) ?: 'PENDING';
$status_color = [
    'PENDING' => 'grey',
    'APPROVE' => 'green',
    'DISAPPROVE' => 'red'
]
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

        .transport-status{
            padding:5px;
            border-radius: 5px;
            font-weight: bold;
            color:white;
        }
    </style>

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
                <h1 class="page-header">HOD/CEO/CHAIRMAN VIEW</h1>
            </div>
        </div>

        <div class="row" style="margin-top: 8px">
            <div class="col-lg-12">
                <div class="tab">
                    <a href="aims_car_hod_list.php?app_status=PENDING" class="<? if($app_status=="PENDING") echo 'active'?>">PENDING </a>
                    <a href="aims_car_hod_list.php?app_status=APPROVE" class="<? if($app_status=="APPROVE") echo 'active'?>">APPROVED </a>
                    <a href="aims_car_hod_list.php?app_status=DISAPPROVE" class="<? if($app_status=="DISAPPROVE") echo 'active'?>">DISAPPROVED </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <? $data=getCheckboxUpdateCarHOD($id,$_SESSION['SESS_NAME'])?>
                        <form name="frmactive" method="post" action="">
                            <div class="row" style="margin-left: 4px;margin-bottom: 16px">
                                <input type="checkbox" id="select_all">&nbsp;
                                <label for="select_all" style="margin-right: 8px"> Select All</label>

                                <input class="btn btn-success" name="activate" type="submit" id="activate" value="APPROVE" />
                                <input class="btn btn-danger" name="deactivate" type="submit" id="deactivate" value="DISAPPROVE" />
                            </div>
                            <table style="width: 100%;" class="table table-striped table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th style="width: 7%">No.</th>
                                    <th style="width: 30%">Staff Info</th>
                                    <th style="width: 25%" class="text-center">CHAIRMAN/CEO/HOD Status</th>
                                    <th style="width: 25%" class="text-center">Vehicle Approval Status</th>
                                    <th style="width: 13%">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $i=1;
                                $car = getCarRequestHodApproval($_SESSION['SESS_NO_STAFF'], $app_status);

                                /*if($app_status == 'PENDING') {
                                    $car= getcarRequestHodBaharu($_SESSION['SESS_DEPARTMENT_SUB'],$_SESSION['SESS_NAME']);
                                }
                                else if($app_status == 'APPROVE') {
                                    $car= getcarRequestHodLulus($_SESSION['SESS_DEPARTMENT_SUB'],$_SESSION['SESS_NAME']);
                                }
                                else {
                                    $car= getcarRequestHodTLulus($_SESSION['SESS_DEPARTMENT_SUB'],$_SESSION['SESS_NAME']);
                                }*/
                                while($row_data = $car->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td class="text-center">
                                            <input name="checkbox[]" type="checkbox" class="checkbox" id="checkbox[]" value="<?php echo $row_data['id'];?>" >
                                            <label for="checkbox[]"><? echo $i++;?></label>
                                        </td>
                                        <td class="text-left">
                                            <label class="control-label">NAME : </label> <? echo $row_data['name'];?><br>
                                            <label class="control-label">DESIGNATION : </label> <? echo $row_data['jawatan'];?><br>
                                        </td>
                                        <td class="text-center">
                                            <span style="background-color: <? echo $status_color[$row_data['sbu_hod_app']] ?>" class="transport-status"><? echo $row_data['sbu_hod_app'] ?></span>
                                        </td>
                                        <td class="text-center">
                                            <span style="background-color: <? echo $status_color[$row_data['app_status']] ?>" class="transport-status"><? echo $row_data['app_status'] ?></span>
                                        </td>
                                        <td class="text-center">
                                            <a href="#myModal1" class="btn btn-info" data-toggle="modal" data-id="<?php echo $row_data['id']?>"><i class='fa fa-edit'></i></a>
                                            <a href="#myModal2" class="btn btn-success" title="Vehicle Request Info" data-toggle="modal" data-id="<?php echo $row_data['id']?>"><i class='fa fa-info-circle'></i></a>
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
    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Update</h4>
                </div>
                <div class="modal-body" id="demo">
                    <script type="text/javascript">
                        $('#myModal1').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'GET',
                                url:'aims_car_hodstatus_update.php',
                                data:'id='+rowid,
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
                    <h4 class="modal-title" id="myModalLabel2">Request Info</h4>
                </div>
                <div class="modal-body" id="demo2">
                    <script type="text/javascript">
                        $('#myModal2').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'aims_car_staffInfo.php',
                                data:'id='+rowid,
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


    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
            $("#department_name").change(function(){
                var selected_department=$(this).val();
                sendType(selected_department);
            });

        });
        function sendType(type)
        {
            window.location.href="aims_hod_list.php?department_name="+type;

        }
    </script>
</body>
</html>