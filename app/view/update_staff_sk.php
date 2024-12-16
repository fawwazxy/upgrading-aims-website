<?php

include ('../controller/auth.php');

require "../model/staff_function.php";

?>

<?
$id = $_GET['id'];
$no_staff = $_GET['no_staff'];
$nama = getNama($id) -> fetch_assoc();

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
            color: #404E67;
            background: #F5F7FA;
            font-family: 'Open Sans', sans-serif;
        }
        .table-wrapper {
            width: 700px;
            margin: 30px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 1px 1px rgba(0,0,0,.05);
        }
        .table-title {
            padding-bottom: 10px;
            margin: 0 0 10px;
        }
        .table-title h2 {
            margin: 6px 0 0;
            font-size: 22px;
        }
        .table-title .add-new {
            float: right;
            height: 30px;
            font-weight: bold;
            font-size: 12px;
            text-shadow: none;
            min-width: 100px;
            border-radius: 50px;
            line-height: 13px;
        }
        .table-title .add-new i {
            margin-right: 4px;
        }
        table.table {
            table-layout: fixed;
        }
        table.table tr th, table.table tr td {
            border-color: #e9e9e9;
        }
        table.table th i {
            font-size: 13px;
            margin: 0 5px;
            cursor: pointer;
        }
        table.table th:last-child {
            width: 100px;
        }
        table.table td a {
            cursor: pointer;
            display: inline-block;
            margin: 0 5px;
            min-width: 24px;
        }
        table.table td a.add {
            color: #27C46B;
        }
        table.table td a.edit {
            color: #FFC107;
        }
        table.table td a.delete {
            color: #E34724;
        }
        table.table td i {
            font-size: 19px;
        }
        table.table td a.add i {
            font-size: 24px;
            margin-right: -1px;
            position: relative;
            top: 3px;
        }
        table.table .form-control {
            height: 32px;
            line-height: 32px;
            box-shadow: none;
            border-radius: 2px;
        }
        table.table .form-control.error {
            border-color: #f50000;
        }
        table.table td .add {
            display: none;
        }
    </style>

    <script language="javascript" type="text/javascript">
        function updateId(curr_updt_id){
            document.getElementById('curr_updt_id').value = curr_updt_id;
        }

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


            <?
            $flagScreen="tab_4";
            include ('../global/menu_staff.php');
            ?>

            <!--div class="panel-heading" align="right">
            <button class="btn btn-primary add-new" data-toggle="modal"  data-target="#myModal">Tambah Baru</button></a>

            </div-->



        </div>
        <div class="panel-heading" align="right">
            <button class="btn btn-primary add-new" data-toggle="modal"  data-target="#myModal">Tambah Baru</button></a>

        </div>



        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Maklumat Staff
                    </div>
                    <input type="hidden" id="curr_updt_id" value="0">


                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" align="left" id="myModalLabel">Tambah Maklumat Jawatan</h4>
                                </div>

                                <div class="modal-body">

                                    <form method="post" action="../controller/staf_add_sk_exec.php">




                                        <input name="staff_record_id" type="hidden" class="input-short" value="<? echo $staff_record_id;?>" />
                                        <input name="no_staff" type="hidden" class="input-short" value="<?echo $no_staff;?>" />

                                        <div

                                        <label align="left"><font color="red">** Maklumat Wajib Diisi.</font></label>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Kemahiran<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" type="text" name="skill" value="" required autocomplete="off">


                                </div>


                                <div class="form-group" align="left">
                                    <label>Tahap Kemahiran<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" type="text" name="level" value="" required autocomplete="off">


                                </div>

                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                </div>



                                </form>
                            </div><!--modal-body-->

                        </div>
                        <!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                        <tr>
                            <th>Kemahiran</th>
                            <th>Tahap Kemahiran</th>
                            <th>Tindakan</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?
                        $log_skill = getStaffKemahiran($no_staff);
                        while($list = $log_skill->fetch_assoc()) {
                        ?>

                        <tr class="odd gradeX">
                            <td><?php echo $list['skill']; ?></td>
                            <td><?php echo $list['level']; ?></td>

                            <td>

                                <a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary">Simpan</button></a>
                                <a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-info " onClick="updateId('<?php echo $list['id']; ?>')">Kemaskini</button></a>
                                <a class="delete" title="Delete" data-toggle="tooltip"><button type="button" class="btn btn-danger" onClick="updateId('<?php echo $list['id']; ?>')">Padam</button></a>
                                <input type="hidden" id="row_id" value="<?php echo $list['id']; ?>">



                                <?
                                }

                                ?>

                            </td>

                        </tr>


                        </tbody>

                    </table>

                </div>

                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <? include ('../global/footer.php'); ?>
        <!-- /.col-lg-12 -->
    </div>


    <!-- /.row -->
    <!-- /.container-fluid -->
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
        $('[data-toggle="tooltip"]').tooltip();
        //var actions = $("table td:last-child").html();
        // Append table with add row form on add new button click
        $(".add-new").click(function(){
            $(this).attr("disabled", "disabled");
            var index = $("table tbody tr:last-child").index();
            var row = '<tr>' +
                '<td><input type="text" class="form-control" name="name" id="name"></td>' +
                '<td><input type="text" class="form-control" name="department" id="department"></td>' +
                '<td>' +
                '<a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary">Simpan</button></a>' +
                '<a class="delete" title="Delete" data-toggle="tooltip"><button type="button" class="btn btn-danger" onClick="updateId("<?php echo $list['id']; ?>")">Padam</button></a>' +
                '</td>' +
                '</tr>';
            $("table").append(row);
            $("table tbody tr").eq(index + 1).find(".add, .edit").toggle();
            $('[data-toggle="tooltip"]').tooltip();
        });
        // Add row on add button click
        $(document).on("click", ".add", function(){
            var empty = false;
            var input = $(this).parents("tr").find('input[type="text"]');
            input.each(function(){
                if(!$(this).val()){
                    $(this).addClass("error");
                    empty = true;
                } else{
                    $(this).removeClass("error");
                }
            });
            $(this).parents("tr").find(".error").first().focus();
            var dataArray = ["",""];
            if(!empty){
                var i=0;
                input.each(function(){
                    $(this).parent("td").html($(this).val());
                    //alert($(this).val());
                    dataArray[i]=$(this).val();
                    i++;
                });
                $(this).parents("tr").find(".add, .edit").toggle();
                $(".add-new").removeAttr("disabled");
            }

            var staff_skill_id = document.getElementById('curr_updt_id').value;

            $.ajax({
                url: "../model/staff_function.php",
                type: "POST",
                data: {action:"update_skills",no_staff:"<?echo $no_staff;?>",staff_skill_id:staff


                    _skill_id, skill:dataArray[0], level:dataArray[1]},
                success: function (response) {
                    // you will get response from your php page (what you echo or print)
                    //$.alert('test here:'+response);
                    document.getElementById('curr_updt_id').value =0;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }


            });

        });
        // Edit row on edit button click
        $(document).on("click", ".edit", function(){


            $(this).parents("tr").find("td:not(:last-child)").each(function(){
                $(this).html('<input type="text" class="form-control" value="' + $(this).text() + '">');
            });
            $(this).parents("tr").find(".add, .edit").toggle();
            $(".add-new").attr("disabled", "disabled");


        });
        // Delete row on delete button click
        $(document).on("click", ".delete", function(){
            var row_id = $(this).parents("tr").find('input[type="hidden"]');
            var curr_id="";
            row_id.each(function(){
                curr_id = $(this).val();
            });

            $(this).parents("tr").remove();
            $(".add-new").removeAttr("disabled");

            //delete data dalam database
            var staff_skill_id = curr_id;
            if(staff_skill_id != "0"){
                $.ajax({
                    url: "../model/staff_function.php",
                    type: "POST",
                    data: {action:"del_skill",staff_skill_id:staff_skill_id},
                    success: function (response) {
                        // you will get response from your php page (what you echo or print)
                        $.alert('Anda Pasti untuk Padam?:'+response);
                        document.getElementById('curr_edit_id').value =0;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }


                });
            }

            // $.confirm({
            // title: 'Confirm!',
            // content: 'Adakah anda pasti untuk padam?',
            // buttons: {
            // YA: function () {
            // //$.alert('Confirmed!');
            // $(this).parents("tr").remove();
            // $(".add-new").removeAttr("disabled");
            // },
            // TIDAK: function () {
            // // $.alert('Canceled!');

            // }

            // }
            // });


        });
    });
</script>

</body>

</html>