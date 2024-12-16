<?php



require "../model/pemohon_functions.php";

?>

<?
$pemohon_id = $_GET['pemohon_id'];
$act = $_GET['act'];
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
        function updateId(curr_update_id){
            document.getElementById('curr_update_id').value = curr_update_id;
        }

    </script>

</head>

<body>



<div class="row" >
    <div class="col-sm-1"></div>
    <div class="col-sm-10" align="center">

        <h1 class="page-header"> <b>Borang Permohonan Perjawatan</b></h1>

        <?
        $flagScreen="tab_3";
        $act="add";
        include ('../global/menu_pemohon_perjawatan.php');
        ?>

        <!-- /.col-lg-12 -->
    </div>
    <div class="col-sm-1"></div>

</div>

<div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-10" align="center">
        <div class="panel-heading" align="right">
            <button class="btn btn-primary add-new" data-toggle="modal"  data-target="#myModal">Tambah Baru</button></a>
        </div>

        <div class="panel panel-default">
            <div class="panel-heading" align="left">
                Maklumat Pemohon
            </div>
            <input type="hidden" id="curr_update_id" value="0">
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                    <tr>
                        <th>Nama Syarikat</th>
                        <th>Tarikh Mula Bekerja</th>
                        <th>Tarikh Berhenti Bekerja</th>
                        <th>Gaji</th>
                        <th>Jawatan</th>
                        <th>Peranan</th>
                        <th>Tindakan</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?
                    $log_exp = getLogExperience($pemohon_id);
                    while($list = $log_exp->fetch_assoc()) {
                    ?>

                    <tr class="odd gradeX">
                        <td><?php echo $list['tempat_berkerja']; ?></td>
                        <td id="tmula"><? echo date('d/m/Y',strtotime($list['tarikh_mula']));?></td>
                        <td id="tend"><? echo date('d/m/Y',strtotime($list['tarikh_akhir']));?></td>
                        <td><?php echo $list['gaji']; ?></td>
                        <td><?php echo $list['jawatan']; ?></td>
                        <td><?php echo $list['peranan']; ?></td>

                        <td>

                            <a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary">Simpan</button></a>
                            <a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-info " onClick="updateId('<?php echo $list['id']; ?>')">Kemaskini</button></a>
                            <a class="delete" title="Delete" data-toggle="tooltip"><button type="button" class="btn btn-danger" onClick="updateId('<?php echo $list['id']; ?>')">Padam</button></a>



                            <?
                            }

                            ?>

                        </td>

                    </tr>


                    </tbody>

                </table>

                <a href="permohonan_perjawatan_kemahiran.php?pemohon_id=<? echo $pemohon_id?>"><center><button class="btn btn-info">Seterusnya</button></center></a>

            </div>

            <!-- /.panel-body -->
        </div>
        <div class="col-sm-1"></div>
        <!-- /.panel -->
        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /.col-lg-12 -->
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
                '<td><input type="text" class="form-control" name="name" id="name"></td>' +
                '<td><input type="text" class="form-control" name="tarikh_mula" id="tarikh_mula"></td>' +
                '<td><input type="text" class="form-control" name="tarikh_akhir" id="tarikh_akhir"></td>' +
                '<td><input type="text" class="form-control" name="phone" id="phone"></td>' +
                '<td><input type="text" class="form-control" name="phone" id="phone"></td>' +
                '<td><input type="text" class="form-control" name="phone" id="phone"></td>' +
                '<td>' +
                '<a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary">Simpan</button></a>' +
                '<a class="delete" title="Delete" data-toggle="tooltip"><button type="button" class="btn btn-danger" onClick="updateId(0)">Padam</button></a>' +
                '</td>' +
                '</tr>';
            $("table").append(row);
            $("table tbody tr").eq(index + 1).find(".add, .edit").toggle();
            $('[data-toggle="tooltip"]').tooltip();

            getDateCustom("tarikh_mula","tarikh_akhir");
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
            var dataArray = ["","","","","",""];
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

            var pemohon_exp_id = document.getElementById('curr_update_id').value;

            $.ajax({
                url: "../model/pemohon_functions.php",
                type: "POST",
                data: {action:"edit_experience_jawatan",pemohon_id:"<?echo $pemohon_id;?>",pemohon_exp_id:pemohon_exp_id, tempat_berkerja:dataArray[0], tarikh_mula:dataArray[1], tarikh_akhir:dataArray[2], gaji:dataArray[3], jawatan:dataArray[4], peranan:dataArray[5]},
                success: function (response) {
                    // you will get response from your php page (what you echo or print)
                    //$.alert('test here:'+response);
                    document.getElementById('curr_update_id').value =0;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }


            });

        });
        // Edit row on edit button click
        $(document).on("click", ".edit", function(){
            var i=0;
            $(this).parents("tr").find("td:not(:last-child)").each(function(){
                $(this).html('<input type="text" name="'+i+'" class="form-control" value="' + $(this).text() + '">');
                i++;
            });

            $(this).parents("tr").find(".add, .edit").toggle();
            $(".add-new").attr("disabled", "disabled");

            getDateCustom("1","2");


        });
        // Delete row on delete button click
        $(document).on("click", ".delete", function(){
            $(this).parents("tr").remove();
            $(".add-new").removeAttr("disabled");

            //delete data dalam database
            var pemohon_exp_id = document.getElementById('curr_update_id').value;
            if(pemohon_exp_id != "0"){
                $.ajax({
                    url: "../model/pemohon_functions.php",
                    type: "POST",
                    data: {action:"del_experience_jawatan",pemohon_exp_id:pemohon_exp_id},
                    success: function (response) {
                        // you will get response from your php page (what you echo or print)
                        //$.alert('test here:'+response);
                        document.getElementById('curr_update_id').value =0;
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
    function getDateCustom(tkhMula,tkhAkhir){
        var tarikh_mula=$('input[name="'+tkhMula+'"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        tarikh_mula.datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
        });
        var tarikh_akhir=$('input[name="'+tkhAkhir+'"]'); //our date input has the name "date"
        // var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        tarikh_akhir.datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,

            todayHighlight:true
        });
    }


</script>

</body>

</html>