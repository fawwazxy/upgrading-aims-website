<?php

include ('../controller/auth.php');

require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$department_name=$_GET['department_name'];
$sys = getSys(1)->fetch_assoc();

$ceo_app = $_GET['ceo_app'];
if (!isset($ceo_app) && $ceo_app == '') {
    $ceo_app = 'PENDING';
}

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

<style>
    body{
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        background-color: #f2f2f2;
        font-family: 'Poppins';
    }
    h1{
        text-transform: uppercase;
        letter-spacing: 3px;
        color: rgba(0,0,0, 0.45);
    }
    .content__table{
        border-collapse: collapse;
        margin: 25px 0;
        font-size: 0.9em;
        min-width: 200px;
        border-radius: 5px 5px 0 0;
        box-shadow: 0 0 20px rgba(0,0,0, 0.15);

    }
    .content__table thead tr{
        background-color: #f1c40f;
        color: rgba(0,0,0, 0.45);
        text-align: left;
        font-weight: bold;
        text-transform: capitalize;
    }

    .content__table th,
    .content__table td {
        padding: 12px 15px;
    }
    .content__table tbody tr{
        /*border-bottom: 1px solid #aaa;*/
        color: #444;
        text-align: center;
    }
    .content__table tbody tr:nth-of-type(even){
        background-color: rgba(241,196,15,0.30);
    }
    .content__table tbody tr:last-of-type{
        border-bottom: 2px solid #f1c40f;
    }
    .content__table tbody tr.active__row{
        font-weight: bold;
        color: #f1c40f;
    }
    .content__table tbody tr td:hover{
        background-color: #f1c40f;
        color: #444;
        font-weight: bold;
        cursor: pointer;
    }

    .footer{
        font-weight: 600;
        color: #444;}
    .footer a{
        color: #444;
    }
    .footer a:hover{
        background-color: rgba(241,196,15,0.3);
    }



    .btn-group button {
        background-color: #c0c0c0; /* Green background */
        border: 1px solid green; /* Green border */
        color: white; /* White text */
        padding: 5px 5px; /* Some padding */
        cursor: pointer; /* Pointer/hand icon */
        float: left; /* Float the buttons side by side */
    }

    /* Clear floats (clearfix hack) */
    .btn-group:after {
        content: "";
        clear: both;
        display: table;
    }

    .btn-group button:not(:last-child) {
        border-right: none; /* Prevent double borders */
    }

    /* Add a background color on hover */
    .btn-group button:hover {
        background-color:#708090;
    }

    .modal-header{
        background-color:#f1c40f;
    }

    //button approve
      .animate
      {
          transition: all 0.1s;
          -webkit-transition: all 0.1s;
      }

    .action-button
    {
        position: relative;
        padding: 5px 20px;
        margin: 0px 10px 10px 0px;
        float: left;
        border-radius: 8px;
        font-family: 'Pacifico', cursive;
        font-size: 10px;
        color: #FFF;
        text-decoration: none;
    }

    .blue
    {
        background-color: #3498DB;
        border-bottom: 5px solid #2980B9;
        text-shadow: 0px -2px #2980B9;
    }

    .red
    {
        background-color: #E74C3C;
        border-bottom: 5px solid #BD3E31;
        text-shadow: 0px -2px #BD3E31;
    }

    .green
    {
        background-color: #82BF56;
        border-bottom: 5px solid #669644;
        text-shadow: 0px -2px #669644;
    }

    .yellow
    {
        background-color: #F2CF66;
        border-bottom: 5px solid #D1B358;
        text-shadow: 0px -2px #D1B358;
    }

    .action-button:active
    {
        transform: translate(0px,5px);
        -webkit-transform: translate(0px,5px);
        border-bottom: 1px solid;
    }
</style>

<script type="text/javascript">
    <!--
    function un_check(){
        for (var i = 0; i < document.frmactive.elements.length; i++) {
            var e = document.frmactive.elements[i];
            if ((e.name != 'allbox') && (e.type == 'checkbox')) {
                e.checked = document.frmactive.allbox.checked;
            }}}
    //-->
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#select_all').on('click',function(){
            if(this.checked){
                $('.checkbox').each(function(){
                    this.checked = true;
                });
            }else{
                $('.checkbox').each(function(){
                    this.checked = false;
                });
            }
        });

        $('.checkbox').on('click',function(){
            if($('.checkbox:checked').length == $('.checkbox').length){
                $('#select_all').prop('checked',true);
            }else{
                $('#select_all').prop('checked',false);
            }
        });
    });
</script>

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

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">TRANSPORT REQUEST APPROVEMENT</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel-body">


                    <? $data=getCheckboxUpdateCarCEO($id,$_SESSION['SESS_NAME'])?>
                    <form name="frmactive" method="post" action="">
                        <table border="0" width="100%">
                            <tr>
                                <td width="80%"><input type="checkbox" id="select_all" /><font size='4'> Select All</font></li></td>
                                <td width="20%"><input class="btn btn-success" name="activate" type="submit" id="activate" value="APPROVE" />
                                    <input class="btn btn-danger" name="deactivate" type="submit" id="deactivate" value="DISAPPROVE" />
                                </td>
                            </tr>

                        </table><br>

                        <table width="100%" class="content__table" id="dataTables-example">
                            <a href="aims_carReserve_ceoList.php?ceo_app=PENDING" class="action-button animate blue">NEW</a>
                            <a href="aims_carReserve_ceoList.php?ceo_app=APPROVE" class="action-button animate green">APPROVED</a>
                            <a href="aims_carReserve_ceoList.php?ceo_app=DISAPPROVE" class="action-button animate red">DISAPPROVED</a><br><br>
                            <thead>
                            <tr>
                                <th width="7%">No.</th>
                                <th width="35%">Maklumat Staf</th>
                                <th width="15%">Status by HOD/SBU</th>
                                <th width="15%">Status by Admin</th>
                                <th width="15%">Status by Ceo</th>
                                <th width="20%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            if($ceo_app == 'PENDING') {
                                $car= getcarRequestList4NEW($_SESSION['SESS_NAME']);
                            }
                            else if($ceo_app == 'APPROVE') {
                                $car= getcarRequestList4APPROVE($_SESSION['SESS_NAME']);
                            }
                            else {
                                $car= getcarRequestList4DISAPPROVE($_SESSION['SESS_NAME']);
                            }
                            $i=1;
                            while($row_data = $car->fetch_assoc() ) {
                                ?>
                                <tr>
                                    <td><? echo $i++;?>
                                        <align="center">
                                        <input name="checkbox[]" type="checkbox" class="checkbox" id="checkbox[]" value="<?php echo $row_data['id'];?>" >
                                    </td>
                                    <td style="text-align:left">
                                        <label class="control-label">NAMA : </label> <? echo $row_data['name'];?><br>
                                        <label class="control-label">DESIGNATION : </label> <? echo $row_data['jawatan'];?>
                                    </td>
                                    <td style="text-align:center"><? if($row_data['sbu_hod_app'] =="PENDING")
                                        {echo "<span style='background-color:Grey; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>PENDING</span>";}
                                        else if ($row_data['sbu_hod_app'] =="APPROVE"){
                                            echo "<span style='background-color:Green; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>APPROVE</span>";
                                        }
                                        else {
                                            echo "<span style='background-color:Red; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>DISAPPROVE</span>";
                                        }?>
                                    </td>
                                    <td style="text-align:center"><? if($row_data['app_status'] =="PENDING")
                                        {echo "<span style='background-color:Grey; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>PENDING</span>";}
                                        else if ($row_data['app_status'] =="APPROVE"){
                                            echo "<span style='background-color:Green; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>APPROVE</span>";
                                        }
                                        else {
                                            echo "<span style='background-color:Red; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>DISAPPROVE</span>";
                                        }?>
                                    </td>
                                    <td style="text-align:center"><? if($row_data['ceo_app'] =="PENDING")
                                        {echo "<span style='background-color:Grey; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>PENDING</span>";}
                                        else if ($row_data['ceo_app'] =="APPROVE"){
                                            echo "<span style='background-color:Green; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>APPROVE</span>";
                                        }
                                        else {
                                            echo "<span style='background-color:Red; padding:5px; border-radius: 5px; font-weight: bold; color:white;'>DISAPPROVE</span>";
                                        }?>
                                    </td>
                                    <td style="vertical-align: middle!important;text-align: center;">
                                        <div class="btn-group">
                                            <button><a href="#myModal1" data-toggle="modal" data-id="<?php echo $row_data['id']?>"><i class='fa fa-edit'></i></a></button>
                                            <button><a href="#myModal2" data-toggle="modal" data-id="<?php echo $row_data['id']?>"><i class='fa fa-info-circle'></i></a></button>
                                        </div>
                                    </td>

                                </tr>
                            <?}?>

                            </tbody>
                        </table>
                </div>

                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>
        <!--
                <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /#wrapper -->

    <!-- Modal -->


    <!-- Page-Level Demo Scripts - Tables - Use for reference -->

    <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Update</h4>
                </div>
                <div class="modal-body" id="demo">
                    <script type="text/javascript">
                        $('#myModal1').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'GET',
                                url:'aims_car_ceostatus_update.php',
                                data:'id='+rowid,
                                success:function(html){
                                    $('#demo').html(html);
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel2">Update</h4>
                </div>
                <div class="modal-body" id="demo2">
                    <script type="text/javascript">
                        $('#myModal2').on('show.bs.modal', function (e) {
                            var rowid = $(e.relatedTarget).data('id');
                            // $('#demo').html(rowid);
                            $.ajax({
                                type:'POST',
                                url:'aims_car_staffInfo.php',
                                data:'id='+rowid,
                                success:function(html){
                                    $('#demo2').html(html);
                                }
                            });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });

    </script>

</body>

</html>