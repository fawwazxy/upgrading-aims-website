<?php

include ('../controller/auth.php');
require "../model/spesifikasi_function.php";
$id = $_GET['id'];
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
        <?
        $flagScreen="tab_5";
        include ('../global/menu_spesifikasi.php');
        ?>

        <div class="row">
        </div>
        <div class="row">
            <div class="panel-heading" align="right">
                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">


            </div>

            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Maklumat Jentera : <b>
                            <?
                            $i=1;
                            $datas = getTajukGambar($id);
                            while($row_datas = $datas->fetch_assoc()){
                                echo $row_datas['nama_spec'];
                            }
                            $i++;
                            ?>
                        </b>
                    </div>

                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table id="dataTables-example" width="100%" class="table table-striped table-bordered table-hover" >
                            <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>Nama Fasa</th>
                                <th>Nama Jentera</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>


                            <tr>

                                <form method="post" action="../controller/spesifikasi_exec.php?act=spesifikasi_jentera_add&id=<? echo $id;?>" >

                                    <!--   <input type="hidden" class="form-control" name="project_code" id="project_code" value="<?echo $data['project_code']?>"> -->
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</</td>
                                    <td>
                                        <select required class="form-control"  name="machinery_id" value="">
                                            <option value="">-- Pilih --</option>

                                            <? $task= getMachinery();
                                            while ($pilih  = $task -> fetch_assoc()){ ?>
                                                <option value="<? echo $pilih['id'];?>"><? echo $pilih['name'];?> </option>
                                            <?}?>
                                        </select>
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </td>
                                </form>

                            </tr>

                            <?
                            $i=1;
                            $log = getMachineryDetail($id);
                            while($list = $log->fetch_assoc()) {

                                ?>

                                <tr class="odd gradeX">

                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $list['detail_name']; ?></td>
                                    <td><?php echo $list['machinery_name']; ?></td>

                                    <td>

                                        <a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary">Simpan</button></a>
                                        <a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-info " onClick="updateId('<?php echo $list['id']; ?>')">Kemaskini</button></a>
                                        <input type="hidden" id="row_id" value="<?echo $list['id']?>">
                                        <br>
                                        <a href="../controller/spesifikasi_exec.php?act=spesifikasi_jentera_delete&id=<? echo $list['id']; ?>"><button type="button" class="btn btn-danger" onclick="return Confirm()">Padam</button>
                                    </td>



                                </tr>
                                <?php $i++; } ?>
                            </tbody>
                        </table>

                        <!-- /.panel-body -->
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




    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
            $(document).on("click", ".add", function(){
                var empty = false;
                var input = $(this).parents("tr").find('select,input[type="hidden"]');
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
                        if (i==0){
                            $(this).parent("td").html($(this).find('option:selected').text());
                        }
                        //alert($(this).val());
                        dataArray[i]=$(this).val();
                        i++;
                    });
                    $(this).parents("tr").find(".add, .edit").toggle();
                    $(".add-new").removeAttr("disabled");
                }


                $.ajax({
                    url: "../model/spesifikasi_function.php",
                    type: "POST",
                    data: {action:"spesifikasi_jentera_update", id_machinery:dataArray[0], id_specs_machinery:dataArray[1]},
                    success: function (response) {
                        // you will get response from your php page (what you echo or print)
                        //$.alert('test here:'+response);

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }


                });

            });
            // Edit row on edit button click
            $(document).on("click", ".edit", function(){
                var i=0;


                $(this).parents("tr").find("td:not(:last-child)").each(function(){
                    if (i>1){
                        var selected = '';
                        var dropdown ='<select required class="form-control"  name="machinery_id" value=>'+
                            ' <option value="">-- Pilih --</option>';

                        <? $task= getMachinery();
                        while ($pilih  = $task -> fetch_assoc()){ ?>

                        if ( $(this).text() == '<? echo $pilih['name'];?>'){
                            selected = 'selected';
                        }else{
                            selected = '';
                        }
                        dropdown +='<option '+selected+' value="<? echo $pilih['id'];?>"><? echo $pilih['name'];?> </option>';
                        <?}?>
                        dropdown +='</select>';
                        $(this).html(dropdown);
                    }
                    i++;
                });
                $(this).parents("tr").find(".add, .edit").toggle();
                $(".add-new").attr("disabled", "disabled");


            });
        });

    </script>
</body>

</html>

