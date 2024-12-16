<!--
Author: W3layouts
Author URL: http://w3layouts.com
License: Creative Commons Attribution 3.0 Unported
License URL: http://creativecommons.org/licenses/by/3.0/
-->

<?
require "../model/pemohon_functions.php";
?>

<?
$pemohon_id = $_GET['pemohon_id'];
$com_id=$_GET['company_id'];
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
<? $sys = getSys(1) -> fetch_assoc(); ?>
<body>



<div class="row" align="center">
    <div class="col-lg-12">

        <marquee behavior="scroll" direction="left" >
            <h1>Permohonan Latihan Industri Selesai</h1>
        </marquee>

        <!-- /.col-lg-12 -->
    </div>
</div>

<!-- /.row -->

<div class="row" align="center">

    <div class="col-lg-12" >

        <div class="panel panel-default">

            <div class="panel-body" >
                <div class="row">
                    <div class="col-sm-1"></div>


                    <div class="col-sm-10" align="center">




                        <?



                        $log_pemohon = getPemohon($pemohon_id)-> fetch_assoc();

                        ?>


                        <br> <br>



                        <p>Semoga berjaya <font color="blue"><b><? echo $log_pemohon['name']; ?></b></font>. Sebarang maklum balas akan kami maklumkan kepada saudara/saudari melalui aplikasi whatsapp atau pihak kami akan menghubungi anda melalui emel.</p>

                        <a href="iklan.php"><center><button class="btn btn-success">Kembali Halaman Utama</button></center></a>



                    </div>
                    <div class="col-sm-1"></div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <? include ('../global/footer.php'); ?>
</div>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>


<script>
    function Age(){
        var ic= document.getElementById("noic").value;
        var year= ic.slice(0,2);
        var age= "19" +year;

        document.getElementById("umur").value=2018-age;
        document.getElementById("umur").focus;

    }
</script>

</body>

</html>