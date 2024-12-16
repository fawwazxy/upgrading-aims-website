<?
require "../model/support_function.php";

?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="aduan" content="">
    <meta name="author" content="">



    <? require "../global/header.php"; ?>

    <!-- include summernote css/js -->
    <link href="../../js/summernote/summernote.css" rel="stylesheet">
    <script src="../../js/summernote/summernote.js"></script>
    <!-- include libraries(jQuery, bootstrap) -->




    <script language="JavaScript" type="text/javascript">


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
        }.option {
             background: #eee;
             display: block;
             padding: 5px 10px 5px;
             color: #000;
             -moz-border-radius: 6px;
             -webkit-border-radius: 6px;
             -khtml-border-radius: 6px;
             border-radius: 6px;
             cursor: pointer;
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
                        <div class="col-sm-2">&nbsp;</div>
                        <div class="col-sm-7" align="center">
                            <center><? $com = getCompany()->fetch_assoc();
                                echo '<img src="data:image/png;base64,'.base64_encode( $com['logo'] ).'" style="width:13%"/>';?>
                            </center>

                            <h3><b>LOG TIKET ADUAN/MAKLUMBALAS<b></h3><br>

                            <form id="formsubmit" method="post" action="../controller/add_support_exec.php" >
                                <input type="hidden" class="form-control" placeholder=" " id="shortcode" name="shortcode" value="<? echo $shortcode; ?>"/>
                                <input id="created_by" name="created_by" type="hidden" value=""/>
                                <input type="hidden" id="catatancode" name="catatancode" value="" />
                                <label><font color="red">** Maklumat Wajib Diisi.</font></label><br>
                                <div class="form-group" align="left">
                                    <label>Projek/Sistem/Produk<font color="red">**</font>&nbsp;</label><br>
                                    <div class="form-control" style="overflow-y:scroll; height: 200px; " >
                                        <? $produk=  getProjectList();
                                        while ($pilih  = $produk -> fetch_assoc()){ ?>
                                            <label class="option"><input type="radio" name="nama_projek" value="<?echo $pilih['kod_projek'];?>" required/>&nbsp;&nbsp;<? echo $pilih['kod_projek']?> - <? echo $pilih['nama_projek']?></label>
                                        <?}?>

                                    </div>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Nama Penghantar<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" placeholder="" name="nama_client" id="nama_client"  autocomplete="" required >
                                </div>



                                <div class="form-group" align="left">
                                    <label>No Telefon<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" placeholder="Contoh:+60123456789" name="notel"  autocomplete="" required>
                                </div>


                            </form>
                            <div class="form-group" align="left">
                                <label>Komen/Catatan<font color="red">**</font>&nbsp;</label>
                                <textarea id="summernote"  cols="45" rows="5" name="aduan" required></textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" form="formsubmit" class="btn btn-success">Simpan</button>
                                <button type="button" class="btn btn-warning" onClick="reset()">Tetapan Semula</button>
                            </div>

                        </div>
                        <div class="col-sm-2">&nbsp;</div>
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

    <!-- /#wrapper -->

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
    </script>

    <script>
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
    </script>

    <script>

        $(document).ready(function() {
            $('#summernote').summernote({
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
            $('#catatancode').val(markupStr);
        });
        function reset() {
            $("#formsubmit").trigger("reset");
            $('#summernote').summernote('reset');
        }

    </script>

</center>
</body>

</html>
