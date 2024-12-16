<?php

include ('../controller/auth.php');


require "../model/claim_function.php";

?>
<?php
$no_staff = $_GET['no_staff'];



?>


<!DOCTYPE html>
<html lang="en">

<head>
    <script language="JavaScript" type="text/javascript">
        function Confirm(){
            return confirm('Anda pasti untuk meneruskan?');
        }

    </script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <? require "../global/header.php"; ?>


    <!-- <title><? echo $list_sys['sys_name'];?>::<? echo $list_sys['sys_tagline'];?></title>-->




    <script>
        function goBack()
        {
            window.history.back()
        }

        function HantarUrl(obj){


// var url=$('#jenis_tuntutan').find('option:selected').data('id');
            var url=$('.mytest').find('option:selected').attr('url');
            if(url != ""){
                //alert("Anda Pasti Untuk Meneruskan?"+url);
                $("#myform").attr('action',url);
                $("#myform").submit();
            }else{
                //$("#myform2").attr('hidden','false');
                document.getElementById('myhidden').hidden = false;
            }


        }
    </script>

</head>

<body>

<div id="wrapper">

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



                <h1 class="page-header">Pengesahan Jenis Tuntutan</h1>

                <div class="panel-heading" align="right">
                    <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!-- /.row -->

            <div class="row">

                <div class="col-lg-12">

                    <div class="panel panel-default">



                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">

                                    <form id="myform" method="post"  name="myform"  enctype="multipart/form-data" >


                                        <div class="form-group" align="left">
                                            <label>Pilih Jenis Tuntutan</label>
                                            <select required class="form-control mytest"  onchange="HantarUrl(this)" name="jenis_tuntutan" value="">
                                                <option value="">-- Pilih --</option>

                                                <? $jenis= getJenisTuntutanLulus();
                                                while ($pilih  = $jenis -> fetch_assoc()){ ?>
                                                    <option value="<? echo $pilih['code'];?>" url="<? echo $pilih['flag'];?>"><? echo $pilih['nama_tuntutan'];?></option>

                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </div>




                                        <div id="myhidden" name="myhidden" hidden="true">

                                            <div class="form-group" align="left">
                                                <label>Jumlah Tuntutan</label> RM
                                                <input class="form-control"  name="jumlah_tuntutan" id="jumlah_tuntutan"  required autocomplete="off"><br>

                                                <div class="form-group" align="left">
                                                    <label>Muat Naik Dokumen/Bukti</label>
                                                    <input class="form-control"  type="file"  name="document" id="document"  required autocomplete="off"><br>


                                                    <div class="form-group" align="left">
                                                        <label>Pilih Pelulus</label>
                                                        <select required class="form-control"  name="pelulus" value="">
                                                            <option value="">-- Pilih --</option>

                                                            <? $person= getTuntutanPelulus();
                                                            while ($pilih  = $person -> fetch_assoc()){ ?>
                                                                <option value="<? echo $pilih['approve_person'];?>"><? echo $pilih['nama_pelulus'];?></option>

                                                                <?
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="comment">Catatan</label>
                                                        <textarea class="form-control" rows="5" name="catatan" id="catatan"></textarea>
                                                    </div>



                                                    <div class="modal-footer">

                                                        <button type="submit" class="btn btn-primary" onclick="return Confirm()">Hantar</button>
                                                        <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                                        <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
                                                    </div>

                                                </div>

                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

        <? include ('../global/footer.php'); ?>
    </div>
    <!-- /#wrapper -->


    <script>
        $(document).ready(function() {
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });

    </script>



</body>

</html>
