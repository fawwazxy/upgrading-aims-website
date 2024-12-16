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

$com_id=$_GET['SESS_COM'];
$id = $_GET['id'];
$com_id = $_GET['company_id'];
$nama = getCompanyname($id) -> fetch_assoc();

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
        .blink_text {

            animation:1s blinker linear infinite;
            -webkit-animation:1s blinker linear infinite;
            -moz-animation:1s blinker linear infinite;

            color: blue;
        }

        @-moz-keyframes blinker {
            0% { opacity: 1.0; }
            50% { opacity: 0.0; }
            100% { opacity: 1.0; }
        }

        @-webkit-keyframes blinker {
            0% { opacity: 1.0; }
            50% { opacity: 0.0; }
            100% { opacity: 1.0; }
        }

        @keyframes blinker {
            0% { opacity: 1.0; }
            50% { opacity: 0.0; }
            100% { opacity: 1.0; }
        }
    </style>
</head>
<? $sys = getSys(1) -> fetch_assoc(); ?>
<body>

<div class="row" align="center">
    <div class="col-lg-12">

        <marquee behavior="scroll" direction="left" >

            <h1> Iklan Jawatan Kosong <? $com = getCompany()->fetch_assoc();
                echo '<img src="data:image/png;base64,'.base64_encode( $com['logo'] ).'" style="width:3%" />';?></center>
                <input type="hidden" name="company_id"  value="<? echo $_SESSION['SESS_COM']; ?>">
            </h1>

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



                        <center><? $com = getCompany()->fetch_assoc();
                            echo '<img src="data:image/png;base64,'.base64_encode( $com['logo'] ).'" style="width:13%"/>';?></center>

                        <h3><b>Peluang kerjaya di <? echo $com ['name'];?> <? echo $date_year;?><b></h3>

                        <div>Kami mempelawa calon-calon yang berkelayakan dalam bidang-bidang yang berkaitan untuk mengisi jawatan Tetap/Kontrak di syarikat kami.</div>
                        <br>

                        <table width="100%" class="table table-striped table-bordered table-hover" >

                            <!--<tr>
                                <td colspan=4>PERJAWATAN</td>
                            </tr>-->
                            <thead>
                            <tr>

                                <th>PERJAWATAN</th>
                                <th>KETERANGAN</th>
                                <th>TARIKH TUTUP PERMOHONAN</th>
                                <th>JAWATAN</th>

                            </tr>
                            </thead>



                            <?
                            $log_jawatan = getLogPenawaranJawatan();
                            while($list = $log_jawatan->fetch_assoc()) {
                                ?>

                                <tr class="odd gradeX">

                                    <td><font color="blue"> <span class="blink_text"><?php echo $list['jenis_role']; ?></span></font><br></td>

                                    <td><?php echo $list['keterangan']; ?></td>
                                    <td id="tend"><? echo date('d/m/Y',strtotime($list['tarikh_akhir']));?></td>

                                    <td>

                                        <?if ($list['role'] == 'INTERN') { ?>
                                        <a href="intern_mohon.php?id=<? echo $list['id'];?>&com_id=<? echo $list['company_id'];?>"><button class="btn btn-info" type="button">Mohon</button>

                                            <?

                                            }
                                            else  { ?>
                                            <a href="permohonan_perjawatan.php?id=<? echo $list['id'];?>"><button class="btn btn-warning" type="button">Mohon</button>
                                                <?
                                                }

                                                ?>
                                    </td>

                                </tr>

                                <?
                            }
                            ?>

                        </table>

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




</body>

</html>