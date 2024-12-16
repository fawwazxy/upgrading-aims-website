<?php

include ('../controller/auth.php');

require "../model/staff_function.php";
require "../model/lookup.php";


?>

<?
$staff_record_id = $_GET['staff_record_id'];
$id = $_GET['id'];
$no_staff = $_GET['no_staff'];
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
                <h1 class="page-header">Maklumat Rekod Jawatan</h1>
            </div>
            <div class="panel-heading" align="right">
                <input class="btn btn-primary" type="button" value="Kembali" onclick="goBack()">
            </div>
        </div>

        <div class="row">

            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        <label class="control-label" for="date">Kemaskini Maklumat Rekod Jawatan</label>
                    </div>



                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">


                                <?
                                $log_staff = getStaffRecordDetails($staff_record_id)-> fetch_assoc();
                                ?>

                                <form method="post" action="../controller/staff_update_record_exec.php">
                                    <div>
                                        <label align="left"><font color="red">** Maklumat Wajib Diisi **</font></label>
                                    </div>

                                    <input name="staff_record_id" type="hidden" class="input-short" value="<? echo $staff_record_id;?>" />
                                    <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                                    <input name="no_staff" type="hidden" class="input-short" value="<? echo $no_staff;?>" />

                                    <div class="form-group row" align="left">
                                        <div class="col-xs-5">
                                            <label class="control-label" for="date">Tarikh Mula<font color="red">&nbsp;**</font></label>
                                            <input class="form-control" id="tarikh_mula" name="tarikh_mula" value=" <? echo date('d/m/Y',strtotime($log_staff['tarikh_mula']));?>" placeholder="DD/MM/YYY" type="text"/>
                                        </div>
                                        <div class="col-xs-5">
                                            <label class="control-label" for="date">Tarikh Akhir</label>
                                            <input class="form-control" id="tarikh_akhir" name="tarikh_akhir" value="<?
                                            if($log_staff['tarikh_akhir']!=''){
                                                echo date('d/m/Y',strtotime($log_staff['tarikh_akhir']));}?>" placeholder="DD/MM/YYY" type="text"/>
                                        </div>
                                    </div>

                                    <div class="form-group row" align="left">
                                        <div class="col-xs-5">
                                            <label class="control-label" for="date">Lokasi<font color="red">&nbsp;**</font></label>
                                            <select required class="form-control" id="id_lkp_cawangan" name="id_lkp_cawangan" value="">
                                                <option value="">-- Pilih --</option>
                                                <?echo getDropDown("lkp_cawangan","cawangan_kod","nama",$log_staff['cawangan_kod']);?>
                                            </select>
                                        </div>
                                        <div class="col-xs-5">
                                            <label>Status<font color="red">&nbsp;**</font></label>
                                            <select id="disabledSelect" class="form-control" name="status" value="<? echo $log_staff['status']; ?>">
                                                <option value="">-- Pilih --</option>
                                                <?
                                                $status = getAddStatus();
                                                while ($list  = $status -> fetch_assoc()){ ?>
                                                    <option value="<? echo $list['code'];?>" <?echo($list['desc']==$log_staff['status']?'selected':'');?>> <? echo $list['desc'];?> </option>
                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row" align="left">
                                        <div class="col-xs-5">
                                            <label>Peranan<font color="red">&nbsp;**</font></label>
                                            <select id="disabledSelect" class="form-control" name="peranan" value="<? echo $log_staff['peranan']; ?>">
                                                <option value="">-- Pilih --</option>
                                                <?
                                                $role= getRole();
                                                while ($list  = $role -> fetch_assoc()){ ?>
                                                    <option value="<? echo $list['code'];?>" <? echo($list['code']==$log_staff['peranan']?'selected':'');?>><? echo $list['role_group_name'];?>:-<? echo $list['role'];?> </option>
                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-xs-5">
                                            <label>Bahagian<font color="red">&nbsp;**</font></label>
                                            <select id="disabledSelect" class="form-control" name="department" value="<? echo $log_staff['department']; ?>">
                                                <option value="">-- Pilih --</option>

                                                <?
                                                $role= getAddDepartment();
                                                while ($list  = $role -> fetch_assoc()){ ?>
                                                    <option value="<? echo $list['code_department'];?>"<?echo($list['code_department']==$log_staff['department']?'selected':'');?>><? echo $list['description'];?> </option>

                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>



                                    <div class="form-group row" align="left">
                                        <div class="col-xs-5">
                                            <label>Nama Bank</label>
                                            <input class="form-control"  name="nama_bank" value="<? echo $log_staff['nama_bank']; ?>" >
                                        </div>
                                        <div class="col-xs-5">
                                            <label>No. Akaun Bank</label>
                                            <input class="form-control"  name="no_akaun" value="<? echo $log_staff['no_akaun']; ?>" >
                                        </div>
                                    </div>

                                    <div class="form-group row" align="left">
                                        <div class="col-xs-5">
                                            <label>Gaji</label>
                                            <input class="form-control" type="text" name="gaji" value="<? echo $log_staff['gaji']; ?>" >
                                        </div>
                                        <div class="col-xs-5">
                                            <label class="control-label" for="date">Caw. / Unit</label>
                                            <select class="form-control" id="department_sub" name="department_sub" value="">
                                                <option value="">-- Pilih --</option>
                                                <?echo getDropDown("department_load","code_department","description",$log_staff['department_sub']);?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row" align="left">
                                        <div class="col-xs-5">
                                            <div class="form-group" align="left">
                                                <label>Taraf Jawatan<font color="red">&nbsp;**</font></label>
                                                <br><input type="radio" value="rule1" name="rule_cuti" id="rule_cuti" <?echo $log_staff['rule_cuti'] == 'rule1'?'checked':''?> />
                                                <label>Tetap</label>&nbsp; &nbsp; &nbsp;
                                                <input type="radio" value="rule2" name="rule_cuti" id="rule_cuti" <?echo $log_staff['rule_cuti'] == 'rule2'?'checked':''?> />
                                                <label>Dalam Percubaan</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group row" align="left">
                                        <div class="col-xs-5">
                                            <label>Catatan<font color="red">&nbsp;**</font></label>
                                            <textarea class="form-control" name="catatan" id="catatan" rows="5"><?echo $log_staff['catatan'];?></textarea>
                                        </div>
                                    </div>

                                    <div align="center">
                                        <button type="submit" class="btn btn-success">Simpan</button>
                                        <button type="reset" class="btn btn-warning">Tetapan Semula</button>
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
    function reloadDepartment(val) {
        $.ajax({
            type: "POST",
            url: "../model/staff_function.php",
            data:{action:"subDepartment",kod_department:val},
            success: function(data){
                $("#department_sub").html(data);
                //console.log(val);//reloadJajahan();
            }
        });
    }


</script>

</body>

</html>
