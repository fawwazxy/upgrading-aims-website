<?
require "../model/support_function.php";
$id = $_GET['id'];
$data = getSupportMaklumBalas($id)->fetch_assoc();
$com = getCompany()->fetch_assoc();
$parent = getParentSub($data['support_parent'])->fetch_assoc();

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

    <!-- include summernote css/js -->
    <link href="../../js/summernote/summernote.css" rel="stylesheet">
    <script src="../../js/summernote/summernote.js"></script>
    <!-- include libraries(jQuery, bootstrap) -->




    <script language="JavaScript" type="text/javascript">
        function Confirm(){
            return confirm('Anda pasti? ') ;
        }


    </script>

    <style>
        .accordion1 {
            background-color: #eee;
            color: #444;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;
        }

        .active1, .accordion1:hover {
            background-color: #ccc;
        }

        .panel1 {
            padding: 0 18px;
            display: none;
            background-color: white;
            overflow: hidden;
        }

        .col-sm-8{
            margin-left: 200px;
            margin-right: 200px;
        }
    </style>


</head>


<? $sys = getSys(1) -> fetch_assoc(); ?>
<body>

<!-- /.row -->
<center>
    <div class="row" align="center">
        <div class="col-lg-12" align="center" >
            <div class="panel panel-default">
                <div class="panel-body" >
                    <div class="row" >
                        <div class="col-sm-8" align="center">
                            <center>
                                <?echo '<img src="data:image/png;base64,'.base64_encode( $com['logo'] ).'" style="width:13%"/>';?>
                            </center>
                            <h3><b>MAKLUM BALAS ADUAN</b></h3><br>
                            <div class="row">
                                <div class="panel panel-default">
                                    <div class="panel-body" style="background-color: #E6FFEB;">
                                        <table align="left"  >
                                            <tbody>
                                            <tr>
                                                <td><p><b>No. Rujukan Ticket Asal</b></p></td>
                                                <td><p>:&nbsp;</p></td>
                                                <td><p><?php if($data['support_parent']!=''){ echo $data['support_parent'];}else{echo $data['norujukan_support'];} ?></p> </td>
                                            </tr>
                                            <tr>
                                                <td><p><b>Tarikh Aduan</b></p></td>
                                                <td><p>:&nbsp;</p></td>
                                                <td><p><?php if($data['support_parent']!=''){ echo date("d-m-Y h:i A", strtotime($parent['created_date']));}else{echo date("d-m-Y h:i A", strtotime($data['created_date']));} ?></p> </td>
                                            </tr>
                                            <tr>
                                                <td><p><b>Nama Penghantar</b></p></td>
                                                <td><p>:&nbsp;</p></td>
                                                <td><p><?php echo $data['nama_client'];?></p></td>
                                            </tr>
                                            <tr>
                                                <td><p><b>No. Tel Penghantar</b></p></td>
                                                <td><p>:&nbsp;</p></td>
                                                <td><p><?php echo $data['notel'];?> </p></td>
                                            </tr>
                                            <tr>
                                                <td><p><b>Nama Projek </b></p></td>
                                                <td><p>:&nbsp;</p></td>
                                                <td><p><?php if($data['support_parent']!=''){ echo $parent['kod_projek'].' - '.$parent['nama_projek'];}else{echo $data['kod_projek'].' - '.$data['nama_projek'];}?></p> </td>
                                            </tr>
                                            <!--<tr>
                                                        <td><p><b>Agensi Rujukan</b></p></td>
                                                        <td><p>:&nbsp;</p></td>
                                                        <td><p><?php echo $data['agensi_rujukan'] ?></p> </td>
                                                    </tr>-->
                                            <tr>
                                                <td><p><b>Aduan Asal</b></p></td>
                                                <td><p>:&nbsp;</p></td>
                                                <td><p><?php if($data['support_parent']!=''){ echo $parent['aduan'];}else{echo $data['aduan'];}?></p> </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <?$j= 1;
                                $data_sub = getSubSupportList($data['support_parent']);
                                while($list_sub = $data_sub->fetch_assoc()) {?>
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <div align="left">
                                                <br><b>No. Rujukan Ticket : </b><?echo $list_sub['norujukan_support']?>
                                                <br><b>Status Terkini Aduan : </b><?echo $list_sub['keterangan']?>
                                                <br><b>Aduan : </b><?echo $list_sub['aduan']?>
                                                <?if($list_sub['client_feedback']!=''){?>
                                                    <br><b>Maklum Balas : </b><?echo $list_sub['client_feedback']?>
                                                <?}?>
                                            </div>
                                            <div align="right">
                                                <a><button class="btn btn-warning" type="button" onclick="openModal(<? echo $list_sub['id']; ?>)">Kemaskini</button></a>
                                            </div>
                                        </div>
                                    </div>

                                    <?$j++;}?>
                            </div>
                            <?if($data['support_parent']==''){?>
                                <form id="formparent" method="post" enctype="multipart/form-data" action="../controller/add_maklumbalas_exec.php?id=<? echo $id;?>">

                                    <input type="hidden" class="form-control" placeholder=" " id="id" name="id" value="<? echo $id; ?>"/><br>
                                    <input type="hidden" id="aduancode" name="aduancode" value="" />

                                </form>
                                <div class="form-group" align="left">
                                    <label>Komen/Catatan</label>
                                    <textarea id="summernote" cols="45" rows="5" name="client_feedback"  required autocomplete=""><?echo $data['client_feedback']?></textarea>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit" form="formparent" class="btn btn-success" >Simpan</button>
                                    <button type="button" class="btn btn-warning" onClick="reset()">Tetapan Semula</button>
                                </div>
                            <?}?>


                        </div>

                        <!-- /.panel -->
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

                <!-- /.row -->
            </div>
            <!-- /#page-wrapper -->

        </div>

        <? include ('../global/footer.php'); ?>
    </div>

    <div class="modal" id="modal">
        <div class="modal-dialog">

            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" align="left" id="myModalLabel">Maklum Balas Aduan</h4>
                </div>

                <div class="modal-body">

                    <form id="formsub" method="post" enctype="multipart/form-data" action="../controller/support_exec.php?action=feedback">
                        <input type="hidden" id="id_sub" name="id_sub" value="" />
                        <input type="hidden" id="catatancode" name="catatancode" value="" />
                    </form>
                    <div class="panel-body">
                        <div class="form-group" align="left">
                            <label>No. Rujukan Tiket : </label><div id="sub_rujukan"></div>&nbsp;&nbsp;
                        </div>
                        <div class="form-group" align="left">
                            <label>Komen/Catatan</label>
                            <textarea id="summernote2" cols="45" rows="5" name="comments"  required autocomplete=""><div id="sub_feedback"></div></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" form="formsub" class="btn btn-success" >Simpan</button>
                            <button type="button" class="btn btn-warning" onClick="resetSub()">Tetapan Semula</button>
                        </div>

                    </div>


                </div><!--modal-body-->

            </div>
            <!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <!-- /#wrapper -->

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
            $('#summernote').summernote({
                height: "300px",
                styleWithSpan: false
            });
            $('#summernote2').summernote({
                height: "300px",
                styleWithSpan: false
            });
        });
        $("#summernote").on("summernote.change", function (e) {   // callback as jquery custom event 
            var markupStr = $('#summernote').summernote('code');

            markupStr = markupStr.replace(/\(/g, "^)·(");
            markupStr = markupStr.replace(/\{/g, "=?¿¡12");
            markupStr = markupStr.replace(/\</g, "++ççcsacsa");
            //alert(markupStr);
            $('#aduancode').val(markupStr);
        });
        $("#summernote2").on("summernote.change", function (e) {   // callback as jquery custom event 
            var markupStr = $('#summernote2').summernote('code');

            markupStr = markupStr.replace(/\(/g, "^)·(");
            markupStr = markupStr.replace(/\{/g, "=?¿¡12");
            markupStr = markupStr.replace(/\</g, "++ççcsacsa");
            //alert(markupStr);
            $('#catatancode').val(markupStr);
        });
        var acc = document.getElementsByClassName("accordion");
        var i;

        for (i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                }
            });
        }
        function reset() {
            $("#formparent").trigger("reset");
            $('#summernote').summernote('reset');
        }
        function resetSub() {
            $("#formsub").trigger("reset");
            $('#summernote2').summernote('reset');
        }
        function openModal(id_support){
            $('#id_sub').val(id_support);

            $.ajax({
                type: "POST",
                url: "../model/support_function.php",
                data:{action:"get_aduan",id:id_support},
                success: function(data){
                    var txt = ""+data+""
                    var obj = JSON.parse(txt);
                    //console.log(txt);
                    document.getElementById("sub_rujukan").innerHTML = obj.norujukan_support ;
                    document.getElementById("sub_feedback").innerHTML = obj.client_feedback ;
                }
            });

            $('#modal').modal('toggle');
        }


    </script>

</center>
</body>

</html>
