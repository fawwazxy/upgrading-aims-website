<?php
date_default_timezone_set("Asia/Kuala_Lumpur");
?>

<link rel="shortcut icon" type="image/x-icon" href="../../resources/images/app_logo.png" />

<title>MMS</title>

<!-- Bootstrap Core CSS -->
<link href="../../js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="../../js/bootstrap/css/fullcalendar.css" rel="stylesheet">


<!-- MetisMenu CSS -->
<link href="../../js/metisMenu/metisMenu.min.css" rel="stylesheet">

<!-- DataTables CSS -->
<link href="../../js/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

<!-- DataTables Responsive CSS -->
<link href="../../js/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

<!-- Custom CSS -->
<link href="../../resources/css/sb-admin-2.css" rel="stylesheet">
<link href="../../resources/css/month_picture.css" rel="stylesheet">
<link href="../../resources/css/table_form.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="../../js/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

<!-- jQuery -->
<script src="../../js/jquery/jquery.min.js"></script>
<link rel="stylesheet" href="../../js/jquery/jquery-confirm.css">
<script src="../../js/jquery/jquery-confirm.js"></script>

<script src="../../js/jquery/croppie.js"></script>
<link rel="stylesheet" href="../../js/jquery/croppie.css" />

<!-- auto complete JavaScript -->
<!-- JS file -->
<script src="../../js/EasyAutocomplete/jquery.easy-autocomplete.min.js"></script>

<!-- CSS file -->
<link rel="stylesheet" href="../../js/EasyAutocomplete/easy-autocomplete.min.css">

<!-- Additional CSS Themes file - not required-->
<link rel="stylesheet" href="../../js/EasyAutocomplete/easy-autocomplete.themes.min.css">

<!-- Default Style -->
<style>
    /*Version style, used for version tag of page header - june 2022, used only at overtime, others claim module*/
    .version{
        color: #ffffff;
        background-color: #34568B;
        font-size: 30%;
        font-weight: bold;
        border-radius: 4px;
        padding: 4px;
    }

    .migration-message{
        width: 100%;
        height: 100%;
        color: #000000;
        font-size: 16px;
        border: 2px dashed black;
    }
    .bg-gradient-danger{
        background: linear-gradient(45deg, #ff9871, #ff7474, #ff9871, whitesmoke);
    }
    .blink-me {
        animation: blinker 3s linear infinite;
    }

    @keyframes blinker {
        50% {
            opacity: 30%;
        }
    }
    .staffDetailTable tr{
        height: 24px;
    }
    .tbHeader th{
        border-bottom: 3px solid black;
        font-size: 24px;
        padding-bottom: 8px;
        width: 100%;
    }
    .colon{
        padding: 0 16px;
    }

    .margin-x{
        overflow: auto;
        margin: 16px 8px 0;
    }
    .font-weight-english{
        font-weight: bold;
        font-style: italic;
    }
    .no-data{
        font-size: 12px;
        font-style: italic;
    }
    .text-green{
        color: #00a900
    }
    .text-red{
        color: #d60008
    }
    .att-table td {
        padding: 15px;
    }
    .opt-icon {
        padding-right: 8px;
    }
    .section-header{
        font-weight: bold;
        padding-bottom: 8px;
        border-bottom: 3px solid #989898;
    }
    .card-notes{
        background-color: rgba(255,240,0,0.4);
        padding: 8px;
        border-radius: 0 12px 0 12px;
        height: 100%;
        box-shadow: 6px 6px 4px #808080;
        border: 1px solid #000000;
    }
</style>

<!-- Bootstrap Core JavaScript -->
<script src="../../js/bootstrap/js/bootstrap.min.js"></script>
<script src="../../js/bootstrap/js/bootstrap-datepicker.min.js"></script>
<script src="../../js/bootstrap/js/moment.min.js"></script>
<script src="../../js/bootstrap/js/fullcalendar.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../../js/metisMenu/metisMenu.min.js"></script>

<!-- DataTables JavaScript -->
<script src="../../js/datatables/js/jquery.dataTables.min.js"></script>
<script src="../../js/datatables-plugins/dataTables.bootstrap.min.js"></script>
<script src="../../js/datatables-responsive/dataTables.responsive.js"></script>

<!-- Custom Theme JavaScript -->
<script src="../../js/sb-admin-2.js"></script>

<!--Summernote -->
<link href="../../js/summernote/summernote.css" rel="stylesheet">
<script src="../../js/summernote/summernote.min.js"></script>

<script src="../../js/collapser/jquery.collapser.min.js"></script>

<!-- HEIC Converter -->
<script src="../../vendor/heic2any-master/dist/heic2any.js"></script>

<script type="text/javascript">
    function confirmDel(url, message = "Are you sure to delete?"){
        if (confirm(message)){
            window.location.href = url;
        }
        return false;
    }

    function blinker() {
        $('.blink_me').fadeOut(<? echo $blink; ?>).fadeIn(<? echo $blink; ?>);
    }
    setInterval(blinker, <? echo $blink; ?>);

    function goBack()
    {
        window.history.back()
    }

    function popitup(url,name) {
        newwindow=window.open(url,name);
        //window.open('/pageaddress.html','winname','directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=400,height=350');
        //directories=0,titlebar=0,toolbar=0,location=0,status=0,menubar=0,scrollbars=no,resizable=no,width=400,height=350"
        //if (window.focus) {newwindow.focus()}
        //return false;
    }
    function myFunction() {
        $.ajax({
            url: "view_notification.php",
            type: "POST",
            processData:false,
            success: function(data){
                $("#notification-count").remove();
                $("#notification-latest").show().html(data);
            },
            error: function(){}
        });
    }
</script>