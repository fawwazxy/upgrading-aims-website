<?php

include ('../controller/auth.php');

require "../model/sales_target_function.php";
$company_id= $_SESSION['SESS_COM'];
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
                <h1 class="page-header">Sasaran Jualan</h1>
            </div>
        </div>
        <?
        $status= $_GET['status'];
        $flagScreen= $_GET['flagScreen'];

        if($flagScreen==''){
            if($status==''){
                $flagScreen='tab_1';
                $status='1';
            }
        }
        include ('../global/menu_status.php');
        ?>
        <br>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Data
                    </div>
                    <div class="panel-body">

                        <table id="dataTables-example"  width="100%" class="table table-striped table-bordered table-hover" >
                            <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="35%">Pekerja</th>
                                <th width="30%">Sasaran Jualan Tahunan (RM)</th>
                                <th width="10%">Tahun</th>
                                <th width="10%">Status</th>
                                <th width="10%">Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?if ($status==1){?>
                                <tr>
                                    <form method="post" action="../controller/sales_target_person_exec.php?act=sales_target_person_add">
                                        <td>&nbsp;</td>
                                        <input type="hidden" class="form-control" name="company_id" id="company_id" value="<?echo $company_id;?>">
                                        <td>
                                            <div class="form-group" align="left">
                                                <select required class="form-control" name="no_staff" value="" style="width: 270px">
                                                    <option value="">--Pilih--</option>
                                                    <?
                                                    $row_data= getNoStaff();
                                                    while ($pilih  = $row_data -> fetch_assoc()){ ?>
                                                        <option value="<? echo $pilih['no_staff'];?>"><? echo $pilih['no_staff'];?> - <? echo $pilih['name'];?></option>
                                                    <?}?>
                                                </select>
                                            </div>
                                        </td>
                                        <td><input type="text" class="form-control" name="target" id="target" size="20"> </td>
                                        <td><input type="number" class="form-control" name="tahun" id="tahun" style="width: 80px"> </td>
                                        <td>AKTIF</td>
                                        <td><a><button type="submit" class="btn btn-primary">Tambah</button></a></td>
                                    </form>
                                </tr>
                            <?}?>

                            <?
                            $i=1;
                            $log = getSalesTargetPerson($status);
                            while($list = $log->fetch_assoc()) {

                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $list['name']; ?><br><?php echo $list['no_staff']; ?></td>
                                    <td><?php echo $list['sales_target_yearly']; ?></td>
                                    <td><?php echo $list['tahun']; ?></td>
                                    <td><?php
                                        if ($list['status']==0){
                                            echo 'TIDAK AKTIF';

                                        }else if ($list['status']==1){
                                            echo 'AKTIF';

                                        } ?>
                                    </td>
                                    <td> <a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary">Simpan</button></a>
                                        <a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-info " onClick="updateId('<?php echo $list['id']; ?>')">Kemaskini</button></a>
                                        <input type="hidden" id="row_id" value="<?echo $list['id']?>">

                                        <?
                                        if($list['status']==1){
                                            ?>
                                            <a href="../controller/sales_target_person_exec.php?act=sales_target_person_status&status=0&id=<?echo $list['id']; ?>"><button type="button" class="btn btn-danger" onclick="return confirm('Anda pasti untuk menukar status kepada TIDAK AKTIF?');">Nyah Aktifkan</button></a>
                                        <?}else if($list['status']==0){?>
                                            <a href="../controller/sales_target_person_exec.php?act=sales_target_person_status&status=1&id=<?echo $list['id']; ?>"><button type="button" class="btn btn-success" onclick="return confirm('Anda pasti untuk menukar status kepada AKTIF?');">Aktifkan</button></a>
                                        <?}?>
                                    </td>
                                </tr>

                                <?php $i++; } ?>
                            </tbody>
                        </table>
                    </div> <!-- /.panel-body -->
                </div>
            </div><!-- /.col-lg-12 -->
        </div><!-- /.row -->

        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    $(document).ready(function() {
        $(document).on("click", ".add", function(){
            var empty = false;
            var input = $(this).parents("tr").find('select, input[type="text"], input[type="hidden"],input[type="dropdown"]');
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
                data.append('action','sales_target_person_update');

                input.each(function(){
                    if (i==0){
                        $(this).parent("td").html($(this).val());
                        data.append('no_staff',$(this).val());
                    }else if (i==1){
                        $(this).parent("td").html($(this).val());
                        data.append('target',$(this).val());
                    }else if (i==2){
                        $(this).parent("td").html($(this).val());
                        data.append('tahun',$(this).val());
                    }else if (i==3){
                        data.append('id',$(this).val());
                    }
                    //alert($(this).val());
                    dataArray[i]=$(this).val();
                    i++;
                });
                $(this).parents("tr").find(".add, .edit").toggle();
                $(".add-new").removeAttr("disabled");



                $.ajax({
                    url: "../model/sales_target_function.php",
                    type: "POST",
                    processData: false,
                    contentType:false,
                    data: data,
                    success: function (response) {
                        // you will get response from your php page (what you echo or print)
                        $.alert('test here:'+response);
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
                    var dropdown ='<select required class="form-control"  name="no_staff" style="width: 270px" value=>'+
                        ' <option value="">-- Pilih --</option>';

                    <? $task= getNoStaff();
                    while ($pilih  = $task -> fetch_assoc()){ ?>

                    if ( $(this).text() == '<? echo $pilih['name'];?><? echo $pilih['no_staff'];?>'){
                        selected = 'selected';
                    }else{
                        selected = '';
                    }
                    dropdown +='<option '+selected+' value="<? echo $pilih['no_staff'];?>"><? echo $pilih['no_staff'];?> - <? echo $pilih['name'];?></option>';
                    <?}?>
                    dropdown +='</select>';
                    $(this).html(dropdown);
                } else if (i==2){
                    var selected = '';
                    var dropdown ='<input type="text" class="form-control"  name="target" value="'+$(this).text()+'" required="">';
                    $(this).html(dropdown);
                } else if (i==3){
                    var selected = '';
                    var dropdown ='<input type="text" class="form-control"  name="tahun" value="'+$(this).text()+'" required="">';
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