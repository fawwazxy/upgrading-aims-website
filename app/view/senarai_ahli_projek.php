<?php

include ('../controller/auth.php');

require "../model/project_management_function.php";


?>
<?
// $staff_holiday_id = $_GET['staff_holiday_id'];
$no_staff = $_GET['no_staff'];
$id = $_GET['id'];
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <script language="JavaScript" type="text/javascript">
        function Alert(){
            return confirm('Anda pasti untuk meneruskan?');
        }

    </script>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <? require "../global/header.php"; ?>

</head>

<body>

<style>
    p{
        font-size: 120%;

    }
</style>
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

        <div class="row">
            <div class="col-lg-12">
                <?
                $flagScreen="tab_2";
                include ('../global/menu_pengurusan_projek.php');

                ?>
            </div></div>
        <div class="row">
            <?
            $flagScreen="tab_2";
            include ('../global/menu_struktur_kerja.php');

            ?>

            <div class="panel-heading" align="right">


            </div>

        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai Staf
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <form method="post" action="../controller/senarai_staf_projek_exec.php?id=<? echo $id; ?>"/>
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">

                            <input name="no_staff" type="hidden" class="input-short"  value="<? echo $_SESSION['SESS_NO_STAFF'];?>" />
                            <!-- <input name="no_staff" type="text" class="input-short"  value="<? echo $log_staff['no_staff'];?>" /> -->
                            <input name="id_projek" type="hidden" class="input-short" value="<?php echo $_GET['id']; ?>" />


                            <thead>
                            <tr>

                                <th>Nama</th>
                                <th>Bahagian</th>
                                <th>Pilih <br><input type="checkbox" name="checkedAll" id="checkedAll" /> Pilih Semua</li></th>
                            </tr>
                            </thead>
                            <?

                            $i=1;
                            $log_staff = getStaffList();
                            while($staff = $log_staff->fetch_assoc()) {

                                ?>

                                <tbody>
                                <tr>
                                    <td> <? echo $staff['name'];?></td>
                                    <td> <? echo $staff['department_name'];?></td>


                                    <td>
                                        <div class="checkbox">
                                            <label><input  class="checkSingle" id="checkbox[]" name="staffs[]" type="checkbox" <?php echo checkCheckbox($staff['no_staff'],$id);?>
                                                           value="<?php echo $staff['no_staff']; ?>"></label>
                                        </div>
                                    </td>

                                </tr>

                                </tbody>
                                <?php $i++; } ?>
                        </table><center>
                            <div class="modal-footer">
                                <center><button type="submit" class="btn btn-primary" >Seterusnya</button>

                                    <!--button class="btn btn-success" href="../view/senarai_pengguna.php">Kembali</button-->

                                    <!--<a href="../view/senarai_pengguna.php"><button class="btn btn-success" type="button" >Kembali</button>-->

                                </center>&nbsp;

                            </div>
                            </form>
                            <!-- Button trigger modal -->



                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <!-- /.container-fluid -->
        <? include ('../global/footer.php'); ?>
    </div>

    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
</script>
<script>
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();
    });
</script>
<script language="JavaScript" type="text/javascript">
    function checkDelete(){
        return confirm('Adakah anda pasti untuk padam Peranan ini?');
    }


</script>
<script>
    $(document).ready(function() {
        $("#checkedAll").change(function(){
            if(this.checked){
                $(".checkSingle").each(function(){
                    this.checked=true;
                })
            }else{
                $(".checkSingle").each(function(){
                    this.checked=false;
                })
            }
        });

        $(".checkSingle").click(function () {
            if ($(this).is(":checked")){
                var isAllChecked = 0;
                $(".checkSingle").each(function(){
                    if(!this.checked)
                        isAllChecked = 1;
                })
                if(isAllChecked == 0){ $("#checkedAll").prop("checked", true); }
            }else {
                $("#checkedAll").prop("checked", false);
            }
        });
    });
</script>
</body>

</html>
