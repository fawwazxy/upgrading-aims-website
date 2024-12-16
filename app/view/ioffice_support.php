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

    <script language="JavaScript" type="text/javascript">
        function Confirm(){
            var nama_client=document.getElementById("nama_client").value;
            return confirm('Terima kasih kerana menggunakan <? echo $sys['sys_name']; ?>. Isu anda akan diproses dan akan dimaklumkan melalui WhatsApp kepada anda.' ;
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



                        <div class="col-sm-2">&nbsp;</div>
                        <div class="col-sm-7" align="center">

                            <?
                            $logo_ioffice = "http://www.indeepreneur.com/ioffice/resources/images/logo_ioffice.jpeg";
                            ?>
                            <center><img src="<? echo $logo_ioffice; ?>" style="width:30%"/></center>



                            <h3><b>Bantuan@i-OFFICE <b></h3>


                            <br>

                            <form method="post" enctype="multipart/form-data" action="http://www.indeepreneur.com/ioffice/app/controller/add_support_exec.php" >


                                <input type="hidden" class="form-control" placeholder=" " id="shortcode" name="shortcode" value="<? echo $shortcode; ?>"/>

                                <label><font color="red">** Maklumat Wajib Diisi.</font></label>
                                <br>

                                <!--     <div class="form-group" align="left">
                                <label>Sistem<font color="red">**</font>&nbsp;</label>
                                <input class="form-control" placeholder=" " name="nama_projek" required autocomplete="" >
                                </div> -->
                                <!--  <?

                                $data = getFAQ();
                                ?>
                        <div class="form-group" align="left">

                        <label>Frequently Asked Questions (FAQ)</label>
                        <?

                                while($row_data = $data->fetch_assoc()) {


                                    ?>

                        <button class="accordion1"><? echo $row_data['faq_title']; ?></button>
                        <div class="panel1">
                        <p>Jawapan:<? echo $row_data['faq_answer']; ?></p>
                        </div>   <?}?>
                        </div>

                        -->



                                <div class="form-group" align="left">
                                    <label>Nama Produk&nbsp;</label>
                                    <input class="form-control" name="nama_projek1" placeholder="i-OFFICE" id="nama_client" value="i-OFFICE" >
                                    <input name="nama_projek" value="0" >
                                </div>

                                <div class="form-group" align="left">
                                    <label>Nama Penghantar<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" placeholder="" name="nama_client" id="nama_client"  autocomplete="" required >
                                </div>

                                <div class="form-group" align="left">
                                    <label>No Telefon<font color="red">**</font>&nbsp;</label>
                                    <input class="form-control" placeholder="Contoh:60123456789" name="notel"  autocomplete="" required>
                                </div>

                                <div class="form-group" align="left">
                                    <label>Komen/Catatan<font color="red">**</font>&nbsp;</label>
                                    <textarea class="form-control" cols="45" rows="5" name="aduan"  required autocomplete=""></textarea>
                                </div>

                                <div class="modal-footer">
                                    <button type="submit"  class="btn btn-primary" onclick="return Confirm()">Simpan</button>
                                    <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                </div>

                            </form>

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

</center>
</body>

</html>
