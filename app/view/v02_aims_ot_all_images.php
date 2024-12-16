<?php
require "../model/v02_aims_ot_function.php";

$id = $_GET['id'];
$month = $_GET['month'];
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
        body{
            background-color: #FFFFFF;
        }
        td {
            padding: 15px;
        }
        .my-card{
            background-color: #b0d6d1;
            border: 1px solid black;
            margin: 4px 0;
            height:360px;
        }
        img{
            object-fit: contain;
            margin: 0 auto;
            max-height:360px;
            width:auto;
            overflow-y: scroll;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row" style="padding:10px 0;">
        <div class="col-md-12">
            <button class="btn btn-block btn-danger"
                    value="Close" onclick="self.close()">Close</button>
        </div>
    </div>
    <div class="row">
        <?
        $ot_list = v02getDocumentListMonthSession($id);
        $i= 1;
        while($list = $ot_list->fetch_assoc()) {

            $filepath = '../../overtimephoto/'.$list['document_name'];
            $explode_name = explode('.', $list['document_name']);
            $doc_type = end($explode_name)?>
            <div class="col-md-3 my-card">
                <p><? echo '<b>'.$list['date'].':</b> '.$list['description']; ?></p>
                <? if(in_array($doc_type, ['jpg', 'jpeg', 'png', 'gif'])) { ?>
                    <img class="img-responsive" width="auto" height="auto"
                         src="<?echo $filepath;?>" alt="overtime_attachment"/>
                <? }else if($list['document_type'] == 'pdf') { ?>
                    <iframe width="100%" height="500" src="<?php echo $filepath; ?>" class="embed-responsive-item"></iframe>
                <? }?>
            </div>
        <?}?>
    </div>
</div>
</body>
</html>





						