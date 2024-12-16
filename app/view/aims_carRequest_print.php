<?php
include "../controller/auth.php";
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$list_car = getcarRequestPrint($id)->fetch_assoc();
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
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid #dddddd;
            padding: 8px;
            font-size:10px;
        }

        body{
            padding:40px;
        }

        @media print {
            button {display: none;}
        }

        @media goBack {
            button {display: none;}
        }

    </style>
</head>
<body>
<table>
    <tr>
        <th rowspan="3" style="width: 30%"><img src="https://www.mprc.gov.my/sites/default/files/styles/medium/public/directories-logo/aims_logo.png?itok=VRmQNKpL" alt="Trulli" width="95" height="95"></th>
    </tr>
    <tr>
        <td class="text-center">COMPANY VEHICLE USAGE APPLICATION FORM AIMS-GLOBAL GROUP</td>
    </tr>
    <tr>
        <td class="text-center">CORPORATE ADMINISTRATION DEPARTMENT AIMS-GLOBAL</td>
    </tr>

</table>

<p style="font-weight: bold">A. USER DETAILS<p>

<table>
    <tr>
        <td class="text-center" colspan="2" style="width: 50%"><b> APPLICANT DETAILS </b></td>
        <td class="text-center" colspan="3" style="width: 50%"><b> DETAILS OF USE </b></td>
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
        <td rowspan="2" style="width: 10%" class="text-center">Propose Schedule </td>
        <td rowspan="2" class="text-center">Milage </td>
        <td style="width: 25%" class="text-center">Date & Time</td>
    </tr>

    <tr>
        <td colspan="2" class="text-center">(need to be taken by the Applicant) </td>
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

    <tr>
        <td style="text-align: left; width: 50%" colspan="5">I hearby declare that:
            <input type="checkbox" id="healty_status" name="healty_status" value="Fit_To_Travel" style="margin-left: 12px"
                <? if($list_car['healty_status'] == "Fit_To_Travel") {echo "checked";}?>>
            <label for="healty_status">Fit To Travel</label>
            <input type="checkbox" id="healty_status" name="healty_status" value="Not_Fit_To_Travel" style="margin-left: 12px"
                <? if($list_car['healty_status'] == "Not_Fit_To_Travel") {echo "checked";}?>>
            <label for="healty_status">Not Fit To Travel</label>
            <br>
            Illness : <? echo $list_car['illness']; ?>
            <br>
            <h6><b>This statement is made truthfully and to be used accordingly</b></h6>
        </td>
    </tr>
</table>

<p><b>B.   FOR USE OF CORPORATE ADMINISTRATION DEPARTMENT</b><p>

<table>
    <tr>
        <td style="width: 50%" colspan="2">Status : <? echo $list_car['app_status']; ?></td>
        <td style="width: 50%" colspan="2"><b>Document Recieved & Return By Stuff</b></td>
    </tr>

    <tr>
        <td colspan="2">Comment : <? echo $list_car['reason']; ?></td>
        <td rowspan="3" colspan="2">
            <table>
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
    <tr>
        <td colspan="4"> Status Of Summons : <? echo $list_car['status_incep']; ?></td>
    </tr>
    <tr>
        <td colspan="2"> 1. Plate Number : <? echo ($list_car['status_incep'] == 'YES') ? $list_car['car_plate_no'] : ""; ?></td>
        <td colspan="2"> 5. Offense Details : <? echo ($list_car['status_incep'] == 'YES') ?  $list_car['offense_details'] : ""; ?></td>
    </tr>

    <tr>
        <td colspan="2"> 2. Issue District : <? echo ($list_car['status_incep'] == 'YES') ?  $list_car['issue_distric'] : ""; ?></td>
        <td colspan="2"> 6. Offense Date/Time : <? echo ($list_car['status_incep'] == 'YES') ?  $list_car['offense'] : ""; ?></td>
    </tr>

    <tr>
        <td colspan="2"> 3. Complaint : - </td>
        <td colspan="2"> 7. Driver Name : <? echo ($list_car['status_incep'] == 'YES') ?  $list_car['drivername'] : ""; ?></td>
    </tr>

    <tr>
        <td colspan="2"> 4. Summon Number : <? echo ($list_car['status_incep'] == 'YES') ?  $list_car['summons_no'] : ""; ?></td>
        <td colspan="2"> 8. Status Of Payment : <? echo ($list_car['status_incep'] == 'YES') ?  $list_car['summon_status'] : ""; ?></td>
    </tr>

    <tr>
        <td colspan="4" class="text-center"><b> VALIDATION</b></td>
    </tr>

    <tr>
        <td> SUMMON PAID BY : <br>
            NAME : <? echo ($list_car['status_incep'] == 'YES') ?  $list_car['name'] : ""; ?>&emsp;&emsp; DATE : </td>
        <td colspan="2"> CHECKED BY : <br>
            NAME : <? echo ($list_car['status_incep'] == 'YES') ?  $list_car['name_admin'] : ""; ?>&emsp;&emsp; DATE : </td>
        <td> CONFIRM BY : <br>
            NAME : <? echo ($list_car['status_incep'] == 'YES') ?  $list_car['name_admin'] : ""; ?>&emsp;&emsp; DATE : </td>
    </tr>
</table>

<div class="text-center" style="margin-top: 64px">
    <button onclick="window.print()" aria-hidden="true">Print this page</button>
    <button onclick="goBack()">Back</button>
</div>

<script>
    function goBack() {
        window.history.back();
    }
</script>
</body>
</html>