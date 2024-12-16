<?php

include ('../controller/auth.php');
//require "../global/menu_bulan1.php";
require "../model/analisa_function.php";

?>
<?
$id=$_GET['id'];
$no_staff=$_GET['no_staff'];
$bulan=$_GET['bulan'];
$tahun=$_GET['tahun'];
$flagtahun=$_GET['flagtahun'];
if($flagtahun == "") "tb_1";
$flag=$_GET['flg'];
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


    <script language="JavaScript" type="text/javascript">
        function Confirm(){
            return confirm('Adakah Anda Pasti untuk tekan butang berhenti ini?');
        }

        function Confirm2(){
            return confirm('Adakah Anda Pasti untuk tekan butang bekerja ini??');
        }


    </script>
    <script language="javascript" type="text/javascript">
        <!--
            function popitup(url) {
                /*newwindow=window.open(url,'name','height=842,width=595');*/
                newwindow=window.open(url,'name','height=595,width=842');
                if (window.focus) {newwindow.focus()}
                return false;
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
        $flagScreen="tab_1";
        include ('../global/menu_analisa_perniagaan.php');
        ?>



        <br>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Adjustment
                    </div>
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="adjustment">
                            <thead>
                            <tr>
                                <th>Tahun</th>
                                <th>Overhead/Month (RM)</th>
                                <th>Untung Disasarkan (RM)</th>
                                <th>Margin Untung (%)</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>

                            <tbody>

                            <tr class="odd gradeX">
                                <td><input class="form-control" type="text" name="tahun" id="tahun" maxlength="4" size="5" /></td>
                                <td><input class="form-control" type="number" name="overhead_month" id="overhead_month" min="0.01" step="0.01" max="2500"/></td>
                                <td><input class="form-control" type="number" name="untung_disasarkan" id="untung_disasarkan"/></td>
                                <td><input class="form-control" type="number" name="margin_untung" id="margin_untung"/></td>

                                <td>
                                    <button class="btn btn-info" onclick="addAnalisa()" type="button" >Papar</button>

                                </td>

                            </tr>


                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Maklumat Perbelanjaan Syarikat
                    </div>

                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="sasaran">
                            <thead>
                            <tr>
                                <th>Bil.</th>
                                <th>Tahun</th>
                                <th>Overhead (RM)</th>
                                <th>Untung Disasarkan (RM)</th>
                                <th>Margin Untung (%)</th>
                                <th>Margin Kos (%)</th>
                                <th>BEP (RM)</th>
                                <th>BEP+Profit (RM)</th>
                                <th>Target Sale (RM)</th>
                                <th>Status</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?
                            $i= 1;

                            $data = getSalesTarget($_SESSION['SESS_COM']);
                            while($row_data = $data->fetch_assoc()) {

                                ?>
                                <tr>
                                    <td><?php echo $i++; ?></td>
                                    <td><?php echo $row_data['target_year']; ?></td>
                                    <td>Month : <?php echo $row_data['target_monthly_overhead']; ?><br>
                                        Year : <?php echo $row_data['target_yearly_overhead']; ?></td>
                                    <td><?php echo $row_data['target_profit']; ?></td>
                                    <td><?php echo $row_data['target_profit_margin']; ?></td>
                                    <td><?php echo $row_data['target_cost_margin']; ?></td>
                                    <td>Month : <?php echo $row_data['target_monthly_bep']; ?><br>
                                        Year : <?php echo $row_data['target_yearly_bep']; ?></td>
                                    <td>Month : <?php echo $row_data['target_monthly_bep_profit']; ?><br>
                                        Year : <?php echo $row_data['target_yearly_bep_profit']; ?></td>
                                    <td>Month : <?php echo $row_data['target_monthly_sale']; ?><br>
                                        Year : <?php echo $row_data['target_yearly_sale']; ?></td>
                                    <td><?php echo ($row_data['status'] == 1)? "Aktif":"Tidak Aktif" ?></td>
                                    <td>
                                        <i class="glyphicon glyphicon-remove" on></i>
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
        $('#sasaran').DataTable({
            responsive: true
        });

        Number.prototype.formatMoney = function(c, d, t){
            var n = this,
                c = isNaN(c = Math.abs(c)) ? 2 : c,
                d = d == undefined ? "." : d,
                t = t == undefined ? "," : t,
                s = n < 0 ? "-" : "",
                i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                j = (j = i.length) > 3 ? j % 3 : 0;
            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        };

        $(document).on("click", ".glyphicon-ok", function(){
            var empty = false;
            var input = $(this).parents("tr").find('span');

            $.confirm({
                'title'     : 'Add',
                'content'   : 'Anda pasti untuk simpan?',
                'buttons'   : {
                    'YA'   : {
                        'class' : 'blue',
                        'action': function(){

                            // input.each(function(){
                            //     if(!$(this).text()){
                            //         $(this).addClass("error");
                            //         empty = true;
                            //     } else{
                            //         $(this).removeClass("error");
                            //     }
                            // });

                            //$(this).parents("tr").find(".error").first().focus();
                            var dataArray = ["","","","","","","","","","","",""];
                            //if(!empty){
                            var i=0;
                            input.each(function(){
                                //$(this).parent("td").html($(this).val());
                                //alert($(this).text());
                                dataArray[i]=$(this).text();
                                i++;
                            });

                            $.ajax({
                                url: "../model/analisa_function.php",
                                type: "POST",
                                data: {action:"add_sale_target",dataArray:dataArray},
                                success: function (response) {
                                    // you will get response from your php page (what you echo or print)                 
                                    //$.alert('test here:'+response);
                                    // if(response == 'edit'){
                                    //     $( ".delete" ).click();
                                    // }else{
                                    //     $(this).parents("tr").find(".add, .delete, .edit").toggle();
                                    //     $(".add-new").removeAttr("disabled");
                                    // }
                                    location.href = "analisa_perniagaan.php";

                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    console.log(textStatus, errorThrown);
                                    //location.href = "harga_semasa_list.php";
                                }


                            });


                            // location.href = "harga_semasa_list.php";
                            // $("#dataTables-example" ).load( "harga_semasa_list.php #dataTables-example" );
                            //}
                        }
                    },
                    'TDAK'    : {
                        'class' : 'gray',
                        'action': function(){}  // Nothing to do in this case. You can as well omit the action property.
                    }
                }
            });
        });

        $(document).on("click", ".edit", function(){
            $(this).parents("tr").find(".ok, .edit, .remove").toggle();
        });


        $(document).on("click", ".remove", function(){
            var curr_tr = $(this).parents("tr");
            var row_id = curr_tr.find('input[type="hidden"]');
            var curr_id="";
            row_id.each(function(){
                curr_id = $(this).val();
            });
            //alert($(this).parents("tr").find("td").eq(4).html());
            var _totalAll = $('#table_jumlah').html();
            var _total = $(this).parents("tr").find("td").eq(4).html();

            $.confirm({
                'title'     : 'Padam',
                'content'   : 'Anda pasti untuk padam?',
                'buttons'   : {
                    'YA'   : {
                        'class' : 'blue',
                        'action': function(){
                            //elem.slideUp();


                            // $('#table_jumlah').html((parseFloat(_totalAll) - parseFloat(_total)))

                            // $(this).parents("tr").find("td:not(:last-child)").each(function(){
                            //           var selectedText = $(this).html();
                            //           alert(selectedText);
                            //       });



                            curr_tr.remove();
                        }
                    },
                    'TDAK'    : {
                        'class' : 'gray',
                        'action': function(){}  // Nothing to do in this case. You can as well omit the action property.
                    }
                }
            });

        });

    });

    function addAnalisa(){
        var index = $("#sasaran tbody tr:last-child").index();

        var overhead_month = $('#overhead_month').val();
        var overhead_month_year = overhead_month * 12;
        var untung_disasarkan = $('#untung_disasarkan').val();
        var margin_untung = $('#margin_untung').val();
        var margin_kos = 1 - parseFloat(margin_untung);

        var bep_profit_month = (parseFloat(overhead_month_year) + parseFloat(untung_disasarkan)) / 12 ;
        var bep_profit_year = (parseFloat(overhead_month_year) + parseFloat(untung_disasarkan)) ;

        var target_sale_month = (bep_profit_year / margin_untung) / 12;
        var target_sale_year = (bep_profit_year / margin_untung);

        var row = '<tr>' +
            '<td>-</td>' +
            '<td><span>'+$('#tahun').val()+'</span></td>' +
            '<td>Month : <span>'+(parseFloat(overhead_month)).formatMoney(2)+'</span><br>Year : <span>'+(parseFloat(overhead_month_year)).formatMoney(2)+'</span></td>' +
            '<td><span>'+(parseFloat(untung_disasarkan)).formatMoney(2)+'</span></td>' +
            '<td><span>'+(parseFloat(margin_untung)).formatMoney(2)+'</span></td>' +
            '<td><span>'+(parseFloat(margin_kos)).formatMoney(2)+'</span></td>' +
            '<td>Month : <span>'+ (parseFloat(overhead_month).formatMoney(2)) +'</span><br>Year : <span>'+(parseFloat(overhead_month_year).formatMoney(2))+'</span></td>' +
            '<td>Month : <span>'+(bep_profit_month).formatMoney(2)+'</span><br>Year : <span>'+(bep_profit_year).formatMoney(2)+'</span></td>' +
            '<td>Month : <span>'+(target_sale_month).formatMoney(2)+'</span><br>Year : <span>'+(target_sale_year).formatMoney(2)+'</span></td>' +
            '<td>trials</td>' +
            '<td align="center">' +
            '<a class="plus" title="Plus" data-toggle="tooltip"><i class="glyphicon glyphicon-ok"></i></a>&nbsp;'+
            '<a class="edit" title="Edit" data-toggle="tooltip"><i class="glyphicon glyphicon-edit"></i></a>&nbsp;'+
            '<a class="remove" title="Remove" data-toggle="tooltip"><i class="glyphicon glyphicon-remove"></i></a>'+
            '<input type="hidden" id="row_id" value="'+(index+1)+'"> '+
            '</td>' +
            '</tr>';

        $("#sasaran").append(row);

        //$('adjustment tr').eq(-1).before(row);

        // var _totalAll = $('#table_jumlah').html();  
        // var _total = $('#span_jumlah_harga').html();

        // var _newTotal = parseFloat(_totalAll) + parseFloat(_total);

        // $('#table_jumlah').html((_newTotal).formatMoney(2));
    }
</script>

</body>

</html>
