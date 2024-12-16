<?php

include ('../controller/auth.php');
require "../model/aims_travel_function.php";
require "../model/lookup.php";

$id = $_POST['id'];
$list_car = getcarRequestPrintTravel($id)->fetch_assoc();

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

</head>

<!DOCTYPE html>
<html>
<head>

</head>
<body>


<table width="100%" class="table table-striped table-bordered table-hover">
  <tr>
    <th rowspan="3" width="30%"><img src="https://www.mprc.gov.my/sites/default/files/styles/medium/public/directories-logo/aims_logo.png?itok=VRmQNKpL" alt="Trulli" width="95" height="95"></th>
  </tr>
  <tr>
    <td style="text-align: center;">COMPANY VEHICLE USAGE APPLICATION FORM AIMS-GLOBAL GROUP</td>
  </tr>
  <tr>
    <td style="text-align: center;">CORPORATE ADMINISTRATION DEPARTMENT AIMS-GLOBAL</td>
  </tr>

</table>


<p><b>A.   USER DETAILS</b><p>
<table width="100%" class="table table-striped table-bordered table-hover">

<tr>
<td style="text-align: center;" colspan="2" width="50%"><b> APPLICANT DETAILS </b></td>
<td style="text-align: center;" colspan="3" width="50%"><b> DETAILS OF USE </b></td>
</tr>

<tr>
<td colspan="2">1. Applicant Name : <? echo $list_car['name']; ?></td>
<td rowspan="2" colspan="3"> 9. Purpose : <? echo $list_car['purpose']; ?></td>
</tr>

<tr>
<td colspan="2">2. Designation : <? echo $list_car['destination']; ?></td>
</tr>

<tr>
<td colspan="2">3. SBU/HOD : <? echo $list_car['approve_by']; ?></td>
<td rowspan="2" colspan="3">10. Destination : <? echo $list_car['destination']; ?></td>
</tr>

<tr>
<td colspan="2">4. Driver Name : <? echo $list_car['drivername']; ?></td>
</tr>

<tr>
<td rowspan="4">5. Type of Vehicle Applied : <? echo $list_car['car_type']; ?></td>
<td rowspan="2">6. Number of Passengers : <? echo $list_car['no_passengers']; ?></td>
<td rowspan="2" width="10%" style="text-align: center;">Propose Schedule </td>
<td rowspan="2" style="text-align: center;">Milage </td>
<td width="25%" style="text-align: center;">Date & Time</td>
</tr>

<tr>
<td colspan="2" style="text-align: center;">(need to be taken by the Applicant) </td>
</tr>

<tr>
<td rowspan="2">8. Plate Number : <? echo $list_car['car_plate_no']; ?></td>
<td>Return </td>
<td><? echo $list_car['return_milage']; ?></td>
<td><? echo $list_car['return_date']; ?> <? echo $list_car['return_time']; ?></td>
</tr>

<tr>
<td>Departure </td>
<td><? echo $list_car['dep_milage']; ?></td>
<td><? echo $list_car['dep_date']; ?> <? echo $list_car['dep_time']; ?></td>
</tr>
</table>


<p><b>B.   FOR USE OF CORPORATE ADMINISTRATION DEPARTMENT</b><p>

<table width="100%" class="table table-striped table-bordered table-hover">

<tr>
<td width="50%" colspan="2">Status : <? echo $list_car['app_status']; ?></td>
<td width="50%" colspan="2"><b>Document Recieved & Return By Stuff</b></td>
</tr>

<tr>
<td colspan="2">Comment : <? echo $list_car['reason']; ?></td>
<td rowspan="3" colspan="2">
<table width="100%" class="table table-striped table-bordered table-hover">
<tr>
<td>No.</td>
<td> Item </td>
<td> Recieved Date </td>
<td> Status</td>
<td>Retun Date</td>
<td>Status</td>
<tr>

<tr>
<td>1.</td>
<td>Pass Usage</td>
<td></td>
<td></td>
<td></td>
<td></td>
<tr>

<tr>
<td>2.</td>
<td>Inspection Company Vehicle Form</td>
<td></td>
<td></td>
<td></td>
<td></td>
<tr>
</table>
</td>
</tr>

<tr>
<td>Name : <? echo $list_car['name_admin']; ?></td>
<td>Date : <? echo $list_car['date_app']; ?></td>

</tr>

<tr>
<td>Designation : <? echo $list_car['descrip']; ?></td>
<td>Signature : <? echo $list_car['department']; ?></td>

</tr>


</table>
<div align="center">
	<button id="printPageButton" type="button" class="btn btn-info" onclick="window.print()">Print</button>
</div>

</body>
</html>