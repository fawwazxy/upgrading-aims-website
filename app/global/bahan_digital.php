<?
	date_default_timezone_set("Asia/Kuala_Lumpur");
	$date_month = date(m);
	$date_year = date(Y);
	$date_day = date(d);
	$time_hour = date(H);
	$time_min = date(i);
	$time_sec = date(s);
	
	$sys = getSys(1)->fetch_assoc();
    $sys_domain=$sys['sys_domain'];
    $shortcode=$sys['short_name'];
?>

<link rel="shortcut icon" type="image/x-icon" href="../../resources/images/<? echo $sys['logo_filename']; ?>" />

<title><? echo $sys['sys_name']; ?>::<? echo $sys['sys_tagline']; ?></title>

<!-- Bootstrap Core CSS -->
<link href="../../js/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="../../js/bootstrap/css/fullcalendar.css" rel="stylesheet">


<!-- MetisMenu CSS -->
<link href="../../js/metisMenu/metisMenu.min.css" rel="stylesheet">

<!-- DataTables CSS -->
<link href="../../js/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

<!-- DataTables Responsive CSS -->
<link href="../../js/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

<!-- Custom Fonts -->
<link href="../../js/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


<!-- jQuery -->
<script src="../../js/jquery/jquery.min.js"></script>
<link rel="stylesheet" href="../../js/jquery/jquery-confirm.css">
<script src="../../js/jquery/jquery-confirm.js"></script>

<!-- auto complete JavaScript -->
<!-- JS file -->
<script src="../../js/EasyAutocomplete/jquery.easy-autocomplete.min.js"></script> 

<!-- CSS file -->
<link rel="stylesheet" href="../../js/EasyAutocomplete/easy-autocomplete.min.css"> 

<!-- Additional CSS Themes file - not required-->
<link rel="stylesheet" href="../../js/EasyAutocomplete/easy-autocomplete.themes.min.css">


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


<script language="javascript" type="text/javascript">

    function blinker() {
    $('.blink_me').fadeOut(<? echo $blink; ?>);
    $('.blink_me').fadeIn(<? echo $blink; ?>);
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
				$("#notification-latest").show();$("#notification-latest").html(data);
			},
			error: function(){}           
		});
	 }	
</script>