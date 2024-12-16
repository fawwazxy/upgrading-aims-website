<?php

include ('../controller/auth.php');

require "../model/meeting_functions.php";

session_start()



?>
<?

$bln=$_GET['mnt'];
$thn=$_GET['yr'];
$tahun=$_GET['tahun'];
$no_staff=$_GET['no_staff'];

?>
<?
// $id=$_GET['id'];
$id=getIdStaff($_GET['no_staff']);
?>

<?php
// $events = getKalendarDetails()->fetch_array();
date_default_timezone_set("Asia/Kuala_Lumpur");
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

    <!-- Bootstrap Core CSS -->

    <!-- Custom CSS -->
    <style>
        #calendar {
            max-width: 800px;
        }
        .col-centered{
            float: none;
            margin: 0 auto;
        }
    </style>

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
                <h1 class="page-header">Kalendar Aktiviti</h1>
            </div>
        </div>
        <?
        $flagScreen="tab_3";
        include ('../global/menu_meeting.php');
        ?>

        <div class="row">


            <div class="col-lg-12">
                <!-- /.panel -->

            </div>

            <div>
                <br>
                <div class="row">
                    <div>
                        <div class="col-lg-12">
                            <div class="panel panel-default">

                                <!-- /.panel-heading -->
                                <div class="panel-body">
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        </tr>
                                        <div class="row">
                                            <div class="col-lg-12 text-center">
                                                <?
                                                $ssss = getCountAktivitiStaff($_GET['no_staff'])->fetch_assoc();
                                                ?>
                                                <h1>Kalendar Keseluruhan Aktiviti</h1>
                                                <h5>Jumlah Bilangan Aktiviti Bulan Ini    :<?php echo $ssss['kira'];?></h5>
                                                <div id="calendar" class="col-centered">
                                                </div>
                                            </div>

                                            <!-- Modal -->


                                        </div>
                                        <!-- /.container -->

                                        <!-- jQuery Version 1.11.1 -->
                                        <script src='../../js/calendar/jquery.js'></script>

                                        <!-- Bootstrap jsCore JavaScript -->
                                        <script src="../../js/calendar/bootstrap.min.js"></script>

                                        <!-- FullCalendjsar -->
                                        <script src='../../js/calendar/moment.min.js'></script>
                                        <script src='../../js/calendar/fullcalendar.js'></script>

                                        <script>

                                            $(document).ready(function() {

                                                $('#calendar').fullCalendar({
                                                    header: {
                                                        left: 'prev,next today',
                                                        center: 'title',
                                                        right: 'month,listWeek,listDay'
                                                    },
                                                    buttonText: {
                                                        today: 'Hari Ini',
                                                        month: 'Bulan',
                                                        week: 'Minggu',
                                                        day: 'Hari',
                                                        listMonth: 'Senarai Bulanan',
                                                        listWeek: 'Senarai Mingguan',
                                                        listDay: 'Senarai Harian'
                                                    },
                                                    defaultDate: '<?php echo date("Y-m-d"); ?>',
                                                    editable: true,
                                                    eventLimit: true, // allow "more" link when too many events
                                                    selectable: true,
                                                    selectHelper: true,
                                                    select: function(start, end) {

                                                        // $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
                                                        // $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
                                                        // $('#ModalAdd').modal('show');
                                                    },

                                                    eventRender: function(event, element) {
                                                        element.bind('click', function() {
                                                            window.location.href="event_descriptions.php?id="+event.id;

                                                        });
                                                    },




                                                    eventDrop: function(event, delta, revertFunc) { // si changement de position

                                                        edit(event);

                                                    },
                                                    eventResize: function(event,dayDelta,minuteDelta,revertFunc) { // si changement de longueur

                                                        edit(event);

                                                    },
                                                    events: [
                                                        <?php
                                                        $data = getKalendarDetails($_GET['no_staff']);
                                                        while($event = $data->fetch_assoc()) {
                                                        ?>
                                                        {
                                                            id: '<?php echo $event['id']; ?>',
                                                            title: '<?php echo $event['title']; ?>',
                                                            start: '<?php echo $event['start']; ?>',
                                                            end: '<?php echo $event['end']; ?>',
                                                            color: '<?php echo $event['color']; ?>',
                                                            description: '<?php echo $event['description']; ?>'
                                                        },
                                                        <?php
                                                        //endforeach;
                                                        }

                                                        ?>
                                                    ]
                                                });
                                            });

                                        </script>
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
        </div>
        <? include ('../global/footer.php'); ?>
    </div>
</div>

</body>

</html>
