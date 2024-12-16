<?php

include ('../controller/auth.php');

require "../model/config_supplier_functions.php";
require "../model/lookup.php";

$flagtab = $_GET['category'];

$stage = $_GET['stage'];
// if(isset($supplier)){
//     echo $supplier = 'set';
// }

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
                <h1 class="page-header">Konfigurasi Milestone</h1>

                <input type="hidden" name="action" value="menuAccess" />
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Pilih Milestone & Stage
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <div class="form-group" align="left">
                            <label>Milestone</label>
                            <select required class="form-control" id="stage" name="stage" value=""
                                    onchange="reloadScreen(this)">
                                <option value="">-- Pilih --</option>
                                <?echo getDropDownStage($stage);?>
                            </select>
                        </div>



                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">


                <?if(isset($stage)){?>
                <div id='cssmenu'>
                    <ul class="tabs">
                        <?
                        $data_category = getCategory();
                        $i=1;
                        while($data = $data_category->fetch_assoc()) {
                            if(!isset($flagtab)){
                                if($i==1){
                                    $active = 'active';
                                    $flagtab = $data['category'];
                                }else{
                                    $active = '';
                                }
                            }else{

                                if($data['category']==$flagtab){
                                    $active = 'active';
                                    //$flagtab = $data['category'];
                                }else{
                                    $active = '';
                                }
                            }
                            ?>
                            <li class="<? echo $active ?>"><a href="config_stage.php?stage=<?echo $stage?>&category=<?echo $data['category']?>"><?echo $data['category']?></a></li>
                            <?$i++;}?>
                    </ul>
                </div>
            </div>
        </div>
        <form method="post" action="../controller/config_supplier_exec.php">
            <input type="hidden" name="action" value="config_stage" />
            <input type="hidden" name="stage" value="<? echo $stage ?>" />
            <input type="hidden" name="category" value="<? echo $flagtab ?>" />

            <div class="row">
                <div class="col-lg-12">
                    <br>

                    <?
                    $data_sub = getSubCategory($flagtab);
                    $i=1;
                    while($data = $data_sub->fetch_assoc()) {
                        ?>
                        <div class="panel panel-default">


                            <div class="panel-heading">
                                <? echo $data['sub_category'] ?>
                            </div>
                            <!-- /.panel-heading -->
                            <div class="panel-body">
                                <table width="100%" class="table table-striped table-bordered table-hover">
                                    <thead>
                                    <tr>
                                        <th>Bil.</th>
                                        <th>Item</th>
                                        <th>Item Kod</th>
                                        <th>Pilih</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?
                                    $data_item = getSubCategoryStage($stage,$flagtab,$data['sub_category']);
                                    $i=1;
                                    while($list = $data_item->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?echo $i++;?></td>
                                            <td><?echo $list['item'];?></td>
                                            <td><?echo $list['item_code'];?></td>
                                            <td width="10%"><input type="checkbox" name="items[]"
                                                                   class="form-control checkbox" value="<?echo $list['id'];?>"
                                                    <?echo $list['cs_id']!=""?"checked":""; ?> />
                                            </td>
                                        </tr>
                                    <?}?>

                                    </tbody>
                                </table>
                            </div>


                            <!-- /.panel-body -->
                        </div>
                    <? }?>
                    <div class="modal-footer">
                        <div class="form-group" align="right">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </div>

                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
                <?}?>
        </form>
        <? include ('../global/footer.php'); ?>
    </div>

    <!-- /.row -->
    <!-- /.container-fluid -->
</div>

<!-- /#page-wrapper -->

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
    });

    function reloadScreen(obj){
        location.href = "config_stage.php?stage="+obj.value;
    }
</script>

</body>

</html>