<?php
include ('../controller/auth.php');
require "../model/aims_gl_function.php";
require "../model/lookup.php";
$month=$_GET['month'];
$year=$_GET['year'];
$ref_no=$_GET['ref_no'];
$sys = getSys(1)->fetch_assoc();
// $id = $_GET['id'];
// $staffinfo = getRoomReservPrintById($id)->fetch_assoc();
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
            font-family: Times New Roman, serif;
            font-size: 9px;
            color: black;
            background-color: white;
            margin-left: 20px;
            margin-right: 20px;
        }
        p {
            font-size: 14px;
        }
        table.one{
            width:100%;
        }
        th{
            text-align: center;
        }
        td{
            padding: 1rem;
        }
        .row input {
            border-top-style: hidden;
            border-right-style: hidden;
            border-left-style: hidden;
            border-bottom-style: hidden;
            background-color: none;
            text-transform: uppercase;
        }
        .box{
            width: 100%;
        }
        @media print {
            #btn-Preview-Image {
                display: none;
            }
        }
    </style>
</head>
<body>
<br>
<div class="box">
    <div class="row" style="text-align: center">
        <p><b>SUMMARY ROOM RESERVATION AIMS-GLOBAL MARITIME SDN BHD<b></p>
        <br>
        <div class="month">
            <p style="text-align: center"> <?
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
                    echo "DECEMBER";
                }
                else {
                    echo "ALL MONTH";
                }?> <?php echo $year; ?></p>
        </div>
        <!-- <p><input style="width:200px; text-align: center;" type="text" placeholder="ENTER MONTH AND YEAR"></p> -->
    </div>


    <table class="one" border="1">
        <tr><br>
            <th rowspan="2">NO.</th>
            <th rowspan="2">RR NO</th>
            <th rowspan="2">CREW NAME</th>
            <th rowspan="2">CLIENT</th>
            <th rowspan="2">IC/PASSPORT NO</th>
            <th rowspan="2">ROOM NO</th>
            <th rowspan="2">BED NO</th>
            <th colspan="2">CHECK IN</th>
            <th colspan="2">CHECK OUT</th>
            <th rowspan="2">PIC</th>

        </tr>
        <tr style="font-weight: bold;">
            <td>Date</td>
            <td>Time</td>
            <td>Date</td>
            <td>Time</td>
        </tr>

        <?
        $rr = getRoomReservListPrint($month, $year);
        $i=1;
        if (mysqli_num_rows($rr) == 0){
            echo '<tr><td colspan="13" class="text-center">No data available</td></tr>';
        }
        while($list_rr = $rr->fetch_assoc()) {
            ?>

            <tr>
                <td style="text-align:center;"><? echo $i++;?></td>
                <td style="text-align:center;"><? echo $list_rr['ref_no']; ?></td>
                <td ><? echo $list_rr['client_name']; ?></td>
                <td style="text-align:center;"><? echo $list_rr['client_company_id']; ?></td>
                <td style="text-align:center;"><? echo $list_rr['client_ic']; ?></td>
                <td style="text-align:center;"><? echo $list_rr['room_id']; ?></td>
                <td style="text-align:center;"><? echo $list_rr['bed_id']; ?></td>
                <td style="text-align:center;"><? echo $list_rr['arrival_date']; ?></td>
                <td style="text-align:center;"><? echo $list_rr['arrival_time']; ?></td>
                <td style="text-align:center;"><? echo $list_rr['departure_date']; ?></td>
                <td style="text-align:center;"><? echo $list_rr['departure_time']; ?></td>
                <td style="text-align:center;"><? echo $list_rr['attend']; ?></td>
            </tr>

        <? } ?>

    </table>
    <br>
    <div style="text-align:center;"><input id="btn-Preview-Image" type="button" onclick="window.print()" value="Cetak"/>

    </div>
</div> <!-- box -->

<!-- Modal -->

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });

    });

</script>


</body>

</html>