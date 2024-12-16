<?php

include ('../controller/auth.php');

require "../model/support_function.php";

?>
<?
$no_staff = $_GET['no_staff'];
$no_staff_login = $_GET['SESS_NO_STAFF'];
$faq_id = $_POST['faq_id'];


?>

<?
if(isset($_GET['act']) && $_GET['act'] == "delete" && !empty($_GET['faq_id']))
{
    deleteFAQ($id);
}

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
            return confirm('Aduan ini akan dihantar kepada Tim Sokongan/Developer?');
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
                <h1 class="page-header">FAQ</h1>
            </div>
        </div>
        <div class="row">


            <div class="panel-heading" align="right">


                <a href="add_faq.php"><button class="btn btn-primary"  type="button" >Tambah FAQ</button></a>

                <a href="faq_test.php" target="_blank"><button class="btn btn-primary"  type="button" >Papar FAQ</button></a>


            </div>

            <div class="col-lg-12">

                <div class="panel panel-default">
                    <div class="panel-heading">
                        Senarai FAQ
                    </div>








                    <!-- /.panel-heading -->
                    <div class="panel-body">

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Sistem</th>
                                <th>Tajuk</th>
                                <th>Huraian</th>
                                <th>Tindakan</th>
                            </thead>
                            <tbody>

                            <?
                            $i= 1;
                            $data = getFAQlist();
                            while($row_data = $data->fetch_assoc()) {



                                ?>



                                <tr class="odd gradeX">
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $row_data['faq_produk']; ?></td>

                                    <td><?php echo $row_data['faq_title']; ?></td>
                                    <td><?php echo $row_data['faq_answer']; ?></td>

                                    <td>
                                        <a href="update_faq.php?id=<? echo $row_data['faq_id'];?>"><button class="btn btn-info" type="button" >Kemaskini</button></a>

                                        <a href="../controller/delete_faq_exec.php?id=<? echo $row_data['faq_id']; ?>"><button type="button" class="btn btn-danger">Padam</button>


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
    $('.Contact').click(function(){
        var id=$('.Contact').val();
        $.ajax({url:"ModalPage.php?id="+id,cache:false,success:function(result){
                $(".modal-content").html(result);
            }});
    });
</script>

<script type="text/javascript">

    $(document).ready(function(){
        $('#myModal').on('show.bs.modal', function (e) {
            var rowid = $(e.relatedTarget).data('id');
            $.ajax({
                type : 'post',
                url : 'fetch_record.php', //Here you will fetch records
                data :  'rowid='+ rowid, //Pass $id
                success : function(data){
                    $('.fetched-data').html(data);//Show fetched data from database
                }
            });
        });
    });
</script>
</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>
</script>

</div>
</div>
<!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->
</div>

</body>

</html>
