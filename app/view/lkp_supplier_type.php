<?php

include ('../controller/auth.php');
require "../model/lkp_function.php";
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
            return confirm('Adakah Anda Pasti untuk padam data ini?');
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
        $flagScreen="tab_2";
        include ('../global/menu_lkp.php');
        ?>
        <div class="row">
            <div class="panel-heading" align="right">
                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">


            </div>

            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Pembekal
                    </div>

                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table id="dataTables-example" width="100%" class="table table-striped table-bordered table-hover" >
                            <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>Jenis Pembekal</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>


                            <tr>

                                <form method="post" action="../controller/lkp_exec.php?act=lkp_supplier_add" >
                                    <td>&nbsp;</td>
                                    <td>
                                        <input type="text" class="form-control" name="supplier_type" id="supplier_type" placeholder="Jenis Pembekal">
                                    </td>
                                    <td>
                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </td>
                                </form>

                            </tr>

                            <?
                            $i=1;
                            $log = getSupplier();
                            while($list = $log->fetch_assoc()) {

                                ?>

                                <tr class="odd gradeX">

                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $list['type']; ?></td>

                                    <td>
                                        <a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary">Simpan</button></a>
                                        <a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-info ">Kemaskini</button></a>
                                        <input type="hidden" id="row_id" value="<?echo $list['id']?>">
                                        <!--                      <button class="btn btn-info" data-toggle="modal" data-target="#myModal<? echo $list['id']?>">Kemaskini</button>
 -->                    <br>
                                        <a href="../controller/lkp_exec.php?act=lkp_supplier_delete&id=<? echo $list['id']; ?>"><button type="button" class="btn btn-danger" onclick="return Confirm()">Padam</button>
                                    </td>


                                    <div class="modal fade" id="myModal<? echo $list['id']?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">

                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" align="left" id="myModalLabel">Kemaskini Pembekal</h4>
                                                </div>


                                                <div class="modal-body">
                                                    <form method="post" action="../controller/lkp_exec.php?act=lkp_supplier_update&id=<? echo $list['id']; ?>" >


                                                        <div class="form-group" align="left">
                                                            <label>Jenis Pembekal</label>
                                                            <input type="text" class="form-control" name="supplier_type" id="supplier_type" value="<?echo $list['type'];?>">
                                                        </div>


                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary">Simpan</button></a>
                                                        </div>
                                                    </form>
                                                </div><!--modal-body-->

                                            </div>
                                            <!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
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
        });
    </script>

    <script>
        $(document).ready(function() {
            $(document).on("click", ".add", function(){
                var empty = false;
                var input = $(this).parents("tr").find('input[type="text"], input[type="hidden"]');
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
                    data.append('action','lkp_supplier_update');

                    input.each(function(){
                        if (i==0){
                            $(this).parent("td").html($(this).val());
                            data.append('supplier_type',$(this).val());
                        }else if (i==1){
                            data.append('id',$(this).val());
                        }
                        //alert($(this).val());
                        dataArray[i]=$(this).val();
                        i++;
                    });
                    $(this).parents("tr").find(".add, .edit").toggle();
                    $(".add-new").removeAttr("disabled");



                    $.ajax({
                        url: "../model/lkp_function.php",
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
            $(document).on("click", ".edit", function(){
                var i=0;

                $(this).parents("tr").find("td:not(:last-child)").each(function(){
                    if (i==1){
                        var selected = '';
                        var dropdown ='<input type="text" class="form-control"  name="supplier_type" value="'+$(this).text()+'" required="">';
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

