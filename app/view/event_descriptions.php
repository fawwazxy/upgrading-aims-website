<?php

include ('../controller/auth.php');

require "../model/meeting_functions.php";

session_start()
?>
<?
$bln=$_GET['mnt'];
$thn=$_GET['yr'];

?>

<?
$id=$_GET['id'];
$list = kemaskiniEvents($id)->fetch_assoc();
$id_staff=$list['id_staff'];
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
        td {
            padding-bottom: 20px;
            vertical-align: top;
        }
    </style>


    <script language="JavaScript" type="text/javascript">
        function Confirm(){
            return confirm('Adakah Anda Pasti untuk tekan butang berhenti ini?');
        }

        function Confirm2(){
            return confirm('Adakah Anda Pasti untuk tekan butang bekerja ini??');
        }


    </script>
    <script language="javascript" type="text/javascript">
        <!--
        function popitup(url) {
            /*newwindow=window.open(url,'name','height=842,width=595');*/
            newwindow=window.open(url,'name','height=595,width=842');
            if (window.focus) {newwindow.focus()}
            return false;
        }

        // -->
    </script>
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
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Kalendar Aktiviti</h1>
            </div>
        </div> <?
        $flagScreen="tab_3";
        include ('../global/menu_meeting.php');
        // ?>
        <div class="row">
            <div class="col-lg-12">
                <!-- /.POP up modal  ------------------------------------------------------------------------------------------------------------------------------------->
                <!-- /.POP up modal  ---------------------------------------------------------------------------------------------------------------------------------------->
            </div>
        </div>
        <div class="row">
            <div class="panel-heading" align="right">
                <input class="btn btn-primary" type="button" value="Kembali" onclick="goBack()">
            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading" align="left">
                        <label>Butir-Butir Aktiviti</label>
                    </div>
                    <div class="panel-body">
                        <?
                        $list = kemaskiniEvents($id)->fetch_assoc();

                        ?>

                        <div class="panel-body">
                            <table width="100%">
                                <tr>
                                    <th width="13%"></th>
                                    <th width="3%"></th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td><label>Nama Aktiviti</label></td>
                                    <td><label>:</label></td>
                                    <td><? echo $list['title'];?></td>
                                </tr>

                                <tr>
                                    <td><label>Tarikh Mula</label></td>
                                    <td><label>:</label></td>
                                    <td><? echo $list['start'];?></td>
                                </tr>

                                <tr>
                                    <td><label>Tarikh Tamat</label></td>
                                    <td><label>:</label></td>
                                    <td><? echo $list['end'];?></td>
                                </tr>

                                <tr>
                                    <td><label>Kategori</label></td>
                                    <td><label>:</label></td>
                                    <td><? echo $list['event_type'];?></td>
                                </tr>

                                <tr>
                                    <td><label>Status</label></td>
                                    <td><label>:</label></td>
                                    <td><? echo $list['status'];?></td>
                                </tr>

                                <tr>
                                    <td><label>Disediakan Oleh</label></td>
                                    <td><label>:</label></td>
                                    <td><? echo $list['prepared_by'];?></td>
                                </tr>

                                <tr>
                                    <td><label>Individu Terlibat</label></td>
                                    <td><label>:</label></td>
                                    <td>
                                        <?
                                        $i= 1;
                                        $staff= getStaffNameByID($id_staff);
                                        while($list_staff = $staff->fetch_assoc()) {
                                            ?>
                                            <?echo $i++;?>.&nbsp;<? echo $list_staff['name'];?><br>
                                        <?}?>
                                    </td>
                                </tr>

                                <tr>
                                    <td><label>Keterangan</label></td>
                                    <td><label>:</label></td>
                                    <td>&nbsp;</td>
                                </tr>
                                <tr>
                                    <td colspan="3" style="border-top: 1px solid;border-bottom: 1px solid;border-right: 1px solid;border-left: 1px solid; padding-right: 10px;padding-left: 10px;">
                                        <?echo $list['description'];?>

                                    </td>
                                </tr>

                            </table>
                        </div>

                        </table>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
            </div>
        </div>

        <!-- /.row -->
        <!-- /.container-fluid -->
        <? include ('../global/footer.php'); ?>
    </div>

    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>
</body>

</html>
