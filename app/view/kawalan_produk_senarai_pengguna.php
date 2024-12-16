<?php

include ('../controller/auth.php');

require "../model/kawalan_produk_functions.php";
require "../model/lookup.php";

$kod_produk = $_GET['kod_produk'];

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
                <h1 class="page-header">Senarai Pengguna</h1>
            </div>
            <div class="form-group" align="right">
                <a href="kawalan_produk_senarai.php" class="btn btn-success">Kembali</a>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading" align="left">
                        <label class="control-label" for="date">Senarai Pengguna</label>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <form method="post" action="../controller/kawalan_produk_exec.php">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th width="5%">Bil.</th>
                                    <th width="20%">User Code</th>
                                    <th width="40%">User Name</th>
                                    <th width="10%">Had Penggunaan (Device)</th>
                                    <th width="15%">Status</th>
                                    <th width="10%">Tindakan</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>



                                    <input type="hidden" id="id" name="id" value="0" />
                                    <input type="hidden" id="kod_produk" name="kod_produk" value="<? echo $kod_produk;?>" />
                                    <input type="hidden" name="action" value="PenggunaAddEdit" />

                                    <td>
                                    </td>
                                    <td><input type="text" required class="form-control" style="text-transform:uppercase" onkeyup="convertToUppercase(this)" name="user_code" id="user_code"></td>
                                    <td><input type="text" required class="form-control" name="user_name" id="user_name"></td>
                                    <td><input type="number" step="0" required class="form-control" name="limit" id="limit"></td>
                                    <td></td>
                                    <td><button type="submit" class="btn btn-primary">Tambah Baharu</button></td>

                                </tr>
                                <?
                                $datas = getPenggunaProduk($kod_produk);
                                $i=1;
                                while($list = $datas->fetch_assoc()) {
                                    if ($list['status'] == '1') {
                                        $status_text = "Nyah Aktif";
                                        $color = "danger";
                                        $status="Aktif";
                                        $font_color="blue";
                                        $update_status='0';
                                    }
                                    else {
                                        $status_text = "Aktif";
                                        $color = "success";
                                        $status="Tidak Aktif";
                                        $font_color="red";
                                        $update_status='1';
                                    }
                                    ?>
                                    <tr>
                                        <td><?echo $i++;?></td>
                                        <td><?echo $list['user_code'];?></td>
                                        <td><?echo $list['user_name']?></td>
                                        <td><strong><font size="4"><?echo $list['limit']?></font></strong></td>
                                        <td><strong><font color="<? echo $font_color;?>" size="4"><? echo $status;?></font></strong></td>
                                        <td>
                                            <a href="#myModal1" class="btn btn-info btn-small" data-toggle="modal" data-id="<? echo $list['id'];?>">Kemaskini</a>
                                            <!--<a class="delete" title="Delete" data-toggle="tooltip"><button type="button" class="btn btn-danger">Padam</button></a>-->

                                            <a onclick="nyahaktifPengguna(<?echo $list['id'] ;?>,<?echo  $update_status;?>)" ><button type="button" class="btn btn-<?echo $color ?>"><?echo $status_text?></button></a>
                                            <input type="hidden" id="row_id" value="<?echo $list['id'];?>">
                                        </td>
                                    </tr>
                                <?}?>

                                </tbody>
                            </table>
                        </form>
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
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Kemaskini Maklumat Pengguna</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'GET',
                            url:'kawalan_produk_pengguna_edit.php',
                            data:{id:rowid,kod_produk:"<? echo $kod_produk;?>"},
                            success:function(html){
                                $('#demo').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    // Delete row on delete button click
    // $(document).on("click", ".delete", function(){
    //     var row_id = $(this).parents("tr").find('input[type="hidden"]');
    //     var curr_id="";
    //     row_id.each(function(){
    //         curr_id = $(this).val();
    //     });
    //     //alert("ghggg");
    //     $.ajax({
    //         url: "../model/acara_functions.php",
    //         type: "POST",
    //         data: {action:"deleteKumpulan", row_id:row_id.val() },
    //         success: function (response) {
    //             $(this).parents("tr").remove();
    //     $(".add-new").removeAttr("disabled");
    //         // you will get response from your php page (what you echo or print)
    //         //$.alert(response);
    //         $.confirm({
    //         title: 'Info',
    //         content: response,
    //         buttons: {
    //             OK: function () {
    //                 location.href = "acara_kumpulan_senarai.php?id_sesi=<?echo $id_sesi?>";
    //             }
    //         }
    //     });
    //         },
    //             error: function(jqXHR, textStatus, errorThrown) {
    //              console.log(textStatus, errorThrown);
    //              location.href = "acara_kumpulan_senarai.php?id_sesi=<?echo $id_sesi?>";
    //          }


    //         });

    // });


    function nyahaktifPengguna(id,status){
        $.ajax({
            url: "../model/kawalan_produk_functions.php",
            type: "POST",
            data: {action:"nyahaktifPengguna",id:id,status:status},
            success: function (response) {
                // you will get response from your php page (what you echo or print)
                //$.alert('test here:'+response);

                window.location='kawalan_produk_senarai_pengguna.php?kod_produk=<? echo $kod_produk;?>';
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