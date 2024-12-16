<?php
if ($staff_id != $_SESSION['SESS_ID'] && !in_array($_SESSION['SESS_DEPARTMENT_SUB'],['HR','HR-SEA']) && $role != 'SUPERADMIN'){
    echo("<script type='text/javascript'>
            alert('Anda hanya dibenarkan untuk kemaskini akaun sendiri')
            history.back();
            </script>");
    exit();
}
?>
<style>
    .img {
        border-radius: 10px;
        border: 1px solid grey;
        width:  100px;
        height: 100px;
        object-fit: cover;
    }.overlay {
         position: absolute;
         top: 6%;
         bottom: 0;
         left: 18%;
         right: 0;
         border-radius: 10px;
         width:  100px;
         height: 100px;
         opacity: 0;
         transition: .3s ease;
         background-color: white;
     }
    .containerHover:hover .overlay {
        opacity: 0.7;
    }
    .icon {
        position: absolute;
        color: black;
        top: 50%;
        left: 47%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
    }
    .containerHover {
        position: relative;
        width:  100px;
        height: 100px;
    }
</style>

<div class="row">
    <div class="col-lg-12">
        <? if ($role == 'SUPERADMIN' || $_SESSION['SESS_DEPARTMENT_SUB'] == 'HR'){ ?>
            <h1 class="page-header">Tetapan Maklumat</h1>
            <!--<a href="staff_info.php" class="btn btn-primary" style="float: right">Kembali ke Staff Info</a>-->
        <? } else { ?>
            <h1 class="page-header">Kemaskini Profil</h1>
        <? } ?>
        <div class="panel panel-default">
            <div class="panel-heading">MAKLUMAT STAF</div>
            <div class="panel-body">
                <table class="table table-bordered">
                    <tbody>
                    <? $row_info = getStaffRecordList($staff_no)->fetch_assoc(); ?>
                    <tr>
                        <td class="containerHover text-center" rowspan="4" style="width: 10%">
                            <img src="../../staffphoto/<? echo $row_info['nama_photo'] ?>" class="img" alt="image-staff">
                            <div class="overlay">
                                <a data-target="#updateProfile" data-toggle="modal" class="icon" title="Kemaskini Profil">
                                    <i class="fa fa-user"></i>
                                </a>
                            </div>
                            <div class="row text-center" style="margin-top: 8px">
                                <a href="../controller/staff_profile_delete.php?id=<? echo $row_info['id']?>" style="font-size: 12px; font-weight: bold; text-decoration: none">
                                    Padam Gambar
                                </a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="text-left" style="width: 30%">Staf No : <b><? echo $row_info['no_staff']; ?></b></td>
                        <td class="text-left">Peranan : <b><? echo $row_info['role_id']; ?></b></td>
                        <td class="text-left">Cawangan Kod : <b><? echo $row_info['nama_cawangan']; ?></b></td>
                    </tr>
                    <tr>
                        <td>Nama : <b><? echo $row_info['name']; ?></b></td>
                        <td class="text-left">Tarikh Mula : <b><? echo $row_info['tarikh_mula']; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;Tarikh Akhir : <b><? echo ($row_info['tarikh_akhir'] != '0000-00-00' && !empty($row_info['tarikh_akhir']))?:'<i class="text-muted" style="font-size: 10pt">-- No Data --</i>'; ?></b></td>
                        <td class="text-left">Caw./Unit : <b><? echo $row_info['nama_deptsub']; ?></b></td>
                    </tr>
                    <tr>
                        <td class="text-left">No. Telefon : <a style="text-decoration: none" onclick="return popitup('https://web.whatsapp.com/send?phone=<? echo $row_info['phone']; ?>')"><i class="fa fa-whatsapp" style="color: green"></i> <? echo $row_info['phone']; ?></a></td>
                        <td class="text-left" style="width: 30%">Status : <b><? echo $row_info['status']; ?></b></td>
                        <td class="text-left">Bahagian : <b><? echo $row_info['description']; ?></b></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div id='cssmenu'>
    <ul>
        <? if ($role == 'SUPERADMIN' || $_SESSION['SESS_DEPARTMENT_SUB'] == 'HR'){ ?>
            <li class="<? echo ($flagScreen=='tab_1'?'active':'') ?>"><a href="staff_update.php?flagScreen=tab_1&id=<? echo $staff_id;?>">Maklumat Pekerja</a></li>
        <? } ?>
        <li class="<? echo ($flagScreen=='tab_2'?'active':'') ?>"><a href="staff_education.php?flagScreen=tab_2&id=<? echo $staff_id;?>">Maklumat Pendidikan</a></li>
        <li class="<? echo ($flagScreen=='tab_3'?'active':'') ?>"><a href="staff_previous_employment.php?flagScreen=tab_3&id=<? echo $staff_id;?>">Maklumat Pekerjaan Terdahulu</a></li>
        <li class="<? echo ($flagScreen=='tab_4'?'active':'') ?>"><a href="staff_skill.php?flagScreen=tab_4&id=<? echo $staff_id;?>">Maklumat Kemahiran </a></li>
        <li class="<? echo ($flagScreen=='tab_5'?'active':'') ?>"><a href="staff_family.php?flagScreen=tab_5&id=<? echo $staff_id;?>">Maklumat Keluarga </a></li>
        <? if ($role == 'SUPERADMIN' || $_SESSION['SESS_DEPARTMENT_SUB'] == 'HR'){ ?>
            <li class="<? echo ($flagScreen=='tab_6'?'active':'') ?>"><a href="staff_position_record.php?flagScreen=tab_6&id=<? echo $staff_id;?>">Maklumat Gaji </a></li>
        <? } ?>
    </ul>
</div>
<!-- The Profile Modal -->
<div class="modal fade" id="updateProfile">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">KEMASKINI PROFIL</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="upload_image">Muat Turun Profil: <span style="color: red; ">*</span></label>
                                    <input accept="image/*" id="upload_image"
                                           name="upload_image" type="file" required/>
                                    <div id="uploaded_image"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="uploadimageModal" class="modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" action="../controller/staff_position_record_crop_image_exec.php" enctype="multipart/form-data">
                <input type="hidden" name="no_staff" value="<? echo $staff_no; ?>">
                <input type="hidden" value="" name="image_data" id="image_data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">MUAT TURUN & PANGKAS IMEJ</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="image_demo"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-block btn-success crop_image" type="submit">Muat Turun & Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function popitup(url) {
        newwindow=window.open(url,'name','height=595,width=842');
        if (window.focus) {newwindow.focus()}
        return false;
    }
    $(document).ready(function(){
        let $image_crop = $('#image_demo').croppie({
            enableExif: true,
            viewport: {
                width: 448,
                height: 448,
                type: 'square'
            },
            boundary: {
                width: 512,
                height: 512
            },
        });
        $('#upload_image').on('change', function(){
            let reader = new FileReader();
            reader.onload = function (event) {
                $image_crop.croppie('bind', {
                    url: event.target.result
                }).then(function(){
                    console.log('jQuery bind complete');
                });
            }
            reader.readAsDataURL(this.files[0]);
            $('#uploadimageModal').modal('show');
        });
        $('.crop_image').click(function(event){
            $image_crop.croppie('result', {
                type: 'canvas',
                size: 'viewport'
            }).then(function(response){
                $('#image_data').val(response);
            })
        });
    });
</script>