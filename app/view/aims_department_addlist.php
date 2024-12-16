<?php

include ('../controller/auth.php');

require "../model/aims_departmentcompany_function.php";
require "../model/lookup.php";

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
                <h1 class="page-header">AIMS-GLOBAL DEPARTMENT/UNIT</h1>
            </div>
        </div>
        <?
        //	$flagScreen="tab_1";
        //	include ('../global/menu_departmentcompany.php');
        ?>

        <div class="row">
            <div class="panel-heading" align="right">

                <button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Add New</button>

            </div>
            <div class="col-lg-12">

                <!-- Modal -->
                <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                    <div class="modal-dialog">

                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" align="left" id="myModalLabel">Add Department</h4>
                            </div>

                            <div class="modal-body">

                                <form method="post" action="../controller/aims_departmentadd_exec.php" >

                                    <div class="form-group" align="left">


                                        <label><font color="red">* Required</font></label>
                                        <br>

                                        <div class="form-group"  align="left">
                                            <label>Department/Unit Name<font color="red">*</font>&nbsp;</label>
                                            <input class="form-control" placeholder=" " name="description" onkeyup="convertToUppercase(this)" required>
                                        </div>

                                        <div class="form-group"  align="left">
                                            <label>Department/Unit Shortname<font color="red">*</font>&nbsp;</label>
                                            <input class="form-control" placeholder=" "  name="code_department" onkeyup="convertToUppercase(this)" required>
                                        </div>


                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                            <button type="reset" class="btn btn-info">Reset</button>
                                        </div>

                                </form>
                            </div><!--modal-body-->
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div><!-- /.modal-dialog -->

            </div><!-- /.modal -->


            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="control-label" for="date">Department/Unit List</label>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th width="7%">No.</th>
                                    <th>Department/Unit Name</th>
                                    <th>Shortname</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $department = getDepartmentList();
                                $i=1;
                                while($list_department = $department ->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><? echo $i++;?></td>
                                        <td><? echo $list_department['description']; ?></td>
                                        <td><? echo $list_department['code_department']; ?></td>
                                        </td>
                                        <td>
                                            <!--	<a href="#myModal1" data-toggle="modal" data-id="<? echo $list_department['id'];?>"><button type="button" class="btn btn-info">Edit</button></a>
									-->
                                            <a href="../controller/aims_departmentdelete_exec.php?id=<? echo $list_department['id']; ?>"><button class="btn btn-danger" type="button" onclick="return confirm('Are you sure you want to delete?');">Delete</button></a>
                                        </td>
                                    </tr>
                                <?}?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <!-- /.container-fluid -->
            </div>
            <? include ('../global/footer.php'); ?>

            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->

        <!-- Page-Level Demo Scripts - Tables - Use for reference -->
        <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel2">Update</h4>
                    </div>
                    <div class="modal-body" id="demo3">
                        <script type="text/javascript">
                            $('#myModal1').on('show.bs.modal', function (e) {
                                var rowid = $(e.relatedTarget).data('id');
                                $.ajax({
                                    type:'POST',
                                    url:'aims_department_update.php',
                                    data:{id:rowid},
                                    success:function(html){
                                        $('#demo3').html(html);
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <script>
            $(document).ready(function() {
                $('#dataTables-example').DataTable({
                    responsive: true
                });
            });

            function convertToUppercase(el) {
                if(!el || !el.value) return;
                el.value = el.value.toUpperCase();
            }


        </script>

</body>

</html>