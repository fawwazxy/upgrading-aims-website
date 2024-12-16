<?php
include ('../controller/auth.php');
require "../model/aims_gl_function.php";
require "../model/lookup.php";

if(in_array($_SESSION['SESS_NOKP'],['920529115513','950728035572','940718115430'])){ // zuhdi, syuhada, syamimy
    echo "<script type='text/javascript'>
            window.location.href='../view/aims_gl_admin.php';
            </script>";
    exit();
}

$month = ($_GET['month']) ?: '0';
$year = ($_GET['year']) ?: date('Y');
$sys = getSys(1)->fetch_assoc();
$utility = getSummaryWbilByMonth($month,$year)->fetch_assoc();
$elec = getSummaryEbilByMonth($month,$year)->fetch_assoc();
$coway = getSummaryCowayByMonth($month,$year)->fetch_assoc();
$transport = getSummaryTransportByMonth($month,$year)->fetch_assoc();
$beverage_expenses = getSummarySugarByMonth($month,$year)->fetch_assoc();
$dobby_expenses = getSummaryDobbyByMonth($_SESSION['SESS_NAME'],$month,$year)->fetch_assoc();
$housekeeping_expenses = getSummaryHousekeepingByMonth($month,$year)->fetch_assoc();

$sugar_total = number_format($beverage_expenses['sugar']*0.4, 2);
$tea_total = number_format($beverage_expenses['tea']*0.4, 2);
$creamer_total = number_format($beverage_expenses['creamer']*0.4, 2);
$soap_total = number_format($beverage_expenses['soap']*0.7, 2);
$shampoo_total = number_format($beverage_expenses['shampoo']*1.0, 2);
$water_total = number_format($beverage_expenses['water']*1.0, 2);

$water_bill = number_format(1*$utility['wbil'], 2);
$elec_bill = number_format(1*$elec['ebil'], 2);
$coway_bill = number_format(1*$coway['coway'], 2);
$transport_bill = number_format(1*$transport['transport'], 2);

$final_total = array_sum([
    $dobby_expenses['amount'],
    $sugar_total,
    $tea_total,
    $creamer_total,
    $soap_total,
    $shampoo_total,
    $water_total,
    $utility['wbil'],
    $elec['ebil'],
    $coway['coway'],
    $transport['transport'],
    $housekeeping_expenses['total']
]);

$month_array = ['1' => 'JANUARY', '2' => 'FEBRUARY', '3' => 'MARCH', '4' => 'APRIL', '5' => 'MAY', '6' => 'JUNE', '7'=> 'JULY','8' => 'AUGUST', '9' => 'SEPTEMBER', '10' => 'OCTOBER', '11' => 'NOVEMBER', '12' => 'DECEMBER'];
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
        body {
            font-family: "Arial", serif;
            font-size: 12px;
            color: black;
        }
        th, td {
            text-align: center;
        }
        input,select {
            border: hidden;
        }
        @media print {
            #month, #year, #label, #btn-Preview-Image{
                display: none;
            }
        }
        .table.table-borderless, .table.table-borderless th, .table.table-borderless td {
            border: none;
        }
    </style>
</head>
<body>
<div id="wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h4 class="text-center"><b>SUMMARY EXPENSES GLOBAL LOUNGE - <? echo $month_array[$month]." ".$year; ?></b></h4>

            <form method="get">
                <table class="table table-borderless" style="width: 20%; float: right">
                    <tr>
                        <td>
                            <label for="month" class="hidden">Month</label>
                            <select  required class="form-control" name="month" id="month" value="<? echo $month?>">
                                <? echo getDropDownMonthSummary($month) ;?>
                            </select>
                        </td>
                        <td>
                            <label for="year" class="hidden">Year</label>
                            <select  required class="form-control" name="year" id="year" value="<? echo $year?>">
                                <option value="">-- Choose Year --</option>
                                <? echo DropDownYear($year) ;?>
                            </select>
                        </td>
                    </tr>
                </table>
            </form>

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>NO</th>
                    <th>DESCRIPTION</th>
                    <th>ITEM</th>
                    <th>QTY</th>
                    <th>PRICE (RM)</th>
                    <th>TOTAL (RM)</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td rowspan="7">1</td>
                    <td colspan="2">Dobby Expenses</td>
                    <td>-</td>
                    <td>-</td>
                    <td><? echo number_format($dobby_expenses['amount'],2);?></td>
                </tr>
                <!--BEVERAGE EXPENSES-->
                <tr>
                    <td rowspan="3" style="vertical-align: middle">Beverage Expenses</td>
                    <td>Tea</td>
                    <td><input class="units-class" type="hidden" value="<? echo $beverage_expenses['tea'];?>" onchange="calculate()"><? echo (empty($beverage_expenses['tea']))? '0': $beverage_expenses['tea']?></td>
                    <td>0.40</td>
                    <td><? echo number_format($beverage_expenses['tea']*0.4, 2);?></td>
                </tr>
                <tr>
                    <td>Sugar</td>
                    <td><input class="units-class" type="hidden" value="<? echo $beverage_expenses['sugar'];?>" onchange="calculate()"><? echo (empty($beverage_expenses['sugar']))? '0': $beverage_expenses['sugar']?></td>
                    <td>0.40</td>
                    <td><? echo number_format($beverage_expenses['sugar']*0.4, 2);?></td>
                </tr>
                <tr>
                    <td>Creamer</td>
                    <td><input class="units-class" type="hidden" value="<? echo $beverage_expenses['creamer'];?>" onchange="calculate()"><? echo (empty($beverage_expenses['creamer']))? '0': $beverage_expenses['creamer']?></td>
                    <td>0.40</td>
                    <td><? echo number_format($beverage_expenses['creamer']*0.4, 2);?></td>
                </tr>
                <!--TOILETRIES EXPENSES-->
                <tr>
                    <td rowspan="3" style="vertical-align: middle">Toiletries Expenses</td>
                    <td>Batch Soap</td>
                    <td><input class="units-class" type="hidden" value="<? echo $beverage_expenses['soap'];?>" onchange="calculate()"><? echo (empty($beverage_expenses['soap']))? '0': $beverage_expenses['soap']?></td>
                    <td>0.70</td>
                    <td><? echo number_format($beverage_expenses['soap']*0.7, 2);?></td>
                </tr>
                <tr>
                    <td>Shampoo</td>
                    <td><input class="units-class" type="hidden" value="<? echo $beverage_expenses['shampoo'];?>" onchange="calculate()"><? echo (empty($beverage_expenses['shampoo']))? '0': $beverage_expenses['shampoo']?></td>
                    <td>1.00</td>
                    <td><? echo number_format($beverage_expenses['shampoo']*1.0, 2);?></td>
                </tr>
                <tr>
                    <td>Mineral Water</td>
                    <td><input class="units-class" type="hidden" value="<? echo $beverage_expenses['water'];?>" onchange="calculate()"><? echo (empty($beverage_expenses['water']))? '0': $beverage_expenses['water']?></td>
                    <td>1.00</td>
                    <td><? echo number_format($beverage_expenses['water']*1.0, 2);?></td>
                </tr>
                <!--UTILITY-->
                <tr>
                    <td rowspan="5">2</td>
                    <td rowspan="5" style="vertical-align: middle">Utility</td>
                </tr>
                <tr>
                    <td>Water Bill</td>
                    <td>1</td>
                    <td><? echo number_format($utility['wbil'], 2);?></td>
                    <td><? echo ($water_bill>0)? $water_bill : '0.00'; ?></td>
                </tr>
                <tr>
                    <td>Electricity Bill</td>
                    <td>1</td>
                    <td><? echo number_format($elec['ebil'], 2);?></td>
                    <td><? echo ($elec_bill>0)? $elec_bill : '0.00'; ?></td>
                </tr>
                <tr>
                    <td>Coway</td>
                    <td>1</td>
                    <td><? echo number_format($coway['coway'], 2);?></td>
                    <td><? echo ($coway_bill>0)? $coway_bill : '0.00'; ?></td>
                </tr>
                <tr>
                    <td>Transportation</td>
                    <td>1</td>
                    <td><? echo number_format($transport['transport'], 2);?></td>
                    <td><? echo ($transport_bill>0)? $transport_bill : '0.00'; ?></td>
                </tr>
                <!--HOUSEKEEPING EXPENSES-->
                <tr>
                    <td>3</td>
                    <td colspan="2">Housekeeping Expenses</td>
                    <td>-</td>
                    <td>-</td>
                    <td><? echo ($housekeeping_expenses['total']) ? number_format($housekeeping_expenses['total'], 2) : '0.00';?></td>
                </tr>
                <tr>
                    <th colspan="5"></th>
                    <th class="text-center"><span id = "total-id"><? echo ($final_total>0)? 'RM '.number_format($final_total, 2) : ''; ?></span></th>
                </tr>
                </tbody>
            </table>

            <table class="table table-borderless">
                <tr>
                    <th style="width: 35%" class="text-left">PREPARED BY :</th>
                    <th style="width: 35%" class="text-left">REVIEWED BY :</th>
                    <th class="text-left">CONFIRMED BY :</th>
                </tr>
                <tr>
                    <td>
                        <p class="text-left" style="margin-top: 30px">............................................</p>
                        <p class="text-left" >
                            Name : <b>Aisyah Athirah Binti Md Yunus</b><br>
                            Designation : <b>Receptionist</b><br>
                            Date :
                        </p>
                    </td>
                    <td>
                        <p class="text-left" style="margin-top: 30px">............................................</p>
                        <p class="text-left" >
                            Name : <b>Siti Aishah Binti Mohd Hatta</b><br>
                            Designation : <b>Admin Assistant of Corporate Administration</b><br>
                            Date :
                        </p>
                    </td>
                    <td>
                        <p class="text-left" style="margin-top: 30px">............................................</p>
                        <p class="text-left" >
                            Name : <b>C. Wan Nurul Azlini binti C. Wan Ramli</b><br>
                            Designation : <b>Head of Corporate Administration</b><br>
                            Date :
                        </p>
                    </td>
                </tr>
            </table>

            <div style="text-align:center;">
                <input id="btn-Preview-Image" class="btn btn-primary" type="button" onclick="window.print()" value="Print"/>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    $(document).ready(function() {
        $("#month,#year").change(function(){

            var selected_month=$("#month").val();
            var selected_year=$('#year').val();
            reloadMonth(selected_month,selected_year);
        });
    });

    function reloadMonth(month,year){
        location.href = "aims_gl_expenses_summary_report.php?month="+month+"&year="+year;
    }

    var prices = [0.4,0.4,0.4,0.7,1,1];
    var units = document.getElementsByClassName('units-class');
    var subs = document.getElementsByClassName('multi-class');
    var grand = document.getElementById('total-id');
    var sum = 0;

    calculate();
</script>

</body>
</html>