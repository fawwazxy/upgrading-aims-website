<?php

include ('../controller/auth.php');

require "../model/aims_gl_function.php";
require "../model/lookup.php";


$ref_no=$_GET['ref_no'];

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
        @media print {
            #printPageButton {
                display: none;
            }
        }

        @media print {
            #html-content-holder {
                display: none;
            }
            #btn-Preview-Image {
                display: none;
            }
        }
    </style>

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

        <!-- /.navbar-header -->
        <? include ('../global/menu_top.php'); ?>

        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <!--li>
                        <center><img src="images/pic.jpg" class="user-image img-responsive"/></center>
                    </li-->

                    <? include ('../global/menu_left.php'); ?>

                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        <br>
        <br>
        <br>

        <div class="row" align="center" style="background-color: orange;">
            <div class="col-lg-12">
                <h3><b>Aims-Global Maritime Sdn Bhd (1041517-X)</b></h3>
                <h4>02-03, Level 3, No. 2, Block C, Bestari Centre,<br>
                    Jalan Hiliran, 20300 Kuala Terengganu, Terengganu Darul Iman<br>
                    No. Tel: 09-6228848 No. Faks: 09-6238848<br>
                    Email: aims@aimsglobal.com.my<br>
                    Website: www.aimsglobal.com.my</h4>
                <h2><center><b><u>ROOM RESERVATION</u></b></center></h2>
            </div>
        </div>

        <div class="form-group" align="right">
        </div>

        <br>
        <br>
        <br>


        <div class="row">
            <div align="left" class="col-lg-12">

                <div class="form-group row" align="left">
                    <label class="control-label col-sm-1" for="ref_no">Ref No:</label>
                    <div class="col-sm-4">
                        <select  required class="form-control" name="ref_no" id="ref_no">
                            <option value="">-- Choose Ref NO --</option>
                            <? echo getDropDownRefNo($ref_no);?>
                        </select>
                    </div>
                </div>

                <?
                $i=1;
                $rrf = getReservByReff($ref_no);
                while($list_rrf = $rrf->fetch_assoc()) {
                    ?>
                    <div class="form-group row" align="left">
                        <label class="control-label col-sm-1" for="reserv_date">Date:</label>
                        <div class="col-sm-4">
                            <input class="form-control" type="date" id="reserv_date" name="reserv_date" value="<?php echo $list_rrf['reserv_date']; ?>">
                        </div>
                    </div>

                    <div class="form-group row" align="left">
                        <label class="control-label col-sm-1" for="to">To:</label>
                        <div class="col-sm-4">
                            <input class="form-control" type="text" id="to" name="to" value="<?php echo $list_rrf['to_gl']; ?>">
                        </div>
                    </div>

                    <div class="form-group row" align="left">
                        <label class="control-label col-sm-1" for="fax">Fax:</label>
                        <div class="col-sm-4">
                            <input class="form-control" type="text" id="fax" name="fax" value="<?php echo $list_rrf['fax']; ?>">
                        </div>
                    </div>

                    <div class="form-group row" align="left">
                        <label class="control-label col-sm-1" for="attend">Attendent:</label>
                        <div class="col-sm-4">
                            <input class="form-control" type="text" id="attend" name="attend" value="<?php echo $list_rrf['attend']; ?>">
                        </div>
                    </div>

                    <div class="form-group row" align="left">
                        <label class="control-label col-sm-1" for="from">From:</label>
                        <div class="col-sm-4">
                            <input class="form-control" type="text" id="from" name="from" value="<?php echo $list_rrf['client_company']; ?>">
                        </div>
                    </div>

                    <?php $i++; } ?>

            </div>
        </div>

        <div class="row">

            <!-- /.panel-heading -->
            <div class="panel-body">


                <table width="100%" class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th width="5%">No.</th>
                        <th width="20%">Name</th>
                        <th width="20%">IC/Passport No</th>
                        <th width="20%">Company</th>
                        <th width="20%">Check In</th>
                        <th width="20%">Check Out</th>
                    </tr>
                    </thead>

                    <?
                    $i=1;
                    $rr = getReservByRef($ref_no);
                    while($list_rr = $rr->fetch_assoc()) {
                        ?>

                        <tr class="odd gradeX">
                            <td><?php echo $i; ?></td>
                            <td><?php echo $list_rr['client_name']; ?></td>
                            <td><?php echo $list_rr['client_ic']; ?></td>
                            <td><?php echo $list_rr['client_company']; ?></td>
                            <td><?php echo $list_rr['arrival_date']; ?></td>
                            <td><?php echo $list_rr['departure_date']; ?></td>
                        </tr>
                        <?php $i++; } ?>
                </table>
            </div>

            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <!-- /.container-fluid -->

        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /#page-wrapper -->

    <div style="text-align:center;">
        <br><input id="btn-Preview-Image" type="button" onclick="window.print()" value="Cetak"/>
        <br><br>
    </div>

    <div class="row" style="padding-left:20px; padding-bottom:20px;">
        <div align="center" style="float:center">
            <a href="aims_gl_room_reserv_print.php">
                <button type="button" class="btn btn-primary">Print</button></a>

            <a class="view" target="blank" href="aims_gl_room_reserv_print.php?id=<?echo $list_rr['id'] ;?>"><button class="btn btn-success hidden-print"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>Print Slip</button></a>
        </div>
    </div>

    <!-- /#wrapper -->
</div>

<!-- Modal -->

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
        // $("#month").change(function(){
        //   var selected_month=$(this).val();
        //   sendType(selected_month);
        //   });
    });
    /*	function sendType(type)
       {
        window.location.href="avsb_rawmaterial_report.php?month="+type;

      } */

    $(document).ready(function() {
        $("#ref_no").change(function(){

            var selected_ref_no=$(this).val();
            reloadRefNo(selected_ref_no);
        });

    });

    function reloadRefNo(ref_no){
        //console.log(cawangan);
        location.href = "aims_gl_room_reserv.php?ref_no="+ref_no;
    }

    /* $('#month,#stock_code').on('change',function(){
       var selectedMonth=$('#month').find('option:selected').val();
       var selectedStock=$('stock_code').find('option:selected').val();
       if(selectedMonth!=0 && selectedStock!=0)
       {
           sendType(selected_month,selectedStock);
       }
   }) */


</script>


</body>

</html>