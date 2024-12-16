<?php

include ('../controller/auth.php');
require "../model/spesifikasi_function.php";

$id_specs_details = $_GET['id'];
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
                <h1 class="page-header">Senarai Semak Spesifikasi : <b>
                        <?
                        $i=1;
                        $datas = getTajukGambar($id_specs_details);
                        while($row_datas = $datas->fetch_assoc()){
                            echo $row_datas['nama_spec'];
                        }
                        $i++;
                        ?>
                    </b>
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="panel-heading" align="right">

                <button class="btn btn-primary add-new">Tambah</button>

                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
            </div>

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Semak
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover">


                            <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="70%">Keterangan</th>
                                <th widht="25%">Tindakan</th>
                            </tr>

                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getSpecChecklists($id_specs_details);
                            while($row_data = $data->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['details']; ?></a></td>
                                    <td>
                                        <a class="edit" title="Edit" data-toggle="tooltip">
                                            <button type="button" class="btn btn-info">Kemaskini</button></a>
                                        <a class="add" title="Add" data-toggle="tooltip">
                                            <button type="button" class="btn btn-primary">Simpan</button></a>
                                        <a class="delete" title="Delete" data-toggle="tooltip"><button type="button" class="btn btn-danger">Padam</button></a>
                                        <input type="hidden" id="id_specs_details" value="<?echo $id_specs_details;?>">
                                        <input type="hidden" id="row_id" value="<?echo $row_data['id'];?>">
                                    </td>
                                </tr>
                                <?php $i++; } ?>
                            </tbody>

                        </table>

                    </div>

                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->

            </div>
        </div>

        <? include ('../global/footer.php'); ?>
    </div>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {

            //table add update delete
            $(".add-new").click(function(){
                $(this).attr("disabled", "disabled");
                var index = $("table tbody tr:last-child").index();
                var row = '<tr>' +
                    '<td>'+(index + 2)+'</td>' +
                    '<td><input type="text" required class="form-control" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" size="30%"></td>' +
                    '<td>' +
                    '<a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary">Simpan</button></a>' +
                    '<a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-info">Kemaskini</button></a>' +
                    '<a class="delete" title="Delete" data-toggle="tooltip"><button type="button" class="btn btn-danger">Padam</button></a>' +
                    '<input type="hidden" id="id_specs_details" value="<?echo $id_specs_details;?>"> '+
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
                        if(i == 0){
                            $(this).parent("td").html($(this).val());
                        }
                        //alert($(this).val());
                        dataArray[i]=$(this).val();
                        i++;
                    });


                    $.ajax({
                        url: "../model/spesifikasi_function.php",
                        type: "POST",
                        data: {action:"editSpecCheclist",details:dataArray[0],id_specs_details:dataArray[1],cheklist_id:dataArray[2]},
                        success: function (response) {
                            // you will get response from your php page (what you echo or print)
                            //$.alert(response);
                            $.confirm({
                                title: 'Info',
                                content: response,
                                buttons: {
                                    OK: function () {
                                        location.href = "spesifikasi_checklist.php?id=<?echo $id_specs_details;?>";
                                    }
                                }
                            });



                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                            location.href = "spesifikasi_checklist.php?id=<?echo $id_specs_details;?>";
                        }


                    });


                    //location.href = "harga_semasa_list.php";
                    //$("#dataTables-example" ).load( "harga_semasa_list.php #dataTables-example" );
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
                var row_id = $(this).parents("tr").find('input[id="row_id"]');
                var curr_id="";
                row_id.each(function(){
                    //alert($(this).val());
                    curr_id = $(this).val();
                });



                $.confirm({
                    title: 'PERHATIAN',
                    content: 'Adakah anda pasti untuk padam data?',
                    buttons: {
                        YA: function () {
                            $.ajax({
                                url: "../model/spesifikasi_function.php",
                                type: "POST",
                                data: {action:"removeSpecCheclist",cheklist_id:curr_id },
                                success: function (response) {
                                    // you will get response from your php page (what you echo or print)
                                    //$.alert(response);


                                    location.href = "spesifikasi_checklist.php?id=<?echo $id_specs_details;?>";
                                    $(this).parents("tr").remove();
                                    $(".add-new").removeAttr("disabled");
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.log(textStatus, errorThrown);
                                    location.href = "spesifikasi_checklist.php?id=<?echo $id_specs_details;?>";
                                }


                            });

                        },
                        TIDAK: function () {
                            //$(this).parents("tr").remove();
                            $(".add-new").removeAttr("disabled");

                        }
                    }
                });




            });
        });

        function convertToUppercase(el) {
            if(!el || !el.value) return;
            el.value = el.value.toUpperCase();
        }
    </script>


</body>

</html>
