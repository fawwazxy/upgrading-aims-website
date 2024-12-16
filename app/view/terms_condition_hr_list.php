<?php
include ('../controller/auth.php');
require "../model/terms_condition_function.php";
require "../model/lookup.php";
date_default_timezone_set("Asia/Kuala_lumpur");

$no_staff = $_SESSION['SESS_NO_STAFF'];
$code_department = $_SESSION['SESS_DEPARTMENT'];
$department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];

if ($department_sub != 'HR' ) {
    echo "<script>
            alert('This page is only accessible to HR Department')
            window.history.back();
            </script>";
    exit();
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
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style type="text/css">
        .card {
            box-shadow: rgba(0, 0, 0, 0.1) 0 4px 12px;
            height: 100%;
            border-radius: 10px;
            border-style: solid;
            border-color: black;
            display: grid;
            grid-template-areas:
                    "image"
                    "content";
            grid-template-rows: 200px 1fr;
        }
        .content {
            display: grid;
            margin: 1em;

        }
        img {
            object-fit: cover;
            width: 100%;
            height: 100%;
        }
        h3{
            font-weight: 600;
            color: #333;
        }
        p{
            line-height: 1.2em;
        }
        .mt-32{
            margin-top: 32px
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
                <h1 class="page-header">TERMS & CONDITION <i class="fa fa-caret-right"></i> HR LIST</h1>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-md-6">
                                <label>List Terms & Condition</label>
                            </div>
                            <div class="col-md-6 text-right">
                                <a href="#TermsModal" class="btn btn-primary" data-toggle="modal">Add New</a>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div id="app" class="row">
                            <? $i=1;
                            $terms_list = getTerms();

                            while ($list = $terms_list->fetch_assoc()) {
                                ?>
                                <div class="col-md-4">
                                    <div class="card mt-32">
                                        <img src="<?php echo $list['thumbnail_path']; ?>" alt="thumbnail">
                                        <div class="content">
                                            <a href="<?php echo $list['file_path']; ?>" target="_blank"><h3 style="width: 250px; white-space: nowrap; overflow: hidden !important; text-overflow: ellipsis;"><? echo $list['title']?></h3></a>
                                            <div class="row">
                                                <div class="col-md-10">
                                                    <p><? echo $list['description']?></p>
                                                </div>
                                                <div class="col-md-2 text-right">
                                                    <div class="dropdown">
                                                        <button class="btn dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" style="right: 0; left: auto">
                                                            <li><a style="display: block" href="#UpdateTermsModal" data-toggle="modal" data-id="<? echo $list['id'] ?>"><i class="fa fa-pencil opt-icon"></i>Update</a></li>
                                                            <li><a onclick="confirmDel('../controller/terms_condition_delete_exec.php?id=<? echo $list["id"] ?>','Are you sure to delete Terms & Condition?')"
                                                                   style="display: block; color: #d70000"><i class="fa fa-trash opt-icon"></i> Delete</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <? if($i%3 == 0){
                                    echo '</div><div class="row">';
                                }
                                $i++;
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>

<!-- Model Terms Condition Form -->
<div class="modal fade" id="TermsModal" tabindex="-1" role="dialog" aria-labelledby="viewTermsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="viewTermsModalLabel">New Terms & Condition</h4>
            </div>
            <div class="modal-body" id="viewModalBody">
                <form method="post" action="../controller/terms_condition_add_exec.php" enctype="multipart/form-data">
                    <input type="hidden" class="input-short"/>
                    <div class="form-group">
                        <div class="form-group">
                            <label class="control-label" for="title">Title: <span style="color: red; ">*</span></label>
                            <input class="form-control" type="text" id="title" name="title" required>
                        </div>

                        <div class="form-group" >
                            <label class="control-label" for="description">Description: <span style="color: red; ">*</span></label><br>
                            <textarea class="form-control" rows="2" id="description" name="description" required></textarea>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="document">Attachment/Document <span class="text-muted">(pdf/jpg/png/HEIC/HEIF)</span>
                                <span style="color: red; ">*</span></label>
                            <input class="" type="file" id="document" name="document" accept=".jpg,.jpeg,.png,.gif,.pdf" required>
                            <input type="hidden" name="MAX_FILE_SIZE" value="4175639">
                        </div>
                        <br>
                        <input type="submit" id="submitBtn" class="btn btn-block btn-success btn-rounded btn-md ml-4" value="Submit">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Model Terms Condition Update -->
<div class="modal fade" id="UpdateTermsModal" tabindex="-1" role="dialog" aria-labelledby="UpdateTermsModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="UpdateTermsModalLabel">Update Terms & Condition</h4>
            </div>
            <div class="modal-body" id="UpdateTermsModalBody">
                <script type="text/javascript">
                    $('#UpdateTermsModal').on('show.bs.modal', function (e) {
                        let id = $(e.relatedTarget).data('id');
                        $.ajax({
                            type:'POST',
                            url:'terms_condition_update.php',
                            data:{id:id},
                            success:function(html){
                                $('#UpdateTermsModalBody').html(html);
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
</div>
</body>
</html>
