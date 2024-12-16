<?php

include ('../controller/auth.php');

require "../model/lkp_function.php";

?>

<?

//$id = $_GET['id'];

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

        $flagScreen="tab_3";
        include ('../global/menu_lkp.php');

        ?>

        <div class="row">
            <div class="col-lg-12">


                <!-- <h1 class="page-header">Tambah Dimensi</h1> -->
            </div>
        </div>




        <div class="row">
            <div class="panel-heading" align="right">
                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">


            </div>

            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Tugasan Projek
                    </div>

                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table id="dataTables-example" width="100%" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th width="3%">#</th>
                                <th>Singkatan Nama Syarikat</th>
                                <th>Jenis Kategori</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>

                                <form method="post" action="../controller/lkp_exec.php?act=lkp_tugasan_projek_add&id=<?echo $id;?>">
                                    <td>&nbsp;</td>

                                    <td><input class="form-control" name="company_shortname" id="company_shortname"> </td>
                                    <td><input class="form-control" name="category_type" id="category_type"> </td>
                                    <td>

                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </td>
                                </form>

                            </tr>

                            <?
                            $i=1;
                            $tugasan_data = getTugasanProjek();
                            while($tugasan = $tugasan_data->fetch_assoc()) {

                                ?>

                                <tr class="odd gradeX">

                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $tugasan['company_shortname']; ?></td>
                                    <td><?php echo $tugasan['category_type']; ?></td>
                                    <td>
                                        <a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary">Simpan</button></a>
                                        <a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-info " onClick="updateId('<?php echo $tugasan['id']; ?>')">Kemaskini</button></a>
                                        <input type="hidden" id="row_id" value="<?echo $tugasan['id']?>">
                                        <!--  <button class="btn btn-info" data-toggle="modal" data-target="#myModal<?//echo $tugasan['id'];?>">Kemaskini</button> -->
                                        <a href="../controller/lkp_exec.php?act=lkp_tugasan_projek_delete&id=<? echo $tugasan['id'];?>"><button type="button" class="btn btn-danger" onclick="return Confirm()">Padam</button>


                                    </td>

                                    <div class="modal fade" id="myModal<?echo $tugasan['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">

                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                    <h4 class="modal-title" align="left" id="myModalLabel">Kemaskini Tugasan Projek</h4>
                                                </div>


                                                <!-- <div class="modal-body">
                          <form method="post" action="../controller/lkp_exec.php?act=lkp_tugasan_projek_edit&id=<? //echo $tugasan['id']; ?>" >

                            <input type="hidden" class="form-control" name="id" id="id" value="<?//echo $tugasan['id'];?>"> 


                          <div class="form-group" align="left">
                          <label>Syarikat</label>
                             <input type="text" class="form-control" name="company_shortname" id="company_shortname" value="<?//echo $tugasan['company_shortname'];?>">
                          </div>

                          <div class="form-group" align="left">
                          <label>Tugasan Projek</label>
                             <input type="text" class="form-control" name="category_type" id="category_type" value="<?//echo $tugasan['category_type'];?>">
                          </div>

                          <div class="modal-footer">
                          <button type="submit" class="btn btn-primary">Simpan</button></a>
                          </div>  
                      </form>
                      </div><-modal-body-->
                                            </div>
                                            <!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->

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
        <!-- /.col-lg-12 -->
        <? include ('../global/footer.php'); ?>
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
            var dataArray = ["",""];
            if(!empty){
                var i=0;
                var data = new FormData();
                data.append('action','lkp_tugasan_projek_edit');

                input.each(function(){
                    if (i==0){
                        $(this).parent("td").html($(this).val());
                        data.append('company_shortname',$(this).val());
                    }else if (i==1){
                        $(this).parent("td").html($(this).val());
                        data.append('category_type',$(this).val());
                    }else if (i==2){
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
                    var dropdown ='<input type="text" class="form-control"  name="company_shortname" value="'+$(this).text()+'" required="">';
                    $(this).html(dropdown);
                } else if (i==2){
                    var selected = '';
                    var dropdown ='<input type="text" class="form-control"  name="category_type" value="'+$(this).text()+'" required="">';
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

