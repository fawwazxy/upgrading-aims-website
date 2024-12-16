<?php
include ('../controller/auth.php');
require "../model/terms_condition_function.php";
require "../model/lookup.php";
date_default_timezone_set("Asia/Kuala_lumpur");

$no_staff = $_SESSION['SESS_NO_STAFF'];
$code_department = $_SESSION['SESS_DEPARTMENT'];
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
                <h1 class="page-header">Terms & Condition</h1>
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
                                            <p><? echo $list['description']?></p>
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
</body>
</html>
