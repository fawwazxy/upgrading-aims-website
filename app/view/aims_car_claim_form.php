<?php
require "../controller/auth.php";
require "../model/aims_carReserve_function.php";
require "../model/lookup.php";

$id = $_GET['id'];
$status = ($_GET['status']) ?: 'FUEL';
$fuel = getFuelcarById($id, $status)->fetch_assoc();
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
        /* Layout: */

        .col-main {
            flex: 1;
        }

        .col-complementary {
            flex: 1;
        }

        /* Responsive: */

        @media only screen and (min-width: 640px) {
            .layout {
                display: flex;
            }
        }

        /* etc */

        .container {
            max-width: 60em;
            margin-right: auto;
            margin-left: auto;
        }

        .col {
            padding: 1em;
            margin: 0 2px 2px 0;
            background: #b3e888;
        }

        h3 {
            display: flex;
            flex-direction: row;
        }
        h3:before, h3:after{
            content: "";
            flex: 1 1;
            border-bottom: 3px solid;
            margin: auto;
        }
        h3:before {
            margin-right: 5px
        }
        h3:after {
            margin-left: 5px
        }
        .border-1{
            border: 1px solid black;
        }
    </style>
</head>

<body style="background-color:white;">

<div style="width:100%; padding-top:10px;" class="text-center">
    <input type="button" class="btn btn-danger" value="Close" onclick="self.close()">
</div>

<div class="container">
    <?
    $doc_path = '../../fuel_photo/'.$fuel['document_name'];
    $filepath = '../../fuel_photo/'.$fuel['file_name'];
    ?>
    <form method="post" action="../controller/aims_car_fuel_exec.php" enctype="multipart/form-data">

        <label style="color: red">* Required Information</label>
        <br>
        <input type="hidden" name="reserve_id" value="<?php echo $id; ?>">
        <input type="hidden" name="id" value="<?php echo $fuel['id']; ?>">
        <input type="hidden" name="status" value="<? echo $status ?>">

        <h3>MILEAGE & <? echo $status ?> RECEIPT</h3>
        <br><br>
        <div class="layout">

            <div class="col col-main">
                <label for="mileage_fuel">MILEAGE (KM)&nbsp;<span style="color: red; ">*</span></label>
                <input class="form-control" placeholder="" id="mileage_fuel" name="mileage_fuel" value="<? echo $fuel['mileage_fuel'];?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">
                    <div style="text-align: center;">
                        <? if(in_array($fuel['document_type'], ['jpg','jpeg', 'png'])) {?>
                            <a href="#viewImageModal" data-toggle="modal" data-url="<?echo $doc_path;?>">
                                <img class="img-responsive border-1" src="<?echo $doc_path;?>" alt="mileage-attachment"
                                     style="width: 100%; margin: 8px 0;"/>
                            </a>
                        <?} else if($fuel['document_type'] == 'pdf') {?>
                            <iframe src="<?php echo $doc_path; ?>" class="embed-responsive-item border-1" style="width: 100%; margin: 8px 0;"></iframe>
                        <?}?>
                    </div>
                <br><input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                <br><input type="file" onchange="preview(event, 'mileage_output')" accept=".jpg,.jpeg,.png,.pdf" name="document" id="document">
                <img id="mileage_output" src="#" alt="mileage-output" style="width: 192px;height: auto;display: none"/>
            </div>

            <div class="col col-complementary">
                <label for="receipt_fuel">RECEIPT (RM)&nbsp;<span style="color: red; ">*</span></label>
                <input class="form-control" placeholder="" id="receipt_fuel" name="receipt_fuel" value="<? echo $fuel['receipt_fuel'];?>" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">

                <label for="receipt_date" style="margin-top: 4px">Receipt Date</label>
                <input type="date" class="form-control" id="receipt_date" name="receipt_date" placeholder="Receipt Date" value="<? echo ($fuel['receipt_date'])?: '';?>">

                <div style="text-align: center;">
                    <? if(in_array($fuel['file_type'], ['jpg','jpeg', 'png', 'gif'])) {?>
                        <a href="#viewImageModal" data-toggle="modal" data-url="<?echo $filepath;?>">
                            <img class="img-responsive border-1" src="<?echo $filepath;?>" alt="receipt-attachment" style="width: 100%; margin: 8px 0;"/>
                        </a>
                    <? }else if($fuel['file_type'] == 'pdf') {?>
                        <iframe src="<?php echo $filepath; ?>" class="embed-responsive-item border-1" style="width: 100%; margin: 8px 0;"></iframe>
                    <?}?>
                </div>
                <br><input type="hidden" name="MAX_FILE_SIZE" value="2000000">
                <br><input type="file" onchange="preview(event, 'receipt_output')" accept=".jpg,.jpeg,.png,.gif,.pdf" name="file" id="file">
                <img id="receipt_output" src="#" alt="receipt-output" style="width: 192px;height: auto;display: none"/>
            </div>
        </div>

        <div class="form-group row text-center" style="margin-top: 16px">
            <div class="col-xs-12">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="../controller/aims_car_fuel_delete_exec.php?id=<? echo $fuel['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete?');">Delete</a>
            </div>
        </div>
    </form>
</div>

<div class="modal fade" id="viewImageModal" tabindex="-1" role="dialog" aria-labelledby="viewImageTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="viewImageTitle">Update Reserve Info</h4>
            </div>
            <div class="modal-body" id="viewImageModalBody">
                <script type="text/javascript">
                    $('#viewImageModal').on('show.bs.modal', function (e) {
                        let url = $(e.relatedTarget).data('url');
                        let img = '<img src="'+url+'" alt="view-attachment" id="view_image_element" class="border-1" style="width: 100%">';
                        $('#view_image_element').remove();
                        $('#viewImageModalBody').prepend(img);
                    });
                </script>
                <button type="button" class="btn btn-danger btn-block" data-dismiss="modal" aria-hidden="true" style="margin-top: 16px">
                    Close
                </button>
            </div>
        </div>
    </div>
</div>
<script>
    function preview(event, element) {
        let image = document.getElementById(element);
        image.src = URL.createObjectURL(event.target.files[0]);
        image.style.display = "block";
    }
</script>
</body>
</html>
