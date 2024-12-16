<?php

include ('../controller/auth.php');

require "../model/aims_gl_function.php";
require "../model/lookup.php";


$er_no=$_GET['er_no'];
$id = $_GET['id'];
$staffinfo = getExchangeFormPrintById($id)->fetch_assoc();

$sys = getSys(1)->fetch_assoc();
?>

<!DOCTYPE html>
<title>iOffice::Sistem Pengurusan Pejabat Bersepadu</title>
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
            font-size: 15px;
            color: black;
            background-color: white;
            margin-left: 20px;
            margin-right: 20px;
        }

        table.office{
          width: 100%;
        }

        table.one{
            width:100%;
    
        }
        table td{
          padding: 2px;
        }
         table.intro{
            width:80%;
        }
    

        input {
          width: 60%;
          border-top-style: hidden;
        border-right-style: hidden;
        border-left-style: hidden;
        border-bottom-style: hidden;
        background-color: none;
        }

        .intro input {
        border-top-style: hidden;
        border-right-style: hidden;
        border-left-style: hidden;
        border-bottom-style: groove;
        background-color: none;
      }
    
    .container{
      line-height: 0.1;
      font-size: 18px;
    }

    .container td{
      color: black;
      font-size: 14px;
    }

    .one td{
      padding: 4px;
      font-size: 12px;
    }


    h3{
      color: black;
      font-size: 28px;
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

  <div class="container">
    &nbsp;     
  <table align="center" >
    <tr>
      <td rowspan="5" ><img src="../../resources/images/aims_logo.png" alt="Aims-Global" width="90px;" ></td>
      <td><b>&nbsp;Aims-Global Maritime Sdn Bhd (1041517-X)</b></td>
    </tr>
    <tr>
      <td>&nbsp;No 20 & 21, Blok B, Bestari Centre, Jalan Hiliran,</td>
    </tr>
    <tr>
      <td>&nbsp;20300 Kuala Terengganu, Terengganu Darul Iman</td>
    </tr>
    <tr>
      <td>&nbsp;PHONE NUMBER: 09-6228848 &nbsp;&nbsp;&nbsp; FAKS NUMBER: 09-6238848</td>
    </tr>
    <tr>
      <td>&nbsp;Email: aims@aimsglobal.com.my</td>
    </tr>
  </table>    
</div>

  <div class="row" align="center">
    <h3><center><b><i>ROOM EXCHANGE-FORM GLOBAL LOUNGE</b></i></center></h3>
  </div>

   <table class="intro" border="0">
    <tr>
        <td><b>Exchanges Room Number: <?echo $staffinfo['er_no'] ;?></b></td>
      </tr>  
        </table>
        <br>

    <table class="one" border="1">
      <tr>
       <td colspan="2" style="font-size: 20px;" align="center"><b>PERSONAL DETAILS</td></b>
      </tr>
        <tr>
        <td width="50%">FULL NAME: <?echo $staffinfo['client_name'] ;?></td>
        <td>COMPANY: <?echo $staffinfo['company_name'] ;?>
    </td>
      </tr>

      <tr>
        <td>IC/PASSPORT NUMBER: <?echo $staffinfo['client_ic'] ;?></td>
        <td>CONTACT NUMBER: <?echo $staffinfo['client_phone_no'] ;?></td>
      </tr>

      <tr>
       <td colspan="2" style="font-size: 20px;" align="center"><b>ROOM DETAILS</td></b>
      </tr>
        <tr>
        <td><center style="font-size: 16px;">PRESENT ROOM</center><br>
        ROOM NUMBER: <?echo $staffinfo['room_pass'] ;?><br>
        BED NUMBER: <?echo $staffinfo['bed_pass'] ;?><br>
        LOCKER NUMBER: <?echo $staffinfo['locker_pass'] ;?>
      </td>
       <td><center style="font-size: 16px;">NEW ROOM</center><br>
        ROOM NUMBER: <?echo $staffinfo['room_id'] ;?><br>
        BED NUMBER: <?echo $staffinfo['bed_id'] ;?><br>
        LOCKER NUMBER: <?echo $staffinfo['locker_id'] ;?>
      </td>
      </tr>

      <tr>
        <td colspan="2">REASON FOR MOVE: <?echo $staffinfo['reason'] ;?></td>
      </tr>

      <tr>
        <td colspan="2" align="center" style="font-size: 20px"><b>I agree to the above room exchanges/changes</b></td>
      </tr>
      <tr>
        <td>DATE: <?echo '<font>'.date('d/m/Y',strtotime($staffinfo['date_change'])).'</font>' ;?>
        <td>SIGN: </td>
      </tr>  
        </table>
        <br>

        <table class="office" border="1">
        <tr>
        <td colspan="2" style="font-size: 20px;" align="center"><b>For Office Use Only:</b></td>
      </tr>
      <tr>
        <td><b>Action By :</b></td>
        <td>Name: <?echo $staffinfo['action_by'] ;?><br>
            Date: <?echo '<font>'.date('d/m/Y',strtotime($staffinfo['action_date'])).'</font>' ;?>
        </td>
      </tr>  
        </table>

        <br>
        <br>

        <div style="text-align:center;">
    <br><input id="btn-Preview-Image" type="button" onclick="window.print()" value="Cetak"/>
    <br><br>
</div>
          </div> <!-- End sign -->



</body>

</html>