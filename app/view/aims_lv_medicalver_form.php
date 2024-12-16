<?php

include ('../controller/auth.php');
require "../model/lookup.php";
require "../model/aims_lv_medicalver_function.php";

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
        <div class="row" align="center">
            <div class="col-lg-12">
                <h1 class="page-header">MEDICAL CLAIM</h1>
            </div>
        </div>

        <div class="panel-heading" align="right">
            <!--a href="stok_barang_new_add.php"><button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Tambah Stok Baharu</button></a-->

        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        STAFF
                    </div>
                    <!-- /.panel-heading -->

                    <div class="panel-body">


                        <form method="post" action="../controller/aims_lv_medicalver_exec.php"
                              enctype="multipart/form-data">

                            <div class="form-group" align="center">
                                <h3> CLAIM FOR THE MONTH ENDED: </h3>
                                <br>
                                <br>
                                <input type="hidden" class="form-control" id="medical_id" name="medical_id" value="<? echo $staffinfo['id'] ?>" />
                                <div class="form-group row" align="left" >
                                    <label class ="control-label col-sm-2" for ="balance"> BALANCE:</label>
                                    <div class="col-sm-6">
                                        <input type="text" required="" class="form-control" placeholder="" id="balance" name="balance" style="text-transform:uppercase" value="<? echo $staffinfo['balance'] ?>" />
                                    </div></div>


                                <div class="form-group row" align="left">
                                    <label class ="control-label col-sm-2" for ="current_balance"> CURRENT BALANCE:</label>
                                    <div class="col-sm-6">
                                        <input type="text" required="" class="form-control" placeholder="" id="current_balance" name="current_balance" style="text-transform:uppercase" value="<? echo $staffinfo['current_balance'] ?>" />
                                    </div></div>


                                <div class="form-group row" align="left">
                                    <label class ="control-label col-sm-2" for ="app_status">STATUS:</label>
                                    <div class="col-sm-6">
                                        <input type="text" required="" class="form-control" placeholder="" id="app_status" name="app_status" style="text-transform:uppercase" value="<? echo $staffinfo['ver_status'] ?>" />
                                    </div></div>


                                <div class="form-group row" align="left">
                                    <label class ="control-label col-sm-2" for ="ver_date">VERIFIED DATE:</label>
                                    <div class="col-sm-6">
                                        <input type="date" required="" class="form-control" placeholder="" id="ver_date" name="ver_date" style="text-transform:uppercase" value="<? echo $staffinfo['ver_date'] ?>" />
                                    </div></div>



                                <div class="col-sm-12">
                                    <br>
                                    <div class="form-group" align="left">
                                        <label>REMINDER</label>

                                        <p>1. PLEASE ATTACHED TOGETHER SUPPORTING DOCUMENT.</p>
                                        <p>2. THE FORM MUST BE VERIFIED BY HUMAN RESOUCES DEPARTMENT</p>


                                    </div>


                                </div><!-- /.panel-body -->

                                <div class="model-footer">
                                    <div align="right">
                                        <button type="submit" class="btn btn-primary">Submit</button> &nbsp
                                        <a href="../view/aims_lv_medicalver_list.php"><button type="button" class="btn btn-primary">View List</button></a>
                                    </div>
                                    </br>
                                </div>


                                <!-- /.panel-body -->
                            </div>
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <!-- /.container-fluid -->
        </div>

        <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
    </div>

    <!-- /#wrapper -->

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#imageprev').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#image").change(function(){
            readURL(this);
        });


    </script>

    <script>
        function convertToUppercase(el) {
            if(!el || !el.value) return;
            el.value = el.value.toUpperCase();
        }
    </script>

</body>

</html>