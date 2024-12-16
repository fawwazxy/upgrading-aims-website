<?php
require "../controller/auth.php";
require "../model/aims_car_function.php";
require "../model/lookup.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <?
    require "../global/header.php";
    include "../custom-css/transport-module.php";
    ?>
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
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
        <div class="row" style="padding-top: 16px">
            <div class="col-md-12">
                <?
                $flagScreen="tab_1";
                include "../global/menu_car_admin.php";
                ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header" style="margin-top: 16px">Vehicle List</h1>
            </div>
        </div>

        <table style="width: 100%;margin: 16px 0; border: 1px solid black">
            <thead class="bg-black">
            <tr>
                <th class="text-center" style="width: 30%;">Total Vehicle</th>
                <th class="text-center" style="width: 20%;">Vehicle In Use</th>
                <th class="text-center" style="width: 30%;">Vehicle available</th>
                <th class="text-center" style="width: 20%;">Pending request</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td class="text-center" style="font-size: 32px"><? echo getTotalCar(); ?></td>
                <td class="text-center" style="font-size: 32px"><? echo getTotalCarByStatus(0);?></td>
                <td class="text-center" style="font-size: 32px"><? echo getTotalCarByStatus(1);?></td>
                <td class="text-center" style="font-size: 32px"><? echo getTotalCarSubmitted(0);?></td>
            </tr>
            </tbody>
        </table>

        <div class="form-group text-right">
            <button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Add New</button>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel-body">
                    <div class="row">
                        <?
                        $car = getcarList();
                        while($list_car = $car->fetch_assoc()) { ?>
                            <div class="col-sm-3">
                                <div class="car-card">
                                    <?if($list_car['document_name'] != '' && in_array($list_car['document_type'], ['jpg', 'png', 'gif'])) {
                                        echo '<img src="data:image/jpeg;base64,'.base64_encode( $list_car['document'] ).'" alt="car-image"/>';
                                    }else{
                                        echo '<img src="../car_photo/default-car-image.png" alt="car-default"/>';
                                    }?>
                                    <div class="car-container">
                                        <h4><b><? echo $list_car['car_model'] ?></b></h4>
                                        <h4><? echo $list_car['car_plate_no'] ?></h4>
                                        <a href="#myModal1" class="btn btn-info" data-toggle='modal' data-id="<? echo $list_car['id'] ?>">Edit</a>
                                        <a href="#myModal2" class="btn btn-success" data-toggle='modal' data-id="<? echo $list_car['id'] ?>">Info</a>
                                        <a class="btn btn-sm btn-danger" onclick="confirmDel('../controller/aims_car_delete_exec.php?id=<? echo $list_car["id"] ?>')">
                                            <i class="fa fa-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                        <?}?>
                    </div>
                </div>
            </div>
        </div>
        <? include "../global/footer.php";?>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4>Add new car info</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="../controller/aims_car_add_exec.php" enctype="multipart/form-data">
                    <div class="form-group">
                        <label style="color: red">* Required</label>
                        <br>
                        <div class="form-group row">
                            <div class="col-xs-8">
                                <label for="document">Attachment&nbsp;<span style="color: red"><i>(Only jpg/png format file are allowed)</i></span></label>
                                <input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                                <input type="file" accept=".jpg,.png" name="document" id="document">
                            </div>
                        </div>

                        <h6>VEHICLE PROFILE</h6>
                        <div class="form-group row">
                            <div class="col-xs-6">
                                <label for="car_model">MODEL&nbsp;<span style="color: red">*</span></label>
                                <input class="form-control" placeholder="" name="car_model" id="car_model" value="" required>
                            </div>

                            <div class="col-xs-6">
                                <label for="car_owner">OWNER&nbsp;<span style="color: red">*</span></label>
                                <select class="form-control" name="car_owner" id="car_owner" required>
                                    <option value="">-- Choose Owner --</option>
                                    <? echo getDropDownCompany2("");?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-xs-4">
                                <label for="car_type">TYPE OF CAR&nbsp;<span style="color: red">*</span></label>
                                <input class="form-control" placeholder="" name="car_type" id="car_type" value="">
                            </div>
                            <div class="col-xs-4">
                                <label for="car_plate_no">PLATE NO&nbsp;<span style="color: red">*</span></label>
                                <input class="form-control" placeholder="" name="car_plate_no" id="car_plate_no" value="" required>
                            </div>
                            <div class="col-xs-4">
                                <label for="color">COLOR&nbsp;<span style="color: red">*</span></label>
                                <input class="form-control" placeholder="" name="color" id="color" value="">
                            </div>
                        </div>

                        <h6>PERSON IN CHARGE</h6>
                        <div class="form-group row">
                            <div class="col-xs-6">
                                <label for="car_pic">PIC 1&nbsp;<span style="color: red">*</span></label>
                                <input class="form-control" list="pic1" id="car_pic" name="car_pic" value=""/>
                                <datalist id="pic1">
                                    <option value="">-- Choose Name --</option>
                                    <? echo getdropdownstaff("")?>
                                </datalist>
                            </div>
                            <div class="col-xs-6">
                                <label for="car_pic2">PIC 2&nbsp;<span style="color: red">*</span></label>
                                <input class="form-control" list="pic3" id="car_pic2" name="car_pic2" value=""/>
                                <datalist id="pic3">
                                    <option value="">-- Choose Name --</option>
                                    <? echo getdropdownstaff("")?>
                                </datalist>
                            </div>
                        </div>

                        <h6>VEHICLE INFORMATION</h6>
                        <div class="form-group row">
                            <div class="col-xs-6">
                                <label for="engine_no">ENGINE NO&nbsp;<span style="color: red">*</span></label>
                                <input class="form-control" placeholder="" name="engine_no" id="engine_no" value="">
                            </div>

                            <div class="col-xs-6">
                                <label for="chassis_no">CHASSIS NO&nbsp;<span style="color: red">*</span></label>
                                <input class="form-control" placeholder="" name="chassis_no" id="chassis_no" value="" >
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-xs-3">
                                <label for="cost_receipt">RECEIPT COST&nbsp;<span style="color: red">*</span></label>
                                <input class="form-control" placeholder=" " name="cost_receipt" id="cost_receipt" value="">
                            </div>
                            <div class="col-xs-3">
                                <label for="date_receipt">RECEIPT DATE&nbsp;<span style="color: red">*</span></label>
                                <input type="date" class="form-control" placeholder="" name="date_receipt" id="date_receipt" value="">
                            </div>
                            <div class="col-xs-6">
                                <label for="suppliers">SUPPLIERS&nbsp;<span style="color: red">*</span></label>
                                <input class="form-control" placeholder="" name="suppliers" id="suppliers" value="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-xs-6">
                                <label for="hire_account_no">HIRE ACCOUNT NO&nbsp;<span style="color: red">*</span></label>
                                <input class="form-control" placeholder="" name="hire_account_no" id="hire_account_no" value="">
                            </div>

                            <div class="col-xs-6">
                                <label for="name_account">ACCOUNT NAME&nbsp;<span style="color: red">*</span></label>
                                <input class="form-control" placeholder="" name="name_account" id="name_account" value="">
                            </div>
                        </div>

                        <h6>SERVICE INFORMATION</h6>

                        <div class="form-group row">
                            <div class="col-xs-6">
                                <label for="last_service">LAST SERVICE&nbsp;<span style="color: red">*</span></label>
                                <input class="form-control" type="date" name="last_service" id="last_service" value="">
                            </div>

                            <div class="col-xs-6">
                                <label for="next_service">NEXT SERVICE&nbsp;<span style="color: red">*</span></label>
                                <input class="form-control" type="date" name="next_service" id="next_service" value="">
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-xs-6">
                                <label for="current_mileage">CURRENT MILEAGE&nbsp;<span style="color: red">*</span></label>
                                <input class="form-control" placeholder="" name="current_mileage" id="current_mileage" value="" onkeypress="return isNumberKey(event)">
                            </div>

                            <div class="col-xs-6">
                                <label for="next_mileage_service">NEXT MILEAGE SERVICE&nbsp;<span style="color: red">*</span></label>
                                <input class="form-control" placeholder="" name="next_mileage_service" id="next_mileage_service" value="" onkeypress="return isNumberKey(event)">
                            </div>
                        </div>

                        <h6>ROADTAX</h6>

                        <div class="form-group row">
                            <div class="col-xs-6">
                                <label for="date_ex_rtx">DATE EXPIRED (RM)&nbsp;<span style="color: red">*</span></label>
                                <input class="form-control" type="date" name="date_ex_rtx" id="date_ex_rtx" value="">
                            </div>

                            <div class="col-xs-6">
                                <label for="value_rtx">VALUE (RM)&nbsp;<span style="color: red">*</span></label>
                                <input class="form-control number" type="text" name="value_rtx" id="value_rtx" value="" onkeypress="return isNumberKey(event)">
                            </div>
                        </div>

                        <h6>INSURANCE PASSENGER</h6>

                        <div class="form-group row">
                            <div class="col-xs-4">
                                <label for="date_ex_ins">DATE EXPIRED&nbsp;<span style="color: red">*</span></label>
                                <input class="form-control" type="date" name="date_ex_ins" id="date_ex_ins" value="">
                            </div>
                            <div class="col-xs-4">
                                <label for="value_ins">VALUE (INSURANCE)&nbsp;<span style="color: red">*</span></label>
                                <input class="form-control number" type="text" name="value_ins" id="value_ins" value="" onkeypress="return isNumberKey(event)">
                            </div>
                            <div class="col-xs-4">
                                <label for="type_ins">TYPE OF INSURANCE&nbsp;<span style="color: red">*</span></label>
                                <select name="type_ins" id="type_ins" class="form-control">
                                    <option value="PLATINUM">PLATINUM</option>
                                    <option value="PREMIUM">PREMIMUM</option>
                                    <option value="GOLD">GOLD</option>
                                </select>
                            </div>
                        </div>

                        <h6>INSURANCE PRIVATE</h6>

                        <div class="form-group row">
                            <div class="col-xs-4">
                                <label for="date_ex_priv">DATE EXPIRED&nbsp;<span style="color: red">*</span></label>
                                <input class="form-control" type="date" name="date_ex_priv" id="date_ex_priv" value="">
                            </div>
                            <div class="col-xs-4">
                                <label for="value_priv">VALUE (INSURANCE)&nbsp;<span style="color: red">*</span></label>
                                <input class="form-control" type="text" name="value_priv" id="value_priv" value="" onkeypress="return isNumberKey(event)">
                            </div>
                            <div class="col-xs-4">
                                <label for="sum_priv">SUM COVERED&nbsp;<span style="color: red">*</span></label>
                                <input class="form-control" type="text" name="sum_priv" id="sum_priv" value="">
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="reset" class="btn btn-info">Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Page-Level Demo Scripts - Tables - Use for reference -->

<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" >&times;</button>
                <h4>Update car info</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var id = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'GET',
                            url:'aims_car_update.php',
                            data:{id:id},
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
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" >&times;</button>
                <h4>View car info</h4>
            </div>
            <div class="modal-body" id="demo2">
                <script type="text/javascript">
                    $('#myModal2').on('show.bs.modal', function (e) {
                        var id = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'GET',
                            url:'aims_car_info.php',
                            data:{id:id},
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

        $('#number').bind("cut copy paste drag drop", function(e) {
            e.preventDefault();
        });
    });
    function isNumberKey(evt) {
        const charCode = (evt.which) ? evt.which : evt.keyCode;
        return !(charCode !== 46 && charCode > 31 && (charCode < 48 || charCode > 57));
    }

    function confirmDel(url){
        if (confirm('Confirm delete car? This action cannot be undone.')){
            window.location.href = url;
        }
        return false;
    }
</script>
</body>
</html>