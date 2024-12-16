<?php

include ('../controller/auth.php');

require "../model/staff_function.php";
require "../model/lookup.php";

?>
<?


$no_staff = $_GET['no_staff'];
$id = $_GET['id'];
$nama = getNama($id) -> fetch_assoc();
$staff = getStaffInformation($no_staff)-> fetch_assoc();
$check = checkStaffRecord($no_staff)-> fetch_assoc();
// echo $staff['staff_record_id'];


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
        $flagScreen="tab_7";
        include ('../global/menu_staff.php');
        ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel-heading" align="right">
                    <?   if($check!="" && $check > 0){
                        $disable="disabled";
                    }else{
                        $disable="";
                    }
                    ?>
                    <button class="btn btn-success add-new" data-toggle="modal"  data-target="#myModal" <? echo $disable ?> >Tambah Maklumat</button><a href="staff_info.php?no_staff=<?echo $no_staff?>">
                        <button class="btn btn-primary">Kembali</button></a>
                </div>

                <div class="panel panel-default">
                    <div class="" align="right">
                    </div>
                    <div class="panel-heading">
                        <label>Maklumat Rekod Jawatan</label>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">

                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" align="left" id="myModalLabel">Tambah Maklumat Rekod Jawatan</h4>
                                </div>

                                <div class="modal-body">

                                    <form method="post" action="../controller/staf_add_record_exec.php">
                                        <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                                        <input name="no_staff" type="hidden" class="input-short" value="<?echo $no_staff;?>" />
                                        <input name="staff_record_id" type="hidden" class="input-short" value="<? echo $staff['staff_record_id'];?>" />

                                        <div>
                                            <label align="left"><font color="red">** Maklumat Wajib Diisi **</font></label>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Tarikh Mula<font color="red">&nbsp;**</font></label>
                                            <input class="form-control" type="date" name="tarikh_mula" value="" required autocomplete="off"
                                                   required pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}">
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Tarikh Akhir<font color="red"></font>&nbsp;</label>
                                            <input class="form-control" type="date"  name="tarikh_akhir" value="">
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Gaji<font color="red"></font>&nbsp;</label>
                                            <input class="form-control" type="text" name="gaji" value="" >
                                        </div>

                                        <div class="form-group" align="left">
                                            <label class="control-label" for="date">Lokasi<font color="red">&nbsp;**</font></label>
                                            <select required class="form-control" id="id_lkp_cawangan" name="id_lkp_cawangan" value="">
                                                <option value="">-- Pilih --</option>
                                                <?echo getDropDown("lkp_cawangan","cawangan_kod","nama",$list_staff['cawangan_kod']);?>
                                            </select>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Peranan<font color="red">&nbsp;**</font></label>
                                            <select class="form-control" name="peranan">
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

                                        <div class="form-group" align="left">
                                            <label>Bahagian<font color="red">&nbsp;**</font></label>
                                            <select id="disabledSelect" class="form-control" name="department" value="<? echo $list_staff['department']; ?>" onchange="reloadDepartment(this.value)">
                                                <option value="">-- Pilih --</option>
                                                <?
                                                $department= getAddDepartment();
                                                while ($list  = $department -> fetch_assoc()){ ?>
                                                    <option value="<? echo $list['code_department'];?>"><? echo $list['description'];?> </option>

                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group" align="left">
                                            <label class="control-label" for="date">Caw. / Unit</label>
                                            <select class="form-control" id="department_sub" name="department_sub" value="">
                                                <option value="">-- Pilih --</option>
                                                <?echo getDropDown("department_load","code_department","description",$log_staff['department_sub']);?>
                                            </select>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Status<font color="red">&nbsp;**</font></label>
                                            <select id="disabledSelect" class="form-control" name="status">
                                                <option value="">-- Pilih --</option>
                                                <?
                                                $status = getAddStatus();
                                                while ($list  = $status -> fetch_assoc()){ ?>
                                                    <option value="<? echo $list['code'];?>"> <? echo $list['desc'];?> </option>
                                                    <?
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>Nama Bank<font color="red"></font>&nbsp;</label>
                                            <input class="form-control"  name="nama_bank" value="" >
                                        </div>

                                        <div class="form-group" align="left">
                                            <label>No. Akaun Bank<font color="red"></font>&nbsp;</label>
                                            <input class="form-control"  name="no_akaun" value="" >
                                        </div>

                                        <!-- <div class="form-group" align="left">
                                        <label>Jumlah Cuti<font color="red">&nbsp;**</font></label>
                                        <input class="form-control"  name="total_cuti" value="" required autocomplete="off">
                                        </div>

                                        <div class="form-group" align="left">
                                        <label>Baki Cuti<font color="red">&nbsp;**</font></label>
                                        <input class="form-control"  name="baki_cuti" value="" required autocomplete="off">
                                        </div>

                                       <div class="form-group" align="left">
                                       <label>Baki Cuti Pohon<font color="red">&nbsp;**</font></label>
                                       <input class="form-control" type="text" name="baki_cuti_pohon" value="" required autocomplete="off">
                                       </div>  -->

                                        <div class="form-group" align="left">
                                            <label>Taraf Jawatan<font color="red">&nbsp;**</font></label>
                                            <br><input type="radio" value="rule2" name="rule_cuti" id="rule_cuti" checked=""/>
                                            <label>Tetap</label>&nbsp; &nbsp; &nbsp;
                                            <input type="radio" value="rule2" name="rule_cuti" id="rule_cuti" />
                                            <label>Dalam Percubaan</label>
                                        </div>

                                        <div class="form-group">
                                            <label for="comment">Catatan</label>
                                            <textarea class="form-control" rows="5" name="catatan" id="catatan"></textarea>
                                        </div>

                                        <div align="right">
                                            <button type="submit" class="btn btn-success">Simpan</button>
                                            <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                        </div>

                                    </form>
                                </div><!--modal-body-->

                            </div>
                            <!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->

                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>No. Staf</th>
                                <th>Tarikh Mula</th>
                                <th>Tarikh Akhir</th>
                                <th>Gaji</th>
                                <th>Cawangan</th>
                                <!--	<th>Kumpulan Peranan</th> -->
                                <th>Peranan</th>
                                <th>Bahagian</th>
                                <th>Unit</th>
                                <th>Status </th>
                                <th>No. Telefon</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data_staff_record = getStaffRecordInfo($no_staff);
                            while($row_data_staff_record = $data_staff_record->fetch_assoc()) {

                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data_staff_record['no_staff']; ?></td>

                                    <td id="tmula"><? echo date('d/m/Y',strtotime($row_data_staff_record['tarikh_mula']));?></td>
                                    <td id="tend">
                                        <?
                                        if($row_data_staff_record['tarikh_akhir']!=null){
                                            echo date('d/m/Y',strtotime($row_data_staff_record['tarikh_akhir']));
                                        }else{
                                            echo "-";
                                        }


                                        ?>

                                    </td>
                                    <td><?php echo $row_data_staff_record['gaji']; ?></td>
                                    <td><?php echo $row_data_staff_record['cawangan']; ?></td>
                                    <!--	<td><?php echo $row_data_staff_record['role_group_name']; ?></td> -->
                                    <td><?php echo $row_data_staff_record['myperanan']; ?></td>
                                    <td><?php echo $row_data_staff_record['mybahagian']; ?></td>
                                    <td><?php echo $row_data_staff_record['myunit']; ?></td>
                                    <td><?php echo $row_data_staff_record['status']; ?></td>
                                    <td><a i class="fa fa-whatsapp" style="font-size:48px;color:green" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $row_data_staff_record['phone']; ?>')"></a></td>

                                    <td>
                                        <?
                                        if($row_data_staff_record['myperanan']=='PELATIH INDUSTRI' && $row_data_staff_record['status']!='TAMATINTERN') {?>


                                        <a href="staff_update_record.php?staff_record_id=<? echo $row_data_staff_record['id'];?>&no_staff=<? echo $row_data_staff_record['no_staff'];?>"><button class="btn btn-info" type="button" >Kemaskini Maklumat</button></a>
                                        <a href="" onclick="return popitup('../template/surat_offer_intern.php?id=<? echo $row_data_staff_record['id']; ?>&no_staff=<? echo $row_data_staff_record['no_staff']; ?>')"><button type="button" class="btn btn-warning">Surat Intern</button>

                                            <?
                                            }

                                            else if($row_data_staff_record['myperanan']=='PELATIH INDUSTRI' && $row_data_staff_record['status']=='TAMATINTERN' ) {?>
                                            <a href="staff_update_record.php?id=<?echo $id;?>&staff_record_id=<? echo $row_data_staff_record['id'];?>&no_staff=<? echo $row_data_staff_record['no_staff'];?>"><button class="btn btn-info" type="button" >Kemaskini Maklumat</button></a>
                                            <a href="" onclick="return popitup('../template/surat_tamat_intern.php?id=<? echo $row_data_staff_record['id']; ?>&no_staff=<? echo $row_data_staff_record['no_staff']; ?>')"><button type="button" class="btn btn-warning">Surat Tamat Intern</button>

                                                <? }
                                                else if($row_data_staff_record['myperanan']!='PELATIH INDUSTRI' && $row_data_staff_record['status']=='BEKERJA' ) {?>
                                                    <a href="staff_update_record.php?id=<?echo $id;?>&staff_record_id=<? echo $row_data_staff_record['id'];?>&no_staff=<? echo $row_data_staff_record['no_staff'];?>"><button class="btn btn-info" type="button" >Kemaskini Maklumat</button></a>
                                                    <br><a href="staff_update_cuti.php?id=<?echo $id;?>&staff_record_id=<? echo $row_data_staff_record['id'];?>&no_staff=<? echo $row_data_staff_record['no_staff'];?>"><button class="btn btn-primary" type="button" >Kemaskini Cuti</button></a>
                                                    <a href="aims_lv_tetapan_medical.php?id=<?echo $id;?>&staff_record_id=<? echo $row_data_staff_record['id'];?>&no_staff=<? echo $row_data_staff_record['no_staff'];?>"><button class="btn btn-primary" type="button" >Kemaskini Medical</button></a>

                                                    <?
                                                }
                                                else if($row_data_staff_record['myperanan']!='myperanan' && $row_data_staff_record['status']=='SMBG BLJR' && 'NAIK PGKT' ) {?>
                                                    <a href="staff_update_record.php?id=<?echo $id;?>&staff_record_id=<? echo $row_data_staff_record['id'];?>&no_staff=<? echo $row_data_staff_record['no_staff'];?>"><button class="btn btn-info" type="button" >Kemaskini Maklumat</button></a>




                                                <?}?>
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
    });



    var tarikh_mula=$('input[name="'+tkhMula+'"]'); //our date input has the name "date"
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    tarikh_mula.datepicker({
        format: 'dd/mm/yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,
    });
    var tarikh_akhir=$('input[name="'+tkhAkhir+'"]'); //our date input has the name "date"
    // var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";
    tarikh_akhir.datepicker({
        format: 'dd/mm/yyyy',
        container: container,
        todayHighlight: true,
        autoclose: true,

        todayHighlight:true
    });
    function reloadDepartment(val) {
        $.ajax({
            type: "POST",
            url: "../model/staff_function.php",
            data:{action:"subDepartment",kod_department:val},
            success: function(data){
                $("#department_sub1").html(data);
                //console.log(val);//reloadJajahan();
            }
        });
    }


</script>

</body>

</html>
