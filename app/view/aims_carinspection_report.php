<?php

include ('../controller/auth.php');
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$year=$_GET['year'];
$month=$_GET['month'];
if(!isset($month)){
  $month=$date_month;
}

$department_code=$_GET['department_id'];
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
  
}

th, td {
  padding: 5px;
  font-size:10px;
}

th{
	background-color: #808080;
	color: black;
}

body{
	padding:10px;
}

@media print {
  button {display: none;}
}
</style>
</head>
<body>

<img id="logo" src="../../resources/images/aims-logo.PNG" style="width:440px;height:90px;margin-left:15px;"/>

<hr/>
<button onclick="window.print()" aria-hidden="true">Print this page</button>
<button onclick="goBack()" aria-hidden="true">Back</button>
<br><br>
<center><?
	if ($month == '1') {
		echo "JANUARY";
	}
	else if ($month == '2') {
		echo "FEBRUARY";
	}
	else if ($month == '3') {
		echo "MARCH";
	}
	else if ($month == '4') {
		echo "APRIL";
	}
	else if ($month == '5') {
		echo "MAY";
	}
	else if ($month == '6') {
		echo "JUNE";
	}
	else if ($month == '7') {
		echo "JULY";
	}
	else if ($month == '8') {
		echo "AUGUST";
	}
	else if ($month == '9') {
		echo "SEPTEMBER";
	}
	else if ($month == '10') {
		echo "OCTOBER";
	}
	else if ($month == '11') {
		echo "NOVEMBER";
	}
	else if ($month == '12') {
		echo "DISCEMBER";
	}
	else {
		echo "-";
	}?>
	<? echo $year?></center>

<br><br>
 <table width="100%" class="content__table" id="dataTable-example">
                            <thead>
                                <tr>
                                    <th style="text-align:center">No.</th>
                                    <th style="text-align:center">Date Inspection</th>
									<th style="text-align:center">Company</th>
									<th style="text-align:center">No Plate & Fuel</th>
									<th style="text-align:center">Car Accessories</th>
									<th style="text-align:center">Exterior Car</th>
									<th style="text-align:center">Interior Car</th>
									<th style="text-align:center">Update By</th>
									<th style="text-align:center">Costing</th>
                                    <th style="text-align:center">Remark Admin</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?
                                    $car = getcarInspectionList4($month,$year);
                                    $i=1;
                                    while($list_car1 = $car->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td style="text-align:center" rowspan="2"><? echo $i++;?></td>
									<td style="text-align:center" rowspan="2"><? echo $list_car1['dep_date']; ?></td>
									<td rowspan="2"><?
									if ($list_car1['car_owner'] == 'AGMASB') {
										echo "AIMS GLOBAL MARITIME SDN BHD";
									}
									else if ($list_car1['car_owner'] == 'AGESB') {
										echo "AIMS GLOBAL ENGINEERING SDN BHD";
									}
									else if ($list_car1['car_owner'] == 'AGMHSB') {
										echo "AIMS GLOBAL MARINE AND HAEVY ENGINEERING SDN BHD";
									}
									else if ($list_car1['car_owner'] == 'AGIR') {
										echo "AIMS GLOBAL INTEGRITY AND RESORCE SDN BHD";
									}
									else if ($list_car1['car_owner'] == 'AVSB') {
										echo "AMIR VISION SDN BHD";
									}
									else {
										echo "AIMS GLOBAL HOLDING SDN BHD";
									}?></td>
									<td style="text-align:left"> PLATE NO : <? echo $list_car1['car_plate_no']; ?></td>
									<td style="text-align:center" rowspan="2"><? echo $list_car1['hd_vehicle']; ?></td>
									<td style="text-align:center"><? echo $list_car1['exterior_car']; ?></td>
									<td style="text-align:center"><? echo $list_car1['interior_car']; ?></td>
                                    <td style="text-align:center" rowspan="2"><? echo $list_car1['created_name']; ?></td>
                                    <td style="text-align:center" rowspan="2"><?echo 'RM '.number_format($list_car1['costing'], 2)?></td>
									<td style="text-align:center" rowspan="2"><? echo $list_car1['status_remark']; ?><br><br>
									<? echo $list_car1['remark_name']; ?><br><br>
									<? echo $list_car1['remark']; ?></td>
									
								</tr>
								<? $total += (float)$list_car1['costing'];?>
								<tr>
									<td style="text-align:left">FUEL : <? echo $list_car1['fuel']; ?></td>
									<td style="text-align:left">COMMENT : <? echo $list_car1['comment1']; ?></td>
									<td style="text-align:left">COMMENT : <? echo $list_car1['comment']; ?></td>
								</tr>
								
                            <?}?>
                             <tr>
									<td bgcolor="#808080" style="text-align:center" colspan="8"></td>
									<td bgcolor="#808080" style="text-align:center;color:black"><?echo 'RM '.number_format($total, 2)?></td>
									<td bgcolor="#808080" style="text-align:center"</td>
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