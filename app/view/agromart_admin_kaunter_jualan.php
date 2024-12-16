<?php
include ('../controller/auth.php');
require "../model/agromart_functions.php";
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
        function checkDelete(){
            return confirm('Adakah anda pasti untuk padam Peranan ini?');
        }
        setInterval(function () {
            var date = new Date();
            $('#timeRunning').html(date);
        }, 1000)
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
    <? $isActive = getTerminalJualanActivation();
    if($isActive){?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Kaunter Jualan</h1>
                    <input type="hidden" id="noresit" name="noresit" value=""/>
                    <h4 style="text-align: left"><span style="color: blue; "><span id="timeRunning"><?php echo date("Y-m-d H:i:s"); ?></span></span></h4>
                    <br>
                    <div class="panel panel-red">
                        <div class="panel-heading" style="text-align: center">
                            <label class="control-label" for="date">Analisa Transaksi Jualan</label>
                        </div>
                        <table style="width: 100%;" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th style="text-align: center; width: 25%; background-color: #D6DBDF">Hari Ini</th>
                                <th style="text-align: center; width: 25%; background-color: #D6DBDF">Minggu Ini</th>
                                <th style="text-align: center; width: 25%; background-color: #D6DBDF">Bulan Ini</th>
                                <th style="text-align: center; width: 25%; background-color: #D6DBDF">Tahun Ini</th>
                            </tr>
                            </thead>
                            <?
                            $transjualan_curdate = getCountTransJualanByCurDate();
                            $transjualan_curweek = getCountTransJualanByCurWeek();
                            $transjualan_curmonth = getCountTransJualanByCurMonth();
                            $transjualan_curyear = getCountTransJualanByCurYear();
                            ?>
                            <tbody>
                            <td style="text-align: center; background-color: #FDFEFE; font-size: 6; color: blue"><strong><?echo $transjualan_curdate;?></strong></td>
                            <td style="text-align: center; background-color: #FDFEFE; font-size: 6; color: purple""><strong><?echo $transjualan_curweek;?></strong></td>
                            <td style="text-align: center; background-color: #FDFEFE; font-size: 6; color: green""><strong><?echo $transjualan_curmonth;?></strong></td>
                            <td style="text-align: center; background-color: #FDFEFE; font-size: 6; color: orange" ><strong><?echo $transjualan_curyear;?></strong></td>
                            </tbody>
                        </table>
                    </div>
                    <div class="row">
                        <div class="panel-heading" align="right">
                            <button class="btn btn-primary" data-toggle="modal" data-target="#myModalItem" id="btn_addItem">Tambah Jualan Baharu</button>
                        </div>
                        <div class="row">
                            <div class="modal fade" id="myModalItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                <div class="modal-dialog">

                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel">Tambah Maklumat Jualan</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form id="new-barang" method="post" action="">
                                                <div>
                                                    <label><span style="color:red;">** Maklumat Wajib Diisi **</span></label>
                                                </div>
                                                <div class="form-group">
                                                    <label for="barcode">Kodbar<span style="color:red;">&nbsp;**</span></label>
                                                    <input class="form-control" name="barcode" id="barcode" onkeyup="getItemJualanDetails(this)">
                                                </div>
                                                <div class="form-group">
                                                    <label>Kuantiti<span style="color:red;">&nbsp;**</span></label>
                                                    <input class="form-control" type="number" min="1" name="kuantiti_item" id="kuantiti_item" onkeyup="getJumlahByItemJualan(this)">
                                                    <input type="hidden" name="hargaRuncit" id="hargaRuncit" value="">
                                                    <input type="hidden" name="spanNokpSeller" id="spanNokpSeller" value="">
                                                </div>
                                                <!-- <div class="form-group" align="left">
                                                <label>Kod Item : </label>
                                                <span id="spanKodItem"></span>
                                                </div> -->
                                                <div class="form-group">
                                                    <label>Nama Item : </label>
                                                    <b><span id="spanKodItem"></span>&nbsp;-&nbsp;</b><span id="spanNamaItem"></span>
                                                </div>
                                                <div class="form-group">
                                                    <label>Kuantiti Semasa : </label>
                                                    <span id="spanKuantiti"></span>
                                                </div>

                                                <div class="form-group" align="left">
                                                    <label>Harga Jualan Semasa :</label>
                                                    <h4 style="font-size: 20px;"><b>RM<span id="spanHargaJualan"></span></b></h4>
                                                </div>

                                                <div class="form-group" align="left">
                                                    <label>Jumlah Keseluruhan :</label>
                                                    <h4 style="font-size: 30px;"><b>RM<span id="spanJumlahByItem"></span></b></h4>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" onclick="getItemJualanList()" class="btn btn-primary">Simpan</button>
                                                    <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-default">
                                <table width="100%" class="table table-striped table-bordered table-hover" id="tableItemJualan">
                                    <thead>
                                    <tr>
                                        <th>Bil.</th>
                                        <th>Kodbar</th>
                                        <th>Nama Item</th>
                                        <th>Kuantiti</th>
                                        <th>Harga Jualan Semasa (RM)</th>
                                        <th>Jumlah (RM)</th>
                                        <th>Tindakan</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td colspan='6' class='text-right'><b>Jumlah Keseluruhan (RM)</b></td>
                                        <td class='text-left'><font color="brown" size="5"><b><span id="tableJumlahKeseluruhan">0.00</span></b></font></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel1">Maklumat Pembayaran</h4>
                                        </div>
                                        <div class="modal-body">
                                            <form method="post" action="">
                                                <div>
                                                    <label><font color="red">** Maklumat Wajib Diisi **</font></label>
                                                </div>
                                                <div class="form-group">
                                                    <label>Jumlah Perlu Dibayar (RM) :<b></label><br>
                                                    <span id="jumlah_jualan" style="font-size: 40px;"></span></b>
                                                    <input type="hidden" name="spanJumlahPerluBayar" id="spanJumlahPerluBayar" value="">
                                                    <input type="hidden" id="spanNoResit" name="spanNoResit" value=""/>
                                                </div>

                                                <div class="form-group">
                                                    <label>Jumlah Dibayar (RM)<font color="red">&nbsp;**</font></label>
                                                    <input class="form-control" placeholder=" " name="jumlah_bayaran" id="jumlah_bayaran" required autocomplete="" onkeyup="kiraanBayaranItemJualan(this.value)" style="font-size: 24px;">
                                                    <input type="hidden" name="spanJumlahDibayar" id="spanJumlahDibayar" value="">
                                                </div>
                                                <div class="form-group">
                                                    <label>Baki Dipulangkan (RM) :<b></label><br>
                                                    <span id="jumlah_baki" style="font-size: 40px;"></span></b>
                                                    <input type="hidden" name="spanBakiBayaran" id="spanBakiBayaran" value="">
                                                    <input type="hidden" id="spanIDAgencies" name="spanIDAgencies" value=""/>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" onclick="addItemJualanProses()" class="btn btn-primary">Simpan</button>
                                                    <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-warning" type="reset" onclick="resetAllItemJualan()"><span class="fa fa-refresh" aria-hidden="true"></span> Jualan Baru</button>
                            <button class="btn btn-primary" id="btn_bayar" onclick="getBayaranItemJualan()"><span class="fa fa-dollar" aria-hidden="true"></span> Bayaran</button>
                            <button class="btn btn-success hidden-print" onclick="getResitItemJualan()"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Cetak Resit</button>
                        </div>
                    </div>
                </div>
            </div>
            <? include ('../global/footer.php'); ?>
        </div>
    <?}else{?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Maaf Terminal Ditutup</h1>
                    <h4 style="text-align: left"><span style="color: blue">  <?php echo date("D M d, Y G:i a"); ?></span></h4>
                </div>
            </div>
            <? include ('../global/footer.php'); ?>
        </div>
    <?}?>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });

        Number.prototype.formatMoney = function(c, d, t){
            var n = this,
                c = isNaN(c = Math.abs(c)) ? 2 : c,
                d = d == undefined ? "." : d,
                t = t == undefined ? "" : t,
                s = n < 0 ? "-" : "",
                i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
                j = (j = i.length) > 3 ? j % 3 : 0;
            return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
        };

        $(document).on("click", ".glyphicon-remove", function(){
            var curr_tr = $(this).parents("tr");
            var row_id = curr_tr.find('input[type="hidden"]');
            var curr_id="";
            row_id.each(function(){
                curr_id = $(this).val();
            });
            //alert($(this).parents("tr").find("td").eq(4).html());
            var jumlahKeseluruhan = $('#tableJumlahKeseluruhan').html();
            var jumlahByItem = $(this).parents("tr").find("td").eq(4).html();

            $.confirm({
                'title'     : 'Padam',
                'content'   : 'Anda pasti untuk mengeluarkan item jualan dari senarai?',
                'buttons'   : {
                    'YA'   : {
                        'class' : 'blue',
                        'action': function(){
                            //elem.slideUp();

                            $('#tableJumlahKeseluruhan').html((parseFloat(jumlahKeseluruhan) - parseFloat(jumlahByItem)))

                            // $(this).parents("tr").find("td:not(:last-child)").each(function(){
                            // var selectedText = $(this).html();
                            // alert(selectedText);
                            // });

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

        $("#myModalItem").on("hidden.bs.modal", function(){
            //alert('here');
            //$(this).removeData();
            $("#myModalItem input").val("");
            $("#myModalItem span").html("");
        });
    });

    function resetAllItemJualan(){
        //$('form-control').reset();
        window.location = "agromart_admin_kaunter_jualan.php";

    }

    function getItemJualanDetails(obj){
        if(obj.value.length > 11){
            $.ajax({
                url: "../model/agromart_functions.php",
                type: "POST",
                data: {action:"itemJualanDetails",barcode:obj.value},
                success: function (response) {
                    // you will get response from your php page (what you echo or print)
                    var dataObject = $.parseJSON(response);
                    //$.alert('test here:'+response.length);
                    if(response.length == 2){
                        $('#spanKodItem').html("");
                        $('#spanNamaItem').html("");
                        $('#spanKuantiti').html("");
                        $('#spanHargaJualan').html("");
                        $('#spanJumlahByItem').html("");
                    }else{
                        $('#spanKodItem').html(dataObject[0].kod_item);
                        $('#spanNamaItem').html(dataObject[0].nama_item);
                        $('#spanKuantiti').html(dataObject[0].kuantiti_item);
                        $('#spanHargaJualan').html(dataObject[0].harga_runcit);
                        var harga_jualan_semasa =dataObject[0].harga_runcit;
                        $('#hargaRuncit').val(harga_jualan_semasa);
                        var id_agencies =dataObject[0].id_agencies;
                        $('#spanIDAgencies').val(id_agencies);
                        var nokp_seller =dataObject[0].nokp_seller;
                        $('#spanNokpSeller').val(nokp_seller);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        }
    }

    function getJumlahByItemJualan(obj){
        var kuantiti = obj.value;
        var harga_runcit = $('#hargaRuncit').val();
        var jumlah_by_item = harga_runcit * kuantiti;

        $('#spanJumlahByItem').html((jumlah_by_item).formatMoney(2));
    }

    function getItemJualanList(){

        if($('#spanJumlahByItem').html() == ""){
            alert("Tiada maklumat item jualan dalam sistem!");
            $('#barcode').focus();
        }else if($('#barcode').val() != ""){
            var index = $("#tableItemJualan tbody tr:last-child").index();

            var row = '<tr>' +
                '<td width="7%">'+(index+1)+'</td>' +
                '<td width="15%">'+$('#barcode').val()+
                '<input type="hidden" name="tableKodbar" value="'+$('#barcode').val()+'"/>'+
                '<input type="hidden" name="tableNokpSeller" value="'+$('#spanNokpSeller').val()+'"/>'+
                '<input type="hidden" name="tableKodItem" value="'+$('#spanKodItem').html()+'"/></td>' +
                '<td width="25%">'+'<b>'+$('#spanKodItem').html()+'</b>'+'&nbsp;'+'-'+'&nbsp;'+$('#spanNamaItem').html()+
                '<input type="hidden" name="tableNamaItem" value="'+$('#spanNamaItem').html()+'"/></td>' +
                '<td width="15%">'+$('#kuantiti_item').val()+
                '<input type="hidden" name="tableKuantiti" value="'+$('#kuantiti_item').val()+'"/></td>' +
                '<td width="20%">'+$('#spanHargaJualan').html()+
                '<input type="hidden" name="tableHargaJualan" value="'+$('#spanHargaJualan').html()+'"/></td>' +
                '<td width="20%">'+$('#spanJumlahByItem').html()
                +'<input type="hidden" name="tableJumlahByItem" value="'+$('#spanJumlahByItem').html()+'"/></td>' +
                '<td align="left" width="15%">' +
                '<i class="glyphicon glyphicon-remove"></i>'+
                '<input type="hidden" id="row_id" value="'+(index+1)+'"> '+
                '</td>' +
                '</tr>';
            //$("table").append(row);

            $('table tr').eq(-1).before(row);
            $('#myModalItem').modal('toggle');

            var jumlahKeseluruhan = $('#tableJumlahKeseluruhan').html();
            var jumlahByItem = $('#spanJumlahByItem').html();
            var nokp_seller = $('#spanNokpSeller').html();
            var kod_item = $('#spanKodItem').html();
            var nama_item = $('#spanNamaItem').html();
            var harga_item = $('#spanHargaJualan').html();
            var jumlah_harga_item = $('#spanJumlahByItem').html();
            var kuantiti_item = $('#kuantiti_item').html();


            $('#tableJumlahKeseluruhan').html((parseFloat(jumlahKeseluruhan) + parseFloat(jumlahByItem)).formatMoney(2))

        }else{
            alert("Sila masukkan kodbar item jualan terlebih dahulu!");
            $('#barcode').focus();
        }
    }

    function getBayaranItemJualan(){
        //alert($('#table_jumlah').html()=="0");
        if($('#tableJumlahKeseluruhan').html()=="0"){
            alert("Sila senaraikan item jualan terlebih dahulu!");
        }else{
            $('#myModal1').modal('toggle');
            $('#jumlah_jualan').html($('#tableJumlahKeseluruhan').html());
            var jumlah_perlu_bayar = parseFloat($('#tableJumlahKeseluruhan').html());
            $('#jumlah_jualan').html((jumlah_perlu_bayar).formatMoney(2));
            $('#spanJumlahPerluBayar').val(jumlah_perlu_bayar);

        }
    }

    function kiraanBayaranItemJualan(jumlah_bayaran,obj){

        var jumlah_dibayar = parseFloat(jumlah_bayaran);
        $('#jumlah_bayaran').html((jumlah_dibayar).formatMoney(2));
        $('#spanJumlahDibayar').val(jumlah_dibayar);
        var baki_bayaran = parseFloat(jumlah_bayaran) - parseFloat($('#tableJumlahKeseluruhan').html());
        $('#jumlah_baki').html((baki_bayaran).formatMoney(2));
        $('#spanBakiBayaran').val(baki_bayaran);
    }

    function addItemJualanProses(){
        var id_agencies = $('#spanIDAgencies').val();
        var no_resit = $('#spanNoResit').val();
        var jumlah_jualan = $('#spanJumlahPerluBayar').val();
        var jumlah_bayaran = $('#spanJumlahDibayar').val();
        var jumlah_baki = $('#spanBakiBayaran').val();
        var created_by = '<?echo $_SESSION['SESS_NAME']?>';
        var nokp_seller = $('#spanNokpSeller').html();
        var kod_item = $('#spanKodItem').html();
        var nama_item = $('#spanNamaItem').html();
        var harga_item = $('#spanHargaJualan').html();
        var jumlah_harga_item = $('#spanJumlahByItem').html();
        var kuantiti_item = $('#kuantiti_item').html();
        var info = '[';
        var lenInfo = 0;

        $('#tableItemJualan').find('tbody tr').each(function(){
            //curr_id = $(this).val();
            //$(this).find('input[name="tbl_kodbar"]').val();

            if ($(this).find('input[name="tableKodbar"]').val() != undefined) {
                if(lenInfo > 0) info += ',';

                info += '{"nokp_seller":"'+$(this).find('input[name="tableNokpSeller"]').val()
                    +'","barcode_item":"'+$(this).find('input[name="tableKodbar"]').val()+'","kod_item":"'+$(this).find('input[name="tableKodItem"]').val()+'","nama_item":"'+$(this).find('input[name="tableNamaItem"]').val()+'","harga_item":"'+$(this).find('input[name="tableHargaJualan"]').val()+'","jumlah_harga_item":"'+$(this).find('input[name="tableJumlahByItem"]').val()+'","kuantiti_item":"'+$(this).find('input[name="tableKuantiti"]').val()+'"}';
            }
            lenInfo++;
        });
        info += ']';

        var mydata = {action:"addItemJualanProses",
            id_agencies:id_agencies,
            no_resit:no_resit,
            jumlah_jualan:jumlah_jualan,
            jumlah_bayaran:jumlah_bayaran,
            jumlah_baki:jumlah_baki,
            created_by:created_by,
            info:info,
        };

        //alert(sys_id);

        $.ajax({
            url: "../model/agromart_functions.php",
            type: "POST",
            data: mydata,
            success: function (response) {
                // you will get response from your php page (what you echo or print)
                // var dataObject = $.parseJSON(response);
                // $.alert('test here:'+response);

                $('#spanNoResit').val(response)
                $("#btn_bayar").hide();
                $("#btn_pelanggan").hide();
                $("#btn_addItem").hide();

                $('#myModal1').modal('toggle');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }

    function getResitItemJualan(){
        var no_resit = $('#spanNoResit').val();
        if(no_resit == ""){
            $.alert('Tiada transaksi jualan!');
        }else{
            window.open("agromart_admin_jualan_resit.php?no_resit="+no_resit);
        }
    }
</script>

</body>

</html>