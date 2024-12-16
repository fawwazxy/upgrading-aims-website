<style>
    .red-badge{
        padding: 4px;
        background-color: #e27723;
        color: white;
        font-size: 10px;
        border-radius: 5px;
        margin: 0 4px;
        white-space: nowrap;
    }
    .text-shadow-1{
        font-family: "Unica One", Arial, Helvetica, sans-serif;
        text-shadow: 2px 2px 2px #4e4e4e;
        color: white;
    }
</style>
<div style="margin: 0 0 8px">
    <!--<div class="notification notification-warning notification-closable" role="alert"
         style="background-color: #dcffce; border-width: 0.0625rem; border-radius: .25rem;padding:12px">
        <div class="row">
            <div class="col-md-11">
                <p style="font-weight: bold; font-size: 24px">NEW MOBILE APPS - AIMS-GROUP</p>

                <p>
                    <b>ATTENTION!</b> New mobile apps <b>Aims-Group</b> is now available on all platform (Android, iOS, & Huawei).
                    You now can download <b class="text-primary">Aims-Group app</b> using link below.
                    <br>

                    <i class="text-muted" style="border-bottom: #7c7c7c">
                        <b>PERHATIAN!</b> Aplikasi baharu <b>Aims-Group</b> telah tersedia untuk semua platform (Android, iOS, & Huawei).
                        Anda boleh memuat turun <b class="text-primary">Aplikasi Aims-Group</b> menggunakan pautan di bawah.</i>
                </p>

                <p style="margin: 8px 0">
                    <a href="https://play.google.com/store/apps/details?id=com.aimsglobal.aims_mobile_v1&hl=en" target="_blank"
                       style="margin: 16px">
                        <img src="../../resources/images/get_it_on_play_store.png" alt="Google Play Store Link" style="height: 48px">
                    </a>

                    <a href="https://apps.apple.com/us/app/aims-group/id6449484256" target="_blank"
                       style="margin: 16px">
                        <img src="../../resources/images/get_it_on_app_store.png" alt="Apple App Store Link" style="height: 48px">
                    </a>

                    <a href="https://appgallery.huawei.com/app/C108311275" target="_blank"
                       style="margin: 16px">
                        <img src="../../resources/images/get_it_on_app_gallery.png" alt="Huawei App Gallery Link" style="height: 48px">
                    </a>
                </p>

                <span style="color: #b90009">
                    i-Office Apps will be closed permanently on <b>9<sup>th</sup> June 2023.</b>
                    Therefore, all staffs are required to install the mobile apps before the date.</span><br>
                <span style="font-style: italic; color: #b90009">
                    Aplikasi i-Office akan ditutup secara kekal pada <b>9<sup>th</sup> Jun 2023.</b>
                    Oleh itu, semua staff diminta untuk memasang aplikasi tersebut sebelum tarikh yang dinyatakan.</span><br>
            </div>
            <div class="col-md-1">
                <button type="button" class="close" data-close="notification" onclick="$(this).parents().eq(3).remove()">
                    <span>&times;</span>
                </button>
            </div>
        </div>
    </div>-->
    <?php
    if(isBirthDay($_SESSION['SESS_ID'], date('m-d'))){ ?>
        <div class="notification notification-warning notification-closable" role="alert"
             style="background-color: pink; border-width: 0.0625rem; border-radius: .25rem;padding:12px">
            <div class="row" style="background-image: url('https://png.pngtree.com/background/20210710/original/pngtree-happy-orange-birthday-background-picture-image_982431.jpg');">
                <div class="col-md-9">
                    <p class="text-shadow-1" style="font-weight: bold; font-size: 24px; padding-top: 10px">Happy Birthday</p>

                    <p class="text-shadow-1" style="font-weight: normal; font-size: 16px;">Ikhlas daripada warga AIMS-GLOBAL HOLDINGS SDN. BHD.</p>
                    <br>
                </div>
                <div class="col-md-2" style="padding-top: 20px">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModal">
                        Click to view birthday mate
                    </button>
                </div>
                <div class="col-md-1">
                    <button type="button" class="close" data-close="notification" onclick="$(this).parents().eq(3).remove()">
                        <span>&times;</span>
                    </button>
                </div>
            </div>
        </div>
    <? }
    ?>

</div>

<?php
$display_announcement = true;
if ($display_announcement){
    $color = [
        'blue' => '#7cd6ff',
        'green' => '#c9ff7c',
        'purple' => '#cd7cff',
        'red' => '#ffc2c2',
        'yellow' => '#fff5b7',
        'turquoise' => '#cffffb',
        'pink' => '#ffdaf4',
        'grey' => '#e9e9e9',
        'black' => '#000000',
    ];
    $announcement = getAnnouncementList();
    while($list = $announcement->fetch_assoc()){?>

        <div style="margin: 0 0 8px">
            <div class="notification notification-warning notification-closable" role="alert"
                 style="background-color: <? echo $color[$list['background_color']]?>; border-width: 0.0625rem; border-radius: .25rem;padding:12px">
                <div class="row">
                    <div class="col-md-11">
                        <p style="font-weight: bold; font-size: 24px;">
                            <? echo $list['title']; ?>
                        </p>
                        <? echo $list['description']; ?>
                    </div>
                    <div class="col-md-1">
                        <button type="button" class="close" data-close="notification" onclick="$(this).parents().eq(3).remove()">
                            <span>&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php }
}?>

<!--
Koleksi warna
- hijau muda: #c9ff7c
- biru muda: #7cd6ff
- ungu muda: #cd7cff
-->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Birthday Mate
                </h5>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Department</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $i = 1;
                    $staffs_born_today = getStaffsBornToday(date('m-d'));
                    while ($data = $staffs_born_today->fetch_assoc()){ ?>
                        <tr>
                            <th scope="row"><? echo $i++; ?></th>
                            <td><? echo $data['name'] ?></td>
                            <td><? echo $data['department_sub'] ?></td>
                        </tr>
                    <? } ?>
                    </tbody>
                </table>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>