<?php

include ('../controller/auth.php');

require "../model/project_schedule_function.php";

?>

<?
$id_project = $_GET['id_project'];
$flagScreenmaterial = 'MATERIAL';
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


    <style>
        #myform{
            display: none;

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
                <h1 class="page-header">Members</h1>
            </div>
        </div>
        <? $data=getProject($id_project)->fetch_assoc()?>
        <h3>Kod Projek: <?echo $data['project_code']?></h3>
        <h3>Nama Projek: <?echo $data['project_name']?></h3>
        </br>

        <a href="../view/ps_project_list.php"><input class="btn btn-success" style="float: right;" type="button" value="Kembali"></a>
        </br>

        </br>

        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                </div>
                <div class="panel panel-default">

                    <div class="panel-body">

                        <?
                        $flagScreen="MATERIAL";

                        include ('../global/menu_member.php');
                        ?>
                        <br><br>
                        <table id="dataTables-example"  width="100%" class="table table-striped table-bordered table-hover" >
                            <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th>Type</th>
                                <th>Assigned To</th>
                                <th>Amount (RM)</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>


                            <tr>


                                <form  method="post"  action="../controller/ps_schedule_exec.php?act=ps_member_material_add&id_project=<? echo $id_project?>&member_type=<?echo $flagScreenmaterial?>">
                                    <td>&nbsp;</td>

                                    <td><input type="text" class="form-control" name="roles" id="roles"></td>
                                    <td>
                                        <div class="form-group" align="left">

                                            <select required class="form-control" name="assign" value="">
                                                <option value="">-- Pilih --</option>

                                                <? $assigned= getSupplierMember();
                                                while ($list  = $assigned -> fetch_assoc()){ ?>
                                                    <option value="<? echo $list['supplier_code'];?>"><? echo $list['supplier_code'];?>&nbsp;&nbsp;<? echo $list['company_name'];?></option>
                                                    <?
                                                }
                                                ?>

                                            </select>
                                        </div>
                                    </td>
                                    <td><input type="text" class="form-control" size="10" name="amount" id="amount"></td>


                                    <td>
                                        <button type="submit" class="btn btn-primary">Tambah</button>
                                    </td>
                                </form>

                            </tr>

                            <?
                            $i=1;
                            $dataN = getSMember($data['id'], $flagScreenmaterial);
                            while($list = $dataN->fetch_assoc()) {

                                ?>

                                <tr class="odd gradeX">

                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $list['member_role']; ?></td>
                                    <td><?php echo $list['member_code']; ?>&nbsp;<?php echo $list['name']; ?></td>
                                    <td><?php echo $list['amount_value']; ?></td>
                                    <td>
                                        <a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary">Simpan</button></a>

                                        <a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-info " onClick="updateId('<?php echo $list['id']; ?>')">Kemaskini</button></a>
                                        <input type="hidden" id="row_id" value="<?echo $list['id']?>">
                                        <a href="../controller/ps_schedule_exec.php?act=ps_member_material_delete&id=<? echo $list['id']?>&id_project=<? echo $id_project?>&member_type=<?echo $flagScreenmaterial?>">
                                            <button type="button" align="right" class="btn btn-danger" onClick="return confirm('adakah anda pasti mahu memadam data ini?')";\">Padam</button></a>
                                    </td>
                                </tr>
                                <? $i++;}?>
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

</div>



<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });

    $(document).ready(function() {
        $(document).on("click", ".add", function(){
            var empty = false;
            var input = $(this).parents("tr").find('input[type="text"], select, input[type="hidden"]');
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
                data.append('action','ps_member_team_update');

                input.each(function(){
                    if (i==0){
                        $(this).parent("td").html($(this).val());
                        data.append('roles',$(this).val());
                    }else if (i==1){
                        $(this).parent("td").html($(this).val());
                        data.append('assign',$(this).val());
                    }else if (i==2){
                        $(this).parent("td").html($(this).val());
                        data.append('amount',$(this).val());
                    }
                    else if (i==3){
                        data.append('id',$(this).val());
                    }
                    //alert($(this).val());
                    dataArray[i]=$(this).val();
                    i++;
                });
                $(this).parents("tr").find(".add, .edit").toggle();
                $(".add-new").removeAttr("disabled");



                $.ajax({
                    url: "../model/project_schedule_function.php",
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
                    var dropdown ='<input type="text" class="form-control"  name="roles" value="'+$(this).text()+'" required="">';
                    $(this).html(dropdown);
                } else if (i==2){
                    var selected = '';
                    var dropdown ='<select required class="form-control"  name="assign" value=>'+
                        ' <option value="">-- Pilih --</option>';

                    <? $task= getSupplierMember();
                    while ($pilih  = $task -> fetch_assoc()){ ?>

                    if ( $(this).text() == '<? echo $pilih['supplier_code'];?>'){
                        selected = 'selected';
                    }else{
                        selected = '';
                    }
                    dropdown +='<option '+selected+' value="<? echo $pilih['supplier_code'];?>"><? echo $pilih['supplier_code'];?>&nbsp;&nbsp;<? echo $pilih['person_incharge'];?></option>';
                    <?}?>
                    dropdown +='</select>';
                    $(this).html(dropdown);
                }
                else if (i==3){
                    var selected = '';
                    var dropdown ='<input type="text" class="form-control"  name="amount" value="'+$(this).text()+'" required="">';
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

