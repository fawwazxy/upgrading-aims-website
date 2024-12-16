<?
require "../controller/auth.php";
require "../model/kehadiran_functions.php";

$department_sub = $_SESSION['SESS_DEPARTMENT_SUB'];
$role_id = $_SESSION['SESS_ROLE'];

if (!in_array($department_sub, ['HR','HR-SEA']) && !in_array($role_id, ['FOUNDER', 'SUPERADMIN'])){
    echo ("<script type='text/javascript'>
                alert('You are not authorized to view this page');
                window.history.back();
                </script>");
    exit();
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
    <script type="text/javascript">
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
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="login-panel panel panel-default">
                <div class="panel-heading">
                    <center> <h3 class="panel-title">Log Kehadiran</h3></center>
                </div>
                <div class="panel-body">
                    <fieldset>
                        <center>
                            <?php
                            $masuk="masuk";
                            echo "<td><a href='#myModal1' class='btn btn-primary btn-small' data-toggle='modal' data-id=".$masuk.">Masuk</a></td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                            $keluar="keluar";
                            echo "<td><a href='#myModal2' class='btn btn-primary btn-small' data-toggle='modal' data-id=".$keluar.">keluar</a></td>"; ?>
                        </center>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<div class="modal fade" id="myModal1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">LOG MASUK</h4>
            </div>
            <div class="modal-body">
                <div class="fetched-data"></div>
            </div>

        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        $('#myModal1').on('show.bs.modal', function (e) {
            var log = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'log_masuk_keluar.php',
                data :  'log='+ log,
                success : function(data){
                    $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
        });
    });
</script>
<!-- Page-Level Demo Scripts - Tables - Use for reference -->
<div class="modal fade" id="myModal2" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">LOG KELUAR</h4>
            </div>
            <div class="modal-body">
                <div class="fetched-data"></div>
            </div>

        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function(){
        $('#myModal2').on('show.bs.modal', function (e) {
            var log = $(e.relatedTarget).data('id');
            //menggunakan fungsi ajax untuk pengambilan data
            $.ajax({
                type : 'post',
                url : 'log_masuk_keluar.php',
                data :  'log='+ log,
                success : function(data){
                    $('.fetched-data').html(data);//menampilkan data ke dalam modal
                }
            });
        });
    });
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</html>