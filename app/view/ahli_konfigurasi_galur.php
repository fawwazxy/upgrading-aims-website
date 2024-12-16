<?php

include ('../controller/auth.php');

require "../model/ahli_functions.php";
require "../model/lookup.php";

$flagScreen = 'tab_2'

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
        <?include '../global/ahli_menu_konfigurasi.php'?>

        <div class="row">
            <div class="col-lg-12">
                <div class="form-group" align="right">
                    <button class="btn btn-primary add-new">Tambah Baharu</button>
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label">Senarai Galur</label>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th width="10%">Bil.</th>
                                <th width="15%">Kod</th>
                                <th width="30%">Nama</th>
                                <th width="15%">Status</th>
                                <th width="20%">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $galur = getGalurList();
                            $i=1;
                            while($list_galur = $galur->fetch_assoc()) {
                                $status_edit=konfigurasiButtonKemaskiniNyahAktif('galur',$list_galur['kod']);
                                $status_text = "";
                                if ($list_galur['status'] == '1') {
                                    $status_text = "Nyah Aktif";
                                    $color = "danger";
                                }
                                else {
                                    $status_text = "Aktif";
                                    $color = "success";
                                }
                                ?>
                                <tr>
                                    <td><?echo $i++;?></td>
                                    <td><?echo $list_galur['kod'];?></td>
                                    <td><?echo $list_galur['nama_galur'];?></td>
                                    <td>
                                        <?if($list_galur['status'] == '1')
                                        {
                                            echo '<b><font color="green">'.'Aktif'.'</font></b>';
                                        }
                                        else {
                                            echo '<b><font color="red">'.'Tidak Aktif'.'</font></b>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <? if($status_edit==0){?>
                                            <a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-primary">Kemaskini</button></a>
                                            <br><a onclick="nyahAktifGalur(<?echo $list_galur['id'] ;?>,<?echo $list_galur['status'] ;?>)" ><button type="button" class="btn btn-<?echo $color ?>"><?echo $status_text?></button></a>
                                            <br>
                                        <?}?>
                                        <a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-success">Simpan</button></a>
                                        <input type="hidden" id="row_id" value="<?echo $list_galur['id'];?>">
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
        $('#dataTables-example').DataTable({
            responsive: true
        });

        //Table add,update,delete
        $(".add-new").click(function(){
            $(this).attr("disabled", "disabled");
            var index = $("table tbody tr:last-child").index();
            var row = '<tr>' +
                // '<td>'+(index + 2)+'</td>' +
                '<td>'+'#'+'</td>' +
                '<td><input type="text" required class="form-control" size="25%" style="text-transform:uppercase" onkeyup="convertToUppercase(this)"></td>' +
                '<td><input type="text" required class="form-control" size="55%"></td>' +
                '<td>'+'<b><font color="green">'+'Aktif'+'</td>' +
                '<td>' +
                '<a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-success">Simpan</button></a>' +
                '<a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-primary">Kemaskini</button></a>' +
                '<br><a class="delete" title="Delete" data-toggle="tooltip"><button type="button" class="btn btn-danger">Padam</button></a>' +
                '<input type="hidden" id="row_id" value="0"> '+
                '</td>' +
                '</tr>';
            $("table").append(row);
            $("table tbody tr").eq(index + 1).find(".add, .edit").toggle();
            $('[data-toggle="tooltip"]').tooltip();
        });

        //Add row on add button click
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
            var dataArray = ["","",""];
            if(!empty){
                var i=0;
                input.each(function(){
                    $(this).parent("td").html($(this).val());
                    //alert($(this).val());
                    dataArray[i]=$(this).val();
                    i++;
                });


                $.ajax({
                    url: "../model/ahli_functions.php",
                    type: "POST",
                    data: {action:"galurAddEdit",kod:dataArray[0],nama_galur:dataArray[1],id:dataArray[2]},
                    success: function (response) {
                        // you will get response from your php page (what you echo or print)                 
                        //$.alert(response);
                        $.confirm({
                            title: 'Info',
                            content: response,
                            buttons: {
                                OK: function () {
                                    location.href = "ahli_konfigurasi_galur.php";
                                }
                            }
                        });

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                        location.href = "ahli_konfigurasi_galur.php";
                    }

                });
            }
        });

        //Update row on edit button click
        $(document).on("click", ".edit", function(){
            var i=0;;
            $(this).parents("tr").find("td:not(:last-child)").each(function(){
                var selectedText = $(this).html();

                if(i==0){

                }else if (i==3){
                    $(this).html('' + $(this).text() + '');
                }else{
                    $(this).html('<input type="text" class="form-control" size="45%" value="' + $(this).text() + '">');
                }

                i++;
            });

            $(this).parents("tr").find(".add, .edit").toggle();
            $(".add-new").attr("disabled", "disabled");
        });

        //Delete row on delete button click
        $(document).on("click", ".delete", function(){
            var row_id = $(this).parents("tr").find('input[type="hidden"]');
            var curr_id="";
            row_id.each(function(){
                curr_id = $(this).val();
            });

            $(this).parents("tr").remove();
            $(".add-new").removeAttr("disabled");
        });
    });

    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }

    function nyahAktifGalur(id,status){
        $.ajax({
            url: "../model/ahli_functions.php",
            type: "POST",
            data: {action:"nyahAktifGalur",id:id,status:status},
            success: function (response) {
                // you will get response from your php page (what you echo or print)
                //$.alert('test here:'+response);

                window.location='ahli_konfigurasi_galur.php';
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

</script>

</body>

</html>