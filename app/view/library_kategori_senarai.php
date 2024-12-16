<?php

include ('../controller/auth.php');

require "../model/library_functions.php";
require "../model/lookup.php";

$flagScreen = 'tab_2';
$kuantiti = $_GET['kuantiti'];

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
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Senarai Kategori</h1>
                <div id='cssmenu'>
                    <ul>
                        <li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="library_kandungan_senarai.php">Bahan Bacaan</a></li>
                        <li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="library_kategori_senarai.php">Kategori</a></li>
                    </ul>
                </div>
                <div class="form-group" align="right">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading" align="left">
                        <label class="control-label" for="date">Senarai Kategori</label>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th width="5%">Bil.</th>
                                <th width="50%">Nama Kategori</th>
                                <th width="20%">Kuantiti</th>
                                <th width="10%">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <form method="post" action="../controller/library_kategori_exec.php" enctype="multipart/form-data">
                                    <div>

                                        <input type="hidden" id="id" name="id" value="0" />
                                        <input type="hidden" name="action" value="kategoriAddEdit" />
                                    </div>
                                    <td>
                                    </td>
                                    <td><input type="text" required class="form-control" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" size="30%" name="jenis" id="jenis"></td>
                                    <td></td>
                                    <td><button type="submit" class="btn btn-warning">Tambah Baharu</button></td>
                                </form>
                            </tr>
                            <?
                            $datas = getKategoriList();
                            $i=1;
                            while($list = $datas->fetch_assoc()) {
                                $status_text = "";
                                if ($list['status'] == '1') {
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
                                    <td><?echo $list['jenis'];?></td>
                                    <td><strong><font color="green" size="5"><?echo $list['kuantiti']?></font></strong></td>
                                    <td>
                                        <a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal-<?php echo $list['id'];?>">Kemaskini</button></a>
                                        <!--<a class="delete" title="Delete" data-toggle="tooltip"><button type="button" class="btn btn-danger">Padam</button></a>-->
                                        <?if($list['kuantiti'] == "0"){?>
                                            <a onclick="nyahaktifKategori(<?echo $list['id'] ;?>,<?echo $list['status'] ;?>)" ><button type="button" class="btn btn-<?echo $color ?>"><?echo $status_text?></button></a>
                                            <input type="hidden" id="row_id" value="<?echo $list['id'];?>"><?}?>
                                        <div class="modal" id="modal-<?php echo $list['id'];?>">
                                            <div class="modal-dialog">

                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                                        <h4 class="modal-title" align="left" id="myModalLabel">Kemaskini Info Kategori</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post" action="../controller/library_kategori_exec.php" enctype="multipart/form-data">
                                                            <div>
                                                                <input type="hidden" name="action" value="kategoriAddEdit" />
                                                                <input type="hidden" id="id" name="id" value="<?echo $list['id']?>" />
                                                            </div>

                                                            <div class="form-group" align="left">
                                                                <label>Nama Kategori<font color="red"> **</font>&nbsp;</label>
                                                                <input class="form-control" placeholder=" " style="text-transform:uppercase" onkeyup="convertToUppercase(this)" name="jenis" id="jenis" required value="<?echo $list['jenis']?>">
                                                            </div>

                                                            <div class="form-group" align="right">
                                                                <button type="submit" class="btn btn-success">Simpan</button>
                                                            </div>

                                                        </form>
                                                    </div>

                                                </div>
                                                <!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div>
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
        // $('#dataTables-example').DataTable({
        //     responsive: true
        // });        
    });

    // Delete row on delete button click
    $(document).on("click", ".delete", function(){
        var row_id = $(this).parents("tr").find('input[type="hidden"]');
        var curr_id="";
        row_id.each(function(){
            curr_id = $(this).val();
        });
        //alert("ghggg");
        $.ajax({
            url: "../model/acara_functions.php",
            type: "POST",
            data: {action:"deleteKumpulan", row_id:row_id.val() },
            success: function (response) {
                $(this).parents("tr").remove();
                $(".add-new").removeAttr("disabled");
                // you will get response from your php page (what you echo or print)                 
                //$.alert(response);
                $.confirm({
                    title: 'Info',
                    content: response,
                    buttons: {
                        OK: function () {
                            location.href = "acara_kumpulan_senarai.php?id_sesi=<?echo $id_sesi?>";
                        }
                    }
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
                location.href = "acara_kumpulan_senarai.php?id_sesi=<?echo $id_sesi?>";
            }


        });

    });


    function nyahaktifKategori(id,status){
        $.ajax({
            url: "../model/library_functions.php",
            type: "POST",
            data: {action:"nyahaktifKategori",id:id,status:status},
            success: function (response) {
                // you will get response from your php page (what you echo or print)
                //$.alert('test here:'+response);

                window.location='library_kategori_senarai.php';
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>

</body>

</html>