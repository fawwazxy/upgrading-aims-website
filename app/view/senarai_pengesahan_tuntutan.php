<?php

include ('../controller/auth.php');

require "../model/claim_function.php";

?>

<?
$value = $_GET['value'];
$claim_id=$_GET['claim_id'];
$table_ref=$_GET['table_ref'];
$no_staff=$_GET['no_staff'];
$id = $_GET['id'];

updateNotiPelulus('1',$no_staff,'SD');


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
        function checkDelete(){
            return confirm('Adakah anda pasti untuk padam Peranan ini?');
        }
    </script>
    <script language="JavaScript" type="text/javascript">
        function Alert(){
            return confirm('Anda pasti untuk meneruskan?');
        }

    </script>
    <script type="text/javascript">
        <!--
        function un_check(){
            for (var i = 0; i < document.frmactive.elements.length; i++) {
                var e = document.frmactive.elements[i];
                if ((e.name != 'allbox') && (e.type == 'checkbox')) {
                    e.checked = document.frmactive.allbox.checked;
                }}}
        //-->
    </script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#select_all').on('click',function(){
                if(this.checked){
                    $('.checkbox').each(function(){
                        this.checked = true;
                    });
                }else{
                    $('.checkbox').each(function(){
                        this.checked = false;
                    });
                }
            });

            $('.checkbox').on('click',function(){
                if($('.checkbox:checked').length == $('.checkbox').length){
                    $('#select_all').prop('checked',true);
                }else{
                    $('#select_all').prop('checked',false);
                }
            });
        });
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
                <?
                $flagScreen="tab_1";
                include ('../global/menu_tuntutan_2.php');

                ?>

                <h1 class="page-header">Senarai Tuntutan Perlu Disahkan</h1>
            </div>
            <div class="panel-heading" align="right">


            </div>

            <!--<div class="panel-heading" align="right">
        <a href="pohon_tuntutan_baru.php?no_staff=<? echo $_SESSION['SESS_NO_STAFF']; ?>">
        <button class="btn btn-primary" data-toggle="modal"  data-target="#myModal">Pohon Tuntutan Baru</button></a>
        
        </div>--></div>

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Maklumat Tuntutan
                    </div>
                    <!-- /.panel-heading -->

                    <input type="checkbox" id="select_all" /> Pilih Semua</li>


                    <? $data=getCheckboxUpdateClaim($id,$no_staff)?>

                    <td><form nmae="frmactive" method="post" action="">
                            <table width="400" border="0" cellpadding="3" cellspacing="1">
                                <tr>
                                    <td colspan="5"><input class="btn btn-success" name="activate" type="submit" id="activate" value="Lulus" />
                                        <input class="btn btn-danger" name="deactivate" type="submit" id="deactivate" value="Tidak Lulus" /></td>
                                    <div class="panel-body">
                                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Pemohon</th>
                                                <th>Tarikh Tuntutan</th>
                                                <th>Nama Tuntutan</th>
                                                <th>Jumlah (RM)</th>
                                                <th>Status</th>
                                                <th>Pilih</th>
                                                <th>Tindakan</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?
                                            $i= 1;
                                            $log_tuntutan= getSenaraiTuntutanPekerja($no_staff);
                                            while($list = $log_tuntutan->fetch_assoc()) {
                                                ?>

                                                <tr class="odd gradeX">
                                                    <td><?php echo $i;?></td>
                                                    <td><?php echo $list['nama']; ?>
                                                    <td><?php echo $list['tarikh_dipohon']; ?></td>
                                                    <td><?php
                                                        if($list['jenis_tuntutan']=='TRNSPRT'){
                                                            echo $list['nama_tuntutan']; ?><br><br>
                                                            <? echo $list['tempat_from']; ?>-
                                                            <? echo $list['tempat_to'];
                                                        } else {
                                                            echo $list['nama_tuntutan'];
                                                        }

                                                        ?>

                                                    </td>
                                                    <td>RM <?php echo $list['jumlah_tuntut']; ?></td>
                                                    <td><font color=red><strong><?php echo $list['status_tuntut'];?></strong></font></td>
                                                    <td align="center"><input name="checkbox[]" type="checkbox" class="checkbox" id="checkbox[]" value="<?php echo $list['id']; ?>" ></td>
                                                    <td>

                                                        <?
                                                        if ($list['approve_status'] == 'SD' && $list['jenis_tuntutan'] !=='TRNSPRT'){
                                                            ?>

                                                            <a href="../view/lulus_tuntutan_default_page.php?value=<? echo $list['value'];?>&no_pemohon=<? echo $list['no_pemohon'];?>&id=<? echo $list['id'];?>&table_ref=<? echo $list['table_ref'];?>"><button type="button"onclick="return Alert()" class="btn btn-info">Pengesahan Tuntutan</button></a><br/>




                                                            <?php echo "<a href='#myModal1' class='btn btn-warning btn-small' data-toggle='modal' data-id=".$list['id'].">Bukti Tuntutan</a>"; ?>

                                                            <?
                                                        }if ($list['approve_status'] == 'SD' && $list['jenis_tuntutan'] =='TRNSPRT'){

                                                            ?>

                                                            <a href="../view/lulus_tuntutan_perjalanan_page.php?value=<? echo $list['value'];?>&no_pemohon=<? echo $list['no_pemohon'];?>&id=<? echo $list['id'];?>&table_ref=<? echo $list['table_ref'];?>"><button type="button"onclick="return Alert()" class="btn btn-info">Pengesahan Tuntutan</button></a><br/>


                                                            <?php echo "<a href='#myModal1' class='btn btn-warning btn-small' data-toggle='modal' data-id=".$list['id'].">Bukti Tuntutan</a>"; ?>

                                                            <?
                                                        }
                                                        ?>







                                                        <!-- Modal -->
                                                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">


                                                                <div class="modal-content">
                                                                    <div class="modal-header">



                                                                        <h4 class="modal-title" align="left" id="myModalLabel">Bukti Tuntutan</h4>




                                                                    </div>  <!-- modal-header -->

                                                                    <div class="modal-body">

                                                                        <div class="form-group" align="left">

                                                                            <?
                                                                            getBuktiTuntutan($row_pemohon['id']);

                                                                            ?>

                                                                        </div>


                                                                    </div><!--modal-body-->

                                                                </div><!-- /.modal-content -->
                                                            </div><!-- /.modal-dialog -->
                                                        </div><!-- /.modal -->







                                                    </td>
                                                </tr>

                                                <?php $i++; } ?>

                                            </tbody>

                                        </table>

                                    </div>

                                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <? include ('../global/footer.php'); ?>

        <!-- /.row -->
        <!-- /.container-fluid -->
    </div>

    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->

<!-- Page-Level Demo Scripts - Tables - Use for reference -->


<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Bukti Tuntutan</h4>
            </div>
            <div class="modal-body" id="demo">
                <script type="text/javascript">
                    $('#myModal1').on('show.bs.modal', function (e) {
                        var rowid = $(e.relatedTarget).data('id');
                        // $('#demo').html(rowid);
                        $.ajax({
                            type:'post',
                            url:'bukti_tuntutan.php',
                            data:'rowid='+rowid,
                            success:function(data){
                                $('#demo').html(data);
                            }
                        });
                    });
                </script>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    });
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