<?php
include ('../controller/auth.php');
require "../model/dashboard_functions.php";
$photo_url = getStaffPhotoUrl($_SESSION['SESS_ID']);
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
        .img-frame {
            border: 3px outset black;
            border-radius: 25px;
            width: 75%;
        }
    </style>
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
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Kemaskini Gambar</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Kemaskini Gambar Peribadi
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6 text-center">
                                <img src="../../staffphoto/<? echo $photo_url ?>" alt="staff-photo" class="img-frame">
                            </div>

                            <div class="col-md-6">
                                <h3>Upload new image:</h3>
                                <br>
                                <input type="file" name="upload_image" id="upload_image" accept="image/*" />
                                <div id="uploaded_image"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>


<div id="uploadimageModal" class="modal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form method="post" action="../controller/crop_image_exec.php" enctype="multipart/form-data">
                <input type="hidden" name="no_staff" value="<? echo $_SESSION['SESS_NO_STAFF']; ?>">
                <input type="hidden" value="" name="image_data" id="image_data">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Upload & Crop Image</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="image_demo"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-block btn-success crop_image" type="submit">Upload & Save</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
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
</body>
</html>
