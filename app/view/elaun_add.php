<?php

include ('../controller/auth.php');

require "../model/elaun_functions.php";

?>

<?
$id = $_GET['id'];
$no_staff = $_GET['no_staff'];
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
        function updateId(curr_edit_id){
            document.getElementById('curr_edit_id').value = curr_edit_id;
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
            <div class="col-lg-12">

                <h1 class="page-header">Maklumat Rujukan Elaun</h1>
            </div>
            <div class="panel-heading" align="right">
                <button class="btn btn-primary add-new" data-toggle="modal"  data-target="#myModal">Tambah Baharu</button></a>

            </div>



        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Maklumat Elaun
                    </div>
                    <input type="hidden" id="curr_edit_id" value="0">
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example"  data-sort-name="stargazers_count"
                               data-sort-order="desc">
                            <thead>
                            <tr>

                                <th>Kod Jenis Elaun</th>
                                <th>Jenis Elaun</th>
                                <th><br>Rujukan<i>(Table dlm DB)</i></th>
                                <th><br>Rujukan<i>(value dlm Table)</i></th>
                                <th><br>Rujukan<i>(text dlm Table)</i></th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $log_elaun = getLogJenisElaun() ;
                            while($list = $log_elaun->fetch_assoc()) {
                            ?>

                            <tr class="odd gradeX">
                                <td><?php echo $list['code']; ?></td>
                                <td><?php echo $list['jenis_elaun']; ?></td>
                                <td><?php echo $list['table_ref']; ?></td>
                                <td><?php echo $list['value_ref']; ?></td>
                                <td><?php echo $list['text_ref']; ?></td>


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
        $('[data-toggle="tooltip"]').tooltip();
        //var actions = $("table td:last-child").html();
        // Append table with add row form on add new button click
        $(".add-new").click(function(){
            $(this).attr("disabled", "disabled");
            var index = $("table tbody tr:last-child").index();
            var row = '<tr>' +
                '<td><input type="text" class="form-control" name="code" id="code" style="text-transform:uppercase"  pattern="^.*@hotmail\.co\.uk$"></td>' +
                '<td><input type="text" class="form-control" name="jenis_elaun" id="jenis_elaun" style="text-transform:uppercase"></td>' +
                '<td><input type="text" class="form-control" name="table_ref" id="table_ref"></td>' +
                '<td><input type="text" class="form-control" name="value_ref" id="value_ref"></td>' +
                '<td><input type="text" class="form-control" name="text_ref" id="text_ref"></td>' +

                '<td>' +
                '<a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary"  pattern="^.*@hotmail\.co\.uk$">Simpan</button></a>' +
                '<a class="delete" title="Delete" data-toggle="tooltip"><button type="button" class="btn btn-danger" onClick="updateId("<?php echo $list['id']; ?>")">Padam</button></a>' +
                '<input type="hidden" id="row_id" value="0"> '+
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
                    //empty = true;
                } else{
                    $(this).removeClass("error");
                }
            });
            $(this).parents("tr").find(".error").first().focus();
            var dataArray = ["","","","",""];
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

            var jenis_elaun_id = document.getElementById('curr_edit_id').value;

            $.ajax({
                url: "../model/elaun_functions.php",
                type: "POST",
                data: {action:"update_jenis_elaun",no_staff :"<?echo $no_staff ;?>",jenis_elaun_id:jenis_elaun_id,code:dataArray[0], jenis_elaun:dataArray[1], table_ref:dataArray[2], value_ref:dataArray[3],text_ref:dataArray[4]},
                success: function (response) {
                    // you will get response from your php page (what you echo or print)
                    //$.alert('test here:'+response);
                    document.getElementById('curr_edit_id').value =0;
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
            var jenis_elaun_id  = curr_id;
            if( jenis_elaun_id  != "0"){
                $.ajax({
                    url: "../model/elaun_functions.php",
                    type: "POST",
                    data: {action:"del_jenis_elaun", jenis_elaun_id :jenis_elaun_id },
                    success: function (response) {
                        // you will get response from your php page (what you echo or print)
                        //$.alert('test here:'+response);
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