<?php

include ('../controller/auth.php');
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";


$car_plate_no=$_GET['car_plate_no'];
$start_date=$_GET['start_date'];
$end_date=$_GET['end_date'];
$mode=$_GET['mode'];

$sys = getSys(1)->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
<style>
table, td, th {  
  border: 1px solid #ddd;
  text-align: left;
}

table {
  border-collapse: collapse;
          width: 100%;
		  padding-top: -20%;
}

th, td {
  padding: 5px;
}

body{
	padding:10px;
}

@media print {
  button {display: none;}
}	
th{
  color: #777;
  background: rgba(0,0,0,.1);
}
table { page-break-inside:auto }
tr { page-break-inside:avoid; page-break-after:auto }
 thead {
          height: 60px;
        }

        tbody {
          height: 40px;
        }
</style>
</head>
<body>

<img id="logo" src="../../resources/images/aims-logo.PNG" style="width:440px;height:90px;margin-left:15px;"/>

<hr/>
<br><br>
<div class="row">
<div class="form-group" align="right">
<button onclick="window.print()" aria-hidden="true">Print this page</button>
</div>
</div>
<br><br>
 <table class="table table-bordered table-striped"
                            <thead>
                                <tr>
                                    <th rowspan="2" style="text-align:center">DATE</th>
                                    <th rowspan="2" style="text-align:center">DESTINATION</th>
									<th colspan="2" style="text-align:center">MILEAGE</th>
									<th rowspan="2" style="text-align:center">REQUESTED BY</th>
									<th rowspan="2" style="text-align:center">PURPOSE</th>
									<th colspan="2" style="text-align:center">BUNKER FUEL</th>
									<th>PIC</th>
									
                                </tr>
								<tr>
									<th>OUT</th>
									<th>IN</th>
									<th>DATE</th>
									<th>PRICE(RM)</th>
									<th>NAME</th>
								</tr>
                            </thead>
                            <tbody>
                                <?
                                    $car = getcarFuelReport($start_date,$end_date,$_SESSION['SESS_NAME'],$car_plate_no,$status,$mode);
                                    $i=1;
                                    while($list_car = $car->fetch_assoc()) {
                                ?>
								
                                <tr class="odd gradeX">
                                    <td style="text-align:center"><? echo $list_car['dep_date']; ?></td>
									<td style="text-align:center"><? echo $list_car['destination']; ?></td>
									<td style="text-align:center"><? echo $list_car['dep_milage']; ?></td>
									<td style="text-align:center"><? echo $list_car['return_milage']; ?></td>
									<td style="text-align:center"><? echo $list_car['request_name']; ?></td>
									<td style="text-align:center"><? echo $list_car['purpose']; ?></td>
									<td style="text-align:center"><? echo $list_car['date_fuel']; ?></td>
									<td style="text-align:center"><? echo 'RM '.number_format($list_car['receipt_fuel'], 2) ?></td>
									<td style="text-align:center"><? echo $list_car['car_pic']; ?></td>
                                </tr>
								<? $total += (float)$list_car['receipt_fuel'];?>
                            <?}?>
							</tbody>
							<tbody>							
								<tr>
                                    <th colspan="7"></th>
                                    <th style="text-align:center"><?echo 'RM '.number_format($total, 2)?></th>
									<th></th>
									
                                </tr>
                            </tbody>
                        </table>
						
						<script>
				function goBack() {
				  window.history.back();
				}
				</script>

</body>
</html>