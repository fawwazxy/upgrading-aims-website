<?php

include ('../controller/auth.php');

require "../model/contractor_function.php";

?>


<?php
$id = $_GET['id'];
$no_staff = $_GET['no_staff'];
if($no_staff == ""){
    $no_staff = $_SESSION['SESS_NO_STAFF'];
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <script>
        <? require "../global/header.php"; ?>
    </script>

</head>

<body>



<?
$nama = getValueName($no_staff) -> fetch_assoc();

$vaksin = getValuePhoto($id) -> fetch_assoc();


$filename = $vaksin['doc_name'];
$filepath = '../../contractorphoto/'.$vaksin['doc_name'];

?>

<div class="row">
    <center>
        <div class="col-lg-12">
            <h1 class="page-header">Contractor & Visitor Information</h1>
        </div>
    </center>
</div>



<center>
    <input class="form-control" >
    <?if($vaksin['doc_type'] == 'jpg' || $vaksin['doc_type'] == 'jpeg'|| $vaksin['doc_type'] == 'JPG' || $vaksin['doc_type'] == 'JPEG'|| $vaksin['doc_type'] == 'png' || $vaksin['doc_type'] == 'gif') {?>
        <center><img class="img-responsive" width="200" height="100" src="<?echo $filepath;?>" border="0"/></center>
    <?   }  else if($vaksin['doc_type'] == 'pdf') {?>
        <center><iframe width="200" height="100" src="<?php echo $filepath; ?>" class="embed-responsive-item"></iframe></center>
    <?}?>
    </br><h4><strong><? echo $nama['name'];?></strong></h4>
</center>
<br>


<!-- /Maklumat Peribadi-->
<div class="row">
    <div class="col-lg-1"></div>
    <div class="col-lg-10">
        <div class="panel panel-default">
            <div class="panel-heading">
                <font color="blue"><strong><b>Personal Information</b></strong></font>
            </div>
            <div class="panel-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <input name="no_staff" type="hidden" class="input-short" value="<? echo $no_staff;?>" />
                    <input name="id" type="hidden" class="input-short" value="<? echo $id;?>"/>
                    <thead>
                    <tr>

                        <th>No IC</th>
                        <th>Phone No</th>
                        <th>Email</th>
                        <th>Age</th>
                        <th>Gender</th>
                        <th>Category</th>
                        <th>Company</th>

                    </thead>
                    <tbody>

                    <?
                    $data_staff= getStaffrecord($no_staff)->fetch_assoc();

                    ?>
                    <tr class="odd gradeX">


                        <td><?php echo $data_staff['noic']; ?></td>
                        <td><?php echo $data_staff['phone']; ?></td>
                        <td><?php echo $data_staff['email']; ?></td>
                        <td><?php echo $data_staff['umur']; ?></td>
                        <td><?php if($data_staff['gender'] == 'LLAKI'){echo "MAN";}
                            else if($data_staff['gender'] == 'PREMPUAN') {echo "WOMAN";}
                            else echo " ";?></td>
                        <td><?php echo $data_staff['role_id']; ?>
                            <br><br>Purpose: <?php echo $data_staff['purpose']; ?></td>
                        <td><?php echo $data_staff['syarikat']; ?></td>

                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <? include ('../global/footer.php'); ?>
</div>





</body>

</html>
