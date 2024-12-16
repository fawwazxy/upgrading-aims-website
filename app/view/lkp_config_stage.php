<?php

include ('../controller/auth.php');

require "../model/lkp_function.php";
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
        <?
        $flagScreen="tab_6";
        include ('../global/menu_lkp.php');
        ?>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel-heading" align="right">
                    <button class="btn btn-primary add-new">Tambah Baru</button>
                </div>


                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Data
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables">
                            <thead>
                            <tr>
                                <th width="5%">Bil.</th>
                                <th>Milestone</th>
                                <th>Susunan</th>
                                <th>Task</th>
                                <th>Label</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $datas = getLkpConfigStage();
                            $i=1;
                            while($list = $datas->fetch_assoc()) {
                                $akclass = "success";
                                $aktext = "Nyah Aktifkan";
                                if($list['status'] == "0"){
                                    $akclass = "danger";
                                    $aktext = "Aktifkan";
                                }
                                ?>
                                <tr>
                                    <td><?echo $i++;?></td>
                                    <td><?echo $list['stage'];?></td>
                                    <td><?echo $list['sequence_no'];?></td>
                                    <td><?echo $list['task'];?></td>
                                    <td><?echo $list['label'];?></td>
                                    <td>
                                        <a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-info">Kemaskini</button></a>
                                        <a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary">Simpan</button></a>
                                        <a class="delete" title="XAktif" data-toggle="tooltip"><button type="button" class="btn btn-<?echo $akclass?>"><?echo $aktext?></button></a>
                                        <input type="hidden" id="row_id" value="<?echo $list['id'];?>">
                                    </td>
                                </tr>
                            <?}?>

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
        $('#dataTables').DataTable({
            responsive: true
        });

        //table add update delete
        $(".add-new").click(function(){
            $(this).attr("disabled", "disabled");
            var index = $("table tbody tr:first-child").index();
            var row = '<tr>' +
                '<td>#</td>' +
                '<td><input type="text" required class="form-control" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" size="25%"></td>' +
                '<td><input type="text" required class="form-control" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" size="10%"></td>' +
                '<td><input type="text" required class="form-control" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" size="35%"></td>' +
                '<td><input type="text" required class="form-control" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" size="20%"></td>' +
                '<td>' +
                '<a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary">Simpan</button></a>' +
                '<a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-info">Kemaskini</button></a>' +
                '<a class="delete" title="Delete" data-toggle="tooltip"><button type="button" class="btn btn-danger">Padam</button></a>' +
                '<input type="hidden" name="rowid" id="row_id" value="0"> '+
                '</td>' +
                '</tr>';
            $("table").prepend(row);
            $("table tbody tr").eq(index).find(".add, .edit").toggle();
            $('[data-toggle="tooltip"]').tooltip();
        });
        // Add row on add button click
        $(document).on("click", ".add", function(){
            var empty = false;
            var input = $(this).parents("tr").find('input[type="text"],input[type="hidden"]');

            input.each(function(){
                if(!$(this).val()){
                    $(this).addClass("error");
                    empty = true;
                } else{
                    $(this).removeClass("error");
                }
            });
            $(this).parents("tr").find(".error").first().focus();
            var nameArray = ["stage","sequence_no","task","label","rowid"];
            if(!empty){
                var i=0;
                var data = new FormData();
                data.append('action','lkp_config_stage');

                $.confirm({
                    title: 'PERHATIAN',
                    content: "Adakah anda pasti untuk simpan?",
                    buttons: {
                        YA: function () {
                            input.each(function(){
                                if(i < 4){
                                    $(this).parent("td").html($(this).val().toUpperCase());
                                }
                                //alert($(this).val());
                                data.append(nameArray[i],$(this).val());
                                //data.append("category",$(this).val());
                                //dataArray[i]=$(this).val();
                                i++;
                            });
                            $.ajax({
                                url: "../model/lkp_function.php",
                                type: "POST",
                                processData: false,
                                contentType:false,
                                data: data,
                                success: function (response) {
                                    // you will get response from your php page (what you echo or print)
                                    //$.alert(response);
                                    $.confirm({
                                        title: 'PERHATIAN',
                                        content: response,
                                        buttons: {
                                            OK: function () {
                                                location.href = "lkp_config_stage.php";
                                            }
                                        }});



                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.log(textStatus, errorThrown);
                                    location.href = "lkp_config_stage.php";
                                }


                            });

                        },
                        TIDAK: function () {

                        }
                    }
                });


                //location.href = "harga_semasa_list.php";
                //$("#dataTables-example" ).load( "harga_semasa_list.php #dataTables-example" );
                //$(this).parents("tr").remove();

            }



        });
        // Edit row on edit button click
        $(document).on("click", ".edit", function(){
            var i=0;;
            $(this).parents("tr").find("td:not(:last-child)").each(function(){
                var selectedText = $(this).html();

                if(i==0){

                }else{
                    $(this).html('<input type="text" class="form-control" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" value="' + $(this).text() + '">');
                }

                i++;
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

            if(curr_id == "0"){
                $(this).parents("tr").remove();
                $(".add-new").removeAttr("disabled");
            }else{
                $.ajax({
                    url: "../model/lkp_function.php",
                    type: "POST",
                    data: {action:"removeLkp_config_stage",rowid:curr_id},
                    success: function (response) {
                        // you will get response from your php page (what you echo or print)                 
                        //$.alert(response);
                        // $.confirm({
                        // title: 'PERHATIAN',
                        // content: response,
                        // buttons: {
                        //     OK: function () {
                        //         location.href = "lkp_config_category.php";
                        //         // $(this).parents("tr").remove();
                        //         // $(".add-new").removeAttr("disabled");
                        //     }
                        // }});    

                        location.href = "lkp_config_stage.php";

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                        location.href = "lkp_config_stage.php";
                    }


                });
            }


        });

    });

    function convertToUppercase(e) {
        var charInput = e.keyCode;
        if((charInput >= 97) && (charInput <= 122)) { // lowercase
            if(!e.ctrlKey && !e.metaKey && !e.altKEY) { // no modifier key
                var newChar = charInput - 32;
                var start = e.target.selectionStart;
                var end = e.target.selectionEnd;
                e.target.value = e.target.value.substring(0, start) + String.fromCharCode(newChar) + e.target.value.substring(end);
                e.target.setSelectionRange(start+1, start+1);
                e.preventDefault();
            }
        }
    }
</script>

</body>

</html>