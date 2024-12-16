<?php

include ('../controller/auth.php');

require "../model/lkp_function.php";

?>

<?

$id = $_GET['id'];
$com_id = $_SESSION['SESS_COM'];

?>

<style>
    div.ex1 {
        height: 500px;
        overflow: scroll;
    }
</style>

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

<body data-spy="scroll" data-target=".scroll">

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
        include ('../global/menu_penawaran_jawatan.php');

        ?>

        <div class="row">
            <div class="col-lg-12">


            </div>
        </div>




        <div class="row">
            <div class="panel-heading" align="right">
                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">


            </div>

            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Zon
                    </div>

                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table id="dataTables-example" width="100%" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th width="3%">#</th>
                                <th>Skop bagi</th>
                                <th>Keterangan</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>

                                <form method="post" action="../controller/skop_kerja_exec.php?act=add&id=<?echo $id;?>">
                                    <td>&nbsp;</td>

                                    <td>
                                        <input type="hidden" name="com_id" value="<?echo $com_id;?>">
                                        <input class="form-control" name="role" id="role" size="20">
                                    </td>
                                    <td><textarea name="keterangan" cols="100" rows="10"></textarea> </td>
                                    <td>
                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </td>
                                </form>

                            </tr>

                            <?
                            $i=1;
                            $skop_data = getSkopKerja();
                            while($skop = $skop_data->fetch_assoc()) {

                                ?>

                                <tr class="odd gradeX">

                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $skop['role']; ?></td>
                                    <td><?php echo $skop['keterangan']; ?></td>
                                    <td>
                                        <a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary">Simpan</button></a>
                                        <a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-info">Kemaskini</button></a><br>
                                        <input type="hidden" id="row_id" value="<?echo $skop['id']?>">
                                        <a href="../controller/skop_kerja_exec.php?act=delete&id=<? echo $skop['id'];?>"><button type="button" class="btn btn-danger" onclick="return Confirm()">Padam</button></a><br>
                                        <a href="" onclick="return popitup('../template/skop_kerja.php?skopid=<? echo $skop['id'];?>&com_id=<? echo $skop['company_id'];?>')" ><button type="button" class="btn btn-warning">Skop Kerja</button></a><br>


                                    </td>

                                </tr>
                                <?php $i++; } ?>
                            </tbody>
                        </table>
                    </div>

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





<script type="text/javascript">


</script>
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

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
            //var dataArray = ["",""];
            if(!empty){
                var i=0;
                var data = new FormData();
                data.append('action','update');

                input.each(function(){
                    if (i==0){
                        $(this).parent("td").html($(this).val());
                        data.append('role',$(this).val());
                    }else if (i==1){
                        $(this).parent("td").html($(this).val());
                        data.append('keterangan',$(this).val());
                    }else if (i==2){
                        data.append('id',$(this).val());
                    }
                    //alert($(this).val());
                    //dataArray[i]=$(this).val();
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
                    var dropdown ='<input type="text" class="form-control"  name="role" size="20" value="'+$(this).text()+'" required="">';
                    $(this).html(dropdown);
                } else if (i==2){
                    var selected = '';
                    var dropdown ='<textarea name="keterangan" cols="100" rows="10">'+$(this).text()+'</textarea>';
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

