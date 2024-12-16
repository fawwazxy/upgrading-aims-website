<?php

include ('../controller/auth.php');

require "../model/pemohon_functions.php";

?>

<?
$com_id=$_GET['SESS_COM'];
$id = $_GET['id'];
$no_staff = $_GET['no_staff'];
?>


<?

if(isset($_GET['act']) && $_GET['act'] == "delete" && !empty($_GET['id']))
{
    activePenawaranJawatan($id,0);

}

if(isset($_GET['act']) && $_GET['act'] == "active" && !empty($_GET['id']))
{
    activePenawaranJawatan($id,1);

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
    <link href="../../js/summernote/summernote.css" rel="stylesheet">
    <script src="../../js/summernote/summernote.js"></script>

    <script language="JavaScript" type="text/javascript">
        function Confirm(){
            return confirm('Adakah Anda Pasti untuk NYAH-AKTIFKAN ?');
        }

    </script>

    <script language="JavaScript" type="text/javascript">
        function Confirm2(){
            return confirm('Adakah Anda Pasti untuk AKTIFKAN kembali ?');
        }


    </script>

    </script>
    <script language="javascript" type="text/javascript">
        <!--
            function popitup(url) {
                /*newwindow=window.open(url,'name','height=842,width=595');*/
                newwindow=window.open(url,'name','height=595,width=842');
                if (window.focus) {newwindow.focus()}
                return false;
            }

    // -->
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
            <div class="col-lg-12">


                <h1 class="page-header">Senarai Iklan Jawatan</h1>
            </div>
        </div>
        <?
        $flagScreen="tab_1";
        include ('../global/menu_penawaran_jawatan.php');
        ?>



        <div class="row">
            <div class="panel-heading" align="right">

                <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                    Tambah Iklan
                </button>
            </div>

            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Maklumat Iklan Jawatan
                    </div>




                    <!--<button type="button" class="btn btn-primary">Add New Record</button-->

                    <!-- Button trigger modal -->


                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" align="left" id="myModalLabel">Tambah Iklan Jawatan</h4>
                                </div>

                                <div class="modal-body">

                                    <form id="formsubmit" method="post" action="../controller/penawaran_jawatan_exec.php" >


                                        <input type="hidden" name="company_id"  value="<? echo $_SESSION['SESS_COM']; ?>">
                                        <input type="hidden" id="catatancode" name="catatancode" value="" />

                                        <div>

                                            <label align="left"><font color="red">** Maklumat Wajib Diisi.</font></label>
                                        </div>


                                        <!--<div class="form-group" align="left">
								<label>Pilih Kumpulan Peranan<font color="red">**</font>&nbsp;</label>
								<select class="form-control" name="role_group_id">
								  <option value="">-- Pilih --</option>
													  
								 <? //$role_group = getRoleGroup();
                                        //while ($list_group  = $role_group-> fetch_assoc()){ ?>
								 <option value="<? //echo $list_group['id'];?>"> <? //echo $list_group['role_group_name'];?> </option>
															
									<?
                                        //}
                                        ?>
								</select>
						</div> -->


                                        <div class="form-group" align="left">
                                            <label>Peranan <font color="red">**</font>&nbsp;</label>
                                            <select required class="form-control" name="role" value="">
                                                <option value="">-- Pilih --</option>

                                                <? $role= getRole();
                                                while ($list  = $role -> fetch_assoc()){ ?>
                                                    <option value="<? echo $list['code'];?>"><? echo $list['role'];?></option>

                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </div>



                                        <div class="form-group"> <!-- Date input -->
                                            <label class="control-label" for="date">Tarikh Mula Iklan</label>
                                            <input class="form-control" id="tarikh_mula" name="tarikh_mula" placeholder="DD/MM/YYY" type="text"/>
                                        </div>


                                        <div class="form-group"> <!-- Date input -->
                                            <label class="control-label" for="date">Tarikh Akhir Iklan</label>
                                            <input class="form-control" id="tarikh_akhir" name="tarikh_akhir" placeholder="DD/MM/YYY" type="text" />
                                        </div>








                                    </form>
                                    <div class="form-group">
                                        <label for="comment">Keterangan</label>
                                        <textarea class="form-control" rows="5" name="keterangan" id="summernote" ></textarea>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" form="formsubmit" class="btn btn-primary" >Simpan</button>
                                        <button type="button" class="btn btn-warning" onClick="reset()">Tetapan Semula</button>
                                    </div>
                                </div><!--modal-body-->

                            </div>
                            <!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->


                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <input name="redirect" type="hidden" value="../view/penawaran_jawatan?id=<?echo $list['id'];?>"/>
                        <input name="iklan_id" type="hidden" class="input-short" value="<? echo $id;?>" />

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Kumpulan Peranan</th>
                                <th>Peranan</th>
                                <th>Keterangan</th>
                                <th>Tarikh Iklan Mula</th>
                                <th>Tarikh Iklan Tamat</th>
                                <th>Bil.Permohonan</th>
                                <th>Status</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i=1;
                            $log_jawatan = getPenJawatan();
                            while($list = $log_jawatan->fetch_assoc()) {
                                $iklan_id =$list['id']

                                ?>

                                <tr class="odd gradeX">

                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $list['role_group_name']; ?></td>
                                    <td><?php echo $list['peranan']; ?></td>
                                    <td><?php echo $list['keterangan']; ?></td>
                                    <td id="tmula"><? echo date('d/m/Y',strtotime($list['tarikh_mula']));?></td>
                                    <td id="tend"><? echo date('d/m/Y',strtotime($list['tarikh_akhir']));?></td>
                                    <?php
                                    $list_bil_pemohon =getBilPemohon($list['id'])->fetch_assoc();?>
                                    <td><a data-toggle="modal" href="#myModal3<?php echo $iklan_id; ?>">
                                            <?
                                            echo $list_bil_pemohon['cnt']; ?></a>
                                        <?

                                        //require "../view/pemohon_senarai_perjawatan.php?iklan_id=".$iklan_id;
                                        require "../view/pemohon_senarai_perjawatan.php";

                                        ?>


                                    </td>


                                    <td>

                                        <?
                                        if($list['status'] == 1)
                                        {

                                            echo'<strong><font color=blue>AKTIF</font></strong>';

                                        }
                                        else
                                        {
                                            echo '<strong><font color=red>TIDAK AKTIF</font></strong>';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <?
                                        if ($list['status'] == 0) {
                                        ?>

                                        <a href="penawaran_jawatan.php?act=active&id=<? echo $list['id'];?>&no_staff=<? echo $no_staff;?>"><button type="button" class="btn btn-success" onclick="return Confirm2()">AKTIFKAN</button>
                                            <?
                                            }
                                            else {
                                            ?>

                                            <a href="penawaran_jawatan_update.php?id=<? echo $list['id'];?>"><button class="btn btn-info" type="button" >Kemaskini</button>
                                                <a href="penawaran_jawatan.php?act=delete&id=<? echo $list['id']; ?>&no_staff=<? echo $no_staff;?>"><button class="btn btn-danger" type="button" onclick="return Confirm()" >NYAH-AKTIF</button>
                                                    <a href="" onclick="return popitup('iklan.php?id=<? echo $list['id']; ?>&com_id=<? echo $list['company_id'];?>')"><button class="btn btn-warning" type="button" >Lihat Iklan</button>

                                                        <?
                                                        }
                                                        ?>
                                    </td>
                                </tr>
                                <?php $i++; } ?>

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
            responsive: true
        });

        var tarikh_mula=$('input[name="tarikh_mula"]'); //our date input has the name "date"
        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        tarikh_mula.datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,
        });
        var tarikh_akhir=$('input[name="tarikh_akhir"]'); //our date input has the name "date"
        // var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
        tarikh_akhir.datepicker({
            format: 'dd/mm/yyyy',
            container: container,
            todayHighlight: true,
            autoclose: true,

            todayHighlight:true
        });

    });



</script>

<script>
    $(document).ready(function(){
        $("#myBtn").click(function(){
            $("#myModal").modal();
        });
        $('#summernote').summernote({
            height: "300px",
            styleWithSpan: false

        });

        $("#summernote").on("summernote.change", function (e) {   // callback as jquery custom event
            var markupStr = $('#summernote').summernote('code');

            markupStr = markupStr.replace(/\(/g, "^)·(");
            markupStr = markupStr.replace(/\{/g, "=?¿¡12");
            markupStr = markupStr.replace(/\</g, "++ççcsacsa");
            //alert(markupStr);
            $('#catatancode').val(markupStr);
        });
    });

    function reset() {
        $("#formsubmit").trigger("reset");
        $('#summernote').summernote('reset');
    }
</script>

</body>

</html>
