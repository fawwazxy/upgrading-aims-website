<?php

include ('../controller/auth.php');

require "../model/staff_function.php";

?>

<?
$id = $_GET['id'];
$no_staff = $_GET['no_staff'];
$nama = getNama($id) -> fetch_assoc();

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


    <script language="javascript" type="text/javascript">
        function updateId(curr_updt_id){
            document.getElementById('curr_updt_id').value = curr_updt_id;
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
        include ('../global/menu_staff.php');
        ?>
        <div class="row">



            <!--div class="panel-heading" align="right">
            <button class="btn btn-primary add-new" data-toggle="modal"  data-target="#myModal">Tambah Baru</button></a>

            </div-->



        </div>
        <div class="panel-heading" align="right">
            <button class="btn btn-primary add-new" data-toggle="modal"  data-target="#myModal">Tambah Baru</button></a>

        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Maklumat Staff
                    </div>
                    <input type="hidden" id="curr_updt_id" value="0">
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>Pencapaian</th>
                                <th>Tempat</th>
                                <th>Tahun Mula</th>
                                <th>Tahun Akhir</th>
                                <th>Keputusan</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i= 1;
                            $list_education = getStaffPendidikan($no_staff);
                            while($row_data_education = $list_education->fetch_assoc()) {
                            ?>

                            <tr class="odd gradeX">

                                <td><?php echo $row_data_education['pencapaian']; ?></td>
                                <td><?php echo $row_data_education['tempat']; ?></td>
                                <td><?php echo $row_data_education['tahun_mula']; ?></td>
                                <td><?php echo $row_data_education['tahun_akhir']; ?></td>
                                <td><?php echo $row_data_education['keputusan']; ?></td>


                                <td>

                                    <a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary">Simpan</button></a>
                                    <a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-info " onClick="updateId('<?php echo $row_data_education['id']; ?>')">Kemaskini</button></a>
                                    <a class="delete" title="Delete" data-toggle="tooltip"><button type="button" class="btn btn-danger" onClick="updateId('<?php echo $row_data_education['id']; ?>')">Padam</button></a>
                                    <input type="hidden" id="row_id" value="<?php echo $row_data_education['id']; ?>">



                                    <?
                                    }

                                    ?>

                                </td>

                            </tr>


                            </tbody>

                        </table>
                        <a href="update_staff_exp.php?id=<?echo $id?>&no_staff=<?echo $no_staff?>"><center><button class="btn btn-info">Seterusnya</button></center></a>
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
        $('#dataTables-example').DataTable({
            responsive: true
        });
        $('[data-toggle="tooltip"]').tooltip();
        //var actions = $("table td:last-child").html();
        // Append table with add row form on add new button click
        $(".add-new").click(function(){
            $(this).attr("disabled", "disabled");
            var index = $("table tbody tr:last-child").index();
            var row = '<tr>' +
                '<td><input type="text" class="form-control" name="pencapaian" id="pencapaian"></td>' +
                '<td><input type="text" class="form-control" name="tempat" id="tempat"></td>' +
                '<td><input type="text" class="form-control" name="tahun_mula" id="tahun_mula"></td>' +
                '<td><input type="text" class="form-control" name="tahun_akhir" id="tahun_akhir"></td>' +
                '<td><input type="text" class="form-control" name="keputusan" id="keputusan"></td>' +

                '<td>' +
                '<a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary">Simpan</button></a>' +
                '<a class="delete" title="Delete" data-toggle="tooltip"><button type="button" class="btn btn-danger" onClick="updateId("<?php echo $list['id']; ?>")">Padam</button></a>' +
                '</td>' +
                '</tr>';
            $("table").append(row);
            $("table tbody tr").eq(index + 1).find(".add, .edit").toggle();
            $('[data-toggle="tooltip"]').tooltip();
        });
        // Add row on add button click
        $(document).on("click", ".add", function(){
            var empty = false;
            var input = $(this).parents("tr").find('input[type="text"]');
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
                    $(this).parent("td").html($(this).val());
                    //alert($(this).val());
                    dataArray[i]=$(this).val();
                    i++;
                });
                $(this).parents("tr").find(".add, .edit").toggle();
                $(".add-new").removeAttr("disabled");
            }

            var staff_edu_id= document.getElementById('curr_updt_id').value;

            $.ajax({
                url: "../model/staff_function.php",
                type: "POST",
                data: {action:"update_education",no_staff:"<?echo $no_staff;?>",staff_edu_id:staff_edu_id, pencapaian:dataArray[0], tempat:dataArray[1], tahun_mula:dataArray[2], tahun_akhir:dataArray[3], keputusan:dataArray[4]},
                success: function (response) {
                    // you will get response from your php page (what you echo or print)
                    //$.alert('test here:'+response);
                    document.getElementById('curr_updt_id').value =0;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }


            });

        });
        // Edit row on edit button click
        $(document).on("click", ".edit", function(){


            $(this).parents("tr").find("td:not(:last-child)").each(function(){
                $(this).html('<input type="text" class="form-control" value="' + $(this).text() + '">');
            });
            $(this).parents("tr").find(".add, .edit").toggle();
            $(".add-new").attr("disabled", "disabled");


        });
        // Delete row on delete button click
        $(document).on("click", ".delete", function(){
            var row_id = $(this).parents("tr").find('input[type="hidden"]');
            var curr_id="";
            row_id.each(function(){
                curr_id = $(this).val();
            });

            $(this).parents("tr").remove();
            $(".add-new").removeAttr("disabled");

            //delete data dalam database
            var staff_edu_id = curr_id;
            if(staff_edu_id != "0"){
                $.ajax({
                    url: "../model/staff_function.php",
                    type: "POST",
                    data: {action:"del_education",staff_edu_id:staff_edu_id},
                    success: function (response) {
                        // you will get response from your php page (what you echo or print)
                        $.alert('test here:'+response);
                        document.getElementById('curr_edit_id').value =0;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }


                });
            }


            // $.confirm({
            // title: 'Confirm!',
            // content: 'Adakah anda pasti untuk padam?',
            // buttons: {
            // YA: function () {
            // //$.alert('Confirmed!');
            // $(this).parents("tr").remove();
            // $(".add-new").removeAttr("disabled");
            // },
            // TIDAK: function () {
            // // $.alert('Canceled!');

            // }

            // }
            // });


        });
    });
</script>

</body>

</html>