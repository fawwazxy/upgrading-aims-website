<?php

include ('../controller/auth.php');

require "../model/aims_gl_function.php";
require "../model/lookup.php";


$ref_no=$_GET['ref_no'];
// $id = $_GET['id'];
// $staffinfo = getRoomReservPrintById($id)->fetch_assoc();

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

        table.reservation{
          width: 100%;
        }

        table.one{
            width:100%;
    
        }
         table.sign{
            width:100%;
    
        }

        .reservation input,select {
          width: 60%;
          border-top-style: hidden;
        border-right-style: hidden;
        border-left-style: hidden;
        border-bottom-style: hidden;
        background-color: none;
        }

        .sign input {
        border-top-style: hidden;
        border-right-style: hidden;
        border-left-style: hidden;
        border-bottom-style: groove;
        background-color: none;
      }

    .box{
          width: 100%;
        }
    
    .container{
      line-height: 0.1;
      font-size: 18px;
    }

    .container td{
      color: black;
    }

    h3{
      color: black;
      font-size: 28px;
    }

    .reservation{
      font-size: 16px;
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
      <td rowspan="6" ><img src="../aims_logo.png" alt="Aims-Global" width="100px;" ></td>
      <td><b>&nbsp;Aims-Global Maritime Sdn Bhd (1041517-X)</b></td>
    </tr>
    <tr>
      <td>&nbsp;02-03, Level 3, No. 2, Block C, Bestari Centre,</td>
    </tr>
    <tr>
      <td>&nbsp;Jalan Hiliran, 20300 Kuala Terengganu, Terengganu Darul Iman</td>
    </tr>
    <tr>
      <td>&nbsp;No. Tel: 09-6228848 &nbsp;&nbsp;&nbsp; No. Faks: 09-6238848</td>
    </tr>
    <tr>
      <td>&nbsp;Email: aims@aimsglobal.com.my &nbsp;&nbsp; Website: www.aimsglobal.com.my</td>
    </tr>
  </table>    
</div>

  <div class="row" align="center">
    <h3><center><b><u>ROOM RESERVATION</u></b></center></h3>
  </div>
  <br>
  <br>

  <div class="reservation">

            <table border='0' cellspacing='0'>

            <tr>
            <td height='25px' width="5%"><b>Ref No&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b></td>
            <td height='25px' width="80%">
              <select name="ref_no" id="ref_no">
                <option value="">-- Choose Ref NO --</option>
                <? echo getDropDownRefNo($ref_no);?>
              </select></td>
          </tr>

          <?
                  $i=1;
                                    $rrf = getReservByReff($ref_no);
                                    while($list_rrf = $rrf->fetch_assoc()) {
                                ?>

          <tr>
            <td height='25px' width="3%"><b>Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b></td>
            <td height='25px' width="80%" ><input type="date" id="reserv_date" name="reserv_date" value="<?php echo $list_rrf['reserv_date']; ?>"></td>
            </tr>

            <tr>
            <td height='25px' width="2%"><b>To &emsp;&emsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b></td>
            <td height='25px' width="80%"><input type="text" id="to" name="to" value="<?php echo $list_rrf['to_gl']; ?>"></td>
            </tr>

            <tr> 
            <td height='25px' width="2%"><b>Fax&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b></td>
            <td height='25px' width="80%"><input type="text" id="fax" name="fax" value="<?php echo $list_rrf['fax']; ?>"></td>
          </tr>

            <tr> 
            <td height='25px' width="2%"><b>Attendent&nbsp;:</b></td>
            <td height='25px' width="80%"><input type="text" id="attend" name="attend" value="<?php echo $list_rrf['attend']; ?>"></td>
          </tr>

          <tr>
            <td height='25px' width="%"><b>From &emsp;&nbsp;&nbsp;&nbsp;:</b></td>
            <td height='25px' width="80%"><input type="text" id="from" name="from" value="<?php echo $list_rrf['client_company']; ?>"></td>
            </tr>

             <?php $i++; } ?>

        </table>
    </div>
    <br>

    <p>Dear Sir / Madam</p>
    <p>Please reserve room for our crew as below :-</p>

    <table class="one" border="1">
        <tr><br>
        <th style="text-align:center;">NO</th>
        <th style="text-align:center;">NAME</th>
        <th style="text-align:center;">IC / PASSPORT<br>NO.</th>
        <th style="text-align:center;">COMPANY</th>
        <th style="text-align:center;">CHECK IN</th>
        <th style="text-align:center;">CHECK OUT</th>
        <th style="text-align:center;">REMARKS</th>
      </tr>

      <?
                  $i=1;
                                    $rr = getReservByRef($ref_no);
                                    while($list_rr = $rr->fetch_assoc()) {
                                ?>

      <tr>
        <td><? echo $i; ?></td>
        <td><? echo $list_rr['client_name']; ?></td>
        <td><? echo $list_rr['client_ic'] ;?></td>
        <td><? echo $list_rr['client_company'] ;?></td>
        <td><? echo $list_rr['arrival_date'] ;?></td>
        <td><? echo $list_rr['departure_date'] ;?></td>
        <td><? echo $list_rr['remarks'] ;?></td>
      </tr>

      <?php $i++; } ?>
              
        </table>

        <br><p>Should you have any queries or need further information, please contace the undersigned at any time.</p>

        <table class="sign" border="0">
        <tr><br>
        <th colspan="2">APPLICANT'S BY :</th>
        <th colspan="2">CONFIRM BY :</th>
      </tr>

      <tr>
        <td width="10%">SIGN</td>
        <td width="40%"></td>
        <td width="10%">SIGN</td>
        <td width="40%"></td>
      </tr>
      <tr>
        <td></td>
        <td><input style="width:230px;" type="text" id="" name="" value=""></td>
        <td> </td>
        <td><input style="width:230px;" type="text" id="" name="" value=""></td>
      </tr>
      <tr>
        <td>NAME&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;:</td>
        <td><input style="width:230px;" type="text" id="" name="" value=""></td>
        <td>NAME&emsp;&emsp;&emsp;&emsp;&nbsp;&nbsp;&nbsp;:</td>
        <td><input style="width:230px;" type="text" id="" name="" value=""></td>
      </tr>
      <tr>
        <td>DESIGNATION&emsp;:</td>
        <td><input style="width:230px;" type="text" id="" name="" value=""></td>
        <td>DESIGNATION&emsp;:</td>
        <td><input style="width:230px;" type="text" id="" name="" value=""></td>
      </tr>
      <tr>
        <td>COMPANY&emsp;&emsp;&nbsp;&nbsp;&nbsp;:</td>
        <td><input style="width:230px;" type="text" id="" name="" value=""></td>
        <td>DATE&emsp;&emsp;&emsp;&emsp;&emsp;:</td>
        <td><input style="width:230px;" type="text" id="" name="" value=""></td>
      </tr>
      <tr>
        <td>DATE&emsp;&emsp;&emsp;&emsp;&emsp;:</td>
        <td><input style="width:230px;" type="text" id="" name="" value=""></td>
        <td></td>
        <td></td>
      </tr>
              
        </table>

        <br>
        <br>
        <br>

        <div style="text-align:center;">
    <br><input id="btn-Preview-Image" type="button" onclick="window.print()" value="Cetak"/>
    <br><br>
</div>
          </div> <!-- box -->
	
	<!-- Modal -->

    <script>
         $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });

        });

        $(document).ready(function() {
              $("#ref_no").change(function(){

          var selected_ref_no=$(this).val();
          reloadRefNo(selected_ref_no);
        });

        });

        function reloadRefNo(ref_no){
              //console.log(cawangan);
              location.href = "aims_gl_room_reserv_print.php?ref_no="+ref_no;
          }

    </script>


</body>

</html>