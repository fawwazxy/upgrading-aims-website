<?php

include ('../controller/auth.php');

require "../model/pembekal_function.php";

?>
<?

$id = $_GET['id'];
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


    <script language="JavaScript" type="text/javascript">
        function Confirm(){
            return confirm('Adakah Anda Pasti untuk tekan butang berhenti ini?');
        }

        function Confirm2(){
            return confirm('Adakah Anda Pasti untuk tekan butang bekerja ini??');
        }


    </script>
    <script language="javascript" type="text/javascript">
        <!--
        function popitup(url) {
            /*newwindow=window.open(url,'name','height=842,width=595');*/
            newwindow=window.open(url,'name','height=595,width=842');
            if (window.focus) {newwindow.focus()}
            return false;
        }

        // -->
    </script>

</head>

<body>
<?

$list = getPembekalDetails($id) -> fetch_assoc();

?>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

        <!-- /.navbar-header -->
        <? include ('../global/menu_top.php'); ?>

        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <!--li>
                        <center><img src="images/pic.jpg" class="user-image img-responsive"/></center>
                    </li-->

                    <? include ('../global/menu_left.php'); ?>

                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">


        <br>
        <div class="row">

            <div class="row">
                <center>
                    <div class="col-lg-12">
                        <h1 class="page-header">Keterangan Pembekal</h1>
                    </div>
                </center>
                <div class="panel-heading" align="right">
                    <a href="pembekal_edit.php?id=<? echo $id;?>"> <button class="btn btn-info" type="button" >Kemaskini</button></a>
                    <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">

                </div>
            </div>
            <div class="col-lg-2"></div>
            <div class="col-lg-7">


                <div class="panel panel-default">
                    <div class="panel-heading">
                        Keterangan Pembekal
                    </div>
                    <!--        

         <input name="redirect" type="hidden" value="../view/perbelanjaan_details?id=<?echo $list['id'];?>"/>
          <input name="id" type="hidden" class="input-short" value="<? echo $id;?>" /> -->

                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example" enctype="multipart/form-data">


                        <thead>
                        <tbody>


                        <tr>
                            <th>Kod Pembekal</th>
                            <td><?php echo $list['supplier_code']; ?></td>
                        </tr>



                        <tr>
                            <th>Nama Syarikat</th>
                            <td><?php echo $list['company_name']; ?></td>
                        </tr>



                        <tr>
                            <th>Nama Singkatan</th>
                            <td><?php echo $list['short_name']; ?></td>
                        </tr>



                        <tr>
                            <th>Nama Pekerja Bertugas</th>
                            <td><?php echo $list['person_incharge']; ?></td>
                        </tr>



                        <tr>
                            <th>Alamat</th>
                            <td><?php echo $list['address1']; ?>, <?php echo $list['address2']; ?>, <?php echo $list['district']; ?>, <?php echo $list['city']; ?>, <?php echo $list['state']; ?>, <?php echo $list['country']; ?></td>
                        </tr>



                        <tr>
                            <th>Nombor Telefon</th>
                            <td><?php echo $list['contact_no']; ?></td>
                        </tr>

                        <tr>
                            <th>Nombor Fax</th>
                            <td><?php echo $list['fax_no']; ?></td>
                        </tr>



                        <tr>
                            <th>Email</th>
                            <td><?php echo $list['official_email']; ?></td>
                        </tr>

                        <tr>
                            <th>Email Jabatan</th>
                            <td><?php echo $list['dept_email']; ?></td>
                        </tr>



                        <tr>
                            <th>Id Facebook</th>
                            <td><?php echo $list['facebook_id']; ?></td>
                        </tr>



                        <tr>
                            <th>Bank</th>
                            <td><?php echo $list['bank']; ?></td>
                        </tr>



                        <tr>
                            <th>Nombor Akaun Bank</th>
                            <td><?php echo $list['account_no']; ?></td>
                        </tr>

                        <?

                        $listN = getZoneDetails($list['id']) -> fetch_assoc();

                        ?>
                        <tr>
                            <th>Zon</th>
                            <td><?php echo $listN['zone_name']; ?> : <?php echo $listN['zone_desc']; ?></td>
                        </tr>

                        <?

                        $listM = getTypeDetails($list['id']) -> fetch_assoc();

                        ?>
                        <tr>
                            <th>Jenis Pembekal</th>
                            <td><?php echo $listM['type']; ?></td>
                        </tr>
                        </tbody>
                        </thead>

                    </table>

                    <div class="modal-footer">

                        <a href="pembekal_edit.php?id=<? echo $id;?>"> <button class="btn btn-info" type="button" >Kemaskini</button></a>
                        <a href="config_supplier.php?supplier=<?php echo $list['supplier_code']; ?>"><button type="button" class="btn btn-info"  >Konfigurasi Pembekal</button></a>
                        <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">


                    </div>


                </div>

            </div>
        </div>



        <? include ('../global/footer.php'); ?>
    </div></div>
</div>


<div class="col-lg-1"></div>

<!--   <br>
  <? //include ('../global/footer.php'); ?>

  
 -->
</body>

</html>
