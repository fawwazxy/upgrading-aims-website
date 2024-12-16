<?php

include ('../controller/auth.php');
require "../model/kehadiran_functions.php";
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
        <?
        $flagScreen="tab_6";
        include ('../global/menu_kehadiran.php');
        ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Maklumat Lokasi</h1>
            </div>
        </div>

        <div class="row">
            <div class="panel-heading" align="right">

                <button type="button" class="btn btn-success" onClick="popitup('lokasi_kehadiran_pinned_map.php')">Papar Peta Lokasi</button>
                <button class="btn btn-primary add-new">Tambah</button>


            </div>

            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Lokasi
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover">


                            <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="20%">Lokasi Qr-code</th>
                                <th width="20%">Lokasi</th>
                                <th width="20%">Latitud</th>
                                <th width="20%">Longitud</th>
                                <th widht="15%">Tindakan</th>
                            </tr>

                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getLokasiData();
                            while($row_data = $data->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['name']; ?></td>
                                    <td><?php echo $row_data['cawangan_kod']?></td>
                                    <td><?php echo $row_data['latitude']; ?></td>
                                    <td><?php echo $row_data['longitude']; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-warning" onClick="popitup('../template/qrcode_label.php?id=<? echo $row_data['id']?>')">Cetak Label QR-CODE</button>
                                        <a class="edit" title="Edit" data-toggle="tooltip">
                                            <button type="button" class="btn btn-info">Kemaskini</button></a>
                                        <a class="add" title="Add" data-toggle="tooltip">
                                            <button type="button" class="btn btn-primary">Simpan</button></a>
                                        <a class="delete" title="Delete" data-toggle="tooltip"><button type="button" class="btn btn-danger">Padam</button></a>

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
                '<td><input type="text" required class="form-control" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" size="20%"></td>' +
                '<td><select required class="form-control" name="leave_approval" value="" style="width: 270px">'+
                '<option value="">--Pilih--</option>'+
                <?
                $row_data= getLokasi();
                while ($pilih  = $row_data -> fetch_assoc()){ ?>
                '<option value="<? echo $pilih['cawangan_kod'];?>"><? echo $pilih['cawangan_kod'];?> - <? echo $pilih['nama'];?></option>'+
                <?}?>
                '</select></td>' +
                '<td><input type="text" required class="form-control" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" size="20%"></td>' +
                '<td><input type="text" required class="form-control" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" size="20%"></td>' +
                '<td>' +
                '<a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary">Simpan</button></a>' +
                '<a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-info">Kemaskini</button></a>' +
                '<a class="delete" title="Delete" data-toggle="tooltip"><button type="button" class="btn btn-danger">Padam</button></a>' +
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
            var select = $(this).parents("tr").find('select');

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
            var dataArray2 = [""];
            if(!empty){
                var i=0;
                var j=0;
                input.each(function(){
                    if(i < 4){
                        $(this).parent("td").html($(this).val());
                    }
                    //alert($(this).val());
                    dataArray[i]=$(this).val();
                    i++;
                });

                select.each(function(){
                    $(this).parent("td").html($(this).find("option:selected").text());
                    //$(this).parent("td").html($(this).val());
                    //alert($(this).val());
                    dataArray2[j]=$(this).val();
                    j++;
                });


                $.ajax({
                    url: "../model/kehadiran_functions.php",
                    type: "POST",
                    data: {action:"locationData",lokasi:dataArray[0],cawangan_kod:dataArray2[0],latitude:dataArray[1],
                        longitude:dataArray[2],lkp_id:dataArray[3]},
                    success: function (response) {
                        // you will get response from your php page (what you echo or print)                 
                        //$.alert(response);
                        $.confirm({
                            title: 'Info',
                            content: response,
                            buttons: {
                                OK: function () {
                                    location.href = "lokasi_kehadiran.php";
                                }
                            }
                        });



                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                        location.href = "lokasi_kehadiran.php";
                    }


                });


            }



        });
        // Edit row on edit button click
        $(document).on("click", ".edit", function(){
            var i=0;;
            $(this).parents("tr").find("td:not(:last-child)").each(function(){
                //var selectedText = $(this).html();

                if(i==0){

                }else if(i==2){
                    var selected = '';
                    var dropdown ='<select required class="form-control"  name="leave_approval" style="width: 270px" value=>'+
                        ' <option value="">-- Pilih --</option>';

                    <? $task= getLokasi();
                    while ($pilih  = $task -> fetch_assoc()){ ?>

                    if ( $(this).text() == '<? echo $pilih['cawangan_kod'];?>'){
                        selected = 'selected';
                    }else{
                        selected = '';
                    }
                    dropdown +='<option '+selected+' value="<? echo $pilih['cawangan_kod'];?>"><? echo $pilih['cawangan_kod'];?> - <? echo $pilih['nama'];?></option>';
                    <?}?>
                    dropdown +='</select>';
                    $(this).html(dropdown);

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
                            url: "../model/kehadiran_functions.php",
                            type: "POST",
                            data: {action:"removeLocationData",lkp_id:curr_id },
                            success: function (response) {
                                // you will get response from your php page (what you echo or print)
                                //$.alert(response);


                                location.href = "lokasi_kehadiran.php";
                                $(this).parents("tr").remove();
                                $(".add-new").removeAttr("disabled");
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                console.log(textStatus, errorThrown);
                                location.href = "lokasi_kehadiran.php";
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
