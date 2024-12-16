<?php

include ('../controller/auth.php');

require "../model/agromart_functions.php";
require "../model/lookup.php";

$nokp_seller = $_GET['nokp_seller'];
$id_agencies = $_GET['id_agencies'];
$id = $_GET['id'];
$pembekal_info = getPembekalInfoById($id,$id_agencies)->fetch_assoc();

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
<style type="text/css">
    input.unit{
        width: 100px;
        box-sizing: border-box;
        border: 4px solid #ccc;
        border-radius: 4px;
        padding: 8px 8px 8px 8px;
    }
</style>
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

                    <? include ('../../app/global/menu_left.php'); ?>

                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Produk</h1>
                <h4><b><?echo $pembekal_info['nama'];?></b></h4>
                <h4><b><?echo $nokp_seller;?></b></h4>
                <h4><b><?echo $pembekal_info['nama_agensi'];?></b></h4>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">

                <form method="post" action="../controller/agromart_exec.php" enctype="multipart/form-data">
                    <div>
                        <input type="hidden" name="action" value="pembekalHasilTaniAddEdit" />
                        <input type="hidden" name="id" id="id" value="<?echo $id;?>" />
                        <input type="hidden" name="nokp_seller" id="nokp_seller" value="<?echo $nokp_seller;?>" />
                        <input type="hidden" name="id_agencies" id="id_agencies" value="<?echo $id_agencies;?>" />
                        <input type="hidden" name="created_by" id="created_by" value="<?echo $_SESSION['SESS_NAME'];?>" />
                    </div>

                    <!--  <div class="col-xs-3">
                                <label>Tarikh Pendaftaran<font color="red">&nbsp;**</font></label>
                                &nbsp;<input class="form-control" placeholder="" type="date" name="tarikh" id="tarikh" required 
                                value="<?if(!$tarikh){
                        echo date("Y-m-d");
                    }else{
                        echo date($tarikh);
                    }
                    ?>">
                        </div> -->
                    <div class="form-group" align="right">
                    </div>
                    <div class="form-group" align="right">
                        <a href="agromart_admin_pembekal_hasiltani_senarai.php?id=<?echo $id;?>&id_agencies=<?echo $id_agencies;?>&nokp=<?echo $nokp_seller;?>" ><button type="button" class="btn btn-primary">Kembali</button></a>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <label class="control-label" for="date">Kemaskini Maklumat Produk</label>
                        </div>

                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                <tr>
                                    <th width="7%">Bil.</th>
                                    <th width="20%">Nama Item</th>
                                    <th width="18%">Kodbar</th>
                                    <th width="22%">Harga Belian Semasa (RM)</th>
                                    <th width="20%">Kuantiti</th>
                                    <th width="20%"><center><input type="checkbox" id="select_all"  style="width:30px;height:30px;" class="form-control checkbox"/></center></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?
                                $hasiltani = getHasilTaniCheckboxList();
                                $i=1;
                                while($list_hasiltani = $hasiltani->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?echo $i++;?></td>
                                        <td><b><?echo $list_hasiltani['kod'];?></b>&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;<?echo $list_hasiltani['nama'];?></td>
                                        <td>
                                            <?
                                            $barcode = getPembekalHasilTaniKodbar($list_hasiltani['id'],$id_agencies,$nokp_seller);
                                            ?>

                                            <?if($barcode != ''){?>

                                            <p><font size="1"><?echo $list_hasiltani['nama'];?> RM<?echo $list_hasiltani['harga_jualan_semasa'];?></font>
                                                <br><img border=0 alt="<?echo $data['barcode']?>" src="../../util/barcode.php?codetype=Code25&size=30&text=<?echo getPembekalHasilTaniKodbar($list_hasiltani['id'],$id_agencies,$nokp_seller)?>&print=true" />
                                                <?}?>
                                        </td>
                                        <td>
                                            <?
                                            $kuantiti = getPembekalHasilTaniQty($list_hasiltani['id'],$id_agencies,$nokp_seller);
                                            ?>

                                            <?if($kuantiti != '') {?>
                                                <input class="unit" type="text" id="harga_jualan_semasa" name="harga_vals<?echo $list_hasiltani['id'];?>"value="<?echo getPembekalHasilTaniPrice($list_hasiltani['id'],$id_agencies,$nokp_seller)?>"/>
                                            <?}
                                            else {?>
                                                <input class="unit" type="text" id="harga_jualan_semasa" name="harga_vals<?echo $list_hasiltani['id'];?>" value="<?echo $list_hasiltani['harga_belian_semasa'];?>" />
                                            <?}?>
                                        </td>
                                        <td>
                                            <?if($kuantiti != '') {?>
                                                <input class="unit" type="text" min="0" id="kuantiti" name="kuantiti_vals<?echo $list_hasiltani['id'];?>" value="<?echo getPembekalHasilTaniQty($list_hasiltani['id'],$id_agencies,$nokp_seller)?>" />
                                            <?}
                                            else {?>
                                                <input class="unit" type="text" value="1" min="0" id="kuantiti" name="kuantiti_vals<?echo $list_hasiltani['id'];?>" />
                                            <?}?>
                                        </td>
                                        <td><center><input type="checkbox" style="width:30px;height:30px;" class="form-control checkbox" name="hasiltani_ids[]" value="<?echo $list_hasiltani['id'];?>"<?echo getPembekalHasilTaniChecked($list_hasiltani['id'],$id_agencies,$nokp_seller)?>/>
                                        </td>
                                    </tr>
                                <?}?>
                                </tbody>
                            </table>
                        </div>
                    </div>
            </div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="reset" class="btn btn-warning">Tetapan Semula</button>
            </div>
            </form>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
</div>
<!-- /#wrapper -->


<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        //select all checkboxes
        $("#select_all").change(function(){  //"select all" change 
            $(".checkbox").prop('checked', $(this).prop("checked")); //change all ".checkbox" checked status
        });

        //".checkbox" change 
        $('.checkbox').change(function(){
            //uncheck "select all", if one of the listed checkbox item is unchecked
            if(false == $(this).prop("checked")){ //if this item is unchecked
                $("#select_all").prop('checked', false); //change "select all" checked status to false
            }
            //check "select all" if all checkbox items are checked
            if ($('.checkbox:checked').length == $('.checkbox').length ){
                $("#select_all").prop('checked', true);
            }
        });
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    function convertToUppercase(el) {
        if(!el || !el.value) return;
        el.value = el.value.toUpperCase();
    }
</script>

</body>

</html>