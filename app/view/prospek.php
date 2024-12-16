<?php

include ('../controller/auth.php');

require "../model/prospek_functions.php";

?>

<?
$id = $_GET['id'];
$no_staff = $_GET['no_staff'];


$department_txt = getDepartment();

$jenis_elaun_txt = getJenisElaun();

$table_ref_txt = getTableRef();

// $col_ref_txt = getColRef();

$ref_txt = getNoStaff();



?>
<?



if(isset($_GET['act']) && $_GET['act'] == "delete" && !empty($_GET['id']))
{
    activeElaun($id,0);

}

if(isset($_GET['act']) && $_GET['act'] == "active" && !empty($_GET['id']))
{
    activeElaun($id,1);

}

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

        function Confirm(){
            return confirm('Adakah Anda Pasti untuk NYAH-AKTIFKAN ?');
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
        <div class="row">



            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Prospek</h1>
                </div>
            </div>


            <div class="panel-heading" align="right">
                <button class="btn btn-primary add-new" data-toggle="modal"  data-target="#myModal" >Tambah Baharu</button></a>

            </div>



        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Maklumat Prospek
                    </div>
                    <input type="hidden" id="curr_update_id" value="0">
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example" >
                            <thead>
                            <tr>
                                <th># </th>
                                <th>Nama Prospek </th>
                                <th>Alamat</th>
                                <th>No. Telefon & Email</th>
                                <th>Nama Pegawai Perhubungan</th>
                                <th>Jawatan</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $x=1;
                            $log_lead = getLogLead();
                            while($list = $log_lead->fetch_assoc()) {

                                $lead_id = $list['id'];
                                ?>

                                <tr class="odd gradeX">
                                    <td><?php echo $x?></td>
                                    <td><?php echo $list['lead_name']; ?></td>
                                    <td><?php echo $list['lead_address']; ?></td>
                                    <td><?php echo $list['lead_telno']; ?><br><?php echo $list['lead_email']; ?></td>
                                    <td><?php echo $list['pic_name']; ?></td>
                                    <td><?php echo $list['pic_position']; ?></td>


                                    <td>

                                        <?
                                        if ($list['status'] == 0) { ?>

                                            <?
                                        }
                                        else {
                                        ?>

                                        <a href="prospek.php?act=delete&id=<? echo $lead_id;?>"><button class="btn btn-danger" type="button" onclick="return Confirm()" onClick="myFunction()">NYAH-AKTIF</button>

                                            <?
                                            }

                                            ?>



                                            <a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary" onClick="myFunction()" >Simpan</button></a>






                                    </td>


                                </tr>

                                <?
                                $x++;            }

                            ?>


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

        $('#dataTables-example').DataTable({

            responsive: true,

        });



        $('[data-toggle="tooltip"]').tooltip();
        //var actions = $("table td:last-child").html();
        // Append table with add row form on add new button click
        $(".add-new").click(function(){
            $(this).attr("disabled", "disabled");
            $('input[type=text]').val (function () {
                return this.value.toUpperCase();
            })
            var index = $("table tbody tr:last-child").index();


            var row = '<tr class="odd gradeX">' +
                '<td></td>' +
                '<td> '+

                '<input type="text" class="form-control" name="nama_elaun" id="nama_elaun" style="text-transform:uppercase"  pattern="^.*@hotmail\.co\.uk$"   onkeypress="return testInput(event);" required />' +

                '</td>' +


                '<td><input type="number" class="form-control" name="nilai_elaun" id=nilai_elaun"></td>' +
                '<td> '+
                '<select class="form-control" name="status" id="status">' +
                '<option value="1" data="">AKTIF</option>' +
                '<option value="0" data="">TIDAK AKTIF</option>' +


                '</select>' +

                '</td>' +
                '<td>'+



                '<select class="form-control" name="jenis_elaun" onchange="handleReference(this)" id="jenis_elaun">' +
                '<option value="" data="">-- Pilih --</option>' +

                '<?echo  $jenis_elaun_txt?>' +

                '</select>' +

                '<input type="hidden" id="table_rujukan" value=""/>'+
                '<input type="hidden" id="value_rujukan" value=""/>' +
                '<input type="hidden" id="text_rujukan" value=""/>' +
                '</td>' +






                '<td><span id="ref"></span>' +

                '</td>' +






                '<td>' +
                '<a class="add" title="Add" data-toggle="tooltip"><button type="button" class="btn btn-primary" onClick="myFunction()">Simpan</button></a>' +
                '<a class="delete" title="Delete" data-toggle="tooltip"><button type="button" class="btn btn-danger" onClick="updateId("<?php echo $list['id']; ?>")">Padam</button></a>' +
                '<input type="hidden" id="row_id" value="0"> '+
                '</td>' +
                '</tr>';
            $("table").append(row);
            $("table tbody tr").eq(index + 1).find(".add, .edit").toggle();
            $('[data-toggle="tooltip"]').tooltip();

            $("#nama_elaun").easyAutocomplete(options);

        });


        // Add row on add button click
        $(document).on("click", ".add", function(){
            var empty = false;
            var input = $(this).parents("tr").find('input');
            var select = $(this).parents("tr").find('select');


            //var span = $(this).parents("tr").find('span');
            input.each(function(){
                if(!$(this).val()){
                    $(this).addClass("error");
                    //empty = true;
                } else{
                    $(this).removeClass("error");
                }
            });
            $(this).parents("tr").find(".error").first().focus();
            var dataArray = ["","","","",""];
            var dataArray2 = ["","",""];

            if(!empty){
                var i=0;
                var j=0;




                input.each(function(){
                    if(i<=1){
                        $(this).parent("td").html($(this).val());
                    }
                    //alert($(this).val());
                    dataArray[i]=$(this).val();
                    i++;
                });
                select.each(function(){
                    $(this).parent("td").html($(this).find("option:selected").text());
                    //$(this).parent("td").html($(this).val());
                    //alert($(this).val());
                    dataArray2[j]=$(this).val();
                    j++;
                });



                $(this).parents("tr").find(".add, .edit").toggle();
                $(".add-new").removeAttr("disabled");
            }

            var elaun_id = document.getElementById('curr_update_id').value;


            $.ajax({
                url: "../model/elaun_functions.php",
                type: "POST",
                data: {action:"update_elaun",no_staff:"?echo $no_staff;?>",elaun_id:elaun_id,nama_elaun:dataArray[0], nilai_elaun:dataArray[1], status:dataArray2[0], jenis_elaun:dataArray2[1],table_ref:dataArray[2],col_ref:dataArray[3],ref:dataArray2[2]},


                success: function (response) {
                    // you will get response from your php page (what you echo or print)
                    $.alert('test here:'+response);
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



        });
        // Delete row on delete button click
        $(document).on("click", ".delete", function(){
            $(this).parents("tr").remove();
            $(".add-new").removeAttr("disabled");

            //delete data dalam database
            var elaun_id = document.getElementById('curr_update_id').value;
            if(elaun_id != "0"){
                $.ajax({
                    url: "../model/elaun_functions.php",
                    type: "POST",
                    data: {action:"del_elaun",elaun_id:elaun_id},
                    success: function (response) {
                        // you will get response from your php page (what you echo or print)
                        $.alert('test here:'+response);
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

    function handleReference(obj){

        var data=$('#jenis_elaun').find('option:selected').attr('data');
        //alert(data);
        //var table_ref = document.getElementById('table_ref');
        var table_rujukan = document.getElementById('table_rujukan');
        //table_ref.innerHTML=data;
        table_rujukan.value=data;

        var data2=$('#jenis_elaun').find('option:selected').attr('data2');
        //alert(data2);
        //var col_ref = document.getElementById('col_ref');
        var value_rujukan = document.getElementById('value_rujukan');
        //col_ref.innerHTML=data2;
        value_rujukan.value=data2;

        var data3=$('#jenis_elaun').find('option:selected').attr('data3');
        var text_rujukan = document.getElementById('text_rujukan');
        //col_ref.innerHTML=data2;
        text_rujukan.value=data3;

        var data4=$('#jenis_elaun').find('option:selected').attr('data4');
        //alert(data3);
        var ref = document.getElementById('ref');
        var val_rujukan= document.getElementById('val_rujukan');
        //ref.innerHTML=data3;
        //val_rujukan.value=data3;
        if(table_rujukan.value != ""){
            var dropdown = '<select class="form-control" name="ref"  id="ref">' +
                '<option value="" data="">-- Pilih --</option>';


            $.ajax({
                url: "../model/elaun_functions.php",
                type: "POST",
                data: {action:"getDropDownElaun",value_ref:data2,text_ref:data3,table_ref:data},
                success: function (response) {
                    // you will get response from your php page (what you echo or print)
                    //$.alert('test here:'+response);

                    dropdown +=	response;
                    dropdown +=	'</select>';
                    ref.innerHTML=dropdown;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });



        }else{
            ref.innerHTML="";
        }
    }





    $(":input").on('keyup mouseup', function () {
        var nilai_elaun = $("#nilai_elaun").val();
        $("#reward").text(nilai_elaun);
    }).trigger('mouseup');


    var options = {
        url: "getElaun.php",

        getValue: "name",


        list: {
            match: {
                enabled: true
            }
        },

        theme: "plate-dark"
    };

    function testInput(event) {
        var value = String.fromCharCode(event.which);
        var pattern = new RegExp(/[a-zåäö ]/i);
        return pattern.test(value);
    }

    function myFunction() {
        location.reload();
    }


</script>

</body>




</html>