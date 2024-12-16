<?php
require "../controller/auth.php";
require "../model/staff_function.php";
require "../model/lookup.php";
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
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
        <? include('../global/menu_top.php'); ?>
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <? include('../global/menu_left.php'); ?>
                </ul>
            </div>
        </div>
    </nav>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Tetapan Maklumat </h1>
            </div>
        </div>
        <div id='cssmenu'>
            <ul>
                <li class="active"><a href="staff_add.php">Maklumat Pekerja</a></li>
            </ul>
        </div>
        <div class="row">
            <div class="panel-heading"></div>
            <form action="../controller/staff_add_exec.php" enctype="multipart/form-data" id="myform" method="post">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>MAKLUMAT PERIBADI</b>
                        </div>
                        <div class="panel-body">
                            <div class="form-group row">
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="ic_number">Kad Pengenalan<span
                                                    style="color: red; ">&nbsp;*</span></label>
                                        <input class="form-control" id="ic_number" maxlength="12" name="ic_number"
                                               oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                               required
                                               type="text">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="name">Nama<span style="color: red; ">&nbsp;*</span></label>
                                        <input class="form-control" id="name"
                                               name="name" onkeyup="convertToUppercase(this)" required
                                               style="text-transform:uppercase"
                                               type="text">
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="tarikh_lahir">Tarikh Lahir<span
                                                    style="color: red; ">&nbsp;*</span></label>
                                        <input class="form-control" id="tarikh_lahir" name="tarikh_lahir"
                                               readonly type="date">
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="control-label" for="umur">Umur</label>
                                        <input class="form-control" id="umur" readonly type="text">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="phone">Nombor Telefon<span
                                                    style="color: red; ">&nbsp;*</span></label>
                                        <input class="form-control" id="phone" maxlength="15" name="phone"
                                               oninput="this.value = this.value.replace(/[^+0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                               required
                                               type="text" value="+60">
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <label for="email">Email<span style="color: red; ">&nbsp;*</span></label>
                                        <input class="form-control" id="email" name="email" required type="email">
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="martial_status">Status<span
                                                    style="color: red; ">&nbsp;*</span></label>
                                        <select class="form-control" id="martial_status" name="martial_status"
                                                required>
                                            <? $martial_status = getMartial();
                                            while ($list = $martial_status->fetch_assoc()) { ?>
                                                <option value="<? echo $list['id']; ?>"><? echo $list['desc']; ?> </option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="control-label" for="gender">Jantina<span
                                                    style="color: red; ">&nbsp;*</span></label>
                                        <select class="form-control" id="gender" name="gender" required>
                                            <option value="">PILIH</option>
                                            <option value="LELAKI">LELAKI</option>
                                            <option value="PEREMPUAN">PEREMPUAN</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="tanggungan">Tanggungan</label>
                                        <input class="form-control" id="tanggungan" min="0" name="tanggungan"
                                               type="number">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="alamat_tetap">Alamat Tetap</label>
                                        <textarea class="form-control" id="alamat_tetap" name="alamat_tetap"
                                                  rows="4"></textarea>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="alamat_surat">Alamat Surat Menyurat</label>
                                        <textarea class="form-control" id="alamat_surat" name="alamat_surat"
                                                  rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <b>MAKLUMAT STAF</b>
                        </div>
                        <div class="panel-body">
                            <div class="form-group row">
                                <div class="col-lg-2">
                                    <div class="form-group" title="Gunakan Nombor IC jika tiada nombor kakitangan">
                                        <label for="no_staff">No Kakitangan <span style="color: red;font-size: 6pt">*</span></label>
                                        <input class="form-control" id="no_staff" name="no_staff" placeholder="1022/C001"
                                               type="text">
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="username">ID Akses Pengguna<span
                                                    style="color: red; ">&nbsp;*</span></label>
                                        <input class="form-control" id="username" name="username" readonly
                                               type="text">
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label class="control-label" for="peranan">Peranan<span
                                                    style="color: red; ">&nbsp;*</span></label>
                                        <select class="form-control" id="peranan" name="peranan" required>
                                            <option value="">-- Pilih --</option>
                                            <? $role = getRole();
                                            while ($list = $role->fetch_assoc()) { ?>
                                                <option value="<? echo $list['code']; ?>"><? echo $list['role_group_name']; ?>
                                                    :-<? echo $list['role']; ?> </option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="unit">Caw. / Unit<span
                                                    style="color: red; ">&nbsp;*</span></label>
                                        <select class="form-control" id="unit" name="unit" required>
                                            <option value="">-- Pilih --</option>
                                            <? echo getDropDown("department_load", "code_department", "description", ''); ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="bahagian">Bahagian <span
                                                    style="color: red; ">*</span>&nbsp</label>
                                        <select class="form-control" id="bahagian" name="bahagian" required>
                                            <option value="">-- Pilih --</option>
                                            <?
                                            $role = getAddDepartment();
                                            while ($list = $role->fetch_assoc()) { ?>
                                                <option value="<? echo $list['code_department']; ?>"><? echo $list['description']; ?> </option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="lokasi" class="control-label">Lokasi<span style="color: red; ">&nbsp;*</span></label>
                                        <select class="form-control" id="lokasi" name="lokasi" required required>
                                            <? echo getDropDown("lkp_cawangan", "cawangan_kod", "nama", ''); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="jum_jam_kerja">Jumlah Jam Kerja<span
                                                    style="color: red; ">&nbsp;*</span></label>
                                        <input class="form-control" id="jum_jam_kerja" name="jum_jam_kerja"
                                               pattern="(?:[01]\d|2[0123]):(?:[012345]\d):(?:[012345]\d)"
                                               placeholder="08:00:00" value="08:00:00"
                                               required type="text" maxlength="8">
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="jum_jam_break">Jumlah Jam Rehat<span
                                                    style="color: red; ">&nbsp;*</span></label>
                                        <input class="form-control" id="jum_jam_break" name="jum_jam_break"
                                               pattern="(?:[01]\d|2[0123]):(?:[012345]\d):(?:[012345]\d)"
                                               placeholder="01:00:00" value="01:00:00"
                                               required type="text" maxlength="8">
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="tarikh_mula">Tarikh Mula<span
                                                    style="color: red;">&nbsp;*</span></label>
                                        <input class="form-control" id="tarikh_mula" name="tarikh_mula" required
                                               type="date" value="<? echo date('Y-m-d') ?>">
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="tarikh_akhir">Tarikh Akhir</label>
                                        <input class="form-control" id="tarikh_akhir" name="tarikh_akhir"
                                               type="date">
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="status">Status <span
                                                    style="color: red; ">*</span>&nbsp;</label>
                                        <select class="form-control" id="status" name="status">
                                            <? $status = getAddStatus();
                                            while ($list = $status->fetch_assoc()) { ?>
                                                <option value="<? echo $list['code']; ?>"><? echo $list['desc']; ?> </option>
                                            <? } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="leave_approval">Pelulus Cuti<span
                                                    style="color: red; ">&nbsp;*</span></label>
                                        <select class="form-control" id="leave_approval" name="leave_approval"
                                                required>
                                            <option value="">-- Pilih --</option>
                                            <? echo getDropDownStaff(''); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="taraf_jawatan">Taraf Jawatan</label> <br><a
                                                class="btn-sm btn-danger"
                                                style="text-decoration:none;font-size: 7pt;cursor: pointer"
                                                onClick="resetTarafJawatan()">Set Semula</a><br>
                                        <input id="taraf_jawatan_1" name="taraf_jawatan" type="radio" value="TETAP">
                                        TETAP
                                        &nbsp;
                                        <input id="taraf_jawatan_0" name="taraf_jawatan" type="radio"
                                               value="DALAM PERCUBAAN"> DALAM PERCUBAAN
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="pantau_kehadiran">Pemantauan Kehadiran</label><br>
                                        <input id="pantau_kehadiran" name="pantau_kehadiran" type="radio" value="1">
                                        YA
                                        &nbsp;
                                        <input checked="checked" id="pantau_kehadiran" name="pantau_kehadiran"
                                               type="radio" value="0"> TIDAK
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="status_qrcode">Status Qr-code</label><br>
                                        <input id="status_qrcode" name="status_qrcode" type="radio" value="1"> YA
                                        &nbsp;
                                        <input checked="checked" id="status_qrcode" name="status_qrcode"
                                               type="radio"
                                               value="0"> TIDAK
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="status_swafoto">Status Swafoto</label><br>
                                        <input id="status_swafoto" name="status_swafoto" type="radio" value="1"> YA
                                        &nbsp;
                                        <input checked="checked" id="status_swafoto" name="status_swafoto"
                                               type="radio"
                                               value="0"> TIDAK
                                    </div>
                                </div>

                                <div class="col-lg-2">
                                    <div class="form-group">
                                        <label for="status_tag">Status Tag</label><br>
                                        <input id="status_tag" name="status_tag" type="radio" value="1"> YA &nbsp;
                                        <input checked="checked" id="status_tag" name="status_tag" type="radio"
                                               value="0"> TIDAK
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div style="float: right">
                                        <a href="staff_info.php" class="btn btn-primary">Kembali</a>
                                        <input type="submit" class="btn btn-success" value="Seterusnya">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <? include "../global/footer.php"; ?>
    </div>

    <script type="text/javascript">
        function resetTarafJawatan() {
            $('#taraf_jawatan_1, #taraf_jawatan_0').prop('checked', false);
        }

        $(document).on('submit', function () {
            let ic = $('#ic_number').val();
            let phone = $('#phone').val();
            if (ic.length < 12) {
                alert('Angka No. Kad Pengenalan hendaklah 12 digit');
                return false;
            }
            if (phone.length < 12) {
                alert('Sila masukkan nombor telefon pekerja');
                return false;
            }
        });

        $(document).ready(function () {
            $("#ic_number").change(function () {
                let ic = $("#ic_number").val();
                let birthDate  = $('#tarikh_lahir');

                if (ic.match(/^(\d{2})(\d{2})(\d{2})(\d{2})(\d{4})$/)) {
                    let year = RegExp.$1;
                    let month = RegExp.$2;
                    let day = RegExp.$3;
                    let lastNum = RegExp.$5;
                    let gender = lastNum % 2;
                    console.log(year, month, day);

                    if (gender === 1) {
                        $("#gender").val("LELAKI");
                    } else {
                        $("#gender").val("PEREMPUAN");
                    }

                    let now = new Date().getFullYear().toString();

                    let decade = now.substr(0, 2);
                    if (now.substr(2, 2) > year) {
                        year = parseInt(decade.concat(year.toString()), 10);
                    } else {
                        year = "19" + year;
                    }

                    birthDate.val(year + "-" + month + "-" + day);

                    let dob = new Date(birthDate.val());
                    let today = new Date();
                    let age = Math.floor((today - dob) / (365.25 * 24 * 60 * 60 * 1000));
                    if (isNaN(age)) {
                        age = 0;
                    }

                    //Send value to field
                    $('#username').val(ic);
                    $('#umur').val(age);
                }
            });
        });
    </script>
</body>
</html>
