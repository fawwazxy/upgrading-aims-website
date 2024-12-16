<?php

include ('../controller/auth.php');

require "../model/support_function.php";

?>
<?
$no_staff = $_GET['no_staff'];

$no_staff_login = $_SESSION['SESS_NO_STAFF'];
$id_support = $_GET['id_support'];
$id_support_developer = $_GET['id_support_developer'];


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
    <script>

        function star(){
            var level=document.getElementById("level_aduan").value;
            var i=0;
            for(i=0;i<=level;i++){
                document.write(*);

            }

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
                <h1 class="page-header">Kemaskini Sokongan</h1>
            </div>

            <div class="panel-heading" align="right">
                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
            </div>

        </div>

        <div class="row">

            <div class="col-lg-12">

                <div class="panel panel-default">

                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">



                                <form method="post" id="formsubmit" action="../controller/reassign_developer_exec.php?id_support=<?php echo $id_support; ?>$id_support_developer=<?php echo $id_support_developer; ?>" >


                                    <input name="id" type="hidden" class="input-short" value="<? echo $_GET['id']; ?>" />
                                    <input name="created_by" type="hidden" class="input-short" value="<? echo $no_staff_login ?>" />
                                    <input type="hidden" id="catatancode" name="catatancode" value="" />






                                    <?


                                    $row=  getReassign($id_support)->fetch_assoc();
                                    echo $id_support = $_GET['id_support'];
                                    echo $id_support_developer = $_GET['id_support_developer'];
                                    echo  $no_staff_login = $_SESSION['SESS_NO_STAFF'];


                                    ?>

                                    <input name="id_support_developer" type="hidden" class="input-short" value=" <? echo $row['id_support_developer'];?>"/>
                                    <label><font color="red">**Maklumat Wajib Diisi.</font></label><br>


                                    <label>Nama Projek/Sistem</label><br>
                                    <? echo $row['nama_projek'];?>

                                    <? echo $row['id_support_developer'];?>

                                    <br><br>

                                    <label>Aduan</label><br>
                                    <? echo $row['aduan'];?>
                                    <br><br>

                                    <label>Nama Pelanggan</label><br>
                                    <? echo $row['nama_client'];?>
                                    <br><br>

                                    <label>Nombor Telefon</label><br>
                                    <? echo $row['notel'];?>

                                    <br><br>



                                    <label>Tindakan Oleh (Previous)</label><br>



                                    <?
                                    $list = getPrevDev($id_support,$row['namadev']);
                                    while($list_data = $list->fetch_assoc()) {
                                        echo $list_data['namadeveloper']."<br>";
                                    }


                                    ?>



                                    <br><br>


                                    <label>Tarikh Mula</label>
                                    <input class="form-control" id="tarikh_mula" name="tarikh_mula" placeholder="DD/MM/YYY" type="text" value="<? echo $row['tarikh_mula'];?>" readonly/>
                                    <br><br>



                                    <label>Tarikh Tamat</label>
                                    <input class="form-control" id="tarikh_tamat" name="tarikh_tamat" placeholder="DD/MM/YYY" type="text" onchange="showDays()" value="<? echo $row['tarikh_tamat'];?>" readonly/>
                                    <br><br>

                                    <label>Bil. Hari Penyelesaian</label>
                                    <input class="form-control"  name="jumlah_hari_siap" id="jumlah_hari_siap"  value="<? echo $row['jumlah_hari_siap'];?>" readonly>

                                    <br>


                                    <br>

                                    <label>Tindakan Oleh<font color="red">**</font>&nbsp;</label><br>

                                    <select required class="form-control"  name="developer" id="developer" >

                                        <option value="">-- Pilih --</option>
                                        <? $person= getNamaDeveloper($department_id);
                                        while ($pilih  = $person -> fetch_assoc()){ ?>
                                            <option value="<? echo $pilih['no_staff'];?>"  <? echo ($pilih['no_staff']==$row['developer']?'selected':'');?>>   <? echo $pilih['name']?></option>

                                            <?
                                        }
                                        ?>
                                    </select>



                                    <br><br>



                                    <label>Tahap Keutamaan<font color="red">**</font>&nbsp;</label><br>
                                    <select required class="form-control"  name="level_aduan" id="level_aduan">

                                        <option value="">-- Pilih --</option>
                                        <? $level= getLevel();
                                        while ($listdata  = $level -> fetch_assoc()){ ?>
                                            <option value="<? echo $listdata['level'];?>"  <? echo ($listdata['level']==$row['level_aduan']?'selected':'');?>>   <? echo $listdata['level']?>-<? echo $listdata['keterangan']?></option>

                                            <?
                                        }
                                        ?>
                                    </select>

                                </form><br><br>
                                <div class="form-group" align="left">
                                    <label>Komen/Catatan<font color="red">**</font>&nbsp;</label>
                                    <textarea id="summernote" cols="45" rows="5" name="remarks"></textarea>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" form="formsubmit" class="btn btn-success" >Simpan</button>
                                    <button type="button" class="btn btn-warning" onClick="reset()">Tetapan Semula</button>
                                    <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">

                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>



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

</body>

</html>
