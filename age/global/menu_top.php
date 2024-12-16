<div class="navbar-header">
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
		<span class="sr-only">Toggle navigation</span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
		<span class="icon-bar"></span>
	</button>
	<? $sys = getSys(1)->fetch_assoc(); ?>
	<a class="navbar-brand"><? echo $sys['sys_name']; ?>&nbsp;v<? echo $sys['version']; ?>::[<? echo $sys['sys_tagline']; ?>]</a>
	
</div>


<ul class="nav navbar-top-links navbar-right">
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