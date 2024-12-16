<?php

include ('../controller/auth.php');
require "../model/spesifikasi_function.php";

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

    <script src="../../js/dragscroll/dragscroll.js"></script>



    <style>
        #navbarManpower {
            overflow: hidden;
            background-color: #099;
            position: fixed;
            top: 0;
            width: 100%;
            padding-top: 3px;
            padding-bottom: 3px;
            padding-left: 20px;
        }

        #navbarManpower a {
            float: left;
            display: block;
            color: #666;
            text-align: center;
            padding-right: 20px;
            text-decoration: none;
            font-size: 17px;
        }

        #navbarManpower a:hover {
            background-color: #ddd;
            color: black;
        }

        #navbarManpower a.active {
            background-color: #4CAF50;
            color: white;
        }

        #navbarMaterial {
            overflow: hidden;
            background-color: #099;
            position: fixed;
            top: 0;
            width: 100%;
            padding-top: 3px;
            padding-bottom: 3px;
            padding-left: 20px;
        }

        #navbarMaterial a {
            float: left;
            display: block;
            color: #666;
            text-align: center;
            padding-right: 20px;
            text-decoration: none;
            font-size: 17px;
        }

        #navbarMaterial a:hover {
            background-color: #ddd;
            color: black;
        }

        #navbarMaterial a.active {
            background-color: #4CAF50;
            color: white;
        }

        #navbarMachinery {
            overflow: hidden;
            background-color: #099;
            position: fixed;
            top: 0;
            width: 100%;
            padding-top: 3px;
            padding-bottom: 3px;
            padding-left: 20px;
        }

        #navbarMachinery a {
            float: left;
            display: block;
            color: #666;
            text-align: center;
            padding-right: 20px;
            text-decoration: none;
            font-size: 17px;
        }

        #navbarMachinery a:hover {
            background-color: #ddd;
            color: black;
        }

        #navbarMachinery a.active {
            background-color: #4CAF50;
            color: white;
        }

        .mainManpower {
            padding: 16px;
            margin-top: 30px;
            width: 100%;
            height: 80vh;
            overflow: auto;
            cursor: grab;
            cursor: -o-grab;
            cursor: -moz-grab;
            cursor: -webkit-grab;
        }

        .mainManpower img {
            height: auto;
            width: 100%;
        }

        .mainMaterial {
            padding: 16px;
            margin-top: 30px;
            width: 100%;
            height: 80vh;
            overflow: auto;
            cursor: grab;
            cursor: -o-grab;
            cursor: -moz-grab;
            cursor: -webkit-grab;
        }

        .mainMaterial img {
            height: auto;
            width: 100%;
        }

        .mainMachinery {
            padding: 16px;
            margin-top: 30px;
            width: 100%;
            height: 80vh;
            overflow: auto;
            cursor: grab;
            cursor: -o-grab;
            cursor: -moz-grab;
            cursor: -webkit-grab;
        }

        .mainMachinery img {
            height: auto;
            width: 100%;
        }

        .button {
            width: 300px;
            height: 60px;
        }

        .model-content {
            padding: 16px;
        }

        .sticky {
            position: fixed;
            top: 0;
            width: 100%;
        }

        .sticky + .content {
            padding-top: 60px;
        }
    </style>

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
                <h1 class="page-header">Daftar Data Asas</h1>
            </div>
        </div>




        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Senarai Manpower
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">


                    <table id="dataTables-example" width="100%" class="table table-striped table-bordered table-hover" >
                        <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Kumpulan</th>
                            <th>Jawatan</th>
                            <th>Gambar</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                        </thead>
                        <tbody>


                        <tr>

                            <form method="post" enctype="multipart/form-data" action="../controller/spesifikasi_exec.php?act=lkp_manpower_add" >

                                <td>&nbsp;</td>
                                <td>
                                    <select class="form-control"  name="groups" id="groups" value="">
                                        <option value="">-- Pilih --</option>

                                        <? $manpower= getManpower();
                                        while ($pilih  = $manpower -> fetch_assoc()){ ?>
                                            <option value="<? echo $pilih['groups'];?>"><? echo $pilih['groups'];?> </option>
                                        <?}?>
                                    </select><br>
                                    <input class="form-control" rows="5" name="groups" id="groups" />
                                </td>

                                <td><input class="form-control" rows="5" name="positions" id="positions" value="" /></td>
                                <td><img id="image" alt="your image" width="100" height="100" />
                                    <input type="file" onchange="document.getElementById('image').src = window.URL.createObjectURL(this.files[0])" name="image" id="image" placeholder="" value="10000"></a>
                                </td>
                                <td></td>
                                <td>
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </td>
                            </form>

                        </tr>

                        <?
                        $i=1;
                        $log = getManpowerList();
                        while($list = $log->fetch_assoc()) {

                        ?>

                        <tr class="odd gradeX">

                            <td><?php echo $i; ?></td>
                            <td><?php echo $list['groups']; ?></td>
                            <td><?php echo $list['positions']; ?></td>
                            <td><?echo '<img src="data:image/jpeg;base64,'.base64_encode( $list['photos'] ).'" style="width: 210px; height: 240px;"/>';?>
                                <br>
                                <br>
                                <button class="btn btn-info" data-toggle="modal" data-target="#myModalManpower<? echo $list['id']?>">Lihat Gambar</button>


                                <div class="modal fade" id="myModalManpower<? echo $list['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">

                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" align="left" id="myModalLabel"></h4>
                                            </div>

                                            <div id="navbarManpower">
                                                <button type="button" onclick="zoominManpower('myImgManpower<? echo $list["id"]?>')"> Zoom In</button>
                                                <button type="button" onclick="zoomoutManpower('myImgManpower<? echo $list["id"]?>')"> Zoom Out</button>
                                            </div>

                                            <div class="mainManpower dragscroll" style=" overflow: scroll; cursor: grab; cursor : -o-grab; cursor : -moz-grab; cursor : -webkit-grab;">

                                                <?echo '<img id="myImgManpower'.$list['id'].'" src="data:image/jpeg;base64,'.base64_encode( $list['photos'] ).'" style="width: 210px; height: 240px;"/>';?>
                                            </div>
                                        </div><!--modal-body-->

                                    </div>
                                    <!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
                </td>
                <td>
                    <font color="red"><strong>
                            <? if($list['status']== '0'){
                            echo "<font color=red><strong>TIDAK AKTIF</strong></font>";?>

                            <font color="blue"><strong><?
                                    } else if ($list['status'] == '1'){
                                        echo  "<font color=blue><strong>AKTIF</strong></font>";
                                    }?>
                </td>


                <td>
                    <? if($list['status']== '0'){
                        echo "";}
                    else if ($list['status']== '1'){
                    echo "";?>

                    <a class="addManpower" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary">Simpan</button></a>
                    <a class="editManpower title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-info ">Kemaskini</button></a>
                    <input type="hidden" id="row_id" value="<?echo $list['id']?>">
                    <br>
                    <a href="../controller/spesifikasi_exec.php?act=lkp_manpower_status&id=<? echo $list['id']; ?>"><button type="button" class="btn btn-danger" onclick="return Confirm()">Nyahaktif</button>
                        <?}?>
                </td>



                </tr>
                <?php $i++; } ?>
                </tbody>
                </table>

                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>

        <div class="row">

            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Bahan
                    </div>
                    <div class="panel-body">
                        <table id="dataTables-example1" width="100%" class="table table-striped table-bordered table-hover" >
                            <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>Nama Bahan</th>
                                <th>Gambar</th>
                                <th>Status</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>


                            <tr>

                                <form method="post" enctype="multipart/form-data" action="../controller/spesifikasi_exec.php?act=lkp_list" >

                                    <td>&nbsp;</td>

                                    <td>
                                        <input type="text" class="form-control"  name="name" value="" required="">
                                    </td>
                                    <td>
                                        <img id="image" alt="your image" width="100" height="100" />
                                        <input type="file" onchange="document.getElementById('image').src = window.URL.createObjectURL(this.files[0])" name="image" id="image" placeholder="" value="10000"></a>
                                    </td>

                                    <td>&nbsp;</td>
                                    <td>
                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </td>
                                </form>

                            </tr>

                            <?
                            $i=1;
                            $log = getMaterialLookup();
                            while($list = $log->fetch_assoc()) {

                            ?>


                            <tr class="odd gradeX">

                                <td><?php echo $i; ?></td>

                                <td><?php echo $list['name']; ?></td>
                                <td><?echo '<img src="data:image/jpeg;base64,'.base64_encode( $list['photos'] ).'" style="width: 210px; height: 240px;"/>';?>
                                    <br>
                                    <br>
                                    <button class="btn btn-info" data-toggle="modal" data-target="#myModalMaterial<? echo $list['id']?>">Lihat Gambar</button>


                                    <div class="modal fade" id="myModalMaterial<? echo $list['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">

                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" align="left" id="myModalLabel"></h4>
                                                </div>

                                                <div id="navbarMaterial">
                                                    <button type="button" onclick="zoominMaterial('myImgMaterial<? echo $list["id"]?>')"> Zoom In</button>
                                                    <button type="button" onclick="zoomoutMaterial('myImgMaterial<? echo $list["id"]?>')"> Zoom Out</button>
                                                </div>

                                                <div class="mainMaterial dragscroll" style=" overflow: scroll; cursor: grab; cursor : -o-grab; cursor : -moz-grab; cursor : -webkit-grab;">
                                                    <?echo '<img id="myImgMaterial'.$list['id'].'" src="data:image/jpeg;base64,'.base64_encode( $list['photos'] ).'" style="width: 210px; height: 240px;"/>';?>
                                                </div>
                                            </div><!--modal-body-->

                                        </div>
                                        <!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    </td>
                    <td>
                        <font color="red"><strong>
                                <? if($list['status']== '0'){
                                echo "<font color=red><strong>TIDAK AKTIF</strong></font>";?>

                                <font color="blue"><strong><?
                                        } else if ($list['status'] == '1'){
                                            echo  "<font color=blue><strong>AKTIF</strong></font>";
                                        }?>
                    </td>

                    <td>
                        <? if($list['status']== '0'){
                            echo "";}
                        else if ($list['status']== '1'){
                        echo "";?>
                        <a class="addMaterial" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary">Simpan</button></a>
                        <a class="editMaterial" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-info " onClick="updateId('<?php echo $list['id']; ?>')">Kemaskini</button></a>
                        <input type="hidden" id="row_id" value="<?echo $list['id']?>">
                        <br>
                        <a href="../controller/spesifikasi_exec.php?act=spesifikasi_bahan_lkp_status&id=<? echo $list['id']; ?>"><button type="button" class="btn btn-danger">Nyahaktif</button>
                            <?}?>
                    </td>
                    </tr>
                    <?php $i++; } ?>
                    </tbody>
                    </table>

                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    Senarai Jentera
                </div>
                <div class="panel-body">
                    <table id="dataTables-example2" width="100%" class="table table-striped table-bordered table-hover" >
                        <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Nama Jentera</th>
                            <th>Gambar</th>
                            <th>Status</th>
                            <th>Tindakan</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>

                            <form method="post" enctype="multipart/form-data" action="../controller/spesifikasi_exec.php?act=spesifikasi_jentera_lkp_add" >

                                <td>&nbsp;</td>
                                <td>
                                    <input type="text" class="form-control"  name="machinery" value="" required="">
                                </td>

                                <td>
                                    <img id="image" alt="your image" width="100" height="100" />
                                    <input type="file" onchange="document.getElementById('image').src = window.URL.createObjectURL(this.files[0])" name="image" id="image" placeholder="" value="10000"></a>
                                </td>
                                <td>&nbsp;</td>
                                <td>
                                    <button type="submit" class="btn btn-primary">Tambah</button>
                                </td>
                            </form>

                        </tr>

                        <?
                        $i=1;
                        $log = getMachineryLookup();
                        while($list = $log->fetch_assoc()) {

                        ?>

                        <tr class="odd gradeX">

                            <td><?php echo $i; ?></td>

                            <td><?php echo $list['name']; ?></td>
                            <td><?echo '<img src="data:image/jpeg;base64,'.base64_encode( $list['photos'] ).'" style="width: 210px; height: 240px;"/>';?>
                                <br>
                                <br>

                                <button class="btn btn-info" data-toggle="modal" data-target="#myModalMachinery<? echo $list['id']?>">Lihat Gambar</button>


                                <div class="modal fade" id="myModalMachinery<? echo $list['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">

                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                <h4 class="modal-title" align="left" id="myModalLabel"></h4>
                                            </div>

                                            <div id="navbarMachinery">
                                                <button type="button" onclick="zoominJentera('myImgMachinery<? echo $list["id"]?>')"> Zoom In</button>
                                                <button type="button" onclick="zoomoutJentera('myImgMachinery<? echo $list["id"]?>')"> Zoom Out</button>
                                            </div>

                                            <div class="mainMachinery dragscroll" style=" overflow: scroll; cursor: grab; cursor : -o-grab; cursor : -moz-grab; cursor : -webkit-grab;">
                                                <?echo '<img id="myImgMachinery'.$list['id'].'" src="data:image/jpeg;base64,'.base64_encode( $list['photos'] ).'" style="width: 210px; height: 240px;"/>';?>
                                            </div>
                                        </div><!--modal-body-->

                                    </div>
                                    <!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
                </td>
                <td>
                    <font color="red"><strong>
                            <? if($list['status']== '0'){
                            echo "<font color=red><strong>TIDAK AKTIF</strong></font>";?>

                            <font color="blue"><strong><?
                                    } else if ($list['status'] == '1'){
                                        echo  "<font color=blue><strong>AKTIF</strong></font>";
                                    }?>
                </td>
                <td>
                    <? if($list['status']== '0'){
                        echo "";}
                    else if ($list['status']== '1'){
                    echo "";?>
                    <a class="addMachinery" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary">Simpan</button></a>
                    <a class="editMachinery" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-info " onClick="updateId('<?php echo $list['id']; ?>')">Kemaskini</button></a>
                    <input type="hidden" id="row_id" value="<?echo $list['id']?>">
                    <br>
                    <br>
                    <a href="../controller/spesifikasi_exec.php?act=spesifikasi_jentera_lkp_status&id=<? echo $list['id']; ?>"><button type="button" class="btn btn-danger">Nyahaktif</button>
                        <?}?>
                </td>

                </tr>
                <?php $i++; } ?>
                </tbody>
                </table>

                <!-- /.panel-body -->
            </div>
        </div>
        <!-- /.row -->
        <!-- /.container-fluid -->
        <? include ('../global/footer.php'); ?>
    </div>

    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->
</div>
</div>




<!-- /lkp_manpower -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#dataTables-example1').DataTable({
            responsive: true
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('#dataTables-example2').DataTable({
            responsive: true
        });
    });
</script>

<!-- /lkp_machinery -->
<script>
    $(document).ready(function() {
        $(document).on("click", ".addMachinery", function(){
            var empty = false;
            var input = $(this).parents("tr").find('input[type="text"], input[type="file"], input[type="hidden"]');
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
                var data = new FormData();
                data.append('action','spesifikasi_jentera_lkp_update');

                input.each(function(){
                    if (i==0){
                        $(this).parent("td").html($(this).val());
                        data.append('machinery',$(this).val());
                    }else if (i==1){
                        data.append('image',$(this)[0].files[0]);
                    }else if (i==2){
                        data.append('id',$(this).val());
                    }
                    //alert($(this).val());
                    dataArray[i]=$(this).val();
                    i++;
                });
                $(this).parents("tr").find(".addMachinery, .editMachinery").toggle();
                $(".add-new").removeAttr("disabled");



                $.ajax({
                    url: "../model/spesifikasi_function.php",
                    type: "POST",
                    processData: false,
                    contentType:false,
                    data: data,
                    success: function (response) {
                        // you will get response from your php page (what you echo or print)
                        //$.alert('test here:'+response);
                        location.reload();

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }


                });
            }



        });
        // Edit row on edit button click
        $(document).on("click", ".editMachinery", function(){
            var i=0;

            $(this).parents("tr").find("td:not(:last-child)").each(function(){
                if (i==1){
                    var selected = '';
                    var dropdown ='<input type="text" class="form-control"  name="machinery" value="'+$(this).text()+'" required="">';
                    $(this).html(dropdown);
                } else if (i==2){
                    var selected = '';
                    var dropdown =$(this).html()+'<input type="file" name="image" id="image" placeholder="" value="10000"></a>';
                    $(this).html(dropdown);
                }
                i++;
            });
            $(this).parents("tr").find(".addMachinery, .editMachinery").toggle();
            $(".add-new").attr("disabled", "disabled");


        });
    });

</script>


<script>
    $(document).ready(function() {
        $(document).on("click", ".addManpower", function(){
            var empty = false;
            var input = $(this).parents("tr").find('input[type="text"],input[type="text"], input[type="file"], input[type="hidden"]');
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
                var data = new FormData();
                data.append('action','lkp_manpower_update');

                input.each(function(){
                    if (i==0){
                        $(this).parent("td").html($(this).val());
                        data.append('groups',$(this).val());
                    }else if (i==1){
                        $(this).parent("td").html($(this).val());
                        data.append('positions',$(this).val());
                    }else if (i==2){
                        data.append('image',$(this)[0].files[0]);
                    }else if (i==3){
                        data.append('id',$(this).val());
                    }
                    //alert($(this).val());
                    dataArray[i]=$(this).val();
                    i++;
                });
                $(this).parents("tr").find(".addManpower, .editManpower").toggle();
                $(".add-new").removeAttr("disabled");



                $.ajax({
                    url: "../model/spesifikasi_function.php",
                    type: "POST",
                    processData: false,
                    contentType:false,
                    data: data,
                    success: function (response) {
                        // you will get response from your php page (what you echo or print)
                        //$.alert('test here:'+response);
                        location.reload();

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }


                });
            }



        });
        // Edit row on edit button click
        $(document).on("click", ".editManpower", function(){
            var i=0;

            $(this).parents("tr").find("td:not(:last-child)").each(function(){
                if (i==1){
                    var selected = '';
                    var dropdown ='<input type="text" class="form-control"  name="groups" value="'+$(this).text()+'" required="">';
                    $(this).html(dropdown);
                }else if (i==2){
                    var selected = '';
                    var dropdown ='<input type="text" class="form-control"  name="positions" value="'+$(this).text()+'" required="">';
                    $(this).html(dropdown);
                } else if (i==3){
                    var selected = '';
                    var dropdown =$(this).html()+'<input type="file" name="image" id="image" placeholder="" value="10000"></a>';
                    $(this).html(dropdown);
                }
                i++;
            });
            $(this).parents("tr").find(".addManpower, .editManpower").toggle();
            $(".add-new").attr("disabled", "disabled");


        });
    });

</script>

<!-- /lkp_material -->

<script>
    $(document).ready(function() {
        $(document).on("click", ".addMaterial", function(){
            var empty = false;
            var input = $(this).parents("tr").find('input[type="text"], input[type="file"], input[type="hidden"]');
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
                var data = new FormData();
                data.append('action','spesifikasi_bahan_lkp_update');

                input.each(function(){
                    if (i==0){
                        $(this).parent("td").html($(this).val());
                        data.append('name',$(this).val());
                    }else if (i==1){
                        data.append('image',$(this)[0].files[0]);
                    }else if (i==2){
                        data.append('id',$(this).val());
                    }
                    //alert($(this).val());
                    dataArray[i]=$(this).val();
                    i++;
                });
                $(this).parents("tr").find(".addMaterial, .editMaterial").toggle();
                $(".add-new").removeAttr("disabled");



                $.ajax({
                    url: "../model/spesifikasi_function.php",
                    type: "POST",
                    processData: false,
                    contentType:false,
                    data: data,
                    success: function (response) {
                        // you will get response from your php page (what you echo or print)
                        //$.alert('test here:'+response);
                        location.reload();

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }


                });
            }



        });
        // Edit row on edit button click
        $(document).on("click", ".editMaterial", function(){
            var i=0;

            $(this).parents("tr").find("td:not(:last-child)").each(function(){
                if (i==1){
                    var selected = '';
                    var dropdown ='<input type="text" class="form-control"  name="name" value="'+$(this).text()+'" required="">';
                    $(this).html(dropdown);
                } else if (i==2){
                    var selected = '';
                    var dropdown =$(this).html()+'<input type="file" name="image" id="image" placeholder="" value="10000"></a>';
                    $(this).html(dropdown);
                }
                i++;
            });
            $(this).parents("tr").find(".addMaterial, .editMaterial").toggle();
            $(".add-new").attr("disabled", "disabled");


        });
    });


    function zoominManpower(id_image) {
        var myImg = document.getElementById(id_image);
        var currWidth = myImg.clientWidth;
        var currHeight = myImg.clientHeight;
        if (currWidth == 2500 && currHeight == 2500) return false;
        else {
            myImg.style.width = (currWidth + 100) + "px";
            myImg.style.height = (currHeight + 100) + "px";
        }
    }

    function zoomoutManpower(id_image) {
        var myImg = document.getElementById(id_image);
        var currWidth = myImg.clientWidth;
        var currHeight = myImg.clientHeight;
        if (currWidth == 100 && currHeight == 250) return false;
        else {
            myImg.style.width = (currWidth - 100) + "px";
            myImg.style.height = (currHeight - 100) + "px";
        }
    }

    function zoominMaterial(id_image_material) {
        var myImg = document.getElementById(id_image_material);
        var currWidth = myImg.clientWidth;
        var currHeight = myImg.clientHeight;
        if (currWidth == 2500 && currHeight == 2500) return false;
        else {
            myImg.style.width = (currWidth + 100) + "px";
            myImg.style.height = (currHeight + 100) + "px";
        }
    }

    function zoomoutMaterial(id_image_material) {
        var myImg = document.getElementById(id_image_material);
        var currWidth = myImg.clientWidth;
        var currHeight = myImg.clientHeight;
        if (currWidth == 100 && currHeight == 250) return false;
        else {
            myImg.style.width = (currWidth - 100) + "px";
            myImg.style.height = (currHeight - 100) + "px";
        }
    }

    function zoominJentera(id_image_jentera) {
        var myImg = document.getElementById(id_image_jentera);
        var currWidth = myImg.clientWidth;
        var currHeight = myImg.clientHeight;
        if (currWidth == 2500 && currHeight == 2500) return false;
        else {
            myImg.style.width = (currWidth + 100) + "px";
            myImg.style.height = (currHeight + 100) + "px";
        }
    }

    function zoomoutJentera(id_image_jentera) {
        var myImg = document.getElementById(id_image_jentera);
        var currWidth = myImg.clientWidth;
        var currHeight = myImg.clientHeight;
        if (currWidth == 100 && currHeight == 250) return false;
        else {
            myImg.style.width = (currWidth - 100) + "px";
            myImg.style.height = (currHeight - 100) + "px";
        }
    }

    // When the user scrolls the page, execute myFunction
    window.onscroll = function() {myFunction()};

    // Get the navbar
    var navbar = document.getElementById("navbarMaterial");

    // Get the offset position of the navbar
    var sticky = navbar.offsetTop;

    // Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
    function myFunction() {
        if (window.pageYOffset >= sticky) {
            navbar.classList.add("sticky")
        } else {
            navbar.classList.remove("sticky");
        }
    }


</script>
</body>

</html>

