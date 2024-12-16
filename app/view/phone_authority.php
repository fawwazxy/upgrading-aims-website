<?php

include ('../controller/auth.php');

require "../model/authority_functions.php";

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
                <h1 class="page-header">Phone Authority</h1>
            </div>
        </div>
        <div class="row">
            <div class="panel-heading" align="right">

                <button class="btn btn-danger" onclick="truncate()">TRUNCATE</button>

            </div>
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai device
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>No. Kad Pengenalan</th>
                                <th>Device Id</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getPhoneAuthority();
                            while($row_data = $data->fetch_assoc()) {

                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['name']; ?></td>
                                    <td><?php echo $row_data['nokp_staff']; ?></td>
                                    <td><?php echo $row_data['device_id']; ?></td>
                                    <td><button class="btn btn-warning" onclick="delId(<? echo $row_data['id'];?>)">NYAHAKTIF</button></td>
                                </tr>
                                <?php $i++; } ?>


                            </tbody>

                        </table>

                    </div>

                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->

            </div>
            <!-- /.col-lg-12 -->
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
    function delId(id){

        $.confirm({
            title: 'Warning',
            content: 'Anda Pasti Ingin Padam Maklumat Ini?',
            buttons: {
                YA: function () {
                    $.ajax({
                        url: "../model/authority_functions.php",
                        type: "POST",
                        data: {action:"delId",id:id},
                        success: function (response) {
                            // you will get response from your php page (what you echo or print)
                            //$.alert('test here:'+response);

                            window.location='phone_authority.php';
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });
                },
                TIDAK: function(){
                    window.location='phone_authority.php';

                }

            }
        });
    }
    function truncate(){

        $.confirm({
            title: 'Warning',
            content: 'Adakah Anda Pasti?',
            buttons: {
                YA: function () {
                    $.ajax({
                        url: "../model/authority_functions.php",
                        type: "POST",
                        data: {action:"truncate"},
                        success: function (response) {
                            // you will get response from your php page (what you echo or print)
                            //$.alert('test here:'+response);

                            window.location='phone_authority.php';
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });
                },
                TIDAK: function(){
                    window.location='phone_authority.php';

                }

            }
        });
    }
</script>

</body>

</html>
