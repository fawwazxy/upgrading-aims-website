<?php

include ('../controller/auth.php');

require "../model/project_schedule_function.php";

$id_project=$_GET['id_project'];
$urlcontroller='';
$ps='';
if ($id_project>0){

    //update
    $urlcontroller="../controller/ps_project_exec.php?act=ps_project_update";
    $data=getProjectInformation($id_project)->fetch_assoc();
    $project_code=$data['project_code'];
    $project_name = $data['project_name'];
    $client_name = $data['client_name'];
    $state = $data['state'];
    $parliament = $data['parliament'];
    $country = $data['country'];
    $type_of_job = $data['type_of_job'];
    $start_date = $data['start_date'];
    $remark = $data['remark'];
    $created_by = $data['created_by'];
    $filename = $data['project_site_plan'];
    // $image = $_FILES['image']['tmp_name'];
    // $imgContent = addslashes(file_get_contents($image));

}
else{
    //add new
    $urlcontroller="../controller/ps_project_exec.php?act=ps_project_add";
}
?>

<?
// $id_project=$_GET['id_project'];
// if($id_project == "0") "";
//  else if($id_project == "1") "";
$user_name = $_SESSION['SESS_NAME'] ;

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
                <?if($id_project>0){
                    echo "<h1>"."<h1 class = 'page-header'>"."Kemaskini Maklumat Projek";
                }else{
                    echo "<h1 class = 'page-header'>"."Tambah Maklumat Projek";
                }?>
            </div>

        </div>
        <div class="row">
            <div class="panel-heading" align="right">
                <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
            </div>
        </div>
        <div class="row">


            <div class="col-lg-12">
                <!-- /.panel -->

            </div>
            <div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                Maklumat Projek
                            </div>

                            <div class="panel-body">


                                <table width="100%" class="table table-striped table-bordered table-hover" >
                                    <tbody>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="panel panel-default">

                                                <div class="panel-body">
                                                    <form method="post" action="<? echo $urlcontroller;?>" enctype="multipart/form-data">
                                                        <input class="form-control"  type="hidden" name="id_project" value="<? echo $id_project; ?>" />
                                                        <input class="form-control"  type="hidden" name="created_by" value="<? echo $user_name; ?>" />


                                                        <div class="form-group" align="left">
                                                            <label>Kod Projek<font color="red">**</font>&nbsp;</label>
                                                            <input type="text" class="form-control" placeholder="" id="project_code" name="project_code" required value="<?echo $project_code;?>" onkeyup="var start = this.selectionStart;  var end = this.selectionEnd; this.value = this.value.toUpperCase(); this.setSelectionRange(start, end);">
                                                        </div>



                                                        <div class="form-group" align="left">
                                                            <label>Nama Projek<font color="red">**</font>&nbsp;</label>
                                                            <input type="text" id="project_name" class="form-control"  name="project_name" required value="<?echo $project_name;?>"></textarea>
                                                        </div>

                                                        <div class="form-group" align="left">
                                                            <label>Nama Pelanggan<font color="red">**</font>&nbsp;</label>
                                                            <input type="text" class="form-control" placeholder=" " id="start" name="client_name" required value="<?echo $client_name;?>">
                                                        </div>

                                                        <div class="form-group" align="left">
                                                            <label>Negara<font color="red">**</font>&nbsp;</label>
                                                            <input type="text" class="form-control" placeholder=" " id="start" name="country" required value="<?echo $country;?>">
                                                        </div>

                                                        <div class="form-group" align="left">
                                                            <label>Negeri<font color="red">**</font>&nbsp;</label>
                                                            <input type="text" class="form-control" placeholder=" " id="start" name="state" required value="<?echo $state;?>">
                                                        </div>

                                                        <div class="form-group" align="left">
                                                            <label>Parlimen<font color="red">**</font>&nbsp;</label>
                                                            <input type="text" class="form-control" placeholder=" " id="start" name="parliament" required value="<?echo $parliament;?>">
                                                        </div>


                                                        <div class="form-group" align="left">
                                                            <label>Jenis Kerja<font color="red">**</font>&nbsp;</label>
                                                            <input type="text" class="form-control" placeholder=" " id="type_of_job" name="type_of_job" required value="<?echo $type_of_job;?>">
                                                        </div>

                                                        <div class="form-group" align="left">
                                                            <label>Tarikh Mula<font color="red">**</font>&nbsp;</label>
                                                            <input type="date" class="form-control" placeholder=" " id="start_date" name="start_date" required value="<?echo $start_date;?>">
                                                        </div>

                                                        <div class="form-group" align="left">
                                                            <label>Catatan</label>
                                                            <textarea class="form-control" placeholder=" " id="remark" name="remark" cols="5" rows="5" value="<?echo $remark;?>"><?echo $remark;?></textarea>
                                                        </div>

                                                        <div class="form-group" align="left">
                                                            <label>Pelan Tapak Projek</label><br>
                                                            <?echo '<img src="data:image/jpeg;base64,'.base64_encode( $filename ).'" style="width: 210px; height: 240px;"/>';?>
                                                            <input type="file" name="image" id="image" placeholder="" class="form-control"  value="<?echo $image;?>">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button class="btn btn-primary">Simpan</button>
                                                            <button type="reset" class="btn btn-warning">Tetapan Semula</button>
                                                            <input class="btn btn-success" type="button" value="Kembali" onclick="goBack()">
                                                        </div>

                                                    </form>
                                                </div></div>
                                            <!-- /.panel-body -->
                                        </div>
                                        <!-- /.panel -->
                                    </div>
                                    </tbody>

                                </table>
                            </div>
                            <!-- /.col-lg-12 -->
                        </div>
                    </div>
                </div>

                <!-- /.row -->
                <!-- /.container-fluid -->
            </div>

            <!-- /#page-wrapper -->

        </div>
        <!-- /#wrapper -->
        <? include ('../global/footer.php'); ?>
    </div>
</div>

<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });


    $(document).ready(function() {
        $('#summernote').summernote({
            height: "300px",
            styleWithSpan: false
        });
    });
    function postForm() {
        $('textarea[name="description"]').html($('#summernote').code());
    }
    $(document).ready(function() {
        $('#summernote').summernote();
    });
</script>
</script>
</body>

</html>
