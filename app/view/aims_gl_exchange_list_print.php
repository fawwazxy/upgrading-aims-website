<?php

include ('../controller/auth.php');

require "../model/aims_gl_function.php";
require "../model/lookup.php";

$month=$_GET['month'];
$er_no=$_GET['er_no'];
// $id = $_GET['id'];
// $staffinfo = getRoomReservPrintById($id)->fetch_assoc();

$sys = getSys(1)->fetch_assoc();
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

    body {      
            font-family: Times New Roman;
            font-size: 9px;
            color: black;
            background-color: white;
            margin-left: 20px;
            margin-right: 20px;
        }

        table.one{
            width:100%;
    
        }
        th{
          text-align: center;
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
  <div class="row" align="center">
<p><b>SUMMARY ROOM EXCHANGE AIMS-GLOBAL MARITIME SDN BHD<b></p>
<br>
<div class="month">
    <p align="center"> <?
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
  }?> <?php echo date("Y"); ?></p>
</div>
</div>


    <table class="one" border="1">
        <tr>
        <th rowspan="2">NO.</th>
        <th rowspan="2">ERN NO</th>
        <th rowspan="2">CREW NAME</th>
        <th rowspan="2">CLIENT</th>
        <th rowspan="2">DATE</th>
        <th rowspan="2">REASON</th>
        <th colspan="3">PRESENT ROOM</th>
        <th colspan="3">NEW ROOM</th>
      </tr>
      <tr style="font-weight: bold;">
        <td>ROOM NO</td>
        <td>BED NO</td>
        <td>LOCKER NO</td>
        <td>ROOM NO</td>
        <td>BED NO</td>
        <td>LOCKER NO</td>
      </tr>

      <?
      $rr = getRoomExchangePrint($month);
      $i=1;
      while($list_ex = $rr->fetch_assoc()) {
        ?>

      <tr>
        <td style="text-align:center;"><? echo $i++;?></td>
        <td style="text-align:center;"><? echo $list_ex['er_no']; ?></td>
        <td ><? echo $list_ex['client_name']; ?></td>
        <td style="text-align:center;"><? echo $list_ex['client_company_id']; ?></td>
        <td style="text-align:center;"><? echo $list_ex['date_change']; ?></td>
        <td style="text-align:center;"><? echo $list_ex['reason']; ?></td>
        <td style="text-align:center;"><? echo $list_ex['room_pass']; ?></td>
        <td style="text-align:center;"><? echo $list_ex['bed_pass']; ?></td>
        <td style="text-align:center;"><? echo $list_ex['locker_pass']; ?></td>
        <td style="text-align:center;"><? echo $list_ex['room_id']; ?></td>
        <td style="text-align:center;"><? echo $list_ex['bed_id']; ?></td>
        <td style="text-align:center;"><? echo $list_ex['locker_id']; ?></td>
      </tr>

      <?php $i++; } ?>
              
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