<?php
include "../controller/auth.php";
require "../model/aims_car_function.php";
require "../model/lookup.php";

$car_model=($_GET['car_model']) ?: 'NONE';
$year=($_GET['year']) ?: date('Y');
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

<!--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bullframe.css">-->
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 5px;
            font-size:12px;

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
                <h1 class="page-header">Vehicle Maintenance</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <select  required class="form-control" name="car_model" id="car_model">
                    <option value="">-- Choose Vehicle--</option>
                    <? echo getDropDown("aims_car_info","car_model","car_model",$car_model);?>
                </select>
            </div>
            <div class="col-lg-2">
                <select  required class="form-control" name="year" id="year" value="<?echo $year?>">
                    <option value="">-- Choose Year--</option>
                    <? echo getDropDownYear($year);?>
                </select>
            </div>
            <div class="col-lg-4">
                <a class="btn btn-info" href="aims_maintenance_report.php?car_model=<? echo $car_model ?>&year=<? echo $year ?>">
                    <i class="fa fa-print"></i> Print</a>
            </div>
            <div class="col-lg-2">
                <a class="btn btn-primary" href="aims_car_add_maintenance.php">
                    <i class="fa fa-plus"></i> Add new maintenance</a>
            </div>
        </div>

        <?
        $car_model = $_GET['car_model'];
        $model = getcarByModel($car_model)->fetch_assoc();
        ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="bf-container">
                    <div class="panel-body">
                        <table>
                            <tr>
                                <td colspan="2" style="text-align:center">
                                    <b>ASSET OF COMPANY</b>
                                    <br> <b> COMPANY NAME : </b><? echo $model['description'];?></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align:center"><b>DETAILS OF ASSET</b></td>
                            </tr>
                            <tr>
                                <td style="width: 50%"><b>Category : </b> <? echo $model['car_category'];?></td>
                                <td style="width: 50%"><b>Cost and Date Of Receipt : </b> <? echo $model['cost_receipt'];?> (<? echo $model['date_receipt'];?>)</td>
                            </tr>
                            <tr>
                                <td><b>Type : </b> <? echo $model['car_type'];?></td>
                                <td><b>Registration No : </b> <? echo $model['car_plate_no'];?></td>
                            </tr>
                            <tr>
                                <td><b>Brand or Model : </b> <? echo $model['car_model'];?></td>
                                <td><b>Suppliers : </b> <? echo $model['suppliers'];?></td>
                            </tr>
                            <tr>
                                <td><b>Type & Engine No : </b> <? echo $model['engine_no'];?></td>
                                <td><b>Hire Purchases Account No : </b> <? echo $model['hire_account_no'];?> (<? echo $model['name_account'];?>)</td>
                            </tr>
                            <tr>
                                <td><b>Chassis No : </b> <? echo $model['chassis_no'];?></td>
                                <td><b>The Original Colour : </b> <? echo $model['color'];?></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="bf-container">
                    <div class="bf-table-responsive bf-table-responsive--zebra">
                        <table class="bf-table" id="sum_table">
                            <tr>
                                <td colspan="15" style="text-align:center"><b>PARTICULARS OF ASSETS MAINTENANCE</b></td>
                            </tr>
                            <tr>
                                <td colspan="7"><b>TYPE, BRAND AND MODEL : <? echo $model['car_model'];?></b></td>
                                <td colspan="8"><b>REGISTRATION NO : </b> <? echo $model['car_plate_no'];?></td>
                            </tr>
                            <tr>
                                <td rowspan="2">DATE INSPECTION ISSUE</td>
                                <!-- <td rowspan="2">ISSUE IDENTIFIED DURING INSPECTION</td> -->
                                <td rowspan="2">KILOMETRE READING (KM)</td>
                                <td rowspan="2">ACTUAL KILOMETRE SERVICE (KM)</td>
                                <td rowspan="2">DATE</td>
                                <td colspan="2">SERVICE DETAIL</td>
                                <td colspan="3">PLACE OF SERVICE/REPAIRS</td>
                                <td rowspan="2">ISSUE IDENTIFIED DURING INSPECTION</td>
                                <td rowspan="2">DURATION PERIOD</td>
                                <td rowspan="2">STATUS ACTION</td>
                                <td rowspan="2">ACTION</td>
                            </tr>

                            <tr>
                                <td>JOB DESCRIPTION</td>
                                <td>ITEM DESCRIPTION</td>
                                <td>SUPPLIER</td>
                                <td>COSTING</td>
                                <td>INVOICE</td>
                            </tr>
                            <?
                            $OPEN = 'OPEN';
                            $CLOSED = 'CLOSED';
                            $car1 = getcarByinspec($car_model,$year);
                            $i=1;
                            while($listinspec = $car1->fetch_assoc()) {
                                ?>


                                <tr>
                                    <td rowspan="2"><? echo $listinspec['dep_date']; ?></td>
                                    <td rowspan="2"><? echo $listinspec['km_read']; ?></td>
                                    <td rowspan="2"><? echo $listinspec['odom_read'];?></td>
                                    <td rowspan="2"><? echo $listinspec['date'];?></td>
                                    <td rowspan="2"><? echo $listinspec['job_desc'];?></td>
                                    <td rowspan="2"><? echo $listinspec['item_desc'];?></td>
                                    <td rowspan="2"><? echo $listinspec['place_service'];?></td>
                                    <td rowspan="2" id="loop"><? echo number_format($listinspec['costing'],2);?></td>
                                    <td rowspan="2"><? echo $listinspec['invoice_no'];?></td>
                                    <td rowspan="2"><? echo $listinspec['issue'];?></td>
                                    <td rowspan="2"><? echo $listinspec['duration'];?></td>
                                    <td>
                                        <? if ($listinspec['status_1'] == 'OPEN') {?>
                                            <a href="../controller/aims_car_status1_exec.php?id=<? echo $listinspec['id'];?>&status_1=<?echo $CLOSED;?>"><button class="btn btn-warning" type="button" onclick="return Confirm()" >OPEN</button></a>
                                        <?}?>
                                        <? if ($listinspec['status_1'] == 'CLOSED') {?>
                                            <a href="../controller/aims_car_status1_exec.php?id=<? echo $listinspec['id'];?>&status_1=<?echo $OPEN;?>"><button class="btn btn-danger" type="button" onclick="return Confirm()" >CLOSED</button></a>
                                        <?}?>
                                    </td>
                                    <td rowspan="2" style="text-align:center">
                                        <?php echo "<a href='#myModal1' data-toggle='modal' data-id=".$listinspec['id']." data-car=".$listinspec['car_id']." ><i class='fa fa-edit'></i></a>"; ?>
                                        <?php /*echo "<a href='#myModal1' data-toggle='modal' data-id=".$listinspec['id']." data-status=".$listinspec['status']." data-car=".$listinspec['car_id']." data-main=".$listinspec['main_id']." ><i class='fa fa-edit'></i></a>"; */?>
                                        <a href="../controller/aims_carMaintanence_delete_exec.php?id=<? echo $listinspec['id']; ?>" onclick="return confirm('Are you sure you want to delete?');"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <!-- <td><?// echo $listinspec['interior_car'];?></td> -->
                                    <td>
                                        <? if ($listinspec['status_2'] == 'OPEN') {?>
                                            <a href="../controller/aims_car_status2_exec.php?id=<? echo $listinspec['id'];?>&status_2=<?echo $CLOSED;?>"><button class="btn btn-warning" type="button" onclick="return Confirm()" >OPEN</button></a>
                                        <?}?>
                                        <? if ($listinspec['status_2'] == 'CLOSED') {?>
                                            <a href="../controller/aims_car_status2_exec.php?id=<? echo $listinspec['id'];?>&status_2=<?echo $OPEN;?>"><button class="btn btn-danger" type="button" onclick="return Confirm()" >CLOSED</button></a>
                                        <?}?>
                                    </td>
                                </tr>
                            <?}?>
                            <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td id="total"></td>
                                <td ></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>
        <!--
                 /#page-wrapper -->
    </div>
</div>



<!-- Page-Level Demo Scripts - Tables - Use for reference -->

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
                        var id = $(e.relatedTarget).data('id');
                        var car_id = $(e.relatedTarget).data('car');
                        $.ajax({
                            type:'POST',
                            url:'aims_car_maintenance_update.php',
                            data:{id:id,car_id:car_id},
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


<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
        $("#car_model").change(function(){
            var selected_cawangan=$(this).val();
            sendType(selected_cawangan);
        });

        $("#year").change(function(){
            if($("#car_model").val()=='' ){
                alert('SELECT CAR MODEL!')
                $("#year").val('');
            }else{
                var selected_year=$(this).val();
                var selected_car_model = $("#car_model").val();
                reloadYear(selected_year,selected_car_model);

            }
        });

    });

    function sendType(type)
    {
        window.location.href="aims_car_maintenance.php?car_model="+type;

    }

    function reloadYear(selected_year,selected_car_model){
        //console.log(obj);
        location.href = "aims_car_maintenance.php?car_model="+selected_car_model+"&year="+selected_year;
    }
    $(document).ready(function(){



    });

</script>

<script type="text/javascript">
    $(function() {

        var TotalValue = 0;

        $("tr #loop").each(function(index,value){
            currentRow = parseFloat($(this).text());
            TotalValue += currentRow
        });

        document.getElementById('total').innerHTML = "RM" + TotalValue;

    });
</script>


</body>

</html>