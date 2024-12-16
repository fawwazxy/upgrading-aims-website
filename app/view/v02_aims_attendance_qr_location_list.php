<?php
require "../controller/auth.php";
require "../model/v02_attendance_function.php";

$branch = $_GET['branch'] ?: 'all';
$qr_branch = getQrBranchList();
$qr_list = getQrLocationList($branch);
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
        .d-none{
            display: none;
        }
        .float-right{
            float: right;
        }
        .cancel-link{
            color: #a50001;
            font-weight: bold;
            float: right;
            cursor: pointer;
        }
        .status-pill{
            padding: 4px 12px;
            color: #303030;
            border-radius: 12px;
            font-weight: bold;
        }
        .location-link{
            display: block;
            color: #FFFFFF;
            background: rgb(82,122,139);
            background: linear-gradient(159deg, rgba(29,39,112,0.85) 23%, rgba(55,77,209,0.85) 77%);
            border-radius: 4px;
        }
        .location-link:hover{
            color: #bedaff;
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
                    ATTENDANCE <sub class="version">v02</sub> <i class="fa fa-caret-right"></i> QR LOCATION CONFIGURATION
                    <a href="lokasi_kehadiran.php" class="btn btn-default btn-sm" style="float: right;background-color: #606060;color: #ffffff; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-rotate-left" style="margin-right: 4px"></i>Switch to Version 01
                    </a>
                    <a href="v02_aims_attendance_homepage.php" class="btn btn-default btn-sm" style="float: right;background-color: #FFA500; font-weight: bold;margin: 0 4px 0 4px">
                        <i class="fa fa-arrow-left" style="margin-right: 8px"></i>
                        Back to menu
                    </a>
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label style="font-size: 18px;padding-top: 4px">QR Location list</label>
                        <a href="#addLocation" data-toggle="modal" class="btn btn-primary float-right">New QR Location</a>
                    </div>
                    <div class="panel-body" style="overflow: auto">
                        <form action="" method="get" onchange="this.submit()">
                            <div class="form-group row">
                                <div class="col-md-3">
                                    <select class="form-control" name="branch" id="branch">
                                        <option value="">All branch</option>
                                        <? foreach ($qr_branch as $option){ ?>
                                            <option value="<? echo $option['cawangan_kod'] ?>"
                                                <? if ($option['cawangan_kod'] == $branch) echo 'selected' ?>>
                                                <? echo $option['cawangan_kod'] ?></option>
                                        <? } ?>
                                    </select>
                                </div>
                            </div>
                        </form>

                        <table class="table table-hover" id="location_list">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Branch</th>
                                <th>Name</th>
                                <th class="text-center">Coordinate</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <? $i=1;
                            while ($list = $qr_list->fetch_assoc()){ ?>
                                <tr>
                                    <td><? echo $i++; ?></td>
                                    <td><? echo $list['cawangan_kod']; ?></td>
                                    <td><? echo $list['name']; ?></td>
                                    <td class="text-center">
                                        <a href="https://www.google.com/maps/place/<? echo $list['latitude'].','.$list['longitude']; ?>"
                                           class="status-pill location-link" style="text-decoration: none" target="_blank">
                                            <? echo $list['latitude'].', '.$list['longitude']; ?>
                                            &nbsp;<i class="fa fa-map-marker"></i></a>
                                    </td>
                                    <td class="text-center">
                                        <span class="status-pill" style="background-color: <? echo $list['status'] ? '#9fff76' : '#ffea76' ?>">
                                            <? echo $list['status'] ? 'Active' : 'Not active'; ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuLeave" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="true">
                                                <i class="fa fa-caret-down"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuLeave" style="margin-left: -96px">
                                                <li><a style="display: block" href="#" onClick="popItUp('../template/qrcode_label.php?id=<? echo $list['id']?>')">
                                                        <i class="fa fa-eye opt-icon"></i> Print QR Code Label</a></li>
                                                <li><a style="display: block" href="#updateLocation" data-toggle="modal" data-id="<? echo $list['id'] ?>">
                                                        <i class="fa fa-pencil opt-icon"></i> Update</a></li>
                                                <li><a onclick="confirmDel('../controller/v02_aims_attendance_qr_location_delete_exec.php?id=<? echo $list["id"] ?>')"
                                                       style="display: block; color: #d70000" disabled="" class="disabled"><i class="fa fa-trash opt-icon"></i> Delete</a></li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            <? } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <? include "../global/footer.php"; ?>
    </div>
</div>

<div class="modal fade" id="addLocation" tabindex="-1" role="dialog" aria-labelledby="addLocationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="addLocationModalLabel">Add new QR Location</h4>
            </div>
            <div class="modal-body" id="addLocationModalBody">
                <form action="../controller/v02_aims_attendance_qr_location_add_exec.php" method="post">
                    <div class="form-group row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="cawangan_kod">Branch <span style="color: red; ">*</span></label>
                                <small class="cancel-link" id="cancel-code" style="display: none">Cancel</small>
                                <select class="form-control" id="cawangan_kod" name="branch" style="display: block">
                                    <option value="custom">Other (Please specify branch name)</option>
                                    <option value="" selected>-- Select Branch --</option>
                                    <? foreach ($qr_branch as $option){ ?>
                                        <option value="<? echo $option['cawangan_kod'] ?>"
                                            <? if ($option['cawangan_kod'] == $branch) echo 'selected' ?>>
                                            <? echo $option['cawangan_kod'] ?></option>
                                    <? } ?>
                                </select>
                                <input class="form-control" type="text" id="custom" name="custom" style="display: none"
                                       placeholder="Custom Branch Name">
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="form-group">
                                <label class="control-label" for="name">Name</label>
                                <input class="form-control" type="text" id="name" name="name" value=""
                                       placeholder="AGHSB-MAIN DOOR BLOCK B">
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="status">Status <span style="color: red; ">*</span></label>
                                <select class="form-control" name="status" id="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="latitude">Latitude <span style="color: red; ">*</span></label>
                                <input class="form-control" type="text" id="latitude" name="latitude" value=""
                                       placeholder="5.322749124" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="longitude">Longitude <span style="color: red; ">*</span></label>
                                <input class="form-control" type="text" id="longitude" name="longitude" value=""
                                       placeholder="103.130074254" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-block btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updateLocation" tabindex="-1" role="dialog" aria-labelledby="updateLocationModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="updateLocationModalLabel">Update QR Location</h4>
            </div>
            <div class="modal-body" id="updateLocationModalBody">
                <script type="text/javascript">
                    $('#updateLocation').on('show.bs.modal', function (e) {
                        let id = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'v02_aims_attendance_qr_location_update.php',
                            data:{id:id},
                            success:function(html){
                                $('#updateLocationModalBody').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#location_list').DataTable({
            responsive: false,
            aLengthMenu: [
                [20, 50, 100, -1],
                [20, 50, 100, "All"]
            ],
            order: [1, 'asc'],
            columnDefs: [
                { targets: -1, orderable: false }
            ]
        });

        $('[data-toggle="popover"]').popover();
        $('#cawangan_kod').on('change', function (){
            let codeValue = $(this).val();

            if (codeValue === 'custom'){
                $(this).attr('style', 'display: none');
                $('#custom, #cancel-code').attr('style', 'display: block');
            }
        });

        $('#cancel-code').on('click', function (){
            $('#custom, #cancel-code').attr('style', 'display: none');
            $('#custom, #cawangan_kod').val('');
            $('#cawangan_kod').attr('style', 'display: block');
        });
    });

    function popItUp(url) {
        let newWindow = window.open(url,'name','height=595,width=842');
        if (window.focus) {newWindow.focus()}
        return false;
    }
</script>
</body>
</html>