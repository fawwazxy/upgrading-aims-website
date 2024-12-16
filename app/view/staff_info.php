<?php
include ('../controller/auth.php');
require "../model/staff_function.php";
require "../model/lookup.php";

if ($_SESSION['SESS_DEPARTMENT_SUB'] != 'HR' && $_SESSION['SESS_ID'] != '2') {
    echo "<script>
            alert('Halaman ini hanya tersedia untuk department HR')
            window.history.back();
            </script>";
    exit();
}


$id = $_GET['id'];
$no_staff = $_GET['no_staff'];
$tahun = $_GET['tahun'];
$statact = ($_GET['statact']) ?: '0';
$active_status = ($_GET['active_status']) ?: 'BEKERJA';

$cawangan_kod= ($_GET['cawangan_kod']) ?: '0';

$default_company = (!in_array($_SESSION['SESS_DEPARTMENT'], ['','SYSTEM'])) ? $_SESSION['SESS_DEPARTMENT'] : '0';
$jabatan_kod= ($_GET['jabatan_kod'] != '') ? $_GET['jabatan_kod'] : $default_company;
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
    <style>
        .img {
            border-radius: 10px;
            border: 1px solid grey;
            width:  100px;
            height: 100px;
            object-fit: cover;

        }
    </style>
    <script type="text/javascript">
        function Confirm(){
            return confirm('Adakah Anda Pasti untuk tekan butang berhenti ini?');
        }

        function Confirm2(){
            return confirm('Adakah Anda Pasti untuk tekan butang bekerja ini??');
        }
        function popitup(url) {
            newwindow=window.open(url,'name','height=595,width=842');
            if (window.focus) {newwindow.focus()}
            return false;
        }
    </script>
</head>
<body>
<div id="wrapper">
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include ('../global/menu_top.php'); ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <? include ('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>

    <div id="page-wrapper">
        <? //include ('../global/menu_staffinfo.php'); ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Info Pekerja <? //echo $nama_cawangan;?></h1>
            </div>

        </div>
        <div class="row" style="margin-bottom: 16px">
            <form action="" method="get">
                <div class="col-md-7">
                    <div class="row">
                        <div class="col-lg-6">
                            <select  required class="form-control" name="jabatan_kod" id="jabatan_kod">
                                <option value="0">Semua Bahagian</option>
                                <? echo getDropDown("department","code_department","description",$jabatan_kod);?>
                            </select>
                        </div>

                        <div class="col-lg-3">
                            <select  required class="form-control" name="statact" id="statact">
                                <option value="0" <? if($statact == '0') echo 'selected' ?>>Semua Peranan</option>
                                <option value="STAFF" <? if($statact == 'STAFF') echo 'selected' ?>>Kakitangan</option>
                                <option value="CONTRACT" <? if($statact == 'CONTRACT') echo 'selected' ?>>Kontrak</option>
                                <option value="INTERN" <? if($statact == 'INTERN') echo 'selected' ?>>Pelatih</option>

                            </select>
                        </div>

                        <div class="col-lg-3">
                            <select  required class="form-control" name="active_status" id="active_status">
                                <option value="BEKERJA" <? if($active_status == 'BEKERJA') echo 'selected' ?>>Aktif</option>
                                <option value="BERHENTI" <? if($active_status == 'BERHENTI') echo 'selected' ?>>Tidak Aktif</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="row">
                        <div class="col-md-3">
                            <button class="btn btn-success">Cari</button>
                        </div>
                        <div class="col-md-9 text-right">
                            <a class="btn btn-warning" data-toggle="modal" data-target="#myModal1">Muat Naik Excel</a>
                            <!--<a href="update_staff.php?id=0" class="btn btn-primary">Tambah</a>-->
                            <a href="staff_add.php" class="btn btn-primary">Tambah</a>
                            <button type="button" onclick="return popitup('kad_semua_staff.php?no_staff=<?echo $no_staff?>&statact=<?echo $statact?>')" class="btn btn-info">Cetak Kad</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="myModalLabel">Muat Naik Fail</h4>
                    </div>
                    <div class="modal-body">
                        <form method="post" action="../controller/upload_staf_exec.php" enctype="multipart/form-data">
                            <input type="hidden" name="company_id"  value="<? echo $_SESSION['SESS_COM']; ?>">
                            <!--<input type="hidden" name="shortcode"  value="<?/* echo $shortcode;*/?>">-->
                            <input type="hidden" name="cawangan_kod"  value="<? echo $cawangan_kod;?>">
                            <input id="action" name="action" type="hidden" value="upload"/>
                            <div class="form-group">
                                <label class="control-label">Fail<span style="color: red; "> **</span>&nbsp;(Fail Excel Sahaja)</label>
                                <input required  accept=".xlsx" type="file" name="csv_file" id="csv_file" class="btn btn-link">

                            </div>
                            <div class="form-group">
                                <label class="control-label">Contoh Excel : </label>
                                <br><a href="../../resources/items/format_add_staf.xlsx">Muat Turun Format</a>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Simpan</button>
                                <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading" style="font-weight: bold">
                        Senarai Pekerja -
                        <span style="color: <? echo ($active_status == 'BEKERJA') ? 'blue' : 'red';?>">
                            <? echo $active_status ?>
                        </span>
                    </div>
                    <div class="panel-body">
                        <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" />
                        <input name="no_staff" type="hidden" class="input-short" value="<? echo $no_staff;?>" />
                        <table style="width: 100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Gambar Profil</th>
                                <th>Nama Pekerja</th>
                                <th>Kumpulan Peranan</th>
                                <th>Peranan</th>
                                <th>Bahagian</th>
                                <th>Unit</th>
                                <th>No Telefon</th>
                                <th>Tarikh Mula & Tamat</th>
                                <th>Tindakan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?
                            $i= 1;
                            $data_staff = getLogStaffByJabatan($cawangan_kod,$jabatan_kod,$statact, $active_status);
                            while($row_data_staff = $data_staff->fetch_assoc()) {

                                $slip_gaji = $row_data_staff['slip_gaji'];
                                $peranan = $row_data_staff['role'];

                                $nostaff = $row_data_staff['no_staff'];
                                $recordservice_start = getRecStart($nostaff) -> fetch_assoc();
                                $recordservice_end = getRecEnd($nostaff) -> fetch_assoc();
                                $enddate = $recordservice_end['tarikh_akhir'];

                                ?>
                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><img src="../../staffphoto/<? echo $row_data_staff['nama_photo'] ?>" class="img" alt="image-staff"></td>
                                    <td>
                                        <b><a href="" onclick="return popitup('staff_details.php?no_staff=<? echo $row_data_staff['no_staff'];?>')"><?php echo $row_data_staff['name']; ?></a><br>
                                            &nbsp;<?php echo $row_data_staff['no_staff']; ?><br>
                                            &nbsp;<?php echo $row_data_staff['noic']; ?></b>
                                    </td>
                                    <td><b><?php echo $row_data_staff['role_group_name']; ?></b></td>
                                    <td><b><?php echo $row_data_staff['role']; ?></b></td>
                                    <td><b><?php echo $row_data_staff['description']; ?></b></td>
                                    <td><b><?php echo $row_data_staff['department_sub']; ?></b></td>
                                    <td>
                                        <b><?php echo $row_data_staff['phone']; ?></b><br>
                                        <button class="btn btn-success" onclick="return popitup('https://web.whatsapp.com/send?phone=<?php echo $row_data_staff['phone']; ?>')" >WhatsApp</button><br>
                                    </td>
                                    <td>
                                        <b>
                                            <?php
                                            echo $recordservice_start['tarikh_mula']." - ";
                                            echo ($enddate == '' || $enddate == '00/00/0000') ? "SEKARANG" : $recordservice_end['tarikh_akhir'];
                                            ?>
                                        </b>
                                    </td>

                                    <td class="text-center">
                                        <div class="dropdown">
                                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuLeave" data-toggle="dropdown"
                                                    aria-haspopup="true" aria-expanded="true">
                                                <i class="fa fa-caret-down"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuStaffInfo" style="margin-left: -96px">
                                                <li><a style="display: block" href="staff_update.php?id=<? echo $row_data_staff['id'];?>"><i class="fa fa-pencil opt-icon"></i> Kemaskini</a></li>
                                                <?
                                                if ($row_data_staff['status'] == 'BEKERJA') { ?>
                                                    <li><a style="display: block" href="../controller/staff_status_exec.php?id=<? echo $row_data_staff['id'];?>&no_staff=<? echo $row_data_staff['no_staff'];?>" onclick="return Confirm()"><i class="fa fa-exclamation-circle opt-icon"></i> Berhenti</a></li>

                                                    <li><a style="display: block" href="" onclick="return popitup('kad_staff.php?id=<? echo $row_data_staff['id']; ?>')"><i class="fa fa-print opt-icon"></i> Cetak Kad</a></li>
                                                    <li>
                                                        <a style="display: block" href="../view/v02_aims_leave_quota.php?id=<? echo $row_data_staff['id'] ?>" target="_blank">
                                                            <i class="fa fa-bar-chart opt-icon"></i> Kuota Cuti <span class="version" style="font-size: 50%">v2</span></a>
                                                    </li>
                                                    <li>
                                                        <a style="display: block" href="../view/v02_aims_medical_quota.php?id=<? echo $row_data_staff['id'] ?>" target="_blank">
                                                            <i class="fa fa-clipboard opt-icon"></i> Kuota Perubatan <span class="version" style="font-size: 50%">v2</span></a>
                                                    </li>
                                                    <? if ($slip_gaji == '1') { ?>
                                                        <li><a style="display: block" href="" onclick="return popitup('../template/surat_pengesahan_jawatan.php?no_staff=<? echo $row_data_staff['no_staff'];?>')"><i class="fa fa-envelope opt-icon"></i> Surat Pengesahan</a></li>
                                                        <li><a style="display: block " href="bulan_salary.php?id=<? echo $row_data_staff['id'];?>&no_staff=<?php echo $row_data_staff['no_staff']; ?>&tahun=<? echo $tahun; ?>"><i class="fa fa-file opt-icon"></i> Maklumat Gaji</a></li>
                                                        <li><a style="display: block" href="penentuan_tarikh_bekerja_staff.php?id=<? echo $row_data_staff['id'];?>&no_staff=<? echo $row_data_staff['no_staff'];?>"><i class="fa fa-calendar opt-icon"></i> Tetapan OffDay</a></li>

                                                    <? } ?>
                                                    <li><a style="display: block" href="../controller/staff_reset_password.php?id=<? echo $row_data_staff['id'];?>" onclick="return confirm('Anda pasti set semula kata laluan?')"><i class="fa fa-recycle opt-icon"></i> Set Semula Kata Laluan</a></li>

                                                <? }else if  ($row_data_staff['status'] == 'SMBGBLJR') {  ?>

                                                    <li><a style="display: block" href="../controller/staff_status_exec_2.php?id=<? echo $row_data_staff['id'];?>&no_staff=<? echo $row_data_staff['no_staff'];?>"><button class="btn btn-success" type="button" onclick="return Confirm2()"><i class="fa fa-user opt-icon"></i> Bekerja</a></li>

                                                <? } else if ($row_data_staff['status'] == 'NAIKPGKT'){ ?>
                                                    <li><a style="display: block" href="../controller/staff_status_exec.php?id=<? echo $row_data_staff['id'];?>&no_staff=<? echo $row_data_staff['no_staff'];?>"><button class="btn btn-danger" type="button" onclick="return Confirm()" ><i class="fa fa-exclamation-circle opt-icon"></i> Berhenti</a></li>

                                                    <? if ($slip_gaji == '1') { ?>
                                                        <li><a style="display: block " href="bulan_salary.php?id=<? echo $row_data_staff['id'];?>&no_staff=<?php echo $row_data_staff['no_staff']; ?>&tahun=<? echo $tahun; ?>"><i class="fa fa-file opt-icon"></i> Maklumat Gaji</a></li>
                                                    <? }

                                                } else if ($row_data_staff['status'] == 'BERHENTI'){ ?>

                                                    <li><a style="display: block" href="../controller/staff_status_exec_2.php?id=<? echo $row_data_staff['id'];?>&no_staff=<? echo $row_data_staff['no_staff'];?>" onclick="return Confirm2()"><i class="fa fa-user opt-icon"></i> Bekerja</a></li>

                                                    <? if ($peranan == 'INTERN') {?>
                                                        <li><a style="display: block" href="" onclick="return popitup('../template/surat_tamat_intern.php?no_staff=<? echo $row_data_staff['no_staff'];?>')"><i class="fa fa-check-circle opt-icon"></i> Tamat Berlatih</a></li>
                                                    <? }else {?>
                                                        <li><a style="display: block" href="" onclick="return popitup('../template/surat_keterangan_berhenti_kerja.php?no_staff=<? echo $row_data_staff['no_staff'];?>')"><i class="fa fa-envelope-o opt-icon"></i> Surat Keterangan Berhenti</a></li>
                                                    <? }

                                                } else if ($row_data_staff['status'] == 'TAMATINTERN'){

                                                    if ($peranan == 'INTERN') {?>
                                                        <li><a style="display: block" href="" onclick="return popitup('../template/surat_tamat_intern.php?no_staff=<? echo $row_data_staff['no_staff'];?>')"><i class="fa fa-check-circle opt-icon"></i> Tamat Berlatih</a></li>
                                                    <? }else {?>
                                                        <li><a style="display: block" href="" onclick="return popitup('../template/surat_keterangan_berhenti_kerja.php?no_staff=<? echo $row_data_staff['no_staff'];?>')"><i class="fa fa-envelope-o opt-icon"></i> Surat Keterangan Berhenti</a></li>
                                                    <? }
                                                } else{?>
                                                    <li><span style="display: block; margin: 0 16px" class="disabled">- Tiada Pilihan Tindakan -</span></li>
                                                <? } ?>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <?php $i++; } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>
</body>
</html>