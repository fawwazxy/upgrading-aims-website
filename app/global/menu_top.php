<div class="navbar-header">
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>
	<? $sys = getSys(1)->fetch_assoc(); ?>
    <a class="navbar-brand form-inline" href="../view/dashboard.php" style="display: inline-block">
        <img src="../../resources/images/app_logo.png" alt="app-logo" class="app-logo"
             style="display: inline-block;border-radius: 4px; height: 32px; width: auto; margin-right: 8px">
        <span><? echo $sys['sys_name']; ?></span>
        <i style="font-size: 14px">"<? echo $sys['sys_tagline']; ?>"</i>
    </a>
	
</div>

<? //include ('../global/notification_dropdown.php'); ?>


<ul class="nav navbar-top-links navbar-right" style="text-align: right">
    <? include "../global/navbar_notification.php";?>
    <!-- /.dropdown -->
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
			<strong><? echo $_SESSION['SESS_NAME'];?></strong>
			<i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
			<!--<li><a href="http://www.indeepreneur.com/ioffice/app/view/ioffice_support.php" target="_blank">Bantuan@i-OFFICE</a></li>-->
			<li><a href="../controller/logout.php"><i class="fa fa-sign-out fa-fw"></i> Log-Keluar</a></li>
		</ul>
		<!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->
</ul>