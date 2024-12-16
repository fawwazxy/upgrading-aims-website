<?php
include ('../controller/auth.php');
require "../model/tolak_gaji.php";

$id = $_GET['id'];
$no_staff = $_GET['no_staff'];
$nama = getNama($id) -> fetch_assoc();
$tahun = $_GET['tahun'];
$bulan = $_GET['bulan'];
$dateObj   = DateTime::createFromFormat('!m', $bulan);
$monthName = $dateObj->format('F'); // March
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
    <script type="text/javascript">
        function updateId(curr_updt_id){
            document.getElementById('curr_updt_id').value = curr_updt_id;
        }
    </script>
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include ('../global/menu_top.php'); ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <!--li>
                        <center><img src="images/pic.jpg" class="user-image img-responsive"/></center>
                    </li-->
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Maklumat Penolakan Gaji - <?echo $monthName." ".$tahun;?></h1>
            </div>
            &nbsp;
            <? $staff = getStaffInformations($no_staff) -> fetch_assoc(); ?>
            <input name="no_staff" type="hidden" class="input-short" value="<? echo $no_staff;?>" />
            <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
            <div class="col-lg-12">
                <table>
                    <tr>
                        <td>
                            <p><b> Nama </b></p></td> <td><p><b>:&nbsp;</b></p></td> <td><p><?php echo $staff['name'] ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><b> Jawatan </b></p></td> <td><p><b>:&nbsp;</b></p></td> <td><p><?php echo $staff['role'] ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><b> Bahagian </b></p></td> <td><p><b>:&nbsp;</b></p></td> <td><p><?php echo $staff['bahagian'] ?></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p><b> Gaji </b></p></td> <td><p><b>:&nbsp;</b></p></td> <td><p>RM<?php echo $staff['gaji_basic'] ?></p>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="panel-heading" align="right">
            <button class="btn btn-primary add-new" >Tambah Baru</button>
            <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Maklumat Kakitangan
                    </div>
                    <input type="hidden" id="curr_updt_id" value="0">
                    <div class="panel-body">
                        <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>Jenis Penolakan</th>
                                <th>Jumlah Penolakan (RM)</th>
                                <th>Catatan</th>
                                <th>Tarikh Dibuat</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <? $log_tolak = getTolakGaji($no_staff,$tahun,$bulan);
                            while($list = $log_tolak->fetch_assoc()) {?>
                            <tr class="odd gradeX">
                                <td><?php echo $list['jenis_penolakan']; ?></td>
                                <td><?php echo $list['jumlah_tolak']; ?></td>
                                <td><?php echo $list['catatan']; ?></td>
                                <td id="tmula"><? echo date('d/m/Y',strtotime($list['tarikh_tolak']));?></td>
                                <td>
                                    <a class="add" title="Add" data-toggle="tooltip"><button onClick="myFunction()" type="button" class="btn btn-primary">Simpan</button></a>
                                    <a class="edit" title="Edit" data-toggle="tooltip"><button type="button" class="btn btn-info " onClick="updateId('<?php echo $list['id']; ?>')">Kemaskini</button></a>
                                    <a class="delete" title="Delete" data-toggle="tooltip"><button type="button" class="btn btn-danger" onClick="updateId('<?php echo $list['id']; ?>')">Padam</button></a>
                                    <!--a class="tolak" title="Tolak" data-toggle="tooltip"><button type="button" class="btn btn-warning">Tolak Gaji</button></a-->
                                    <input type="hidden" id="row_id" value="<?php echo $list['id']; ?>">
                                </td>
                            </tr>
                            <?} ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
        $('[data-toggle="tooltip"]').tooltip();
        //var actions = $("table td:last-child").html();
        // Append table with add row form on add new button click
        $(".add-new").click(function(){
            $(this).attr("disabled", "disabled");
            var index = $("#dataTables-example tbody tr:last-child").index();
            var row = '<tr>' +
                '<td><input type="text" class="form-control" name="jenis_penolakan" id="jenis_penolakan"></td>' +
                '<td><input type="text" class="form-control" name="jumlah_tolak" id="jumlah_tolak"></td>' +
                '<td><input type="text" class="form-control" name="catatan" id="catatan"></td>' +
                '<td><input type="hidden" class="form-control" value="<?echo date('Y-m-d');?>" name="tarikh_mula" id="tarikh_mula"></td>' +
                '<td>' +
                '<a class="add" title="Add" data-toggle="tooltip"><button type="button" onClick="myFunction()" class="btn btn-primary">Simpan</button></a>' +
                '<a class="delete" title="Delete" data-toggle="tooltip"><button type="button" class="btn btn-danger" onClick="updateId("<?php echo $list['id']; ?>")">Padam</button></a>' +
                '</td>' +
                '</tr>';
            $("#dataTables-example").append(row);
            $("#dataTables-example tbody tr").eq(index + 1).find(".add, .edit").toggle();
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="tooltip"]').tooltip();

            getDateCustom("tarikh_mula");
        });
        // Add row on add button click
        $(document).on("click", ".add", function(){
            var empty = false;
            var input = $(this).parents("tr").find('input');
            input.each(function(){
                if(!$(this).val()){
                    $(this).addClass("error");
                    empty = true;
                } else{
                    $(this).removeClass("error");
                }
            });
            $(this).parents("tr").find(".error").first().focus();
            var dataArray = ["","","","",""];
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

            var tolak_gaji_id = document.getElementById('curr_updt_id').value;

            $.ajax({
                url: "../model/tolak_gaji.php",
                type: "POST",
                data: {action:"update_tolak_gaji",no_staff:"<?echo $no_staff;?>",tolak_gaji_id:tolak_gaji_id, jenis_penolakan:dataArray[0], jumlah_tolak:dataArray[1],catatan:dataArray[2], tarikh_tolak:dataArray[3]},
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

            getDateCustom("1");
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
            var tolak_gaji_id = curr_id;
            if(tolak_gaji_id != "0"){
                $.ajax({
                    url: "../model/tolak_gaji.php",
                    type: "POST",
                    data: {action:"del_tolak_gaji",tolak_gaji_id:tolak_gaji_id},
                    success: function (response) {
                        // you will get response from your php page (what you echo or print)
                        //$.alert('test here:'+response);
                        document.getElementById('curr_updt_id').value =0;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
        });
    });
    function getDateCustom(tkhMula){
        var tarikh_mula=$('input[name="'+tkhMula+'"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        tarikh_mula.datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
        });
    }
    function myFunction() {
        location.reload();
    }
</script>
</body>
</html>








